@extends('layouts.app')

@section('title', 'Kelola Campaign - ' . $campaign->title)

@section('content')
<div class="manage-wrapper">

    <div class="manage-breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>&gt;</span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a> <span>&gt;</span>
        Kelola Campaign
    </div>

    <h1 class="manage-title">Kelola: {{ $campaign->title }}</h1>

    <div class="meta-box">
        <div class="meta-item">Status: <span class="status-badge">{{ ucfirst($campaign->status) }}</span></div>
        <div class="meta-item">Sisa Waktu: <strong>{{ max(0, ceil($campaign->getDaysLeft())) }} Hari</strong></div>
        <div class="meta-item">Terkumpul: <strong>Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong></div>
    </div>

    <div class="manage-image-wrapper">
        @if($campaign->image)
            <img src="{{ asset('images/' . $campaign->image) }}" class="manage-image-real" alt="Campaign Image">
        @else
            <div style="width:100%; height:100%; background:#ccc; display:flex; align-items:center; justify-content:center; color:#666;">Belum ada foto</div>
        @endif
    </div>

    <div class="top-tabs">
        <div class="top-tab-item active" id="tab-btn-kisah" onclick="switchTopTab('kisah')">Kisah</div>
        <div class="top-tab-item" id="tab-btn-berita" onclick="switchTopTab('berita')">Berita ({{ $campaign->updates->count() + ($campaign->goods_description ? 1 : 0) }})</div>
    </div>

    <div class="tab-content-box">
        <div id="content-kisah">
            <h3 style="font-weight:700; color:#173059; margin-bottom:15px;">{{ $campaign->title }}</h3>
            <div style="font-size: 14px; line-height: 1.8; color: #333; text-align: justify;">
                {{ $campaign->description }}
            </div>
        </div>

        <div id="content-berita" style="display: none;">
            <div class="news-header">
                <strong style="color:#173059; font-size:16px;">Update Terbaru</strong>
                <button class="btn-add-news" onclick="openModal('newsModal')">
                    <i class="bi bi-plus-circle"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tulis Kabar Baru
                </button>
            </div>

            @if($campaign->goods_description)
                <div style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                        <strong style="color: #173059; font-size:15px;">Kebutuhan Barang</strong>
                        <small style="color:#999;">{{ $campaign->created_at->format('d M Y') }}</small>
                    </div>
                    <p style="font-size: 14px; color:#555; margin: 0; line-height:1.6;">{{ $campaign->goods_description }}</p>
                </div>
            @endif

            @forelse($campaign->updates as $update)
                <div style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                        <strong style="color: #173059; font-size:15px;">{{ $update->title }}</strong>
                        <small style="color:#999;">{{ $update->created_at->format('d M Y') }}</small>
                    </div>
                    <p style="font-size: 14px; color:#555; margin: 0; line-height:1.6;">{{ $update->content }}</p>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: #999;">
                    <i class="bi bi-newspaper" style="font-size:30px; display:block; margin-bottom:10px;"></i>
                    Belum ada kabar terbaru. Yuk tulis update pertama!
                </div>
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
                        <i class="bi bi-person-circle" style="font-size:35px; color:#173059;"></i>
                        <div class="donatur-info">
                            <h5>{{ $donation->is_anonymous ? 'Anonim' : $donation->user->name }}</h5>
                            <p>Rp {{ number_format($donation->amount, 0, ',', '.') }} • {{ $donation->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div><img src="{{ asset('images/qris.png') }}" alt="QRIS" style="background:white; border:1px solid #000; padding:2px 5px; width:8kfkf0px; height:auto;"></div>
                </div>
                @empty
                <div style="text-align: center; padding: 20px; color: #666;">Belum ada donasi dana.</div>
                @endforelse
            </div>

            <div id="list-barang">
                @forelse($campaign->goodsDonations as $donation)
                <div class="donatur-item">
                    <div class="donatur-left">
                        <i class="bi bi-person-circle" style="font-size:35px; color:#173059;"></i>
                        <div class="donatur-info">
                            <h5>{{ $donation->user->name }}</h5>
                            <p>{{ $donation->item_name }} • {{ $donation->quantity }} buah</p>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <form action="{{ route('donations.goods.received', $donation->id) }}" method="POST" id="form-barang-{{ $donation->id }}">
                            @csrf
                            <input type="hidden" name="status" id="status-input-{{ $donation->id }}" value="">
                            <label class="check-wrapper">
                                <input type="checkbox" class="real-checkbox" style="display:none;"
                                    {{ $donation->status === 'received' ? 'checked' : '' }}
                                    onclick="openGoodsModal(event, {{ $donation->id }})">
                                <div class="check-box-custom"></div>
                                <span style="font-size:13px; color:#173059;">Tandai Diterima</span>
                            </label>
                        </form>
                        <div class="status-note {{ $donation->status === 'received' ? 'done' : '' }}">
                            {{ $donation->status === 'received' ? '* Sudah Diterima' : '* Menunggu' }}
                        </div>
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
                        <i class="bi bi-person-circle" style="font-size:35px; color:#173059;"></i>
                        <div class="donatur-info">
                            <h5>{{ $donation->user->name }}</h5>
                            <p>{{ $donation->position }}</p>
                        </div>
                    </div>
                    <div>
                        @if($donation->status === 'approved') <i class="bi bi-check-lg" style="color:green; font-size:24px;"></i>
                        @elseif($donation->status === 'pending')
                            <form action="{{ route('donations.volunteer.approve', $donation->id) }}" method="POST" style="display:inline;">@csrf <button class="btn btn-sm btn-primary">Terima</button></form>
                        @else <span style="color:red;">Ditolak</span>
                        @endif
                    </div>
                </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #666;">Belum ada relawan.</div>
                @endforelse
            </div>
        </div>
    </div>
        @if($campaign->status === 'draft')
            <div class="meta-item">
                <form action="{{ route('dashboard.campaigns.update-status', $campaign->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="status" value="active">
                    <button type="submit" class="btn-publish-campaign">
                        <i class="bi bi-upload"></i> Publikasikan Campaign
                    </button>
                </form>
            </div>
        @endif
        <button type="button" class="btn-delete-campaign" onclick="openModal('deleteModal')">
            <i class="bi bi-trash"></i> Hapus Campaign
        </button>
</div>

{{-- === MODAL SECTION === --}}

<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title" style="color:#dc3545;">Hapus Campaign?</div>
        <div class="modal-text">Tindakan ini tidak dapat dibatalkan. Semua data donasi terkait juga akan terhapus.</div>
        <div class="modal-actions-delete">
            <button onclick="closeModal('deleteModal')" class="btn-modal-cancel">Batal</button>
            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-confirm danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>



<div id="newsModal" class="modal-overlay">
    <div class="modal-box" style="width: 500px;">
        <div class="modal-title">Tulis Kabar Terbaru</div>
        <form action="{{ route('dashboard.campaigns.add-update', $campaign->id) }}" method="POST">
            @csrf
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:14px;">Judul Kabar</label>
                <input type="text" name="title" class="form-input" placeholder="Contoh: Penyaluran Tahap 1" required>
            </div>
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:14px;">Isi Kabar</label>
                <textarea name="content" class="form-input" rows="4" placeholder="Ceritakan perkembangan campaign..." required></textarea>
            </div>
            <div class="modal-actions-news">
                <button type="button" onclick="closeModal('newsModal')" class="btn-modal-cancel">Batal</button>
                <button type="submit" class="btn-modal-confirm">Kirim Kabar</button>
            </div>
        </form>
    </div>
</div>

<div id="goodsModalOverlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Konfirmasi Status Barang</div>
        <div class="modal-text">Apakah barang ini sudah diterima dari donatur?</div>
        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="submitGoodsStatus('pending')">Belum</button>
            <button type="button" class="btn-modal-confirm" onclick="submitGoodsStatus('received')">Sudah</button>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    // Modal General Logic
    function openModal(id) { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }

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

    // Logic Checkbox Barang (Reused)
    let selectedDonationId = null;
    function openGoodsModal(event, id) {
        event.preventDefault();
        selectedDonationId = id;
        document.getElementById('goodsModalOverlay').classList.add('show');
    }

    function submitGoodsStatus(status) {
        if (selectedDonationId) {
            document.getElementById('status-input-' + selectedDonationId).value = status;
            document.getElementById('form-barang-' + selectedDonationId).submit();
        }
    }

    // Close Modals on Outside Click
    window.onclick = function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('show');
        }
    }
</script>

@endsection
