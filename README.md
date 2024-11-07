# Asset Management System

Asset Management System adalah aplikasi berbasis Laravel untuk manajemen aset perusahaan, dilengkapi dengan fitur pengelolaan data pengguna, data master aset, manajemen aset, dan transaksi aset. Aplikasi ini menyediakan alur kerja lengkap untuk mengelola aset mulai dari registrasi, pelacakan, hingga disposisi.

## Fitur Utama

### 1. **User Management**

-   **Data Roles**: Mengelola peran (roles) dengan akses dan hak berbeda.
-   **Data Users**: Mengelola pengguna dengan profil, autentikasi, dan otorisasi.

### 2. **Master Data**

Menyediakan data referensi yang penting untuk mendukung manajemen aset.

-   **Status Aset**: Mengelola status aset untuk penanda kondisi atau status.
-   **Kelas Aset (Class)**: Klasifikasi aset sesuai jenis atau kategori tertentu.
-   **Satuan Unit Aset (Unit of Measurement)**: Mengelola satuan unit seperti pcs, kg, dll.
-   **Departemen (Cost Center)**: Mengelola departemen yang bertanggung jawab atas aset.
-   **Penanggung Jawab (Person in Charge)**: Mengelola data penanggung jawab aset.
-   **Pengguna Aset (User)**: Mengelola data pengguna aset.
-   **Kategori Aset (Category)**: Mengelola kategori atau klasifikasi aset.
-   **Lokasi Aset (Location)**: Menentukan lokasi aset.
-   **Masa Garansi (Warranty)**: Mengatur informasi masa garansi untuk aset.

### 3. **Manajemen Asset**

Fitur inti untuk mencatat dan melacak aset fisik.

-   **Data Asset**: Merekam semua data penting terkait aset.
-   **QR Asset**: Menyediakan QR code untuk setiap aset, memudahkan pelacakan dan identifikasi.
-   **Historical Asset**: Melihat riwayat perubahan atau pergerakan aset.

### 4. **Transaksi Asset**

Menyediakan modul transaksi terkait perubahan status atau lokasi aset.

-   **Movement**: Melakukan pergerakan atau mutasi aset antar lokasi atau departemen.
-   **Disposal**: Melakukan penghapusan atau pelepasan aset yang sudah tidak digunakan.
-   **Reverse Disposal**: Mengembalikan aset yang sebelumnya telah didisposisi.

## Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/username/repo-name.git
    cd repo-name
    ```

2. **Instal Dependensi**

    ```bash
    composer install
    npm install && npm run dev
    ```

3. **Konfigurasi Environment**

    Salin file `.env.example` menjadi `.env` dan lakukan pengaturan database.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Migrasi Database**

    ```bash
    php artisan migrate --seed
    ```

5. **Jalankan Server Lokal**

    ```bash
    php artisan serve
    ```

6. **Akses Aplikasi**

    Buka [http://localhost:8000](http://localhost:8000) di browser Anda.

## Kontribusi

Kami menyambut kontribusi dari siapa saja yang ingin mengembangkan proyek ini lebih lanjut. Silakan ikuti langkah berikut untuk memulai:

1. Fork repository ini.
2. Buat branch untuk fitur yang ingin Anda tambahkan (`git checkout -b feature-name`).
3. Commit perubahan Anda (`git commit -m 'Add feature name'`).
4. Push ke branch (`git push origin feature-name`).
5. Buat Pull Request ke branch `main`.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

**Asset Management System** adalah solusi berbasis Laravel yang memudahkan pengelolaan aset perusahaan. Kami berharap proyek ini dapat membantu Anda dalam mengelola aset secara efisien.
