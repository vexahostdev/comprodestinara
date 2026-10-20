@props(['title', 'createRoute', 'createLabel' => 'Tambah Baru'])
<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-sm sm:text-base font-medium text-gray-800 uppercase tracking-wide">{{ $title }}</h2>
    </div>
    <a href="{{ route($createRoute) }}"
       class="inline-flex items-center gap-1.5 bg-[#1B2B5E] hover:bg-[#243d7a] text-white text-xs font-medium px-3.5 py-1.5 rounded-2xl transition-colors shadow-sm">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
        {{ $createLabel }}
    </a>
</div>

