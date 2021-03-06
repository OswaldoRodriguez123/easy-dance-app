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

    <div class="modal fade" id="modalCongelar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro"> Alumno: <span id="span_alumno">Congelar un alumno</span> <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
               <div class="modal-body">                           
               <div class="row p-t-20 p-b-0">

                   <div class="col-sm-3">

                        <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                        <div class="clearfix p-b-15"></div>

                        <span class="f-15 f-700 span_alumno"></span>

                          
                   </div>

               <div class="col-sm-9">
         
                <label for="razon_cancelacion" id="id-razon_congelacion">Razones de congelar el alumno</label>
                <br></br>

                <div class="fg-line">
                  <textarea class="form-control" id="razon_congelacion" name="razon_congelacion" rows="2" placeholder="Ej. No podré asistir por razones ajenas a mi voluntad" disabled></textarea>
                  </div>
              </div>


              <div class="col-sm-9">
                <div class="form-group">
                    <div class="form-group fg-line">
                    <label for="fecha_inicio">Fecha</label>
                    <div class="fg-line">
                        <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha" disabled>
                    </div>
                 </div>
                </div>
               </div>
              </div>

               
            </div>

        </div>
    </div>
</div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                        
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                        
                            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                                
                                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                                
                                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                                
                                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                               
                                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            </ul>
                        @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-mood-bad zmdi-hc-fw f-25"></i> Bandeja Congelados</p>
                            <hr class="linea-morada">
                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="fecha">Fecha Congelación</th>
                                    <th class="text-center" data-column-id="dias_restantes">Tiempo Restante</th>
                                    <th class="text-center" data-column-id="estatu_e">Balance E</th>
                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <th class="text-center" data-column-id="operacion">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos as $alumno)
                                <?php 
                                    $id = $alumno['inscripcion_id'];

                                    $contenido = '';

                                    if($alumno['imagen']){
                                        $imagen = '/assets/uploads/usuario/'.$alumno['imagen'];
                                    }else{
                                        if($alumno['sexo'] == 'F'){
                                            $imagen = '/assets/img/Mujer.jpg';
                                        }else{
                                            $imagen = '/assets/img/Hombre.jpg';
                                        }
                                    }


                                    $contenido = 
                                    '<p class="c-negro">' .
                                        $alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .
                                        'Identificación: ' . $alumno['identificacion'] . '<br>'.
                                        'Clase Grupal: ' . $alumno['clase_grupal_nombre'] . '<br>'.
                                        '<span style="border-bottom: 1px solid #F0F0F0"> Cantidad que adeuda: ' . number_format($alumno['deuda'], 2, '.' , '.')  . '</span> <br><br>'.
                                        'Razon de Congelación: ' . $alumno['razon_congelacion'] . '<br>'.
                                    '</p>'; 
                                ?>
                                <tr data-nombre="{{$alumno['nombre']}} {{$alumno['apellido']}}" data-fecha = "{{$alumno['fecha_inicio']}} - {{$alumno['fecha_final']}}" data-congelacion="{{$alumno['razon_congelacion']}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">
                                        @if($alumno['imagen'])
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                        @else
                                            @if($alumno['sexo'] == 'M')
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                            @else
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['identificacion']}}</td>
                                    <td class="text-center previa">
                                        @if($alumno['edad'] >= 18)
                                            @if($alumno['sexo']=='F')
                                                <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                            @else
                                                <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                            @endif
                                        @else
                                            @if($alumno['sexo']=='F')
                                                <span style="display: none">F</span><i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                            @else
                                                <span style="display: none">M</span><i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                            @endif
                                        @endif
                                    </td>

                                    <?php 
                                        $tmp = explode(" ", $alumno['nombre']);
                                        $nombre_alumno = $tmp[0];

                                        $tmp = explode(" ", $alumno['apellido']);
                                        $apellido_alumno = $tmp[0];
                                    ?>

                                    <td class="text-center previa">{{$nombre_alumno}} {{$apellido_alumno}} </td>
                                    <td class="text-center">{{$alumno['fecha_inicio']}} - {{$alumno['fecha_final']}}</td>
                                    <td class="text-center">{{$alumno['dias_vencimiento']}} Días</td>
                                    <td class="text-center previa">
                                        <i class="zmdi zmdi-money {{ $alumno['deuda'] ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3"></i>
                                    </td>
                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                        <td class="text-center">

                                            <ul class="top-menu">
                                                <li class="dropdown" id="dropdown_{{$id}}">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                       <span class="f-15 f-700" style="color:black"> 
                                                            <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                       </span>
                                                    </a>
                                                    <div class="dropup">
                                                        <ul class="dropdown-menu dm-icon pull-right">
                                                            <li class="hidden-xs descongelar pointer">
                                                                <a><i class="zmdi zmdi zmdi-refresh-alt f-16 boton blue"></i>Descongelar</a>
                                                            </li>

                                                            <li class="hidden-xs eliminar">
                                                                <a><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar Permanentemente</a>
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

        route_operacion="{{url('/')}}/participante/alumno/operaciones";
        route_restablecer="{{url('/')}}/participante/alumno/descongelar/";
        route_eliminar="{{url('/')}}/participante/alumno/eliminar-inscripcion/";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25, 
            order: [[4, 'desc']],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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

        $(".descongelar").click(function(){
                id = $(this).closest('tr').attr('id');
                element = this;
                var padre=$(this).parents('tr');
                swal({   
                    title: "Desea descongelar al alumno?",   
                    text: "Confirmar descongelamiento!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Descongelar!",  
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        restablecer(id, element);
          }
                });
            });
      function restablecer(id){
        var route = route_restablecer + id;
        var token = '{{ csrf_token() }}';
        procesando();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        t.row( $(element).parents('tr') )
                            .remove()
                            .draw();
                        swal("Exito!","El alumno ha sido descongelado!","success");
                        finprocesado()
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
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

      $(".eliminar").click(function(){
                id = $(this).closest('tr').attr('id');
                element = this;
                var padre=$(this).parents('tr');
                swal({   
                    title: "Desea eliminar la inscripción permanentemente?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + id;
         var token = '{{ csrf_token() }}';
         procesando();
                
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
                        swal("Exito!","El alumno ha sido eliminado permanentemente!","success");
                        finprocesado()
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
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

        function previa(t){

            var fecha = $(t).closest('tr').data('fecha');
            var congelacion = $(t).closest('tr').data('congelacion');
            var nombre = $(t).closest('tr').data('nombre');


            $('#fecha').val(fecha);
            $('#razon_congelacion').val(congelacion);
            $('#span_alumno').text(nombre);
            
            $('#modalCongelar').modal('show');
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

    </script>

@stop