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
                    <button class="btn btn-primary" onclick="confirmDateTimeAction()">OK</button>
                </div>
            </div>
            <div>
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

<script>
    let floatingDivVisible = false;

    function minButton() {
        const minDiv = document.getElementById("minDiv");

        if (minDiv) {
            minDiv.style.display = "block";
        }

        floatingDivVisible = false;
        floatingDiv.style.display = "none";
    }

    document.getElementById("minDiv").addEventListener("click", function() {
        let floatingDiv = document.getElementById("floatingDiv");

        if (floatingDiv) {
            minDiv.style.display = "none";
            floatingDiv.style.display = "block";
            floatingDivVisible = true;
        }
    });


    function closeButton() {
        floatingDivVisible = false;
        floatingDiv.style.display = "none";
    }

    function toggleFloatingDiv() {
        const floatingDiv = document.getElementById("floatingDiv");
        let isDragging = false;
        let initialX;
        let initialY;

        floatingDiv.addEventListener("mousedown", (e) => {
            isDragging = true;
            initialX = e.clientX - floatingDiv.getBoundingClientRect().left;
            initialY = e.clientY - floatingDiv.getBoundingClientRect().top;
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
        });

        floatingDiv.addEventListener("mouseover", () => {
            floatingDiv.style.cursor = "move";
        });

        floatingDiv.addEventListener("mouseout", () => {
            floatingDiv.style.cursor = "auto";
        });

        document.addEventListener("mousemove", (e) => {
            if (!isDragging) return;

            const newX = e.clientX - initialX;
            const newY = e.clientY - initialY;

            floatingDiv.style.left = newX + "px";
            floatingDiv.style.top = newY + "px";
        });
        if (!floatingDivVisible) {
            if (minDiv.style.display = "block") {
                minDiv.style.display = "none";
            }
            floatingDiv.style.display = "block";
        } else {
            floatingDiv.style.display = "none";
        }

        floatingDivVisible = !floatingDivVisible;
    }

    var cardCounter = 1;
    var activeColor = "none";
    var isSelectedCells = new Map();
    var isDateAndAction = false;

    function setTimer() {
        var dateAndActionPicker = document.getElementById('dateAndActionPicker');
        if (dateAndActionPicker.style.display === 'none' || dateAndActionPicker.style.display === '') {
            dateAndActionPicker.style.display = 'block';
            timerButton.style.backgroundColor = "#8392ab";
            isDateAndAction = true;
        } else {
            dateAndActionPicker.style.display = 'none';
            timerButton.style.backgroundColor = "";
            isDateAndAction = false;
            isSelectedCells.forEach(function(selectedCell) {
                selectedCell.style.backgroundColor = 'white';
                var cellContent = selectedCell.textContent;
                if (cellContent.includes("Pemupukan")) {
                    selectedCell.style.backgroundColor = 'yellow';
                } else if (cellContent.includes("Panen")) {
                    selectedCell.style.backgroundColor = 'green';
                }
            });
            isSelectedCells.clear();
        }
    }

    function confirmDateTimeAction() {
        var totalWeight = 0
        var dateTimePicker = document.getElementById('dateTimePicker');
        var actionPicker = document.getElementById('actionPicker');
        var action = actionPicker.value;
        if (!action) {
            alert('Pilih aksi terlebih dahulu');
            return;
        }

        if (!dateTimePicker.value) {
            alert('Pilih waktu dan tanggal terlebih dahulu');
            return;
        }

        if (isSelectedCells.size === 0) {
            alert('Pilih satu atau lebih kolom terlebih dahulu');
            return;
        }

        var selectedDateTime = new Date(dateTimePicker.value);
        var action = actionPicker.value;

        isSelectedCells.forEach(function(selectedCell) {
            if (selectedCell.getAttribute('data-timer-set') === 'true') {
                if (confirm('Waktu sudah diterapkan disini. Apakah Anda ingin mengubahnya?')) {
                    isSelectedCells.forEach(function(selectedCell) {
                        resetCellTimer(selectedCell);
                    });
                } else {
                    var spanText = selectedCell.querySelector('span').textContent;
                    if (spanText === 'Pemupukan') {
                        selectedCell.style.backgroundColor = 'yellow';
                    } else if (spanText === 'Panen') {
                        selectedCell.style.backgroundColor = 'green';
                    } else {
                        selectedCell.style.backgroundColor = originalBackgroundColor;
                    }
                    return;
                }
            }


            originalText = selectedCell.textContent;

            if (selectedCell.getAttribute('data-timer')) {
                clearTimeout(selectedCell.getAttribute('data-timer'));
            }

            if (action === 'Fertilization' || action === 'Harvest') {
                selectedCell.style.backgroundColor = 'red';
                var timer = setTimeout(function() {
                    selectedCell.style.backgroundColor = (action === 'Fertilization') ? 'yellow' : 'green';
                    selectedCell.setAttribute('data-timer-set', 'true');

                    var container = document.createElement('div');

                    var textElement = document.createElement('span');
                    textElement.textContent = (action === 'Fertilization') ? 'Pemupukan' : 'Panen';
                    textElement.style.color = "#000";
                    textElement.style.fontWeight = "bold";
                    textElement.classList.add('selected-cell');
                    textElement.style.marginTop = '10px';

                    var inputText = document.createElement('input');
                    inputText.type = 'text';
                    inputText.style.marginTop = '4px';
                    inputText.style.border = "none";
                    inputText.style.background = "none";
                    inputText.style.outline = "none";
                    inputText.style.textAlign = "center";
                    inputText.style.width = "90%";
                    inputText.style.height = "20%";
                    inputText.style.color = "#066";
                    inputText.style.fontWeight = "bold";
                    inputText.placeholder = 'Catatan';
                    inputText.addEventListener('input', function(event) {
                        var input = event.target;
                        var inputText = input.value;

                        var matches = inputText.match(/\d+/g);

                        if (matches) {
                            for (var i = 0; i < matches.length; i++) {
                                var weight = parseInt(matches[i], 10);
                                if (!isNaN(weight)) {
                                    totalWeight += weight;
                                }
                            }
                        }

                        var tableBodyId = selectedCell.closest('tbody').id;
                        var idWithoutPrefix = tableBodyId.substring('tableBody'.length);
                        var totalWeightElement = document.getElementById('totalWeight' + idWithoutPrefix);
                        totalWeightElement.textContent = totalWeight;
                    });
                    inputText.addEventListener("input", function() {
                        if (this.value.length > 5) {
                            this.value = this.value.slice(0, 5);
                        }
                    });
                    container.appendChild(textElement);
                    container.appendChild(inputText);

                    selectedCell.innerHTML = '';
                    selectedCell.appendChild(container);
                }, selectedDateTime - new Date());
                selectedCell.setAttribute('data-timer', timer);
            }

            selectedCell.textContent = selectedDateTime.toLocaleString();
        });

        var dateAndActionPicker = document.getElementById('dateAndActionPicker');
        dateAndActionPicker.style.display = 'none';
        timerButton.style.backgroundColor = "";
        isDateAndAction = false;
        isSelectedCells.clear();
    }

    function selectCell(cell) {
        if (isClearingEnabled) {
            cell.style.backgroundColor = 'white';
            cell.textContent = '';
            resetCellTimer(cell);
        } else if (isDateAndAction == true) {
            if (isSelectedCells.has(cell)) {
                isSelectedCells.delete(cell);
                resetCellTimer(cell);
            } else {
                if (isDateAndAction == true) {
                    cell.style.backgroundColor = 'cyan';
                    isSelectedCells.set(cell, cell);
                }
            }
        }
    }

    function resetCellTimer(cell) {
        if (cell.getAttribute('data-timer')) {
            clearTimeout(cell.getAttribute('data-timer'));
        }
        cell.removeAttribute('data-timer');
        cell.removeAttribute('data-timer-set');
        cell.style.backgroundColor = 'white';
        cell.textContent = originalText;
    }

    function zoomIn(cardId) {
        const contBody = document.getElementById(`contBody${cardId}`);
        if (!contBody) return;

        let currentScale = parseFloat(contBody.getAttribute("data-scale")) || 1;

        if (currentScale < 1.1) {
            currentScale += 0.1;
            contBody.setAttribute("data-scale", currentScale);
            updateZoom(contBody, currentScale);
        }
    }

    function zoomOut(cardId) {
        const contBody = document.getElementById(`contBody${cardId}`);
        if (!contBody) return;

        let currentScale = parseFloat(contBody.getAttribute("data-scale")) || 1;

        if (currentScale > 0.5) {
            currentScale -= 0.1;
            contBody.setAttribute("data-scale", currentScale);
            updateZoom(contBody, currentScale);
        }
    }

    function updateZoom(contBody, currentScale) {
        contBody.style.transform = `scale(${currentScale})`;
    }

    document.addEventListener('click', function(event) {
        const zoomButtons = document.querySelectorAll('.btn.btn-primary');

        for (const button of zoomButtons) {
            if (button.contains(event.target)) {
                const cardId = button.getAttribute("data-card-id");
                zoomIn(cardId);
                return;
            }
        }

        const cardContainers = document.querySelectorAll('.table-container');

        for (const container of cardContainers) {
            resetZoom(container);
        }
    });

    function resetZoom(contBody) {
        contBody.style.transform = 'scale(1)';
        contBody.setAttribute("data-scale", 1);
    }

    function buatCard(namaLahan, jumlahBaris, jumlahKolom) {
        var containerCounter = 1;
        var tabelLahanContainer = document.getElementById("tabelLahanContainer");
        var tabelLahanDiv = document.createElement("div");
        tabelLahanDiv.className = "row";
        var cardId = "" + cardCounter;
        tabelLahanDiv.id = cardId;
        tabelLahanDiv.innerHTML = `
        <div class="col-11 ms-4-2">
    <div class="alert1 alert-light me-n3-1" onclick="toggleElements(${cardCounter})">
        <div class="row">
            <div class="col-md mb-n2">
                <div id="namaLahanDiv${cardCounter}"></div>
            </div>
            <div class="col-md mb-n2">
                <div id="idLahanDiv${cardCounter}"></div>
            </div>
            <div class="col-md-auto">
                <i class="fas fa-trash me-2" style="cursor: pointer;" onclick="konfirmasiHapus('${cardCounter}')"></i>
            </div>
        </div>
    </div>
    <div class="content col-md-12 pt-2" id="content${cardCounter}" style="display: none;">
        <div class="card1 me-n3-1 mt-n4 mb-4">
            <div class="card-body ms-n4-1 mb-n2">
                <div class="row">
                    <div class="col-md-9 mx-4-1">
                        <div class="card mb-3">
                            <div class="card-body px-4 py-4">
                            <button class="btn btn-primary me-3" onclick="zoomIn('${cardCounter}')"><i class="fas fa-search-plus"></i></button>
                            <button class="btn btn-primary" onclick="zoomOut('${cardCounter}')"><i class="fas fa-search-minus"></i></button>
                                <div class="table-container" id="contBody${cardCounter}" style="max-height: 300px; overflow: auto; transform: scale(1);">
                                    <table class="table">
                                        <tbody id="tableBody${cardCounter}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ms-n5">
                        <div class="card">
                            <div class="card-body">
                                Total Berat: <span id="totalWeight${cardCounter}">0</span>
                                <button class="btn btn-dark px-4 mt-2 mb-n1" onclick="resetCell()">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
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

    function resetCell() {
        var button = event.target;
        var table = button.closest('.content');
        if (table) {
            var cells = table.getElementsByClassName("cell");
            if (confirm("Apakah Anda yakin ingin mereset semua data pada tabel?")) {
                for (var i = 0; i < cells.length; i++) {
                    cells[i].style.backgroundColor = "white";
                    cells[i].textContent = "";

                    var timerId = cells[i].getAttribute('data-timer');
                    if (timerId) {
                        clearTimeout(timerId);
                        cells[i].removeAttribute('data-timer');
                        cells[i].removeAttribute('data-timer-set');
                    }
                }
            }
        }
    }

    let isClearingEnabled = false;

    function hapusSelectedCell() {
        isClearingEnabled = !isClearingEnabled;

        var hapusButton = document.getElementById("hapusButton");

        if (isClearingEnabled) {
            hapusButton.style.backgroundColor = "#8392ab";
        } else {
            hapusButton.style.backgroundColor = "";
        }
    }

    document.addEventListener('click', function(event) {
        var hapusButton = document.getElementById("hapusButton");

        if (!hapusButton.contains(event.target) && !event.target.classList.contains('cell') && !event.target.classList.contains('selected-cell')) {
            isClearingEnabled = false;
            hapusButton.style.backgroundColor = "";
        }
    });

    function simpanLahan() {
        var inputIdLahan = document.getElementById("EinputIdLahan").value;
        var inputNamaLahan = document.getElementById("EinputNamaLahan").value;
        var inputBaris = parseInt(document.getElementById("EinputBaris").value);
        var inputKolom = parseInt(document.getElementById("EinputKolom").value);

        if (!isNaN(inputBaris) && !isNaN(inputKolom) && inputBaris > 0 && inputKolom > 0 && inputBaris <= 16 && inputKolom <= 26) {
            var cardToUpdate = document.getElementById(inputIdLahan);

            if (cardToUpdate) {
                var confirmation = confirm("Tindakan ini akan mengatur ulang semua data dari Lahan yang dipilih. Apakah Anda ingin melanjutkan?");
                if (confirmation) {
                    document.getElementById("dateTimePicker").value = "";
                    document.getElementById("actionPicker").value = "";

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
                                this.style.backgroundColor = activeColor;
                                this.style.width = cellWidth;
                                this.style.height = cellHeight;

                                selectCell(this);
                            });

                            row.appendChild(cell);
                        }
                        tableBody.appendChild(row);
                    }

                    var namaLahanDiv = cardToUpdate.querySelector(`#namaLahanDiv${inputIdLahan}`);
                    namaLahanDiv.textContent = "Lahan: " + inputNamaLahan;
                }
            } else {
                alert("ID Lahan tidak ditemukan");
            }

            document.getElementById("formUbah").style.display = "none";
        } else {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)");
        }
    }

    function konfirmasiHapus(cardId) {
        if (cardId) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus Lahan dengan ID " + cardId + "?");

            if (konfirmasi) {
                var cardToDelete = document.getElementById(cardId);

                if (cardToDelete) {
                    cardToDelete.remove();
                    alert("Lahan dengan ID " + cardId + " telah dihapus");
                } else {
                    alert("Penghapusan dibatalkan");
                }
            }
        }
    }

    document.getElementById("tambahLahanButton").addEventListener("click", function() {
        var formLahan = document.getElementById("formLahan");
        if (formLahan.style.display === "none" || formLahan.style.display === "") {
            formLahan.style.display = "block";
            document.getElementById("formUbah").style.display = "none";
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

    document.getElementById("formInputLahan").addEventListener("submit", function(event) {
        event.preventDefault();
        var namaLahan = document.getElementById("inputNamaLahan").value;
        var jumlahBaris = parseInt(document.getElementById("inputBaris").value);
        var jumlahKolom = parseInt(document.getElementById("inputKolom").value);

        if (!isNaN(jumlahBaris) && !isNaN(jumlahKolom) && jumlahBaris > 0 && jumlahKolom > 0 && jumlahBaris <= 16 && jumlahKolom <= 26) {
            buatCard(namaLahan, jumlahBaris, jumlahKolom);
            document.getElementById("formLahan").style.display = "none";
        } else {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)");
        }
    });

    function toggleElements(cardCounter) {
        const contentElement = document.getElementById(`content${cardCounter}`);

        if (contentElement.classList.contains('hidden-content')) {
            contentElement.style.display = "block";
            setTimeout(() => {
                contentElement.classList.remove('hidden-content');
                contentElement.classList.add('visible-content');
            }, 0);
        } else {
            contentElement.classList.remove('visible-content');
            contentElement.classList.add('hidden-content');
        }
    }
</script>
@endsection