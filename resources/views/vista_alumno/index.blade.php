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
    <div class="card">
    <div class="card-body p-b-20">
      <div class="row p-l-10 p-r-10">
          <div class="col-sm-3" style="background: #f8f8f8 ; margin-left: 5px; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px">
                  <!-- div class="p-relative"> -->
                      <a href="">
                          @if($academia->imagen)
                            <img class="img-responsive" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                          @else
                            <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                          @endif
                      </a>
                  <!-- </div> -->

              <div class="pmo-block pmo-contact hidden-xs">
                  <h2>Contacto</h2>

                  <!-- <ul>
                       <p class="text-center">
                                 
                                  <a href="{{ empty($academia->facebook) ? '' : $academia->facebook}}" target="_blank"><i class="{{ empty($academia->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                  <a href="{{ empty($academia->twitter) ? '' : $academia->twitter}}" target="_blank"><i class="{{ empty($academia->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                  <a href="{{ empty($academia->instagram) ? '' : $academia->instagram}}" target="_blank"><i class="{{ empty($academia->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                  <a href="{{ empty($academia->linkedin) ? '' : $academia->linkedin}}" target="_blank"><i class="{{ empty($academia->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                  <a href="{{ empty($academia->youtube) ? '' : $academia->youtube}}" target="_blank"><i class="{{ empty($academia->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                  <a href="{{ empty($academia->pagina_web) ? '' : $academia->pagina_web}}" target="_blank"><i class="{{ empty($academia->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                                
                                  
                                </p>
                            <li>
                                <i class="zmdi zmdi-pin"></i>
                                <address class="m-b-0 ng-binding">
                                    {{$academia->direccion}}
                                </address>
                            </li>
                  </ul> -->

                  <ul>
                      <li><i class="zmdi zmdi-email"></i> info@easydancelatino.com</li>
                      <li><i class="zmdi zmdi-facebook-box"></i> Easydancelatino</li>
                      <li><i class="zmdi zmdi-twitter"></i> EasyDanceLatino</li>
                      <li>
                          <i class="zmdi zmdi-pin"></i>
                          <address class="m-b-0 ng-binding">
                              Centro Comercial Salto Ángel, <br>
                              en la avenida 3 Y – entre la <br> calle 78 y 79 <br>
                              Maracaibo, Venezuela <br>
                          </address>
                      </li>
                  </ul>
                  
                  <div class="clearfix p-b-15"></div>

                  <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Regalo</div>
                          <div class="col-sm-12">
                          <div class="clearfix p-b-15"></div>
                            <label class="text-left opaco-0-8"> Texto</label>


                               <hr class="linea-morada opaco-0-8">

                              


                              <!-- <p class="text-center">
                               
                                <a href="{{ empty($clase_grupal->facebook) ? '' : $clase_grupal->facebook}}" target="_blank"><i class="{{ empty($clase_grupal->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->twitter) ? '' : $clase_grupal->twitter}}" target="_blank"><i class="{{ empty($clase_grupal->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->instagram) ? '' : $clase_grupal->instagram}}" target="_blank"><i class="{{ empty($clase_grupal->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->linkedin) ? '' : $clase_grupal->linkedin}}" target="_blank"><i class="{{ empty($clase_grupal->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->youtube) ? '' : $clase_grupal->youtube}}" target="_blank"><i class="{{ empty($clase_grupal->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->pagina_web) ? '' : $clase_grupal->pagina_web}}" target="_blank"><i class="{{ empty($clase_grupal->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p> -->
                          


                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                            <span class="text-center">
                                 <button class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 regalo" style="width:100%; padding:5px"> Agregar </button>
                            </span>

                          </div>

                          <div class="clearfix p-b-15"></div>

                  @foreach($campanas as $campana)
                   <div style="border: 1px solid;">
                        <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Campaña</div>
                          <div class="col-sm-12">
                          <div class="clearfix p-b-15"></div>
                            <label class="text-left opaco-0-8"> {{$campana->nombre}}</label>


                               <hr class="linea-morada opaco-0-8">

                              


                              <!-- <p class="text-center">
                               
                                <a href="{{ empty($clase_grupal->facebook) ? '' : $clase_grupal->facebook}}" target="_blank"><i class="{{ empty($clase_grupal->facebook) ? '' : 'zmdi zmdi-facebook-box f-25 c-facebook m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->twitter) ? '' : $clase_grupal->twitter}}" target="_blank"><i class="{{ empty($clase_grupal->twitter) ? '' : 'zmdi zmdi-twitter-box f-25 c-twitter m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->instagram) ? '' : $clase_grupal->instagram}}" target="_blank"><i class="{{ empty($clase_grupal->instagram) ? '' : 'zmdi zmdi-instagram f-25 c-instagram m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->linkedin) ? '' : $clase_grupal->linkedin}}" target="_blank"><i class="{{ empty($clase_grupal->linkedin) ? '' : 'zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->youtube) ? '' : $clase_grupal->youtube}}" target="_blank"><i class="{{ empty($clase_grupal->youtube) ? '' : 'zmdi zmdi-collection-video f-25 c-youtube m-l-5'}}"></i></a>

                                <a href="{{ empty($clase_grupal->pagina_web) ? '' : $clase_grupal->pagina_web}}" target="_blank"><i class="{{ empty($clase_grupal->pagina_web) ? '' : 'zmdi zmdi zmdi-google-earth zmdi-hc-fw f-25 c-verde m-l-5'}}"></i></a>
                              
                                
                              </p> -->
                          


                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                        </div>

                            <span class="text-center">
                                 <button id="{{$campana->id}}" class="btn-blanco m-r-10 f-20 f-700 p-l-20 p-r-20 recompensa" data-toggle="modal" href="#modalAgregar" style="width:100%; padding:5px"> Contribuir </button>
                            </span>

                          </div>

                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>
                        @endforeach
              </div>

              </div>
            </div>

          
          <div class="col-sm-6" style="width:49%">

          <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect"><a href="{{url('/')}}/administrativo" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Administrativo</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/asistencia" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Asistencia</p></a></li>
                                    <li class="waves-effect"><a href="{{url('/')}}/documentos" aria-controls="home11" onclick="procesando()"><p style=" margin-bottom: -2px;">Normativas</p></a></li>
                                    
                            </ul>
              </div>

           <div class="clearfix p-b-20"></div>

            @foreach($clases_grupales as $clase_grupal)
              
              <div class="text-left pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

              <div class= "clase_grupal" id="{{$clase_grupal->id}}"  onclick="procesando()">

                <div style="padding: 10px">

                <p class="f-25 f-700" style="color:#5e5e5e">{{$clase_grupal->nombre}}</p>
              

                @if($clase_grupal->descripcion)

                  <p class="f-15 f-700">{{ str_limit($clase_grupal->descripcion, $limit = 150, $end = '...') }}</p>

                @endif
                            
                @if($clase_grupal->imagen)
                  <img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clase_grupal->imagen}}" class="img-responsive" alt="">

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
                          <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/agendar/clases-grupales/progreso/{{$clase_grupal->id}}" class="popup">
                            <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                            <span class="rrssb-text">facebook</span>
                          </a>
                        </li>
                        <li class="rrssb-twitter">
                          <!-- Replace href with your Meta and URL information  -->
                          <a href="https://twitter.com/intent/tweet?text=Participa en la clase grupal {{$clase_grupal->nombre}} te invita @EasyDanceLatino {{url('/')}}/agendar/clases-grupales/progreso/{{$clase_grupal->id}}"
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

             @foreach($talleres as $taller)


              <div class="text-left">
                <a href="{{url('/')}}/agendar/talleres/progreso/{{$taller->id}}" class="text-center f-25 f-700" style="color:#5e5e5e">{{$taller->nombre}}</a>
              </div>

              <div class="clearfix p-b-20"></div>
                          
              @if($taller->imagen)
                <img src="{{url('/')}}/assets/uploads/taller/{{$taller->imagen}}" class="img-responsive opaco-0-8" alt="">
              @endif

              <div class="clearfix p-b-20"></div>

              <p class="text-center f-15 f-700 opaco-0-8">{{$taller->descripcion}}</p>

              <hr>

            @endforeach

            @foreach($fiestas as $fiesta)

              <div class="text-left">
                <span class="text-center f-25 f-700 opaco-0-8">{{$fiesta->nombre}}</span>
              </div>

              <div class="clearfix p-b-20"></div>
                          
              @if($fiesta->imagen)
                <img src="{{url('/')}}/assets/uploads/fiesta/{{$fiesta->imagen}}" class="img-responsive opaco-0-8" alt="">
              @endif

              <div class="clearfix p-b-20"></div>

              <p class="text-center f-15 f-700 opaco-0-8">{{$fiesta->descripcion}}</p>

              <hr>

            @endforeach
                        
           
          </div>

  

            <div class="col-sm-3" style="background: #f8f8f8 ; margin-right: 5px; float:right; padding-left: 10px; padding-right: 10px; min-height: 600px">
              <div style="padding-top:10px;">
                  <!-- <div class="p-relative">
                      <a href="">
                          @if($academia->imagen)
                            <img class="img-responsive" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                          @else
                            <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                          @endif
                      </a>
                  </div>

              <div class="pmo-block pmo-contact hidden-xs">
                  <h2>Contacto</h2>

                  <ul>
                      <li><i class="zmdi zmdi-email"></i> info@easydancelatino.com</li>
                      <li><i class="zmdi zmdi-facebook-box"></i> Easydancelatino</li>
                      <li><i class="zmdi zmdi-twitter"></i> EasyDanceLatino</li>
                      <li>
                          <i class="zmdi zmdi-pin"></i>
                          <address class="m-b-0 ng-binding">
                              Centro Comercial Salto Ángel, <br>
                              en la avenida 3 Y – entre la <br> calle 78 y 79 <br>
                              Maracaibo, Venezuela <br>
                          </address>
                      </li>
                  </ul>
              </div>
 -->
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



        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

        var recompensa = 0;

              // create a simple soon counter on the supplied element
          $(document).ready(function() {
      

          });


        $(".clase_grupal").click(function(){

          id = this.id;
          window.location= "{{url('/')}}/agendar/clases-grupales/progreso/"+id;

        });

          $(".recompensa").click(function(){

          id = this.id;
          window.location= "{{url('/')}}/especiales/campañas/progreso/"+id;

        });

        $(".regalo").click(function(){

          id = this.id;
          window.location= "{{url('/')}}/especiales/regalos";

        });

        </script>
@stop        