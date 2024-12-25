<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('css/quiz/reset.css') }}">
    <link rel="stylesheet" href="{{ url('css/quiz/hakata-wellcome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>Harajuku|LaravelTravel</title>
</head>
<body>
<div class="wrapper">
  <h1>Welcome to Hakata Quiz !!!</h1>
  <p>クイズをクリアして、記念写真をゲットしよう</p>
  <div class="game-rule">
    <h2>博多クイズ</h2>
    <h3>♦︎基本ルール</h3>
    <p>
    についてクイズ形式で答えてみよう！<br>
    クイズのジャンルを選んで、そのジャンルのクイズを解いてみよう！<br>
    クイズのジャンルは、「文化」「歴史」「ことば」「人物」「経済」の5つから選べます。<br>
    <br>
    【クリアの条件】<br>
    問題が5問出題されるので、全て正解するとクリアとなります。<br>
    何度でも再チャレンジ可能なのでクリア目指して頑張ってください！<br>
    <br>
    【ジャンルごとに異なる記念写真】<br>
    クリアすると、ジャンルごとに異なる記念写真がゲットできます。<br>
    ゲットした写真は、マイページから確認できます。<br>
    ぜひ、全種類の写真をゲットして、あなたの博多ライフを本棚に飾りましょう。<br>
    </p>
  </div>
  <div class="announce">
        <img src="{{ url('img/lasvegas/announce2.png') }}" alt="ディーラーの熊の画像" class="announce-dog">
        <div class="hukidashi">
          <img src="{{ url('img/lasvegas/hukidashi.png') }}" alt="吹き出し画像">
          <p id="announce-msg">最初にジャンルを選択！<br>5問中5問回答できたらクリアだよ！</p>
        </div>
  </div>
  <!-- <a href="{{ route('quiz.menu', ['region' => 'harajuku']) }}" class="start-button">スタート</a> -->
  <a href="{{ route('quiz.menu', 'hakata') }}">スタート</a>
</div>
</body>
</html>
