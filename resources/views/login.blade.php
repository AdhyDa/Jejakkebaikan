<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Jejakkebaikan</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Hero -->
        <div class="auth-left">
            <div class="auth-hero">
                <div class="logo-section">
                    <img src="{{ asset('images/org-logo.png') }}" alt="Jejakkebaikan Logo" class="auth-logo">
                    <h2>Jejakkebaikan</h2>
                </div>

                <h1>Selamat Datang Kembali!</h1>
                <p>Mari lanjutkan jejak kebaikanmu hari ini.</p>

                <div class="illustration">
                    <img src="{{ asset('images/ilustrasi.png') }}" alt="Illustration">
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <h1>Masuk ke akunmu</h1>

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" class="auth-form">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="far fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">Masuk</button>
                </form>

                <!-- Forgot Password Link -->
                <div class="forgot-password">
                    <a href="#">Lupa password?</a>
                </div>

                <div class="divider">
                    <span></span>
                </div>

                <!-- Register Link -->
                <div class="auth-footer">
                    <p>Belum mempunyai akun? <a href="{{ route('register') }}">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
