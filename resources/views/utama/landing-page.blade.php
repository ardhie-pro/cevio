<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citta Bhakti Nirbaya</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assetts/images/favicon.ico') }}">

    <style>
        /* Background untuk layar besar (Laptop / Desktop) */
        body {
            background-image: url('{{ asset('assetts/images/leptop.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: flex-end;
            /* turun ke bawah */
            justify-content: flex-start;
            /* kiri */
            padding: 40px;
            /* jarak dari pinggir */
        }

        /* Background untuk HP */
        @media (max-width: 768px) {
            body {
                background-image: url('{{ asset('assetts/images/hp.jpg') }}');
            }
        }

        .box {
            background: rgba(0, 0, 0, 0.55);
            padding: 30px;
            border-radius: 15px;
            text-align: left;
            /* biar tulisannya rata kiri */
            color: #fff;
            width: 90%;
            max-width: 420px;
            backdrop-filter: blur(4px);
        }

        .btn-login {
            padding: 12px 25px;
            font-size: 18px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2 class="mb-3">Citta Bhakti Nirbaya</h2>
        <p class="mb-4">
            Silakan login untuk melanjutkan ke halaman berikutnya.

        </p>

        <a href="{{ route('login') }}" class="btn btn-primary btn-login">Login</a>

    </div>

</body>

</html>
