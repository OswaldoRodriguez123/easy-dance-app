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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/asistencia/generar" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        

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

                        <!-- <div class="text-left"><a class="text-success f-20" href="{{url('/')}}/reportes/asistencias">Reporte</a></div> -->

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="alumnos" value="A" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumnos2" name="alumnos2" class="icon_a-participantes c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="instructores" value="I" type="radio">
                                        <i class="input-helper"></i>  
                                        Instructores <i id="instructores2" name="instructores2" class="icon_a-instructor f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="staff" value="S" type="radio">
                                        <i class="input-helper"></i>  
                                        Staff <i id="staff2" name="staff2" class="icon_f-staff f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                        <div class="clearfix p-b-15"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">D??a</th>
                                    <th class="text-center" data-column-id="clase" id="clase">Clase</th>
                                    <th class="text-center" data-column-id="instructor" id="nombre">Instructor</th>
                                    <th class="text-center" data-column-id="participante" id="participante">Participante</th>
                                    <th class="text-center" data-column-id="hora" id="hora">Hora</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($asistencias as $asistencia)

                                
                                    <tr class="seleccion" >
                                        <td class="text-center previa"><span style="display: none">{{$asistencia['tipo']}}</span></td>
                                        <td class="text-center previa">{{$asistencia['fecha']}}</td>
                                        <td class="text-center previa">{{$asistencia['dia']}}</td>
                                        <td class="text-center previa">
                                            @if($asistencia['tipo'] != 'S')
                                                {{$asistencia['clase']}}
                                            @else
                                                {!! $asistencia['clase'] !!}
                                            @endif
                                        </td>
                                        <td class="text-center previa">{{$asistencia['nombre']}} {{$asistencia['apellido']}}</td>
                                        <td class="text-center previa">{{$asistencia['hora']}}</td>
                                        <td class="text-center previa">{{$asistencia['hora_salida']}}</td>
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

            $(document).ready(function(){

                $('#alumnos').prop('checked',true)
        
                t
                .columns(0)
                .search('A')
                .draw(); 
            
            });

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                order: [[1, 'desc'], [6, 'desc']],
                language: {
                      searchPlaceholder: "Buscar"
                },
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "disabled");
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

            $('input[name="tipo"]').on('change', function(){

                if($(this).val() == 'A'){

                    document.getElementById('participante').innerHTML = 'Participante';
                    document.getElementById('hora').innerHTML = 'Hora';  
                    document.getElementById('clase').innerHTML = 'Clase';
                    document.getElementById('nombre').innerHTML = 'Instructor';

                    $( "#instructores2" ).removeClass( "c-verde" );
                    $( "#staff2" ).removeClass( "c-verde" );
                    $( "#alumnos2" ).addClass( "c-verde" );

                    t
                    .columns(0)
                    .search($(this).val())
                    .draw(); 

                }else if($(this).val() == 'I'){

                    document.getElementById('participante').innerHTML = 'Hora Entrada'; 
                    document.getElementById('hora').innerHTML = 'Hora Salida';
                    document.getElementById('clase').innerHTML = 'Clase';
                    document.getElementById('nombre').innerHTML = 'Instructor';

                    $( "#alumnos2" ).removeClass( "c-verde" );
                    $( "#staff2" ).removeClass( "c-verde" );
                    $( "#instructores2" ).addClass( "c-verde" );

                    t
                    .columns(0)
                    .search($(this).val())
                    .draw();

                }else{

                    document.getElementById('participante').innerHTML = 'Hora Entrada'; 
                    document.getElementById('hora').innerHTML = 'Hora Salida';
                    document.getElementById('clase').innerHTML = 'Status'; 
                    document.getElementById('nombre').innerHTML = 'Nombre'; 

                    $( "#alumnos2" ).removeClass( "c-verde" );
                    $( "#instructores2" ).removeClass( "c-verde" );
                    $( "#staff2" ).addClass( "c-verde" );

                    t
                    .columns(0)
                    .search($(this).val())
                    .draw();

                }
        
            });

        </script>

@stop