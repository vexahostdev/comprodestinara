<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'full_name',
        'institution',
        'whatsapp',
        'topic',
        'notes',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function getTopicLabelAttribute(): string
    {
        return match ($this->topic) {
            'sekolah' => 'Ekskursi & Live-in Siswa Sekolah Menengah',
            'riset' => 'Kuliah Kerja Lapangan & Riset Komunitas Akademik',
            'desa' => 'Penjajakan Mitra Desa & Sanggar Baru',
            'kurikulum' => 'Penyusunan Modul Lapangan Berbasis Muatan Lokal',
            default => 'Kunjungan Khusus / Diskusi Terfokus Lainnya',
        };
    }
}
