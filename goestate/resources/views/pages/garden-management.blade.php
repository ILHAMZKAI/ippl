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
        <div class="alert1 alert-light"><strong>Perkebunan</strong> @csrf <button class="btn btn-gm1 ms-0 mx-auto mt-n2"
                onclick="toggleFloatingDiv()">Alat</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" onclick="simpanData()">Simpan</button> <button class="btn btn-gm1
            ms-0 mx-3 mt-n2" id="UbahLahanButton">Ubah Lahan</button> <button class="btn btn-gm1 ms-0 mx-3 mt-n2"
                id="tambahLahanButton">Tambah Lahan</button>
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
                <button class="btn btn-dark px-5" id="timerButton" onclick="setTimer()">Tambah Waktu</button>
                <div id="dateAndActionPicker" style="display: none;">
                    <label for="dateTimePicker">Pilih Tanggal dan Waktu:</label>
                    <input type="datetime-local" id="dateTimePicker">
                    <label for="actionPicker">Pilih Aksi:</label>
                    <select id="actionPicker">
                        <option value="Fertilization">Pemupukan</option>
                        <option value="Harvest">Panen</option>
                    </select>
                    <button class="btn btn-success" onclick="confirmDateTimeAction()">OK</button>
                </div>
            </div>
            <div>
                <button class="btn btn-dark px-md-5" id="catatanButton" onclick="catatan()">Tambah
                    Catatan</button>
                <div id="NotesPicker" style="display: none;">
                    <input type="text" class="form-control" id="notesInput" placeholder="Angka dalam kilogram">
                    <button class="btn btn-success mt-3" onclick="confirmNotes()">OK</button>
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
    @foreach($lahanData as $lahan)
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
                                                <tbody id="tableBody{{ $cardCounter }}">
                                                    <script>
                                                        buatTabel("{{ $lahan->id }}", "{{ $lahan->nama }}", {{ $lahan-> jumlah_baris }}, {{ $lahan-> jumlah_kolom }}, {{ $cardCounter }});
                                                        function buatTabel(id, namaLahan, baris, kolom, counter) {
                                                            var tableBody = document.getElementById(`tableBody${counter}`);
                                                            tableBody.innerHTML = '';
                                                            var cellWidth = 100 / kolom + "%";
                                                            var cellHeight = 100 / baris + "%";
                                                            for (var i = 1; i <= baris; i++) {
                                                                var row = document.createElement("tr");
                                                                for (var j = 1; j <= kolom; j++) {
                                                                    var cell = document.createElement("td");
                                                                    cell.className = "cell";
                                                                    cell.style.backgroundColor = "white";
                                                                    cell.style.border = "3px solid grey";
                                                                    cell.style.width = cellWidth;
                                                                    cell.style.height = cellHeight;
                                                                    cell.style.overflow = "hidden";
                                                                    cell.style.lineHeight = cellHeight;
                                                                    cell.style.padding = "0";
                                                                    cell.style.margin = "0";
                                                                    cell.setAttribute('data-width', cell.clientWidth + 'px');
                                                                    cell.setAttribute('data-height', cell.clientHeight + 'px');
                                                                    cell.setAttribute('data-row', i);
                                                                    cell.setAttribute('data-col', j);
                                                                    cell.addEventListener("click", function () {
                                                                        this.style.backgroundColor = activeColor;
                                                                        this.style.width = cellWidth;
                                                                        this.style.height = cellHeight;
                                                                        selectCell(this);
                                                                    });
                                                                    row.appendChild(cell);
                                                                }
                                                                tableBody.appendChild(row);
                                                            }
                                                            var namaLahanDiv = document.getElementById(`namaLahanDiv${counter}`);
                                                            namaLahanDiv.textContent = "Lahan: " + namaLahan;
                                                            namaLahanDiv.style.fontWeight = "bold";
                                                            namaLahanDiv.style.marginBottom = "10px";
                                                        }
                                                    </script>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ms-n5">
                                <div class="card">
                                    <div class="card-body">
                                        Total Berat: <span id="totalWeight{{ $cardCounter }}">0</span>
                                        <button class="btn btn-dark px-4 mt-2 mb-n1"
                                            onclick="resetCell()">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@include('pages.script')
@endsection