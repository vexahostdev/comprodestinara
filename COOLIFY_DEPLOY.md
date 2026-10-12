# 🚀 Panduan Deployment Destinara Compro ke Coolify

Panduan lengkap deployment proyek **Destinara Company Profile** (Laravel 12 + Vite + Tailwind CSS + MySQL) ke **Coolify** menggunakan domain **destinara.my.id**.

---

## 1. Ringkasan Kredensial MySQL Coolify

| Parameter | Development | Staging | Production |
|---|---|---|---|
| **Coolify Resource** | `destinara-mysql-dev` | `destinara-mysql-staging` | `destinara-mysql-production` |
| **DB_HOST / Container** | `vbi0lskyqkxybarmwlgtmobo` | `athi0chh8tohka2pb9dbrrfh` | `kgnzm2wodjjnfjfrxdo1avqa` |
| **DB_PORT** | `3306` | `3306` | `3306` |
| **DB_DATABASE** | `db_comprodestinara` | `db_comprodestinara` | `db_comprodestinara` |
| **DB_USERNAME** | `mysql` | `mysql` | `mysql` |
| **Domain (FQDN)** | `http://localhost:8030` | `https://staging.destinara.my.id` | `https://destinara.my.id` |
| **File Env Acuan** | `.env.development` | `.env.staging` | `.env.production` |

> 💡 **Tips Hak Akses MySQL di Coolify:**
> Default user `mysql` di Coolify awalnya terasosiasi ke database default (`destinara_dev` / `destinara_staging` / `destinara_production`).
> Jika migrasi mengalami error *Access denied for database db_comprodestinara*, ubah `DB_USERNAME=root` dan masukkan `ROOT_PASSWORD` yang tertera di catatan resource Coolify.

---

## 2. Langkah Deployment di Dashboard Coolify

### A. Buat Resource Application
1. Buka dashboard **Coolify**.
2. Pilih Project & Environment tujuan (**Production**, **Staging**, atau **Development**).
3. Klik **+ New** -> **Application** -> pilih repositori Git Anda.
4. Pilih branch yang sesuai (`main` atau `dev`).
5. Pada pilihan Build Pack, gunakan **Nixpacks** (default).

### B. Konfigurasi Domain (FQDN)
Pada kolom **Domains**:
- **Production**: `https://destinara.my.id`
- **Staging**: `https://staging.destinara.my.id`
*(SSL Let's Encrypt diurus otomatis oleh Coolify).*

### C. Masukkan Environment Variables
1. Buka tab **Environment Variables** di aplikasi Coolify Anda.
2. Buka file `.env.production` (atau `.env.staging` / `.env.development`).
3. Salin (**Copy**) seluruh isi file dan tempel (**Paste**) ke form Environment Variables Coolify.
4. Simpan perubahan.

### D. Perintah Pasca-Deploy (Post-deployment Command)
Di menu konfigurasi aplikasi Coolify, pada bagian **Post-deployment Command** (atau jalankan di Terminal Container):
```bash
php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## 3. Persistent Storage (Upload Gambar & Dokumen)
Tambahkan **Persistent Storage** di Coolify agar aset upload tidak terhapus saat container di-rebuild:
- **Source Volume**: `compro-storage-public`
- **Destination Path**: `/app/storage/app/public`

---

## 4. Akun Admin Awal
Setelah menjalankan `php artisan migrate --seed`:
- **URL Admin**: `https://destinara.my.id/admin`
- **Email**: `admin@destinara.my.id`
- **Password**: Sesuai nilai `ADMIN_PASSWORD` di environment Coolify.
