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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/productos" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Productos</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_f-productos f-25" id="id-clase_grupal_id"></i> Agregar Producto</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_producto" id="agregar_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                              <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del producto" title="" data-original-title="Ayuda"></i>
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Gomas de Baile">
                                      </div>
                                    </div>
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="costo" id="id-costo">Costo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el valor o precio del producto que ofreces a tus clientes" title="" data-original-title="Ayuda"></i>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="costo" id="costo" data-mask="00000000" placeholder="Ej. 5000">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-costo">
                                      <span >
                                          <small id="error-costo_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="cantidad" id="id-cantidad">Cantidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de unidades disponibles del producto" title="" data-original-title="Ayuda"></i>
                                        <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="00000000" placeholder="Ej. 50">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-costo">
                                      <span >
                                          <small id="error-cantidad_mensaje" class="help-block error-span" ></small>
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                <label for="imagen" id="id-imagen">Cargar Imagen</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona una imagen del producto desde tu ordenador, soporta formato en JPG, JPEG Y PNG, el tamaño de la imagen debe ser menor o igual a 1 MB. Nota: imágenes grandes o mayor a 230 x 120 se reducirán" title="" data-original-title="Ayuda"></i>
                            
                                <div class="clearfix"></div>
                              
                              <input type="hidden" name="imageBase64" id="imageBase64">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                <div>
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="imagen" id="imagen" >
                                    </span>
                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                </div>
                            </div>
                              <div class="has-error" id="error-imagen">
                              <span >
                                  <small class="help-block error-span" id="error-imagen_mensaje"  ></small>
                              </span>
                            </div>
                          </div>

                          <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="descripcion" id="id-descripcion">Descripción</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las caracteristicas del producto que ofreces a tus clientes" title="" data-original-title="Ayuda"></i>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="80 Caracteres"  maxlength="80" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">80</span> Caracteres</div>
                                 </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="tipo" id="id-tipo">Categoría</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona en la categoría en que se encuentre el producto, por ejemplo, si es una camiseta que ofreces como venta, pertenece a un evento de la academia y deseas reflejar en los reportes en el sector que se encuentra dicho producto, debes indicar que este pertenece a la categoría evento. De esa forma podrás sectorizar el Tipo de producto que ofreces a tus clientes" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">
                                          <option value="2">Academia Recepción</option>
                                          <option value="11">Campaña</option>
                                          <option value="14">Fiesta y Eventos</option>
                                          <option value="5">Taller</option>
                                          
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-tipo">
                                      <span >
                                        <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Incluye impuestos fiscales (IVA)</label id="id-iva"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica si manejas impuestos fiscales, en caso que el producto no aplique, deja el suiche de modo inactivo" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="incluye_iva" name="incluye_iva" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="iva" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                       </div>
                                       <div class="has-error" id="error-impuesto">
                                            <span >
                                                <small class="help-block error-span" id="error-impuesto_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                  <div class="clearfix p-b-35"></div>   

                                <div class="col-sm-12">
                                   <div class="form-group fg-line ">
                                      <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar la clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                      
                                      <br></br>
                                      <input type="text" id="boolean_promocionar" name="boolean_promocionar" value="" hidden="hidden">
                                      <div class="p-t-10">
                                        <div class="toggle-switch" data-ts-color="purple">
                                        <span class="p-r-10 f-700 f-16">No</span><input id="promocionar" type="checkbox">
                                        
                                        <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                        </div>
                                      </div>
                                      
                                   </div>
                                   <div class="has-error" id="error-boolean_promocionar">
                                        <span >
                                            <small class="help-block error-span" id="error-boolean_promocionar_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                 </div>

                               <div class="clearfix p-b-35"></div>

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
                            <div class="col-sm-12 text-left">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

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

  route_agregar="{{url('/')}}/productos/agregar";
  route_principal="{{url('/')}}/productos";
  
  $(document).ready(function(){

        $("#promocionar").on('change', function(){
          if ($("#promocionar").is(":checked")){
            $("#boolean_promocionar").val('1');
          }else{
            $("#boolean_promocionar").val('0');
          }    
        });

        if("{{$incluye_iva}}" == 1){
          $("#incluye_iva").val('1');  //VALOR POR DEFECTO
          $("#iva").attr("checked", true); //VALOR POR DEFECTO
        }
        
        $("#iva").on('change', function(){
          if ($("#iva").is(":checked")){
            $("#incluye_iva").val('1');
          }else{
            $("#incluye_iva").val('0');
          }   
          console.log($("#incluye_iva").val());     
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

        document.getElementById("nombre").focus();

        $("#imagen").bind("change", function() {
            //alert('algo cambio');
            
            setTimeout(function(){
              var imagen = $("#imagena img").attr('src');
              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL("image/jpeg", 0.8);
              var image64 = $("input:hidden[name=imageBase64]").val(newimage);
            },500);

        });

      });

  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["nombre", "costo", "descripcion", "imagen", "iva", "cantidad"];
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
                var datos = $( "#agregar_producto" ).serialize(); 
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
      var campo = ["nombre", "costo", "cantidad", "descripcion", "imagen", "iva"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
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
      }, 1000);          

  }  

       $( "#cancelar" ).click(function() {
        $("#agregar_producto")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
        $("#id-nombre").focus();
      });

    function addFieldText(newLat, newLng){
      $('#coord').val(newLat+', '+newLng);
    }

    function countChar(val) {
      var len = val.value.length;
      if (len >= 80) {
        val.value = val.value.substring(0, 80);
      } else {
        $('#charNum').text(80 - len);
      }
    };

</script> 
@stop

