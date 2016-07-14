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

    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title">Verificación de datos<button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="modal-body">
                        <div class="row p-l-10 p-r-10">

                        <div class="col-sm-5"></div>
                        <div class="col-sm-2"><i class="icon_a-tarjeta-de-regalo f-75"></i> </div>
                        <div class="col-sm-5"></div>

                        <div class="clearfix p-b-15"></div>
                        <div class="text-center">
                            <span class="f-25 c-morado text-center">Verifica tu regalo</span>  
                            <br></br>   
                            <span class="f-16 c-morado">Revisa detalladamente la tarjeta de regalo antes de pagar</span>  
                        </div>

                        <hr></hr>

                        <p><span class="f-20 f-700 opaco-0-8">Ítem o experiencia :</span> <span class="f-15 f-700 opaco-0-8" id="span_item" name="span_item"></span></p>

                        <hr></hr>
                        
                        <p><span class="f-20 f-700 opaco-0-8">Precio del regalo :</span> <span class="f-15 f-700 opaco-0-8" id="span_precio" name="span_precio"></span></p>

                        <hr></hr>
                        
                        <p><span class="f-20 f-700 opaco-0-8">Dirigido a :</span> <span class="f-15 f-700 opaco-0-8" id="span_dirigido" name="span_dirigido"></span></p>

                        <hr></hr>
                        
                        <p><span class="f-20 f-700 opaco-0-8">De Parte de  :</span> <span class="f-15 f-700 opaco-0-8" id="span_parte" name="span_parte"></span></p>

                        <hr></hr>
                        
                        <p><span class="f-20 f-700 opaco-0-8">Correo Electrónico :</span> <span class="f-15 f-700 opaco-0-8" id="span_correo" name="span_correo"></span></p>

                        <div class="clearfix p-b-15"></div>

                        <div class="text-center">

                          <button type="button" class="btn-blanco m-r-10 f-25 guardar" id="guardar" name="guardar">Listo <i class="zmdi zmdi-check"></i></button>

                        </div>

                        <div class="clearfix p-b-15"></div>
                           

                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">

                <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div>
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-tarjeta-de-regalo f-25"></i> Personaliza tu Regalo </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_regalo" id="agregar_regalo"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre"> Ítem o experiencia </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe el tipo de regalo de que deseas obsequiar relacionado a los servicios que ofrece tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-tarjeta-de-regalo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Inscripcion y Mensualidad">
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
                                    
                                      <label for="fecha_inicio" id="id-costo"> Precio del regalo </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el valor en moneda que deseas obsequiar" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input type="text" class="form-control input-sm input-mask" name="costo" id="costo" data-mask="000.000.000" placeholder="Ej. 2500">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-costo">
                                        <span >
                                            <small class="help-block error-span" id="error-costo_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion"> Descripción </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Diseña algún mensaje especial que deseas incluir en tu tarjeta de regalo" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="500 Caracteres"></textarea>
                                    </div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                    
                                      <label for="fecha_inicio" id="id-dirigido_a"> Dirigido a </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la persona a quien va dirigido el regalo" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-long-arrow-right zmdi-hc-fw f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="dirigido_a" id="dirigido_a" class="form-control" placeholder="Ej. Valeria Sanchez" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-dirigido_a">
                                        <span >
                                            <small class="help-block error-span" id="error-dirigido_a_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                    
                                      <label for="fecha_inicio" id="id-alumno_id"> De Parte de </label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de quien emite el regalo" title="" data-original-title="Ayuda"></i>


                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-long-arrow-left zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona">

                                           @foreach ( $alumnos as $alumno )
                                            <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="has-error" id="error-alumno_id">
                                        <span >
                                          <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                        </span>
                                      </div>
                                    </div>

                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                               <label for="apellido" id="id-correo">Correo Electrónico</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electrónico de la persona a la que le emitirás el regalo" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="correo" id="correo" placeholder="Ej. easydance@gmail.com">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
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

                            <div class="clearfix p-b-35"></div>
                            
                            <div class="col-sm-12 text-left">    

                              <button type="button" class="btn btn-blanco m-r-10 f-18 verificar" id="verificar">Dar Regalo</button>

                          <!--     <button type="button" class="btn btn-blanco m-r-10 f-18" data-toggle="modal" href="#modalAgregar">Dar Regalo</button> -->

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

  route_agregar="{{url('/')}}/especiales/regalos/agregar";
  route_verificar="{{url('/')}}/especiales/regalos/verificar";
  
  $(document).ready(function(){
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

      });
  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["nombre", "costo", "descripcion", "dirigido_a", "alumno_id", "correo"];
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


  $("#verificar").click(function(){

                var route = route_verificar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_regalo" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
                procesando();
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
                          // var nType = 'success';
                          // $("#agregar_regalo")[0].reset();
                          // var nTitle="Ups! ";
                          // var nMensaje=respuesta.mensaje;
                          // window.location = "{{url('/')}}/participante/alumno/deuda/" + respuesta.id;
                          $('#modalAgregar').modal('show');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        finprocesado();
                        $("#guardar").removeAttr("disabled");
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");

                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        finprocesado();
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

  $("#guardar").click(function(){

                procesando();
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_regalo" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
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
                          var nType = 'success';
                          $("#agregar_regalo")[0].reset();
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          window.location = "{{url('/')}}/participante/alumno/deuda/" + respuesta.id;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        // finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        finprocesado();
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
        var campo = ["nombre", "costo", "descripcion", "dirigido_a", "alumno_id", "correo"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
      var campo = ["nombre", "costo", "descripcion", "dirigido_a", "alumno_id", "correo"];
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
      }, 800);          

  }

       $( "#cancelar" ).click(function() {
        $("#agregar_regalo")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-nombre").offset().top-90,
        }, 800);
        document.getElementById("nombre").focus();
      });

    $('#modalAgregar').on('show.bs.modal', function (event) {
      $("#span_item").text($("#nombre").val()); 
      $("#span_precio").text($("#costo").val());
      $("#span_dirigido").text($("#dirigido_a").val());
      $("#span_correo").text($("#correo").val());   
      expresion = "#alumno_id option[value="+$("#alumno_id").val()+"]";
      texto = $(expresion).text();
      $("#span_parte").text(texto); 
    })
</script> 
@stop

