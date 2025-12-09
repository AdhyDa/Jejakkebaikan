@extends('layouts.app')

@section('title', 'Buat Campaign - Jejakkebaikan')

@section('content')
<div class="nav-container">
    <div class="breadcrumb-nav">
        <a href="{{ route('home') }}">Home</a> &nbsp; > &nbsp;
        <a href="{{ route('dashboard.index') }}">Dashboard</a> &nbsp; > &nbsp; Buat Campaign
    </div>
</div>
<div class="create-form-container">
    <h2 class="page-title">Buat Campaign Baru</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-4 rounded-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <input type="file" id="imageInput" name="image" accept="image/jpeg,image/png,image/jpg" class="d-none" required onchange="previewImage(this)">
            <label for="imageInput" class="upload-box-wrapper">
                <div class="upload-placeholder-content" id="uploadPlaceholder">
                    <div class="upload-icon-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload">
                            <path d="M12 3v12"/>
                            <path d="m17 8-5-5-5 5"/>
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        </svg>
                    </div>
                    <div class="upload-text-hint">Upload an image (jpg, png, jpeg) <span class="text-red">*</span></div>
                </div>
                <img id="image-preview" src="#" alt="Preview">
            </label>
        </div>

        <div class="form-group">
            <label for="title" class="form-label-custom">Judul Campaign <span class="text-red">*</span></label>
            <input type="text" class="form-input-rounded" id="title" name="title" value="{{ old('title') }}" required placeholder="Masukkan Judul Campaign" oninput="capitalizeTitle(this)">
        </div>


        <div class="form-group">
            <label for="organization_name" class="form-label-custom">Organisasi <span class="text-red">*</span></label>
            <input type="text" class="form-input-rounded" id="organization_name" name="organization_name" value="{{ old('organization_name', 'Jejakkebaikan') }}" required placeholder="Masukkan Nama Organisasi">
        </div>

        <input type="hidden" name="organization_name" value="{{ old('organization_name', 'Jejakkebaikan') }}">

        <div class="form-group">
            <label for="description" class="form-label-custom">Deskripsi Lengkap <span class="text-red">*</span></label>
            <textarea class="form-input-rounded" id="description" name="description" rows="6" required placeholder="Masukkan Deskripsi/Cerita Campaign">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="category" class="form-label-custom">Kategori Campaign <span class="text-red">*</span></label>
            <select class="form-input-rounded" id="category" name="category" required style="-webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill=\"%23999\" height=\"24\" viewBox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>'); background-repeat: no-repeat; background-position: right 15px center;">
                <option value="">Masukkan Kategori Campaign</option>
                <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Kemanusiaan" {{ old('category') == 'Kemanusiaan' ? 'selected' : '' }}>Kemanusiaan</option>
                <option value="Kesehatan" {{ old('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                <option value="Bencana Alam" {{ old('category') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                <option value="Lingkungan" {{ old('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                <option value="Panti Asuhan" {{ old('category') == 'Panti Asuhan' ? 'selected' : '' }}>Panti Asuhan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="end_date" class="form-label-custom">Batas Waktu Campaign <span class="text-red">*</span></label>
            {{-- Trik agar placeholder muncul sebelum diklik jadi date picker --}}
            <input type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="form-input-rounded" id="end_date" name="end_date" value="{{ old('end_date') }}" required placeholder="DD/MM/YY">
        </div>

        <div class="form-group">
            <label class="form-label-custom">Kebutuhan Campaign <span class="text-red">*</span></label>

            <div class="needs-container">

                <div class="need-item-row">
                    <input type="checkbox" class="btn-check-hidden" id="need_money" name="need_money" value="1" onchange="toggleNeed('money')">
                    <label class="btn-pill-custom" for="need_money">Dana</label>

                    <div class="dynamic-input-wrapper" id="input_wrapper_money">
                        <input type="number" class="form-input-rounded" name="target_amount" placeholder="Target Nominal Dana">
                    </div>
                </div>

                <div class="need-item-col">
                    <div class="need-item-row">
                        <input type="checkbox" class="btn-check-hidden" id="need_goods" name="need_goods" value="1" onchange="toggleNeed('goods')">
                        <label class="btn-pill-custom" for="need_goods">Barang</label>
                    </div>

                    <div class="dynamic-input-full" id="input_wrapper_goods">
                        <textarea class="form-input-rounded" name="goods_description" rows="3" placeholder="Deskripsi kebutuhan barang (akan muncul di tab Berita)"></textarea>
                    </div>
                </div>

                <div class="need-item-row">
                    <input type="checkbox" class="btn-check-hidden" id="need_volunteer" name="need_volunteer" value="1" onchange="toggleNeed('volunteer')">
                    <label class="btn-pill-custom" for="need_volunteer">Tenaga</label>

                    <div class="dynamic-input-wrapper" id="input_wrapper_volunteer">
                        <input type="number" class="form-input-rounded" name="volunteer_quota" placeholder="Jumlah Kapasitas Maksimal Relawan">
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons-row">
            <div class="action-col">
                <button type="submit" name="draft" value="1" class="btn-draft">Simpan Sebagai Draft</button>
            </div>
            <div class="action-col">
                <button type="submit" name="publish" value="1" class="btn-publish">Publikasikan Sekarang</button>
            </div>
        </div>

    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
                document.getElementById('uploadPlaceholder').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleNeed(type) {
        const checkbox = document.getElementById('need_' + type);
        const wrapper = document.getElementById('input_wrapper_' + type);

        if (checkbox.checked) {
            // Tampilkan input (Block untuk goods/full, Flex/Block untuk lainnya)
            wrapper.style.display = (type === 'goods') ? 'block' : 'block';

            // Set required jika diperlukan
            const inputField = wrapper.querySelector('input, textarea');
            if(inputField) inputField.required = true;
        } else {
            wrapper.style.display = 'none';

            // Reset value & required
            const inputField = wrapper.querySelector('input, textarea');
            if(inputField) {
                inputField.value = '';
                inputField.required = false;
            }
        }
    }

    function capitalizeTitle(input) {
        input.value = input.value.replace(/\b\w/g, l => l.toUpperCase());
    }
</script>
@endsection
