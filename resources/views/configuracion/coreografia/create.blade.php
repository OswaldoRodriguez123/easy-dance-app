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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/coreografias" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Coreografía</a>
                        
                    </div> 
                    
                      <div class="card">
                        <div class="card-header text-center">
                            <span class="f-30 c-morado"><i class="icon_d-coreografia f-25" id="id-clase_grupal_id"></i> Crea tu coreografía </span>     
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_coreografia" id="agregar_coreografia"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                                <div class="col-sm-12">

                                <span class="f-30 text-center c-morado">Fundamentos generales</span>
                                    
                                <hr></hr>

                                <div class="clearfix p-b-15"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-fiesta_id">Nombre del evento</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre del evento, en el que desarrollarás la coreografía" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class=" icon_a-fiesta f-22"></i></span>
                                      <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" name="fiesta_id" id="fiesta_id" data-live-search="true">

                                            <option value="0">Sin Especificar</option>
                                            @foreach ( $fiestas as $fiesta )
                                            <option value = "{{ $fiesta->id }}">{{ $fiesta->nombre }}</option>
                                            @endforeach
                                          
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-fiesta_id">
                                      <span >
                                          <small class="help-block error-span" id="error-fiesta_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre_coreografia">Nombre de la coreografía</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre para identificar  la propuesta coreográfica" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class=" icon_d-coreografia f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="nombre_coreografia" id="nombre_coreografia" placeholder="Ej. Coreografía">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_coreografia">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_coreografia_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-tipo">Tipo de coreografía</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de coreografía" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                      <div class="fg-line">
                                        <div class="select">
                                          <select class="selectpicker" name="tipo" id="tipo" data-live-search="true">

                                            <option value="">Selecciona</option>
                                            @foreach ( $config_coreografias as $tipo )
                                              <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                          
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
                                <label for="apellido" id="id-imagen">Cargar Imagen</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Soporta formatos en: JPEG, JPG y PNG. El tamaño de la imagen debe menor o igual a 1 MB. NOTA: Logos grandes o mayor de 230 x 120 se reducirán" title="" data-original-title="Ayuda"></i>
                                
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
                                 
                                <span class="f-30 text-center c-morado">Fundamentos Coreográficos</span>
                                
                                <hr>

                                <div class="clearfix p-b-35"></div>
                                  
                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Concepto o descripción coreográfica</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Presenta el concepto coreográfico que deseas realizar , indicándole  a tus alumnos o grupo lo que deseas manifestar a través de la propuesta , informándoles si es o no temático , tipo de vestimenta , lo que deseas expresar al público entre otros detalles , de la coreografía y sus beneficios  , de esa forma motivarás a tus alumnos" title="" data-original-title="Ayuda"></i>

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
                                  <label for="id" id="id-link_video">Ingresa el link del video promocional</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa el link">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-link_video">
                                    <span >
                                     <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                                <div class="clearfix p-b-35"></div>  

                                 <div class="col-sm-12">
                                    <label for="apellido" id="id-imagen_presentacion">Imagen horizontal</label></label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="clearfix p-b-15"></div>
                                      
                                    <input type="hidden" name="imagePresentacionBase64" id="imagePresentacionBase64">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_presentacion" id="imagen_presentacion" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                      <div class="has-error" id="error-imagen_presentacion">
                                      <span >
                                          <small class="help-block error-span" id="error-imagen_presentacion_mensaje"  ></small>
                                      </span>
                                  </div>
                                </div>

                              <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                   <label for="especialidad_id" id="id-especialidad_id">Estilos de baile que se implementará</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona los estilos de baile que se utilizaran, en caso de no poseerlo, dirígete a la sección de especialidades y procede a registrarlo" title="" data-original-title="Ayuda"></i>

                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                  <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker bs-select-hidden" id="especialidad_id" name="especialidad_id" multiple="" data-max-options="5" title="Selecciona">

                                        <option value="">Selecciona</option>
                                        @foreach ( $especialidades as $especialidad )
                                        <option value = "{{$especialidad->nombre}}">{{$especialidad->nombre}}</option>
                                        @endforeach
                                      
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                  <div class="has-error" id="error-especialidad_id">
                                    <span >
                                      <small class="help-block error-span" id="error-especialidad_id_mensaje" ></small>                                           
                                    </span>
                                </div>
                            </div>

                            <div class="clearfix p-b-35"></div>


                            <div class="col-sm-12">
                           
                              <label for="nombre" id="id-tema_musical">Tema musical principal</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del tema musical que utilizara la propuesta coreográfica" title="" data-original-title="Ayuda"></i>

                              <div class="input-group">
                                <span class="input-group-addon"><i class=" icon_d-coreografia f-22"></i></span>
                                <div class="fg-line">
                                  <input type="text" class="form-control input-sm input-mask" name="tema_musical" id="tema_musical" placeholder="Ej. Coreografía">
                                </div>
                              </div>
                           <div class="has-error" id="error-tema_musical">
                                <span >
                                    <small class="help-block error-span" id="error-tema_musical_mensaje" ></small>                                
                                </span>
                            </div>
                         </div>

                         <div class="clearfix p-b-35"></div>


                                  <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-instructor_id"> Coreógrafo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre del coreógrafo o instructor que dirigirá la coreografía" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor->id }}">{{ $instructor->nombre }} {{ $instructor->apellido }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-instructor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-xs-12">
                                 
                                      <label for="tiempo_duracion" id="id-tiempo_duracion">Tiempo aproximado de la coreografía</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el tiempo de duración aproximado o exacto de la coreografía" title="" data-original-title="Ayuda"></i>

                                        <div class="form-group">
                                        
                                          <div class="col-sm-5">
                                            <label>La coreografía tiene una duración aproximada de  </label>
                                          </div>

                                          <div class="col-sm-1">
                                            <input type="text" class="form-control input-sm input-mask" name="tiempo_duracion" id="tiempo_duracion" data-mask="0000" placeholder="Ej. 10">
                                          </div>

                                          <div class="col-sm-2">
                                            <label>minutos</label>
                                          </div>

                                        </div>

                                 <div class="has-error" id="error-tiempo_duracion">
                                      <span >
                                          <small class="help-block error-span" id="error-tiempo_duracion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>



                                <div class="col-sm-12">
                                  <div class="form-group fg-line ">
                                    <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar la clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                    
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

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

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

  route_agregar="{{url('/')}}/configuracion/coreografias/agregar";
  route_principal="{{url('/')}}/configuracion/coreografias";
  
  $(document).ready(function(){

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

    $("#imagen_presentacion").bind("change", function() {
        
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
        var image64 = $("input:hidden[name=imagePresentacionBase64]").val(newimage);
        
      },500);

    });

    $("#boolean_promocionar").val('1');  //VALOR POR DEFECTO
    $("#promocionar").attr("checked", true); //VALOR POR DEFECTO

    $("#promocionar").on('change', function(){
      if ($("#promocionar").is(":checked")){
        $("#boolean_promocionar").val('1');
      }else{
        $("#boolean_promocionar").val('0');
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
  }); 

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["fiesta_id", "nombre_coreografia", "imagen", "tipo", "descripcion", "link_video", "imagen_presentacion", "tema_musical", "instructor_id", "tiempo_duracion"];
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
          var datos = $( "#agregar_coreografia" ).serialize(); 

          var especialidad = [];
          $('#especialidad_id option:selected').each(function() {
            especialidad.push( $( this ).val() );
          });
          procesando();       
          limpiarMensaje();
          $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data:datos + "&especialidad="+especialidad,
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
                    $("#agregar_coreografia")[0].reset();
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
        var campo = ["fiesta_id", "nombre_coreografia", "imagen", "tipo", "descripcion", "link_video", "imagen_presentacion", "tema_musical", "instructor_id", "tiempo_duracion"];
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
    $("#agregar_coreografia")[0].reset();
    $('#especialidad_id').selectpicker('render');
    $('#tipo').selectpicker('render');
    $('#fiesta_id').selectpicker('render');
    $('#instructor_id').selectpicker('render');
    limpiarMensaje();
    $('html,body').animate({
    scrollTop: $("#id-fiesta_id").offset().top-90,
    }, 1500);
  });

</script> 
@stop

