@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/promociones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Secci??n Promoci??n</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-promocion f-25" id="id-clase_grupal_id"></i> Agregar una Promoci??n </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_promocion" id="agregar_promocion"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">??Cu??l es el nombre de la promoci??n?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la promoci??n" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-promocion f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Dia de las Madres">
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
                                 
                                    <label for="numero" id="id-numero">??Cu??l es el numero de canjes que tendra la promocion?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el numero de veces que el codigo podra ser reclamado" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-promocion f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="numero" id="numero" placeholder="Ej. 100">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-numero">
                                      <span >
                                          <small class="help-block error-span" id="error-numero_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre" id="id-porcentaje_descuento">??Cu??l es el porcentaje de descuento que le asignar??s?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el porcentaje de descuento que ofreces como promoci??n" title="" data-original-title="Ayuda"></i>


                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="icon_a icon_a-presupuesto f-22"></i></span>
                                            <div class="dtp-container fg-line">
                                                    <input type="text" class="form-control input-sm input-mask" name="porcentaje_descuento" id="porcentaje_descuento" data-mask="00" placeholder="Ej. 12">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-porcentaje_descuento">
                                            <span >
                                                <small class="help-block error-span" id="error-porcentaje_descuento_mensaje" ></small>                                
                                            </span>
                                        </div>


                                     </div>
                                  </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre" id="id-fecha_inicio">Fecha de promoci??n</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el d??a en el que iniciar?? tu promoci??n hasta el d??a en que culmine, recomendamos que la fecha de promoci??n no supere los 60 dias" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="fg-line">
                                              <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha">
                                      </div>
                                    </div>
                                    
                                     
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Describe tu promoci??n</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Informarle a tus clientes el tipo de promoci??n que est??s ofreciendo" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="1000 Caracteres" maxlength="1000" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">1000</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                            <label for="apellido" id="id-imagen">Cargar Imagen</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Soporta formatos en: JPEG, JPG y PNG. El tama??o de la imagen debe menor o igual a 1 MB. NOTA: Logos grandes o mayor de 230 x 120 se reducir??n" title="" data-original-title="Ayuda"></i>
                            
                            <div class="clearfix p-b-15"></div>
                              
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
                                     <label for="nombre" id="id-edad_inicio">Edad</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="A trav??s de este campo podr??s segmentar tu promoci??n por edades" title="" data-original-title="Ayuda"></i>
                                    
                                       <div class="panel-body">
                                          <div class="col-xs-6">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="icon_b-fecha-de-nacimiento f-22"></i></span>
                                            <div class="dtp-container fg-line">
                                                    <input type="text" class="form-control input-sm input-mask" name="edad_inicio" id="edad_inicio" data-mask="00" placeholder="Desde">
                                            </div>
                                          </div>
                                       <div class="has-error" id="error-edad_inicio">
                                            <span >
                                                <small class="help-block error-span" id="error-edad_inicio_mensaje" ></small>                                
                                            </span>
                                        </div>
                                     </div>

                                     <div class="col-xs-6" id="id-edad_final">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="icon_b-fecha-de-nacimiento f-22"></i></span>
                                            <div class="dtp-container fg-line">
                                                    <input type="text" class="form-control input-sm input-mask" name="edad_final" id="edad_final" data-mask="00" placeholder="Hasta">
                                                </div>
                                          </div>
                                       <div class="has-error" id="error-edad_final">
                                            <span >
                                                <small class="help-block error-span" id="error-edad_final_mensaje" ></small>                                
                                            </span>
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                  </div>
      
                               <br>

                                <div class="col-sm-12">
                               <label for="nombre" id="id-sexo">Sexo</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="A trav??s de este campo podr??s segmentar tu promoci??n por sexo, masculino o femenino" title="" data-original-title="Ayuda"></i>
                                    
                                        <div class="panel-body">
                                          <div class="col-xs-6">
                                            <div class="input-group">
                                              <div class="input-group">
                                                <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
                                                <div class="p-t-10">
                                                <label class="radio radio-inline m-r-20">
                                                  <input name="sexo" id="ambos" value="A" type="radio">
                                                  <i class="input-helper"></i>  
                                                  Ambos <i class="zmdi zmdi-male-female p-l-5 f-20"></i>
                                              </label>
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
                                          </div>
                                       <div class="has-error" id="error-sexo">
                                            <span >
                                                <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                            </span>
                                        </div>
                                     </div>

                                     </div>
                                  </div>
                                </div>
    
                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="condiciones" id="id-condiciones">Condiciones y Normativas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las condiciones necesarias, dichas condiciones ser??n vistas por tus clientes y de esa forma podr??s mantener una comunicaci??n clara y transparente en cuanto a las normativas que rigen en tus actividades" title="" data-original-title="Ayuda"></i>
                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="condiciones" name="condiciones" rows="2" placeholder="1500 Caracteres" maxlength="1500" onkeyup="countChar2(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum2">1500</span> Caracteres</div>
                                    <div class="has-error" id="error-condiciones">
                                      <span >
                                        <small class="help-block error-span" id="error-condiciones_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                  <label for="id" id="id-video_promocional">Ingresa url del video promocional</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendr??s  m??s oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_promocional" id="video_promocional" placeholder="Ingresa la url">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_promocional">
                                    <span >
                                     <small id="error-video_promocional_mensaje" class="help-block error-span" ></small>                                           
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
                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Crear la Promoci??n</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar">Cancelar</button>

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

  route_agregar="{{url('/')}}/especiales/promociones/agregar";
  route_principal="{{url('/')}}/especiales/promociones";
  
  $(document).ready(function(){

      $("#ambos").prop('checked', true);

        $('#fecha').daterangepicker({
            "autoApply" : false,
            "opens": "left",
            "applyClass": "bgm-morado waves-effect",
            locale : {
                format: 'DD/MM/YYYY',
                applyLabel : 'Aplicar',
                cancelLabel : 'Cancelar',
                daysOfWeek : [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],        
            }
        });

        document.getElementById("nombre").focus();
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

  var valor="";

  function porcentaje(){
    var campo = ["nombre", "numero", "porcentaje_descuento", "descripcion", "fecha", "imagen", "edad_inicio", "edad_final", "video_promocional","condiciones"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if ( valor.length > 0 ){        
          cantidad=cantidad+1;
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
                var datos = $( "#agregar_promocion" ).serialize(); 
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
        var campo = ["nombre", "numero", "porcentaje_descuento", "descripcion", "fecha", "imagen", "edad_inicio", "edad_final", "video_promocional","condiciones"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
      var campo = ["nombre", "numero", "porcentaje_descuento", "descripcion", "fecha", "imagen", "edad_inicio", "edad_final", "video_promocional","condiciones"];
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
    $("#agregar_promocion")[0].reset();
    limpiarMensaje();
    $('html,body').animate({
    scrollTop: $("#id-clase_grupal_id").offset().top-90,
    }, 1500);
    $("#nombre").focus();
  });

   function countChar(val) {
    var len = val.value.length;
    if (len >= 1000) {
      val.value = val.value.substring(0, 1000);
    } else {
      $('#charNum').text(1000 - len);
    }
  };

  function countChar2(val) {
    var len = val.value.length;
    if (len >= 1500) {
      val.value = val.value.substring(0, 1500);
    } else {
      $('#charNum2').text(1500 - len);
    }
  };
</script> 
@stop

