@props(['disabled' => false])
<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'border-blue-300 dark:border-blue-700 text-black dark:text-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
]) }}
style="background-color: #bfdbfe; color: #000; border-radius: 0.375rem;">
