@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#27a2a2] text-start text-base font-medium text-[#27a2a2] bg-[#fef2f2] focus:outline-none focus:text-[#27a2a2] focus:bg-[#fef2f2] focus:border-[#102b1f] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#27a2a2]/80 hover:text-[#102b1f] hover:bg-[#fef2f2] hover:border-[#27a2a2]/50 focus:outline-none focus:text-[#102b1f] focus:bg-[#fef2f2] focus:border-[#27a2a2]/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
