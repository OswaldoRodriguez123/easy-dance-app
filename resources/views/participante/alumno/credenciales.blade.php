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

            <a data-toggle="modal" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

            <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_agregar" id="form_agregar"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <div class="modal-body">                           
                          <div class="row p-t-20 p-b-0">

                          @if(isset($id))
                            <input type="hidden" name="alumno_id" value="{{$id}}"></input>
                          @else

                            <div class="col-sm-12">
                                <label for="alumno_id" id="id-alumno_id">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> 

                                 <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un alumno" title="" data-original-title="Ayuda"></i>

                                 <div class="input-group">
                                  <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona" data-live-search="true">

                                     @foreach ( $alumnos as $alumno )
                                      <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="has-error" id="error-alumno_id">
                                  <span >
                                    <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>
                           </div>

                           <div class="clearfix p-b-20"></div>
                          @endif

                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-instructor_id">Instructor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el instructor" title="" data-original-title="Ayuda" data-html="true"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{$instructor['id'] }}">{{$instructor['nombre'] }} {{$instructor['apellido'] }}</option>
                                          @endforeach 
                                          
                                        
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-instructor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-20"></div>

                               <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="cantidad">Ingresa la cantidad de credenciales</label>
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="0000000" placeholder="Ej: 50">
                                      </div>
                                 </div>
                                 <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                             </div>

                                <div class="clearfix p-b-20"></div> 


                                 <div class="col-sm-12">
                                   <div class="form-group">
                                      <label for="dias_vencimiento">Días de caducidad</label>
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="dias_vencimiento" id="dias_vencimiento" data-mask="0000000" placeholder="Ej: 25">
                                      </div>
                                   </div>
                                   <div class="has-error" id="error-dias_vencimiento">
                                        <span >
                                            <small class="help-block error-span" id="error-dias_vencimiento_mensaje"  ></small>                                           
                                        </span>
                                    </div>
                                 </div>
                               </div>

                       
                               <div class="clearfix p-b-35"></div>

                               
                           </div>
                        </div>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" name="guardar" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        @if(isset($id))
                          <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @else
                          <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/"><i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @endif

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
 
                                <span class="f-16 p-t-0 text-success">Agregar Credenciales<i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            </div>
                              
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-plus-circle-o f-25"></i> Sección de Credenciales</p>
                            <hr class="linea-morada">

                            <div class="col-sm-12">
                                <div class="p-t-10 pull-right">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="Activa" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="Vencida" type="radio">
                                        <i class="input-helper"></i>  
                                        Vencidas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                </div>
                            </div>


                            <div class="clearfix"></div>

                            @if(isset($id))
                              <span class ="f-700 f-16 opaco-0-8">Total : <span id="total">{{ $total }}</span></span>
                            @endif
                         
                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    @if(!isset($id))
                                      <th class="text-center" data-column-id="alumno">Alumno</th>
                                    @endif
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="cantidad" data-order="desc">Cantidad</th>
                                    <th class="text-center" data-column-id="fecha_vencimiento">Fecha Expiración</th>
                                    <th class="text-center" data-column-id="status" data-type="numeric">Status</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($credenciales as $credencial)
                                <?php $credencial_id = $credencial['id']; ?>
             
                                <tr id="{{$credencial_id}}" class="seleccion">
                                    
                                    @if(!isset($id))
                                      <td class="text-center previa">
                                        {{$credencial['alumno_nombre']}} {{$credencial['alumno_apellido']}}
                                      </td>
                                    @endif
                                    <td class="text-center previa">{{$credencial['instructor_nombre']}} {{$credencial['instructor_apellido']}}</td>
                                    <td class="text-center previa">{{$credencial['cantidad']}}</td>
                                    <td class="text-center previa">{{$credencial['fecha_vencimiento']}}</td>
                                    <td class="text-center previa">
                                        <span class="{{ empty($credencial['dias_restantes']) ? 'c-youtube' : '' }}">{{$credencial['status']}}</span>
                                        Restan {{$credencial['dias_restantes']}} Días
                                    </td>
                                    <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$credencial_id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i></td>
                        
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

        route_agregar="{{url('/')}}/participante/alumno/credenciales/agregar";
        route_eliminar="{{url('/')}}/participante/alumno/credenciales/eliminar/";


        @if(isset($id))
          order = 2
          column = 3

        @else
          order = 3
          column = 4

        @endif


        $(document).ready(function(){

          total = parseInt("{{{$total or 0}}}")

          t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,    
          order: [[order, 'asc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
            // $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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
            .columns(column)
            .search('Activa')
            .draw();
    
          
        });

        $("#guardar").click(function(){

            var datos = $( "#form_agregar" ).serialize(); 
            procesando();
            var route = route_agregar;
            var token = $('input:hidden[name=_token]').val();
            var datos = datos;
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

                      var instructor = $("#instructor_id option:selected").text();
                      var concepto = respuesta.array.concepto;
                      var cantidad = respuesta.array.cantidad;
                      var fecha_vencimiento = respuesta.array.fecha_vencimiento;

                      var rowId=respuesta.array.id;

                      @if(isset($id))

                        total = total + parseInt(cantidad);
                        $('#total').text(total);

                      var rowNode=t.row.add( [
                        ''+instructor+'',
                        ''+cantidad+'',
                        ''+fecha_vencimiento+'',
                        '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                      ] ).draw(false).node();

                      @else

                        alumno = $("#alumno_id option:selected").text();

                        var rowNode=t.row.add( [
                          ''+alumno+'',
                          ''+instructor+'',
                          ''+cantidad+'',
                          ''+fecha_vencimiento+'',
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                        ] ).draw(false).node();
                      @endif

                      $('#form_agregar')[0].reset();
                      $('.selectpicker').selectpicker('refresh')
                      $('.modal').modal('hide')

                    }else{
                      var nTitle="Ups! ";
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      var nType = 'danger';
                    }                       
                    finprocesado();

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  }, 1000);
                },
                error:function(msj){
                  setTimeout(function(){ 
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
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

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

        var id = $(this).closest('tr').attr('id');
        var element = this
        swal({   
            title: "Desea eliminar las credenciales?",   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: true 
        }, function(isConfirm){   
        if (isConfirm) {
            procesando()

            var token = "{{ csrf_token() }}"

            $.ajax({
                 url: route_eliminar+id,
                 headers: {'X-CSRF-TOKEN': token},
                 type: 'POST',
                 dataType: 'json',                
                success: function (data) {
                  if(data.status=='OK'){


                  t.row( $(element).parents('tr') )
                    .remove()
                    .draw();

                    total = total - parseInt(data.cantidad);
                    $('#total').text(total)
                    finprocesado()
                    swal("Listo!","Las credenciales han sido eliminados!","success");
                      
                                       
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
                  finprocesado()
                }
              })
            }
            });
          });

        function limpiarMensaje(){
            var campo = ["concepto", "remuneracion", "fecha_vencimiento"];
            fLen = campo.length;
            for (i = 0; i < fLen; i++) {
                $("#error-"+campo[i]+"_mensaje").html('');
            }
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
            .columns(column)
            .search($(this).val())
            .draw();
        });



        </script>

@stop