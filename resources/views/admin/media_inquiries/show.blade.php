@extends('layouts.admin')

@section('title', 'Inquiry Detail')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.media.inquiries') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem;">← Kembali ke Daftar Inquiry</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <!-- INFORMASI PENGIRIM -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem; height: fit-content; display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">
            <h2 style="font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); margin: 0;">Pengirim</h2>
            @if(!$inquiry->is_read)
                <span class="badge-premium" style="background: rgba(239, 68, 68, 0.15); color: var(--red); border: 1px solid rgba(239, 68, 68, 0.2); font-size: 0.65rem;">
                    UNREAD
                </span>
            @else
                <span class="badge-premium" style="background: rgba(16, 185, 129, 0.15); color: var(--green); border: 1px solid rgba(16, 185, 129, 0.2); font-size: 0.65rem;">
                    READ
                </span>
            @endif
        </div>

        <div style="font-size: 0.85rem; display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Nama Lengkap</div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $inquiry->name }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Email Address</div>
                <div style="font-weight: 600; color: var(--gold); font-size: 0.9rem;">{{ $inquiry->email }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Nomor Telepon</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $inquiry->phone ?? '-' }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Organisasi Media</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $inquiry->organization ?? '-' }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Kategori Inquiry</div>
                <div style="font-weight: 600; color: var(--text-primary);"><span style="color: var(--gold);">{{ $inquiry->inquiry_type ?? '-' }}</span></div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Tanggal Masuk</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $inquiry->created_at->format('d M Y, H:i') }} WIB</div>
            </div>
        </div>
    </div>

    <!-- DETAIL PESAN & BALASAN -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- PESAN ASLI -->
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem;">
            <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Subjek Pesan</div>
            <h2 style="font-size: 1.15rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.25rem;">{{ $inquiry->subject ?? '-' }}</h2>

            <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Isi Pesan</div>
            <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); border-radius: 8px; padding: 1.25rem; color: var(--text-primary); font-size: 0.9rem; line-height: 1.6; white-space: pre-line;">{{ $inquiry->message }}</div>
        </div>

        <!-- RIWAYAT BALASAN -->
        @if($inquiry->replies->count())
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem; margin: 0;">Riwayat Balasan</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($inquiry->replies as $reply)
                    <div style="position: relative; padding-left: 1.5rem; border-left: 2px solid var(--gold);">
                        <div style="position: absolute; left: -5px; top: 2px; width: 8px; height: 8px; border-radius: 50%; background: var(--gold); box-shadow: 0 0 8px var(--gold);"></div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary); margin-bottom: 0.4rem; font-weight: 600;">
                            Admin membalas &bull; {{ $reply->created_at->format('d M Y, H:i') }} WIB
                        </div>
                        <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(212,175,55,0.1); border-radius: 8px; padding: 1rem; color: var(--text-primary); font-size: 0.85rem; line-height: 1.5; white-space: pre-line;">
                            {{ $reply->message }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- BALAS PESAN -->
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">Kirim Balasan Ke {{ $inquiry->name }}</h3>
            
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--green); padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.media.inquiries.reply', $inquiry->id) }}">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <textarea name="reply_message" rows="5" required placeholder="Tuliskan respon balasan di sini... (Akan langsung terkirim ke email pengirim)"
                        style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; resize: vertical; outline: none; font-family: inherit; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
                    ></textarea>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.75rem; color: var(--text-secondary);">Balasan Anda akan dikirim ke alamat email: <strong style="color: var(--gold);">{{ $inquiry->email }}</strong></span>
                    <button type="submit" class="btn-premium" style="padding: 0.65rem 1.5rem; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
                        KIRIM BALASAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
