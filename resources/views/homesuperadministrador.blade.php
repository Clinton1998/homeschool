@extends('reutilizable.principal')

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
@endsection

@section('main-content')

<h2 class="hs_titulo">Bienvenido a panel de administrador</h2>

<div class="row hs_contenedor">
    <div class="card">
        <div class="card-body">
        </div>
    </div>
</div>

<div>

</div>

@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v3.script.js')}}"></script>

@endsection
