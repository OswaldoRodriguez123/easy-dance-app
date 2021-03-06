@extends('layout.master2')

@section('css_vendor')
  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
  <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
@stop

@section('js_vendor')
  <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
  <script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

<meta content='{{$campana->nombre}}' property='og:title'/>
<meta name="description" content="{{$campana->historia}}" />
<meta property="og:description" content="{{$campana->historia}}" />

@if($campana->imagen)
  <meta content="{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}" property='og:image'/>
@endif

@section('content')


<div class="imagen_principal_progreso" style="background: url('{{url('/')}}/assets/uploads/campana/{{$campana->imagen}}'); background-repeat: no-repeat; background-size: cover; background-position: center;"></div>

    <div class="clearfix"></div>

    <div class="card" id="profile-main" style="margin-bottom: 0px">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
    
                    @if($academia->imagen)
                      <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                    @else
                      <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                    @endif
              

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                    <p class="text-center f-700" >Compartir en</p>

                    <ul class="rrssb-buttons clearfix">

                      <li class="rrssb-facebook">
                        <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header: https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/especiales/campa??as/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>

                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Ayuda a que la campa??a {{$campana->nombre}} se haga realidad en @EasyDanceLatino {{url('/')}}/especiales/campa??as/progreso/{{$id}}"
                        class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                          <span class="rrssb-text">twitter</span>
                        </a>
                      </li>
                    </ul>

                    <br>

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
                    <p class="text-center f-700" > {{$porcentaje}} % de???{{ number_format($campana->cantidad, 2, '.' , '.') }}</p> 

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
                            
              <div class="text-center f-700" >Tiempo restante de la campa??a</div>
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

                      @if($activa)
                        @if(Auth::check())
                          @foreach ($recompensas as $recompensa)

                            <div style="border: 1px solid;">
                              <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">
                                Recompensa
                              </div>

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
                        @endif
                      @endif

<!--                       <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Paga con MercadoPago</div>

                        
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

                      </div> -->
                  
                  

                  <!-- FIN CONDICION -->
    
            </div>
        </div>

        <div class="pm-body clearfix" id="id-tabs">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <!-- <ul class="tab-nav tn-justified" role="tablist">
                  <li class="active waves-effect"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Campa??a</a></li>
                  <li class="waves-effect"><a href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab">Patrocinadores</a></li>
                  <li class="waves-effect"><a href="#datos" aria-controls="datos" role="tab" data-toggle="tab">Datos Bancarios</a></li>
                </ul>
             -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">
                <div class="pmb-block m-t-0 p-t-0">
                  
                    <p class="text-center f-30 f-700 opaco-0-8" id="offset_nombre">{!! nl2br($campana->nombre) !!}</p>
                    <p class="text-center f-20 f-700 opaco-0-8">{!! nl2br($campana->eslogan) !!}</p>
                    
                    <div class="clearfix p-b-20"></div>

                    @if($campana->historia)

                      <div class="f-700 f-30">Historia</div>
                      <hr class='linea-morada'>

                      <p class="text-center f-20">{!! nl2br($campana->historia) !!}</p>

                    @endif
                    

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

                    @if($campana->presentacion)

                      <div class="f-700 f-30">Presentaci??n general de la campa??a</div>
                      <hr class='linea-morada'>

                      @if($campana->imagen_presentacion)
                        <img src="{{url('/')}}/assets/uploads/campana/{{$campana->imagen_presentacion}}" class="img-responsive opaco-0-8" alt="">
                      @endif

                      <br>

                      <p class="text-center f-20">{!! nl2br($campana->presentacion) !!}</p>

                    @endif


                    <div class="clearfix p-b-35"></div>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">
                <div class="pmb-block m-t-0 p-t-0">
                  <p class="text-left f-30 opaco-0-8 f-700" id="offset_patrocinador" >Nuestros patrocinadores</p>
                  <hr class='linea-morada'>

                  <div class="col-sm-6 text-left">
                    <label class="c-morado f-15">Selecciona la clase grupal</label>
                    <div class="select">
                      <select class="selectpicker" name="clase_grupal_id" id="clase_grupal_id" data-live-search="true" data-container="body">
                          <option value = "0">Todas</option>
                          @foreach ( $clases_grupales as $clase_grupal )
                            <option value = "{{ $clase_grupal['id'] }}"> {{ $clase_grupal['nombre'] }} - {{ $clase_grupal['hora_inicio'] }}  / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia'] }} - {{ $clase_grupal['instructor_nombre'] }}  {{ $clase_grupal['instructor_apellido'] }} </option>

                          @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="clearfix"></div>

                  <div class="table-responsive row">
                    <div class="col-sm-12">
                      <table class="table table-striped table-bordered" id="tablelistar" >

                        <thead>
                            <tr>    
                                <th data-column-id="imagen"></th> 
                                <th data-column-id="nombre">Nombre</th>
                                <th data-column-id="monto" class="text-right">Cantidad</th>
                                <th data-column-id="cantidad" class="text-right">Cantidad</th>                                  
                            </tr>
                        </thead>

                        <tbody>
                                   
                          @foreach ($patrocinadores as $patrocinador)
                            <?php $id = $patrocinador['id']; ?>
                            <tr id="{{$id}}" class="p-10"">
                              <td>
                                <div class="pull-left p-relative">
                                  <span style="display:none">{{$patrocinador['clase_grupal_id']}}</span>
                                  @if($patrocinador['imagen'])
                                    <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$patrocinador['imagen']}}" alt="">
                                  @else
                                    @if($patrocinador['sexo'] == 'F')
                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                    @else
                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                    <!--              
                                    elseif($patrocinador[''] == 'M')
                                      
                                    elseif($patrocinador->sexo == 'FA')
                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/Familia.jpg" alt="">
                                    elseif($patrocinador->sexo == 'O')
                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/Empresa.jpg" alt="">
                                    else
                                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/Anonimo.jpg" alt=""> -->
                                    @endif
                                  @endif
                                </div>
                              </td>

                              <td>
                                <p class="lv-title c-morado">
                                  {{ $patrocinador['Nombres']}}
                                </p>
                                <small class="lv-small">{{$fecha_de_realizacion[$id]}}</small>
                              </td>

                              
                              <td>

                                <div class="pull-right p-relative">
                                  <span class="c-morado">

                                    {{$patrocinador['cantidad']}}
                                  </span>
                                </div>

                              </td>

                              <td>
                                <div class="pull-right p-relative">
                                  <span class="c-morado">{{ number_format($patrocinador['monto'], 2, '.' , '.') }} 
                                    @if($patrocinador['tipo_moneda'] == 1)

                                      Pesos

                                    @elseif($patrocinador['tipo_moneda'] == 2)

                                      USD

                                    @else

                                      BsF

                                    @endif

                                  </span>
                                </div>
                              </td>
                            </tr>
                          @endforeach 
                                                       
                        </tbody>
                    </table>
                  </div>
                </div>

                
              </div>
              </div>
              <div role="tabpanel" class="tab-pane animated fadeInUp in" id="rango_grupos">
                <div class="pmb-block m-t-0 p-t-0">
                  <p class="text-left f-30 opaco-0-8 f-700" id="offset_grupo">Rango de los grupos</p>
                  <hr class='linea-morada'>
                
                  @foreach($array_progreso as $key => $clase_grupal)
                    
                    <div id="{{$clase_grupal['id']}}" class="pointer opaco-0-8 progreso" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                      @if($clase_grupal['imagen'])
                      <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clase_grupal['imagen']}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                      @else

                      <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                      @endif

                      <div class="col-sm-7">

                      <p class="f-25 f-700" style="color:#5e5e5e">{{$clase_grupal['nombre']}}</p>


                      <p class="f-15 f-700">{{$clase_grupal['hora_inicio']}} - {{$clase_grupal['hora_final']}} / {{$clase_grupal['dia']}} / {{$clase_grupal['instructor_nombre']}} {{$clase_grupal['instructor_apellido']}} 

                      @if($clase_grupal['instructor_imagen'])
                        <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$clase_grupal['instructor_imagen']}}" alt="">
                      @else
                        @if($clase_grupal['sexo'] == 'F')
                          <img class="lv-img-sm" src="{{url('/')}}/assets/img/Mujer.jpg" alt="">
                        @else
                          <img class="lv-img-sm" src="{{url('/')}}/assets/img/Hombre.jpg" alt="">
                        @endif
                      @endif
                      </p>

                      <p class="f-15 f-700">Cantidad Recaudadada: {{ number_format($clase_grupal['cantidad_recaudada'], 2, '.' , '.') }}</p>


                      </div>

                      <div class="col-sm-3 text-center">

                      <div style="padding-top: 50px">
                        <div class="rating-list text-center">
                          <div class="rl-star">

                            <span class="f-15 m-r-5">
                              @if($key == 0)
                                1er Lugar
                              @elseif($key == 1)
                                2do Lugar
                              @elseif($key == 2)
                                3er Lugar
                              @elseif($key == 3)
                                4to Lugar
                              @elseif($key == 4)
                                5to Lugar
                              @endif
                            </span>
                            <br>
                            @if($key <= 4)
                              <i class="zmdi zmdi-star active"></i>
                            @endif
                            @if($key <= 3)
                              <i class="zmdi zmdi-star active"></i>
                            @endif
                            @if($key <= 2)
                              <i class="zmdi zmdi-star active"></i>
                            @endif
                            @if($key <= 1)
                              <i class="zmdi zmdi-star active"></i>
                            @endif
                            @if($key <= 0)
                              <i class="zmdi zmdi-star active"></i>
                            @endif
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="clearfix"></div>
                  </div>

                @endforeach
                <div class="clearfix p-b-35"></div>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane animated fadeInUp in" id="invitar">
                <div class="pmb-block m-t-0 p-t-0">
                  <p class="text-left f-30 opaco-0-8 f-700" id="offset_invitar" >Invitar</p>
                    <hr class='linea-morada'>

                    <form name="formInvitacion" id="formInvitacion">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input name="id" value="{{$campana->id}}" type="hidden">
                      <div class="col-sm-6">
                        <label id="id-invitacion_nombre">Ingresa tu nombre </label>
                        <div class="input-group input-group-lg">
                          <span class="input-group-addon"><i class="icon_b icon_b-nombres"></i></span>
                          <div class="fg-line">
                              <input class="form-control input-lg" name="invitacion_nombre" id="invitacion_nombre" placeholder="ej: Valeria" required="required">
                          </div>
                        </div>
                        <div class="has-error" id="error-invitacion_nombre">
                          <span >
                              <small class="help-block error-span" id="error-invitacion_nombre_mensaje" ></small>      
                          </span>
                        </div>
                      </div>
                    </form>

                    <div class="clearfix p-b-35"></div>

                    <form name="formComparte" id="formComparte" class="">
                      <div class="col-sm-6">
                        <label id="id-nombre_invitado">Ingresa el nombre de la persona </label>
                        <div class="input-group input-group-lg">
                          <span class="input-group-addon"><i class="icon_b icon_b-nombres"></i></span>
                          <div class="fg-line">
                            <input class="form-control input-lg" name="nombre_invitado" id="nombre_invitado" placeholder="ej: Valeria" required="required">
                          </div>
                        </div>
                        <div class="has-error" id="error-nombre_invitado">
                          <span >
                            <small class="help-block error-span" id="error-nombre_invitado_mensaje" ></small>             
                          </span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label id="id-correo_invitado">Ingresa su correo electr??nico </label>
                      <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                        <div class="fg-line">
                          <input class="form-control input-lg" name="correo_invitado" id="correo_invitado" placeholder="ej: info@easydancelatino.com" type="email" required="required">
                          <input type="hidden" value="" id="alm-email">
                        </div>
                      </div>
                      <div class="has-error" id="error-correo_invitado">
                        <span >
                          <small class="help-block error-span" id="error-correo_invitado_mensaje" ></small>      
                        </span>
                      </div>
                    </div>
                  </form>

                  <div class="clearfix p-b-35"></div>
                  <div class="clearfix p-b-35"></div>

                  <div class="col-sm-2">
                    <button type="button" class="btn btn-blanco m-r-8 f-10" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                  </div>

                  <div class="col-sm-4">
                    <div class="has-error" id="error-linea">
                          <span >
                            <small class="help-block error-span" id="error-linea_mensaje" ></small> 
                          </span>
                      </div>
                  </div>

                  <div class="clearfix p-b-35"></div>
                  <div class="clearfix p-b-35"></div>
                

                  <div class="table-responsive row">
                     <div class="col-md-12">
                      <table class="table table-striped table-bordered text-center " id="tablea??adir" >
                        <thead>
                            <tr>
                                <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                <th class="text-center" data-column-id="correo">Correo</th>
                                <th class="text-center" data-column-id="operacion">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                                       
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="clearfix p-b-35"></div>
                  <div class="clearfix p-b-35"></div>

                  <div class="block-header text-right">
                      <a class="btn-blanco m-r-10 f-25 pointer" id="guardar_invitacion"> Enviar</a>
                  </div>
                </div>
              </div>


              <!-- DATOS BANCARIOS -->

              <div role="tabpanel" class="tab-pane animated fadeInUp in" id="datos">
                <div class="pmb-block m-t-0 p-t-0">
                  <p class="text-left f-30 opaco-0-8 f-700" id ="offset_datos" >Datos Bancarios</p>
                  <hr class='linea-morada'>

                  <div class="clearfix p-b-35"></div>
                  <div class="col-sm-12">
                    <p class="text-left f-22 opaco-0-8 f-700">TRANSFERENCIAS O DEP??SITOS BANCARIOS</p>
                    <hr class='linea-morada'>

                    @foreach($datos as $dato)
                      <p class="text-left f-16 opaco-0-8 f-700"><span class="c-verde">???</span> {{$dato->nombre_banco}}, {{$dato->tipo_cuenta}}, No: {{$dato->numero_cuenta}}</p>
                      <p class="text-left f-16 opaco-0-8 f-700">A nombre de: {{$dato->nombre}}. N??mero de c??dula: {{$dato->rif}}</p>
                      <div class="clearfix p-b-35"></div>
                    @endforeach
                  </div>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane animated fadeInUp in" id="pago">
                <div class="pmb-block m-t-0 p-t-0">
                  <p class="text-left f-30 opaco-0-8 f-700" id ="offset_pago" >Confirma tu Aporte</p>
                  <hr class='linea-morada'>
                  <div class="clearfix p-b-35"></div>
                  <form name="form_normal" id="form_normal">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input name="form" value="2" type="hidden">
                    <input name="id" value="{{$campana->id}}" type="hidden">

                    <div class="col-sm-12" style="padding:0px">
               
                      <label for="apellido" id="id-tipo_contribuyente">Tipo de Contribuyente</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

                      <div class="input-group">
                        <div class="p-t-10">
                          <label class="radio radio-inline m-r-20">
                            <input checked="checked" name="tipo_contribuyente" id="particular" value="1" type="radio">
                            <i class="input-helper"></i>  
                            Particular 
                          </label>
                          <label class="radio radio-inline m-r-20 ">
                            <input name="tipo_contribuyente" id="familia" value="2" type="radio">
                            <i class="input-helper"></i>  
                            Familia
                          </label>
                          <label class="radio radio-inline m-r-20 ">
                            <input name="tipo_contribuyente" id="organizacion" value="3" type="radio">
                            <i class="input-helper"></i>  
                            Organizaci??n
                          </label>
                          <label class="radio radio-inline m-r-20 ">
                              <input name="tipo_contribuyente" id="anonimo" value="4" type="radio">
                              <i class="input-helper"></i>  
                              An??nimo
                          </label>
                        </div>
                      </div>
                      <div class="has-error" id="error-tipo_contribuyente">
                        <span>
                            <small class="help-block error-span" id="error-tipo_contribuyente_mensaje"></small>
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" id="div_nombre" style="padding: 0px">

                      <div class="clearfix p-b-35"></div>

                      <label for="id" id="id-nombre">Nombre y Apellido</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el nombre del contribuyente" title="" data-original-title="Ayuda"></i>

                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                        <div class="fg-line"> 
                          <input class="form-control input-sm input-mask" name="nombre" id="nombre" placeholder="Ej: Valeria Zambrano" type="text">
                        </div>
                      </div>
                      <div class="has-error" id="error-nombre">
                        <span>
                            <small id="error-nombre_mensaje" class="help-block error-span"></small> 
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" id="div_sexo" style="padding: 0px">
                      <div class="clearfix p-b-35"></div>
           
                      <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Selecciona el sexo del contribuyente" title="" data-original-title="Ayuda"></i>

                      <div class="input-group">
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
                        <span>
                          <small class="help-block error-span" id="error-sexo_mensaje"></small>                                
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" id="div_correo" style="padding: 0px">

                      <div class="clearfix p-b-35"></div>

                      <label for="id" id="id-correo">Correo Electr??nico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el correo electronico del contribuyente" title="" data-original-title="Ayuda"></i>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                        <div class="fg-line"> 
                          <input class="form-control input-sm input-mask" name="correo" id="correo" placeholder="Ej: easydance@gmail.com" type="text">
                        </div>
                      </div>
                      <div class="has-error" id="error-correo">
                        <span>
                          <small id="error-correo_mensaje" class="help-block error-span"></small>                                           
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" id="div_telefono" style="padding: 0px">

                      <div class="clearfix p-b-35"></div>

                      <label for="id" id="id-telefono">N??mero Telef??nico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el n??mero telef??nico del contribuyente" title="" data-original-title="Ayuda"></i>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                        <div class="fg-line"> 
                          <input autocomplete="off" maxlength="13" class="form-control input-sm input-mask" data-mask="(000)000-0000" name="telefono" id="telefono" placeholder="Ej: (426)367-0894" type="text">
                        </div>
                      </div>
                      <div class="has-error" id="error-telefono">
                        <span>
                          <small id="error-telefono_mensaje" class="help-block error-span"></small>                                           
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" id="div_coordinador" style="padding: 0px">

                      <div class="clearfix p-b-35"></div>

                      <label for="id" id="id-coordinador">Coordinador</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el nombre del coordinador de la organizaci??n" title="" data-original-title="Ayuda"></i>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                        <div class="fg-line"> 
                          <input class="form-control input-sm input-mask" name="coordinador" id="coordinador" placeholder="Ej. Valeria Zambrano" type="text">
                        </div>
                      </div>
                      <div class="has-error" id="error-coordinador">
                        <span>
                          <small id="error-coordinador_mensaje" class="help-block error-span"></small>  
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" style="padding:0px">

                      <div class="clearfix p-b-35"></div>

                      <div class="form-group">
                        <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el monto que deseas contribuir" title="" data-original-title="Ayuda"></i>
                        
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                          <div class="fg-line">
                            <input autocomplete="off" maxlength="15" class="form-control input-sm input-mask" name="monto" id="monto" data-mask="000000000000000" placeholder="Ej. 5000" type="text">
                          </div>
                        </div>
                        <div class="has-error" id="error-monto">
                          <span>
                              <small id="error-monto_mensaje" class="help-block error-span"></small>
                          </span>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12" style="padding:0px">

                      <div class="clearfix p-b-35"></div>
         
                      <label for="apellido" id="id-tipo_moneda">Moneda</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Selecciona el tipo de moneda" title="" data-original-title="Ayuda"></i>

                      <div class="input-group">
                        <div class="p-t-10">
                          <label class="radio radio-inline m-r-20">
                            <input checked="checked" name="tipo_moneda" id="pesos" value="1" type="radio">
                            <i class="input-helper"></i>  
                            Pesos 
                          </label>
                          <label class="radio radio-inline m-r-20 ">
                            <input name="tipo_moneda" id="dolares" value="2" type="radio">
                            <i class="input-helper"></i>  
                            Dolares
                          </label>
                        </div>
                      </div>
                      <div class="has-error" id="error-tipo_moneda">
                        <span>
                          <small class="help-block error-span" id="error-tipo_moneda_mensaje"></small>                                
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-12" style="padding:0px">

                      <div class="clearfix p-b-35"></div>
         
                      <label for="apellido" id="id-tipo_cuenta">Tipo de Pago</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

                      <div class="input-group">
                        <div class="p-t-10">
                          <label class="radio radio-inline m-r-20">
                            <input name="tipo_cuenta" id="efectivo" value="1" checked="checked" type="radio">
                            <i class="input-helper"></i>  
                            Efectivo 
                          </label>
                          <label class="radio radio-inline m-r-20 ">
                            <input name="tipo_cuenta" id="transferencia" value="2" type="radio">
                            <i class="input-helper"></i>  
                            Transferencia
                          </label>
                        </div>
                      </div>
                      <div class="has-error" id="error-tipo_cuenta">
                        <span>
                          <small class="help-block error-span" id="error-tipo_cuenta_mensaje"></small>                                
                        </span>
                      </div>
                    </div>

                      <div class="col-sm-12" id="div_identidad" style="padding: 0px">

                        <div class="clearfix p-b-35"></div>

                        <label for="id" id="id-nombre_banco">Identidad bancaria</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el nombre del banco" title="" data-original-title="Ayuda"></i>

                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon_c-piggy-bank f-22"></i></span>
                          <div class="fg-line"> 
                            <input class="form-control input-sm input-mask" name="nombre_banco" id="nombre_banco" placeholder="Ej. Banco del Tesoro" type="text">
                          </div>
                        </div>
                        <div class="has-error" id="error-nombre_banco">
                          <span>
                            <small id="error-nombre_banco_mensaje" class="help-block error-span"></small>
                          </span>
                        </div>
                      </div>

                      <div class="col-sm-12" id="div_numero" style="padding: 0px">

                        <div class="clearfix p-b-35"></div>

                        <label for="id" id="id-numero_cuenta">N??mero de transferencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Ingresa el numero de transferencia" title="" data-original-title="Ayuda"></i>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="zmdi icon_c-money f-22"></i></span>
                          <div class="fg-line"> 
                            <input autocomplete="off" maxlength="20" class="form-control input-sm input-mask" name="numero_cuenta" id="numero_cuenta" data-mask="00000000000000000000" placeholder="Ingresa N??mero de Transferencia" type="text">
                          </div>
                        </div>
                        <div class="has-error" id="error-numero_cuenta">
                          <span>
                            <small id="error-numero_cuenta_mensaje" class="help-block error-span"></small>  
                          </span>
                        </div>
                      </div>

                      <div class="clearfix p-b-35"></div>

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
                          <button data-formulario="form_normal" type="button" class="btn btn-blanco m-r-10 f-18 guardar waves-effect" id="guardar">Guardar</button>
                        </div>
                      </div>
                  </form>
                    
                  <div class="clearfix p-b-35"></div>
                </div>
              </div>

              <div class="clearfix p-b-35"></div>
              <!--
              <ul class="fw-footer pagination wizard">
                <li class="previous"><a class="a-prevent" href="" onclick="irArriba('tabs')" ><i class="zmdi zmdi-arrow-back"></i></a></li>
                <li class="next"><a class="a-prevent" href="" onclick="irArriba('tabs')" ><i class="zmdi zmdi-arrow-forward"></i></a></li>
              </ul>-->
              <footer id="footer" style="position:relative">
                <div class="p-10 footer-text">
                  <p><b><a href="http://easydancelatino.com/" target="_blank">www.easydancelatino.com</a></b></p> 
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
              </footer>

              <br><br>


          </div> <!-- Tab Content -->
        </div>
      </div><!-- Tab Nav end -->
    </div>
  </div>
<!-- </div>
 -->



@stop

@section('js') 
        
        
  <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>
  <script src="{{url('/')}}/assets/js/soon.min.js" data-auto="false"></script>

  <script type="text/javascript">

  //route_agregar="{{url('/')}}/especiales/campa??as/contribuir";
  route_agregar="{{url('/')}}/especiales/campa??as/contribuir/recompensa";
  route_agregar_unsign="{{url('/')}}/especiales/campa??as/contribuir/campa??a";
  route_agregar_contribucion="{{url('/')}}/especiales/campa??as/contribuir/contribucion";
  route_enhorabuena="{{url('/')}}/especiales/campa??as/contribuir/enhorabuena/";

  route_enviar_invitacion="{{url('/')}}/especiales/campa??as/invitar";
  route_agregar_invitacion="{{url('/')}}/especiales/campa??as/invitar/agregar";
  route_eliminar_invitacion="{{url('/')}}/especiales/campa??as/invitar/eliminar";
  route_enhorabuena_invitacion="{{url('/')}}/especiales/campa??as/invitacion/enhorabuena/";
  route_progreso_clase_grupal="{{url('/')}}/especiales/campa??as/progreso/clases-grupales/";

  var recompensa = 0;

  $(document).ready(function() {

    $("#form_normal")[0].reset();
    $('#div_numero').hide();
    $('#div_identidad').hide();
    $('#div_coordinador').hide();

    $("#navbar li a").click(function(event) {
       $('.navbar-collapse').collapse('hide');
    });

    $('body,html').animate({scrollTop : 0}, 500);
    var animation = 'fadeInDownBig';
    if (animation === "hinge") {
      animationDuration = 3100;
    }
    else {
      animationDuration = 3200;
    }
    $(".container").addClass('animated '+animation);

    setTimeout(function(){
      $(".card-body").removeClass(animation);
    }, animationDuration);

    $(".soon").soon({
      due:"{{$campana->fecha_final}}",
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

    $('.glyphicon').css('top','10px')
  });

  var t=$('#tablelistar').DataTable({
    processing: true,
    serverSide: false, 
    // bPaginate: false, 
    bInfo:false,
    pageLength: 25,
    fnDrawCallback: function() {

      $('#tablelistar_length').hide();
 
    },
    language: {
      processing:     "Procesando ...",
      search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
      lengthMenu:     "Mostrar _MENU_ Registros",
      info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
      infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
      infoFiltered:   "(filtrada de _MAX_ registros en total)",
      infoPostFix:    "",
      loadingRecords: "...",
      zeroRecords:    "No se encontraron registros coincidentes",
      emptyTable:     "No hay datos disponibles en la tabla",
      paginate: {
          first:      "Primero",
          previous:   "Anterior",
          next:       "Siguiente",
          last:       "Ultimo"
      },
      aria: {
          sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
          sortDescending: ": habilitado para ordenar la columna en orden descendente"
      }
    }
  });

  var h=$('#tablea??adir').DataTable({
    processing: true,
    serverSide: false, 
    bPaginate: false, 
    bFilter:false, 
    bSort:false, 
    bInfo:false,
    order: [[0, 'asc']],
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
    },
    language: {
      processing:     "Procesando ...",
      search:         "Buscar:",
      lengthMenu:     "Mostrar _MENU_ Registros",
      info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
      infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
      infoFiltered:   "(filtrada de _MAX_ registros en total)",
      infoPostFix:    "",
      loadingRecords: "...",
      zeroRecords:    "No se encontraron registros coincidentes",
      emptyTable:     "No hay datos disponibles en la tabla",
      paginate: {
          first:      "Primero",
          previous:   "Anterior",
          next:       "Siguiente",
          last:       "Ultimo"
      },
      aria: {
          sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
          sortDescending: ": habilitado para ordenar la columna en orden descendente"
      }
    }
  });

  $(".recompensa_confirmar").click(function(){
    $('#modalConfirmar').modal('show');
  })


  $(".guardar").click(function(){
    var route = route_agregar_contribucion;
    var token = $('input:hidden[name=_token]').val();
    var form = $(this).data('formulario');
    var datos = $( "#form_normal" ).serialize();

    procesando();
    limpiarMensaje();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
        success:function(respuesta){
          setTimeout(function(){ 
            if(respuesta.status=="OK"){
              $("#form_normal")[0].reset();
              window.location = route_enhorabuena + "{{$campana->id}}"
            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }                      
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
            finprocesado();
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

  $("#guardar_invitacion").click(function(){

    var route = route_enviar_invitacion;
    var token = $('input:hidden[name=_token]').val();
    var datos = $( "#formInvitacion" ).serialize(); 
    procesando();     
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
              // finprocesado();
              // var nType = 'success';
              // $("#agregar_alumno")[0].reset();
              // var nTitle="Ups! ";
              // var nMensaje=respuesta.mensaje;
              window.location = route_enhorabuena_invitacion;
            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              finprocesado();
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }                       
          }, 1000);
        },
        error:function(msj){
          setTimeout(function(){ 
             if (typeof msj.responseJSON === "undefined") {
              window.location = "{{url('/')}}/error";
            }
            if(msj.responseJSON.status=="ERROR"){
              console.log(msj.responseJSON.errores);
              errores(msj.responseJSON.errores);
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
            }else{
              var nTitle="   Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            }                        
            finprocesado();
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
    var campo = ["nombre", "nombre_banco", "tipo_cuenta", "numero_cuenta", "correo", "telefono", "nombre_invitado", "correo_invitado", "invitacion_nombre", "linea", "monto", "coordinador", "sexo"];
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
      window.open(route, '_blank');;    
  
    });

    $(".recompensa_otra").click(function(){   

      procesando();         

      recompensa = this.id;            

      campana = "1"    
      var route=route_agregar_unsign+"/"+campana;   
      window.open(route, '_blank');;    

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

    $('#tab_grupo').click(function (){
      setTimeout(function(){ 
        $('html,body').animate({
          scrollTop: $("#offset_grupo").offset().top-90,
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

    $('#tab_invitar').click(function (){
      setTimeout(function(){ 
        $('html,body').animate({
          scrollTop: $("#offset_invitar").offset().top-90,
        }, 1000);
      }, 1000);
    })

    $('#tab_pago').click(function (){
      setTimeout(function(){ 
        $('html,body').animate({
          scrollTop: $("#offset_pago").offset().top-90,
        }, 1000);
      }, 1000);
    })


    $("#add").click(function(){
      $("#add").attr("disabled","disabled");
      $("#add").css({
        "opacity": ("0.2")
      });

      $("#guardar_invitacion").attr("disabled","disabled");
        $("#guardar_invitacion").css({
          "opacity": ("0.2")
      });

      var route = route_agregar_invitacion;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#formComparte").serialize(); 
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

                 $('html,body').animate({
                    scrollTop: $("#tablea??adir").offset().top-90,
                  }, 1000);

                $("#formComparte")[0].reset();
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                var nombre = respuesta.array[0].nombre;
                var email = respuesta.array[0].email;

                var rowId=respuesta.id;
                var rowNode=h.row.add( [
                ''+nombre+'',
                ''+email+'',
                '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                .attr('id',rowId)
                .addClass('seleccion');

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }

              $("#guardar_invitacion").removeAttr("disabled");
              $("#add").removeAttr("disabled");
              $("#add").css({
                "opacity": ("1")
              });
              $("#guardar_invitacion").css({
                "opacity": ("1")
              });

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }, 1000);
          },
          error:function(msj){
            setTimeout(function(){ 
               if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              if(msj.responseJSON.status=="ERROR"){
                errores(msj.responseJSON.errores);
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle="   Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }                        
              $("#guardar_invitacion").removeAttr("disabled");
              $("#guardar_invitacion").css({
                "opacity": ("1")
              });
              $("#add").removeAttr("disabled");
                $("#add").css({
                  "opacity": ("1")
                });
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

    $('#tablea??adir tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
      $.ajax({
        url: route_eliminar_invitacion+"/"+id,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',                
        success: function (data) {
          if(data.status=='OK'){

              
          }else{
            swal(
              'Solicitud no procesada',
              'Ha ocurrido un error, intente nuevamente por favor',
              'error'
            );
          }
        },
        error:function (xhr, ajaxOptions, thrownError){
          swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
        }
      })

      h.row( $(this).parents('tr') )
        .remove()
        .draw();
    });   

    $("input[name=tipo_cuenta]").change(function(){
      limpiarMensaje();

      if($(this).val() == 1){
        $('#numero_cuenta').val('');
        $('#nombre_banco').val('');
        $('#div_identidad').hide();
        $('#div_numero').hide()
      }else{
        $('#div_identidad').show();
        $('#div_numero').show()
      }
    });

    $("input[name=tipo_contribuyente]").change(function(){

      limpiarMensaje();

      if($(this).val() == 1){
        $('#id-nombre').text('Nombre y Apellido');
        $('#nombre').attr('placeholder','Ej: Valeria Zambrano');
        $('#div_nombre').show();
        $('#div_sexo').show();
        $('#div_correo').show();
        $('#div_telefono').show();
        $('#div_coordinador').hide();

      }
      else if($(this).val() == 2){
        $('#id-nombre').text('Apellidos');
        $('#nombre').attr('placeholder','Ej: Zambrano Rivera');
        $('#div_nombre').show();
        $('#div_sexo').hide();
        $('#div_correo').show();
        $('#div_telefono').show();
        $('#div_coordinador').hide();
      }else if($(this).val() == 3){
        $('#id-nombre').text('Nombre');
        $('#nombre').attr('placeholder','Ej: Habana Maracaibo');
        $('#div_nombre').show();
        $('#div_sexo').hide();
        $('#div_correo').show();
        $('#div_telefono').show();
        $('#div_coordinador').show();
      }else{
        $('#div_nombre').hide();
        $('#div_sexo').hide();
        $('#div_correo').hide();
        $('#div_telefono').hide();
        $('#div_coordinador').hide();
      }

    });

    $('#clase_grupal_id').on('change', function(){

        if($(this).val() == 0){
            t
            .columns(0)
            .search('')
            .draw(); 

        }else{
            t
            .columns(0)
            .search($(this).val())
            .draw();
        }

    });

    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)

      $(".progreso").click(function(){
        var id = $(this).attr('id');
        var route = route_progreso_clase_grupal+id+'-{{$campana->id}}';
        window.open(route, '_blank');
      });
    @endif

  </script>
@stop        