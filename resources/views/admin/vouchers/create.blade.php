@extends('layouts.admin')

@section('title', 'Tambah Voucher dan Reward')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">

    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.vouchers.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="premium-card">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin: 0;">Tambah Voucher dan Reward</h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Buat kupon diskon atau merchandise hadiah penukaran poin baru.</p>
        </div>
        
        <div style="padding: 2rem;">
            <form method="POST" action="{{ route('admin.vouchers.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Type Selector -->
                <div style="margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Jenis Item</label>
                    <div style="display: flex; gap: 2.5rem; align-items: center;">
                        <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer; color: var(--text-primary); font-size: 0.9rem; user-select: none;">
                            <input type="radio" name="type" value="voucher" {{ old('type', 'voucher') === 'voucher' ? 'checked' : '' }} onchange="toggleType(this.value)" style="width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer;">
                            Voucher Diskon
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer; color: var(--text-primary); font-size: 0.9rem; user-select: none;">
                            <input type="radio" name="type" value="reward" {{ old('type') === 'reward' ? 'checked' : '' }} onchange="toggleType(this.value)" style="width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer;">
                            Reward / Merchandise
                        </label>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Common Fields -->
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem;">
                        <div>
                            <label for="title" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nama / Judul</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Voucher Diskon Kopi 20k"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                        <div>
                            <label for="points_required" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Poin Dibutuhkan</label>
                            <input type="number" id="points_required" name="points_required" value="{{ old('points_required') }}" min="0" required placeholder="0"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>

                    <!-- Voucher Fields -->
                    <div id="voucher-fields">
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label for="discount_type" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Tipe Diskon</label>
                                    <select id="discount_type" name="discount_type"
                                            style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                        <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="discount_value" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nilai Diskon</label>
                                    <input type="number" id="discount_value" name="discount_value" value="{{ old('discount_value') }}" min="0" placeholder="0"
                                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label for="max_uses" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Maks. Penggunaan</label>
                                    <input type="number" id="max_uses" name="max_uses" value="{{ old('max_uses') }}" min="0" placeholder="e.g. 100"
                                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                </div>
                                <div>
                                    <label for="min_purchase" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Min. Pembelian (Rp)</label>
                                    <input type="number" id="min_purchase" name="min_purchase" value="{{ old('min_purchase') }}" min="0" placeholder="e.g. 50000"
                                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label for="valid_from" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Berlaku Dari</label>
                                    <input type="date" id="valid_from" name="valid_from" value="{{ old('valid_from') }}"
                                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                </div>
                                <div>
                                    <label for="valid_until" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Berlaku Sampai</label>
                                    <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until') }}"
                                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reward Fields -->
                    <div id="reward-fields" style="display: none;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label for="stock" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Stok</label>
                                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0" placeholder="0"
                                       style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                            </div>
                            <div>
                                <label for="image" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Gambar Reward</label>
                                <input type="file" id="image" name="image" accept="image/*"
                                       style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                            </div>
                        </div>
                    </div>

                    <!-- Description & Status -->
                    <div>
                        <label for="description" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" placeholder="Detail deskripsi, syarat & ketentuan voucher atau reward..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s;">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="status" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Status</label>
                        <select id="status" name="status" required
                                style="width: 100%; max-width: 240px; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                @if($errors->any())
                    <div style="background:rgba(231,76,76,0.1); border:1px solid rgba(231,76,76,0.3); color:#E74C4C; padding:0.75rem 1rem; border-radius:8px; margin-top: 1.5rem; margin-bottom:1rem; font-size:0.85rem;">
                        @foreach($errors->all() as $error)<p style="margin: 0.2rem 0;">{{ $error }}</p>@endforeach
                    </div>
                @endif

                <div style="text-align: right; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2.5rem;">
                    <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; padding: 0.75rem 1rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Item Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleType(type) {
        const voucherFields = document.getElementById('voucher-fields');
        const rewardFields = document.getElementById('reward-fields');
        
        const voucherInputs = voucherFields.querySelectorAll('input, select, textarea');
        const rewardInputs = rewardFields.querySelectorAll('input, select, textarea');
        
        if (type === 'reward') {
            voucherFields.style.display = 'none';
            rewardFields.style.display = 'block';
            
            // Disable voucher fields so they are not sent or validated incorrectly
            voucherInputs.forEach(el => el.disabled = true);
            rewardInputs.forEach(el => el.disabled = false);
        } else {
            voucherFields.style.display = 'block';
            rewardFields.style.display = 'none';
            
            voucherInputs.forEach(el => el.disabled = false);
            rewardInputs.forEach(el => el.disabled = true);
        }
    }

    // Run on load to set initial state
    document.addEventListener('DOMContentLoaded', function() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        toggleType(selectedType);
    });
</script>
@endpush
@endsection
