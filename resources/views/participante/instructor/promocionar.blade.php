@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop


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

                                  <button type="button" class="btn btn-blanco m-r-10 f-14 guardar">Reservar</button>

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


            <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Ups! <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row">

                        <div class="col-sm-10 col-sm-offset-1">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> Este instructor no se encuentra disponible en este momento. </div>


                         </div>

                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>


                        </div>
                       


                        </div>
                       
                    </div>
                </div>
            </div>


<div class="container">

@if(Auth::check())

  <div class="block-header">

    @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
    

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/instructor" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección instructores</a>
                      

    @else

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/instructores" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección instructores</a>

    @endif

  </div> 
  
@endif

    <div class="card" id="profile-main">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        @if($instructores_academia->imagen)
                          <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/uploads/instructor/{{$instructores_academia->imagen}}" alt="">
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
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/agendar/clases-personalizadas/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>
                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Participa en las clases personalizadas te invita {{$academia->nombre}} {{url('/')}}/agendar/clases-personalizadas/progreso/{{$id}}"
                        class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                          <span class="rrssb-text">twitter</span>
                        </a>
                      </li>
                    </ul>

                    <div class="clearfix p-b-15"></div>

                    <div class="pmo-block pmo-contact hidden-xs">

                    <h2>Contacto</h2>

                    <ul>
                        <li>
                            <i class="icon_a-instructor"></i>
                                {{$instructores_academia->nombre}} {{$instructores_academia->apellido}}
                        </li>

                        <li><i class="zmdi zmdi-email"></i> <a class ="enlace_gris" href="mailto:{{$instructores_academia->correo}}" target="_blank">{{$instructores_academia->correo}}</a></li>

                        <!-- @if($academia->facebook)
                        <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="{{$academia->facebook}}">Facebook</a></li>
                        @endif

                        @if($academia->twitter)
                        <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="{{$academia->twitter}}">Twitter</a></li>
                        @endif

                        @if($academia->instagram)
                        <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="{{$academia->instagram}}">Instagram</a></li>
                        @endif

                        @if($academia->linkedin)
                        <li><i class="zmdi zmdi-linkedin-box"></i> <a class ="enlace_gris" href="{{$academia->linkedin}}">Linkedin</a></li>
                        @endif

                        @if($academia->youtube)
                        <li><i class="zmdi zmdi-collection-video"></i> <a class ="enlace_gris" href="{{$academia->youtube}}">Youtube</a></li>
                        @endif

                        @if($academia->pagina_web)
                        <li><i class="zmdi zmdi-google-earth"></i> <a class ="enlace_gris" href="{{$academia->pagina_web}}">Pagina Web</a></li>
                        @endif -->

                        @if($instructores_academia->facebook)
                        <li><a name="facebook" id="facebook" class ="enlace_gris" href="{{ empty($instructores_academia->facebook) ? '' : $instructores_academia->facebook}}" target="_blank"><i class="zmdi zmdi-facebook-box"></i> Facebook</a></li>
                        @endif

                        @if($instructores_academia->twitter)
                          <li><a name="twitter" id="twitter" class ="enlace_gris" href="{{ empty($instructores_academia->twitter) ? '' : $instructores_academia->twitter}}" target="_blank"><i class="zmdi zmdi-twitter"></i> Twitter</a></li>
                        @endif


                        @if($instructores_academia->instagram)
                          <li><a name="instagram" id="instagram" class ="enlace_gris" href="{{ empty($instructores_academia->instagram) ? '' : $instructores_academia->instagram}}" target="_blank"><i class="zmdi zmdi-instagram"></i> Instagram</a></li>
                        @endif

                        @if($instructores_academia->linkedin)
                          <li><a name="linkedin" id="linkedin" class ="enlace_gris" href="{{ empty($instructores_academia->linkedin) ? '' : $instructores_academia->linkedin}}" target="_blank"><i class="zmdi zmdi-linkedin-box"></i> Linkedin</a></li>
                        @endif

                        @if($instructores_academia->youtube)

                          <li><a name="youtube" id="youtube" class ="enlace_gris" href="{{ empty($instructores_academia->youtube) ? '' : $instructores_academia->youtube}}" target="_blank"><i class="zmdi zmdi-collection-video"></i> Youtube</a></li>


                        @endif

                        @if($instructores_academia->pagina_web)

                          <li><i class="zmdi zmdi-google-earth"></i> <a class="enlace_gris" name="pagina_web" id="pagina_web" href="{{ empty($instructores_academia->pagina_web) ? '' : $instructores_academia->pagina_web}}" target="_blank"><i class="zmdi zmdi-google-earth"></i> Pagina Web</a></li>

                        @endif

                        @if($instructores_academia->direccion)
                        <li>
                            <i class="zmdi zmdi-pin"></i>
                            <address class="m-b-0 ng-binding">
                                {{$instructores_academia->direccion}}
                            </address>
                        </li>
                        @endif

                        @if($instructores_academia->celular)
                        <li>
                            <i class="icon_b-telefono"></i>
                                {{$instructores_academia->celular}} - {{$instructores_academia->telefono}}
                        </li>
                        @endif
                    </ul>

                    </div>

                    <div class="clearfix p-b-15"></div>


                     <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu pointer">
                                    <li>
                                        <a class ="reservar">
                                            <span class="ca-icon"><i class="icon_a-clase-personalizada"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Reserva tu Clase Personalizada</h2>
                                                <h3 class="ca-sub">Activate ya!</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>
                          </div>

            </div>
            
            <div class="clearfix"></div>
                      

            

        </div>

        <div class="pm-body clearfix">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">


                          @if($instructores_academia->imagen_artistica)
                          <img name="imagen_artistica" id="imagen_artistica" src="{{url('/')}}/assets/uploads/instructor/{{$instructores_academia->imagen_artistica}}" class="img-responsive opaco-0-8" alt="">
                          @endif
                        

                        <div class="clearfix p-b-20"></div>

                        @if($instructores_academia->tiempo_experiencia_instructor != '')

                        <div class="f-700 f-30">Experiencia laboral como instructor </div>
                        <hr class="linea-morada">

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="tiempo_experiencia_instructor" id ="tiempo_experiencia_instructor"> {{$instructores_academia->tiempo_experiencia_instructor}}</div>
                            <span class="span_circulo"> Años de experiencia</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="genero_instructor" id ="genero_instructor"> {{$instructores_academia->genero_instructor}}</div>
                            <span class="span_circulo"> Géneros que domina</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="cantidad_horas" id ="cantidad_horas"> {{$instructores_academia->cantidad_horas}}</div>
                            <span class="span_circulo"> Horas impartidas</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="titulos_instructor" id ="titulos_instructor"> {{$instructores_academia->titulos_instructor}}</div>
                            <span class="span_circulo"> Títulos y reconocimientos </span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="organizador" id ="organizador"> {{$instructores_academia->organizador}}</div>
                            <span class="span_circulo"> Organizador de eventos</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="invitacion_evento" id ="invitacion_evento"> {{$instructores_academia->invitacion_evento}}</div>
                            <span class="span_circulo"> Invitaciones a eventos</span>
                          </div>
                          

                        <hr class="linea-morada">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        @if($instructores_academia->descripcion)

                        <div class="f-700 f-30">Perfil del instructor</div>
                        <hr class="linea-morada">
                        <p class="f-14" name="descripcion_instructor" id="descripcion_instructor">


                        {!! nl2br($instructores_academia->descripcion) !!}

                        </p>

                        @endif

                        <!-- <p class="text-center">
                               
                                <a name="facebook" id="facebook" href="{{ empty($instructores_academia->facebook) ? '' : $instructores_academia->facebook}}" target="_blank"><i class="{{ empty($instructores_academia->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a name="twitter" id="twitter" href="{{ empty($instructores_academia->twitter) ? '' : $instructores_academia->twitter}}" target="_blank"><i class="{{ empty($instructores_academia->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a name="instagram" id="instagram" href="{{ empty($instructores_academia->instagram) ? '' : $instructores_academia->instagram}}" target="_blank"><i class="{{ empty($instructores_academia->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a name="linkedin" id="linkedin" href="{{ empty($instructores_academia->linkedin) ? '' : $instructores_academia->linkedin}}" target="_blank"><i class="{{ empty($instructores_academia->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a name="youtube" id="youtube" href="{{ empty($instructores_academia->youtube) ? '' : $instructores_academia->youtube}}" target="_blank"><i class="{{ empty($instructores_academia->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a name="pagina_web" id="pagina_web" href="{{ empty($instructores_academia->pagina_web) ? '' : $instructores_academia->pagina_web}}" target="_blank"><i class="{{ empty($instructores_academia->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p> -->


                          <!-- <div class="clearfix p-b-20"></div> -->

                          @if($instructores_academia->video_promocional)

                          <?php $parts = parse_url($instructores_academia->video_promocional);
                                $partes = explode( '=', $parts['query'] );
                                $video_promocional = $partes[1]; ?>

                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>

                            <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                              <div class="embed-responsive embed-responsive-4by3" name="video_promocional_frame" id="video_promocional_frame">
                                <iframe name="video_promocional" id="video_promocional" class="embed-responsive-item" src="http://www.youtube.com/embed/{{$video_promocional}}"></iframe>
                              </div>
                            </div>
                          @endif

                        <div class="clearfix p-b-20"></div>

                        @if($instructores_academia->tiempo_experiencia_bailador != '')


                        <div class="f-700 f-30">Experiencia como bailarín </div>
                        <hr class="linea-morada">


                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="tiempo_experiencia_bailador" id ="tiempo_experiencia_bailador"> {{$instructores_academia->tiempo_experiencia_bailador}}</div>
                            <span class="span_circulo"> Años de experiencia</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="genero_bailador" id ="genero_bailador"> {{$instructores_academia->genero_bailador}}</div>
                            <span class="span_circulo"> Géneros que domina</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="participacion_coreografia" id ="participacion_coreografia"> {{$instructores_academia->participacion_coreografia}}</div>
                            <span class="span_circulo text-center"> Participación en coreografías</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="montajes" id ="montajes"> {{$instructores_academia->montajes}}</div>
                            <span class="span_circulo"> Montajes coreográficos </span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="titulos_bailador" id ="titulos_bailador"> {{$instructores_academia->titulos_bailador}}</div>
                            <span class="span_circulo"> Títulos y reconocimientos</span>
                          </div>

                          <div class="container_circulo">
                            <div class="circulo_instructor f-700" name ="participacion_escenario" id ="participacion_escenario"> {{$instructores_academia->participacion_escenario}}</div>
                            <span class="span_circulo text-center"> Participación en escenarios y shows</span>
                          </div>
                          
                        <hr class="linea-morada">

                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        @if($instructores_academia->resumen_artistico)
                        

                          <div class="f-700 f-30">Resumen artístico</div>
                          <hr class="linea-morada">
                          <p class="f-14" name="resumen_artistico" id="resumen_artistico">


                          {!! nl2br($instructores_academia->resumen_artistico) !!}


                          </p>
                        
                        @endif
    
                          @if($instructores_academia->video_testimonial)

                          <div class="clearfix p-b-20"></div>
                          <div class="clearfix p-b-20"></div>

                          <?php $parts = parse_url($instructores_academia->video_testimonial);
                                $partes = explode( '=', $parts['query'] );
                                $video_testimonial = $partes[1]; ?>

                            <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                              <div class="embed-responsive embed-responsive-4by3" name="video_testimonial_frame" id="video_testimonial_frame">
                                <iframe name="video_testimonial" id="video_testimonial" class="embed-responsive-item" src="http://www.youtube.com/embed/{{$video_testimonial}}"></iframe>
                              </div>
                            </div>
                          @endif

                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>

                        <div class="col-sm-3" style="margin-left: 35%">


                                <div class="text-center">

                                  <a class="btn btn-blanco m-r-10 f-20 reservar"> ¡ Quiero Reservar Ya ! </a>

                                </div>

                              </div>

                        

                    </div>
                </div>


                </div>

                    <ul class="fw-footer pagination wizard">
                        <!--<li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                        <li class="previous"><a class="a-prevent" href=""><i class="zmdi zmdi-arrow-back"></i></a></li>
                        <li class="next"><a class="a-prevent" href=""><i class="zmdi zmdi-arrow-forward"></i></a></li>
                        <!--<li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                    </ul>

                    

                        <div class="clearfix"></div>

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
        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        console.log("{{$instructores_academia->id}}");

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

       $(".reservar").click(function(){

        if("{{$instructores_academia->boolean_disponibilidad}}" == 1)
        {



          procesando();

           var route = "{{url('/')}}/instructores/sesion";
           var token = "{{ csrf_token() }}";
                  
                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                      dataType: 'json',
                      data:"&instructor_id={{$instructores_academia->id}}",
                      success:function(respuesta){

                          window.location = "{{url('/')}}/agendar/clases-personalizadas/disponibles/{{$academia->id}}" 

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

                }else{

                  $('#modalError').modal('show');

                }


        });


       $(".instructor").click(function(){

        $(".tab_instructor").click();

          id = this.id;

          var instructores = <?php echo json_encode($instructores_academia);?>;

          var instructor = $.grep(instructores, function(e){ return e.id == id; });

          $.each(instructor, function (index, array) {

            $("#descripcion_instructor").html(nl2br(array.descripcion));
            $("#resumen_artistico").html(nl2br(array.resumen_artistico));

            $("#tiempo_experiencia_instructor").html(array.tiempo_experiencia_instructor);
            $("#genero_instructor").html(array.genero_instructor);
            $("#cantidad_horas").html(array.cantidad_horas);
            $("#titulos_instructor").html(array.titulos_instructor);
            $("#invitacion_evento").html(array.invitacion_evento);
            $("#organizador").html(array.organizador);

            $("#tiempo_experiencia_bailador").html(array.tiempo_experiencia_bailador);
            $("#genero_bailador").html(array.genero_bailador);
            $("#participacion_coreografia").html(array.participacion_coreografia);
            $("#montajes").html(array.montajes);
            $("#titulos_bailador").html(array.titulos_bailador);
            $("#participacion_escenario").html(array.participacion_escenario);


            if(array.imagen_artistica){
              $("#imagen_artistica").attr('src', "{{url('/')}}/assets/uploads/instructor/"+array.imagen_artistica);
            }else{
               $("#imagen_artistica").hide();
            }

            var video_promocional = array.video_promocional.split('=');

            if(video_promocional[1])
            {
              $("#video_promocional").attr('src', "http://www.youtube.com/embed/"+video_promocional[1]);
              $("#video_promocional_frame").show();
              // document.getElementById('video_promocional').contentDocument.location.reload(true);
            }else{
              $("#video_promocional_frame").hide();
            }

            var video_testimonial = array.video_testimonial.split('=');

            if(video_testimonial[1])
            {
              $("#video_testimonial").attr('src', "http://www.youtube.com/embed/"+video_testimonial[1]);
              $("#video_testimonial_frame").show();
              // document.getElementById('video_testimonial').contentDocument.location.reload(true);

            }else{
              $("#video_testimonial_frame").hide();
            }

            if(array.facebook)
            {
              $("#facebook").attr('href', array.facebook);
              $("#facebook").show();
            }else{
              $("#facebook").hide();
            }

            if(array.twitter)
            {
              $("#twitter").attr('href', array.twitter);
              $("#twitter").show();
            }else{
              $("#twitter").hide();
            }

            if(array.instagram)
            {
              $("#instagram").attr('href', array.instagram);
              $("#instagram").show();
            }else{
              $("#instagram").hide();
            }

            if(array.linkedin)
            {
              $("#linkedin").attr('href', array.linkedin);
              $("#linkedin").show();
            }else{
              $("#linkedin").hide();
            }

            if(array.pagina_web)
            {
              $("#pagina_web").attr('href', array.pagina_web);
              $("#pagina_web").show();
            }else{
              $("#pagina_web").hide();
            }

            if(array.youtube)
            {
              $("#youtube").attr('href', array.youtube);
              $("#youtube").show();
            }else{
              $("#youtube").hide();
            }

            
            
            // $("#alumno-nombre").text(array.nombre)
            // $("#alumno-apellido").text(array.apellido)
            // $("#alumno-fecha_nacimiento").text(array.fecha_nacimiento)
            // $("#alumno-correo").text(array.correo)
            // $("#alumno-telefono").text(array.telefono)
            // $("#alumno-celular").text(array.celular)
            // $("#alumno-direccion").text(array.direccion)

            // if(array.sexo=='F'){

            //   $('.imagen_mostrar').attr('src', '{{url('/')}}/assets/img/profile-pics/1.jpg');

            // }

            // else{

            //   $('.imagen_mostrar').attr('src', '{{url('/')}}/assets/img/profile-pics/2.jpg');

            // }
         

            });

        });

       $("#condiciones").on('change', function(){
          if ($("#condiciones").is(":checked")){
             $(".agendar").removeAttr("disabled");
                           
             $(".agendar").css({
                "opacity": ("1")
             });
          }else{
            $(".agendar").attr("disabled","disabled");
            $(".agendar").css({
                "opacity": ("0.2")
            });
          }    
        });

       function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      }


            /*$(document).ready(function(){

                $('li').hover(function(){
                    //alert('prueba');
                    var animation = "bounceIn";
                    var cardImg = $(this).closest('.tab-nav').find('li');
                    if (animation === "hinge") {
                        animationDuration = 2100;
                    }
                    else {
                        animationDuration = 1200;
                    }
                    
                    cardImg.removeAttr('class');
                    cardImg.addClass('animated '+animation);
                    
                    setTimeout(function(){
                        cardImg.removeClass(animation);
                    }, animationDuration);
                });
            });*/

            

        </script>
@stop        