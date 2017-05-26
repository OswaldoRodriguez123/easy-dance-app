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

<a href="{{url('/')}}/configuracion/supervisiones/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            <div class ="col-md-6 text-left">  
                                <a class="email" href="{{url('/')}}/configuracion/supervisiones/eliminadas"><i class="zmdi zmdi-wrench f-20 m-r-5 boton blue sa-warning" data-original-title="Bandeja Eliminados" data-toggle="tooltip" data-placement="top" title=""></i></a>
                            </div>

                        

                            <div class ="col-md-12 text-right">                                
 
                                <span class="f-16 p-t-0 text-success">Agregar una Supervisión <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-staff f-25"></i> Sección de Supervisiones</p>
                            <hr class="linea-morada">

                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="supervisor">Supervisor</th>
                                    <th class="text-center" data-column-id="cargo">Cargo a Supervisar</th>
                                    <th class="text-center" data-column-id="staff">Staff a Supervisar</th>
                                    <th class="text-center" data-column-id="fecha">Rango de Fecha</th>
                                    <th class="text-center" data-column-id="operaciones">Operaciones</th>

                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($supervisiones as $supervision)
                                <?php $id = $supervision['id']; ?>
                                <!-- can('view-alumnos', $alumno) -->
                                <tr id="row_{{$id}}" class="seleccion" >
                                    
                                    <?php $tmp = explode(" ", $supervision['nombre']);
                                    $nombre_alumno = $tmp[0];

                                    $tmp = explode(" ", $supervision['apellido']);
                                    $apellido_alumno = $tmp[0];

                                    ?>
                                    <td class="text-center previa">{{$supervision['supervisor']}}</td>
                                    <td class="text-center previa">{{$supervision['cargo']}}</td>
                                    <td class="text-center previa">{{$nombre_alumno}} {{$apellido_alumno}} </td>
                                    <td class="text-center previa">{{$supervision['fecha_inicio']}} / {{$supervision['fecha_final']}}</td>
                                    <td class="text-center disabled"> 
                                        <ul class="top-menu">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                                   <span class="f-15 f-700" style="color:black"> 
                                                        <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                   </span>
                                                </a>

                                                  <div class="dropup" dropdown-append-to-body>
                                                    <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/configuracion/supervisiones/agenda/{{$id}}"><i class="zmdi zmdi-eye f-20"></i> Ver Agenda</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/configuracion/supervisiones/evaluar/{{$id}}"><i class="zmdi icon_a-examen f-20"></i> Evaluar</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/configuracion/supervisiones/evaluaciones/{{$id}}"><i class="zmdi zmdi-hourglass-alt f-20"></i> Historial</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a class="eliminar"><i class="zmdi zmdi-delete f-20"></i> Eliminar</a>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
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

        route_detalle="{{url('/')}}/configuracion/supervisiones/detalle";
        route_operacion="{{url('/')}}/configuracion/supervisiones/operaciones";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,    
        order: [[3, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
    
          
        });

        function previa(t){

            var row = $(t).closest('tr').attr('id');
            var id_alumno = row.split('_');
            var route =route_detalle+"/"+id_alumno[1];
            window.location=route;
        }

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
         });


        $( ".dropdown-toggle" ).hover(function() {

          if($('.dropdown').hasClass('open')){

          }else{
            $( this ).click();
          }
         
        });

        $('.table-responsive').on('show.bs.dropdown', function () {
          $('.table-responsive').css( "overflow", "inherit" );
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
          $('.table-responsive').css( "overflow", "auto" );
        })


        </script>

@stop