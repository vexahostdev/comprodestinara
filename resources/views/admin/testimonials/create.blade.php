@extends('layouts.admin')

@section('title', isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni')

@section('content')
<div class="max-w-xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">{{ isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni Baru' }}</h2>
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-gray-500 hover:underline">Kembali</a>
    </div>

    <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" method="POST" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
        @csrf
        @if(isset($testimonial))
            @method('PUT')
        @endif

        <div>
            <label class="block font-medium text-gray-700 mb-1">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Peran / Jabatan *</label>
                <input type="text" name="role" value="{{ old('role', $testimonial->role ?? '') }}" placeholder="cth. Dosen Antropologi Terapan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Institusi</label>
                <input type="text" name="institution" value="{{ old('institution', $testimonial->institution ?? '') }}" placeholder="cth. Universitas Indonesia" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Kutipan / Testimoni *</label>
            <textarea name="quote" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1F2B45]">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-2xl hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-5 py-2 bg-[#1F2B45] text-white font-medium rounded-2xl hover:bg-[#16203A] shadow-sm">
                {{ isset($testimonial) ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
