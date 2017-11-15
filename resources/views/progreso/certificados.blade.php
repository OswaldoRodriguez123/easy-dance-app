@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/progreso" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">
                                    <div class="clearfix" style="margin-bottom: 50px"></div>
                                    
                                    <div class="col-sm-4"> 
                                        
                                        @if(Auth::user()->imagen)
                                            <img id="foto_perfil" class="img-circle img-responsive" src="{{url('/')}}/assets/uploads/usuario/{{Auth::user()->imagen}}" alt="" width="75px" height="auto">  
                                        @else
                                         @if(Auth::user()->sexo=='F')
                                              <img id="foto_perfil" class="img-circle img-responsive" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="" width="75px" height="auto">        
                                           @else
                                              <img id="foto_perfil" class="img-circle img-responsive" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="" width="75px" height="auto">
                                           @endif
                                        @endif

                                        <span class="f-14">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</span>
                                    </div>

                                    <div class="clearfix m-b-20"></div>


                                    <div class="col-sm-3 text-center">
                                        <div id="basico" class="opaco-0-2 certificados">
                                        <div id="certificado_estrellas" class="rating-list text-center">
                                            <div class="rl-star">
                                                <span id="certificado_puntaje" class="f-15 m-r-5"></span>
                                                <i id="certificado_estrella_1" class="zmdi zmdi-star active"></i>
                                                <i id="certificado_estrella_2" class="zmdi zmdi-star active"></i>
                                                <i id="certificado_estrella_3" class="zmdi zmdi-star active"></i>
                                                <i id="certificado_estrella_4" class="zmdi zmdi-star active"></i>
                                                <i id="certificado_estrella_5" class="zmdi zmdi-star active"></i>
                                       
                                            </div>
                                        </div>
                                            <div class="clearfix"></div>

                                            <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/basico.jpg"></img>

                                        </div>

                                        <span id="basico_span">Por alcanzar</span>
                                        <br>
                                        <i id="basico_icon" class="zmdi zmdi-dot-circle c-amarillo f-20 opaco-0-5"></i>
                                    </div>

                                    <div class="col-sm-3 text-center">
                                        <div id="intermedio" class="opaco-0-2 certificados">
                                            <div class="clearfix"></div>

                                            <div id="certificado_estrellas" class="rating-list text-center">

                                                <div class="rl-star">
                                                    <span id="certificado_puntaje" class="f-15 m-r-5"></span>
                                                    <i id="certificado_estrella_1" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_2" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_3" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_4" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_5" class="zmdi zmdi-star active"></i>
                                           
                                                </div>
                                            </div>

                                            <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/intermedio.jpg"></img>

                                        </div>
                                        <span id="intermedio_span">Por alcanzar</span>
                                        <br>
                                        <i id="intermedio_icon" class="zmdi zmdi-dot-circle c-amarillo f-20 opaco-0-5"></i>
                                    </div>

                                    <div class="col-sm-3 text-center">
                                        <div id="avanzado" class="opaco-0-2 certificados">
                                            <div class="clearfix"></div>

                                            <div id="certificado_estrellas" class="rating-list text-center">

                                                <div class="rl-star">
                                                    <span id="certificado_puntaje" class="f-15 m-r-5"></span>
                                                    <i id="certificado_estrella_1" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_2" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_3" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_4" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_5" class="zmdi zmdi-star active"></i>
                                           
                                                </div>
                                            </div>

                                            <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/avanzado.jpg"></img>

                                        </div>
                                        <span id="avanzado_span">Por alcanzar</span>
                                        <br>
                                        <i id="avanzado_icon" class="zmdi zmdi-dot-circle c-amarillo f-20 opaco-0-5"></i>
                                    </div>

                                    <div class="col-sm-3 text-center">
                                        <div id="master" class="opaco-0-2 certificados">
                                            <div class="clearfix"></div>

                                            <div id="certificado_estrellas" class="rating-list text-center">

                                                <div class="rl-star">
                                                    <span id="certificado_puntaje" class="f-15 m-r-5"></span>
                                                    <i id="certificado_estrella_1" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_2" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_3" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_4" class="zmdi zmdi-star active"></i>
                                                    <i id="certificado_estrella_5" class="zmdi zmdi-star active"></i>
                                           
                                                </div>
                                            </div>

                                            <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/master.jpg"></img>

                                        </div>
                                        <span id="master_span">Por alcanzar</span>
                                        <br>
                                        <i id="master_icon" class="zmdi zmdi-dot-circle c-amarillo f-20 opaco-0-5"></i>
                                    </div>

                                    <div class="clearfix m-b-30"></div>

                                    <div class="col-sm-4 col-sm-offset-4 text-center">

                                        <span class="f-14 opaco-0-8 f-700">
                                        <span id="barra_span">{{$porcentaje}}</span> % COMPLETADA</span>
                                    
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43; height: 15px";>
                                            <div id="barra_progreso" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;">
                                            </div>
                                        </div>

                                    </div>
                                  
                                 
                                <br><br><br>
                            
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

        route_certificado="{{url('/')}}/certificado/";

        $(document).ready(function(){

            if("{{$porcentaje}}" == "25"){
                $('#basico').removeClass('opaco-0-2')
                $('#basico').addClass('pointer')
                $('#basico').attr('hash', "{{$basico}}")
                $('#basico_span').text('Alcanzado')
                $('#basico_icon').removeClass('zmdi-dot-circle c-amarillo f-20 opaco-0-5')
                $('#basico_icon').addClass('zmdi-check c-verde f-30')
            }

            if("{{$porcentaje}}" == "50"){
                $('#intermedio').removeClass('opaco-0-2')
                $('#intermedio').addClass('pointer')
                $('#intermedio').attr('hash', "{{$intermedio}}")
                $('#intermedio_span').text('Alcanzado')
                $('#intermedio_icon').removeClass('zmdi-dot-circle c-amarillo f-20 opaco-0-5')
                $('#intermedio_icon').addClass('zmdi-check c-verde f-30')
            }

            if("{{$porcentaje}}" == "75"){
                $('#avanzado').removeClass('opaco-0-2')
                $('#avanzado').addClass('pointer')
                $('#avanzado').attr('hash', "{{$avanzado}}")
                $('#avanzado_span').text('Alcanzado')
                $('#avanzado_icon').removeClass('zmdi-dot-circle c-amarillo f-20 opaco-0-5')
                $('#avanzado_icon').addClass('zmdi-check c-verde f-30')
            }

            if("{{$porcentaje}}" == "100"){

                $('#master').removeClass('opaco-0-2')
                $('#master').addClass('pointer')
                $('#master').attr('hash', "{{$master}}")
                $('#master_span').text('Alcanzado')
                $('#master_icon').removeClass('zmdi-dot-circle c-amarillo f-20 opaco-0-5')
                $('#master_icon').addClass('zmdi-check c-verde f-30')

                $("#barra-progreso").removeClass('progress-bar-morado');
                $("#barra-progreso").addClass('progress-bar-success');
            }

        });

        $(".certificados").click(function(){
            hash = $(this).attr('hash')
            var route = route_certificado + hash;
            window.open(route, '_blank');
        });

     </script>

@stop