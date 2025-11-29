<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Jejakkebaikan</title>
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

                <h1>Mulai Jejak Kebaikanmu<br>di Sini!</h1>
                <p>Satu langkah kecil darimu bisa membawa dampak besar bagi mereka yang membutuhkan.</p>

                <div class="illustration">
                    <img src="{{ asset('images/ilustrasi.png') }}" alt="Illustration">
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <h1>Daftar Sekarang</h1>

                <form action="{{ route('register.submit') }}" method="POST" class="auth-form">
                    @csrf

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

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

                    <!-- Nomor Handphone -->
                    <div class="form-group">
                        <label for="phone">Nomor Handphone</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}"
                            required
                        >
                        @error('phone')
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

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="password-field">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="far fa-eye" id="password_confirmation-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">Daftar</button>
                </form>

                <!-- Login Link -->
                <div class="auth-footer">
                    <p>Sudah mempunyai akun? <a href="{{ route('login') }}">Masuk</a></p>
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
