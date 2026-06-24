# Dokumen Blackbox Testing - Website Wismilak Cigars

**Proyek:** Website Wismilak Cigars Event Management  
**Tanggal:** 4 Mei 2026  
**Penguji:** QA Team  
**Total Test Case:** 100  

---

## A. Verifikasi Usia (3 Test Cases)

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| A-01 | Akses halaman verifikasi usia | Buka URL `/age-verification` | - | Halaman verifikasi usia ditampilkan | Sesuai | ✅ Pass |
| A-02 | Verifikasi usia berhasil (≥21) | Klik tombol "Ya, saya berusia 21+" | verified=true | Redirect ke Home, session tersimpan | Sesuai | ✅ Pass |
| A-03 | Verifikasi usia gagal (<21) | Klik tombol "Tidak" | verified=false | Redirect ke google.com | Sesuai | ✅ Pass |

---

## B. Autentikasi (14 Test Cases)

### B1. Registrasi

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| B-01 | Registrasi data valid | Isi form lengkap, klik Register | name=John, email=john@test.com, password=Pass1234, confirm=Pass1234, terms=accepted | Akun terbuat, auto-login, redirect dashboard | Sesuai | ✅ Pass |
| B-02 | Registrasi email duplikat | Isi email yang sudah terdaftar | email=existing@test.com | Error "email has already been taken" | Sesuai | ✅ Pass |
| B-03 | Registrasi tanpa nama | Kosongkan field nama | name="" | Error "name is required" | Sesuai | ✅ Pass |
| B-04 | Registrasi tanpa email | Kosongkan field email | email="" | Error "email is required" | Sesuai | ✅ Pass |
| B-05 | Registrasi password tidak cocok | Password & konfirmasi berbeda | password=Pass1234, confirm=Pass5678 | Error "confirmation does not match" | Sesuai | ✅ Pass |
| B-06 | Registrasi tanpa accept terms | Tidak centang terms | terms=unchecked | Error "You must accept the terms" | Sesuai | ✅ Pass |
| B-07 | Registrasi usia < 21 tahun | Isi tanggal lahir < 21 tahun | dob=2010-01-01 | Error "must be at least 21 years old" | Sesuai | ✅ Pass |

### B2. Login

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| B-08 | Login kredensial valid | Isi email & password, klik Login | email=john@test.com, password=Pass1234 | Login berhasil, redirect dashboard sesuai role | Sesuai | ✅ Pass |
| B-09 | Login password salah | Isi email benar, password salah | password=wrong | Error autentikasi gagal | Sesuai | ✅ Pass |
| B-10 | Login email tidak terdaftar | Isi email tidak ada di DB | email=noexist@test.com | Error autentikasi gagal | Sesuai | ✅ Pass |
| B-11 | Smart redirect per role | Login sebagai tiap role | Login per role | Redirect ke dashboard masing-masing | Sesuai | ✅ Pass |

### B3. Logout & Password

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| B-12 | Logout | Klik tombol Logout | - | Session dihapus, redirect ke halaman utama | Sesuai | ✅ Pass |
| B-13 | Forgot password | Isi email di form forgot password | email=john@test.com | Email reset password terkirim | Sesuai | ✅ Pass |
| B-14 | Reset password token valid | Klik link reset, isi password baru | token=valid, password=NewPass123 | Password berhasil diubah | Sesuai | ✅ Pass |

---

## C. Halaman Publik (11 Test Cases)

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| C-01 | Akses halaman Home | Buka URL `/` | - | Halaman home ditampilkan lengkap | Sesuai | ✅ Pass |
| C-02 | Akses halaman About | Buka URL `/about` | - | Halaman about ditampilkan | Sesuai | ✅ Pass |
| C-03 | Lihat daftar produk | Buka URL `/products` | - | Daftar produk ditampilkan | Sesuai | ✅ Pass |
| C-04 | Lihat detail produk | Klik salah satu produk | product_id=1 | Detail produk ditampilkan | Sesuai | ✅ Pass |
| C-05 | Lihat daftar outlet | Buka URL `/outlets` | - | Daftar outlet ditampilkan | Sesuai | ✅ Pass |
| C-06 | Lihat detail outlet | Klik salah satu outlet | outlet_id=1 | Detail outlet ditampilkan | Sesuai | ✅ Pass |
| C-07 | Lihat daftar pressroom | Buka URL `/pressroom` | - | Daftar artikel ditampilkan | Sesuai | ✅ Pass |
| C-08 | Lihat detail pressroom | Klik salah satu artikel | slug=article-1 | Detail artikel ditampilkan | Sesuai | ✅ Pass |
| C-09 | Kirim media inquiry | Isi form media inquiry | name, email, message | Inquiry terkirim, pesan sukses | Sesuai | ✅ Pass |
| C-10 | Lihat daftar event publik | Buka URL `/events` | - | Daftar event ditampilkan | Sesuai | ✅ Pass |
| C-11 | Lihat detail event | Klik salah satu event | event_id=1 | Detail event ditampilkan | Sesuai | ✅ Pass |

---

## D. Fitur Customer (40 Test Cases)

### D1. Dashboard

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-01 | Akses dashboard customer | Login customer, buka `/customer/dashboard` | - | Dashboard dengan statistik poin, event, voucher | Sesuai | ✅ Pass |
| D-02 | Lihat riwayat event | Cek bagian riwayat event | - | 5 event terakhir yang sudah dibayar | Sesuai | ✅ Pass |

### D2. Registrasi Event

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-03 | Registrasi event data valid | Isi form registrasi, submit | full_name, email, phone, dob, ktp(16digit), ktp_file(jpg) | Berhasil, redirect ke pembayaran | Sesuai | ✅ Pass |
| D-04 | Registrasi tanpa KTP | Kosongkan field KTP | ktp_number="" | Error "ktp_number is required" | Sesuai | ✅ Pass |
| D-05 | KTP bukan 16 digit | Isi KTP <16 digit | ktp_number=123 | Error "must be 16 digits" | Sesuai | ✅ Pass |
| D-06 | Peserta usia < 21 | Isi dob peserta < 21 | dob=2010-05-01 | Error "must be at least 21 years old" | Sesuai | ✅ Pass |
| D-07 | Event sudah full | Registrasi event quota=0 | remaining_quota=0 | Error "Event is sold out" | Sesuai | ✅ Pass |
| D-08 | Event sudah lewat | Registrasi event tanggal lewat | past date | Error "Event sudah berakhir" | Sesuai | ✅ Pass |
| D-09 | Registrasi duplikat (paid) | Registrasi event yang sudah dibayar | existing paid reg | Error "You already registered" | Sesuai | ✅ Pass |
| D-10 | Gunakan voucher valid | Isi kode voucher valid | voucher_code=VCH-XXX | Diskon diterapkan | Sesuai | ✅ Pass |
| D-11 | Gunakan voucher invalid | Isi kode voucher salah | voucher_code=INVALID | Error "Invalid voucher code" | Sesuai | ✅ Pass |
| D-12 | Registrasi event gratis | Registrasi event free | price_type=free | Langsung berhasil, tiket di-generate | Sesuai | ✅ Pass |

### D3. Pembayaran Midtrans

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-13 | Halaman pembayaran | Akses payment setelah registrasi | registration valid | Snap Midtrans & detail pembayaran muncul | Sesuai | ✅ Pass |
| D-14 | Pembayaran berhasil | Bayar via Midtrans sandbox | - | Status=paid, tiket di-generate | Sesuai | ✅ Pass |
| D-15 | Akses payment user lain | Akses payment milik user lain | user_id ≠ auth | 403 Forbidden | Sesuai | ✅ Pass |
| D-16 | Webhook Midtrans | Midtrans kirim callback | status=settlement | Registrasi updated, tiket di-generate | Sesuai | ✅ Pass |

### D4. Tiket & Transaksi

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-17 | Download tiket PDF | Klik download tiket | ticket milik user | File PDF ter-download | Sesuai | ✅ Pass |
| D-18 | Download tiket user lain | Akses tiket user lain | user_id ≠ auth | 403 Forbidden | Sesuai | ✅ Pass |
| D-19 | Verifikasi tiket valid | Akses URL verifikasi | ticket_number valid | Halaman verifikasi tampil | Sesuai | ✅ Pass |
| D-20 | Verifikasi tiket invalid | Akses URL tiket invalid | ticket_number=INVALID | Pesan "Ticket invalid" | Sesuai | ✅ Pass |
| D-21 | Lihat daftar transaksi | Buka `/customer/transactions` | - | Daftar transaksi tampil | Sesuai | ✅ Pass |
| D-22 | Lihat detail transaksi | Klik salah satu transaksi | transaction_id valid | Detail transaksi tampil | Sesuai | ✅ Pass |

### D5. Voucher & Poin

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-23 | Redeem voucher berhasil | Klik redeem voucher | poin cukup | Voucher ditukar, poin berkurang | Sesuai | ✅ Pass |
| D-24 | Redeem poin tidak cukup | Redeem dengan poin kurang | points < required | Error "Poin Anda tidak cukup" | Sesuai | ✅ Pass |
| D-25 | Redeem voucher inactive | Redeem voucher expired | status=inactive | Error "Voucher tidak tersedia" | Sesuai | ✅ Pass |
| D-26 | Lihat voucher saya | Buka `/customer/vouchers` | - | Daftar voucher user tampil | Sesuai | ✅ Pass |
| D-27 | Lihat riwayat poin | Buka `/customer/points/history` | - | Riwayat earn & spend tampil | Sesuai | ✅ Pass |

### D6. Feedback

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-28 | Feedback setelah check-in | Isi form feedback | rating=5, comment="Bagus" | Tersimpan, poin diberikan | Sesuai | ✅ Pass |
| D-29 | Feedback tanpa check-in | Akses form tanpa check-in | belum check-in | Error "hanya setelah check-in" | Sesuai | ✅ Pass |
| D-30 | Feedback tanpa registrasi | Akses feedback event lain | belum terdaftar | Error "belum terdaftar" | Sesuai | ✅ Pass |
| D-31 | Feedback duplikat | Feedback event yang sudah ada | sudah feedback | Error "sudah memberi feedback" | Sesuai | ✅ Pass |
| D-32 | Edit feedback | Edit feedback yang ada | rating=4 | Feedback diperbarui | Sesuai | ✅ Pass |
| D-33 | Riwayat feedback | Buka `/customer/feedback/history` | - | Daftar feedback tampil | Sesuai | ✅ Pass |

### D7. Live Chat & Profil

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| D-34 | Mulai sesi chat | Klik "Mulai Chat" | - | Sesi chat baru dibuat | Sesuai | ✅ Pass |
| D-35 | Kirim pesan chat | Ketik pesan, klik kirim | message="Hello" | Pesan terkirim & tampil | Sesuai | ✅ Pass |
| D-36 | Request admin | Klik request admin | - | Request dikirim | Sesuai | ✅ Pass |
| D-37 | Update profil berhasil | Edit nama/email, simpan | name="Updated" | Profil diperbarui | Sesuai | ✅ Pass |
| D-38 | Update email duplikat | Ganti ke email yang ada | email=existing | Error "email taken" | Sesuai | ✅ Pass |
| D-39 | Ubah password berhasil | Isi current & new password | valid data | Password diubah | Sesuai | ✅ Pass |
| D-40 | Ubah password current salah | Current password salah | current=wrong | Error validasi | Sesuai | ✅ Pass |

---

## E. Fitur Partner (15 Test Cases)

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| E-01 | Akses dashboard partner | Login sebagai partner | - | Dashboard dengan statistik | Sesuai | ✅ Pass |
| E-02 | Buat event (draft) | Isi form create event | title, date, location, quota | Event tersimpan sbg draft | Sesuai | ✅ Pass |
| E-03 | Buat event tanpa judul | Kosongkan title | title="" | Error "title is required" | Sesuai | ✅ Pass |
| E-04 | Buat event tanggal lampau | Tanggal sudah lewat | date=2020-01-01 | Error "date must be after today" | Sesuai | ✅ Pass |
| E-05 | Edit event draft | Edit event status draft | updated data | Event diperbarui | Sesuai | ✅ Pass |
| E-06 | Edit event sudah diajukan | Edit event pending/published | - | Error "tidak bisa diedit" | Sesuai | ✅ Pass |
| E-07 | Submit event approval | Submit event draft | status=draft | Status berubah ke pending | Sesuai | ✅ Pass |
| E-08 | Resubmit event rejected | Submit ulang event ditolak | status=rejected | Diajukan ulang | Sesuai | ✅ Pass |
| E-09 | Lihat peserta event | Klik Participants | event_id valid | Daftar peserta paid tampil | Sesuai | ✅ Pass |
| E-10 | Lihat feedback event | Klik Feedbacks | event_id valid | Feedback & statistik tampil | Sesuai | ✅ Pass |
| E-11 | Akses event partner lain | Akses event bukan miliknya | created_by ≠ auth | 403 Forbidden | Sesuai | ✅ Pass |
| E-12 | Export event PDF | Klik export PDF | event_id valid | PDF ter-download | Sesuai | ✅ Pass |
| E-13 | Export event CSV | Klik export CSV | event_id valid | CSV ter-download | Sesuai | ✅ Pass |
| E-14 | Halaman QR scan | Buka scan QR | - | Scanner QR tampil | Sesuai | ✅ Pass |
| E-15 | Proses check-in | Scan QR tiket valid | ticket data | Check-in berhasil | Sesuai | ✅ Pass |

---

## F. Fitur Admin (25 Test Cases)

### F1. Dashboard & Event Management

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| F-01 | Akses dashboard admin | Login sebagai admin | - | Dashboard admin tampil | Sesuai | ✅ Pass |
| F-02 | Lihat daftar event | Buka `/admin/event` | - | Semua event + tiket terjual | Sesuai | ✅ Pass |
| F-03 | Tambah event | Isi form, submit | data event | Event ditambahkan | Sesuai | ✅ Pass |
| F-04 | Edit event | Edit data event | updated data | Event diperbarui | Sesuai | ✅ Pass |
| F-05 | Hapus event | Klik delete | event_id valid | Event dihapus | Sesuai | ✅ Pass |

### F2. Verifikasi Event & Peserta

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| F-06 | Lihat event pending | Buka verifikasi | - | Event pending tampil | Sesuai | ✅ Pass |
| F-07 | Approve event | Klik verify | event_id | Status → verified | Sesuai | ✅ Pass |
| F-08 | Reject event | Klik reject | event_id | Status → rejected | Sesuai | ✅ Pass |
| F-09 | Publish event | Klik publish | event_id | Status → published | Sesuai | ✅ Pass |
| F-10 | Lihat detail verifikasi | Klik detail | event_id | Detail tampil | Sesuai | ✅ Pass |
| F-11 | Lihat peserta event | Buka participants | event_id | Daftar peserta tampil | Sesuai | ✅ Pass |
| F-12 | Detail peserta | Klik detail peserta | ticket_id | Detail & tiket tampil | Sesuai | ✅ Pass |
| F-13 | Download tiket peserta | Klik download | ticket_id | PDF ter-download | Sesuai | ✅ Pass |
| F-14 | Admin QR check-in | Scan QR tiket | ticket data | Check-in berhasil | Sesuai | ✅ Pass |

### F3. CRUD Produk, Gallery, Pressroom, Outlet, User

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| F-15 | CRUD Produk | Tambah/Edit/Hapus produk | data produk | Operasi berhasil | Sesuai | ✅ Pass |
| F-16 | CRUD Gallery | Tambah/Hapus gallery | image file | Operasi berhasil | Sesuai | ✅ Pass |
| F-17 | CRUD Pressroom | Tambah/Edit/Hapus artikel | data artikel | Operasi berhasil | Sesuai | ✅ Pass |
| F-18 | CRUD Outlet + toggle | Tambah/Edit/Hapus/Toggle outlet | data outlet | Operasi berhasil | Sesuai | ✅ Pass |
| F-19 | Assign partner outlet | Pilih partner untuk outlet | partner_id | Partner di-assign | Sesuai | ✅ Pass |
| F-20 | CRUD User + toggle | Tambah/Edit/Toggle user | data user | Operasi berhasil | Sesuai | ✅ Pass |

### F4. Voucher, Reward, Chat, Feedback, Lainnya

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| F-21 | CRUD Voucher | Tambah/Edit/Hapus voucher | data voucher | Operasi berhasil | Sesuai | ✅ Pass |
| F-22 | CRUD Reward + toggle | Tambah/Edit/Toggle reward | data reward | Operasi berhasil | Sesuai | ✅ Pass |
| F-23 | Live Chat admin | Lihat/Reply/Close chat | session data | Operasi berhasil | Sesuai | ✅ Pass |
| F-24 | Feedback admin | Lihat daftar & detail feedback | feedback_id | Data tampil | Sesuai | ✅ Pass |
| F-25 | Media/Instagram/Pages | CRUD media inquiry, instagram, pages | data terkait | Operasi berhasil | Sesuai | ✅ Pass |

---

## G. Fitur Manager (18 Test Cases)

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| G-01 | Dashboard manager | Login sebagai manager | - | Dashboard statistik tampil | Sesuai | ✅ Pass |
| G-02 | Laporan event | Buka `/manager/events` | - | Data event tampil | Sesuai | ✅ Pass |
| G-03 | Export event PDF | Klik export PDF | - | PDF ter-download | Sesuai | ✅ Pass |
| G-04 | Export event CSV | Klik export CSV | - | CSV ter-download | Sesuai | ✅ Pass |
| G-05 | Laporan user | Buka `/manager/users` | - | Data user tampil | Sesuai | ✅ Pass |
| G-06 | Export user PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |
| G-07 | Laporan transaksi | Buka `/manager/transactions` | - | Data transaksi tampil | Sesuai | ✅ Pass |
| G-08 | Export transaksi PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |
| G-09 | Laporan reward | Buka `/manager/rewards` | - | Data reward tampil | Sesuai | ✅ Pass |
| G-10 | Export reward PDF | Klik export PDF | - | PDF ter-download | Sesuai | ✅ Pass |
| G-11 | Laporan engagement | Buka `/manager/engagement` | - | Data engagement tampil | Sesuai | ✅ Pass |
| G-12 | Export engagement PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |
| G-13 | Laporan feedback | Buka `/manager/feedback` | - | Data feedback tampil | Sesuai | ✅ Pass |
| G-14 | Export feedback PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |
| G-15 | Laporan partner | Buka `/manager/partners` | - | Data partner tampil | Sesuai | ✅ Pass |
| G-16 | Export partner PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |
| G-17 | Laporan customer | Buka `/manager/customers` | - | Data customer tampil | Sesuai | ✅ Pass |
| G-18 | Export customer PDF/CSV | Klik export | - | File ter-download | Sesuai | ✅ Pass |

---

## H. Otorisasi & Keamanan (6 Test Cases)

| No | Skenario Pengujian | Langkah Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|
| H-01 | Customer akses admin | Login customer, buka `/admin/dashboard` | role=customer | 403 / redirect | Sesuai | ✅ Pass |
| H-02 | Customer akses partner | Login customer, buka `/partner/dashboard` | role=customer | 403 / redirect | Sesuai | ✅ Pass |
| H-03 | Customer akses manager | Login customer, buka `/manager/dashboard` | role=customer | 403 / redirect | Sesuai | ✅ Pass |
| H-04 | Guest akses auth-only | Buka `/customer/dashboard` tanpa login | not authenticated | Redirect ke login | Sesuai | ✅ Pass |
| H-05 | Partner akses admin | Login partner, buka `/admin/dashboard` | role=partner | 403 / redirect | Sesuai | ✅ Pass |
| H-06 | CSRF protection | Submit form tanpa CSRF token | missing _token | 419 Page Expired | Sesuai | ✅ Pass |

---

## Ringkasan Hasil Pengujian

| Kategori | Jumlah Test Case | Pass | Fail |
|---|---|---|---|
| A. Verifikasi Usia | 3 | 3 | 0 |
| B. Autentikasi | 14 | 14 | 0 |
| C. Halaman Publik | 11 | 11 | 0 |
| D. Fitur Customer | 40 | 40 | 0 |
| E. Fitur Partner | 15 | 15 | 0 |
| F. Fitur Admin | 25 | 25 | 0 |
| G. Fitur Manager | 18 | 18 | 0 |
| H. Otorisasi & Keamanan | 6 | 6 | 0 |
| **TOTAL** | **132** | **132** | **0** |

**Kesimpulan:** Seluruh fitur website Wismilak Cigars telah diuji dan berfungsi sesuai dengan yang diharapkan.
