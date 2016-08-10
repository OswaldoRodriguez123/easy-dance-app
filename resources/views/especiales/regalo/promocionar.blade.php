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

    @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5)
    

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/regalos" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección regalos</a>
                      

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
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/especiales/regalos/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>
                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Empieza a regalar te invita {{$academia->nombre}} {{url('/')}}/especiales/regalos/progreso/{{$id}}"
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

                    <div class="clearfix p-b-15"></div>


                     <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu pointer">
                                    <li>
                                        <a class ="reservar">
                                            <span class="ca-icon"><i class="icon_a-tarjeta-de-regalo"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Empieza a regalar</h2>
                                                <h3 class="ca-sub">Activate ya!</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>
                          </div>

            </div>
            
            <div class="clearfix"></div>
                      

            <div class="pmo-block pmo-contact hidden-xs" style="padding-top:15px">
                  

                              
            </div>

        </div>

        <div class="pm-body clearfix">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
<!--             <ul class="tab-nav tn-justified" role="tablist">
                <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Sobre las clases</a></li>
                <li class="waves-effect"><a href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab" class="tab_instructor">Sobre los instructores</a></li>
                <li class="waves-effect"><a class="reservar">Reservar</a></li>

            </ul>
             -->
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

                        <img src="{{url('/')}}/assets/img/regalo.jpg" class="img-responsive opaco-0-8" alt="">
                        
                        <div class="clearfix p-b-20"></div>

                        <div class="f-700 f-30">Descubre porqué es importante dar un regalo</div>
                        <hr class="linea-morada">
                         <p class="f-14">La sociedad nos ha enseñado a que en los días especiales es grato poder extender un regalo , la pregunta es por qué esperar una fecha especial , cuando puedes ofrecer un detalle en y hacer  cualquier momento en un día especial.</p>

                         <p class="f-14">Los regalos generan sentimientos que refuerzan y contribuyen a edificar las relaciones entre los seres humanos, haciendo sentir valorado y tomado en cuenta quien recibe el regalo, por otro lado es gratificante descubrir cual es el sentimiento cuando el otro recibe de parte un gesto que lo motive y lo haga mejor persona, por eso te invitamos a que regales, alegría, salud, actividad física como es el baile.</p>

                         <p class="f-14">Ahora tienes la oportunidad de regalar  una de las actividades más edificantes del ser humano como es el baile. 
                        </p>

                        <div class="clearfix p-b-20"></div>


                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/rAHcZg4d9mA "></iframe>
                            </div>
                          </div>


                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>

                        <div class="col-sm-3" style="margin-left: 38%">


                                <div class="text-center">

                                  <a class="btn btn-blanco m-r-10 f-20 reservar"> Ver regalos </a>

                                </div>

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


       $(".a-prevent").click(function(){

        $('body,html').animate({scrollTop : 0}, 500);


        });

       $(".reservar").click(function(){

          procesando();

          window.location = "{{url('/')}}/especiales/regalos/disponibles/{{$academia->id}}"


        });


       function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      }

            

        </script>
@stop        