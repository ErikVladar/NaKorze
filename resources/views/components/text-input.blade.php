@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-stone-600 bg-stone-600 text-gray-200 focus:border-stone-500 focus:ring-stone-500 rounded-md shadow-sm']) }}>
