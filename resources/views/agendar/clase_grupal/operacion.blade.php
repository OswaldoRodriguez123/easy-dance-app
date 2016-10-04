@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">

@stop


@section('content')


<div class="modal fade" id="modalTrasladar-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <form name="form_trasladar" id="form_trasladar"  >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <div class="modal-body">                           
               <div class="row p-t-20 p-b-0">
                   <div class="col-sm-12">
                     <div class="form-group fg-line">
                        <label for="nombre">Clases Grupales</label>

                          <div class="select">
                              <select class="form-control" id="clasegrupal_id" name="clasegrupal_id">
                              @foreach ( $grupales as $grupal )
                              <option value = "{{ $grupal['id'] }}">{{ $grupal['nombre'] }} - {{ $grupal['hora_inicio'] }} / {{ $grupal['hora_final'] }} - {{ $grupal['dia_de_semana'] }} - {{ $grupal['instructor'] }} - {{ $grupal['especialidad'] }}</option>
                              @endforeach 
                              </select>
                          </div> 

                     </div>
                     <div class="has-error" id="error-clasegrupal_id">
                          <span >
                              <small class="help-block error-span" id="error-clasegrupal_id_mensaje" ></small>                                
                          </span>
                      </div>
                   </div>


                   <input type="hidden" name="id" value="{{$id}}"></input>
                

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

                  <a class="btn-blanco m-r-5 f-12 trasladar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                </div>
            </div></form>
        </div>
    </div>
</div>

<section id="content">
        <div class="container">
           <div class="block-header">
                <div class="col-sm-6">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-grupales"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase grupal</a>
                </div>
                <div class="col-sm-6 text-right">
                <a class="btn-blanco m-r-10 f-16" style="text-align: right" href="{{url('/')}}/agendar/clases-grupales/detalle/{{$id}}"> Vista Previa <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                </div>
            </div> 

            <br>
            
            <h4 class ="c-morado text-right">Clase Grupal: {{$clasegrupal->nombre}}</h4> 
            <br><br><h1 class="text-center c-morado"><i class="zmdi zmdi-wrench p-r-5"></i> Sección de Operaciones</h1>
            <hr class="linea-morada">
            <br>
            <div class="card-body p-b-20">
            <div>

            <div class = "col-sm-1"></div>

			<ul class="ca-menu-c col-sm-8" style="width: 1200px;">

                <li data-ripplecator class ="dark-ripples">
                        <a data-toggle="modal" href="#modalTrasladar-ClaseGrupal">
                            <span class="ca-icon-c"><i class="zmdi zmdi-trending-up f-35 boton blue sa-warning" data-original-title="Trasladar" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Trasladar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                </li>

                <li data-ripplecator class ="dark-ripples">
                        <a class="multihorario">
                            <span class="ca-icon-c"><i class="zmdi zmdi-calendar-note f-35 boton blue sa-warning" data-original-title="Ver Multihorario" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Multihorario</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                </li>
        		<li data-ripplecator class ="dark-ripples">
                        <a class="participantes">
                            <span class="ca-icon-c"><i class="icon_a-participantes f-35 boton blue sa-warning" data-original-title="Ver Participantes" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Participantes</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a class = "progreso">
                            <span class="ca-icon-c"><i class="icon_e-ver-progreso f-35 boton blue sa-warning" 
                                   data-original-title="Progreso" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Ver Progreso</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a href="#" class="eliminar">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-delete f-35 boton red sa-warning" name="eliminar" id="{{$id}}" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Eliminar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <!--<li>
                        <a href="#">
                            <span class="ca-icon-c">A</span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Exceptional Service</h2>
                                <h3 class="ca-sub-c">Personalized to your needs</h3>
                            </div>
                        </a>
                    </li>-->
                    


                    
                </ul>

                <div class = "col-sm-1"></div>
                
                </div>
            </div>
        </div>
</section>
@stop
@section('js') 
	<script type="text/javascript">

    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar/";
    route_principal="{{url('/')}}/agendar/clases-grupales";
    route_trasladar="{{url('/')}}/agendar/clases-grupales/trasladar";

    $(document).ready(function(){

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInUpBig';
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

      });
		function setAnimation(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 2000); 

            console.log("entro");
  }

  function setAnimationRapido(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 500); 
  }

  $(".multihorario").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/multihorario/{{$id}}";

  });

  $(".participantes").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/participantes/{{$id}}";

    });

  $(".progreso").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/progreso/{{$id}}";

    });

  $(".eliminar").click(function(){
                console.log(this.id);
                id = this.id;
                swal({   
                    title: "Desea eliminar la clase grupal?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + "{{$id}}";
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        window.location=route_principal; 

                    },
                    error:function(msj){
                                // $("#msj-danger").fadeIn(); 
                                // var text="";
                                // console.log(msj);
                                // var merror=msj.responseJSON;
                                // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                // $("#msj-error").html(text);
                                // setTimeout(function(){
                                //          $("#msj-danger").fadeOut();
                                //         }, 3000);
                                //         
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

      $(".trasladar").click(function(){
      id = this.id;
      swal({   
          title: "Desea trasladar todos los alumnos inscritos a la clase grupal seleccionada?",   
          text: "Tenga en cuenta que la otra clase grupal sera eliminada",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Trasladar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: false 
      }, function(isConfirm){   
          if (isConfirm) {
            $(".sweet-alert").hide();
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                      
            trasladar();
            }
        });
    });
      function trasladar(){
        var route = route_trasladar;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#form_trasladar" ).serialize();

        procesando();
                
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data:datos,
            success:function(respuesta){

                window.location=route_principal; 

            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                // if (typeof msj.responseJSON === "undefined") {
                //           window.location = "{{url('/')}}/error";
                //         }
                var nType = 'danger';
                if(msj.responseJSON.status=="ERROR"){
                  errores(msj.responseJSON.errores);
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                finprocesado();
                  
              }, 1000);             
            }
        });
      }
  
  setAnimation('fadeInUp', 'content');
	</script>
@stop