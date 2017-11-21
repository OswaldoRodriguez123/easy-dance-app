@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header hidden-print">

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/reportes" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Reportes</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right hidden-print">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-pagar f-25"></i> Reporte de Comisiones</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        
                        <div class ="hidden-print">
                            <div class="col-sm-12">
                                <form name="formFiltro" id="formFiltro">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">

                                <div class="col-md-4">
                                    <label>Promotor</label>


                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" id="usuario" name="usuario" data-live-search="true">

                                            <option value="0">Todos</option>

                                            @foreach ( $promotores as $promotor )

                                                <option value = "{{ $promotor['id'] }}" data-content="{{ $promotor['nombre'] }} {{ $promotor['apellido'] }} {!!$promotor['icono']!!}"></option>
                                         
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Linea de Servicio</label>

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo_servicio" id="tipo_servicio" data-live-search="true">
                                            <option value="0">Todo</option>
                                            <option value="99">Academia Recepción</option>
                                            <option value="14">Fiestas y Eventos</option>
                                            <option value="5">Talleres</option>
                                            <option value="11">Campañas</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo</label>

                                    <div class="fg-line">
                                        <div class="select">
                                            <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                                <option value="0">Todos</option>
                                                <option value="1">Pagadas</option>
                                                <option value="2">Pendientes por Pagar</option>
                                            </select>
                                        </div>
                                    </div> 

                                </div>

                                <div class ="clearfix m-b-20"></div>


                                <div class="col-md-4">
                                    <label>Fecha</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="fecha" id="fecha">
                                            <option value="1">Hoy</option>
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                      </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Detalle</label>

                                    <div class="dropdown" id="dropdown_boton">
                                        <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                            Todos <span class="caret"></span>
                                        </a>
                                        <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        </ul>
                                    </div>
             

                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                        <label for="nombre">Personalizar</label>
                                        <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-collapse">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                          <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">

                                                        <div class="clearfix m-b-20"></div>
                                                    

                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                            <div class="fg-line">
                                                                    <input type="text" name = "fecha2" id="fecha2" class="form-control" placeholder="Personalizar">
                                                            </div>
                                                        </div>

            

                                                        
                                                    </div>

                                                    <div class="clearfix p-b-35"></div>
                                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>   

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                                <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                                </form>
                            </div>

                           
                            <div class="col-md-6" id="flot-chart" style="display: none">
                                <h2>Informe de Comisiones</h2>
                                <hr>
                                <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                                <div class="flc-pie hidden-xs"></div>

                            </div><!-- COL-MD-6 -->

                            <div class ="clearfix"></div>

                        </div>

                        
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table display  cell-border text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="promotor" data-order="desc">Promotor</th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="hora" data-order="asc">Hora</th>
                                    <th class="text-center" data-column-id="servicio_producto">Servicio / Producto</th>
                                    <th class="text-center" data-column-id="monto">Monto</th>
                                    <th class="text-center" data-column-id="tipo">Tipo</th>
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
                                    <div class="clearfix m-b-10"></div>

                                    <div class="col-sm-12  text-right" id="totales">

                                        <span class="f-30 text-center c-morado">Totales</span>
                                        
                                        <hr></hr>
                                     
                                        <div class="col-sm-12">
                                            <p class="pendientes" style="display: none">
                                                <span class="f-15 c-morado">Pendientes por pagar</span>
                                                <span class="f-15 c-morado" id="pendientes">0</span>
                                            </p>
                                            <p class="pagadas" style="display: none">
                                                <span class="f-15 text-right c-morado">Pagadas</span>
                                                <span class="f-15 c-morado" id="pagadas">0</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </section>

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
    <script type="text/javascript">


        route_filtrar="{{url('/')}}/reportes/comisiones";

        tipo_dropdown = ''
        servicio_producto_tipo = ''
        nombre_servicio = ''
        servicio_producto_id = ''

        var linea_servicio = <?php echo json_encode($linea_servicio);?>;

        $(document).ready(function(){

            //DateRangePicker
            $('#fecha2').daterangepicker({
                "autoApply" : false,
                "opens": "right",
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

            $("#formFiltro")[0].reset();

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[1, 'desc'], [2, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "disabled" );
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
    

        });


        $("#guardar").click(function(){

            $('#error-linea_mensaje').text('')

            var route = route_filtrar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();

            procesando(); 

            t.clear().draw();

            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: datos+"&servicio_producto_tipo="+servicio_producto_tipo+"&tipo_dropdown="+tipo_dropdown+"&servicio_producto_id="+servicio_producto_id,
                success:function(respuesta){
                  setTimeout(function(){ 
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY"; 
                    if(respuesta.status=="OK"){

                        $('#pendientes').text(formatmoney(parseFloat(respuesta.pendientes)))
                        $('#pagadas').text(formatmoney(parseFloat(respuesta.pagadas)))

                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje=respuesta.mensaje;

                        if($('#tipo').val() == 0){
                            $('#flot-chart').show()
                            $('.pendientes').show();
                            $('.pagadas').show();
                        }else{
                            $('#flot-chart').hide()
                            if($('#tipo').val() == 1){
                                $('.pagadas').show();
                                $('.pendientes').hide();
                            }else{
                                $('.pendientes').show();
                                $('.pagadas').hide();
                            }
                        }

                        $.each(respuesta.array, function (index, array) {

                            if(array.boolean_pago == 1){
                                tipo = 'Pagada';
                            }else{
                                tipo = 'Pendiente por Pagar';
                            }

                            var rowId=array.id;

                            var rowNode=t.row.add( [
                                ''+array.usuario+'',
                                ''+array.fecha+'',
                                ''+array.hora+'',
                                ''+array.servicio_producto+'',
                                ''+formatmoney(parseFloat(array.monto))+'',
                                ''+tipo+'',
                            ] ).draw(false).node();
                            $( rowNode )
                              .attr('id',rowId)
                              .addClass('seleccion');
                 
                        
                        });

                        datos = JSON.parse(JSON.stringify(respuesta));

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.estatus, function( i, item ) {
                            var label = item[0];
                            var cant = item[1];
                            data1 += '{"data":"'+cant+'","label":"'+label+'"},';
                        });

                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';
            
                        $("#pie-chart-procesos").html('');
                        $(".flc-pie").html('');
                        $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                            series: {
                                pie: {
                                    show: true,
                                    stroke: { 
                                        width: 2,
                                    },
                                },
                            },
                            legend: {
                                container: '.flc-pie',
                                backgroundOpacity: 0.5,
                                noColumns: 0,
                                backgroundColor: "white",
                                lineWidth: 0
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "Cantidad: %n ... %n, %s", 
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },

                            
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
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }
                    if(msj.responseJSON.status=="ERROR"){
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
              $("#error-linea_mensaje").html(error);             
           });
        });       

    }

    function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.open(route, '_blank');;
    }

    function collapse_minus(collaps){
        $('#'+collaps).collapse('hide');
    }   

    $('#collapseTwo').on('show.bs.collapse', function () {
        $("#boolean_fecha").val('1');
        $("#fecha").attr('disabled',true);
        $("#fecha").addClass('disabled');
        $("#fecha").selectpicker('refresh');
        setTimeout(function(){ 
            $("#fecha2").click();
        }, 500);
    })

    $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#fecha").attr('disabled',false);
        $("#fecha").removeClass('disabled');
        $("#fecha").selectpicker('refresh');
        $("#boolean_fecha").val('0');
    })

    function formatmoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    } 

    $('body').on('click','.servicio_detalle',function(e){
            
        tipo_dropdown = $(this).data('tipo_dropdown')
        servicio_producto_tipo = $(this).data('servicio_producto_tipo')
        nombre_servicio = $(this).data('nombre_servicio')
        servicio_producto_id = $(this).data('servicio_producto_id')

        $('#detalle_boton').text(nombre_servicio)

        $('#dropdown_boton').removeClass('open')
        $('#detalle_boton').attr('aria-expanded',false);
    });

    $('#tipo_servicio').on('change', function(){
       
        tipo_servicio = $(this).val();
        nombre = '';
        tipo_dropdown = ''
        servicio_producto_id = ''

        $('#detalle_boton').text('Todos')

        id = $(this).val();
        $('#dropdown_principal').empty();

        if(id == 99){

            contenido = '';

            contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-servicio_producto_tipo="3" data-nombre_servicio="Clases Grupales" data-servicio_producto_id ="3">'
            contenido += '<a>Clases Grupales</a>'
            contenido += '<ul class="dropdown-menu">'

            $.each(linea_servicio, function (index, array) {  
                if(array.tipo == 3 || array.tipo == 4){
                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                }                   
            });

            contenido += '</ul></li>'

            $('#dropdown_principal').append(contenido);

            contenido = '';
        
            contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-servicio_producto_tipo="9" data-nombre_servicio="Clases Personalizadas" data-servicio_producto_id ="9">'
            contenido += '<a>Clases Personalizadas</a>'
            contenido += '<ul class="dropdown-menu">'

            $.each(linea_servicio, function (index, array) {  
                if(array.tipo == 9){
                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                }                   
            });

            contenido += '</ul></li>'

            $('#dropdown_principal').append(contenido);

            contenido = '';

            contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-servicio_producto_tipo="2" data-nombre_servicio="Productos" data-servicio_producto_id ="2">'
            contenido += '<a>Productos</a>'
            contenido += '<ul class="dropdown-menu">'

            $.each(linea_servicio, function (index, array) {  
                if(array.tipo == 2){
                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                }                   
            });

            contenido += '</ul></li>'

            $('#dropdown_principal').append(contenido);

            contenido = '';

            contenido += '<li class="dropdown-submenu pointer servicio_detalle" data-tipo_dropdown="1" data-servicio_producto_tipo="1" data-nombre_servicio="Servicios" data-servicio_producto_id ="1">'
            contenido += '<a>Servicios</a>'
            contenido += '<ul class="dropdown-menu">'

            $.each(linea_servicio, function (index, array) {  
                if(array.tipo == 1){
                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>'
                }                   
            });

            contenido += '</ul></li>'

            $('#dropdown_principal').append(contenido);

            contenido = '';
        

        }else if(id == 14){
                

            $.each(linea_servicio, function (index, array) {  

                if(array.tipo == 14){

                    contenido = '';

                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                    $('#dropdown_principal').append(contenido);

                }                   
            });
            
        }else if(id == 5){

            $.each(linea_servicio, function (index, array) {  

                if(array.tipo == 5){

                    contenido = '';

                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                    $('#dropdown_principal').append(contenido);

                }                   
            });
        }else if(id == 11){

            $.each(linea_servicio, function (index, array) {  

                if(array.tipo == 11){

                    contenido = '';

                    contenido += '<li class = "pointer servicio_detalle" data-tipo_dropdown="2" data-servicio_producto_tipo="'+array.servicio_producto_tipo+'" data-nombre_servicio="'+array.nombre+'" data-servicio_producto_id="'+array.id+'"><a>'+array.nombre+'</a></li>';

                    $('#dropdown_principal').append(contenido);

                }                   
            });
            
        }
        
    });

</script>

@stop