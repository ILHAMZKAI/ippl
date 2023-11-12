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
                                <div class="card">
                                    <div class="card-body">
                                        Total Berat: <span id="totalWeight{{ $cardCounter }}">0</span>
                                        <button class="btn btn-dark px-4 mt-2 mb-n1"
                                            onclick="resetCell()">Reset</button>
                                    </div>
                                </div>

                                <div class="card" style="margin-top: 10px;">
                                    <div class="card-body">
                                        Waktu: <span id="userTime{{ $cardCounter }}">-</span>
                                        <div class="mt-1">
                                            <label for="inputTime{{ $cardCounter }}">Set Time:</label>
                                            <input type="text" id="inputTime{{ $cardCounter }}" placeholder="HH:mm:ss"
                                                style="width: 100px; margin-right: 10px; margin-bottom: 5px;">
                                            <button class="btn btn-dark px-4" style="margin-bottom: 10px;"
                                                onclick="startCountdown('{{ $cardCounter }}', '{{ $lahan->id }}')">Start
                                                Timer</button>
                                        </div>

                                        <div id="countdown{{ $cardCounter }}" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var countdownIntervals = {};

        function startCountdown(cardCounter, lahanId) {
            // Clear the previous interval if it exists
            clearInterval(countdownIntervals[cardCounter]);

            var inputTime = document.getElementById(`inputTime${cardCounter}`).value;
            var userTimeElement = document.getElementById(`userTime${cardCounter}`);
            var countdownElement = document.getElementById(`countdown${cardCounter}`);

            // Validate the input time format (HH:mm:ss)
            var isValidTime = validateTimeFormat(inputTime);

            if (!isValidTime) {
                alert("Invalid time format. Please use the format HH:mm:ss.");
                return;
            }

            // Convert user input to seconds
            var userTimeInSeconds = convertToSeconds(inputTime);

            // Display user input
            userTimeElement.textContent = inputTime;

            // Save the user input and remaining time to localStorage
            localStorage.setItem(`userTime${cardCounter}`, inputTime);
            localStorage.setItem(`remainingTime${cardCounter}`, userTimeInSeconds);

            // Start the countdown
            countdownIntervals[cardCounter] = setInterval(function () {
                // Retrieve remaining time from localStorage
                userTimeInSeconds = localStorage.getItem(`remainingTime${cardCounter}`);

                userTimeInSeconds--;

                formatted = formatTime(userTimeInSeconds)

                // Display the remaining time in hh:mm:ss format
                countdownElement.textContent = formatted;

                if (userTimeInSeconds <= 0) {
                    clearInterval(countdownIntervals[cardCounter]);
                    countdownElement.textContent = "Time's up!";
                }

                // Update the remaining time in localStorage
                localStorage.setItem(`remainingTime${cardCounter}`, userTimeInSeconds);
            }, 1000);
        }

        function validateTimeFormat(timeString) {
            var regex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
            return regex.test(timeString);
        }

        function convertToSeconds(timeString) {
            var parts = timeString.split(":");
            return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]);
        }

        function formatTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;

            return pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
        }

        function pad(num) {
            return num < 10 ? "0" + num : num;
        }

        // On page load, resume any existing timers
        window.onload = function () {
            @foreach($lahanData as $lahan)
            var cardCounter = {{ $loop-> index + 1
        }};
        var remainingTimeInSeconds = parseInt(localStorage.getItem(`remainingTime${cardCounter}`)) || 0;

        if (remainingTimeInSeconds > 0) {
            document.getElementById(`inputTime${cardCounter}`).value = formatTime(remainingTimeInSeconds);
            startCountdown(cardCounter, '{{ $lahan->id }}');
        }
        @endforeach
                }

        // Handle the window unload event to save remaining time
        window.addEventListener("unload", function () {
            @foreach($lahanData as $lahan)
            var cardCounter = {{ $loop-> index + 1
        }};
        var remainingTime = countdownIntervals[cardCounter] ?
            localStorage.getItem(`remainingTime${cardCounter}`) :
            0;

        // Save remaining time to localStorage as seconds
        localStorage.setItem(`remainingTime${cardCounter}`, remainingTime);
        @endforeach
                });
    </script>
    @endforeach
</div>


@include('pages.script')
@endsection