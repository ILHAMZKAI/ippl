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
    var isClearingEnabled = false;
    var isAction = false;
    var isNotes = false;
    var totalWeights = {};

    function saveActionTimer(lahanId, cardCounter, userId) {
        var selectedAction = document.getElementById('selectAction' + cardCounter).value;
        var dateTime = document.getElementById('dateTimePicker' + cardCounter).value;

        var data = {
            lahan_id: lahanId,
            action: selectedAction,
            date_time: dateTime,
            iduser: userId,
        };

        fetch('/saveActionTimer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(responseData => {
                console.log('Action and Timer saved successfully:', responseData);
            })
            .catch(error => {
                console.error('Error saving Action and Timer:', error);
            });
    }

    function setMark() {
        var markActionPicker = document.getElementById('markActionPicker');
        if (markActionPicker.style.display === 'none' || markActionPicker.style.display === '' || NotesPicker
            .style.display === 'block') {
            markActionPicker.style.display = 'block';
            markButton.style.backgroundColor = "#8392ab";
            isAction = true;

            NotesPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
            isNotes = false;
        } else {
            markActionPicker.style.display = 'none';
            markButton.style.backgroundColor = "";
            isAction = false;
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
        var markActionPicker = document.getElementById('markActionPicker');
        markActionPicker.style.display = 'none';
        markButton.style.backgroundColor = "";
        isAction = false;
        isSelectedCells.clear();
    }

    function refreshButton() {
        location.reload(true);
    }

    function selectCell(cell) {
        if (isAction == true) {
            cell.style.backgroundColor = 'red';
            isSelectedCells.set(cell, cell);
        } else if (isClearingEnabled == true) {
            cell.style.backgroundColor = 'white';
            isSelectedCells.set(cell, cell);
        }
    }

    function handleCellClick(cardCounter, idLahan) {
        if (isAction == true) {
            saveSelectedCellsToDatabase(cardCounter, idLahan);
        } else if (isClearingEnabled == true) {
            deleteSelectedCellsFromDatabase(cardCounter, idLahan);
        }
    }

    function saveSelectedCellsToDatabase(cardCounter, idlahan) {
        if (isAction == true) {
            const url = '/saveSelectedCells';

            const selectedCellsData = Array.from(isSelectedCells.values()).map(cell => ({
                idlahan: idlahan,
                id_user: '{{ Auth::id() }}',
                data_col: cell.getAttribute('data-col'),
                data_row: cell.getAttribute('data-row'),
                warna: 'red'
            }));

            console.log('Selected Cells Data:', selectedCellsData);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    selectedCells: selectedCellsData
                }),
            })

                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
        }
        isSelectedCells.clear();
    }

    function hapusSelectedCell() {
        isClearingEnabled = !isClearingEnabled;

        var hapusButton = document.getElementById("hapusButton");

        if (isAction) {
            markActionPicker.style.display = 'none';
            markButton.style.backgroundColor = "";
            isAction = false;
        }

        if (isClearingEnabled) {
            hapusButton.style.backgroundColor = "#8392ab";
        } else {
            hapusButton.style.backgroundColor = "";
        }
    }

    function deleteSelectedCellsFromDatabase(cardCounter, idlahan) {
        if (isClearingEnabled == true) {
            const url = '/deleteSelectedCells';

            const selectedCellsData = Array.from(isSelectedCells.values()).map(cell => ({
                idlahan: idlahan,
                id_user: '{{ Auth::id() }}',
                data_col: cell.getAttribute('data-col'),
                data_row: cell.getAttribute('data-row'),
            }));

            console.log('Selected Cells Data:', selectedCellsData);

            const queryParams = selectedCellsData.map(cellData =>
                `idlahan=${cellData.idlahan}&id_user=${cellData.id_user}&data_col=${cellData.data_col}&data_row=${cellData.data_row}`
            ).join('&');

            fetch(`${url}?${queryParams}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })

                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
        }
        isSelectedCells.clear();
    }

    document.addEventListener('click', function (event) {
        var hapusButton = document.getElementById("hapusButton");

        if (!hapusButton.contains(event.target) && !event.target.classList.contains('cell') && !event.target
            .classList.contains('selected-cell')) {
            isClearingEnabled = false;
            hapusButton.style.backgroundColor = "";
        }
    });

    function saveSelectedCellsToDatabase(cardCounter, idlahan) {
        if (isAction == true) {
            const url = '/saveSelectedCells';

            const selectedCellsData = Array.from(isSelectedCells.values()).map(cell => ({
                idlahan: idlahan,
                id_user: '{{ Auth::id() }}',
                data_col: cell.getAttribute('data-col'),
                data_row: cell.getAttribute('data-row'),
                warna: 'red'
            }));

            console.log('Selected Cells Data:', selectedCellsData);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    selectedCells: selectedCellsData
                }),
            })

                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error(error);
                });
        }
        isSelectedCells.clear();
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

    function updateTabel(data, idlahan, counter) {
        data.forEach(function (item) {
            var data_col = item.data_col;
            var data_row = item.data_row;
            var warna = item.warna;

            var cell = document.querySelector(
                `#tableBody${counter} [data-row="${data_row}"][data-col="${data_col}"]`);

            if (cell) {
                cell.style.backgroundColor = warna;
            } else {
                console.error('Sel tidak ditemukan.');
            }
        });
    }

    function buatTabel(id, namaLahan, baris, kolom, counter) {
        var tableBody = document.getElementById(`tableBody${counter}`);
        tableBody.innerHTML = '';
        var cellWidth = 100 / kolom + "%";
        var cellHeight = 100 / baris + "%";
        var idlahan;

        function ambilDataDariDatabase() {
            var url = `/getMarksData/${id}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    idlahan = data[0].idLahan;

                    updateTabel(data, idlahan, counter);
                })
                .catch(error => console.error('Error:', error));
        }

        for (var i = 1; i <= baris; i++) {
            var row = document.createElement("tr");
            for (var j = 1; j <= kolom; j++) {
                var cell = document.createElement("td");
                cell.className = `cell cell${counter}`;
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

        ambilDataDariDatabase();
        var namaLahanDiv = document.getElementById(`namaLahanDiv${counter}`);
        namaLahanDiv.textContent = "Lahan: " + namaLahan;
        namaLahanDiv.style.fontWeight = "bold";
        namaLahanDiv.style.marginBottom = "10px";
    }

    function catatan() {
        var NotesPicker = document.getElementById('NotesPicker');
        if (NotesPicker.style.display === 'none' || NotesPicker.style.display === '' || markActionPicker.style
            .display === 'block') {
            NotesPicker.style.display = 'block';
            catatanButton.style.backgroundColor = "#8392ab";
            isNotes = true;

            markActionPicker.style.display = 'none';
            markButton.style.backgroundColor = "";
            isAction = false;
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

    function resetCell(idlahan, cardCounter) {
        if (confirm("Apakah Anda yakin ingin mereset semua data pada tabel?")) {
            const url = '/deleteAllCells';

            const queryParams = `idlahan=${idlahan}&cardCounter=${cardCounter}`;

            fetch(`${url}?${queryParams}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error(error);
                });

            var cells = document.querySelectorAll(`.cell${cardCounter}`);

            cells.forEach(cell => {
                cell.style.backgroundColor = 'white';
                cell.textContent = '';
            });
        }
    }

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
        if (isNaN(ejumlahBaris) || isNaN(ejumlahKolom) || ejumlahBaris < 1 || ejumlahBaris > 16 || ejumlahKolom < 1 ||
            ejumlahKolom > 26) {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)");
        } else if (confirm(
            "Tindakan ini akan mengatur ulang semua data dari Lahan yang dipilih. Apakah Anda ingin melanjutkan?"
        )) {
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