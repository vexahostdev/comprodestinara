# 🚀 Panduan Deployment Destinara Compro ke Coolify

Panduan deployment produksi **Destinara Company Profile** (`destinara.my.id`) ke **Coolify** (Nixpacks, PHP 8.2+, MySQL) sesuai **BACKEND SPEC DESTINARA §21**.

---

## 1. Arsitektur & Lingkungan

- **Build Pack**: Nixpacks
- **PHP Version**: 8.2+
- **Database**: MySQL 8.0+ (`db_comprodestinara`)
- **Domain (FQDN)**:
  - Production: `https://destinara.my.id` (SSL Let's Encrypt otomatis dari Coolify)
  - Staging: `https://staging.destinara.my.id`
  - Development: `https://dev.destinara.my.id`

---

## 2. Environment Variables Wajib

Masukkan variabel-variabel berikut pada tab **Environment Variables** aplikasi Coolify:

```dotenv
APP_NAME="Destinara Compro"
APP_ENV=production
APP_KEY=base64:... # Generate dengan: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://destinara.my.id

LOG_CHANNEL=stack
LOG_LEVEL=info

# Database MySQL Coolify
DB_CONNECTION=mysql
DB_HOST=kgnzm2wodjjnfjfrxdo1avqa # Sesuai resource container MySQL
DB_PORT=3306
DB_DATABASE=db_comprodestinara
DB_USERNAME=mysql # atau root jika hak akses dibatasi
DB_PASSWORD=secret_password_anda

# Integrasi ke Destinara Core System (Layanan Booking)
CORE_SYSTEM_URL=https://layanan.destinara.my.id
CORE_SYSTEM_API_URL=https://layanan.destinara.my.id/api/v1/public

# Inisialisasi Akun Admin Portal
ADMIN_NAME="Administrator Compro"
ADMIN_EMAIL="admin@destinara.my.id"
ADMIN_PASSWORD="GantiDenganPasswordSuperAman123!"
```

---

## 3. Persistent Storage (Volume)

Untuk menjaga agar gambar sampul artikel, dokumen media editorial, dan aset upload CMS tidak hilang saat rebuild container:

Di Coolify, pada tab **Storages** / **Persistent Storage**:
- **Source Volume**: `compro-storage-public`
- **Destination Path**: `/app/storage/app/public`

---

## 4. Perintah Pasca-Deploy (Post-deployment Command)

### Deploy Pertama Kali (Setelah Refactor Backend):
Jalankan migrasi, pembersihan data demo lama (`compro:purge-dummy`), pembuatan symlink storage, dan optimasi cache:
```bash
php artisan migrate --force && php artisan compro:purge-dummy && php artisan storage:link && php artisan optimize
```

### Update Deploy Selanjutnya:
```bash
php artisan migrate --force && php artisan storage:link && php artisan optimize
```

---

## 5. Akses Admin Portal

Setelah deployment selesai:
- Akses URL: `https://destinara.my.id/admin`
- Email & Password: Sesuai nilai `ADMIN_EMAIL` dan `ADMIN_PASSWORD` yang Anda tentukan di environment Coolify.
- Pengguna umum tidak dapat mendaftar (rute `/register` mengembalikan 404).
