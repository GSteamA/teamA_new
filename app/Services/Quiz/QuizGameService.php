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
            DB::beginTransaction();

            // ゲーム設定の構成
            $gameDetail = $this->createGameDetail($params['region_id'], $params['category_id']);
            // ゲームインスタンスの作成
            $game = $this->createGameInstance($gameDetail->id);
            // dd($game);

            // クイズの取得と検証
            $quizzes = $this->getRandomQuizzes(
                $params['region_id'],
                $params['category_id'],
                $gameDetail->json['quiz_config']['questions_per_game']
            );
            // dd($quizzes);

            if ($quizzes->isEmpty()) {
                DB::rollBack();
                return null;
            }

            // ユーザーのゲーム参加記録を作成
            $this->createUserGameRecord($game->id, $gameDetail->id);

            DB::commit();

            dd($gameDetail->json['quiz_config']);
            return [
                'game_id' => $game->id,
                'quizzes' => $quizzes,
                'config' => $gameDetail->json['quiz_config']
            ];

        } catch (\Exception $e) {
            DB::rollBack();
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
        $userGame = UserGame::where([
            'game_id' => $gameState['game_id'],
            'user_id' => auth()->id()
        ])->first();

        $correctAnswers = collect($gameState['answers'])
            ->filter(fn($answer) => $answer['is_correct'])
            ->count();

        $gameDetail = $userGame->gameDetail;
        $isQualified = $this->checkQualification($correctAnswers, $gameDetail);

        $this->updateGameResults(
            $userGame,
            $correctAnswers,
            $isQualified,
            $gameDetail
        );

        return [
            'correct_answers' => $correctAnswers,
            'total_questions' => count($gameState['answers']),
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

    private function createGameInstance(int $detailId): Game
    {
        return Game::create([
            'game_name' => 'quiz',
            'base_score' => config('quiz.base_score', 100),
            'config_json' => ['type' => 'quiz'],
            'detail_id' => $detailId
        ]);
    }

    private function createUserGameRecord(int $gameId, int $detailId): void
    {
        UserGame::create([
            'user_id' => auth()->id(),
            'game_id' => $gameId,
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
        $userGame->update([
            'status' => 'completed',
            'score' => $correctAnswers * $userGame->game->base_score,
            'picture' => $isQualified ? $this->generateAwardImagePath(
                $gameDetail->json['region_id'],
                $gameDetail->json['category_id']
            ) : null
        ]);
    }

    private function generateAwardImagePath(int $regionId, int $categoryId): string
    {
        return sprintf(
            'awards/%d_%d_%s.jpg',
            $regionId,
            $categoryId,
            now()->format('Ymd_His')
        );
    }
}