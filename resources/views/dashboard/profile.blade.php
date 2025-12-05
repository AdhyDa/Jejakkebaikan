@extends('layouts.app')

@section('title', 'Edit Profil - Jejakkebaikan')

@section('content')
<div class="dashboard-layout">
    <div class="dashboard-sidebar">
        <h5 class="sidebar-title">Dashboard</h5>

        <div class="dashboard-menu">
            <a href="{{ route('dashboard.index') }}"
                class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Utama
            </a>

            <a href="{{ route('dashboard.profile') }}"
                class="menu-item {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Edit Profil
            </a>

            <a href="{{ route('dashboard.change-password') }}"
                class="menu-item {{ request()->routeIs('dashboard.change-password') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Ganti Password
            </a>

            <a href="#" class="menu-item text-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Keluar
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <div class="dashboard-main" style="background-color: #fff;">
        <div class="profile-header">
            <h3>Profile Saya</h3>
            <p>Isilah data profil dengan benar</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="avatar-section">
                <div class="avatar-wrapper">
                    <div class="avatar-circle">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" id="avatarPreview">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=173059&color=fff" id="avatarPreview">
                        @endif
                    </div>
                    <div class="avatar-label">Foto</div>
                </div>

                <div>
                    <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                    <label for="avatarInput" class="btn-ganti-foto">
                        Ganti Foto
                    </label>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Email <span class="text-red">*</span></label>
                    <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled style="background-color: #fff;">
                </div>
                <div class="form-group">
                    <label class="form-label">Username <span class="text-red">*</span></label>
                    <input type="text" name="username" class="form-input" value="{{ old('username', auth()->user()->username) }}" placeholder="Masukkan Username Anda">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="text-red">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan Nama Lengkap Anda">
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Kelamin <span class="text-red">*</span></label>
                <div class="gender-group">
                    <label class="gender-option">
                        <input type="radio" name="gender" value="Pria" {{ auth()->user()->gender == 'Pria' ? 'checked' : '' }}>
                        <div class="gender-box">
                            <svg class="gender-icon" viewBox="0 0 24 24">
                                <path d="M16 2h6v6l-4.2-4.2-3.3 3.3c.9 1.4 1.5 3 1.5 4.9 0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8c1.9 0 3.5.6 4.9 1.5L16.2 6.2 16 2z" fill="none" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            Pria
                        </div>
                    </label>

                    <label class="gender-option">
                        <input type="radio" name="gender" value="Wanita" {{ auth()->user()->gender == 'Wanita' ? 'checked' : '' }}>
                        <div class="gender-box">
                            <svg class="gender-icon" viewBox="0 0 24 24">
                                <path d="M12 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm0 16v3m-3 0h6" fill="none" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            Wanita
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Handphone <span class="text-red">*</span></label>
                <input type="text" name="phone" class="form-input" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Masukkan Nomor Handphone Anda">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat <span class="text-red">*</span></label>
                <input type="text" name="address" class="form-input" value="{{ old('address', auth()->user()->address) }}" placeholder="Masukkan Alamat Anda">
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-input" rows="4">{{ old('bio', auth()->user()->bio) }}</textarea>
            </div>

            <button type="submit" class="btn-simpan">
                SIMPAN
            </button>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
