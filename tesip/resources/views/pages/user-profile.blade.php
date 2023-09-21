@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profil Anda'])
    <div class="card shadow-lg mx-4 mt-1 card-profile-bottom">
        <div class="card-body p-2 mb-n2">
            <div class="row gx-1">
                <div class="col-auto">
                    <div class=" avatar-xl position-relative">
                        <!-- <img src="/img/team-1.jpg" alt="profile_image" class="w-100 rounded-circle shadow-sm"> -->
                        <img src="{{ asset('storage/user_images/' . auth()->user()->gambar) }}" width="65" height="65" class="w-101 h-101 rounded-circle shadow-sm" >
                    </div>
                </div>
                <div class="col-auto my-auto mt-n4">
                    <div class="h-100">
                        <form action="{{ route('user-profile.delete-image') }}" method="POST"> 
                            <h3 class="mb-2">
                                {{ auth()->user()->firstname ?? '' }} {{ auth()->user()->lastname ?? '' }}
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger ms-2 mx-8 mt-2">Hapus Profil</button>
                            </h3>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header-0 pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 mx-4 me-xxl-4">Ubah Profil</p>
                                <button type="submit" class="btn btn-primary btn-sm mt-3 ms-auto me-auto">Simpan</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Informasi Pengguna</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama panggilan</label>
                                        <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat email</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama depan</label>
                                        <input class="form-control" type="text" name="firstname"  value="{{ old('firstname', auth()->user()->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama belakang</label>
                                        <input class="form-control" type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="gambar" class="form-label">Ganti foto profil</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                    <input class="form-control" type="file" id="gambar" name="gambar" onchange="previewImage()">
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Informasi Kontak</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', auth()->user()->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kota</label>
                                        <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Negara</label>
                                        <input class="form-control" type="text" name="country" value="{{ old('country', auth()->user()->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kode pos</label>
                                        <input class="form-control" type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Tentang</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tentang saya</label>
                                        <input class="form-control" type="text" name="about"
                                            value="{{ old('about', auth()->user()->about) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(){
            const image = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent){
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
