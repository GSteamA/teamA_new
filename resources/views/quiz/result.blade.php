@extends('quiz._layout')

@section('title', 'クイズ結果')

@section('content')
<div class="quiz-result-container">
    <h1 class="result-title">クイズ結果</h1>

    <div class="result-content">
        <div class="score-section">
            <div class="score-label">スコア</div>
            <div class="score-value">{{ $result['score'] }}点</div>
        </div>

        <div class="stats-section">
            <div class="stat-item">
                <div class="stat-label">正解数</div>
                <div class="stat-value">{{ $result['correct_answers'] }} / {{ $result['total_questions'] }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('quiz.menu', ['region' => session('last_region', 'harajuku')]) }}" class="menu-button">
                メニューに戻る
            </a>
        </div>
    </div>
</div>
@endsection

@section('additional_css')
<style>
    .quiz-result-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .result-title {
        color: white;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .result-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .score-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .score-label {
        font-size: 1.2rem;
        color: var(--navy-color);
        margin-bottom: 10px;
    }

    .score-value {
        font-size: 3rem;
        font-weight: bold;
        color: var(--main-color);
    }

    .stats-section {
        border-top: 1px solid #eee;
        padding-top: 20px;
        margin-bottom: 30px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 1.1rem;
        color: var(--navy-color);
    }

    .stat-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--navy-color);
    }

    .action-buttons {
        text-align: center;
    }

    .menu-button {
        display: inline-block;
        padding: 15px 40px;
        background-color: var(--main-color);
        color: white;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .menu-button:hover {
        background-color: var(--navy-color);
    }
</style>
@endsection
