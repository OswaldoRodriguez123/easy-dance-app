@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')
@if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
<a href="{{url('/')}}/especiales/campañas/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
@endif
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                            <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                                
                                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                                
                                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                                
                                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                               
                                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                                
                            </ul>
                        @else
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">
                        
                            @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                <span class="f-16 p-t-0 text-success">Agregar una Campaña <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            @endif

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-campana f-25"></i> Sección de Campañas</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        @if($campanas)
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="fecha_inicio" data-order="desc">Fecha Inicio</th>
                                    <th class="text-center" data-column-id="fecha_final" data-order="desc">Fecha Final</th>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="status" data-type="numeric">Status</th>
                                    @endif
                                    <th class="text-center" data-column-id="meta" data-order="desc">Meta</th>
                                    <th class="text-center" data-column-id="actual" data-order="desc">Actual</th>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($campanas as $campana)

                                <?php $id = $campana['id']; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$campana['nombre']}}</td>
                                    <td class="text-center previa">{{$campana['fecha_inicio']}}</td>
                                    <td class="text-center previa">{{$campana['fecha_final']}}</td>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center previa">
                                            <span class="{{ empty($campana['dias_restantes']) ? 'c-youtube' : '' }}">{{$campana['status']}}</span>
                                            Restan {{$campana['dias_restantes']}} Días
                                        </td>
                                    @endif
                                    <td class="text-center previa">{{ number_format($campana['cantidad'], 2, '.' , '.') }} </td>
                                    <td class="text-center previa">{{ number_format($campana['total'], 2, '.' , '.') }}</td>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center disabled"> 

                                            <!-- <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i> -->

                                            <ul class="top-menu">
                                                <li class="dropdown" id="dropdown_{{$id}}">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                       <span class="f-15 f-700" style="color:black"> 
                                                            <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                       </span>
                                                    </a>
                                                    <div class="dropup">
                                                        <ul class="dropdown-menu dm-icon pull-right">

                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/especiales/campañas/contribuciones/{{$id}}"><i class="icon_c-money f-16 m-r-10 boton blue"></i> Contribuciones</a>
                                                            </li>

                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/especiales/campañas/progreso/{{$id}}"><i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i> Progreso</a>
                                                            </li>
                   

                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/especiales/campañas/egresos/{{$id}}"><i class="fa fa-money f-16 m-r-10 boton blue"></i> Egresos</a>
                                                            </li>

                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/especiales/campañas/patrocinadores/{{$id}}"><i class="zmdi icon_a-campana f-16 boton blue"></i>Patrocinadores</a>
                                                            </li>

                                                            <li class="hidden-xs eliminar">
                                                                <a class="pointer eliminar"><i class="zmdi zmdi-delete f-20 boton red sa-warning"></i> Eliminar</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    @endif
                                  </tr>
                            @endforeach 
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado campañas. </div>


                             </div>




                        @endif
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

        route_detalle="{{url('/')}}/especiales/campañas/detalle";
        route_operacion="{{url('/')}}/especiales/campañas/operaciones";
        route_eliminar="{{url('/')}}/especiales/campañas/eliminar/";
        route_principal="{{url('/')}}/especiales/campañas";
        route_progreso="{{url('/')}}/especiales/campañas/progreso";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false,    
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($campanas)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
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
        if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6){
            var route =route_detalle+"/"+row;
        }else{
            var route =route_progreso+"/"+row;
        }

        window.open(route, '_blank');;
      }

      $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
        });

      $(".eliminar").click(function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar la campaña?",   
                text: "Confirmar eliminación!",      
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
      if (isConfirm) {
        var route = route_eliminar + id;
        var token = '{{ csrf_token() }}';
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){

                    procesando();
                    window.open(route, '_blank');_principal; 

                },
                error:function(msj){
                            // $("#msj-danger").fadeIn(); 
                            // var text="";
                            // console.log(msj);
                            // var merror=msj.responseJSON;
                            // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                            // $("#msj-error").html(text);
                            // setTimeout(function(){
                            //          $("#msj-danger").fadeOut();
                            //         }, 3000);
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                            }
            });
            }
        });
    });

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