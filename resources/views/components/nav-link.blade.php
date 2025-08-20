@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#27a2a2] text-sm font-medium leading-5 text-[#27a2a2] focus:outline-none focus:border-[#102b1f] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#27a2a2]/80 hover:text-[#102b1f] hover:border-[#102b1f]/50 focus:outline-none focus:text-[#102b1f] focus:border-[#102b1f]/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
