<div class="notification-dropdown-wrapper" style="position: relative; display: inline-block;">
    <button type="button" id="notifBellBtn" class="notif-bell-btn" style="background: none; border: none; cursor: pointer; position: relative; padding: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--text-secondary, #aaa); transition: color 0.3s; outline: none;">
        <svg style="width: 22px; height: 22px; stroke: currentColor;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @php
            $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
        @endphp
        @if($unreadCount > 0)
            <span class="notif-badge" style="position: absolute; top: 0px; right: 0px; background: #EF4444; color: white; border-radius: 50%; font-size: 0.6rem; font-weight: 700; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; border: 1.5px solid var(--charcoal, #0D0805); box-shadow: 0 2px 5px rgba(0,0,0,0.5);">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div id="notifDropdownMenu" class="notif-dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 320px; background: #120c08; border: 1px solid var(--card-border, rgba(212, 175, 55, 0.15)); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); z-index: 10000; overflow: hidden; animation: notifFadeIn 0.2s ease;">
        <div style="padding: 1rem; border-bottom: 1px solid rgba(212, 175, 55, 0.1); display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.2);">
            <span style="font-weight: 700; color: #fff; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase;">Notifikasi</span>
            @if($unreadCount > 0)
                <a href="javascript:void(0)" onclick="markAllNotificationsRead(event)" style="font-size: 0.7rem; color: var(--gold, #D4AF37); text-decoration: none; font-weight: 600;">Tandai semua dibaca</a>
            @endif
        </div>
        <div style="max-height: 280px; overflow-y: auto;">
            @php
                $recentNotifications = auth()->user()->notifications()->take(5)->get();
            @endphp
            @if($recentNotifications->isEmpty())
                <div style="padding: 2.5rem 1rem; text-align: center; color: #777; font-size: 0.8rem;">
                    Tidak ada notifikasi baru
                </div>
            @else
                @foreach($recentNotifications as $notif)
                    <div style="padding: 0.85rem 1rem; border-bottom: 1px solid rgba(212, 175, 55, 0.05); background: {{ $notif->is_read ? 'transparent' : 'rgba(212, 175, 55, 0.04)' }}; display: flex; gap: 0.75rem; align-items: flex-start; transition: background 0.2s;">
                        <div style="margin-top: 0.25rem; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; background: {{ $notif->is_read ? 'transparent' : 'var(--gold, #D4AF37)' }}"></div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.8rem; font-weight: 600; color: #fff; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $notif->title }}</div>
                            <div style="font-size: 0.7rem; color: #bbb; margin-top: 0.25rem; line-height: 1.3;">{{ $notif->message }}</div>
                            <div style="font-size: 0.6rem; color: #666; margin-top: 0.35rem;">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <a href="{{ route('notifications.index') }}" style="display: block; text-align: center; padding: 0.75rem; background: rgba(0,0,0,0.3); color: var(--gold, #D4AF37); text-decoration: none; font-size: 0.75rem; font-weight: 700; border-top: 1px solid rgba(212, 175, 55, 0.1); transition: background 0.2s;">
            Lihat Semua
        </a>
    </div>
</div>

<style>
    @keyframes notifFadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    if (typeof markAllNotificationsRead !== 'function') {
        window.markAllNotificationsRead = function(e) {
            if (e) e.stopPropagation();
            fetch('{{ route("notifications.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        };
    }

    // Toggle dropdown
    (function() {
        const setupNotifDropdown = () => {
            const bellBtn = document.getElementById('notifBellBtn');
            const dropdownMenu = document.getElementById('notifDropdownMenu');

            if (bellBtn && dropdownMenu) {
                // Remove old event listener to prevent duplicate attachment
                const newBellBtn = bellBtn.cloneNode(true);
                bellBtn.parentNode.replaceChild(newBellBtn, bellBtn);

                newBellBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (dropdownMenu.style.display === 'none' || !dropdownMenu.style.display) {
                        dropdownMenu.style.display = 'block';
                        newBellBtn.style.color = 'var(--gold, #D4AF37)';
                    } else {
                        dropdownMenu.style.display = 'none';
                        newBellBtn.style.color = 'var(--text-secondary, #aaa)';
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!dropdownMenu.contains(e.target) && !newBellBtn.contains(e.target)) {
                        dropdownMenu.style.display = 'none';
                        newBellBtn.style.color = 'var(--text-secondary, #aaa)';
                    }
                });
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupNotifDropdown);
        } else {
            setupNotifDropdown();
        }
    })();
</script>
