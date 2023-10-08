@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <button class="btn btn-gm1 ms-0 mx-auto mt-n2" onclick="konfirmasiHapus()">Hapus</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2">Simpan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="tambahLahanButton">Tambah Lahan</button>
            <button class="btn btn-gm1 ms-0 mx-3 mt-n2" id="UbahLahanButton">Ubah Lahan</button>
        </div>
    </div>
</div>

<div class="row mx-4 me-4-1 ms-4-1" id="formLahan" style="display:none;">
    <div class="col-md-2">
        <div class="card px-8 mb-3">
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

<script>
    var cardCounter = 1;
    var warnaAktif = "white";
    var isMerahAktif = false;
    var isHijauAktif = false;
    var isKuningAktif = false;
    var isHapusAktif = false;

    function buatCard(namaLahan, jumlahBaris, jumlahKolom) {
        var containerCounter = 1;
        var tabelLahanContainer = document.getElementById("tabelLahanContainer");
        var tabelLahanDiv = document.createElement("div");
        tabelLahanDiv.className = "row";
        var cardId = "" + cardCounter;
        tabelLahanDiv.id = cardId;
        tabelLahanDiv.innerHTML = `
            <div class="col-md-8 mx-4-1">
                <div class="card mb-3">
                    <div class="card-body px-4 py-4">
                        <div id="namaLahanDiv${cardCounter}"></div>
                        <div id="idLahanDiv${cardCounter}"></div>
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
                <div class="card px-8" me-n4>
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

        var idLahanDiv = document.getElementById(`idLahanDiv${cardCounter}`);
        idLahanDiv.textContent = "ID Lahan: " + cardId;

        buatTabel(namaLahan, jumlahBaris, jumlahKolom, cardCounter);
        cardCounter++;
    }

    function buatTabel(namaLahan, baris, kolom, counter) {
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
                cell.style.border = "3px solid black";
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

                cell.addEventListener("click", function() {
                    if (!this.querySelector('input[type="text"]')) {
                        var row = this.getAttribute('data-row');
                        var col = this.getAttribute('data-col');

                        this.innerHTML = '';

                        var inputAngka = document.createElement("input");
                        inputAngka.type = "text";
                        inputAngka.className = "numeric-input";
                        inputAngka.id = `inputAngka${counter}-${row}-${col}`;
                        inputAngka.style.border = "none";
                        inputAngka.style.padding = "0";
                        inputAngka.style.margin = "0";
                        inputAngka.style.background = "none";
                        inputAngka.style.outline = "none";
                        inputAngka.style.textAlign = "center";
                        inputAngka.style.width = "80%";
                        inputAngka.style.height = "100%";
                        inputAngka.style.color = "#008B8B";

                        inputAngka.addEventListener("input", function() {
                            if (this.value.length > 10) {
                                this.value = this.value.slice(0, 10);
                            }
                        });

                        this.appendChild(inputAngka);
                    }
                    this.style.backgroundColor = warnaAktif;
                    this.style.width = cellWidth;
                    this.style.height = cellHeight;
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

    function ubahWarna(warna) {
        if (warnaAktif === warna) {
            warnaAktif = "none";
        } else {
            warnaAktif = warna;
        }
        isMerahAktif = (warna === "red" && warnaAktif === "red");
        isHijauAktif = (warna === "green" && warnaAktif === "green");
        isKuningAktif = (warna === "yellow" && warnaAktif === "yellow");
    }

    function resetWarna() {
        var sel = document.getElementsByClassName("cell");
        for (var i = 0; i < sel.length; i++) {
            sel[i].style.backgroundColor = "white";
        }
    }

    function hapusWarna(warna) {
        if (warnaAktif === warna) {
            warnaAktif = "none";
        } else {
            warnaAktif = warna;
        }
    }

    function simpanLahan() {
        var inputIdLahan = document.getElementById("EinputIdLahan").value;
        var inputNamaLahan = document.getElementById("EinputNamaLahan").value;
        var inputBaris = parseInt(document.getElementById("EinputBaris").value);
        var inputKolom = parseInt(document.getElementById("EinputKolom").value);

        if (!isNaN(inputBaris) && !isNaN(inputKolom) && inputBaris > 0 && inputKolom > 0 && inputBaris <= 16 && inputKolom <= 26) {
            var cardId = "" + inputIdLahan;
            var cardToUpdate = document.getElementById(cardId);

            if (cardToUpdate) {
                var namaLahanDiv = cardToUpdate.querySelector(`#namaLahanDiv${inputIdLahan}`);
                namaLahanDiv.textContent = "Lahan: " + inputNamaLahan;

                var tableBody = cardToUpdate.querySelector(`#tableBody${inputIdLahan}`);
                tableBody.innerHTML = '';

                var cellWidth = 100 / inputKolom + "%";
                var cellHeight = 100 / inputBaris + "%";

                for (var i = 1; i <= inputBaris; i++) {
                    var row = document.createElement("tr");
                    for (var j = 1; j <= inputKolom; j++) {
                        var cell = document.createElement("td");
                        cell.className = "cell";
                        cell.style.backgroundColor = "white";
                        cell.style.border = "3px solid black";
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

                        cell.addEventListener("click", function() {
                            if (!this.querySelector('input[type="text"]')) {
                                var row = this.getAttribute('data-row');
                                var col = this.getAttribute('data-col');

                                this.innerHTML = '';

                                var inputAngka = document.createElement("input");
                                inputAngka.type = "text";
                                inputAngka.className = "numeric-input";
                                inputAngka.id = `inputAngka${inputIdLahan}-${row}-${col}`;
                                inputAngka.style.border = "none";
                                inputAngka.style.padding = "0";
                                inputAngka.style.margin = "0";
                                inputAngka.style.background = "none";
                                inputAngka.style.outline = "none";
                                inputAngka.style.textAlign = "center";
                                inputAngka.style.width = "80%";
                                inputAngka.style.height = "100%";
                                inputAngka.style.color = "#008B8B";

                                inputAngka.addEventListener("input", function() {
                                    if (this.value.length > 10) {
                                        this.value = this.value.slice(0, 10);
                                    }
                                });

                                this.appendChild(inputAngka);
                            }
                            this.style.backgroundColor = warnaAktif;
                            this.style.width = cellWidth;
                            this.style.height = cellHeight;
                        });

                        row.appendChild(cell);
                    }
                    tableBody.appendChild(row);
                }

                document.getElementById("formUbah").style.display = "none";
            } else {
                alert("ID Lahan tidak ditemukan");
            }
        } else {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)");
        }
    }

    function konfirmasiHapus() {
        var cardId = prompt("Masukkan ID Lahan yang akan dihapus:");

        if (cardId) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus Lahan dengan ID " + cardId + "?");

            if (konfirmasi) {
                var cardToDelete = document.getElementById(cardId);

                if (cardToDelete) {
                    cardToDelete.remove();
                    alert("Lahan dengan ID " + cardId + " telah dihapus");
                } else {
                    alert("Lahan dengan ID " + cardId + " tidak ditemukan");
                }
            } else {
                alert("Penghapusan dibatalkan");
            }
        }
    }

    document.getElementById("tambahLahanButton").addEventListener("click", function() {
        var formLahan = document.getElementById("formLahan");
        if (formLahan.style.display === "none" || formLahan.style.display === "") {
            formLahan.style.display = "block";
        } else {
            formLahan.style.display = "none";
        }
    });

    document.getElementById("UbahLahanButton").addEventListener("click", function() {
        var formUbah = document.getElementById("formUbah");
        if (formUbah.style.display === "none" || formUbah.style.display === "") {
            formUbah.style.display = "block";
            document.getElementById("formLahan").style.display = "none";
        } else {
            formUbah.style.display = "none";
        }
    });

    document.getElementById("formMasukkan").addEventListener("submit", function(event) {
        event.preventDefault();
        var namaLahan = document.getElementById("inputNamaLahan").value;
        var jumlahBaris = parseInt(document.getElementById("inputBaris").value);
        var jumlahKolom = parseInt(document.getElementById("inputKolom").value);

        if (!isNaN(jumlahBaris) && !isNaN(jumlahKolom) && jumlahBaris > 0 && jumlahKolom > 0 && jumlahBaris <= 16 && jumlahKolom <= 26) {
            buatCard(namaLahan, jumlahBaris, jumlahKolom);
            document.getElementById("formLahan").style.display = "none";
        } else {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26).");
        }
    });
</script>
@endsection