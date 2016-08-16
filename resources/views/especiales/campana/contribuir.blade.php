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
<!--MERCADO PAGO MODAL -->
<script type="text/javascript" src="http://resources.mlstatic.com/mptools/render.js"></script>
@stop

@section('content')
  <!-- ENHORABUENA -->

  
    
    <div class="container">
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">

              <div class="panel-body">
                    
                <div role="tabpanel" class="tab">
                   
                    <div class="tab-content ">
                     
                     <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="primero">

                    <div class="block-header text-center">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    
                    <div class="c-morado text-center">
                      
                        

                        <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar" href="#segundo" aria-controls="segundo" role="tab" data-toggle="tab">Hablemos</button>

                    </div> 
                  </div>

                  <div class="col-md-1"></div>

                  
                  </div>
                    
                 </div>

                 <div role="tabpanel" class="tab-pane active animated fadeInRight in" id="segundo">

                    <div class="block-header text-center">

                    
                    <img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;  margin: 0 auto;" class="img-responsive opaco-0-8" alt="">
                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="text-center">
                      
                    <p class="f-30">Hola, mi nombre es Peggy de Easy dance</p> 
                    <p class="f-25">Estás aquí porqué apoyas la campaña de {{$academia->nombre}} </p> 
                    <p class="f-25">Llamada, <span class="f-700" style="color:black">{{$campana->nombre}}</span></p>
                    <div class="text-center c-morado f-30">Dime,  ¿Cuál es tu nombre? </div>
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

                 </div>

                 <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="tercero">

                    <div class="text-center">

                    <div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px; margin: 0 auto;" class="img-responsive opaco-0-8" alt=""></div>
                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="text-center">
                      
                    <p class="f-30">Muy bien <span class="f-700" id="mostrar">Nombre</span></p> 
                    <p class="f-25">Te estaré re direccionado para la página de mercadopago, en el que puedes a través de tu tarjeta de crédito <br> pagar de forma rápida y segura, ademas necesitamos tu correo electrónico </p>

                    <div class="text-center c-morado f-30">Dime, ¿por cuanto será tu contribución? </div>
                    <div class="clearfix m-20 m-b-25"></div>
                   
                    <input type="text" class="form-control caja" id="monto" name="monto" data-mask="0000000000"></input>
                    <div class="has-error" id="error-monto">
                        <span >
                            <small id="error-monto_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>
                    
                    <div class="text-center c-morado f-30">Dime tu Correo Electronico</div>
                    <div class="clearfix m-20 m-b-25"></div>
                    <input type="text" class="form-control caja" id="email_externo" name="email_externo"></input>
                    <div class="has-error" id="error-email_externo">
                        <span >
                            <small id="error-email_externo_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>

                    <hr>
                    <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar cuarto" href="#cuarto" aria-controls="cuarto" role="tab" data-toggle="tab" name="cuarto" id="cuarto">Ok <i class="zmdi zmdi-check"></i><i class="zmdi zmdi-replay zmdi-hc-spin-reverse"></i></button>
                    <span class="f-700">Pulsa Aqui</span>


                    </div> 

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
                                    <label for="correo">Número telefónico</label>
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
                                 <div class="col-sm-6">
                                           <label>¿Cómo nos conociste?</label>
                                          <div class="form-group">
                                              <span class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-como-se-entero f-22"></i></span>
                                                <div class="fg-line">
                             
                                                </div>
                                           </span>
                                        <div class="has-error" id="error-como_nos_conociste_id">
                                          <span >
                                           <small id="error-como_nos_conociste_id_mensaje" class="help-block error-span" ></small>
                                          </span>
                                          </div>
                                    </div>
                                 </div>
                               </div>
                               <br><br><br><br>        
                    <div class="text-center">
                       <!-- <a class="btn-blanco2 m-r-6 f-22 guardar" id="guardar"  style=" margin-top: 60px; " >  Llévame </a> -->

                       <button type="button" class="btn-blanco m-r-10 f-22 guardar" id="guardar" name ="guardar" onclick="procesando()">Llévame</button>

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

    route_agregar="{{url('/')}}/registro";
    route_completado="{{url('/')}}/registro/completado";
    route_pagar_participante="{{url('/')}}/especiales/campañas/partcipante_externo";

    $(document).ready(function(){

        $(".zmdi-hc-spin-reverse").css('visibility','hidden');

    $('#email').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    $('#email_confirmation').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    $('#password').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    $('#password_confirmation').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

        $(".tercero").attr("disabled","disabled");
        $(".tercero").css({
          "opacity": ("0.2")
        });

        $(".cuarto").attr("disabled","disabled");
        $(".cuarto").css({
          "opacity": ("0.2")
        });

        $('#cambio').mask('AAAAAAAAAAAAAA', {'translation': {

            A: {pattern: /[A-Za-z]/}
            }

        });

        //PAGAR CAMPAÑA
        $("#cuarto").on("click",function(){

            var token = $('input:hidden[name=_token]').val();
            var nombre = $("input[name=nombre]").val();
            var monto = $("input[name=monto]").val();
            var email_externo = $("input[name=email_externo]").val();
            var campana_id = "{{$campana->id}}";
            var campana_nombre = "{{$campana->nombre}}";
            var academia_id = "{{$academia->id}}";

            $(".zmdi-check").css('visibility','hidden');
            $(".zmdi-hc-spin-reverse").css('visibility','visible');

                $.ajax({
                    url: route_pagar_participante,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            nombre : nombre,
                            monto: monto,
                            campana_id : campana_id,
                            campana_nombre : campana_nombre,
                            academia_id : academia_id,
                            email_externo : email_externo
                        },
                    success:function(respuesta){
                        if(respuesta.status == 'OK'){
                            window.location = route_pagar_participante;
                        }    
                    },
                    error:function(msj){
                      
                    }
                });

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
          
      }
      else{

        $(".tercero").attr("disabled","disabled");
        $(".tercero").css({
          "opacity": ("0.2")
        });
      }
    });


    //$("#monto").keyup(function(){
    $("#email_externo").keyup(function(){



            if($("#monto").val() != "" && $("#email_externo").val()!=""){

                $(".cuarto").removeAttr("disabled");
                $(".cuarto").css({
                  "opacity": ("1")
                 });
                  
            }else{

                $(".cuarto").attr("disabled","disabled");
                $(".cuarto").css({
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
                      console.log(msj.responseJSON);
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        errores(msj.responseJSON.errores);
                        
                        var nTitle="   Ups! "; 
                        var nMensaje="Ha ocurrido un error, intente nuevamente por favor";                     
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

    function limpiarMensaje(){
      var campo = ["email", "email_confirmation", "nombre", "password", "password_confirmation", "telefono", "como_nos_conociste_id"];
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