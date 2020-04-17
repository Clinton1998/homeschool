@extends('reutilizable.principal')

@section('main-content')
            <div class="row mb-4">
                <div class="col-md-12 mb-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pendientes-basic-tab" data-toggle="tab" href="#pendientesBasic" role="tab" aria-controls="pendientesBasic" aria-selected="true">Pendientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="por-vencer-basic-tab" data-toggle="tab" href="#porvencerBasic" role="tab" aria-controls="porvencerBasic" aria-selected="false">Por vencer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="vencidos-basic-tab" data-toggle="tab" href="#vencidosBasic" role="tab" aria-controls="vencidosBasic" aria-selected="false">Vencidos</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" id="enviados-basic-tab" data-toggle="tab" href="#enviadosBasic" role="tab" aria-controls="enviadosBasic" aria-selected="false">Enviados</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="completados-basic-tab" data-toggle="tab" href="#completadosBasic" role="tab" aria-controls="completadosBasic" aria-selected="false">Calificados</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pendientesBasic" role="tabpanel" aria-labelledby="pendientes-basic-tab">
                                    
                                    @include('layouts.taskmanager.alumno.pendientes')

                                        
                                </div>
                                <div class="tab-pane fade" id="porvencerBasic" role="tabpanel" aria-labelledby="por-vencer-basic-tab">
                                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.
                                </div>
                                <div class="tab-pane fade" id="vencidosBasic" role="tabpanel" aria-labelledby="vencidos-basic-tab">
                                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.
                                </div>

                                <div class="tab-pane fade" id="enviadosBasic" role="tabpanel" aria-labelledby="enviados-basic-tab">
                                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.
                                </div>

                                <div class="tab-pane fade" id="completadosBasic" role="tabpanel" aria-labelledby="completados-basic-tab">
                                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.
                                </div>
                            </div>
                      
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->


         
@endsection

@section('page-js')

@endsection
