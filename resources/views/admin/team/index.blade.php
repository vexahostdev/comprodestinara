@extends('layouts.admin')

@section('title', 'Kelola Dewan Kurator & Tim')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Dewan Kurator &amp; Fasilitator Lapangan ({{ $members->count() }})</h1>
            <p class="text-xs text-gray-500 mt-0.5">Kelola profil anggota tim pendiri, kurator riset, dan fasilitator tapak yang tampil di halaman Tentang Kami.</p>
        </div>
        <a href="{{ route('admin.team.create') }}" class="px-4 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-medium flex items-center gap-1.5 shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Tambah Anggota</span>
        </a>
    </div>

    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-emerald-600 text-sm">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] border-b border-gray-200">
                <tr>
                    <th class="p-3.5">Foto &amp; Nama</th>
                    <th class="p-3.5">Peran / Jabatan</th>
                    <th class="p-3.5">Afiliasi / Latar Belakang</th>
                    <th class="p-3.5">Email &amp; Lokasi</th>
                    <th class="p-3.5">Urutan</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($members as $m)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-3.5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden border border-gray-200 bg-gray-100 shrink-0">
                                <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $m->name }}</span>
                            </div>
                        </td>
                        <td class="p-3.5 font-medium text-[#1F2B45]">{{ $m->role }}</td>
                        <td class="p-3.5 text-gray-600 italic text-[11px]">{{ $m->affiliation ?? '-' }}</td>
                        <td class="p-3.5 text-gray-600">
                            <div>{{ $m->email ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $m->location ?? '-' }}</div>
                        </td>
                        <td class="p-3.5 text-gray-400">{{ $m->order }}</td>
                        <td class="p-3.5">
                            @if($m->is_active)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="{{ route('admin.team.edit', $m->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            <form action="{{ route('admin.team.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada anggota tim terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
