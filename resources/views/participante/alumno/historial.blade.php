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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$alumno->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Vista Previa</a>

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

                        <span class="f-16 p-t-0 c-morado">{{$alumno->nombre}} {{$alumno->apellido}} {{$alumno->identificacion}}</span>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-money f-25"></i> Historial Administrativo</p>
                        <hr class="linea-morada">

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
                              <span class ="f-700 f-16 opaco-0-8"><span id="tipo_pago">Pendiente por pagar</span> : <span id="total">{{ number_format($total_deuda, 2) }}</span></span>
                            </div>
                            <br><br>
                                                          
                        </div>

                        <div class="clearfix p-b-15"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th><input name="select_all" value="1" id="select_all" type="checkbox" /></th>
                                    <th id="factura" class="text-center" data-column-id="factura" data-order="asc">Factura</th>
                                    <th class="text-center" data-column-id="concepto">Concepto</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="fecha_vencimiento">Fecha De Vencimiento</th>
                                    <th class="text-center" data-column-id="estatus">Estatus</th>
                                    <th class="text-center" data-column-id="total">Total</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($facturas as $factura)
                                <?php $id = $factura['id']; ?>
                                <tr id="{{$id}}" class="seleccion" data-tipo="{{$factura['tipo']}}">
                                    <td class="text-center previa">
                                        <span id="tipo_{{$factura['id']}}" style="display: none">{{$factura['tipo']}}</span>
                                        @if($factura['tipo'] == 0)
                                            <input name="select_check" id="select_check_{{$factura['id']}}" type="checkbox" />
                                        @endif
                                    </td>
                                    <td class="text-center previa">{{str_pad($factura['numero_factura'], 10, "0", STR_PAD_LEFT)}}</td>
                                    <td class="text-center previa">{{ str_limit($factura['concepto'], $limit = 50, $end = '...') }}
                                    </td>
                                    <td class="text-center previa">{{$factura['fecha']}}</td>
                                    <td class="text-center previa">{{$factura['fecha_vencimiento']}}</td>
                                    <td class="text-center previa">
                                        @if($factura['tipo'] == 0)
                                            @if($factura['estatus'] == 0)
                                                <span class="c-youtube">Vencida</span>
                                            @else
                                                <span>Por Pagar</span>
                                            @endif
                                        @else
                                            <span>Pagada</span>
                                        @endif
                                    </td>
                                    <td class="text-center previa">{{ number_format($factura['total'], 2, '.' , '.') }}</td>
                                    <td class="text-center"> 
                                        @if($factura['tipo'] == 1)
                                            <i id={{$id}} class="zmdi zmdi-email f-20 p-r-10"></i>
                                        @endif
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

        route_detalle="{{url('/')}}/administrativo/factura";
        route_gestion="{{url('/')}}/administrativo/pagos/gestion/";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
                "columnDefs": [ {
                    "targets": [ 0 ],
                    "orderable": false
                } ],
                processing: true,
                serverSide: false,
                pageLength: 25,
                bLengthChange:false, 
                bSort:false, 
                bInfo:false, 
                order: [[1, 'desc']],
                language: {
                      searchPlaceholder: "Buscar"
                },
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

            $("#pendientes").prop("checked", true);
            t.column(1).visible(false)
            t.column(7).visible(false)

            t
            .columns(0)
            .search(0)
            .draw();
        });


        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $('input[name="tipo"]').on('change', function(){


            t
            .columns(0)
            .search($(this).val())
            .draw();

            if ($(this).val()=='1') {

                $('#tipo_pago').text('Pagado')

                $('#total').text(formatmoney(parseFloat("{{$total_pago}}")))

                t.column(1).visible(true)
                t.column(4).visible(false)
                t.column(5).visible(false)
                t.column(7).visible(true)

                $( "#pendientes2" ).removeClass( "c-verde" );
                $( "#pagadas2" ).addClass( "c-verde" );

                $('#select_all').hide();
                $('#pagar').hide();

            } else{

                $('#tipo_pago').text('Pendiente por pagar')

                $('#total').text(formatmoney(parseFloat("{{$total_deuda}}")))

                t.column(1).visible(false)
                t.column(4).visible(true)
                t.column(5).visible(true)
                t.column(7).visible(false)

                $( "#pagadas2" ).removeClass( "c-verde" );
                $( "#pendientes2" ).addClass( "c-verde" );

                if("{{$usuario_tipo}}" != 2 || "{{$usuario_tipo}}" != 4){
                    $('#select_all').show();
                }

                $('#pagar').show();
            }
        });


        function previa(t){
            var row = $(t).closest('tr')
            var tipo = row.data('tipo')

            if(tipo == 1){
                procesando();
                var id = row.attr('id');
                var route =route_detalle+"/"+id;
                window.open(route, '_blank');;
            }
        }

        function getChecked(){
          var checked = [];
          $('#tablelistar tr').each(function (i, row) {
              var actualrow = $(row);
              checkbox = actualrow.find('input:checked').val();
              if(checkbox == 'on')
              {
                var row = $(actualrow).attr('id');
                var temp = row.split('_');
                var id = temp[1];
                checked[i] = id;
              }
          });

          return checked;
        }

        $("#pagar").click(function(){

                var route = route_gestion;
                var token = "{{ csrf_token() }}";
                procesando();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:"&items_factura="+getChecked()+"&usuario_id=1-{{$alumno->id}}",
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          
                            window.location = route_gestion;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        // finprocesado();
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

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
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $(".cancelar").removeAttr("disabled");
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
            });

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

        </script>

@stop