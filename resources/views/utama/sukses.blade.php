<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="alert alert-success">
            <h5>✅ Berhasil Login!</h5>
            <p>Anda berhasil masuk ke modul:</p>
            <strong>{{ $modul->nama }}</strong>
            <hr>
            <p>ID Modul: {{ $modul->id }}</p>
            <p>Deskripsi: {{ $modul->modul ?? '-' }}</p>
        </div>
    </div>

</body>

</html>
