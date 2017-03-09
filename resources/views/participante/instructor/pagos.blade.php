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

<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Pago<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_pago" id="form_pago"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="id" value="{{ $instructor->id }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               
                              <div class="col-sm-12">
                                <div class="clearfix p-b-35"></div>

                                    <label for="clase_grupal_id" id="id-clase_grupal_id">Ingresa la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="El título para esta recompensa es lo que aparecerá en tu página de la campaña de Easy Dance . Crear un título que describa bien el contenido de lo que ofrece esta recompensa" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                          <div class="select">
                                            <select class="selectpicker bs-select-hidden" id="clase_grupal_id" name="clase_grupal_id" multiple="" data-max-options="5" title="Todas">

                                             @foreach ( $clases_grupales as $clase_grupal )
                                              <?php $exist = false; ?>
                                              @foreach ( $pagos_instructor as $pagos)
                                                @if ($pagos->clase_grupal_id==$clase_grupal['id'] )
                                                  <?php $exist = true; ?>
                                                @endif
                                              @endforeach
                                              @if ($exist)

                                                  <option value = "{{ $clase_grupal['id'] }}" disabled="" data-icon="glyphicon-remove"> {{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }}  / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia'] }}</option>
                                              @else
                                                  <option value = "{{ $clase_grupal['id'] }}"> {{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }}  / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia'] }}</option>
                                              @endif
                                             @endforeach
                                            </select>
                                          </div>
                                    </div>
                                    </div>
                                     <div class="has-error" id="error-clase_grupal_id">
                                          <span >
                                              <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                               
                                          </span>
                                      </div>

                                  <div class="clearfix p-b-35"></div>

                               
                                  <label for="apellido" id="id-tipo">Tipo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de pago" title="" data-original-title="Ayuda"></i>

                                  <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                      <label class="radio radio-inline m-r-20">
                                          <input name="tipo_pago" id="monto" value="1" type="radio" checked>
                                          <i class="input-helper"></i>  
                                          Por Clase 
                                      </label>
                                      <label class="radio radio-inline m-r-20 ">
                                          <input name="tipo_pago" id="porcentaje" value="2" type="radio">
                                          <i class="input-helper"></i>  
                                          Mensual 
                                      </label>
                                  </div>
                                  </div>
                               <div class="has-error" id="error-tipo">
                                    <span >
                                        <small class="help-block error-span" id="error-tipo_mensaje" ></small>                                
                                    </span>
                                </div>

                               <div class="clearfix p-b-35"></div>

                                    <div class="form-group">
                                        <label for="cantidad" id="id-cantidad">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto a pagar por clase grupal" title="" data-original-title="Ayuda"></i>
                                        
                                      <div class="input-group">
                                        <span class="input-group-addon"><i class="icon_b icon_b-costo f-22"></i></span>
                                        <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="00000000" placeholder="Ej. 5000">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small id="error-cantidad_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>

                                  <div class="clearfix p-b-35"></div>

                                 
                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="add" >Agregar Linea</button>
                              </div>

                              <br></br>

                              <div class="table-responsive row">
                                 <div class="col-md-12">
                                  <table class="table table-striped table-bordered text-center " id="tablepagos" >
                                    <thead>
                                        <tr>
                                            
                                            <th class="text-center" data-column-id="clase_grupal">Clase Grupal</th>
                                            <th class="text-center" data-column-id="tipo" data-type="numeric">Tipo</th>
                                            <th class="text-center" data-column-id="monto" data-type="numeric">Monto</th>
                                            <th class="text-center" data-column-id="operaciones">Operaciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($pagos_instructor as $pagos)
                                        <?php $id = $pagos->id; ?>
                                        <tr id="{{$id}}" class="seleccion" >
                                            <td class="text-center">{{$pagos->nombre}}</td>
                                            <td class="text-center">

                                            @if($pagos->tipo == 1)

                                              Por Clase
                                            @else

                                              Mensual

                                            @endif

    
                                            </td>
                                            <td class="text-center">{{$pagos->monto}}</td>
                                            <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                          </tr>
                                    @endforeach 
                                                                   
                                    </tbody>
                                  </table>

                                </div>
                              </div> <!-- TABLE RESPONSIVE -->
                            </div><!--  COL-SM-12 -->
                          </div><!-- ROW -->

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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>

                            </div>
                        </div>
                    </div></form>
                </div>
            </div>
        </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/participantes/instructores/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
	                        <div class="text-left">
	                            <a data-toggle="modal" id="modalPe" href="#modalPago" class="f-16 p-t-0 text-success">Configurar Pago</a>
	                        </div>
                        @endif

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Pagos</p>
                        <hr class="linea-morada">
                                                              
                        </div>


                        @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)

	                        <div class="col-md-offset-10">
	                          <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" > Pagar <i class="icon_a-pagar"></i></button>
	                        </div>

                        @endif

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pagadas" value="pagadas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Pagadas <i id="pagadas2" name="pagadas2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pendientes" value="pendientes" type="radio">
                                        <i class="input-helper"></i>  
                                        Pendientes por Pagar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>
                                
                                <div class="col-md-12">
                                <span id="monto" class ="f-700 f-16 opaco-0-8">Pendiente por cobrar : <span id="total">{{ number_format($total, 2) }}</span></span>
                                </div>
                                <br><br>
                                <!-- <div class="clearfix"></div> -->

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
 
                                    <th style="width:7%;"><input style="margin-left:49%; display: none" name="select_all" value="1" id="select_all" type="checkbox" /></th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="clase">Clase</th>
                                    <th class="text-center" data-column-id="monto">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
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

        route_agregar="{{url('/')}}/participante/instructor/agregarpago";
        route_eliminar="{{url('/')}}/participante/instructor/eliminarpago/";
        route_pagar="{{url('/')}}/participante/instructor/pagar";

        tipo = 'pagadas';

        var total = "{{$total}}"

        var por_pagar = <?php echo json_encode($por_pagar);?>;
        var pagadas = <?php echo json_encode($pagadas);?>;

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $(document).ready(function(){

          $("#pagar").hide();
          $("#pagar").attr("disabled","disabled");
            
            $("#pagar").css({
                "opacity": ("0.2")
            });

          $('#clase_grupal_id').val('');
          $("#form_pago")[0].reset();
          $('#clase_grupal_id').selectpicker('refresh');

          $("#pagadas").prop("checked", true);

          t=$('#tablelistar').DataTable({
          "columnDefs": [ {
            "targets": [ 0 ],
            "orderable": false
          } ],
          processing: true,
          serverSide: false,
          pageLength: 50, 
          order: [[1, 'desc'], [3, 'desc']],
          fnDrawCallback: function() {
          if ("{{count($por_pagar)}}" < 50) {
                $('.dataTables_paginate').hide();
                $('#tablelistar_length').hide();
            }else{
             $('.dataTables_paginate').show();
            }
          },
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          },
          language: {
                          processing:     "Procesando ...",
                          search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                          searchPlaceholder: "BUSCAR",
                          lengthMenu:     " ",
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


          rechargeFactura();

        });

        h=$('#tablepagos').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 50, 
          order: [[0, 'desc']],
          fnDrawCallback: function() {
          if ("{{count($por_pagar)}}" < 50) {
                $('.dataTables_paginate').hide();
                $('#tablelistar_length').hide();
            }
          },
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          },
          language: {
                          processing:     "Procesando ...",
                          search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                          searchPlaceholder: "BUSCAR",
                          lengthMenu:     " ",
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


         function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='pagadas') {
                  tipo = 'pagadas';
                  rechargeFactura();
                  $('#pagar').hide();
            } else  {
                  tipo= 'proformas';
                  rechargeProforma();
                  $('#pagar').show();
            }
         });

        function rechargeFactura(){

            $('#monto').css('opacity', '0');
            $('#select_all').hide();

            $.each(pagadas, function (index, array) {
                var rowNode=t.row.add( [
                ''+ ' ' +'',
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.monto+'',
                // '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeProforma(){
            

            $('#monto').css('opacity', '1');

            if("{{Auth::user()->usuario_tipo}}" != 3)
            {
            	$('#select_all').show();
            	checkbox = '<input name="select_check" id="select_check" type="checkbox" />'
            }else{
            	checkbox = ''
            }

            $.each(por_pagar, function (index, array) {
                var rowNode=t.row.add( [


                ''+checkbox+'', 
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.monto+'',
                // '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('text-center');
            });
        }

        $("#pagadas").click(function(){
            $( "#pendientes2" ).removeClass( "c-verde" );
            $( "#pagadas2" ).addClass( "c-verde" );
        });

        $("#pendientes").click(function(){
            $( "#pagadas2" ).removeClass( "c-verde" );
            $( "#pendientes2" ).addClass( "c-verde" );
        });

        $('#tablelistar tbody').on( 'click', 'i.icon_a-pagar', function () {
            var id = $(this).closest('tr').attr('id');
            window.location = route_gestion + id;
        });

        $('#tablelistar tbody').on( 'click', 'i.zmdi-email', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea re-enviar la factura por correo electrónico?",   
                    text: "Confirmar re-envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Re-Enviar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","El correo ha sido enviado!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        enviar(id, element);
          }
                });
            });
      
        function enviar(id, element){
         var route = route_enviar + id;
         var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
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

                          // t.row( $(element).parents('tr') )
                          //   .remove()
                          //   .draw();
                        
                        }
                    },
                    error:function(msj){
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

      $('#tablepagos tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea eliminar esta configuración?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","La configuración ha sido eliminada!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
                
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

                          $("#clase_grupal_id option[value='"+respuesta.id+"']").removeAttr("disabled");
                          $("#clase_grupal_id option[value='"+respuesta.id+"']").data("icon","");

                          $('#clase_grupal_id').selectpicker('refresh');

                          h.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        
                        }
                    },
                    error:function(msj){
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


    $(".dismiss").click(function(){
      $('.modal').modal('hide');
    });


    $("#add").click(function(){


      $("#add").attr("disabled","disabled");
        $("#add").css({
          "opacity": ("0.2")
        });

      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_pago" ).serialize(); 
      limpiarMensaje();

      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data:datos+"&clase_grupal_id="+$("#clase_grupal_id").val(),
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
                $("#form_pago")[0].reset();

                $.each(respuesta.array, function (index, array) {

                  if(array.tipo == 1){
                    tipo = 'Por Clase'
                  }else{
                    tipo = 'Mensual'
                  }

                  var rowId=array.id;
                  var rowNode=h.row.add( [
                  ''+array.nombre+'',
                  ''+tipo+'',
                  ''+array.monto+'',
                  '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                  ] ).draw(false).node();
                  $( rowNode )
                  .attr('id',rowId)
                  // .attr('data-precio',precio_neto)
                  .addClass('seleccion');

                  $("#clase_grupal_id option[value='"+array.clase_grupal_id+"']").attr("disabled","disabled");
                  $("#clase_grupal_id option[value='"+array.clase_grupal_id+"']").data("icon","glyphicon-remove");

                  

                });

                $('#clase_grupal_id').val('');
                $('#clase_grupal_id').selectpicker('refresh');
                

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#add").removeAttr("disabled");
                $("#add").css({
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
                console.log(msj.responseJSON.errores);
                errores(msj.responseJSON.errores);
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle="   Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }
              $("#add").removeAttr("disabled");
                $("#add").css({
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

    $("#pagar").click(function(){


      // procesando();

      var route = route_pagar;
      var token = $('input:hidden[name=_token]').val();
      var datos = "&asistencias="+getChecked();
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

                $.each(respuesta.array, function (index, id) {

                  var pago = $.grep(por_pagar, function(e){ return e.id == id; });

                  pagadas.push(pago[0]);

                  console.log(pagadas);

                  indexes = $.map(por_pagar, function(obj, index) {
                      if(obj.id == id){
                          por_pagar.splice( $.inArray(por_pagar[index], por_pagar), 1 );

                          t.row( $('#'+id) )
                            .remove()
                            .draw();

                          total = total - obj.monto;

                          $('#total').text(total);


                      }
                  })


                  // value = 1
                  // index = $.inArray value, array
                  // if index > -1
                  // array.splice(index, 1)

                });

                $('#clase_grupal_id').val('');
                $('#clase_grupal_id').selectpicker('refresh');
                

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#add").removeAttr("disabled");
                $("#add").css({
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
                console.log(msj.responseJSON.errores);
                errores(msj.responseJSON.errores);
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle="   Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }
              $("#add").removeAttr("disabled");
                $("#add").css({
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

    function limpiarMensaje(){
      var campo = ["monto"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });    

  }

  function getChecked(){
      var checked = [];
      $('#tablelistar tr').each(function (i, row) {
          var actualrow = $(row);
          checkbox = actualrow.find('input:checked').val();
          if(checkbox == 'on')
          {
            var id = $(actualrow).attr('id');
            checked[i] = id;
          }
      });

      return checked;
    }


  $('#select_all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = t.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);

      values = getChecked();

      if(values.length > 0){

        $("#pagar").removeAttr("disabled");
        $("#pagar").css({
          "opacity": ("1")
        });

      }else{
        $("#pagar").attr("disabled","disabled");
        $("#pagar").css({
          "opacity": ("0.2")
        });
      }

   });

  $('#tablelistar tbody').on( 'click', 'input[type="checkbox"]', function () {
      values = getChecked();

      if(values.length > 0){

        $("#pagar").removeAttr("disabled");
        $("#pagar").css({
          "opacity": ("1")
        });

      }else{
        $("#pagar").attr("disabled","disabled");
        $("#pagar").css({
          "opacity": ("0.2")
        });
      }


  });


    </script>

@stop