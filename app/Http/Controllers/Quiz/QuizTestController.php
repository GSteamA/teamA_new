<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizTestController extends Controller
{
    public function showTestDriver()
    {
        // 開発環境でのみアクセス可能
        if (!app()->environment('local')) {
            abort(404);
        }
        
        return view('quiz.test-driver');
    }

    public function testLogin(Request $request)
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        // auth()でもユーザーIDを取得できるように設定
        session([
            'user_id' => $request->user_id,
            'test_mode' => true,
            'last_region' => $request->region,
            'auth.id' => $request->user_id
        ]);

        \Log::debug('Test Session Created:', session()->all());

        return redirect()->route('Quiz.menu', ['region' => $request->region])
            ->with('success', 'テストセッションを開始しました');
    }
} 