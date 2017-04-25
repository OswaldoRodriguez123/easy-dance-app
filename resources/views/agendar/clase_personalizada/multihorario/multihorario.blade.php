@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop
@section('content')



            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/agendar/clases-personalizadas/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                          <div class="text-right">
                            <span class="f-15">Asignadas: <span>{{$clasepersonalizada->horas_asignadas}}</span> Horas</span><br>
                            <span class="f-15">Agendadas: <span id="agendadas">{{$agendadas}}</span> Horas</span><br>
                            <span class="f-15">Por Agendar: <span id="por_agendar">{{$por_agendar}}</span> Horas</span>
                          </div>

                          <br><br><p class="text-center opaco-0-8 f-22" id="id-clase"><i class="icon_a-clase-personalizada p-r-5"></i> Clase: {{$clasepersonalizada->nombre}}</p>
                          <hr class="linea-morada">
                                            
                        </div>
                        <form name="agregar_clase_grupal" id="agregar_clase_grupal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $id }}">

                        <div class="card-body p-b-20">
	                        <div class="col-md-12">
	                        	<div class="form-group fg-line">
                                    <label for="nombre">Multihorarios</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás crear distintos instructores, especialidades, horarios y días de la semana de la clase personalizada" title="" data-original-title="Ayuda"></i>

                                </div>
	                        </div>
	                        <div class="clearfix p-b-35"></div>
	                        <div class="row">

                            <div class="col-sm-2 text-center">
                                <span class="f-16 c-morado">Instructor</span>
                            </div>

                            <div class="col-sm-2 text-center">
                                <span class="f-16 c-morado">Especialidad</span>
                            </div>

                            <div class="col-sm-2 text-center">
                                <span class="f-16 c-morado">Estudio</span>
                            </div>
                                   
                            <div class="col-sm-2 text-center">
                                <!-- <span class="f-16 c-morado">Día de la semana</span> -->
                                <span class="f-16 c-morado">Fecha</span>
                            </div>

                            <div class="col-sm-2 text-center">
                                <span class="f-16 c-morado">Hora Desde</span>
                            </div>

                            <div class="col-sm-2 text-center">
                                <span class="f-16 c-morado">Hora Hasta</span>
                            </div>

                            </div>

	                        <div class="clearfix"></div>

	                        <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-2">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_acordeon_id" id="instructor_acordeon_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              <div class="col-sm-2 text-center">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="especialidad_acordeon_id" id="especialidad_acordeon_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_especialidades as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="estudio_id" id="estudio_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_estudios as $estudio )
                                          <option value = "{{ $estudio['id'] }}">{{ $estudio['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <!-- <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="dia_de_semana_id" id="dia_de_semana_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $dias_de_semana as $dias )
                                          <option value = "{{ $dias['id'] }}">{{ $dias['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div> -->
                                    <div class="dtp-container fg-line">
                                        <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text">
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio_acordeon" id="hora_inicio_acordeon" class="form-control time-picker" placeholder="Desde" type="text">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final_acordeon" id="hora_final_acordeon" class="form-control time-picker" placeholder="Hasta" type="text">
                                          </div>
                                    </div>
                              </div>

                              <div class="clearfix"></div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-instructor_acordeon_id">
                                  <span>
                                       <small id="error-instructor_acordeon_id_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-especialidad_acordeon_id">
                                  <span>
                                       <small id="error-especialidad_acordeon_id_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-estudio_id">
                                  <span>
                                       <small id="error-estudio_id_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <!-- <div class="has-error" id="error-dia_de_semana_id">
                                  <span>
                                       <small id="error-dia_de_semana_id_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div> -->
                                <div class="has-error" id="error-fecha">
                                  <span>
                                       <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-hora_inicio_acordeon">
                                  <span>
                                       <small id="error-hora_inicio_acordeon_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="col-sm-2 text-center">
                                <div class="has-error" id="error-hora_final_acordeon">
                                  <span>
                                       <small id="error-hora_final_acordeon_mensaje" class="help-block error-span" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="clearfix p-b-15"></div>

                              <div class="col-sm-2 text-center">
                                    <div class="cp-container">
                                        <span id="id-color_etiqueta" class="f-16 c-morado">Color de etiqueta</span>

                                        <div class="input-group form-group">

                                        <br>

                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="#de87b4" data-toggle="dropdown">
                                                    
                                                <div class="dropdown-menu">
                                                    <div class="color-picker" data-cp-default="#de87b4"></div>
                                                </div>
                                                
                                                <i class="cp-value"></i>
                                            </div>
                                            <div class="has-error" id="error-color_etiqueta">
                                                <span >
                                                      <small class="help-block error-span" id="error-color_etiqueta_mensaje" ></small>                                           
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <div class="clearfix p-b-15"></div>


                            <div class="card-header text-left">
                                <button type="button" class="btn btn-blanco m-r-10 f-12 guardar" id="add" >Agregar Linea</button>
                            </div>

                            <div class="table-responsive row">
                           		<div class="col-md-12">
		                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
		                            <thead>
		                                <tr>
		                                    <th class="text-center" data-column-id="id" data-type="numeric">Instructor</th>
		                                    <th class="text-center" data-column-id="sexo">Especialidad</th>
                                        <th class="text-center" data-column-id="sexo">Estudio</th>
		                                    <th class="text-center" data-column-id="nombre" data-order="desc">Día</th>
		                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Hora Inicio</th>
		                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Hora Final</th>
                                        <th class="text-center">Cantidad Horas</th>
		                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acción</th>
		                                </tr>
		                            </thead>
		                            <tbody class="text-center">
		                                <!-- foreach(arrayHorario as horario)
                                    
                                    <tr id="$horario['id']}}" class="odd seleccion text-center" role="row">
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['instructor']}}
                                      </td>
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['especialidad']}}
                                      </td>
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['estudio']}}
                                      </td>
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['dia_de_semana']}}
                                      </td>
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['hora_inicio']}}
                                      </td>
                                      <td onclick="previa(this)" class="text-center">
                                        $horario['hora_final']}}
                                      </td>
                                      <td class="text-center" width="50">
                                      <i class="zmdi zmdi-delete f-20 p-r-10"></i>
                                      </td>
                                    </tr>

                                    endforeach         -->                  
		                            </tbody>
		                            </table>
                            	</div>
                            </div>

                            <div class="col-sm-12"> 
                              <!-- <i class="zmdi zmdi-cloud zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Guardar" data-toggle="tooltip" data-placement="bottom" title=""></i> -->

                              <div class="clearfix p-b-35"></div>


                              <div class="text-right">                           
                                <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "guardar" id="guardar" >Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                                <button type="button" class="cancelar btn btn-default" name="cancelar" id="cancelar">Cancelar</button>
                              </div>
                              
                               
                            </div>

                            <div class="clearfix p-b-35"></div>

                        </div>
                        </form>

                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">      

      $.ajaxSetup(
      {
          headers:
          {
              'X-CSRF-Token': $('input[name="_token"]').val()
          }
      });

    	route_horario="{{url('/')}}/agendar/clases-personalizadas/multihorario/agregarhorario";
      route_eliminar="{{url('/')}}/agendar/clases-personalizadas/multihorario/eliminarhorario";
      route_cancelar = "{{url('/')}}/agendar/clases-personalizadas/multihorario/cancelarhorarios";
      route_guardar = "{{url('/')}}/agendar/clases-personalizadas/multihorario/guardarhorarios";

      var agendadas = "{{$agendadas}}"
      var por_agendar = "{{$por_agendar}}"

        var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
        if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
          $('td:eq(5)', nRow).attr( "width","50" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         "Buscar:",
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

		$("#add").click(function(){

                var route = route_horario;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_clase_grupal" ).serialize(); 
                limpiarMensaje();

                $("#add").attr("disabled","disabled");
                $("#add").css({
                  "opacity": ("0.2")
                });

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

                          $("#agregar_clase_grupal")[0].reset();
                          $('#instructor_acordeon_id').selectpicker('refresh');
                          $('#especialidad_acordeon_id').selectpicker('refresh');
                          $('#estudio_id').selectpicker('refresh');
                          $('#dia_de_semana_id').selectpicker('refresh');
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          var instructor_id = respuesta.array.instructor;
                          var especialidad_id = respuesta.array.especialidad;
                          var estudio = respuesta.array.estudio;
                          var dia_de_semana_id = respuesta.array.dia_de_semana;
                          var hora_inicio = respuesta.array.hora_inicio;
                          var hora_final = respuesta.array.hora_final;
                          var hora_asignada = respuesta.array.hora_asignada;

                          por_agendar = parseInt(por_agendar - hora_asignada)
                          agendadas = parseInt(agendadas) + parseInt(hora_asignada)

                          $('#agendadas').text(agendadas)
                          $('#por_agendar').text(por_agendar)


                          var rowId=respuesta.array.id;
                          var rowNode=t.row.add( [
                          ''+instructor_id+'',
                          ''+especialidad_id+'',
                          ''+estudio+'',
                          ''+dia_de_semana_id+'',
                          ''+hora_inicio+'',
                          ''+hora_final+'',
                          ''+hora_asignada+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion text-center');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#add").removeAttr("disabled");
                        $("#add").css({
                          "opacity": ("1")
                        });
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
                        $("#add").removeAttr("disabled");
                        $("#add").css({
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

  $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
        var padre=$(this).parents('tr');
        var token = $('input:hidden[name=_token]').val();
        var id = $(this).closest('tr').attr('id');
        var datos = $( "#agregar_clase_grupal" ).serialize();
        
              $.ajax({
                   url: route_eliminar+"/"+id,
                   headers: {'X-CSRF-TOKEN': token},
                   type: 'POST',
                   dataType: 'json', 
                   data:datos,               
                  success: function (data) {
                    if(data.status=='OK'){
                        
                      var hora_asignada = data.hora_asignada;
                      por_agendar = parseInt(por_agendar + hora_asignada)
                      agendadas = parseInt(agendadas) - parseInt(hora_asignada)

                      $('#agendadas').text(agendadas)
                      $('#por_agendar').text(por_agendar)
                                         
                    }else{
                      swal(
                        'Solicitud no procesada',
                        'Ha ocurrido un error, intente nuevamente por favor',
                        'error'
                      );
                    }
                  },
                  error:function (xhr, ajaxOptions, thrownError){
                    swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                  }
                })

                t.row( $(this).parents('tr') )
                  .remove()
                  .draw();
            });

      function limpiarMensaje(){
      var campo = ["instructor_acordeon_id", "especialidad_acordeon_id", "estudio_id", "hora_final_acordeon", "hora_inicio_acordeon", "dia_de_semana_id"];
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
          //scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1500);          

  }

  $( "#cancelar" ).click(function() {

    var token = $('input:hidden[name=_token]').val();

    $.ajax({
         url: route_cancelar,
         headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',                
        success: function (data) {
          if(data.status=='OK'){

            $("#agregar_clase_grupal")[0].reset();
            $('#instructor_acordeon_id').selectpicker('refresh');
            $('#especialidad_acordeon_id').selectpicker('refresh');
            $('#estudio_id').selectpicker('refresh');
            $('#dia_de_semana_id').selectpicker('refresh');

             t
              .clear()
              .draw();
                               
          }else{
            swal(
              'Solicitud no procesada',
              'Ha ocurrido un error, intente nuevamente por favor',
              'error'
            );
          }
        },
        error:function (xhr, ajaxOptions, thrownError){
          swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
        }
      })

        $('html,body').animate({
        scrollTop: $("#id-clase").offset().top-90,
        }, 1000);
      });

  $("#guardar").click(function(){

      var route = route_guardar;
      var token = $('input:hidden[name=_token]').val();
      limpiarMensaje();
      procesando();
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data: "&id={{$id}}",
          success:function(respuesta){
            setTimeout(function(){ 
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              if(respuesta.status=="OK"){
                window.location = "{{$url}}";
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
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
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nType = 'danger';
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY";  
              finprocesado();                     
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
            }, 1000);
          }
      });

    });

    </script>

@stop