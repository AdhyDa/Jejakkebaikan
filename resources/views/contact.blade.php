@extends('layouts.app')

@section('title', 'Contact Us - Jejakkebaikan')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">›</span>
            <span class="current">Contact us</span>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <h1>Contact Jejakkebaikan</h1>
        <p class="subtitle">Kebaikan selalu meninggalkan jejak. Bersama,<br>harapan bisa tumbuh dari tindakan kecil yang tulus.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="contact-content">
    <div class="container">
        <div class="contact-grid">
            <!-- Address Info -->
            <div class="address-section">
                <h2>Alamat Kami</h2>
                <div class="address-details">
                    <p><strong>Universitas Negeri Malang</strong></p>
                    <p>Jl. Cakrawala No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145</p>
                </div>
            </div>

            <!-- Map -->
            <div class="map-section">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.3706440901165!2d112.61509681019787!3d-7.960594292031009!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e788281bdd08839%3A0xc915f268bffa831f!2sUniversitas%20Negeri%20Malang!5e0!3m2!1sid!2sid!4v1764340969360!5m2!1sid!2sid"
                        width="600"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
