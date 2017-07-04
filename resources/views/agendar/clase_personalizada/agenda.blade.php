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
            
            <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Cancelar una clase <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_clase" id="cancelar_clase"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="clasepersonalizada_id" id="clasepersonalizada_id"></input>  
                                       <input type="hidden" name="tipo" id="tipo"></input>
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-9">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                                            <p class="f-16">Fecha: <span class="f-700 span_fecha"></span></p> 

                                            <p class="f-16">Especialidad: <span class="f-700 span_especialidad"></span></p>

                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>

                                       <div class="row p-t-20 p-b-0">

                                       <hr style="margin-top:5px">

                                       <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelar la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                                          </div>
                                        <div class="has-error" id="error-razon_cancelacion">
                                          <span >
                                            <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                                          </span>
                                        </div>
                                      </div>

                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-6 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_clase" id="cancelar_clase" name="cancelar_clase" > Completar la cancelación</button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/clases-personalizadas/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
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

                            <div class="text-right">
                              <span class="f-15">Asignadas: <span id="horas_asignadas">{{$horas_asignadas}}</span> Horas</span><br>
                              <span class="f-15">Restantes: <span id="horas_restantes">{{$horas_restantes}}</span> Horas</span>
                            </div>
  
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada f-25"></i> Clase Personalizada: {{$nombre}}</p>
                            <hr class="linea-morada">

                            <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="activas" value="activas" type="radio">
                                            <i class="input-helper"></i>  
                                            Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="finalizadas" value="finalizadas" type="radio" checked >
                                            <i class="input-helper"></i>  
                                            Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="canceladas" value="canceladas" type="radio" checked >
                                            <i class="input-helper"></i>  
                                            Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-close zmdi-hc-fw f-20"></i>
                                        </label>
                                    </div>
                                    
                                </div>
                            </div> 

                            <div class="clearfix"></div>                                                                           
                        </div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="horario" data-order="desc">Horario</th>
                                    <th class="text-center" data-column-id="horas" data-order="desc">Cantidad Horas</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="operaciones" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($activas as $fecha)
                                <tr id="{{$fecha['id']}}" class="disabled" data-instructor="{{$fecha['instructor']}}" data-especialidad="{{$fecha['especialidad']}}" data-fecha="{{$fecha['fecha_inicio']}}" data-hora="{{$fecha['hora_inicio']}} - {{$fecha['hora_final']}}" data-tipo="{{$fecha['tipo']}}">
                                    <td class="text-center previa">{{$fecha['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$fecha['hora_inicio']}} - {{$fecha['hora_final']}}</td>
                                    <td class="text-center previa">{{$fecha['hora_asignada']}}</td>
                                    <td class="text-center previa">{{$fecha['especialidad']}}</td>
                                    <td class="text-center previa">{{$fecha['instructor']}}</td>
                                    <td class="text-center previa">
                                        <i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer acciones c-youtube" data-original-title="Cancelar Clase" data-toggle="tooltip" data-placement="bottom" title=""></i>
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

    route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones/";
    route_cancelar="{{url('/')}}/agendar/clases-personalizadas/cancelar";
    route_cancelarpermitir="{{url('/')}}/agendar/clases-personalizadas/cancelarpermitir";

    var finalizadas = <?php echo json_encode($finalizadas);?>;
    var activas = <?php echo json_encode($activas);?>;
    var canceladas = <?php echo json_encode($canceladas);?>;

    $(document).ready(function(){

        $("#activas").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "disabled" );
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

    $("#activas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#canceladas2" ).removeClass( "c-verde" );
        $( "#activas2" ).addClass( "c-verde" );

    });
    $("#canceladas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
        $( "#canceladas2" ).addClass( "c-verde" );
    });
    $("#finalizadas").click(function(){
        $( "#finalizadas2" ).addClass( "c-verde" );
        $( "#canceladas2" ).removeClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
    });


     function rechargeActivas(){

            $.each(activas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.hora_asignada+'',
                ''+array.especialidad+'',
                ''+array.instructor+'' ,
                '<i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer acciones c-youtube" data-original-title="Cancelar Clase" data-toggle="tooltip" data-placement="bottom" title=""></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .attr('id', array.id)
                    .attr('data-tipo', array.tipo)
                    .attr('data-instructor', array.instructor)
                    .attr('data-especialidad', array.especialidad)
                    .attr('data-fecha', array.fecha_inicio)
                    .attr('data-hora', array.hora_inicio + ' - ' + array.hora_final);
            });
        }

        function rechargeFinalizadas(){

            $.each(finalizadas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.hora_asignada+'',
                ''+array.especialidad+'',
                ''+array.instructor+'' ,
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .addClass('seleccion_deleted')
                    .attr('id', array.id)
                    .attr('data-tipo', array.tipo)
                    .attr('data-instructor', array.instructor)
                    .attr('data-especialidad', array.especialidad)
                    .attr('data-fecha', array.fecha_inicio)
                    .attr('data-hora', array.hora_inicio + ' - ' + array.hora_final);
            });
        }

        function rechargeCanceladas(){

            $.each(canceladas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                ''+array.hora_asignada+'',
                ''+array.especialidad+'',
                ''+array.instructor+'' ,
                ''
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .addClass('seleccion_deleted')
                    .attr('id', array.id)
                    .attr('data-tipo', array.tipo)
                    .attr('data-instructor', array.instructor)
                    .attr('data-especialidad', array.especialidad)
                    .attr('data-fecha', array.fecha_inicio)
                    .attr('data-hora', array.hora_inicio + ' - ' + array.hora_final);
            });
        }

        function clear(){

            t.clear().draw();
        }

        $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                tipo = 'activas';
                rechargeActivas();
            } else if($(this).val()=='finalizadas')  {
                tipo= 'finalizadas';
                rechargeFinalizadas();
            }else if($(this).val()=='canceladas')  {
                tipo= 'canceladas';
                rechargeCanceladas();
            }
         });

        $(".cancelar_clase").click(function(){

        var id = $('#id').val();
    
        swal({   
                    title: "Desea cancelar la clase personalizada",   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
        if (isConfirm) {
        procesando();
        var route = route_cancelar;
        var token = '{{ csrf_token() }}';
        var datos = $( "#cancelar_clase" ).serialize(); 

        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        var cancelada = $.grep(activas, function(e){ return e.id == respuesta.id; });

                        canceladas.push(cancelada[0]);

                        indexes = $.map(activas, function(obj, index) {
                            if(obj.id == respuesta.id){
                                activas.splice( $.inArray(activas[index], activas), 1 );

                                t.row( $('#'+respuesta.id) )
                                    .remove()
                                    .draw();
                            }
                        })
                      
                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje=respuesta.mensaje;

                      finprocesado();
                      $('#modalCancelar').modal('hide');
                      notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    },
                    error:function(msj){
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    $(".modal").modal('hide');
                    finprocesado();
                    swal({ 
                    title: 'El estatus de esta clase es de "cancelación tardía", al cancelarla de igual manera será debitada económicamente al participante. ¿ Desea proceder ?',   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true,
                    html: true
                }, function(isConfirm){   
                  if (isConfirm) {
                    procesando();
                    var route = route_cancelarpermitir;

                    $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        var cancelada = $.grep(activas, function(e){ return e.id == respuesta.id; });

                        canceladas.push(cancelada[0]);

                        indexes = $.map(activas, function(obj, index) {
                            if(obj.id == respuesta.id){
                                activas.splice( $.inArray(activas[index], activas), 1 );

                                t.row( $('#'+respuesta.id) )
                                    .remove()
                                    .draw();
                            }
                        }) 

                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        finprocesado();
                        $('#modalCancelar').modal('hide');
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                    },
                    error:function(msj){

                            if (typeof msj.responseJSON === "undefined") {
                                window.location = "{{url('/')}}/error";
                             }


    
                            }
                        });
                    }
                });
             }
         });
        }
      });
    });

    $('#tablelistar tbody').on( 'click', 'i.zmdi-close-circle-o', function () {
        var row = $(this).closest('tr');
        var id = row.attr('id');
        var tipo = row.data('tipo');
        var fecha = row.data('fecha');
        var hora = row.data('hora');
        var instructor = row.data('instructor');
        var especialidad = row.data('especialidad');
        $('.span_fecha').text(fecha)
        $('.span_hora').text(hora)
        $('.span_instructor').text(instructor)
        $('.span_especialidad').text(especialidad)
        $('#clasepersonalizada_id').val(id)
        $('#tipo').val(tipo)
        $("#modalCancelar" ).modal('show');
    });

    </script>
@stop