@extends('layouts.admin')
@section('title', $stat->exists ? 'Edit Statistik' : 'Tambah Statistik')

@section('content')
<div class="max-w-md">
    <a href="{{ route('admin.stats.index') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 shadow-sm">
        <h2 class="text-xs uppercase tracking-wider font-medium text-gray-800 mb-4 pb-3 border-b border-gray-100">{{ $stat->exists ? 'Edit Statistik' : 'Tambah Statistik' }}</h2>
        <form action="{{ $stat->exists ? route('admin.stats.update', $stat) : route('admin.stats.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($stat->exists) @method('PUT') @endif
            <div>
                <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Label *</label>
                <input type="text" name="label" value="{{ old('label', $stat->label) }}" required placeholder="Contoh: Event Sukses" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Nilai *</label>
                    <input type="text" name="value" value="{{ old('value', $stat->value) }}" required placeholder="150" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Suffix</label>
                    <input type="text" name="suffix" value="{{ old('suffix', $stat->suffix) }}" placeholder="+, K+, %" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-normal text-gray-500 uppercase tracking-wider mb-1.5">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $stat->order ?? 0) }}" min="0" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1B2B5E] text-xs">
            </div>
            <div class="flex gap-2.5 pt-2">
                <button type="submit" class="bg-[#1B2B5E] hover:bg-[#243d7a] text-white font-normal px-4 py-2 rounded-2xl text-xs transition-colors shadow-sm">
                    {{ $stat->exists ? 'Simpan' : 'Tambah' }}
                </button>
                <a href="{{ route('admin.stats.index') }}" class="px-4 py-2 rounded-2xl border border-gray-200 text-gray-600 text-xs font-normal">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

