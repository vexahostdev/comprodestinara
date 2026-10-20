<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Users (SPEC §16.1, §19.3 & Audit V2)
        $email = config('admin.email');
        $password = config('admin.password');
        $name = config('admin.name', 'Admin Destinara');

        // Tanpa fallback password di env apa pun selain local / testing
        if (! app()->environment('local', 'testing') && (empty($email) || empty($password))) {
            throw new \RuntimeException('ADMIN_EMAIL and ADMIN_PASSWORD environment variables are required in non-local environments (production/staging). Fallback credentials are not permitted.');
        }

        $email = $email ?: 'admin@destinara.id';
        $password = $password ?: 'DestinaraAdmin2026!';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        // 2. Site Settings
        $settings = [
            'site_name' => 'Destinara',
            'company_legal_name' => 'PT DESTINARA CHAKRAWAL ARTHA',
            'site_tagline' => 'Menghidupkan Ruang Belajar Nyata di Tapak Nusantara',
            'site_description' => 'Inisiatif pendidikan lapangan dan riset berbasis komunitas yang menjembatani kurikulum institusi dengan kearifan tapak dan pengetahuan lokal di seluruh Nusantara.',
            'contact_email' => 'hello@destinara.id',
            'contact_email_partnership' => 'partnership@destinara.id',
            'contact_email_hello' => 'hello@destinara.id',
            'contact_phone' => '+62 821-1620-0363',
            'contact_whatsapp' => '6282116200363',
            'contact_phone_maya' => '+62 821-1620-0363',
            'contact_whatsapp_maya' => '6282116200363',
            'contact_phone_azki' => '+62 858-9486-0696',
            'contact_whatsapp_azki' => '6285894860696',
            'contact_phone_ryan' => '+62 857-7441-0978',
            'contact_whatsapp_ryan' => '6285774410978',
            'address_sleman' => 'Jl. Kaliurang KM 14, Sinduharjo, Ngaglik, Sleman, D.I. Yogyakarta',
            'address_jakarta' => 'Jl. Teuku Umar No. 12, Menteng, Jakarta Pusat',
            'office_hours' => 'Senin – Sabtu, 08.00–17.00 WIB',
            'instagram' => 'destinara.id',
            'manifesto_quote' => 'Pendidikan sejati tidak memisahkan insan akademis dari tanah tempat ia berpijak, melainkan mempertemukan kecendekiaan akal dengan kerendahhatian laku warga di perbatasan.',
            'manifesto_author' => 'Piagam Pendidikan Tapak Nusantara • Dewan Penasihat Akademik & Pemangku Adat Mitra',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Programs (Pilar Kurikulum Destinara)
        if (Program::count() === 0) {
            $programs = [
                [
                    'target' => 'sekolah',
                    'title' => 'Ekskursi & Live-in Siswa Sekolah Menengah',
                    'subtitle' => 'Pendidikan Karakter & Pembelajaran Kontekstual Berbasis Tapak',
                    'description' => 'Kurikulum kontekstual terakreditasi mulai dari ekologi maritim, mitigasi bencana berbasis lanskap, hingga etnografi kriya. Dilengkapi logistik tersertifikasi dan instrumen asesmen capaian belajar mandiri siswa.',
                    'features' => [
                        'Modul Pembelajaran Lapangan Lintas Disiplin (Sains, Geografi, Sejarah)',
                        'Pendampingan Fasilitator Profesional & Rasio Pembina 1:8',
                        'Protokol Keselamatan & Asuransi Perjalanan Pelajar Penuh',
                        'Buku Kerja Lapangan & Refleksi Etika Komunitas',
                    ],
                    'image_path' => 'assets/img/hd/sekolah-diskusi.jpg',
                    'cta_text' => 'Pelajari Program Sekolah',
                    'cta_url' => '/untuk-sekolah',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'target' => 'peneliti',
                    'title' => 'Kuliah Kerja Lapangan & Kolaborasi Riset Akademik',
                    'subtitle' => 'Laboratorium Hidup Sains Terapan & Antropologi Budaya',
                    'description' => 'Akses terstruktur ke lanskap penelitian primer dengan perlindungan hak kekayaan intelektual komunitas lokal, dukungan basis data tapak, dan jejaring tetua adat sebagai narasumber primer terverifikasi.',
                    'features' => [
                        'Persetujuan Bebas Didahulukan (FPIC) Resmi dari Lembaga Adat',
                        'Akomodasi Riset, Ruang Transit Sampel, & Jejaring Data Primer',
                        'Fasilitasi Dialog Komunal & Penerjemah Bahasa Lokal',
                        'Dukungan Logistik Ekspedisi di Wilayah Terpencil',
                    ],
                    'image_path' => 'assets/img/hd/peneliti-wawancara.jpg',
                    'cta_text' => 'Pelajari Kolaborasi Riset',
                    'cta_url' => '/untuk-peneliti',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'target' => 'mitra_desa',
                    'title' => 'Kemitraan Kedaulatan Desa & Sanggar Adat',
                    'subtitle' => 'Merawat Ruang Adat, Menjaga Regenerasi Pemuda Lokal',
                    'description' => 'Kedaulatan narasi sepenuhnya berada di tangan komunitas lokal. Dana program dialokasikan langsung untuk kas konservasi sanggar, regenerasi keterampilan muda, dan penjagaan wilayah adat secara berkelanjutan.',
                    'features' => [
                        'Bagi Hasil Adil & Transparan Langsung ke Kas Sanggar Desa',
                        'Pelatihan Fasilitator Muda Desa Tanpa Mengubah Adat Istiadat',
                        'Kedaulatan Pembatasan Jumlah Pengunjung Demi Ketenangan Warga',
                        'Dokumentasi Arsip Digital Pengetahuan Warisan Leluhur',
                    ],
                    'image_path' => 'assets/img/hd/desa-serambi.jpg',
                    'cta_text' => 'Pelajari Kemitraan Desa',
                    'cta_url' => '/mitra-desa',
                    'order' => 3,
                    'is_active' => true,
                ],
            ];

            foreach ($programs as $item) {
                Program::create($item);
            }
        }

        // 4. Page Sections (Full CMS Structure)
        $this->call(PageSectionSeeder::class);

        // 5. Team Members (Dewan Kurator & Pendiri)
        $this->call(TeamMemberSeeder::class);
    }
}
