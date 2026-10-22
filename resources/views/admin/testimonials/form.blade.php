@extends('layouts.admin')
@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 shadow-sm">
        <h2 class="text-xs uppercase tracking-wider font-medium text-gray-800 mb-4 pb-3 border-b border-gray-100">{{ $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h2>
        <form action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($testimonial->exists) @method('PUT') @endif
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Nama *</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Jabatan</label>
                    <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Perusahaan</label>
                <input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Isi Testimoni *</label>
                <textarea name="content" rows="3" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs resize-none">{{ old('content', $testimonial->content) }}</textarea>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Rating</label>
                    <select name="rating" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs bg-white">
                        @for($r=5;$r>=1;$r--)<option value="{{ $r }}" {{ old('rating', $testimonial->rating ?? 5) == $r ? 'selected' : '' }}>{{ $r }} Bintang</option>@endfor
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Foto</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-xs text-gray-600 file:mr-3 file:py-1 file:px-3 file:rounded-2xl file:border-0 file:bg-[#1B2B5E] file:text-white file:text-xs cursor-pointer">
                </div>
            </div>
            <div class="flex gap-2.5 pt-2">
                <button type="submit" class="bg-[#1B2B5E] hover:bg-[#243d7a] text-white font-normal px-4 py-2 rounded-2xl text-xs transition-colors shadow-sm">
                    {{ $testimonial->exists ? 'Simpan' : 'Tambah' }}
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-normal">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

