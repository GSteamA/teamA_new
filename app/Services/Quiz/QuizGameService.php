<?php

namespace App\Services\Quiz;

use App\Models\Game;
use App\Models\GameDetail;
use App\Models\UserGame;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\Region;
use App\Models\Quiz\QuizCategory;
use App\Services\Game\GameServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class QuizGameService implements GameServiceInterface
{
    /**
     * クイズゲームを初期化し、必要なデータ構造を作成
     *
     * @param int $regionId 地域ID
     * @param int $categoryId カテゴリーID
     * @return array|null 初期化されたゲーム設定。失敗時はnull
     */
    public function initializeGame(array $params): ?array
    {
        try {
            return DB::transaction(function () use ($params) {
                // クイズゲーム固定ID=2を使用、なければ作成
                $game = Game::firstOrCreate(
                    ['id' => 2],
                    [
                        'game_name' => 'quiz',
                        'base_score' => config('quiz.base_score', 20),
                        'config_json' => json_encode(['type' => 'quiz']),
                        'detail_id' => null
                    ]
                );

                // 作成したゲームが確実にコミットされるのを待つ
                DB::commit();
                DB::beginTransaction();

                // GameDetailの作成
                $gameDetail = GameDetail::create([
                    'json' => [
                        'region_id' => $params['region_id'],
                        'category_id' => $params['category_id']
                    ]
                ]);

                // UserGameの作成
                UserGame::create([
                    'user_id' => $this->getUserId(),
                    'game_id' => $game->id,
                    'status' => 'in_progress',
                    'score' => 0,
                    'detail_id' => $gameDetail->id
                ]);

                // ランダムな問題を取得
                $quizzes = $this->getRandomQuizzes(
                    $params['region_id'],
                    $params['category_id'],
                    config('quiz.questions_per_game', 5)
                );

                return [
                    'game_id' => $game->id,
                    'quizzes' => $quizzes
                ];
            });

        } catch (\Exception $e) {
            \Log::error('Game initialization failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * ユーザーの回答を処理し、結果を返却します
     *
     * @param array $params 回答情報を含むパラメータ
     * @return array 処理結果
     */
    public function processGameAction(array $params): array
    {
        $quiz = Quiz::with('options')->find($params['quiz_id']);
        $selectedOption = $quiz->options->find($params['answer_id']);
        
        $isCorrect = $selectedOption && $selectedOption->is_correct;
        
        return [
            'is_correct' => $isCorrect,
            'explanation' => $quiz->explanation,
            'correct_option' => $quiz->options->where('is_correct', true)->first()
        ];
    }

    /**
     * ゲームを終了し、最終結果を処理します
     *
     * @param array $gameState ゲームの状態情報
     * @return array 最終結果
     */
    public function finalizeGame(array $gameState): array
    {
        $userId = $this->getUserId();
        
        \Log::debug('Starting finalizeGame:', [
            'gameState' => $gameState,
            'userId' => $userId
        ]);

        // 進行中のゲームのみを取得するように修正
        $userGame = UserGame::where([
            'game_id' => $gameState['game_id'],
            'user_id' => $userId,
            'status' => 'in_progress'  // この条件を追加
        ])
        ->orderBy('created_at', 'desc')  // 最新のレコードを取得
        ->first();

        \Log::debug('UserGame found:', [
            'userGame' => $userGame ? $userGame->toArray() : null,
            'query' => [
                'game_id' => $gameState['game_id'],
                'user_id' => $userId,
                'status' => 'in_progress'
            ]
        ]);

        if (!$userGame) {
            \Log::error('Active game session not found:', [
                'game_id' => $gameState['game_id'],
                'user_id' => $userId
            ]);
            throw new \Exception('アクティブなゲームセッションが見つかりません。');
        }

        $correctAnswers = collect($gameState['answers'])
            ->filter(fn($answer) => $answer['is_correct'])
            ->count();

        \Log::debug('Calculated results:', [
            'correctAnswers' => $correctAnswers,
            'totalAnswers' => count($gameState['answers'])
        ]);

        $gameDetail = $userGame->gameDetail;
        $isQualified = $this->checkQualification($correctAnswers, $gameDetail);

        \Log::debug('Qualification check:', [
            'isQualified' => $isQualified,
            'gameDetail' => $gameDetail->toArray()
        ]);

        $this->updateGameResults($userGame, $correctAnswers, $isQualified, $gameDetail);

        return [
            'score' => $userGame->score,
            'qualified_for_award' => $isQualified
        ];
    }

    /**
     * 地域情報を検証し、取得します
     */
    public function validateAndGetRegion(string $regionCode): ?Region
    {
        return Region::where('code', $regionCode)->first();
    }

    /**
     * 利用可能なカテゴリーを取得します
     */
    public function getAvailableCategories(int $regionId): Collection
    {
        return QuizCategory::whereHas('quizzes', function ($query) use ($regionId) {
            $query->where('region_id', $regionId);
        })->get();
    }

    // プライベートメソッド

    private function createGameDetail(int $regionId, int $categoryId): GameDetail
    {
        return GameDetail::create([
            'json' => [
                'quiz_config' => [
                    'questions_per_game' => config('quiz.questions_per_game', 5),
                    'min_correct_for_award' => config('quiz.min_correct_for_award', 4)
                ],
                'region_id' => $regionId,
                'category_id' => $categoryId
            ]
        ]);
    }

    // 下記メソッドは不要 削除予定
    // private function createGameInstance(int $detailId): Game
    // {
    //     return Game::create([
    //         'game_name' => 'quiz',
    //         'base_score' => config('quiz.base_score', 100),
    //         'config_json' => ['type' => 'quiz'],
    //         'detail_id' => $detailId
    //     ]);
    // }

    private function createUserGameRecord(int $gameId, int $detailId): void
    {
        $userId = $this->getUserId();
        
        if (!$userId) {
            throw new \Exception('ユーザーが認証されていません。');
        }

        UserGame::create([
            'user_id' => $userId,
            'game_id' => 2, // クイズゲーム固定ID
            'status' => 'in_progress',
            'score' => 0,
            'detail_id' => $detailId
        ]);
    }

    private function getRandomQuizzes(int $regionId, int $categoryId, int $count): Collection
    {
        return Quiz::with('options')
            ->where('region_id', $regionId)
            ->where('category_id', $categoryId)
            ->inRandomOrder()
            ->take($count)
            ->get();
    }

    private function checkQualification(int $correctAnswers, GameDetail $gameDetail): bool
    {
        return $correctAnswers >= ($gameDetail->json['quiz_config']['min_correct_for_award'] ?? 4);
    }

    private function updateGameResults(
        UserGame $userGame,
        int $correctAnswers,
        bool $isQualified,
        GameDetail $gameDetail
    ): void {
        try {
            \Log::debug('Starting updateGameResults:', [
                'userGame' => $userGame->toArray(),
                'correctAnswers' => $correctAnswers,
                'isQualified' => $isQualified,
                'gameDetail' => $gameDetail->toArray()
            ]);

            DB::beginTransaction();
            
            $userGame = $userGame->fresh();
            \Log::debug('After fresh():', [
                'userGame' => $userGame->toArray()
            ]);
            
            $baseScore = $userGame->game->base_score;
            \Log::debug('Base score:', [
                'base_score' => $baseScore
            ]);

            $userGame->status = 'completed';
            $userGame->score = $correctAnswers * $baseScore;
            
            if ($isQualified) {
                $awardPath = $this->generateAwardImagePath(
                    $gameDetail->json['region_id'],
                    $gameDetail->json['category_id']
                );
                \Log::debug('Award path generated:', [
                    'path' => $awardPath
                ]);
                $userGame->picture = $awardPath;
            }

            \Log::debug('Before save():', [
                'userGame' => [
                    'id' => $userGame->id,
                    'status' => $userGame->status,
                    'score' => $userGame->score,
                    'picture' => $userGame->picture,
                    'isDirty' => $userGame->isDirty(),
                    'dirtyAttributes' => $userGame->getDirty()
                ]
            ]);
            
            $saved = $userGame->save();
            
            \Log::debug('After save():', [
                'saved' => $saved,
                'userGame' => $userGame->fresh()->toArray()
            ]);

            DB::commit();
            
            \Log::debug('Transaction committed');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update game results:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'userGame' => $userGame->toArray(),
                'sql' => DB::getQueryLog()
            ]);
            throw $e;
        }
    }

    private function generateAwardImagePath(int $regionId, int $categoryId): string
    {
        return sprintf(
            '../img/quiz/award_%d_%d_%s.jpg', // awardsからawardに修正
            $regionId,
            $categoryId,
            'default'
        );
    }

    private function getUserId(): int
    {
        // テストモード時のユーザーID取得ロジックを追加
        if (app()->environment('local') && session('test_mode')) {
            return session('user_id', 1);
        }
        return auth()->id();
    }
}