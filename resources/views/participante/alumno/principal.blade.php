@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
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
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
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
                                                <a onclick="procesando()" href="{{url('/')}}/participante/alumno/eliminados"><i name="eliminados" id="eliminados" class="tm-icon zmdi zmdi-delete f-25 pointer eliminados detalle"></i>&nbsp;Bandeja Eliminados</a>
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

                            <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="todos" value="T" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Todos <i id="todos2" name="todos2" class="zmdi zmdi-male-female zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="mujeres" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujeres <i id="mujeres2" name="mujeres2" class="zmdi zmdi-female zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="hombres" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombres <i id="hombres2" name="hombres2" class="zmdi zmdi-male-alt zmdi-hc-fw f-20"></i>
                                    </label>
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


                                    $contenido = '<p class="c-negro">' .

                                    $alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .

                                    'Cantidad que adeuda: ' . number_format($alumno['deuda'], 2, '.' , '.')  . '<br>'.
                                    'Número Móvil: ' . $alumno['celular'] . '<br>'.
                                    'Correo Electrónico: ' . $alumno['correo'] . '<br>'.
                                    'Edad: ' . $alumno['edad'] . '<br>'.



                                    '</p>';
                    
                                    

                                ?>
                                <!-- can('view-alumnos', $alumno) -->
                                @if($alumno['deleted_at'] == null)
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="row_{{$id}}" class="seleccion" data-tipo = "1">
                                @else
                                    <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="row_{{$id}}" class="seleccion seleccion_deleted" data-tipo = "2">
                                @endif
                                    <td class="text-center previa"> @if($alumno['activacion']) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">
                                        @if($alumno['imagen'])
                                          <img class="lv-img-lg" src="{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                        @else
                                            @if($alumno['sexo'] == 'M')
                                              <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                            @else
                                              <img class="lv-img-lg" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
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
                                    <i data-toggle="modal" href="#" class="zmdi zmdi-money {{ $alumno['deuda'] ? 'c-youtube ' : 'c-verde' }} zmdi-hc-fw f-20 p-r-3 operacionModal"></i>
                                    </td>
                                    <!--<td class="text-center"> <i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-filter-list f-20 p-r-10 operacionModal"></i></td>-->
                                    <!-- <td class="text-center"> <a href="{{url('/')}}/participante/alumno/operaciones/{{$id}}"><i class="zmdi zmdi-filter-list f-20 p-r-10"></i></a></td> -->
                                    @if($alumno['deleted_at'] == null)
                                        <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i></td>
                                    @else
                                        <td></td>
                                    @endif
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

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,    
        order: [[4, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
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
            var row = $(t).closest('tr');
            var tipo = row.data('tipo');
            if(tipo == '1'){
                var tmp = row.attr('id');
                var id_alumno = tmp.split('_');
                var route =route_detalle+"/"+id_alumno[1];
                window.location=route;
            }
        }


        $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
        });

        $('input[name="tipo"]').on('change', function(){

            if($(this).val() == 'T'){

                $( "#hombres2" ).removeClass( "c-verde" );
                $( "#mujeres2" ).removeClass( "c-verde" );
                $( "#todos2" ).addClass( "c-verde" );

                t
                .columns(3)
                .search('')
                .draw(); 

            }else if($(this).val() == 'F'){

                $( "#hombres2" ).removeClass( "c-verde" );
                $( "#mujeres2" ).addClass( "c-verde" );
                $( "#todos2" ).removeClass( "c-verde" );

                t
                .columns(3)
                .search($(this).val())
                .draw();

            }else{

                $( "#hombres2" ).addClass( "c-verde" );
                $( "#mujeres2" ).removeClass( "c-verde" );
                $( "#todos2" ).removeClass( "c-verde" );

                t
                .columns(3)
                .search($(this).val())
                .draw();

            }
    
        });

        </script>

@stop