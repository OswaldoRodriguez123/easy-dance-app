@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

<a href="{{url('/')}}/agendar/talleres/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

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
                        <div class="card-header text-right">

                            <span class="f-16 p-t-0 text-success">Agregar un Taller <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-talleres f-25"></i> Sección de Talleres</p>
                            <hr class="linea-morada">                                                          
                        </div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <th class="text-center" data-column-id="status" data-type="numeric">Status</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                               
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($talleres as $taller)
                                <?php $id = $taller['id']; 

                                    $contenido = '';

                                    $contenido = 
                                    '<p class="c-negro">' .
                                        'Costo: ' . number_format($taller['costo'], 2, '.' , '.')  . '<br>'.
                                        'Cantidad de Participantes: ' . $taller['cantidad_participantes'] . '<br>'.
                                        'Estilos de Baile: ' . $taller['especialidades'] . '<br>'.
                                        'Dias de Semana: ' . $taller['dias'] . '<br>'.
                                        'Estatus: ' . $taller['status'] . '<br>'.
                                    '</p>';
                    
                                    

                                ?>
                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" id="{{$id}}" class="seleccion">
                                    <td class="text-center previa">{{$taller['nombre']}}</td>
                                    <td class="text-center previa">{{$taller['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$taller['instructor_nombre']}} {{$taller['instructor_apellido']}}</td>
                                    <td class="text-center previa">{{$taller['hora_inicio']}} - {{$taller['hora_final']}}</td>
                                    <td class="text-center previa">
                                        <span class="{{ empty($taller['dias_restantes']) ? 'c-youtube' : '' }}">{{$taller['status']}}</span>
                                        Restan {{$taller['dias_restantes']}} Días
                                    </td>
                                    <td class="text-center disabled"> 
                                        <!-- <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i> -->

                                        <ul class="top-menu">
                                            <li class="dropdown" id="dropdown_{{$id}}">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                   <span class="f-15 f-700" style="color:black"> 
                                                        <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                   </span>
                                                </a>
                                                <div class="dropup">
                                                    <ul class="dropdown-menu dm-icon pull-right">

                                                        <li class="hidden-xs">
                                                            <a onclick="procesando()" href="{{url('/')}}/agendar/talleres/participantes/{{$id}}"><i class="icon_a-participantes f-16 m-r-10 boton blue"></i> Participantes</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a onclick="procesando()" href="{{url('/')}}/agendar/talleres/progreso/{{$id}}"><i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i> Ver Progreso</a>
                                                        </li>
                                                    
                                                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                                          <li class="hidden-xs">
                                                            <a onclick="procesando()" href="{{url('/')}}/agendar/talleres/egresos/{{$id}}"><i class="fa fa-money f-16 m-r-10 boton blue"></i> Egresos</a>
                                                          </li>

                                                          <li class="hidden-xs">
                                                            <a onclick="procesando()" href="{{url('/')}}/agendar/talleres/multihorario/{{$id}}"><i class="zmdi zmdi-calendar-note f-16 boton blue"></i>Multihorario</a>
                                                          </li>

                                                          <li class="hidden-xs eliminar">
                                                              <a class="pointer eliminar"><i class="zmdi zmdi-delete f-20 boton red sa-warning"></i> Eliminar</a>
                                                          </li>

                                                        @endif
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
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

        route_detalle="{{url('/')}}/agendar/talleres/detalle";
        route_operacion="{{url('/')}}/agendar/talleres/operaciones";
        route_progreso="{{url('/')}}/agendar/talleres/progreso";
        route_eliminar="{{url('/')}}/agendar/talleres/eliminar/";
        route_principal="{{url('/')}}/agendar/talleres";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25,    
            order: [[1, 'desc'],[3, 'desc']],
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
    

        });

    function previa(t){
        var row = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+row;
        window.open(route, '_blank');
      }

    $("i[name=operacion").click(function(){
        var route =route_operacion+"/"+this.id;
        window.open(route, '_blank');;
     });

    $('#tablelistar tbody').on( 'click', 'a.eliminar', function () {
        var id = $(this).closest('tr').attr('id');
                swal({   
                    title: "Desea eliminar el taller",   
                    text: "Tenga en cuenta que los horarios creados para este taller tambien seran eliminados!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
        });
    });
      function eliminar(id){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
         procesando();
                
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
            dataType: 'json',
            success:function(respuesta){

                window.open(route, '_blank');_principal; 

            },
            error:function(msj){
            // $("#msj-danger").fadeIn(); 
            // var text="";
            // console.log(msj);
            // var merror=msj.responseJSON;
            // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
            // $("#msj-error").html(text);
            // setTimeout(function(){
            //          $("#msj-danger").fadeOut();
            //         }, 3000);
                finprocesado()
                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
            }
        });
    }

    $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

        var id = $(this).closest('tr').attr('id');
        var dropdown = $(this).closest('.dropdown')
        var dropdown_toggle = $(this).closest('.dropdown-toggle')

        $('.dropdown-toggle').attr('aria-expanded','false')
        $('.dropdown').removeClass('open')
        $('.table-responsive').css( "overflow", "auto" );

        if(!dropdown.hasClass('open')){
            dropdown.addClass('open')
            dropdown_toggle.attr('aria-expanded','true')
            $('.table-responsive').css( "overflow", "inherit" );
        }
     
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })

    </script>
@stop