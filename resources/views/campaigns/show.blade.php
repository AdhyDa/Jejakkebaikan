@extends('layouts.app')

@section('title', $campaign->title . ' - Jejakkebaikan')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Left Column - Campaign Details -->
        <div class="col-md-8">
            <img src="{{ asset('storage/' . $campaign->image) }}" class="img-fluid rounded mb-4" alt="{{ $campaign->title }}">

            <h2 class="mb-3">{{ $campaign->title }}</h2>
            <p class="text-muted">{{ $campaign->organization_name }}</p>

            <ul class="nav nav-tabs mb-3" id="campaignTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="story-tab" data-bs-toggle="tab" data-bs-target="#story" type="button">
                        Kisah
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button">
                        Berita ({{ $campaign->updates->count() }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="campaignTabsContent">
                <div class="tab-pane fade show active" id="story" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $campaign->title }}</h5>
                            <p>{{ $campaign->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="updates" role="tabpanel">
                    @forelse($campaign->updates as $update)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6>{{ $update->title }}</h6>
                                <p class="text-muted small">{{ $update->created_at->format('d M Y') }}</p>
                                <p>{{ $update->content }}</p>
                                @if($update->image)
                                    <img src="{{ asset('storage/' . $update->image) }}" class="img-fluid rounded" alt="{{ $update->title }}">
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada update untuk kampanye ini</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column - Donation Info -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    @if($campaign->need_money)
                        <h5 class="text-success">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</h5>
                        <small class="text-muted">dari target Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</small>

                        <div class="progress my-3" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $campaign->getProgressPercentage() }}%"></div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <i class="bi bi-people"></i>
                            <strong>{{ $campaign->moneyDonations->count() }}</strong>
                            <small class="text-muted">Donasi</small>
                        </div>
                        <div>
                            <i class="bi bi-calendar"></i>
                            <strong>{{ max(0, $campaign->getDaysLeft()) }}</strong>
                            <small class="text-muted">Hari Lagi</small>
                        </div>
                    </div>

                    @auth
                        @if($campaign->need_money)
                            <button class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#donateMoneyModal">
                                <i class="bi bi-cash-coin"></i> Donasi Dana
                            </button>
                        @endif

                        @if($campaign->need_goods)
                            <button class="btn btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#donateGoodsModal">
                                <i class="bi bi-box-seam"></i> Donasi Barang
                            </button>
                        @endif

                        @if($campaign->need_volunteer)
                            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#volunteerModal">
                                <i class="bi bi-people"></i> Daftar Relawan
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success w-100 mb-2">Login untuk Donasi</a>
                    @endauth

                    <button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#shareModal">
                        <i class="bi bi-share"></i> Bagikan
                    </button>
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="card mt-3">
                <div class="card-header">
                    <strong>Donasi Terakhir</strong>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @forelse($campaign->moneyDonations()->latest()->take(5)->get() as $donation)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <strong>{{ $donation->is_anonymous ? 'Anonim' : $donation->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $donation->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                <strong class="text-success">Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada donasi</p>
                    @endforelse

                    @if($campaign->moneyDonations->count() > 5)
                        <button class="btn btn-link w-100" data-bs-toggle="modal" data-bs-target="#allDonationsModal">
                            Lihat Semua Donasi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Donate Money Modal -->
<div class="modal fade" id="donateMoneyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('donations.money', $campaign->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Donasi Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Donasi</label>
                        <input type="number" name="amount" class="form-control" min="1000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan (Opsional)</label>
                        <textarea name="message" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_anonymous" class="form-check-input" id="anonymous">
                        <label class="form-check-label" for="anonymous">Donasi sebagai Anonim</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Donasi Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Donate Goods Modal -->
<div class="modal fade" id="donateGoodsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('donations.goods', $campaign->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Donasi Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Kirim Janji Donasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Volunteer Modal -->
<div class="modal fade" id="volunteerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('donations.volunteer', $campaign->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Relawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Posisi yang Diinginkan</label>
                        <input type="text" name="position" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan (Opsional)</label>
                        <textarea name="message" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
