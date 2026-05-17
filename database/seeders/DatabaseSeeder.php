<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 1. ADMIN  (>10 catatan di kategori Catatan)
        // ─────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@catatanku.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        $aCat1 = Category::create(['user_id' => $admin->id, 'name' => 'Catatan',    'color' => '#FBBF24', 'order' => 0]);
        $aCat2 = Category::create(['user_id' => $admin->id, 'name' => 'Sistem',     'color' => '#60A5FA', 'order' => 1]);
        $aCat3 = Category::create(['user_id' => $admin->id, 'name' => 'Todo Admin', 'color' => '#34D399', 'order' => 2]);

        $this->seedNotes($admin->id, [
            // Catatan (>10)
            [$aCat1->id, 'Selamat Datang di CatatanKu', 'Ini akun administrator. Gunakan panel admin untuk memantau pengguna dan aktivitas sistem.', '#fef9c3', true],
            [$aCat1->id, 'Panduan Onboarding Admin', "1. Login ke /admin/dashboard\n2. Cek daftar pengguna terdaftar\n3. Pantau jumlah catatan & kategori\n4. Monitor aktivitas sistem", '#dbeafe', false],
            [$aCat1->id, 'Kebijakan Data Pengguna', "• Data catatan bersifat privat per user\n• Admin hanya melihat statistik agregat\n• Tidak ada akses ke isi catatan\n• Log aktivitas disimpan 90 hari", '#dcfce7', false],
            [$aCat1->id, 'Changelog v1.0.0', "✅ Auth (login/register)\n✅ CRUD Catatan\n✅ CRUD Kategori\n✅ Masonry & List layout\n✅ Search & Sort\n✅ Pin catatan\n✅ Panel Admin", '#fef3c7', false],
            [$aCat1->id, 'Rencana Fitur v1.1', "⬜ Dark mode\n⬜ Export catatan ke PDF\n⬜ Share catatan\n⬜ Tag/label tambahan\n⬜ Reminder & notifikasi", '#fae8ff', false],
            [$aCat1->id, 'Catatan Teknis Deploy', "Server: Ubuntu 22.04\nPHP: 8.3\nMySQL: 8.0\nNginx: 1.24\nSSL: Let's Encrypt (auto-renew)", '#e0f2fe', false],
            [$aCat1->id, 'Backup Schedule', "Harian: backup DB jam 02.00\nMingguan: full backup Minggu 03.00\nRetention: 30 hari\nStorage: /var/backups/catatanku", '#ecfdf5', false],
            [$aCat1->id, 'Kontak Tim Dev', "Lead Dev: dev@catatanku.com\nOps: ops@catatanku.com\nSupport: support@catatanku.com\nEmergency: +62 812-xxxx-xxxx", '#ffedd5', false],
            [$aCat1->id, 'Performance Notes', "Avg response time: ~120ms\nDB query avg: ~15ms\nCache hit ratio: 87%\nUptime 30 hari: 99.94%", '#fce7f3', false],
            [$aCat1->id, 'Security Checklist', "✅ CSRF protection aktif\n✅ XSS sanitasi input\n✅ SQL injection (Eloquent ORM)\n✅ Rate limiting login\n⬜ 2FA admin (planned)", '#ede9fe', false],
            [$aCat1->id, 'Monitoring Tools', "Uptime: UptimeRobot\nError tracking: Sentry\nLog: Laravel Telescope\nMetrics: Grafana + Prometheus", '#fff7ed', false],
            [$aCat1->id, 'SLA & Support Policy', "Response time: < 4 jam\nResolution target: < 24 jam\nMaintenance window: Minggu 01.00-03.00\nStatus page: status.catatanku.com", '#f0fdf4', false],
            // Sistem
            [$aCat2->id, 'Environment Config', "APP_ENV=production\nAPP_DEBUG=false\nDB_CONNECTION=mysql\nQUEUE_CONNECTION=redis\nCACHE_DRIVER=redis", '#fef9c3', true],
            [$aCat2->id, 'Artisan Commands Berguna', "php artisan cache:clear\nphp artisan config:cache\nphp artisan route:cache\nphp artisan queue:work\nphp artisan migrate", '#dbeafe', false],
            // Todo Admin
            [$aCat3->id, 'Sprint Minggu Ini', "✅ Fix bug empty state\n✅ Tambah dummy data seeder\n🔄 Review PR #12\n⬜ Deploy ke staging\n⬜ QA testing", '#dcfce7', true],
            [$aCat3->id, 'Review Permintaan Fitur', "1. Export CSV (requested by user)\n2. Folder/subfolder kategori\n3. Collaborative notes\n4. Mobile app (React Native)", '#ffedd5', false],
        ]);

        // ─────────────────────────────────────────
        // 2. DEMO USER  (>10 per kategori)
        // ─────────────────────────────────────────
        $demo = User::create([
            'name'     => 'Demo User',
            'email'    => 'demo@catatanku.com',
            'password' => Hash::make('demo123'),
            'role'     => 'user',
        ]);

        $dCat1 = Category::create(['user_id' => $demo->id, 'name' => 'Catatan',    'color' => '#FBBF24', 'order' => 0]);
        $dCat2 = Category::create(['user_id' => $demo->id, 'name' => 'Pekerjaan', 'color' => '#60A5FA', 'order' => 1]);
        $dCat3 = Category::create(['user_id' => $demo->id, 'name' => 'Pribadi',   'color' => '#34D399', 'order' => 2]);
        $dCat4 = Category::create(['user_id' => $demo->id, 'name' => 'Ide',       'color' => '#F472B6', 'order' => 3]);

        $this->seedNotes($demo->id, [
            // ── Catatan (12 notes) ──
            [$dCat1->id, 'Selamat datang di CatatanKu! 🎉', 'Ini adalah catatan pertamamu. Kamu bisa menambah, mengedit, dan menghapus catatan dengan mudah. Selamat mencatat!', '#fef9c3', false],
            [$dCat1->id, 'Tips Menggunakan CatatanKu', "• Klik '+' di sidebar untuk kategori baru\n• Warna catatan = prioritas\n• Sematkan catatan penting agar muncul di atas\n• Gunakan pencarian untuk menemukan catatan cepat", '#dbeafe', false],
            [$dCat1->id, 'Shortcut Keyboard', "Ctrl+S = Simpan\nCtrl+N = Catatan baru\nEsc = Tutup modal\nCtrl+F = Fokus ke pencarian", '#fef3c7', false],
            [$dCat1->id, 'Quote of the Day', '"Sebuah perjalanan seribu mil dimulai dari satu langkah kecil." – Lao Tzu', '#fce7f3', false],
            [$dCat1->id, 'Hal yang Kusyukuri Hari Ini', "1. Bangun pagi dengan segar\n2. Sarapan enak\n3. Cuaca cerah\n4. Pekerjaan selesai tepat waktu\n5. Tidur yang berkualitas", '#dcfce7', true],
            [$dCat1->id, 'Rekomendasi Podcast', "• Podcast Hiduplah Indonesia\n• Thirty Days of Lunch\n• Menjadi Manusia\n• Tech In Asia Podcast\n• Inspigo", '#ede9fe', false],
            [$dCat1->id, 'Film yang Ingin Ditonton', "1. Oppenheimer\n2. Past Lives\n3. Poor Things\n4. The Zone of Interest\n5. Fallen Leaves", '#ffedd5', false],
            [$dCat1->id, 'Tempat Makan Favorit', "🍜 Soto Ayam Bu Sari – Jl. Merdeka 12\n🍣 Ichiban Sushi – Mall Central\n☕ Kopi Kenangan – dekat kantor\n🍱 Warteg Pak Kumis – murah meriah!", '#ecfdf5', false],
            [$dCat1->id, 'Password Hints (enkripsi!)', "Email utama: P***123!\nAkun kerja: W***@21\nNetflix: N***x99\nGithub: G***hub#1", '#fef9c3', false],
            [$dCat1->id, 'Nomor Penting', "Dokter: 0812-xxx-1234\nBengkel: 0856-xxx-5678\nAsuransi: 1500-XXX\nDarurat keluarga: 0821-xxx-9999", '#dbeafe', false],
            [$dCat1->id, 'Rutinitas Pagi', "05.30 – Bangun & sholat subuh\n06.00 – Olahraga ringan 15 menit\n06.30 – Mandi & siap-siap\n07.00 – Sarapan\n07.30 – Berangkat kerja", '#dcfce7', false],
            [$dCat1->id, 'Rutinitas Malam', "21.00 – Review hari ini\n21.30 – Baca buku 30 menit\n22.00 – Jurnal harian\n22.30 – Matikan HP\n23.00 – Tidur", '#fce7f3', false],

            // ── Pekerjaan (11 notes) ──
            [$dCat2->id, 'Meeting Mingguan', 'Agenda: Review sprint, update progress, planning minggu depan. Pastikan semua anggota hadir tepat waktu.', '#dcfce7', true],
            [$dCat2->id, 'Deadline Proyek Q2', "Proyek A – 30 Mei\nProyek B – 15 Juni\nProyek C – 1 Juli\nRevisi Laporan – 5 Juni", '#ffedd5', false],
            [$dCat2->id, 'Kontak Klien Penting', "PT Maju Jaya: 021-555-1234\nCV Berkah: 0812-3456-7890\nStartup X: hello@startupx.id\nPT Sejahtera: 021-777-8888", '#e0f2fe', false],
            [$dCat2->id, 'Standar Laporan Bulanan', "1. Summary eksekutif\n2. KPI dashboard\n3. Detail per divisi\n4. Hambatan & solusi\n5. Rekomendasi", '#fae8ff', false],
            [$dCat2->id, 'Template Email Profesional', "Yth. Bapak/Ibu [Nama],\n\nDengan hormat, bersama email ini saya bermaksud untuk...\n\nDemikian yang dapat saya sampaikan. Atas perhatiannya saya ucapkan terima kasih.\n\nHormat saya,\n[Nama]", '#fef3c7', false],
            [$dCat2->id, 'OKR Q2 2025', "Objective: Tingkatkan customer retention\n• KR1: Churn rate < 5%\n• KR2: NPS score > 70\n• KR3: Onboarding time < 3 hari", '#ecfdf5', false],
            [$dCat2->id, 'Skill yang Ingin Dipelajari', "1. Data Analysis (Python/Excel)\n2. Public Speaking\n3. Project Management (PMP)\n4. UI/UX basics\n5. Bahasa Inggris bisnis", '#fce7f3', false],
            [$dCat2->id, 'Meeting Notes 12 Mei', "Hadir: Ali, Budi, Citra, Dewi\nTopik: Revisi strategi Q2\nKeputusan: Fokus ke 2 produk utama\nAction items: Kirim proposal ke klien (Ali, 15 Mei)", '#dbeafe', false],
            [$dCat2->id, 'KPI Bulanan', "Leads masuk: 127 (target 100 ✅)\nKonversi: 23% (target 20% ✅)\nRevenue: 45jt (target 50jt ⚠️)\nSatisfaction: 4.3/5 ✅", '#fff7ed', false],
            [$dCat2->id, 'Tools Produktivitas Favorit', "• Notion – project management\n• Figma – desain UI\n• Slack – komunikasi tim\n• Toggl – time tracking\n• Loom – screen recording", '#ede9fe', true],
            [$dCat2->id, 'Agenda Rapat Besar 20 Mei', "09.00 Pembukaan & sambutan\n09.30 Presentasi divisi A\n10.30 Presentasi divisi B\n11.30 Sesi tanya jawab\n12.00 Makan siang\n13.00 Workshop & brainstorming\n16.00 Penutup", '#dcfce7', false],

            // ── Pribadi (11 notes) ──
            [$dCat3->id, 'Daftar Belanja Mingguan', "- Susu UHT full cream\n- Roti gandum\n- Telur 1 papan\n- Sayur bayam & kangkung\n- Buah apel & pisang\n- Yoghurt Greek\n- Teh celup", '#fce7f3', false],
            [$dCat3->id, 'Buku yang Ingin Dibaca', "1. Atomic Habits – James Clear\n2. The Psychology of Money\n3. Deep Work – Cal Newport\n4. Essentialism – Greg McKeown\n5. The Almanack of Naval Ravikant", '#ede9fe', false],
            [$dCat3->id, 'Resolusi Tahun Ini', "✅ Olahraga 3x seminggu\n✅ Kurangi kopi jadi 1 gelas/hari\n🔄 Baca 12 buku (5/12)\n⬜ Nabung 20% gaji tiap bulan\n⬜ Belajar skill baru", '#ecfdf5', true],
            [$dCat3->id, 'Tracker Olahraga Mei', "1 Mei – Lari 5km ✅\n3 Mei – Push up 3x30 ✅\n5 Mei – Lari 4km ✅\n7 Mei – Yoga 30 menit ✅\n9 Mei – Istirahat\n10 Mei – Renang 1 jam ✅", '#dbeafe', false],
            [$dCat3->id, 'Rencana Liburan Akhir Tahun', "Destinasi: Lombok\nDurasi: 5 hari 4 malam\nBudget: ~4 juta/orang\nMustdo: Gili Trawangan, Mandalika, Senggigi\nAkomodasi: Booking via Traveloka", '#ffedd5', false],
            [$dCat3->id, 'Target Keuangan', "Tabungan emergency: Rp 30 juta\nInvestasi reksa dana: Rp 5jt/bulan\nDP rumah: Rp 150 juta (2027)\nDana pendidikan anak: mulai 2026", '#dcfce7', false],
            [$dCat3->id, 'Kontak Darurat Keluarga', "Papa: 0812-xxx-0001\nMama: 0813-xxx-0002\nKakak: 0856-xxx-0003\nAdik: 0878-xxx-0004\nPaman: 0821-xxx-0005", '#fef3c7', false],
            [$dCat3->id, 'Menu Masakan Favorit', "Senin: Soto ayam\nSelasa: Nasi goreng\nRabu: Mie rebus telur\nKamis: Ayam goreng + lalapan\nJumat: Ikan bakar\nSabtu: Gado-gado\nMinggu: Masak bareng keluarga", '#fce7f3', false],
            [$dCat3->id, 'Anniversary Plans', "Tanggal: 3 September\nAktivitas: Dinner di restoran romantis\nHadiah: Watch (sudah dipesan)\nSurprise: Bunga + surat tulisan tangan", '#fae8ff', false],
            [$dCat3->id, 'Review Bulanan – April', "✅ Target tabungan tercapai\n✅ Olahraga 10x dari target 12x\n✅ Tidak ada hutang baru\n⚠️ Makan di luar overspend 200rb\n⬜ Belum mulai kursus bahasa Inggris", '#ecfdf5', false],
            [$dCat3->id, 'Playlist Belajar Fokus', "• Lo-fi Hip Hop Radio\n• Study with Me – Spotify\n• Hans Zimmer Collection\n• White Noise for Focus\n• Classical Study Music", '#ede9fe', false],

            // ── Ide (10 notes) ──
            [$dCat4->id, 'Ide Bisnis: Laundry Kiloan', 'Buka laundry kiloan dekat kos-kosan kampus. Modal awal ~5jt. Target BEP 6 bulan. Diferensiasi: ambil-antar + parfum premium.', '#fff7ed', false],
            [$dCat4->id, 'Konsep Aplikasi To-Do', "Fitur:\n- Dark mode\n- Reminder harian\n- Sync multi-device\n- Kategori warna\n- Widget homescreen", '#f0fdf4', false],
            [$dCat4->id, 'Ide Konten YouTube', "Channel: Tips produktivitas & keuangan\nVideo pertama: 'Setup workspace 2025'\nFrekuensi: 2x seminggu\nMonetisasi: Afiliasi + sponsorship", '#fef9c3', false],
            [$dCat4->id, 'Startup Idea: FoodPlanner', "Problem: Susah merencanakan menu & belanja\nSolusi: App meal planning + auto grocery list\nTarget: Ibu rumah tangga urban\nBM: Freemium + premium fitur", '#dbeafe', false],
            [$dCat4->id, 'Konsep Novel Pendek', "Genre: Fiksi kontemporer\nSeting: Jakarta 2035\nProtagonist: Data scientist yang menemukan anomali di sistem kota\nTema: Privasi vs kemudahan teknologi", '#fce7f3', false],
            [$dCat4->id, 'Ide Workshop: Ngoding Bareng', "Target peserta: SMA & mahasiswa semester 1-2\nMateri: HTML, CSS, JavaScript dasar\nDurasi: 2 hari (weekend)\nHarga: Rp 150rb (termasuk sertifikat)", '#dcfce7', false],
            [$dCat4->id, 'Side Project: Template CV', "Buat template CV premium berbasis Notion/Canva\nJual di Gumroad / Tokopedia\nHarga: 25rb-50rb\nVariant: Fresh graduate, Mid-level, Senior", '#ffedd5', false],
            [$dCat4->id, 'Ide Podcast: Cerita Karir', "Format: Interview 45-60 menit\nNarasumber: Profesional dari berbagai bidang\nTopik: Perjalanan karir, gagal, bangkit\nDistribusi: Spotify, YouTube, Apple Podcast", '#ede9fe', false],
            [$dCat4->id, 'NFT Art Concept', "Style: Flat illustration Indonesia culture\nSeri pertama: 10 karakter wayang modern\nPlatform: OpenSea / Raible\nCommunity: Discord + Twitter", '#e0f2fe', false],
            [$dCat4->id, 'Buka Toko Online Tanaman', "Niche: Tanaman hias indoor low maintenance\nPlatform: Instagram + Shopee\nProduk: Monstera, Pothos, Kaktus, Sukulen\nLayanan plus: konsultasi perawatan gratis", '#fae8ff', true],
        ]);

        // ─────────────────────────────────────────
        // 3. BUDI SANTOSO
        // ─────────────────────────────────────────
        $budi = User::create(['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'password' => Hash::make('budi123'), 'role' => 'user']);
        $bCat1 = Category::create(['user_id' => $budi->id, 'name' => 'Catatan', 'color' => '#FBBF24', 'order' => 0]);
        $bCat2 = Category::create(['user_id' => $budi->id, 'name' => 'Kuliah',  'color' => '#818CF8', 'order' => 1]);
        $bCat3 = Category::create(['user_id' => $budi->id, 'name' => 'Hobi',   'color' => '#FB923C', 'order' => 2]);
        $this->seedNotes($budi->id, [
            [$bCat1->id, 'Catatan Pertama', 'Mulai menggunakan CatatanKu untuk hidup lebih terorganisir!', '#fef9c3', false],
            [$bCat2->id, 'Jadwal Ujian Semester', "Senin 12 Mei – Kalkulus\nRabu 14 Mei – Fisika\nJumat 16 Mei – Kimia\nSenin 19 Mei – Pemrograman Web", '#dbeafe', true],
            [$bCat2->id, 'Tugas Menumpuk', "1. Makalah Sejarah (deadline 20 Mei)\n2. Praktikum Kimia\n3. Presentasi Kelompok\n4. Quiz online Matematika", '#fce7f3', false],
            [$bCat2->id, 'Referensi Jurnal TA', "- Jurnal A: Teknologi AI di Pendidikan (2023)\n- Jurnal B: Machine Learning Review (2024)\n- Sumber: Google Scholar, SINTA", '#ecfdf5', false],
            [$bCat3->id, 'Lagu Gitar Favorit', "1. Peterpan – Menunggumu\n2. Sheila on 7 – Sahabat Sejati\n3. Coldplay – The Scientist", '#ede9fe', false],
            [$bCat3->id, 'Gear Gaming', "Monitor: 144Hz 1080p\nKeyboard: Mechanical Brown Switch\nMouse: Wireless 16000 DPI\nHeadset: 7.1 Surround", '#e0f2fe', false],
            [$bCat3->id, 'Rencana Liburan Bali', "Hari 1: Pantai Kuta + Sunset\nHari 2: Ubud & Tegalalang\nHari 3: Nusa Penida\nBudget: ~2jt/orang", '#dcfce7', false],
        ]);

        // ─────────────────────────────────────────
        // 4. SITI RAHAYU
        // ─────────────────────────────────────────
        $siti = User::create(['name' => 'Siti Rahayu', 'email' => 'siti@example.com', 'password' => Hash::make('siti123'), 'role' => 'user']);
        $sCat1 = Category::create(['user_id' => $siti->id, 'name' => 'Catatan',  'color' => '#FBBF24', 'order' => 0]);
        $sCat2 = Category::create(['user_id' => $siti->id, 'name' => 'Resep',    'color' => '#F87171', 'order' => 1]);
        $sCat3 = Category::create(['user_id' => $siti->id, 'name' => 'Keuangan','color' => '#34D399', 'order' => 2]);
        $sCat4 = Category::create(['user_id' => $siti->id, 'name' => 'Wishlist', 'color' => '#A78BFA', 'order' => 3]);
        $this->seedNotes($siti->id, [
            [$sCat1->id, 'Halo CatatanKu!', 'App catatan yang simpel dan cantik. Siap produktif!', '#fef9c3', false],
            [$sCat2->id, 'Resep Nasi Goreng Spesial', "2 piring nasi, 3 siung bawang putih, 2 telur\nTumis bumbu, masukkan nasi, aduk rata.\nTambah kecap & saos tiram secukupnya.", '#ffedd5', true],
            [$sCat2->id, 'Resep Brownies Fudgy', "200g dark choco + 100g butter → lelehkan\n2 telur + 150g gula → kocok\nCampur + 100g terigu → Oven 180°C 25 menit", '#fce7f3', false],
            [$sCat2->id, 'Resep Es Dalgona', "2 sdm kopi + 2 sdm gula + 2 sdm air panas\nKocok hingga berbusa kental\nTuang di atas susu dingin", '#fef3c7', false],
            [$sCat3->id, 'Anggaran Bulanan', "Pemasukan: 5.000.000\nMakan: 1.200.000\nTransport: 400.000\nTabungan: 1.000.000\nSisa: 1.600.000", '#ecfdf5', true],
            [$sCat3->id, 'Utang Piutang', "Hutang ke Mama: 500rb\nPiutang dari Rina: 200rb\nCicilan HP: 350rb/bulan", '#e0f2fe', false],
            [$sCat4->id, 'Wishlist Skincare', "1. Sunscreen SPF50 Anessa\n2. Serum Vit C Skintific\n3. Toner BHA COSRX\n4. Moisturizer Cetaphil", '#fae8ff', false],
            [$sCat4->id, 'Wishlist Fashion', "- Kemeja flanel oversized\n- Celana wide leg\n- Sneakers putih\n- Tote bag kanvas", '#ede9fe', false],
        ]);

        // ─────────────────────────────────────────
        // 5. RIZKY PRATAMA
        // ─────────────────────────────────────────
        $rizky = User::create(['name' => 'Rizky Pratama', 'email' => 'rizky@example.com', 'password' => Hash::make('rizky123'), 'role' => 'user']);
        $rCat1 = Category::create(['user_id' => $rizky->id, 'name' => 'Catatan',   'color' => '#FBBF24', 'order' => 0]);
        $rCat2 = Category::create(['user_id' => $rizky->id, 'name' => 'Dev Notes', 'color' => '#6366F1', 'order' => 1]);
        $rCat3 = Category::create(['user_id' => $rizky->id, 'name' => 'Proyek',    'color' => '#14B8A6', 'order' => 2]);
        $this->seedNotes($rizky->id, [
            [$rCat1->id, 'Setup Environment', "☐ PHP 8.3\n☐ Composer\n☐ Node 20 LTS\n☐ MySQL 8\n☐ VS Code", '#fef9c3', false],
            [$rCat2->id, 'Laravel Tips', "- Eager loading: with()\n- N+1 problem → detect pakai Telescope\n- Scout = full-text search\n- Horizon = queue monitoring", '#dbeafe', true],
            [$rCat2->id, 'Git Workflow Tim', "main → production\ndevelop → staging\nfeature/xxx → PR ke develop", '#dcfce7', false],
            [$rCat2->id, 'Docker Compose', "services:\n  app:\n    build: .\n    ports: [\"8000:8000\"]\n  mysql:\n    image: mysql:8", '#fae8ff', false],
            [$rCat3->id, 'Proyek SIAKAD', "✅ Auth & Role\n✅ Data Master\n🔄 Modul Nilai (50%)\n⬜ Raport Generator\n⬜ Deploy VPS", '#ecfdf5', true],
            [$rCat3->id, 'Proyek E-Commerce', "⬜ Product catalog\n⬜ Cart & Checkout\n⬜ Payment Gateway\n⬜ Admin panel", '#ffedd5', false],
        ]);

        // ─────────────────────────────────────────
        // 6. DEWI ANGGRAINI
        // ─────────────────────────────────────────
        $dewi = User::create(['name' => 'Dewi Anggraini', 'email' => 'dewi@example.com', 'password' => Hash::make('dewi123'), 'role' => 'user']);
        $wCat1 = Category::create(['user_id' => $dewi->id, 'name' => 'Catatan',  'color' => '#FBBF24', 'order' => 0]);
        $wCat2 = Category::create(['user_id' => $dewi->id, 'name' => 'Bisnis',   'color' => '#F59E0B', 'order' => 1]);
        $wCat3 = Category::create(['user_id' => $dewi->id, 'name' => 'Motivasi', 'color' => '#EC4899', 'order' => 2]);
        $this->seedNotes($dewi->id, [
            [$wCat1->id, 'First Note!', 'Akhirnya punya app catatan yang keren. Mulai dari sini!', '#fef9c3', false],
            [$wCat2->id, 'Ide UMKM Online Shop', "Produk: Hampers & Gift Box\nTarget: Ibu 25-40 th\nPlatform: IG + Shopee\nModal: ~3 juta", '#fff7ed', true],
            [$wCat2->id, 'Strategi Konten IG', "- Post 1x/hari\n- Stories behind the scenes\n- Reels tutorial\n- Giveaway per 1k followers", '#dbeafe', false],
            [$wCat3->id, 'Quote Favorit', '"Sukses adalah jumlah dari usaha kecil yang diulang setiap hari." – R. Collier', '#fce7f3', true],
            [$wCat3->id, 'Affirmasi Pagi', "✨ Produktif dan fokus\n✨ Memberi nilai untuk orang lain\n✨ Satu langkah lebih dekat ke tujuan", '#ede9fe', false],
            [$wCat3->id, 'Goals 2025', "Q1: Bangun brand awareness\nQ2: Revenue 5jt/bulan\nQ3: Rekrut 1 karyawan\nQ4: Buka toko offline", '#ecfdf5', false],
        ]);
    }

    private function seedNotes(int $userId, array $notes): void
    {
        foreach ($notes as [$catId, $title, $desc, $color, $pinned]) {
            Note::create([
                'user_id'     => $userId,
                'category_id' => $catId,
                'title'       => $title,
                'description' => $desc,
                'color'       => $color,
                'is_pinned'   => $pinned,
                'is_archived' => false,
            ]);
        }
    }
}
