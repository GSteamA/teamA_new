<!-- 共通レイアウトファイル：_layout.blade.php を参照して表示している -->
@extends('quiz._layout')

@section('title', $region->display_name . ' - クイズメニュー')

@section('content')
<div class="quiz-menu-container">
    <h1 class="menu-title">{{ $region->display_name }}のクイズ</h1>

    <!-- Loop through all categories -->
    @foreach($categories as $category)
    <div class="quiz-category-section">
        <h2 class="category-title">{{ $category->display_name }}</h2>
        <form action="{{ route('Quiz.start') }}" method="POST">
            @csrf
            <input type="hidden" name="region_id" value="{{ $region->id }}">
            <input type="hidden" name="region_name" value="{{ $region->display_name }}">
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <input type="hidden" name="category_name" value="{{ $category->display_name }}">
            
            <button type="submit" class="start-button">
                このカテゴリーで始める
            </button>
        </form>
    </div>
    @endforeach
</div>

<div class="quiz-copyright">
    © 2024 LaravelTravel App. All rights reserved.
</div>
@endsection

@section('additional_css')
<style>
    body {
        background-color: var(--main-color);
        min-height: 100vh;
    }

    .quiz-menu-container {
        max-width: 1200px;  /* 800pxから1200pxに変更 */
        margin: 0 auto;
        padding: 40px;      /* 20pxから40pxに変更 */
    }

    /* タイトルのスタイルを追加 */
    .menu-title {
        color: white;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .quiz-category-section {
        margin-bottom: 20px;
        max-width: 800px;   /* 追加：セクション幅の制限 */
        margin: 0 auto 30px; /* marginを調整 */
    }

    .category-title {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .start-button {
        width: 100%;
        background-color: white;
        color: var(--navy-color);
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        transition: all 0.3s ease;
        max-width: 800px;   /* 追加：ボタン幅の制限 */
        display: block;     /* 追加：中央配置のため */
        margin: 0 auto;     /* 追加：中央配置のため */
    }

    .start-button:hover {
        background-color: var(--navy-color);
        color: white;
    }

    .start-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quiz-copyright {
        text-align: center;
        color: white;
        font-size: 0.8rem;
        margin-top: 40px;
        opacity: 0.8;
    }
</style>
@endsection