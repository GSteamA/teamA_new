<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('獲得した記念写真') }}
    </h2>
  </x-slot>

  <div id="shelf"></div>

  <div id="game-images-container"></div>

  <!-- jQueryをインポート -->
  <script src="{{asset('js/lasvegas/jquery-2.1.3.min.js')}}"></script>
  <!-- 画像を取得して表示するjsファイル -->
  {{-- <script src="{{asset('js/showpicture/create.js')}}"></script> --}}
  <!-- 棚を表示するjsファイル -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script type="module" src="{{asset('js/showpicture/home.shelf.js')}}"></script>

</x-app-layout>
