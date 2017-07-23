@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">

@stop


@section('content')
<section id="content">
        <div class="container">
           <div class="block-header">
                <div class="col-sm-6 text-left">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno" > <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Alumno</a>
                </div>

                <div class="col-sm-6 text-right">
                <a class="btn-blanco m-r-10 f-16" style="text-align: right" href="{{url('/')}}/participante/alumno/detalle/{{$id}}"> Vista Previa <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                </div>
            </div> 

            <br>

 
            <h4 class ="c-morado text-right">Alumno: {{$alumno->nombre}} {{$alumno->apellido}}</h4>
            <br><br><h1 class="text-center c-morado"><i class="zmdi zmdi-wrench p-r-5"></i> Sección de Operaciones</h1>

            <hr class="linea-morada">
            <br>
            <div class="card-body p-b-20">
            <div>

			<ul class="ca-menu-c" style="width: 1200px;">

                    @if($total)
                		<li data-ripplecator class ="dark-ripples">
                            <a class = "pagar">
                                <span class="ca-icon-c"><i class="icon_a-pagar f-35 boton blue sa-warning" data-original-title="Pagar" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                                <div class="ca-content-c">
                                    <h2 class="ca-main-c">Pagar</h2>
                                    <h3 class="ca-sub-c"></h3>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if($usuario)
                        <li data-ripplecator class ="dark-ripples">
                            <a class="email" id="{{$id}}">
                                <span class="ca-icon-c"><i class="zmdi zmdi-email f-35 boton blue sa-warning" 
                                       data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                                <div class="ca-content-c">
                                    <h2 class="ca-main-c">Enviar Correo</h2>
                                    <h3 class="ca-sub-c"></h3>
                                </div>
                            </a>
                        </li>
                    @else
                        <li class="email" id="{{$id}}" style="display: none" data-ripplecator class ="dark-ripples">
                            <a>
                                <span class="ca-icon-c"><i class="zmdi zmdi-email f-35 boton blue sa-warning" 
                                       data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                                <div class="ca-content-c">
                                    <h2 class="ca-main-c">Enviar Correo</h2>
                                    <h3 class="ca-sub-c"></h3>
                                </div>
                            </a>
                        </li>
                        <li class="usuario" data-ripplecator class ="dark-ripples">
                            <a>
                                <span class="ca-icon-c"><i class="zmdi zmdi-alert-circle-o f-35 boton blue sa-warning" 
                                       data-original-title="Crear Cuenta" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                                <div class="ca-content-c">
                                    <h2 class="ca-main-c">Crear Cuenta</h2>
                                    <h3 class="ca-sub-c"></h3>
                                </div>
                            </a>
                        </li>
                    @endif
                    <li data-ripplecator class ="dark-ripples">
                        <a class = "transferir">
                            <span class="ca-icon-c"><i class="zmdi zmdi-trending-up zmdi-hc-fw f-35 boton blue sa-warning" 
                                   data-original-title="Transferir" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Transferir</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a class = "valoracion">
                            <span class="ca-icon-c"><i class="zmdi glyphicon glyphicon-search zmdi-hc-fw f-35 boton blue sa-warning" 
                                   data-original-title="Valoración" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Valoración</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>


                    <li data-ripplecator class ="dark-ripples">
                        <a class="reservar">
                            <span class="ca-icon-c"><i  class="icon_a-reservaciones f-35 boton blue sa-warning" name="eliminar" id="{{$id}}" data-original-title="Reservar" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Reservar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a href="#" class="eliminar" id = "{{$id}}">
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


                </div>
            </div>
            
        </div>
</section>
@stop
@section('js') 
	<script type="text/javascript">

    route_eliminar="{{url('/')}}/participante/alumno/eliminar/";
    route_principal="{{url('/')}}/participante/alumno";
    route_email="{{url('/')}}/correo/sesion";
    route_agregar="{{url('/')}}/participante/alumno/crear_cuenta/";
    
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
  
  setAnimation('fadeInUp', 'content');

  $(".pagar").click(function(){
               
    window.location = "{{url('/')}}/participante/alumno/deuda/{{$id}}";

    });

  $(".transferir").click(function(){
               
    window.location = "{{url('/')}}/participante/alumno/transferir/{{$id}}";

    });

  $(".valoracion").click(function(){
               
    window.location = "  {{url('/')}}/participante/alumno/evaluaciones/{{$id}}";

    });



  $(".perfil_evaluativo").click(function(){
               
    window.location = "{{url('/')}}/participante/alumno/perfil-evaluativo/{{$id}}";

    });

  $(".eliminar").click(function(){
    @can('delete-alumnos', $alumno)
                id = this.id;
                swal({   
                    title: "Desea eliminar al alumno?",   
                    text: "Confirmar eliminación!",   
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
    @else
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = 'danger';
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out');
        var nMensaje = 'No tiene permisos para ejecutar esta acción';
        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut, nMensaje);
    @endcan  
   });


    $(".email").click(function(){
         var route = route_email;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:"&usuario_tipo=1&usuario_id={{$id}}",
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/{{$id}}"  

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
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      });

      function eliminar(id){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        procesando();
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
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

      $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/1";
        var token = '{{ csrf_token() }}';
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/agendar/reservaciones/actividades/{{$id}}"

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
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    });

    $(".usuario").click(function(){
      element = this;
      swal({   
        title: "Desea crearle la cuenta al alumno?",   
        text: "Confirmar creación!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Crear!",  
        cancelButtonText: "Cancelar",         
        closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {

          procesando();
          var token = '{{ csrf_token() }}';
          var route = route_agregar + "{{$id}}";
                
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            success:function(respuesta){
              finprocesado();
              swal('Exito!','La cuenta ha sido creada','success');
              $(element).hide();
              $('.email').show();

            },
            error:function(msj){
              swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
              finprocesado();
            }
          });
        }
      });
    });

	</script>
@stop