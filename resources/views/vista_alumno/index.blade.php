@extends('layout.master')

@section('css_vendor')

  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />

@stop

@section('js_vendor')

  <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

  <script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

@stop

@section('content')


<div class="modal fade" id="modalCredencial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
              <h4 class="modal-title c-negro"> Credenciales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
          </div>
             <div class="modal-body">                           
             <div class="row p-t-20 p-b-0">

                 <div class="col-sm-3">

                      <img name = "instructor_imagen" id ="instructor_imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                      <div class="clearfix p-b-15"></div>

                      <p class="p-l-10" id="instructor_nombre"></p>
                        
                 </div>
                 

                 <div class="col-sm-8">
                     <label for="asistencia-clase_grupal_id" class="f-16">Instructor</label>
                        <div class="select">
                          <select class="selectpicker form-control" name="credencial_id" id="credencial_id" data-live-search="true">

                            <option value="">Selecciona</option>

                            @foreach ( $credenciales_alumno as $credencial_alumno )
                              <option data-nombre = "{{$credencial_alumno['instructor_nombre']}} {{$credencial_alumno['instructor_apellido']}}" value = "{{ $credencial_alumno['id'] }}">{{ $credencial_alumno['instructor_nombre'] }} {{ $credencial_alumno['instructor_apellido'] }}</option>
                            @endforeach
                            
                          </select>
                        </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form-group fg-line">
                      <label for="cantidad">Cantidad de credenciales</label>
                      <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="0000000" placeholder="Ej: 50" value="0" disabled>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form-group fg-line">
                      <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                      <input type="text" class="form-control input-sm input-mask" name="dias_vencimiento" id="fecha_vencimiento" placeholder="Ej: 20/08/1991" value="0" disabled>
                   </div>
                 </div>
        
                 <div class="clearfix"></div> 

             </div>
             
          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro"> <h4>
<!-- <div class="iconox-icon">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
  <title>Confirma tu academia</title>
  <circle fill="#692A5A" cx="16" cy="16" r="16"/>
<img src="{{url('/')}}/assets/img/icono_easydance2.png"  height="26" width="28" style="margin-top: -30px; margin-left: 3px;"/></svg>
</div> -->Bienvenid@ </h4> <!-- <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> --></h4>
            </div>
                      
            <div class="modal-body">                           
              <div class="row p-t-20 p-b-0">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="col-md-offset-5">
                <div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;" class="img-responsive opaco-0-8" alt=""></div>
              </div>

              <div class="clearfix m-20 m-b-25"></div>

              <div class="col-sm-11"><br>
                <p align="left" style="font-size: 20px;">Bienvenid@, <b> {{Auth::user()->nombre}} </b><br>
                <text style="font-size: 16px;">Dedica un momento para ayudarnos a configurar tu perfil evaluativo.</text></p>
              </div>

              <div class="clearfix m-20 m-b-25"></div>
      
              <div class="col-sm-12 col-sd-12 text-center"><br><br><br>

                <button type="submit" class="butp button5" onclick="configuracion()">Llévame</button>
                <button type="submit" class="but2 button55" onclick="atras()"><span>Más Tarde</span></button><br><br><br>

                <br><br><br><br>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<a href="{{url('/')}}/agendar" class="btn bgm-blue btn-float waves-effect m-btn" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="" title="" data-original-title="Agendar clase personalizada"><i class="zmdi zmdi-calendar"></i></a>
<div class="container">
    <div class="card">
    <div class="card-body p-b-20">
      <div class="row p-l-10 p-r-10">
        <div class="col-sm-12">
          
          <a href="{{url('/')}}/invitar"> 

            @if($academia->imagen_horizontal)
              <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_horizontal}}" alt="">
            @else
              <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/banner.png" alt="">
            @endif
            
          </a>

        </div>
          <div class="col-sm-3" style="background: #f8f8f8 ; margin-left: 5px; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px">
                 
              <div class="pmo-block pmo-contact hidden-xs">
                  
                   <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                        <div class="header_cuadro_alumno_borde_morado text-left f-16 f-700">Agendar</div>
                        
                        <div class ="detalle clase_grupal" style="margin-top:10px">
                            <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clases-grupales f-20"></i> Clases Grupales <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$clases_grupales}}</span></a> 

                          </div>
                          
                          <div class ="detalle clase_personalizada">
                            <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clase-personalizada f-20"></i> Clases Personalizadas <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$clase_personalizada_contador}}</span>


                            </a>
                            </div>

                            <div class ="detalle taller">
                              <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-talleres f-20"></i> Talleres <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$talleres}}</span></a>
                            </div>

                            <div class ="detalle instructor">
                              <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-instructor f-15"></i> Instructores <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$instructor_contador}}</span>

                              </a>
                            </div>



                          <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                    </div> <!-- AGENDAR -->


                    <div class="clearfix p-b-15"></div>

                    <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff ">
                        <div class="header_cuadro_alumno_borde_morado text-left f-16 f-700">Especiales</div>

                        <div class ="detalle regalos" style="margin-top:10px">
                          
                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-tarjeta-de-regalo f-20"></i> Regalos <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{count($regalos)}}</span></a> 

                          </div>


                        <div class ="detalle evaluaciones">
                          

                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-examen f-20"></i> Valoraciones <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{count($alumno_examenes)}}</span></a> 
                            
                          </div>

                          <div class ="detalle campana">

                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-campana f-20"></i> Campañas <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$contador_campana}}</span></a> </div>

                          <div class ="detalle credencial">

                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-campana f-20"></i> Credenciales <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$total_credenciales}}</span></a> </div>

                          <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                    </div> <!-- ESPECIALES -->


                    
                    <div class="clearfix p-b-15"></div>

                    <a href="{{url('/')}}/invitar"> <img class="opaco-0-8 img-responsive" src="{{url('/')}}/assets/img/banner_referido.jpg" alt=""></a>


                    <div class="clearfix p-b-15"></div>


                    <table class="table table-striped table-bordered text-center">
                     <tr>
                     <td></td>
                     <td class="f-14 m-l-15"><span class="f-12 f-700">Mi Código: </span><span class = "f-12 f-700" id="puntos_referidos" name="puntos_referidos">{{$alumno->codigo_referido}}</span></td>
                    </tr>
                    </table>

                    <table class="table table-striped table-bordered text-center">
                     <tr class="disabled">
                     <td></td>
                     <td class="f-14 m-l-15"><span class="f-12 f-700">Puntos Acumulados: </span><span class = "f-12 f-700" id="puntos_referidos" name="puntos_referidos">{{$puntos_referidos}}</span></td>
                    </tr>
                    </table>
            
   
                </div>

              </div>
            </div>

          
          <div class="col-sm-6" style="width:49%">

          <div class="col-xs-12 text-left">
            <ul class="tab-nav tn-justified" role="tablist">
              <li class="waves-effect"><a href="{{url('/')}}/administrativo" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Administrativo</p></a></li>
              <li class="waves-effect"><a href="{{url('/')}}/asistencia" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Asistencia</p></a></li>
              <li class="waves-effect"><a href="{{url('/')}}/normativas" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Normativas</p></a></li>
            </ul>
          </div>

           <div class="clearfix p-b-20"></div>

           <span class="f-16 f-700 opaco-0-8"><i class="zmdi zmdi-arrow-split zmdi-hc-fw"></i> Actividades Recientes</span>

           <hr class="linea-morada">

           <div class ="enlaces">

            @foreach(array_slice($enlaces, 0, 4) as $enlace)
              
              <div class="text-left pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">
                <div class= "enlace" id="enlace" name="enlace" data-url="{{$enlace['url']}}">
                  <div style="padding: 10px">
                    <p class="f-25 f-700" style="color:#5e5e5e">
                      {{$enlace['nombre']}} 
                      <span class="f-16 c-youtube">{{$enlace['disponible']}}</span>
                    </p>
                  

                    @if($enlace['descripcion'])
                      <p class="f-15 f-700">{{ str_limit($enlace['descripcion'], $limit = 150, $end = '...') }}</p>
                    @endif
                            
                    <p class="f-15 f-700">Fecha : {{$enlace['fecha']}}</p>

                    <p class="f-15 f-700">Dias : {{$enlace['dias']}}</p>
                    
                    @if($enlace['especialidad'])
                      <p class="f-15 f-700">Especialidad : {{$enlace['especialidad']}}</p>

                      <p class="f-15 f-700">Instructor : {{$enlace['instructor']}}</p>
                    @endif
                    
                    <p class="f-15 f-700">Hora : {{$enlace['hora']}}</p>
   
                    @if($enlace['imagen'])
                      <img src="{{url('/')}}{{$enlace['imagen']}}" class="img-responsive" alt="">
                      <br>
                    @else
                      <img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="height:150px; width:350px" class="img-responsive" alt="">
                      <br>
                    @endif

                  </div>
                </div>

                <hr style="margin-bottom:5px">


                <div class="col-sm-3">
                  <span class="f-13 f-700">Comparte</span>
                  <ul class="rrssb-buttons clearfix">
                    <li class="rrssb-facebook">
                      <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header: https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                      <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}{{$enlace['facebook']}}" class="popup">
                        <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                        <span class="rrssb-text">facebook</span>
                      </a>
                    </li>
                    <li class="rrssb-twitter">
                      <!-- Replace href with your Meta and URL information  -->
                      <a href="https://twitter.com/intent/tweet?text={{$enlace['twitter']}} {{url('/')}}{{$enlace['twitter_url']}}"
                      class="popup">
                        <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                        <span class="rrssb-text">twitter</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <br><br><br>
              </div>
            @endforeach

            @if(count($enlaces) > 4)

              <div class="text-center mostrar_mas"> <!-- MOSTRAR MAS -->
                <br><br>
                <span class="mostrar f-16 c-morado f-700 pointer">Mostrar más</span>
              </div>
            @endif

            </div>
                        
           
          </div>

  

            <div class="col-sm-3" style="background: #f8f8f8 ; margin-right: 5px; float:right; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px;">
                <div class="pmo-block pmo-contact hidden-xs">

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

                    <div class="pmo-block pmo-contact hidden-xs">

                    <h2 style="font-size: 16px; margin: 0 0 15px">Contacto</h2>

                    <ul>
                        <li><i class="zmdi zmdi-email"></i> <a class ="enlace_gris" href="mailto:{{$academia->correo}}" target="_blank">{{$academia->correo}}</a></li>
                        
                        @if($academia->facebook)
                          @if (!filter_var($academia->facebook, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="{{$academia->facebook}}">{{ str_limit($academia->facebook, $limit = 25, $end = '...') }}</a></li>
                          @else
                            <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="https://www.facebook.com/{{$academia->facebook}}">https://www.facebook.com/...</a></li>
                          @endif
                        @endif

                        @if($academia->twitter)

                          @if (!filter_var($academia->twitter, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="{{$academia->twitter}}">https://www.twitter.com/{{$academia->twitter}}</a></li>
                          @else
                            <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="https://www.twitter.com/{{$academia->twitter}}">@ {{$academia->twitter}}</a></li>
                          @endif
                        @endif

                        @if($academia->instagram)
                          @if (!filter_var($academia->instagram, FILTER_VALIDATE_URL) === false) 
                            <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="{{$academia->instagram}}">{{$academia->instagram}}</a></li>
                          @else
                            <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="https://www.instagram.com/{{$academia->instagram}}">@ {{$academia->instagram}}</a></li>
                          @endif
                        @endif

                        @if($academia->linkedin)
                        <li><i class="zmdi zmdi-linkedin-box"></i> <a class ="enlace_gris" href="{{$academia->linkedin}}">Linkedin</a></li>
                        @endif

                        @if($academia->youtube)
                        <li><i class="zmdi zmdi-collection-video"></i> <a class ="enlace_gris" href="{{$academia->youtube}}">Youtube</a></li>
                        @endif

                        @if($academia->pagina_web)
                        <li><i class="zmdi zmdi-google-earth"></i> <a class ="enlace_gris" href="{{$academia->pagina_web}}">Pagina Web</a></li>
                        @endif

                        @if($academia->direccion)
                        <li>
                            <i class="zmdi zmdi-pin"></i>
                            <address class="m-b-0 ng-binding">
                                {{$academia->direccion}}
                            </address>
                        </li>
                        @endif

                        @if($academia->celular)
                        <li>
                            <i class="icon_b-telefono"></i>
                                {{$academia->celular}} - {{$academia->telefono}}
                        </li>
                        @endif
                    </ul>

                    <div class="clearfix p-b-15"></div>

                    <div style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                      <div class="header_cuadro_alumno_borde_morado text-center f-16">Consultarle al profesor</div>

                      
                      <div class="col-sm-12">

                          <div class="clearfix p-b-15"></div>
                          <div class="text-center">
                          <i class="icon_f-consultarle-al-instructor f-50"></i>
                          </div>
                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                      </div>

                      <span class="text-center">

                          <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 consulta_instructor" style="width:100%; padding:5px"> </i> Consultar </button> 
                      </span>

                    </div>

                    <div class="clearfix p-b-15"></div>

                    <div style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                      <div class="header_cuadro_alumno_borde_morado text-center f-16">Recepción - Admistración</div>

                      
                      <div class="col-sm-12">

                          <div class="clearfix p-b-15"></div>
                          <div class="text-center">
                          <i class="icon_f-consultarle-al-instructor f-50"></i>
                          </div>
                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                      </div>

                      <span class="text-center">

                          <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 consulta_recepcion" style="width:100%; padding:5px"> </i> Consultar </button> 
                      </span>

                    </div>
                  
                  </div>

                    <div class="clearfix p-b-15"></div>
                  </div>

              </div>
            </div>
            </div>
            <!--<data ui-view></data>-->
        </div>
    </div>
</div>




@stop

@section('js') 
        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        var credenciales_alumno = <?php echo json_encode($credenciales_alumno);?>;
        var campanas = <?php echo json_encode($campanas);?>;

        function configuracion(){
          window.location = "{{url('/')}}/perfil-evaluativo";
          }

          $(".evaluaciones").click(function(){
            procesando();
            window.location = "{{url('/')}}/evaluaciones";
          });

          $(".regalos").click(function(){
            procesando();
            window.location = "{{url('/')}}/especiales/regalos/progreso/{{$academia->id}}";
          });

          $(".clase_grupal").click(function(){
            procesando();
            window.location = "{{url('/')}}/agendar/clases-grupales/disponibles/{{$academia->id}}";
          });

          $(".clase_personalizada").click(function(){
            window.location = "{{url('/')}}/agendar/clases-personalizadas/progreso/{{$academia->id}}";
          });

          $(".taller").click(function(){
            procesando();
            window.location = "{{url('/')}}/agendar/talleres/disponibles/{{$academia->id}}";
          });

          $(".instructor").click(function(){
            procesando();
            window.location = "{{url('/')}}/instructores";
          });

          $(".campana").click(function(){
            procesando();

            if(campanas.length > 1 || campanas.length == 0)
            {
              window.location = "{{url('/')}}/especiales/campañas";
            }else{
              window.location = "{{url('/')}}/especiales/campañas/progreso/"+campanas[0].id;
            }
            
          });

          $(".credencial").click(function(){
            $('#modalCredencial').modal('show');
          });


          $(".consulta_instructor").click(function(){
            procesando();
            window.location = "{{url('/')}}/sugerencias/instructor";
          });

          $(".consulta_recepcion").click(function(){
            procesando();
            window.location = "{{url('/')}}/sugerencias/recepcion";
          });
         
         function atras(){
          $("#modalConfiguracion").modal('hide');
         }
         
        $(document).ready(function(){
        
        if("{{$perfil}}" == 0)

        {
          setTimeout(function(){ 

            // $("#modalConfiguracion").modal({

            //       backdrop: 'static',

            //       keyboard: false

            //   });

            $('#modalConfiguracion').modal('show'); 

            }, 3000);
        }

        });

        var enlaces = <?php echo json_encode($enlaces);?>;

        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

        var recompensa = 0;
        var inicio = 4;
        var final = 7;

        $(document).on( 'click', '.enlace', function () {
          url = $(this).data('url');
          window.open("{{url('/')}}"+url, '_blank');
        });

        $(document).on( 'click', '.mostrar', function () {

          $(".mostrar_mas").remove();

          var enlace = $.grep(enlaces, function(e){ return (e.contador >= inicio && e.contador <= final) });

          $.each(enlace, function (index, array) {

            if(array.tipo == 1){
              fecha_inicio = "<p class='f-15 f-700'> Fecha de Inicio : "+array.fecha_inicio+"</p>"
            }else{
              fecha_inicio = ''
            }

            $(".enlaces").append('<div class="text-left pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)"><div class="enlace" name="enlace" id="enlace" data-url="'+array.url+'"><div style="padding: 10px"><p class="f-25 f-700" style="color:#5e5e5e">'+array.nombre+'<span class="f-16 c-youtube">'+array.disponible+'</span></p><p class="f-15 f-700">'+array.descripcion.substr(0, 150) + "..."+ '</p><img src="{{url('/')}}'+array.imagen+'" class="img-responsive" alt=""> <br>'+fecha_inicio+'</div></div><hr style="margin-bottom:5px"><div class="col-sm-3"><span class="f-13 f-700">Comparte</span><ul class="rrssb-buttons clearfix"><li class="rrssb-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}'+array.facebook+'" class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span><span class="rrssb-text"></span></a></li><li class="rrssb-twitter"><a href="https://twitter.com/intent/tweet?text='+array.twitter+' {{url('/')}}'+array.twitter_url+'"class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span><span class="rrssb-text"></span></a></li></ul></div><br><br><br></div>')


          });

          inicio = final;
          final = final + 4;

          if(inicio <= enlaces.length){

            $(".enlaces").append('<div class="text-center mostrar_mas"> <br><br> <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span> </div>');

          }

        });

        $('#credencial_id').on('change', function(){

          credencial_id = $(this).val();

          existe = false


          $.each(credenciales_alumno, function (index, array) { 

            if(credencial_id == array.id){

              $('#instructor_nombre').text(array.instructor_nombre + ' ' + array.instructor_apellido)

              if(array.imagen){
                $('#instructor_imagen').attr('src', "{{url('/')}}/assets/uploads/usuario/"+array.imagen)
              }else{
                if(array.sexo == 'M'){
                  $('#instructor_imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
                }else{
                  $('#instructor_imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
                }
              }

              $('#fecha_vencimiento').val(array.fecha_vencimiento)
              $('#cantidad').val(array.cantidad)

              existe = true

            }
          });

          if(existe == false){
            $('#fecha_vencimiento').val(0)
            $('#cantidad').val(0)
          }
          
        });

        </script>
@stop        