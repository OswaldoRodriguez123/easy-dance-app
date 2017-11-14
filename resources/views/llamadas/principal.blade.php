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
                        <div class="card-header">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-phone" f-25"></i> Sección de registro de llamadas</p>
                            <hr class="linea-morada">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombre">Filtro</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="usuario_tipo" id="usuario_tipo" data-live-search="true">
                                            <option value = "">Todos</option>
                                            <option value = "2">Alumnos</option>
                                            <option value = "1">Visitantes</option>
                                        </select>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-sm-offset-4">
                                 <div class="form-group">
                                    <div class="p-t-10">
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="activas" value="1" type="radio" checked>
                                            <i class="input-helper"></i>  
                                            Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="finalizadas" value="0" type="radio">
                                            <i class="input-helper"></i>  
                                            Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
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
                                    <th class="text-center" data-column-id="tipo"></th>
                                    <th class="text-center" data-column-id="usuario_tipo"></th>
                                    <th class="text-center" data-column-id="nombres">Nombre y Apellido</th>
                                    <th class="text-center" data-column-id="fecha_siguiente">Fecha de Proxima Llamada</th>
                                    <th class="text-center" data-column-id="dia">Día</th>
                                    <th class="text-center" data-column-id="tipologia">Perfil del Cliente</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($llamadas as $llamada)
                                <?php $id = $llamada['id']; 

                                    $contenido = '';

                                    $contenido = 
                                    '<p class="c-negro">' .
                                        'Fecha de Visita: ' . $llamada['fecha_visita'] . '<br>'.
                                        'Observación: ' . $llamada['observacion'] . '<br>'.
                                    '</p>';
                    
                                    

                                ?>

                                @if($llamada['tipo'] == 1)
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" data-tipo="1" data-usuario_tipo="{{$llamada['usuario_tipo']}}" data-usuario_id="{{$llamada['usuario_id']}}">
                                @else
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion seleccion_deleted" data-tipo="0" data-usuario_tipo="{{$llamada['usuario_tipo']}}" data-usuario_id="{{$llamada['usuario_id']}}">
                                @endif

                                    
                                    <?php 
                                        $tmp = explode(" ", $llamada['nombre']);
                                        $nombre = $tmp[0];

                                        $tmp = explode(" ", $llamada['apellido']);
                                        $apellido = $tmp[0];
                                    ?>
                                    
                                    <td class="text-center"><span style="display:none">{{$llamada['tipo']}}</span></td>
                                    <td class="text-center"><span style="display:none">{{$llamada['usuario_tipo']}}</span></td>
                                    <td class="text-center">{{$nombre}} {{$apellido}} </td>
                                    <td class="text-center">{{$llamada['fecha_siguiente']}}</td>
                                    <td class="text-center">{{$llamada['dia']}}</td>
                                    <td class="text-center">{{$llamada['tipologia']}}</td>
                                    <!-- <td class="text-center disabled"> 
                                        <i name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i>
                                    </td> -->
                                </tr>
                                <!-- endcan -->
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

        var tipo = 1
        var usuario_tipo = ''

        $(document).ready(function(){

            route_llamada_alumno="{{url('/')}}/participante/alumno/llamadas/";
            route_llamada_visitante="{{url('/')}}/participante/visitante/llamadas/";

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,    
                bLengthChange: false,
                order: [[3, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
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

            rechargeTable()

        });

        function previa(t){

            var row = $(t).closest('tr');
            var id = $(row).data('usuario_id');

            if($(row).data('usuario_tipo') == '1'){
                var route_detalle = route_llamada_visitante
            }else{
                var route_detalle = route_llamada_alumno
            }

            var route =route_detalle+id;
            window.open(route, '_blank');;
        }


        $('input[name=tipo]').on('change', function(){

            tipo = $(this).val()
            rechargeTable()

        });

        $('#usuario_tipo').on('change', function(){

            usuario_tipo = $(this).val()
            rechargeTable()
    
        });

        $("#activas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#finalizadas").click(function(){
            $( "#finalizadas2" ).addClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });

        function rechargeTable(){
            t
                .columns(0)
                .search(tipo)
                .columns(1)
                .search(usuario_tipo)
                .draw();
        }

    </script>

@stop