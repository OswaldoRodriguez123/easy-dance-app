@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
    <!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet"> -->


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

@section('content')
<a href="{{url('/')}}/agendar" class="btn bgm-blue btn-float waves-effect m-btn" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="" title="" data-original-title="Calendario"><i class="zmdi zmdi-calendar"></i></a>
<div class="container">
    <div class="card">
    <div class="card-body p-b-20">
      <div class="row p-l-10 p-r-10">
      <div class="col-sm-12">


      @if($instructor->imagen_artistica)

        <img class="opaco-0-8 img-responsive" src="{{url('/')}}/assets/uploads/instructor/{{$instructor->imagen_artistica}}" alt="">

      @else
        
        <img class="opaco-0-8 img-responsive" src="{{url('/')}}/assets/img/banner_tuclasedebaile.jpg" alt="">

      @endif

      </div>
          <div class="col-sm-3" style="background: #f8f8f8 ; margin-left: 5px; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px">
                 
              <div class="pmo-block pmo-contact hidden-xs">
                  
                   <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                      <div class="header_cuadro_alumno_borde_morado text-left f-16 f-700">Agendar</div>
                    
                      <div class ="detalle clase_grupal" style="margin-top:10px">
                        <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clases-grupales f-20"></i> Clases Grupales <span style ="padding-right:5px" class ="pull-right opaco-0-8"></span></a> 
                      </div>
                      
                      <div class ="detalle ciclos">
                        <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clase-personalizada f-20"></i> Nivelar Ciclos <span style ="padding-right:5px" class ="pull-right opaco-0-8"></span></a>
                      </div>

                      <div class ="detalle progreso">
                        <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-talleres f-20"></i> Progreso de clases <span style ="padding-right:5px" class ="pull-right opaco-0-8"></span></a>
                      </div>

                      <div class ="detalle valoracion">
                        <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-examen f-20"></i> Valoración <span style ="padding-right:5px" class ="pull-right opaco-0-8"></span></a>
                      </div>

                      <div class="clearfix p-b-15"></div>


                      <div class="clearfix p-b-15"></div>
                      <div class="clearfix p-b-15"></div>
                      <div class="clearfix p-b-15"></div>


                    </div> <!-- AGENDAR -->


        
            
   
                </div>

              </div>
            </div>

          
          <div class="col-sm-6" style="width:49%">

          <div class="col-xs-12 text-left">
            <ul class="tab-nav tn-justified" role="tablist">
              <li class="waves-effect"><a href="{{url('/')}}/pagos" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Administrativo</p></a></li>
              <li class="waves-effect"><a href="{{url('/')}}/asistencia" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Asistencia</p></a></li>
              <li class="waves-effect"><a href="{{url('/')}}/procedimientos" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Procedimientos</p></a></li>
            </ul>
          </div>

           
            </div>
                        

            <div class="col-sm-3" style="background: #f8f8f8 ; margin-right: 5px; float:right; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px;">
                <div class="pmo-block pmo-contact hidden-xs">

                 <div class="p-relative">
                        @if($instructor->imagen)

                        <img class="opaco-0-8 img-responsive img-circle" src="{{url('/')}}/assets/uploads/instructor/{{$instructor->imagen}}" alt="">

                      @else
                        
                        <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">

                      @endif

                </div>


                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                    <div class="pmo-block pmo-contact hidden-xs">

                    <h2 style="font-size: 16px; margin: 0 0 15px">Contacto</h2>

                    <ul>
                        <li><i class="zmdi zmdi-email"></i> <a class ="enlace_gris" href="mailto:{{$instructor->correo}}" target="_blank">{{$instructor->correo}}</a></li>
                        
                        @if($instructor->facebook)
                          @if (!filter_var($instructor->facebook, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="{{$instructor->facebook}}">{{ str_limit($instructor->facebook, $limit = 25, $end = '...') }}</a></li>
                          @else
                            <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="https://www.facebook.com/{{$instructor->facebook}}">https://www.facebook.com/...</a></li>
                          @endif
                        @endif

                        @if($instructor->twitter)

                          @if (!filter_var($academia->twitter, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="{{$instructor->twitter}}">https://www.twitter.com/{{$instructor->twitter}}</a></li>
                          @else
                            <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="https://www.twitter.com/{{$instructor->twitter}}">@ {{$instructor->twitter}}</a></li>
                          @endif
                        @endif

                        @if($instructor->instagram)
                          @if (!filter_var($academia->instagram, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="{{$instructor->instagram}}">{{$instructor->instagram}}</a></li>
                          @else
                            <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="https://www.instagram.com/{{$instructor->instagram}}">@ {{$instructor->instagram}}</a></li>
                          @endif
                        @endif

                        @if($instructor->linkedin)
                        <li><i class="zmdi zmdi-linkedin-box"></i> <a class ="enlace_gris" href="{{$instructor->linkedin}}">Linkedin</a></li>
                        @endif

                        @if($instructor->youtube)
                        <li><i class="zmdi zmdi-collection-video"></i> <a class ="enlace_gris" href="{{$instructor->youtube}}">Youtube</a></li>
                        @endif

                        @if($instructor->pagina_web)
                        <li><i class="zmdi zmdi-google-earth"></i> <a class ="enlace_gris" href="{{$instructor->pagina_web}}">Pagina Web</a></li>
                        @endif

                        @if($instructor->direccion)
                        <li>
                            <i class="zmdi zmdi-pin"></i>
                            <address class="m-b-0 ng-binding">
                                {{$instructor->direccion}}
                            </address>
                        </li>
                        @endif

                        @if($instructor->celular)
                        <li>
                            <i class="icon_b-telefono"></i>
                                {{$instructor->celular}} - {{$instructor->telefono}}
                        </li>
                        @endif
                    </ul>

                    <div class="clearfix p-b-15"></div>

                    
                  </div>

                    <div class="clearfix p-b-15"></div>
                  </div>

              </div>
            </div>
            </div>
        </div>
    </div>
</div>




@stop

@section('js') 
        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>

        <script type="text/javascript">

          $(".evaluaciones").click(function(){
            procesando();
            window.location = "{{url('/')}}/evaluaciones";
          });

          $(".clase_grupal").click(function(){
            procesando();
            window.location = "{{url('/')}}/clases-grupales";
          });

          $(".ciclos").click(function(){
            procesando();
            window.location = "{{url('/')}}/nivelaciones";
          });

          $(".progreso").click(function(){
            procesando();
            window.location = "{{url('/')}}/programaciones";
          });

          $(".valoracion").click(function(){
            procesando();
            window.location = "{{url('/')}}/especiales/examenes";
          });

        </script>
@stop        