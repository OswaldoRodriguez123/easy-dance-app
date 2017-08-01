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

<a href="{{url('/')}}/configuracion/productos/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

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
                        <div class="card-header text-center">

                        <div class="text-right">
                            <span class="f-16 p-t-0 text-success">Agregar un Producto <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                        </div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-productos zmdi-hc-fw p-r-5 f-25"></i> Área de Productos</p>
                        <hr class="linea-morada">
                        <br>

                        <div class="col-sm-4 text-left">
                                 
                            <label class="c-morado f-15">Filtro</label>

                            <div class="dropdown" id="dropdown_boton">
                              <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                  Todos <span class="caret"></span>
                              </a>
                              <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                <li class="servicio_detalle pointer" data-nombre="Todos">
                                  <a>Todos</a>
                                </li>
                                <li class="dropdown-submenu pointer">
                                <a>Academia Recepción</a>
                                  <ul class="dropdown-menu">
                                    <li class = "pointer servicio_detalle" data-nombre="Clases Grupales"><a>Clases Grupales</a></li>
                                    <li class = "pointer servicio_detalle" data-nombre="Clases Personalizadas"><a>Clases Personalizadas</a></li>
                                    <li class = "pointer servicio_detalle" data-nombre="Productos"><a>Productos</a></li>
                                    <li class = "pointer servicio_detalle" data-nombre="Servicios"><a>Servicios</a></li>
                                    <li class = "pointer servicio_detalle" data-nombre="Paquetes"><a>Paquetes</a></li>
                                  </ul>
                                </li>

                                <li class="servicio_detalle pointer" data-nombre="Talleres">
                                  <a>Talleres</a>
                                </li>

                                <li class="servicio_detalle pointer" data-nombre="Campañas">
                                  <a>Campañas</a>
                                </li>

                                <li class="servicio_detalle pointer" data-nombre="Fiestas y Eventos">
                                  <a>Fiestas y Eventos</a>
                                </li>
                              </ul>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>                              
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="descripcion">Nombre</th>
                                    <th class="text-center" data-column-id="descripcion">Tipo</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Costo</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Cantidad</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($productos as $producto)
                                <?php $id = $producto['id']; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa">
                                        {{$producto['nombre']}}

                                        @if($producto['tipo'] == 'Servicios')
                                            <i class="icon_f-servicios f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Productos')
                                            <i class="icon_f-productos f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Clases Grupales')
                                            <i class="icon_a-clases-grupales f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Talleres')
                                            <i class="icon_a-talleres f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Clases Personalizadas')
                                            <i class="icon_a-clase-personalizada f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Campañas')
                                            <i class="icon_a-campana f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Fiestas y Eventos')
                                            <i class="icon_a-fiesta f-20 p-r-10"></i>
                                        @elseif($producto['tipo'] == 'Paquetes')
                                            <i class="icon_a-paquete f-20 p-r-10"></i>
                                        @endif

                                    </td>
                                    <td class="text-center previa">{{$producto['tipo']}}</td>
                                    <td class="text-center previa">{{ number_format($producto['costo'], 2, '.' , '.') }}</td>
                                    <td class="text-center previa">{{$producto['cantidad']}}</td>
                                    <td class="text-center disabled"> 
                                        <span style="display: none">
                                            {{$producto['tipo']}}
                                        </span> 
                                        <i name="eliminar" id={{$id}} class="zmdi zmdi-delete f-20 p-r-10 pointer acciones"></i>
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
            
            route_detalle="{{url('/')}}/configuracion/productos/detalle";
            route_eliminar="{{url('/')}}/configuracion/productos/eliminar/";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,  
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($productos)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
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

        function previa(t){

            var row = $(t).closest('tr').attr('id');
            var id_producto = row.split('_');
            var route =route_detalle+"/"+id_producto[1];
            window.location=route;
        }

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
         });

         $("i[name=eliminar]").click(function(){
                id = this.id;
                element = this;
                swal({   
                    title: "Desea eliminar el producto?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            console.log(this);
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
            var nTitle="Ups! ";
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
            swal("Hecho!","Eliminado con éxito!","success");
            
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

                    t.row( $(element).parents('tr') )
                      .remove()
                      .draw();

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

      $('#tipo').on('change', function(){

        tipo = $(this).val()

        if(tipo == '0'){

            t
            .columns(4)
            .search('')
            .draw(); 

        }else{

            t
            .columns(4)
            .search(tipo)
            .draw();

        }

    });

    $('body').on('click','.servicio_detalle',function(e){
            
        nombre = $(this).data('nombre')

        $('#detalle_boton').text(nombre)

        if(nombre == 'Todos'){

            t
            .columns(4)
            .search('')
            .draw(); 

        }else{

            t
            .columns(4)
            .search(nombre)
            .draw();

        }

        $('#dropdown_boton').removeClass('open')
        $('#detalle_boton').attr('aria-expanded',false);
    });



    </script>

@stop