@extends('layouts.admin')

@section('title', isset($stat) ? 'Edit Statistik' : 'Tambah Statistik')

@section('content')
<div class="max-w-md mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">{{ isset($stat) ? 'Edit Statistik' : 'Tambah Statistik Baru' }}</h2>
        <a href="{{ route('admin.stats.index') }}" class="text-xs text-gray-500 hover:underline">Kembali</a>
    </div>

    <form action="{{ isset($stat) ? route('admin.stats.update', $stat->id) : route('admin.stats.store') }}" method="POST" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
        @csrf
        @if(isset($stat))
            @method('PUT')
        @endif

        <div>
            <label class="block font-medium text-gray-700 mb-1">Nilai / Angka (cth. 14+, 1.200+, 100%) *</label>
            <input type="text" name="value" value="{{ old('value', $stat->value ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Label Keterangan *</label>
            <input type="text" name="label" value="{{ old('label', $stat->label ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Urutan</label>
            <input type="number" name="order" value="{{ old('order', $stat->order ?? 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.stats.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-2xl hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-5 py-2 bg-[#1F2B45] text-white font-medium rounded-2xl hover:bg-[#16203A] shadow-sm">
                {{ isset($stat) ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
