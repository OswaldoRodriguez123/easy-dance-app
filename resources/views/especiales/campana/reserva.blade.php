@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

@section('content')

<div class="container">


    <div class="card" id="profile-main">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                    </a>

                </div>

            </div>

            <div class="pmo-block pmo-contact hidden-xs">
                <hr>
                              <p class="text-left f-15 f-700"> 42,523.00 recaudado  por <br> 477 patrocinantes </p>
                              <div class="clearfix"></div>

                              <div class="progress progress-striped m-b-10">
                                <div class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                              </div>
                              <p class="text-center f-700" > 147% de 29,000.00</p> 

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
                          
                           <p class="text-center f-18 f-700" >Tiempo restante</p>

                          <div class="soon" id="my-soon-watch-red"
                               data-layout="group tight label-uppercase label-small"
                               data-format="d,h,m,s"
                               data-face="slot"
                               data-padding="false"
                               data-visual="ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0">
                          </div> 
                          
                          <div class="clearfix p-b-15"></div>

                          <hr class="linea-morada">

                          @foreach ($recompensas as $recompensa)
                          
                        
                            <span class="text-center f-25 f-700" > {{$recompensa->cantidad}}</span> 
                            <br>
                            <span class="text-center f-20 f-700" > {{$recompensa->nombre}}</span> 
                            <br>
                            <span class="text-center f-15 f-700" > {{$recompensa->descripcion}}</span> 

                          <hr class="linea-morada">

                          @endforeach


                              @if($administrador == 1)

                              @else

                              <p class="text-center">
                               
                                <a href="{{ empty($clase_grupal->facebook) ? '' : $clase_grupal->facebook}}" target="_blank"><i class="{{ empty($clase_grupal->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->twitter) ? '' : $clase_grupal->twitter}}" target="_blank"><i class="{{ empty($clase_grupal->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->instagram) ? '' : $clase_grupal->instagram}}" target="_blank"><i class="{{ empty($clase_grupal->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->linkedin) ? '' : $clase_grupal->linkedin}}" target="_blank"><i class="{{ empty($clase_grupal->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->youtube) ? '' : $clase_grupal->youtube}}" target="_blank"><i class="{{ empty($clase_grupal->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->pagina_web) ? '' : $clase_grupal->pagina_web}}" target="_blank"><i class="{{ empty($clase_grupal->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p>
                              

                                <p class="text-center">
                                 <button id="reserva" name ="reserva" class="btn-blanco m-r-10 f-22 f-700 p-l-20 p-r-20" > </i> Lo quiero </button>
                                </p>
                              
                              @endif
            </div>

        </div>

        <div class="pm-body clearfix">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <ul class="tab-nav tn-justified" role="tablist">
                <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Campaña</a></li>
                <li class="waves-effect"><a href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab">Patrocinadores</a></li>
                <li class="waves-effect"><a href="#faqs" aria-controls="faqs" role="tab" data-toggle="tab">Sobre Easy Dance</a></li>

            </ul>
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

<!--                         <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/caracteristicas-principal.jpg"> -->

                        <p class="text-center f-30 f-700 opaco-0-8">{{$campana->nombre}}</p>
                        <p class="text-center f-20 f-700 opaco-0-8">{{$campana->eslogan}}</p>


                        <div class="clearfix p-b-20"></div>
                        
                        @if($campana->imagen)
                        <img src="{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        
                        <div class="clearfix p-b-20"></div>

                        <div class="f-700 f-30">Historia</div>
                        <br>
                        <p class="f-14">{{$campana->historia}}.</p>

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


                      <div class="f-700 f-30">Presentación general de la campaña</div>
                        <br>
                        <p class="f-14">{{$campana->presentacion}}.</p>

                        @if($campana->imagen_presentacion)
                        <img src="{{url('/')}}/assets/uploads/campana/{{$campana->imagen_presentacion}}" class="img-responsive opaco-0-8" alt="">
                        @endif
                        


                    </div>

                </div>

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">

                        

                        @if($campana->imagen)
                        <img src="{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}" class="img-responsive opaco-0-8" alt="">
                        @endif


                         <table class="table" id="tablelistar_asistencia" >

                            <thead>
                                <tr class="hidden">    
                                    <th class="text-center" >Nombres</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                          
                                                 
                            @foreach ($alumnos as $alumno)
                                
                                <?php $id = $alumno['id']; ?>
                                <tr id="tablelistar" class="">
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">
                                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                                      <i class="chat-status-busy"></i>
                                                  </div>
                                                  <div class="col-sm-6">
                                                    <div class="media-body">
                                                        <div class="lv-title"><span class="c-morado">{{$alumno['nombre']}} {{$alumno['apellido']}}</span></div>
                                                        <small class="lv-small">hace 10 minutos</small>
                                                    </div>
                                                  </div>

                                                   <div class="col-sm-5">
                                                     <div class="pull-right p-relative">
                                                        <div class="lv-title"><span class="c-morado">99 BsF</span></div>
                                                    </div>
                                                  </div>
                                                  
                                              </div>
                                      </a>
                                      </div>
                                   </td>
                                </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                            



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

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

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
              $(".soon").soon({
                  due:"2016-07-14",
                  layout:"group"
              });

              // create a more advanced counter
              // $(".your-advanced-counter").soon({
              //     due:"2015-11-25",
              //     layout:"group tight",
              //     face:"flip color-light corners-sharp shadow-soft",
              //     separateChars:false,
              //     eventComplete:function(){ alert("done!"); }
              // });
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