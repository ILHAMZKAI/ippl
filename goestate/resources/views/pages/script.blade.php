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
    var isActionMark = false;
    var isNotes = false;
    var totalWeights = {};

    function saveActionTimer(lahanId, cardCounter, userId) {
        var selectedAction = document.getElementById('selectAction' + cardCounter).value;
        var dateTime = document.getElementById('dateTimePicker' + cardCounter).value;

        fetch('/checkActionTimer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ lahan_id: lahanId, iduser: userId })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(responseData => {
                var data = {
                    lahan_id: lahanId,
                    action: selectedAction,
                    timer: dateTime,
                    iduser: userId,
                };

                if (responseData.exists) {
                    var confirmation = confirm('Waktu sudah diterapkan pada lahan. Apakah Anda ingin memperbarui waktu');
                    if (!confirmation) {
                        return;
                    }

                    return fetch('/updateActionTimer', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(data)
                    });
                } else {
                    return fetch('/saveActionTimer', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(data)
                    });
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(responseData => {
                console.log('Action and Timer saved successfully:', responseData);
                location.reload();
            })
            .catch(error => {
                console.error('Error saving Action and Timer:', error);
            });
    }

    function setMark() {
        var markActionPicker = document.getElementById('markActionPicker');
        if (markActionPicker.style.display === 'none' || markActionPicker.style.display === '' || weightPicker
            .style.display === 'block') {
            markActionPicker.style.display = 'block';
            markButton.style.backgroundColor = "#8392ab";
            isActionMark = true;

            weightPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
            isNotes = false;
        } else {
            markActionPicker.style.display = 'none';
            markButton.style.backgroundColor = "";
            isActionMark = false;
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
        isActionMark = false;
        isSelectedCells.clear();
    }

    function refreshButton() {
        location.reload(true);
    }

    function selectCell(cell) {
        if (isActionMark == true) {
            cell.style.backgroundColor = '#cc0000';
            isSelectedCells.set(cell, cell);
        } else if (isClearingEnabled == true) {
            cell.style.backgroundColor = 'white';
            isSelectedCells.set(cell, cell);
            cell.textContent = '';
        } else if (isNotes == true) {
            if (cell.style.backgroundColor === 'white') {
                alert("Tidak dapat memberi data berat pada sel yang kosong");
            } else {
                cell.style.backgroundColor = 'blue';
                isSelectedCells.set(cell, cell);
                const weightInput = document.getElementById("weightInput").value;
                cell.textContent = weightInput + '.0';
                cell.style.textAlign = 'center';
                cell.style.verticalAlign = 'middle';
                cell.style.fontSize = '20px';
                cell.style.fontWeight = 'bold';
                cell.style.color = 'white';
            }
        }
    }

    function handleCellClick(cardCounter, idlahan) {
        if (isActionMark == true) {
            saveSelectedCellsToDatabase(cardCounter, idlahan);
        } else if (isClearingEnabled == true) {
            deleteSelectedCellsFromDatabase(cardCounter, idlahan);
        } else if (isNotes == true) {
            saveNotesToDatabase(cardCounter, idlahan);
        }
    }

    function hapusSelectedCell() {
        isClearingEnabled = !isClearingEnabled;

        var hapusButton = document.getElementById("hapusButton");

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

    document.addEventListener('click', function (event) {
        var markButton = document.getElementById("markButton");

        if (!markButton.contains(event.target) && !event.target.classList.contains('cell') && !event.target
            .classList.contains('selected-cell')) {
            isActionMark = false;
            markActionPicker.style.display = 'none';
            markButton.style.backgroundColor = "";
        }
    });

    document.addEventListener('click', function (event) {
        var catatanButton = document.getElementById("catatanButton");
        var floatingDiv = document.getElementById("floatingDiv");

        if (!catatanButton.contains(event.target) && !event.target.classList.contains('cell') && !event.target
            .classList.contains('selected-cell') && !floatingDiv.contains(event.target)) {
            isNotes = false;
            weightPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
        }
    });

    function saveSelectedCellsToDatabase(cardCounter, idlahan) {
        if (isActionMark == true) {
            const url = '/saveSelectedCells';

            const selectedCellsData = Array.from(isSelectedCells.values()).map(cell => ({
                idlahan: idlahan,
                id_user: '{{ Auth::id() }}',
                data_col: cell.getAttribute('data-col'),
                data_row: cell.getAttribute('data-row'),
                warna: '#cc0000'
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

    function saveNotesToDatabase(cardCounter, idlahan) {
        if (isNotes == true) {
            var beratInput = document.getElementById('weightInput').value;

            const selectedCellsData = Array.from(isSelectedCells.values()).map(cell => ({
                idlahan: idlahan,
                id_user: '{{ Auth::id() }}',
                data_col: cell.getAttribute('data-col'),
                data_row: cell.getAttribute('data-row'),
                berat: beratInput,
            }));

            console.log('Selected Cells Data:', selectedCellsData);

            fetch('/update-berat', {
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
                .then(response => {
                    console.log(response);
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

        var weightPicker = document.getElementById('weightPicker');
        weightPicker.style.display = 'none';
        catatanButton.style.backgroundColor = "";
        isNotes = false;
        isSelectedCells.clear();
    }

    function updateTabel(data, idlahan, counter) {
        data.forEach(function (item) {
            var data_col = item.data_col;
            var data_row = item.data_row;
            var warna = item.warna;
            var berat = item.berat;

            var cell = document.querySelector(
                `#tableBody${counter} [data-row="${data_row}"][data-col="${data_col}"]`);

            if (cell) {
                cell.style.backgroundColor = warna;
                cell.style.textAlign = 'center';
                cell.style.verticalAlign = 'middle';
                cell.style.fontSize = '20px';
                cell.style.fontWeight = 'bold';
                cell.textContent = berat;

                if (warna === 'yellow') {
                    cell.style.color = 'black';
                } else if (warna === 'green') {
                    cell.style.color = 'white';
                } else {
                    cell.style.color = 'white';
                }
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

    function setCatatan() {
        var weightPicker = document.getElementById('weightPicker');
        if (weightPicker.style.display === 'none' || weightPicker.style.display === '' || markActionPicker.style
            .display === 'block') {
            weightPicker.style.display = 'block';
            catatanButton.style.backgroundColor = "#8392ab";
            isNotes = true;
        } else {
            weightPicker.style.display = 'none';
            catatanButton.style.backgroundColor = "";
            isNotes = false;
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

    document.addEventListener('DOMContentLoaded', function () {
        calculateTotalWeight();
    });

    function calculateTotalWeight() {
        var elements = document.querySelectorAll('[data-lahan-id][data-user-id]');

        elements.forEach(function (element) {
            var lahanId = element.getAttribute('data-lahan-id');
            var userId = element.getAttribute('data-user-id');

            fetch('/get-total-weight/' + lahanId + '/' + userId)
                .then(response => response.json())
                .then(data => {
                    var totalWeight = data.totalWeight || 0;
                    element.textContent = totalWeight + ' KG';
                })
                .catch(error => {
                    console.error(error);
                });
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
                    document.getElementById(`totalWeight${cardCounter}`).textContent = '0 KG';
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

    document.addEventListener('DOMContentLoaded', function () {
        updateTimersFromDatabase();
    });

    function updateTimersFromDatabase() {
        var elements = document.querySelectorAll('[data-timer-id][user-id]');

        elements.forEach(function (element) {
            var lahanId = element.getAttribute('data-timer-id');
            var userId = element.getAttribute('user-id');

            fetch('/timers/' + lahanId + '/' + userId)
                .then(response => response.json())
                .then(data => {
                    if (data && data.action !== undefined && data.timer !== undefined) {
                        var action = data.action;
                        var timer = data.timer;

                        element.innerText = 'Aksi: ' + action + ' Waktu: ' + timer;
                    } else {
                        element.innerText = 'Tidak ada waktu diterapkan';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
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
        if (isNaN(ejumlahBaris) || isNaN(ejumlahKolom) || ejumlahBaris < 1 || ejumlahBaris > 6 || ejumlahKolom < 1 ||
            ejumlahKolom > 10) {
            alert("Harap masukkan nilai yang valid untuk baris (maksimum 6) dan kolom (maksimum 10)");
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

    document.addEventListener('DOMContentLoaded', function () {
        const savedState = sessionStorage.getItem('contentState');

        if (savedState) {
            const contentElement = document.getElementById(savedState);
            if (contentElement) {
                contentElement.style.display = 'block';
                contentElement.classList.add('visible-content');
            }
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
        sessionStorage.setItem('contentState', `content${cardCounter}`);
    }
</script>