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

                    </div>
                    <div class="question-box mb-5">
                        <div class="card-body p-4" id="area-soal">
                            <div class="text-center text-muted">Memuat soal...</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 mt-3">
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
                const modul =
                    @json($ambilmodul); // dari controller (string modul atau array tergantung implementasi kamu)
                const kodeLogin = "{{ $kode }}";
                const kunci = @json($kunci); // format: { "1": "A", "2": "B", ... }

                // Jika ambilmodul adalah array nama breadcrumb, biarkan seperti ini.
                // Kalau modul seharusnya string, pastikan value yang dikirim dari controller sesuai.
                // alert(modul); // hapus atau aktifkan untuk debug

                let no = 1;
                const totalSoal = Object.keys(kunci).length || 0;

                // Inisialisasi breadcrumb jika ada ambilModul (opsional; kalau tidak ingin tampil, comment saja)
                (function renderBreadcrumb() {
                    try {
                        const breadcrumb = document.getElementById("breadcrumb-modul");
                        if (!breadcrumb || !Array.isArray(modul)) return;
                        breadcrumb.innerHTML = "";
                        modul.forEach((m, idx) => {
                            const li = document.createElement("li");
                            li.classList.add("breadcrumb-item");
                            if (idx === modul.length - 1) {
                                li.classList.add("active");
                                li.textContent = m;
                            } else {
                                const a = document.createElement("a");
                                a.href = "javascript:void(0);";
                                a.textContent = m;
                                li.appendChild(a);
                            }
                            breadcrumb.appendChild(li);
                        });
                    } catch (e) {
                        /* ignore if breadcrumb not present */
                    }
                })();

                // Load soal pertama
                loadSoal(no);

                function loadSoal(nomor) {
                    // update nomor global
                    no = nomor;

                    fetch(`/get-soal/${modul}/${no}`)
                        .then(res => {
                            if (!res.ok) {
                                showSelesai();
                                throw new Error("Selesai");
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (!data || data.done) {
                                showSelesai();
                                return;
                            }

                            const kelompok = data.kelompok;
                            const s = data.soal;

                            // Render HTML soal (utuh, rapi)
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
              ${[1,2,3,4,5].map(i => `
                                                                                                                                                                    <td>
                                                                                                                                                                      ${
                                                                                                                                                                        !kelompok[`soal${i}_text`]
                                                                                                                                                                          ? (kelompok[`soal${i}_img`] ? `<img src="/storage/${kelompok[`soal${i}_img`]}" class="soal-img">` : '')
                                                                                                                                                                          : kelompok[`soal${i}_text`]
                                                                                                                                                                      }
                                                                                                                                                                    </td>
                                                                                                                                                                  `).join('')}
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>A</th><th>B</th><th>C</th><th>D</th><th>E</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    ${
      s.soal2
        ? `<h1 class="fw-bold soal-2 text-primary"><span>${s.soal2}</span></h1>`
        : `
                                                                                                                                                              <div class="container text-center my-3">
                                                                                                                                                                <div class="d-inline-flex flex-wrap justify-content-center align-items-center border border-2 border-dark rounded p-3"
                                                                                                                                                                     style="max-width: 100%; gap: 10px;">
                                                                                                                                                                  ${[s.j1, s.j2, s.j3, s.j4]
                                                                                                                                                                    .filter(src => src)
                                                                                                                                                                    .map(src => `
                  <div style="border: 2px solid #000; border-radius: 6px; padding: 5px; margin-bottom: 20px;">
                    <img src="${src}" alt="Gambar Soal" style="height: 5rem; width: auto; object-fit: contain;" class="img-fluid" />
                  </div>
                `).join('')}
                                                                                                                                                                </div>
                                                                                                                                                              </div>
                                                                                                                                                            `
    }

    <div class="container mb-5">
      <div class="row justify-content-center g-2">
        ${['A','B','C','D','E'].map(h => `
                                    <div class="col-2">
                                    <button id="btn-${h}" class="btn-jawab btn btn-outline-primary w-100" onclick="jawab('${h}')">
                                    ${h}
                                     </button>
                                    </div>
                                    `).join('')}
      </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button class="btn btn-secondary" id="btn-prev" ${no === 1 ? 'disabled' : ''}>⬅ Sebelumnya</button>
      <button class="btn btn-primary" id="btn-next" ${no === totalSoal ? 'disabled' : ''}>Selanjutnya ➡</button>
    </div>
  </div>
                `;

                            // pasang event nav setelah render
                            document.getElementById('btn-prev').addEventListener('click', () => {
                                if (no > 1) loadSoal(no - 1);
                            });
                            document.getElementById('btn-next').addEventListener('click', () => {
                                if (no < totalSoal) loadSoal(no + 1);
                            });

                            // Setelah render soal, ambil jawaban user untuk soal ini dan tandai tombol
                            getJawabanUser(no);
                        })
                        .catch(err => {
                            // console.error(err);
                        });
                }

                // Ambil semua jawaban user (endpoint yang kamu sediakan) lalu mark untuk nomor soal ini
                function getJawabanUser(noSoal) {
                    fetch(`/get-jawaban/${modul}/${kodeLogin}`)
                        .then(res => res.json())
                        .then(data => {
                            // data = [{ no:1, jawaban: 'A' }, ...]
                            // disable & reset class tombol dulu
                            document.querySelectorAll('.btn-jawab').forEach(b => {
                                b.disabled = false;
                                b.classList.remove('btn-success', 'btn-danger');
                                // pastikan outline class ada (kembali ke default)
                                if (!b.classList.contains('btn-outline-primary')) b.classList.add(
                                    'btn-outline-primary');
                            });

                            const item = (Array.isArray(data) ? data.find(d => +d.no === +noSoal) : null);
                            const kunciBenar = kunci[noSoal] || null;

                            if (item && item.jawaban) {
                                const userJawab = item.jawaban.toUpperCase();
                                // disable semua tombol
                                document.querySelectorAll('.btn-jawab').forEach(b => b.disabled = true);

                                // tombol user
                                const btnUser = document.getElementById(`btn-${userJawab}`);
                                // tombol kunci
                                const btnKunci = kunciBenar ? document.getElementById(`btn-${kunciBenar.toUpperCase()}`) : null;

                                if (userJawab === (kunciBenar || '').toUpperCase()) {
                                    // jawaban benar: hijau pada tombol user
                                    if (btnUser) {
                                        btnUser.classList.remove('btn-outline-primary');
                                        btnUser.classList.add('btn-success');
                                    }
                                } else {
                                    // jawaban salah: user -> merah, kunci -> hijau (jika ada)
                                    if (btnUser) {
                                        btnUser.classList.remove('btn-outline-primary');
                                        btnUser.classList.add('btn-danger');
                                    }
                                    if (btnKunci) {
                                        btnKunci.classList.remove('btn-outline-primary');
                                        btnKunci.classList.add('btn-success');
                                    }
                                }
                            } else {
                                // belum jawab: biarkan tombol aktif (user bisa jawab)
                                // namun jika kamu mau men-disable jawaban setelah waktu atau kondisi tertentu,
                                // tambahkan logika di sini.
                            }
                        })
                        .catch(err => {
                            // console.error('Gagal ambil jawaban user', err);
                        });
                }

                // Simpan jawaban lalu tanda warna (tidak otomatis pindah soal)
                function jawab(huruf) {
                    // untuk mencegah klik ganda, disable semua tombol sementara
                    document.querySelectorAll('.btn-jawab').forEach(b => b.disabled = true);

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
                                jawaban: huruf
                            })
                        })
                        .then(res => res.json())
                        .then(() => {
                            // setelah sukses simpan, panggil ulang getJawabanUser untuk menandai warna
                            getJawabanUser(no);
                        })
                        .catch(err => {
                            // kalau error, aktifkan tombol kembali dan log error
                            document.querySelectorAll('.btn-jawab').forEach(b => b.disabled = false);
                            // console.error(err);
                        });
                }

                function showSelesai() {
                    document.getElementById("area-soal").innerHTML = `
            <div class="text-center mt-5">
                <h3 class="text-success">🎉 Semua soal telah selesai!</h3>
                <p>Terima kasih telah mengerjakan latihan ini.</p>
            </div>
        `;
                }
            </script>
        @endsection
