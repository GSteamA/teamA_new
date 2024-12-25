@extends('quiz._layout')

@section('title', 'クイズゲームテストドライバー')

@section('content')
<div class="test-driver-container">
    <h1 class="driver-title">クイズゲームテストドライバー</h1>
    
    <div class="driver-content">
        <form action="{{ route('quiz.test-login') }}" method="POST" class="test-form">
            @csrf
            <div class="form-group">
                <label for="user_id">テストユーザーID:</label>
                <select name="user_id" id="user_id" required>
                    <option value="1">テストユーザー1</option>
                    <option value="2">テストユーザー2</option>
                    <option value="3">テストユーザー3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="region">地域選択:</label>
                <select name="region" id="region" required>
                    <option value="harajuku">原宿</option>
                    <option value="hakata">博多</option>
                    <option value="las_vegas">ラスベガス</option>
                </select>
            </div>

            <button type="submit" class="submit-button">テストセッション開始</button>
        </form>

        <div class="session-info">
            <h2>現在のセッション情報</h2>
            <pre>{{ print_r(session()->all(), true) }}</pre>
        </div>
    </div>
</div>
@endsection

@section('additional_css')
<style>
    .test-driver-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .driver-title {
        color: white;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .driver-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .test-form {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: var(--navy-color);
    }

    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .submit-button {
        width: 100%;
        padding: 15px;
        background-color: var(--main-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: var(--navy-color);
    }

    .session-info {
        margin-top: 30px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 8px;
    }

    .session-info h2 {
        color: var(--navy-color);
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .session-info pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endsection 