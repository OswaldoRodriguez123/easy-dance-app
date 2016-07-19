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

@section('content')

<div class="container">

@if(Auth::check())
<div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/talleres" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección talleres</a>
                    </div> 
  @endif

    <div class="card" id="profile-main">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        @if($academia->imagen)
                          <img class="img-responsive" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                        @else
                          <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
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
                      <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Datos Generales</div>
                          <div class="col-sm-12">
                          <div class="clearfix p-b-15"></div>
                            <label class="text-left opaco-0-8"><i class="zmdi zmdi-border-color zmdi-hc-fw f-18"></i> Cupos disponibles:</label>
                              <p class="text-left opaco-0-8 f-16" >

                                {{$cupos_restantes}}</p>

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
                                 <button id="{{$taller->id}}" name ="{{$taller->id}}" class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa" data-toggle="modal" href="#modalAgregar" style="width:100%; padding:5px"> </i> Reservar </button>
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
                <li class="waves-effect"><a href="#faqs" aria-controls="faqs" role="tab" data-toggle="tab">Sobre Easy Dance</a></li>

            </ul>
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

<!--                         <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/caracteristicas-principal.jpg"> -->

                        <p class="text-center f-25 f-700 opaco-0-8">Es hora de bailar y participar en el nuevo taller de</p>
                               <h2 class="text-center"> {{$taller->academia_nombre}} </h2>
                               <div class="p-b-15"></div>
                               <h4 class="text-center"> <i class="zmdi zmdi-pin zmdi-hc-fw c-morado-suave"></i> {{$taller->estado}} - {{$taller->direccion}}  </h4>


                        <div class="clearfix p-b-20"></div>
                        
                        @if($taller->imagen)
                        <img src="{{url('/')}}/assets/uploads/taller/{{$taller->imagen}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        <div class="f-700 f-30">Descripción</div>
                        <br>
                        <p class="f-14">{{$taller->descripcion}}.</p>

                        <!-- <p class="f-14">Easy Dance es una aplicación Online dirigida a la gestión de las academias de baile, con el propósito de organizar las actividades que involucran a: Directores de academias, instructores de baile, alumnos y todas aquellas personas interesadas en aprender a bailar de una manera más fácil. La aplicación se encuentra en una etapa temprana, hemos lanzado al mercado la primera fase del proyecto, en el que pondremos a prueba la adaptabilidad del mercado con el uso de las nuevas tecnologías. Nuestro equipo se encuentra laborando arduamente para ir incrementando las características de manera periódica y de ese modo ir creando de la aplicación una herramienta más completa que contribuya de manera sustancial con el ecosistema del baile.</p>

                        <p class="f-14">Easy dance se encuentra en un proceso de periodo de prueba (Fase Beta) completamente abierta para cualquier academia de baile que desee integrarse, haciendo uso y prueba de nuestro proyecto piloto. Por tal motivo invitamos a toda la comunidad de baile a participar generando invitaciones a todas aquellas academias que aún no conocen la herramienta.</p>

                        <p class="f-14">Así que los invitamos a estar muy atentos de todos nuestros avances, semanalmente estaremos haciendo nuevos anuncios de todas las características que se estarán actualizando dentro de la plataforma para el disfrute y organización en el ambiente del baile.</p> -->


                        @if($link_video)
                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{$link_video}}"></iframe>
                            </div>
                          </div>
                        @endif

                          <div class="clearfix p-b-20"></div>

                        


                    </div>

                </div>

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">

                        

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

        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

        var recompensa = 0;

          // (function(){

          //     var i=0,soons = document.querySelectorAll('.auto-due .soon'),l=soons.length;
          //     for (;i<l;i++) {
          //         soons[i].setAttribute('data-due','2016-01-30T14:10:09');
          //         soons[i].setAttribute('data-now','2016-01-01T00:00:00');
          //     }

          // }());

          // if ('addEventListener' in document) {
          //   var showDemo = function(e){
          //       var btn = e.target;
          //       btn.style.display = 'none';
          //       var wrapper = e.target.parentNode;
          //       var panel = wrapper.querySelector('.el-sample');
          //       panel.style.display = 'block';
          //       var nodes = e.target.parentNode.querySelectorAll('.soon');
          //       for(var i=0;i<nodes.length;i++){
          //           Soon.create(nodes[i]);
          //       }
          //   };
          //   var buttons = document.querySelectorAll('.demo-button');
          //   for(var i=0;i<buttons.length;i++) {
          //       buttons[i].addEventListener('click',showDemo);
          //   }
          // }
          // var soons = document.querySelectorAll('.auto-due .soon');
          // for(var i=0;i<soons.length;i++) {
          //     Soon.create(soons[i]);
          // }

              // create a simple soon counter on the supplied element
            $(document).ready(function() {


              // create a more advanced counter
              // $(".your-advanced-counter").soon({
              //     due:"2015-11-25",
              //     layout:"group tight",
              //     face:"flip color-light corners-sharp shadow-soft",
              //     separateChars:false,
              //     eventComplete:function(){ alert("done!"); }
              // });

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