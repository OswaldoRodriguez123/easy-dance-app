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

                       <div class="clearfix p-b-35"></div>
                      @endif

                      <div class="col-sm-12" id="id-concepto">
                          <div class="form-group fg-line">
                            <label for="concepto" id="id-concepto">Concepto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el concepto" title="" data-original-title="Ayuda"></i>

                            <div class="input-group">
                              <span class="input-group-addon"><i class="icon_b-nombres f-22"></i></span>
                              <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask proceso" name="concepto" id="concepto" placeholder="Ej. Puntos acumulados por colaborador" maxlength="100" onkeyup="countChar(this)">
                              </div>
                              <div class="opaco-0-8 text-right">Resta <span id="charNum">100</span> Caracteres</div>
                            </div>
                            <div class="has-error" id="error-concepto">
                              <span >
                                <small class="help-block error-span" id="error-concepto_mensaje" ></small>
                              </span>
                            </div>
                          </div>
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="col-sm-12" id="id-fecha_vencimiento">
                          <div class="form-group fg-line">
                            <label for="fecha_vencimiento">Fecha de Expiración</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de expiración" title="" data-original-title="Ayuda"></i>

                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                <div class="dtp-container fg-line">
                                    <input name="fecha_vencimiento" id="fecha_vencimiento" class="form-control date-picker pointer" placeholder="Seleciona" type="text">
                                </div>
                            </div>
                            <div class="has-error" id="error-fecha_vencimiento">
                              <span >
                                <small class="help-block error-span" id="error-fecha_vencimiento_mensaje" ></small>
                              </span>
                            </div>
                          </div>
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="col-sm-12" id="id-remuneracion">
                          <div class="form-group fg-line">
                            <label for="remuneracion" id="id-remuneracion">Cantidad</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de puntos a agregar" title="" data-original-title="Ayuda"></i>

                            <div class="input-group">
                              <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                              <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask proceso" data-mask="000000" name="remuneracion" id="remuneracion" placeholder="Ej. 500">
                              </div>
                            </div>
                            <div class="has-error" id="error-remuneracion">
                              <span >
                                <small class="help-block error-span" id="error-remuneracion_mensaje" ></small>
                              </span>
                            </div>
                          </div>
                        </div>

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

                        <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" name="guardar" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                        <div class="clearfix p-b-35"></div>
                
                      </div>
                    </div>
                  </form>
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
 
                                <span class="f-16 p-t-0 text-success">Agregar Puntos<i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-plus-circle-o f-25"></i> Sección de Puntaje</p>
                            <hr class="linea-morada">


                            @if(isset($id))
                              <span class ="f-700 f-16 opaco-0-8">Total : <span id="total">{{ $puntos_totales }}</span></span>
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
                                    <th class="text-center" data-column-id="concepto">Concepto</th>
                                    <th class="text-center" data-column-id="cantidad" data-order="desc">Cantidad</th>
                                    <th class="text-center" data-column-id="fecha_vencimiento">Fecha Expiración</th>
                                    <th class="text-center" data-column-id="status" data-type="numeric">Status</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($puntos as $punto)
                                <?php 
                                  $alumno_id = $punto['id']; 

                                  $contenido = 
                                  '<p class="c-negro">' .
                                      'Concepto: ' . $punto['concepto'] . '<br>'.
                                  '</p>'; 
                                ?>


             
                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$alumno_id}}" class="seleccion">

                                    @if(!isset($id))
                                      <td class="text-center previa">
                                        {{$punto['nombre']}} {{$punto['apellido']}}
                                      </td>
                                    @endif
            
                                    <td>{{ str_limit(title_case($punto['concepto']), $limit = 30, $end = '...') }}</td>
                                    <td class="text-center previa">{{$punto['remuneracion']}}</td>
                                    <td class="text-center previa">{{$punto['fecha_vencimiento']}}</td>
                                    <td class="text-center previa">
                                        <span class="{{ empty($punto['dias_restantes']) ? 'c-youtube' : '' }}">{{$punto['status']}}</span>
                                        Restan {{$punto['dias_restantes']}} Días
                                    </td>
                                    <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$alumno_id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i></td>
                        
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

        route_agregar="{{url('/')}}/participante/alumno/puntos-acumulados/agregar";
        route_eliminar="{{url('/')}}/participante/alumno/puntos-acumulados/eliminar/";
        route_detalle="{{url('/')}}/participante/alumno/puntos-acumulados/detalle/";

        
        total = parseInt("{{{$puntos_totales or 0}}}")
    

        $(document).ready(function(){
          t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,  
          paging:false,  
          bLengthChange: false, 
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

        $('#modalReferido-Alumno').on('hidden.bs.modal', function (event) {
          limpiarMensaje();
          $('#form_agregar')[0].reset();
        })

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

                      var concepto = respuesta.array.concepto;
                      var remuneracion = respuesta.array.remuneracion;
                      var fecha_vencimiento = respuesta.array.fecha_vencimiento;
                      var estatus = respuesta.estatus;

                      if(concepto.length > 15){
                        concepto = concepto.substr(0, 30) + "..."
                      }

                      var rowId=respuesta.id;

                      @if(isset($id))

                        total = total + parseInt(remuneracion);
                        $('#total').text(total);

                      var rowNode=t.row.add( [
                        ''+concepto+'',
                        ''+remuneracion+'',
                        ''+fecha_vencimiento+'',
                        ''+estatus+'',
                        '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                      ] ).draw(false).node();

                      @else

                        alumno = $("#alumno_id option:selected").text();

                        var rowNode=t.row.add( [
                          ''+alumno+'',
                          ''+concepto+'',
                          ''+remuneracion+'',
                          ''+fecha_vencimiento+'',
                          ''+estatus+'',
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                        ] ).draw(false).node();
                      @endif

                      $( rowNode )
                        .attr('id',respuesta.array.id)
                        .addClass('seleccion')
                        .attr('data-trigger','hover')
                        .attr('data-toggle','popover')
                        .attr('data-placement','top')
                        .attr('data-content','<p class="c-negro">Concepto:'+respuesta.array.concepto+'</p>')
                        .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
                        .attr('data-container','body')
                        .attr('data-html','true')
                        .attr('title','');

                      $('[data-toggle="popover"]').popover();
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
          title: "Desea eliminar los puntos?",   
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
        var token = $('input:hidden[name=_token]').val();
          $.ajax({
               url: route_eliminar+id,
               headers: {'X-CSRF-TOKEN': token},
               type: 'DELETE',
               dataType: 'json',                
              success: function (data) {
                if(data.status=='OK'){


                t.row( $(element).parents('tr') )
                  .remove()
                  .draw();

                  total = total - parseInt(data.cantidad);
                  $('#total').text(total)
                  finprocesado()
                  swal("Listo!","Los puntos han sido eliminados!","success");
                    
                                     
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

      $('#modalAgregar').on('shown.bs.modal', function (e) {
        $("#form_agregar")[0].reset();
      })

      function limpiarMensaje(){
        var campo = ["concepto", "remuneracion", "fecha_vencimiento"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+id;
        window.open(route, '_blank');
      }

      function errores(merror){
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
      }

    function countChar(val) {
      var len = val.value.length;
      if (len >= 100) {
        val.value = val.value.substring(0, 100);
      } else {
        $('#charNum').text(100 - len);
      }
    };

  </script>

@stop