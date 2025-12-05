@extends('layouts.app')

@section('title', 'Home - Jejakkebaikan')

@section('content')
<section class="hero-section">
    <div class="container">
        <h1>Donasi Sekarang</h1>
        <p>Kebaikan selalu meningalkan jejak. Bersama,<br>harapan bisa tumbuh dari tindakan kecil yang tulus.</p>

        <div class="filter-wrapper">
            <button class="btn-filter" id="btnOpenFilter">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-wide-narrow-icon lucide-arrow-down-wide-narrow">
                <path d="m3 16 4 4 4-4"/>
                <path d="M7 20V4"/>
                <path d="M11 4h10"/>
                <path d="M11 8h7"/>
                <path d="M11 12h4"/>
            </svg>
                Filter & Urutkan
            </button>
        </div>
    </div>
</section>

<section class="campaign-section">
    <div class="container">
        <!-- Search Result Info -->
        @if(!empty($search))
            <div class="search-result-info">
                <p>Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong></p>
                @if(count($campaigns) > 0)
                    <span class="result-count">{{ count($campaigns) }} kampanye ditemukan</span>
                @endif
            </div>
        @endif

        <!-- No Results Message -->
        @if(count($campaigns) === 0)
            <div class="no-results">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <line x1="11" y1="8" x2="11" y2="14"></line>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
                <h3>Tidak Ada Kampanye Ditemukan</h3>
                @if(!empty($search))
                    <p>Maaf, tidak ada kampanye yang cocok dengan pencarian "{{ $search }}"</p>
                @else
                    <p>Tidak ada kampanye yang sesuai dengan filter yang dipilih</p>
                @endif
                <a href="{{ route('home') }}" class="btn-reset">Tampilkan Semua Kampanye</a>
            </div>
        @else

            <div class="campaign-grid">
                @foreach($campaigns as $campaign)
                <div class="campaign-card">
                    <div class="card-image">
                        <img src="{{ asset('images/' . $campaign['image']) }}" alt="Foto Kampanye">
                    </div>

                    <div class="card-content">
                        <h3 class="campaign-title">{{ $campaign['title'] }}</h3>

                        <div class="organization">
                            <img src="{{ asset('images/' . $campaign['organization_logo']) }}"
                                alt="{{ $campaign['organization'] }}"
                                class="org-icon"
                            >
                            <span class="org-name">{{ $campaign['organization'] }}</span>
                            @if($campaign['verified'])
                            <img src="{{ asset('images/verified.png') }}" alt="Verified" class="verified-badge">
                            @endif
                        </div>

                        <p class="description">{{ $campaign['description'] }}</p>

                        <button class="campaign-link-btn" onclick="window.location.href='{{ route('campaigns.show', $campaign['slug']) }}'">
                            {{ $campaign['link'] ?? ' ' }}
                            <span class="arrow-down">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="drop-down">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </span>
                        </button>

                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $campaign['progress'] }}%"></div>
                        </div>

                        <div class="campaign-stats">
                            <div class="stat-item">
                                <strong class="stat-value">{{ $campaign['collected'] }}</strong>
                                <span class="stat-label">Terkumpul</span>
                            </div>
                            <div class="stat-item stat-right">
                                <strong class="stat-value">{{ (int) $campaign['days'] }}</strong>
                                <span class="stat-label">Hari Lagi</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<div id="filterModal" class="filter-modal">
    <div class="filter-overlay" id="filterOverlay"></div>
    <div class="filter-content">
        <form method="GET" action="{{ route('home') }}" id="filterForm">
            <div class="filter-section">
                <h3>Kategori</h3>
                <div class="filter-options">
                    <label class="filter-pill {{ in_array('Pendidikan', (array)$kategori) ? 'active' : '' }}">
                        <input type="checkbox" name="kategori[]" value="Pendidikan" {{ in_array('Pendidikan', (array)$kategori) ? 'checked' : '' }}>
                        <span>Pendidikan</span>
                    </label>
                    <label class="filter-pill {{ in_array('Kemanusiaan', (array)$kategori) ? 'active' : '' }}">
                        <input type="checkbox" name="kategori[]" value="Kemanusiaan" {{ in_array('Kemanusiaan', (array)$kategori) ? 'checked' : '' }}>
                        <span>Kemanusiaan</span>
                    </label>
                    <label class="filter-pill {{ in_array('Bencana Alam', (array)$kategori) ? 'active' : '' }}">
                        <input type="checkbox" name="kategori[]" value="Bencana Alam" {{ in_array('Bencana Alam', (array)$kategori) ? 'checked' : '' }}>
                        <span>Bencana Alam</span>
                    </label>
                    <label class="filter-pill {{ in_array('Lingkungan', (array)$kategori) ? 'active' : '' }}">
                        <input type="checkbox" name="kategori[]" value="Lingkungan" {{ in_array('Lingkungan', (array)$kategori) ? 'checked' : '' }}>
                        <span>Lingkungan</span>
                    </label>
                    <label class="filter-pill {{ in_array('Panti Asuhan', (array)$kategori) ? 'active' : '' }}">
                        <input type="checkbox" name="kategori[]" value="Panti Asuhan" {{ in_array('Panti Asuhan', (array)$kategori) ? 'checked' : '' }}>
                        <span>Panti Asuhan</span>
                    </label>
                </div>
            </div>

            @php
            $statusDefault = $status ?? 'Berlangsung';
            @endphp
            <div class="filter-section">
                <h3>Status</h3>
                <div class="filter-options">
                    <label class="filter-pill {{ $statusDefault === 'Berlangsung' ? 'active' : '' }}">
                        <input type="radio" name="status" value="Berlangsung" {{ $statusDefault === 'Berlangsung' ? 'checked' : '' }}>
                        <span>Berlangsung</span>
                    </label>
                    <label class="filter-pill {{ $statusDefault === 'Selesai' ? 'active' : '' }}">
                        <input type="radio" name="status" value="Selesai" {{ $statusDefault === 'Selesai' ? 'checked' : '' }}>
                        <span>Selesai</span>
                    </label>
                </div>
            </div>

            @php
            $urutkanDefault = $urutkan ?? 'Progres Tertinggi';
            @endphp
            <div class="filter-section">
                <h3>Urutkan</h3>
                <div class="filter-options">
                    <label class="filter-pill {{ $urutkanDefault === 'Akan Berakhir' ? 'active' : '' }}">
                        <input type="radio" name="urutkan" value="Akan Berakhir" {{ $urutkanDefault === 'Akan Berakhir' ? 'checked' : '' }}>
                        <span>Akan Berakhir</span>
                    </label>
                    <label class="filter-pill {{ $urutkanDefault === 'Terbaru' ? 'active' : '' }}">
                        <input type="radio" name="urutkan" value="Terbaru" {{ $urutkanDefault === 'Terbaru' ? 'checked' : '' }}>
                        <span>Terbaru</span>
                    </label>
                    <label class="filter-pill {{ $urutkanDefault === 'Progres Tertinggi' ? 'active' : '' }}">
                        <input type="radio" name="urutkan" value="Progres Tertinggi" {{ $urutkanDefault === 'Progres Tertinggi' ? 'checked' : '' }}>
                        <span>Progres Tertinggi</span>
                    </label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Organisasi</h3>
                <div class="filter-options">
                    <label class="filter-pill {{ in_array('Oleh Jejakkebaikan', (array) $organisasi) ? 'active' : '' }}">
                        <input type="checkbox" name="organisasi[]" value="Oleh Jejakkebaikan" {{ in_array ('Oleh Jejakkebaikan', (array)$organisasi) ? 'checked' : '' }}>
                        <span>Oleh Jejakkebaikan</span>
                    </label>
                    <label class="filter-pill {{ in_array('Oleh Yayasan', (array)$organisasi) ? 'active' : '' }}">
                        <input type="checkbox" name="organisasi[]" value="Oleh Yayasan" {{ in_array('Oleh Yayasan', (array)$organisasi) ? 'checked' : '' }}>
                        <span>Oleh Yayasan</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-apply-filter">Terapkan Filter</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnOpenFilter = document.getElementById('btnOpenFilter');
    const filterModal = document.getElementById('filterModal');
    const filterOverlay = document.getElementById('filterOverlay');

    // Open filter modal
    btnOpenFilter.addEventListener('click', function() {
        filterModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    });

    // Close filter modal when clicking overlay
    filterOverlay.addEventListener('click', function() {
        filterModal.classList.remove('show');
        document.body.style.overflow = 'auto';
    });

    // Handle filter pill active state
    const filterPills = document.querySelectorAll('.filter-pill');
    filterPills.forEach(pill => {
        const input = pill.querySelector('input');

        pill.addEventListener('click', function(e) {
            if (e.target === input) return;
        });

        input.addEventListener('change', function() {
            if (input.type === 'checkbox') {
                if (input.checked) {
                    pill.classList.add('active');
                } else {
                    pill.classList.remove('active');
                }
            } else if (input.type === 'radio') {
                const siblings = input.closest('.filter-options').querySelectorAll('.filter-pill');
                siblings.forEach(s => s.classList.remove('active'));

                if (input.checked) {
                    pill.classList.add('active');
                }
            }
        });
    });
});
</script>
@endsection
