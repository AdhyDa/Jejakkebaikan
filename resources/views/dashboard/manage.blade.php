@extends('layouts.app')

@section('title', 'Kelola Campaign - ' . $campaign->title)

@section('content')
<div class="manage-wrapper">

    <div class="manage-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>&gt;</span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a>
        <span>&gt;</span>
        Kelola Campaign
    </div>

    <h1 class="manage-title">Kelola Campaign: {{ $campaign->title }}</h1>

    <div class="manage-meta">
        Status : <a href="#">{{ ucfirst($campaign->status) }}</a>
        <br>
        Sisa Waktu : {{ max(0, ceil($campaign->getDaysLeft())) }} Hari
    </div>

    @if($campaign->image)
        <img src="{{ asset('storage/' . $campaign->image) }}" class="manage-image-real" alt="Campaign Image">
    @else
        <div class="manage-image-placeholder"></div>
    @endif

    <div class="top-tabs">
        <div class="top-tab-item active" id="tab-btn-kisah" onclick="switchTopTab('kisah')">Kisah</div>
        <div class="top-tab-item" id="tab-btn-berita" onclick="switchTopTab('berita')">Berita ({{ $campaign->updates->count() }})</div>
    </div>

    <div class="tab-content-box">
        <div id="content-kisah">
            <h3 class="story-heading">{{ $campaign->title }}</h3>
            <div style="font-size: 14px; line-height: 1.6; color: #333; text-align: justify;">
                {{ $campaign->description }}
            </div>
        </div>

        <div id="content-berita" style="display: none;">
            @forelse($campaign->updates as $update)
                <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    <strong style="color: #173059;">{{ $update->title }}</strong>
                    <div style="font-size: 12px; color: #888; margin-bottom: 8px;">{{ $update->created_at->format('d M Y') }}</div>
                    <p style="font-size: 14px; margin: 0;">{{ $update->content }}</p>
                </div>
            @empty
                <p style="color: #999; text-align: center;">Belum ada berita terbaru.</p>
            @endforelse
        </div>
    </div>

    <h3 class="donatur-section-title">Lihat Detail Donatur</h3>

    <div class="donatur-wrapper">
        <div class="donatur-tabs">
            <div class="donatur-tab" id="nav-dana" onclick="switchDonaturTab('dana')">Donatur Dana</div>
            <div class="donatur-tab active" id="nav-barang" onclick="switchDonaturTab('barang')">Donatur Barang</div>
            <div class="donatur-tab" id="nav-tenaga" onclick="switchDonaturTab('tenaga')">Donatur Tenaga</div>
        </div>

        <div class="donatur-list-area">

            <div id="list-dana" style="display: none;">
                @forelse($campaign->moneyDonations as $donation)
                <div class="donatur-item">
                    <div class="donatur-left">
                        <div class="donatur-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="donatur-info">
                            <h5>{{ $donation->is_anonymous ? 'Anonim' : $donation->user->name }}</h5>
                            <p>Rp {{ number_format($donation->amount, 0, ',', '.') }} &bull; {{ $donation->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="donatur-right">
                        <img src="{{ asset('images/payment-method.png') }}" alt="Volunteer Jejakkebaikan">
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 20px; color: #666;">Belum ada donasi dana.</div>
                @endforelse
            </div>

            <div id="list-barang">
                @forelse($campaign->goodsDonations as $donation)
                <div class="donatur-item">
                    <div class="donatur-left">
                        <div class="donatur-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="donatur-info">
                            <h5>{{ $donation->user->name }}</h5>
                            <p>Barang : {{ $donation->item_name }} &bull; {{ $donation->quantity }} buah</p>
                        </div>
                    </div>
                    <div class="donatur-right">
                        <form action="{{ route('donations.goods.received', $donation->id) }}" method="POST" id="form-barang-{{ $donation->id }}" data-current-status="{{ $donation->status }}">
                            @csrf
                            <input type="hidden" name="status" id="status-input-{{ $donation->id }}" value="">

                            <label class="check-wrapper">
                                <input type="checkbox" class="real-checkbox" style="display:none;"
                                    {{ $donation->status === 'received' ? 'checked' : '' }}
                                    onclick="openGoodsModal(event, {{ $donation->id }})">

                                <div class="check-box-custom"></div>
                                <span class="check-label">Tandai Sudah Diterima</span>
                            </label>
                        </form>

                        @if($donation->status === 'received')
                            <div class="status-note done">* Sudah Diterima</div>
                        @else
                            <div class="status-note">* Menunggu Diterima</div>
                        @endif
                    </div>
                </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #666;">Belum ada donasi barang.</div>
                @endforelse
            </div>

            <div id="list-tenaga" style="display: none;">
                @forelse($campaign->volunteerDonations as $donation)
                <div class="donatur-item">
                    <div class="donatur-left">
                        <div class="donatur-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="donatur-info">
                            <h5>{{ $donation->user->name }} <span style="font-weight: 400; font-size: 12px; color: #777; margin-left: 5px;">{{ $donation->user->email }}</span></h5>
                            <p>Posisi : {{ $donation->position }} &bull; {{ $donation->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="donatur-right">
                        @if($donation->status === 'approved')
                            <div style="color: white; font-size: 20px;">✓</div>
                        @elseif($donation->status === 'pending')
                            <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                <form action="{{ route('donations.volunteer.approve', $donation->id) }}" method="POST">@csrf <button class="btn btn-sm btn-primary" style="font-size: 10px; padding: 2px 8px;">Terima</button></form>
                                <form action="{{ route('donations.volunteer.reject', $donation->id) }}" method="POST">@csrf <button class="btn btn-sm btn-danger" style="font-size: 10px; padding: 2px 8px;">Tolak</button></form>
                            </div>
                        @else
                            <span style="font-size: 12px; color: red;">Ditolak</span>
                        @endif
                    </div>
                </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #666;">Belum ada relawan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="goodsModalOverlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Konfirmasi Status Barang</div>
        <div class="modal-text">Apakah barang ini sudah diterima dari donatur?</div>

        <div class="modal-buttons">
            <button type="button" class="btn-modal-choice btn-belum" onclick="submitGoodsStatus('pending')">BELUM</button>

            <button type="button" class="btn-modal-choice btn-sudah" onclick="submitGoodsStatus('received')">SUDAH</button>
        </div>
    </div>
</div>

<script>
    // Variabel ID Donasi yang sedang aktif
    let selectedDonationId = null;

    // 1. Fungsi Buka Modal
    function openGoodsModal(event, id) {
        // Stop checkbox berubah visualnya dulu (tunggu konfirmasi)
        event.preventDefault();

        selectedDonationId = id;

        // Get current status of the donation
        const form = document.getElementById('form-barang-' + id);
        const currentStatus = form.getAttribute('data-current-status');

        // Set button states based on current status
        const belumBtn = document.querySelector('[onclick="submitGoodsStatus(\'pending\')"]');
        const sudahBtn = document.querySelector('[onclick="submitGoodsStatus(\'received\')"]');

        if (currentStatus === 'pending') {
            belumBtn.disabled = true;
            belumBtn.style.opacity = '0.5';
            belumBtn.style.cursor = 'not-allowed';
            sudahBtn.disabled = false;
            sudahBtn.style.opacity = '1';
            sudahBtn.style.cursor = 'pointer';
        } else if (currentStatus === 'received') {
            sudahBtn.disabled = true;
            sudahBtn.style.opacity = '0.5';
            sudahBtn.style.cursor = 'not-allowed';
            belumBtn.disabled = false;
            belumBtn.style.opacity = '1';
            belumBtn.style.cursor = 'pointer';
        } else {
            // Enable both if status is neither pending nor received
            belumBtn.disabled = false;
            belumBtn.style.opacity = '1';
            belumBtn.style.cursor = 'pointer';
            sudahBtn.disabled = false;
            sudahBtn.style.opacity = '1';
            sudahBtn.style.cursor = 'pointer';
        }

        document.getElementById('goodsModalOverlay').classList.add('show');
    }

    // 2. Fungsi Submit Status (Dipanggil tombol Modal)
    function submitGoodsStatus(status) {
        if (selectedDonationId) {
            // Isi input hidden 'status' di dalam form yang sesuai
            const statusInput = document.getElementById('status-input-' + selectedDonationId);
            statusInput.value = status;

            // Submit Form
            document.getElementById('form-barang-' + selectedDonationId).submit();
        }

        // Close modal after submission
        document.getElementById('goodsModalOverlay').classList.remove('show');

        // Disable button if status is pending
        if (status === "pending") {
            const belumBtn = document.querySelector('[onclick="submitGoodsStatus(\'pending\')"]');
            belumBtn.disabled = true;
            belumBtn.style.opacity = '0.5';
            belumBtn.style.cursor = 'not-allowed';
            const sudahBtn = document.querySelector('[onclick="submitGoodsStatus(\'received\')"]');
            sudahBtn.disabled = false;
            sudahBtn.style.opacity = '1';
            sudahBtn.style.cursor = 'pointer';
        }

        // Disable button if status is received
        if (status === "received") {
            const sudahBtn = document.querySelector('[onclick="submitGoodsStatus(\'received\')"]');
            sudahBtn.disabled = true;
            sudahBtn.style.opacity = '0.5';
            sudahBtn.style.cursor = 'not-allowed';
            const belumBtn = document.querySelector('[onclick="submitGoodsStatus(\'pending\')"]');
            belumBtn.disabled = false;
            belumBtn.style.opacity = '1';
            belumBtn.style.cursor = 'pointer';
        }
    }

    // 3. Tutup Modal jika klik luar
    window.onclick = function(event) {
        const modal = document.getElementById('goodsModalOverlay');
        if (event.target == modal) {
            modal.classList.remove('show');
            selectedDonationId = null;
        }
    }

    // Tab Logic
    function switchTopTab(tab) {
        document.querySelectorAll('.top-tab-item').forEach(el => el.classList.remove('active'));
        document.getElementById('content-kisah').style.display = 'none';
        document.getElementById('content-berita').style.display = 'none';
        document.getElementById('tab-btn-' + tab).classList.add('active');
        document.getElementById('content-' + tab).style.display = 'block';
    }

    function switchDonaturTab(type) {
        document.querySelectorAll('.donatur-tab').forEach(el => el.classList.remove('active'));
        document.getElementById('list-dana').style.display = 'none';
        document.getElementById('list-barang').style.display = 'none';
        document.getElementById('list-tenaga').style.display = 'none';
        document.getElementById('nav-' + type).classList.add('active');
        document.getElementById('list-' + type).style.display = 'block';
    }
</script>
@endsection
