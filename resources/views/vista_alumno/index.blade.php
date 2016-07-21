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
          <div class="col-sm-3" style="background: #f8f8f8 ; margin-left: 5px; padding-left: 10px; padding-right: 10px">
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

                  <ul>
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

           <div class="clearfix p-b-20"></div>

            @foreach($clases_grupales as $clase_grupal)
            
              <div class="text-center">
                <a href="{{url('/')}}/agendar/clases-grupales/progreso/{{$clase_grupal->id}}" class="text-center f-25 f-700">{{$clase_grupal->nombre}}</a>
              </div>

              <div class="clearfix p-b-20"></div>
                          
              @if($clase_grupal->imagen)
                <img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clase_grupal->imagen}}" class="img-responsive opaco-0-8" alt="">
              @endif

              <div class="clearfix p-b-20"></div>

              <p class="text-center f-15 f-700 opaco-0-8">{{$clase_grupal->descripcion}}</p>

              <hr>

            @endforeach

             @foreach($talleres as $taller)


              <div class="text-center">
                <a href="{{url('/')}}/agendar/talleres/progreso/{{$taller->id}}" class="text-center f-25 f-700">{{$taller->nombre}}</a>
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

              <div class="text-center">
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

  

            <div class="col-sm-3" style="background: #f8f8f8 ; margin-right: 5px; float:right; padding-left: 10px; padding-right: 10px">
              <div style="padding-top:10px;">
                  <div class="p-relative">
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

              </div>
            </div>
            </div>
            <!--<data ui-view></data>-->
        </div>
    </div>
</div>




@stop

@section('js') 
        


        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

        var recompensa = 0;

              // create a simple soon counter on the supplied element
          $(document).ready(function() {
      

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