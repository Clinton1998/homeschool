@extends('reutilizable.principal')

@section('page-css')
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection
@section('main-content')
       <!--<div class="breadcrumb">
                <h1>Version 2 Alumno</h1>
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li>Version 2</li>
                </ul>
            </div>
            <div class="separator-breadcrumb border-top"></div>-->
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- CARD ICON -->
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Data-Upload"></i>
                                    <p class="text-muted mt-2 mb-2">Tareas pendientes</p>
                                    <p class="text-primary text-24 line-height-1 m-0">21</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Add-User"></i>
                                    <p class="text-muted mt-2 mb-2">Tareas enviados</p>
                                    <p class="text-primary text-24 line-height-1 m-0">21</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Money-2"></i>
                                    <p class="text-muted mt-2 mb-2">Tareas completados</p>
                                    <p class="text-primary text-24 line-height-1 m-0">4021</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon-big mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Money-2"></i>
                                    <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon-big mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Gear"></i>
                                    <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-icon-big mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Bell"></i>
                                    <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <h5 class="card-title m-0 p-3">Sales</h5>
                            <div id="echart4" style="height: 300px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of row-->
@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
      <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v2.script.js')}}"></script>

@endsection

