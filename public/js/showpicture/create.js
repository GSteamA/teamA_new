// APIからデータを取得して表示
async function fetchUserGames() {
    try {
        const response = await fetch('/api/show-picture', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const result = await response.json();

        if (result.success) {
            const gameData = result.data;
            displayImages(gameData); // データを使って画像を表示
        } else {
            console.error('データ取得エラー:', result);
        }
    } catch (error) {
        console.error('通信エラー:', error);
    }
}

// 画像を表示する関数
function displayImages(gameData) {
    const container = document.getElementById('game-images-container');
    container.innerHTML = ''; // 既存のコンテンツをクリア

    Object.values(gameData).forEach(game => {
        const imageElement = document.createElement('img');

        if (game.has_picture) {
            imageElement.src = game.picture; // 画像パスを設定
            imageElement.alt = `Game ${game.game_id}`;
        } else {
            imageElement.alt = `No image for Game ${game.game_id}`;
        }

        container.appendChild(imageElement);
    });
}

// ページ読み込み時にデータ取得
document.addEventListener('DOMContentLoaded', fetchUserGames);
