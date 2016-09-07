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

<div class="container">

@if(Auth::check())

  <div class="block-header">

    @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
    

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/clases-personalizadas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase personalizada</a>
                      

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


                    <div class="pmo-block pmo-contact hidden-xs">

                    <h2>Contacto</h2>

                    <ul>
                        <li><i class="zmdi zmdi-email"></i> <a class ="enlace_gris" href="mailto:{{$academia->correo}}" target="_blank">{{$academia->correo}}</a></li>
                        @if($academia->facebook)
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

                    </div>


            </div>
            
            <div class="clearfix"></div>
                      

            <div class="pmo-block pmo-contact hidden-xs" style="padding-top:15px">
      
                      <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Datos Generales</div>
                          <div class="col-sm-12">
                          <div class="clearfix p-b-15"></div>

                              <label class="text-left opaco-0-8"><i class="zmdi zmdi-calendar f-22"></i>  Fecha de inicio:</label>
                              <p class="text-left opaco-0-8 f-16">{{$clase_personalizada->fecha_inicio}}</p>

                              <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-especialidad f-22"></i> Especialidad:</label>
                              <p class="text-left opaco-0-8 f-16">{{$clase_personalizada->especialidad_nombre}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-estudio-salon f-22"></i> Estudio salón:</label>
                              <p class="text-left f-16">{{$clase_personalizada->estudio_nombre}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="icon_a-instructor f-22"></i> Instructor:</label>
                              <p class="text-left f-16">{{$clase_personalizada->instructor_nombre}} {{$clase_personalizada->instructor_apellido}}</p> 

                               <hr class="linea-morada opaco-0-8">

                              <label class="text-left opaco-0-8" ><i class="zmdi zmdi-alarm f-22"></i> Horarios:</label>
                              <p class="text-left f-16">{{$clase_personalizada->hora_inicio}} - {{$clase_personalizada->hora_final}}</p>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                    </div>

    
            </div>

        </div>

        <div class="pm-body clearfix">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <ul class="tab-nav tn-justified" role="tablist">
                <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Sobre la clase</a></li>

            </ul>
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane  active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

                        @if($config_clase_personalizada->imagen_principal)
                        <img src="{{url('/')}}/assets/uploads/clase_personalizada/{{$config_clase_personalizada->imagen_principal}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        @if($config_clase_personalizada->descripcion)


                        <div class="f-700 f-30">Descripción</div>
                        <hr class="linea-morada">
                        {!! nl2br($config_clase_personalizada->descripcion) !!}

                        <div class="clearfix p-b-20"></div>

                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        @endif

  
                        @if($link_video)
                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{$link_video}}"></iframe>
                            </div>
                          </div>
                        @endif

                        <div class="clearfix p-b-20"></div>

                        @if($config_clase_personalizada->ventajas)

                        <div class="f-700 f-30">Programación ventajas y beneficios</div>
                        <hr class="linea-morada">
                        <p class="f-14">{!! nl2br($config_clase_personalizada->ventajas) !!}</p>

                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        @endif

                        <div class="col-sm-3" style="margin-left: 35%">


                                <div class="text-center">

                                  <a class="btn btn-blanco m-r-10 f-20 reservar"> ¡ Quiero Reservar ! </a>

                                </div>

                              </div>

                        

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

        var condiciones = <?php echo json_encode($config_clase_personalizada->condiciones);?>;

        $(document).ready(function() {


              $("#pre_condiciones").html(nl2br(condiciones));

              $(".guardar").attr("disabled","disabled");

              $(".guardar").css({
                  "opacity": ("0.2")
              });

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

          procesando();

          window.location = "{{url('/')}}/agendar/clases-personalizadas/disponibles/{{$academia->id}}"


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