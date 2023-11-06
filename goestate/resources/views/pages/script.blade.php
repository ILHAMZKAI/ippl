<script>
    var autoHideAlerts = document.querySelectorAll('.auto-hide-alert');

    autoHideAlerts.forEach(function (autoHideAlert) {
        if (autoHideAlert) {
            setTimeout(function () {
                autoHideAlert.style.display = 'none';
            }, 6000);
        }
    });

    let floatingDivVisible = false;
    let isDragging = false;
    let initialX;
    let initialY;

    function closeButton() {
        const floatingDiv = document.getElementById("floatingDiv");
        floatingDivVisible = false;
        floatingDiv.style.display = "none";
    }

    function minButton() {
        const floatingDiv = document.getElementById("floatingDiv");
        const minDiv = document.getElementById("minDiv");

        floatingDivVisible = false;
        floatingDiv.style.display = "none";
        minDiv.style.display = "block";
        toggleMinDiv(minDiv);
    }

    function toggleMinDiv(minDiv) {
        minDiv.addEventListener("mousedown", (e) => {
            isDragging = true;
            initialX = e.clientX - minDiv.getBoundingClientRect().left;
            initialY = e.clientY - minDiv.getBoundingClientRect().top;
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
        });

        minDiv.addEventListener("mouseover", () => {
            minDiv.style.cursor = "move";
        });

        minDiv.addEventListener("mouseout", () => {
            minDiv.style.cursor = "auto";
        });

        document.addEventListener("mousemove", (e) => {
            if (!isDragging) return;

            const newX = e.clientX - initialX;
            const newY = e.clientY - initialY;

            minDiv.style.left = newX + "px";
            minDiv.style.top = newY + "px";
        });

        minDiv.addEventListener("click", function () {
            if (!isDragging) {
                floatingDivVisible = true;
                floatingDiv.style.display = "block";
                minDiv.style.display = "none";
            }
        });

        minDiv.addEventListener("mousedown", function (event) {
            event.preventDefault();
        });
    }

    function toggleFloatingDiv() {
        const floatingDiv = document.getElementById("floatingDiv");

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
            const minDiv = document.getElementById("minDiv");
            if (minDiv.style.display === "block") {
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
    var isNotes = false;
    var totalWeights = {};

    function setTimer() {
        var dateAndActionPicker = document.getElementById('dateAndActionPicker');
        if (dateAndActionPicker.style.display === 'none' || dateAndActionPicker.style.display === '' || NotesPicker
            .style.display === 'block') {
            dateAndActionPicker.style.display = 'block';
            timerButton.style.backgroundColor = "#8392ab";
            isDateAndAction = true;

            NotesPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
            isNotes = false;
        } else {
            dateAndActionPicker.style.display = 'none';
            timerButton.style.backgroundColor = "";
            isDateAndAction = false;
            isSelectedCells.forEach(function (selectedCell) {
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

    function tutup() {
        var dateAndActionPicker = document.getElementById('dateAndActionPicker');
        dateAndActionPicker.style.display = 'none';
        timerButton.style.backgroundColor = "";
        isDateAndAction = false;
        isSelectedCells.clear();
    }

    function confirmDateTimeAction() {
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

        isSelectedCells.forEach(function (selectedCell) {
            if (selectedCell.getAttribute('data-timer-set') === 'true') {
                if (confirm('Waktu sudah diterapkan disini. Apakah Anda ingin mengubahnya?')) {
                    isSelectedCells.forEach(function (selectedCell) {
                        resetCellTimer(selectedCell);
                    });
                } else {
                    isSelectedCells.forEach(function (selectedCell) {
                        var spanText = selectedCell.querySelector('span').textContent;
                        if (spanText === 'Pemupukan') {
                            selectedCell.style.backgroundColor = 'yellow';
                        } else if (spanText === 'Panen') {
                            selectedCell.style.backgroundColor = 'green';
                        } else {
                            selectedCell.style.backgroundColor = 'white';
                        }
                    });
                    tutup();
                }
            }


            originalText = selectedCell.textContent;

            if (selectedCell.getAttribute('data-timer')) {
                clearTimeout(selectedCell.getAttribute('data-timer'));
            }

            if (action === 'Fertilization' || action === 'Harvest') {
                var tableBodyId = selectedCell.closest('tbody').id;

                if (!totalWeights[tableBodyId]) {
                    totalWeights[tableBodyId] = 0;
                }
                selectedCell.style.backgroundColor = 'red';
                var timer = setTimeout(function () {
                    selectedCell.style.backgroundColor = (action === 'Fertilization') ? 'yellow' :
                        'green';
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
                    inputText.addEventListener('input', function (event) {
                        var input = event.target;
                        var inputText = input.value;
                        var previousInput = input.getAttribute('data-previous-input') || '';

                        var addedMatches = inputText.match(/\d+/g);
                        var previousMatches = previousInput.match(/\d+/g);

                        var addedTotal = 0;
                        var previousTotal = 0;

                        if (addedMatches) {
                            for (var i = 0; i < addedMatches.length; i++) {
                                var weight = parseInt(addedMatches[i], 10);
                                if (!isNaN(weight)) {
                                    addedTotal += weight;
                                }
                            }
                        }

                        if (previousMatches) {
                            for (var i = 0; i < previousMatches.length; i++) {
                                var weight = parseInt(previousMatches[i], 10);
                                if (!isNaN(weight)) {
                                    previousTotal += weight;
                                }
                            }
                        }

                        totalWeights[tableBodyId] += addedTotal - previousTotal;

                        var tableBodyIds = selectedCell.closest('tbody').id;
                        var idWithoutPrefix = tableBodyIds.substring('tableBody'.length);
                        var totalWeightElement = document.getElementById('totalWeight' +
                            idWithoutPrefix);
                        totalWeightElement.textContent = totalWeights[tableBodyId];

                        input.setAttribute('data-previous-input', inputText);
                    });
                    inputText.addEventListener("input", function () {
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

        tutup();
    }

    function confirmNotes() {
        var notesInput = document.getElementById("notesInput");
        var notesText = notesInput.value;
        var alertShown = false;

        if (confirm('Apakah data sudah benar?')) {
            isSelectedCells.forEach(function (selectedCell) {
                if (selectedCell.querySelector('input')) {
                    var inputElement = selectedCell.querySelector('input');
                    var previousValue = inputElement.getAttribute('data-previous-input');
                    var newValue = notesText;

                    var previousNumericValue = parseInt(previousValue, 10) || 0;
                    var newNumericValue = parseInt(newValue, 10) || 0;

                    var tableBodyId = selectedCell.closest('tbody').id;
                    if (!totalWeights[tableBodyId]) {
                        totalWeights[tableBodyId] = 0;
                    }
                    totalWeights[tableBodyId] -= previousNumericValue;

                    totalWeights[tableBodyId] += newNumericValue;

                    var idWithoutPrefix = tableBodyId.substring('tableBody'.length);
                    var totalWeightElement = document.getElementById('totalWeight' + idWithoutPrefix);
                    totalWeightElement.textContent = totalWeights[tableBodyId];

                    inputElement.value = newValue;
                    inputElement.setAttribute('data-previous-input', newValue);
                } else {
                    var spanElement = selectedCell.querySelector('span');
                    if (!spanElement) {
                        if (!alertShown) {
                            alert('Kotak yang kosong tidak dapat diberi data');
                            alertShown = true;
                        }
                    }
                }

                isSelectedCells.forEach(function (selectedCell) {
                    selectedCell.style.backgroundColor = 'white';
                    var cellContent = selectedCell.textContent;
                    if (cellContent.includes("Pemupukan")) {
                        selectedCell.style.backgroundColor = 'yellow';
                    } else if (cellContent.includes("Panen")) {
                        selectedCell.style.backgroundColor = 'green';
                    }
                });
            });
        }

        isSelectedCells.forEach(function (selectedCell) {
            selectedCell.style.backgroundColor = 'white';
            var cellContent = selectedCell.textContent;
            if (cellContent.includes("Pemupukan")) {
                selectedCell.style.backgroundColor = 'yellow';
            } else if (cellContent.includes("Panen")) {
                selectedCell.style.backgroundColor = 'green';
            }
        });

        var NotesPicker = document.getElementById('NotesPicker');
        NotesPicker.style.display = 'none';
        catatanButton.style.backgroundColor = "";
        isNotes = false;
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
        } else if (isNotes == true) {
            if (isSelectedCells.has(cell)) {
                cell.textContent = notesInput.value;
                isSelectedCells.delete(cell);
                resetCellTimer(cell);
            } else {
                if (isNotes == true) {
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
        cell.textContent = '';
    }

    function catatan() {
        var NotesPicker = document.getElementById('NotesPicker');
        if (NotesPicker.style.display === 'none' || NotesPicker.style.display === '' || dateAndActionPicker.style
            .display === 'block') {
            NotesPicker.style.display = 'block';
            catatanButton.style.backgroundColor = "#8392ab";
            isNotes = true;

            dateAndActionPicker.style.display = 'none';
            timerButton.style.backgroundColor = "";
            isDateAndAction = false;
        } else {
            NotesPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
            isNotes = false;
            isSelectedCells.forEach(function (selectedCell) {
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

    function zoomIn(cardCounter) {
        var tableContainer = document.getElementById(`contBody${cardCounter}`);
        var currentTransform = tableContainer.style.transform || 'scale(1)';
        var currentScale = parseFloat(currentTransform.match(/scale\(([^)]+)\)/)[1]);
        var maxZoom = 3;
        var newScale = currentScale + 0.2;

        if (newScale <= maxZoom) {
            tableContainer.style.transform = `scale(${newScale})`;
        }
    }

    function zoomOut(cardCounter) {
        var tableContainer = document.getElementById(`contBody${cardCounter}`);
        var currentTransform = tableContainer.style.transform || 'scale(1)';
        var currentScale = parseFloat(currentTransform.match(/scale\(([^)]+)\)/)[1]);
        var minZoom = 0.5;
        var newScale = currentScale - 0.1;

        if (newScale >= minZoom) {
            tableContainer.style.transform = `scale(${newScale})`;
        }
    }

    function resetZoom(cardCounter) {
        var tableContainer = document.getElementById(`contBody${cardCounter}`);
        tableContainer.style.transform = 'scale(1)';
    }

    document.addEventListener('click', function (event) {
        var cardElement = event.target.closest('.card.mb-3');
        if (!cardElement) {
            resetZoom(cardCounter);
        }
    });

    var cardElements = document.querySelectorAll('.card.mb-3');
    cardElements.forEach(function (cardElement) {
        cardElement.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });


    function createLahan() {
        var namaLahan = document.getElementById("inputNamaLahan").value;
        var jumlahBaris = document.getElementById("inputBaris").value;
        var jumlahKolom = document.getElementById("inputKolom").value;

        var data = {
            _token: '{{ csrf_token() }}',
            namaLahan: namaLahan,
            jumlahBaris: jumlahBaris,
            jumlahKolom: jumlahKolom
        };

        fetch('/create-lahan', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .catch(error => {
                console.error('Error:', error);
            });
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
                var tableBodyId = table.querySelector('tbody').id;
                totalWeights[tableBodyId] = 0;

                var idWithoutPrefix = tableBodyId.substring('tableBody'.length);
                var totalWeightElement = document.getElementById('totalWeight' + idWithoutPrefix);
                if (totalWeightElement) {
                    totalWeightElement.textContent = totalWeights[tableBodyId];
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

    document.addEventListener('click', function (event) {
        var hapusButton = document.getElementById("hapusButton");

        if (!hapusButton.contains(event.target) && !event.target.classList.contains('cell') && !event.target
            .classList.contains('selected-cell')) {
            isClearingEnabled = false;
            hapusButton.style.backgroundColor = "";
        }
    });

    function ubahLahan() {
        var idLahan = document.getElementById('EinputIdLahan').value;
        var enamaLahan = document.getElementById('EinputNamaLahan').value;
        var ejumlahBaris = document.getElementById('EinputBaris').value;
        var ejumlahKolom = document.getElementById('EinputKolom').value;

        var data = {
            _token: '{{ csrf_token() }}',
            idLahan: idLahan,
            namaLahan: enamaLahan,
            jumlahBaris: ejumlahBaris,
            jumlahKolom: ejumlahKolom,
        };
        if (isNaN(ejumlahBaris) || isNaN(ejumlahKolom) || ejumlahBaris < 1 || ejumlahBaris > 16 || ejumlahKolom < 1 || ejumlahKolom > 26) {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)");
        } else if (confirm("Tindakan ini akan mengatur ulang semua data dari Lahan yang dipilih. Apakah Anda ingin melanjutkan?")) {
            location.reload();
            fetch('/update-lahan', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error');
                    }
                })
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    function submitDeleteForm(id) {
        var confirmDelete = confirm("Anda yakin ingin menghapus lahan ini?");

        if (confirmDelete) {
            document.getElementById(`deleteForm${id}`).submit();
        }
    }

    document.getElementById("tambahLahanButton").addEventListener("click", function () {
        var formLahan = document.getElementById("formLahan");
        if (formLahan.style.display === "none" || formLahan.style.display === "") {
            formLahan.style.display = "block";
            document.getElementById("formUbah").style.display = "none";
        } else {
            formLahan.style.display = "none";
        }
    });

    document.getElementById("UbahLahanButton").addEventListener("click", function () {
        var formUbah = document.getElementById("formUbah");
        if (formUbah.style.display === "none" || formUbah.style.display === "") {
            formUbah.style.display = "block";
            document.getElementById("formLahan").style.display = "none";
        } else {
            formUbah.style.display = "none";
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