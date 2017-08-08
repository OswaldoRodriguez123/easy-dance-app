@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">

@stop


@section('content')
<section id="content">
        <div class="container">
           <div class="block-header">
                <div class="col-sm-6 text-left">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Visitante</a>
                </div>
                <div class="col-sm-6 text-right">
                <a class="btn-blanco m-r-10 f-16" style="text-align: right" href="{{url('/')}}/participante/visitante/detalle/{{$id}}"> Vista Previa <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                </div>
            </div> 

            <br>
            
            <h4 class ="c-morado text-right">Visitante: {{$visitante->nombre}}</h4>
            <br><br><h1 class="text-center c-morado"><i class="zmdi zmdi-wrench p-r-5"></i> Sección de Operaciones</h1>
            <hr class="linea-morada">
            <br>
            <div class="card-body p-b-20">
            <div>
            
            <ul class="ca-menu-c col-sm-12" style="width: 1200px;">

                <li data-ripplecator class ="dark-ripples">
                        <a class="email">
                            <span class="ca-icon-c"><i class="zmdi zmdi-email f-35 boton blue sa-warning" data-original-title="Enviar Correo" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Enviar Correo</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a href="{{url('/')}}/participante/visitante/impresion/{{$id}}">
                            <span class="ca-icon-c"><i class="icon_a-examen f-35 boton blue sa-warning" 
                                   data-original-title="Realizar encuesta" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Realizar encuesta</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a href="{{url('/')}}/participante/alumno/agregar/{{$id}}">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-trending-up f-35 boton blue sa-warning" name="eliminar" id="{{$id}}" data-original-title="Transferir" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Transferir</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a href="{{url('/')}}/participante/visitante/llamadas/{{$id}}">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-phone f-35 boton blue sa-warning" name="eliminar" id="{{$id}}" data-original-title="Llamadas" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Llamadas</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <li data-ripplecator class ="dark-ripples">
                        <a class="reservar">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-phone f-35 boton blue sa-warning" name="eliminar" id="{{$id}}" data-original-title="Reservar" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Reservar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>
                    
                </ul>


                </div>
            </div>
        </div>
</section>
@stop
@section('js') 
    <script type="text/javascript">

    route_enviar="{{url('/')}}/participante/visitante/enviar-correo";
    route_email="{{url('/')}}/correo/sesion";

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

      $(".informacion").click(function(){
                id = "{{$id}}";
                swal({   
                    title: "Desea enviar la informacion al visitante?",   
                    text: "Confirmar envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Enviar!",  
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
            procesando();
            var route = route_enviar;
            var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data: "&id="+id,
                    success:function(respuesta){
                        
                        finprocesado();
                        swal("Listo!","La información fue enviada con exito!","success");

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
                
                }
            });
      });

      $(".email").click(function(){
         var route = route_email;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:"&usuario_tipo=3&usuario_id={{$id}}",
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



    $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/2";
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
                
             
  setAnimation('fadeInUp', 'content');
    </script>
@stop