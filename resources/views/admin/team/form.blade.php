@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Anggota Tim' : 'Tambah Anggota Tim')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-800">{{ $isEdit ? 'Edit Profil Anggota Tim' : 'Tambah Anggota Tim Baru' }}</h2>
        <a href="{{ route('admin.team.index') }}" class="text-xs text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    @if($errors->any())
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg text-xs space-y-1">
            @foreach($errors->all() as $err)
                <div>• {{ $err }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <form action="{{ $isEdit ? route('admin.team.update', $member->id) : route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap &amp; Gelar *</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="cth. Ryan Prasetya">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Peran / Jabatan Lapangan *</label>
                    <input type="text" name="role" value="{{ old('role', $member->role) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="cth. Inisiator &amp; Kurator Lapangan">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Afiliasi Akademis / Keahlian Khusus</label>
                <input type="text" name="affiliation" value="{{ old('affiliation', $member->affiliation) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                       placeholder="cth. Alumnus Antropologi Terapan &amp; Ekologi Manusia">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Biografi Singkat &amp; Pengalaman Lapangan</label>
                <textarea name="bio" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                          placeholder="Ceritakan latar belakang, dedikasi riset, dan peran dalam mendampingi komunitas adat...">{{ old('bio', $member->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Lokasi Sekretariat / Basis</label>
                    <input type="text" name="location" value="{{ old('location', $member->location) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="cth. Sekretariat Sleman &amp; Borobudur">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Alamat Email Korespondensi</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="cth. ryan@destinara.id">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Kontak / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="cth. +62 812-xxxx-xxxx">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tautan LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]"
                           placeholder="https://linkedin.com/in/...">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <label class="block text-xs font-medium text-gray-700 mb-2">Foto Profil (JPG, PNG, WEBP, Maks. 3MB)</label>
                <div class="flex items-center gap-4">
                    @if($member->photo)
                        <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 shrink-0">
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="photo" accept="image/*"
                               class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-xs file:mr-3 file:py-1 file:px-3 file:rounded-2xl file:border-0 file:text-xs file:font-semibold file:bg-[#1F2B45]/10 file:text-[#1F2B45]">
                        <span class="block text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto profil.</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', $member->order ?? 0) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-1 focus:ring-[#1F2B45]">
                </div>

                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-[#1F2B45] border-gray-300 rounded focus:ring-[#1F2B45]">
                        <span class="text-xs font-medium text-gray-700">Tampilkan di Halaman Web</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.team.index') }}" class="px-4 py-2 border border-gray-300 rounded-2xl text-xs font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2 bg-[#1F2B45] hover:bg-[#16203A] text-white rounded-2xl text-xs font-bold shadow-sm transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Anggota' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
