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
        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
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
                                                <h2 class="ca-main-planilla">Manuales de Procedimientos</h2>
                                                <h3 class="ca-sub-planilla">Sección de procedimientos</h3>
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

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">COORDINACIÓN DE PISTA</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/coordinacion de pista.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">PRODUCTORA DE EVENTOS</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/productora de eventos.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">VENTAS</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/ventas.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">SUPERVISOR</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/supervisor.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">RECEPCIONISTA</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/recepcionista.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">INSTRUCTORES</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/instructores.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">ADMINISTRATIVO</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/administrativo.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">GENERAR AMBIENTE</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/generar ambiente.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">ROLES DE LA APLICACIÓN</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/roles de la aplicacion.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">GUÍA DE ATENCIÓN AL CLIENTE</strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/assets/uploads/procedimientos/guia de atencion al cliente.docx" class="f-18 p-t-0 c-morado pointer"> Ver Procedimientos</a>
                                        </div>
                                    </div>
                                </div>
                           

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop