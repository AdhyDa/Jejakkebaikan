@extends('layouts.app')

@section('title', 'Buat Campaign - Jejakkebaikan')

@push('styles')
<style>
    /* PAGE TITLE */
    .page-title {
        color: #142850;
        font-weight: 800;
        text-align: center;
        margin-bottom: 30px;
        margin-top: 10px;
    }

    /* UPLOAD BOX CUSTOM */
    .upload-container {
        background-color: #aeb4b9; /* Abu-abu sesuai gambar */
        height: 220px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-bottom: 30px;
        position: relative;
        transition: 0.3s;
        border-radius: 4px; /* Sedikit rounded di sudut */
    }

    .upload-container:hover {
        opacity: 0.9;
    }

    .upload-icon {
        font-size: 3rem;
        color: #4a4a4a;
        margin-bottom: 5px;
    }

    .upload-text {
        color: #555;
        font-size: 0.85rem;
    }

    /* LABEL STYLING */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #142850;
        margin-bottom: 8px;
    }

    /* PILL BUTTONS & LAYOUT (VERTICAL) */
    .campaign-options-container {
        display: flex;
        flex-direction: column; /* Susun ke bawah */
        gap: 15px; /* Jarak antar tombol */
    }

    .dana-row {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        width: 100%;
    }

    /* Style Tombol Pill */
    .btn-outline-custom {
        min-width: 130px;
        border: 2px solid #aeb4b9;
        color: #6c757d;
        border-radius: 50px; /* Bentuk kapsul */
        padding: 8px 20px;
        font-weight: 700;
        background-color: white;
        transition: all 0.2s;
        text-align: center;
    }

    .btn-outline-custom:hover {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    /* State Checked */
    .btn-check:checked + .btn-outline-custom {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    /* Icon Checklist (Opsional, jika ingin persis gambar ada centang putih) */
    .btn-check:checked + .btn-outline-custom::before {
        content: "✓ ";
        font-weight: bold;
    }

    /* Target Input Wrapper */
    .target-input-wrapper {
        flex-grow: 1;
        max-width: 400px;
    }

    /* Input di dalam target wrapper */
    .target-input-wrapper .form-control {
        border-radius: 10px;
        border: 2px solid #aeb4b9; /* Border abu-abu tebal */
        color: #6c757d;
    }

    /* ACTION BUTTONS */
    .btn-action-draft {
        border: 2px solid #aeb4b9;
        color: #6c757d;
        background: white;
        border-radius: 10px;
        padding: 12px 0;
        width: 100%;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-action-draft:hover {
        background: #f8f9fa;
        color: #333;
    }

    .btn-action-publish {
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 0;
        width: 100%;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-action-publish:hover {
        background-color: #0b5ed7;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &nbsp; > &nbsp;
        <a href="{{ route('dashboard.index') }}">Dashboard</a> &nbsp; > &nbsp;
        <span>Buat Campaign Baru</span>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="page-title">Buat Campaign Baru</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="image" class="upload-container" id="upload-label">
                        <i class="bi bi-upload upload-icon"></i>
                        <span class="upload-text">upload image (jpg, png, jpeg) *</span>
                        <img id="image-preview" src="#" alt="Preview" style="display:none; width:100%; height:100%; object-fit:cover; position:absolute; border-radius:4px;">
                    </label>
                    <input type="file" class="d-none" id="image" name="image" accept="image/jpeg,image/png,image/jpg" required onchange="previewImage(this)">
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Campaign <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-3" id="title" name="title" value="{{ old('title') }}" required placeholder="Masukkan Judul Campaign">
                </div>
                <div class="mb-3">
                    <label for="organization_name" class="form-label">Organisasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-3" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required placeholder="Masukkan Organisasi Campaign">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control rounded-3" id="description" name="description" rows="5" required placeholder="Masukkan Deskripsi/Cerita Campaign">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Kategori Campaign <span class="text-danger">*</span></label>
                    <select class="form-select rounded-3" id="category" name="category" required>
                        <option value="">Masukkan Kategori Campaign</option>
                        <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="Kemanusiaan" {{ old('category') == 'Kemanusiaan' ? 'selected' : '' }}>Kemanusiaan</option>
                        <option value="Bencana Alam" {{ old('category') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                        <option value="Lingkungan" {{ old('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                        <option value="Panti Asuhan" {{ old('category') == 'Panti Asuhan' ? 'selected' : '' }}>Panti Asuhan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="end_date" class="form-label">Batas Waktu Campaign <span class="text-danger">*</span></label>
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control rounded-3" id="end_date" name="end_date" value="{{ old('end_date') }}" required placeholder="DD/MM/YY">
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Kebutuhan Campaign <span class="text-danger">*</span></label>

                    <div class="campaign-options-container">

                        <div class="dana-row">
                            <div>
                                <input type="checkbox" class="btn-check" id="need_money" name="need_money" value="1" {{ old('need_money') ? 'checked' : '' }} onchange="toggleMoneyTarget()">
                                <label class="btn btn-outline-custom rounded-pill" for="need_money">Dana</label>
                            </div>

                            <div id="target_amount_div" class="target-input-wrapper" style="display: none;">
                                <input type="number" class="form-control" id="target_amount" name="target_amount" value="{{ old('target_amount') }}" placeholder="Target Nominal Dana">
                            </div>
                        </div>

                        <div>
                            <input type="checkbox" class="btn-check" id="need_goods" name="need_goods" value="1" {{ old('need_goods') ? 'checked' : '' }}>
                            <label class="btn btn-outline-custom rounded-pill" for="need_goods">Barang</label>
                        </div>

                        <div>
                            <input type="checkbox" class="btn-check" id="need_volunteer" name="need_volunteer" value="1" {{ old('need_volunteer') ? 'checked' : '' }}>
                            <label class="btn btn-outline-custom rounded-pill" for="need_volunteer">Tenaga</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-5 mb-5">
                    <div class="col-6">
                        <button type="submit" name="draft" class="btn btn-action-draft">Simpan Sebagai Draft</button>
                    </div>
                    <div class="col-6">
                        <button type="submit" name="publish" class="btn btn-action-publish">Publikasikan Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview Image Logic
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
                document.querySelector('.upload-icon').style.display = 'none';
                document.querySelector('.upload-text').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle target amount field logic
    function toggleMoneyTarget() {
        const needMoney = document.getElementById('need_money');
        const targetAmountDiv = document.getElementById('target_amount_div');
        const targetAmountInput = document.getElementById('target_amount');

        if (needMoney.checked) {
            targetAmountDiv.style.display = 'block';
            targetAmountInput.required = true;
        } else {
            targetAmountDiv.style.display = 'none';
            targetAmountInput.required = false;
            targetAmountInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleMoneyTarget();
    });
</script>
@endpush
@endsection
