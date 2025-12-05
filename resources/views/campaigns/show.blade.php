@extends('layouts.app')

@section('title', $campaign->title . ' - Jejakkebaikan')

@section('content')

<div class="detail-container">
    <div class="breadcrumb-nav">
        <a href="{{ route('home') }}">Home</a> <span>&gt;</span> {{ $campaign->title }}
    </div>

    <h1 class="campaign-main-title">{{ $campaign->title }}</h1>

    <div class="campaign-layout">
        <div class="layout-left">
            <div class="main-image-wrapper">
                @if($campaign->image)
                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}">
                @else
                    <div style="width:100%; height:100%; background:#ccc;"></div>
                @endif
            </div>

            <div class="nav-tabs-custom">
                <div class="nav-tab-item active" id="tab-kisah" onclick="switchTab('kisah')">Kisah</div>
                <div class="nav-tab-item" id="tab-berita" onclick="switchTab('berita')">Berita ({{ $campaign->updates->count() }})</div>
            </div>

            <div class="tab-content-area">
                <div id="content-kisah">
                    <h3 style="font-weight: 700; margin-bottom: 15px;">{{ $campaign->title }}</h3>
                    <p>{!! nl2br(e($campaign->description)) !!}</p>
                </div>
                <div id="content-berita" style="display: none;">
                    @forelse($campaign->updates as $update)
                        <div class="mb-4 pb-3 border-bottom">
                            <strong style="font-size: 16px;">{{ $update->title }}</strong><br>
                            <small class="text-muted">{{ $update->created_at->format('d M Y') }}</small>
                            <p class="mt-2">{{ $update->content }}</p>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada berita.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="layout-right">
            <div class="right-sidebar-full">

                <div class="lbl-small">Dana Terkumpul</div>
                <div class="amount-big">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</div>
                <div class="target-muted">dari target Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</div>

                @php
                    $percent = ($campaign->target_amount > 0) ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                @endphp
                <div class="prog-bar-bg">
                    <div class="prog-bar-fill" style="width: {{ min(100, $percent) }}%"></div>
                </div>

                <div class="stats-row">
                    <div>
                        <span class="stat-num">{{ $campaign->moneyDonations->count() }}</span>
                        <span class="stat-lbl">Donasi</span>
                    </div>
                    <div>
                        <span class="stat-num">7</span>
                        <span class="stat-lbl">Bagikan</span>
                    </div>
                    <div>
                        <span class="stat-num">{{ (int) max(0, $campaign->getDaysLeft()) }}</span>
                        <span class="stat-lbl">Hari Lagi</span>
                    </div>
                </div>

                @if($campaign->status === 'active')
                    <div class="donate-dropdown-wrapper">
                        <button class="btn-blue-block" id="mainDonateBtn" onclick="toggleDonateDropdown()">
                            Donasi
                            <svg id="dropdownArrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div class="donate-dropdown-menu" id="donateDropdown">
                            <button class="donate-option-uang" onclick="openDonateModal('uang')">
                                <span>Donasi Uang</span>
                            </button>
                            <button class="donate-option-barang" onclick="openDonateModal('barang')">
                                <span>Donasi Barang</span>
                            </button>
                            <button class="donate-option-tenaga" onclick="openDonateModal('tenaga')">
                                <span>Donasi Tenaga</span>
                            </button>
                        </div>
                    </div>

                    <button class="btn-white-block">Bagikan</button>
                @else
                    <button class="btn-blue-block" style="background:#999; cursor:not-allowed;">Selesai</button>
                @endif

                <div class="divider-line"></div>

                <div class="org-row">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($campaign->organization_name) }}&background=random" class="org-img">
                    <span class="org-name">{{ $campaign->organization_name }}</span>
                    <i class="bi bi-patch-check-fill org-verify"></i>
                </div>
                <a href="#" class="fund-detail">Rincian Penggunaan Dana</a>

                <div class="divider-line"></div>

                <div class="donasi-header">Donasi</div>

                @forelse($campaign->moneyDonations()->latest()->take(3)->get() as $donation)
                    <div class="donor-list-item">
                        <i class="bi bi-person-circle donor-icon-lg"></i>
                        <div>
                            <div class="donor-amount-txt">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                            <div class="donor-name-txt">Oleh {{ $donation->is_anonymous ? 'Hamba Allah' : $donation->user->name }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted small">Belum ada donasi.</p>
                @endforelse

                @if($campaign->moneyDonations->count() > 0)
                    <button class="btn-see-all-link" onclick="openAllDonorsModal()">Lihat Semua Donasi</button>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="donateModalUang" class="modal-backdrop-custom">
    <div class="modal-content-custom" style="height: auto;">
        <div class="modal-header-top">
            <h4 style="margin: 0; color: #173059;">Donasi Uang</h4>
        </div>
        <div class="modal-body-scroll">
            <form action="#" method="POST" style="padding: 20px 0;">
                @csrf
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Nominal (Rp)</label>
                    <input type="number" name="amount" class="form-input" placeholder="Minimum Rp 1.000" min="1000" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_anonymous" style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-size: 14px; color: #333;">Donasi sebagai Anonim</span>
                    </label>
                </div>
                <button type="submit" class="btn-blue-block" style="margin-bottom: 0;">Lanjut Pembayaran</button>
            </form>
        </div>
        <div class="modal-footer-bottom">
            <button class="btn-close-red" onclick="closeDonateModal('uang')">Batal</button>
        </div>
    </div>
</div>

<div id="donateModalBarang" class="modal-backdrop-custom">
    <div class="modal-content-custom" style="height: auto; max-height: 90vh;">
        <div class="modal-header-top">
            <h4 style="margin: 0; color: #173059;">Donasi Barang</h4>
        </div>
        <div class="modal-body-scroll">
            <form action="#" method="POST" style="padding: 20px 0;">
                @csrf
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Nama Barang <span style="color: red;">*</span></label>
                    <input type="text" name="item_name" class="form-input" placeholder="Contoh: Buku, Pakaian, dll" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Jumlah <span style="color: red;">*</span></label>
                    <input type="number" name="quantity" class="form-input" placeholder="Jumlah barang" min="1" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Kondisi Barang</label>
                    <select name="condition" class="form-input">
                        <option value="baru">Baru</option>
                        <option value="bekas_baik">Bekas - Kondisi Baik</option>
                        <option value="bekas_layak">Bekas - Masih Layak</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Deskripsi barang..."></textarea>
                </div>
                <button type="submit" class="btn-blue-block" style="margin-bottom: 0;">Kirim Donasi Barang</button>
            </form>
        </div>
        <div class="modal-footer-bottom">
            <button class="btn-close-red" onclick="closeDonateModal('barang')">Batal</button>
        </div>
    </div>
</div>

<div id="donateModalTenaga" class="modal-backdrop-custom">
    <div class="modal-content-custom" style="height: auto; max-height: 90vh;">
        <div class="modal-header-top">
            <h4 style="margin: 0; color: #173059;">Donasi Tenaga</h4>
        </div>
        <div class="modal-body-scroll">
            <form action="#" method="POST" style="padding: 20px 0;">
                @csrf
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Jenis Keahlian <span style="color: red;">*</span></label>
                    <input type="text" name="skill_type" class="form-input" placeholder="Contoh: Mengajar, Memasak, Desain, dll" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Durasi Ketersediaan</label>
                    <select name="duration" class="form-input">
                        <option value="1-2_jam">1-2 Jam</option>
                        <option value="setengah_hari">Setengah Hari</option>
                        <option value="sehari_penuh">Sehari Penuh</option>
                        <option value="fleksibel">Fleksibel</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Jadwal yang Tersedia</label>
                    <input type="text" name="availability" class="form-input" placeholder="Contoh: Sabtu-Minggu, Weekdays sore, dll">
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Catatan Tambahan</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Jelaskan pengalaman atau detail lainnya..."></textarea>
                </div>
                <button type="submit" class="btn-blue-block" style="margin-bottom: 0;">Daftar Sebagai Relawan</button>
            </form>
        </div>
        <div class="modal-footer-bottom">
            <button class="btn-close-red" onclick="closeDonateModal('tenaga')">Batal</button>
        </div>
    </div>
</div>

<div id="allDonorsModal" class="modal-backdrop-custom">
    <div class="modal-content-custom">
        <div class="modal-header-top">
            Daftar Donatur: {{ $campaign->title }}
        </div>
        <div class="modal-body-scroll">
            @foreach($campaign->moneyDonations()->latest()->get() as $donation)
            <div class="modal-donor-row">
                <i class="bi bi-person-circle" style="font-size: 40px; color: #173059;"></i>
                <div>
                    <div class="modal-donor-name">{{ $donation->is_anonymous ? 'Hamba Allah' : $donation->user->name }}</div>
                    <div class="modal-donor-sub">
                        Rp {{ number_format($donation->amount, 0, ',', '.') }} • {{ $donation->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="modal-footer-bottom">
            <button class="btn-close-red" onclick="closeAllDonorsModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    // Tab Logic
    function switchTab(tabName) {
        document.querySelectorAll('.nav-tab-item').forEach(item => {
            item.classList.remove('active');
        });

        document.getElementById('content-kisah').style.display = 'none';
        document.getElementById('content-berita').style.display = 'none';

        document.getElementById('tab-' + tabName).classList.add('active');
        document.getElementById('content-' + tabName).style.display = 'block';
    }

    // ===== DROPDOWN ANIMATION LOGIC =====
    function toggleDonateDropdown() {
        const dropdown = document.getElementById('donateDropdown');
        const btn = document.getElementById('mainDonateBtn');

        // Toggle class 'show' untuk menu
        dropdown.classList.toggle('show');

        // Toggle class 'active' untuk tombol (agar icon berputar)
        btn.classList.toggle('active');
    }

    // Tutup dropdown jika klik di luar area
    document.addEventListener('click', function(event) {
        const wrapper = document.querySelector('.donate-dropdown-wrapper');
        const dropdown = document.getElementById('donateDropdown');
        const btn = document.getElementById('mainDonateBtn');

        // Jika klik terjadi di luar wrapper, tutup dropdown
        if (wrapper && !wrapper.contains(event.target)) {
            dropdown.classList.remove('show');
            btn.classList.remove('active'); // Reset rotasi icon
        }
    });

    // ===== MODAL LOGIC =====
    function openDonateModal(type) {
        // Tutup dropdown otomatis saat modal dibuka
        document.getElementById('donateDropdown').classList.remove('show');
        document.getElementById('mainDonateBtn').classList.remove('active');

        // Buka modal sesuai tipe
        if (type === 'uang') {
            document.getElementById('donateModalUang').classList.add('show');
        } else if (type === 'barang') {
            document.getElementById('donateModalBarang').classList.add('show');
        } else if (type === 'tenaga') {
            document.getElementById('donateModalTenaga').classList.add('show');
        }
    }

    function closeDonateModal(type) {
        if (type === 'uang') {
            document.getElementById('donateModalUang').classList.remove('show');
        } else if (type === 'barang') {
            document.getElementById('donateModalBarang').classList.remove('show');
        } else if (type === 'tenaga') {
            document.getElementById('donateModalTenaga').classList.remove('show');
        }
    }

    function openAllDonorsModal() {
        document.getElementById('allDonorsModal').classList.add('show');
    }

    function closeAllDonorsModal() {
        document.getElementById('allDonorsModal').classList.remove('show');
    }

    window.onclick = function(e) {
        if (e.target.classList.contains('modal-backdrop-custom')) {
            e.target.classList.remove('show');
        }
    }
</script>
@endsection
