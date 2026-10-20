@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-gray-400 text-xs uppercase font-medium">Pesan Masuk</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalMessages }}</div>
                @if($unreadMessages > 0)
                    <div class="text-xs text-rose-600 font-medium mt-0.5">{{ $unreadMessages }} belum dibaca</div>
                @else
                    <div class="text-xs text-emerald-600 font-medium mt-0.5">Semua terbaca</div>
                @endif
            </div>
            <div class="w-11 h-11 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">mail</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-gray-400 text-xs uppercase font-medium">Tapak Destinasi</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDestinations }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Katalog Terverifikasi</div>
            </div>
            <div class="w-11 h-11 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">explore</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-gray-400 text-xs uppercase font-medium">Cerita Lapangan</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalStories }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Warta &amp; Monograf</div>
            </div>
            <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">auto_stories</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-gray-400 text-xs uppercase font-medium">Program &amp; Mitra</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPrograms }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Skema Kemitraan</div>
            </div>
            <div class="w-11 h-11 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">school</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="font-semibold text-gray-800 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600 text-[18px]">mark_email_unread</span>
                    <span>Pesan Masuk Terbaru</span>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs text-[#703a3a] hover:underline">Lihat Semua Inbox &rarr;</a>
            </div>
            <div class="divide-y divide-gray-100 overflow-x-auto">
                @forelse($recentMessages as $msg)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800">{{ $msg->full_name }}</span>
                                @if(!$msg->is_read)
                                    <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-rose-100 text-rose-700 rounded">Baru</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500">{{ $msg->institution }} &bull; {{ $msg->whatsapp }}</div>
                            <p class="text-xs text-gray-600 line-clamp-1 italic">{{ $msg->notes }}</p>
                        </div>
                        <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs hover:bg-gray-100 font-medium">Buka</a>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 text-xs">Belum ada pesan masuk.</div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-5 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="font-semibold text-gray-800 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#703a3a] text-[18px]">explore</span>
                    <span>Katalog Tapak (Core System API)</span>
                </div>
                <a href="{{ config('services.core_system.url') }}/admin/destinasi" target="_blank" class="text-xs text-[#703a3a] font-semibold hover:underline flex items-center gap-1">
                    <span>Kelola di Core</span>
                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentDestinations as $dest)
                    @php
                        $dName = is_array($dest) ? ($dest['name'] ?? '') : ($dest->name ?? '');
                        $dSlug = is_array($dest) ? ($dest['slug'] ?? '') : ($dest->slug ?? '');
                        $dCity = is_array($dest) ? ($dest['city'] ?? '') : ($dest->city ?? '');
                        $dProv = is_array($dest) ? ($dest['province'] ?? '') : ($dest->province ?? '');
                        $dImg = is_array($dest) ? ($dest['cover_url'] ?? asset('assets/img/hd/hero-fieldwork.jpg')) : ($dest->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg'));
                    @endphp
                    <div class="p-3.5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <img src="{{ $dImg }}" alt="{{ $dName }}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <div class="font-medium text-gray-800 text-xs">{{ $dName }}</div>
                                <div class="text-[11px] text-gray-400">{{ $dCity }}, {{ $dProv }}</div>
                            </div>
                        </div>
                        <a href="{{ route('destinations.show', $dSlug) }}" target="_blank" class="text-gray-400 hover:text-gray-700" title="Lihat di Web">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 text-xs">Belum ada data destinasi terhubung dari Core API.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection