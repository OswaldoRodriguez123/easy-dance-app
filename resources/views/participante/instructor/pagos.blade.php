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


            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/participante/instructor/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

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

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Pagos</p>
                        <hr class="linea-morada">
                                                              
                        </div>


                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

	                        <div class="col-md-offset-10">
	                          <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" style="opacity: 0.2" disabled> Pagar <i class="icon_a-pagar"></i></button>
	                        </div>

                        @endif

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pendientes" value="0" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        Pendientes por Pagar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw  c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pagadas" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Pagadas <i id="pagadas2" name="pagadas2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
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
 
                                    <th style="width:7%;"><input style="margin-left:49%;" name="select_all" value="1" id="select_all" type="checkbox" /></th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="hora" data-order="asc">Hora</th>
                                    <th class="text-center" data-column-id="hora" data-order="asc">Día</th>
                                    <th class="text-center" data-column-id="clase">Servicio / Producto</th>
                                    <th class="text-center" data-column-id="cliente" data-order="asc">Cliente</th>
                                    <th class="text-center" data-column-id="monto">Monto</th>
                                </tr>
                            </thead>
                            <tbody>

                              @foreach($pagos_comisiones as $pago)
                                <tr id="{{$pago['id']}}" class="seleccion" data-monto="{{$pago['monto']}}" >
                                  <td class="text-center previa">
                                    <span id="boolean_pago_{{$pago['id']}}" style="display: none">{{$pago['boolean_pago']}}</span>
                                    @if($pago['boolean_pago'] == 0)
                                      <input name="select_check" id="select_check_{{$pago['id']}}" type="checkbox" />
                                    @endif
                                  </td>
                                  <td class="text-center previa">{{$pago['fecha']}}</td>
                                  <td class="text-center previa">{{$pago['hora']}}</td>
                                  <td class="text-center previa">{{$pago['dia']}}</td>
                                  <td class="text-center previa">{{$pago['servicio_producto']}}</td>
                                  <td class="text-center previa">{{$pago['cliente']}}</td>
                                  <td class="text-center previa">{{ number_format($pago['monto'], 2, '.' , '.') }}</td>
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

        route_pagar="{{url('/')}}/participante/instructor/pagar";

        var total = "{{$total}}"

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $(document).ready(function(){

          t=$('#tablelistar').DataTable({
          "columnDefs": [ {
            "targets": [ 0 ],
            "orderable": false
          } ],
          processing: true,
          serverSide: false,
          pageLength: 50, 
          order: [[1, 'desc'], [2, 'desc']],
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


          t
            .columns(0)
            .search(0)
            .draw();

        });


         $('input[name="tipo"]').on('change', function(){


            t
            .columns(0)
            .search($(this).val())
            .draw();

            if ($(this).val()=='1') {

              $( "#pendientes2" ).removeClass( "c-verde" );
              $( "#pagadas2" ).addClass( "c-verde" );

              $('#monto').css('opacity', '0');
              $('#select_all').hide();
              $('#pagar').hide();
            } else  {

              $( "#pagadas2" ).removeClass( "c-verde" );
              $( "#pendientes2" ).addClass( "c-verde" );

              $('#monto').css('opacity', '1');

              if("{{$usuario_tipo}}" != 3)
              {
                $('#select_all').show();
              }

              $('#pagar').show();
            }
         });

    $("#pagar").click(function(){

      swal({   
        title: "Desea consignar el pago?",   
        text: "Consignar pago!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Consignar!",  
        cancelButtonText: "Cancelar",         
        closeOnConfirm: true 
        }, function(isConfirm){   
          if (isConfirm) {
            
          procesando();

          var route = route_pagar;
          var token = "{{ csrf_token() }}";
          var datos = "&pendientes="+getChecked();
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

                    $.each(respuesta.array, function (i, id) {
                      monto = $('#'+id).data('monto')
                      total = total - monto;
                      $('#total').text(formatmoney(parseFloat(total)));
                      boolean_pago = $('#boolean_pago_'+id);
                      boolean_pago.text(1);
                      select_check = $('#select_check_'+id);
                      select_check.hide();
                      UpdateTD = boolean_pago.parent('td');
                      t.cell(UpdateTD).data(UpdateTD.html()).draw();
                    });
                    
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
                  var nFrom = $(this).attr('data-from');
                  var nAlign = $(this).attr('data-align');
                  var nIcons = $(this).attr('data-icon');
                  var nType = 'danger';
                  var nAnimIn = "animated flipInY";
                  var nAnimOut = "animated flipOutY";   
                  finprocesado();
                  notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                }, 1000);
              }
          });
        }
      });
    });

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