@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>
@stop
@section('content')

<div class="modal fade" id="modalCorreo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Editor <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <form name="correo_personalizado" id="correo_personalizado"  >

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="col-sm-12">
                      <div class="form-group fg-line ">
                        <label for="tipo p-t-10" id="id-tipo">Tipo de envio</label> <span class="c-morado f-700 f-16">*</span>
                        <br><br>
                        <label class="radio radio-inline m-r-20" style="margin-top:0px">
                            <input name="tipo" id="todos" value="1" type="radio" checked>
                            <i class="input-helper"></i>  
                            Todos los visitantes 
                        </label>
                        <label class="radio radio-inline m-r-20 ">
                            <input name="tipo" id="particular" value="2" type="radio">
                            <i class="input-helper"></i>  
                            Particular
                        </label>
                        
                      </div>
                     <div class="has-error" id="error-tipo">
                          <span >
                              <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                           
                          </span>
                      </div>
                   </div>

                  <div class="clearfix p-b-35"></div>

                  <div class="col-sm-12 interesados" style="display: none"> 
                    <label for="nombre" id="id-visitante_id">Visitante</label> <span class="c-morado f-700 f-16">*</span>
                    <br><br>
                      <div class="fg-line">
                      <div class="select">
                        <select class="selectpicker" name="visitante_id" id="visitante_id" data-live-search="true">

                          <option value="">Selecciona</option>
                          @foreach ( $visitantes as $visitante )
                          <option value = "{{ $visitante['id'] }}">{{ $visitante['nombre'] }} {{ $visitante['apellido'] }} - {{ $visitante['correo'] }}</option>
                          @endforeach
                        
                        </select>
                      </div>
                    </div>
                 <div class="has-error" id="error-visitante_id">
                      <span >
                          <small class="help-block error-span" id="error-visitante_id_mensaje" ></small>                                
                      </span>
                  </div>
                  <div class="clearfix p-b-35"></div>
               </div>



                              <div class="col-sm-12">
                                  <label for="id" id="id-url">Ingresa url de la imagen</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                                  <br><br>
                                  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="url" id="url" placeholder="Ingresa la url">
                                    </div>
                                   
                                   <div class="has-error" id="error-url">
                                    <span >
                                     <small id="error-url_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
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

                              <div class="clearfix p-b-35"></div>


         

                        </form>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>                        
                        <div class="col-md-12">
                        <label for="id" id="id-msj_html">Mensaje</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>

                                  <br><br>
                            <div id="html-personalizado"></div>
                        </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>

                         <div class="modal-footer">
                            <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="EnviarPersonalizado" >Enviar</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>


                        </div>
                       
                    </div>
                </div>
            </div>

<a href="{{url('/')}}/participante/visitante/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header ">

                            <div class="text-left">
                                <a data-toggle="modal" id="modalPe" href="#modalCorreo" class="f-16 p-t-0 text-success">Enviar Correo</a>
                            </div>

                            <div class="text-right">
                                <span class="f-16 p-t-0 text-success">Agregar un Visitante <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-visitante-presencial f-25"></i> Sección de Visitantes</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" name="tablelistar">
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="cliente"></th>
                                    <th class="text-center" data-column-id="fecha">Fecha de Registro</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="como_se_entero" data-order="desc">Cómo se Enteró</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Promotor</th>
                                    <th class="text-center" data-column-id="operaciones">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($visitantes as $visitante)
                                <?php 
                                  $id = $visitante['id']; 

                                  if($visitante['sexo'] == 'F'){
                                      $imagen = '/assets/img/Mujer.jpg';
                                  }else{
                                      $imagen = '/assets/img/Hombre.jpg';
                                  }

                                  $contenido = '';

                                  $contenido = '<p class="c-negro">' .

                                  $visitante['nombre'] . ' ' . $visitante['apellido']. ' <img class="lv-img-sm" src="'.$imagen.'" alt=""><br><br>' .

                                  'Número Móvil: ' . $visitante['celular'] . '<br>'.
                                  'Correo Electrónico: ' . $visitante['correo'] . '<br>'.
                                  'Especialidad de Interés: ' . $visitante['especialidad'] . '<br>'.



                                  '</p>';


                                ?>

                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> @if($visitante['cliente'])<i class="icon_a-estatus-de-clases c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">{{$visitante['fecha_registro']}}</td>
                                    <td class="text-center previa">
                                    @if($visitante['sexo']=='F')
                                    <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                    @else
                                    <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                    @endif
                                    </td>

                                    <?php $tmp = explode(" ", $visitante['nombre']);
                                    $nombre_visitante = $tmp[0];

                                    $tmp = explode(" ", $visitante['apellido']);
                                    $apellido_visitante= $tmp[0];

                                    ?>

                                    <td class="text-center previa">{{$nombre_visitante}} {{$apellido_visitante}} </td>
                                    <td class="text-center previa">{{$visitante['como_se_entero']}}</td>
                                    <td class="text-center previa">{{$visitante['instructor_nombre']}} {{$visitante['instructor_apellido']}}</td>

                                    <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i></td>
                                    
                                </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                
                              </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

        route_detalle="{{url('/')}}/participante/visitante/detalle";
        route_operacion="{{url('/')}}/participante/visitante/operaciones";
        route_personalizado="{{url('/')}}/participante/visitante/enviar-correo-personalizado";
            
        $(document).ready(function(){

          $("#correo_personalizado")[0].reset();

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[1, 'desc']],
        fnDrawCallback: function() {
        if ("{{count($visitantes)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                        searchPlaceholder: "BUSCAR",
                        lengthMenu:     "Mostrar _MENU_ Registros",
                        info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
                        infoFiltered:   "(filtrada de _MAX_ registros en total)",
                        infoPostFix:    "",
                        loadingRecords: "...",
                        zeroRecords:    "No se encontraron registros coincidentes",
                        emptyTable:     "No hay datos disponibles en la tabla",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        },
                        aria: {
                            sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
                            sortDescending: ": habilitado para ordenar la columna en orden descendente"
                        }
                    }
        });
    
      });


    function previa(t){
        var row = $(t).closest('tr').attr('id');
        var id_visitante = row.split('_');
        var route =route_detalle+"/"+id_visitante[1];
        window.location=route;
      }

      $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
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

      $("#modalPe").on("click", function(){
                $('#html-personalizado').summernote({
                        height: 150,
                        toolbar: [
                          // [groupName, [list of button]]
                          ['style', ['bold', 'italic', 'underline']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['link', ['link']],
                        ],
                        lang: 'es-ES'

                    });
                $('#html-personalizado').summernote('code', '');                
            });

      $("#EnviarPersonalizado").on('click', function(){

                procesando();

                limpiarMensaje();

                var datos = $( "#correo_personalizado" ).serialize();
                var html = $('#html-personalizado').summernote('code');
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
                      $('#modalCorreo').modal('hide');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        finprocesado();
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
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nType = 'danger';
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY";                       
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);          
                        }else if(msj.responseJSON.status=="ERROR-CORREO"){
                          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }                        
                        finprocesado();
                      }, 1000);
                    }
                });
                        
            });

      $('input[name=tipo]').change(function() {
        val = $(this).val();

        if(val == 1)
        {
          $(".interesados").hide();
        }else{
          $(".interesados").show();
        }
    });

      function limpiarMensaje(){
        var campo = ["visitante_id", "tipo", "url", "imagen", "titulo"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
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