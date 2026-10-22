@extends('layouts.admin')

@section('title', 'Detail Pesan Masuk')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.messages.index') }}" class="text-xs text-gray-500 hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali ke Inbox</span>
        </a>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.messages.toggle-read', $message->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-3 py-1.5 border border-gray-300 rounded-2xl text-xs hover:bg-gray-100">
                    {{ $message->is_read ? 'Tandai Belum Dibaca' : 'Tandai Terbaca' }}
                </button>
            </form>
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl text-xs">Hapus</button>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6 text-xs">
        <div class="border-b border-gray-100 pb-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-800">{{ $message->full_name }}</h3>
                <span class="text-gray-400 text-[11px]">{{ $message->created_at->translatedFormat('d F Y, H:i:s') }} WIB</span>
            </div>
            <div class="text-gray-500 mt-1">{{ $message->institution }}</div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
            <div>
                <span class="text-gray-400 block text-[11px]">Nomor WhatsApp:</span>
                <span class="font-semibold text-gray-800 text-sm">{{ $message->whatsapp }}</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[11px]">Rencana Kebutuhan Program:</span>
                <span class="font-semibold text-gray-800 text-sm">{{ $message->topic_label }}</span>
            </div>
        </div>

        <div>
            <span class="text-gray-400 block text-[11px] mb-2 font-medium">Catatan Rombongan &amp; Gambaran Harapan:</span>
            <div class="bg-gray-50 p-4 rounded-lg text-gray-700 text-xs leading-relaxed whitespace-pre-wrap">
                {{ $message->notes ?: '(Tidak ada catatan tambahan)' }}
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->whatsapp) }}?text=Halo%20{{ urlencode($message->full_name) }},%20terima%20kasih%20telah%20menghubungi%20Destinara%20mengenai%20{{ urlencode($message->topic_label) }}." target="_blank" rel="noopener" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                <span>Balas ke WhatsApp Pemohon</span>
            </a>
        </div>
    </div>
</div>
@endsection
