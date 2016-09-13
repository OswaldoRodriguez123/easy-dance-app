@extends('layout.master2')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    
    <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
<link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

<meta content='{{$campana->nombre}}' property='og:title'/>
@if($campana->imagen)
<meta content="{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}" property='og:image'/>
@endif

@section('content')

<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Confirma tu pago aquí<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_modal" id="form_modal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="id" value="{{ $campana->id }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                                        <div class="col-sm-12">
                                              <label for="id" id="id-nombre">Nombre y Apellido del contribuyente</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      
                                                      <input type="text" class="form-control input-sm input-mask" name="nombre" id="nombre" placeholder="Ej. Valeria Zambrano">

                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-nombre">
                                                    <span >
                                                        <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                 
                                              <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del contribuyente" title="" data-original-title="Ayuda"></i>

                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
                                                <div class="p-t-10">
                                              <label class="radio radio-inline m-r-20">
                                                  <input name="sexo" id="mujer" value="F" type="radio">
                                                  <i class="input-helper"></i>  
                                                  Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                              </label>
                                              <label class="radio radio-inline m-r-20 ">
                                                  <input name="sexo" id="hombre" value="M" type="radio">
                                                  <i class="input-helper"></i>  
                                                  Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                              </label>
                                              </div>
                                              </div>
                                           <div class="has-error" id="error-sexo">
                                                <span >
                                                    <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                                </span>
                                            </div>
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                      <div class="form-group">
                                      <div class="form-group">
                                        <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto que deseas contribuir" title="" data-original-title="Ayuda"></i>
                                        
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="monto" id="monto" data-mask="000000000000000" placeholder="Ej. 5000">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-monto">
                                      <span >
                                          <small id="error-monto_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                        <div class="col-sm-12">
                                              <label for="id" id="id-nombre_banco">Identidad bancaria</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del banco" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_c-piggy-bank f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      
                                                      <input type="text" class="form-control input-sm input-mask" name="nombre_banco" id="nombre_banco" placeholder="Ej. Banco del Tesoro">

                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-nombre_banco">
                                                    <span >
                                                        <small id="error-nombre_banco_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-numero_cuenta">Número de transferencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el numero de cuenta" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="zmdi icon_c-money f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="numero_cuenta" id="numero_cuenta" data-mask="00000000000000000000" placeholder="Ingresa Número de Transferencia">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-numero_cuenta">
                                                    <span >
                                                        <small id="error-numero_cuenta_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-rif">Cédula - Pasaporte</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cedula o pasaporte del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="rif" id="rif" placeholder="Rif: J-298324278">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-rif">
                                                    <span >
                                                        <small id="error-rif_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-correo">Correo Electrónico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electronico del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="correo" id="correo" placeholder="Ej: easydance@gmail.com">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-correo">
                                                    <span >
                                                        <small id="error-correo_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
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
                            <div class="col-sm-12">                            

                             <button type="button" data-formulario="form_modal" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

<div style="padding:0 ; background: url('{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}');  min-height: 450px; background-repeat: no-repeat; background-size: cover; background-position: center;" >

</div>

<!-- <div class="container"> -->

<!-- @if(Auth::check())

  <div class="block-header">

    @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
    

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Campaña</a>
                      

    @else

      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>

    @endif

  </div> 
  
@endif -->



    <div class="clearfix"></div>

    <div class="card" id="profile-main" style="margin-bottom: 0px">
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

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                    <ul class="rrssb-buttons clearfix">

                      <li class="rrssb-facebook">
                        <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header: https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/especiales/campañas/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>

                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Ayuda a que la campaña {{$campana->nombre}} se haga realidad en @EasyDanceLatino {{url('/')}}/especiales/campañas/progreso/{{$id}}"
                        class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                          <span class="rrssb-text">twitter</span>
                        </a>
                      </li>
                    </ul>

                   <!--  <br> -->

                    <!-- <p class="text-center">
                               
                                <a href="{{ empty($academia->facebook) ? '' : $academia->facebook}}" target="_blank"><i class="{{ empty($academia->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a href="{{ empty($academia->twitter) ? '' : $academia->twitter}}" target="_blank"><i class="{{ empty($academia->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a href="{{ empty($academia->instagram) ? '' : $academia->instagram}}" target="_blank"><i class="{{ empty($academia->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a href="{{ empty($academia->linkedin) ? '' : $academia->linkedin}}" target="_blank"><i class="{{ empty($academia->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a href="{{ empty($academia->youtube) ? '' : $academia->youtube}}" target="_blank"><i class="{{ empty($academia->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a href="{{ empty($academia->pagina_web) ? '' : $academia->pagina_web}}" target="_blank"><i class="{{ empty($academia->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p> -->

                </div>

            </div>

            <div class="pmo-block pmo-contact hidden-xs" style="padding-top:15px">
                            <p class="text-left f-15 f-700"> {{ number_format($recaudado, 2, '.' , '.') }} recaudado  

                            @if($cantidad == 0)

                            @elseif($cantidad == 1)
                            
                              por <br> {{$cantidad}}  patrocinador 
                            
                            @else

                              por <br> {{$cantidad}}  patrocinantes

                            @endif

                              </p>
                              <div class="clearfix"></div>

                     
                              <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                <div class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" id="barra-progreso" style="width: {{$porcentaje}}%;"></div>
                              </div>
                              <p class="text-center f-700" > {{$porcentaje}} % de {{ number_format($campana->cantidad, 2, '.' , '.') }}</p> 


                              <br>

                              <div class="text-center f-700" >Tiempo restante de la campaña</div>
                              <hr class="linea-morada opaco-0-8">

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

                          <!--  
                        Aqui Validamos que muestre las recompensas para contribuir
                        si el la sesion existe, de lo contrario solamente habra un
                        boton de contribucion para personas externas a la Aplicacion
                  -->

                      @foreach ($recompensas as $recompensa)

                      <div style="border: 1px solid;">
                      <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Recompensa</div>

                      
                    <div class="col-sm-12">
                        <span class="text-center f-25 f-700" >{{ number_format($recompensa->cantidad, 2, '.' , '.') }} </span> 
                        <br>
                        <span class="text-center f-20 f-700" > {{$recompensa->nombre}}</span> 
                        <br>
                        <span class="text-center f-15 f-700 opaco-0-8" > {{$recompensa->descripcion}}</span> 

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                    </div>

                        <span class="text-center">
                             <!--<button id="{{$recompensa->id}}" name ="{{$recompensa->id}}" class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa" data-toggle="modal" href="#modalAgregar" style="width:100%; padding:5px"> </i> Contribuir </button>-->

                            <button id="{{$recompensa->id}}" name ="{{$recompensa->id}}" class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa" style="width:100%; padding:5px"> </i> Contribuir </button>
                        </span>

                      </div>

                      <div class="clearfix p-b-15"></div>

                      @endforeach 

                      <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Otro monto a través de MercadoPago</div>

                        
                        <div class="col-sm-12">

                            <div class="clearfix p-b-15"></div>
                            <div class="text-center">
                            <i class="icon_a-pagar f-50"></i>
                            </div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                        <span class="text-center">

                            <button id="{{$campana->id}}" name ="{{$campana->id}}" class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa_otra" style="width:100%; padding:5px"> </i> Contribuir </button> 
                        </span>

                      </div>

                      <div class="clearfix p-b-15"></div>

                      <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Confirma tu pago aquí</div>

                        
                        <div class="col-sm-12">

                            <div class="clearfix p-b-15"></div>
                            <div class="text-center">
                            <i class="zmdi zmdi-check c-verde  zmdi-hc-5x"></i>
                            </div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                        <span class="text-center">

                            <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa_confirmar" style="width:100%; padding:5px"> </i> Confirmar </button> 
                        </span>

                      </div>
                  
                  

                  <!-- FIN CONDICION -->
    
            </div>

        </div>

        <div class="pm-body clearfix" id="id-tabs">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <!-- <ul class="tab-nav tn-justified" role="tablist">
                <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Campaña</a></li>
                <li class="waves-effect"><a href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab">Patrocinadores</a></li>
                <li class="waves-effect"><a href="#datos" aria-controls="datos" role="tab" data-toggle="tab">Datos Bancarios</a></li>


            </ul>
             -->
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

<!--                         <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/caracteristicas-principal.jpg"> -->
                      

                        <p class="text-center f-30 f-700 opaco-0-8" id="offset_nombre">{!! nl2br($campana->nombre) !!}</p>
                        <p class="text-center f-20 f-700 opaco-0-8">{!! nl2br($campana->eslogan) !!}</p>
                        
                        <div class="clearfix p-b-20"></div>

                        <div class="f-700 f-30">Historia</div>
                        <hr class='linea-morada'>
                        <p class="f-20">Emprendí un viaje a Colombia, específicamente al departamento de Risaralda en la ciudad de Pereira, con el objetivo de sumar fuerzas en el área de baile y gerencia de la academia <b>TU CLASE DE BAILE</b> y a su vez, validar el proyecto tecnológico de creación personal llamado <b>Easy Dance</b> que he venido forjando desde unos años atrás, (aplicación web para academias de baile) herramienta que sería estrenada formalmente con la academia <b>TU CLASE DE BAILE</b>.</p>

                        <p class="f-20">Al encontrarme en mis actividades diarias, sentía como fuertes dolores oprimían mi pecho y parte de mi espalda y decidí asistir al médico, pensando que era un problema muscular, pues este aparecía sólo al momento de exigirme físicamente, Entre consultas y exámenes pude darme por enterado que padecía de una enfermedad coronaria severa. Fue así que de manera muy rápida y en un cerrar de ojos me encontraba hospitalizado y sin oportunidad de volver a Venezuela.</p>

                        <p class="f-20">Después de haber sido sometido varios exámenes y a la práctica de un cateterismo fui valorado por el médico, el cual diagnosticó que habría que generarme la cirugía a corazón abierto, hoy día me encuentro esperando con mucha fe y optimismo que saldré adelante de esta dura prueba.</p>

                        <div class="clearfix p-b-20"></div>

                        <div class="f-700 f-30">Mi Perfil</div>
                        <hr class='linea-morada'>
                        <p class="f-20">Mi nombre es Robert Virona soy de la ciudad de Maracaibo y desde muy joven me apasioné por los bailes en especial los géneros latinos, por esa razón hace aproximadamente 20 años atrás decidí tomar un rumbo e iniciar mi carrera como bailador, con el paso del tiempo fui inclinando una profunda atención a los procesos y gerencia de las academias de baile, eventos y actividades en el que pude sentir una gran afinidad con el arte de gerenciar y organizar.</p>

                        <p class="f-20">Siempre me acompaña un deseo inmenso de superación y tengo la fortuna de ser un apasionado a los procesos de mejoramiento continuo, por eso utilizo la tecnología a mi favor para ser cada vez mejor, mis mejores fuentes de aprendizaje las consigo a través de la lectura y tutoriales que diariamente nos ofrece el internet , el cual , a mi juicio lo considero como la casa de estudio número 1 en el mundo , debido a la fuente de recursos y herramientas que te brinda para el crecimiento profesional.</p>


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

                        <div class="f-700 f-30">Logros Más Significativos</div>
                        <hr class='linea-morada'>

                        <p class="f-20">1.  Uno de los principales promotores  de la bailoterapia en el estado Zulia- Venezuela 1997</p>
                        <p class="f-20">2.  Pionero del estilo de baile de salsa casino en el estado Zulia- Venezuela 2005</p>
                        <p class="f-20">3.  Dirigió la academia de baile Habana Maracaibo por diez 10 años consecutivos (2005-2015)</p>
                        <p class="f-20">4.  Sub campeón nacional de salsa en Venezuela 2006</p>
                        <p class="f-20">5.  Seleccionado por la revista estampa Zuliana entre los 10 venezolanos más destacado del país en el año – 2008</p>
                        <p class="f-20">6.  Ganador del  Mara de Oro (2008)</p>
                        <p class="f-20">7.  Productor principal  del proyecto de la rueda de salsa casino más grande de Venezuela, superando la del record guiness en Cali Colombia. En Abril 2014 ,a través de AZUCA (Asociación Zuliana de Casineros del estado Zulia )</p>
                        <p class="f-20">8.  Productor general del evento festival de la gaita en el año 2014.</p>
                        <p class="f-20">9.  Productor del Reality show de baile llamado “la elite” 2015</p>
                        <p class="f-20">10. Fundador y ex -presidente de la asociación zuliana de salsa casino (2013-2015)</p>
                        <p class="f-20">11. Ha organizado evento con artistas nacionales e internacionales durante  varios años</p>
                        <p class="f-20">12.  Fundador de la primera aplicación  web en Latinoamérica  para el gremio del baile llamada Easy dance</p>

                        <div class="f-700 f-30">En clases bailando recientemente</div>
                        <hr class='linea-morada'>

                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/sNdOSfbqggU"></iframe>
                            </div>
                          </div>

                          <div class="clearfix p-b-35"></div>
                        

                    </div>

                </div>

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">

                        <p class="text-left f-30 opaco-0-8 f-700" id="offset_patrocinador" >Nuestros patrocinadores ángeles</p>
                        <hr class='linea-morada'>


                         <table class="table" id="tablelistar" >

                            <thead>
                                <tr class="hidden">    
                                    <th class="text-center" >Nombres</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                          
                                                 
                            @foreach ($patrocinadores as $patrocinador)
                                <?php $id = $patrocinador->id; ?>
                                <tr id="tablelistar" class="">
                                    <td class="p-10" >
                                      <div class="listview">
                                      <a class="lv-item" href="javascript:void(0)"  >
                                              <div class="media">
                                                  <div class="pull-left p-relative">
                                                      @if($patrocinador->sexo == 'F')
                                                        <img class="lv-img-sm" src="{{url('/')}}/assets/img/mujer.jpg" alt="">
                                                        <i class="chat-status-busy"></i>
                                                      @else
                                                        <img class="lv-img-sm" src="{{url('/')}}/assets/img/hombre.jpg" alt="">
                                                        <i class="chat-status-busy"></i>
                                                      @endif
                                                  </div>
                                                  <div class="col-sm-6">
                                                    <div class="media-body">
                                                        <div class="lv-title"><span class="c-morado">
                                                          {{ $patrocinador->Nombres }}
                                                        </span></div>
                                                        <!-- <small class="lv-small">hace 10 minutos</small> -->
                                                    </div>
                                                  </div>

                                                   <div class="col-sm-5">
                                                     <div class="pull-right p-relative">
                                                        <div class="lv-title"><span class="c-morado">{{ number_format($patrocinador->monto, 2, '.' , '.') }} BsF</span></div>
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

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="datos">

                 <div class="pmb-block m-t-0 p-t-0">


                        <p class="text-left f-30 opaco-0-8 f-700" id ="offset_datos" >Datos Bancarios</p>

                          <hr class='linea-morada'>

                          <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                <p class="text-left f-22 opaco-0-8 f-700">TRANSFERENCIAS O DEPÓSITOS  BANCARIOS EN VENEZUELA</p>
                                <hr class='linea-morada'>

                                <p class="text-left f-16 opaco-0-8 f-700"><span class="c-verde">✔</span> Banco Occidental de Descuento ( B.O.D ), Cuenta Corriente, No: 0116-0128-62-0007411502</p>
                                <p class="text-left f-16 opaco-0-8 f-700"><span class="c-verde">✔</span> Banco de Venezuela, Cuenta Corriente, No: 0102-0345-77-0000076241</p>
                                
                                <p class="text-left f-16 opaco-0-8 f-700">A nombre de: Richard Virona. Número de cédula 12.590.716</p>
                                
                                <div class="clearfix p-b-35"></div>

                                <p class="text-left f-22 opaco-0-8 f-700">TRANSFERENCIAS O DEPÓSITOS  BANCARIOS EN COLOMBIA</p>
                                <hr class='linea-morada'>
                                <p class="text-left f-16 opaco-0-8 f-700"><span class="c-verde">✔</span> Banco Davivienda, Cuenta de Ahorros, No: 126000663123. Energía Latina</p>

                                <div class="clearfix p-b-35"></div>

                                <p class="text-left f-22 opaco-0-8 f-700">APORTES EN EFECTIVO  DESDE EL EXTRANJERO</p>
                                <hr class='linea-morada'>
                                <p class="text-left f-16 opaco-0-8 f-700"><span class="c-verde">✔</span> Los aportes realizados en efectivo de cuentas del exterior hacia Colombia podrán ser realizados a través de Western Union a nombre de Helmer Morcillo 7 3141903</p>


                              </div>

                               <div class="clearfix p-b-35"></div>


                              <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre" id="id-aporte">Confirma tu pago aquí</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde aquí podras dejar los datos de tu transferencia o deposito"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <form name="form_normal" id="form_normal"  >
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="col-sm-12">
                                              <label for="id" id="id-nombre">Nombre y Apellido del contribuyente</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      
                                                      <input type="text" class="form-control input-sm input-mask" name="nombre" id="nombre" placeholder="Ej. Valeria Zambrano">

                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-nombre">
                                                    <span >
                                                        <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                 
                                              <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del contribuyente" title="" data-original-title="Ayuda"></i>

                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
                                                <div class="p-t-10">
                                              <label class="radio radio-inline m-r-20">
                                                  <input name="sexo" id="mujer" value="F" type="radio">
                                                  <i class="input-helper"></i>  
                                                  Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                              </label>
                                              <label class="radio radio-inline m-r-20 ">
                                                  <input name="sexo" id="hombre" value="M" type="radio">
                                                  <i class="input-helper"></i>  
                                                  Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                              </label>
                                              </div>
                                              </div>
                                           <div class="has-error" id="error-sexo">
                                                <span >
                                                    <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                                </span>
                                            </div>
                                         </div>

                                         <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                      <div class="form-group">
                                      <div class="form-group">
                                        <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto que deseas contribuir" title="" data-original-title="Ayuda"></i>
                                        
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="monto" id="monto" data-mask="000000000000000" placeholder="Ej. 5000">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-monto">
                                      <span >
                                          <small id="error-monto_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                        <div class="col-sm-12">
                                              <label for="id" id="id-nombre_banco">Identidad bancaria</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del banco" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_c-piggy-bank f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      
                                                      <input type="text" class="form-control input-sm input-mask" name="nombre_banco" id="nombre_banco" placeholder="Ej. Banco del Tesoro">

                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-nombre_banco">
                                                    <span >
                                                        <small id="error-nombre_banco_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-numero_cuenta">Número de transferencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el numero de cuenta" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="zmdi icon_c-money f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="numero_cuenta" id="numero_cuenta" data-mask="00000000000000000000" placeholder="Ingresa Número de Transferencia">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-numero_cuenta">
                                                    <span >
                                                        <small id="error-numero_cuenta_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-rif">Cédula - Pasaporte</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cedula o pasaporte del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="rif" id="rif" placeholder="Rif: J-298324278">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-rif">
                                                    <span >
                                                        <small id="error-rif_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>

                                          <div class="clearfix p-b-35"></div>

                                          <div class="col-sm-12">
                                              <label for="id" id="id-correo">Correo Electrónico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electronico del contribuyente" title="" data-original-title="Ayuda"></i>
                                                  <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                                     <div class="fg-line"> 
                                                      <input type="text" class="form-control input-sm input-mask" name="correo" id="correo" placeholder="Ej: easydance@gmail.com">
                                                      </div>
                                                    </div>
                                                  <div class="has-error" id="error-correo">
                                                    <span >
                                                        <small id="error-correo_mensaje" class="help-block error-span" ></small>                                           
                                                    </span>
                                                  </div>
                                              
                                          </div>


                                          <div class="clearfix p-b-35"></div>
                                          
                                          <input type="hidden" name="id" value="{{ $campana->id }}">

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


                                            <div class="col-sm-12 text-left">

                                              <button data-formulario="form_normal" type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                                            </div>
                                        </div></form>

                                        <div class="clearfix p-b-35"></div>
                                        <div class="clearfix p-b-35"></div>

                                        <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>
                                        
                                        <div class="clearfix p-b-35"></div>


                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>


                    </div>
                  </div>
                </div>

                <div class="clearfix p-b-35"></div>

                <!--     <ul class="fw-footer pagination wizard">
                        <li class="previous"><a class="a-prevent" href="" onclick="irArriba('tabs')" ><i class="zmdi zmdi-arrow-back"></i></a></li>
                        <li class="next"><a class="a-prevent" href="" onclick="irArriba('tabs')" ><i class="zmdi zmdi-arrow-forward"></i></a></li>
                    </ul>
 -->
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
<!-- </div>
 -->



@stop

@section('js') 
        

        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>
        <script src="{{url('/')}}/assets/js/soon.min.js" data-auto="false"></script>

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        //route_agregar="{{url('/')}}/especiales/campañas/contribuir";
        route_agregar="{{url('/')}}/especiales/campañas/contribuir/recompensa";
        route_agregar_unsign="{{url('/')}}/especiales/campañas/contribuir/campaña";
        route_agregar_contribucion="{{url('/')}}/especiales/campañas/contribuir/contribucion";
        route_enhorabuena="{{url('/')}}/especiales/campañas/contribuir/enhorabuena/";

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

              $('body,html').animate({scrollTop : 0}, 500);
              var animation = 'fadeInDownBig';
              //var cardImg = $(this).closest('#content').find('h1');
              if (animation === "hinge") {
              animationDuration = 3100;
              }
              else {
              animationDuration = 3200;
              }
              //$("h1").removeAttr('class');
              $(".container").addClass('animated '+animation);

                  setTimeout(function(){
                      $(".card-body").removeClass(animation);
                  }, animationDuration);
              $(".soon").soon({
                  due:"{{$campana->fecha_final}}",
                  //layout:"group"
                  layout:"group tight label-uppercase label-small",
                  format:"d,h,m,s",
                  face:"slot",
                  padding:"false",
                  visual:"ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0"
              });


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

              $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

                  A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
                }

            });
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

            $(".recompensa_confirmar").click(function(){
              $('#modalConfirmar').modal('show');
            })


            $(".guardar").click(function(){

                var route = route_agregar_contribucion;
                var token = $('input:hidden[name=_token]').val();
                var form = $(this).data('formulario');
                var datos = $( "#"+form ).serialize(); 
                
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          var nType = 'success';
                          $("#"+form)[0].reset();
                          $('#modalConfirmar').modal('hide');
                          window.location = route_enhorabuena + "{{$campana->id}}"
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          $('html,body').animate({
                            scrollTop: $("#id-aporte").offset().top-90,
                          }, 1000);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                      }, 1000);
                    }
                });
            });

        function limpiarMensaje(){
          var campo = ["nombre", "nombre_banco", "tipo_cuenta", "numero_cuenta", "correo", "rif"];
          fLen = campo.length;
          for (i = 0; i < fLen; i++) {
              $("#error-"+campo[i]+"_mensaje").html('');
          }
        }

      function errores(merror){
        $('#collapseTwo').collapse('show');
        var elemento="";
        var contador=0;
        $.each(merror, function (n, c) {
          if(contador==0){
          elemento=n;
          }
          contador++;

           $.each(this, function (name, value) {              
              var error=value;
              $("#error-"+n+"_mensaje").html(error);             
           });
        });

        $('html,body').animate({
              scrollTop: $("#id-"+elemento).offset().top-90,
        }, 1000); 

        $("#modalConfirmar").scrollTop(0);         

      }


        $(".recompensa").click(function(){   

          procesando();         
      
          recompensa = this.id;            
         
          var route=route_agregar+"/"+recompensa;             
          window.location=route;    
      
        });

         $(".recompensa_otra").click(function(){   

          procesando();         
      
          recompensa = this.id;            
  
          campana = "{{$campana->id}}"    
          var route=route_agregar_unsign+"/"+campana;   
          window.location=route;    
   
      
          });

        $(".a-prevent").click(function(){

          $('body,html').animate({scrollTop : 0}, 500);


        });

        function irArriba(elemento){
                $('html,body').animate({
                        scrollTop: $("#id-"+elemento).offset().top-90,
                }, 300); 
        }


        $('#tab_campana').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_nombre").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_patrocinador').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_patrocinador").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_datos').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_datos").offset().top-90,
                }, 1000);

          }, 1000);
        })

        </script>
@stop        