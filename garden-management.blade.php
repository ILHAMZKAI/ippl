@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2">Simpan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="buatButton">Tambah Lahan</button>
        </div>
    </div>
    <div class="container" id="kontainerLahan">
    </div>
    <!-- <div class="container" id="tampilanLahan" style="display:none;">
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
            <div class="col-md-4 mx-1 pe-8">
                <div class="card mt-3">
                    <div class="card-body mb-n3">
                        <div>
                            <button class="btn btn-danger pe-5 ms-n1">Merah</button>
                            <button class="btn btn-primary ms-2-1 px-4-2">Hijau</button>
                        </div>
                        <div>
                            <button class="btn btn-yellow ms-n1 px-4">Kuning</button>
                            <button class="btn btn-dark ms-3-1 ps-5-1">Reset</button>
                        </div>
                        <div>
                            <button class="btn btn-light pe-5 ms-n1">Hapus</button>
                            <button class="btn btn-secondary ms-2-1 px-4-1">Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <script>
        var jumlahLahan = 1;

        document.getElementById("buatButton").addEventListener("click", function() {
            var kontainerLahan = document.getElementById("kontainerLahan");
            var lahanBaru = document.createElement("div");
            lahanBaru.className = "row mt-3";
            lahanBaru.innerHTML = `
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
                <div class="col-md-2">
                    <div class="card px-8">
                        <div class="card-body mx-n8 mb-n3">
                            <div>
                                <button class="btn btn-danger pe-5 ms-n1">Merah</button>
                                <button class="btn btn-primary ms-2-1 px-4-2">Hijau</button>
                            </div>
                            <div>
                                <button class="btn btn-yellow ms-n1 px-4">Kuning</button>
                                <button class="btn btn-dark ms-3-1 ps-5-1">Reset</button>
                            </div>
                            <div>
                                <button class="btn btn-light pe-5 ms-n1">Hapus</button>
                                <button class="btn btn-secondary ms-2-1 px-4-1">Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            kontainerLahan.appendChild(lahanBaru);
            jumlahLahan++;
        });
    </script>
</div>
@endsection