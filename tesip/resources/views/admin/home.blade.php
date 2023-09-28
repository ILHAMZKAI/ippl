@extends('layouts.appad', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnavad', ['title' => 'Manajemen Admin'])
    <div class="row mx-4 me-4-1">
        <div class="col-12 mx-1">
            <div class="alert1 alert-light"><strong>Pengguna GoEstate</strong>
            </div>
        </div>
    </div>
@endsection
