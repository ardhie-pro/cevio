<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        CIBN | Citta Bhakhti Nirbaya
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assetts/images/favicon.ico') }}">

    <!-- DataTables -->
    <link href="{{ asset('assetts/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assetts/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assetts/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetts/css/code.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetts/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetts/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assetts/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="colored">

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            {{-- Header --}}
            @include('partials.header')

        </header>

        <!-- ========== Left Sidebar Start ========== -->

        <!-- Left Sidebar End -->
        @include('partials.sidebar')


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            {{-- Konten Halaman --}}
            <main class="container-fluid py-4">
                @yield('content')
            </main>
            <!-- End Page-content -->


            {{-- Footer --}}
            @include('partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assetts/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assetts/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    {{-- <script src="{{ asset('assetts/js/pages/form-editor.init.js') }}"></script> --}}

    <!-- Required datatable js -->
    <script src="{{ asset('assetts/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>


    <!-- Responsive examples -->
    <script src="{{ asset('assetts/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assetts/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('assetts/js/pages/datatables.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assetts/js/app.js') }}"></script>


    <script>
        // Fungsi umum untuk inisialisasi TinyMCE
        function initTinyMCE(selector) {
            tinymce.init({
                selector: selector,
                selector: selector,
                height: 250,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media",
                    "table emoticons paste"
                ],
                toolbar: "undo redo | styleselect | bold italic underline | " +
                    "alignleft aligncenter alignright alignjustify | " +
                    "bullist numlist outdent indent | link image | forecolor backcolor | code",

                // --------------------------------------------------
                // ⚡ BASE64 IMAGE (DRAG & DROP / COPY PASTE)
                // --------------------------------------------------
                automatic_uploads: true,
                file_picker_types: 'image',
                paste_data_images: true,

                // Convert gambar ke base64
                images_upload_handler: function(blobInfo, success, failure) {
                    const base64 = "data:" + blobInfo.blob().type + ";base64," + blobInfo.base64();
                    success(base64);
                },
            });
        }

        $(document).ready(function() {

            // --- Inisialisasi awal TinyMCE untuk form TAMBAH ---
            initTinyMCE("#elm_soal, #elm_j1, #elm_pembahasan, #elm_j2, #elm_j3, #elm_j4, #elm_j5");

            // --- Tombol Tambah Soal ---
            $("#tambahSoalBtn").on("click", function() {
                $("#formEditSoal").hide();
                $("#formTambahSoal").show();
                $(this).hide();

                // Re-init editor agar muncul jika sebelumnya dihapus
                setTimeout(() => {
                    tinymce.remove();
                    initTinyMCE(
                        "#elm_soal, #elm_j1, #elm_pembahasan, #elm_j2, #elm_j3, #elm_j4, #elm_j5"
                    );
                }, 300);
            });

            // --- Tombol Batal Tambah ---
            $("#batalBtn").on("click", function() {
                $("#formTambahSoal").hide();
                $("#tambahSoalBtn").show();
                tinymce.remove("#elm_soal, #elm_j1, #elm_pembahasan, #elm_j2, #elm_j3, #elm_j4, #elm_j5");
            });

            // --- Tombol Batal Edit ---
            $("#batalEditBtn").on("click", function() {
                $("#formEditSoal").hide();
                $("#tambahSoalBtn").show();
                tinymce.remove(
                    "#edit_soal,#edit_pembahasan, #edit_j1, #edit_j2, #edit_j3, #edit_j4, #edit_j5");
            });
        });

        // --- Fungsi untuk buka form Edit ---
        function showEditForm(id, modul, soal, pembahasan, no, j1, j2, j3, j4, j5) {
            $("#formTambahSoal").hide();
            $("#formEditSoal").show();

            // Isi field biasa
            $("#edit_id").val(id);
            $("#edit_modul").val(modul);
            $("#edit_no").val(no);

            // Hapus editor lama jika ada
            tinymce.remove("#edit_soal, #edit_pembahasan,#edit_j1, #edit_j2, #edit_j3, #edit_j4, #edit_j5");

            // Inisialisasi ulang editor edit
            const fields = ["edit_soal", "edit_pembahasan", "edit_j1", "edit_j2", "edit_j3", "edit_j4", "edit_j5"];
            fields.forEach(idField => {
                tinymce.init({
                    selector: `#${idField}`,
                    menubar: false,
                    height: 200,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media",
                        "table emoticons paste"
                    ],
                    toolbar: "undo redo | styleselect | bold italic underline | " +
                        "alignleft aligncenter alignright alignjustify | " +
                        "bullist numlist outdent indent | link image | forecolor backcolor | code",

                    // --------------------------------------------------
                    // ⚡ BASE64 IMAGE (DRAG & DROP / COPY PASTE)
                    // --------------------------------------------------
                    automatic_uploads: true,
                    file_picker_types: 'image',
                    paste_data_images: true,

                    // Convert gambar ke base64
                    images_upload_handler: function(blobInfo, success, failure) {
                        const base64 = "data:" + blobInfo.blob().type + ";base64," + blobInfo.base64();
                        success(base64);
                    },
                    setup: function(editor) {
                        editor.on("init", function() {
                            switch (idField) {
                                case "edit_soal":
                                    editor.setContent(soal || "");
                                    break;
                                case "edit_pembahasan":
                                    editor.setContent(pembahasan || "");
                                    break;
                                case "edit_j1":
                                    editor.setContent(j1 || "");
                                    break;
                                case "edit_j2":
                                    editor.setContent(j2 || "");
                                    break;
                                case "edit_j3":
                                    editor.setContent(j3 || "");
                                    break;
                                case "edit_j4":
                                    editor.setContent(j4 || "");
                                    break;
                                case "edit_j5":
                                    editor.setContent(j5 || "");
                                    break;
                            }
                        });
                    }
                });
            });

            // Set action form edit
            $("#editSoalForm").attr("action", `/soal-multiple/${id}`);
        }
    </script>
</body>

</html>
