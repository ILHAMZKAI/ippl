<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('{{ asset('img/bg102.jpg') }}') no-repeat center top fixed, #f4f4f4;
            background-size: cover, auto;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #777;
        }

        .btn-verify {
            background-color: #12e655;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-verify:hover {
            background-color: #179d08;
        }

        /* Styling for the "Request Another" link */
        .btn-request {
            text-decoration: underline;
            color: #007BFF;
            cursor: pointer;
        }

        .btn-request:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Verifikasi Email</h1>
        <p>Silakan klik tombol di bawah untuk verifikasi email Anda.</p>
        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-verify"
                onclick="showVerificationAlert()">{{ __('Klik untuk verifikasi') }}</button>
        </form>
    </div>

    <script>
        function showVerificationAlert() {
            alert("Verifikasi email telah dikirim. Silakan cek email Anda.");
        }
    </script>
</body>

</html>
