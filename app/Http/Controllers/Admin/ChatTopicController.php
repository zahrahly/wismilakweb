<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatTopic;
use Illuminate\Http\Request;

class ChatTopicController extends Controller
{
    public function index()
    {
        $topics = ChatTopic::orderBy('category')->orderBy('sort_order')->get();
        $categories = ChatTopic::distinct()->pluck('category');
        return view('admin.chat-topics.index', compact('topics', 'categories'));
    }

    public function create()
    {
        $categories = ChatTopic::distinct()->pluck('category');
        return view('admin.chat-topics.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keyword'       => 'required|string|max:255|unique:chat_topics,keyword',
            'response'      => 'required|string',
            'category'      => 'required|string|max:50',
            'is_escalation' => 'boolean',
            'sort_order'    => 'integer|min:0',
        ]);

        $validated['is_escalation'] = $request->boolean('is_escalation');
        $validated['is_active'] = true;

        ChatTopic::create($validated);

        return redirect()->route('admin.chat-topics.index')
            ->with('success', 'Topik chat berhasil ditambahkan.');
    }

    public function edit(ChatTopic $chatTopic)
    {
        $categories = ChatTopic::distinct()->pluck('category');
        return view('admin.chat-topics.edit', compact('chatTopic', 'categories'));
    }

    public function update(Request $request, ChatTopic $chatTopic)
    {
        $validated = $request->validate([
            'keyword'       => 'required|string|max:255|unique:chat_topics,keyword,' . $chatTopic->id,
            'response'      => 'required|string',
            'category'      => 'required|string|max:50',
            'is_escalation' => 'boolean',
            'sort_order'    => 'integer|min:0',
            'is_active'     => 'boolean',
        ]);

        $validated['is_escalation'] = $request->boolean('is_escalation');
        $validated['is_active'] = $request->boolean('is_active');

        $chatTopic->update($validated);

        return redirect()->route('admin.chat-topics.index')
            ->with('success', 'Topik chat berhasil diperbarui.');
    }

    public function destroy(ChatTopic $chatTopic)
    {
        $chatTopic->delete();

        return back()->with('success', 'Topik chat berhasil dihapus.');
    }

    /**
     * Seed default topics from hardcoded keywords
     */
    public function seedDefaults()
    {
        ChatTopic::truncate();

        $defaults = [
            ['keyword' => 'halo, hallo, helo, hi, hei, permisi, pagi, siang, sore, malam, assalamualaikum', 'response' => "Halo! 👋 Selamat datang di Wismilak. Ada yang bisa saya bantu?\n\nAnda bisa bertanya tentang:\n• Event & Registrasi\n• Tiket & Pembayaran\n• Voucher & Diskon\n• Produk & Outlet\n• Reward & Poin\n\nAtau ketik \"admin\" untuk bicara langsung dengan tim kami.", 'category' => 'greeting'],
            ['keyword' => 'hello, welcome', 'response' => "Hello! 👋 Welcome to Wismilak. How can I help you?", 'category' => 'greeting'],
            ['keyword' => 'event, kalender, jadwal, acara, sisa kuota, kuota', 'response' => "Untuk melihat event terbaru:\n1. Buka menu **Event** di navbar\n2. Pilih Calendar View atau Event List\n3. Klik event untuk detail & registrasi\n\nSetiap event memiliki kuota terbatas, jadi daftar sekarang!", 'category' => 'event'],
            ['keyword' => 'daftar, registrasi, register, ikut, join, gabung', 'response' => "Cara mendaftar event:\n1. Buka halaman event yang diminati\n2. Klik \"Register Now\"\n3. Isi data peserta\n4. Gunakan voucher jika ada\n5. Lanjutkan ke pembayaran", 'category' => 'event'],
            ['keyword' => 'tiket, ticket, pdf, qr, barcode, download tiket', 'response' => "Informasi tiket:\n• Tiket otomatis dibuat setelah pembayaran sukses\n• Download tiket PDF dari halaman **Riwayat Transaksi**\n• Tiket memiliki QR code untuk check-in di event", 'category' => 'ticket'],
            ['keyword' => 'bayar, pembayaran, midtrans, transfer, e-wallet, qris, gopay, shopeepay', 'response' => "Informasi pembayaran:\n• Pembayaran melalui Midtrans (transfer bank, e-wallet, dll)\n• Batas waktu pembayaran: 30 menit\n• Status otomatis terupdate setelah pembayaran", 'category' => 'payment'],
            ['keyword' => 'voucher, diskon, promo, kode voucher, potongan', 'response' => "Tentang voucher:\n• Tukar poin Anda dengan voucher di **Dashboard**\n• Gunakan kode voucher saat registrasi event\n• Cek masa berlaku voucher sebelum digunakan", 'category' => 'voucher'],
            ['keyword' => 'poin, point, reward, hadiah, tukar poin', 'response' => "Cara mendapatkan poin:\n• Registrasi event gratis: +5 poin\n• Pembayaran event: +10 poin per tiket\n• Memberikan feedback: +15 poin per tiket\n\nTukar poin dengan voucher di Dashboard!", 'category' => 'reward'],
            ['keyword' => 'produk, cigar, cerutu, koleksi, collection, premium', 'response' => "Lihat koleksi premium kami di menu **Collection**.\nSetiap produk memiliki detail spesifikasi lengkap.", 'category' => 'product'],
            ['keyword' => 'outlet, toko, alamat, lokasi, find us, map, peta, jam buka, operasional', 'response' => "Temukan outlet terdekat di menu **Find Us**.\nSetiap outlet memiliki alamat, jam operasional, dan peta lokasi.", 'category' => 'outlet'],
            ['keyword' => 'feedback, review, ulasan, rating, bintang, komentar', 'response' => "Tentang feedback:\n• Berikan feedback setelah semua tiket di check-in\n• Dapatkan +15 poin per tiket\n• Rating 1-5 bintang + komentar", 'category' => 'feedback'],
            ['keyword' => 'checkin, check-in, scanner, scan, masuk', 'response' => "Informasi check-in:\n• Tunjukkan tiket PDF/QR code saat datang ke event\n• Staff akan scan QR code Anda\n• Check-in wajib untuk mendapatkan poin feedback", 'category' => 'checkin'],
            ['keyword' => 'admin, bantuan, help, cs, customer service, hubungi, komplain, keluhan, tanya staff', 'response' => "Saya akan menghubungkan Anda dengan admin. Mohon tunggu sebentar...", 'category' => 'escalation', 'is_escalation' => true],
        ];

        foreach ($defaults as $i => $topic) {
            ChatTopic::create(array_merge($topic, [
                'sort_order' => $i,
                'is_escalation' => $topic['is_escalation'] ?? false,
                'is_active' => true,
            ]));
        }

        return back()->with('success', 'Topik default berhasil ditambahkan.');
    }
}
