@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>

@stop

@section('content')

<div class="container">

    <div class="block-header">
        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                
                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                
                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                
                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                               
                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                
            </ul>
        @else
            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
        @endif
    </div> 
    
    <div class="card">
                <div class="card-body p-b-20">
                    <div class="row">
                        <div class="container">
                          <div class="col-sm-3">
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a icon_a-tutoriales"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Normativas</h2>
                                                <h3 class="ca-sub-planilla">Sección de normativas</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>


                                    
                                   
                                </div>

                                </div>                
                              </div>
                                    
                          </div>

                        <div class="pm-body clearfix col-sm-9">
                            <div class="timeline">
                                
                                @foreach($normativas as $normativa)
                                    <div class="t-view" data-tv-type="text">
                                        <div class="tv-header media">
                                            <a href="" class="tvh-user pull-left">
                                                <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                            </a>
                                            <div class="media-body p-t-5">
                                                <strong class="d-block f-20">{{$normativa->nombre}}</strong>

                                            </div>
                                        </div>
                                        <div class="tv-body">
                   
                                        
                                            <div class="clearfix"></div>
                                            
                                            <br>

                                            <div class="text-right">

                                                
                                                <a href="{{url('/')}}/assets/uploads/normativas/{{$normativa->nombre}}-{{$id}}.pdf" target="_blank" class="f-18 p-t-0 c-morado pointer"> Ver Normativa</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop