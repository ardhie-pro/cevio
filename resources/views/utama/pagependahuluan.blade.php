@extends('layouts.main-soal')

@section('title', 'Dashboard')
@section('content2')

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(55px, 1fr));
            grid-gap: 10px;
            padding: 10px;
        }

        .question-box {
            height: auto !important;
        }

        /* Pastikan isi soal bebas memanjang */
        .question-body {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            min-height: auto !important;

            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            overflow: visible !important;
        }

        /* Elemen-elemen di dalam soal */
        .question-body * {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
        }

        /* Jika ada <pre> bikin jebol */
        .question-body pre,
        .question-body code {
            white-space: pre-wrap !important;
            word-break: break-word !important;
        }

        .option-item {
            display: flex !important;
            align-items: flex-start !important;
            gap: 10px;

            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;

            max-width: 100% !important;
        }

        /* Input radio/checkbox tetap kecil */
        .option-item input {
            flex-shrink: 0;
        }

        /* Teks jawaban wajib wrap */
        .option-item span,
        .option-item div,
        .option-item p {
            flex-grow: 1;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            max-width: 100% !important;
        }
    </style>
    <div class="container mt-3">

        <!-- MAIN SECTION -->
        <div class="row mt-2 align-items-start" id="main-row">
            <!-- LEFT: Question -->
            <div class="col-lg-12" id="soal-col">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                        <ol class="breadcrumb mb-0" id="breadcrumb-modul"></ol>
                    </nav>
                    <div class="timer-box">
                        <span id="liveTimer">00:00:00</span>
                    </div>
                </div>
                <div class="question-box mb-5" id="soal-container"></div>
            </div>

            <!-- RIGHT: Sidebar -->


            <footer>
                <p class="text-left mb-5">
                    Created By
                    <a href="" class="text-decoration-none text-body">Citta Bhakti Nirbaya</a>
                </p>
            </footer>
        </div>
    </div>
    <script>
        const ambilModul = @json($ambilmodul);
        const breadcrumb = document.getElementById("breadcrumb-modul");
        breadcrumb.innerHTML = "";

        // Modul yang tidak ditampilkan
        const skipList = ["Nama-Peserta", "istirahat", "panduan"];

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
        document.addEventListener("DOMContentLoaded", function() {

            const toggleBtn = document.getElementById("toggle-layout");
            const soalCol = document.getElementById("soal-col");
            const sidebarCol = document.getElementById("sidebar-col");
            const mainRow = document.getElementById("main-row");
            const soalContainer = document.getElementById("soal-container");

            // Simpan posisi asli
            const originalNextElement = sidebarCol.nextElementSibling;

            toggleBtn.addEventListener("click", function() {

                const isFull = soalCol.classList.contains("col-12");

                if (!isFull) {
                    // 👉 MASUK MODE FULLSCREEN

                    soalCol.classList.remove("col-lg-8");
                    soalCol.classList.add("col-12");

                    sidebarCol.classList.remove("col-lg-4");
                    sidebarCol.classList.add("col-12", "mb-3");

                    // 🔥 Pindahkan sidebar tepat di atas question-box
                    soalContainer.parentNode.insertBefore(sidebarCol, soalContainer);

                } else {
                    // 👉 KEMBALI KE POSISI SEMULA

                    soalCol.classList.remove("col-12");
                    soalCol.classList.add("col-lg-8");

                    sidebarCol.classList.remove("col-12", "mb-3");
                    sidebarCol.classList.add("col-lg-4");

                    // 🔥 Kembalikan ke kanan seperti awal
                    if (originalNextElement) {
                        mainRow.insertBefore(sidebarCol, originalNextElement);
                    } else {
                        mainRow.appendChild(sidebarCol);
                    }
                }
            });

        });
    </script>

    <!-- JAVASCRIPT -->
    @php

        use App\Models\Kode;
        use Carbon\Carbon;

        $kodeLogin = session('kode_login');
        $kodeData = Kode::where('kode', $kodeLogin)->first();

        // waktu selesai dari database (format waktu Jakarta)
        $waktuSelesai = $kodeData ? Carbon::parse($kodeData->waktu, 'Asia/Jakarta')->format('Y-m-d H:i:s') : null;

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
        let tandaiSoal = {};
        document.addEventListener("DOMContentLoaded", function() {
            const kodeLogin = "{{ session('kode_login') }}";
            let modul = "{{ $modul ?? 'default' }}";
            let index = 0;
            let soalList = [];
            let jawabanUser = {};

            // ✅ Fungsi utama: ambil soal + jawaban dari database
            function loadSoal(modul) {
                fetch(`/get-soal-multiple/${modul}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            document.getElementById('soal-container').innerHTML =
                                "<p class='text-center text-danger'>Belum ada soal untuk modul ini.</p>";
                            return;
                        }

                        soalList = data;
                        soalList.sort((a, b) => a.no - b.no);

                        // 🧠 Ambil jawaban user dari database
                        fetch(`/get-jawaban/${modul}/${kodeLogin}`)
                            .then(res => res.json())
                            .then(jawabDb => {
                                // Masukkan ke objek jawabanUser
                                jawabDb.forEach(item => {
                                    jawabanUser[item.no] = item.jawaban;
                                });

                                // cari nomor terakhir yang dijawab
                                if (jawabDb.length > 0) {
                                    const nomorTerakhir = Math.max(...jawabDb.map(j => j.no));
                                    const idxTerakhir = soalList.findIndex(s => s.no === nomorTerakhir);
                                    if (idxTerakhir !== -1) index = idxTerakhir;
                                }

                                renderSoal(index);
                                renderSidebar();
                            })
                            .catch(err => {
                                console.error("Gagal ambil jawaban user:", err);
                                renderSoal(index);
                                renderSidebar();
                            });
                    })
                    .catch(err => {
                        document.getElementById('soal-container').innerHTML =
                            "<p class='text-center text-danger'>Gagal memuat soal.</p>";
                        console.error(err);
                    });
            }

            // ✅ Simpan jawaban
            window.jawab = function(no, j) {
                jawabanUser[no] = j;

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
                    .catch(err => console.error("Gagal simpan jawaban:", err));

                renderSidebar();
            };

            // ✅ Render soal
            function renderSoal(i) {
                const soal = soalList[i];
                const total = soalList.length;
                const noSoal = soal.no;

                // Ambil semua opsi jawaban beserta abjad aslinya
                let jawaban = [{
                        abjad: 'A',
                        text: soal.j1
                    },
                    {
                        abjad: 'B',
                        text: soal.j2
                    },
                    {
                        abjad: 'C',
                        text: soal.j3
                    },
                    {
                        abjad: 'D',
                        text: soal.j4
                    },
                    {
                        abjad: 'E',
                        text: soal.j5
                    }
                ].filter(j => j.text); // hapus yang kosong

                // 🔀 Acak urutan tampilan (tapi tetap tahu abjad aslinya)
                const acakJawaban = jawaban
                    .map(j => ({
                        ...j,
                        sort: Math.random()
                    }))
                    .sort((a, b) => a.sort - b.sort);

                // Simpan mapping abjad asli biar tahu nanti yang dipilih user
                soal.mapping = acakJawaban.map(j => j.abjad);

                let html = `
    <div class="question-body p-2">
        ${soal.soal}

    </div>

    `;

                acakJawaban.forEach((j, idx) => {
                    const tampilanAbjad = String.fromCharCode(65 + idx); // A, B, C, D, E
                    const checked = jawabanUser[noSoal] === j.abjad ? 'checked' : '';

                    html += `
        <label class="list-group-item list-group-item-action option-item">

        </label>`;
                });

                html += `
        </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-answered" onclick="nextQuestion()">
                ${i === total - 1 ? 'Selesai' : 'Selanjutnya →'}
            </button>
        </div>
    </form>
    </div>`;

                document.getElementById('soal-container').innerHTML = html;

                // ✅ Tambahan event untuk tombol tandai
                const flagButton = document.querySelector(".flag-btn");
                flagButton.addEventListener("click", function() {
                    const soalSekarang = soalList[i].no;
                    tandaiSoal[soalSekarang] = !tandaiSoal[soalSekarang];

                    // 🔁 Update tampilan tombol
                    if (tandaiSoal[soalSekarang]) {
                        flagButton.classList.add("flagged-active");
                        flagButton.innerHTML = `<i class="bi bi-flag"></i> Sudah Ditandai`;
                    } else {
                        flagButton.classList.remove("flagged-active");
                        flagButton.innerHTML = `<i class="bi bi-flag"></i> Tandai Soal`;
                    }

                    renderSidebar(); // tetap update warna di sidebar juga
                });

            }


            // ✅ Sidebar soal
            function renderSidebar() {
                const sidebar = document.getElementById("soal-buttons");
                if (!sidebar) return;
                sidebar.innerHTML = "";

                // 🔥 URUTKAN BERDASARKAN nomor soal (VIEW ONLY)
                const sortedSoal = [...soalList].sort((a, b) => Number(a.no) - Number(b.no));

                sortedSoal.forEach((soal, idx) => {
                    const active = index === soalList.indexOf(soal) ? "btn-aktif" : "";
                    const sudahJawab = jawabanUser[soal.no] ? "btn-answered" : "btn-unanswered";
                    const ditandai = tandaiSoal[soal.no] ? "btn-flagged" : "";

                    sidebar.innerHTML += `
           <div class="grid-item ${ditandai} ${sudahJawab} ${active}">
    <button class="btn btn-soal ${ditandai} ${sudahJawab} ${active}"
            onclick="goToQuestion(${soalList.indexOf(soal)})">
        ${soal.no}
    </button>
</div>`;
                });
            }


            // ✅ Navigasi
            window.nextQuestion = function() {
                if (index < soalList.length - 1) {
                    index++;
                    renderSoal(index);
                    renderSidebar();
                } else {
                    showSelesai();
                }
            };
            window.prevQuestion = function() {
                if (index > 0) {
                    index--;
                    renderSoal(index);
                    renderSidebar();
                }
            };
            window.goToQuestion = function(i) {
                index = i;
                renderSoal(index);
                renderSidebar();
            };

            // ✅ Akhiri modul
            function showSelesai() {
                document.getElementById('soal-container').innerHTML = `
        <div class="text-center p-5">
              <h3 class="fw-bold text-success mb-2">Siap Mengerjakan Soal?</h3>
            <p class="text-muted mb-4">
                Pastikan Anda telah membaca instruksi dan siap melanjutkan ke tahap berikutnya.
            </p>
            <form action="/next-modul" method="POST">
                @csrf
                <input type="hidden" name="modul" value="${modul}">
                <button type="submit" class="btn btn-success mt-3">
                    Lanjut
                </button>
            </form>
        </div>`;
            }

            // ✅ Panggil fungsi
            loadSoal(modul);
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

    <!-- akhir ujian -->
@endsection
