@extends('layouts.admin')

@section('title', 'Pesan Masuk & Konsultasi')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h2 class="text-base font-semibold text-gray-800">Inbox Pesan Masuk ({{ $messages->total() }})</h2>
            @if($unreadCount > 0)
                <span class="px-2 py-0.5 text-xs font-semibold bg-rose-100 text-rose-700 rounded-full">{{ $unreadCount }} Belum Dibaca</span>
            @endif
        </div>
        @if($unreadCount > 0)
            <form action="{{ route('admin.messages.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-xs font-medium">Tandai Semua Terbaca</button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] border-b border-gray-200">
                    <tr>
                        <th class="p-3.5">Pengirim</th>
                        <th class="p-3.5">Institusi</th>
                        <th class="p-3.5">WhatsApp</th>
                        <th class="p-3.5">Topik Program</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-gray-50 transition-colors {{ !$msg->is_read ? 'bg-rose-50/40' : '' }}">
                            <td class="p-3.5 font-semibold text-gray-800">{{ $msg->full_name }}</td>
                            <td class="p-3.5 text-gray-600">{{ $msg->institution }}</td>
                            <td class="p-3.5">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $msg->whatsapp) }}" target="_blank" class="text-emerald-700 font-medium hover:underline">{{ $msg->whatsapp }}</a>
                            </td>
                            <td class="p-3.5 text-gray-600">{{ $msg->topic_label }}</td>
                            <td class="p-3.5 text-gray-400 text-[11px]">{{ $msg->created_at->translatedFormat('d M Y, H:i') }}</td>
                            <td class="p-3.5">
                                @if(!$msg->is_read)
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-700 rounded text-[10px] font-semibold">Baru</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px]">Terbaca</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Buka</a>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-400">Belum ada pesan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
