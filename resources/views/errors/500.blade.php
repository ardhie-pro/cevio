<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Sistem</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 80px;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 14px;
            width: 420px;
            margin: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #d9534f;
        }

        p {
            font-size: 18px;
            color: #444;
        }

        a.logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #dc3545;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
        }

        a.logout-btn:hover {
            background: #bb2d3b;
        }
    </style>
</head>

<body>

    <div class="box">
        <h1>😵‍💫 Ups! Terjadi Kesalahan</h1>
        <p>Ada gangguan pada sistem. Silakan coba lagi beberapa saat.</p>

        {{-- Tombol Logout --}}
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="logout-btn">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

</body>

</html>
