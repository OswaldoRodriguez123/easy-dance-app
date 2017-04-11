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
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop
@section('content')

        <div class="modal fade" id="modalCongelar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                        <h4 class="modal-title c-negro"> Congelar un alumno <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                    </div>
                    <form name="congelar_alumno" id="congelar_alumno"  >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="inscripcion_clase_grupal_id" id="inscripcion_clase_grupal_id"></input>  
                       <div class="modal-body">                           
                       <div class="row p-t-20 p-b-0">

                           <div class="col-sm-3">

                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                <div class="clearfix p-b-15"></div>

                                <span class="f-15 f-700 span_alumno"></span>

                                  
                           </div>

                       <div class="col-sm-9">
                 
                        <label for="razon_cancelacion" id="id-razon_congelacion">Razones de congelar el alumno</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás congelando al alumno" title="" data-original-title="Ayuda"></i>
                        <br></br>

                        <div class="fg-line">
                          <textarea class="form-control" id="razon_congelacion" name="razon_congelacion" rows="2" placeholder="Ej. No podré asistir por razones ajenas a mi voluntad"></textarea>
                          </div>
                        <div class="has-error" id="error-razon_congelacion">
                          <span >
                            <small class="help-block error-span" id="error-razon_congelacion_mensaje" ></small>                                           
                          </span>
                        </div>
                      </div>


                      <div class="col-sm-9">
                        <div class="form-group">
                            <div class="form-group fg-line">
                            <label for="fecha_inicio">Fecha</label>
                            <div class="fg-line">
                                <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha">
                            </div>
                         </div>
                            <div class="has-error" id="error-fecha">
                              <span >
                                  <small id="error-fecha_mensaje" class="help-block error-span" ></small>                                           
                              </span>
                            </div>
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
                          <button type="button" class="btn-blanco btn m-r-10 f-16" id="congelar" name="congelar" > Completar la congelación</button>
                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                        </div>
                    </div></form>
                </div>
            </div>
        </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Alumno</a>
                        
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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-mood-bad zmdi-hc-fw f-25"></i> Bandeja Inactivos</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha">Fecha de Inactividad</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="clase_grupal">Clase Grupal</th>
                                    <th class="text-center" data-column-id="estatu_e">Balance E</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos as $alumno)
                                <?php $id = $alumno->inscripcion_id; ?>
                                <tr id="{{$id}}" class="seleccion" data-nombre="{{$alumno->nombre}} {{$alumno->apellido}}">
                                    <td class="text-center disabled">{{$alumno->deleted_at}}</td>
                                    <td class="text-center disabled">{{$alumno->identificacion}}</td>
                                    <td class="text-center disabled">
                                    @if($alumno->sexo=='F')
                                    <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                    @else
                                    <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                    @endif
                                    </td>
                                    <td class="text-center disabled">{{$alumno->nombre}} {{$alumno->apellido}}</td>
                                    <td class="text-center">{{$alumno->clase_grupal_nombre}}</td>
                                    <td class="text-center disabled">
                                    <i data-toggle="modal" href="#" class="zmdi zmdi-money {{ isset($deuda[$id]) ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3 operacionModal"></i>
                                    </td>
                                    
                                    <td class="text-center disabled"> 

                                        <i class="zmdi zmdi-close-circle-o f-20 p-r-10 pointer congelar_alumno" id="{{$id}}" name="congelar_alumno" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Congelar Alumno" title="" data-original-title=""></i>

                                        <i class="zmdi zmdi-delete f-20 p-r-10 pointer acciones" id="{{$id}}" name="eliminar" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Eliminar Permanentemente" title="" data-original-title=""></i>
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

        route_operacion="{{url('/')}}/participante/alumno/operaciones";
        route_restablecer="{{url('/')}}/participante/alumno/activar/";
        route_eliminar="{{url('/')}}/participante/alumno/eliminar-inscripcion/";
        route_congelar="{{url('/')}}/agendar/clases-grupales/congelar-alumno";

        $(document).ready(function(){

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
        order: [[0, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

            });

        
      $("i[name=eliminar").click(function(){
                id = this.id;
                element = this;
                var padre=$(this).parents('tr');
                swal({   
                    title: "Desea eliminar la inscripción permanentemente?",   
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        t.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        swal("Exito!","La inscripción ha sido eliminada permanentemente!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
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

      $(".congelar_alumno").on('click', function(){

            var id = $(this).closest('tr').attr('id');
            var nombre = $(this).closest('tr').data('nombre');

            $('#inscripcion_clase_grupal_id').val(id);
            $('.span_alumno').text(nombre);
            
            $('#modalCongelar').modal('show');

        });

      $("#congelar").click(function(){
            swal({   
                    title: "¿Seguro deseas congelar al alumno ?",   
                    text: "Confirmar la congelación",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, congelar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_congelar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#congelar_alumno" ).serialize(); 
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          row = $('#'+respuesta.id)
                          
                          t.row($(row))
                            .remove()
                            .draw();

                          finprocesado();
                          $('#modalCongelar').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
              }
            });
        });

        function limpiarMensaje(){
            var campo = ["fecha", "razon_congelacion"];
            fLen = campo.length;
            for (i = 0; i < fLen; i++) {
                $("#error-"+campo[i]+"_mensaje").html('');
            }
      }



        </script>

@stop