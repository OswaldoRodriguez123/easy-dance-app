@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<!--<link href="{{url('/')}}/assets/vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">-->
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('css')
<link href="{{url('/')}}/assets/css/jquery.floating-social-share.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/font-awesome.min.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/mediaelement/build/mediaelement-and-player.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop



@section('content')
<section id="content" class="back-blanco">
  <div style="margin-top: -24px;"></div>
        <div class="container">
        <div class="clearfix p-b-20"></div>
        <div class="clearfix p-b-20"></div>

                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
          					        <div class="p-t-30">       
          					          <div class="row p-b-15">
          					            <div class="col-md-12" >
          					              <div class="text-center">
          					                <img src="{{url('/')}}/assets/uploads/academia/{{$clase_grupal->imagen_academia}}" class="img-responsive opaco-0-8" alt="">
          					              </div>
          					            </div>  

          					          </div>
                              <div class="row p-l-10 p-b-0">

                              <hr>
                              <p class="text-center f-18 f-700">Participante</p>
                              <div class="clearfix"></div>

                              <div class="progress progress-striped m-b-10">
                                <div class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;"></div>
                              </div>
                              <p class="text-center f-700" >{{$porcentaje}} % Inscritos</p>                            

                              <label class="text-left">Límite de cupos:</label>
                              <p class="text-left" >

                              @if($clase_grupal->cupo_reservacion > 0)

                                {{$clase_grupal->cupo_reservacion}}
                              
                              @else

                                Sin Limites
                              
                              @endif</p>

                              <label class="text-left" >Fecha de inicio:</label>
                              <p class="text-left">{{$clase_grupal->fecha_inicio}}</p>

                              <label class="text-left" >Especialidad:</label>
                              <p class="text-left">{{$clase_grupal->especialidad_nombre}}</p> 

							                <label class="text-left" >Estudio salón:</label>
                              <p class="text-left">{{$clase_grupal->estudio_nombre}}</p> 

                              <label class="text-left" >Instructor:</label>
                              <p class="text-left">{{$clase_grupal->instructor_nombre}} {{$clase_grupal->instructor_apellido}}</p> 

                              <label class="text-left" >Horarios:</label>
                              <p class="text-left">{{$clase_grupal->hora_inicio}} - {{$clase_grupal->hora_final}}</p>

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
                              
                                <hr>

                                <p class="text-center">
                                 <button id="reserva" name ="reserva" class="btn-blanco m-r-10 f-22 f-700 p-l-20 p-r-20" > </i> Lo quiero </button>
                                </p>
                              
                              @endif

                              </div>
                              </div>
                              </div>

                              <div class="col-sm-9">
                               <p class="text-center f-25 f-700 opaco-0-8">Es hora de bailar y participar en la nueva clase grupal de</p>
                               <h2 class="text-center"> {{$clase_grupal->academia_nombre}} </h2>
                               <div class="p-b-15"></div>
                               <h4 class="text-center"> <i class="zmdi zmdi-pin zmdi-hc-fw c-morado-suave"></i> {{$clase_grupal->estado}} - {{$clase_grupal->direccion}}  </h4>

                               <div class="clearfix p-b-20"></div>

                               <div class="col-sm-offset-3 col-sm-6" >
          					        <div class="text-center">
          					           <img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clase_grupal->imagen}}" class="img-responsive opaco-0-8" alt="">
          					        </div>
          					    </div>

          					    <div class="clearfix p-b-20"></div>

          					    <p class="f-16 f-700 opaco-0-8">Te traemos para ti </p>

          					    <p>
          					    	{{$clase_grupal->descripcion}}
          					    </p>

          					    <div class="clearfix p-b-20"></div>
                        
                        @if($clase_grupal->link_video)

            					    <div class="col-sm-offset-3 col-sm-6 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{$clase_grupal->link_video}}"></iframe>
                            </div>
                          </div>

                        @endif


                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>

          					    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Condiciones 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">

                                          {{ empty($clase_grupal->condiciones) ? 'Esta clase grupal no presenta condiciones' : $clase_grupal->condiciones}}
                                            
                                        </div>
                                    </div>
                                    </div>
                                    </div>

                                    <div class="clearfix p-b-20"></div>
                                    <div class="clearfix p-b-20"></div>
                                    <div class="clearfix p-b-20"></div>
                                    <div class="clearfix p-b-20"></div>

                              </div>
                              
          					         

					        </div>
					    </div>
					</div>

          <div style="margin-top: -35px;"></div>
				</section>


				
@stop

@extends('layout.footer')

@section('js') 

  <script type="text/javascript">

      route_reserva="{{url('/')}}/reservacion/{{$id}}";

      

      $(document).ready(function(){


      if("{{$administrador == 1}}")
      {

          $("body").floatingSocialShare({
            buttons: ["facebook", "twitter", "instagram", "linkedin", "google-plus"],
            text: "share with: "
          });

        }
      });
      
      $("#reserva").click(function(){

                var route = route_reserva;
                var token = "{{ csrf_token() }}"
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
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
                          window.location = route_reserva;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

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
  </script>

@stop
