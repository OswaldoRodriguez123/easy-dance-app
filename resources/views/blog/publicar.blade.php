@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
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
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/blog" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="glyphicon glyphicon-book f-25" id="id-entrada"></i> Agregar Entrada </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_entrada" id="agregar_entrada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                            <div class="col-sm-12">
                                 
                                  <label for="usuario_id" id="id-usuario_id">Autor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el autor de la entrada" title="" data-original-title="Ayuda" data-html="true"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_b-nombres f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="usuario_id" id="usuario_id" data-live-search="true">

                                        <option value="">Selecciona</option>
                                        @foreach($bloggers as $blogger)
                                          <option value="{{$blogger->id}}">{{$blogger->nombre}}</option>
                                        @endforeach
                                        
                                      
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                 <div class="has-error" id="error-usuario_id">
                                      <span >
                                          <small class="help-block error-span" id="error-usuario_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="titulo" id="id-titulo">Titulo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el titulo de la entrada" title="" data-original-title="Ayuda" data-html="true"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-book f-22"></i></span>
                                      <div class="fg-line">
                                        <textarea class="form-control" id="titulo" name="titulo" rows="2" placeholder="60 Caracteres" maxlength="60" onkeyup="countChar(this)"></textarea>
                                      </div>
                                      <div class="opaco-0-8 text-right">Resta <span id="charNum">60</span> Caracteres</div>
                                    </div>
                                 <div class="has-error" id="error-titulo">
                                      <span >
                                          <small class="help-block error-span" id="error-titulo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                  <label for="categoria">Categoría</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona la categoria de la entrada" title="" data-original-title="Ayuda" data-html="true"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="categoria" id="categoria" data-live-search="true">

                                        <option value="">Selecciona</option>
                                        @foreach($categorias as $categoria)
                                          <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                        
                                      
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                 <div class="has-error" id="error-categoria">
                                      <span >
                                          <small class="help-block error-span" id="error-categoria_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                  <label for="tipo">A quien va dirigido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona a quienes le llegaran un correo al publicarse esta entrada" title="" data-original-title="Ayuda" data-html="true"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">

                                        <option value="1">Todos</option>
                                        <option value="2">Visitantes Presenciales</option>
                                        <option value="3">Alumnos</option>
                                        <option value="4">En Espera</option>
                                        
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                 <div class="has-error" id="error-tipo">
                                      <span >
                                          <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                               
                               <div class="col-sm-12">
                                 
                                      <label for="fecha_inicio" id="id-contenido">Contenido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el contenido de la entrada" title="" data-original-title="Ayuda"></i>

                                      <div id="contenido"></div>
                                 <div class="has-error" id="error-contenido">
                                      <span >
                                          <small class="help-block error-span" id="error-contenido_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
    
                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                <label for="apellido" id="id-imagen">Imagen Principal</label></label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga la imagen principal de la entrada" title="" data-original-title="Ayuda"></i>
                                
                                <div class="clearfix p-b-15"></div>
                                  
                                <input type="hidden" name="imageBase64" id="imageBase64">
                                  <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px"></div>
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
                                <label for="apellido" id="id-imagen_poster">Imagen Poster</label></label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga la imagen poster de la entrada" title="" data-original-title="Ayuda"></i>
                                
                                <div class="clearfix p-b-15"></div>
                                  
                                <input type="hidden" name="imagePoster64" id="imagePoster64">
                                  <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                    <div>
                                        <span class="btn btn-info btn-file">
                                            <span class="fileinput-new">Seleccionar Imagen</span>
                                            <span class="fileinput-exists">Cambiar</span>
                                            <input type="file" name="imagen_poster" id="imagen_poster" >
                                        </span>
                                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                    </div>
                                </div>
                                  <div class="has-error" id="error-imagen_poster">
                                  <span >
                                      <small class="help-block error-span" id="error-imagen_poster_mensaje"  ></small>
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

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar Borrador</button>

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

@stop
@section('js') 
<script type="text/javascript">

    route_agregar="{{url('/')}}/blog/publicar";
    route_principal="{{url('/')}}/blog";

  $(document).ready(function(){

      $('#contenido').summernote({
          height: 400,
          dialogsInBody: true,
          // toolbar: [
          //   ['style', ['bold', 'italic', 'underline']],
          //   ['fontsize', ['fontsize']],
          //   ['color', ['color']],
          //   ['para', ['ul', 'ol', 'paragraph']],
          //   ['height', ['height']],
          //   ['link', ['link']],
          // ],
          lang: 'es-ES'

      }); 

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

      $("#imagen_poster").bind("change", function() {
          //alert('algo cambio');
          
          setTimeout(function(){
            var imagen = $("#imagenb img").attr('src');
            var canvas = document.createElement("canvas");
   
            var context=canvas.getContext("2d");
            var img = new Image();
            img.src = imagen;
            
            canvas.width  = img.width;
            canvas.height = img.height;

            context.drawImage(img, 0, 0);
     
            var newimage = canvas.toDataURL("image/jpeg", 0.8);
            var image64 = $("input:hidden[name=imagePoster64]").val(newimage);
          },500);

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

                var contenido = $('#contenido').summernote('code');
                contenido = encodeURIComponent(contenido);
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_entrada" ).serialize(); 
                procesando();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos+"&contenido="+contenido,
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
                          finprocesado();

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        // if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        finprocesado();
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
      var campo = ["usuario_id","titulo", "contenido", "categoria"];
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
      }, 1500);          

  }

  $( "#cancelar" ).click(function() {
    $("#agregar_entrada")[0].reset();
    limpiarMensaje();
    $('html,body').animate({
    scrollTop: $("#id-titulo").offset().top-90,
    }, 1500);
    $("#titulo").focus();
  });

  function countChar(val) {
    var len = val.value.length;
    if (len >= 60) {
      val.value = val.value.substring(0, 60);
    } else {
      $('#charNum').text(60 - len);
    }
  };

    

</script> 
@stop

