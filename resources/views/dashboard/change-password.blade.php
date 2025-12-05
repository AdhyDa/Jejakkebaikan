@extends('layouts.app')

@section('title', 'Ganti Password - Jejakkebaikan')

@section('content')
<div class="dashboard-layout">
    <div class="dashboard-sidebar">
        <h5 class="sidebar-title">Dashboard</h5>

        <div class="dashboard-menu">
            <a href="{{ route('dashboard.index') }}"
                class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Utama
            </a>

            <a href="{{ route('dashboard.profile') }}"
                class="menu-item {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Edit Profil
            </a>

            <a href="{{ route('dashboard.change-password') }}"
                class="menu-item {{ request()->routeIs('dashboard.change-password') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Ganti Password
            </a>

            <a href="#" class="menu-item text-danger" onclick="openLogoutModal(event)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Keluar
            </a>
        </div>
    </div>

    <div class="dashboard-main" style="background-color: #fff;">
        <div class="profile-header">
            <h3>Ganti Password</h3>
            <p>Ganti Password Sekarang!</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Password Lama</label>
                <div class="password-wrapper">
                    <input type="password" name="current_password" id="current_password"
                            class="form-input password-field"
                            placeholder="Masukkan Password Lama Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password', this)">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password"
                            class="form-input password-field"
                            placeholder="Masukkan Password Baru Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password', this)">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-input password-field"
                            placeholder="Konfirmasi Password Baru Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', this)">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-simpan">
                SIMPAN
            </button>
        </form>
    </div>
</div>

<div id="logoutModalOverlay" class="logout-overlay">
    <div class="logout-modal">
        <div class="modal-title">Konfirmasi</div>
        <div class="modal-text">Apakah anda yakin akan keluar?</div>
        <div class="modal-buttons">
            <button type="button" class="btn-modal no" onclick="closeLogoutModal()">TIDAK</button>
            <button type="button" class="btn-modal yes" onclick="submitLogout()">YA</button>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    // Fungsi Buka Modal
    function openLogoutModal(event) {
        event.preventDefault(); // Mencegah link pindah halaman / menambah #
        document.getElementById('logoutModalOverlay').classList.add('show');
    }

    // Fungsi Tutup Modal
    function closeLogoutModal() {
        document.getElementById('logoutModalOverlay').classList.remove('show');
    }

    // Fungsi Submit Logout
    function submitLogout() {
        document.getElementById('logout-form').submit();
    }

    // Toggle Password Visibility
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Tutup modal jika klik di area gelap luar kotak
    window.onclick = function(event) {
        const modal = document.getElementById('logoutModalOverlay');
        if (event.target == modal) {
            closeLogoutModal();
        }
    }

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        if (input.type === "password") {
            input.type = "text";
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'block';
        } else {
            input.type = "password";
            eyeOpen.style.display = 'block';
            eyeClosed.style.display = 'none';
        }
    }
</script>
@endsection
