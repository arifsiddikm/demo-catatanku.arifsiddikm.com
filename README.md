# CatatanKu — Aplikasi Catatan Digital

Aplikasi catatan digital sederhana berbasis web, terinspirasi dari Google Keep. User bisa daftar, login, dan langsung mencatat dengan fitur kategori, warna catatan, masonry/list layout, search, sortir, dan pin catatan.

🌐 **Live Demo:** [demo-catatanku.arifsiddikm.com](https://demo-catatanku.arifsiddikm.com)

---

## Tech Stack

- **Backend:** PHP 8.3 + Laravel 12
- **Database:** MySQL
- **Frontend:** Tailwind CSS CDN · SweetAlert2
- **Font:** Inter (Google Fonts)

---

## Fitur

**Pengguna**
- Register & Login
- Buat, edit, hapus catatan (AJAX — realtime tanpa reload)
- Kategori catatan (CRUD) dengan warna kustom
- Default kategori "Catatan" otomatis saat daftar
- Masonry layout & List layout (toggle)
- Sortir catatan Asc / Desc
- Pencarian catatan real-time
- Pin / unpin catatan penting
- Warna catatan custom (7 pilihan)
- Tampil info waktu dibuat & diperbarui

**Admin Panel** (`/admin/dashboard`)
- Statistik: total pengguna, catatan, kategori
- Daftar semua pengguna terdaftar
- Auto-fill form login admin (untuk testing)
- Logout dengan konfirmasi SweetAlert

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/arifsiddikm/catatanku.git
cd catatanku

# 2. Install dependencies
composer install

# 3. Copy dan konfigurasi .env
cp file env to .env and setting your password
php artisan key:generate

# 4. Buat database MySQL, lalu jalankan migrasi & seeder
php artisan migrate
php artisan db:seed

# 5. Jalankan server
php artisan serve
```

Akses di `http://localhost:8000`

---

## Login

**Admin**
```
URL   : http://localhost:8000/admin/dashboard
Email : admin@catatanku.com
Pass  : admin123
```

**Demo User**
```
Email : demo@catatanku.com
Pass  : demo123
```

---

## Konfigurasi MySQL

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=catatanku
DB_USERNAME=root
DB_PASSWORD=
```

---

### Support me on
<a href="https://saweria.co/arifsiddikm" target="_blank"><img src="https://user-images.githubusercontent.com/26188697/180601310-e82c63e4-412b-4c36-b7b5-7ba713c80380.png" alt="Sawer me" height="41" width="174"></a>
