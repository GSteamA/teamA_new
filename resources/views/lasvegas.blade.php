<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ url('css/lasvegas.css') }}">
  <link rel="icon" href="{{ url('img/icon.jpeg') }}" type="image/x-icon">
  <link rel="preconnect" href="{{ url('https://fonts.googleapis.com') }}">
  <link rel="preconnect" href="{{ url('https://fonts.gstatic.com') }}" crossorigin>
  <link href="{{ url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap') }}"
    rel="stylesheet">
  <title>LasVegas|LaravelTravel </title>
</head>

<body>
  <div class="wrapper">
    <div class="title">
      <h1>Let's play BLACK JACK!</h1>
    </div>
    <div class="dealer">
      <audio id="bgm" src="{{ url('music/betting_on_you.mp3') }}" preload="auto" ></audio>
      <button id="playButton">♪ MUSIC ON</button>
      <div class="dealer_t">
        <img src="{{ url('img/omote.png') }}" alt="ディーラーの手札1枚目です" id="dealer_1">
        <img src="{{ url('img/omote.png') }}" alt="ディーラーの手札2枚目です" id="dealer_2">
        <img src="{{ url('img/omote.png') }}" alt="ディーラーの手札3枚目です" id="dealer_3">
        <img src="{{ url('img/omote.png') }}" alt="ディーラーの手札4枚目です" id="dealer_4">
        <img src="{{ url('img/omote.png') }}" alt="ディーラーの手札5枚目です" id="dealer_5">
        <img src="{{ url('img/omote.png') }}" alt="" id="dealer_2_2">
      </div>
      <div id="dealer_score"></div>
      <svg viewBox="0 0 100 100" class="svg1">
        <!-- 下向きの円弧を描く。開始点と終点のy座標を異なる値にする。 -->
        <path d="M 10,30 A 100,100 0 0 0 90,30" stroke="white" fill="none" stroke-width="0.3" />
      </svg>
      <svg viewBox="0 0 100 100" class="svg2">
        <!-- 下向きの円弧を描く。開始点と終点のy座標を異なる値にする。 -->
        <path d="M 10,30 A 100,100 0 0 0 90,30" stroke="white" fill="none" stroke-width="0.3" />
      </svg>
    </div>

      <div id="message"></div>
      <div class="you">
      <div class="you_t">
        <img src="{{ url('img/omote.png') }}" alt="あなたの手札1枚目です" id="you_1">
        <img src="{{ url('img/omote.png') }}" alt="あなたの手札2枚目です" id="you_2">
        <img src="{{ url('img/omote.png') }}" alt="あなたの手札3枚目です" id="you_3">
        <img src="{{ url('img/omote.png') }}" alt="あなたの手札4枚目です" id="you_4">
        <img src="{{ url('img/omote.png') }}" alt="あなたの手札5枚目です" id="you_5">
      </div>
      <div id="score">0</div>

      <svg viewBox="0 0 100 100">
        <!-- 長方形を描く -->
        <rect x="10" y="10" width="12" height="15" fill="none" stroke="white" stroke-width="0.3" />
      </svg>
      <img src="{{ url('img/toumei.png') }}" alt="" class="tip1">
      <img src="{{ url('img/toumei.png') }}" alt="" class="tip2">
    </div>

    <div class="btn">
      <ul>
        <li id="hit">Hit</li>
        <li id="stand">Stand</li>
        <li id="surrender">Surrender</li>
      </ul>
    </div>

    <div class="money">
      <div class="money_1">
        <ul>
          <li>Credit <span id="credit_area"></span></li>
          <li>Bet <span id="bet">0</span></li>
        </ul>
      </div>
      <div class="money_2">
        <div id="bet_btns"></div>
        <audio id="charin" src="{{ url('music/お金を落とす1.mp3') }}" preload="auto" ></audio>
        <audio id="bu-"    src="{{ url('music/クイズ不正解2.mp3') }}" preload="auto" ></audio>
        <audio id="win"    src="{{ url('music/win.mp3') }}" preload="auto" ></audio>
        <audio id="lose"   src="{{ url('music/lose.mp3') }}" preload="auto" ></audio>
        <audio id="card"   src="{{ url('music/card.mp3') }}" preload="auto" ></audio>
        <button class="reset">リセット</button>
      </div>
    </div>
    <script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
  </div>
</body>

</html>
