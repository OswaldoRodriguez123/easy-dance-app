@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>
@stop
@section('content')


<a href="{{url('/')}}/participante/visitante/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
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
                        <div class="card-header ">

                            <div class="text-right">
                                <span class="f-16 p-t-0 text-success">Agregar un Visitante <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-visitante-presencial f-25"></i> Sección de Visitantes</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" name="tablelistar">
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="cliente"></th>
                                    <th class="text-center" data-column-id="fecha">Fecha de Registro</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="como_se_entero" data-order="desc">Cómo se Enteró</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Promotor</th>
                                    <th class="text-center" data-column-id="operaciones">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($visitantes as $visitante)
                                <?php 
                                  $id = $visitante['id']; 

                                  if($visitante['sexo'] == 'F'){
                                      $imagen = '/assets/img/Mujer.jpg';
                                  }else{
                                      $imagen = '/assets/img/Hombre.jpg';
                                  }

                                  $contenido = '';

                                  $contenido = '<p class="c-negro">' .

                                  $visitante['nombre'] . ' ' . $visitante['apellido']. ' <img class="lv-img-sm" src="'.$imagen.'" alt=""><br><br>' .

                                  'Número Móvil: ' . $visitante['celular'] . '<br>'.
                                  'Correo Electrónico: ' . $visitante['correo'] . '<br>'.
                                  'Especialidad de Interés: ' . $visitante['especialidad'] . '<br>'.



                                  '</p>';


                                ?>

                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa"> @if($visitante['cliente'])<i class="icon_a-estatus-de-clases c-verde f-20" data-html="true" data-original-title="" data-content="Cliente" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">{{$visitante['fecha_registro']}}</td>
                                    <td class="text-center previa">
                                    @if($visitante['sexo']=='F')
                                    <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                    @else
                                    <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                    @endif
                                    </td>

                                    <?php $tmp = explode(" ", $visitante['nombre']);
                                    $nombre_visitante = $tmp[0];

                                    $tmp = explode(" ", $visitante['apellido']);
                                    $apellido_visitante= $tmp[0];

                                    ?>

                                    <td class="text-center previa">{{$nombre_visitante}} {{$apellido_visitante}} </td>
                                    <td class="text-center previa">{{$visitante['como_se_entero']}}</td>
                                    <td class="text-center previa">{{$visitante['instructor_nombre']}} {{$visitante['instructor_apellido']}}</td>

                                    <td class="text-center disabled"> <i data-toggle="modal" name="operacion" id={{$id}} class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i></td>
                                    
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

        route_detalle="{{url('/')}}/participante/visitante/detalle";
        route_operacion="{{url('/')}}/participante/visitante/operaciones";
            
        $(document).ready(function(){


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
        var id_visitante = row.split('_');
        var route =route_detalle+"/"+id_visitante[1];
        window.location=route;
      }

      $("i[name=operacion").click(function(){
          var route =route_operacion+"/"+this.id;
          window.location=route;
       });

    </script>
@stop