<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\Story;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Users (SPEC §16.1 & §19.3)
        $email = config('admin.email');
        $password = config('admin.password');
        $name = config('admin.name', 'Admin Destinara');

        if (app()->isProduction() && (empty($email) || empty($password))) {
            throw new \RuntimeException('ADMIN_EMAIL and ADMIN_PASSWORD environment variables are required in production.');
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

        // 3. Stories (Destinations are served via Core System API per SPEC §16.3)
        if (Story::count() === 0) {
            $stories = [
                [
                    'title' => 'Monograf: Zat Pewarna Alami Sikka di Balik Modernisasi Tekstil',
                    'slug' => 'zat-pewarna-alami-sikka',
                    'category' => 'Etnobotani',
                    'archive_no' => 'Arsip Lapangan No. 042',
                    'read_time' => '8 Menit Baca',
                    'author_name' => 'Dewi Anggraini',
                    'author_role' => 'Fasilitator Lapangan Sikka',
                    'excerpt' => 'Di perbukitan Maumere, perempuan penenun merawat akar mengkudu dan daun tarum bukan semata demi estetika kain, melainkan ikatan spiritual penjagaan hutan rempah Flores.',
                    'content' => '<p>Perjalanan menembus rimbun perbukitan Sikka membawa kita pada aroma tanah basah bercampur fermentasi dedaunan alami. Di sini, para mama penenun tidak mengenal pewarna sintetis buatan pabrik. Setiap helai benang kapas dipintal tangan dan direndam dalam ramuan akar Morinda citrifolia (mengkudu hutan) dan daun Indigofera tinctoria (tarum).</p><p>Proses perendaman membutuhkan waktu berbulan-bulan, mengikuti siklus rembulan dan kelembapan udara. Ada rasa hormat mendalam kepada tanah: pohon yang diambil akarnya tidak boleh dicabut seluruhnya, melainkan disisakan agar tetap hidup dan bertunas kembali.</p><blockquote>"Bagi kami, warna merah tua bukan sekadar pigmen. Ia adalah denyut darah leluhur yang mengalir dalam doa-doa benang." — Mama Maria, Penenun Adat Watublapi.</blockquote><p>Melalui keterlibatan langsung peserta didik Destinara, kami mendokumentasikan formula kimia alami yang mampu bertahan ratusan tahun tanpa luntur, sekaligus menumbuhkan apresiasi tulus bagi kedaulatan pengetahuan perempuan adat nusantara.</p>',
                    'image_path' => 'assets/img/hd/story-sikka.jpg',
                    'published_at' => now()->subDays(4),
                    'is_featured' => true,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pelajaran Musim Tanam dari Tetua Adat Sasak: Mengapa Benih Lokal Tetap Bertahan',
                    'slug' => 'musim-tanam-tetua-adat-sasak',
                    'category' => 'Sosio-Ekologi',
                    'archive_no' => 'Arsip Lapangan No. 039',
                    'read_time' => '6 Menit Baca',
                    'author_name' => 'Dr. Hendro Wicaksono',
                    'author_role' => 'Peneliti Agroekologi',
                    'excerpt' => 'Di tengah ancaman perubahan iklim dan kekeringan ekstrem, lumbung beras padi gogo rancah di Lombok Selatan membuktikan keunggulan seleksi genetik ratusan tahun.',
                    'content' => '<p>Ketika gelombang El Niño melanda wilayah Nusa Tenggara, banyak lahan persawahan modern mengalami gagal panen. Namun, di kantung-kantung desa adat Sasak, padi lokal berbatang tinggi justru kokoh tegak menyerap embun malam.</p><p>Tetua adat memandu rombongan mahasiswa untuk mencatat kalender mangsa dan perilaku burung pemangsa hama. Tanpa pestisida kimia, ekosistem pematang sawah memelihara keseimbangannya sendiri.</p>',
                    'image_path' => 'assets/img/hd/story-sasak.jpg',
                    'published_at' => now()->subDays(12),
                    'is_featured' => false,
                    'is_active' => true,
                ],
                [
                    'title' => 'Menguji Struktur Kayu Ulin Tanpa Paku: Kejeniusan Arsitektur Sambungan Pasak',
                    'slug' => 'arsitektur-kayu-tanpa-paku',
                    'category' => 'Kriya & Material',
                    'archive_no' => 'Arsip Lapangan No. 035',
                    'read_time' => '7 Menit Baca',
                    'author_name' => 'Bagus Prasetyo, S.T.',
                    'author_role' => 'Fasilitator Konstruksi Vernakular',
                    'excerpt' => 'Catatan lapangan bersama 16 mahasiswa arsitektur saat merekonstruksi model pasak geser dan peredam gempa alami pada tiang kayu ulin Kalimantan.',
                    'content' => '<p>Sebelum standar gedung tahan gempa modern dirumuskan, nenek moyang kepulauan telah menyelesaikan masalah getaran tanah melalui sambungan pasak elastis. Kayu tidak diikat mati dengan semen kaku, melainkan dibiarkan bergerak harmonis mengikuti gelombang seismik.</p>',
                    'image_path' => 'assets/img/hd/story-ulin.jpg',
                    'published_at' => now()->subDays(20),
                    'is_featured' => false,
                    'is_active' => true,
                ],
            ];

            foreach ($stories as $item) {
                Story::create($item);
            }
        }

        // 5. Programs
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

        // 6. Testimonials
        if (Testimonial::count() === 0) {
            $testimonials = [
                [
                    'name' => 'M. Taufik Hidayat',
                    'role' => 'Koordinator Komunitas Konservasi Tapak',
                    'institution' => 'DI Yogyakarta',
                    'quote' => 'Destinara tidak membawa rombongan turis massal yang merusak tapak. Peserta yang datang mematuhi adab setempat, menghargai sesepuh desa, dan menjaga ekosistem bersama.',
                    'avatar_path' => null,
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => 'Dr. Ratih Kumalasari, M.Hum.',
                    'role' => 'Dosen Antropologi Terapan',
                    'institution' => 'Fakultas Ilmu Budaya Universitas Indonesia',
                    'quote' => 'Protokol etika FPIC Destinara adalah standar emas baru dalam riset lapangan mahasiswa kami. Bukan sekadar observasi dari luar, melainkan peleburan yang menghasilkan empati dan data lapangan orisinal.',
                    'avatar_path' => null,
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'name' => 'Drs. Ignatius Suryanto',
                    'role' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                    'institution' => 'SMA Kolese De Britto',
                    'quote' => 'Siswa kami pulang bukan membawa suvenir murah buatan pabrik, tetapi kesadaran mendalam mengenai cara hidup mandiri warga desa, tanggung jawab ekologi, dan rasa hormat pada kearifan lokal.',
                    'avatar_path' => null,
                    'order' => 3,
                    'is_active' => true,
                ],
            ];

            foreach ($testimonials as $item) {
                Testimonial::create($item);
            }
        }

        // 7. Stats
        if (Stat::count() === 0) {
            $stats = [
                ['value' => '14+', 'label' => 'Tapak Riset Terkurasi', 'order' => 1, 'is_active' => true],
                ['value' => '1.200+', 'label' => 'Pelajar & Peneliti Terfasilitasi', 'order' => 2, 'is_active' => true],
                ['value' => '100%', 'label' => 'Kemitraan Berbasis Etika FPIC', 'order' => 3, 'is_active' => true],
                ['value' => '28', 'label' => 'Modul Pembelajaran Lapangan Aktif', 'order' => 4, 'is_active' => true],
            ];

            foreach ($stats as $item) {
                Stat::create($item);
            }
        }

        // 8. Page Sections (Full CMS)
        $this->call(PageSectionSeeder::class);

        // 9. Team Members (Dewan Kurator)
        $this->call(TeamMemberSeeder::class);
    }
}
