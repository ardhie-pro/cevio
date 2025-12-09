<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CIBN | User Test Multiple Choice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('assetts//images/favicon.ico') }}" />

    <link href="{{ asset('assetts/css/soal.css') }}" rel="stylesheet" type="text/css" />

</head>

<body onload="openFullscreen()">
    <!-- HEADER -->

    @include('partials.header-soal')

    @yield('content2')



</body>

</html>
