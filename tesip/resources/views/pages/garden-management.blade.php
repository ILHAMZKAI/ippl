@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2">Simpan</button>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-1">
                <div class="card mb-0">
                    <div class="card-body px-4 py-4">
                        <div class="table-container">
                            <table class="table">
                                <tbody>
                                    @for ($i = 1; $i <= 15; $i++) <tr class="cell">
                                        @for ($j = 1; $j <= 4; $j++) <td class="cell" style="background-color: white; border: 3px solid black;">
                                            </td>
                                            @endfor
                                            </tr>
                                            @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-1">
                <div class="card mt-3">
                    <div class="card-body mb-n3">
                        <div>
                            <button class="btn btn-danger ms-n1">Merah</button>
                        </div>
                        <div>
                            <button class="btn btn-yellow ms-n1">Kuning</button>
                        </div>
                        <div>
                            <button class="btn btn-light ms-n1">Hapus</button>
                        </div>
                        <div>
                            <button class="btn btn-secondary ms-n1">Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection