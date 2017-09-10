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
                        <a class="btn-blanco m-r-10 f-4" href="#" > <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            
                            <span class="f-30 c-morado">Paga de manera fácil, rápido y seguro! </span>                                                         
                        </div>


                        
                        <div class="card-body p-b-20">
                          <form name="agregar_regalo" id="agregar_regalo"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                

                              <div class="col-sm-6"><img src="{{url('/')}}/assets/img/software-easy-dance.jpg" style="max-height: 500px; max-width: 500px;" class="img-responsive opaco-0-8" alt="">

                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>
                              <div class="clearfix p-b-15"></div>

                              </div>


                                  

                                  <div class="col-sm-6">
                                 
                                    <label for="nombre"> Nombre </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del titular de la tarjeta de crédito" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Valeria Sanchez">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               
                                <br></br>
                                <br></br>
                                <br></br>

                               <div class="col-sm-6">
                                    
                                      <label for="fecha_inicio"> Cédula /Id  </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de cédula o pasaporte del titular de la tarjeta de crédito" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="precio" id="precio" class="form-control" placeholder="Ej. 16133223" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-precio">
                                        <span >
                                            <small class="help-block error-span" id="error-precio_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                
                                <br></br>
                                <br></br>
                                <br></br>

                               <div class="col-sm-6">
                                 
                                    <label for="nombre"> Número de tarjeta  </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los números pertenecientes a tu tarjeta de crédito, aceptamos Visa y MasterCard" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"> <img src="{{url('/')}}/assets/img/visa-master.jpg" style="max-height: 50px; max-width: 50px;" class="img-responsive opaco-0-8" alt="">
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="descripcion" id="descripcion" placeholder="Ej. 5552453204064036">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                                <br></br>
                                <br></br>
                                <br></br>

                               <div class="col-sm-6">
                                    
                                      <label for="fecha_inicio"> Código de seguridad  </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los tres (3) dígitos que se encuentran en area posterior de tu tarjeta de crédito" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"> <img src="{{url('/')}}/assets/img/codigo.gif" style="max-height: 50px; max-width: 50px;" class="img-responsive opaco-0-8" alt="">
                                      <div class="dtp-container fg-line">
                                              <input name="dirigido_a" id="dirigido_a" class="form-control" placeholder="Ej. 553" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-dirigido_a">
                                        <span >
                                            <small class="help-block error-span" id="error-dirigido_a_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <br></br>
                                <br></br>
                                <br></br>

                                <div class="col-sm-6">
                                    
                                      <label for="fecha_inicio"> Fecha de vencimiento  </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la fecha de vencimiento de tu tarjeta de crédito" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                            <div class="dtp-container fg-line">
                                              <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker proceso" placeholder="Ej. 20/04/2020" type="text">
                                          </div>
                                        </div>

                                    </div>
                                    <div class="has-error" id="error-de_parte_de">
                                        <span >
                                            <small class="help-block error-span" id="error-de_parte_de_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>


                                <br></br>
                                <br></br>
                                <br></br>
                                <br></br>
                                <br></br>


                            
                            <div class="col-sm-6 text-center">    


                              <a class="btn-blanco m-r-10 f-22 guardar" id="guardar" href="#"> Confirmar mi pago
                              <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            
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


                        </div></form>
                    </div>
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

  route_agregar="{{url('/')}}/especiales/examenes/agregar";
  /*$('.proceso').on( 'click', function () {
    
  });*/

  /*$( ".proceso" ).blur(function () {
    
    porcentaje();

  });  

  $( ".proceso" ).change(function () {
    porcentaje();

  }); 

  $( ".proceso" ).selected(function () {
    
    porcentaje();

  });  

  $( ".proceso" ).focusout(function () {
    
    porcentaje();

  }); */  

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["nombre", "fecha", "descripcion", "imagen"];
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
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
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
                var datos = $( "#agregar_examen" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
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
                          var nType = 'success';
                          $("#agregar_examen")[0].reset();
                          $("#mujer").prop("checked", true);
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

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

      function limpiarMensaje(){
        var campo = ["nombre", "fecha", "descripcion", "imagen"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre", "fecha", "descripcion", "imagen"];
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
</script> 
@stop

