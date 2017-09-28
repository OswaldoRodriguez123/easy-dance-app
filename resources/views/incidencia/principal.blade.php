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

    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
        <a href="{{url('/')}}/incidencias/generar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
    @endif

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
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
                                <span class="f-16 p-t-0 text-success">Agregar una Incidencia <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            @endif

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_f-incidencias"></i> Área de Incidencias</p>
                            <hr class="linea-morada">
                            <br>

                            <div class="clearfix"></div>                               
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="nombre">Miembro del Staff</th>
                                    @endif
                                    <th class="text-center" data-column-id="nombre">Nivel de Incidencia</th>
                                    <th class="text-center" data-column-id="nombre">Administrador</th>
                                    <th class="text-center" data-column-id="nombre">Fecha</th>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($incidencias as $incidencia)
                                <?php $id = $incidencia['id']; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center previa">{{$incidencia['usuario']}}</td>
                                    @endif
                                    <td class="text-center previa">{{$incidencia['gravedad']}}</td>
                                    <td class="text-center previa">{{$incidencia['administrador']}}</td>
                                    <td class="text-center previa">{{$incidencia['fecha']}} </td>
                                    @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center disabled">

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
                                                                <a onclick="procesando()" href="{{url('/')}}/incidencias/visualizar/{{$id}}"><i class="zmdi zmdi-eye f-16 boton blue"></i> Visualizar</a>
                                                            </li>

                                                            <li class="hidden-xs eliminar">
                                                                <a class="pointer eliminar"><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>
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
        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
            route_detalle="{{url('/')}}/incidencias/detalle";
            order = 3;
        @else
            route_detalle="{{url('/')}}/incidencias/visualizar";
            order = 2
        @endif

        route_eliminar="{{url('/')}}/incidencias/eliminar";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,  
                bInfo: false,
                bLengthChange: false,
                order: [[order, 'desc']],
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

        });


        function previa(t){
            var id = $(t).closest('tr').attr('id');
            var route =route_detalle+"/"+id;
            window.open(route, '_blank');;
        }

         $("i[name=operacion").click(function(){
            var route = route_operacion+"/"+this.id;
            window.location = route;
         });

         $("i[name=eliminar]").click(function(){

            id = this.id;
            element = this;

            swal({   
                title: "Para eliminar la incidencia necesita colocar la clave de supervisión",   
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

                        t.row($(element).parents('tr') )
                            .remove()
                            .draw();

                        swal("Hecho!","Eliminado con éxito!","success");
                        finprocesado();

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