# 🎪 House of Salbai — Event Logistics, Portfolio & Management System

<p align="left">
  <a href="https://houseofsalbai.kesug.com"><img src="https://img.shields.io/badge/Live%20Demo-houseofsalbai.kesug.com-10B981?style=for-the-badge&logo=googlechrome&logoColor=white" alt="Live Demo" /></a>
  <img src="https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Database-MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Frontend-Blade%20%7C%20Bootstrap%205-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5" />
  <img src="https://img.shields.io/badge/Security-RBAC%20%7C%20CSRF%20%7C%20SMTP-red?style=for-the-badge&logo=shield" alt="Security" />
</p>

> *"Wujudkan Event Impian Anda dengan Ekosistem Logistik & Dokumentasi Terintegrasi"*  
> Platform web komersial enterprise yang menggabungkan landing page interaktif bergaya obsidian modern, katalog logistik acara digital, galeri dokumentasi & video teaser portofolio, sistem digital manifest surat jalan, serta dashboard Content Management System (CMS) mandiri untuk vendor acara **House of Salbai (HOS)**.

🔗 **Live Website Demo:** [https://houseofsalbai.kesug.com](https://houseofsalbai.kesug.com)

---

## 📌 Ringkasan Proyek

**House of Salbai (HOS)** dikembangkan sebagai solusi digital menyeluruh (*end-to-end*) untuk industri operasional acara (*event organizer / event production*). Proyek ini dibangun dengan fokus pada **kecepatan muat tinggi, estetika visual obsidian glassmorphism, integrasi alur kerja logistik di lapangan, dan transparansi approval multi-role**.

### Kenapa Proyek Ini Dibangun?
1. **Pengalaman Klien yang Elegan & Interaktif**: Klien dapat mengeksplorasi inventaris peralatan (Sound System, Lighting, Stage, Rigging), melihat portofolio dokumentasi event terdahulu lengkap dengan video, dan melakukan konsultasi langsung ke WhatsApp representatif tanpa hambatan.
2. **Digitalisasi Logistik & Manifes Acara**: Menggantikan pencatatan manual surat jalan muatan barang (*Load-in / Load-out*) dengan fitur **Digital Manifest** yang siap dicetak rapi (*printable*) untuk bukti serah terima alat di lapangan.
3. **Approval Workflow & Multi-Role Security**: Pengajuan penambahan alat atau dokumentasi oleh staf lapangan (*Pegawai*) wajib divalidasi oleh *Administrator* sebelum dipublikasikan ke katalog umum.

---

## 🌟 Fitur Utama

### 1. Sisi Pengunjung / Klien (Public Facing)
* **Katalog Logistik Acara Interaktif**: Menampilkan daftar peralatan premium dengan kategori jelas (*Lighting, Audio, Visual, Stage & Rigging*), status ketersediaan, serta spesifikasi detail alat.
* **Galeri Dokumentasi & Video Teaser**: Dokumentasi portofolio acara masa lalu yang dilengkapi multi-upload foto beresolusi tinggi, navigasi slide/zoom, dan video teaser event.
* **Direct WhatsApp Consultation**: Tombol integrasi WhatsApp dinamis untuk mempermudah klien berkonsultasi mengenai ketersediaan dan penawaran paket acara.
* **Portal Admin Tersembunyi (Easter Egg)**: Pintu masuk login admin yang dirancang unik dan aman melalui *double-click* pada logo navbar atau kombinasi tombol keyboard `Ctrl + Alt + L`.
* **Desain Obsidian Dark Theme**: Tampilan responsif dengan perpaduan warna obsidian black, aksen emerald green, micro-animations (AOS), dan efek *particle canvas*.

### 2. Sisi Pengelola / Admin CMS (Dashboard Manajemen)
* **Manajemen Inventaris & Aset (CRUD)**:
  * Tambah alat baru lengkap dengan kategori, stok tersedia, kondisi fisik alat (*Baik/Perlu Servis*), dan foto pendukung.
  * Pembuatan **QR Code otomatis** untuk mempermudah audit fisik aset di gudang/lapangan.
* **Digital Manifest Logistik & Surat Jalan**:
  * Pencatatan nomor manifes, klien event, tanggal loading, crew chief penanggung jawab, dan daftar alat keluar-masuk.
  * Fitur **Printable Manifest** berformat resmi yang siap dicetak/disimpan sebagai PDF untuk kru lapangan.
* **Manajemen Dokumentasi & Album Acara**:
  * Pembuatan album event baru, pengaturan cover, upload multiple dokumentasi foto, dan video preview.
* **Sistem Approval Bertingkat (Workflow)**:
  * Meninjau pengajuan inventaris atau album dari staf lapangan dengan opsi *Approve* atau *Reject* disertai catatan alasan penolakan.
* **Content Management System (CMS Studio)**:
  * Pengaturan dinamis nama perusahaan, nomor kontak WhatsApp, tagline, deskripsi profil, dan hero banner tanpa mengubah kode sumber.
* **Statistik & Rekapitulasi**:
  * Pemantauan ringkas jumlah total aset, total event, status manifes berjalan (*Alat Diluar / Selesai*), dan data mitra vendor.

### 3. Aspek Keamanan & Rekayasa Perangkat Lunak
* **Environment Variables (`.env`)**: Kredensial rahasia database, APP_KEY, dan mailer dipisahkan dari repositori publik dan diamankan oleh `.gitignore`.
* **Role-Based Access Control (RBAC)**: Pemisahan hak akses yang tegas antara level **Administrator** (full control & approval) dan **Pegawai** (input operasional).
* **Reset Password via SMTP Gmail**: Fitur pemulihan kata sandi otomatis dengan pengiriman tautan token unik ke email pengguna.
* **Proteksi Akses Root & Server Hardening**: Konfigurasi file `.htaccess` yang memblokir akses publik langsung ke folder sistem (`.env`, `storage/`, `vendor/`, `database/`).
* **Proteksi CSRF & Sanitasi Data**: Setiap transaksi formulir dilindungi oleh token CSRF Laravel dan validasi request yang ketat.

---

## 🛠️ Tech Stack & Arsitektur

| Bagian | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | [Laravel 11 / 12](https://laravel.com) | Arsitektur MVC modern, Eloquent ORM, Service Providers, Middleware |
| **Bahasa Pemrograman**| PHP 8.3+ | Performa optimal dengan fitur pengetikan modern |
| **Database** | MySQL / MariaDB | Relasi tabel terstruktur, foreign key cascade, indexing performa |
| **Frontend UI** | Blade Engine, Bootstrap 5.3, Vanilla CSS | Obsidian dark design system, responsive flexbox & grid |
| **Library Interaktif** | FontAwesome 6, AOS (Animate On Scroll), Particles.js | Micro-interactions dan animasi visual modern |
| **Build Tools** | Vite 6 & Composer 2.x | Bundling aset statis cepat dan manajemen dependensi handal |
| **Layanan Eksternal** | WhatsApp Click-to-Chat API & SMTP Gmail | Integrasi pesan instan dan sistem pengiriman email transaksional |

---

## 🚀 Panduan Menjalankan di Server Lokal (Local Setup)

Bagi penguji (*recruiter* / *developer*) yang ingin menjalankan seluruh fitur aplikasi secara lokal, ikuti langkah berikut:

### 1. Prasyarat Sistem
* Terinstal **PHP >= 8.2 / 8.3** (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`).
* Terinstal **[Composer](https://getcomposer.org/)** (v2.x).
* Terinstal **[Node.js](https://nodejs.org/)** (v18+ atau v20+) & NPM.
* Database server MySQL aktif (via XAMPP, Laragon, atau Docker).

### 2. Clone Repositori
```bash
git clone https://github.com/tareqq23/house-of-salbai.git
cd house-of-salbai
```

### 3. Install Dependensi PHP & JavaScript
```bash
# Install paket backend
composer install

# Install paket frontend & compile aset
npm install
npm run build
```

### 4. Konfigurasi Environment (`.env`)
Salin file template `.env.example` menjadi `.env`:

* **Windows (PowerShell)**:
  ```powershell
  Copy-Item .env.example .env
  ```
* **macOS / Linux**:
  ```bash
  cp .env.example .env
  ```

Buka file `.env` dan sesuaikan koneksi database MySQL lokal Anda:
```env
APP_NAME="House of Salbai"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_hos
DB_USERNAME=root
DB_PASSWORD=
```
*(Buat database kosong bernama `db_hos` di phpMyAdmin / MySQL lokal Anda).*

### 5. Generate Key, Migrasi Database & Storage
Jalankan rangkaian perintah artisan berikut:
```bash
# Generate application encryption key
php artisan key:generate

# Eksekusi migrasi tabel dan data seeder default
php artisan migrate --seed

# Hubungkan symlink folder media upload
php artisan storage:link
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```

### 7. Akses Melalui Browser

* 🎪 **Halaman Utama (Klien / Publik)**:  
  Buka [http://localhost:8000](http://localhost:8000)

* 🔐 **Dashboard Admin CMS**:  
  Buka [http://localhost:8000/login](http://localhost:8000/login)  
  *(Atau klik ganda pada logo navbar / tekan shortcut `Ctrl + Alt + L` di halaman utama).*
  * **Username**: `admin`
  * **Password**: `password` *(atau `skripsi123`)*

---

## 📁 Struktur Direktori Proyek

```text
house-of-salbai/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # AdminController & logika bisnis operasional
│   │   └── Middleware/       # Proteksi autentikasi & session security
│   ├── Models/               # Model Eloquent (Inventory, Album, Manifest, Vendor, CMS)
│   └── Providers/            # AppServiceProvider & HTTPS forcing
│
├── bootstrap/
│   ├── app.php               # Konfigurasi middleware & routing aplikasi
│   └── providers.php         # Registrasi service provider
│
├── config/                   # Berkas konfigurasi framework Laravel
│
├── database/
│   ├── factories/            # Model data factory
│   ├── migrations/           # 19 skema tabel database relasional
│   ├── seeders/              # DatabaseSeeder akun administrator default
│   └── database_hos_infinityfree.sql # Backup skema SQL siap import
│
├── public/
│   ├── css/                  # Custom styling admin dan tema website
│   ├── img/                  # Asset visual statis & logo
│   ├── uploads/              # Direktori penyimpanan media (album & inventaris)
│   ├── index.php             # Front controller entrypoint
│   └── .htaccess             # Aturan rewrite Apache & hosting compatibility
│
├── resources/
│   ├── views/                # Template Blade (welcome, login, dashboard, print manifest)
│   ├── css/ & js/            # Source assets untuk Vite compiler
│
├── routes/
│   ├── web.php               # Rute publik, otentikasi, dan rute dashboard terlindungi
│   └── console.php           # Artisan command kustom
│
├── storage/                  # Direktori cache, session, dan compiled views
├── tests/                    # Feature & Unit test cases
├── usecase_images/           # Diagram use case pendukung dokumentasi teknis
│
├── .env.example              # Template variabel lingkungan aman
├── .gitignore                # Proteksi berkas sensitif dari repositori Git
├── composer.json             # Dependensi paket PHP
├── package.json              # Dependensi pustaka frontend NPM
├── vite.config.js            # Konfigurasi bundler Vite
└── README.md                 # Dokumentasi komprehensif proyek
```

---

## 📡 Rangkuman Rute & Arsitektur Sistem

Aplikasi dilengkapi dengan rute aplikasi dan RESTful-style controller yang terlindungi:

| Method | Endpoint | Fungsi | Hak Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/` | Menampilkan Landing Page publik, katalog, dan portofolio | Publik |
| `GET` | `/login` | Antarmuka autentikasi masuk pengelola | Publik |
| `POST`| `/login` | Proses verifikasi kredensial login pengguna | Publik |
| `POST`| `/logout` | Mengakhiri sesi aktif dan destroy session | 🔒 Terautentikasi |
| `GET` | `/forgot-password`| Formulir permohonan token reset kata sandi | Publik |
| `POST`| `/forgot-password`| Pengiriman link token reset sandi via SMTP Gmail | Publik |
| `GET` | `/reset-password/{token}` | Formulir pembaruan kata sandi baru | Publik |
| `POST`| `/reset-password` | Proses pembaruan kata sandi di database | Publik |
| `GET` | `/dashboard` | Dashboard utama statistik, approval, & manajemen data | 🔒 Admin / Pegawai |
| `POST`| `/admin/aset` | Menambahkan item aset / inventaris baru | 🔒 Admin / Pegawai |
| `POST`| `/admin/album` | Mengunggah album acara baru beserta media | 🔒 Admin / Pegawai |
| `POST`| `/admin/manifest` | Membuat dokumen surat jalan / manifes muatan baru | 🔒 Admin / Pegawai |
| `GET` | `/admin/manifest/{id}/print` | Menampilkan dokumen manifes dalam format siap cetak | 🔒 Admin / Pegawai |
| `POST`| `/admin/approval/{type}/{id}` | Menyetujui atau menolak pengajuan data staf | 🔒 Khusus Admin |
| `POST`| `/admin/cms` | Memperbarui teks, kontak, dan pengaturan tampilan situs | 🔒 Khusus Admin |

---

## 📍 Informasi Bisnis & Kontak

* **Perusahaan**: House of Salbai (HOS)
* **Spesialisasi**: *Premium Event Logistics, Sound System, Lighting & Event Documentation*
* **Pengembang**: Alif Wijaya
* **GitHub Profil**: [@tareqq23](https://github.com/tareqq23)
* **LinkedIn**: [Profil LinkedIn](https://www.linkedin.com) *(Update sesuai tautan Anda)*
* **Email Kontak**: alifwijaya03@gmail.com

---

## 📄 Lisensi & Hak Cipta

Hak Cipta © 2025–2026 **House of Salbai**. Semua hak dilindungi undang-undang.  
Didesain dan dikembangkan sebagai portofolio sistem manajemen logistik acara profesional.
