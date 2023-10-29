@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1 mb-4">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Perkebunan</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2" onclick="toggleFloatingDiv()">Alat</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2">Simpan</button>
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
                <button class="btn btn-dark px-md-5" id="catatanButton" onclick="catatan()">Tambah Catatan</button>
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
                <form id="formInputLahan">
                    <div class="form-group">
                        <label for="inputNamaLahan">Nama Lahan:</label>
                        <input type="text" class="form-control" id="inputNamaLahan" placeholder="Masukkan nama lahan" required>
                    </div>
                    <div class="form-group">
                        <label for="inputBaris">Baris:</label>
                        <input type="number" class="form-control" id="inputBaris" placeholder="Masukkan jumlah baris" required>
                    </div>
                    <div class="form-group">
                        <label for="inputKolom">Kolom:</label>
                        <input type="number" class="form-control" id="inputKolom" placeholder="Masukkan jumlah kolom" required>
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
                <form id="formEdit">
                    <div class="form-group">
                        <label for="EinputIdLahan">ID Lahan:</label>
                        <input type="text" class="form-control" id="EinputIdLahan" placeholder="Masukkan ID lahan" required>
                    </div>
                    <div class="form-group">
                        <label for="EinputNamaLahan">Nama Lahan:</label>
                        <input type="text" class="form-control" id="EinputNamaLahan" placeholder="Masukkan nama lahan" required>
                    </div>
                    <div class="form-group">
                        <label for="EinputBaris">Baris:</label>
                        <input type="number" class="form-control" id="EinputBaris" placeholder="Masukkan jumlah baris" required>
                    </div>
                    <div class="form-group">
                        <label for="EinputKolom">Kolom:</label>
                        <input type="number" class="form-control" id="EinputKolom" placeholder="Masukkan jumlah kolom" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="simpanLahan()">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tabelLahanContainer">
</div>
@include('pages.script')
@endsection