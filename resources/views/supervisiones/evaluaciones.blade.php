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

                        @if(isset($id_evaluacion))

                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/supervisiones/evaluar/{{$id_evaluacion}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        @elseif(isset($id))

                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/supervisiones/conceptos/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @else

                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/supervisiones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        @endif
                        
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            @if(isset($id))
                                <div class="col-sm-4 col-sm-offset-8 text-center">

                                    Porcentaje de Efectividad<br>

                                    <div class="progress progress-striped m-t-10 m-b-10" style="border:1px solid; color:#4E1E43">
                                        <div class="progress-bar progress-bar-morado" id="barra_progreso" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;"></div>
                                    </div>

                                    {{$porcentaje}}% de Efectividad

                                    
                                    <div class="rating-list">
                                        <div class="rl-star">
                                            @if($porcentaje >= 20)
                                                <i class="zmdi zmdi-star active"></i>
                                            @else
                                                <i class="zmdi zmdi-star"></i>
                                            @endif

                                            @if($porcentaje >= 40)
                                                <i class="zmdi zmdi-star active"></i>
                                            @else
                                                <i class="zmdi zmdi-star"></i>
                                            @endif

                                            @if($porcentaje >= 60)
                                                <i class="zmdi zmdi-star active"></i>
                                            @else
                                                <i class="zmdi zmdi-star"></i>
                                            @endif

                                            @if($porcentaje >= 80)
                                                <i class="zmdi zmdi-star active"></i>
                                            @else
                                                <i class="zmdi zmdi-star"></i>
                                            @endif

                                            @if($porcentaje >= 100)
                                                <i class="zmdi zmdi-star active"></i>
                                            @else
                                                <i class="zmdi zmdi-star"></i>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-examen f-25"></i> Sección de Evaluaciones</p>
                            <hr class="linea-morada">                                                        
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="organizador"></th>
                                    <th class="text-center" data-column-id="nombre">Staff</th>
                                    <th class="text-center" data-column-id="instructor">Supervisor</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nota">Nota</th>
                                    <th class="text-center" data-column-id="nota">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($evaluaciones as $evaluacion)
                                <?php $id = $evaluacion['id']; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa"><span style="display: none">{{$id}}</span></td>
                                    <td class="text-center previa">{{$evaluacion['nombre']}} {{$evaluacion['apellido']}}</td>
                                    <td class="text-center previa">{{$evaluacion['supervisor']}}</td>
                                    <td class="text-center previa">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$evaluacion['created_at'])->format('d-m-Y')}}</td>
                                    <td class="text-center previa">{{$evaluacion['total']}}</td>
                                    <td class="text-center previa">{{intval($evaluacion['porcentaje'])}}%</td>
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

        route_detalle="{{url('/')}}/supervisiones/evaluaciones/detalle/";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).attr( "onclick","previa(this)" );
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

            var id = $(t).closest('tr').attr('id');
            window.location=route_detalle+id;
        }


    </script>
@stop