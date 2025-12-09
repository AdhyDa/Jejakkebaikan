@php
    $currentRoute = Route::currentRouteName();
@endphp

<style>
    ul li a:hover {
        background-color: #f1f5f9;
        color: #1a56db;
    }

    ul li button:hover {
        background-color: #fee8e8;
        color: #b91c1c;
    }
</style>

<div class="dashboard-sidebar-user">
    <h3 class="sidebar-title-user">Dashboard</h3>

    <ul class="sidebar-menu-user">
        <li>
            <a href="{{ route('user.edit') }}"
                class="menu-link-user {{ Route::currentRouteName() == 'user.edit' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <span>Edit Profil</span>
            </a>
        </li>

        <li>
            <a href="{{ route('user.history') }}"
                class="menu-link-user {{ Route::currentRouteName() == 'user.history' ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history-icon lucide-history">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
                <span>Riwayat Donasi</span>
            </a>
        </li>

        <li>
            <a href="{{ route('user.change-password') }}"
                class="menu-link-user {{ Route::currentRouteName() == 'user.change-password' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Ganti Password</span>
            </a>
        </li>

        <li>
            <button type="button" class="menu-link-user text-danger btn-logout" onclick="openLogoutModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Keluar</span>
            </button>
        </li>

        <li>
            <a href="{{ route('dashboard.account.show') }}"
            class="menu-link-user text-danger {{ Route::currentRouteName() == 'dashboard.account.show' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-x-icon lucide-user-round-x">
                <path d="M2 21a8 8 0 0 1 11.873-7"/>
                <circle cx="10" cy="8" r="5"/>
                <path d="m17 17 5 5"/>
                <path d="m22 17-5 5"/>
            </svg>
            <span>Hapus Akun</span>
            </a>
        </li>
    </ul>
</div>

<div id="logoutModal" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <div class="modal-header">Konfirmasi</div>
        <div class="modal-body">Apakah anda yakin mau keluar?</div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeLogoutModal()">Batal</button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-confirm-logout">Keluar</button>
            </form>
        </div>
    </div>
</div>

<div id="deleteAccountModal" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <div class="modal-header" style="color: #dc3545;">Hapus Akun?</div>
        <div class="modal-body">
            Apakah Anda yakin ingin menghapus akun ini secara permanen?
            <br><small style="color: #666;">Data yang dihapus tidak dapat dikembalikan.</small>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <button class="btn-confirm-logout" style="background-color: #dc3545;" onclick="submitDeleteAccount()">Ya, Hapus</button>
        </div>
    </div>
</div>

<form id="delete-account-form" action="{{ route('dashboard.account.delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function openLogoutModal() {
        document.getElementById('logoutModal').classList.add('show');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.remove('show');
    }
    // Update window.onclick agar bisa menutup modal Logout
    window.onclick = function(e) {
        if(e.target.id === 'logoutModal') {
            document.getElementById('logoutModal').classList.remove('show');
        }
    }
</script>
