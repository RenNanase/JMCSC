<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-[#eefbf9] border border-[#27a2a2]/20 rounded-md font-semibold text-xs text-[#27a2a2] uppercase tracking-widest shadow-sm hover:bg-[#fef2f2] focus:outline-none focus:ring-2 focus:ring-[#102b1f] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
