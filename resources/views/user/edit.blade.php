@extends('layouts.app')

@section('title', 'Dashboard - Jejakkebaikan')

@section('content')
    <div class="user-breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>&gt;</span>
        <a href="{{ route('dashboard.index') }}">Dashboard</a> <span>&gt;</span>
        Kelola Campaign
    </div>
<div class="dashboard-container">

    @include('user.sidebar')

    <div class="dashboard-content">

        <div class="profile-header-user">
            <h2>Profile Saya</h2>
            <p>Isilah data profil dengan benar</p>
        </div>

        @if(session('success'))
            <div style="background: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="avatar-section-user">
                <div class="avatar-col text-center">
                    <div class="avatar-wrapper-user">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" id="avatarPreview" alt="Avatar">
                        @else
                            <i class="bi bi-person-fill avatar-icon-user" id="avatarIcon"></i>
                            <img src="" id="avatarPreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div style="font-size: 13px; color: #666; margin-top: 5px; text-align: center;">Foto</div>
                </div>

                <div>
                    <input type="file" name="photo" id="photoInput" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    <button type="button" class="btn-change-photo-user" onclick="document.getElementById('photoInput').click()">
                        Ganti Foto
                    </button>
                </div>
            </div>

            <div class="form-row-user">
                <div class="form-col-user">
                    <div class="form-group-user">
                        <label class="form-label-user">Email <span class="text-red">*</span></label>
                        <input type="email" class="form-input-user" value="{{ Auth::user()->email }}" disabled style="background: #f9f9f9;">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group-user">
                        <label class="form-label-user">Username <span class="text-red">*</span></label>
                        <input type="text" name="username" class="form-input-user" value="{{ old('username', Auth::user()->username) }}" placeholder="Masukkan Username Anda">
                    </div>
                </div>
            </div>

            <div class="form-group-user">
                <label class="form-label-user">Nama Lengkap <span class="text-red">*</span></label>
                <input type="text" name="name" class="form-input-user" value="{{ old('name', Auth::user()->name) }}" placeholder="Masukkan Nama Lengkap Anda">
            </div>

            <div class="form-group-user">
                <label class="form-label-user">Jenis Kelamin <span class="text-red">*</span></label>
                <div class="gender-wrapper">
                    <label>
                        <input type="radio" name="gender" value="Pria" class="gender-radio" {{ Auth::user()->gender == 'Pria' ? 'checked' : '' }}>
                        <div class="gender-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mars-icon lucide-mars">
                                <path d="M16 3h5v5"/>
                                <path d="m21 3-6.75 6.75"/>
                                <circle cx="10" cy="14" r="6"/>
                            </svg>
                            Pria
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Wanita" class="gender-radio" {{ Auth::user()->gender == 'Wanita' ? 'checked' : '' }}>
                        <div class="gender-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-venus-icon lucide-venus">
                                <path d="M12 15v7"/>
                                <path d="M9 19h6"/>
                                <circle cx="12" cy="9" r="6"/>
                            </svg>
                            Wanita
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-group-user">
                <label class="form-label-user">Nomor Handphone <span class="text-red">*</span></label>
                <input type="tel" name="phone" class="form-input-user" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Masukkan Nomor Handphone Anda">
            </div>

            <div class="form-group-user">
                <label class="form-label-user">Alamat <span class="text-red">*</span></label>
                <input type="text" name="address" class="form-input-user" value="{{ old('address', Auth::user()->address) }}" placeholder="Masukkan Alamat Anda">
            </div>

            <div class="form-group-user">
                <label class="form-label-user">Bio</label>
                <textarea name="bio" class="form-input-user" rows="4" placeholder="Tulis bio singkat...">{{ old('bio', Auth::user()->bio) }}</textarea>
            </div>

            <button type="submit" class="btn-save">SIMPAN</button>

        </form>
    </div>
</div>

<script>
    // Preview Image Logic
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.getElementById('avatarPreview');
                var icon = document.getElementById('avatarIcon');

                img.src = e.target.result;
                img.style.display = 'block';

                if(icon) icon.style.display = 'none';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
