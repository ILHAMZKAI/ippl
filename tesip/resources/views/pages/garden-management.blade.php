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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
