@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>


<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/asistencia" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Asistencias</a> -->

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/reportes" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Reportes</a>

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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-account-add f-25"></i> Reporte de Inscritos</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="formFiltro" id="formFiltro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">
                                <div class="col-md-4">
                                    <label>Sexo</label>


                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="sexo" id="sexo">
                                          <option value="0">Todos</option>
                                          <option value="M">Masculino</option>
                                          <option value="F">Femenino</option>
                                        </select>
                                      </div>
                                    </div>
                                  

                                    
                                </div>

                                <div class="col-md-4">
                                    <label>Edad</label> 

                                    <div class="clearfix"></div>

                                    <div class="col-md-6" style="padding-left: 0px">
                                        <input type="text" class="form-control input-sm proceso" name="edad_inicio" id="edad_inicio" placeholder="Desde" style="padding-left: 0px">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-sm proceso" name="edad_final" id="edad_final" placeholder="Hasta">
                                    </div> 

                                </div>

                                <div class="col-md-4">
                                    <label>Fecha</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">Hoy</option>
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                      </div>
                                </div>

                               <div class="clearfix m-b-20"></div>

                                <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                        <label for="nombre">Personalizar</label>
                                        <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-collapse">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                          <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">

                                                        <div class="clearfix m-b-20"></div>
                                                    

                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                            <div class="fg-line">
                                                                    <input type="text" name = "fecha" id="fecha" class="form-control" placeholder="Personalizar">
                                                            </div>
                                                        </div>

            

                                                        
                                                    </div>

                                                    <div class="clearfix p-b-35"></div>
                                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>   

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

   

                                 <!-- <div class="clearfix m-b-10"></div> -->

                                 

                                 <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="guardar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                       
                        <div class="col-md-6">
                            <h2>Informe de Inscritos</h2>
                            <hr>
                            <div id="pie-chart-procesos" class="flot-chart-pie"></div>
                            <div class="flc-pie hidden-xs"></div>
                        </div>


                        <div class="col-md-6">
                            <h2>Información</h2>
                            <hr>
                            
                            <div class="col-md-3">    
                                <i class="m-l-25 zmdi zmdi-male-alt zmdi-hc-5x c-azul"></i>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">    
                                <i class="m-r-25 zmdi zmdi-female zmdi-hc-5x c-rosado pull-right"></i>
                            </div>
                            <div class="clearfix"></div>    

                            <div class="mini-charts-item bgm-blue">
                                <div class="clearfix">
                                    <div class="count">
                                        <small>Total Inscritos:</small>
                                        <h2 id="hombres" class="pull-left m-l-30"></h2>
                                        <h2 id="mujeres" class="pull-right m-r-30"></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-md-offset-4">
                                <table class="table display cell-border" id="tipo_pago" >
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-column-id="adultos_niños">Modalidad de Pago:</th>
                                                <th class="text-center" data-column-id="cantidad"></th>
                                            </tr>
                                        </thead>

                                        <tbody>


                                            <tr>
                                                <td>
                                                    <span style="padding-left: 3%">Contado</span>
                                                </td>

                                                <td>
                                                    <span style="padding-left: 3%" id="contado">0</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span style="padding-left: 3%">Crédito</span>
                                                </td>

                                                <td>
                                                    <span style="padding-left: 3%" id="credito">0</span>
                                                </td>
                                            </tr>



                                            <tr>
                                                <td>
                                                    <span style="padding-left: 3%">Total</span>
                                                </td>

                                                <td>
                                                    <span style="padding-left: 3%" class ="total_inscritos" id="total_inscritos">0</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                            </div>
                        </div>

                    

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="nac" data-order="desc">Nacimiento</th>
                                    <th class="text-center" data-column-id="sexo" data-order="desc">Sexo</th>                    
                                    <th class="text-center" data-column-id="celular">Contacto Móvil</th>
                                    <th class="text-center" data-column-id="curso">Curso</th>
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

            <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 
            
        <script type="text/javascript">

        var clase_grupal_array = [];

        route_filtrar="{{url('/')}}/reportes/inscritos";
        route_detalle="{{url('/')}}/participante/alumno/detalle";

        $(document).ready(function(){


        //DateRangePicker
        $('#fecha').daterangepicker({
            "autoApply" : false,
            "opens": "right",
            "applyClass": "bgm-morado waves-effect",
            locale : {
                format: 'DD/MM/YYYY',
                applyLabel : 'Aplicar',
                cancelLabel : 'Cancelar',
                daysOfWeek : [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],

                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],        
            }

        });

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25, 
        order: [[1, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
    
        });

         $("#guardar").click(function(){

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

                        array = respuesta.inscritos

                        if(array[1]){
                            if(array[1].sexo == 'F'){
                                color2 = "#2196f3"
                                color1 = "#FF4081"
                            }else{
                                color1 = "#2196f3"
                                color2 = "#FF4081"
                            }
                        }


                        
                        $.each(respuesta.inscritos, function (index, array) {

                            if(array.edad >= 18){
                                if(array.sexo=='F'){
                                    sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                                }else{
                                    sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                                }
                            }else{
                                if(array.sexo=='F'){
                                    sexo = '<i class="zmdi fa fa-child f-15 c-rosado"></i> </span>'
                                }else{
                                    sexo = '<i class="zmdi fa fa-child f-15 c-azul"></i> </span>'
                                }
                            }

                            contenido = ''
                            contenido += 'Nombre: ' +array.curso+'<br>'
                            contenido += 'Especialidad: ' +array.especialidad+'<br>'
                            contenido += 'Nivel: ' +array.nivel+'<br>'
                            contenido += 'Instructor: ' +array.instructor_nombre+' ' +array.instructor_apellido+'<br>'
                            contenido += 'Horario: ' +array.hora_inicio+' - ' +array.hora_final+'<br>'
                            contenido += 'Día: ' +array.dia

                            var rowNode=t.row.add( [
                            ''+array.fecha+'',
                            ''+array.nombre+ ' ' +array.apellido+'',
                            ''+array.fecha_nacimiento+'',
                            ''+sexo+'',
                            ''+array.celular+'',
                            ''+array.curso+'',
                            ''+array.hora_inicio+ ' - ' +array.hora_final+'',
                            ] ).draw(false).node();
                            $( rowNode )
                                .attr('id',array.id)
                                .attr('data-trigger','hover')
                                .attr('data-toggle','popover')
                                .attr('data-placement','top')
                                .attr('data-content','<p class="c-negro">'+contenido+'</p>')
                                .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
                                .attr('data-html','true')
                                .attr('title','')
                                .addClass('disabled');
                        });

                        $('[data-toggle="popover"]').popover(); 

                        // sexos = respuesta.sexos

                        // if(sexos[1]){
                        //     if(sexos[1][0] == 'F'){
                        //         color1 = "#2196f3"
                        //         color2 = "#FF4081"
                        //     }else{
                        //         color2 = "#2196f3"
                        //         color1 = "#FF4081"
                        //     }
                        // }


                        datos = JSON.parse(JSON.stringify(respuesta));

                        $("#mujeres").text(datos.mujeres);
                        $("#hombres").text(datos.hombres);


                        $("#contado").text(datos.contado);
                        $("#credito").text(datos.credito);
                        $("#total_inscritos").text(datos.total_inscritos);

                        var data1 = ''
                        data1 += '[';
                        $.each( datos.horas, function( i, item ) {
                            var label = item[0];
                            var cant = item[1];
                            data1 += '{"data":"'+cant+'","label":"'+label+'"},';
                        });
                        data1 = data1.substring(0, data1.length -1);
                        data1 += ']';

                        $("#pie-chart-procesos").html('');
                        $(".flc-pie").html('');
                        $.plot('#pie-chart-procesos', $.parseJSON(data1), {
                            series: {
                                pie: {
                                    show: true,
                                    stroke: { 
                                        width: 2,
                                    },
                                },
                            },
                            legend: {
                                container: '.flc-pie',
                                backgroundOpacity: 0.5,
                                noColumns: 0,
                                backgroundColor: "white",
                                lineWidth: 0
                            },
                            grid: {
                                hoverable: true,
                                clickable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false,
                                cssClass: 'flot-tooltip'
                            },
                            // colors: [color1, color2],
                            
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

     function previa(t){
        var id = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+id;
        window.location=route;
      }
  
    
    function collapse_minus(collaps){
        $('#'+collaps).collapse('hide');
    }   

    $('#collapseTwo').on('show.bs.collapse', function () {
        $("#boolean_fecha").val('1');
        $("#tipo").attr('disabled',true);
        $("#tipo").addClass('disabled');
        $("#tipo").selectpicker('refresh');
        setTimeout(function(){ 
            $("#fecha").click();
        }, 500);
    })

    $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#tipo").attr('disabled',false);
        $("#tipo").removeClass('disabled');
        $("#tipo").selectpicker('refresh');
        $("#boolean_fecha").val('0');
    })

    $('.table-responsive').on('show.bs.popover', function () {
      $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.popover', function () {
      $('.table-responsive').css( "overflow", "auto" );
    })

</script>

@stop