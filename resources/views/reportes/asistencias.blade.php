@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/asistencia" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Asistencias</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_b-telefono f-25"></i> Informes de Asistencias</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label>Participantes</label>

                                    <select name="participante_id" id="participante_id">
                                      <option value="1">Asistentes</option>
                                      <option value="2">Inasistentes</option>
                                    </select>

                                  &nbsp; &nbsp; &nbsp; <label>Fecha</label> &nbsp; &nbsp; &nbsp;


                                <input type="text" id="fecha" name="fecha" class="date-picker proceso pointer" placeholder="Selecciona la fecha" style="display: inline; width: 10% "> 
                                
                               <!--  <div class="has-error" id="error-fecha">
                                  <span>
                                      <small class="help-block error-span" id="error-fecha_mensaje" ></small>      
                                  </span>
                              </div>
                                 -->
                                  &nbsp; &nbsp; &nbsp; <label>Clase Grupal</label> &nbsp; &nbsp; &nbsp;


                                <select name="clase_grupal_id" id="clase_grupal_id">
                                </select> 
                                
                               <!--  <div class="has-error" id="error-fecha">
                                  <span>
                                      <small class="help-block error-span" id="error-fecha_mensaje" ></small>      
                                  </span>
                              </div>
     -->

                                  &nbsp; &nbsp;&nbsp; <label>Instructor</label> &nbsp; &nbsp; &nbsp;


                                <select name="instructor_id" id="instructor_id">
                                </select> 
                                
                              <!--   <div class="has-error" id="error-instructor_id">
                                  <span>
                                      <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>      
                                  </span>
                              </div>
                                 -->

                                 <div class="clearfix m-b-10"></div>
                                 <div class="has-error" id="error-linea">
                                  <span>
                                      <small class="help-block error-span" id="error-linea_mensaje" ></small>      
                                  </span>
                                 </div>

                                 <div class="clearfix m-b-10"></div>

                                 

                                 <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                            </form>
                        </div>

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="cedula" data-order="desc">Cedula</th>
                                    <th class="text-center" data-column-id="fecha_nacimiento" data-order="desc">Fecha Nacimiento</th>
                                    <th class="text-center" data-column-id="telefono">Contacto Local</th>
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="hora">Hora</th>                                                                                                            
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

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;
        var instructores = <?php echo json_encode($instructores);?>;
        var clase_grupal_array = [];

        route_filtrar="{{url('/')}}/reportes/asistencias/filtrar";

        $(document).ready(function(){

        var hoy = moment().format('DD/MM/YYYY');

        $("#formFiltro")[0].reset();
        $('#clase_grupal_id').empty();
        $('#instructor_id').empty();

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 50, 
        // paging:false, 
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 50) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }
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
            });

        function rechargeClase(){

            $('#clase_grupal_id').empty();
            clase_grupal_array = [];

            var tmp = $("#fecha").val().split("/");
            var hoy = new Date();
            var fecha_seleccionada = new Date(tmp[2]+'-'+tmp[1]+'-'+tmp[0]);
            // if(fecha_seleccionada > hoy){
            //     $('#error-fecha_mensaje').text('Ups! Debe seleccionar una fecha menor o igual a hoy')
            //     $("#fecha").val('')
            // }else{
            // $('#error-fecha_mensaje').text('')
            var dia = fecha_seleccionada.getDay() + 1;

            $.each(clases_grupales, function (index, array) {
                if(array.dia == dia){

                    clase_grupal_array.push(array); 

                   
                    $('#clase_grupal_id').append( new Option(array.clase_grupal_nombre,array.clase_grupal_id));

                }
            });
            // }
        }

        function rechargeInstructor(){

            $('#instructor_id').empty();

            var id = $('#clase_grupal_id').val();
            $.each(clase_grupal_array, function (index, array) {
                if(array.clase_grupal_id == id){
                    $.each(instructores, function (n, arreglo) {
                        if(array.instructor_id == arreglo.id)
                        {

                            $('#instructor_id').append( new Option(arreglo.nombre + ' ' + arreglo.apellido,arreglo.id));
                        }
                    });
                }
            });
        }

        $("#fecha").on("dp.change", function (e) {

            rechargeClase();
            rechargeInstructor();
            
        });

        $('#clase_grupal_id').on('change', function() {

          rechargeInstructor();

        });

         $("#guardar").click(function(){

            $('#error-linea_mensaje').text('')

            var route = route_filtrar;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#formFiltro" ).serialize();

            procesando(); 

            t.clear().draw();


            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data:datos,
                success:function(respuesta){
                  setTimeout(function(){ 
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY"; 
                    if(respuesta.status=="OK"){

                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje=respuesta.mensaje;

                        
                    $.each(respuesta.array, function (index, array) {

                        if(array.nombre=='F'){
                            sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i>'
                        }
                        else{
                            sexo = '<i class="zmdi zmdi-male f-25 c-azul"></i>'
                        }


                        if (typeof array.fecha === "undefined") {
                            fecha = '';
                            hora = '';
                        }else{
                            fecha = array.fecha;
                            hora = array.hora;
                        }


                        var rowId=array.id;
                        var rowNode=t.row.add( [
                        ''+array.nombre+ ' '+array.apellido+ '',
                        ''+array.identificacion+'',
                        ''+array.fecha_nacimiento+'',
                        ''+array.telefono+'',
                        ''+array.celular+'',
                        ''+sexo+'',
                        ''+fecha+'',
                        ''+hora+'',
                        ] ).draw(false).node();
                        $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');
                    });
                
                    }else{
                      var nTitle="Ups! ";
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      var nType = 'danger';
                    }

                    finprocesado();                       

                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  }, 1000);
                },
                error:function(msj){
                  setTimeout(function(){ 
                    // if (typeof msj.responseJSON === "undefined") {
                    //   window.location = "{{url('/')}}/error";
                    // }
                    if(msj.responseJSON.status=="ERROR"){
                      errores(msj.responseJSON.errores);
                      var nTitle="    Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                    }else{
                      var nTitle="   Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                    }

                    finprocesado();

                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nType = 'danger';
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY";                       
                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                  }, 1000);
                }
            });

        });

    function errores(merror){

      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
          if(contador==0){
          elemento=n;
          }
          contador++;

           $.each(this, function (name, value) {              
              var error=value;
              $("#error-linea_mensaje").html(error);             
           });
        });       

    }

</script>

@stop