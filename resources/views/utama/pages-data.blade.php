@extends('layouts.main-soal')

@section('title', 'Data Peserta')
@section('content2')
    <div class="container mt-3">
        <div class="row mt-2 align-items-start">
            <div class="col-lg-12 card">
                <div id="form-container" class="p-3">
                    <h4 class="text-muted font-size-18 text-center">Selamat Datang</h4>
                    <p class="text-muted text-center">Anda Akan Dialihkan Kedalam Mode Full Screen</p>

                    <form id="namaForm">
                        <div class="mb-3">
                            <input type="hidden" name="jawaban" class="form-control" id="username"
                                value="{{ Auth::user()->name }}" placeholder="MASUKAN NAMA" required />
                        </div>

                        <div class="text-center mt-5">
                            <button class="btn btn-primary w-md waves-effect waves-light p-3" type="submit">
                                Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Hasil setelah kirim -->
                <div id="hasil-container" class="text-center p-5 d-none">
                    <h3 class="text-success mb-3">✅ Siap mulai mengerjakan!</h3>
                    <p class="text-muted">Klik tombol di bawah untuk memulai tes.</p>
                    <form action="/next-modul" method="POST">
                        @csrf
                        <input type="hidden" name="modul" value="{{ $modul }}">
                        <button type="submit" class="btn btn-success mt-3" id="btnMulai">Mulai Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <p class="text-muted">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script> CIBN. Crafted by Citta Bhakti Nirbaya
        </p>
    </div>

    <script src="{{ asset('assetts/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("namaForm");
            const formContainer = document.getElementById("form-container");
            const hasilContainer = document.getElementById("hasil-container");

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const nama = document.getElementById("username").value.trim();
                if (!nama) {
                    alert("⚠️ Nama tidak boleh kosong!");
                    return;
                }

                fetch('/simpan-jawaban', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            modul: "{{ $modul }}",
                            kodeLogin: "{{ session('kode_login') }}",
                            no: 1,
                            jawaban: nama
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error("Gagal menyimpan nama!");
                        return res.json();
                    })
                    .then(data => {
                        formContainer.classList.add("d-none");
                        hasilContainer.classList.remove("d-none");
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan saat menyimpan nama.");
                    });
            });
        });
    </script>
    {{-- untuk fullscreen --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnMulai = document.getElementById("btnMulai");

            if (btnMulai) {
                btnMulai.addEventListener("click", function(e) {
                    // Minta browser masuk fullscreen
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.msRequestFullscreen) {
                        document.documentElement.msRequestFullscreen();
                    }
                });
            }
        });
    </script>


@endsection
