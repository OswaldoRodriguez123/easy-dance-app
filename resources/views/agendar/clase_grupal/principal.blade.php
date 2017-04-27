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


  <div class="modal fade" id="modalTrasladar-ClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                  <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Grupal<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <form name="form_trasladar" id="form_trasladar"  >
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <div class="modal-body">                           
                 <div class="row p-t-20 p-b-0">
                     <div class="col-sm-12">
                       <div class="form-group fg-line">
                          <label for="nombre">Clases Grupales</label>

                            <div class="select">
                                <select class="form-control" id="clase_grupal_id" name="clase_grupal_id">
                                @foreach ($clase_grupal_join as $clase_grupal )
                                  <option value = "{{ $clase_grupal['id'] }}">{{ $clase_grupal['clase_grupal_nombre'] }} - {{ $clase_grupal['hora_inicio'] }} / {{ $clase_grupal['hora_final'] }} - {{ $clase_grupal['dia_de_semana'] }} - {{ $clase_grupal['instructor_nombre'] }} {{ $clase_grupal['instructor_apellido'] }} - {{ $clase_grupal['especialidad_nombre'] }}</option>
                                @endforeach 
                                </select>
                            </div> 

                       </div>
                       <div class="has-error" id="error-clase_grupal_id">
                            <span >
                                <small class="help-block error-span" id="error-clase_grupal_id_mensaje" ></small>                                
                            </span>
                        </div>
                     </div>


                     <input type="hidden" name="id"></input>
                  

                     <div class="clearfix"></div> 
                    
                </div>
                 
              </div>
              <div class="modal-footer p-b-20 m-b-20">
                  <div class="col-sm-12 text-left">
                    <div class="procesando hidden">
                    <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                    <div class="preloader pls-purple">
                        <svg class="pl-circular" viewBox="25 25 50 50">
                            <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                        </svg>
                    </div>
                    </div>
                  </div>
                  <div class="col-sm-12">                            

                    <a class="btn-blanco m-r-5 f-12 trasladar" href="#"> Trasladar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                  </div>
              </div></form>
          </div>
      </div>
  </div>




<a href="{{url('/')}}/agendar/clases-grupales/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
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

                            <div class="col-sm-6">
                                <i class="zmdi zmdi-label-alt f-25 c-verde"></i> Activos: {{$activos}} 
                                <div class="clearfix"></div>
                                <a href="{{url('/')}}/agendar/clases-grupales/riesgo-ausencia"><i class="zmdi zmdi-label-alt f-25 c-amarillo"></i> Riesgo de Ausencia: {{$riesgo}}</a>
                                <div class="clearfix m-b-20"></div>
                                <span class="f-15">Total: {{$activos + $riesgo}}</span>
                            </div>

                            <div class="col-sm-6 text-right">
                                <span class="f-16 p-t-0 text-success">Agregar una Clase Grupal <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 
                            </div>

                            <div class="clearfix"></div>

                            <div class="text-center">
                                <p class="opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>

                                <hr class="linea-morada"> 

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

                        @if($clase_grupal_join)
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="inicio" data-order="desc"></th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="especialidad" data-order="desc">Especialidad</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Final]</th>
                                    <!--<th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Estatus E</th>-->
                                    <th class="text-center operacion" data-column-id="operacion" data-order="desc">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado clases grupales. </div>


                             </div>




                            @endif
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

        route_detalle="{{url('/')}}/agendar/clases-grupales/detalle";
        route_operacion="{{url('/')}}/agendar/clases-grupales/operaciones";
        route_progreso="{{url('/')}}/agendar/clases-grupales/progreso";
        route_participantes="{{url('/')}}/agendar/clases-grupales/participantes";
        route_principal="{{url('/')}}/agendar/clases-grupales";

        var clases_grupales = <?php echo json_encode($clase_grupal_join);?>;

        var i;
        var hoy;

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
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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

             $.each(clases_grupales, function (index, array) {
                if(i == array.dia_de_semana){
                    clase_grupal.push(array);
                }
                
            });

            var pagina = document.location.origin

            $.each(clase_grupal, function (index, array) {

                    operacion = ''
                    if(array.inicio == 0){
                        inicio = '<i class="zmdi zmdi-star zmdi-hc-fw zmdi-hc-fw c-amarillo f-20" data-html="true" data-original-title="" data-content="Esta clase grupal no ha comenzado" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>'
                    }else{
                        inicio = '';
                    }

                    operacion += '<ul class="top-menu">'
                    operacion += '<li class="dropdown">' 
                    operacion += '<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">' 
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
                    operacion += '<li class="hidden-xs"> <a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/multihorario/'+array.id+'">'
                    operacion += '<i class="zmdi zmdi-calendar-note f-16 boton blue"></i>'
                    operacion += 'Multihorario'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs"> <a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/progreso/'+array.id+'">'
                    operacion += '<i class="icon_e-ver-progreso f-16 m-r-10 boton blue"></i>' 
                    operacion += 'Ver Progreso'
                    operacion += '</a></li>'
                    operacion += '<li class="hidden-xs"><a onclick="procesando()" href="'+pagina+'/agendar/clases-grupales/canceladas/'+array.id+'">'
                    operacion += '<i class="zmdi zmdi-close-circle-o f-20 boton red sa-warning"></i>'
                    operacion += 'Cancelar Clase'
                    operacion += '</a></li>'
                    operacion += '</ul></div></li></ul>'
       
                    var rowNode=t.row.add( [
                    ''+inicio+'',
                    ''+array.clase_grupal_nombre+'',
                    ''+array.instructor_nombre+ ' ' +array.instructor_apellido+ '',
                    ''+array.especialidad_nombre+'',
                    ''+array.hora_inicio+ ' '+array.hora_final+'',
                    ''+operacion+''
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                        .addClass('seleccion');
                });
        }

    function previa(t){
        var row = $(t).closest('tr').attr('id');

        id_alumno = "{{Session::get('id_alumno')}}";
        if(!id_alumno){
            var route =route_detalle+"/"+row;
        }
        else{
            var route =route_participantes+"/"+row;
        }
        
        window.location=route;
      }

 

    // $('#tablelistar tbody').on( 'hover', 'a.dropdown-toggle', function () {
    //     console.log('entro')

    //   if($('.dropdown').hasClass('open')){

    //   }else{
    //     $( this ).click();
    //   }
     
    // });


    $(".trasladar").click(function(){
      id = this.id;
      swal({   
          title: "Desea trasladar todos los alumnos inscritos a la clase grupal seleccionada?",   
          text: "Tenga en cuenta que la otra clase grupal sera eliminada",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Trasladar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                      
            trasladar();
            }
        });
    });

    function trasladar(){
      var route = route_trasladar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_trasladar" ).serialize();

      procesando();
              
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
          dataType: 'json',
          data:datos,
          success:function(respuesta){

              window.location=route_principal; 

          },
          error:function (msj, ajaxOptions, thrownError){
            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              var nType = 'danger';
              if(msj.responseJSON.status=="ERROR"){
                errores(msj.responseJSON.errores);
                var nTitle=" Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle=" Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              finprocesado();
                
            }, 1000);             
          }
      });
    }

  $('#tablelistar tbody').on( 'click', 'a.cancelado', function () {
    var id = $(this).closest('tr').attr('id');
    $('input[name=id]').val(id)
    $('#modalCancelar').modal('show')
  });

  $('#tablelistar tbody').on( 'click', 'a.modal_trasladar', function () {
    var id = $(this).closest('tr').attr('id');
    $('input[name=id]').val(id)
    $('#modalTrasladar-ClaseGrupal').modal('show')
  });



    $('#tablelistar tbody').on( 'mouseenter', 'i.zmdi-wrench', function () {

      if($('.dropdown').hasClass('open')){

      }else{
        $( this ).click();
      }
     
    });

    $('.table-responsive').on('show.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
    })

    </script>
@stop