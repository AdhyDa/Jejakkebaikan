<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejakkebaikan - Platform Crowdfunding')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="nav-left">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('images/org-logo.png') }}" alt="Jejakkebaikan Logo">
                        <span>Jejakkebaikan</span>
                    </a>

                    <form method="GET" action="{{ route('home') }}" class="search-box">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari Kampanye"
                            value="{{ $search ?? '' }}"
                            aria-label="Cari Kampanye"
                        />
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                                <path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/>
                            </svg>
                        </button>
                    </form>
                </div>


                <div class="nav-right">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    <a href="{{ route('about') }}" class="nav-link">About us</a>
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <h3>Jejakkebaikan.com</h3>
                    <p>Jejakkebaikan adalah sebuah platform sebuah platform crowdfunding yang menampung 3 bentuk donasi dan bertujuan untuk menggalang dana dan berdonasi secara online</p>

                    <div class="social-links">
                        <a href="https://wa.me/62895396048445" class="social-icon" target="_blank" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://instagram.com/dhy.adhyy" class="social-icon" target="_blank" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/adhyaksa.daudi" class="social-icon" target="_blank" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-right">
                    <h3>About us</h3>
                    <ul>
                        <li><a href="{{ route('about') }}">Jejakkebaikan</a></li>
                        <li><a href="{{ route('contact') }}">Contact us</a></li>
                        <li><a href="{{ route(name: 'faq') }}">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>© 2025 Jejakkebaikan. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</body>
</html>
