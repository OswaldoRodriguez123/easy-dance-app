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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/evaluar/{{$id_evaluacion}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">
                            <!--<span class="f-16 p-t-0 text-success">Agregar un Examen <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>-->

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-examen f-25"></i> Sección de Examenes</p>
                            <hr class="linea-morada">                                                        
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="organizador"></th>
                                    <th class="text-center" data-column-id="identificacion">Identificación</th>
                                    <th class="text-center" data-column-id="nombre">Nombre</th>
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="examen">Examen</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nota">Nota</th>

                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($evaluacion as $evaluaciones)
                                <?php $id = $evaluaciones->id; ?>
                                <tr id="row_{{$id}}" class="seleccion">
                                    <td class="text-center previa"><span style="display: none">{{$evaluaciones->id}}</span></td>
                                    <td class="text-center previa">
                                    {{$evaluaciones->identificacion}}
                                    </td>
                                    <td class="text-center previa">{{$evaluaciones->alumno_nombre}} {{$evaluaciones->alumno_apellido}}</td>
                                    <td class="text-center previa">{{$evaluaciones->instructor_nombre}} {{$evaluaciones->instructor_apellido}}</td>
                                    <td class="text-center previa">{{$evaluaciones->nombreExamen}}</td>
                                    <td class="text-center previa">{{$evaluaciones->fecha}}</td>
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
        //route_operacion="{{url('/')}}/especiales/examenes/operaciones";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[0, 'desc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
        },
        pageLength: 25,
        paging: false,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    }
                });

            });

    function previa(t){

            var row = $(t).closest('tr').attr('id');
            var id_alumno = row.split('_');
            var route =route_detalle+"/"+id_alumno[1];
            window.location=route;
        }

        /*$("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
        });*/

    </script>
@stop