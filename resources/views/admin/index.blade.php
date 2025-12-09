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

    <div class="dashboard-main">
        <div class="dash-breadcrumb">
            <a href="{{ url('/') }}">Home</a> &gt; Dashboard
        </div>

        <div class="dash-header">
            <a href="{{ route('campaigns.create') }}" class="btn-create-campaign">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Buat Campaign Baru
            </a>
        </div>

        <h3 class="section-title">Daftar Semua Campaign</h3>

        @if($campaigns->isEmpty())
            <div class="alert alert-info text-center">
                <p>Belum ada campaign yang tersedia.</p>
            </div>
        @else
            <div class="campaign-list">
                @foreach($campaigns as $campaign)
                <div class="dash-campaign-card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/' . $campaign['image']) }}" alt="{{ $campaign->title }}">
                    </div>

                    <div class="card-info">
                        <div>
                            <div class="card-header-row">
                                <h4 class="card-title">{{ $campaign->title }}</h4>
                                @if($campaign->status === 'active')
                                    <span class="card-status status-active">Aktif</span>
                                @elseif($campaign->status === 'finished')
                                    <span class="card-status status-finished">Selesai</span>
                                @else
                                    <span class="card-status status-draft">Draft</span>
                                @endif
                            </div>

                            <div class="org-info">
                                <span class="icon-org">🏢</span> {{ $campaign->organization_name }}
                                <span style="color: #0046FF">✔</span> </div>

                            <p class="card-desc">
                                {{ Str::limit($campaign->description, 120) }}
                            </p>

                            @php
                                $percentage = ($campaign->collected_amount / $campaign->target_amount) * 100;
                                $percentage = min(100, $percentage); // Cap at 100%
                            @endphp
                            <div class="custom-progress">
                                <div class="custom-progress-bar" style="width: {{ $percentage }}%;"></div>
                            </div>

                            <div class="stats-row">
                                <div class="stat-group">
                                    <strong>Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong>
                                    <span>Terkumpul</span>
                                </div>
                                <div class="stat-group text-right">
                                    <strong>{{ (int) max(0, $campaign->getDaysLeft()) }}</strong>
                                    <span>Hari Lagi</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('dashboard.campaigns.manage', $campaign->id) }}" class="btn-kelola">
                            Kelola Campaign
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
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
</script>
@endsection
