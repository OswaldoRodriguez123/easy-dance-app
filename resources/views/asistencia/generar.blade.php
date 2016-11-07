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

<a href="{{url('/')}}/configuracion/productos/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                        <br>
                                                              
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="descripcion">Imagen</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Nombre</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Identificacion</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnosacademia as $alumno)
                                <?php $id = $alumno['id']; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$alumno->imagen}}" data-id-participante = "{{$alumno->id}}" data-nombre-participante = "{{$alumno->nombre}} {{$alumno->apellido}}" data-identificacion-participante = "{{$alumno->identificacion}}" data-tipo-participante = "alumno" data-sexo = "{{$alumno->sexo}}">
                                    <td class="text-center previa">
                                    @if($alumno->imagen){
                                        <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/'+array.imagen+'" alt="">
                                    @else
                                        @if($alumno->sexo == 'M')
                                          <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                        @else
                                          <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                    @endif
                                  @endif
                                  </td>
                                    <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}}</td>
                                    <td class="text-center previa">{{$alumno['identificacion']}}</td>

                                </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25,  
            order: [[0, 'asc']],
            fnDrawCallback: function() {
            if ("{{count($alumnosacademia)}}" < 25) {
                  $('.dataTables_paginate').hide();
                  $('#tablelistar_length').hide();
              }else{
                 $('.dataTables_paginate').show();
              }
            },
            pageLength: 25,
            language: {
                  searchPlaceholder: "Buscar"
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2)', nRow).attr( "onclick","buscar(this)" );
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

    </script>

@stop