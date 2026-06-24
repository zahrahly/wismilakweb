# Lampiran Source Code (Berdasarkan Struktur Gambar Skripsi)

Berikut adalah daftar potongan kode program (Source Code) yang dipetakan sesuai dengan urutan gambar tampilan pada naskah skripsi Anda. Tanda `// ... //` menunjukkan letak pasti di mana logika program dijalankan atau dimodifikasi.

---

### 1. Verifikasi Usia
**Gambar 4.155 Source Code Verifikasi Usia**
- **Controller:** `app/Http/Controllers/AgeVerificationController.php`

```php
public function verify(Request $request) {
    // ... //
    // Memeriksa apakah request memiliki konfirmasi usia (tombol "Ya, 21+").
    // Jika iya, simpan status verifikasi di session pengguna.
    // ... //
    if ($request->has('verified')) {
        $request->session()->put('age_verified', true);
        return redirect()->intended(route('home'));
    }
    // Jika tidak memenuhi syarat usia, redirect keluar sistem (contoh: Google).
    return redirect('https://www.google.com');
}
```

---

### 2. Login
**Gambar 4.155 Source Code Login**
- **Controller:** `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

```php
public function store(LoginRequest $request): RedirectResponse {
    // ... //
    // Memvalidasi kredensial login (email & password).
    // ... //
    $request->authenticate();
    $request->session()->regenerate();
    
    // ... //
    // Redirect pengguna berdasarkan rolenya ke dashboard yang sesuai
    // (Customer, Admin, Manager, atau Partner).
    // ... //
    return redirect()->route('dashboard');
}
```

---

### 3. Homepage
**Gambar 4.159 Source Code Homepage**
- **Controller:** `app/Http/Controllers/HomeController.php`

```php
public function index() {
    // ... //
    // Mengambil data produk, event yang akan datang, berita pressroom,
    // dan informasi outlet dari database untuk ditampilkan di halaman utama.
    // ... //
    $events = Event::where('status', 'published')->latest()->take(3)->get();
    $products = Product::latest()->take(4)->get();
    return view('home', compact('events', 'products'));
}
```

---

### 4. Daftar Event
**Gambar 4.157 Source Code Daftar Event**
- **Controller:** `app/Http/Controllers/EventController.php` (Customer)

```php
public function index() {
    // ... //
    // Mengambil daftar seluruh event aktif dengan paginasi.
    // Hanya event dengan status 'published' yang ditarik dari database.
    // ... //
    $events = Event::where('status', 'published')->orderBy('date', 'asc')->paginate(10);
    return view('customer.events.index', compact('events'));
}
```

---

### 5. Daftar Produk
**Gambar 4.163 Source Code Daftar Produk**
- **Controller:** `app/Http/Controllers/ProductController.php` (Customer)

```php
public function index() {
    // ... //
    // Mengambil seluruh katalog data produk untuk pelanggan umum.
    // ... //
    $products = Product::where('status', 'active')->paginate(12);
    return view('customer.products.index', compact('products'));
}
```

---

### 6. Daftar dan Detail Outlet
**Gambar 4.165 Source Code Daftar Outlet & Gambar 4.167 Source Code Detail Outlet**
- **Controller:** `app/Http/Controllers/OutletController.php` (Customer)

```php
public function index() {
    // ... //
    // Mengambil data seluruh outlet aktif untuk ditampilkan pada peta atau daftar.
    // ... //
}

public function show(Outlet $outlet) {
    // ... //
    // Mengambil data spesifik 1 outlet beserta produk atau event yang terhubung dengannya.
    // ... //
}
```

---

### 7. Pressroom dan Media Inquiry
**Gambar 4.169 Source Code Pressroom & Gambar 4.171 Source Code Media Inquiry**
- **Controller:** `app/Http/Controllers/PressroomController.php` (Customer)

```php
public function index() {
    // ... //
    // Menarik seluruh artikel berita terbaru untuk ditampilkan di Pressroom.
    // ... //
}

public function sendMediaInquiry(Request $request) {
    // ... //
    // Memvalidasi input formulir media inquiry.
    // Menyimpan data pertanyaan/kebutuhan informasi ke tabel MediaInquiries.
    // Memicu pengiriman email/notifikasi kepada admin Wismilak.
    // ... //
}
```

---

### 8. Admin - Dashboard
**Gambar 4.173 Source Code Dashboard Admin**
- **Controller:** `app/Http/Controllers/Admin/DashboardController.php`

```php
public function index() {
    // ... //
    // Melakukan query agregasi (Count/Sum) untuk statistik operasional admin.
    // Menghitung jumlah pengguna, event pending, dan pendapatan tiket.
    // ... //
    return view('admin.dashboard', compact('stats'));
}
```

---

### 9. Admin - Kelola Event
**Gambar 4.175 Source Code Kelola Event Admin**
- **Controller:** `app/Http/Controllers/Admin/EventController.php`

```php
public function store(Request $request) {
    // ... //
    // Menangani upload gambar event, memvalidasi input, dan merekam event baru ke database.
    // ... //
}

public function destroy(Event $event) {
    // ... //
    // Menghapus data event dan gambar terkait dari storage jika tidak dibutuhkan.
    // ... //
}
```

---

### 10. Admin - Verifikasi Event
**Gambar 4.177 Source Code Verifikasi Event Admin**
- **Controller:** `app/Http/Controllers/Admin/EventVerificationController.php`

```php
public function verify(Request $request, Event $event) {
    // ... //
    // Memperbarui status verifikasi event pengajuan dari partner.
    // Jika disetujui, event berubah status menjadi 'published'.
    // ... //
    $event->update([
        'status' => 'published',
        'verification_status' => 'approved',
        'verified_by' => Auth::id()
    ]);
}
```

---

### 11. Admin - Kelola Voucher dan Reward
**Gambar 4.179 Source Code Kelola Voucher dan Reward Admin**
- **Controller:** `app/Http/Controllers/Admin/VoucherController.php` & `RewardController.php`

```php
public function store(Request $request) {
    // ... //
    // Membuat voucher diskon atau reward baru dengan batasan poin penukaran.
    // Generate kode unik secara otomatis untuk Voucher.
    // ... //
}
```

---

### 12. Admin - Sistem Chat (+topik)
**Gambar 4.181 Source Code Live Chat Admin**
- **Controller:** `app/Http/Controllers/Admin/LiveChatController.php`

```php
public function reply(Request $request, ChatSession $session) {
    // ... //
    // Menyimpan balasan dari admin (Customer Service) ke pelanggan terkait.
    // Memicu event Real-time / Polling agar pesan muncul di layar pengguna.
    // ... //
}

public function close(ChatSession $session) {
    // ... //
    // Mengubah status sesi percakapan menjadi selesai (resolved).
    // ... //
}
```

---

### 13. Admin - Kelola Media Inquiry
**Gambar 4.183 Source Code Kelola Media Inquiry Admin**
- **Controller:** `app/Http/Controllers/Admin/MediaInquiryController.php`

```php
public function reply(Request $request, MediaInquiry $inquiry) {
    // ... //
    // Menyimpan data balasan inquiry dan mengirimkannya via Email ke penanya.
    // Mengupdate status inquiry menjadi 'replied'.
    // ... //
}
```

---

### 14. Partner - Dashboard
**Gambar 4.185 Source Code Dashboard Partner**
- **Controller:** `app/Http/Controllers/Partner/EventController.php`

```php
public function dashboard() {
    // ... //
    // Mengambil data ringkasan performa khusus untuk event milik Partner yang login (Auth::id()).
    // Menghitung jumlah peserta yang mendaftar ke event-event buatan mereka.
    // ... //
}
```

---

### 15. Partner - Pengajuan Event
**Gambar 4.187 Source Code Pengajuan Event Partner**
- **Controller:** `app/Http/Controllers/Partner/EventController.php`

```php
public function submit(Event $event) {
    // ... //
    // Mengajukan event draft (yang telah diisi informasinya) ke pihak admin.
    // Status event berubah dari 'draft' menjadi 'pending'.
    // ... //
}
```

---

### 16. Partner - Verifikasi Event (Check-in QR)
**Gambar 4.189 Source Code Verifikasi Event Partner**
- **Controller:** `app/Http/Controllers/Partner/CheckinController.php`

```php
public function process(Request $request) {
    // ... //
    // Membaca kode hasil tangkapan scanner QR Code.
    // Memvalidasi apakah kode tiket ada di database, cocok dengan event, dan belum terpakai.
    // Mengubah status 'is_checked_in' menjadi True pada tabel tiket.
    // ... //
}
```

---

### 17. Partner - Feedback Event
**Gambar 4.191 Source Code Feedback Event Partner**
- **Controller:** `app/Http/Controllers/Partner/EventController.php`

```php
public function feedbacks(Event $event) {
    // ... //
    // Menarik seluruh rekap penilaian (rating bintang) dan ulasan dari tabel EventFeedback
    // khusus untuk event yang dimiliki oleh partner tersebut.
    // Menghitung rata-rata bintang (Average Rating).
    // ... //
}
```

---

### 18. Manager - Dashboard
**Gambar 4.193 Source Code Dashboard Manager**
- **Controller:** `app/Http/Controllers/Manager/ReportController.php`

```php
public function dashboard() {
    // ... //
    // Melakukan proses pengambilan data komprehensif di seluruh modul.
    // Menyiapkan data agregasi grafik performa transaksi bulanan untuk evaluasi top-level.
    // ... //
}
```

---

### 19. Manager - Laporan
**Gambar 4.195, 4.197, 4.199, 4.201 Source Code Laporan (Manager)**
- **Controller:** `app/Http/Controllers/Manager/ReportController.php`

```php
public function exportTransactionsCsv() {
    // ... //
    // Menarik histori seluruh transaksi (berhasil/gagal) dari database.
    // Mengekspornya ke dalam format CSV menggunakan fungsi streaming agar
    // proses ekspor laporan dalam jumlah besar tidak membebani server.
    // ... //
}

public function exportEventsPdf() {
    // ... //
    // Men-generate PDF laporan detail performa acara menggunakan view template Laporan.
    // ... //
}
```

---

### 20. Customer - Dashboard
**Gambar 4.203 Source Code Dashboard Customer**
- **Controller:** `app/Http/Controllers/Customer/DashboardController.php`

```php
public function index() {
    // ... //
    // Menampilkan profil singkat, ringkasan saldo poin yang dimiliki,
    // tiket acara yang sudah dibayar, serta voucher promo yang belum digunakan.
    // ... //
}
```

---

### 21. Customer - Registrasi Event
**Gambar 4.205 Source Code Registrasi Event Customer**
- **Controller:** `app/Http/Controllers/EventRegistrationController.php`

```php
public function store(Request $request, Event $event) {
    // ... //
    // Memvalidasi KTP dan memastikan peserta memenuhi syarat usia (>= 21 tahun).
    // Mengecek sisa kuota event secara real-time.
    // Jika valid, menghasilkan Snap Token Midtrans untuk proses pembayaran.
    // ... //
}
```

---

### 22. Customer - Poin dan Reward
**Gambar 4.207 Source Code Poin dan Reward Customer**
- **Controller:** `app/Http/Controllers/Customer/DashboardController.php`

```php
public function redeemReward(Reward $reward) {
    // ... //
    // Memvalidasi kecukupan jumlah saldo poin pelanggan.
    // Mengurangi saldo poin dan merekam data penukaran reward/merchandise.
    // ... //
}
```

---

### 23. Customer - Feedback Event
**Gambar 4.209 Source Code Feedback Event Customer**
- **Controller:** `app/Http/Controllers/Customer/FeedbackController.php`

```php
public function store(Request $request, Event $event) {
    // ... //
    // Memastikan user sudah memiliki riwayat Check-in di event tersebut (tidak boleh ngawur).
    // Menyimpan nilai rating dan komentar pengalaman.
    // Mencegah pelanggan memasukkan ulasan lebih dari satu kali (duplikasi).
    // ... //
}
```

---

### 24. Customer - Live Chat
**Gambar 4.211 Source Code Live Chat Customer**
- **Controller:** `app/Http/Controllers/LiveChatController.php` (Customer View)

```php
public function startSession() {
    // ... //
    // Membuka ruang/sesi obrolan baru khusus untuk customer ini dengan tim Admin.
    // ... //
}

public function sendMessage(Request $request, ChatSession $session) {
    // ... //
    // Menyisipkan baris pesan baru ke dalam database pada ID sesi percakapan terkait.
    // ... //
}
```
