@extends('layouts.app')

@section('title', 'Ganti Password - Jejakkebaikan')

@section('content')
    <div class="user-breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>&gt;</span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a> <span>&gt;</span>
        Ganti Password
    </div>
<div class="dashboard-container">

    @include('user.sidebar')

    <div class="dashboard-content">
        <div class="page-header">
            <h2>Ganti Password</h2>
            <p>Ganti Password Sekarang!</p>
        </div>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Password Lama</label>
                <div class="password-wrapper">
                    <input type="password" name="current_password" id="current_password" class="form-input password-field" placeholder="Masukkan Password Lama Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-open" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7c.44 0 .88-.02 1.32-.05"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" class="form-input password-field" placeholder="Masukkan Password Baru Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-open" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7c.44 0 .88-.02 1.32-.05"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input password-field" placeholder="Konfirmasi Password Baru Anda" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-open" style="display: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7c.44 0 .88-.02 1.32-.05"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-save">SIMPAN</button>

        </form>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan/menyembunyikan password
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        if (input.type === "password") {
            input.type = "text";
            eyeOpen.style.display = 'block';
            eyeClosed.style.display = 'none';
        } else {
            input.type = "password";
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'block';
        }
    }
</script>

@endsection
