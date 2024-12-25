<x-app-layout>
  <x-slot name="header">
  <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps API Sample</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #map {
            height: 600px;
            width: 100%;
            background-color: #78BBE6;
        }
        .marker-content {
            background-color: #4a5568;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <!-- <button id="mapbutton">マーカー</button> -->

    <script type="module">
        import { config } from '{{ asset('js/laraveltravel/config.js') }}';
        import { GoogleMapsLoader } from '{{ asset('js/laraveltravel/GoogleMapsLoader.js') }}';
        import { MarkerManager } from '{{ asset('js/laraveltravel/MarkerManager.js') }}';

        const isDebug = config.isDebug;
        const GOOGLE_MAPS_API_KEY = config.GOOGLE_MAPS_API_KEY; //{{ env('GOOGLE_MAPS_API_KEY') }};
        const GOOGLE_MAP_ID = config.GOOGLE_MAP_ID;
        
        // DOM要素の取得
        const elements = {
            $map: $('#map')
        };

        const map = new GoogleMapsLoader(config, elements, isDebug);

        // Google Maps API の動的読み込み
        await map.loadGoogleMapsAPI();

        // // マーカーの取得
        await map.initializeMap();

        // $('#mapbutton').on('click', ()=>{
        //     map.addSampleMarker();
        //     map.addMarker(locations);
        // });
        // await map.addSampleMarkers();

        const locations = [
            { lat: 35.669515, lng: 139.702954, title: 'ジーズアカデミー東京' , url: '/harajuku'},
            { lat: 33.586843, lng: 130.394501, title: 'ジーズアカデミー福岡' , url: 'menu'},
            { lat: 36.147685, lng: -115.15651, title: 'ラスベガス', url: 'dashboard'}                 ];
            map.addSampleMarker();
            map.addMarker(locations);
        // map.addSampleMarker();
        // locations.forEach(function(location) {
        //     let marker = map.addMarker(location.position);
        //     marker.addListener('click', function() {
        //         window.location.href = location.url;
        //         echo(location.url);
        //     });
        // });
        // await map.addSampleMarkers();


        // /**
        //  * Google Maps APIを動的に読み込む
        //  */
        // async function loadGoogleMapsAPI() {
        //     return new Promise((resolve, reject) => {
        //         const script = document.createElement('script');
        //         script.src = `https://maps.googleapis.com/maps/api/js?key=${GOOGLE_MAPS_API_KEY}&v=beta`;
        //         script.async = true;
        //         script.defer = true;
        //         script.addEventListener('load', () => resolve());
        //         script.addEventListener('error', () => reject(new Error('Google Maps API の読み込みに失敗しました')));
        //         document.head.appendChild(script);
        //     });
        // }

        // /**
        //  * Google Maps APIを利用してマップを初期化し、マーカーを配置する
        //  */
        // async function initializeMap() {
        //     const { Map } = await google.maps.importLibrary("maps");
        //     const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            
        //     const mapManager = new GoogleMapManager(Map, AdvancedMarkerElement, elements.$map[0], isDebug);
        //     await mapManager.initialize();
            
        //     const markerManager = new MarkerManager(AdvancedMarkerElement, mapManager.map, isDebug);
        //     await markerManager.addSampleMarkers();
        // }

        // class GoogleMapManager {
        //     constructor(MapClass, MarkerClass, mapElement, isDebug = false) {
        //         this.MapClass = MapClass;
        //         this.MarkerClass = MarkerClass;
        //         this.mapElement = mapElement;
        //         this.isDebug = isDebug;
        //         this.map = null;
        //     }

        //     logDebug(methodName, params = null, result = null) {
        //         if (this.isDebug) {
        //             console.log(`[GoogleMapManager] ${methodName}`);
        //             if (params) console.log('Parameters:', params);
        //             if (result) console.log('Result:', result);
        //         }
        //     }

        //     async initialize() {
        //         const mapOptions = {
        //             center: { lat: 35.6812, lng: 139.7671 },
        //             zoom: 13,
        //             mapId: GOOGLE_MAP_ID
        //         };
                
        //         this.logDebug('initialize', mapOptions);
        //         this.map = new this.MapClass(this.mapElement, mapOptions);
        //         return this.map;
        //     }
        // }

        // class MarkerManager {
        //     constructor(MarkerClass, map, isDebug = false) {
        //         this.MarkerClass = MarkerClass;
        //         this.map = map;
        //         this.isDebug = isDebug;
        //         this.markers = [];
        //     }

        //     logDebug(methodName, params = null, result = null) {
        //         if (this.isDebug) {
        //             console.log(`[MarkerManager] ${methodName}`);
        //             if (params) console.log('Parameters:', params);
        //             if (result) console.log('Result:', result);
        //         }
        //     }

        //     async addSampleMarkers() {
        //         const locations = [
        //             { lat: 35.6812, lng: 139.7671, title: '東京駅' },
        //             { lat: 35.6586, lng: 139.7454, title: '六本木ヒルズ' }
        //         ];

        //         this.logDebug('addSampleMarkers', locations);

        //         locations.forEach(location => {
        //             const markerContent = this.createMarkerContent(location.title);
        //             const marker = new this.MarkerClass({
        //                 map: this.map,
        //                 position: location,
        //                 content: markerContent
        //             });

        //             marker.addListener('click', () => {
        //                 this.handleMarkerClick(location);
        //             });

        //             this.markers.push(marker);
        //         });
        //     }

        //     createMarkerContent(title) {
        //         const content = document.createElement('div');
        //         content.classList.add('marker-content');
        //         content.textContent = title;
        //         return content;
        //     }

        //     handleMarkerClick(location) {
        //         this.logDebug('handleMarkerClick', location);
        //         this.map.panTo(location);
        //     }
        // }
    </script>
</body>
</html>
  </x-slot>

  <!-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($laraveltravel  as $tweet)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300">{{ $tweet->tweet }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $tweet->user->name }}</p>
            <a href="{{ route('laraveltravel .show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div> -->

</x-app-layout>
