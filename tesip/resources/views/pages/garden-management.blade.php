@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
    <div class="row mx-4 me-4-1">
        <div class="col-12 mx-1">
            <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn1 btn-danger1 ms-0 mx-auto mt-n2">Tambah Lahan</button>
            </div>
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <!DOCTYPE html>
                            <html>
                                <head>
                                    <style>
                                    /* Gaya untuk sel catur */
                                    .chessboard {
                                        display: grid;
                                        grid-template-columns: repeat(8, 50px); /* 8 kolom */
                                        grid-template-rows: repeat(8, 50px); /* 8 baris */
                                    }
                                    .dark {
                                        background-color: #769656; /* Warna sel gelap */
                                    }.light {
                                        background-color: #0000; /* Warna sel terang */
                                    }
                                    </style>
                                    </head>
                                    <body>
                                        <div class="chessboard">
                                             <!-- Baris 1 -->
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <!-- Baris 2 -->
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <!-- Baris 3 (dan seterusnya) -->
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>

                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>

                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>

                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <div class="light"></div>
                                             <div class="dark"></div>
                                             <!-- Silakan tambahkan sel-sel sisa sesuai dengan pola catur yang diinginkan -->
                                            </div>
                                        </body>
                                        </html>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
