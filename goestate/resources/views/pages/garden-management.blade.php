@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
@if (session('error'))
<div id="alert-container" class="alert alert-danger ms-4-2 me-5 auto-hide-alert" style="color: white;">
    {{ session('error') }}
</div>
@endif

@if (session('success'))
<div id="success-container" class="alert alert-success ms-4-2 me-5 auto-hide-alert" style="color: white;">
    {{ session('success') }}
</div>
@endif
<div class="row mx-4 me-4-1 mb-4">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Perkebunan</strong> @csrf
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2" onclick="toggleFloatingDiv()">Alat</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" onclick="simpanData()">Simpan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="UbahLahanButton">Ubah Lahan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="tambahLahanButton">Tambah Lahan</button>
        </div>
    </div>
</div>

<div class="col-md-2" id="minDiv" style="display: none;">
    <img src="/img/logos/favicon.png" alt="Cyan Circle Image" style="width: 30px; height: 30px;">
</div>

<div class="col-md-2" id="floatingDiv" style="display: none;">
    <div class="card px-8">
        <div class="d-flex">
            <a class="ms-6 px-4" style="font-weight: bold; cursor: pointer;" onclick="minButton()">-</strong></a>
            <a class="ms-n2" style="font-weight: bold; cursor: pointer;" onclick="closeButton()">X</strong></a>
        </div>
        <div class="card-body mx-n8 mb-n3">
            <div>
                <button class="btn btn-dark pe-4" id="hapusButton" onclick="hapusSelectedCell()">Hapus</button>
                <button class="btn btn-dark ms-3 px-4-1">Info</button>
            </div>
            <div>
                <button class="btn btn-dark px-5" id="markButton" onclick="setMark()">Tandai Lahan</button>
                <div id="markActionPicker" style="display: none;">
                    <button class="btn btn-success" onclick="refreshButton()">OK</button>
                </div>
            </div>
            <div>
                <button class="btn btn-dark px-md-5" id="catatanButton" onclick="setCatatan()">Tambah
                    Berat</button>
                <div id="weightPicker" style="display: none;">
                    <input type="number" class="form-control" id="weightInput" placeholder="Angka dalam kilogram">
                    <button class="btn btn-success mt-3" onclick="refreshButton()">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mx-4 me-4-1 ms-4-1" id="formLahan" style="display:none;">
    <div class="col-md-2">
        <div class="card px-8 mb-3">
            <div class="card-body mx-n8 mb-n3">
                <form method="POST" action="{{ route('create-lahan') }}">
                    @csrf
                    <div class="form-group">
                        <label for="inputNamaLahan">Nama Lahan:</label>
                        <input type="text" class="form-control" id="inputNamaLahan" name="namaLahan"
                            placeholder="Masukkan nama lahan" required>
                    </div>
                    <div class="form-group">
                        <label for="inputBaris">Baris:</label>
                        <input type="number" class="form-control" id="inputBaris" name="jumlahBaris"
                            placeholder="Masukkan jumlah baris" required>
                    </div>
                    <div class="form-group">
                        <label for="inputKolom">Kolom:</label>
                        <input type="number" class="form-control" id="inputKolom" name="jumlahKolom"
                            placeholder="Masukkan jumlah kolom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Lahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mx-4 me-4-1 ms-4-1" id="formUbah" style="display:none;">
    <div class="col-md-2">
        <div class="card px-8 mb-3">
            <div class="card-body mx-n8 mb-n3">
                <form id="updateForm" method="POST" action="{{ route('update-lahan') }}">
                    @csrf
                    <div class="form-group">
                        <label>ID Lahan:</label>
                        <input type="text" class="form-control" id="EinputIdLahan" placeholder="Masukkan ID lahan"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lahan:</label>
                        <input type="text" class="form-control" id="EinputNamaLahan" placeholder="Masukkan nama lahan"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Baris:</label>
                        <input type="number" class="form-control" id="EinputBaris" placeholder="Masukkan jumlah baris"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Kolom:</label>
                        <input type="number" class="form-control" id="EinputKolom" placeholder="Masukkan jumlah kolom"
                            required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="ubahLahan()">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@php
$cardCounter = 0;
@endphp
<div id="tabelLahanContainer">
    @foreach ($lahanData as $lahan)
    @php
    $cardCounter++;
    @endphp
    <div class="row">
        <div class="col-md-11 ms-4-2">
            <form method="POST" action="{{ route('delete-lahan', $lahan->id) }}" id="deleteForm{{ $lahan->id }}">
                @csrf
                <div class="alert1 alert-light me-n3-1" onclick="toggleElements({{ $cardCounter }})">
                    <div class="row">
                        <div class="col-md mb-n2">
                            <div id="namaLahanDiv{{ $cardCounter }}">{{ $lahan->nama }}</div>
                        </div>
                        <div class="col-md mb-n2">
                            <div id="idLahanDiv{{ $cardCounter }}">ID Lahan: {{ $lahan->id }}</div>
                        </div>
                        <div class="col-md-auto">
                            <i class="fas fa-trash me-2" style="cursor: pointer;"
                                onclick="submitDeleteForm({{ $lahan->id }})" data-id="{{ $lahan->id }}"></i>
                        </div>
                    </div>
                </div>
            </form>
            <div class="content col-md-12 pt-2" id="content{{ $cardCounter }}" style="display: none;">
                <div class="card1 me-n3-1 mt-n4 mb-4">
                    <div class="card-body ms-n4-1 mb-n2">
                        <div class="row">
                            <div class="col-md-9 mx-4-1">
                                <div class="card mb-3">
                                    <div class="card-body px-4 py-4">
                                        <button class="btn btn-primary me-3" onclick="zoomIn('{{ $cardCounter }}')"><i
                                                class="fas fa-search-plus"></i></button>
                                        <button class="btn btn-primary" onclick="zoomOut('{{ $cardCounter }}')"><i
                                                class="fas fa-search-minus"></i></button>
                                        <div class="table-container"
                                            style="max-height: auto; overflow: auto; transform: scale(1);">
                                            <table class="table" id="contBody{{ $cardCounter }}">
                                                @csrf
                                                <tbody id="tableBody{{ $cardCounter }}"
                                                    onclick="handleCellClick({{ $cardCounter }}, {{ $lahan->id }})">
                                                    @include('pages.script')
                                                    <script>
                                                        buatTabel("{{ $lahan->id }}", "{{ $lahan->nama }}", {{ $lahan-> jumlah_baris }}, {{ $lahan-> jumlah_kolom }},
                                                            {{ $cardCounter }});
                                                    </script>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ms-n5">
                                <div class="card me-n5">
                                    <div class="card-body">
                                        Total Berat: <span id="totalWeight{{ $cardCounter }}"
                                            data-lahan-id="{{ $lahan->id }}" data-user-id="{{ Auth::id() }}"></span>
                                        @csrf
                                        <button class="btn btn-dark px-4 mt-2 mb-n1"
                                            onclick="resetCell('{{ $lahan->id }}', '{{ $cardCounter }}')">Reset
                                            Lahan</button>
                                    </div>
                                </div>
                                <div class="card me-n5" style="margin-top: 25px;">
                                    <div class="card-body">
                                        <div>
                                            <label class="ms-0 mb-n2">Pilih Aksi:</label>
                                            <select id="selectAction{{ $cardCounter }}"
                                                style="width: 170px; margin-bottom: 8px;">
                                                <option value="pemupukan">Pemupukan</option>
                                                <option value="panen">Panen</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="ms-0 mb-n2">Tanggal dan Waktu:</label>
                                            <input type="datetime-local" id="dateTimePicker{{ $cardCounter }}"
                                                style="width: 170px; margin-bottom: 8px;">
                                        </div>
                                        <div>
                                            @csrf
                                            <button class="btn btn-dark px-4"
                                                onclick="saveActionTimer({{ $lahan->id }}, {{ $cardCounter }}, {{ auth()->user()->id }})">Simpan
                                                Jadwal</button>
                                        </div>
                                        <div>
                                            <span id="timer{{ $cardCounter }}" data-timer-id="{{ $lahan->id }}"
                                                user-id="{{ Auth::id() }}"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.script')
    @endforeach
</div>
@include('pages.script')
@endsection