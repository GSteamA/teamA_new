@extends('quiz._layout')

@section('title', '表彰状')

@section('content')
<div class="award-container">
    <h1 class="award-title">おめでとうございます！</h1>

    <div class="award-content">
        <div class="award-image">
            <!-- 表彰状の画像を表示 -->
            <img src="{{ asset('storage/' . $result['award_image']) }}" alt="表彰状" class="certificate-image">
        </div>

        <div class="award-message">
            <p>素晴らしい成績を収められました！</p>
            <p>この表彰状を記念として保存してください。</p>
        </div>

        <div class="action-buttons">
            <a href="{{ route('Quiz.menu', ['region' => session('last_region', 'harajuku')]) }}" class="menu-button">
                メニューに戻る
            </a>
            <button onclick="window.print()" class="print-button">
                表彰状を印刷する
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional_css')
<style>
    .award-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .award-title {
        color: white;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .award-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .award-image {
        text-align: center;
        margin-bottom: 30px;
    }

    .certificate-image {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
    }

    .award-message {
        text-align: center;
        margin-bottom: 30px;
        color: var(--navy-color);
    }

    .award-message p {
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .menu-button, .print-button {
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .menu-button {
        background-color: var(--main-color);
        color: white;
    }

    .print-button {
        background-color: var(--navy-color);
        color: white;
        border: none;
        cursor: pointer;
    }

    .menu-button:hover, .print-button:hover {
        opacity: 0.9;
    }

    @media print {
        .action-buttons {
            display: none;
        }
    }
</style>
@endsection
