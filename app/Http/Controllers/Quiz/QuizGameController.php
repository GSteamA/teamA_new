<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Services\Quiz\QuizGameService;
use App\Models\Quiz\Region;
use App\Models\Quiz\QuizCategory;
use Illuminate\Http\Request;
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
     * URLパラメータから地域情報を取得し、その地域で利用可能なカテゴリーを表示します。
     * 
     * @param Request $request リクエスト情報（regionパラメータを含む）
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showMenu(Request $request)
    {
        // QuizGameServiceのメソッドを使用して地域情報を取得・検証
        $region = $this->quizService->validateAndGetRegion($request->region);
        if (!$region) {
            return redirect()->route('home')
                ->with('error', '指定された地域が見つかりません。');
        }

        // その地域で利用可能なカテゴリーを取得
        $categories = $this->quizService->getAvailableCategories($region->id);

        return view('quiz.menu', [
            'region' => $region,
            'categories' => $categories
        ]);

        // テスト用に変更：ビューの代わりにデータを返す
        // return [
        //     'region' => $region,
        //     'categories' => $categories
        // ];
    }

    /**
     * クイズゲームを開始します。
     * 選択された地域とカテゴリーに基づいてゲームを初期化し、最初の問題を表示します。
     * 
     * @param StartGameRequest $request バリデーション済みのリクエスト情報
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function startGame(StartGameRequest $request)
    {
        // dd($request ?? 'null');
        // ゲームの初期化
        $gameConfig = $this->quizService->initializeGame([
            'region_id' => $request->region_id ?? 1,
            'category_id' => $request->category_id
        ]);

        // dd($gameConfig ?? 'null');
        if (!$gameConfig) {
            return redirect()->route('Quiz.menu')
                ->with('error', 'クイズの準備に失敗しました。');
        }

        // セッションにゲーム状態を保存
        session([self::QUIZ_STATE_KEY => [
            'game_id' => $gameConfig['game_id'],
            'current_question_index' => 0,
            'answers' => [],
            'start_time' => now()
        ]]);

        // 地域名とカテゴリー名はリクエストから取得
        return view('quiz.game', [
            'gameConfig' => $gameConfig,
            'quizzes' => $gameConfig['quizzes'],
            'region' => $request->region_name,
            'category' => $request->category_name
        ]);
        // return [
        //     'gameConfig' => $gameConfig,
        //     // 'quizzes' => $gameConfig['quizzes'],
        //     'region' => $request->region_name,
        //     'category' => $request->category_name
        // ];
    }

    /**
     * クイズの回答を処理します。
     * 
     * @param SubmitAnswerRequest $request バリデーション済みのリクエスト情報
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitAnswer(SubmitAnswerRequest $request)
    {
        $quizState = session(self::QUIZ_STATE_KEY);
        if (!$quizState) {
            return response()->json([
                'error' => 'ゲームセッションが見つかりません。'
            ], 400);
        }

        // QuizGameServiceのインターフェースに合わせて回答処理を実行
        $result = $this->quizService->processGameAction([
            'quiz_id' => $request->quiz_id,
            'answer_id' => $request->answer_id
        ]);

        // セッションの更新
        $quizState['answers'][] = [
            'quiz_id' => $request->quiz_id,
            'answer_id' => $request->answer_id,
            'is_correct' => $result['is_correct']
        ];
        $quizState['current_question_index']++;
        session([self::QUIZ_STATE_KEY => $quizState]);

        return response()->json([
            'result' => $result,
            'is_last_question' => count($quizState['answers']) >= config('quiz.questions_per_game', 5)
        ]);
    }

    /**
     * ゲームの結果を表示します。
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showResult()
    {
        $quizState = session(self::QUIZ_STATE_KEY);
        if (!$quizState) {
            return redirect()->route('quiz.menu')
                ->with('error', 'ゲームセッションが見つかりません。');
        }

        // ゲームの最終結果を処理
        $result = $this->quizService->finalizeGame($quizState);
        
        // セッションをクリア
        session()->forget(self::QUIZ_STATE_KEY);

        // 表彰の条件を満たしている場合は表彰画面へリダイレクト
        if ($result['qualified_for_award']) {
            return redirect()->route('quiz.award', ['game_id' => $quizState['game_id']]);
        }

        return view('quiz.result', compact('result'));
    }
}