<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Services\Quiz\QuizGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Quiz\StartGameRequest;
use App\Http\Requests\Quiz\SubmitAnswerRequest;

class QuizGameController extends Controller
{
    private QuizGameService $quizService;
    private const QUIZ_STATE_KEY = 'quiz_state';

    public function __construct(QuizGameService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * クイズのメニュー画面を表示します。
     * 地域パラメータに基づいて、利用可能なカテゴリーを表示します。
     */
    public function showMenu(Request $request)
    {
        $region = $this->quizService->validateAndGetRegion($request->region);
        
        if (!$region) {
            return redirect()->route('home')
                ->with('error', '指定された地域が見つかりません。');
        }

        $categories = $this->quizService->getAvailableCategories($region->id);

        return view('quiz.menu', [
            'region' => $region,
            'categories' => $categories
        ]);
    }

    /**
     * クイズゲームを開始します。
     * 選択された地域とカテゴリーに基づいてゲームを初期化します。
     */
    public function startGame(StartGameRequest $request)
    {
        $gameConfig = $this->quizService->initializeGame([
            'region_id' => $request->region_id,
            'category_id' => $request->category_id
        ]);

        if (!$gameConfig) {
            return redirect()->route('quiz.menu')
                ->with('error', 'ゲームの初期化に失敗しました。');
        }

        // ゲームの初期状態をセッションに保存
        $this->initializeGameState($gameConfig);

        return view('quiz.game', [
            'gameConfig' => $gameConfig,
            'region' => $request->region_name,
            'category' => $request->category_name
        ]);
    }

    /**
     * クイズの回答を処理します。
     * 回答の正誤判定と、次の問題への遷移を管理します。
     */
    public function submitAnswer(SubmitAnswerRequest $request)
    {
        $quizState = $this->getGameState();
        
        if (!$quizState) {
            return response()->json([
                'error' => 'ゲームセッションが見つかりません。'
            ], 400);
        }

        $result = $this->quizService->processGameAction([
            'quiz_id' => $request->quiz_id,
            'answer_id' => $request->answer_id
        ]);

        // ゲーム状態の更新
        $this->updateGameState($request->quiz_id, $request->answer_id, $result['is_correct']);

        return response()->json([
            'result' => $result,
            'is_last_question' => $this->isLastQuestion()
        ]);
    }

    /**
     * クイズの結果画面を表示します。
     * 最終スコアの計算と、表彰の判定を行います。
     */
    public function showResult()
    {
        $quizState = $this->getGameState();
        
        if (!$quizState) {
            return redirect()->route('quiz.menu')
                ->with('error', 'ゲームセッションが見つかりません。');
        }

        $result = $this->quizService->finalizeGame($quizState);

        // ゲームセッションのクリア
        $this->clearGameState();

        if ($result['qualified_for_award']) {
            return redirect()->route('quiz.award', [
                'game_id' => $quizState['game_id']
            ]);
        }

        return view('quiz.result', [
            'result' => $result,
            'game_id' => $quizState['game_id']
        ]);
    }

    /**
     * ゲーム状態の管理用プライベートメソッド
     */
    private function initializeGameState(array $gameConfig): void
    {
        session([self::QUIZ_STATE_KEY => [
            'game_id' => $gameConfig['game_id'],
            'current_question_index' => 0,
            'answers' => [],
            'start_time' => now()
        ]]);
    }

    private function getGameState(): ?array
    {
        return session(self::QUIZ_STATE_KEY);
    }

    private function updateGameState(int $quizId, int $answerId, bool $isCorrect): void
    {
        $quizState = $this->getGameState();
        
        $quizState['answers'][] = [
            'quiz_id' => $quizId,
            'answer_id' => $answerId,
            'is_correct' => $isCorrect
        ];
        
        $quizState['current_question_index']++;
        
        session([self::QUIZ_STATE_KEY => $quizState]);
    }

    private function clearGameState(): void
    {
        session()->forget(self::QUIZ_STATE_KEY);
    }

    private function isLastQuestion(): bool
    {
        $quizState = $this->getGameState();
        return count($quizState['answers']) >= config('quiz.questions_per_game', 5);
    }
}