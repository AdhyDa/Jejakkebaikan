@extends('layouts.app')

@section('title', 'About Us - Jejakkebaikan')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">></span>
            <span class="current">About us</span>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <h1>Tentang Jejakkebaikan</h1>
        <p class="subtitle">Kebaikan selalu meninggalkan jejak. Bersama,<br>harapan bisa tumbuh dari tindakan kecil yang tulus.</p>
    </div>
</section>

<!-- Why Section -->
<section class="why-section">
    <div class="container">
        <div class="why-content">
            <div class="why-text">
                <h2>Kenapa kami ada?</h2>
                <p>Kami melihat banyak niat baik seringkali terhambat. Ada yang punya dana tapi tak punya waktu. Ada yang punya tenaga tapi tak punya uang. Ada panti asuhan yang lebih butuh beras daripada uang tunai. Jejakkebaikan lahir untuk memecahkan masalah itu.</p>
            </div>
            <div class="why-image">
                <img src="{{ asset('images/about-volunteer.jpg') }}" alt="Volunteer Jejakkebaikan">
            </div>
        </div>
    </div>
</section>

<!-- Solution Section -->
<section class="solution-section">
    <div class="container">
        <h2>Solusi Kami: 3-in-1</h2>

        <p class="solution-subtitle">Jejakkebaikan hadir untuk menghapus batasan dalam berbagi</p>
        <p class="solution-description-top">Kami menawarkan 3 bentuk donasi sekaligus dalam satu kampanye agar setiap orang memiliki kesempatan yang sama untuk berbagi, baik melalui donasi dana, kiriman barang, ataupun turun tangan langsung sebagai relawan. Dengan begitu, bantuan yang disalurkan menjadi lebih lengkap dan berdampak.</p>

        <div class="solution-grid">
            <!-- Donation Type Cards -->
            <div class="donation-card uang">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#2DD4BF" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <h3>Donasi Dana</h3>
                <p class="card-description">Salurkan bantuan finansial untuk mendukung operasional dan kebutuhan mendesak mereka.</p>
            </div>

            <div class="donation-card barang">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FBBF24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-icon lucide-package">
                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/>
                        <path d="M12 22V12"/>
                        <polyline points="3.29 7 12 12 20.71 7"/>
                        <path d="m7.5 4.27 9 5.15"/>
                    </svg>
                </div>
                <h3>Donasi Barang</h3>
                <p class="card-description">Penuhi daftar kebutuhan fisik mereka dengan mengirimkan barang yang tepat sasaran."</p>
            </div>

            <div class="donation-card tenaga">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </div>
                <h3>Donasi Tenaga</h3>
                <p class="card-description">Dedikasikan waktu dan keahlianmu dengan terjun langsung menjadi relawan di lapangan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Project Section -->
<section class="project-section">
    <div class="container">
        <h2>Tentang Proyek Ini</h2>
        <p class="project-intro">Jejakkebaikan adalah sebuah prototipe platform sosial yang dirancang sebagai Tugas Akhir mata kuliah Rekayasa Perangkat Lunak (RPL) oleh:</p>

        <div class="team-grid">
            <div class="team-card">
                <h3>Adhyaksa Daudi</h3>
                <p class="nim">Mahasiswa</p>
                <div class="social-links">
                    <a href="https://instagram.com/dhy.adhyy" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://twitter.com/adhyaksa" target="_blank" aria-label="Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://linkedin.com/in/adhyaksa" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="team-card">
                <h3>Agbita Grace</h3>
                <p class="nim">Mahasiswa</p>
                <div class="social-links">
                    <a href="#" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="team-card">
                <h3>Aluna Syela</h3>
                <p class="nim">Mahasiswa</p>
                <div class="social-links">
                    <a href="#" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div class="team-card">
                <h3>Elisabeth Jenny</h3>
                <p class="nim">Mahasiswa</p>
                <div class="social-links">
                    <a href="#" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="#" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <p class="project-description">dari Universitas Negeri Malang. Platform ini adalah studi kasus tentang bagaimana UI/UX dan manajemen database dapat menyatukan tiga bentuk donasi dalam satu alur yang terintegrasi.</p>
    </div>
</section>
@endsection
