@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2">Simpan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2">Ubah Lahan</button>
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
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tabelLahanContainer">
</div>

<script>
    var cardCounter = 1;

    function buatCard(namaLahan, jumlahBaris, jumlahKolom) {
        var tabelLahanContainer = document.getElementById("tabelLahanContainer");
        var tabelLahanDiv = document.createElement("div");
        tabelLahanDiv.className = "row";
        tabelLahanDiv.innerHTML = `
            <div class="col-md-8 mx-4-1">
                <div class="card mb-0">
                    <div class="card-body px-4 py-4">
                        <div id="namaLahanDiv${cardCounter}"></div>
                        <div class="table-container">
                            <table class="table">
                                <tbody id="tableBody${cardCounter}">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 ms-n5">
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
        `;
        tabelLahanContainer.appendChild(tabelLahanDiv);

        buatTabel(namaLahan, jumlahBaris, jumlahKolom, cardCounter);
        cardCounter++;
    }

    function buatTabel(namaLahan, baris, kolom, counter) {
        var tableBody = document.getElementById(`tableBody${counter}`);
        tableBody.innerHTML = '';

        for (var i = 1; i <= baris; i++) {
            var row = document.createElement("tr");
            for (var j = 1; j <= kolom; j++) {
                var cell = document.createElement("td");
                cell.className = "cell";
                cell.style.backgroundColor = "white";
                cell.style.border = "3px solid black";
                cell.addEventListener("click", function() {
                    this.style.backgroundColor = warnaAktif;
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

    var warnaAktif = "white";

    function ubahWarna(warna) {
        warnaAktif = warna;
    }

    function resetWarna() {
        var sel = document.getElementsByClassName("cell");
        for (var i = 0; i < sel.length; i++) {
            sel[i].style.backgroundColor = "white";
        }
    }

    function hapusWarna(warna) {
        warnaAktif = warna;
    }

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
        var namaLahan = document.getElementById("inputNamaLahan").value;
        var jumlahBaris = parseInt(document.getElementById("inputBaris").value);
        var jumlahKolom = parseInt(document.getElementById("inputKolom").value);

        if (!isNaN(jumlahBaris) && !isNaN(jumlahKolom) && jumlahBaris > 0 && jumlahKolom > 0) {
            buatCard(namaLahan, jumlahBaris, jumlahKolom);
            document.getElementById("formLahan").style.display = "none";
        } else {
            alert("Harap masukkan nilai yang valid untuk baris dan kolom.");
        }
    });
</script>
@endsection