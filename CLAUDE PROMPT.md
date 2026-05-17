# CLAUDE PROMPT — CatatanKu (PRD Lengkap)

> Upload file ini ke Claude dan minta: **"Buatkan website ini dari awal sesuai prompt di bawah, kirim dalam file ZIP."**

---

## Identitas Proyek

- **Nama Web:** CatatanKu
- **Konsep:** Aplikasi catatan digital sederhana mirip Google Keep — user bisa daftar, login, dan langsung mencatat per kategori
- **Tech Stack:**
  - Backend: PHP 8.3 + Laravel 12 (MVC biasa, **tanpa Filament**)
  - Database: MySQL
  - Frontend: Tailwind CSS CDN (bukan build), SweetAlert2 CDN
  - Font: Inter dari Google Fonts
- **Warna tema:** Kuning soft (`#FBBF24`), putih, abu-abu — nuansa catatan/notes

---

## Konsep Teknis Umum

- Laravel MVC biasa (tidak pakai Filament, tidak pakai Livewire)
- Database MySQL
- **Jangan pakai `npm run build` / Vite** — Tailwind CSS via CDN langsung di `<head>`
- SweetAlert2 via CDN untuk semua konfirmasi (hapus, logout, dll)
- AJAX (`fetch`) untuk CRUD catatan agar daftar notes realtime tanpa reload halaman
- Pindah kategori boleh full reload (bukan AJAX)
- Setiap form input, button, checkbox, radio — **wajib ada styling Tailwind** (jangan ada elemen tanpa desain)
- Sidebar di kiri, konten di kanan
- Responsive untuk desktop & tablet
- Buat logo SVG inline dan favicon SVG untuk web ini
- Tambahkan meta SEO (title, description, keywords, og tags) di setiap halaman
- Semua konfirmasi delete & logout pakai **SweetAlert2**
- Logout pakai SweetAlert confirm dulu sebelum submit form POST

---

## Struktur Database

### Tabel `users`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK auto | |
| name | varchar(255) | |
| email | varchar(255) unique | |
| email_verified_at | timestamp nullable | |
| password | varchar(255) | bcrypt |
| role | enum('user','admin') | default 'user' |
| remember_token | varchar(100) nullable | |
| created_at, updated_at | timestamp | |

### Tabel `categories`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK auto | |
| user_id | bigint FK → users (cascade delete) | |
| name | varchar(255) | |
| color | varchar(20) | default '#FBBF24' |
| order | int | default 0 |
| created_at, updated_at | timestamp | |

### Tabel `notes`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK auto | |
| user_id | bigint FK → users (cascade delete) | |
| category_id | bigint FK → categories (cascade delete) | |
| title | varchar(255) | |
| description | text nullable | |
| color | varchar(20) | default '#FBBF24' |
| is_pinned | boolean | default false |
| is_archived | boolean | default false |
| created_at, updated_at | timestamp | |

> Sertakan juga migration default Laravel: `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`, `failed_jobs`, `job_batches` — **digabung dalam 1 file migration users** agar tidak ada yang hilang.

---

## Fitur & Halaman

### Auth
- **Halaman Login** (`/login`) — form email + password, link ke register
- **Halaman Register** (`/register`) — form nama, email, password, konfirmasi password
- Redirect ke `/notes` setelah login/register
- Guest middleware: halaman login & register tidak bisa diakses kalau sudah login
- Setelah register otomatis buat 1 kategori default bernama **"Catatan"** warna `#FBBF24`

### Halaman Notes Utama (`/notes`)
Layout: Sidebar kiri + main content kanan

**Sidebar kiri:**
- Logo + nama app + nama user yang login
- Label "KATEGORI" + tombol `+` untuk tambah kategori
- Daftar kategori user (tiap item: dot warna, nama, jumlah catatan)
- Hover kategori → muncul tombol edit & hapus kategori (kecil, di kanan)
- Hapus kategori pakai SweetAlert confirm (warning: semua catatannya ikut terhapus)
- Di bawah sidebar: link "Panel Admin" (hanya kalau role = admin) + tombol Keluar
- Keluar pakai SweetAlert confirm

**Header main:**
- Judul kategori aktif
- Input pencarian real-time (debounce 400ms, AJAX)
- Tombol sortir Asc/Desc (toggle, ikon panah)
- Toggle layout: Masonry | List (2 tombol ikon)
- Tombol "+ Catatan Baru" (kuning)

**Area catatan:**
- Default layout: **Masonry** (CSS column-count)
- List layout: flex column, max-width 42rem, terpusat
- Tiap card catatan tampil: warna background, judul, deskripsi (max 3 baris), waktu update, ikon pin (kalau disematkan)
- Hover card → muncul tombol aksi: pin/unpin, edit, hapus
- Hapus catatan pakai SweetAlert confirm
- **Empty state** (tidak ada catatan): tampil di luar grid, terpusat, icon catatan, teks "Belum ada catatan", teks sub "Mulai abadikan idemu sekarang", tombol "Buat Catatan Pertama" (kuning, langsung buka modal)

**Modal Tambah/Edit Catatan:**
- Field: Judul (required), Deskripsi (textarea), Kategori (select), Warna (7 pilihan radio dot warna)
- Simpan via AJAX (fetch POST/PUT)
- Setelah simpan: tutup modal, toast SweetAlert sukses, reload list notes (AJAX)
- Warna pilihan: `#fef9c3` Kuning, `#dbeafe` Biru, `#dcfce7` Hijau, `#fce7f3` Pink, `#ede9fe` Ungu, `#ffedd5` Oranye, `#f9fafb` Putih

**Modal Tambah/Edit Kategori:**
- Field: Nama kategori (required), Warna (7 pilihan radio dot warna)
- Simpan via AJAX, reload halaman setelah berhasil (700ms delay)
- Warna pilihan: `#FBBF24`, `#60A5FA`, `#34D399`, `#F472B6`, `#A78BFA`, `#FB923C`, `#94A3B8`

### API Endpoint (AJAX internal)
- `GET /api/notes?category=&search=&sort=&sort_by=` → JSON list notes milik user aktif
- `POST /notes` → buat catatan baru
- `POST /notes/{id}` + `_method=PUT` → update catatan
- `POST /notes/{id}` + `_method=DELETE` → hapus catatan
- `POST /notes/{id}/pin` + `_method=PATCH` → toggle pin
- `POST /categories` → buat kategori
- `POST /categories/{id}` + `_method=PUT` → update kategori
- `POST /categories/{id}` + `_method=DELETE` → hapus kategori

### Admin Panel (`/admin/dashboard`)
- Middleware: harus login + role = admin
- Tampil statistik: total pengguna, total catatan, total kategori
- Tabel daftar semua pengguna (nama, email, jumlah catatan, jumlah kategori, tanggal daftar)
- **Tombol autofill login** di halaman login admin: klik tombol → otomatis isi field email & password (bukan auto login, tetap klik tombol login manual)
- Tidak ada halaman untuk melihat isi catatan pengguna (privasi)

---

## Routes

```php
Route::get('/', fn() => redirect()->route('login'));

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');
    Route::get('/api/notes', [NoteController::class, 'getNotes'])->name('notes.api');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Admin only
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
```

---

## Controllers

### AuthController
- `showLogin()` → view login
- `login()` → validasi, Auth::attempt, redirect ke notes
- `showRegister()` → view register
- `register()` → validasi, buat user, buat kategori default "Catatan", login otomatis, redirect notes
- `logout()` → Auth::logout, redirect login

### NoteController
- `index()` → ambil kategori user, notes filter by category+search+sort, render view
- `store()` → validasi, buat note, return JSON `{success, message, note}`
- `update()` → validasi, update note, return JSON
- `destroy()` → hapus note, return JSON
- `togglePin()` → toggle `is_pinned`, return JSON
- `getNotes()` → filter notes (category, search, sort), return JSON untuk AJAX

### CategoryController
- `store()` → validasi, buat kategori, return JSON
- `update()` → validasi, update kategori (cek ownership), return JSON
- `destroy()` → hapus kategori (cek bukan satu-satunya + ownership), return JSON

### AdminController
- `dashboard()` → ambil statistik global + daftar users, render view

---

## Models

### User
- `hasMany(Category::class)`
- `hasMany(Note::class)`
- Method `isAdmin()`: return `$this->role === 'admin'`

### Category
- `belongsTo(User::class)`
- `hasMany(Note::class)`

### Note
- `belongsTo(User::class)`
- `belongsTo(Category::class)`
- Fillable: user_id, category_id, title, description, color, is_pinned, is_archived

---

## Middleware

### AdminMiddleware
```php
if (!Auth::check() || !Auth::user()->isAdmin()) {
    abort(403);
}
```
Daftarkan alias `'admin'` di `bootstrap/app.php`.

---

## Seeder (DatabaseSeeder)

Buat data dummy berikut:

**Admin:** `admin@catatanku.com` / `admin123` (role: admin), 1 kategori "Catatan", 12+ catatan

**Demo User:** `demo@catatanku.com` / `demo123`, 4 kategori (Catatan, Pekerjaan, Pribadi, Ide), masing-masing 10+ catatan dengan konten realistis Bahasa Indonesia

**Dummy users tambahan (4 orang):**
- Budi Santoso `budi@example.com` / `budi123` — 3 kategori (Catatan, Kuliah, Hobi)
- Siti Rahayu `siti@example.com` / `siti123` — 4 kategori (Catatan, Resep, Keuangan, Wishlist)
- Rizky Pratama `rizky@example.com` / `rizky123` — 3 kategori (Catatan, Dev Notes, Proyek)
- Dewi Anggraini `dewi@example.com` / `dewi123` — 3 kategori (Catatan, Bisnis, Motivasi)

Konten catatan: realistis, Bahasa Indonesia, bervariasi (daftar, tips, jadwal, quote, resep, dll). Gunakan helper `private function seedNotes(int $userId, array $notes)` agar kode rapi.

---

## Views (Blade)

### `layouts/app.blade.php`
- Meta SEO lengkap (title, description, keywords, og:title, og:description, og:type, og:url)
- Favicon SVG
- Tailwind CSS CDN + config warna kustom
- SweetAlert2 CDN
- Google Fonts Inter
- `@yield('content')` + `@stack('scripts')`
- CSS inline untuk: `.sidebar-item`, `.form-input`, `.form-label`, `.btn`, `.btn-primary`, `.btn-secondary`, `.btn-icon`, `.color-option`, `.color-dot`, `.masonry-grid`, `.masonry-item`, `.note-card`, `.fade-in-up`, `.input-group`, `.input-icon`

### `auth/login.blade.php`
- Form login dengan styling lengkap
- Link ke register
- Tombol **"Isi Login Admin (Testing)"** yang autofill email & password via JS (bukan auto submit)
- Error flash dari session

### `auth/register.blade.php`
- Form register dengan styling lengkap
- Link ke login
- Error flash

### `notes/index.blade.php`
- Sidebar + main layout (flex, full viewport height, overflow hidden)
- Semua fitur notes (lihat bagian Fitur di atas)
- Modal catatan + modal kategori
- Semua JS (AJAX, modal, SweetAlert) di `@push('scripts')`

### `notes/_note_card.blade.php`
- Partial card satu catatan
- Support layout masonry & list
- Hover actions: pin, edit, hapus

### `admin/dashboard.blade.php`
- Header admin
- Cards statistik (total users, notes, kategori)
- Tabel daftar pengguna
- Tombol logout + link ke `/notes`

---

## Desain & UX

- Warna primer: Kuning `#FBBF24` / `#f59e0b`
- Sidebar putih bersih, border kanan tipis
- Card catatan: sudut bulat, warna background dari field `color`, shadow tipis
- Hover card → tampil tombol aksi (opacity transition)
- Modal: backdrop blur, fade-in-up animation, shadow besar
- Tombol primary: kuning solid, hover lebih gelap
- Tombol secondary: abu-abu
- Input form: border rounded, focus ring kuning
- Radio warna: dot bulat 1.5rem, border saat selected, scale up saat hover
- Empty state: icon di lingkaran kuning gradient, centered, tombol CTA kuning
- Toast notification: SweetAlert2 `toast: true, position: 'top-end'`
- Semua transisi: `0.15s ease`

---

## File yang Harus Dikirim dalam ZIP

```
catatanku/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── NoteController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   └── Note.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php              ← daftarkan alias middleware 'admin'
├── config/
│   └── app.php              ← locale id, timezone Asia/Jakarta
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php   ← termasuk sessions & password_reset_tokens
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_01_01_000001_create_categories_table.php
│   │   └── 2024_01_01_000002_create_notes_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   ├── favicon.svg
│   └── images/
│       └── logo.svg
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── notes/
│       │   ├── index.blade.php
│       │   └── _note_card.blade.php
│       └── admin/
│           └── dashboard.blade.php
├── routes/
│   └── web.php
├── .env.example
└── README.md
```

---

## Catatan Tambahan

- Locale Laravel: `id` (Bahasa Indonesia), timezone: `Asia/Jakarta`
- Kalau ada error `setLocale`, tambahkan `setlocale(LC_ALL, 'id_ID.UTF-8', 'id_ID', 'id')` di `AppServiceProvider::boot()`
- `.env.example` sudah dikonfigurasi untuk MySQL (bukan SQLite)
- Jangan kirim `vendor/`, `node_modules/`, `storage/logs/`, `public/storage/`
- Tambahkan `README.md` singkat dengan instruksi instalasi
- Semua response controller CRUD catatan & kategori return JSON `{success: bool, message: string, ...data}`
