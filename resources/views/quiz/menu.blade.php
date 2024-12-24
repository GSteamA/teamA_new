<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クイズメニュー - {{ $region->display_name }}編</title>
    @vite(['public/css/quiz/menu.css','public/js/quiz/menu.js'])
</head>
<body>
    <div>
        <h1>{{ $region->display_name }}のクイズ</h1>
        @if(session('error'))
            <div>{{ session('error') }}</div>
        @endif

        <div>
            @foreach($categories as $category)
            <div>
                <h2>{{$category->display_name}}</h2>
                <form action="{{ route('quiz.start') }}" method="post">
                    @csrf
                    <input type="hidden" name="region_id" value="{{ $region->id }}">
                    <input type="hidden" name="region_name" value="{{ 
                    $region->name }}">"
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                    <input type="hidden" name="category_name" value="{{ $category->display_name }}">
                    <button type="submit">このカテゴリーで始める</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    
</body>
</html>
