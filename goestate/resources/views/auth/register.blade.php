@extends('layouts.app')

@section('content')
@include('layouts.navbars.guest.navbar')
<main class="main-content">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-4 m-2 border-radius-lg" style="background-image: url('/img/bg109.jpg'); background-position: 70;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-4,5">Selamat datang!</h1>
                    <p class="text-lead text-white">Laman ini untuk membuat akun baru di Website Manajemen Kebun Anda</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-np1 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-5 mx-auto">
                <div class="card z-index-0">
                    <div class="text-center">
                        <h3>Daftar</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.perform') }}">
                            @csrf
                            <div class="flex flex-col mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Nama pengguna" aria-label="Name" value="{{ old('username') }}">
                                @error('username') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                            </div>
                            <div class="flex flex-col mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" value="{{ old('email') }}" required>
                                @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                            </div>
                            <div class="flex flex-col mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Kata sandi" aria-label="Password">
                                @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                            </div>
                            <div class="form-check form-check-info text-start">
                                <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Saya menyetujui <a href="javascript:;" class="text-dark font-weight-bolder">Syarat dan Ketentuan</a>
                                </label>
                                @error('terms') <p class='text-danger text-xs'> {{ $message }} </p> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-2 mb-0">Daftar</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footers.guest.footer')
@endsection