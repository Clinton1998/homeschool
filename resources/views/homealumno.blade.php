@extends('reutilizable.principal')

@section('page-css')
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
 <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">

@endsection
@section('main-content')

<h2 class="hs_titulo">!Bienvenido(a)!</h2>

<div class="row hs_contenedor">
    <div class="card  col col-lg-7 col-sm-12">
        <div class="card-body">
            <div class="alert alert-dark" role="alert">
                <h4>En esta sección encontrarás tus progresos académicos</h4>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
      <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v2.script.js')}}"></script>

@endsection

