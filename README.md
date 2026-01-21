# Jejak Kebaikan - Platform Crowdfunding & Donasi Digital

[![Laravel](https://img.shields.io/badge/Laravel-11.x/12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Category](https://img.shields.io/badge/Category-Social_Engineering-green?style=for-the-badge)](https://github.com/AdhyDa/Jejakkebaikan)

**Jejak Kebaikan** adalah platform *crowdfunding* berbasis web yang dirancang untuk menjembatani antara para donatur dengan kampanye sosial, kemanusiaan, dan pembangunan. Proyek ini dikembangkan sebagai bagian dari tugas *Software Engineering* untuk menciptakan solusi teknologi yang transparan dan mudah diakses bagi kegiatan filantropi.

## 🌟 Fitur Utama

- **Eksplorasi Kampanye:** Pengguna dapat melihat daftar berbagai kategori kampanye (Bencana Alam, Pendidikan, Kesehatan, Pembangunan, dll).
- **Sistem Donasi Transparan:** Fitur untuk melakukan donasi secara digital dengan pencatatan otomatis.
- **Progress Tracking:** Menampilkan persentase pencapaian dana yang terkumpul secara *real-time* dibandingkan dengan target kampanye.
- **Manajemen Kampanye (Admin):** Dasbor khusus bagi pengelola untuk memvalidasi kampanye, memantau riwayat transaksi, dan mengelola data donatur.
- **Otentikasi Pengguna:** Sistem login dan registrasi yang aman untuk donatur maupun penggalang dana.

## 🛠️ Tech Stack

- **Framework Utama:** [Laravel](https://laravel.com) (PHP)
- **Frontend:** [Blade Templating](https://laravel.com/docs/blade) & [Tailwind CSS](https://tailwindcss.com)
- **Database:** MySQL
- **Tooling:** Vite, Composer, NPM
- **Integration (Opsional):** Midtrans/Payment Gateway (jika diaktifkan)

## 📂 Struktur Folder Utama

- `app/Models` - Definisi skema untuk Kampanye, Donasi, dan User.
- `app/Http/Controllers` - Logika pemrosesan donasi dan manajemen konten.
- `resources/views` - Antarmuka pengguna (Landing page, List kampanye, Dashboard).
- `database/migrations` - Struktur tabel untuk database crowdfunding.

## 💻 Cara Menjalankan di Lokal

1. **Clone Repositori:**
   ```bash
   git clone [https://github.com/AdhyDa/Jejakkebaikan.git](https://github.com/AdhyDa/Jejakkebaikan.git)
   cd Jejakkebaikan

2.  **Konfigurasi Environment:**
      ```bash
        cp .env.example .env
        php artisan key:generate

3.  **Clone Repositori:**
      ```bash
       git clone [https://github.com/AdhyDa/Jejakkebaikan.git](https://github.com/AdhyDa/Jejakkebaikan.git)
       cd Jejakkebaikan

4.  **Migrasi Database & Seeding:**
      ```bash
       php artisan migrate --seed

5.  **Jalankan Aplikasi:**
      ```bash
       php artisan serve

## 🤝 Kontribusi
Proyek ini terbuka untuk dikembangkan lebih lanjut. Jika Anda menemukan bug atau memiliki ide fitur baru, jangan ragu untuk membuka Issue atau mengirimkan Pull Request.

## 📄 Lisensi
Proyek ini berada di bawah lisensi MIT License.
Proyek ini dikembangkan oleh Adhyaksa Daudi - Mahasiswa Teknik Informatika, Universitas Negeri Malang.
