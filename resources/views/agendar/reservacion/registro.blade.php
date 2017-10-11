@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('css')

<!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet"> -->

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop

@section('content')
  <!-- ENHORABUENA -->

  
    
    <div class="container">
     <div class="block-header">


        <?php $url = "/inicio" ?>
        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

    
    </div> 

      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">

              <div class="panel-body">
                    
                <div role="tabpanel" class="tab">
                   
                    <div class="tab-content ">
                     
                     <div role="tabpanel" class="tab-pane  animated active fadeInRight in" id="primero">

                    <div class="block-header text-center">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    <div class="col-md-offset-4">
                    <div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;" class="img-responsive opaco-0-8" alt=""></div>
                    </div>
                    <div class="c-morado text-center">
                      
                        <p class="f-25">Hola, mi nombre es Peggy de la aplicación web <b>Easy Dance</b></p> 
                        <p class="f-20">Represento a la academia de baile <b>{{$academia->nombre}}</b></p> 
                        <p class="f-15">Quiero saber más de ti</p>

                        <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar" href="#segundo" aria-controls="segundo" role="tab" data-toggle="tab">Hablemos</button> <a class="f-700" href="#quinto" aria-controls="quinto" role="tab" data-toggle="tab" name="quinto">Ya posees una cuenta?</a>

                    </div> 
                  </div>

                  <div class="col-md-1"></div>

                  
                  </div>
                    
                 </div>

                 <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="segundo">

                    <div class="block-header text-center">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    <div class="text-center">
                      
                    <div class="text-center c-morado f-30">Dime,  ¿Cuál es tu nombre? </div>
                    <br>
                    <div class="text-center"><i class="zmdi zmdi-mood f-100 c-morado"></i></div>
                    <br>
                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="clearfix m-20 m-b-25"></div>
                    <input type="text" class="form-control caja" id="cambio" name="cambio"></input>
                    <div class="has-error" id="error-cambio">
                        <span >
                            <small id="error-cambio_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>
                                                             

                    <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar tercero" href="#tercero" aria-controls="tercero" role="tab" data-toggle="tab" name="tercero">Ok <i class="zmdi zmdi-check"></i></button>

                     <!-- <button type="button" class="btn-blanco m-r-10 f-25 guardar" name="tercero">Ok <i class="zmdi zmdi-check"></i></button> -->


                     <span class="f-700">Pulsa Aqui</span>

                     <div class="clearfix m-20 m-b-25"></div>
                     <div class="clearfix m-20 m-b-25"></div>


                    </div> 
                  </div>

                  <div class="col-md-1"></div>

                  </div>
                 </div>

                 <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="tercero">

                    <div class="block-header text-center">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    <div class="col-md-offset-4">
                    <div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;" class="img-responsive opaco-0-8" alt=""></div>
                    </div>
                    <div class="c-morado text-center">
                      
                    <p class="f-30">Un placer conocerte <span class="f-700" id="mostrar">Nombre</span></p> 
                    <p class="f-25">Voy a crearte un registro</p> 
                    <p class="f-22"> Pero necesito que llenes el siguiente formulario</p>


                    <hr>

                    <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar" href="#cuarto" aria-controls="cuarto" role="tab" data-toggle="tab">Ok <i class="zmdi zmdi-check"></i></button>
                     <span class="f-700">Pulsa Aqui</span>


                    </div> 
                  </div>

                  <div class="col-md-1"></div>

                  </div>
                 </div>

                   <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="quinto">

                    <div class="block-header">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                    <form name="consultar_usuario" id="consultar_usuario"  >

                    <input type="hidden" name="tipo_id" value= {{$id}} >
                      
                    <div class="c-morado f-25">Correo Electrónico </div>
                    <div class="clearfix m-20 m-b-25"></div>
                    <input type="text" class="form-control caja" id="correo_registro" name="correo_registro"></input>
                    <div class="has-error" id="error-correo_registro">
                        <span >
                            <small id="error-correo_registro_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>

                     <div class="clearfix m-20 m-b-25"></div>

                     <div class="c-morado f-25">Contraseña </div>
                    <div class="clearfix m-20 m-b-25"></div>
                    <input type="password" class="form-control caja" id="password_registro" name="password_registro"></input>
                    <div class="has-error" id="error-password_registro">
                        <span >
                            <small id="error-password_registro_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>
                                                             

                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="text-center">
                      <button type="button" class="btn-blanco m-r-10 f-22 guardar_registro" id="guardar_registro" name ="guardar_registro" onclick="procesando()">¡ Quiero Reservar Ya !</button>
                     </div>


                     <div class="clearfix m-20 m-b-25"></div>
                     <div class="clearfix m-20 m-b-25"></div>

                    </form>
                  </div>

                  <div class="col-md-1"></div>

                  </div>
                 </div>

                 <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="cuarto">

                    <div class="iconox-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                            <title>Crear Cuenta</title>
                            <circle fill="#692A5A" cx="16" cy="16" r="16"/>
                            <path fill="white" d="M23 21.163V22H8v-.837c0-2.757 5-2.757 5-4.02v-.617c0-.55-1.392-2.12-1.392-3.975C11.608 9.713 13 8.127 15 7.916v-.023s.066-.004.103-.004c.066 0 .13.004.194.01.067-.005.33-.01.398-.01l.305.004v.023c2 .21 2.892 1.797 2.892 4.636 0 1.857-.892 3.426-1.892 3.976v.618c0 1.263 6 1.263 6 4.02zM26 12h-2v-2h-1v2h-2v1h2v2h1v-2h2v-1z"/>
                        </svg>
                    </div>
                INGRESA TUS DATOS </h4>
                <hr>

                <div class="clearfix m-20 m-b-25"></div>
                <div class="clearfix m-20 m-b-25"></div>
       
                <form name="agregar_usuario" id="agregar_usuario"  >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="nombre" value= "Prueba" >
                <input type="hidden" name="tipo_id" value= {{$id}} >
                        <div class="roww row">
                            <div class="col-sm-6">
                                 <div class="form-group">

                                    <label for="fechanacimiento">Correo electrónico</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="text" class="form-control input-sm" name="email" id="email" placeholder="Ej. easydancelatino@gmail.com">
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-email">
                                    <span >
                                     <small id="error-email_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div> 
                                 </div>
                               </div>
                                <div class="col-sm-6">
                                 <div class="form-group">
                                    <label for="sexo">Confirmar Correo</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="text" class="form-control input-sm" name="email_confirmation" id="email_confirmation" placeholder="Repite correo electrónico">
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-email_confirmation">
                                    <span >
                                     <small id="error-email_confirmation_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>
                               </div>
                               </div>

                               <br>

                               <div class="roww row">
                             <div class="col-sm-6 ">
                                 <div class="form-group">
                                    <label for="correo">Contraseña</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="password" class="form-control input-sm" name="password" id="password" placeholder="Mínimo de 6 caracteres">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password">
                                    <span >
                                     <small id="error-password_mensaje" class="help-block error-span" ></small>
                                    </span>
                                    </div>
                               </div>
                                <div class="col-sm-6">
                                 <div class="form-group">
                                    <label for="direccion">Confirmar tu contraseña</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="password" class="form-control input-sm" name="password_confirmation" id="password_confirmation" placeholder="Repite tu contraseña">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-password_confirmation">
                                    <span >
                                     <small id="error-password_confirmation_mensaje" class="help-block error-span" ></small>
                                    </span>
                                    </div>
                               </div>
                            </div>

                            <br>

                        
                        <div class="roww row">
                           <div class="col-sm-6">
                                 <div class="form-group">
                                    <label for="correo">Número móvil</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-celular">
                                    <span >
                                     <small id="error-celular_mensaje" class="help-block error-span" ></small>
                                    </span>
                                    </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group">
                                    <label for="correo">Número local</label>
                                    <span class="input-group">
                                    <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                    </div>
                                    </span>
                                 </div>
                                 <div class="has-error" id="error-telefono">
                                    <span >
                                     <small id="error-telefono_mensaje" class="help-block error-span" ></small>
                                    </span>
                                    </div>
                               </div>
                              </div>

                               <br>

                                <div class="roww row">

                                 <div class="col-sm-6">
                                           <label>Sexo</label>
                                          <div class="form-group">
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
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
                                          <span >
                                           <small id="error-sexo_mensaje" class="help-block error-span" ></small>
                                          </span>
                                          </div>
                                    </div>
                                 </div>
                               </div>
                               
                               <br><br><br><br>        
                    <div class="text-center">
                       <!-- <a class="btn-blanco2 m-r-6 f-22 guardar" id="guardar"  style=" margin-top: 60px; " >  Llévame </a> -->

                       <button type="button" class="btn-blanco m-r-10 f-22 guardar" id="guardar" name ="guardar" onclick="procesando()">¡ Quiero Reservar Ya !</button> <a class="f-700" href="#quinto" aria-controls="quinto" role="tab" data-toggle="tab" name="quinto">Ya posees una cuenta?</a>

                    </div>
                     <br><br><br> 
                </form>
                    
                </div>


                <!-- - -->
                </div>
              </div> <!-- FINAL -->

            </div>

            <div class="col-md-2"></div>
            
        </div>
        <div class="card-body">
         <div class="clearfix"></div>  
        </div>
      <div class="clearfix m-20 m-b-25"></div>
      </div>
      
      <!--<div class="clearfix"></div>-->

    </div>


@stop


@section('js') 
            
	<script type="text/javascript">

        route_agregar="{{url('/')}}/reservar";
        route_agregarconusuario="{{url('/')}}/reservarconusuario";
        route_completado="{{url('/')}}/agendar/reservaciones/completado";

        $(document).ready(function(){

            $('#email').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            $('#email_confirmation').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            $(".tercero").attr("disabled","disabled");
            $(".tercero").css({
              "opacity": ("0.2")
            });

            $('#cambio').mask('AAAAAAAAAAAAAA', {'translation': {

                A: {pattern: /[A-Za-z]/}
                }

            });
        });

        $('button[name="tercero"]').click(function(){       

            var nombre = $('#cambio').val();

            $("input[name=nombre]").val(nombre);
            $('#mostrar').text(nombre);

        });

        $("#cambio").keyup(function(){

            if($("#cambio").val() != ""){

            $(".tercero").removeAttr("disabled");
            $(".tercero").css({
              "opacity": ("1")
             });
              
          }else{

            $(".tercero").attr("disabled","disabled");
            $(".tercero").css({
              "opacity": ("0.2")
            });
          }
        });

        function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
                    $.growl({
                        icon: icon,
                        title: titulo,
                        message: mensaje,
                        url: ''
                    },{
                            element: 'body',
                            type: type,
                            allow_dismiss: true,
                            placement: {
                                    from: from,
                                    align: align
                            },
                            offset: {
                                x: 20,
                                y: 85
                            },
                            spacing: 10,
                            z_index: 1070,
                            delay: 2500,
                            timer: 2000,
                            url_target: '_blank',
                            mouse_over: false,
                            animate: {
                                    enter: animIn,
                                    exit: animOut
                            },
                            icon_type: 'class',
                            template: '<div data-growl="container" class="alert" role="alert">' +
                                            '<button type="button" class="close" data-growl="dismiss">' +
                                                '<span aria-hidden="true">&times;</span>' +
                                                '<span class="sr-only">Close</span>' +
                                            '</button>' +
                                            '<span data-growl="icon"></span>' +
                                            '<span data-growl="title"></span>' +
                                            '<span data-growl="message"></span>' +
                                            '<a href="#" data-growl="url"></a>' +
                                        '</div>'
                    });
                };

          $("#guardar").click(function(){

            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#agregar_usuario" ).serialize(); 
            $("#guardar").attr("disabled","disabled");
            procesando();
            $("#guardar").css({
              "opacity": ("0.2")
            });
            $(".cancelar").attr("disabled","disabled");
            $(".procesando").removeClass('hidden');
            $(".procesando").addClass('show');         
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
                        finprocesado();
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;
                        window.location = route_completado;
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
                      
                    } 

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                      
                  }, 1000);
                },
                error:function(msj){
                    if(msj.responseJSON.error_mensaje){

                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');

                    }else{

                        setTimeout(function(){ 
                      
                            errores(msj.responseJSON.errores);
                      
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";       
                            var nFrom = $(this).attr('data-from');
                            var nAlign = $(this).attr('data-align');
                            var nIcons = $(this).attr('data-icon');
                            var nType = 'danger';
                            var nAnimIn = "animated flipInY";
                            var nAnimOut = "animated flipOutY";                       
                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                        }, 1000);
                    }
                    $("#guardar").removeAttr("disabled");
                    finprocesado();
                    $("#guardar").css({
                        "opacity": ("1")
                    });
                    $(".cancelar").removeAttr("disabled");
                    $(".procesando").removeClass('show');
                    $(".procesando").addClass('hidden');
                }
            });
        });

        $("#guardar_registro").click(function(){

            var route = route_agregarconusuario;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#consultar_usuario" ).serialize(); 
            $("#guardar").attr("disabled","disabled");
            procesando();
            $("#guardar").css({
              "opacity": ("0.2")
            });
            $(".cancelar").attr("disabled","disabled");
            $(".procesando").removeClass('hidden');
            $(".procesando").addClass('show');         
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
                      window.location = route_completado;
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
                  if(msj.responseJSON.error_mensaje){

                      swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');

                  }else{

                    setTimeout(function(){ 
                      
                      errores(msj.responseJSON.errores);
                      
                      var nTitle="   Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";       
                      var nFrom = $(this).attr('data-from');
                      var nAlign = $(this).attr('data-align');
                      var nIcons = $(this).attr('data-icon');
                      var nType = 'danger';
                      var nAnimIn = "animated flipInY";
                      var nAnimOut = "animated flipOutY";                       
                      notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                  }
                  $("#guardar").removeAttr("disabled");
                  finprocesado();
                  $("#guardar").css({
                    "opacity": ("1")
                  });
                  $(".cancelar").removeAttr("disabled");
                  $(".procesando").removeClass('show');
                  $(".procesando").addClass('hidden');
                }
            });
        });

        function limpiarMensaje(){
          var campo = ["email", "email_confirmation", "nombre", "password", "password_confirmation", "telefono", "como_nos_conociste_id", "correo_registro", "password_registro"];
            fLen = campo.length;
            for (i = 0; i < fLen; i++) {
                $("#error-"+campo[i]+"_mensaje").html('');
            }
          }

        function errores(merror){
            var campo = ["email", "email_confirmation", "nombre", "password", "password_confirmation", "telefono", "como_nos_conociste_id"];
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

        }

	</script>
@stop