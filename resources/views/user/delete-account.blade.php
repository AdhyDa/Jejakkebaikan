@extends('layouts.app')

@section('title', 'Hapus Akun - Jejakkebaikan')

@section('content')
    <div class="user-breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>></span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a> <span>></span>
        Hapus Akun
    </div>
<div class="dashboard-container">

    @include('user.sidebar')

    <div class="dashboard-content">
        <div class="page-header">
            <h2>Hapus Akun</h2>
            <p>Hapus Akun Anda Secara Permanen</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-danger">
            <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen, termasuk:
            <ul>
                <li>Informasi profil</li>
                <li>Riwayat donasi</li>
                <li>Kampanye yang Anda buat</li>
                <li>Data lainnya yang terkait dengan akun Anda</li>
            </ul>
        </div>

        <form action="{{ route('dashboard.account.delete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label class="form-label">Konfirmasi dengan mengetik "HAPUS AKUN SAYA"</label>
                <input type="text" name="confirmation" class="form-input" placeholder="Ketik konfirmasi di sini" required>
            </div>

            <button type="submit" class="btn-save" style="background-color: #dc3545;" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')">HAPUS AKUN</button>
        </form>
    </div>
</div>

@endsection
