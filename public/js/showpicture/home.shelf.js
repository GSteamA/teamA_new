// three.jsのセットアップ
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(20, window.innerWidth / window.innerHeight, 0.1, 500);
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight * 1);
renderer.setPixelRatio(window.devicePixelRatio);
renderer.shadowMap.enabled = true;
document.getElementById("shelf").appendChild(renderer.domElement);

// カメラ位置設定
camera.position.set(0, 2, 15);
camera.lookAt(0, 0, 0);

// 背景色を明るく設定
renderer.setClearColor(0xf09c7a);

// 環境光とスポットライトを追加
const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
scene.add(ambientLight);

const spotLight = new THREE.SpotLight(0xffffff, 0.8);
spotLight.position.set(5, 15, 10);
spotLight.castShadow = true;
scene.add(spotLight);

// 本棚の構造を作成する関数
function createShelf() {
  const shelfMaterial = new THREE.MeshStandardMaterial({ color: 0x8B5A2B });
  const shelfWidth = 7;
  const shelfHeight = 0.1;
  const shelfDepth = 0.5;

  for (let i = 0; i < 1; i++) {
    const geometry = new THREE.BoxGeometry(shelfWidth, shelfHeight, shelfDepth);
    const shelf = new THREE.Mesh(geometry, shelfMaterial);
    shelf.position.set(0, 0, 0);
    shelf.receiveShadow = true;
    scene.add(shelf);
  }
}

// 本を作成する関数
function createBook(textureUrl, x, y) {
    const geometry = new THREE.BoxGeometry(1, 1.5, 0.05);
    const texture = new THREE.TextureLoader().load(textureUrl); // 直接URLを使用
    const material = new THREE.MeshStandardMaterial({ map: texture });
    const book = new THREE.Mesh(geometry, material);
    book.position.set(x, y, -0.2);
    book.rotation.x = Math.PI / -10;
    book.castShadow = true;
    scene.add(book);
    return book;
  }

  //クリア画像取得
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
        console.log("APIからのデータ:", result);

        if (result.success) {
            const gameData = Object.values(result.data); // データを配列として取得
            console.log("配列化したデータ:", gameData);
            return gameData;
        } else {
            console.error('データ取得エラー:', result);
            return [];
        }
    } catch (error) {
        console.error('通信エラー:', error);
        return [];
    }
}

//取得した画像で本を作成
async function populateShelfFromDatabase(bookData) {
    if (!Array.isArray(bookData) || bookData.length === 0) {
        console.warn("bookData が空または不正です:", bookData);
        return [];
    }

    const books = [];
    const booksPerShelf = 3; // 1段に並べる本の数

    for (let i = 0; i < bookData.length; i++) {
        const getBookData = bookData[i];
        const yPosition = 0.77; // 棚の逆順に調整
        const xPosition = (i % booksPerShelf - (booksPerShelf - 1) / 2) * 2; // X座標を設定

        if (!getBookData.picture) {
            console.warn(`データに picture がありません:`, getBookData);
            continue;
        }

        const book = createBook(getBookData.picture, xPosition, yPosition);
        books.push(book);
    }

    return books;
}


// //本棚に取得した本を並べる関数
// async function populateShelfFromDatabase() {
//   const bookData = []; // 配列を初期化

//   // 複数のオブジェクトを一括で追加
//   bookData.push(
//       { cover_url: "/img/lasvegas/lasvegas_clear.png" },
//       { cover_url: "/img/lasvegas/lasvegas_clear.png" },
//       { cover_url: "/img/lasvegas/lasvegas_clear.png" }
//   );
//   const books = [];
//   const booksPerShelf = 3; // 1段に並べる本の数

//   for (let i = 0; i < bookData.length; i++) {
//     const getBookData = bookData[i];
//     const yPosition =  0.77; // 棚の逆順に調整
//     const xPosition = (i % booksPerShelf - (booksPerShelf - 1) / 2) * 2; // X座標を設定

//     // 本を作成
//     const book = createBook(getBookData.cover_url, xPosition, yPosition);
//     books.push(book);
//   }

//   return books;
// }

let books = []; // グローバル変数として定義

// 本棚を作成してデータベースの本を配置
createShelf(); // 本棚を作成

// APIからデータを取得して本棚を構築する
const initialPositions = new Map();

fetchUserGames().then((gameData) => {
    if (!gameData || gameData.length === 0) {
        console.warn("取得したデータが空です:", gameData);
        return;
    }
  // APIから取得したデータを使って populateShelfFromDatabase を呼び出す
  populateShelfFromDatabase(gameData).then((result) => {
    books = result; // booksに結果を代入
    // 各本の初期位置を保持
    books.forEach((book) => {
      initialPositions.set(book, book.position.clone()); // 初期位置を記録
    });
  });
});

// クリックイベント処理の追加
const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

function onMouseClick(event) {
  mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse.y = -(event.clientY / window.innerHeight) * 2 + 1.3;

  raycaster.setFromCamera(mouse, camera);
  const intersects = raycaster.intersectObjects(books);

  if (intersects.length > 0) {
    const clickedBook = intersects[0].object;
    const Id = clickedBook.userData.Id; // id を取得
    const bookId = clickedBook.userData.bookId //book_idを取得

    if (Id) {
      // sakuhin.html に遷移し、id とbook_idを渡す
      window.location.href = `sakuhin.html?id=${Id}&bookid=${bookId}`;
    }
  }
}

window.addEventListener('click', onMouseClick, false);


// アニメーションループ
function animate() {
  requestAnimationFrame(animate);
  renderer.render(scene, camera);
}
animate();


// マウスムーブイベントのためのベクターと変数
let hoveredBook = null;
const raycaster2 = new THREE.Raycaster();
const mouse2 = new THREE.Vector2();

// マウスムーブイベントを監視
function onMouseMove(event) {
  // マウス位置を正規化
  mouse2.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse2.y = -(event.clientY / window.innerHeight) * 2 + 1.3;

  // Raycasterにカメラとマウス座標をセット
  raycaster2.setFromCamera(mouse2, camera);

  // 本との交差判定
  const intersects = raycaster2.intersectObjects(books);

  if (intersects.length > 0) {
    const intersectedBook = intersects[0].object;

    // ホバーされた本が変更された場合のみ処理
    if (hoveredBook !== intersectedBook) {
      if (hoveredBook) {
        // 前のホバーされた本を元の位置に戻す
        gsap.to(hoveredBook.position, {
          y: initialPositions.get(hoveredBook).y, // 初期位置に戻す
          duration: 0.3,
        });
      }

      // 新しいホバーされた本を少し浮かせる
      hoveredBook = intersectedBook;
      gsap.to(hoveredBook.position, {
        y: initialPositions.get(hoveredBook).y + 0.2, // 浮かせる
        duration: 0.3,
      });
    }
  } else {
    // マウスが本から離れたときにリセット
    if (hoveredBook) {
      gsap.to(hoveredBook.position, {
        y: initialPositions.get(hoveredBook).y, // 初期位置に戻す
        duration: 0.3,
      });
      hoveredBook = null;
    }
  }
}

// マウスムーブイベントのリスナー
window.addEventListener('mousemove', onMouseMove, false);

