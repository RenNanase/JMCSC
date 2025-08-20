<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#27a2a2] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#27a2a2]/80 focus:bg-[#27a2a2]/90 active:bg-[#27a2a2] focus:outline-none focus:ring-2 focus:ring-[#102b1f] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
