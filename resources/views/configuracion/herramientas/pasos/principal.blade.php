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

    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar Paso<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">                           
                    <div class="row p-t-20 p-b-0">
                        <form name="form_agregar" id="form_agregar"  >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
           
                            <div class="col-sm-12">
                                
                                <label for="nombre" id="id-nombre">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del paso" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-tutoriales f-22"></i></span>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Dile que no">
                                    </div>
                                </div>
                                <div class="has-error" id="error-nombre">
                                    <span >
                                        <small class="help-block error-span" id="error-nombre_mensaje" ></small>                               
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>

                            
                                <label for="fecha_cobro" id="id-especialidad_id">Especialidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de diversas especialidades" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                  <span class="input-group-addon"><i class="icon_a icon_a-especialidad f-22"></i></span>
                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" name="especialidad_id" id="especialidad_id" data-live-search="true" onchange="porcentaje" >

                                      <option value="">Selecciona</option>
                                      @foreach ( $config_especialidades as $especialidades )
                                      <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                      @endforeach
                                    
                                    </select>
                                  </div>
                                </div>
                                <div class="has-error" id="error-especialidad_id">
                                  <span >
                                    <small class="help-block error-span" id="error-especialidad_id_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>
                           
                               <div class="clearfix p-b-35"></div>

                                
                              <label for="ciclo" id="id-ciclo">Ciclo</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-nivel" id = "pop-nivel" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Seleccione el ciclo" title="" data-original-title="Ayuda" data-html="true"></i>


                                 <div class="input-group">
                                  <span class="input-group-addon"><i class="icon_a-niveles f-22"></i></span>
                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" name="nivel_id" id="nivel_id" data-live-search="true">

                                      <option value="">Selecciona</option>
                                      @foreach ( $config_niveles as $niveles )
                                      <option value = "{{ $niveles['id'] }}">{{ $niveles['nombre'] }}</option>
                                      @endforeach

                                    </select>
                                  </div>
                                </div>
                                <div class="has-error" id="error-nivel_id">
                                  <span >
                                    <small class="help-block error-span" id="error-nivel_id_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                                <label for="nivel_id" id="id-nivel_id">Nivel de baile</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-nivel" id = "pop-nivel" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selección de distintos niveles, en caso que desees asignar uno nuevo, debes dirigirte a la sección de configuración general y personalizar nuevos niveles" title="" data-original-title="Ayuda" data-html="true"></i>

                                 <div class="input-group">
                                  <span class="input-group-addon"><i class="icon_a-niveles f-22"></i></span>
                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" name="ciclo" id="ciclo" data-live-search="true">

                                      <option value="">Selecciona</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      

                                    </select>
                                  </div>
                                </div>
                                <div class="has-error" id="error-ciclo">
                                  <span >
                                    <small class="help-block error-span" id="error-ciclo_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <label for="id" id="id-link_video">Ingresa el link del video</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el link del video" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa el link">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-link_video">
                                    <span >
                                     <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
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

                          <a class="btn-blanco m-r-5 f-12 pointer" id="guardar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <a data-toggle="modal" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/herramientas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Herramientas</a>
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

                            <span class="f-16 p-t-0 text-success">Agregar un Paso <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-tutoriales f-25"></i> Sección de Pasos</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Ciclo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nivel</th>
                                    <th class="text-center" data-column-id="acciones" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($pasos as $paso)
                                <?php $id = $paso->id; ?>
                                <tr id="{{$id}}" class="seleccion">
                                    <td class="text-center previa">{{$paso->nombre}}</td>
                                    <td class="text-center previa">{{$paso->especialidad}}</td>
                                    <td class="text-center previa">{{$paso->nivel}}</td>
                                    <td class="text-center previa">{{$paso->ciclo}}</td>
                                    <td class="text-center disabled"> <i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i></td>
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

        route_agregar = "{{url('/')}}/configuracion/herramientas/pasos/agregar";
        route_eliminar = "{{url('/')}}/configuracion/herramientas/pasos/eliminar/";

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
        });


        $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

            var id = $(this).closest('tr').attr('id');
            element = this;

            swal({   
                title: "Desea eliminar el paso?",   
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

                        swal("Exito!","El paso ha sido eliminado!","success");
                        finprocesado();
                        
                        }
                    },
                    error:function(msj){
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
        }

        $("#guardar").click(function(){

            procesando();

            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $('#form_agregar').serialize()

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

                            $('#form_agregar')[0].reset()
                            $('.selectpicker').selectpicker('refresh')
                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje="¡Excelente! El registro se ha guardado satisfactoriamente";

                            var rowId=respuesta.paso.id;
                            var rowNode=t.row.add( [
                                ''+respuesta.paso.nombre+'',
                                ''+respuesta.especialidad+'',
                                ''+respuesta.nivel+'',
                                ''+respuesta.paso.ciclo+'',
                                '<i class="zmdi zmdi-delete boton red f-20 p-r-10 pointer"></i>'
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id',rowId)
                                .addClass('disabled');
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

        function limpiarMensaje(){
            var campo = ["nombre", "especialidad_id", "nivel_id", "ciclo", "link_video"];
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

    </script>
@stop