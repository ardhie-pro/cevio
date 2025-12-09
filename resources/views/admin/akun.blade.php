@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            background: #f4f6fb;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            font-weight: 800;
            color: #222;
            margin: 0;
        }

        h2 {
            color: #4b4b4b;
            text-align: center;
            margin-top: 6px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        /* WRAPPER */
        .wrapper {
            border: 2px solid #cdd6e4;
            border-radius: 14px;
            padding: 25px;
            background: #fff;
            margin: 40px auto;
            width: 90%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 18px;
            background: #F4C542 !important;
            color: #0E2542 !important;
            padding: 8px 14px;
            border-radius: 8px;
            width: max-content;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* CARD */
        .card {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #dde3ee;
            box-shadow:
                0 3px 6px rgba(0, 0, 0, 0.05),
                0 1px 2px rgba(0, 0, 0, 0.04);
            transition: 0.25s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.14),
                0 4px 10px rgba(0, 0, 0, 0.08);
            border-color: #b8c6df;
        }

        /* ROW */
        .row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        /* FIELD BOX */
        .box {
            flex: 1;
            background: #e7e9ef;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #4d4d4d;
            letter-spacing: 0.3px;
            min-width: 0;
            word-break: break-word;
        }

        /* BUTTON */
        .btn-custom {
            width: 95px;
            background: #F4C542 !important;
            color: #0E2542 !important;
            padding: 10px 0;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            transition: 0.25s;
            border: none !important;
            flex-shrink: 0;
        }

        .btn-custom:hover {
            background: #e1b63b !important;
        }

        .btn-danger-sm {
            background: #c0392b !important;
            color: white !important;
        }

        .btn-danger-sm:hover {
            background: #962d22 !important;
        }
    </style>

    <div class="page-content">
        <h1>SELAMAT DATANG,</h1>
        <h2>ADMIN CITTA BHAKTI NIRBAYA</h2>
    </div>


    {{-- =====================  TABEL ADMIN  ===================== --}}
    <div class="wrapper">
        <div class="title">Informasi Akun — Admin</div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead style="background:#F4C542; color:#0E2542; font-weight:700;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Paswword</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php $noAdmin = 1; @endphp

                    @foreach ($admins as $user)
                        <tr>
                            <td>{{ $noAdmin++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->lihatpw }}</td>

                            <td>
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm">
                                        <option value="active" {{ $user->role == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->role == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="suspended" {{ $user->role == 'suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                    </select>
                            </td>

                            <td>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="admin" {{ $user->status == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="review" {{ $user->status == 'review' ? 'selected' : '' }}>Review
                                    </option>
                                </select>
                            </td>

                            <td>
                                <button type="submit" class="btn btn-warning btn-sm">💾</button>
                                </form>

                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    {{-- =====================  TABEL REVIEW  ===================== --}}
    <div class="wrapper">
        <div class="title">Informasi Akun — Review</div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead style="background:#F4C542; color:#0E2542; font-weight:700;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php $noReview = 1; @endphp

                    @foreach ($reviews as $user)
                        <tr>
                            <td>{{ $noReview++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->lihatpw }}</td>


                            <td>
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm">
                                        <option value="active" {{ $user->role == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->role == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="suspended" {{ $user->role == 'suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                    </select>
                            </td>

                            <td>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="admin" {{ $user->status == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="review" {{ $user->status == 'review' ? 'selected' : '' }}>Review
                                    </option>
                                </select>
                            </td>

                            <td>
                                <button type="submit" class="btn btn-warning btn-sm">💾</button>
                                </form>

                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    </div>


@endsection
