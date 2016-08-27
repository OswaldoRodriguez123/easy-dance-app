@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop

@section('content')
    
            <section id="content">
                <div class="container">

                    <div class="card">


                        <div style="margin-left:45%"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 130px; max-width: 130px;" class="img-responsive opaco-0-8" alt=""></div>

                        <div class="clearfix p-b-15"></div>
                        <div class="text-center">
                            <span class="f-25 c-morado text-center">Hola <b>{{Auth::user()->nombre}}</b></span>  
                            <br></br>   
                            <span class="f-16 c-morado">Bienvenido a la Academia <b>{{$academia->nombre}}</b></span> 

                            <br></br>   
                            <span class="f-16 c-morado">A traves de la aplicacion <b>Easy Dance</b> podras reservar clases, ver asistencias, <br> reportes administrativas, agendar activdades y otras funcionalidades mas.</span> 

                            <br><br><br>

                            <span class="f-25 c-morado text-center"><b>Condiciones Generales</b></span> 

                            <br><br><br>
                        </div>



                    <div style="margin-left: 25%">
                        <div class="col-sm-8" style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc; overflow-y: auto; height:400px">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones">


                                    <div class="text-center f-25 f-700">Etiqueta dentro del salón de clases</div>
                                        <hr>
                                    <div class="col-md-1"></div>
                                       <div class="col-md-10">
                                      <div class="text-justify">

                                      <p>Queremos que todos nuestros alumnos tengan una experiencia de baile agradable y educativa. Trataremos a usted  y/o sus hijos con cortesía y respeto. Esperamos que haya una conducta reciproca hacia   sus profesores, el personal  compañeros y bailadores. Solicitamos que  observes  las siguientes reglas sencillas:</p>
                                      <div class="f-18 f-700"> 1- Vestimenta   </div>
                                      <br>

                                      <p>Venga preparado para bailar - vestimenta, el aseo, la actitud, la ambición, la energía!.</p>


                                      <div class="f-18 f-700">2-  Horario  </div><br>

                                      <p>Debe llegar a la academia con tiempo suficiente antes de comenzar la clase. Aquellos alumnos presenten de diez o más minutos de retraso, serán bienvenidos pero  a observar la clase; sin embargo, no se les permitirá participar a menos que haya una circunstancia atenuante. </p>

                                      <div class="f-18 f-700"> 3- Disciplina   </div><br>

                                      <p>Deberá mantener absoluto respeto y disciplina dentro de las instalaciones y salón de clases, no se permiten conductas inapropiadas que se aparten de las  buenas costumbres y buenos modales, al igual que consumo de alimentos y bebidas dentro de la pista de baile. </p>


                                      <div class="f-18 f-700"> 4- Retirada </div><br>

                                      <p>Si el alumno debe retirarse antes  de  finalizar  la clase, debe notificar a su instructor  antes de que comience, de lo contrario los alumnos no deben  salir del salón de clases sin el consentimiento del instructor. </p>

                                      <div class="f-18 f-700"> 5-  Teléfonos  </div><br>

                                      <p>Se prohíbe el uso de dispositivos celulares dentro de las clases, los teléfonos deben permanecer apagados o en silencio.</p>

                                      <div class="f-18 f-700"> 6-  Calzados   </div><br>

                                      <p>El calzado debe ser gomas deportivas, prohibido el uso de tacones, pantuflas, zapatos de vestir, descalzo u otros.</p>

                                      <div class="f-18 f-700"> 7-  Visitantes  </div><br>

                                      <p>No se permiten visitantes dentro del salón de clases.</p>

                                      <div class="f-18 f-700"> 8- Sonido  </div><br>

                                      <p>El manejo del sonido es exclusivo del personal o de instructores, por tal motivo, los alumnos tienen estrictamente prohibido el uso y manejo de los equipos de sonido e iluminación.</p>

                                      <div class="f-18 f-700"> 9- Pertenencias </div><br>

                                      <p>El alumno es responsable de sus pertenecías, tales como, carteras, bolsos, celulares entre otros.</p>

                                      </div>
                                    </div>

                                    
                                    
                                    </p>

                                  </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="col-sm-3" style="margin-left: 40%">

                                <input type="checkbox" id="condiciones" name="condiciones">  <span class="f-16 f-700 opaco-0-8">  Acepto los  términos</span> <br><br>

                                <div class="text-center">
                       
                                  <button type="button" class="btn btn-blanco m-r-10 f-20 guardar"> Guardar</button>

                                </div>

                              </div>

                              <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                           </div>
                    </div>
            </section>

@stop


@section('js') 
            
		<script type="text/javascript">
            route_principal="{{url('/')}}/inicio";
            route_aceptar="{{url('/')}}/inicio/condiciones";
   
            $(document).ready(function(){

            $(".guardar").attr("disabled","disabled");

              $(".guardar").css({
                  "opacity": ("0.2")
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

          });

             $(".guardar").click(function(){

                var route = route_aceptar;
                var token = "{{ csrf_token() }}"
                procesando();

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

                          window.location = route_principal;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
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