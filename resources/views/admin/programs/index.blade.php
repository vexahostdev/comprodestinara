@extends('layouts.admin')

@section('title', 'Kelola Program & Layanan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">Program Kemitraan &amp; Layanan ({{ $programs->count() }})</h2>
        <a href="{{ route('admin.programs.create') }}" class="px-4 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-medium flex items-center gap-1.5 shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Tambah Program Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] border-b border-gray-200">
                <tr>
                    <th class="p-3.5">Target Mitra</th>
                    <th class="p-3.5">Judul Program</th>
                    <th class="p-3.5">Deskripsi</th>
                    <th class="p-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($programs as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-3.5">
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-gray-100 text-gray-800">
                                {{ $p->target }}
                            </span>
                        </td>
                        <td class="p-3.5 font-semibold text-gray-800">{{ $p->title }}</td>
                        <td class="p-3.5 text-gray-500 max-w-xs truncate">{{ $p->description }}</td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="{{ route('admin.programs.edit', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            <form action="{{ route('admin.programs.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus program ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada program tersimpan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
