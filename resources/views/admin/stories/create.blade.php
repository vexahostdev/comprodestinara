@extends('layouts.admin')

@section('title', isset($story) ? 'Edit Cerita' : 'Tulis Cerita Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">{{ isset($story) ? 'Edit Cerita Lapangan' : 'Tulis Cerita Lapangan Baru' }}</h2>
        <a href="{{ route('admin.stories.index') }}" class="text-xs text-gray-500 hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ isset($story) ? route('admin.stories.update', $story->id) : route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
        @csrf
        @if(isset($story))
            @method('PUT')
        @endif

        <div>
            <label class="block font-medium text-gray-700 mb-1">Judul Cerita / Monograf *</label>
            <input type="text" name="title" value="{{ old('title', $story->title ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Kategori *</label>
                <input type="text" name="category" value="{{ old('category', $story->category ?? 'Etnobotani') }}" placeholder="cth. Etnobotani" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Nomor Arsip</label>
                <input type="text" name="archive_no" value="{{ old('archive_no', $story->archive_no ?? '') }}" placeholder="cth. Arsip Lapangan No. 042" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Estimasi Waktu Baca</label>
                <input type="text" name="read_time" value="{{ old('read_time', $story->read_time ?? '5 Menit') }}" placeholder="cth. 7 Menit Baca" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Nama Penulis</label>
                <input type="text" name="author_name" value="{{ old('author_name', $story->author_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Peran / Institusi Penulis</label>
                <input type="text" name="author_role" value="{{ old('author_role', $story->author_role ?? '') }}" placeholder="cth. Peneliti Etnobotani" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Ringkasan / Excerpt</label>
            <textarea name="excerpt" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ old('excerpt', $story->excerpt ?? '') }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Konten Lengkap (Mendukung tag HTML)</label>
            <textarea name="content" rows="8" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ old('content', $story->content ?? '') }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Foto Sampul Cerita</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            @if(isset($story) && $story->image_path)
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-gray-400 text-[11px]">Foto saat ini:</span>
                    <img src="{{ $story->image_url }}" alt="Preview" class="h-10 w-16 object-cover rounded">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $story->is_featured ?? false) ? 'checked' : '' }} class="rounded text-[#1F2B45] focus:ring-0">
                <span class="font-medium text-gray-700">Cerita Unggulan (Featured)</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $story->is_active ?? true) ? 'checked' : '' }} class="rounded text-[#1F2B45] focus:ring-0">
                <span class="font-medium text-gray-700">Status Aktif</span>
            </label>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-2xl hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-5 py-2 bg-[#1F2B45] text-white font-medium rounded-2xl hover:bg-[#16203A] shadow-sm">
                {{ isset($story) ? 'Perbarui Cerita' : 'Terbitkan Cerita' }}
            </button>
        </div>
    </form>
</div>
@endsection
