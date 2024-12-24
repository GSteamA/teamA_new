<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('css/lasvegas/lasvegas1.css') }}">
    <title>LasVegas|LaravelTravel</title>
</head>
<body>
<div class="wrapper">
  <h1>Welcome to Las Vegas !!!</h1>  
  <p>ゲームをクリアして、記念写真を撮影しよう</p>
  <div class="game-rule">
    <h2>Black Jack ゲーム</h2>
    <h3>♦︎基本ルール</h3>
    <p>
    カジノディーラーとプレイヤーの対戦型ゲームです。<br>
    プレイヤーはカジノディーラーよりも「カードの合計が21点」に近ければ勝利となり、賭け金の2倍の金額を得ることができます。<br>
    ただしプレイヤーの「カードの合計が21点」を超えてしまうと、その時点で負けとなります。<br>
    <br>
    【カードの数え方】<br>
    ”2～9”まではそのままの数字、”10・J・Q・K”は「すべて10点」と数えます。<br>
    また、”A”（エース）は「1点」もしくは「11点」のどちらに数えても構いません。<br>
    <br>
    【特別な役】<br>
    最初に配られた2枚のカードが　”Aと10点札”　で21点が完成していた場合を『ブラックジャック』といい、その時点で勝ちとなります。但し、カジノディーラーもブラックジャックだった場合は引き分けとなります。
    </p>
  </div>
  <div class="announce">
        <img src="{{ url('img/lasvegas/announce2.png') }}" alt="ディーラーの熊の画像" class="announce-dog">
        <div class="hukidashi">
          <img src="{{ url('img/lasvegas/hukidashi.png') }}" alt="吹き出し画像">
          <p id="announce-msg">最初の所持金は、40ドルからスタート！<br>80ドルまで増やすことができたらクリアだよ！</p>
        </div>
  </div>
  <a href="{{ route('lasvegas2') }}">スタート</a>
</div>
</body>
</html>