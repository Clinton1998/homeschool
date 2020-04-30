@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
@endsection

@section('main-content')

<section class="ul-contact-detail">
    <h2 class="hs_titulo">Comunicados</h2>
    <div class="row">
        
        <div class="col-lg-12 col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right">Nuevo comunicado</button>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active show" id="nav-paratodo-tab" data-toggle="tab" href="#nav-paratodo" role="tab" aria-controls="nav-paratodo" aria-selected="true">Todos</a>
                            <a class="nav-item nav-link " id="nav-paradocentes-tab" data-toggle="tab" href="#nav-paradocentes" role="tab" aria-controls="nav-paradocentes" aria-selected="false">Solo docentes</a>
                            <a class="nav-item nav-link " id="nav-paraalumnos-tab" data-toggle="tab" href="#nav-paraalumnos" role="tab" aria-controls="nav-paraalumnos" aria-selected="false">Solo alumnos</a>
                        </div>
                    </nav>
                    <div class="tab-content ul-tab__content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-paratodo" role="tabpanel" aria-labelledby="nav-paratodo-tab">
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="card mt-3 mb-3">
                                        <div class="card-body">
                                            <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                                <div>
                                                    <h5 class="hs_upper"><a href="#">titulo</a></h5>
                                                    <p class="ul-task-manager__paragraph mb-3 text-justify hs_capitalize-first">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos, nobis! Cupiditate ullam est non sequi voluptatibus provident deleniti. Facere, tempora corrupti error at magnam pariatur nesciunt vel rerum molestias culpa?</p>
                                                </div>
    
                                                <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right;">
                                                    <li><span class="ul-task-manager__font-date text-muted">29/04/2020 19:00:00</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-paradocentes" role="tabpanel" aria-labelledby="nav-paradocentes-tab">
                            <h1>Comunicado para docentes</h1>
                        </div>

                        <div class="tab-pane fade" id="nav-paraalumnos" role="tabpanel" aria-labelledby="nav-paraalumnos-tab">
                            <h1>Comunicado para alumnos</h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('page-js')

@endsection