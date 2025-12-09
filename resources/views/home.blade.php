@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <div class="page-title">
                                        <h4 class="mb-0 font-size-18">Form Editors</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Agroxa</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Form Editors</li>
                                        </ol>
                                    </div>

                                    <div class="state-information d-none d-sm-block">
                                        <div class="state-graph">
                                            <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                                            <div class="info">Balance $ 2,317</div>
                                        </div>
                                        <div class="state-graph">
                                            <div id="header-chart-2" data-colors='["--bs-warning"]'></div>
                                            <div class="info">Item Sold 1230</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- Start Page-content-Wrapper -->
                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">Tinymce wysihtml5</h4>
                                            <p class="card-title-desc">Bootstrap-wysihtml5 is a javascript plugin that makes it
                                                easy to create simple, beautiful wysiwyg editors with the help of wysihtml5 and
                                                Twitter Bootstrap.</p>

                                            <form method="post">
                                                <textarea id="elm1" name="area"></textarea>
                                            </form>

                                        </div>
                                        <!-- End Cardbody -->
                                    </div>
                                    <!-- End Card-->
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->



                        </div>
                        <!-- End Page-content -->

                    </div>
                    <!-- Container-Fluid -->
                </div>
@endsection