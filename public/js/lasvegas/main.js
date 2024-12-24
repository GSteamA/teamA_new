
// トランプデッキを作成する関数
function createDeck() {
    const suits = ['s', 'h', 'd', 'c']; // スート
    const ranks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13']; // ランク
    let deck = [];
    for (let suit of suits) {
        for (let rank of ranks) {
            deck.push(`${suit}${rank}`);
        }
    }
    return deck;
};

// シャッフルする関数
function shuffleDeck(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]]; // カードを交換
    }
    return deck;
};

//カードを引いて画像表示させる関数
function drawCard(deck, imgPosition) {
    if (deck.length === 0) {
        return 'デッキが空です';
    }
    drawCardNum = deck.pop(); // デッキから1枚引く
    $(imgPosition).attr("src", imgCard(drawCardNum, cardURL));
    return drawCardNum;
};

//カード画像のURLを表示する関数
let currentCard = "";
let cardURL = "img/lasvegas/omote.png";
function imgCard(currentCard, cardURL) {
    cardURL = "img/lasvegas/" + currentCard + ".png"
    return cardURL;
};

//チップ画像を表示する関数
function tipImg1(){
    tip1URL = "img/lasvegas/" + window.selectBet + ".png"
    $(".tip1").attr("src", tip1URL);
};

//チップ画像2枚目を表示する関数
function tipImg2(){
    tip2URL = "img/lasvegas/" + window.selectBet + ".png"
    $(".tip2").attr("src", tip2URL);
};

//掛け金をかけたときの効果音を再生する関数
function playCharin() {
    const audio2 = $("#charin")[0];
    audio2.play();
};

//持ち金以上の掛け金をかけた時の効果音を再生する関数
function playBu() {
    const audio3 = $("#bu-")[0];
    audio3.play();
};

//数字を調整する関数(トランプの値を数字のみにし、11〜13は10に、1は場合によって11か1に調整)
function adjustNum(card, oldSum) {
    let cardNum = Number(card.replace(/[^0-9^]/g, ""));
    if (cardNum > 11) {
        cardNum = 10;
    } else if (cardNum == 1 && oldSum < 11) {
        cardNum = 11;
    };
    return cardNum
};

//リスタート関数
function restartGame(){
    $("#dealer_1, #dealer_2, #dealer_3, #dealer_4, #dealer_5,#you_1, #you_2, #you_3, #you_4, #you_5").attr("src","img/lasvegas/omote.png");
    window.dealerScore=0, window.youScore = 0, window.dealer1=0, window.dealer2=0, window.dealer3=0, window.dealer4=0, window.dealer5=0, window.dealerNum1=0, window.dealerNum2=0,window.dealerNum3=0, window.dealerNum4=0, window.dealerNum5=0, window.you1=0, window.you2=0, window.you3=0, window.you4=0, window.you5=0, window.youNum1=0, window.youNum2=0, window.youNum3=0, window.youNum4=0, window.youNum5=0;
    $("#message").css("opacity","0");
    $("#message").html("");
    $("#score").html("");
    $("#dealer_2_2").css("display", "block");
    $("#dealer_score").html("");
    $(".tip1").attr("src", "img/lasvegas/toumei.png");
    $(".tip2").attr("src", "img/lasvegas/toumei.png");
};

//ゲーム終了後の、データ引き継ぎorリセット処理
function finishGame(){
    let oldCredit = Number($("#credit_area").text());
    localStorage.clear();

    if (oldCredit == 0) {
        overGame();
    } else {
        continueGame();
    }};

//ゲームオーバー関数
function overGame(){
    $("#message").css("opacity","1");
    $("#message").html("GAME OVER...");
    setTimeout(() => {location.reload();}, 2000) //2秒後にリロード;
};

//コンティニュー関数
function continueGame(){
    let key = 1;
    let oldCredit = Number($("#credit_area").text());
    localStorage.setItem(key, oldCredit);
    setTimeout(restartGame, 2000); //2秒後にリスタート
};

//ゲームに勝ったときの関数
function winGame(message){
    $("#dealer_2_2").css("display", "none");
    $("#dealer_score").html(window.dealerScore);
    $("#message").css("opacity","1");
    $("#message").html(message);
    $("#credit_area").text(Number(window.credit) + Number(window.selectBet)*2);
    $("#bet").text(0);
    tipImg2();
    const audio3 = $("#win")[0];
    audio3.play();
    sendScore();
    finishGame();
    };

//ゲームに負けたときの関数
function loseGame(message){
    $("#dealer_2_2").css("display", "none");
    $("#dealer_score").html(window.dealerScore);
    $("#message").css("opacity","1");
    $("#message").html(message);
    $("#bet").text(0);
    $(".tip1").attr("src", "img/lasvegas/toumei.png");
    const audio4 = $("#lose")[0];
    audio4.play();
    finishGame();
    };

//ゲームに引き分けのときの関数
function drawGame(message){
    $("#dealer_2_2").css("display", "none");
    $("#dealer_score").html(window.dealerScore);
    $("#message").css("opacity","1");
    $("#message").html(message);
    $("#credit_area").text(Number(window.credit) + Number(window.selectBet));
    $("#bet").text(0);
    finishGame();
    };

//サレンダーのときの関数
function surrenderGame(){
    $("#dealer_2_2").css("display", "none");
    $("#dealer_score").html(window.dealerScore);
    $("#message").css("opacity","1");
    $("#message").html("You pay "+Number(window.selectBet) / 2+"＄");
    $("#credit_area").text(Number(window.credit) + Number(window.selectBet)/2);
    $("#bet").text(0);
    const audio4 = $("#lose")[0];
    audio4.play();
    finishGame();
    };

//プレイヤーのスコアが21点になったときの処理
function ruleScore21() {
    if (window.dealerScore == 21) {
        drawGame("BLACK JUCK! DRAW...");
    } else {
        winGame("BLACK JACK!!!YOU WIN!!!");
    };
};

//スコアを送信する関数
async function sendScore(){
    const score = Number($("#credit_area").text());

    const response = await fetch('/lasvegas/store-or-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ score: score }),
    });

    const data = await response.json();

    if (data.success) {
        console.log('ゲームデータが保存されました:', data.game);
    } else {
        console.error('エラーが発生しました');
    }
}

$(document).ready(function() {

//画面表示
$(".dealer_t,#dealer_2_2,.you_t").fadeIn(1000);

//bgm
$(document).ready(function () {
    var audio = $('#bgm')[0]; // audio要素を取得
    var isPlaying = false;

    // デフォルトの音量を小さく設定
    audio.volume = 0.2;

    $('#playButton').click(function () {
        if (isPlaying) {
            audio.pause(); // 音楽を一時停止
            audio.currentTime = 0; // 再生位置を最初に戻す
            $(this).text('♪ MUSIC ON'); // ボタンのテキストを「再生」に変更
        } else {
            audio.play(); // 音楽を再生
            $(this).text('♪ MUSIC OFF'); // ボタンのテキストを「停止」に変更
        }
        isPlaying = !isPlaying; // フラグを反転
    });
});

//掛け金とクレジットを設定
window.betAmounts = [1, 5, 10, 20, 50, 100];
window.firstcredit = 40;

//掛け金を動的に表示
$("#credit_area").append(window.firstcredit);

//ボタンを動的に生成して追加
window.betAmounts.forEach(function(bet) {
    $("<button>", {
        class: "start",
        value: bet,
        text: bet + '$'
    }).appendTo("#bet_btns");
});

// デッキを作成してシャッフル
window.deck = createDeck();
window.deck = shuffleDeck(window.deck);

// グローバル変数を明示的に window に登録(laravel-mixの影響で、グローバル変数が使えないため)
window.credit = Number($("#credit_area").text());
window.dealerScore = 0;
window.youScore = 0;

window.dealer1 = undefined;
window.dealer2 = undefined;
window.dealer3 = undefined;
window.dealer4 = undefined;
window.dealer5 = undefined;

window.dealerNum1 = undefined;
window.dealerNum2 = undefined;
window.dealerNum3 = undefined;
window.dealerNum4 = undefined;
window.dealerNum5 = undefined;

window.you1 = 0;
window.you2 = 0;
window.you3 = 0;
window.you4 = 0;
window.you5 = 0;

window.youNum1 = undefined;
window.youNum2 = undefined;
window.youNum3 = undefined;
window.youNum4 = undefined;
window.youNum5 = undefined;

window.selectBet = undefined; // グローバル変数として定義


//掛け金をクリックしたときのスタート処理
$(document).on("click", ".start", function () {
    window.selectBet = Number($(this).val());
    window.credit = Number($("#credit_area").text());
    tipImg1();
    if (window.selectBet > window.credit) {
        playBu();
        return
    } else if (window.selectBet <= window.credit) {
        playCharin();
        $("#bet").text(window.selectBet);
        $("#credit_area").text(window.credit - window.selectBet);
        window.credit = Number($("#credit_area").text());
        window.dealer1 = drawCard(window.deck, "#dealer_1");
        window.dealer2 = drawCard(window.deck, "#dealer_2");
        window.you1 = drawCard(window.deck, "#you_1");
        window.you2 = drawCard(window.deck, "#you_2");

        window.dealerNum1 = Number(adjustNum(window.dealer1, 0));
        window.dealerNum2 = Number(adjustNum(window.dealer2, window.dealerNum1));
        window.youNum1 = Number(adjustNum(window.you1, 0));
        window.youNum2 = Number(adjustNum(window.you2, window.youNum1));
        window.dealerScore = window.dealerNum1 + window.dealerNum2;
        window.youScore = window.youNum1 + window.youNum2;
        $("#score").html(window.youScore);

        if (window.youScore == 21) {
        ruleScore21();
        };
    };
});

//hit操作
$("#hit").click(function () {
    if($("#bet").text() == 0){
        playBu();
        return;
    }
    const audio5 = $("#card")[0];
    audio5.play();
        if (window.you3 == 0) {
            window.you3 = drawCard(window.deck,"#you_3");
            window.youNum3 = Number(adjustNum(window.you3,window.youScore));
            window.youScore = window.youScore + window.youNum3;
            $("#score").html(window.youScore);

            if (window.youScore == 21) {
                ruleScore21();
            } else if (window.youScore >= 22) {
                loseGame("BUSTED!!!YOU LOSE...");
            }
        } else if (window.you4 == 0) {
            window.you4 = drawCard(window.deck,"#you_4");
            window.youNum4 = Number(adjustNum(window.you4,window.youScore));
            window.youScore = window.youScore + window.youNum4;
            $("#score").html(window.youScore);

            if (window.youScore == 21) {
                ruleScore21();
            } else if (window.youScore >= 22) {
                loseGame("BUSTED!!!YOU LOSE...");
            }
        } else if (window.you5 == 0) {
            window.you5 = drawCard(window.deck,"#you_5");
            window.youNum5 = Number(adjustNum(window.you5,window.youScore));
            window.youScore = window.youScore + window.youNum5;
            $("#score").html(window.youScore);

            if (window.youScore == 21) {
                ruleScore21();
            } else if (window.youScore >= 22) {
                loseGame("BUSTED!!!YOU LOSE...");
            }
        }
    });

//Stand操作
$("#stand").on("click", function () {
    if($("#bet").text() == 0){
        playBu();
        return;
    }

    const audio5 = $("#card")[0];
    audio5.play();
    if (window.dealerScore == 21) {
        loseGame("SORRY...YOU LOSE...");
    } else if (window.dealerScore < 21 && window.dealerScore >= 17) {
        if (window.dealerScore < window.youScore) {
            winGame("CONGRATULAYIONS!YOU WIN!");
        } else if (window.dealerScore > window.youScore) {
            loseGame("SORRY...YOU LOSE...");
        } else {
            drawGame("DRAW! LET'S TRAY AGAIN!");
        }
    } else if (window.dealerScore < 17) {
        window.dealer3 = drawCard(window.deck,"#dealer_3");
        window.dealerNum3 = Number(adjustNum(window.dealer3,window.dealerScore));
        window.dealerScore = window.dealerScore + window.dealerNum3;
        $("#dealer_score").html(window.dealerScore);

        if (window.dealerScore > 21) {
            winGame("CONGRATULAYIONS!YOU WIN!");
        } else if (window.dealerScore == 21) {
            loseGame("SORRY...YOU LOSE...");
        } else if (window.dealerScore < 21 && window.dealerScore >= 17) {
            if (window.dealerScore < window.youScore) {
                winGame("CONGRATULAYIONS!YOU WIN!");
            } else if (window.dealerScore > window.youScore) {
                loseGame("SORRY...YOU LOSE...");
            } else {
                drawGame("DRAW! LET'S TRAY AGAIN!");
            }
        } else if (window.dealerScore < 17) {
            window.dealer4 = drawCard(window.deck,"#dealer_4");
            window.dealerNum4 = Number(adjustNum(window.dealer4,window.dealerScore));
            window.dealerScore = window.dealerScore + window.dealerNum4;
            $("#dealer_score").html(window.dealerScore);

            if (window.dealerScore > 21) {
                winGame("CONGRATULAYIONS!YOU WIN!");
            } else if (window.dealerScore == 21) {
                loseGame("SORRY...YOU LOSE...");
            }else if (window.dealerScore < 21 && window.dealerScore >= 17) {
                if (window.dealerScore < window.youScore) {
                    winGame("CONGRATULAYIONS!YOU WIN!");
                } else if (window.dealerScore > window.youScore) {
                    loseGame("SORRY...YOU LOSE...");
                } else {
                    drawGame("DRAW! LET'S TRAY AGAIN!");
                }
            }else if(window.dealerScore < 17){
                window.dealer5 = drawCard(window.deck,"#dealer_5");
                window.dealerNum5 = Number(adjustNum(window.dealer5,window.dealerScore));
                window.dealerScore = window.dealerScore + window.dealerNum5;
                $("#dealer_score").html(window.dealerScore);
                if (window.dealerScore > 21) {
                    winGame("CONGRATULAYIONS!YOU WIN!");
                } else if (window.dealerScore == 21) {
                    loseGame("SORRY...YOU LOSE...");
                }else if (window.dealerScore < 21 && window.dealerScore >= 17) {
                    if (window.dealerScore < window.youScore) {
                        winGame("CONGRATULAYIONS!YOU WIN!");
                    } else if (window.dealerScore > window.youScore) {
                        loseGame("SORRY...YOU LOSE...");
                    } else {
                        drawGame("DRAW! LET'S TRAY AGAIN!");
                    }
                }else if(window.dealerScore < 17){
                    drawGame("SORRY,DRAW...LET'S TRAY AGAIN!");
                }

            }
        }

    }
});

//Sullender操作
$("#surrender").on("click", function () {
    if($("#bet").text() == 0){
        playBu();
        return;
    }
    const audio5 = $("#card")[0];
    audio5.play();
    surrenderGame();
});

//データ引き継ぎ
for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    const oldCredit = localStorage.getItem(key);
    $("#credit_area").text(oldCredit);
}

//リセットボタン
$(".reset").on("click", function () {
    localStorage.clear();
    location.reload();
})

});
