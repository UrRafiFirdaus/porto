# Web Portofolio Dinamis & CMS Admin (Laravel 10 + Livewire 3 + Tailwind CSS)

Aplikasi web portofolio pribadi lengkap dengan **Content Management System (CMS) Single-User Admin** yang dibangun menggunakan **Laravel 10**, **Livewire 3**, **Alpine.js**, dan **Tailwind CSS**.

---

## Fitur Utama

### 1. Autentikasi & Keamanan (Single-User Admin)
- **Halaman Login Khusus Tersembunyi**: Hanya dapat diakses melalui `/admin/login`.
- **Registrasi Publik Dinonaktifkan**: Fitur register Fortify dimatikan dan rute `/register` serta `/login` bawaan diblokir (`404 Not Found`).
- **Proteksi Middleware**: Seluruh halaman CMS admin dilindungi oleh middleware `auth` dan `level:1` (khusus administrator utama) serta rate-limiting pada percobaan login.

### 2. Halaman Utama / Landing Page Publik (`/`)
- **Desain Minimalis, Modern & Responsif**: Mendukung **Dark Mode & Light Mode** serta animasi transisi halus saat di-scroll (`IntersectionObserver` + Alpine.js).
- **Hero & Tentang Saya (About Me)**: Foto profil, status ketersediaan kerja (*Open to Work*), nama lengkap, profesi, tagline, bio, dan tombol **Unduh CV (PDF)**.
- **Tech Stack & Skills**: Dikelompokkan berdasarkan kategori lengkap dengan ikon Devicon atau logo kustom.
- **Experiences & Education**: Timeline kronologis untuk pengalaman kerja, magang, organisasi, dan riwayat pendidikan.
- **Showcase Projects**: Kartu proyek dengan thumbnail, deskripsi singkat, badge tech stack, tautan **Live Demo** dan **GitHub Repository** (atau penanda *Private Repo*).
- **Contact & Social Media**: Tautan langsung ke Email, LinkedIn, GitHub, Instagram, serta formulir kontak interaktif berbasis Livewire.

### 3. Dashboard Admin / CMS (`/admin/dashboard`)
- **Navigasi SPA-Like & Toast Notification**: Perpindahan menu instan menggunakan `wire:navigate`, notifikasi toast real-time, serta **live image preview** sebelum mengunggah foto profil maupun thumbnail proyek.
- **Manajemen Profil & General Settings (`/admin/profile`)**: Ubah foto profil, nama, profesi, bio, file CV PDF, tautan sosial media, serta email & password login admin.
- **Manajemen Projects (`/admin/projects`)**: CRUD lengkap proyek beserta toggle cepat status **Tampil / Sembunyi**.
- **Manajemen Experiences, Education & Tech Stack**: CRUD penuh seluruh konten tanpa perlu mengubah kode (*hardcode*).
- **Kotak Masuk Pengunjung (`/admin/messages`)**: Membaca dan membalas pesan yang dikirim pengunjung melalui formulir kontak landing page.

---

## Cara Menjalankan Project (Instalasi Lokal)

1. **Ekstrak file ZIP** ini ke folder project Anda (misal: `htdocs/porto` atau folder kerja Anda) dan masuk ke direktorinya:
   ```bash
   cd porto
   ```

2. **Install dependensi PHP melalui Composer**:
   ```bash
   composer install
   ```

3. **Konfigurasi Database di file `.env`**:
   - Buat database baru di MySQL/MariaDB dengan nama `porto_db` (atau sesuaikan dengan pengaturan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di file `.env`).
   - *(Opsional)* Jika ingin menggunakan SQLite agar lebih cepat tanpa MySQL, ubah `DB_CONNECTION=sqlite` pada `.env` dan buat file kosong `database/database.sqlite`.

4. **Jalankan Migrasi & Seeder Data Awal**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal Laravel**:
   ```bash
   php artisan serve
   ```

6. **Akses Aplikasi di Browser**:
   - **Landing Page Publik**: `http://127.0.0.1:8000`
   - **Halaman Login Admin**: `http://127.0.0.1:8000/admin/login`

---

## Kredensial Login Admin Default

- **URL Login**: `/admin/login`
- **Email**: `admin@porto.test`
- **Password**: `admin12345`

> *Segera ubah email dan kata sandi default melalui menu **Profil & General Settings** di dashboard admin setelah berhasil masuk.*
