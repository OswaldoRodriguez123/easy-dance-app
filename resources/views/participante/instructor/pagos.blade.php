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
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               
                               
                          <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <div class="clearfix p-b-35"></div>

                                    <label for="clase_grupal_id" id="id-clase_grupal_id">Ingresa la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="El título para esta recompensa es lo que aparecerá en tu página de la campaña de Easy Dance . Crear un título que describa bien el contenido de lo que ofrece esta recompensa" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                          <div class="select">
                                            <select class="selectpicker bs-select-hidden" id="clase_grupal_id" name="clase_grupal_id" multiple="" data-max-options="5" title="Selecciona">

                                             @foreach ( $clases_grupales as $clase_grupal )
                                              <?php $exist = false; ?>
                                              @foreach ( $pagos_instructor as $pagos)
                                                @if ($pagos_instructor->clase_grupal_id==$clase_grupal->id )
                                                  <?php $exist = true; ?>
                                                @endif
                                              @endforeach
                                              @if ($exist)
                                                  <option value = "{{ $clase_grupal->id }}" disabled="" data-icon="glyphicon-remove"> {{ $clase_grupal->nombre }}</option>
                                              @else
                                                  <option value = "{{ $clase_grupal->id }}">{{ $clase_grupal->nombre }}</option>
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

                                  <label for="monto" id="id-monto">Monto</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Este monto representa lo que deseas recaudar  de los patrocinadores que busquen esta recompensa, por los elementos incluidos en este campo" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="monto" id="monto" data-mask="0000000" placeholder="Ej. 50">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-monto">
                                      <span >
                                          <small class="help-block error-span" id="error-monto_mensaje" ></small>                               
                                      </span>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                 
                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10" id="add" >Agregar Linea</button>
                              </div>

                              <br></br>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    
                                    <th class="text-center" data-column-id="clase_grupal"></th>
                                    <th class="text-center" data-column-id="monto" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="operaciones"></th>

                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($pagos_instructor as $pagos)
                                <?php $id = $pagos->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$pagos->nombre}}</td>
                                    <td class="text-center previa">{{$pagos->monto}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></td>
                                  </tr>
                            @endforeach 
                                                           
                            </tbody>
                            </table>

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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" data-formulario="edit_administrativo_academia" data-update="administrativo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
          </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participantes/instructores" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Instructores</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        <div class="text-left">
                                <a data-toggle="modal" id="modalPe" href="#modalPago" class="f-16 p-t-0 text-success">Configurar Pago</a>
                            </div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Pagos</p>
                        <hr class="linea-morada">
                                                              
                        </div>

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
                                <span id="monto" class ="f-700 f-16 opaco-0-8">Pendiente por cobrar : {{ number_format($total, 2) }}</span>
                                </div>
                                <br><br>
                                <!-- <div class="clearfix"></div> -->

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="clase">Clase</th>
                                    <th class="text-center" data-column-id="hora_entrada">Hora Entrada</th>
                                    <th class="text-center" data-column-id="hora_salida">Hora Salida</th>
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
            route_detalle="{{url('/')}}/administrativo/factura";
            route_enviar="{{url('/')}}/administrativo/factura/enviar/";
            route_gestion="{{url('/')}}/administrativo/pagos/gestion/";
            route_eliminar="{{url('/')}}/administrativo/pagos/eliminardeuda/";

        tipo = 'pagadas';

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $(document).ready(function(){

        $("#pagadas").prop("checked", true);

        t=$('#tablelistar').DataTable({
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
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
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

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    }
                });

                rechargeFactura();
            });

        function previa(t){

            if(tipo =='pagadas'){

                var row = $(t).closest('tr').attr('id');
                var route =route_detalle+"/"+row;
                window.location=route;
            }

        }

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
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
            } else  {
                  tipo= 'proformas';
                  rechargeProforma();
            }
         });

        function rechargeFactura(){
            var pagadas = <?php echo json_encode($pagadas);?>;
            $('#monto').css('opacity', '0');

            $.each(pagadas, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.hora+'',
                ''+array.hora_salida+'',
                ''+array.monto+'',
                '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeProforma(){
            var por_pagar = <?php echo json_encode($por_pagar);?>;

            $('#monto').css('opacity', '1');

            $.each(por_pagar, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.hora+'',
                ''+array.hora_salida+'',
                ''+array.monto+'',
                '<i data-toggle="modal" name="pagar" class="icon_a-pagar f-20 p-r-10 pointer"></i> <i data-toggle="modal" name="eliminar" class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
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

      $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar la proforma?",   
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
                        swal("Exito!","La campaña ha sido eliminada!","success");
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

                          t.row( $(element).parents('tr') )
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


    </script>

@stop