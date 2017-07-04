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

<!--<a href="{{url('/')}}/especiales/examenes/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>-->
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                     @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                        @if(isset($id_evaluacion))
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/evaluar/{{$id_evaluacion}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @else

                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @endif
                        
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    @else
                        <a class="btn-blanco m-r-10 f-16" href="/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                    @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">
                            <!--<span class="f-16 p-t-0 text-success">Agregar un Examen <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>-->

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-examen f-25"></i> Sección de Evaluaciones</p>
                            <hr class="linea-morada">                                                        
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="organizador"></th>
                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="confirmacion" data-type="numeric"></th>
                                    @endif
                                    <th class="text-center" data-column-id="identificacion">Identificación</th>
                                    <th class="text-center" data-column-id="nombre">Nombre</th>
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="examen">Valoración</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nota">Nota</th>

                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($evaluacion as $evaluaciones)
                                <?php $id = $evaluaciones->id; ?>
                                <?php $alumno_id = $evaluaciones->alumno_id; ?>
                                <tr id="row_{{$id}}" class="seleccion">
                                    <td class="text-center previa"><span style="display: none">{{$evaluaciones->id}}</span></td>

                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center previa"> @if(isset($activacion[$alumno_id])) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    @endif
                                    <td class="text-center previa">
                                    {{$evaluaciones->identificacion}}
                                    </td>
                                    <td class="text-center previa">{{$evaluaciones->alumno_nombre}} {{$evaluaciones->alumno_apellido}}</td>
                                    <td class="text-center previa">{{$evaluaciones->instructor_nombre}} {{$evaluaciones->instructor_apellido}}</td>
                                    <td class="text-center previa">{{$evaluaciones->nombreExamen}}</td>
                                    <td class="text-center previa">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$evaluaciones->fecha)->format('d-m-Y')}}</td>
                                    <td class="text-center previa">{{$evaluaciones->nota_total}}</td>
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

        route_detalle="{{url('/')}}/especiales/evaluaciones/detalle";
        route_detalle2="{{url('/')}}/evaluaciones/detalle";
        //route_operacion="{{url('/')}}/especiales/examenes/operaciones";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'desc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
        },
        pageLength: 25,
        paging: false,
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

            });

    function previa(t){

            var row = $(t).closest('tr').attr('id');
            var id_alumno = row.split('_');
            if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6)
            {
                var route =route_detalle+"/"+id_alumno[1];
            }else{
                var route =route_detalle2+"/"+id_alumno[1];

            }
            
            window.location=route;
        }

        /*$("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
        });*/

    </script>
@stop