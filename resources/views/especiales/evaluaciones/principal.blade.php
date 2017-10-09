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
                     @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                        @if(isset($id_evaluacion))
                            <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/evaluar/{{$id_evaluacion}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a> -->
                            <?php $url = "/especiales/examenes" ?>
                            <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @elseif(isset($id))
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @else
                            <?php $url = "/especiales/examenes" ?>
                            <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-examen f-25"></i> Sección de Evaluaciones</p>
                            <hr class="linea-morada">

                            <div class="col-sm-12">
                                <div class="p-t-10 pull-right">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="En Proceso" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        En Proceso <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="Finalizada" type="radio">
                                        <i class="input-helper"></i>  
                                        Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                </div>
                            </div>


                            <div class="clearfix"></div>                                                        
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="nombre">Nombre</th>
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="examen">Valoración</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nota">Nota</th>
                                    <th class="text-center" data-column-id="nota">Estatus</th>

                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($evaluaciones as $evaluacion)
                                <?php $id = $evaluacion['id']; ?>
                                <tr id="{{$id}}" class="seleccion" data-estatus="{{$evaluacion['estatus']}}">
                                    <td class="text-center previa">
                                        @if($evaluacion['imagen'])
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$evaluacion['imagen']}}" alt="">
                                        @else
                                            @if($evaluacion['sexo'] == 'M')
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                            @else
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$evaluacion['alumno_nombre']}} {{$evaluacion['alumno_apellido']}}</td>
                                    <td class="text-center previa">{{$evaluacion['instructor_nombre']}} {{$evaluacion['instructor_apellido']}}</td>
                                    <td class="text-center previa">{{$evaluacion['nombreExamen']}}</td>
                                    <td class="text-center previa">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$evaluacion['created_at'])->format('Y-m-d')}}</td>
                                    <td class="text-center previa">{{$evaluacion['total']}}</td>
                                    <td class="text-center previa">
                                        @if($evaluacion['estatus'] == 1)
                                            Finalizada
                                        @else
                                            <span class="c-verde">En Proceso</span>
                                        @endif
                                    </td>
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
        route_evaluar="{{url('/')}}/especiales/evaluaciones/evaluar";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25,   
            order: [[4, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).attr( "onclick","previa(this)" );
            },
            drawCallback: function(){
                loadImages();
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

            t
            .columns(6)
            .search('En Proceso')
            .draw();

        });

        function loadImages(){
            imagenes = $('.lazy')

            $.each(imagenes, function(){
                var row = $(this).closest('tr')
                var image = this;
                var src = $(image).data('image');
                image.src = src;
            });
        }

        function previa(t){
            var id = $(t).closest('tr').attr('id');
            var estatus = $(t).closest('tr').data('estatus');

            if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6)
            {
                if(estatus == 1){
                    var route =route_detalle+"/"+id;
                }else{
                    var route =route_evaluar+"/"+id;
                }
                
            }else{
                var route =route_detalle2+"/"+id;

            }
            
            window.open(route, '_blank');;
        }

        $("#activas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#finalizadas").click(function(){
            $( "#finalizadas2" ).addClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });

        $("input[name='tipo']").on('change', function(){ 
          t
            .columns(6)
            .search($(this).val())
            .draw();
        });


    </script>
@stop