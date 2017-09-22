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

<div class="modal fade" id="modalReserva" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"><span id="titulo">Titulo</span> <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="form_reserva" id="form_reserva"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" id="reservacion" name="reservacion" value="">
                                       <input type="hidden" name="tipo_usuario_id" value="{{$tipo_usuario_id}}">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img id="imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-9">
                                             
                                            <p class="f-16">Disponible <i class="zmdi zmdi-female f-25 c-rosado"></i> : <span class="f-700 span_mujer"></span></p>

                                            <p class="f-16">Disponible <i class="zmdi zmdi-male-alt f-25 c-azul"></i> : <span class="f-700 span_hombre"></span></p> 

                                            <p class="f-16">Cupos Disponibles Total : <span class="f-700 span_total"></span></p> 

                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>

                                       <div class="row p-t-20 p-b-0">

                                       <hr style="margin-top:5px">

                                       <div class="col-sm-12">

                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Días de reservación</label>
                                        <br></br>

                                        </div>

                                        <div class="form-group">
                                        
                                        <div class="col-sm-3">
                                        <label for="dias_expiracion" id="id-dias_expiracion">El participante tendrá </label>
                                        </div>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control input-sm input-mask" name="dias_expiracion" id="dias_expiracion" data-mask="000" placeholder="Ej. 10">
                                        </div>
                                        <div class="col-sm-8">
                                        <label for="cantidad_sesiones" id="id-cantidad_sesiones">días continuos para sostener su reserva</label>
                                        </div>

                                       </div>

                                       </div></div>

                                       
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
                                          <button type="button" id="guardar" class="btn-blanco btn m-r-10 f-16 guardar" > Guardar</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>


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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-fiesta f-25"></i> Sección de Reservaciones</p>
                            <hr class="linea-morada">                                                           
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="fecha">Fecha de Inicio</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <th class="text-center" data-column-id="dia" data-order="desc">Día</th>
                                    <th class="text-center" data-column-id="cupos_disponibles" data-order="desc">Cupos Disp.</th>
                                    <th class="text-center" data-column-id="disponible_mujer" data-order="desc">Disp. <i class="zmdi zmdi-female f-25 c-rosado"></i></th>
                                    <th class="text-center" data-column-id="disponible_hombre" data-order="desc">Disp. <i class="zmdi zmdi-male-alt f-25 c-azul"></i></th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($actividades as $actividad)
                                <?php $id = $actividad['id']; ?>
                                <tr id="{{$id}}" data-imagen="{{$actividad['imagen']}}" class="seleccion"> 
                                    <td class="text-center previa">{{$actividad['nombre']}}</td>
                                    <td class="text-center previa">{{$actividad['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$actividad['hora_inicio']}} - {{$actividad['hora_final']}}</td>
                                    <td class="text-center previa">{{$actividad['dia_de_semana']}}</td>
                                    <td class="text-center previa">{{$actividad['disponible']}}</td>
                                    <td class="text-center previa">{{$actividad['cantidad_mujeres']}}</td>
                                    <td class="text-center previa">{{$actividad['cantidad_hombres']}}</td>
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

        route_agregar="{{url('/')}}/agendar/reservaciones/agregar";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[1, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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
    var row = $(t).closest('tr');


      var mujer = $(row).find('td').eq(5).html();
      var hombre = $(row).find('td').eq(6).html();
      var total = $(row).find('td').eq(4).html();
      var titulo = $(row).find('td').eq(0).html();
      var imagen = row.data('imagen');
      var id = row.attr('id');

      console.log(id);
      $('.span_mujer').text(mujer)
      $('.span_hombre').text(hombre)
      $('.span_total').text(total)
      $('#titulo').text(titulo)
      $('#imagen').attr('src',imagen)
      $('#reservacion').val(id)
      $("#modalReserva" ).modal('show');

        
      }

      $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#form_reserva" ).serialize(); 
                procesando();       
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
                        $('#dias_expiracion').val('');
                        $('#modalReserva').modal('hide');
                        finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          var row = $('#'+respuesta.reservacion);
                          console.log(respuesta.reservacion)
                          console.log(row)
                          var sexo = respuesta.sexo

                          if(sexo == 'F')
                          {
                            valor = $(row).find('td').eq(5).html();
                            if(valor > 0)
                            {
                              valor_cambio = valor - 1;
                              $(row).find('td').eq(5).html(valor_cambio);
                            }
                            
                          }else{
                            valor = $(row).find('td').eq(6).html();
                            if(valor > 0)
                            {
                              valor_cambio = valor - 1;
                              $(row).find('td').eq(6).html(valor_cambio);
                            }

                          }

                          if(valor > 0)
                          {
                            valor = $(row).find('td').eq(4).html();
                            valor = valor - 1;
                            $(row).find('td').eq(4).html(valor);
                          }

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          finprocesado();

                        }        

                         notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);               
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        // if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
                        // 
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        // if(msj.responseJSON.status=="ERROR"){
                        //   console.log(msj.responseJSON.errores);
                        //   errores(msj.responseJSON.errores);
                        //   var nTitle="    Ups! "; 
                        //   var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        // }else{
                        //   var nTitle="   Ups! "; 
                        //   var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        // }                        
                        finprocesado();
                        $('#modalReserva').modal('hide');
                        // var nFrom = $(this).attr('data-from');
                        // var nAlign = $(this).attr('data-align');
                        // var nIcons = $(this).attr('data-icon');
                        // var nType = 'danger';
                        // var nAnimIn = "animated flipInY";
                        // var nAnimOut = "animated flipOutY";                       
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                      }, 1000);
                    }
                });
            });

      function limpiarMensaje(){
        var campo = ["dias_expiracion"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }


    $('#modalReserva').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#dias_expiracion").val(''); 
    })

    </script>
@stop