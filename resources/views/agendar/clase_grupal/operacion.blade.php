@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">



@stop

@section('js_vendor')

<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

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
                                <select class="form-control" id="clase_grupal_id" name="clase_grupal_id">
                                @foreach ( $grupales as $grupal )
                                <option value = "{{ $grupal['id'] }}">{{ $grupal['nombre'] }} - {{ $grupal['hora_inicio'] }} / {{ $grupal['hora_final'] }} - {{ $grupal['dia_de_semana'] }} - {{ $grupal['instructor'] }} - {{ $grupal['especialidad'] }}</option>
                                @endforeach 
                                </select>
                            </div> 

                       </div>
                       <div class="has-error" id="error-clase_grupal_id">
                            <span >
                                <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                                
                            </span>
                        </div>
                     </div>


                     <input type="hidden" name="id" value="{{$clasegrupal->id}}"></input>
                  

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

                    <a class="btn-blanco m-r-5 f-12 trasladar" href="#">  Trasladar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                  </div>
              </div></form>
          </div>
      </div>
  </div>

  <section id="content">
          <div class="container">
             <div class="block-header">
                  <div class="col-sm-6">
                    <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Agenda</a>
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

                <div class="col-sm-5"></div>

                <ul class="top-menu">
                  <li class="dropdown" style="width: 19.5%">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                       <span class="f-15 f-700"> 
                         <ul class="ca-menu-c">
                            <li>
                                <span class="ca-icon-c"><i class="zmdi zmdi-wrench f-35 boton blue sa-warning"></i></span>
                                <div class="ca-content-c">
                                    <h2 class="ca-main-c f-20">Operaciones</h2>
                                    <h3 class="ca-sub-c"></h3>
                                </div>
                            </li>
                          </ul>
                       </span>
                    </a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/nivelaciones/{{$clasegrupal->id}}"><i class="icon_a-niveles f-16 m-r-10 boton blue"></i>&nbsp;Nivelaciones</a>
                        </li>

                        <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/participantes/{{$clasegrupal->id}}"><i class="icon_a-participantes f-16 m-r-10 boton blue"></i> Participantes</a>
                        </li>

                        <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/especiales/examenes/agregar/{{$clasegrupal->id}}"><i class="icon_a-examen f-16 m-r-10 boton blue"></i> Valorar</a>
                        </li>

                        <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/progreso/{{$clasegrupal->id}}"><i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i> Ver Progreso</a>
                        </li>
                    
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                        
                          <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/multihorario/{{$clasegrupal->id}}"><i class="zmdi zmdi-calendar-note f-16 boton blue"></i>Multihorario</a>
                          </li>

                          <li class="hidden-xs">
                            <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/agenda/{{$clasegrupal->id}}"><i class="zmdi zmdi-eye f-16 boton blue"></i>Ver Agenda</a>
                          </li>

                          <li class="hidden-xs">
                              <a onclick="procesando()" href="{{url('/')}}/agendar/clases-grupales/canceladas/{{$clasegrupal->id}}"><i class="zmdi zmdi-close-circle-o f-20 boton red sa-warning"></i> Cancelar Clase</a>
                          </li>

                          <li class="hidden-xs eliminar">
                              <a class ="pointer"><i class="zmdi zmdi-delete f-20 boton red sa-warning"></i> Eliminar Clase</a>
                          </li>

                        @endif
                    </ul>
                  </li>
                </ul>
              </div>
          </div>
  </section>
@stop

@section('js') 
	<script type="text/javascript">

    route_eliminar="{{url('/')}}/agendar/clases-grupales/eliminar/";
    route_principal="{{url('/')}}/agendar/clases-grupales";
    route_trasladar="{{url('/')}}/agendar/clases-grupales/trasladar";
    route_valorar="{{url('/')}}/especiales/examenes/agregar";

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

  $(".valorar").click(function(){
               
    window.location = "{{url('/')}}/especiales/examenes/agregar/{{$id}}";

    });

  $(".nivelaciones").click(function(){
               
    window.location = "{{url('/')}}/agendar/clases-grupales/nivelaciones/{{$id}}";

    });

  $(".eliminar").click(function(){
                console.log(this.id);
                id = this.id;
                swal({   
                    title: "Desea eliminar la clase grupal?",   
                    text: "Tenga en cuenta que los horarios creados para esta clase grupal tambien seran eliminados!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
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
         procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        window.open(route, '_blank');_principal; 

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
          closeOnConfirm: true 
      }, function(isConfirm){   
          if (isConfirm) {
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

                window.open(route, '_blank');_principal; 

            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                if (typeof msj.responseJSON === "undefined") {
                  window.location = "{{url('/')}}/error";
                }
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

    $('.modal_trasladar').click(function(){

        $('#modalTrasladar-ClaseGrupal').modal('show')

      });


  
  setAnimation('fadeInUp', 'content');
	</script>
@stop