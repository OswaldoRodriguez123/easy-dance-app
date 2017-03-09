@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_inscripcion" id="agregar_inscripcion">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="clase_personalizada_id" value="{{ $id }}">
                            <div class="row p-l-10 p-r-10">
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="alumno" class="c-morado f-22">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual deseas asignar a la clase personalizada" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <!-- <select class="selectpicker" name="alumno_id" id="alumno_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $alumnos as $alumno )
                                          <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                          @endforeach
                                        </select>
 -->
                                        <!-- <select class="selectpicker bs-select-hidden" id="alumno_id" name="alumno_id" multiple="" data-max-options="5" title="Selecciona"> -->

                                        <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona" data-live-search="true">

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
                                    
                                      <label for="fecha" id="id-fecha_inicio">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el día de la clase personalizada" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_inicio" id="fecha_inicio" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text"
                                                  @if (session('fecha_inicio'))
                                                    value="{{session('fecha_inicio')}} - {{session('fecha_inicio')}}"
                                                  @endif
                                              >
                                          </div>

                                    <div class="has-error" id="error-fecha_inicio">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_inicio_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                  </div>
                                </div>
    
                               <div class="clearfix p-b-35"></div>

                                <div class="col-xs-6">
                                 
                                      <label for="fecha_inicio" id="id-hora_inicio">Horario</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la hora de inicio y final de la clase personalizada" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group col-xs-12">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio" id="hora_inicio" class="form-control time-picker" placeholder="Desde" type="text">
                                    </div>
                                 <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                      </div>
                                  </div>
                               </div>

                               <div class="col-xs-6">
                                      <label for="fecha_inicio" id="id-hora_final">&nbsp;</label>
                                      <div class="input-group col-xs-12">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final" id="hora_final" class="form-control time-picker" placeholder="Hasta" type="text">
                                          </div>
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                               </div>

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="fecha_cobro" id="id-especialidad_id">Especialidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de diversas especialidades" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="especialidad_id" id="especialidad_id" data-live-search="true" onchange="porcentaje" >

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_especialidades as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-especialidad_id">
                                      <span >
                                        <small class="help-block error-span" id="error-especialidad_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-instructor_id">Instructor</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-instructor" id = "pop-instructor" aria-describedby="popoverinstructor" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un instructor, en caso de no poseerlo o deseas crear un nuevo registro, dirígete a la sección de instructores y procede a registrarlo. Desde esta sección podemos redireccionarte" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{$instructor['id'] }}">{{$instructor['nombre'] }} {{$instructor['apellido'] }}</option>
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
                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-estudio_id">Sala / Estudio</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-salon" id = "pop-salon" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la sala o estudio de tu academia, en caso de no haberla asignado o deseas crear un nuevo registro, dirígete a la sección de sala o estudio e ingresa la información en el área de configuración general. Desde esta sección podemos redireccionarte" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-estudio-salon f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" id="estudio_id" name="estudio_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_estudios as $estudios )
                                          <option value = "{{ $estudios['id'] }}">{{ $estudios['nombre'] }}</option>
                                          @endforeach

                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-estudio_id">
                                      <span >
                                        <small class="help-block error-span" id="error-estudio_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
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
                            <div class="col-sm-12 text-right">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar" name="guardar">  Agregar </a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 agregar" id="agregar" name="agregar">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div>
                      </div></form>
                    </div>
                </div>
            </div>

             <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Cancelar una clase <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_clase" id="cancelar_clase"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="clasepersonalizada_id" id="clasepersonalizada_id" value=""></input>  
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="p-l-10 f-16 f-700 span_instructor">  </span>

                                                  
                                           </div>

                                           <div class="col-sm-9">
                                             
                                            <p class="f-16"> <span class="f-700 span_hora"></span></p>

                                            <p class="f-16"> <span class="f-700 span_fecha"></span></p> 

                                            <p class="f-16"> <span class="f-700 span_especialidad"></span></p>

                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>

                                       <div class="row p-t-20 p-b-0">

                                       <hr style="margin-top:5px">

                                       <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelar la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_clase" id="cancelar_clase" name="cancelar_clase" > Completar la cancelación</button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

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
                            <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Participante <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada p-r-5"></i> Clase: {{$clasepersonalizada->nombre}}</p>
                            <hr class="linea-morada">

                            </div>

                            <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="activas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="canceladas" value="canceladas" type="radio">
                                        <i class="input-helper"></i>  
                                        Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>

                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Balance E</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                                           
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

        route_agregar="{{url('/')}}/agendar/clases-personalizadas/inscribir";
        route_enhorabuena="{{url('/')}}/agendar/clases-personalizadas/enhorabuena/";
        route_cancelar="{{url('/')}}/agendar/clases-personalizadas/cancelar/";
        route_cancelarpermitir="{{url('/')}}/agendar/clases-personalizadas/cancelarpermitir/";
        route_principal="{{url('/')}}/agendar/clases-personalizadas";

        $(document).ready(function(){

        $("#activas").prop('checked',true);

        // $('#alumno_id > option[value="{{ Session::get('id_alumno') }}"]').attr('selected', 'selected');

        // id_alumno = "{{Session::get('id_alumno')}}";
        
        // if(id_alumno){

        //   setTimeout(function(){ 
        //       $('#modalAgregar').modal('show');
        //     }, 2000);
        // }

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,  
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
        /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }*/
        },
        pageLength: 25,
        paging: false,
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                rechargeActivas();
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

        $("#agregar").click(function(){


                procesando();
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_inscripcion" ).serialize(); 
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
                          if(respuesta.array){

                            var nType = 'success';
                            // $("#agregar_inscripcion")[0].reset();
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;

                            $("#modalAgregar").modal("hide");

                            $.each(respuesta.array, function (index, array) {

                              var identificacion = array.identificacion;
                              
                              if(array.sexo=='F')
                              {
                                sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                              }
                              else
                              {
                                sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i> </span>'
                              }
                             
                              var nombre = array.nombre;
                              var apellido = array.apellido;

                              var rowId=array.id;
                              var rowNode=t.row.add( [
                              ''+identificacion+'',
                              ''+sexo+'',
                              ''+nombre+ ' ' +apellido+'',
                              '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal c-verde"></i></label>',
                              '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-money f-20 p-r-3 operacionModal c-verde"></i></label>',
                              '<i data-toggle="modal" class="zmdi zmdi-delete eliminar f-20 p-r-10"></i>'
                              ] ).draw(false).node();
                              $( rowNode )
                              .attr('id',rowId)
                              .addClass('seleccion');

                              });
                            }
                            else{

                              window.location = route_enhorabuena + respuesta.id;

                            }

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        // finprocesado();
                        $("#guardar").removeAttr("disabled");
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

        function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                  tipo = 'activas';
                  rechargeActivas();
            } else  {
                  tipo= 'canceladas';
                  rechargeCanceladas();
            }
         });


       $("#activas").click(function(){
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#canceladas").click(function(){
            $( "#activas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).addClass( "c-verde" );
        });


        function rechargeActivas(){
            var activas = <?php echo json_encode($activas);?>;

            $.each(activas, function (index, array) {

              if(array.sexo=='F')
              {
                sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
              }
              else
              {
                sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i> </span>'
              }
              
                var rowNode=t.row.add( [

                ''+array.identificacion+'',
                ''+sexo+'',
                ''+array.nombre+ ' '+array.apellido+'',
                '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal c-verde"></i></label>',
                '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-money f-20 p-r-3 operacionModal c-verde"></i></label>',
                '<i data-toggle="modal" name="operacion" class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer acciones c-youtube"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.clase_personalizada_id)
                    .addClass('seleccion');
            });
        }

        function rechargeCanceladas(){
            var canceladas = <?php echo json_encode($canceladas);?>;

            $.each(canceladas, function (index, array) {

              if(array.sexo=='F')
              {
                sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
              }
              else
              {
                sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i> </span>'
              }

                var rowNode=t.row.add( [
                ''+array.identificacion+'',
                ''+sexo+'',
                ''+array.nombre+ ' '+array.apellido+'',
                '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-label-alt-outline f-20 p-r-3 operacionModal c-verde"></i></label>',
                '<label class="label estatusc-verde f-16"><i data-toggle="modal" href="#" class="zmdi zmdi-money f-20 p-r-3 operacionModal c-verde"></i></label>',
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.clase_personalizada_id)
                    .addClass('seleccion');
            });
        }

        $('#tablelistar tbody').on( 'click', 'i.zmdi-close-circle-o', function () {

          var id = $(this).closest('tr').attr('id');
          $('#clasepersonalizada_id').val(id);

          $('#modalCancelar').modal('show');

          
        
        });


    function limpiarMensaje(){
        var campo = ["alumno_id", "fecha_inicio", "hora_inicio", "hora_final", "especialidad_id", "instructor_id", "estudio_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["alumno_id", "fecha_inicio", "hora_inicio", "hora_final", "especialidad_id", "instructor_id", "estudio_id"];
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

             $('#pop-instructor').popover({
                    html: true,
                    trigger: 'manual'
                }).click(function(e) {

                  if($('.popover').hasClass('in')){
                     $(this).popover('hide');
                  } else {
                    $(this).popover('show');
                    $('.popover-content').append('<br> <a class="redirect pointer"> Llévame <i class="icon_a-instructor f-22"></i></a>');
                  }
            
                    $('.redirect').click(function(e){
                        window.location = "{{url('/')}}/participante/instructor/agregar";
                    });
                    e.preventDefault();
          });

          $('#pop-salon').popover({
                    html: true,
                    trigger: 'manual'
                }).click(function(e) {

                  if($('.popover').hasClass('in')){
                     $(this).popover('hide');
                  } else {
                    $(this).popover('show');
                    $('.popover-content').append('<br> <a class="redirect pointer"> Llévame <i class="icon_a-estudio-salon f-22"></i></a>');
                  }
            
                    $('.redirect').click(function(e){
                        window.location = "{{url('/')}}/configuracion/academia";
                    });
                    e.preventDefault();
          });

          $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

        $(".cancelar_clase").click(function(){

        id = $("#clasepersonalizada_id").val();
    
         swal({   
                    title: "Desea cancelar la clase personalizada",   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar + id;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_clase" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        window.location=route_principal; 

                    },
                    error:function(msj){
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    $(".modal").modal('hide');
                    finprocesado();
                    swal({ 
                    title: 'El estatus de esta clase es de "cancelación tardía", al cancelarla de igual manera será debitada económicamente al participante. ¿ Desea proceder ?',   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true,
                    html: true
                }, function(isConfirm){   
                  if (isConfirm) {
                    procesando();
                    var route = route_cancelarpermitir + id;

                    $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        window.location=route_principal; 

                    },
                    error:function(msj){

                            if (typeof msj.responseJSON === "undefined") {
                                window.location = "{{url('/')}}/error";
                             }


    
                            }
                        });
                    }
                });
             }
         });
        }
      });
    });


 

    </script>

@stop