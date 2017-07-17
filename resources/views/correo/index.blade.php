@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>

@stop

@section('content')

            <div class="modal fade" id="modalCorreo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Enviar Correo: <span id="span_correo"></span> <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>

                        <form name="form_correo" id="form_correo"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="correo_id" id="correo_id">
                            <div class="modal-body">                           
                              <div class="row p-t-20 p-b-0">

                                @if(!isset($id))

                                  <div class="col-sm-12">
                                   
                                    <label for="dirigido">A quien va dirigido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona a quienes le llegara el correo" title="" data-original-title="Ayuda" data-html="true"></i>

                                    <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">
                                      <option value="1">Alumnos</option>
                                      <option value="3">Visitantes</option>
                                      <option value="5">Clases Grupales</option>
                                    </select>
         
                                    <div class="has-error" id="error-tipo">
                                        <span >
                                            <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                        </span>
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-15"></div>

                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="nombre">Nombre</label>
                                      <select class="selectpicker" name="usuario_id" id="usuario_id" data-live-search="true" data-container="body" multiple="" data-max-options="5" title="Todos">
                                      </select>
                                    </div>
                                    <div class="has-error" id="error-usuario_id">
                                      <span >
                                          <small class="help-block error-span" id="error-usuario_id_mensaje" ></small> 
                                      </span>
                                    </div>
                                  </div>

                                @else

                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="nombre">Nombre</label>

                                          <input type="hidden" name="usuario_id" id="usuario_id" value="{{$usuario->id}}">
                                          <label for="nombre" class="f-14">{{$usuario->nombre}} {{$usuario->apellido}} </label>

                                    </div>
                                    <div class="has-error" id="error-id">
                                      <span >
                                          <small class="help-block error-span" id="error-id_mensaje" ></small> 
                                      </span>
                                    </div>
                                  </div>

                                @endif

                              <div class="personalizado">

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                    <label for="id" id="id-url">Ingresa url de la imagen</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                                    <br><br>
                                    
                       
                                    <input type="text" class="form-control caja input-sm" name="url" id="url" placeholder="Ingresa la url">
                                     
                                     
                                     <div class="has-error" id="error-url">
                                      <span >
                                       <small id="error-url_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                      </div>                                          
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-12">

                                  <br><br>
                                   
                                      <label for="nombre" id="id-subj">Titulo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la clase personalizada" title="" data-original-title="Ayuda"></i>


                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="subj" id="subj" placeholder="Ej. Información">
                                        </div>
                                        <div class="has-error" id="error-subj">
                                        <span >
                                            <small class="help-block error-span" id="error-subj_mensaje" ></small>                                
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                  <label for="apellido" id="id-imagen">Cargar Imagen</label></label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                  
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

                                <div class="clearfix p-b-15"></div>
                                <div class="clearfix p-b-15"></div> 

                                <div class="col-md-12">
                                  <label for="id" id="id-msj_html">Mensaje</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                                  <br><br>
                                  <div id="html-personalizado"></div>
                                  <div class="has-error" id="error-msj_html">
                                    <span >
                                        <small class="help-block error-span" id="error-msj_html_mensaje" ></small>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-blanco m-r-10 f-14 fijo" id="enviar">Enviar</button>
                          <button type="button" class="btn btn-blanco m-r-10 f-14 personalizado" id="EnviarPersonalizado">Enviar</button>
                          <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>


<div class="container">

    <div class="block-header">

        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>

        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                            
            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                            
            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                            
            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                           
            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
        </ul>
    </div> 
    
    <div class="card">
                <div class="card-body p-b-20">
                    <div class="row">
                        <div class="container">
                          <div class="col-sm-3">
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="zmdi zmdi-email zmdi-hc-fw"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Envío de correos</h2>
                                                <h3 class="ca-sub-planilla">Personaliza tus envíos</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>

                                  <div class="text-center">
                                    @if(isset($id))
                                      @if($sin_confirmar) 
                                        <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20 mousedefault" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="top" title="" type="button" data-trigger="hover"></i> <a class="btn-morado m-r-5 f-15 pointer confirmacion"> Enviar confirmación</a>  
                                      @endif
                                    @endif

                                  </div> 

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>
                                   
                              </div>
                            </div>                
                          </div>      
                        </div>

                        <div class="pm-body clearfix col-sm-9">
                            <div class="timeline">

                                @foreach($correos as $correo)

                                  <div class="t-view" data-tv-type="text">
                                      <div class="tv-header media">
                                          <a href="" class="tvh-user pull-left">
                                              <i class="zmdi zmdi-email zmdi-hc-fw f-30 m-r-5 boton blue sa-warning"></i>
                                          </a>
                                          <div class="media-body p-t-5">
                                              <strong class="d-block f-20">{{$correo['titulo']}}</strong>

                                          </div>
                                      </div>
                                      <div class="tv-body">
                                          {!!$correo['contenido']!!}
                                      
                                          <div class="clearfix"></div>
                                          
                                          <br>

                                          <div class="text-right">
                                              <a href="{{url('/')}}/correo/enviar/{{$correo['id']}}"><span class="f-18 p-t-0 c-morado pointer">Enviar Correo</span></a>
                                          </div>
                                      </div>
                                  </div>
                                @endforeach

                                <div class="t-view" data-tv-type="text">
                                  <div class="tv-header media">
                                      <a href="" class="tvh-user pull-left">
                                          <i class="zmdi zmdi-email f-30 m-r-5 boton blue sa-warning"></i>
                                      </a>
                                      <div class="media-body p-t-5">
                                          <strong class="d-block f-20">Personalizado </strong>

                                      </div>
                                  </div>
                                  <div class="tv-body">
                                      
                                      <br>

                                      <div class="text-right">
                                          <span id="personalizado" class="f-18 p-t-0 c-morado pointer">Enviar Correo</span>
                                      </div>
                                  </div>
                              </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js') 

<script type="text/javascript">


  route_correo="{{url('/')}}/correo/enviar";
  route_personalizado="{{url('/')}}/correo/personalizado";

  var alumnos = <?php echo json_encode($alumnos);?>;  
  var visitantes = <?php echo json_encode($visitantes);?>;  
  var clases_grupales = <?php echo json_encode($clases_grupales);?>;  

  $(document).ready(function(){

    $('#tipo').val(1)
    $('#tipo').selectpicker('refresh')
    rechargeAlumno();

    $('#html-personalizado').summernote({
        height: 150,
        lang: 'es-ES'
    });

    $('#html-personalizado').summernote('code', '');
  });

  $(".correos").on("click", function(){
    $('.fijo').show()
    $('.personalizado').hide()
    $('#correo_id').val($(this).attr('id'))  
    $('#span_correo').text($(this).data('titulo'))  
    $('#modalCorreo').modal('show')           
  }); 

  $("#personalizado").on("click", function(){
    $('.personalizado').show()
    $('.fijo').hide()
    $('#correo_id').val('')  
    $('#span_correo').text('Personalizado')  
    $('#modalCorreo').modal('show')           
  });

  $("#EnviarPersonalizado").on('click', function(){

    procesando();

    var datos = $( "#form_correo" ).serialize();
    var html = $('#html-personalizado').summernote('code');
    html = encodeURIComponent(html);
    var token = $('input:hidden[name=_token]').val();
    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        url: route_personalizado,
        type: 'POST',
        dataType: 'json',
        data: datos+"&msj_html="+html,
        success:function(respuesta){
          setTimeout(function(){ 
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            if(respuesta.status=="OK"){
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nType = 'success';
              var nTitle="Ups! ";
              var nMensaje="Tu correo ha sido enviado exitósamente";

              finprocesado();
              $('.modal').modal('hide');

            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }                       
            finprocesado();
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

  $("#enviar").on('click', function(){

    procesando();
    
    var datos = $( "#form_correo" ).serialize();
    var token = $('input:hidden[name=_token]').val();
    var usuario_id = $('#usuario_id').val();
    var usuarios = '';
    
    if(usuario_id){
      for(var i = 0; i < usuario_id.length; i += 1) {
        usuarios = usuarios + ',' + usuario_id[i];
      }
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        url: route_correo,
        type: 'POST',
        dataType: 'json',
        data: datos+"&usuarios="+usuarios,
        success:function(respuesta){
          setTimeout(function(){ 
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            if(respuesta.status=="OK"){
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nType = 'success';
              var nTitle="Ups! ";
              var nMensaje="Tu correo ha sido enviado exitósamente";

              finprocesado();
              $('.modal').modal('hide');

            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
            }                       
            finprocesado();
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

  @if(isset($id))

    $(".confirmacion").click(function(){
      swal({   
        title: "Desea enviar el correo de confirmación",   
        text: "Confirmar envio!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Enviar!",  
        cancelButtonText: "Cancelar",         
        closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {

            procesando();

            var route = "{{url('/')}}/activar";
            var token = $('input:hidden[name=_token]').val();
          
            $.ajax({
              url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data:"&email={{$usuario->correo}}",
              success:function(respuesta){

                swal("Listo!","Correo enviado exitósamente!","success");
                finprocesado();

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
        }
      });
    });
  @endif

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

  $("#imagen").bind("change", function() {
      
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
      
    $("#tipo").change(function(){

      if($(this).val() == 1){
        rechargeAlumno();
      }else if($(this).val() == 3){
        rechargeVisitante()
      }else{
        rechargeClaseGrupal()
      }
      
    });

  function rechargeAlumno(){

    $('#usuario_id').empty();

    $.each(alumnos, function (index, array) {
      $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+ " " + array.identificacion+'"></option>')
    });

    $('#usuario_id').selectpicker('refresh');
  }

  function rechargeVisitante(){

    $('#usuario_id').empty();

    $.each(visitantes, function (index, array) {
      $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+'"></option>');
    });

    $('#usuario_id').selectpicker('refresh');

  }

  function rechargeClaseGrupal(){

    $('#usuario_id').empty();

    $.each(clases_grupales, function (index, array) {
      $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre +'  -  '+array.dia+'  -  '+array.hora_inicio+' / '+array.hora_final + '  -  ' + array.instructor_nombre + ' ' + array.instructor_apellido+'"></option>');
    });

    $('#usuario_id').selectpicker('refresh');

  }

  $('#modalCorreo').on('hidden.bs.modal', function (e) {
    $('#form_correo')[0].reset()
    $(".selectpicker").selectpicker("refresh");
  })

  </script>
@stop        