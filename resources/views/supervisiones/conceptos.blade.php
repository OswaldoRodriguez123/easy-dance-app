@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/moment/min/moment.min.js"></script>

@stop
@section('content')

    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> <span id="span_agregar"> Agregar</span> Concepto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">                           
                    <div class="row p-t-20 p-b-0">
                        <form name="form_agregar" id="form_agregar"  >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                            <input type="hidden" name="id" id="id" value="{{$id}}">
                            <input type="hidden" name="concepto_id" id="concepto_id">

                            <div class="col-sm-12">
                                
                                <label for="cargo" id="id-procedimiento_id">Concepto a Evaluar</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el concepto a evaluar" title="" data-original-title="Ayuda"></i>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                    <div class="select">
                                        <select class="selectpicker" name="procedimiento_id" id="procedimiento_id" data-live-search="true">
                                            @foreach ( $procedimientos as $procedimiento )
                                                <option value = "{{$procedimiento['id']}}">{{$procedimiento['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="has-error" id="error-procedimiento_id">
                                        <span >
                                            <small class="help-block error-span" id="error-procedimiento_id_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>


                                <label for="fecha" id="id-fecha">Rango de Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define el rango de fecha" title="" data-original-title="Ayuda"></i>

                                  <div class="input-group">
                                  <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                  <div class="fg-line">
                                          <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha">
                                  </div>
                                </div>
                                <div class="has-error" id="error-fecha">
                                    <span >
                                        <small class="help-block error-span" id="error-fecha_mensaje" ></small>
                                    </span>
                                </div>

                                <div class="clearfix p-b-35"></div>
                     
                                <div class="col-sm-6">
            
                                    <label for="cargo" id="id-frecuencia">Frecuencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="Indícale al sistema la frecuencia de de las supervisiones" title="" data-original-title="Ayuda"></i>

                                    <div class="select">
                                        <select class="selectpicker bs-select-hidden" name="frecuencia" id="frecuencia" data-live-search="true" disabled>
                                          <option value="">Selecciona</option>
                                          <option value="1">Semanal</option>
                                          <option value="2">Quincenal</option>
                                          <option value="3">Mensual</option>  
                                        </select>
                                    </div>
                                    <div class="has-error" id="error-frecuencia">
                                        <span >
                                            <small class="help-block error-span" id="error-frecuencia_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                            
                                <div class="clearfix p-b-35"></div>

                                @foreach( $dias_de_semana as $dia)
                                    <div class="col-sm-2">
                                        <input type="text" id="dia_{{$dia->id}}" name="dia_{{$dia->id}}" value="" hidden="hidden">

                                        <span class="f-20 f-700 p-r-10">{{$dia->nombre}}</span>
                                    </div>

                                    <div class="col-sm-10">
                                        <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span>

                                            <input class="frecuencia" id="switch_{{$dia->id}}" data-name="switch_{{$dia->id}}" type="checkbox" hidden="hidden">

                                            <label for="switch_{{$dia->id}}" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                        </div>
                                    </div>

                                    <div class="clearfix p-b-15"></div>
                                @endforeach

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

                            <a style="display:none" class="btn-blanco m-r-5 f-12 pointer" id="actualizar">  Actualizar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <a data-toggle="modal" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
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

                            <span class="f-16 p-t-0 text-success">Agregar un Concepto <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-staff f-25"></i> Sección de Conceptos</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Procedimiento</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Items a Evaluar</th>
                                    <th class="text-center" data-column-id="fecha">Rango de Fecha</th>
                                    <th class="text-center" data-column-id="acciones" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($conceptos as $concepto)

                                <?php $id = $concepto['id']; ?>
                                <tr id="{{$id}}" class="seleccion" data-procedimiento_id="{{$concepto['procedimiento_id']}}">
                                    <td class="text-center previa">{{$concepto['nombre']}}</td>
                                    <td class="text-center previa">{{$concepto['items']}}</td>
                                    <td class="text-center previa">{{$concepto['fecha_inicio']}} / {{$concepto['fecha_final']}}</td>
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
                                                            <a href="{{url('/')}}/supervisiones/agenda/{{$id}}"><i class="zmdi zmdi-eye f-20"></i> Ver Agenda</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/supervisiones/evaluar/{{$id}}"><i class="zmdi icon_a-examen f-20"></i> Evaluar</a>
                                                        </li>

                                                        <li class="hidden-xs">
                                                            <a href="{{url('/')}}/supervisiones/evaluaciones/{{$id}}"><i class="zmdi zmdi-hourglass-alt f-20"></i> Historial</a>
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

        route_eliminar="{{url('/')}}/supervisiones/conceptos/eliminar/";
        route_agregar="{{url('/')}}/supervisiones/conceptos/agregar";
        route_actualizar="{{url('/')}}/supervisiones/conceptos/actualizar";

        frecuencias = $('input[type="checkbox"].frecuencia');
        var pagina = document.location.origin

        var procedimientos = <?php echo json_encode($procedimientos);?>;
        var procedimientos_usados = <?php echo json_encode($procedimientos_usados);?>;

        $(document).ready(function(){

            $.each(procedimientos, function (i, procedimiento) {
                $.each(procedimientos_usados, function (j, id) {
                    if(procedimiento.id == id){
                        $("#procedimiento_id option[value='"+procedimiento.id+"']").attr("disabled","disabled");
                        $("#procedimiento_id option[value='"+procedimiento.id+"']").data("icon","glyphicon-remove");
                    }
                });
            });

            $('#procedimiento_id').selectpicker('refresh')

            $('#fecha').daterangepicker({
                "autoApply" : false,
                "opens": "left",
                "applyClass": "bgm-morado waves-effect",
                locale : {
                    format: 'DD/MM/YYYY',
                    applyLabel : 'Aplicar',
                    cancelLabel : 'Cancelar',
                    daysOfWeek : [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ],
                    monthNames: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],        
                }
            });

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                bInfo: false,
                bLengthChange: false,
                order: [[0, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2)', nRow).attr( "onclick","previa(this)" );
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


        $('#tablelistar tbody').on( 'click', '.eliminar', function () {

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
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;


                        t.row($(element).parents('tr') )
                            .remove()
                            .draw();

                        $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").removeAttr("disabled");
                        $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").data("icon","");
                        $('.selectpicker').selectpicker('refresh')

                        swal("Exito!","La configuración ha sido eliminada!","success");
                        finprocesado();
                    
                    }
                },
                error:function(msj){

                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                }
            });
        }
  
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

        $("#guardar").click(function(){

            procesando();

            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#form_agregar" ).serialize(); 

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

                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").attr("disabled","disabled");
                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").data("icon","glyphicon-remove");
                            $('.selectpicker').selectpicker('refresh')

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje="¡Excelente! El registro se ha actualizado satisfactoriamente";

                            $("#form_agregar")[0].reset();

                            operacion = ''

                            operacion += '<ul class="top-menu">'
                            operacion += '<li id = dropdown_'+respuesta.id+' class="dropdown">' 
                            operacion += '<a id = dropdown_toggle_'+respuesta.id+' href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">' 
                            operacion += '<span class="f-15 f-700" style="color:black">'
                            operacion += '<i class="zmdi zmdi-wrench f-20 mousedefault" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>'
                            operacion += '</span></a>'
                            operacion += '<div class="dropup">'
                            operacion += '<ul class="dropdown-menu dm-icon pull-right" style="position:absolute;">'
                            operacion += '<li class="hidden-xs">'
                            operacion += '<a onclick="procesando()" href="'+pagina+'/supervisiones/agenda/'+respuesta.id+'">'
                            operacion += '<i class="zmdi zmdi-eye f-20 boton blue"></i>'
                            operacion += 'Ver Agenda'
                            operacion += '</a></li>'
                            operacion += '<li class="hidden-xs">'
                            operacion += '<a onclick="procesando()" href="'+pagina+'/supervisiones/evaluar/'+respuesta.id+'">'
                            operacion += '<i class="zmdi icon_a-examen f-20 boton blue"></i>'
                            operacion += 'Evaluar'
                            operacion += '</a></li>'
                            operacion += '<li class="hidden-xs">'
                            operacion += '<a onclick="procesando()" href="'+pagina+'/supervisiones/evaluaciones/'+respuesta.id+'">'
                            operacion += '<i class="zmdi zmdi-hourglass-alt f-20 boton blue"></i>'
                            operacion += 'Historial'
                            operacion += '</a></li>'
                            operacion += '<li class="hidden-xs eliminar"><a class="pointer eliminar">'
                            operacion += '<i class="zmdi zmdi-delete f-20 boton red sa-warning"></i>'
                            operacion += 'Eliminar'
                            operacion += '</a></li>'
                            operacion += '</ul></div></li></ul>'

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                                ''+respuesta.nombre+'',
                                ''+respuesta.cantidad+'',
                                ''+respuesta.fecha+'',
                                ''+operacion+''
                            ] ).draw(false).node();

                            $( rowNode )
                                .attr('id',rowId)
                                .data('procedimiento_id',respuesta.procedimiento_id)
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

        $('.frecuencia').on('change', function(){

            $('#frecuencia').val('');
            checked = false;
            $.each(frecuencias, function (index, array) {
              check = $(array).attr('id');
              explode = check.split('_')
              id = explode[1];
              if ($(array).is(":checked")){
                checked = true
                $('#dia_'+id).val(1);
                $('#frecuencia').removeAttr('disabled');
              }else{
                $('#dia_'+id).val(0);
                if(checked == false){
                  $('#frecuencia').attr('disabled', 'disabled');
                }
              }   
            });


            $('#frecuencia').selectpicker('refresh');

        });

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


        function previa(t){

            var row = $(t).closest('tr');
            var concepto_id = row.attr('id');
            var procedimiento_id = row.data('procedimiento_id');
            var fecha = row.find('td:eq(2)').text();
            fecha = fecha.trim();
            var fecha_explode = fecha.split('/')
            fecha_inicio = moment(fecha_explode[0]).format('DD/MM/YYYY');
            fecha_final = moment(fecha_explode[1]).format('DD/MM/YYYY');

            fecha = fecha_inicio + ' - ' + fecha_final;


            $('#fecha').val(fecha)
            $('#concepto_id').val(concepto_id)
            $('#procedimiento_id').val(procedimiento_id)
            $('.selectpicker').selectpicker('refresh')

            $('#guardar').hide()
            $('#actualizar').show()
            $('#span_agregar').text('Actualizar')
            $('#modalAgregar').modal('show')

        }

        $('#modalAgregar').on('hidden.bs.modal', function () {
            $('#span_agregar').text('Agregar')
            $('#actualizar').hide()
            $('#guardar').show()
        })

        $("#actualizar").click(function(){

            procesando();

            var route = route_actualizar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#form_agregar" ).serialize(); 

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

                            var row = $('#'+respuesta.id).closest('tr');

                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id_anterior+"']").removeAttr("disabled");
                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id_anterior+"']").data("icon","");

                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").attr("disabled","disabled");
                            $("#procedimiento_id option[value='"+respuesta.procedimiento_id+"']").data("icon","glyphicon-remove");

                            row.find('td:eq(0)').text(respuesta.nombre);
                            row.find('td:eq(1)').text(respuesta.cantidad);
                            row.find('td:eq(2)').text(respuesta.fecha);
                            row.data('procedimiento_id',respuesta.procedimiento_id);

                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje="¡Excelente! El registro se ha actualizado satisfactoriamente";

                            $("#form_agregar")[0].reset();
                            $('.selectpicker').selectpicker('refresh')
      
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