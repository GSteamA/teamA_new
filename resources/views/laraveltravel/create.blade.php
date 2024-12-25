<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('アーカイブ') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($laraveltravel as $lrtr)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300">{{ $lrtr->lrtr }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">獲得者: {{ $lrtr->user->name }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>