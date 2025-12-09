@extends('layouts.app')

@section('title', 'Riwayat Donasi - Jejakkebaikan')

@section('content')
    <div class="user-breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>&gt;</span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a> <span>&gt;</span>
        Riwayat Donasi
    </div>
<div class="dashboard-container-history">

    @include('user.sidebar')
    {{-- Asumsi file sidebar.blade.php ada di folder views utama, jika di folder user ubah jadi user.sidebar --}}

    <div class="dashboard-content">

        <div class="history-tabs">
            <button class="tab-btn active" id="btn-dana" onclick="switchHistoryTab('dana')">
                Donasi Dana ({{ $moneyDonations->count() }})
            </button>
            <button class="tab-btn" id="btn-barang" onclick="switchHistoryTab('barang')">
                Donasi Barang ({{ $goodsDonations->count() }})
            </button>
            <button class="tab-btn" id="btn-tenaga" onclick="switchHistoryTab('tenaga')">
                Donasi Tenaga ({{ $volunteerDonations->count() }})
            </button>
        </div>

        <div id="content-dana" class="tab-content-item">
            @if($moneyDonations->count() > 0)
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Tanggal Donasi</th>
                            <th>Nama Campaign</th>
                            <th>Jumlah Donasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moneyDonations as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->campaign->title ?? 'Campaign Dihapus' }}</td>
                            <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    {{-- <img src="{{ asset('images/empty-box.png') }}" width="150" style="margin-bottom:20px; opacity:0.5;"> --}}
                    <p>Kamu belum pernah berdonasi dana. Yuk ciptakan Jejak-mu!</p>
                </div>
            @endif
        </div>

        <div id="content-barang" class="tab-content-item" style="display: none;">
            @if($goodsDonations->count() > 0)
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Tanggal Donasi</th>
                            <th>Nama Campaign</th>
                            <th>Barang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($goodsDonations as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->campaign->title ?? 'Campaign Dihapus' }}</td>
                            <td>{{ $item->item_name }} ({{ $item->quantity }})</td>
                            <td>
                                @if($item->status == 'received')
                                    <span style="color:green; font-weight:bold;">Diterima</span>
                                @else
                                    <span style="color:#f59e0b; font-weight:bold;">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>Kamu belum pernah berdonasi barang. Yuk ciptakan Jejak-mu!</p>
                </div>
            @endif
        </div>

        <div id="content-tenaga" class="tab-content-item" style="display: none;">
            @if($volunteerDonations->count() > 0)
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <th>Nama Campaign</th>
                            <th>Posisi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($volunteerDonations as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->campaign->title ?? 'Campaign Dihapus' }}</td>
                            <td>{{ $item->position ?? $item->skill_type }}</td>
                            <td>
                                @if($item->status == 'approved')
                                    <span style="color:green; font-weight:bold;">Disetujui</span>
                                @elseif($item->status == 'rejected')
                                    <span style="color:red; font-weight:bold;">Ditolak</span>
                                @else
                                    <span style="color:#f59e0b; font-weight:bold;">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>Kamu belum pernah mendaftar sebagai relawan. Yuk ciptakan Jejak-mu!</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    function switchHistoryTab(tabName) {
        // 1. Reset Buttons
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('btn-' + tabName).classList.add('active');

        // 2. Hide All Contents
        document.querySelectorAll('.tab-content-item').forEach(content => content.style.display = 'none');

        // 3. Show Selected Content
        document.getElementById('content-' + tabName).style.display = 'block';
    }
</script>

@endsection
