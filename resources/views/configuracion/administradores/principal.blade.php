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

<a href="{{url('/')}}/configuracion/administradores/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
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

                            <div class ="col-md-12 text-left">  
                                <ul class="top-menu">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                           <span class="f-15 f-700" style="color:black"> 
                                                <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                           </span>
                                        </a>
                                        <ul class="dropdown-menu dm-icon pull-right">
                                            <li class="hidden-xs">
                                                <a onclick="procesando()" href="{{url('/')}}/configuracion/administradores/eliminados"><i name="eliminados" id="eliminados" class="tm-icon zmdi zmdi-delete boton red f-25 pointer eliminados detalle"></i>&nbsp;Bandeja Eliminados</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <span class="f-16 p-t-0 text-success">Agregar un administrador <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-administradores f-25"></i> Sección de Administradores</p>
                            <hr class="linea-morada">                                                        
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="academia" data-order="desc">Academia</th>
                                    <th class="text-center" data-column-id="tipo" data-order="desc">Tipo</th>
                                    <th class="text-center" data-column-id="email" data-order="desc">Correo Electrónico</th>
                                    <th class="text-center" data-column-id="direccion" data-order="desc">Dirección</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($usuarios as $usuario)
                                <?php $id = $usuario->id; ?>

                                @if($usuario->estatus)
                                    <tr id="row_{{$id}}" class="seleccion" >
                                @else
                                    <tr id="row_{{$id}}" class="seleccion seleccion_deleted" >
                                @endif
                                    <td class="text-center previa">{{$usuario->nombre}} {{$usuario->apellido}}</td>
                                    <td class="text-center previa">{{$usuario->nombre_academia}}</td>
                                    <td class="text-center previa">

                                    @if($usuario->usuario_tipo == 1)

                                        Administrador

                                    @elseif($usuario->usuario_tipo == 5)

                                        Sucursal

                                    @elseif($usuario->usuario_tipo == 6)

                                        Recepcionista

                                    @endif</td>
                                    <td class="text-center previa">{{ str_limit($usuario->email, $limit = 30, $end = '...') }}</td>
                                    <td class="text-center previa">{{ str_limit($usuario->direccion, $limit = 40, $end = '...') }}</td>
                                    <td class="text-center disabled"> 
                                        @if($usuario->estatus)
                                            <i name="eliminar" id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i>
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

        route_detalle="{{url('/')}}/configuracion/administradores/detalle";
        route_operacion="{{url('/')}}/configuracion/administradores/operaciones";
        route_deshabilitar="{{url('/')}}/configuracion/administradores/deshabilitar/";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({

                processing: true,
                serverSide: false,
                pageLength: 25,    
                order: [[0, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "disabled" );
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

        $("i[name=eliminar]").click(function(){

            id = this.id;
            element = this;

            swal({   
                title: "Desea eliminar el usuario?",   
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
                    var nTitle="Ups! ";
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                    
                    
                    eliminar(id, element);
                }
            });
        });

        function eliminar(id, element){

            var route = route_deshabilitar + id;
            var token = "{{ csrf_token() }}";
            procesando();
                
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){

                    finprocesado()

                    swal("Hecho!","El usuario ha sido deshabilitado!","success");
                    $(element).closest('tr').addClass('seleccion_deleted');
                    $(element).remove();

                },
                error:function(msj){
                    finprocesado()
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


    </script>
@stop