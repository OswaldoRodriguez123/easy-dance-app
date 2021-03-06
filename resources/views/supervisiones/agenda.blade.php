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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/supervisiones/conceptos/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">
  

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Secci??n de Agenda</p>
                            <hr class="linea-morada">

                            <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="activas" value="activas" type="radio">
                                            <i class="input-helper"></i>  
                                            Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input name="tipo" id="finalizadas" value="finalizadas" type="radio" checked >
                                            <i class="input-helper"></i>  
                                            Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
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
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="fecha">Supervisor</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($activas as $horario)
                                <tr id="{{$horario['id']}}" class="disabled" data-fecha="{{$horario['fecha']}}">
                                    <td class="text-center previa">{{$horario['fecha']}}</td>
                                    <td class="text-center previa">{{$horario['supervisor']}}</td>
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


    var finalizadas = <?php echo json_encode($finalizadas);?>;
    var activas = <?php echo json_encode($activas);?>;

    $(document).ready(function(){

        $("#activas").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2)', nRow).addClass( "disabled" );
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


    $("#activas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#activas2" ).addClass( "c-verde" );
    });

    $("#finalizadas").click(function(){
        $( "#finalizadas2" ).addClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
    });


     function rechargeActivas(){


            $.each(activas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.supervisor+''
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .attr('data-fecha', array.fecha_inicio);
            });
        }

        function rechargeFinalizadas(){

            $.each(finalizadas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.supervisor+''
                ] ).draw(false).node();
                $( rowNode )
                    .addClass('disabled')
                    .addClass('seleccion_deleted');
            });
        }

        function clear(){

            t.clear().draw();
        }

        $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                tipo = 'activas';
                rechargeActivas();
            } else if($(this).val()=='finalizadas')  {
                tipo= 'finalizadas';
                rechargeFinalizadas();
            }
         });


    </script>
@stop