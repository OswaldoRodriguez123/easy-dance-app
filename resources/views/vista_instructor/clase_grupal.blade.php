@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/easy_dance_ico_5.css" rel="stylesheet">

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
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>
                            <hr class="linea-morada"> 

                            <div class="text-center"> 

                               <button class="btn btn-blanco button_izquierda" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-left zmdi-hc-fw f-20"></i></button> <span class="span_dia f-20 c-morado">LUNES</span> <button class="btn btn-blanco button_derecha" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i></button>

                                <div class="clearfix"></div>

                                <button class="no_border_button btn btn-blanco button_dia" value="1">Lun</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="2">Mar</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="3">Mier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="4">Juev</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="5">Vier</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="6">Sab</button> &nbsp; 
                                <button class="btn btn-blanco button_dia no_border_button" value="7">Dom</button>



                            </div>                                                   
                        </div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <th class="text-center operacion" data-column-id="operacion" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                                                           
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

        @if($tipo == 1)
            route_detalle="{{url('/')}}/agendar/clases-grupales/detalle";
        @elseif($tipo == 2)
            route_detalle="{{url('/')}}/agendar/clases-grupales/nivelaciones";
        @else
            route_detalle="{{url('/')}}/programacion";
        @endif

        var i;
        var hoy;
        var pagina = document.location.origin

        $(document).ready(function(){

        i = parseInt("{{$hoy}}");
        hoy = i;
        
        $(".button_izquierda").removeAttr("disabled");
        $(".button_derecha").removeAttr("disabled");


        if( i == 1){
            $(".button_izquierda").attr("disabled","disabled");
        }

        if( i == 7){
            $(".button_derecha").attr("disabled","disabled");
        }

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[3, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
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

                changeSpan();

            });

        $(".button_izquierda").click(function(){

            $(".button_derecha").removeAttr("disabled");

            i = i - 1;

            if( i <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }
            changeSpan();
        });

        $(".button_derecha").click(function(){

            $(".button_izquierda").removeAttr("disabled");

            i = i + 1;

            if( i >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }
            changeSpan();
        });

        $('.button_dia').click(function(){
            i = parseInt($(this).val());

            if( i >= 7){
                $(".button_derecha").attr("disabled","disabled");
            }else{
                $(".button_derecha").removeAttr("disabled");
            }

            if( i <= 1){
                $(".button_izquierda").attr("disabled","disabled");
            }else{
                $(".button_izquierda").removeAttr("disabled");
            }

            changeSpan();

         });

        function changeSpan(){

            if(i == hoy){
                $('.span_dia').text('HOY');
            }
            
            else if(i == 1){

                $('.span_dia').text('LUNES');

            }else if(i == 2){

                $('.span_dia').text('MARTES');

            }else if(i == 3){

                $('.span_dia').text('MIERCOLES');

            }else if(i == 4){

                $('.span_dia').text('JUEVES');

            }else if(i == 5){

                $('.span_dia').text('VIERNES');

            }else if(i == 6){

                $('.span_dia').text('SABADO');

            }else if(i == 7){

                $('.span_dia').text('DOMINGO');

            }

            $(".button_dia").removeAttr("style")

            $(".button_dia[value='"+i+"']").css("background-color", "#2196F3");
            $(".button_dia[value='"+i+"']").css("color", "white");

            rechargeClase();

        }


        function rechargeClase(){

            t.clear().draw();

            var clase_grupal = [];
            var clases_grupales = <?php echo json_encode($clase_grupal_join);?>;

             $.each(clases_grupales, function (index, array) {
                if(i == array.dia_de_semana){
                    clase_grupal.push(array);
                }
                
            });

            $.each(clase_grupal, function (index, array) {

                if(array.inicio == 0){
                    inicio = '<i class="zmdi zmdi-star zmdi-hc-fw zmdi-hc-fw c-amarillo f-20" data-html="true" data-original-title="" data-content="Esta clase grupal no ha comenzado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                }else{
                    inicio = '';
                }

                operacion = '';

                operacion += '<ul class="top-menu">'
                operacion += '<li id = dropdown_'+array.id+' class="dropdown">' 
                operacion += '<a id = dropdown_toggle_'+array.id+' href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">' 
                operacion += '<span class="f-15 f-700" style="color:black">'
                operacion += '<i class="zmdi zmdi-wrench f-20 mousedefault" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>'
                operacion += '</span></a>'
                operacion += '<div class="dropup">'
                operacion += '<ul class="dropdown-menu dm-icon pull-right" style="position:absolute;">'
                operacion += '<li class="hidden-xs">'
                operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/nivelaciones/'+array.id+'">'
                operacion += '<i class="icon_a-niveles f-16 m-r-10 boton blue"></i>'
                operacion += '&nbsp;Nivelaciones'
                operacion += '</a></li>'
                operacion += '<li class="hidden-xs">'
                operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/participantes/'+array.id+'">'
                operacion += '<i class="icon_a-participantes f-16 m-r-10 boton blue"></i>'
                operacion += 'Participantes'
                operacion += '</a></li>'
                operacion += '<li class="hidden-xs">'
                operacion += '<a onclick="procesando()" href="'+pagina+'/especiales/examenes/agregar/'+array.id+'">'
                operacion += '<i class="icon_a-examen f-16 m-r-10 boton blue"></i>'
                operacion += 'Valorar'
                operacion += '</a></li>'
                operacion += '<li class="hidden-xs">'
                operacion += '<a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/agenda/'+array.id+'">'
                operacion += '<i class="zmdi zmdi-eye f-16 boton blue"></i>'
                operacion += 'Ver Agenda'
                operacion += '</a></li>'
                operacion += '<li class="hidden-xs"> <a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/progreso/'+array.id+'">'
                operacion += '<i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i>' 
                operacion += 'Ver Progreso'
                operacion += '</a></li>'
                operacion += '</ul></div></li></ul>'
   
                var rowNode=t.row.add( [
                ''+inicio+'',
                ''+array.clase_grupal_nombre+'',
                ''+array.especialidad_nombre+'',
                ''+array.hora_inicio+ ' '+array.hora_final+'',
                ''+operacion+'',
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });

            $('[data-toggle="popover"]').popover(); 
        }

        function previa(t){
            var id = $(t).closest('tr').attr('id');
            var route =route_detalle+"/"+id;
            
            window.open(route, '_blank');;
        }

        $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

            var id = $(this).closest('tr').attr('id');
            var dropdown = $('#dropdown_'+id)
            var dropdown_toggle = $('#dropdown_toggle_'+id)

            if(!dropdown.hasClass('open')){
                dropdown.addClass('open')
                dropdown_toggle.attr('aria-expanded','true')
                $('.table-responsive').css( "overflow", "inherit" );
            }
         
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
          $('.table-responsive').css( "overflow", "auto" );
        })

    </script>
@stop