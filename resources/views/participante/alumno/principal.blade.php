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

<a href="{{url('/')}}/participante/alumno/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
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
                        <div class="card-header">
                            <div class ="col-md-6 text-left">  

                                <ul class="top-menu">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                           <span class="f-15 f-700" style="color:black"> 
                                                <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                           </span>
                                        </a>
                                        <ul class="dropdown-menu dm-icon pull-right">
                                            <li class="hidden-xs">
                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/eliminados"><i name="eliminados" id="eliminados" class="tm-icon zmdi zmdi-delete boton red f-25 pointer eliminados detalle"></i>&nbsp;Bandeja Eliminados</a>
                                            </li>

                                            <li class="hidden-xs">
                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/inactivos"><i name="inactivos" id="inactivos" class="tm-icon zmdi zmdi-label-alt-outline f-25 pointer inactivos detalle"></i> Bandeja Inactivos</a>
                                            </li>

                                            <li class="hidden-xs">
                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/congelados"><i name="congelados" id="congelados" class="tm-icon zmdi zmdi-close-circle-o f-25 pointer congelados detalle"></i> Bandeja Congelados</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>


                            </div>

                            <div class ="col-md-6 text-right">                                
 
                                <span class="f-16 p-t-0 text-success">Agregar un Alumno <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-alumnos f-25"></i> Sección de Alumnos</p>
                            <hr class="linea-morada">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nombre">Sexo</label>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="sexo" id="sexo" data-live-search="true">
                                            <option value = "T">Todos</option>
                                            <option value = "F">Mujeres</option>
                                            <option value = "M">Hombres</option>
                                        </select>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div> 
                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="confirmacion" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_e">Balance E</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos as $alumno)
                                <?php $id = $alumno['id']; 

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
                                        $alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg lazy" src="/assets/img/Hombre.jpg" data-image = "'.$imagen.'" alt=""><br><br>' .

                                        'Cantidad que adeuda: ' . number_format($alumno['deuda'], 2, '.' , '.')  . '<br>'.
                                        'Número Móvil: ' . $alumno['celular'] . '<br>'.
                                        'Correo Electrónico: ' . $alumno['correo'] . '<br>'.
                                        'Edad: ' . $alumno['edad'] . '<br>'.
                                    '</p>';
                    
                                    

                                ?>
                                @if($alumno['deleted_at'] == null)
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" data-tipo = "1">
                                @else
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion seleccion_deleted" data-tipo = "2">
                                @endif
                                    <td class="text-center previa"> @if($alumno['activacion']) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">
                                        @if($alumno['imagen'])
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                        @else
                                            @if($alumno['sexo'] == 'M')
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/profile-pics/4.jpg" data-image = "{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                            @else
                                              <img class="lv-img lazy" src="{{url('/')}}/assets/img/profile-pics/5.jpg" data-image = "{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
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
                                    <td class="text-center previa">
                                        <i class="zmdi zmdi-money {{ $alumno['deuda'] ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3"></i>
                                    </td>
                                    <td class="text-center disabled"> 
                                        @if($alumno['deleted_at'] == null)
                                            <!-- <i name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i> -->

                                            <ul class="top-menu">
                                                <li class="dropdown" id="dropdown_{{$id}}">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                       <span class="f-15 f-700" style="color:black"> 
                                                            <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                       </span>
                                                    </a>
                                                    <div class="dropup">
                                                        <ul class="dropdown-menu dm-icon pull-right">

                                                            @if($alumno['deuda'])
                                                                <li class="hidden-xs">
                                                                    <a onclick="procesando()" href="{{url('/')}}/participante/alumno/deuda/{{$id}}"><i class="icon_a-pagar f-16 m-r-10 boton blue"></i> Pagar</a>
                                                                </li>
                                                            @endif

                                                            @if($alumno['usuario'])
                                                                <li class="hidden-xs email">
                                                                    <a onclick="procesando()"><i class="zmdi zmdi-email f-16 boton blue"></i> Enviar Correo</a>
                                                                </li>
                                                            @endif


                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/transferir/{{$id}}"><i class="zmdi zmdi-trending-up f-16 boton blue"></i> Transferir</a>
                                                            </li>

                                                            <li class="hidden-xs">
                                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/evaluaciones/{{$id}}"><i class="zmdi glyphicon glyphicon-search f-16 boton blue"></i>Valoración</a>
                                                            </li>

                                                            <li class="hidden-xs reservar">
                                                                <a onclick="procesando()"><i class="zmdi icon_a-reservaciones f-16 boton blue"></i>Reservar</a>
                                                            </li>

                                                            <li class="hidden-xs eliminar">
                                                                <a class="pointer eliminar"><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </td>
                                </tr>
                                <!-- endcan -->
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

        route_detalle="{{url('/')}}/participante/alumno/detalle";
        route_operacion="{{url('/')}}/participante/alumno/operaciones";
        route_email="{{url('/')}}/correo/sesion";
        route_eliminar="{{url('/')}}/participante/alumno/eliminar/";
        route_principal="{{url('/')}}/participante/alumno";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
                processing: true,
                serverSide: false,
                pageLength: 25,    
                deferRender: true,
                order: [[4, 'asc']],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
                  $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
                },
                drawCallback: function(){
                    loadImages();
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

        function loadImages(){
            imagenes = $('.lazy')

            $.each(imagenes, function(){
                var this_image = this;
                var src = $(this_image).data('image');
                this_image.src = src;
            });
        }

        function previa(t){
            var row = $(t).closest('tr');
            var tipo = row.data('tipo');

            if(tipo == '1'){
                var id = row.attr('id');
                var route =route_detalle+"/"+id;
                window.open(route, '_blank');
            }
        }

        $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
        });

        $('#sexo').on('change', function(){

            if($(this).val() == 'T'){

                t
                .columns(3)
                .search('')
                .draw(); 

            }else{

                t
                .columns(3)
                .search($(this).val())
                .draw();

            }
    
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

        $(".email").click(function(){

            var route = route_email;
            var token = '{{ csrf_token() }}';
            var id = $(this).closest('tr').attr('id');
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:"&usuario_tipo=1&usuario_id="+id,
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/"+id  

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
      });

    $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/1";
        var token = '{{ csrf_token() }}';
        var id = $(this).closest('tr').attr('id');
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/agendar/reservaciones/actividades/"+id

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
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    })

    $(".eliminar").click(function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar al alumno?",   
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
                    window.location = route_principal; 

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

    </script>

@stop