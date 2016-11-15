@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
    <!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet"> -->


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
                              <!-- <a class="btn-blanco2 btn-blanco1._largesubmit  m-r-5 f-16 " type="submit"   data-formulario="edit_cupo_taller" data-update="cupo" style=" margin-top: 20px; " >Enviar </a> -->

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
          <div class="col-sm-3" style="background: #f8f8f8 ; margin-left: 5px; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px">
                 
              <div class="pmo-block pmo-contact hidden-xs">
                  
                   <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                        <div class="header_cuadro_alumno_borde_morado text-left f-16 f-700">Agendar</div>
                        
                        <div class ="detalle">
                          @if($clases_grupales != 1)
                            <a href="{{url('/')}}/agendar/clases-grupales/disponibles/{{$academia->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clases-grupales f-20"></i> Clases Grupales <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$clases_grupales}}</span>
                              
                            @else
                              <a href="{{url('/')}}/agendar/clases-grupales/disponibles/{{$academia->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clases-grupales f-20"></i> Clase Grupal <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$clases_grupales}}</span>
                            @endif
                            </a> 
                          </div>
                          
                          <div class ="detalle">
                            <a href="{{url('/')}}/agendar/clases-personalizadas/progreso/{{$academia->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-clase-personalizada f-20"></i> Clases Personalizadas <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$clase_personalizada_contador}}</span>


                            </a>
                            </div>

                          <div class ="detalle">
                            @if($talleres != 1)
                            <a href="{{url('/')}}/agendar/talleres" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-talleres f-20"></i> Talleres <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$talleres}}</span>
                              
                            @else
                              <a href="{{url('/')}}/agendar/talleres" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-talleres f-20"></i> Taller <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$talleres}}</span>
                            @endif


                            </a>
                            </div>

                            <div class ="detalle">
                            <a href="{{url('/')}}/instructores" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-instructor f-15"></i> Instructores <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$instructor_contador}}</span>

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

                        <div class ="detalle">
                          
                          @if(count($regalos) != 1)
                          <a href="{{url('/')}}/especiales/regalos/progreso/{{$academia->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-tarjeta-de-regalo f-20"></i> Regalos <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{count($regalos)}}</span>
                            
                          @else
                            <a href="{{url('/')}}/especiales/regalos/progreso/{{$academia->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-tarjeta-de-regalo f-20"></i> Regalo <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{count($regalos)}}</span>
                          @endif
                            </a> </div>

                          <div class ="detalle">

                           @if($campanas != 1)
                          <a href="{{url('/')}}/especiales/campañas" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-campana f-20"></i> Campañas <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$campanas}}</span>
                            
                          @else
                            <a href="{{url('/')}}/especiales/campañas" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> <i class="icon_a-campana f-20"></i> Campaña <span style ="padding-right:5px" class ="pull-right opaco-0-8">{{$campanas}}</span>
                          @endif

                            </a> </div>

                          <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                    </div> <!-- ESPECIALES -->


                    <div class="clearfix p-b-15"></div>

                   <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                        <div class="header_cuadro_alumno_borde_morado text-left f-16 f-700">Proximas fecha de pago</div>

                       @foreach($proformas as $proforma)

                        <div class ="detalle">

                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> {{$proforma['nombre']}} </a> 
                        
                        </div>

                        <div class ="detalle">
                         
                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> {{$proforma['fecha_vencimiento']}} - {{ number_format($proforma['monto'], 2, '.' , '.') }}</a>
                        
                        </div>

                        <div class ="detalle">
                         
                          <a class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> Dias de Vencimiento : {{\Carbon\Carbon::createFromFormat('Y-m-d',$proforma['fecha_vencimiento'])->diffInDays(\Carbon\Carbon::now())}}</a>
                        
                        </div>

                        <div class="clearfix p-b-15"></div>

                        @endforeach

                          <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                  </div> <!-- ESPECIALES -->

                    <div class="clearfix p-b-15"></div>

                   <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff">
                      <div class="text-left f-16 f-700 header_cuadro_alumno_borde_morado">Evaluacion / Diagnostico</div>

                       @foreach($alumno_examenes as $examenes)
                        <div class ="detalle">
                          <a href="especiales/evaluaciones/detalle/{{$examenes->id}}" class="opaco-0-8 f-20" style="padding-left:5px; color:#5e5e5e"> {{$examenes->nombre}} </a> 
                        </div>
                        @endforeach

                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>
                    </div>
            
   
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

                <p class="f-25 f-700" style="color:#5e5e5e">{{$enlace['nombre']}}</p>
              

                @if($enlace['descripcion'])

                  <p class="f-15 f-700">{{ str_limit($enlace['descripcion'], $limit = 150, $end = '...') }}</p>

                @endif
                            
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



              <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span>

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

                  <!-- <div class="text-left pointer" style="border: 1px solid rgba(0, 0, 0, 0.1)">
                        <div style="width:100%; padding:5px; border-bottom: 1px solid rgba(0, 0, 0, 0.1)" class="text-left f-16 f-700">Consultarle al profesor</div>



                          <div class="col-sm-12">

                          <div class="clearfix p-b-15"></div>
                          <div class="text-center">
                          <i class="icon_a-pagar f-50"></i>
                          </div>
                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                          </div>

                      <span class="text-center">

                          <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 consulta_instructor" style="width:100%; padding:5px"> </i> Consultar </button> 
                      </span>


                    </div> 
 -->
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

        function configuracion(){
          window.location = "{{url('/')}}/perfil-evaluativo";
          }

          $(".consulta_instructor").click(function(){
            procesando();
            window.location = "{{url('/')}}/sugerencias/generar";
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
          window.location = "{{url('/')}}"+url;
        });


        $(document).on( 'click', '.mostrar', function () {

          $(".mostrar_mas").remove();

          var enlace = $.grep(enlaces, function(e){ return (e.contador >= inicio && e.contador <= final) });

          console.log(enlace);

          $.each(enlace, function (index, array) {

            $(".enlaces").append('<div class="text-left pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)"><div class="enlace" name="enlace" id="enlace" data-url="'+array.url+'"><div style="padding: 10px"><p class="f-25 f-700" style="color:#5e5e5e">'+array.nombre+'</p><p class="f-15 f-700">'+array.descripcion.substr(0, 150) + "..."+ '</p><img src="{{url('/')}}'+array.imagen+'" class="img-responsive" alt=""> <br</div></div><hr style="margin-bottom:5px"><div class="col-sm-3"><span class="f-13 f-700">Comparte</span><ul class="rrssb-buttons clearfix"><li class="rrssb-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}'+array.facebook+'" class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span><span class="rrssb-text"></span></a></li><li class="rrssb-twitter"><a href="https://twitter.com/intent/tweet?text='+array.twitter+' {{url('/')}}'+array.twitter_url+'"class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span><span class="rrssb-text"></span></a></li></ul></div><br><br><br></div>')


          });

          inicio = final;
          final = final + 4;

          if(inicio <= enlaces.length){

            $(".enlaces").append('<div class="text-center mostrar_mas"> <br><br> <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span> </div>');

          }

        });

        </script>
@stop        