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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-pagar f-25"></i> Sección de Comisiones</p>
                            <hr class="linea-morada">                                                         
                        </div>

                        <div class="col-sm-5">
                         <div class="form-group fg-line ">
                            <div class="p-t-10">
                            <label class="radio radio-inline m-r-20">
                                <input name="tipo" id="staff" value="1" type="radio" checked>
                                <i class="input-helper"></i>  
                                Staff <i id="staff2" name="staff2" class="icon_f-staff c-verde f-20"></i>
                            </label>
                            <label class="radio radio-inline m-r-20">
                                <input name="tipo" id="instructor" value="2" type="radio">
                                <i class="input-helper"></i>  
                                Instructor <i id="instructor2" name="instructor2" class="icon_a-instructor f-20"></i>
                            </label>
                            </div>
                            
                         </div>
                        </div> 

                        <div class="clearfix"></div>

                        <div class="table-responsive row">
                          <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" name="tablelistar">
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="tipo" data-order="desc">Tipo</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                              @foreach ($usuarios as $usuario)

                                <?php $id = $usuario['id']; ?>

                                <tr id="{{$id}}" data-tipo="{{$usuario['tipo']}}" class="seleccion" >
                                  <td class="text-center previa">
                                    {{$usuario['nombre']}} {{$usuario['apellido']}} 
                                  </td>
                                  <td class="text-center previa">
                                    <span style="display:none">{{$usuario['tipo']}}</span>{{$usuario['tipo_nombre']}}
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


        route_instructor = "{{url('/')}}/participante/instructor/pagos/"
        route_staff = "{{url('/')}}/configuracion/staff/pagos/"
   
        t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,   
          order: [[0, 'desc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).attr( "onclick","previa(this)" );
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

      t
        .columns(1)
        .search(1)
        .draw();

      function previa(t){
        var id = $(t).closest('tr').attr('id');
        var tipo = $(t).closest('tr').data('tipo');

        if(tipo == 1){
          var route =route_staff+id;
        }else{
          var route =route_instructor+id;
        }
        
        window.open(route, '_blank');
      }

      $('input[name="tipo"]').on('change', function(){
            t
            .columns(1)
            .search($(this).val())
            .draw();

            if ($(this).val() == '1') {
              $( "#instructor2" ).removeClass( "c-verde" );
              $( "#staff2" ).addClass( "c-verde" );

            }else{
              $( "#staff2" ).removeClass( "c-verde" );
              $( "#instructor2" ).addClass( "c-verde" );
            }
         });

    </script>
@stop