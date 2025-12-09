@extends('layouts.main-soal')

@section('title', 'Dashboard')
@section('content2')

    <body onload="openFullscreen()">
        <!-- HEADER -->
        <div class="container mt-3">

            <!-- MAIN SECTION -->
            <div class="row mt-2 align-items-start">
                <!-- LEFT: Question -->
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                            <ol class="breadcrumb mb-0" id="breadcrumb-modul">

                            </ol>
                        </nav>
                        <div class="timer-box">
                            <span id="timer">
                                <span id="liveTimer">00:00:00</span>
                            </span>
                        </div>
                    </div>
                    <div class="question-box mb-5">
                        <div class="card-body p-4" id="area-soal">
                            <div class="text-center text-muted">Memuat soal...</div>
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
            <link rel="shortcut icon" href="{{ asset('assetts//images/favicon.ico') }}" />
            <style>
                .timer-box {
                    position: static !important;
                    /* pastikan tidak fixed */
                    right: auto !important;
                    top: auto !important;
                    background: transparent;
                    padding: 0;
                }

                .masuk-soal {
                    font-size: 2rem;
                    font-weight: bold;
                    border: 2px solid black;
                    display: flex;
                    justify-content: center;
                    /* posisi tengah default */
                    align-items: center;
                    position: relative;
                }

                .masuk-soal strong {
                    flex-grow: 1;
                    text-align: center;
                }

                .masuk-soal span.soal-no {
                    position: absolute;
                    right: 15px;
                }

                .soal-2 {
                    font-size: 5rem;
                    margin-bottom: 5rem;
                }

                @media (max-width: 768px) {
                    .masuk-soal {
                        font-size: 1rem;
                        font-weight: bold;
                    }

                    .soal-2 {
                        font-size: 2rem;
                    }
                }


                .soaltabel {
                    border: 2px solid black;
                    table-layout: fixed;
                    /* kolom rata */
                    width: 100%;
                    text-align: center;
                }

                .btn-jawab {
                    background-color: white;
                    color: black;
                    font-size: 1.2rem;
                    padding: 12px;
                    border: 2px solid #000000;
                    width: 100%;
                }

                .btn-jawab:hover {
                    background-color: #244e9b;
                    /* hijau */
                    color: white;
                    border-color: #000000;
                }

                .text-primary-blue {
                    color: var(--primary-blue) !important;
                }

                /* Hanya bagian tbody yang hurufnya besar */
                .soaltabel tbody td {
                    font-size: 8rem;
                    border: 2px solid black;
                    width: 20%;
                    vertical-align: middle;
                }

                /* Bagian footer (A,B,C,D,E) kecil normal */
                .soaltabel tfoot th {
                    font-size: 1rem;
                    color: white;
                    border: 2px solid #000;
                    width: 20%;
                    vertical-align: middle;
                    background-color: #244e9b;
                }

                .table-responsive {
                    overflow-x: auto;
                }

                .soal-img {
                    max-width: 100%;
                    height: 8rem;
                    object-fit: contain;
                    border-radius: 8px;
                }

                /* Responsif di HP */
                @media (max-width: 768px) {
                    .soaltabel tbody td {
                        font-size: 3rem;
                    }

                    .soaltabel tfoot th {
                        font-size: 0.9rem;
                    }

                    .soal-img {
                        height: 4rem;
                    }

                }

                .soal-2 span {
                    display: inline-block;
                    border: 3px solid black;
                    letter-spacing: 40px;
                    padding-left: 40px;
                }

                /* nomor soal */
                #vertical-menu-btn {
                    display: none;
                }

                @media (max-width: 991px) {
                    #vertical-menu-btn {
                        display: inline-block;
                    }
                }

                .card {
                    border-radius: 16px;
                    background: #ffffff;
                }

                .card-body {
                    background-color: #fff;
                }

                .option-item {
                    border-radius: 10px;
                    cursor: pointer;
                    font-size: 1.05rem;
                    padding: 12px 15px;
                    transition: all 0.2s ease-in-out;
                }

                .option-item:hover {
                    background-color: #f1f3f5;
                }

                .option-item input[type="radio"]:checked+span {
                    font-weight: 600;
                }

                input[type="radio"]:checked~label,
                .option-item input[type="radio"]:checked {
                    accent-color: #244e9b;
                }

                .badge {
                    border-radius: 8px;
                }

                @media (max-width: 576px) {
                    .card-body {
                        padding: 1.25rem;
                    }

                    .fs-5 {
                        font-size: 1rem !important;
                    }
                }

                @media (max-width: 600px) {

                    /* TABEL BAGIAN SOAL */
                    .soaltabel tbody td {
                        font-size: 2.2rem !important;
                        /* lebih kecil tapi tetap jelas */
                        padding: 6px !important;
                    }

                    .soaltabel {
                        table-layout: fixed !important;
                        width: 100% !important;
                    }

                    /* FOOTER A-B-C-D-E */
                    .soaltabel tfoot th {
                        font-size: 0.8rem !important;
                        padding: 6px !important;
                    }

                    /* GAMBAR SOAL */
                    .soal-img {
                        height: 3rem !important;
                        max-width: 100%;
                        object-fit: contain !important;
                    }

                    /* JUDUL SOAL */
                    .masuk-soal {
                        font-size: 0.9rem !important;
                        padding: 8px !important;
                    }

                    /* NO SOAL KANAN */
                    .masuk-soal .soal-no {
                        right: 8px;
                        font-size: 0.75rem !important;
                    }

                    /* SOAL 2 BESAR SPAN */
                    .soal-2 {
                        font-size: 1.5rem !important;
                        margin-bottom: 2rem !important;
                    }

                    .soal-2 span {
                        letter-spacing: 20px !important;
                        padding-left: 20px !important;
                        border-width: 2px !important;
                    }

                    /* BUTTON A B C D E */
                    .btn-jawab {
                        font-size: 1rem !important;
                        padding: 10px !important;
                        border-width: 2px !important;
                    }

                    /* Kolom tombol selalu 5 tapi fleksibel */
                    .row .col-2 {
                        max-width: 20% !important;
                        flex: 0 0 20% !important;
                        padding-left: 4px !important;
                        padding-right: 4px !important;
                    }
                }

                /* HP super kecil (<= 400px) */
                @media (max-width: 400px) {
                    .soaltabel tbody td {
                        font-size: 1.8rem !important;
                    }

                    .soal-img {
                        height: 2.5rem !important;
                    }

                    .btn-jawab {
                        font-size: 0.85rem !important;
                        padding: 8px !important;
                    }

                    .row .col-2 {
                        padding-left: 2px !important;
                        padding-right: 2px !important;
                    }
                }
            </style>




            <script>
                const ambilModul = @json($ambilmodul);
                const breadcrumb = document.getElementById("breadcrumb-modul");
                breadcrumb.innerHTML = "";

                // Modul yang tidak ditampilkan
                const skipList = ["Nama-Peserta", "istirahat"];

                let filtered = ambilModul.filter(modul => !skipList.includes(modul));

                filtered.forEach((modul, index) => {

                    // Tambah separator jika bukan yang pertama
                    if (index > 0) {
                        const separator = document.createElement("span");
                        separator.innerHTML = "&nbsp;&gt;&nbsp;";
                        separator.classList.add("breadcrumb-separator");
                        breadcrumb.appendChild(separator);
                    }

                    // Elemen teks modul (bukan link)
                    const item = document.createElement("span");
                    item.textContent = modul;

                    // Styling item terakhir = aktif
                    if (index === filtered.length - 1) {
                        item.classList.add("breadcrumb-active");
                    } else {
                        item.classList.add("breadcrumb-item-text");
                    }

                    breadcrumb.appendChild(item);
                });
                const kodeLogin = "{{ session('kode_login') }}";
                let modul = {!! json_encode($modul ?? 'default') !!};
                let no = 1;

                // ambil soal pertama
                loadSoal(no);

                function disableJawabanButtons() {
                    const btns = document.querySelectorAll('.btn-jawab');
                    btns.forEach(b => {
                        b.disabled = true;
                        b.style.opacity = "0.4";
                        b.style.pointerEvents = "none";
                    });
                }

                function loadSoal(no) {
                    fetch(`/get-soal/${modul}/${no}`)
                        .then(res => {
                            if (!res.ok) {
                                // soal habis → disable tombol saja
                                disableJawabanButtons();
                                throw new Error("Selesai");
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (!data || data.done) {
                                // soal habis → disable tombol saja
                                disableJawabanButtons();
                                return;
                            }

                            const kelompok = data.kelompok;
                            const s = data.soal;

                            document.getElementById("area-soal").innerHTML = `

        <div class="question-content text-center  border-1">
          <div class="container">
            <div class="table-responsive">
              <h1 class="masuk-soal mt-5 p-2">
                <strong>${kelompok.judul}</strong>
                <span class="soal-no">No. ${s.no}</span>
            </h1>
              <table class="table table-bordered soaltabel">
                <tbody>
                  <tr>
                    <tr>
                      <td>
                          ${
                              !kelompok.soal1_text
                              ? (kelompok.soal1_img ? `<img src="/storage/${kelompok.soal1_img}" class="soal-img">` : '')
                              : kelompok.soal1_text
                          }
                      </td>
                      <td>
                          ${
                              !kelompok.soal2_text
                              ? (kelompok.soal2_img ? `<img src="/storage/${kelompok.soal2_img}" class="soal-img">` : '')
                              : kelompok.soal2_text
                          }
                      </td>
                      <td>
                          ${
                              !kelompok.soal3_text
                              ? (kelompok.soal3_img ? `<img src="/storage/${kelompok.soal3_img}" class="soal-img">` : '')
                              : kelompok.soal3_text
                          }
                      </td>
                      <td>
                          ${
                              !kelompok.soal4_text
                              ? (kelompok.soal4_img ? `<img src="/storage/${kelompok.soal4_img}" class="soal-img">` : '')
                              : kelompok.soal4_text
                          }
                      </td>
                      <td>
                          ${
                              !kelompok.soal5_text
                              ? (kelompok.soal5_img ? `<img src="/storage/${kelompok.soal5_img}" class="soal-img">` : '')
                              : kelompok.soal5_text
                          }
                      </td>
                  </tr>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            </div>

       ${
           s.soal2
           ? `<h1 class="fw-bold soal-2 text-primary-blue"><span>${s.soal2}</span></h1>`
           : `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="container text-center my-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <div class="d-inline-flex flex-wrap justify-content-center align-items-center border border-2 border-dark rounded p-3"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           style="max-width: 100%; gap: 10px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ${
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [s.j1, s.j2, s.j3, s.j4]
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .filter(src => src)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .map(src => `
            <div style="border: 2px solid #000; border-radius: 6px; padding: 5px; margin-bootom: 20px;">
              <img
                src="${src}"
                alt="Gambar Soal"
                style="height: 5rem; width: auto; object-fit: contain;"
                class="img-fluid"
              />
            </div>
          `).join('')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `
       }

          <div class="container mb-5">
            <div class="row justify-content-center g-2">
              ${['A', 'B', 'C', 'D', 'E'].map((huruf) => `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <button
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="btn-jawab"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            onclick="jawab('${huruf}')">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ${huruf}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    `).join('')}
            </div>
          </div>
        </div>
      `;

                        })
                        .catch(() => {});
                }

                function jawab(j) {
                    fetch('/simpan-jawaban', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                modul: modul,
                                kodeLogin: kodeLogin,
                                no: no,
                                jawaban: j
                            })
                        })
                        .then(res => res.json())
                        .then(() => {
                            no++;
                            loadSoal(no);
                        }); // jaga-jaga kalau terakhir
                }
            </script>
            @php
                use App\Models\Kode;
                use Carbon\Carbon;

                $kodeLogin = session('kode_login');
                $kodeData = Kode::where('kode', $kodeLogin)->first();

                // waktu selesai dari database (format waktu Jakarta)
                $waktuSelesai = $kodeData
                    ? Carbon::parse($kodeData->waktu, 'Asia/Jakarta')->format('Y-m-d H:i:s')
                    : null;
            @endphp
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const display = document.getElementById("liveTimer");
                    if (!display) return;

                    // 🕒 Ambil waktu selesai dari session (format: Y-m-d H:i:s)
                    const waktuSelesaiString = "{{ $waktuSelesai }}";
                    const kodeLogin = "{{ session('kode_login') }}";
                    const modul = "{{ $modul }}";

                    // ⏰ Parse waktu selesai (anggap format lokal Asia/Jakarta)
                    const waktuSelesai = new Date(waktuSelesaiString.replace(" ", "T") + "+07:00");

                    const timerInterval = setInterval(updateTimer, 1000);
                    updateTimer();

                    function updateTimer() {
                        const now = new Date();
                        const remaining = waktuSelesai - now;

                        if (remaining <= 0) {
                            clearInterval(timerInterval);
                            tampilkanWaktuHabis();
                            return;
                        }

                        const totalSeconds = Math.floor(remaining / 1000);
                        const hours = Math.floor(totalSeconds / 3600);
                        const minutes = Math.floor((totalSeconds % 3600) / 60);
                        const seconds = totalSeconds % 60;

                        display.textContent =
                            `${hours.toString().padStart(2,"0")}:${minutes.toString().padStart(2,"0")}:${seconds.toString().padStart(2,"0")}`;
                    }

                    function tampilkanWaktuHabis() {
                        // 🔒 cegah tombol back
                        history.pushState(null, null, document.URL);
                        window.onpopstate = () => history.pushState(null, null, document.URL);

                        // 🌕 overlay full-screen putih
                        const overlay = document.createElement("div");
                        overlay.style = `
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;

                        overlay.innerHTML = `
        <style>
            .spinner {
                position: relative;
                width: 120px;
                height: 120px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .spinner::before {
                content: "";
                position: absolute;
                width: 100px;
                height: 100px;
                border: 5px solid #ddd;
                border-top-color: #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>

        <form id="autoNextForm" action="/next-modul" method="POST">
            @csrf
            <input type="hidden" name="kodeLogin" value="${kodeLogin}">
            <input type="hidden" name="modul" value="${modul}">
            <div class="spinner">
                <img src="{{ asset('assetts/images/logo-sm-dark.png') }}"
                     alt="logo"
                     style="width: 60px; height: auto; z-index: 2;">
            </div>
        </form>
    `;
                        document.body.appendChild(overlay);

                        // ⏳ auto-submit setelah 1 detik
                        setTimeout(() => {
                            document.getElementById("autoNextForm").submit();
                        }, 1000);
                    }
                });
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    let windowBlurred = false;

                    // 🔹 Fungsi Logout Otomatis
                    function autoLogout() {
                        fetch("/logouttest", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        }).then(() => {
                            alert("Anda keluar atau mengklik di luar halaman. Anda akan logout otomatis.");
                            window.location.href = "/";
                        }).catch(() => {
                            window.location.href = "/";
                        });
                    }

                    // 🔹 Deteksi Keluar Fullscreen
                    document.addEventListener("fullscreenchange", function() {
                        if (!document.fullscreenElement) {
                            autoLogout();
                        }
                    });

                    // 🔹 Cegah klik kanan
                    document.addEventListener("contextmenu", e => {
                        e.preventDefault();
                        alert("Klik kanan dinonaktifkan!");
                        autoLogout();
                    });

                    // 🔹 Cegah Shortcut Berbahaya
                    document.addEventListener("keydown", e => {
                        const forbidden = [
                            (e.ctrlKey && e.key === "u"),
                            (e.ctrlKey && e.shiftKey && e.key === "i"),
                            (e.key === "F12"),
                            (e.ctrlKey && e.key === "c"),
                            (e.ctrlKey && e.key === "p"),
                            (e.key === "PrintScreen")
                        ];

                        if (forbidden.some(f => f)) {
                            e.preventDefault();
                            alert("Tindakan ini tidak diizinkan!");
                            autoLogout();
                        }
                    });

                    // 🔹 Ketika user meninggalkan window (ALT+TAB / klik luar)
                    window.addEventListener("blur", () => {
                        windowBlurred = true; // tandai bahwa user keluar window
                    });

                    // 🔹 Jika user kembali ke window lalu melakukan KLIK → logout
                    window.addEventListener("focus", () => {
                        if (windowBlurred) {
                            autoLogout();
                        }
                    });

                    // 🔹 Jika user benar-benar KLIK DI LUAR (browser tidak mendeteksi klik),
                    //     tapi cara ini: jika window blur + ada klik pertama saat kembali → logout.
                    document.addEventListener("mousedown", () => {
                        if (windowBlurred) {
                            autoLogout();
                        }
                    });

                });
            </script>


            <style>
                #timerButton {
                    font-weight: 600;
                    letter-spacing: 0.5px;
                }
            </style>
        @endsection
