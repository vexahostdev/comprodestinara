@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">Edit Program: {{ $program->title }}</h2>
        <a href="{{ route('admin.programs.index') }}" class="text-xs text-gray-500 hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Target Peserta / Mitra *</label>
                <select name="target" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
                    <option value="sekolah" {{ old('target', $program->target) === 'sekolah' ? 'selected' : '' }}>Sekolah &amp; Siswa Menengah</option>
                    <option value="peneliti" {{ old('target', $program->target) === 'peneliti' ? 'selected' : '' }}>Peneliti &amp; Kampus</option>
                    <option value="mitra_desa" {{ old('target', $program->target) === 'mitra_desa' ? 'selected' : '' }}>Pengelola Destinasi / Mitra Desa</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Judul Program *</label>
                <input type="text" name="title" value="{{ old('title', $program->title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Subjudul Program</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $program->subtitle) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Deskripsi Program</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ old('description', $program->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Teks Tombol Aksi (CTA)</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $program->cta_text) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Tautan URL CTA</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $program->cta_url) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-2xl hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-5 py-2 bg-[#1F2B45] text-white font-medium rounded-2xl hover:bg-[#16203A] shadow-sm">
                Perbarui Program
            </button>
        </div>
    </form>
</div>
@endsection
