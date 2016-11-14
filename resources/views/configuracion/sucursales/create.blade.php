@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/administradores" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Administradores</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">

                      <div class="card-header text-center">
                        <span class="f-25 c-morado" id="id-clase_grupal_id"> <i class="icon_f-administradores f-25"></i> Agregar un nuevo Administrador</span>
                      </div>

                      <div class="card-body p-b-20 m-l-20 m-r-20">
                        <div class="clearfix m-20 m-b-25"></div>
               
                        <form name="agregar_usuario_sucursal" id="agregar_usuario_sucursal"  >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!--<input type="hidden" name="nombre" value= "Prueba" >-->
                                <div class="row">
                                    <div class="col-sm-6">
                                         <div class="form-group">

                                            <label for="email" id="id-email">Correo electrónico</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electrónico del participante " title="" data-original-title="Ayuda"></i>
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
                                            <label for="confirm-email" id="id-email_confirmation">Confirmar Correo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Repite el correo electrónico para confirmar su cuenta" title="" data-original-title="Ayuda"></i>
                                            <span class="input-group">
                                            <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                            <div class="fg-line">
                                            <input type="text" class="form-control input-sm" name="email_confirmation" id="email_confirmation" placeholder="Repite correo electrónico" autocomplete="off">
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

                                        <div class="row">
                                     <div class="col-sm-6 ">
                                         <div class="form-group">
                                            <label for="correo" id="id-password">Contraseña</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa una contraseña que contenga un mínimo de seis (6) caracteres , esta podrá ser números o letras, mayúsculas o minúscula" title="" data-original-title="Ayuda"></i>
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
                                            <label for="direccion" id="id-password_confirmation">Confirmar tu contraseña</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Repite la contraseña para confirmarla" title="" data-original-title="Ayuda"></i>
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
                                
                                <div class="row">
                                   <div class="col-sm-6">
                                         <div class="form-group">
                                            <label for="correo" id="id-responsable">Administrador</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del participante que recibirá la invitación para usar la cuenta de invitación" title="" data-original-title="Ayuda"></i>
                                            <span class="input-group">
                                            <span class="input-group-addon"><i class="zmdi zmdi-account f-22"></i></span>
                                            <div class="fg-line">
                                            <input type="text" class="form-control input-sm input-mask" name="responsable" id="responsable" placeholder="Coordinador o responsable">
                                            </div>
                                            </span>
                                         </div>
                                         <div class="has-error" id="error-responsable">
                                            <span >
                                             <small id="error-responsable_mensaje" class="help-block error-span" ></small>
                                            </span>
                                            </div>
                                       </div>

                                       <div class="col-sm-6">
                                           <label>Tipo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de cuenta que deseas invitar" title="" data-original-title="Ayuda"></i>
                                          <div class="form-group">
                                              <span class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-como-se-entero f-22"></i></span>
                                                <div class="fg-line">
                                                  <div class="select">
                                                      <select class="form-control" id="usuario_tipo" name="usuario_tipo" placeholder="Seleccione>>">
                                                      <option value="">Selecciona</option>
                                                      <option value="1">Administrador</option>
                                                      <option value="5">Sucursal</option>
                                                      <option value="6">Recepcionista</option>

                                                      </select>
                                                </div>
                                                </div>
                                           </span>
                                        <div class="has-error" id="error-usuario_tipo">
                                          <span >
                                           <small id="error-usuario_tipo_mensaje" class="help-block error-span" ></small>
                                          </span>
                                          </div>
                                    </div>
                                 </div>

                                       </div>
                                       <br><br><br><br>        
                            <div class="text-center">
                               <!-- <a class="btn-blanco2 m-r-6 f-22 guardar" id="guardar"  style=" margin-top: 60px; " >  Llévame </a> -->

                               <button type="button" class="btn-blanco m-r-10 f-22 guardar" id="guardar" name ="guardar" onclick="procesando()">Guardar</button>
                               <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

                            </div>
                             <br><br><br> 
                        </form>
                      </div>  <!-- END CARD BODY -->



                    </div>  <!-- END CARD -->
                </div>  <!-- END CONATAINER -->    

            </section>

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/configuracion/administradores/agregar";
  route_principal="{{url('/')}}/configuracion/administradores";
  
  $(document).ready(function(){

    $('#responsable').mask('AAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z]/}
        }

      });

        

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
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

        document.getElementById("email").focus();

      });

  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["email", "email_confirmation", "password", "password_confirmation", "responsable"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }
    //$("#barra-progreso").s

  }

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
                var datos = $( "#agregar_usuario_sucursal" ).serialize(); 
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
                          window.location = route_principal;
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
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
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

      function limpiarMensaje(){
      var campo = ["email", "email_confirmation", "password", "password_confirmation", "responsable"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["email", "email_confirmation", "password", "password_confirmation", "responsable"];
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

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 500);          

  }  

       $( "#cancelar" ).click(function() {
        $("#agregar_usuario_sucursal")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
        $("#email").focus();
      });


</script> 
@stop

