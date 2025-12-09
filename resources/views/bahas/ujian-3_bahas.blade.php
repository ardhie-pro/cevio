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
            <div class="col-lg-8" id="soal-col">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                        <ol class="breadcrumb mb-0" id="breadcrumb-modul"></ol>
                    </nav>

                </div>
                <div class="question-box mb-5" id="soal-container"></div>
            </div>

            <!-- RIGHT: Sidebar -->
            <div class="col-lg-4 mt-3 mt-lg-0" id="sidebar-col">
                <div class="sidebar-box">
                    <div class="sidebar-title d-flex align-items-center justify-content-between px-2">
                        <span> Nomor Soal Pengerjaan</span>
                        <i class="bi bi-list" id="toggle-layout" style="cursor:pointer"></i>
                    </div>
                    <div class="grid-container" id="soal-buttons"></div>
                </div>
            </div>

            <footer>
                <p class="text-left mb-5">
                    Created By
                    <a href="" class="text-decoration-none text-body">Citta Bhakti Nirbaya</a>
                </p>
            </footer>
        </div>
    </div>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const kunci = @json($kunci);
            const kodeLogin = "{{ $kode }}";
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

            };

            // ✅ Render soal
            function renderSoal(i) {
                const soal = soalList[i];
                const total = soalList.length;
                const noSoal = soal.no;
                const jawabanBenar = kunci[noSoal]; // ambil kunci jawaban

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
                ].filter(j => j.text);

                const acakJawaban = jawaban
                    .map(j => ({
                        ...j,
                        sort: Math.random()
                    }))
                    .sort((a, b) => a.sort - b.sort);

                soal.mapping = acakJawaban.map(j => j.abjad);

                let html = `
 <div class="question-header">
    <h6>SOAL NOMER ${noSoal}</h6>

    </div>
     <div class="question-body p-2">
        ${soal.soal}

    </div>
        <form id="form-soal-${i}" class="mt-4">
        <div class="list-group">
    `;

                acakJawaban.forEach((j, idx) => {
                    const tampilanAbjad = String.fromCharCode(65 + idx);
                    const checked = jawabanUser[noSoal] === j.abjad ? 'checked' : '';

                    const userAnswer = jawabanUser[noSoal];
                    let bgClass = "";

                    // 🔹 hijau selalu untuk jawaban benar
                    if (j.abjad === jawabanBenar) {
                        bgClass = "bg-success text-white";
                    }

                    // 🔹 merah kalau user pilih salah
                    if (userAnswer && userAnswer !== jawabanBenar && j.abjad === userAnswer) {
                        bgClass = "bg-danger text-white";
                    }

                    html += `

            <label class="list-group-item list-group-item-action option-item ${bgClass}">
            <input class="form-check-input me-2"
                   type="radio"
                   name="jawaban${noSoal}"
                   value="${j.abjad}"
                   ${checked}>
             ${j.text}
        </label>`;
                });

                // ✅ Pembahasan langsung tampil
                html += `
            </div>
            <div class="mt-3 border-left border-info ps-2">
                <strong>Pembahasan:</strong>
                <p>${soal.pembahasan || 'Pembahasan belum tersedia.'}</p>
             </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-flagged"
                    onclick="prevQuestion()" ${i===0 ? 'disabled' : ''}>
                ← Sebelumnya
            </button>
            <button type="button" class="btn btn-answered" onclick="nextQuestion()">
                ${i === total - 1 ? 'Selesai' : 'Selanjutnya →'}
            </button>
        </div>
    </form>
    </div>`;

                document.getElementById('soal-container').innerHTML = html;
            }
            // ✅ Sidebar soal
            function renderSidebar() {
                const sidebar = document.getElementById("soal-buttons");
                if (!sidebar) return;
                sidebar.innerHTML = "";

                soalList.forEach((soal, idx) => {
                    const active = idx === index ? "btn-aktif" : "";
                    const sudahJawab = jawabanUser[soal.no] ? "btn-answered" : "btn-unanswered";

                    sidebar.innerHTML += `
                      <div class="grid-item  ${sudahJawab} ${active}">
    <button class="btn btn-soal ${sudahJawab} ${active}"
            onclick="goToQuestion(${idx})">
        ${soal.no}
    </button>
</div>
    `;
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
            <h3 class="text-success mb-3">🎉 Semua soal telah selesai!</h3>
            <p class="text-muted">Terima kasih sudah mengerjakan ujian ini.</p>

        </div>`;
            }

            // ✅ Panggil fungsi
            loadSoal(modul);
        });
    </script>
@endsection
