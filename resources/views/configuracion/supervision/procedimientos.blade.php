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

    <div class="modal fade" id="modalSession" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar Procedimiento<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">                           
                    <div class="row p-t-20 p-b-0">
                        <form name="form_session" id="form_session"  >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                            <input type="hidden" name="id" value="{{$id}}">            
                            <div class="col-sm-12">
                                
                                <label for="procedimiento_session" id="id-procedimiento_session">Procedimiento</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del Procedimiento" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="procedimiento_session" id="procedimiento_session" placeholder="Ej. Cierre de Caja">
                                    </div>
                                </div>
                                <div class="has-error" id="error-procedimiento_session">
                                    <span >
                                        <small class="help-block error-span" id="error-procedimiento_session_mensaje" ></small>                               
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <label for="item_session" id="id-item_session">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del item de supervision que deseas agregar al procedimiento" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="item_session" id="item_session" placeholder="Ej. Asistencia">
                                    </div>
                                </div>
                                <div class="has-error" id="error-item_session">
                                    <span >
                                        <small class="help-block error-span" id="error-item_session_mensaje" ></small>                               
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="card-header text-left">
                                    <button type="button" class="btn btn-blanco m-r-10 f-10" name= "add_session" id="add_session" > Agregar Linea</button>
                                </div>

                            </div>

                            <div class="clearfix p-b-35"></div>

                            <div class="table-responsive row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered text-center " id="tablesession" >
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-column-id="nombre"></th>
                                                <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                      
                <div class="clearfix p-b-35"></div>

                <div class="clearfix"></div> 
                <div class="modal-footer p-b-20 m-b-20">
                    <div class="col-sm-12 text-left">
                        <div class="procesando hidden">
                            <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                            <div class="preloader pls-purple">
                                <svg class="pl-circular" viewBox="25 25 50 50">
                                    <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">                            

                          <a class="btn-blanco m-r-5 f-12 pointer" id="save_session">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFijo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Procedimiento<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">                           
                    <div class="row p-t-20 p-b-0">
                        <form name="form_fijo" id="form_fijo"  >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                            <input type="hidden" id="procedimiento_id" name="procedimiento_id">            
                            <div class="col-sm-12">
                                
                                <label for="procedimiento_fijo" id="id-procedimiento_fijo">Procedimiento</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del Procedimiento" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="procedimiento_fijo" id="procedimiento_fijo" placeholder="Ej. Cierre de Caja">
                                    </div>
                                </div>
                                <div class="has-error" id="error-procedimiento_fijo">
                                    <span >
                                        <small class="help-block error-span" id="error-procedimiento_fijo_mensaje" ></small>                               
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <label for="item_fijo" id="id-item_fijo">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del item de supervision que deseas agregar al procedimiento" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="item_fijo" id="item_fijo" placeholder="Ej. Asistencia">
                                    </div>
                                </div>
                                <div class="has-error" id="error-item_fijo">
                                    <span >
                                        <small class="help-block error-span" id="error-item_fijo_mensaje" ></small>                               
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>

                                <div class="card-header text-left">
                                    <button type="button" class="btn btn-blanco m-r-10 f-10" name= "add_fijo" id="add_fijo" > Agregar Linea</button>
                                </div>

                            </div>

                            <div class="clearfix p-b-35"></div>

                            <div class="table-responsive row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered text-center " id="tablefijo" >
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-column-id="nombre"></th>
                                                <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                      
                <div class="clearfix p-b-35"></div>

                <div class="clearfix"></div> 
                <div class="modal-footer p-b-20 m-b-20">
                    <div class="col-sm-12 text-left">
                        <div class="procesando hidden">
                            <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                            <div class="preloader pls-purple">
                                <svg class="pl-circular" viewBox="25 25 50 50">
                                    <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">                            

                          <a class="btn-blanco m-r-5 f-12 pointer" id="save_fijo">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <a data-toggle="modal" href="#modalSession" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/configuracion/supervisiones/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
    
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <span class="f-16 p-t-0 text-success">Agregar un Procedimiento <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-staff f-25"></i> Sección de Procedimientos</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Procedimiento</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Items a Evaluar</th>
                                    <th class="text-center" data-column-id="acciones" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($procedimientos as $procedimiento)

                                <?php $id = $procedimiento['id']; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa">{{$procedimiento['nombre']}}</td>
                                    <td class="text-center previa">{{$procedimiento['items']}}</td>
                                    <td class="text-center disabled"> <i class="zmdi zmdi-delete f-20 p-r-10 pointer acciones"></i></td>
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

        route_eliminar="{{url('/')}}/eliminar_procedimiento/";

        route_agregar_session = "{{url('/')}}/agregar_procedimiento_session";
        route_eliminar_session = "{{url('/')}}/eliminar_procedimiento_session/";

        route_agregar_fijo = "{{url('/')}}/agregar_procedimiento_fijo";
        route_eliminar_fijo = "{{url('/')}}/eliminar_procedimiento_fijo/";

        route_agregar="{{url('/')}}/guardar_procedimiento";
        route_update="{{url('/')}}/actualizar_procedimiento";
        route_consultar_items = "{{url('/')}}/consultar_items_procedimientos/";
 
        $(document).ready(function(){
            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                bInfo: false,
                bLengthChange: false,
                order: [[0, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1)', nRow).attr( "onclick","previa(this)" );
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

            s=$('#tablesession').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                bInfo: false,
                bLengthChange: false,
                order: [[0, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "text-center" );
                    $('td:eq(0)', nRow).addClass( "disabled" );
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

            f=$('#tablefijo').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                bInfo: false,
                bLengthChange: false,
                order: [[0, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "text-center" );
                    $('td:eq(0)', nRow).addClass( "disabled" );
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


        $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea eliminar la configuracion?",   
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
                        
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
         procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          // finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          t.row( $(element).parents('tr') )
                            .remove()
                            .draw();

                        swal("Exito!","La configuración ha sido eliminada!","success");
                        finprocesado();
                        
                        }
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
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
        }

        function previa(t){

            procesando();

            $("#form_fijo")[0].reset();

            f
            .clear()
            .draw();

            var id = $(t).closest('tr').attr('id');
            $('#procedimiento_id').val(id)
            var nombre = $(t).closest('tr').find('td:eq(0)').text();
            $('#procedimiento_fijo').val(nombre);
            var token = $('input:hidden[name=_token]').val();
            var route = route_consultar_items + id

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                success:function(respuesta){
                    setTimeout(function(){ 

                        $.each(respuesta.array, function (index, array) {
                            var rowId=array.id;
                            var rowNode=f.row.add( [
                                ''+array.nombre+'',
                                '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id','fijo_'+rowId)
                                .addClass('seleccion');
                        });
                    });
                },error:function(msj){
                    setTimeout(function(){ 
                      // if (typeof msj.responseJSON === "undefined") {
                      //   window.location = "{{url('/')}}/error";
                      // }
                        if(msj.responseJSON.status=="ERROR"){
                            errores(msj.responseJSON.errores);
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        finprocesado();
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                }
            })

            finprocesado();
            $('#modalFijo').modal('show')
        }

        $("#add_session").click(function(){

            var datos = $( "#form_session" ).serialize(); 
            $("#add_session").attr("disabled","disabled");
            $("#add_session").css({
                "opacity": ("0.2")
            });
            var route = route_agregar_session
            var token = $('input:hidden[name=_token]').val();
            limpiarMensaje();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: datos ,
                success:function(respuesta){
                    setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;


                            var rowId=respuesta.array.id;
                            var rowNode=s.row.add( [
                                ''+respuesta.array.nombre+'',
                                '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id','session_'+rowId)
                                .addClass('seleccion');

                            $('#item_session').val('')

                        }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                        }                       

                        $("#add_session").removeAttr("disabled");
                        $("#add_session").css({
                            "opacity": ("1")
                        });


                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }, 1000);
                },
                error:function(msj){
                    setTimeout(function(){ 
                      // if (typeof msj.responseJSON === "undefined") {
                      //   window.location = "{{url('/')}}/error";
                      // }
                        if(msj.responseJSON.status=="ERROR"){
                            errores(msj.responseJSON.errores);
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#add_session").removeAttr("disabled");
                        $("#add_session").css({
                            "opacity": ("1")
                        });
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                }
            });
        });

        $('#tablesession tbody').on( 'click', 'i.zmdi-delete', function () {
            var padre=$(this).parents('tr');
            var token = $('input:hidden[name=_token]').val();
            var row = $(this).closest('tr').attr('id');
            var explode = row.split('_');
            var id = explode[1]
            swal({   
                title: "Desea eliminar este item?",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
                if (isConfirm) {
                    $.ajax({
                        url: route_eliminar_session+id,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',                
                        success: function (data) {
                            if(data.status=='OK'){

                                var nFrom = $(this).attr('data-from');
                                var nAlign = $(this).attr('data-align');
                                var nIcons = $(this).attr('data-icon');
                                var nAnimIn = "animated flipInY";
                                var nAnimOut = "animated flipOutY"; 
                                var nType = 'success';
                                var nTitle="Ups! ";
                                var nMensaje="¡Excelente! Los campos se han eliminado satisfactoriamente";

                                s.row(padre)
                                    .remove()
                                    .draw();              
                            }else{
                              swal(
                                'Solicitud no procesada',
                                'Ha ocurrido un error, intente nuevamente por favor',
                                'error'
                              );
                            }
                          },
                        error:function (xhr, ajaxOptions, thrownError){
                            swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                        }
                    })
                }
            });
        });

        $("#save_session").click(function(){

            procesando();

            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#form_session" ).serialize(); 

            limpiarMensaje();

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:datos,
                success:function(respuesta){
                    setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje="¡Excelente! El registro se ha guardado satisfactoriamente";

                            $("#form_session")[0].reset();

                            s
                            .clear()
                            .draw();

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                                ''+respuesta.nombre+'',
                                ''+respuesta.cantidad+'',
                                '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id',rowId)
                                .addClass('seleccion');
                            finprocesado();
                            
                            $('.modal').modal('hide')
                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';

                            finprocesado();

                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                    
                    }, 1000);
                },
                error:function(msj){
                    setTimeout(function(){ 
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }
                        if(msj.responseJSON.status=="ERROR"){
                            console.log(msj.responseJSON.errores);
                            errores(msj.responseJSON.errores);
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        finprocesado();
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                }
            });
        });

        $("#add_fijo").click(function(){

            var datos = $( "#form_fijo" ).serialize(); 
            $("#add_fijo").attr("disabled","disabled");
            $("#add_fijo").css({
                "opacity": ("0.2")
            });
            var route = route_agregar_fijo
            var token = $('input:hidden[name=_token]').val();
            limpiarMensaje();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: datos ,
                success:function(respuesta){
                    setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;


                            var rowId=respuesta.array.id;
                            var rowNode=f.row.add( [
                                ''+respuesta.array.nombre+'',
                                '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id','fijo_'+rowId)
                                .addClass('seleccion');

                            $('#item_fijo').val('')

                            var column = $("#"+respuesta.array.procedimiento_id).closest('tr').find('td:eq(1)')
                            var cantidad = column.text();
                            cantidad_nueva = parseInt(cantidad) + 1;
                            column.text(cantidad_nueva);

                        }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                        }                       

                        $("#add_fijo").removeAttr("disabled");
                        $("#add_fijo").css({
                            "opacity": ("1")
                        });


                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                    }, 1000);
                },
                error:function(msj){
                    setTimeout(function(){ 
                      // if (typeof msj.responseJSON === "undefined") {
                      //   window.location = "{{url('/')}}/error";
                      // }
                        if(msj.responseJSON.status=="ERROR"){
                            errores(msj.responseJSON.errores);
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#add_fijo").removeAttr("disabled");
                        $("#add_fijo").css({
                            "opacity": ("1")
                        });
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                }
            });
        });

        $('#tablefijo tbody').on( 'click', 'i.zmdi-delete', function () {
            var padre=$(this).parents('tr');
            var token = $('input:hidden[name=_token]').val();
            var row = $(this).closest('tr').attr('id');
            var explode = row.split('_');
            var id = explode[1]
            swal({   
                title: "Desea eliminar la configuracion?",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
                if (isConfirm) {
                    procesando();
                    $.ajax({
                        url: route_eliminar_fijo+id,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',                
                        success: function (data) {
                            if(data.status=='OK'){

                                var nFrom = $(this).attr('data-from');
                                var nAlign = $(this).attr('data-align');
                                var nIcons = $(this).attr('data-icon');
                                var nAnimIn = "animated flipInY";
                                var nAnimOut = "animated flipOutY"; 
                                var nType = 'success';
                                var nTitle="Ups! ";
                                var nMensaje="¡Excelente! Los campos se han eliminado satisfactoriamente";
                                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                                procedimiento_id = $('#procedimiento_id').val();

                                f.row(padre)
                                    .remove()
                                    .draw();    

                                var column = $("#"+procedimiento_id).closest('tr').find('td:eq(1)')
                                var cantidad = column.text();
                                cantidad_nueva = parseInt(cantidad) - 1;
                                column.text(cantidad_nueva);   
                                finprocesado();   

                            }else{
                              swal(
                                'Solicitud no procesada',
                                'Ha ocurrido un error, intente nuevamente por favor',
                                'error'
                              );
                            }
                          },
                        error:function (xhr, ajaxOptions, thrownError){
                            swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                        }
                    })
                }
            });
        });

        function limpiarMensaje(){
            var campo = ["procedimiento_session", "item_session"];
            fLen = campo.length;
            for (i = 0; i < fLen; i++) {
                $("#error-"+campo[i]+"_mensaje").html('');
            }
        }

        function errores(merror){
            $.each(merror, function (n, c) {
                $.each(this, function (name, value) {
                    var error=value;
                    $("#error-"+n+"_mensaje").html(error);
                });
            });
        }

        $("#save_fijo").click(function(){

            procesando();

            var route = route_update;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#form_fijo" ).serialize(); 

            limpiarMensaje();

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:datos,
                success:function(respuesta){
                    setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje="¡Excelente! El registro se ha actualizado satisfactoriamente";

                            $("#form_fijo")[0].reset();

                            f
                            .clear()
                            .draw();

                            $("#"+respuesta.id).closest('tr').find('td:eq(0)').text(respuesta.nombre);
      
                            finprocesado();
                            
                            $('.modal').modal('hide')
                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';

                            finprocesado();

                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                    
                    }, 1000);
                },
                error:function(msj){
                    setTimeout(function(){ 
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }
                        if(msj.responseJSON.status=="ERROR"){
                            console.log(msj.responseJSON.errores);
                            errores(msj.responseJSON.errores);
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                            var nTitle="   Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        finprocesado();
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                    }, 1000);
                }
            });
        });

    </script>
@stop