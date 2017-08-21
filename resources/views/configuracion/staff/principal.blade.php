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

<a href="{{url('/')}}/configuracion/staff/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
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
                        <div class="card-header">

                        

                            <div class ="col-md-12 text-right">                                
 
                                <span class="f-16 p-t-0 text-success">Agregar un Staff <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-staff f-25"></i> Sección de Staff</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="cargo" data-order="desc">Cargo</th>
                                    <th class="text-center" data-column-id="operaciones" data-order="desc">Operaciones</th>

                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($staffs as $staff)
                                <?php $id = $staff['id']; ?>
                                <!-- can('view-alumnos', $alumno) -->
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$staff['identificacion']}}</td>
                                    <td class="text-center previa">
                                        @if($staff['sexo']=='F')
                                            <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                        @else
                                            <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                        @endif
                                    </td>

                                    <?php $tmp = explode(" ", $staff['nombre']);
                                    $nombre_alumno = $tmp[0];

                                    $tmp = explode(" ", $staff['apellido']);
                                    $apellido_alumno = $tmp[0];

                                    ?>

                                    <td class="text-center previa">{{$nombre_alumno}} {{$apellido_alumno}} </td>
                                    <td class="text-center previa">{{$staff['cargo']}}</td>
                                    <td class="text-center"> 
                                        <ul class="top-menu">
                                            <li class="dropdown" id="dropdown_{{$id}}">
                                                <a href="#" id="dropdown_toggle_{{$id}}" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                                   <span class="f-15 f-700" style="color:black"> 
                                                        <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                   </span>
                                                </a>

                                                  <div class="dropup" dropdown-append-to-body>
                                                    <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">
                                                        
                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/incidencias/generar/{{$id}}"><i class="zmdi icon_f-incidencias f-20"></i>&nbsp;Incidencias</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/configuracion/staff/pagos/{{$id}}"><i class="zmdi zmdi-money f-20"></i>&nbsp;Pagos</a>
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

        route_detalle="{{url('/')}}/configuracion/staff/detalle/";
        route_operacion="{{url('/')}}/configuracion/staff/operaciones";
        route_eliminar="{{url('/')}}/configuracion/staff/eliminar/";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,    
        order: [[2, 'asc']],
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

            var id = $(t).closest('tr').attr('id');
            var route =route_detalle + id;
            window.open(route, '_blank');
        }

         $(".eliminar").click(function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar al staff?",   
                text: "Confirmar eliminación!",   
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
                    eliminar(id);
                }
            });
        });
        function eliminar(id){
            var route = route_eliminar + id;
            var token = '{{ csrf_token() }}';
            procesando();
                    
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){
                    finprocesado();
                    swal("Exito!","Ha sido eliminado!","success");
                    t.row($('#'+id))
                      .remove()
                      .draw();

                },
                error:function(msj){
                    finprocesado();
                    $("#msj-danger").fadeIn(); 
                    var text="";
                    console.log(msj);
                    var merror=msj.responseJSON;
                    text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                    $("#msj-error").html(text);
                    setTimeout(function(){
                             $("#msj-danger").fadeOut();
                            }, 3000);
                    }
            });
        }

        $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

            var id = $(this).closest('tr').attr('id');
            var dropdown = $('#dropdown_'+id)
            var dropdown_toggle = $('#dropdown_toggle_'+id)

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