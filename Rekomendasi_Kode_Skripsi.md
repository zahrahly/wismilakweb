# Panduan Penulisan Kode Program (Bab Implementasi) untuk Skripsi

Dalam penulisan Bab Implementasi di skripsi, **tidak perlu** memasukkan seluruh kode program (karena akan memakan puluhan/ratusan halaman). Anda hanya perlu memasukkan **potongan kode (snippet) dari fitur-fitur utama (Core Features)**, logika bisnis yang kompleks, dan integrasi pihak ketiga.

Berikut adalah rekomendasi daftar kode program (berdasarkan arsitektur website Wismilak Anda) yang sangat bagus dan berbobot untuk dimasukkan ke dalam naskah skripsi:

---

### 1. Implementasi Keamanan & Akses Kontrol (Multi-Role)
Bagian ini menunjukkan bagaimana sistem membedakan hak akses antara Customer, Admin, Partner, dan Manager.

*   **Smart Dashboard Redirect**
    *   **Deskripsi:** Kode yang mengatur ke mana user diarahkan setelah login berdasarkan perannya (role).
    *   **Lokasi File:** `routes/web.php` (Bagian route `/dashboard` dengan fungsi `match`) atau Middleware terkait.
*   **Age Verification (Verifikasi Usia 21+)**
    *   **Deskripsi:** Middleware atau fungsi controller yang memblokir pengunjung di bawah umur untuk mengakses konten sensitif. Sangat krusial untuk website seperti Wismilak.
    *   **Lokasi File:** `app/Http/Controllers/AgeVerificationController.php` (Fungsi `verify`).

### 2. Integrasi Payment Gateway (Midtrans)
Ini adalah salah satu fitur paling bernilai (high-value) dalam skripsi IT karena menunjukkan kemampuan integrasi sistem eksternal (API).

*   **Generate Snap Token Pembayaran**
    *   **Deskripsi:** Kode saat customer mendaftar event dan sistem meminta token pembayaran ke API Midtrans.
    *   **Lokasi File:** `app/Http/Controllers/EventRegistrationController.php` (Fungsi `payment` / `store` saat generate transaksi).
*   **Penanganan Webhook (Midtrans Notification)**
    *   **Deskripsi:** Kode yang menerima callback dari Midtrans secara otomatis (di belakang layar) saat user selesai membayar, kemudian mengubah status registrasi menjadi 'Paid' dan men-generate tiket.
    *   **Lokasi File:** `app/Http/Controllers/MidtransNotificationController.php` (Fungsi `handleNotification`).

### 3. Logika Bisnis Utama (Core Business Logic)
Bagian ini menunjukkan seberapa baik Anda membangun alur pemrosesan data.

*   **Redeem Voucher & Sistem Poin**
    *   **Deskripsi:** Logika pengecekan validitas voucher (apakah masih aktif, kuota cukup, syarat terpenuhi), serta kalkulasi pemotongan poin/harga.
    *   **Lokasi File:** `app/Http/Controllers/Customer\DashboardController.php` (Fungsi `redeemVoucher`).
*   **Pembuatan E-Ticket (PDF Generation)**
    *   **Deskripsi:** Kode yang merender view menjadi format dokumen PDF (E-Ticket) secara dinamis lengkap dengan QR Code setelah pembayaran berhasil.
    *   **Lokasi File:** `app/Http/Controllers/Customer\DashboardController.php` (Fungsi `generateTicketPdf`).

### 4. Implementasi Fitur Event & Operasional
Fitur yang membedakan aplikasi ini dari sekadar aplikasi toko online biasa.

*   **Sistem Check-in via Scan QR Code**
    *   **Deskripsi:** Kode yang memproses hasil scan QR Code dari tiket peserta, memvalidasi apakah tiket asli dan belum digunakan.
    *   **Lokasi File:** `app/Http/Controllers/Admin/CheckinController.php` atau PartnerCheckin (Fungsi `process`).
*   **Real-time Live Chat Customer Service**
    *   **Deskripsi:** Menunjukkan kemampuan membuat komunikasi dua arah. Tampilkan potongan kode pengiriman pesan atau *fetching* pesan.
    *   **Lokasi File:** `app/Http/Controllers/LiveChatController.php` (Fungsi `sendMessage` / `fetchMessages`).

### 5. Pelaporan & Analisis Data (Reporting)
Menunjukkan bahwa sistem mampu mengolah banyak data menjadi informasi yang berguna untuk manajemen.

*   **Export Laporan Manager (PDF/CSV)**
    *   **Deskripsi:** Potongan kode (bisa query Eloquent ORM atau fungsi export) yang merekapitulasi pendapatan (revenue), penjualan tiket event, dan mengekspornya.
    *   **Lokasi File:** `app/Http/Controllers/Manager/ReportController.php` (Misalnya fungsi `exportTransactionsPdf`).

---

### 💡 Tips Menuliskan Kode di Naskah Skripsi:
1.  **Gunakan *Line Number*:** Tambahkan nomor baris pada setiap cuplikan kode agar mudah dijelaskan.
2.  **Fokus pada Logika:** Jangan tampilkan kode HTML/CSS/Blade yang terlalu panjang (kecuali membahas algoritma UI/UX). Fokus pada **Controller**, **Model**, atau **Middleware** (PHP).
3.  **Berikan Penjelasan Paragraf:** Setiap selesai menampilkan satu kotak *source code*, berikan paragraf yang menjelaskan alurnya secara bahasa manusia. Contoh: *"Pada baris ke 15-20, sistem melakukan pengecekan ke tabel voucher. Jika tanggal hari ini melebihi `valid_until`, maka sistem mengembalikan pesan error..."*
