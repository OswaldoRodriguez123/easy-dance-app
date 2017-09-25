@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

<meta content='{{$taller->taller_nombre}}' property='og:title'/>
@if($taller->imagen)
<meta content="{{url('/')}}/assets/uploads/taller/{{$taller->imagen}}" property='og:image'/>
@endif

@if($taller->descripcion)
  <meta name="description" content="{{$taller->descripcion}}" />
  <meta property="og:description" content="{{$taller->descripcion}}" />
@else

  <meta name="description" content="{{$taller->taller_nombre}}" />
  <meta property="og:description" content="{{$taller->taller_nombre}}" />

@endif

@section('content')

<div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Condiciones y Normativas<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="configuracion_clase_personalizada" id="configuracion_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                                <div class="col-sm-12">
                                    
                                <div style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones"></p>

                                  </div>

                                </div>

                                <div class="col-sm-3" style="margin-left: 39%">

                                <input type="checkbox" id="condiciones" name="condiciones">  <span class="f-16 f-700 opaco-0-8">  Acepto los  términos</span> <br><br>

                                <div class="text-center">

                                  @if(Auth::check())

                                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                              <button type="button" class="btn btn-blanco m-r-10 f-20 guardar"> Inscribir</button>

                                            @else

                                              <button type="button" class="btn btn-blanco m-r-10 f-20 guardar"> Inscribirse</button>

                                            @endif

                                          @else

                                            <button type="button" class="btn btn-blanco m-r-10 f-20 guardar"> Reservar</button>

                                        @endif

                                </div>

                              </div>
                            

                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-12 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>

                        </div></form>
                    </div>
                </div>
            </div>

<div class="container">

  @if(Auth::check())

  <div class="block-header">

    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
    

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/talleres" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección talleres</a>
                      

    @else

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>

    @endif

  </div> 
  
@endif

    <div class="card" id="profile-main">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        @if($academia->imagen)
                          <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                        @else
                          <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                        @endif
                    </a>

                </div>

                <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                <ul class="rrssb-buttons clearfix">

                      <li class="rrssb-facebook">
                        <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header: https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/agendar/talleres/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>
                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Participa en el taller {{$taller->taller_nombre}} te invita @EasyDanceLatino {{url('/')}}/agendar/talleres/progreso/{{$id}}"
                        class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                          <span class="rrssb-text">twitter</span>
                        </a>
                      </li>
                    </ul>

            </div>

            <div class="pmo-block pmo-contact hidden-xs" style="padding-top:15px">
                            <p class="text-center f-18 f-700">Participantes</p>
                              <div class="clearfix"></div>

                              <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                <div class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;"></div>
                              </div>
                              <p class="text-center f-700" >{{$porcentaje}} % Inscritos</p>

                              <style type="text/css">
                                @import url(http://fonts.googleapis.com/css?family=Comfortaa);
                                #my-soon-watch-red {background-color:#030303;}
                                #my-soon-watch-red .soon-reflection {background-color:#030303;background-image:linear-gradient(#030303 25%,rgba(3,3,3,0));}
                                #my-soon-watch-red {color:#ffffff;}
                                #my-soon-watch-red .soon-label {color:#ffffff;color:rgba(255,255,255,0.75);}
                                #my-soon-watch-red {font-family:"Comfortaa",sans-serif;}
                                #my-soon-watch-red .soon-ring-progress {background-color:#410918;}
                                #my-soon-watch-red .soon-ring-progress {border-top-width:14px;}
                                #my-soon-watch-red .soon-ring-progress {border-bottom-width:13px;}
                            </style>
                            <div class="soon" id="my-soon-watch-red"
                                 data-layout="group tight label-uppercase label-small"
                                 data-format="d,h,m,s"
                                 data-face="slot"
                                 data-padding="false"
                                 data-visual="ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0">
                            </div>     

                            <div class="clearfix p-b-15"></div>

                      <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Datos Generales</div>
                          <div class="col-sm-12">
                          <div class="clearfix p-b-15"></div>
                            <label class="text-left opaco-0-8"><i class="zmdi zmdi-border-color zmdi-hc-fw f-18"></i> Cupos disponibles:</label>
                              <p class="text-left opaco-0-8 f-16" >

                                {{$cupos_restantes}}</p>

                               <hr class="linea-morada opaco-0-8">

                               <label class="text-left opaco-0-8"><i class="icon_b icon_b-costo f-22"></i>  Costo:</label>
                              <p class="text-left opaco-0-8 f-16">{{ number_format($taller->costo, 2, '.' , '.') }}</p>

                              <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8"><i class="zmdi zmdi-calendar f-22"></i>  Fecha de inicio:</label>
                              <p class="text-left opaco-0-8 f-16">{{$taller->fecha_inicio}}</p>

                              <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-especialidad f-22"></i> Especialidad:</label>
                              <p class="text-left opaco-0-8 f-16">{{$taller->especialidad_nombre}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-estudio-salon f-22"></i> Estudio salón:</label>
                              <p class="text-left f-16">{{$taller->estudio_nombre}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-instructor f-22"></i> Instructor:</label>
                              <p class="text-left f-16">{{$taller->instructor_nombre}} {{$taller->instructor_apellido}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="zmdi zmdi-alarm f-22"></i> Horarios:</label>
                              <p class="text-left f-16">{{$taller->hora_inicio}} - {{$taller->hora_final}}</p>

                             <!--  <p class="text-center">
                               
                                <a href="{{ empty($taller->facebook) ? '' : $taller->facebook}}" target="_blank"><i class="{{ empty($taller->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a href="{{ empty($taller->twitter) ? '' : $taller->twitter}}" target="_blank"><i class="{{ empty($taller->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a href="{{ empty($taller->instagram) ? '' : $taller->instagram}}" target="_blank"><i class="{{ empty($taller->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a href="{{ empty($taller->linkedin) ? '' : $taller->linkedin}}" target="_blank"><i class="{{ empty($taller->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a href="{{ empty($taller->youtube) ? '' : $taller->youtube}}" target="_blank"><i class="{{ empty($taller->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a href="{{ empty($taller->pagina_web) ? '' : $taller->pagina_web}}" target="_blank"><i class="{{ empty($taller->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p> -->
                          

                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                          <span class="text-center">
                             @if(Auth::check())

                                @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                  <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 reservar" style="width:100%; padding:5px"> </i>Inscribir</button>

                                @else

                                  <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 reservar" style="width:100%; padding:5px"> </i>Inscribirse</button>

                                @endif

                              @else

                                  <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 reservar" style="width:100%; padding:5px"> </i>Reservar</button>

                              @endif
                          </span>

                        </div>


                              

                              
            </div>

        </div>

        <div class="pm-body clearfix">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <ul class="tab-nav tn-justified" role="tablist">
                <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Taller</a></li>
                <li class="waves-effect"><a href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab">Reglamentos</a></li>
                @if(Auth::check())

                  @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                    <li class="waves-effect reservar"><a class ="reservar" aria-controls="faqs" role="tab" data-toggle="tab">Inscribir</a></li>

                  @else

                    <li class="waves-effect reservar"><a class ="reservar" aria-controls="faqs" role="tab" data-toggle="tab">Inscribirse</a></li>

                  @endif

                @else

                  <li class="waves-effect reservar"><a class ="reservar" aria-controls="faqs" role="tab" data-toggle="tab">Reservar</a></li>

                @endif

            </ul>
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

                      <p class="text-center f-25 f-700 opaco-0-8">Es hora de bailar y participar en el nuevo taller de</p>
                      <h2 class="text-center"> {{$taller->academia_nombre}} </h2>
                      <div class="p-b-15"></div>
                      <h4 class="text-center"> <i class="zmdi zmdi-pin zmdi-hc-fw c-morado-suave"></i> {{$taller->estado}} - {{$taller->direccion}}  </h4>


                        <div class="clearfix p-b-20"></div>
                        
                        @if($taller->imagen)
                          <img src="{{url('/')}}/assets/uploads/taller/{{$taller->imagen}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        @if($taller->descripcion)

                          <div class="f-700 f-30">Descripción</div>
                          <br>
                          <p class="f-14">{!! nl2br($taller->descripcion) !!}</p>

                        @endif

                        <!-- <p class="f-14">Easy Dance es una aplicación Online dirigida a la gestión de las academias de baile, con el propósito de organizar las actividades que involucran a: Directores de academias, instructores de baile, alumnos y todas aquellas personas interesadas en aprender a bailar de una manera más fácil. La aplicación se encuentra en una etapa temprana, hemos lanzado al mercado la primera fase del proyecto, en el que pondremos a prueba la adaptabilidad del mercado con el uso de las nuevas tecnologías. Nuestro equipo se encuentra laborando arduamente para ir incrementando las características de manera periódica y de ese modo ir creando de la aplicación una herramienta más completa que contribuya de manera sustancial con el ecosistema del baile.</p>

                        <p class="f-14">Easy dance se encuentra en un proceso de periodo de prueba (Fase Beta) completamente abierta para cualquier academia de baile que desee integrarse, haciendo uso y prueba de nuestro proyecto piloto. Por tal motivo invitamos a toda la comunidad de baile a participar generando invitaciones a todas aquellas academias que aún no conocen la herramienta.</p>

                        <p class="f-14">Así que los invitamos a estar muy atentos de todos nuestros avances, semanalmente estaremos haciendo nuevos anuncios de todas las características que se estarán actualizando dentro de la plataforma para el disfrute y organización en el ambiente del baile.</p> -->


                        @if($link_video)
                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>

                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{$link_video}}"></iframe>
                            </div>
                          </div>
                        @endif

                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>


                            <div class="col-sm-3" style="margin-left: 39%">

                                        <div class="text-center">

                                          @if(Auth::check())

                                          @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                            <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Inscribir</button>

                                            @else

                                              <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Inscribirse</button>

                                          @endif

                                          @else

                                            <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Reservar</button>

                                        @endif

                                        </div>

                                      </div>

                                      <div class="clearfix"></div>

                        


                    </div>

                </div>

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">

                    @if($taller->condiciones)

                        <div class="f-700 f-30">Reglamentos</div>
                        <br>
                        <p class="f-14">{!! nl2br($taller->condiciones) !!}</p>
                    @endif

                        <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>

                            <div class="col-sm-3" style="margin-left: 39%">

                                        <div class="text-center">

                                          @if(Auth::check())

                                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                              <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Inscribir</button>

                                            @else

                                              <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Inscribirse</button>

                                            @endif

                                          @else

                                            <button type="button" class="btn btn-blanco m-r-10 f-20 reservar"> Reservar</button>

                                        @endif

                                        </div>

                                      </div>

                                      <div class="clearfix"></div>

                        </div>
                    
                </div>


                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="faqs">

                 <div class="pmb-block m-t-0 p-t-0">

                        <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/caracteristicas-principal.jpg">

                        <div class="f-700 f-30">Easy Dance</div>
                        <br>

                        <p class="f-14">Easy dance llega con el objetivo resolver los problemas organizativos, que surgen a través de las múltiples características específicas en el ecosistema del baile , tales como , clases grupales y privadas , show de las compañías de baile , eventos de exhibición y competencia , graduaciones, inscripción , reserva y compra en línea ,presupuesto de montajes coreográficos ,entre otras actividades, que impactan en gran medida a nuestros gremio , que se ve afectado por la falta de herramientas organizacional .</p>

                        <div class="f-700 f-30">Misión</div>
                        <br>
                        <p class="f-14">Hacer del ecosistema del baile un mejor lugar, más organizado y transparente a nivel global, aprovechando el uso de la tecnología para brindar en gran medida valor a los usuarios, directores de academia, bailarines e instructores.</p>

                        <div class="f-700 f-30">Visión</div>
                        <br>
                        <p class="f-14">Easy dance trazará una nueva forma y estilo a nivel internacional, todos conectados en una gran comunidad, vemos a cientos de miles de persona compartiendo a través de la aplicación.</p>
                        <hr>
                        <div class="f-200 f-30">Resumen</div>
                        <br>
                        <p class="f-14">Easy Dance es una aplicación Online dirigida a la gestión de las academias de baile, con el propósito de organizar las actividades que involucran a: Directores de academias, instructores de baile, alumnos y todas aquellas personas interesadas en aprender a bailar de una manera más fácil. La aplicación se encuentra en una etapa temprana, hemos lanzado al mercado la primera fase del proyecto, en el que pondremos a prueba la adaptabilidad del mercado con el uso de las nuevas tecnologías. Nuestro equipo se encuentra laborando arduamente para ir incrementando las características de manera periódica y de ese modo ir creando de la aplicación una herramienta más completa que contribuya de manera sustancial con el ecosistema del baile.</p>

                        <p class="f-14">Easy dance se encuentra en un proceso de periodo de prueba (Fase Beta) completamente abierta para cualquier academia de baile que desee integrarse, haciendo uso y prueba de nuestro proyecto piloto. Por tal motivo invitamos a toda la comunidad de baile a participar generando invitaciones a todas aquellas academias que aún no conocen la herramienta.</p>

                        <p class="f-14">Así que los invitamos a estar muy atentos de todos nuestros avances, semanalmente estaremos haciendo nuevos anuncios de todas las características que se estarán actualizando dentro de la plataforma para el disfrute y organización en el ambiente del baile.</p>

                    </div>

                </div>

                </div>

                    <ul class="fw-footer pagination wizard">
                        <!--<li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                        <li class="previous"><a class="a-prevent" href=""><i class="zmdi zmdi-arrow-back"></i></a></li>
                        <li class="next"><a class="a-prevent" href=""><i class="zmdi zmdi-arrow-forward"></i></a></li>
                        <!--<li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                    </ul>

                    <footer id="footer" style="position:relative">

                          <div class=" p-10 footer-text">
                          <p> <b><a href="http://easydancelatino.com/" target="_blank" > www.easydancelatino.com </a></b></p> 


                          <p class="f-35" >
                              <a href="https://www.facebook.com/Easydancelatino/" target="_blank" title="Facebook">
                                  <i class="zmdi zmdi-facebook"></i>
                              </a>
                              <a href="https://www.instagram.com/easydancelatino/" target="_blank" title="Instagram">
                                  <i class="zmdi zmdi-instagram"></i>
                              </a>
                              <a href="https://twitter.com/EasyDanceLatino" target="_blank" title="Twitter" >
                                  <i class="zmdi zmdi-twitter" ></i>
                              </a> 
                              <a href="https://plus.google.com/u/0/104687135628887176910" target="_blank" title="Google+" >
                                  <i class="zmdi zmdi-google-plus"></i>
                              </a>
                          </p>

                          </div>

                      </footer><br><br>


            </div> <!-- Tab Content -->
            </div>
            </div><!-- Tab Nav end -->

            <!--<data ui-view></data>-->
        </div>
    </div>
</div>




@stop

@section('js') 
        

        <script src="{{url('/')}}/assets/js/soon.min.js" data-auto="false"></script>
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        route_reserva="{{url('/')}}/reservacion/";
        route_inscripcion= "{{url('/')}}/agendar/talleres/inscribirse"
        route_inscribir= "{{url('/')}}/agendar/talleres/participantes/{{$id}}"

        var recompensa = 0;
        var condiciones = <?php echo json_encode($taller->condiciones);?>;

            $(document).ready(function() {

              if("{{$inicio}}" == 1){
                $('.reservar').hide();
              }


              $("#pre_condiciones").html(nl2br(condiciones));

              $(".guardar").attr("disabled","disabled");

              $(".guardar").css({
                  "opacity": ("0.2")
              });

              $(".soon").soon({
                  due:"{{$taller->fecha_inicio}}",
                  //layout:"group"
                  layout:"group tight label-uppercase label-small",
                  format:"d,h,m,s",
                  face:"slot",
                  padding:"false",
                  visual:"ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0"
              });

              if("{{$porcentaje}}" >= 100){
                $("#barra-progreso").removeClass('progress-bar-morado');
                $("#barra-progreso").addClass('progress-bar-success');
              }else{
                $("#barra-progreso").removeClass('progress-bar-success');
                $("#barra-progreso").addClass('progress-bar-morado');
              }
          });

      function errores(merror){
        console.log(merror);
        var campo = ["alumno_id"];
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
       }

       $(".a-prevent").click(function(){

        $('body,html').animate({scrollTop : 0}, 500);


        });

      $("#condiciones").on('change', function(){
          if ($("#condiciones").is(":checked")){
             $(".guardar").removeAttr("disabled");
                           
             $(".guardar").css({
                "opacity": ("1")
             });
          }else{
            $(".guardar").attr("disabled","disabled");
            $(".guardar").css({
                "opacity": ("0.2")
            });
          }    
        });

      $(".reservar").click(function(){

          if("{{Auth::check()}}"){

            if(condiciones){

              if("{{$usuario_tipo}}" != 1 || "{{$usuario_tipo}}" != 5){

                $('#modalConfiguracion').modal('show');
              }else{
             $(".guardar").click();
              }
            }else{
             $(".guardar").click();
           }
          }else{
             $(".guardar").click();
        }

        });

      $(".guardar").click(function(){

        id = "{{$id}}";
        var token = $('input:hidden[name=_token]').val();
        

        if("{{Auth::check()}}")
        {
          if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6){

            procesando();

            window.location = route_inscribir;

            }else{

              swal({   
                    title: "Desea inscribirse en este taller?",   
                    text: "Confirmar inscripción!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Inscribirse!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   

                if (isConfirm) {

                procesando();

                var route = route_inscripcion;

                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                      dataType: 'json',
                      data:"&taller_id="+id,
                      success:function(respuesta){

                          swal("Exito!","Te has inscrito exitosamente","success");

                      },
                      error:function(msj){
     
                          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
                  });
                  finprocesado();
                  $('.modal').modal('hide');
              }
            });
          }
        }
        else{

           procesando();
           var route = route_reserva + 2;
                  
                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                      dataType: 'json',
                      data:"&tipo_reservacion=2",
                      success:function(respuesta){

                          window.location=route_reserva+id;  

                      },
                      error:function(msj){
                                  // $("#msj-danger").fadeIn(); 
                                  // var text="";
                                  // console.log(msj);
                                  // var merror=msj.responseJSON;
                                  // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                  // $("#msj-error").html(text);
                                  // setTimeout(function(){
                                  //          $("#msj-danger").fadeOut();
                                  //         }, 3000);
                                  swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                  }


                  });
                }
            });


        function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      }

            

        </script>
@stop        