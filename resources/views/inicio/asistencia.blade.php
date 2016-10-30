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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        <div class="text-left"><a class="text-success f-20" href="{{url('/')}}/reportes/asistencias">Reporte</a></div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="alumnos" value="alumnos" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumnos2" name="alumnos2" class="icon_a-participantes c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="instructores" value="instructores" type="radio">
                                        <i class="input-helper"></i>  
                                        Instructores <i id="instructores2" name="instructores2" class="icon_a-instructor f-20"></i>
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
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="clase">Clase</th>
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="participante" id="participante">Participante</th>
                                    <th class="text-center" data-column-id="hora" id="hora">Hora</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($alumnos_asistencia as $asistencia)

                                    <?php $id = $asistencia['id']; ?>
                                
                                    <tr id="row_{{$id}}" class="seleccion" >
                                        <td class="text-center previa">{{$asistencia['fecha']}}</td>
                                        <td class="text-center previa">{{$asistencia['clase']}}</td>
                                        <td class="text-center previa">{{$asistencia['nombre_instructor']}} {{$asistencia['apellido_instructor']}}</td>
                                        <td class="text-center previa">{{$asistencia['nombre']}} {{$asistencia['apellido']}}</td>
                                        <td class="text-center previa">{{$asistencia['hora']}}</td>
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

            var alumno = <?php echo json_encode($alumnos_asistencia);?>;
            var instructor = <?php echo json_encode($instructores_asistencia);?>;

            $(document).ready(function(){

                $("#alumnos").prop("checked", true);

                t=$('#tablelistar').DataTable({
                    processing: true,
                    serverSide: false,
                    pageLength: 25,  
                    order: [[0, 'desc'], [4, 'desc']],
                    fnDrawCallback: function() {
                    if ("{{count($alumnos_asistencia)}}" < 25) {
                          $('.dataTables_paginate').hide();
                          $('#tablelistar_length').hide();
                      }
                    },
                    pageLength: 25,
                    language: {
                          searchPlaceholder: "Buscar"
                    },
                    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                      $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
                      $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "disabled");
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


             $('input[name="tipo"]').on('change', function(){
                procesando();
                t.clear().draw();

                if ($(this).val()=='alumnos') {
                      rechargeAlumno();
                } else  {
                      rechargeInstructor();
                }
                
             });

            function rechargeAlumno(){

                setTimeout(function(){
                
                    document.getElementById('participante').innerHTML = 'Participante';
                    document.getElementById('hora').innerHTML = 'Hora';  

                    $.each(alumno, function (index, array) {
                        var rowNode=t.row.add( [
                        ''+array.fecha+'',
                        ''+array.clase+'',
                        ''+array.nombre_instructor+ ' '+array.apellido_instructor+'',
                        ''+array.nombre+ ' '+array.apellido+'',
                        ''+array.hora+''
                        // '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                        ] ).draw(false).node();
                        $( rowNode )
                            .attr('id',array.id)
                            .addClass('seleccion');
                    });

                    finprocesado();

                }, 1000);
            }

            function rechargeInstructor(){
                
                document.getElementById('participante').innerHTML = 'Hora Entrada'; 
                document.getElementById('hora').innerHTML = 'Hora Salida'; 

                $.each(instructor, function (index, array) {
                    var rowNode=t.row.add( [
                    ''+array.fecha+'',
                    ''+array.clase+'',
                    ''+array.nombre_instructor+ ' '+array.apellido_instructor+'',
                    ''+array.hora+'',
                    ''+array.hora_salida+''
                    // '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                });
                finprocesado();
            }

            $("#alumnos").click(function(){
                $( "#instructores2" ).removeClass( "c-verde" );
                $( "#alumnos2" ).addClass( "c-verde" );
            });

            $("#instructores").click(function(){
                $( "#alumnos2" ).removeClass( "c-verde" );
                $( "#instructores2" ).addClass( "c-verde" );
            });

        </script>

@stop