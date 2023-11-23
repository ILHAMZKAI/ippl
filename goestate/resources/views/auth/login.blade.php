@extends('layouts.app')

@section('content')
<div class="container position-sticky z-index-sticky top-1">
    <div class="row">
        <div class="col-12">
            @include('layouts.navbars.guest.navbar')
        </div>
    </div>
</div>
<main class="main-content">
    <section>
        <div class="page-header min-vh-95">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-7 d-flex flex-column mx-lg-13 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Masuk</h4>
                                <p class="mb-0">Masukkan email dan kata sandi Anda untuk masuk</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    @method('post')
                                    <div class="flex flex-col mb-3">
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            value="{{ old('email')}}" placeholder="Email">
                                        @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            placeholder="Password">
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Masuk</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    Lupa kata sandi Anda? Atur ulang kata sandi Anda
                                    <a href="{{ route('reset-password') }}"
                                        class="text-primary text-gradient font-weight-bold">di sini</a>
                                </p>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-primary text-gradient font-weight-bold">Daftar</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto ps-0 pe-13 position-fixed top-0 end-50 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('/img/logos/logo-01.png');
              background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">"Website Manajemen
                                Perkebunan"</h4>
                            <p class="text-white position-relative">Pertanian Modern, Hasil Tradisional Terbaik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection