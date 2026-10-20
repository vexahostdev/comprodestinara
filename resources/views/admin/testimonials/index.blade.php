@extends('layouts.admin')

@section('title', 'Kelola Testimoni & Catatan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">Catatan &amp; Testimoni ({{ $testimonials->count() }})</h2>
        <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-medium flex items-center gap-1.5 shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Tambah Testimoni</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] border-b border-gray-200">
                <tr>
                    <th class="p-3.5">Nama &amp; Peran</th>
                    <th class="p-3.5">Kutipan</th>
                    <th class="p-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($testimonials as $t)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-3.5">
                            <div class="font-semibold text-gray-800">{{ $t->name }}</div>
                            <div class="text-gray-400 text-[11px]">{{ $t->role }} &bull; {{ $t->institution }}</div>
                        </td>
                        <td class="p-3.5 text-gray-600 max-w-md italic truncate">"{{ $t->quote }}"</td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-6 text-center text-gray-400">Belum ada testimoni tersimpan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
