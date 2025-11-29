@extends('layouts.app')

@section('title', 'FAQ - Jejakkebaikan')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">›</span>
            <span class="current">FAQ</span>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="faq-hero">
    <div class="container">
        <h1>Frequently Asked Question</h1>
    </div>
</section>

<!-- FAQ Content -->
<section class="faq-content">
    <div class="container">
        <div class="faq-grid">
            <!-- Image Section -->
            <div class="faq-image">
                <img src="{{ asset('images/faq-volunteer.jpg') }}" alt="Jejakkebaikan Volunteers">
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion">
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bagaimana cara saya berdonasi?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Sangat mudah! 1. Pilih kampanye, 2. Di bagian detail, pilih salah satu dari tiga cara: "Donasi Dana (Simulasi)", "Donasi Barang", atau "Daftar Relawan". 3. Ikuti langkahnya!</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Apakah donasi dana saya aman?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Ya, sistem kami menggunakan enkripsi dan metode pembayaran yang aman untuk melindungi data dan transaksi Anda.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bagaimana alur "Donasi Barang"?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>1. Lihat daftar barang yang dibutuhkan pada kampanye. 2. Pilih barang yang ingin Anda donasikan. 3. Isi form pengiriman. 4. Kirim barang ke alamat yang tertera. 5. Pantau status barang Anda melalui dashboard.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Apa yang terjadi setelah saya "Daftar Relawan"?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Setelah mendaftar, tim penyelenggara akan menghubungi Anda melalui email atau WhatsApp untuk memberikan detail kegiatan, lokasi, dan waktu. Anda juga akan mendapatkan panduan tugas relawan.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bisakah saya membatalkan donasi?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Untuk donasi dana yang sudah diproses, pembatalan sulit dilakukan. Namun untuk donasi barang yang belum dikirim atau pendaftaran relawan, Anda dapat menghubungi tim kami melalui halaman Contact Us.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bagaimana cara melacak donasi saya?</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Setelah login, masuk ke Dashboard Anda. Di sana Anda bisa melihat riwayat semua donasi (dana, barang, atau kegiatan relawan) beserta statusnya secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const isActive = faqItem.classList.contains('active');

    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Toggle current item
    if (!isActive) {
        faqItem.classList.add('active');
    }
}
</script>
@endsection
