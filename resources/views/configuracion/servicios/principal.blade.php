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

<a href="{{url('/')}}/servicios/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

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
                            <span class="f-16 p-t-0 text-success">Agregar un Servicio <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                        </div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-servicios"></i> Área de Servicios</p>
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
                                    <th class="text-center" data-column-id="nombre">Nombre</th>
                                    <th class="text-center" data-column-id="nombre">Tipo</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Costo</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($servicios as $servicio)
                                <?php $id = $servicio['id']; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa">
                                        {{$servicio['nombre']}}
                                        
                                        @if($servicio['tipo'] == 'Servicios')
                                            <i class="icon_f-servicios f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Clases Grupales')
                                            <i class="icon_a-clases-grupales f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Talleres')
                                            <i class="icon_a-talleres f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Clases Personalizadas')
                                            <i class="icon_a-clase-personalizada f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Campañas')
                                            <i class="icon_a-campana f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Fiestas y Eventos')
                                            <i class="icon_a-fiesta f-20 p-r-10"></i>
                                        @elseif($servicio['tipo'] == 'Paquetes')
                                            <i class="icon_a-paquete f-20 p-r-10"></i>
                                        @endif
                                    </td>
                                    <td class="text-center previa">{{$servicio['tipo']}}</td>
                                    <td class="text-center previa">{{ number_format($servicio['costo'], 2, '.' , '.') }} </td>
                                    <td class="text-center disabled"> 
                                        <span style="display: none">
                                            {{$servicio['tipo']}}
                                        </span> 
                                        <i name="eliminar" id={{$id}} class="zmdi zmdi-delete boton red f-20 p-r-10 pointer acciones"></i>
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
            route_detalle="{{url('/')}}/servicios/detalle";
            route_eliminar="{{url('/')}}/servicios/eliminar/";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,  
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($servicios)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        paging: false,
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2)', nRow).attr( "onclick","previa(this)" );
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
   

        function previa(t){
        var row = $(t).closest('tr').attr('id');
        var id_servicio = row.split('_');
        var route =route_detalle+"/"+id_servicio[1];
        window.open(route, '_blank');;
        }

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
         });

         $("i[name=eliminar]").click(function(){
                id = this.id;
                element = this;
                swal({   
                    title: "Desea eliminar el servicio?",   
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
           
            
            eliminar(id, element);
                }
            });
        });
      function eliminar(id, element){
         var route = route_eliminar + id;
         var token = "{{ csrf_token() }}";
         procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                         swal("Hecho!","Eliminado con éxito!","success");

                        t.row( $(element).parents('tr') )
                          .remove()
                          .draw();

                        finprocesado();

                    },
                    error:function(msj){
                                finprocesado();
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

      $('body').on('click','.servicio_detalle',function(e){
            
        nombre = $(this).data('nombre')

        $('#detalle_boton').text(nombre)

        if(nombre == 'Todos'){

            t
            .columns(3)
            .search('')
            .draw(); 

        }else{

            t
            .columns(3)
            .search(nombre)
            .draw();

        }

        $('#dropdown_boton').removeClass('open')
        $('#detalle_boton').attr('aria-expanded',false);
    });

    </script>

@stop