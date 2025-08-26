# Portal Web Dinas Energi dan Sumber Daya Mineral (ESDM) Provinsi Sumatra Selatan

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20.svg?style=flat-square)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3.svg?style=flat-square)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC.svg?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-4479A1.svg?style=flat-square&logo=mysql&logoColor=white)

Ini adalah repositori kode sumber untuk portal web resmi Dinas ESDM Provinsi Sumatra Selatan. Aplikasi ini berfungsi sebagai platform informasi publik, sistem manajemen konten, dan portal layanan PPID (Pejabat Pengelola Informasi dan Dokumentasi).

## ✨ Fitur Utama

-   **Frontend Ganda**: Tampilan publik yang modern dengan Bootstrap 5 dan dasbor admin fungsional dengan Laravel Breeze (Tailwind CSS).
-   **Manajemen Konten (CMS)**: Modul CRUD yang komprehensif untuk Berita, Dokumen, Galeri, Pejabat, dan Halaman Statis.
-   **Sistem Layanan PPID**: Sistem berbasis login untuk publik mengajukan Permohonan Informasi dan Keberatan, lengkap dengan dasbor pengguna.
-   **Keamanan Berlapis**:
    -   Kontrol akses berbasis peran & **Laravel Policies**.
    -   Sanitasi input otomatis untuk mencegah serangan XSS menggunakan `mews/purifier`.
-   **Pencarian Cerdas**: Fungsionalitas pencarian *full-text* di seluruh situs menggunakan **Laravel Scout**.
-   **Kinerja Tinggi**:
    -   **Caching Halaman** otomatis di level Controller untuk mempercepat waktu muat.
    -   Sistem gambar "Anti-Gagal" dengan *placeholder* dan dukungan *fallback*.
-   **API Read-Only**: Menyediakan API komprehensif yang diamankan dengan **Laravel Sanctum**.
-   **Logging & Audit**: Mencatat semua aktivitas penting pengguna dan sistem menggunakan `spatie/laravel-activitylog`.

## 🛠️ Tumpukan Teknologi (Tech Stack)

| Komponen | Teknologi/Pustaka |
| :--- | :--- |
| **Framework Backend** | Laravel 10 |
| **Frontend Publik** | Bootstrap 5, SASS, Vite |
| **Frontend Admin** | Laravel Breeze, Tailwind CSS, Alpine.js, Vite |
| **Database** | MySQL |
| **Server-side Search** | Laravel Scout (Driver: Database) |
| **Asset Bundler** | Vite |

## 🚀 Instalasi & Setup Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan pengembangan lokal Anda.

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/hifni59/desdm-sumsel-portal.git
    cd desdm-sumsel-portal
    ```

2.  **Instal Dependensi:**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan:**
    -   Salin file `.env.example` menjadi `.env`.
        ```bash
        cp .env.example .env
        ```
    -   Hasilkan kunci aplikasi baru.
        ```bash
        php artisan key:generate
        ```
    -   Atur koneksi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD) di dalam file `.env`.

4.  **Migrasi & Seeding Database:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Buat Symbolic Link:**
    *Ini penting agar gambar yang diunggah dapat diakses dari web.*
    ```bash
    php artisan storage:link
    ```

6.  **Kompilasi Aset Frontend:**
    ```bash
    npm run dev
    ```

7.  **Jalankan Server Pengembangan:**
    ```bash
    php artisan serve
    ```

Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

---
