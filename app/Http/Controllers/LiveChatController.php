<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ChatTopic;
use Illuminate\Support\Facades\Auth;

class LiveChatController extends Controller
{

    private $keywords = [
        // Greetings
        'halo'      => "Selamat datang di Wismilak. Ada yang bisa kami bantu?\n\nAnda dapat bertanya mengenai:\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nAtau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.",
        'hallo'     => "Selamat datang di Wismilak. Ada yang bisa kami bantu?\n\nAnda dapat bertanya mengenai:\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nAtau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.",
        'hello'     => "Welcome to Wismilak. How may we assist you?\n\nYou may inquire about:\n- Events and Registration\n- Tickets and Payment\n- Vouchers and Discounts\n- Products and Outlets\n- Rewards and Points\n\nOr type \"admin\" to speak with our service team.",
        'hi'        => "Selamat datang. Ada yang bisa kami bantu hari ini?\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung dengan layanan pelanggan.",
        'hei'       => "Selamat datang. Ada yang bisa kami bantu hari ini?",
        'permisi'   => "Selamat datang di Wismilak. Silakan sampaikan pertanyaan Anda.",
        'pagi'      => "Selamat pagi! Ada yang bisa kami bantu hari ini?",
        'siang'     => "Selamat siang! Ada yang bisa kami bantu?",
        'sore'      => "Selamat sore! Ada yang bisa kami bantu?",
        'malam'     => "Selamat malam! Ada yang bisa kami bantu?",
        'assalamualaikum' => "Waalaikumsalam! Selamat datang di Wismilak. Ada yang bisa kami bantu?",

        // Events
        'event'     => "Untuk melihat event terbaru:\n1. Buka menu Event di navigasi utama\n2. Pilih Calendar View atau Event List\n3. Klik event yang diminati untuk detail dan registrasi\n\nSetiap event memiliki kuota terbatas. Kami sarankan untuk segera mendaftar.",
        'acara'     => "Untuk melihat acara terbaru, kunjungi menu Event di website kami. Setiap acara memiliki kuota terbatas.",
        'jadwal'    => "Jadwal event terbaru dapat dilihat melalui menu Event. Gunakan Calendar View untuk melihat per tanggal.",
        'kalender'  => "Kalender event tersedia di halaman Event. Anda bisa melihat jadwal acara per bulan.",
        'kuota'     => "Informasi kuota tersedia di halaman detail setiap event. Kuota akan berkurang secara otomatis setiap ada pendaftaran.",
        'daftar'    => "Cara mendaftar event:\n1. Buka halaman event yang diminati\n2. Klik \"Register Now\"\n3. Lengkapi data peserta\n4. Gunakan voucher jika tersedia\n5. Lanjutkan ke pembayaran\n\nPastikan semua peserta berusia minimal 21 tahun.",
        'registrasi' => "Cara registrasi event:\n1. Buka halaman event\n2. Klik \"Register Now\"\n3. Isi data peserta lengkap\n4. Gunakan voucher jika ada\n5. Selesaikan pembayaran",
        'register'  => "To register for an event:\n1. Visit the event page\n2. Click \"Register Now\"\n3. Complete participant details\n4. Apply voucher if available\n5. Proceed to payment",
        'gabung'    => "Untuk bergabung dalam event, silakan buka menu Event dan pilih acara yang diminati, lalu klik Register Now.",
        'ikut'      => "Untuk ikut event, buka halaman event dan klik Register Now. Pastikan semua peserta berusia minimal 21 tahun.",

        // Tickets
        'tiket'     => "Informasi tiket:\n- Tiket dibuat secara otomatis setelah pembayaran berhasil\n- Unduh tiket PDF melalui halaman Riwayat Transaksi\n- Setiap tiket dilengkapi QR code untuk proses check-in\n- Masing-masing peserta mendapat tiket tersendiri",
        'ticket'    => "Ticket information:\n- Tickets are generated automatically after successful payment\n- Download your PDF ticket from Transaction History\n- Each ticket includes a QR code for check-in\n- Each participant receives an individual ticket",
        'download'  => "Untuk download tiket PDF, buka halaman Riwayat Transaksi di Dashboard Anda, lalu klik tombol Download PDF.",
        'qr'        => "QR code terdapat di tiket PDF Anda. Tunjukkan QR code saat check-in di lokasi event.",
        'barcode'   => "Barcode/QR code untuk check-in tersedia di tiket PDF Anda. Download dari halaman Riwayat Transaksi.",

        // Payment
        'bayar'     => "Informasi pembayaran:\n- Pembayaran diproses melalui Midtrans (transfer bank, e-wallet, dsb)\n- Batas waktu pembayaran: 30 menit\n- Status akan diperbarui secara otomatis setelah pembayaran\n- Pantau status di halaman Riwayat Transaksi",
        'pembayaran' => "Pembayaran event menggunakan Midtrans. Tersedia metode: transfer bank, e-wallet (GoPay, ShopeePay), dan QRIS. Batas waktu 30 menit.",
        'payment'   => "Payment information:\n- Payments are processed via Midtrans\n- Payment deadline: 30 minutes\n- Status updates automatically after payment\n- Monitor status in Transaction History",
        'midtrans'  => "Kami menggunakan Midtrans untuk memastikan keamanan transaksi Anda.\nMetode yang tersedia: Bank Transfer, GoPay, ShopeePay, QRIS, dan lainnya.",
        'transfer'  => "Pembayaran via transfer bank tersedia melalui Midtrans. Pilih metode Bank Transfer saat checkout.",
        'gopay'     => "GoPay tersedia sebagai metode pembayaran. Pilih GoPay saat proses checkout.",
        'shopeepay' => "ShopeePay tersedia sebagai metode pembayaran. Pilih ShopeePay saat proses checkout.",
        'qris'      => "Pembayaran via QRIS tersedia. Anda bisa scan QR code dari aplikasi e-wallet manapun.",
        'gagal'     => "Jika pembayaran gagal:\n- Pastikan saldo atau limit mencukupi\n- Coba lagi dalam beberapa menit\n- Batas waktu pembayaran adalah 30 menit\n- Jika masih bermasalah, ketik \"admin\" untuk bantuan",
        'expired'   => "Jika pembayaran expired, Anda perlu mendaftar ulang ke event. Buka halaman event dan klik Register Now kembali.",
        'refund'    => "Untuk informasi refund atau pengembalian dana, silakan hubungi admin kami. Ketik \"admin\" untuk terhubung.",

        // Voucher & Discount
        'voucher'   => "Tentang voucher:\n- Tukar poin Anda dengan voucher melalui Dashboard\n- Gunakan kode voucher saat proses registrasi event\n- Diskon berlaku untuk total seluruh tiket\n- Periksa masa berlaku voucher sebelum digunakan",
        'diskon'    => "Cara mendapatkan diskon:\n1. Kumpulkan poin dari partisipasi event dan feedback\n2. Tukar poin dengan voucher di Dashboard\n3. Gunakan kode voucher saat registrasi event\n\nSetiap event berhasil memberikan +10 poin, dan feedback memberikan +15 poin.",
        'promo'     => "Promo dan diskon tersedia dalam bentuk voucher. Tukar poin Anda di Dashboard untuk mendapatkan voucher diskon.",
        'kode voucher' => "Kode voucher dapat dilihat di halaman Voucher Saya di Dashboard. Masukkan kode saat registrasi event.",
        'potongan'  => "Potongan harga tersedia melalui voucher. Tukar poin loyalty Anda di Dashboard untuk mendapatkan voucher.",

        // Points & Rewards
        'poin'      => "Cara mendapatkan poin:\n- Registrasi event gratis: +5 poin\n- Pembayaran event: +10 poin per tiket\n- Check-in di event: +10 poin\n- Memberikan feedback: +15 poin per tiket\n\nTukar poin dengan voucher atau reward melalui Dashboard Anda.",
        'point'     => "Cara mendapatkan poin:\n- Registrasi event gratis: +5 poin\n- Pembayaran event: +10 poin per tiket\n- Check-in: +10 poin\n- Feedback: +15 poin per tiket",
        'reward'    => "Reward dapat ditukar melalui menu Poin dan Reward di dashboard Anda.\nKumpulkan poin dari partisipasi event dan feedback untuk mendapatkan berbagai keuntungan.",
        'hadiah'    => "Hadiah/reward tersedia untuk ditukar dengan poin loyalty. Cek katalog reward di Dashboard Anda.",
        'tukar poin' => "Untuk menukar poin, buka Dashboard > bagian Voucher/Reward. Pilih item yang diinginkan dan klik Tukar.",

        // Check-in
        'check-in'  => "Informasi check-in:\n- Tunjukkan tiket PDF atau QR code saat tiba di lokasi event\n- Staf kami akan memindai QR code Anda\n- Check-in diperlukan untuk mendapatkan poin feedback",
        'checkin'   => "Informasi check-in:\n- Tunjukkan tiket PDF/QR code saat datang ke event\n- Staff akan scan QR code Anda\n- Check-in wajib untuk mendapatkan poin feedback",
        'scan'      => "QR code di tiket Anda akan di-scan oleh staff saat check-in di lokasi event.",
        'masuk'     => "Untuk masuk ke event, tunjukkan tiket PDF atau QR code kepada staff di pintu masuk.",

        // Feedback
        'feedback'  => "Tentang feedback:\n- Berikan feedback setelah seluruh tiket telah di-check-in\n- Dapatkan +15 poin untuk setiap tiket\n- Rating 1-5 bintang disertai komentar\n- Riwayat feedback dapat dilihat di Dashboard",
        'review'    => "Cara memberikan review:\n1. Pastikan Anda telah check-in di event\n2. Buka Dashboard kemudian pilih Riwayat Event\n3. Klik \"Berikan Feedback\"\n4. Isi rating dan komentar Anda\n\nAnda akan mendapat bonus poin setelah memberikan review.",
        'ulasan'    => "Untuk memberikan ulasan, buka Dashboard dan cari event yang sudah Anda hadiri. Klik Berikan Feedback.",
        'rating'    => "Rating diberikan dengan skala 1-5 bintang saat memberikan feedback event. Anda mendapat +15 poin per tiket.",
        'bintang'   => "Sistem rating menggunakan 1-5 bintang. Berikan rating jujur Anda saat mengisi feedback event.",

        // Products & Outlet
        'produk'    => "Silakan jelajahi koleksi premium kami melalui menu Collection.\nSetiap produk dilengkapi dengan spesifikasi dan detail lengkap.",
        'product'   => "Please explore our premium collection through the Collection menu.",
        'cerutu'    => "Koleksi cerutu premium Wismilak tersedia di menu Collection. Lihat spesifikasi lengkapnya di sana.",
        'cigar'     => "Our premium cigar collection is available in the Collection menu.",
        'koleksi'   => "Koleksi lengkap produk premium Wismilak dapat dilihat di menu Collection.",
        'outlet'    => "Temukan outlet terdekat melalui menu Find Us.\nInformasi alamat, jam operasional, dan lokasi tersedia untuk setiap outlet.",
        'toko'      => "Temukan toko/outlet Wismilak terdekat melalui menu Find Us di website.",
        'alamat'    => "Alamat outlet tersedia di halaman Find Us. Gunakan peta untuk menemukan outlet terdekat.",
        'lokasi'    => "Lokasi outlet Wismilak dapat ditemukan di menu Find Us lengkap dengan peta interaktif.",
        'galeri'    => "Galeri kami dapat diakses melalui halaman utama website.",
        'harga'     => "Untuk informasi harga, silakan kunjungi halaman produk kami di menu Collection.",
        'jam'       => "Jam operasional outlet kami tersedia di halaman Find Us.",
        'jam buka'  => "Jam operasional setiap outlet tersedia di halaman Find Us.",

        // Account & Profile
        'profil'    => "Untuk mengelola profil Anda, buka menu Kelola Profil di Dashboard. Anda bisa mengubah nama, email, dan password.",
        'password'  => "Untuk mengubah password, buka menu Kelola Profil > Ubah Password di Dashboard Anda.",
        'akun'      => "Kelola akun Anda melalui menu Kelola Profil di Dashboard. Anda bisa update informasi pribadi dan password.",
        'login'     => "Untuk login, klik tombol Login di pojok kanan atas website, lalu masukkan email dan password Anda.",
        'lupa password' => "Jika lupa password, klik \"Forgot Password\" di halaman login untuk mereset password via email.",

        // Transaction & History
        'transaksi' => "Riwayat transaksi Anda tersedia di menu Riwayat Transaksi di Dashboard. Anda bisa melihat status dan download tiket.",
        'riwayat'   => "Riwayat event, transaksi, dan feedback dapat diakses melalui Dashboard Anda.",
        'histori'   => "Histori aktivitas Anda tersedia di Dashboard, termasuk transaksi, event, dan poin.",

        // General Info
        'tentang'   => "Wismilak adalah brand cerutu premium Indonesia. Kunjungi halaman About untuk informasi selengkapnya.",
        'about'     => "Wismilak is a premium Indonesian cigar brand. Visit the About page for more information.",
        'pressroom' => "Berita dan siaran pers terbaru tersedia di halaman Pressroom website kami.",
        'berita'    => "Berita terbaru tentang Wismilak tersedia di halaman Pressroom.",
        'kontak'    => "Untuk menghubungi kami, ketik \"admin\" untuk live chat, atau kunjungi halaman Pressroom untuk media inquiry.",
        'umur'      => "Semua peserta event Wismilak wajib berusia minimal 21 tahun. Verifikasi umur dilakukan saat registrasi.",
        'usia'      => "Syarat usia minimum untuk mengikuti event adalah 21 tahun.",
        'ktp'       => "KTP diperlukan saat registrasi event untuk verifikasi identitas dan usia peserta.",
        'terima kasih' => "Sama-sama! Senang bisa membantu. Ada yang lain yang bisa kami bantu?",
        'makasih'   => "Sama-sama! Senang bisa membantu. Ada pertanyaan lain?",
        'thanks'    => "You're welcome! Is there anything else we can help with?",

        // Escalation
        'bantuan'   => "Kami akan menghubungkan Anda dengan tim layanan kami. Mohon tunggu sebentar.",
        'admin'     => "Kami akan menghubungkan Anda dengan tim layanan kami. Mohon tunggu sebentar.",
        'help'      => "We will connect you with our service team. Please wait a moment.",
        'cs'        => "Menghubungkan Anda ke layanan pelanggan. Mohon tunggu.",
        'komplain'  => "Kami akan menghubungkan Anda dengan tim kami untuk menangani keluhan Anda. Mohon tunggu.",
        'keluhan'   => "Kami akan menghubungkan Anda dengan tim kami untuk menangani keluhan Anda.",
        'customer service' => "Menghubungkan Anda ke layanan pelanggan. Mohon tunggu.",
        'hubungi'   => "Kami akan menghubungkan Anda dengan admin. Mohon tunggu sebentar.",
    ];

    private $escalationKeywords = ['admin', 'bantuan', 'help', 'cs', 'komplain', 'complaint', 'keluhan', 'customer service', 'hubungi', 'tanya staff'];

    public function getActiveSession()
    {
        if (!Auth::check()) {
            return response()->json(['session_id' => null]);
        }
        $existing = ChatSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
        return response()->json([
            'session_id' => $existing ? $existing->id : null
        ]);
    }

    public function startSession()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memulai live chat.');
        }

        $user = Auth::user();

        // Check existing open session
        $existing = ChatSession::where('user_id', $user->id)
            ->where('status', 'open')
            ->first();

        if ($existing) {
            return redirect()->route('customer.chat.show', $existing);
        }

        $session = ChatSession::create([
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'status'  => 'open',
            'mode'    => 'bot',
        ]);

        // Welcome message
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender'          => 'bot',
            'message'         => "Selamat datang, {$user->name}. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.\n\n(Catatan: Layanan admin aktif pada jam kerja pukul 08:00 - 15:00. Di luar jam kerja tersebut, pertanyaan akan dijawab otomatis oleh chatbot).",
        ]);

        return redirect()->route('customer.chat.show', $session);
    }

    public function show(ChatSession $session)
    {
        if (Auth::id() !== $session->user_id) {
            abort(403);
        }

        $session->load('messages');
        return view('customer.chat.show', compact('session'));
    }

    public function sendMessage(Request $request, ChatSession $session)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if (Auth::id() !== $session->user_id) {
            abort(403);
        }

        // Save user message
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender'          => 'user',
            'message'         => $request->message,
        ]);

        // Only auto-respond if in bot mode
        if ($session->isBot()) {
            $lowerMessage = strtolower($request->message);

            // Check for escalation (DB topics first, then hardcoded fallback)
            $shouldEscalate = false;
            $dbEscalationTopics = ChatTopic::active()->escalation()->pluck('keyword')->toArray();
            $escalationList = !empty($dbEscalationTopics) ? $dbEscalationTopics : $this->escalationKeywords;
            foreach ($escalationList as $keyword) {
                if (str_contains($lowerMessage, strtolower($keyword))) {
                    $shouldEscalate = true;
                    break;
                }
            }

            if ($shouldEscalate) {
                $session->switchToAdmin();

                ChatMessage::create([
                    'chat_session_id' => $session->id,
                    'sender'          => 'bot',
                    'message'         => "Anda telah terhubung dengan tim layanan kami. Mohon tunggu, admin akan segera merespons.\n\nApabila admin belum merespons dalam beberapa menit, silakan coba lagi nanti.",
                ]);

                // Kirim notifikasi ke admin
                try {
                    $admins = \App\Models\User::whereHas('role', function($q) {
                        $q->where('name', 'admin');
                    })->get();
                    foreach ($admins as $admin) {
                        \App\Models\Notification::send(
                            $admin->id,
                            'Bantuan Chat Admin Dibutuhkan',
                            "Pelanggan {$session->name} memerlukan bantuan live chat admin.",
                            'chat'
                        );
                    }
                } catch (\Exception $ne) {
                    \Illuminate\Support\Facades\Log::error('Chat escalation notification failed: ' . $ne->getMessage());
                }
            } else {
                $botReply = $this->generateBotReply($lowerMessage);

                ChatMessage::create([
                    'chat_session_id' => $session->id,
                    'sender'          => 'bot',
                    'message'         => $botReply,
                ]);
            }
        } else {
            // Jika sudah mode live, kirim notifikasi pesan baru ke admin
            try {
                $admins = \App\Models\User::whereHas('role', function($q) {
                    $q->where('name', 'admin');
                })->get();
                foreach ($admins as $admin) {
                    \App\Models\Notification::send(
                        $admin->id,
                        'Pesan Chat Baru',
                        "Pesan baru dari {$session->name}: \"" . \Illuminate\Support\Str::limit($request->message, 50) . "\"",
                        'chat'
                    );
                }
            } catch (\Exception $ne) {
                \Illuminate\Support\Facades\Log::error('Chat live message notification failed: ' . $ne->getMessage());
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function requestAdmin(ChatSession $session)
    {
        if (Auth::id() !== $session->user_id) {
            abort(403);
        }

        $session->switchToAdmin();

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender'          => 'bot',
            'message'         => "Anda telah terhubung dengan tim layanan kami. Mohon tunggu, admin akan segera merespons.\n\nApabila admin belum merespons dalam beberapa menit, silakan coba lagi nanti.",
        ]);

        // Kirim notifikasi ke admin
        try {
            $admins = \App\Models\User::whereHas('role', function($q) {
                $q->where('name', 'admin');
            })->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::send(
                    $admin->id,
                    'Bantuan Chat Admin Dibutuhkan',
                    "Pelanggan {$session->name} memerlukan bantuan live chat admin.",
                    'chat'
                );
            }
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Chat requestAdmin notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Admin akan segera membalas.');
    }

    public function fetchMessages(ChatSession $session)
    {
        if (Auth::id() !== $session->user_id) {
            abort(403);
        }

        $messages = $session->messages()->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages,
            'mode'     => $session->mode,
        ]);
    }

    private function generateBotReply(string $message): string
    {
        // Try database topics first (supports comma-separated keywords)
        $dbTopics = ChatTopic::active()->get();
        if ($dbTopics->isNotEmpty()) {
            foreach ($dbTopics as $topic) {
                // Split comma-separated keywords and check each one
                $keywords = array_map('trim', explode(',', strtolower($topic->keyword)));
                foreach ($keywords as $kw) {
                    if ($kw !== '' && str_contains($message, $kw)) {
                        return $topic->response;
                    }
                }
            }
        }

        // Fallback to hardcoded keywords (always checked if DB had no match)
        foreach ($this->keywords as $keyword => $reply) {
            if (str_contains($message, $keyword)) {
                return $reply;
            }
        }

        return "Mohon maaf, kami belum dapat memahami pertanyaan Anda.\n\nSilakan coba tanyakan mengenai:\n- \"event\" — Informasi event terbaru\n- \"daftar\" — Panduan registrasi\n- \"tiket\" — Informasi tiket\n- \"bayar\" — Informasi pembayaran\n- \"voucher\" — Informasi voucher dan diskon\n- \"poin\" — Informasi poin dan reward\n- \"checkin\" — Panduan check-in\n- \"feedback\" — Panduan memberikan review\n- \"produk\" — Koleksi premium\n- \"outlet\" — Lokasi outlet\n- \"profil\" — Kelola akun\n\nAtau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.";
    }
}
