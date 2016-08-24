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

@if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
<a href="{{url('/')}}/agendar/clases-grupales/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
@endif
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        @if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        @else
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        @endif
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">
                            @if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
                                <span class="f-16 p-t-0 text-success">Agregar una Clase Grupal <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                            @endif

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>
                            <hr class="linea-morada">                                                        
                        </div>

                        @if($clase_grupal_join)
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="dia" data-order="desc">Dia</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <!--<th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Estatus E</th>-->
                                    @if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
                                        <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($clase_grupal_join as $clase_grupal)
                                <?php $id = $clase_grupal['id']; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> @if($clase_grupal['inicio'] == 0) <i class="zmdi zmdi-star zmdi-hc-fw zmdi-hc-fw c-amarillo f-20" data-html="true" data-original-title="" data-content="Esta clase grupal no ha comenzado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">{{$clase_grupal['clase_grupal_nombre']}}</td>
                                    <td class="text-center previa">{{$clase_grupal['especialidad_nombre']}}</td>
                                    <td class="text-center previa"><span style="display: none;">{{$clase_grupal['dia_de_semana']}}</span> 

                                    @if($clase_grupal['dia_de_semana'] == 1)

                                    Lunes

                                    @elseif($clase_grupal['dia_de_semana'] == 2)

                                    Martes

                                    @elseif($clase_grupal['dia_de_semana'] == 3)

                                    Miercoles

                                    @elseif($clase_grupal['dia_de_semana'] == 4)

                                    Jueves

                                    @elseif($clase_grupal['dia_de_semana'] == 5)

                                    Viernes

                                    @elseif($clase_grupal['dia_de_semana'] == 6)

                                    Sabado

                                    @elseif($clase_grupal['dia_de_semana'] == 7)

                                    Domingo

                                    @endif</td>
                                    <td class="text-center previa">{{$clase_grupal['hora_inicio']}} - {{$clase_grupal['hora_final']}} </td>
                                    @if(Auth::user()->usuario_tipo == 1 || Auth::user()->usuario_tipo == 5)
                                     <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i></td>
                                    @endif
                                  </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado clases grupales. </div>


                             </div>




                            @endif
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

        route_detalle="{{url('/')}}/agendar/clases-grupales/detalle";
        route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones";
        route_progreso="{{url('/')}}/agendar/clases-grupales/progreso";
        route_participantes="{{url('/')}}/agendar/clases-grupales/participantes";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[3, 'asc'], [4, 'asc']],
       fnDrawCallback: function() {
        if ("{{count($clase_grupal_join)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }
        },
        pageLength: 25,
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
        if("{{Auth::user()->usuario_tipo}}" == 1 || "{{Auth::user()->usuario_tipo}}" == 5)
        {
            id_alumno = "{{Session::get('id_alumno')}}";
            if(!id_alumno){
                var route =route_detalle+"/"+row;
            }
            else{
                var route =route_participantes+"/"+row;
            }
        }else{
            var route =route_progreso+"/"+row;
        }
        window.location=route;
      }

      $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
         });


    </script>
@stop