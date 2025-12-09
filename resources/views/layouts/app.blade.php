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
                    @auth
                        <div class="user-menu">
                            <button class="user-button" id="userMenuButton">
                                <span class="user-name">{{ Auth::user()->username }}</span>
                                <div class="user-avatar">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    @endif
                                </div>
                            </button>

                            <div class="user-dropdown" id="userDropdown">
                                <div class="dropdown-header">
                                    <p class="dropdown-name">{{ Auth::user()->name }}</p>
                                    <p class="dropdown-email">{{ Auth::user()->email }}</p>
                                    <span style="font-size: 10px; background: #e3f2fd; color: #0046FF; padding: 2px 6px; border-radius: 4px; font-weight: bold; text-transform: uppercase;">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>
                                <div class="dropdown-divider"></div>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('dashboard.index') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="9" y1="3" x2="9" y2="21"></line>
                                        </svg>
                                        <span>Dashboard Admin</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('dashboard.profile') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>Edit Profil</span>
                                    </a>
                                @endif

                                @if(Auth::user()->role === 'user')
                                    <a href="{{ route('user.history') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>Riwayat Donasi</span>
                                    </a>
                                    <div class="dropdown-divider"></div>


                                    <a href="{{ route('user.edit') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>Edit Profil</span>
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Not Logged In -->
                        <a href="{{ route('login') }}" class="btn-login">Login</a>
                        <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                    @endauth
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

    <script>
        document.getElementById('userMenuButton').addEventListener('click', function(event) {
            event.stopPropagation();
            document.getElementById('userDropdown').classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.getElementById('userMenuButton');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

</body>
</html>
