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

            <div class="modal fade" id="modalDevolucion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Generar Devolución<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_devolucion" id="form_devolucion"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="razon_devolucion">Razon de la Devolución</label>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="razon_devolucion" name="razon_devolucion" rows="8" placeholder="1000 Caracteres" maxlength="1000" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">1000</span> Caracteres</div>
                                    <div class="has-error" id="error-razon_devolucion">
                                      <span >
                                          <small id="error-razon_devolucion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" id="id"></input>
                              

                               <div class="clearfix"></div> 

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12" id="generar_devolucion" href="#">  Generar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/administrativo/pagos/generar" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Pagos</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Facturas</p>
                            <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-12">
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
                                        Cuentas por Cobrar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <!-- <div class="clearfix"></div>

                                <div class="col-sm-12" id="checkbox_tipo" style="display:none">
                                    <div class="form-group fg-line ">
                                        <div class="p-t-10">

                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo_proforma" id="todos" type="radio" value="0">
                                            <i class="input-helper"></i>  
                                            Todos <i id="todos2" name="todos2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                        </label>


                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo_proforma" id="inscripcion" type="radio" value="3" >
                                            <i class="input-helper"></i>  
                                            Inscripción <i id="inscripcion2" name="inscripcion2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                        </label>

                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo_proforma" id="mensualidad" type="radio" value="4" >
                                            <i class="input-helper"></i>  
                                            Mensualidad <i id="mensualidad2" name="mensualidad2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                        </label>

                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo_proforma" id="acuerdo" type="radio" value="6" >
                                            <i class="input-helper"></i>  
                                            Acuerdo de Pago <i id="acuerdo2" name="acuerdo2" class="zmdi zmdi-money-box zmdi-hc-fw f-20"></i>
                                        </label>

                                        </div>
                                    </div>
                                </div>  -->

                                <div class="clearfix"></div>
                                
                        <div class="col-md-12">
                            <span id="monto" class ="f-700 f-16 opaco-0-8" style="display:none">Pendiente por cobrar : <span id="total">{{ number_format($total, 2) }}</span></span>
                        
                        </div>
                        
                        <div class="clearfix m-b-20"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                                <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                    <thead>
                                        <tr>
                                            <th class="text-center" data-column-id="tipo" data-order="asc"></th>
                                            <th id="factura" class="text-center" data-column-id="factura" data-order="asc">Factura</th>
                                            <th class="text-center" data-column-id="cliente">Cliente</th>
                                            <th class="text-center" data-column-id="cliente">Tipo de Pago</th>
                                            <th class="text-center" data-column-id="concepto">Concepto</th>
                                            <th class="text-center" data-column-id="fecha" id="fecha">Fecha de Vencimiento</th>
                                            <th class="text-center" data-column-id="total">Total</th>
                                            <th class="text-center" data-column-id="operacion">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($facturas as $factura)
                                            <?php $id = $factura['id']; ?>

                                            @if($factura['tipo_pago'] != 'Devolución')
                                                <tr id="{{$id}}" class="seleccion" data-tipo="{{$factura['tipo']}}">
                                            @else
                                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$factura['contenido']}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" data-tipo="{{$factura['tipo']}}">
                                            @endif

                                                <td>
                                                    <span style="display:none">{{$factura['tipo']}}</span>
                                                    @if($factura['tipo_pago'] == 'Devolución')
                                                        <i class="zmdi zmdi-minus c-youtube m-l-10 f-20"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center previa">{{str_pad($factura['numero_factura'], 10, "0", STR_PAD_LEFT)}}</td>
                                                <td class="text-center previa">{{$factura['nombre']}}</td>
                                                <td class="text-center previa">{{$factura['tipo_pago']}}</td>
                                                <td class="text-center previa">{{ str_limit($factura['concepto'], $limit = 50, $end = '...') }}
                                                </td>
                                                <td class="text-center previa">{{$factura['fecha']}}</td>
                                                <td class="text-center previa">{{ number_format($factura['total'], 2, '.' , '.') }}</td>
                                                <td class="text-center previa">
                                                    <span style="display:none">{{$factura['tipo_proforma']}}</span>
                                                    <ul class="top-menu">
                                                        <li class="dropdown" id="dropdown_{{$id}}">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                               <span class="f-15 f-700" style="color:black"> 
                                                                    <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                               </span>
                                                            </a>
                                                            <div class="dropup">
                                                                <ul class="dropdown-menu dm-icon pull-right">

                                                                    @if($factura['tipo'] == 1)

                                                                        @if($factura['tipo_pago'] != 'Devolución')
                                                                            <li class="hidden-xs email">
                                                                                <a><i class="zmdi zmdi-email f-16 boton blue"></i> Enviar Correo</a>
                                                                            </li>

                                                                             <li class="hidden-xs devolucion">
                                                                                <a><i class="zmdi zmdi-rotate-left f-16 boton blue"></i> Devolución</a>
                                                                            </li>
                                                                        @endif

                                                                        <li class="hidden-xs eliminar_factura">
                                                                            <a class="pointer"><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>
                                                                        </li>
                                                                    @else
                                                                        <li class="hidden-xs pagar">
                                                                            <a><i class="zmdi icon_a-pagar f-16 boton blue"></i> Pagar</a>
                                                                        </li>

                                                                        <li class="hidden-xs eliminar">
                                                                            <a class="pointer"><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>
                                                                        </li>
                                                                    @endif

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
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

        route_detalle="{{url('/')}}/administrativo/factura";
        route_enviar="{{url('/')}}/administrativo/factura/enviar/";
        route_gestion="{{url('/')}}/administrativo/pagos/gestion/";
        route_eliminar="{{url('/')}}/administrativo/pagos/eliminardeuda";
        route_eliminar_factura="{{url('/')}}/administrativo/pagos/eliminar-factura";
        route_devolucion="{{url('/')}}/administrativo/pagos/devolucion/";

        t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[1, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
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

        $(document).ready(function(){

            t
            .columns(0)
            .search(1)
            .draw(); 

            $("#pagadas").prop("checked", true);
            
            document.getElementById('fecha').innerHTML = 'Fecha';
            document.getElementById('factura').innerHTML = '#'; 
        });


        $('input[name="tipo"]').on('change', function(){

            if($(this).val()=='pagadas'){

                $('#monto').hide();
                $('#checkbox_tipo').hide();

                t.column(3).visible(true);

                t
                .columns(0)
                .search(1)
                .draw(); 

                document.getElementById('fecha').innerHTML = 'Fecha'; 

            }else{

                tipo = $('input[name="tipo_proforma"]').val()
            
                t
                    .columns(0)
                    .search(2)
                    .draw(); 

                if(tipo){

                    // t
                    //     .columns(7)
                    //     .search(tipo)
                    //     .draw(); 
                }
                
                $('#checkbox_tipo').show();
                $('#monto').show();
                t.column(3).visible(false);
                document.getElementById('fecha').innerHTML = 'Fecha de Vencimiento';
            }
        });

        $("#pagadas").click(function(){
            $( "#pendientes2" ).removeClass( "c-verde" );
            $( "#pagadas2" ).addClass( "c-verde" );
        });

        $("#pendientes").click(function(){
            $( "#pagadas2" ).removeClass( "c-verde" );
            $( "#pendientes2" ).addClass( "c-verde" );
        });

        $("#inscripcion").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).addClass( "c-verde" );
        });

        $("#mensualidad").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).addClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $("#acuerdo").click(function(){
            $( "#todos2" ).removeClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).addClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $("#todos").click(function(){
            $( "#todos2" ).addClass( "c-verde" );
            $( "#mensualidad2" ).removeClass( "c-verde" );
            $( "#acuerdo2" ).removeClass( "c-verde" );
            $( "#inscripcion2" ).removeClass( "c-verde" );
        });

        $('#tablelistar tbody').on( 'click', '.pagar', function () {
            var id = $(this).closest('tr').attr('id');
            window.location = route_gestion + id;
        });

        $('#tablelistar tbody').on( 'click', '.email', function () {

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
                closeOnConfirm: true 
            }, function(isConfirm){   
              if (isConfirm) {
                var nFrom = $(this).attr('data-from');
                var nAlign = $(this).attr('data-align');
                var nIcons = $(this).attr('data-icon');
                var nType = 'success';
                var nAnimIn = $(this).attr('data-animation-in');
                var nAnimOut = $(this).attr('data-animation-out')
                            
                enviar(id, element);
                }
            });
        });
      
        function enviar(id, element){

            var route = route_enviar + id;
            var token = "{{ csrf_token() }}";
            procesando();
                
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
                        finprocesado();
                        swal("Exito!","El correo ha sido enviado!","success");
                    
                    
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

        $('#tablelistar tbody').on( 'click', '.eliminar_factura', function () {

            var id = $(this).closest('tr').attr('id');
            element = this;

            swal({   
                  title: "Para eliminar la factura necesita colocar la clave de supervisión",   
                  text: "Confirmar eliminación!",   
                  type: "input",  
                  showCancelButton: true,   
                  confirmButtonColor: "#DD6B55",   
                  confirmButtonText: "Aceptar",  
                  cancelButtonText: "Cancelar",         
                  closeOnConfirm: false,
                  animation: "slide-from-top",
                  inputPlaceholder: "Coloque la clave de supervisión"
              }, function(inputValue){

                if (inputValue === false) return false;
                
                if (inputValue === "") {
                  swal.showInputError("Ups! La clave de supervisión es requerida");
                  return false
                }else{

                  var route = route_eliminar_factura;
                  var token = "{{ csrf_token() }}"
                  var datos = "&id="+id+"&password_supervision="+inputValue
                  procesando();
                  
                  $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                      swal("Exito!","La factura ha sido eliminada!","success");

                      t.row( $(element).parents('tr') )
                          .remove()
                          .draw();
                      finprocesado()

                    },
                    error:function(msj){
                      finprocesado();
                      if(msj.responseJSON.status == "ERROR-PASSWORD"){
                        swal.showInputError("Ups! La clave de supervisión es incorrecta");
                      }else{
                        swal('Solicitud no procesada','Ups! Ha ocurrido un error, intente nuevamente','error');
                      }
                    }
                  });
                }
            });
        });

        $('#tablelistar tbody').on( 'click', '.eliminar', function () {

            var id = $(this).closest('tr').attr('id');
            element = this;

            swal({   
                title: "Para eliminar la proforma necesita colocar la clave de supervisión",   
                text: "Confirmar eliminación!",   
                type: "input",  
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Aceptar",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Coloque la clave de supervisión"
                 }, function(inputValue){
                if (inputValue === false) return false;
                
                if (inputValue === "") {
                    swal.showInputError("Ups! La clave de supervisión es requerida");
                    return false
                }else{

                    var route = route_eliminar;
                    var token = "{{ csrf_token() }}"
                    var datos = "&id="+id+"&password_supervision="+inputValue
                    procesando();
                  
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                        success:function(respuesta){

                            swal("Exito!","La proforma ha sido eliminada!","success");

                            t.row( $(element).parents('tr') )
                                .remove()
                                .draw();

                            finprocesado();

                        },
                        error:function(msj){
                            finprocesado();
                            if(msj.responseJSON.status == "ERROR-PASSWORD"){
                                swal.showInputError("Ups! La clave de supervisión es incorrecta");
                            }else{
                                wal('Solicitud no procesada','Ups! Ha ocurrido un error, intente nuevamente','error');
                            }
                        }
                    });
                }
            });
        });

        $('#tablelistar tbody').on( 'click', '.devolucion', function () {

            var id = $(this).closest('tr').attr('id');
            element = this;

            $('#id').val(id)

            $('#modalDevolucion').modal('show')
        });

        function countChar(val) {
            var len = val.value.length;
            if (len >= 1000) {
                val.value = val.value.substring(0, 1000);
            } else {
                $('#charNum').text(1000 - len);
            }
        };

        $('#generar_devolucion').on( 'click', function () {

            $('.modal').modal('hide')

            swal({   
                  title: "Para realizar la devolución necesita colocar la clave de supervisión",   
                  text: "Confirmar eliminación!",   
                  type: "input",  
                  showCancelButton: true,   
                  confirmButtonColor: "#DD6B55",   
                  confirmButtonText: "Aceptar",  
                  cancelButtonText: "Cancelar",         
                  closeOnConfirm: false,
                  animation: "slide-from-top",
                  inputPlaceholder: "Coloque la clave de supervisión"
              }, function(inputValue){

                if (inputValue === false) return false;
                
                if (inputValue === "") {
                  swal.showInputError("Ups! La clave de supervisión es requerida");
                  return false
                }else{

                    procesando();
                    limpiarMensaje();

                    var id = $('#id').val();
                    var razon_devolucion = $('#razon_devolucion').val();

                    var route = route_devolucion + id;
                    var token = "{{ csrf_token() }}"
                    var datos = "&id="+id+"&password_supervision="+inputValue+"&razon_devolucion="+razon_devolucion
                  
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                        success:function(respuesta){

                          swal("Exito!","La devolución ha sido realizada!","success");

                          t.row( $(element).parents('tr') )
                              .remove()
                              .draw();
                          finprocesado()

                        },
                        error:function(msj){
                            finprocesado();
                            if(msj.responseJSON.status == "ERROR-PASSWORD"){
                                swal.showInputError("Ups! La clave de supervisión es incorrecta");
                            }else{
                                
                                swal.close();
                                $('#modalDevolucion').modal('show');
                                errores(msj.responseJSON.errores);
                                var nTitle=" Ups! "; 
                                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            } 
                        }
                    });
                }
            });
        });

        function previa(t){

            var tipo = $(t).closest('tr').data('tipo');

            if(tipo == 1){
                var id = $(t).closest('tr').attr('id');
                var route =route_detalle+"/"+id;
                window.open(route, '_blank');
            }
        }

        function limpiarMensaje(){
            var campo = ["razon_devolucion"];
            fLen = campo.length;
            for (i = 0; i < fLen; i++) {
                $("#error-"+campo[i]+"_mensaje").html('');
            }
        }

        function errores(merror){
            $.each(merror, function (n, c) {
                 console.log(n);
               $.each(this, function (name, value) {
                  var error=value;
                  $("#error-"+n+"_mensaje").html(error);
                  console.log(value);
               });
            });
        }


        $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

            var id = $(this).closest('tr').attr('id');
            var dropdown = $(this).closest('.dropdown')
            var dropdown_toggle = $(this).closest('.dropdown-toggle')

            $('.dropdown-toggle').attr('aria-expanded','false')
            $('.dropdown').removeClass('open')
            $('.table-responsive').css( "overflow", "auto" );

            if(!dropdown.hasClass('open')){
                dropdown.addClass('open')
                dropdown_toggle.attr('aria-expanded','true')
                $('.table-responsive').css( "overflow", "inherit" );
            }
         
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "auto" );
        })

    </script>
@stop