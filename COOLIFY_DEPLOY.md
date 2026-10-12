# 🚀 Panduan Deployment Destinara Compro ke Coolify

Panduan lengkap deployment proyek **Destinara Company Profile** (Laravel 12 + Vite + Tailwind CSS + MySQL) ke **Coolify** menggunakan domain **destinara.my.id**.

---

## 1. Arsitektur Domain & Environment

| Environment | Domain / FQDN di Coolify | Database | File Acuan Env |
|---|---|---|---|
| **Development** | `http://localhost:8030` | `db_comprodestinara` | `.env.development` |
| **Staging** | `https://staging.destinara.my.id` | `destinara_compro_staging` | `.env.staging` |
| **Production** | `https://destinara.my.id` | `destinara_compro_prod` | `.env.production` |

---

## 2. Langkah Deployment di Coolify Dashboard

### A. Buat Resource Application
1. Buka dashboard **Coolify**.
2. Pilih Project & Environment (misal: `Production` atau `Staging`).
3. Klik **+ New** -> **Application** -> pilih **Public Repository** atau **GitHub App / Private Repository**.
4. Masukkan URL repo dan pilih branch yang sesuai (`main` atau `dev`).
5. Pada pilihan Build Pack, biarkan default (**Nixpacks**).

### B. Konfigurasi Domain (FQDN)
Pada kolom **Domains**:
- **Production**: `https://destinara.my.id`
- **Staging**: `https://staging.destinara.my.id`

> Coolify secara otomatis akan mengurus sertifikat SSL Let's Encrypt melalui reverse proxy Traefik/Caddy. Laravel sudah dilengkapi middleware `trustProxies(at: '*')` sehingga HTTPS langsung aktif tanpa error mixed content.

### C. Masukkan Environment Variables
1. Buka tab **Environment Variables** di Coolify.
2. Buka file `.env.production` (atau `.env.staging`).
3. Salin (**Copy**) seluruh isi file dan tempel (**Paste**) ke form Environment Variables Coolify.
4. Sesuaikan nilai kredensial rahasia:
   - `DB_HOST`: Jika MySQL dibuat sebagai service di Coolify pada project/network yang sama, isi dengan nama servicenya (misal: `mysql` atau `destinara-mysql`). Jika di luar container, gunakan IP private atau `host.docker.internal`.
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   - `MAIL_PASSWORD` (password SMTP email Hostinger).
   - `ADMIN_PASSWORD` (password untuk seeder admin pertama).

### D. Perintah Pasca-Deploy (Post-deployment Command)
Di menu konfigurasi aplikasi Coolify, pada bagian **Post-deployment Command** (atau jalankan di Terminal Container):
```bash
php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## 3. Persistent Storage (Penting untuk Upload File)
Jika aplikasi mengizinkan upload gambar (destinasi, cerita, tim), tambahkan **Persistent Storage** di Coolify agar data upload tidak hilang saat rebuild container:
- **Source Volume**: `compro-storage-public`
- **Destination Path**: `/app/storage/app/public` (atau path storage aplikasi Anda)

---

## 4. Akun Admin Awal
Setelah menjalankan `php artisan migrate --seed`:
- **URL Admin**: `https://destinara.my.id/admin`
- **Email**: `admin@destinara.my.id`
- **Password**: Sesuai nilai `ADMIN_PASSWORD` di environment Coolify.
