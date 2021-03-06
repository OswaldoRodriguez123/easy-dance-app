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

<div class="modal fade" id="modalCosto-Taller" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Taller<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_taller" id="edit_costo_taller"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo</label>
                                    <input type="text" class="form-control input-sm" name="costo" id="costo" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$taller->id}}"></input>
                              

                               <div class="clearfix"></div> 

                               
                               
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
                            <div class="col-sm-12">                            

                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar_costo" name="guardar_costo">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

          

            <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_inscripcion" id="agregar_inscripcion">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="taller_id" value="{{ $id }}">
                            <div class="row p-l-10 p-r-10">
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                                <div class="col-sm-12">
                                 
                                     <label for="alumno" class="c-morado f-22">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante al cual deseas asignar a la clase grupal" title="" data-original-title="Ayuda"></i>

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
                                          <?php $exist = false; ?>
                                          @foreach ( $alumnos_inscritos as $inscripcion)
                                            @if ($inscripcion['id']==$alumno['id'])
                                              <?php $exist = true; ?>
                                            @endif
                                          @endforeach
                                          @if ($exist)
                                              <option disabled title="Ya esta en el taller" data-content="<span title='Este alumno ya se encuentra en el taller'><i class='glyphicon glyphicon-remove'></i> {{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</span>" value = "{{ $alumno['id'] }}"></option>
                                          @else
                                              <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                          @endif
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
                               <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">

                               <span class="f-22 c-morado"> Datos Administrativos del Taller </span>

                               <hr>

                               </div>

                               <br>

                               <div class="col-sm-12">
                                 
                                <table class="table table-striped table-bordered">
                                   <tr class="detalle" data-toggle="modal" href="#modalCosto-Taller">
                                     <td>
                                        <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo" class="zmdi  {{ empty($taller->costo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                       <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                                       <span class="f-14"> Costo</span>
                                     </td>
                                     <td class="f-14 m-l-15" ><span id="taller-costo"><span>{{$taller->costo}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                                    </tr>
                                    </table>
                                 
                               </div>

                               <div class="col-sm-12 p-20" id="textarea_observacion" style="display:none">

                                    <div class="clearfix p-b-10"></div>
                                   
                                    <label for="observacion_cambio_costo" id="id-observacion_cambio_costo">Explique las razones por las que el costo fue cambiado</label>
                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="observacion_cambio_costo" name="observacion_cambio_costo" rows="2"></textarea>
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
                            <div class="col-sm-12 text-right">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar" name="guardar">  Agregar </a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 agregar" id="agregar" name="agregar">Guardar<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                            </div>
                        </div>
                      </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/talleres/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a> -->

                        <?php $url = "/agendar/talleres/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                          <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                              <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                              
                              <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                              
                              <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                              
                              <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                             
                              <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                              
                          </ul>

                        @endif
                    </div>

                    <div class="card">
                        <div class="card-header">

                            <div class="text-right">
                              <a class="f-16 p-t-0 text-right text-success" data-toggle="modal" href="#modalAgregar">Agregar Nuevo Participante <i class="zmdi zmdi-account-add zmdi-hc-fw f-20 c-verde"></i></a>
                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-talleres p-r-5"></i> Taller: {{$taller->nombre}}</p>
                            <hr class="linea-morada">

                            <div class="col-sm-6 text-left">
                              <div class="p-t-10"> 
                                <i class="zmdi zmdi-female f-25 c-rosado"></i> <span class="f-15" id="span_mujeres" style="padding-left:5px"> {{$mujeres}}</span>
                                <i class="zmdi zmdi-male-alt p-l-5 f-25 c-azul"></i> <span class="f-15" id="span_hombres" style="padding-left:5px"> {{$hombres}} </span>
                              </div>
                            </div>

                            <div class="clearfix"></div>        

                            <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="todos" value="T" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Todos <i id="todos2" name="todos2" class="zmdi zmdi-male-female zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="mujeres" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujeres <i id="mujeres2" name="mujeres2" class="zmdi zmdi-female zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="hombres" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombres <i id="hombres2" name="hombres2" class="zmdi zmdi-male-alt zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                </div>
                              </div>                                               
                          </div>

                          <div class="clearfix p-b-35"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="iconos"></th>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Balance E</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos_inscritos as $alumno)
                              <?php $id = $alumno['inscripcion_id']; ?>
                              @if($alumno['tipo'] == 1)
                                <tr data-tipo ="{{$alumno['tipo']}}" id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> 
                                      <span style="display: none">1</span>
                                      @if($alumno['activacion']) 
                                        <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>

                                      @endif
                                    </td>
                                    <td class="text-center previa">
                                      @if($alumno['imagen'])
                                        <img class="lv-img" src="{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                      @else
                                          @if($alumno['sexo'] == 'M')
                                            <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                          @else
                                            <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                          @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['identificacion']}}</td>
                                    <td class="text-center previa">
                                    @if($alumno['edad'] >= 18)
                                        @if($alumno['sexo']=='F')
                                            <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                        @else
                                            <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                        @endif
                                    @else
                                        @if($alumno['sexo']=='F')
                                            <span style="display: none">F</span><i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                        @else
                                            <span style="display: none">M</span><i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                        @endif
                                    @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}} </td>
                                    <td class="text-center previa">
                                      <span style="display: none">{{$alumno['deuda']}}</span><i class="zmdi zmdi-money {{ $alumno['deuda'] ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3"></i>
                                    </td>
                                    <td class="text-center">
                                      <i class="zmdi zmdi-delete boton red eliminar f-20 p-r-10"></i>
                                    </td>
                                </tr>
                                @else
                                  <tr data-tipo ="{{$alumno['tipo']}}" data-sexo="{{$alumno['sexo']}}" id="{{$alumno['inscripcion_id']}}" class="seleccion seleccion_deleted">
                                      <td class="text-center previa"><span style="display: none">2</span><span class="c-amarillo"><b>R</b></span></td>
                                      <td class="text-center previa">

                                        @if($alumno['sexo'] == 'M')
                                          <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                        @else
                                          <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                        @endif

                                      </td>
                                      <td class="text-center previa"> 
                                        @if(isset($alumno['tiempo_vencimiento']))
                                          {{$alumno['tiempo_vencimiento']}}
                                        @endif
                                      </td>
                                      <td class="text-center previa">
                                      @if($alumno['sexo']=='F')
                                        <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                      @else
                                        <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                      @endif
                                      </td>
                                      <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}} </td>
                                      <td class="text-center previa">
                                        <i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>
                                      </td>
                                      <td class="text-center">
                                        <ul class="top-menu">
                                          <li class="dropdown" id="dropdown_{{$id}}">
                                              <a id="dropdown_toggle_{{$id}}" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                                 <span class="f-15 f-700" style="color:black"> 
                                                      <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                 </span>
                                              </a>

                                                <div class="dropup" dropdown-append-to-body>
                                                  <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">
                                                      <li class="hidden-xs pointer">
                                                          <a class="inscribir"><i class="zmdi zmdi-plus f-20"></i> Inscribir</a>
                                                      </li>


                                                      <li class="hidden-xs pointer">
                                                          <a class="eliminar"><i class="zmdi zmdi-delete boton red f-20"></i> Eliminar</a>
                                                      </li>

                                                  </ul>
                                              </div>
                                          </li>
                                        </ul>
                                      </td>
                                  </tr>
                                @endif
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

        route_agregar="{{url('/')}}/agendar/talleres/inscribir";
        route_eliminar="{{url('/')}}/agendar/talleres/eliminarinscripcion/";
        route_update="{{url('/')}}/agendar/talleres/update";
        route_enhorabuena="{{url('/')}}/agendar/talleres/enhorabuena/";
        route_inscribir="{{url('/')}}/reservaciones/inscribir/";
        route_eliminar_reserva="{{url('/')}}/reservaciones/eliminar/";

        $(document).ready(function(){

        $('#alumno_id > option[value="{{ Session::get('id_alumno') }}"]').attr('selected', 'selected');

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[3, 'asc']],
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

                var costo = $("#taller-costo").text();

                var values = $('#alumno_id').val();

                if(values){
                
                // var alumno = '';
                
                // for(var i = 0; i < values.length; i += 1) {

                // alumno = alumno + '-' + values[i];

                // }

                procesando();
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var taller_id = $('input:hidden[name=taller_id]').val();
                var observacion_cambio_costo = $('#observacion_cambio_costo').val();
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
                        data:"&taller_id="+taller_id+"&alumno_id="+values+"&costo="+costo+"&observacion_cambio_costo="+observacion_cambio_costo,
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
                              
                              if(array.sexo=='F')
                              {
                                valor = $('#span_mujeres').html()
                                valor = parseInt(valor) + 1;
                                $('#span_mujeres').html(valor)

                                sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                              }
                              else
                              {
                                valor = $('#span_hombres').html()
                                valor = parseInt(valor) + 1;
                                $('#span_hombres').html(valor)
                                sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                              }
                             
                              var nombre = array.nombre;
                              var apellido = array.apellido;
                              var identificacion = array.identificacion;
    
                              if(respuesta.deuda > 0){
                                deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-youtube"></i>'
                              }else{
                                deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>'
                              }

                              var rowId=array.id;
                              var rowNode=t.row.add( [
                              ''+identificacion+'',
                              ''+sexo+'',
                              ''+nombre+ ' ' +apellido+'',
                              ''+deuda+'',
                              '<i class="zmdi zmdi-delete boton red eliminar f-20 p-r-10"></i>'
                              ] ).draw(false).node();
                              $( rowNode )
                              .attr('id',rowId)
                              .addClass('seleccion');

                            });

                            $('#observacion_cambio_costo').text('')
                            $('#textarea_observacion').hide();

                            }else{

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
              }
              else{

                $("#error-alumno_id_mensaje").html("Debe seleccionar un alumno primero");

              }
            });

        $("#guardar_costo").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar el costo del taller?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update+"/costo_taller";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_costo_taller" ).serialize(); 
                procesando();
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
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          
                          var costo = $("#costo").val();
                          $("#taller-costo").text(costo)
                          $('#textarea_observacion').show();

                          finprocesado();
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $('#modalCosto-Taller').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

        $('#tablelistar tbody').on( 'click', '.eliminar', function () {

          var id = $(this).closest('tr').attr('id');
          var tipo = $(this).closest('tr').data('tipo');

          if(tipo == 1){
            titulo = 'Desea eliminar al alumno?'
          }else{
            titulo = 'Desea eliminar la reservación?'
          }

          element = this;

          swal({   
              title: titulo,   
              text: "Confirmar eliminación!",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Eliminar!",  
              cancelButtonText: "Cancelar",         
              closeOnConfirm: true 
          }, function(isConfirm){   
            if (isConfirm) {  
              eliminar(id, element);
            }
          });
        });
      
        function eliminar(id, element){
          procesando()
          var tipo = $(element).closest('tr').data('tipo');
          if(tipo == 1){
            var route = route_eliminar + id;
          }else{
            var route = route_eliminar_reserva + id;
          }
          var token = $('input:hidden[name=_token]').val();
          $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            data: id,
            success:function(respuesta){
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              if(respuesta.status=="OK"){
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                t.row( $(element).parents('tr') )
                  .remove()
                  .draw();

                if(tipo == 1){
                  swal("Exito!","La inscripción ha sido eliminada!","success");
                }else{
                  swal("Exito!","La reservación ha sido eliminada!","success");
                }
                var sexo = $(element).closest('tr').data('sexo');

                if(sexo == 'F'){

                  mujeres = mujeres - 1

                  $('#span_mujeres').text(mujeres)

                }else{
                  hombres = hombres - 1

                  $('#span_hombres').text(hombres)
                }
                finprocesado()
              
              }
            },
            error:function(msj){
              $("#msj-danger").fadeIn(); 
              var text="";
              console.log(msj);
              var merror=msj.responseJSON;
              text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
              $("#msj-error").html(text);
              setTimeout(function(){
                 $("#msj-danger").fadeOut();
              }, 3000);
            }
          });
        }

    $(document)  
      .on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
      })
      .on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
      })
      .on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
      });

    function setModalsAndBackdropsOrder() {  
      var modalZIndex = 1040;
      $('.modal.in').each(function(index) {
        var $modal = $(this);
        modalZIndex++;
        $modal.css('zIndex', modalZIndex);
        $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
    });
      $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    function limpiarMensaje(){
        var campo = ["alumno_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["alumno_id"];
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

    $('#modalCosto-Taller').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo").val($("#taller-costo").text());
    })

    $('input[name="tipo"]').on('change', function(){

        if($(this).val() == 'T'){

            $( "#hombres2" ).removeClass( "c-verde" );
            $( "#mujeres2" ).removeClass( "c-verde" );
            $( "#todos2" ).addClass( "c-verde" );

            t
            .columns(2)
            .search('')
            .draw(); 

        }else if($(this).val() == 'F'){

            $( "#hombres2" ).removeClass( "c-verde" );
            $( "#mujeres2" ).addClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );

            t
            .columns(2)
            .search($(this).val())
            .draw();

        }else{

            $( "#hombres2" ).addClass( "c-verde" );
            $( "#mujeres2" ).removeClass( "c-verde" );
            $( "#todos2" ).removeClass( "c-verde" );

            t
            .columns(2)
            .search($(this).val())
            .draw();

        }

    });

    $('#tablelistar tbody').on( 'click', '.inscribir', function () {

      var id = $(this).closest('tr').attr('id');

      element = this;

      swal({   
          title: 'Desea inscribir al alumno?',   
          text: "Confirmar inscripción!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Inscribir!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {  
          inscribir(id,element);
        }
      });
    });
  
    function inscribir(id,element){
      procesando()

      var route = route_inscribir + id;
   
      var token = $('input:hidden[name=_token]').val();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: id,
        success:function(respuesta){
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){

            finprocesado();
            var nType = 'success';
            var nTitle="Ups! ";
            var nMensaje=respuesta.mensaje;
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

            alumno = respuesta.alumno;
            inscripcion = respuesta.inscripcion

            var identificacion = alumno.identificacion;    
            var nombre = alumno.nombre;
            var apellido = alumno.apellido;
            
            if(alumno.sexo=='F'){
              imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/5.jpg" alt="">'
              valor = $('#span_mujeres').html()
              valor = parseInt(valor) + 1;
              $('#span_mujeres').html(valor)
              sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
            }else{
              imagen = '<img class="lv-img-sm" src="/assets/img/profile-pics/4.jpg" alt="">'
              valor = $('#span_hombres').html()
              valor = parseInt(valor) + 1;
              $('#span_hombres').html(valor)
              sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
            }
            
            if(respuesta.deuda > 0){
              deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-youtube"></i>'
            }else{
              deuda = '<i class="zmdi zmdi-money f-20 p-r-3 c-verde"></i>'
            }

            var rowId=inscripcion.id;
            var rowNode=t.row.add( [
            '',
            ''+imagen+'',
            ''+identificacion+'',
            ''+sexo+'',
            ''+nombre+ ' ' +apellido+'',
            ''+deuda+'',
            ''
            ] ).draw(false).node();

            $( rowNode )
              .attr('id',rowId)
              .data('tipo',1)
              .addClass('seleccion');

            t.row( $(element).parents('tr') )
              .remove()
              .draw();

            window.location = route_enhorabuena + respuesta.id;
          
          }
        },
        error:function(msj){
          $("#msj-danger").fadeIn(); 
          var text="";
          console.log(msj);
          var merror=msj.responseJSON;
          text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
          $("#msj-error").html(text);
          setTimeout(function(){
             $("#msj-danger").fadeOut();
          }, 3000);
        }
      });
    }

    $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

        var id = $(this).closest('tr').attr('id');
        var dropdown = $(this).closest('.dropdown')
        var dropdown_toggle = $(this).closest('.dropdown-toggle')

        $('.dropdown-toggle').attr('aria-expanded','false')
        $('.dropdown').removeClass('open')
        $('.table-responsive').css( "overflow", "auto" );

        if(!dropdown.hasClass('open')){
            dropdown.addClass('open')
            dropdown_toggle.attr('aria-expanded','true')
            $('.table-responsive').css( "overflow", "inherit" );
        }
     
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })



    </script>

@stop