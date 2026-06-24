@extends('layouts.dashboard')

@section('title', 'QR Check-in Scanner')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
        <div>
            <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">QR Check-in</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">Validasi tiket peserta secara real-time menggunakan kamera perangkat.</p>
        </div>
        <div style="min-width: 200px;">
            <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-dim);">Filter Event</label>
            <select onchange="window.location='?event_id='+this.value" class="form-input" style="width: 100%; padding: 0.65rem;">
                <option value="">Semua Event Saya</option>
                @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>
                        {{ Str::limit($ev->title, 25) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        {{-- LEFT: Scanner --}}
        <div>
            <div class="premium-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Video preview -->
                <div style="position: relative; background: #000; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; aspect-ratio: 1/1; border: 1px solid var(--card-border);">
                    <video id="qr-video" style="width: 100%; height: 100%; object-fit: cover;" playsinline></video>
                    <canvas id="qr-canvas" style="display: none;"></canvas>
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none;">
                        <div id="scan-frame" style="width: 70%; height: 70%; border: 2px solid var(--gold); border-radius: 20px; box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);">
                            <div style="position: absolute; top: -5px; left: -5px; width: 30px; height: 30px; border-top: 4px solid var(--gold); border-left: 4px solid var(--gold); border-radius: 10px 0 0 0;"></div>
                            <div style="position: absolute; top: -5px; right: -5px; width: 30px; height: 30px; border-top: 4px solid var(--gold); border-right: 4px solid var(--gold); border-radius: 0 10px 0 0;"></div>
                            <div style="position: absolute; bottom: -5px; left: -5px; width: 30px; height: 30px; border-bottom: 4px solid var(--gold); border-left: 4px solid var(--gold); border-radius: 0 0 0 10px;"></div>
                            <div style="position: absolute; bottom: -5px; right: -5px; width: 30px; height: 30px; border-bottom: 4px solid var(--gold); border-right: 4px solid var(--gold); border-radius: 0 0 10px 0;"></div>
                        </div>
                    </div>
                    <div id="scanner-overlay" style="position: absolute; inset: 0; background: rgba(0,0,0,0.8); display: flex; align-items: center; justify-content: center; z-index: 10;">
                        <div style="text-align: center;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--gold); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; color: #000; box-shadow: 0 0 20px var(--gold-dim);">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p style="color: var(--text-primary); font-size: 0.85rem; font-weight: 600;">Kamera Nonaktif</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button id="start-btn" onclick="startScanner()" class="btn-premium" style="flex: 1; justify-content: center; padding: 1rem;">
                        MULAI SCANNER
                    </button>
                    <button id="stop-btn" onclick="stopScanner()" disabled class="btn-premium" style="flex: 1; justify-content: center; padding: 1rem; background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);">
                        BERHENTI
                    </button>
                </div>
            </div>

            <div class="premium-card" style="padding: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 1rem; font-size: 0.75rem;">Input Tiket Manual</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" id="manual-input" placeholder="TCK-ABCDEF1234" class="form-input" style="flex: 1;">
                    <button onclick="processManual()" class="btn-premium" style="padding: 0 1.5rem;">PROSES</button>
                </div>
            </div>
        </div>

        {{-- RIGHT: Result & History --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div id="result-panel" style="display: none;">
                <div id="result-card" class="premium-card" style="padding: 1.5rem; border: 1px solid var(--gold-dim); background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.05), transparent); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                    <div id="result-title" style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--gold);">Hasil Check-in</div>
                    <div id="result-body"></div>
                </div>
            </div>

            <div class="premium-card" style="flex: 1; display: flex; flex-direction: column;">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">Riwayat Scan Hari Ini</h3>
                    <span id="scan-count" style="font-size: 0.7rem; color: var(--gold); font-weight: 700;">{{ $recentCheckins->count() }} SCAN</span>
                </div>
                <div style="flex: 1; overflow-y: auto; max-height: 400px; padding: 1rem;" id="recent-list">
                    @forelse($recentCheckins as $checkin)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-radius: 10px; background: rgba(255,255,255,0.02); margin-bottom: 0.75rem; border: 1px solid var(--card-border);">
                            <div style="flex: 1; overflow: hidden;">
                                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $checkin->ticket->full_name ?? $checkin->ticket->user->name }}
                                </div>
                                <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px;">
                                    <span style="color: var(--gold-dim);">{{ $checkin->ticket->ticket_number }}</span> — {{ Str::limit($checkin->ticket->event->title, 20) }}
                                </div>
                            </div>
                            <div style="text-align: right; margin-left: 1rem;">
                                <div style="font-size: 0.75rem; font-weight: 700; color: var(--green);">{{ $checkin->checked_in_at->format('H:i') }}</div>
                                <div style="font-size: 0.65rem; color: var(--gold); font-weight: 600; margin-top: 2px;">+{{ $checkin->points_awarded }} pts</div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 3rem 1rem; text-align: center; color: var(--text-secondary);">
                            <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.1; margin-bottom: 1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            <p style="font-size: 0.8rem;">Belum ada check-in hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
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
        const overlay = document.getElementById('scanner-overlay');
        
        video.srcObject = videoStream;
        video.onloadedmetadata = () => {
            video.play();
            overlay.style.display = 'none';
        };
        
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
    document.getElementById('scanner-overlay').style.display = 'flex';
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
    if (data.startsWith('data=')) data = data.replace('data=', '');
    if (data.includes('/')) data = data.split('/').pop();

    const panel = document.getElementById('result-panel');
    const body = document.getElementById('result-body');
    const title = document.getElementById('result-title');
    const card = document.getElementById('result-card');

    // Reset card style to loading state
    card.style.borderColor = 'var(--gold-dim)';
    card.style.background = 'radial-gradient(circle at top right, rgba(212, 175, 55, 0.05), transparent)';
    card.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.2)';
    title.innerHTML = '<span style="color: var(--gold);">Hasil Check-in</span>';

    panel.style.display = 'block';
    body.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--text-secondary); font-size: 0.85rem; padding: 0.5rem 0;">
            <svg class="animate-spin" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Memproses data tiket...
        </div>`;

    try {
        const res = await fetch('{{ route("partner.checkin.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ qr_data: data }),
        });

        const result = await res.json();

        if (result.success) {
            // Apply green success styling to the outer card
            card.style.borderColor = 'rgba(16, 185, 129, 0.3)';
            card.style.background = 'radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent)';
            card.style.boxShadow = '0 10px 30px rgba(16, 185, 129, 0.15)';

            title.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--green);">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="filter: drop-shadow(0 0 5px var(--green));"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="font-family: 'Crimson Pro', serif; font-size: 1.35rem; font-weight: 700;">Check-in Berhasil</span>
                </div>`;
            
            let rewardHtml = '';
            if (result.ticket.reward) {
                rewardHtml = `
                    <div style="background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.25); border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.5rem; line-height: 1;">🎁</span>
                        <div style="text-align: left;">
                            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; margin-bottom: 0.25rem;">Hadiah Merchandise</div>
                            <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">${result.ticket.reward}</div>
                            <div style="font-size: 0.75rem; color: var(--green); font-weight: 500; margin-top: 2px;">(Berhasil Diklaim)</div>
                        </div>
                    </div>
                `;
            }

            body.innerHTML = `
                <div style="display: flex; flex-direction: column; gap: 1rem; animation: slideIn 0.3s ease-out;">
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(16,185,129,0.1); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; border: 1px solid rgba(16,185,129,0.2);">
                            ${result.ticket.user.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-primary); font-size: 1.05rem; letter-spacing: -0.01em;">${result.ticket.user}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 1px;">Peserta Terverifikasi</div>
                        </div>
                    </div>
                    
                    ${rewardHtml}
                    
                    <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.25rem; display: grid; gap: 0.75rem; font-size: 0.85rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-secondary);">Kode Tiket</span>
                            <span style="font-family: monospace; font-weight: 700; color: var(--gold); background: rgba(212,175,55,0.08); padding: 0.2rem 0.6rem; border-radius: 6px; border: 1px solid rgba(212,175,55,0.15);">${result.ticket.number}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                            <span style="color: var(--text-secondary);">Event</span>
                            <span style="color: var(--text-primary); font-weight: 600; text-align: right; font-size: 0.9rem;">${result.ticket.event}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-secondary);">Apresiasi Poin</span>
                            <span style="color: var(--gold); font-weight: 800; font-size: 0.95rem; display: flex; align-items: center; gap: 0.25rem;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" style="color: var(--gold);"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                +${result.ticket.points} PTS
                            </span>
                        </div>
                    </div>
                </div>`;
            addToHistory(result.ticket, true);
        } else {
            // Apply red warning styling to the outer card
            card.style.borderColor = 'rgba(231, 76, 76, 0.3)';
            card.style.background = 'radial-gradient(circle at top right, rgba(231, 76, 76, 0.08), transparent)';
            card.style.boxShadow = '0 10px 30px rgba(231, 76, 76, 0.15)';

            title.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--red);">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="filter: drop-shadow(0 0 5px var(--red));"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span style="font-family: 'Crimson Pro', serif; font-size: 1.35rem; font-weight: 700;">Check-in Gagal</span>
                </div>`;

            body.innerHTML = `
                <div style="display: flex; flex-direction: column; gap: 1rem; animation: slideIn 0.3s ease-out;">
                    <div style="background: rgba(231,76,76,0.05); border: 1px solid rgba(231,76,76,0.15); border-radius: 12px; padding: 1.25rem; color: #ff8e8e; font-size: 0.9rem; font-weight: 500; line-height: 1.5; display: flex; gap: 0.75rem; align-items: flex-start;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--red); flex-shrink: 0; margin-top: 1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <div style="font-weight: 700; color: #fff; margin-bottom: 3px; font-size: 0.95rem;">Gagal Validasi</div>
                            ${result.message}
                        </div>
                    </div>
                    
                    ${result.ticket ? `
                    <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.25rem; display: grid; gap: 0.75rem; font-size: 0.85rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-secondary);">Kode Tiket</span>
                            <span style="font-family: monospace; font-weight: 700; color: var(--gold); background: rgba(212,175,55,0.08); padding: 0.2rem 0.6rem; border-radius: 6px; border: 1px solid rgba(212,175,55,0.15);">${result.ticket.number}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-secondary);">Nama Peserta</span>
                            <span style="color: var(--text-primary); font-weight: 600;">${result.ticket.user}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                            <span style="color: var(--text-secondary);">Event</span>
                            <span style="color: var(--text-primary); font-weight: 600; text-align: right; font-size: 0.9rem;">${result.ticket.event}</span>
                        </div>
                    </div>` : ''}
                </div>`;
        }
    } catch (e) {
        card.style.borderColor = 'rgba(231, 76, 76, 0.3)';
        card.style.background = 'radial-gradient(circle at top right, rgba(231, 76, 76, 0.08), transparent)';
        title.innerHTML = `
            <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--red);">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span style="font-family: 'Crimson Pro', serif; font-size: 1.35rem; font-weight: 700;">Kesalahan Koneksi</span>
            </div>`;
        body.innerHTML = `
            <div style="background: rgba(231,76,76,0.05); border: 1px solid rgba(231,76,76,0.15); border-radius: 12px; padding: 1.25rem; color: #ff8e8e; font-size: 0.85rem; display: flex; gap: 0.5rem; align-items: center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Terjadi kesalahan koneksi. Silakan periksa jaringan Anda dan coba lagi.
            </div>`;
    }

    setTimeout(() => {
        document.getElementById('manual-input').value = '';
    }, 1000);
}

function addToHistory(ticket, success) {
    const time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
    checkinHistory.unshift({...ticket, time, success});
    renderHistory();
}

function renderHistory() {
    const list = document.getElementById('recent-list');
    if (checkinHistory.length === 0) return;
    
    // Simple update to the count display if we have new items
    const countEl = document.getElementById('scan-count');
    const baseCount = parseInt('{{ $recentCheckins->count() }}');
    countEl.textContent = (baseCount + checkinHistory.length) + ' SCAN';

    let html = '';
    // Prepend new history items
    checkinHistory.forEach(h => {
        html += `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-radius: 10px; background: rgba(16,185,129,0.05); margin-bottom: 0.75rem; border: 1px solid rgba(16,185,129,0.2); animation: slideIn 0.3s ease-out;">
                <div style="flex: 1; overflow: hidden;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${h.user}</div>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px;">
                        <span style="color: var(--gold-dim);">${h.number}</span> — ${h.event}
                    </div>
                </div>
                <div style="text-align: right; margin-left: 1rem;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: var(--green);">${h.time}</div>
                    <div style="font-size: 0.65rem; color: var(--gold); font-weight: 600; margin-top: 2px;">+${h.points} pts</div>
                </div>
            </div>`;
    });
    
    // Re-render the initial items from server (this is a simplified approach)
    @foreach($recentCheckins as $checkin)
        html += `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-radius: 10px; background: rgba(255,255,255,0.02); margin-bottom: 0.75rem; border: 1px solid var(--card-border);">
                <div style="flex: 1; overflow: hidden;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $checkin->ticket->full_name ?? $checkin->ticket->user->name }}
                    </div>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px;">
                        <span style="color: var(--gold-dim);">{{ $checkin->ticket->ticket_number }}</span> — {{ Str::limit($checkin->ticket->event->title, 20) }}
                    </div>
                </div>
                <div style="text-align: right; margin-left: 1rem;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: var(--green);">{{ $checkin->checked_in_at->format('H:i') }}</div>
                    <div style="font-size: 0.65rem; color: var(--gold); font-weight: 600; margin-top: 2px;">+{{ $checkin->points_awarded }} pts</div>
                </div>
            </div>`;
    @endforeach

    list.innerHTML = html;
}
</script>

<style>
@keyframes slideIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
.animate-spin { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush
