@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#2cacad]/20 bg-white text-gray-700 focus:border-[#2cacad] focus:ring-[#2cacad] rounded-md shadow-sm']) }}>
