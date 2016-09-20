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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        <div class="text-left"><a class="text-success f-20" href="{{url('/')}}/reportes/asistencias">Reporte</a></div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                                                              
                        </div>

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="alumnos" value="alumnos" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Alumnos <i id="alumnos2" name="alumnos2" class="icon_a-participantes c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="instructores" value="instructores" type="radio">
                                        <i class="input-helper"></i>  
                                        Instructores <i id="instructores2" name="instructores2" class="icon_a-instructor f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                        <div class="clearfix p-b-15"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="clase">Clase</th>
                                    <th class="text-center" data-column-id="instructor">Instructor</th>
                                    <th class="text-center" data-column-id="participante" id="participante">Participante</th>
                                    <th class="text-center" data-column-id="hora" id="hora">Hora</th>
                                </tr>
                            </thead>
                            <tbody>

                                                           
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

        $(document).ready(function(){

        $("#alumnos").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[0, 'desc'], [4, 'desc']],
        fnDrawCallback: function() {
        if ("{{count($alumnos_asistencia)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }
        },
        pageLength: 25,
        language: {
              searchPlaceholder: "Buscar"
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "disabled");
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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    }
                });

                rechargeAlumno();
            });

         $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.location=route;
         });

         function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='alumnos') {
                  rechargeAlumno();
            } else  {
                  rechargeInstructor();
            }
         });

        function rechargeAlumno(){
            var alumno = <?php echo json_encode($alumnos_asistencia);?>;

            document.getElementById('participante').innerHTML = 'Participante';
            document.getElementById('hora').innerHTML = 'Hora';  

            $.each(alumno, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.nombre_instructor+ ' '+array.apellido_instructor+'',
                ''+array.nombre+ ' '+array.apellido+'',
                ''+array.hora+'',
                '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeInstructor(){
            var instructor = <?php echo json_encode($instructores_asistencia);?>;

            document.getElementById('participante').innerHTML = 'Hora Entrada'; 
            document.getElementById('hora').innerHTML = 'Hora Salida'; 

            $.each(instructor, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.fecha+'',
                ''+array.clase+'',
                ''+array.nombre_instructor+ ' '+array.apellido_instructor+'',
                ''+array.hora+'',
                ''+array.hora_salida+'',
                '<i data-toggle="modal" name="correo" class="zmdi zmdi-email f-20 p-r-10"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        $("#alumnos").click(function(){
            $( "#instructores2" ).removeClass( "c-verde" );
            $( "#alumnos2" ).addClass( "c-verde" );
        });

        $("#instructores").click(function(){
            $( "#alumnos2" ).removeClass( "c-verde" );
            $( "#instructores2" ).addClass( "c-verde" );
        });

        $('#tablelistar tbody').on( 'click', 'i.icon_a-pagar', function () {
            var id = $(this).closest('tr').attr('id');
            window.location = route_gestion + id;
        });

        $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
                var id = $(this).closest('tr').attr('id');
                var element = this;
                swal({   
                    title: "Desea eliminar la factura proforma ?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id, element);
          }
                });
            });
      function eliminar(id, element){

          var token = "{{ csrf_token() }}"
                $.ajax({
                    url: route_eliminar+id,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        t.row( $(element).parents('tr') )
                        .remove()
                        .draw();
                              
                    },
                    error:function(msj){
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

        </script>

@stop