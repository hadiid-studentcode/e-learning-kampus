# E-Learning Kampus

Ini adalah backend API untuk aplikasi E-Learning Kampus yang dibangun menggunakan Laravel. Aplikasi ini menyediakan fungsionalitas untuk autentikasi, manajemen mata kuliah, materi, tugas, diskusi, dan laporan statistik untuk dua peran utama: **Dosen** dan **Mahasiswa**.

## Prasyarat

- PHP >= 8.1
- Composer
- MySQL 
- Laravel

## Cara Instalasi & Setup

1.  **Clone repository ini:**
    ```bash
    git clone https://github.com/hadiid-studentcode/e-learning-kampus.git
    cd e-learning-kampus
    ```

2.  **Install dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Setup file environment:**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Jalankan migrasi database:**
    Perintah ini akan membuat semua tabel yang diperlukan dalam database Anda.
    ```bash
    php artisan migrate
    ```

5.  **Buat symbolic link untuk storage:**
    Agar file yang di-upload bisa diakses secara publik.
    ```bash
    php artisan storage:link
    ```

6.  **Jalankan server pengembangan:**
    ```bash
    php artisan serve
    ```
    API sekarang akan berjalan di `http://127.0.0.1:8000`.

---

## Dokumentasi Endpoint API

Semua endpoint memerlukan header `Accept: application/json`. Endpoint yang memerlukan autentikasi harus menyertakan token Sanctum di header `Authorization: Bearer <TOKEN>`.

### 1. Autentikasi

| Method | Endpoint | Deskripsi | Body Request |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Registrasi user baru. | `name`, `email`, `password`, `password_confirmation`, `role` ('mahasiswa' atau 'dosen') |
| `POST` | `/api/login` | Login user & mendapatkan token. | `email`, `password` |
| `POST` | `/api/logout` | Logout & menghapus token. | (Kosong) - *Memerlukan Autentikasi* |

### 2. Manajemen Mata Kuliah

| Method | Endpoint | Deskripsi | Otorisasi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/courses` | Menampilkan semua mata kuliah. | Mahasiswa & Dosen |
| `POST` | `/api/courses` | Menambah mata kuliah baru. | Dosen |
| `PUT` | `/api/courses/{course}` | Mengedit detail mata kuliah. | Dosen (Pemilik) |
| `DELETE` | `/api/courses/{course}` | Menghapus mata kuliah. | Dosen (Pemilik) |
| `POST` | `/api/courses/{id}/enroll` | Mendaftarkan diri ke mata kuliah. | Mahasiswa |

### 3. Materi Perkuliahan

| Method | Endpoint | Deskripsi | Otorisasi |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/materials` | Mengunggah file materi baru. | Dosen |
| `POST`* | `/api/materials/{id}/download` | Mengunduh file materi. | Mahasiswa (Terdaftar) |

*\*Catatan: Method `GET` lebih konvensional untuk endpoint download.*

### 4. Tugas & Penilaian

| Method | Endpoint | Deskripsi | Otorisasi |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/assignments` | Membuat tugas baru. | Dosen |
| `POST` | `/api/submissions` | Mengunggah file jawaban tugas. | Mahasiswa |
| `POST` | `/api/submissions/{id}/grade` | Memberi nilai pada jawaban. | Dosen |

### 5. Forum Diskusi

| Method | Endpoint | Deskripsi | Otorisasi |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/discussions` | Membuat topik diskusi baru. | Mahasiswa & Dosen |
| `POST` | `/api/discussions/{id}/replies`| Membalas sebuah diskusi. | Mahasiswa & Dosen |

### 6. Laporan & Statistik

| Method | Endpoint | Deskripsi | Otorisasi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/reports/courses` | Statistik jumlah mahasiswa per mata kuliah. | Dosen |
| `GET` | `/api/reports/assignments`| Statistik tugas yang sudah/belum dinilai. | Dosen |
| `GET` | `/api/reports/students/{id}`| Statistik tugas & nilai per mahasiswa. | Dosen & Mahasiswa (Hanya data sendiri) |