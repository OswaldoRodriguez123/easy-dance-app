@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/js/jquery.iconmenu.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
     <!--                    <div class="card-header text-right">
                            <div class="text-center icon_a icon_a-reservaciones f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Reportes</p></div>                   
                        </div> -->
                        <div class="card-body text-center">
                            <div class="col-sm-12">
                                <div role="tabpanel" class="tab">
                                    <ul class="tab-nav tab-menu" role="tablist" data-menu-color="naranja">
                                        <li class="active" role="presentation"><a class="rojo" href="#reportes" aria-controls="reportes" role="tab" data-toggle="tab"><div class="icon_a icon_a-reservaciones f-30" style="color:#f44336;  "></div><p style=" margin-bottom: -2px; color:#f44336;">Reportes</p></a></li>   
                                    </ul>
                                </div>
                                <div class="tab-content ">
                                    <div role="tabpanel" class="tab-pane  animated active fadeInRight in" id="reportes">
                                        <ul id="sti-menu"  class="sti-menu">
                                            <li data-hovercolor="#f44336">
                                                <a href="{{url('/')}}/reportes/asistencias"><h2 data-type="mText" class="sti-item">Asistencias</h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a>
                                            </li>
                                            <li data-hovercolor="#f44336">
                                                <a href="{{url('/')}}/reportes/diagnosticos"><h2 data-type="mText" class="sti-item">Valoración</h2><span data-type="icon" class="sti-icon sti-icon-reportes1 sti-item"></span></a>
                                            </li>    
                                            <li data-hovercolor="#f44336">
                                                <a href="{{url('/')}}/reportes/presenciales"><h2 data-type="mText" class="sti-item">Presenciales </h2><span data-type="icon" class="sti-icon sti-icon-reportes2 sti-item"></span></a>
                                            </li>
                                            <li data-hovercolor="#f44336">
                                                <a data-toggle="modal" href="{{url('/')}}/reportes/estatus_alumnos"><h2 data-type="mText" class="sti-item">Estatus de alumnos</h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a>
                                            </li>

                                            <div class="clearfix"></div>

                                            <li data-hovercolor="#f44336">
                                              <a href="{{url('/')}}/reportes/inscritos"><h2 data-type="mText" class="sti-item">Inscritos</h2><span data-type="icon" class="sti-icon sti-icon-reportes1 sti-item"></span></a>
                                            </li>
                                            <li data-hovercolor="#f44336">
                                                <a href="{{url('/')}}/reportes/camisetas-programacion"><h2 data-type="mText" class="sti-item">Camisetas y Programación </h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a>
                                            </li>    
                                            <li data-hovercolor="#f44336">
                                                <a href="{{url('/')}}/reportes/referidos"><h2 data-type="mText" class="sti-item">Referidos </h2><span data-type="icon" class="sti-icon sti-icon-reportes2 sti-item"></span></a>
                                            </li>
                                            <li data-hovercolor="#f44336">
                                                <a data-toggle="modal" href="{{url('/')}}/reportes/reservaciones"><h2 data-type="mText" class="sti-item">Reservaciones</h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a>
                                            </li>

                                            <div class="clearfix"></div>

                                            <li data-hovercolor="#f44336">
                                                <a data-toggle="modal" href="{{url('/')}}/reportes/credenciales"><h2 data-type="mText" class="sti-item">Credenciales</h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
@stop

@section('js') 
            
        <script type="text/javascript">

        $(document).ready(function(){

            $('body').css('background', "#fff")

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 50, 
            // paging:false, 
            order: [[0, 'asc']],
            fnDrawCallback: function() {
              $('.dataTables_paginate').show();
              /*if ($('#tablelistar tr').length < 25) {
                  $('.dataTables_paginate').hide();
              }
              else{
                 $('.dataTables_paginate').show();
              }*/
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
            },
            language: {
                            processing:     "Procesando ...",
                            search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                            searchPlaceholder: "BUSCAR",
                            lengthMenu:     " ",
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

            $('a[data-toggle="tab"]').click( function (e) {
              var tabs = e.currentTarget.hash;

              if(tabs == '#participantes'){
                $('[data-menu-color]').attr('data-menu-color', 'azul');
              }
              if(tabs == '#agendar'){
                $('[data-menu-color]').attr('data-menu-color', 'amarillo');
              }
              if(tabs == '#especiales'){
                $('[data-menu-color]').attr('data-menu-color', 'morado');
              }
              if(tabs == '#validar'){
                $('[data-menu-color]').attr('data-menu-color', 'naranja');
              }       
              if(tabs == '#punto_venta'){
                $('[data-menu-color]').attr('data-menu-color', 'verde');
              }       
              if(tabs == '#reportes'){
                $('[data-menu-color]').attr('data-menu-color', 'rojo');
              }       
          });

          $('div.tab-pane').each(function () {
              $(this).addClass("active");
          });

          $('.sti-menu').iconmenu({
              animMouseenter: {
                  'mText': {speed: 500, easing: 'easeOutExpo', delay: 200, dir: -1},
                  'sText': {speed: 500, easing: 'easeOutExpo', delay: 200, dir: -1},
                  'icon': {speed: 700, easing: 'easeOutBounce', delay: 0, dir: 1}
              },
              animMouseleave: {
                  'mText': {speed: 400, easing: 'easeInExpo', delay: 0, dir: -1},
                  'sText': {speed: 400, easing: 'easeInExpo', delay: 0, dir: 1},
                  'icon': {speed: 400, easing: 'easeInExpo', delay: 0, dir: -1}
              }
          });
          $('div.tab-pane').each(function () {
              $(this).removeClass("active");
          });

          $("div.tab-pane").first().addClass("active");
        });

    


        </script>

@stop