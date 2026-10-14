# Destinara — Company Profile & Editorial Web Portal

Portal web profil perusahaan resmi dan ruang publik **Destinara (Inisiatif Pendidikan Lapangan & Riset Berbasis Komunitas)** (`destinara.my.id`), dibangun menggunakan **Laravel 12**, **Tailwind CSS**, **Alpine.js**, dan **Breeze**.

---

## 🌟 Arsitektur & Peran Sistem

Destinara Compro bertindak sebagai wajah publik perusahaan dan menyajikan konten editorial, profil inisiatif, program sekolah/peneliti, serta warta lapangan.

### Integrasi dengan Destinara Core System
Sesuai **BACKEND SPEC DESTINARA §15 & §16**:
1. **Katalog Destinasi Terpusat**: Compro **tidak lagi menyimpan data destinasi di database lokal**. Seluruh destinasi diambil secara langsung melalui HTTP API dari Core System (`layanan.destinara.my.id/api/v1/public/destinations`).
2. **Klien API Tangguh (`CoreSystemClient`)**:
   - Cache lokal berdurasi 10 menit dengan tag `core-system`.
   - Timeout request 5 detik.
   - **Stale Fallback**: Apabila Core System sedang offline atau tidak dapat dijangkau, compro secara otomatis menyajikan data cache terakhir (stale cache) agar pengunjung tetap dapat melihat direktori desa.
3. **Pemesanan Terintegrasi**: Tombol *Reservasi* atau *Booking* pada detail destinasi langsung mengarahkan pengunjung ke halaman pemesanan Core System menggunakan `booking_url` resmi dari API.
4. **Pembersihan Data Fiktif (`compro:purge-dummy`)**: Command konsol untuk membersihkan data demo lama (testimoni fiktif, angka statistik klaim, destinasi lokal).

---

## 🔒 Keamanan & Kebijakan Akses

- **Registrasi Publik Ditutup**: Endpoint `/register` ditutup sepenuhnya dan mengembalikan respons HTTP `404 Not Found`.
- **Proteksi Panel Admin**: Panel administrasi `/admin` dilindungi oleh middleware `EnsureAdmin` yang memvalidasi flag `is_admin = true` pada tabel `users`.
- **Aman Path Traversal**: Route streaming aset `/storage/{path}` diproteksi dengan verifikasi `realpath()` terhadap direktori basis storage publik.
- **Pembersihan Cache Aman**: Endpoint pembersihan cache sistem hanya dapat diakses melalui metode `POST` oleh admin terautentikasi (bukan `GET`).
- **Zero Dummy Data**: Seluruh akun demo lama dan seeder fiktif telah dibersihkan. Akun admin diinisialisasi melalui environment variable.

---

## 📁 Struktur Modul & Fitur

- `app/Services/CoreSystemClient.php`: Service pengambil data katalog destinasi dari Core System.
- `app/Http/Controllers/DestinationController.php`: Menampilkan direktori tapak nusantara dari Core API.
- `app/Http/Controllers/HomeController.php`: Beranda dengan destinasi unggulan dari Core API dan konten editorial CMS.
- `app/Console/Commands/ComproPurgeDummy.php`: Command `php artisan compro:purge-dummy`.
- `app/Http/Middleware/EnsureAdmin.php`: Penjaga akses khusus admin portal.
- `routes/web.php` & `routes/auth.php`: Routing halaman publik, CMS, dan autentikasi.

---

## 🛠️ Persyaratan Lingkungan & Instalasi Lokal

### Kebutuhan:
- PHP >= 8.2 (ekstensi: pdo_mysql, mbstring, curl, openssl)
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0+

### Langkah Setup:

1. **Clone repositori & masuk ke direktori**:
   ```bash
   cd "destinara - compro"
   ```

2. **Install dependensi**:
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Salin file environment & generate APP_KEY**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi `.env`**:
   ```dotenv
   APP_NAME="Destinara Compro"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_comprodestinara
   DB_USERNAME=root
   DB_PASSWORD=

   # Integrasi Core System
   CORE_SYSTEM_URL=http://localhost:8001
   CORE_SYSTEM_API_URL=http://localhost:8001/api/v1/public

   # Kredensial Administrator Awal
   ADMIN_NAME="Administrator Compro"
   ADMIN_EMAIL="admin@destinara.my.id"
   ADMIN_PASSWORD="PasswordAman123!"
   ```

5. **Migrasi database & Inisialisasi Konten**:
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan compro:purge-dummy
   php artisan storage:link
   ```

6. **Jalankan web server lokal**:
   ```bash
   php artisan serve --port=8000
   ```

---

## 🧪 Pengujian (Testing)

Jalankan test suite otomatis:
```bash
php artisan test
```

Semua unit & feature test memverifikasi:
- Penutupan rute registrasi (`/register` → 404).
- Proteksi panel admin terhadap pengguna non-admin (403 Forbidden).
- Resiliensi `CoreSystemClient` dengan simulasi HTTP API timeout & offline fallback.
- Validasi streaming storage dan pencegahan path traversal.
- Eksekusi command `compro:purge-dummy`.

---

## 📦 Standar Kode
Format kode dijaga menggunakan Laravel Pint:
```bash
./vendor/bin/pint
```
