@extends('layouts.app')

@section('title', 'Kelola Campaign - ' . $campaign->title)

@push('styles')
<style>
    /* --- RESET & BASE STYLES --- */
    body {
        background-color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #000;
    }

    /* --- 1. BAGIAN ATAS: TABS KISAH & BERITA --- */
    .top-tabs-container {
        display: flex;
        width: 100%;
        margin-top: 20px;
    }

    .top-tab {
        width: 50%;
        text-align: center;
        padding: 12px 0;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #000;
    }

    .top-tab.active {
        background-color: #fff;
        color: #000;
        border-bottom: 1px solid #fff;
        font-weight: 600;
        position: relative;
        z-index: 10;
        top: 1px;
    }

    .top-tab.inactive {
        background-color: #d1d5db;
        color: #333;
        border-left: none;
    }

    .story-container {
        border: 1px solid #000;
        padding: 25px;
        background: #fff;
        min-height: 150px;
        position: relative;
        z-index: 5;
    }

    .story-title {
        font-weight: 800;
        font-size: 16px;
        margin-bottom: 10px;
        color: #000;
    }

    .story-text {
        font-size: 13px;
        line-height: 1.5;
        text-align: justify;
        color: #333;
    }

    /* --- 2. BAGIAN BAWAH: DONATUR LIST --- */
    .section-header {
        color: #0d6efd;
        font-size: 18px;
        font-weight: 500;
        margin-top: 40px;
        margin-bottom: 15px;
    }

    .donor-wrapper {
        border: 1px solid #999;
        border-radius: 2px;
        overflow: hidden;
    }

    .donor-nav {
        display: flex;
        background: #fff;
        border-bottom: 1px solid #ccc;
    }

    .donor-nav-item {
        flex: 1;
        text-align: center;
        padding: 15px 0;
        font-size: 14px;
        color: #555;
        cursor: pointer;
        position: relative;
        font-weight: 500;
    }

    .donor-nav-item.active {
        color: #0d6efd;
        font-weight: 700;
    }

    .donor-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: #0d6efd;
    }

    .donor-list-background {
        background-color: #e3ecfa;
        padding: 10px 0;
        min-height: 200px;
    }

    /* Styles untuk Row Donatur */
    .donor-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 15px 25px;
    }

    .row-left {
        display: flex;
        gap: 15px;
    }

    .icon-avatar {
        font-size: 34px;
        color: #111827;
        margin-top: -5px;
    }

    .info-box {
        display: flex;
        flex-direction: column;
    }

    .info-name {
        font-weight: 800;
        font-size: 14px;
        color: #142850;
    }

    .info-detail {
        font-size: 13px;
        color: #142850;
        margin-top: 2px;
    }

    .row-right {
        text-align: left;
        min-width: 220px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Checkbox & Status Styles */
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        margin-bottom: 3px;
    }

    .hidden-cb { display: none; }

    .custom-cb-box {
        width: 20px;
        height: 20px;
        border: 2px solid #0d6efd;
        border-radius: 4px;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .hidden-cb:checked + .custom-cb-box {
        background-color: #0d6efd;
    }

    .hidden-cb:checked + .custom-cb-box::after {
        content: '✓';
        color: #fff;
        font-size: 14px;
        font-weight: bold;
    }

    .cb-text {
        font-size: 13px;
        color: #142850;
    }

    .status-msg {
        font-size: 12px;
        margin-left: 30px;
        font-style: italic;
        color: #142850;
    }

    .status-msg.received {
        color: #142850;
        font-style: normal;
    }

    .status-simple {
        font-size: 13px;
        font-weight: 600;
        color: #142850;
    }

</style>
@endpush

@section('content')
<div class="container my-5" style="max-width: 850px;">

    <div style="font-size: 12px; font-weight: 700; margin-bottom: 25px;">
        <a href="{{ route('home') }}" style="text-decoration: none; color: #000;">Home</a>
        <span style="margin: 0 5px;">></span>
        <a href="{{ route('dashboard.index') }}" style="text-decoration: none; color: #000;">Dashboard</a>
        <span style="margin: 0 5px;">></span>
        <span style="color: #555;">Kelola Campaign</span>
    </div>

    <h1 style="color: #142850; font-weight: 800; font-size: 24px; margin-bottom: 10px;">Kelola Campaign: {{ $campaign->title }}</h1>

    <div style="font-size: 13px; font-weight: 500; color: #333;">
        <div>
            Status : <a href="#" style="color: #4A90E2; text-decoration: underline; font-weight: 600;">{{ ucfirst($campaign->status) }}</a>
        </div>
        <div style="margin-top: 2px;">
            Sisa Waktu : <strong>{{ max(0, ceil($campaign->getDaysLeft())) }} Hari</strong>
        </div>
    </div>

    <br>

    @if($campaign->image)
        <img src="{{ asset('storage/' . $campaign->image) }}"
            style="width: 100%; height: 250px; object-fit: contain; background-color: #f0f0f0;"
            alt="Campaign">
    @else
        <div style="background-color: #d9d9d9; width: 100%; height: 250px;"></div>
    @endif

    <div class="top-tabs-container">
        <div class="top-tab active" id="tab-kisah" onclick="openTopTab('kisah')">Kisah</div>
        <div class="top-tab inactive" id="tab-berita" onclick="openTopTab('berita')">Berita ({{ $campaign->updates->count() }})</div>
    </div>

    <div class="story-container">
        <div id="content-kisah">
            <h3 class="story-title">Judul Kampanye</h3>
            <div class="story-text">
                {{ $campaign->description }}
            </div>
        </div>

        <div id="content-berita" style="display: none;">
            @forelse($campaign->updates as $update)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $update->title }}</strong> <br>
                    <small class="text-muted">{{ $update->created_at->format('d M Y') }}</small>
                    <p class="story-text mt-2">{{ $update->content }}</p>
                </div>
            @empty
                <p class="text-center text-muted mt-3">Belum ada berita terbaru.</p>
            @endforelse
        </div>
    </div>


    <h3 class="section-header">Lihat Detail Donatur</h3>

    <div class="donor-wrapper">
        <div class="donor-nav">
            <div class="donor-nav-item" id="nav-dana" onclick="openDonorTab('dana')">Donatur Dana</div>
            <div class="donor-nav-item active" id="nav-barang" onclick="openDonorTab('barang')">Donatur Barang</div>
            <div class="donor-nav-item" id="nav-tenaga" onclick="openDonorTab('tenaga')">Donatur Tenaga</div>
        </div>

        <div class="donor-list-background">

            <div id="list-barang">
                @forelse($campaign->goodsDonations as $donation)
                <div class="donor-row">
                    <div class="row-left">
                        <i class="bi bi-person-circle icon-avatar"></i>
                        <div class="info-box">
                            <span class="info-name">{{ $donation->user->name }}</span>
                            <span class="info-detail">Barang : {{ $donation->item_name }} &nbsp;•&nbsp; {{ $donation->quantity }} buah</span>
                        </div>
                    </div>
                    <div class="row-right">
                        <form action="{{ route('donations.goods.received', $donation->id) }}" method="POST" id="form-goods-{{ $donation->id }}">
                            @csrf
                            <label class="checkbox-label">
                                <input type="checkbox" class="hidden-cb"
                                       {{ $donation->status === 'received' ? 'checked' : '' }}
                                       {{ $donation->status === 'received' ? 'disabled' : '' }}
                                       onchange="if(confirm('Konfirmasi barang diterima?')) document.getElementById('form-goods-{{ $donation->id }}').submit();">
                                <span class="custom-cb-box"></span>
                                <span class="cb-text">Tandai Sudah Diterima</span>
                            </label>
                        </form>

                        @if($donation->status === 'received')
                            <div class="status-msg received">* Sudah Diterima</div>
                        @else
                            <div class="status-msg">* Menunggu Diterima</div>
                        @endif
                    </div>
                </div>
                @empty
                    <div class="text-center py-4 text-muted" style="font-size: 13px;">Belum ada donasi barang.</div>
                @endforelse
            </div>

            <div id="list-dana" style="display: none;">
                @forelse($campaign->moneyDonations as $donation)
                <div class="donor-row">
                    <div class="row-left">
                        <i class="bi bi-person-circle icon-avatar"></i>
                        <div class="info-box">
                            <span class="info-name">{{ $donation->is_anonymous ? 'Anonim' : $donation->user->name }}</span>
                            <span class="info-detail">Nominal : Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="row-right">
                        <img src="{{ asset('img/qris.png') }}" alt="QRIS" class="qris-logo" width="150px" height="100px">
                    </div>
                </div>
                @empty
                    <div class="text-center py-4 text-muted" style="font-size: 13px;">Belum ada donasi dana.</div>
                @endforelse
            </div>

            <div id="list-tenaga" style="display: none;">
                @forelse($campaign->volunteerDonations as $donation)
                <div class="donor-row">
                    <div class="row-left">
                        <i class="bi bi-person-circle icon-avatar"></i>
                        <div class="info-box">
                            <span class="info-name">{{ $donation->user->name }} - {{$donation->user->phone}}</span>
                            <span class="info-detail">Posisi : {{ $donation->position }}</span>
                            @if($donation->message)
                                <small style="font-size: 11px; color: #666; font-style: italic;">"{{ $donation->message }}"</small>
                            @endif
                        </div>
                    </div>
                    <div class="row-right">
                        @if($donation->status === 'pending')
                            <div class="d-flex gap-2">
                                <form action="{{ route('donations.volunteer.approve', $donation->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-primary" style="font-size: 11px;">Terima</button>
                                </form>
                                <form action="{{ route('donations.volunteer.reject', $donation->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-danger" style="font-size: 11px;">Tolak</button>
                                </form>
                            </div>
                            <div class="status-msg" style="margin-left: 0; margin-top: 4px;">* Menunggu Persetujuan</div>
                        @elseif($donation->status === 'approved')
                             <span class="status-simple text-primary">
                                <i class="bi bi-check-circle-fill"></i> Disetujui
                            </span>
                        @else
                             <span class="status-simple text-danger">
                                <i class="bi bi-x-circle-fill"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                    <div class="text-center py-4 text-muted" style="font-size: 13px;">Belum ada relawan mendaftar.</div>
                @endforelse
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Script Toggle Tab Atas
    function openTopTab(tabName) {
        document.getElementById('tab-kisah').classList.remove('active');
        document.getElementById('tab-kisah').classList.add('inactive');
        document.getElementById('tab-berita').classList.remove('active');
        document.getElementById('tab-berita').classList.add('inactive');

        document.getElementById('tab-' + tabName).classList.add('active');
        document.getElementById('tab-' + tabName).classList.remove('inactive');

        document.getElementById('content-kisah').style.display = (tabName === 'kisah') ? 'block' : 'none';
        document.getElementById('content-berita').style.display = (tabName === 'berita') ? 'block' : 'none';
    }

    // Script Toggle Tab Bawah
    function openDonorTab(type) {
        // Reset Active Nav
        document.getElementById('nav-dana').classList.remove('active');
        document.getElementById('nav-barang').classList.remove('active');
        document.getElementById('nav-tenaga').classList.remove('active');

        // Hide Lists
        document.getElementById('list-dana').style.display = 'none';
        document.getElementById('list-barang').style.display = 'none';
        document.getElementById('list-tenaga').style.display = 'none';

        // Set Active
        document.getElementById('nav-' + type).classList.add('active');
        document.getElementById('list-' + type).style.display = 'block';
    }
</script>
@endpush
