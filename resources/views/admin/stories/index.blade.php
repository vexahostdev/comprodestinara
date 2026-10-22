@extends('layouts.admin')

@section('title', 'Kelola Cerita Lapangan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">Cerita &amp; Monograf Lapangan ({{ $stories->total() }})</h2>
        <a href="{{ route('admin.stories.create') }}" class="px-4 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-medium flex items-center gap-1.5 shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Tulis Cerita Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] border-b border-gray-200">
                    <tr>
                        <th class="p-3.5">Judul Cerita</th>
                        <th class="p-3.5">Kategori</th>
                        <th class="p-3.5">Penulis</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stories as $story)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-12 h-9 rounded-lg object-cover flex-shrink-0">
                                    <div>
                                        <div class="font-semibold text-gray-800 text-xs">{{ $story->title }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $story->archive_no ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 text-emerald-800 font-medium">{{ $story->category }}</td>
                            <td class="p-3.5 text-gray-600">{{ $story->author_name ?? '-' }}</td>
                            <td class="p-3.5 text-gray-400 text-[11px]">{{ $story->published_at ? $story->published_at->translatedFormat('d F Y') : '-' }}</td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.stories.edit', $story->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus cerita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">Belum ada cerita yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $stories->links() }}
        </div>
    </div>
</div>
@endsection
