@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2">Simpan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="tambahLahanButton">Tambah Lahan</button>
        </div>
    </div>
</div>
<div class="row mx-4 me-4-1 ms-4-1" id="formLahan" style="display:none;">
    <div class="col-md-2">
        <div class="card px-8">
            <div class="card-body mx-n8 mb-n3">
                <form id="formMasukkan">
                    <div class="form-group">
                        <label for="inputBaris">Baris:</label>
                        <input type="number" class="form-control" id="inputBaris" placeholder="Masukkan jumlah baris" required>
                    </div>
                    <div class="form-group">
                        <label for="inputKolom">Kolom:</label>
                        <input type="number" class="form-control" id="inputKolom" placeholder="Masukkan jumlah kolom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row ms-4" id="tabelLahan" style="display:none;">
    <div class="row">
        <div class="col-md-8 mx-1">
            <div class="card mb-0">
                <div class="card-body px-4 py-4">
                    <div class="table-container">
                        <table class="table">
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 ms-n2">
            <div class="card px-8">
                <div class="card-body mx-n8 mb-n3">
                    <div>
                        <button class="btn btn-danger pe-5 ms-n1" onclick="ubahWarna('red')">Merah</button>
                        <button class="btn btn-primary ms-2-1 px-4-2" onclick="ubahWarna('green')">Hijau</button>
                    </div>
                    <div>
                        <button class="btn btn-yellow ms-n1 px-4" onclick="ubahWarna('yellow')">Kuning</button>
                        <button class="btn btn-dark ms-3-1 ps-5-1" onclick="resetWarna()">Reset</button>
                    </div>
                    <div>
                        <button class="btn btn-light pe-5 ms-n1" onclick="hapusWarna('white')">Hapus</button>
                        <button class="btn btn-secondary ms-2-1 px-4-1">Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("tambahLahanButton").addEventListener("click", function() {
        var formLahan = document.getElementById("formLahan");
        if (formLahan.style.display === "none" || formLahan.style.display === "") {
            formLahan.style.display = "block";
        } else {
            formLahan.style.display = "none";
        }
    });

    document.getElementById("formMasukkan").addEventListener("submit", function(event) {
        event.preventDefault();
        var jumlahBaris = parseInt(document.getElementById("inputBaris").value);
        var jumlahKolom = parseInt(document.getElementById("inputKolom").value);

        if (!isNaN(jumlahBaris) && !isNaN(jumlahKolom) && jumlahBaris > 0 && jumlahKolom > 0) {
            buatTabel(jumlahBaris, jumlahKolom);
            document.getElementById("formLahan").style.display = "none";
        } else {
            alert("Harap masukkan nilai yang valid untuk baris dan kolom.");
        }
    });

    function buatTabel(baris, kolom) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = '';

        for (var i = 1; i <= baris; i++) {
            var row = document.createElement("tr");
            for (var j = 1; j <= kolom; j++) {
                var cell = document.createElement("td");
                cell.className = "cell";
                cell.style.backgroundColor = "white";
                cell.style.border = "3px solid black";
                cell.addEventListener("click", function() {
                    this.style.backgroundColor = warnaAktif; // Mengubah warna sel saat diklik
                });
                row.appendChild(cell);
            }
            tableBody.appendChild(row);
        }
        var tabelLahan = document.getElementById("tabelLahan");
        tabelLahan.style.display = "block";
    }

    var warnaAktif = "white"; // Inisialisasi warna aktif

    // Fungsi untuk mengubah warna aktif
    function ubahWarna(warna) {
        warnaAktif = warna;
    }

    // Fungsi untuk menghapus semua warna kolom
    function resetWarna() {
        var sel = document.getElementsByClassName("cell");
        for (var i = 0; i < sel.length; i++) {
            sel[i].style.backgroundColor = "white";
            sel[i].style.border = "3px solid black";
        }
        // var sel = document.getElementsByClassName("cell");
        // for (var i = 0; i < sel.length; i++) {
        //     sel[i].style.backgroundColor = "white";
        // }
    }

    // Fungsi untuk mengembalikan warna kolom ke awal
    function hapusWarna(warna) {
        warnaAktif = warna;
    }
</script>

@endsection