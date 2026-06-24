# Dokumen Blackbox Testing - Website Wismilak

Dokumen ini berisi pengujian fungsional (Blackbox Testing) secara mendetail untuk keseluruhan sistem website, mencakup seluruh peran dan fungsionalitas sistem.

---

### A. Verifikasi Usia

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| A-01 | Akses halaman verifikasi usia | Halaman verifikasi usia ditampilkan | Halaman verifikasi usia ditampilkan | Sukses |
| A-02 | Verifikasi usia berhasil (≥21) | Redirect ke halaman Home, session age_verified tersimpan | Redirect ke halaman Home, session age_verified tersimpan | Sukses |
| A-03 | Verifikasi usia gagal (<21) | Redirect ke google.com | Redirect ke google.com | Sukses |

---

### B. Autentikasi - B1. Registrasi

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| B-01 | Registrasi dengan data valid | Akun terbuat, auto-login, redirect ke dashboard | Akun terbuat, auto-login, redirect ke dashboard | Sukses |
| B-02 | Registrasi dengan email duplikat | Pesan error "email has already been taken" | Pesan error "email has already been taken" | Sukses |
| B-03 | Registrasi tanpa nama | Validasi error "name is required" | Validasi error "name is required" | Sukses |
| B-04 | Registrasi tanpa email | Validasi error "email is required" | Validasi error "email is required" | Sukses |
| B-05 | Registrasi password tidak cocok | Validasi error "password confirmation does not match" | Validasi error "password confirmation does not match" | Sukses |
| B-06 | Registrasi tanpa accept terms | Validasi error "You must accept the terms" | Validasi error "You must accept the terms" | Sukses |
| B-07 | Registrasi usia < 21 tahun | Validasi error "You must be at least 21 years old" | Validasi error "You must be at least 21 years old" | Sukses |

---

### B. Autentikasi - B2. Login

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| B-08 | Login dengan kredensial valid | Login berhasil, redirect ke dashboard sesuai role | Login berhasil, redirect ke dashboard sesuai role | Sukses |
| B-09 | Login dengan password salah | Pesan error autentikasi gagal | Pesan error autentikasi gagal | Sukses |
| B-10 | Login dengan email tidak terdaftar | Pesan error autentikasi gagal | Pesan error autentikasi gagal | Sukses |
| B-11 | Smart redirect berdasarkan role | Redirect ke dashboard masing-masing role | Redirect ke dashboard masing-masing role | Sukses |

---

### B. Autentikasi - B3. Logout & Password

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| B-12 | Logout | Session dihapus, redirect ke halaman utama | Session dihapus, redirect ke halaman utama | Sukses |
| B-13 | Forgot password | Email reset password terkirim | Email reset password terkirim | Sukses |
| B-14 | Reset password dengan token valid | Password berhasil diubah | Password berhasil diubah | Sukses |

---

### C. Halaman Publik

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| C-01 | Akses halaman Home | Halaman home ditampilkan dengan konten lengkap | Halaman home ditampilkan dengan konten lengkap | Sukses |
| C-02 | Akses halaman About | Halaman about ditampilkan | Halaman about ditampilkan | Sukses |
| C-03 | Lihat daftar produk | Daftar produk ditampilkan | Daftar produk ditampilkan | Sukses |
| C-04 | Lihat detail produk | Halaman detail produk ditampilkan | Halaman detail produk ditampilkan | Sukses |
| C-05 | Lihat daftar outlet | Daftar outlet ditampilkan | Daftar outlet ditampilkan | Sukses |
| C-06 | Lihat detail outlet | Halaman detail outlet ditampilkan | Halaman detail outlet ditampilkan | Sukses |
| C-07 | Lihat daftar pressroom/berita | Daftar artikel pressroom ditampilkan | Daftar artikel pressroom ditampilkan | Sukses |
| C-08 | Lihat detail artikel pressroom | Halaman detail artikel ditampilkan | Halaman detail artikel ditampilkan | Sukses |
| C-09 | Kirim media inquiry | Inquiry terkirim, pesan sukses ditampilkan | Inquiry terkirim, pesan sukses ditampilkan | Sukses |
| C-10 | Lihat daftar event publik | Daftar event publik ditampilkan | Daftar event publik ditampilkan | Sukses |
| C-11 | Lihat detail event | Halaman detail event ditampilkan | Halaman detail event ditampilkan | Sukses |

---

### D. Fitur Customer - D1. Dashboard

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-01 | Akses dashboard customer | Dashboard ditampilkan dengan statistik poin, event, voucher | Dashboard ditampilkan dengan statistik poin, event, voucher | Sukses |
| D-02 | Lihat riwayat event | Menampilkan 5 event terakhir yang sudah dibayar | Menampilkan 5 event terakhir yang sudah dibayar | Sukses |

---

### D. Fitur Customer - D2. Registrasi Event

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-03 | Registrasi event dengan data valid | Registrasi berhasil, redirect ke halaman pembayaran | Registrasi berhasil, redirect ke halaman pembayaran | Sukses |
| D-04 | Registrasi event tanpa KTP | Validasi error "ktp_number is required" | Validasi error "ktp_number is required" | Sukses |
| D-05 | Registrasi event KTP bukan 16 digit | Validasi error "ktp_number must be 16 digits" | Validasi error "ktp_number must be 16 digits" | Sukses |
| D-06 | Registrasi event peserta usia < 21 | Validasi error "must be at least 21 years old" | Validasi error "must be at least 21 years old" | Sukses |
| D-07 | Registrasi event yang sudah full | Error "Event is sold out" | Error "Event is sold out" | Sukses |
| D-08 | Registrasi event yang sudah lewat | Error "Event sudah berakhir" | Error "Event sudah berakhir" | Sukses |
| D-09 | Registrasi duplikat (sudah paid) | Error "You already registered for this event" | Error "You already registered for this event" | Sukses |
| D-10 | Registrasi dengan voucher valid | Diskon diterapkan ke total pembayaran | Diskon diterapkan ke total pembayaran | Sukses |
| D-11 | Registrasi dengan voucher invalid | Error "Invalid or already used voucher code" | Error "Invalid or already used voucher code" | Sukses |
| D-12 | Registrasi event gratis | Registrasi langsung berhasil, tiket di-generate, poin ditambah | Registrasi langsung berhasil, tiket di-generate, poin ditambah | Sukses |

---

### D. Fitur Customer - D3. Pembayaran (Midtrans)

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-13 | Halaman pembayaran ditampilkan | Snap token Midtrans ditampilkan, detail pembayaran muncul | Snap token Midtrans ditampilkan, detail pembayaran muncul | Sukses |
| D-14 | Pembayaran berhasil via Midtrans | Status berubah ke "paid", tiket di-generate, redirect ke transaksi | Status berubah ke "paid", tiket di-generate, redirect ke transaksi | Sukses |
| D-15 | Akses payment milik user lain | Error 403 Forbidden | Error 403 Forbidden | Sukses |
| D-16 | Webhook Midtrans notification | Registrasi di-update ke paid, tiket di-generate, voucher ditandai used | Registrasi di-update ke paid, tiket di-generate, voucher ditandai used | Sukses |

---

### D. Fitur Customer - D4. Tiket & Transaksi

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-17 | Download tiket PDF | File PDF tiket ter-download | File PDF tiket ter-download | Sukses |
| D-18 | Download tiket PDF milik user lain | Error 403 Forbidden | Error 403 Forbidden | Sukses |
| D-19 | Verifikasi tiket via URL | Halaman verifikasi tiket ditampilkan | Halaman verifikasi tiket ditampilkan | Sukses |
| D-20 | Verifikasi tiket invalid | Pesan "Ticket invalid" | Pesan "Ticket invalid" | Sukses |
| D-21 | Lihat daftar transaksi | Daftar transaksi ditampilkan | Daftar transaksi ditampilkan | Sukses |
| D-22 | Lihat detail transaksi | Detail transaksi ditampilkan | Detail transaksi ditampilkan | Sukses |

---

### D. Fitur Customer - D5. Voucher & Poin

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-23 | Redeem voucher berhasil | Voucher ditukar, poin berkurang | Voucher ditukar, poin berkurang | Sukses |
| D-24 | Redeem voucher poin tidak cukup | Error "Poin Anda tidak cukup" | Error "Poin Anda tidak cukup" | Sukses |
| D-25 | Redeem voucher tidak aktif | Error "Voucher tidak tersedia" | Error "Voucher tidak tersedia" | Sukses |
| D-26 | Lihat daftar voucher saya | Daftar voucher user ditampilkan | Daftar voucher user ditampilkan | Sukses |
| D-27 | Lihat riwayat poin | Riwayat earn & spend poin ditampilkan | Riwayat earn & spend poin ditampilkan | Sukses |

---

### D. Fitur Customer - D6. Feedback

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-28 | Beri feedback setelah check-in | Feedback tersimpan, poin diberikan | Feedback tersimpan, poin diberikan | Sukses |
| D-29 | Feedback tanpa check-in | Error "Feedback hanya tersedia setelah check-in" | Error "Feedback hanya tersedia setelah check-in" | Sukses |
| D-30 | Feedback tanpa registrasi | Error "Anda belum terdaftar di event ini" | Error "Anda belum terdaftar di event ini" | Sukses |
| D-31 | Feedback duplikat | Error "Anda sudah memberi feedback" | Error "Anda sudah memberi feedback" | Sukses |
| D-32 | Edit feedback | Feedback berhasil diperbarui | Feedback berhasil diperbarui | Sukses |
| D-33 | Lihat riwayat feedback | Daftar feedback ditampilkan | Daftar feedback ditampilkan | Sukses |

---

### D. Fitur Customer - D7. Live Chat

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-34 | Mulai sesi chat | Sesi chat baru dibuat | Sesi chat baru dibuat | Sukses |
| D-35 | Kirim pesan chat | Pesan terkirim dan ditampilkan | Pesan terkirim dan ditampilkan | Sukses |
| D-36 | Request admin di chat | Request dikirim ke admin | Request dikirim ke admin | Sukses |

---

### D. Fitur Customer - D8. Profil

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| D-37 | Update profil berhasil | Profil berhasil diperbarui | Profil berhasil diperbarui | Sukses |
| D-38 | Update profil email duplikat | Validasi error "email has already been taken" | Validasi error "email has already been taken" | Sukses |
| D-39 | Ubah password berhasil | Password berhasil diubah | Password berhasil diubah | Sukses |
| D-40 | Ubah password - current salah | Validasi error current_password salah | Validasi error current_password salah | Sukses |

---

### E. Fitur Partner

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| E-01 | Akses dashboard partner | Dashboard partner dengan statistik ditampilkan | Dashboard partner dengan statistik ditampilkan | Sukses |
| E-02 | Buat event baru (draft) | Event tersimpan sebagai draft | Event tersimpan sebagai draft | Sukses |
| E-03 | Buat event tanpa judul | Validasi error "title is required" | Validasi error "title is required" | Sukses |
| E-04 | Buat event tanggal lampau | Validasi error "date must be after today" | Validasi error "date must be after today" | Sukses |
| E-05 | Edit event draft | Event berhasil diperbarui | Event berhasil diperbarui | Sukses |
| E-06 | Edit event yang sudah diajukan | Error "Event yang sudah diajukan tidak bisa diedit" | Error "Event yang sudah diajukan tidak bisa diedit" | Sukses |
| E-07 | Submit event untuk approval | Status berubah ke pending, menunggu approval admin | Status berubah ke pending, menunggu approval admin | Sukses |
| E-08 | Resubmit event rejected | Event diajukan ulang untuk review | Event diajukan ulang untuk review | Sukses |
| E-09 | Lihat peserta event | Daftar peserta (paid) ditampilkan | Daftar peserta (paid) ditampilkan | Sukses |
| E-10 | Lihat feedback event | Daftar feedback dengan statistik ditampilkan | Daftar feedback dengan statistik ditampilkan | Sukses |
| E-11 | Akses event milik partner lain | Error 403 Forbidden | Error 403 Forbidden | Sukses |
| E-12 | Export laporan event PDF | File PDF laporan ter-download | File PDF laporan ter-download | Sukses |
| E-13 | Export laporan event CSV | File CSV laporan ter-download | File CSV laporan ter-download | Sukses |
| E-14 | QR Check-in scan | Halaman scanner QR ditampilkan | Halaman scanner QR ditampilkan | Sukses |
| E-15 | Proses check-in | Check-in berhasil diproses | Check-in berhasil diproses | Sukses |

---

### F. Fitur Admin - F1. Dashboard & Event

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-01 | Akses dashboard admin | Dashboard admin dengan statistik ditampilkan | Dashboard admin dengan statistik ditampilkan | Sukses |
| F-02 | Lihat daftar event | Semua event ditampilkan dengan jumlah tiket terjual | Semua event ditampilkan dengan jumlah tiket terjual | Sukses |
| F-03 | Tambah event baru | Event berhasil ditambahkan | Event berhasil ditambahkan | Sukses |
| F-04 | Edit event | Event berhasil diperbarui | Event berhasil diperbarui | Sukses |
| F-05 | Hapus event | Event berhasil dihapus | Event berhasil dihapus | Sukses |

---

### F. Fitur Admin - F2. Verifikasi Event

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-06 | Lihat daftar event pending | Event dengan status pending ditampilkan | Event dengan status pending ditampilkan | Sukses |
| F-07 | Approve event | Event status berubah ke verified | Event status berubah ke verified | Sukses |
| F-08 | Reject event | Event status berubah ke rejected | Event status berubah ke rejected | Sukses |
| F-09 | Publish event | Event status berubah ke published | Event status berubah ke published | Sukses |
| F-10 | Lihat detail event verifikasi | Detail event ditampilkan | Detail event ditampilkan | Sukses |

---

### F. Fitur Admin - F3. Peserta Event & Check-in

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-11 | Lihat daftar peserta per event | Daftar peserta ditampilkan | Daftar peserta ditampilkan | Sukses |
| F-12 | Lihat detail peserta | Detail peserta & tiket ditampilkan | Detail peserta & tiket ditampilkan | Sukses |
| F-13 | Download tiket peserta | PDF tiket ter-download | PDF tiket ter-download | Sukses |
| F-14 | Admin QR check-in | Check-in berhasil | Check-in berhasil | Sukses |

---

### F. Fitur Admin - F4. Kelola Produk, Gallery, Pressroom

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-15 | CRUD Produk - Tambah | Produk berhasil ditambahkan | Produk berhasil ditambahkan | Sukses |
| F-16 | CRUD Produk - Edit | Produk berhasil diperbarui | Produk berhasil diperbarui | Sukses |
| F-17 | CRUD Produk - Hapus | Produk berhasil dihapus | Produk berhasil dihapus | Sukses |
| F-18 | CRUD Gallery - Tambah | Gallery berhasil ditambahkan | Gallery berhasil ditambahkan | Sukses |
| F-19 | CRUD Gallery - Hapus | Gallery berhasil dihapus | Gallery berhasil dihapus | Sukses |
| F-20 | CRUD Pressroom - Tambah | Artikel berhasil ditambahkan | Artikel berhasil ditambahkan | Sukses |
| F-21 | CRUD Pressroom - Edit | Artikel berhasil diperbarui | Artikel berhasil diperbarui | Sukses |
| F-22 | CRUD Pressroom - Hapus | Artikel berhasil dihapus | Artikel berhasil dihapus | Sukses |

---

### F. Fitur Admin - F5. Kelola Outlet

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-23 | CRUD Outlet - Tambah | Outlet berhasil ditambahkan | Outlet berhasil ditambahkan | Sukses |
| F-24 | CRUD Outlet - Edit | Outlet berhasil diperbarui | Outlet berhasil diperbarui | Sukses |
| F-25 | CRUD Outlet - Hapus | Outlet berhasil dihapus | Outlet berhasil dihapus | Sukses |
| F-26 | Toggle status outlet | Status outlet berubah (active/inactive) | Status outlet berubah (active/inactive) | Sukses |
| F-27 | Assign partner ke outlet | Partner berhasil di-assign | Partner berhasil di-assign | Sukses |
| F-28 | Kelola produk outlet | Produk outlet berhasil diperbarui | Produk outlet berhasil diperbarui | Sukses |

---

### F. Fitur Admin - F6. Kelola User

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-29 | Lihat daftar user | Daftar user ditampilkan | Daftar user ditampilkan | Sukses |
| F-30 | Tambah user baru | User berhasil ditambahkan | User berhasil ditambahkan | Sukses |
| F-31 | Edit user | User berhasil diperbarui | User berhasil diperbarui | Sukses |
| F-32 | Toggle status user | Status user berubah (active/inactive) | Status user berubah (active/inactive) | Sukses |

---

### F. Fitur Admin - F7. Voucher

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-33 | Tambah voucher | Voucher berhasil dibuat dengan kode auto-generate | Voucher berhasil dibuat dengan kode auto-generate | Sukses |
| F-34 | Tambah voucher valid_until < valid_from | Validasi error "must be after or equal valid_from" | Validasi error "must be after or equal valid_from" | Sukses |
| F-35 | Edit voucher | Voucher berhasil diperbarui | Voucher berhasil diperbarui | Sukses |
| F-36 | Hapus voucher | Voucher berhasil dihapus | Voucher berhasil dihapus | Sukses |

---

### F. Fitur Admin - F8. Poin & Reward

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-37 | Lihat daftar poin user | Daftar user dengan poin ditampilkan | Daftar user dengan poin ditampilkan | Sukses |
| F-38 | Lihat detail poin user | Detail riwayat poin ditampilkan | Detail riwayat poin ditampilkan | Sukses |
| F-39 | CRUD Reward - Tambah | Reward berhasil ditambahkan | Reward berhasil ditambahkan | Sukses |
| F-40 | CRUD Reward - Edit | Reward berhasil diperbarui | Reward berhasil diperbarui | Sukses |
| F-41 | Toggle status reward | Status reward berubah | Status reward berubah | Sukses |
| F-42 | Lihat redemptions | Daftar redemption ditampilkan | Daftar redemption ditampilkan | Sukses |

---

### F. Fitur Admin - F9. Live Chat & Feedback

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-43 | Lihat daftar chat sessions | Daftar sesi chat ditampilkan | Daftar sesi chat ditampilkan | Sukses |
| F-44 | Balas chat customer | Reply terkirim | Reply terkirim | Sukses |
| F-45 | Tutup sesi chat | Sesi chat ditutup | Sesi chat ditutup | Sukses |
| F-46 | Lihat analytics chat | Statistik chat ditampilkan | Statistik chat ditampilkan | Sukses |
| F-47 | Kelola chat topics | Topic berhasil dikelola | Topic berhasil dikelola | Sukses |
| F-48 | Seed default chat topics | Topic default berhasil dibuat | Topic default berhasil dibuat | Sukses |
| F-49 | Lihat daftar feedback | Daftar feedback ditampilkan | Daftar feedback ditampilkan | Sukses |
| F-50 | Lihat detail feedback | Detail feedback ditampilkan | Detail feedback ditampilkan | Sukses |

---

### F. Fitur Admin - F10. Media Inquiry, Instagram, Pages

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| F-51 | Lihat media inquiries | Daftar inquiry ditampilkan | Daftar inquiry ditampilkan | Sukses |
| F-52 | Reply media inquiry | Balasan terkirim | Balasan terkirim | Sukses |
| F-53 | Hapus media inquiry | Inquiry berhasil dihapus | Inquiry berhasil dihapus | Sukses |
| F-54 | CRUD Instagram post | Post berhasil dikelola | Post berhasil dikelola | Sukses |
| F-55 | CRUD Pages | Halaman berhasil dikelola | Halaman berhasil dikelola | Sukses |

---

### G. Fitur Manager

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| G-01 | Akses dashboard manager | Dashboard manager dengan statistik ditampilkan | Dashboard manager dengan statistik ditampilkan | Sukses |
| G-02 | Lihat laporan event | Daftar event dengan data lengkap | Daftar event dengan data lengkap | Sukses |
| G-03 | Export event PDF | File PDF laporan event ter-download | File PDF laporan event ter-download | Sukses |
| G-04 | Export event CSV | File CSV laporan event ter-download | File CSV laporan event ter-download | Sukses |
| G-05 | Lihat laporan user | Daftar user ditampilkan | Daftar user ditampilkan | Sukses |
| G-06 | Export user PDF/CSV | File laporan user ter-download | File laporan user ter-download | Sukses |
| G-07 | Lihat laporan transaksi | Daftar transaksi ditampilkan | Daftar transaksi ditampilkan | Sukses |
| G-08 | Export transaksi PDF/CSV | File laporan transaksi ter-download | File laporan transaksi ter-download | Sukses |
| G-09 | Lihat laporan reward | Data reward ditampilkan | Data reward ditampilkan | Sukses |
| G-10 | Export reward PDF | File PDF ter-download | File PDF ter-download | Sukses |
| G-11 | Lihat laporan engagement | Data engagement ditampilkan | Data engagement ditampilkan | Sukses |
| G-12 | Export engagement PDF/CSV | File laporan ter-download | File laporan ter-download | Sukses |
| G-13 | Lihat laporan feedback | Data feedback ditampilkan | Data feedback ditampilkan | Sukses |
| G-14 | Export feedback PDF/CSV | File laporan ter-download | File laporan ter-download | Sukses |
| G-15 | Lihat laporan partner | Data partner ditampilkan | Data partner ditampilkan | Sukses |
| G-16 | Export partner PDF/CSV | File laporan ter-download | File laporan ter-download | Sukses |
| G-17 | Lihat laporan customer | Data customer ditampilkan | Data customer ditampilkan | Sukses |
| G-18 | Export customer PDF/CSV | File laporan ter-download | File laporan ter-download | Sukses |

---

### H. Otorisasi & Keamanan

| Id | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian | Status |
|:---:|---|---|---|:---:|
| H-01 | Customer akses admin panel | Error 403 / redirect | Error 403 / redirect | Sukses |
| H-02 | Customer akses partner panel | Error 403 / redirect | Error 403 / redirect | Sukses |
| H-03 | Customer akses manager panel | Error 403 / redirect | Error 403 / redirect | Sukses |
| H-04 | Guest akses halaman auth-only | Redirect ke halaman login | Redirect ke halaman login | Sukses |
| H-05 | Partner akses admin panel | Error 403 / redirect | Error 403 / redirect | Sukses |
| H-06 | CSRF protection | Error 419 Page Expired | Error 419 Page Expired | Sukses |
