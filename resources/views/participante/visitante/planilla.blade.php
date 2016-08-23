@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@stop

@section('content')
     
           
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Visitante</a>
                    </div> 
                    
                    <div class="card">
                      <div class="card-header">
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
                            <div class="text-center p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a-visitante-presencial"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Visitante</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo visitante</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <a class="email"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="impresion"><i class="icon_a-examen f-20 m-r-5 boton blue sa-warning" data-original-title="Realizar encuesta" data-toggle="tooltip" data-placement="bottom" title=""></i></a>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Visitante</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="disabled" data-toggle="modal" href="#modalNombre-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($visitante->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-nombre" class="capitalize">{{$visitante->nombre}}</span> <span id="visitante-apellido" class="capitalize">{{$visitante->apellido}}</span></td>
                            </tr>
                            <tr class="disabled" data-toggle="modal" href="#modalFechaNacimiento-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_nacimiento" class="zmdi {{ empty($visitante->fecha_nacimiento) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-calendar-check f-22"></i> </span>
                               <span class="f-14"> Fecha de nacimiento  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="visitante-fecha_nacimiento" >{{ \Carbon\Carbon::createFromFormat('Y-m-d',$visitante->fecha_nacimiento)->format('d/m/Y')}}</span></td>
                            </tr>
                             <tr class="disabled" data-toggle="modal" href="#modalSexo-Visitante">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty($visitante->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-sexo" data-valor="{{$visitante->sexo}}">
                               @if($visitante->sexo=='F')
                                  <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                               @else
                                  <i class="zmdi zmdi-male f-25 c-azul"></i> </span>
                               @endif
                             </span></td>
                            </tr>
                            <tr class="disabled" data-toggle="modal" href="#modalCorreo-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($visitante->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-correo"><span>{{$visitante->correo}}</span></span> <span class="pull-right c-blanco"></td>
                            </tr>
                            <tr class="disabled" data-toggle="modal" href="#modalTelefono-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty($visitante->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-telefono">{{$visitante->telefono}}</span> / <span id="visitante-celular">{{$visitante->celular}}</span><span class="pull-right c-blanco"></td>
                            </tr>
                              <tr class="disabled" data-toggle="modal" href="#modalComoseentero-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-como_nos_conociste_id" class="zmdi {{ empty($visitante->como_nos_conociste_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-como-se-entero f-22"></i> </span>
                               <span class="f-14"> ¿Cómo se Enteró? </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-como_nos_conociste_id"><span>{{$visitante->como_nos_conociste_nombre}}</span></span></td>
                            </tr>
                            <tr class="disabled" data-toggle="modal" href="#modalEspecialidades-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidad_id" class="zmdi {{ empty($visitante->especialidad_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especialidad de Interés </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-especialidad_id"><span>{{$visitante->especialidad_nombre}}</span></span></td>
                            </tr>
                            <tr class="disabled" data-toggle="modal" href="#modalDireccion-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty($visitante->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="visitante-direccion" class="f-14 m-l-15" data-valor="{{$visitante->direccion}}" ><span ><span>{{ str_limit($visitante->direccion, $limit = 30, $end = '...') }}</span></span></td>
                            </tr>


                           </table>

                          
                          <div class="clearfix"></div>   
               
           
                          </div>

                    
            


					                   </div>
                          </div>
                      </div>                       
                    </div>                   
                </div>
            </section>
@stop


@section('js') 
   <script type="text/javascript">
    route_update="{{url('/')}}/participante/visitante/update";
    route_email="{{url('/')}}/correo/sesion/";
    route_impresion="{{url('/')}}/participante/visitante/impresion/";

    $(document).ready(function(){

        $('#nombre').mask('AAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z]/}
        }

      });

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInLeftBig';
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

    $('#modalID-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#identificacion").val($("#visitante-identificacion").text()); 
    })
    $('#modalNombre-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#visitante-nombre").text()); 
      $("#apellido").val($("#visitante-apellido").text());
    })
    $('#modalFechaNacimiento-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#visitante-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#visitante-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })

    $('#modalCorreo-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#correo").val($("#visitante-correo").text()); 
    })

    $('#modalTelefono-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#visitante-telefono").text());
      $("#celular").val($("#visitante-celular").text()); 
    })

    $('#modalDireccion-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var direccion=$("#visitante-direccion").data('valor');
       $("#direccion").val(direccion);
    })

    $('#modalEstatus-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var status= $("#visitante-estatus").data('valor');
      if(status==1){
        $("#activo").prop("checked", true);
      }else{
        $("#inactivo").prop("checked", true);
      }
      
    })

    function limpiarMensaje(){
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "estatus"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "estatus"];
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
      }

      function campoValor(form){
        $.each(form, function (n, c) {
          if(c.name=='sexo'){
            if(c.value=='M'){              
              var valor='<i class="zmdi zmdi-male f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#visitante-"+c.name).data('valor',c.value);
            $("#visitante-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#visitante-"+c.name).data('valor',c.value);
             $("#visitante-"+c.name).html(c.value.substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='como_nos_conociste_id' || c.name=='especialidad_id' || c.name=='dias_clase_id'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();

             $("#visitante-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else{
            $("#visitante-"+c.name).text(c.value.toLowerCase());
          }

          if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }
          
        });
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
                        template: '<div data-growl="container" class="alert f-700" role="alert">' +
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

    $(".guardar").click(function(){
        //$(this).data('formulario');
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        $(".guardar").attr("disabled","disabled");
         procesando();
        $("#guardar").css({
            "opacity": ("0.2")
        });
        $(".cancelar").attr("disabled","disabled");
        $(".procesando").removeClass('hidden');
        $(".procesando").addClass('show');
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#"+form ).serialize();
        var datos_array=  $( "#"+form ).serializeArray();
        console.log(datos_array);
        
        var route = route_update+"/"+update;
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: datos,                
            success: function (respuesta) {
              setTimeout(function() {
                if(respuesta.status=='OK'){
                  finprocesado(); 
                  campoValor(datos_array);            
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;                                      
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                 $(".procesando").removeClass('show');
                 $(".procesando").addClass('hidden');
                 $(".guardar").removeAttr("disabled");
                 finprocesado();
                $("#guardar").css({
                  "opacity": ("1")
                });
                 $(".cancelar").removeAttr("disabled");
                 $('.modal').modal('hide');
              }, 1000);  
            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                var nType = 'danger';
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
                  errores(msj.responseJSON.errores);
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }
                 notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  $(".procesando").removeClass('show');
                  $(".procesando").addClass('hidden');
                  $(".guardar").removeAttr("disabled");
                  finprocesado();
                  $("#guardar").css({
                    "opacity": ("1")
                  });
                  $(".cancelar").removeAttr("disabled");
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar al visitante?",   
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

    $(".email").click(function(){
         var route = route_email + 3;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/{{$visitante->id}}"  

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

        $(".impresion").click(function(){
        procesando();
        window.location = route_impresion + "{{$visitante->id}}";
      });
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
