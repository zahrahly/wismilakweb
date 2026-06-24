@extends('layouts.admin')

@section('title', 'QR Check-in Scanner')

@push('styles')
<style>
    .scanner-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .scanner-hero {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.05) 0%, rgba(19, 19, 26, 0.4) 100%);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 3rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .viewport-wrapper {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto 2.5rem;
        aspect-ratio: 1;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid var(--card-border);
        background: #000;
        box-shadow: 0 0 40px rgba(0,0,0,0.4);
    }
    #qr-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .scan-viewfinder {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .scan-frame {
        width: 260px;
        height: 260px;
        border: 2px solid var(--gold);
        border-radius: 24px;
        position: relative;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);
    }
    .scan-frame::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gold);
        box-shadow: 0 0 15px var(--gold);
        animation: scanLine 2.5s infinite ease-in-out;
    }
    @keyframes scanLine {
        0%, 100% { top: 0; opacity: 0; }
        10%, 90% { opacity: 1; }
        50% { top: 100%; }
    }
    .scanner-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2rem;
    }
    .manual-input-box {
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    .result-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .result-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 3rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
        animation: cardIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-stop-scanner {
        transition: all 0.3s ease;
    }
    .btn-stop-scanner:not(:disabled):hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(231, 76, 76, 0.25);
        background: rgba(231,76,76,0.2) !important;
        color: #ff5f5f !important;
        border-color: rgba(231,76,76,0.4) !important;
    }
    .btn-stop-scanner:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }
    @keyframes cardIn {
        from { opacity: 0; transform: scale(0.9) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="scanner-container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.event.participants') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Data Peserta
        </a>
    </div>

    <div class="scanner-hero">
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">QR Check-in</h1>
        <p style="color: var(--text-secondary); font-size: 1rem; max-width: 500px; margin: 0 auto 3rem;">Arahkan kamera ke QR Code tiket peserta untuk memvalidasi kehadiran secara otomatis.</p>

        <div class="viewport-wrapper">
            <video id="qr-video" playsinline></video>
            <canvas id="qr-canvas" style="display:none;"></canvas>
            <div class="scan-viewfinder">
                <div class="scan-frame"></div>
            </div>
        </div>

        <div class="scanner-actions">
            <button id="start-btn" onclick="startScanner()" class="btn-premium" style="padding: 1rem 2.5rem; min-width: 220px; display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem; border-radius: 12px; font-size: 0.9rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                START SCANNER
            </button>
            <button id="stop-btn" onclick="stopScanner()" disabled style="background: rgba(231,76,76,0.1); border: 1px solid rgba(231,76,76,0.3); color: var(--red); padding: 1rem 2.5rem; border-radius: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem; min-width: 150px; font-size: 0.9rem;" class="btn-stop-scanner">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                STOP
            </button>
        </div>

        <div class="manual-input-box">
            <p style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Manual Entry</p>
            <div style="display: flex; gap: 1rem;">
                <input type="text" id="manual-input" placeholder="Masukkan Nomor Tiket..." style="flex: 1; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 10px; padding: 0.8rem 1.25rem; color: var(--text-primary); font-family: inherit;">
                <button onclick="processManual()" class="btn-premium" style="padding: 0 1.5rem; border-radius: 10px;">PROSES</button>
            </div>
        </div>
    </div>

    <div style="margin-top: 3rem;">
        <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; color: var(--text-primary); margin-bottom: 1.5rem;">Riwayat Kehadiran Terbaru</h2>
        <div id="recent-list" class="card" style="padding: 1.5rem; border: 1px solid var(--card-border); background: var(--card-bg);">
            @if($recentCheckins->isEmpty())
                <p style="color: var(--text-secondary); font-size: 0.9rem; text-align: center; padding: 2rem;">Belum ada aktivitas check-in.</p>
            @else
                @foreach($recentCheckins as $checkin)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--card-border);">
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $checkin->ticket->full_name ?? $checkin->ticket->user->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px;">{{ $checkin->ticket->ticket_number }} &bull; {{ $checkin->ticket->event->title }}</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: inline-block; padding: 2px 10px; background: rgba(16,185,129,0.1); color: var(--green); border-radius: 20px; font-size: 0.7rem; font-weight: 700;">
                                CHECKED-IN {{ $checkin->checked_in_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Result Overlay -->
<div id="result-overlay" class="result-overlay">
    <div id="result-card" class="result-card">
        <!-- Content injected by JS -->
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
let videoStream = null;
let scanning = false;
let animFrame = null;
let checkinHistory = [];

async function startScanner() {
    try {
        videoStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
        const video = document.getElementById('qr-video');
        video.srcObject = videoStream;
        video.play();
        scanning = true;
        document.getElementById('start-btn').disabled = true;
        document.getElementById('stop-btn').disabled = false;
        scanFrame();
    } catch (e) {
        alert('Tidak bisa mengakses kamera: ' + e.message);
    }
}

function stopScanner() {
    scanning = false;
    if (animFrame) cancelAnimationFrame(animFrame);
    if (videoStream) videoStream.getTracks().forEach(t => t.stop());
    document.getElementById('start-btn').disabled = false;
    document.getElementById('stop-btn').disabled = true;
}

function scanFrame() {
    if (!scanning) return;
    const video = document.getElementById('qr-video');
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
        const canvas = document.getElementById('qr-canvas');
        canvas.height = video.videoHeight;
        canvas.width = video.videoWidth;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);
        if (code) {
            stopScanner();
            processQR(code.data);
            return;
        }
    }
    animFrame = requestAnimationFrame(scanFrame);
}

function processManual() {
    const input = document.getElementById('manual-input').value.trim();
    if (!input) return;
    processQR(input);
}

async function processQR(data) {
    const overlay = document.getElementById('result-overlay');
    const card = document.getElementById('result-card');
    overlay.style.display = 'flex';
    card.innerHTML = `<div style="padding: 2rem;"><p style="color:var(--text-secondary);">Validating ticket signature...</p></div>`;

    try {
        const res = await fetch('{{ route("admin.checkin.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ qr_data: data }),
        });

        const result = await res.json();

        if (result.success) {
            let rewardHtml = '';
            if (result.ticket.reward) {
                rewardHtml = `
                    <div style="text-align: left; background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.25); border-radius: 16px; padding: 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; margin-bottom: 0.25rem;">Hadiah Merchandise</div>
                            <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">${result.ticket.reward}</div>
                            <div style="font-size: 0.75rem; color: var(--green); font-weight: 500; margin-top: 2px;">(Berhasil Diklaim)</div>
                        </div>
                    </div>
                `;
            }

            card.innerHTML = `
                <div style="width: 80px; height: 80px; background: rgba(16,185,129,0.1); color: var(--green); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.75rem; color: var(--text-primary); margin-bottom: 1rem;">Access Granted</h2>
                <p style="color: var(--text-secondary); margin-bottom: 2.5rem;">${result.message}</p>
                <div style="text-align: left; background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.5rem; margin-bottom: ${result.ticket.reward ? '1rem' : '2rem'};">
                    <div style="font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; margin-bottom: 0.5rem;">Attendee Information</div>
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 1.1rem; margin-bottom: 0.25rem;">${result.ticket.user}</div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">${result.ticket.number} &bull; ${result.ticket.event}</div>
                </div>
                ${rewardHtml}
                <button onclick="closeOverlay()" class="btn-gold" style="width: 100%; padding: 1rem;">CONTINUE SCANNING</button>
            `;
            addToHistory(result.ticket, true);
        } else {
            card.innerHTML = `
                <div style="width: 80px; height: 80px; background: rgba(231,76,76,0.1); color: var(--red); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.75rem; color: var(--text-primary); margin-bottom: 1rem;">Access Denied</h2>
                <p style="color: var(--red); font-weight: 500; margin-bottom: 2.5rem;">${result.message}</p>
                <button onclick="closeOverlay()" style="width: 100%; padding: 1rem; border-radius: 12px; border: 1px solid var(--card-border); background: transparent; color: var(--text-primary); font-weight: 600; cursor: pointer;">TRY AGAIN</button>
            `;
        }
    } catch (e) {
        card.innerHTML = `<p style="color:var(--red);">Communication Error. Please check your connection.</p><button onclick="closeOverlay()" class="btn-gold" style="margin-top:1rem; padding:0.5rem 1.5rem;">OK</button>`;
    }
}

function closeOverlay() {
    document.getElementById('result-overlay').style.display = 'none';
    document.getElementById('manual-input').value = '';
}

function addToHistory(ticket, success) {
    const time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
    checkinHistory.unshift({...ticket, time, success});
    renderHistory();
}

function renderHistory() {
    const list = document.getElementById('recent-list');
    if (checkinHistory.length === 0) return;
    list.innerHTML = checkinHistory.map(h => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--card-border);">
            <div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">${h.user}</div>
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px;">${h.number} &bull; ${h.event}</div>
            </div>
            <div style="text-align: right;">
                <span style="display: inline-block; padding: 2px 10px; background: rgba(16,185,129,0.1); color: var(--green); border-radius: 20px; font-size: 0.7rem; font-weight: 700;">
                    CHECKED-IN ${h.time}
                </span>
            </div>
        </div>
    `).join('');
}
</script>
@endpush
