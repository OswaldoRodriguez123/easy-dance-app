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

<div class="container">

@if(Auth::check())

  <div class="block-header">

    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
    

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

                        @if($clase_personalizada->imagen)
                        <img src="{{url('/')}}/assets/uploads/clase_personalizada/{{$clase_personalizada->imagen}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        @if($clase_personalizada->descripcion)


                        <div class="f-700 f-30">Descripción</div>
                        <hr class="linea-morada">
                        {!! nl2br($clase_personalizada->descripcion) !!}

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

                        <div class="col-sm-12">

                                <div style="margin-left: 25%">
                                    
                                <div class="col-sm-8" style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc; overflow-y: auto; height:400px">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones">
                                    
                                            <div class="text-center f-25 f-700">Normativas de las clases personalizadas</div>
                                        <hr>
                                    <div class="table-responsive row">
                                    <div class="col-md-1"></div>
                                       <div class="col-md-10">
                                      <div class="text-justify">

                                      <div class="f-18 f-700"> 1. Principal   </div>
                                      <br>

                                      <p>Al momento de hacer la reserva, al alumno comprende que envía una solicitud a la academia  y no una confirmación de la  clase, la reserva  deberá ser verificada y constatada   por un representante  la academia, por medio de la  plataforma o través de una llamada telefónica.</p>


                                      <div class="f-18 f-700">2.  Reservar  </div><br>

                                      <p>Todas las clases personalizadas o paquetes de su elección, deberán ser  apartadas con el 50% del costo total, al momento de asistir deberá pagar  el resto de la  totalidad de la clase, dicha pago podrá ser ejecutado a través de la plataforma o enviando el Boucher del  pago generado  a través, de la cuenta de banco establecida por la academia. </p>

                                      <div class="f-18 f-700"> 3. Asistencia  </div><br>

                                      <p>El alumno deberá asistir en el horario establecido en la reservación, en caso de atraso de parte del alumno, la academia no se responsabiliza ni se obliga  a reponer el tiempo perdido. </p>


                                      <div class="f-18 f-700"> 4. Inasistencia  </div><br>

                                      <p>En caso de que el alumnos no pueda asistir a su clase programada  deberá notificarlo con 08 horas de antelación a través de la plataforma, o confirmar a través de una llamada telefónica su cancelación, de lo contrario, la clase obtendrá un estatus de <b>“cancelación tardía”</b>, lo que significa que esta será percibida como una  clase vista, por tal motivo, esta deberá ser pagada en su totalidad, sin derecho a reprogramar dicha clase, esta podrá ser reprogramada siempre y cuando la cancelación sea superior a las 08 horas de límite que estable la institución.  </p>

                                      <div class="f-18 f-700"> 5. Dinámica </div><br>

                                      <p>Usted comprende que el instructor podrá realizar una clase personalizada, con dos partipantesen una misma sección u hora de clases. </p>

                                      </div>
                                      </div>
                                      </div>

                                  </p>

                                  </div>

                                  </div>

                                </div>

                                <div class="col-sm-3" style="margin-left: 39%">

                                <input type="checkbox" id="condiciones" name="condiciones">  <span class="f-16 f-700 opaco-0-8">  Acepto los  términos</span> <br><br>

                                <div class="text-center">

                                  <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name="guardar" id="guardar" >Agendar</button>

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

        route_aceptar="{{url('/')}}/agendar/clases-personalizadas/";
        route_principal="{{url('/')}}/inicio";

        $(document).ready(function() {

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

       $(".a-prevent").click(function(){

        $('body,html').animate({scrollTop : 0}, 500);


        });

       $(".guardar").click(function(){

        id = "{{$id}}";
        var token = $('input:hidden[name=_token]').val();

        procesando();
        var route = route_aceptar + id;
                  
                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                      dataType: 'json',
                      success:function(respuesta){

                          window.location = route_principal; 

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
            });


       $("#condiciones").on('change', function(){
          if ($("#condiciones").is(":checked")){
             $("#guardar").removeAttr("disabled");
                           
             $("#guardar").css({
                "opacity": ("1")
             });
          }else{
            $("#guardar").attr("disabled","disabled");
            $("#guardar").css({
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