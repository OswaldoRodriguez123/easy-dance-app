@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@stop
@section('content')

            <div class="modal fade" id="modalObservacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Alumno: <span id="span_alumno"></span> <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_editar" id="form_editar"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Observación</label>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="observacion" name="observacion" rows="2" placeholder="500 Caracteres"></textarea>
                                    </div>
                                 </div>
                                    <div class="has-error" id="error-observacion">
                                      <span >
                                          <small id="error-descripcion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" id="tipo_usuario_id" name="tipo_usuario_id"></input>
                               <input type="hidden" id="tipo_evento_id" name="tipo_evento_id" value="{{$id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12" href="#" id="editar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas/progreso/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                          <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                              <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                              
                              <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                              
                              <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                              
                              <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                             
                              <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                              
                          </ul>

                        @endif
                    </div>  
                    
                    <div class="card">
                      <div class="card-header">

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales p-r-5"></i> Clase: {{$clasegrupal->nombre}}</p>
                        <hr class="linea-morada">

                        <div class="col-sm-6 text-left">
                          <div class="p-t-10"> 
                            <i class="zmdi zmdi-female f-25 c-rosado"></i> <span class="f-15" id="span_mujeres" style="padding-left:5px"> {{$mujeres}}</span>
                            <i class="zmdi zmdi-male-alt p-l-5 f-25 c-azul"></i> <span class="f-15" id="span_hombres" style="padding-left:5px"> {{$hombres}} </span>
                          </div>
                        </div>
                      </div>

                      <div class="clearfix"></div>        

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

                        <div class="clearfix p-b-35"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="iconos"></th>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Contribuyo</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Contribución</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnos_inscritos as $alumno)
                              <?php 
                                
                                $contenido = '';

                                $id = $alumno['id'];

                                if($alumno['imagen']){
                                    $imagen = '/assets/uploads/usuario/'.$alumno['imagen'];
                                }else{
                                    if($alumno['sexo'] == 'F'){
                                        $imagen = '/assets/img/Mujer.jpg';
                                    }else{
                                        $imagen = '/assets/img/Hombre.jpg';
                                    }
                                }

                                if($alumno['tipo'] == 1){

                                 	if($alumno['boolean_franela'] && $alumno['boolean_programacion']){

	                                	$camiseta_programacion = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-16 f-700"></i>';
	                                }else{
	                                	if($alumno['boolean_franela'] == 0 && $alumno['boolean_programacion'] == 0){

	                                      	$camiseta_programacion = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i> <i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>';
	                                    }else{

	                                      	if($alumno['boolean_franela']){
	                                        	$camiseta_programacion = '<i class="zmdi c-youtube icon_a-examen zmdi-hc-fw f-16 f-700"></i>';
	                                      	}else{
	                                        	$camiseta_programacion = '<i class="zmdi c-youtube icon_f-productos zmdi-hc-fw f-16 f-700"></i>';
	                                      	}

	                                    }
	                                }

                                  if($alumno['tipo_pago'] == 1){
                                    $tipo_pago = 'Contado';
                                  }else if($alumno['tipo_pago'] == 2){
                                    $tipo_pago = 'Crédito';
                                  }else{
                                    $tipo_pago = 'Sin Confirmar';
                                  }

	                                $talla_franela = $alumno['talla_franela'];

                                }else{
                              		$camiseta_programacion = '';
                              		$talla_franela = '';
                              		$deuda = 0;
                                  $tipo_pago = '';
                                }

                                $contenido = 

                                '<p class="c-negro">' .
                                	$alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .

                                	'Camiseta y Programación: ' . $camiseta_programacion . '<br>'.
                                	'Talla: ' . $talla_franela . '<br>'.
                                  'Modalidad de pago: <span id="tipo_pago_'.$id.'">' . $tipo_pago . '</span><br>'.
                                  'Registro de llamada: ' . $alumno['llamadas'] . '<br>'.
                                '</p>';

                              ;?>


                              <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion" data-observacion="{{$alumno['observacion']}}" data-nombre="{{$alumno['nombre']}} {{$alumno['apellido']}}">

                                  
                                <td class="text-center previa"> 
                                  <span style="display: none">1</span>
                                  @if($alumno['activacion']) 
                                    <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>

                                  @endif
                                </td>
                                <td class="text-center previa">
                                  @if($alumno['imagen'])
                                    <img class="lv-img" src="{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                  @else
                                      @if($alumno['sexo'] == 'M')
                                        <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                      @else
                                        <img class="lv-img" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                      @endif
                                  @endif
                                </td>                                <td class="text-center previa">
                                @if($alumno['sexo']=='F')
                                  <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> 
                                @else
                                  <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i>
                                @endif
                                </td>
                                <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}} </td>
                                <td class="text-center previa">
                                  @if($alumno['contribuyo'])
                                    <i class="zmdi zmdi-mood c-verde zmdi-hc-fw f-20 p-r-3"></i>
                                  @else
                                    <i class="zmdi zmdi-mood-bad c-youtube zmdi-hc-fw f-20 p-r-3"></i>
                                  @endif
                                </td>
                                <td class="text-center"> 
                                  {{ number_format($alumno['contribucion'], 2, '.' , '.') }}

                                </td>
                                <td class="text-center previa">

                                  <i data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" data-content = "Ver Observación" class="zmdi zmdi-search f-20 p-r-10 pointer"></i> 

                                  <i id="estatus-{{$id}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" class="zmdi {{ empty($alumno['observacion']) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw" data-content = "{{ empty($alumno['observacion']) ? 'No Posee Observación' : 'Posee Observación' }}"></i>
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

        route_editar="{{url('/')}}/especiales/campañas/progreso/clases-grupales/editar";

        var hombres = "{{$hombres}}";
        var mujeres = "{{$mujeres}}";

        t=$('#tablelistar').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,  
          paging: false,
          order: [[4, 'asc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "disabled" );
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

        function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
                $.growl({
                    icon: icon,
                    title: titulo,
                    message: mensaje,
                    url: ''
                },{
                        element: 'body',
                        type: type,
                        allow_dismiss: true,
                        placement: {
                                from: from,
                                align: align
                        },
                        offset: {
                            x: 20,
                            y: 85
                        },
                        spacing: 10,
                        z_index: 1070,
                        delay: 2500,
                        timer: 2000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                                enter: animIn,
                                exit: animOut
                        },
                        icon_type: 'class',
                        template: '<div data-growl="container" class="alert" role="alert">' +
                                        '<button type="button" class="close" data-growl="dismiss">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '<span class="sr-only">Close</span>' +
                                        '</button>' +
                                        '<span data-growl="icon"></span>' +
                                        '<span data-growl="title"></span>' +
                                        '<span data-growl="message"></span>' +
                                        '<a href="#" data-growl="url"></a>' +
                                    '</div>'
                });
            };

        


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

    $('#tablelistar tbody').on( 'click', 'i.zmdi-search', function () {

        var id = $(this).closest('tr').attr('id');
        var nombre = $(this).closest('tr').data('nombre');
        var observacion = $(this).closest('tr').data('observacion');

        $('#tipo_usuario_id').val(id);
        $('#span_alumno').text(nombre);
        $('#observacion').val(observacion);
        
        $('#modalObservacion').modal('show');
    });

    $("#editar").click(function(){

      var route = route_editar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_editar" ).serialize(); 
      procesando();  
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

                $('#'+respuesta.id).data('observacion',respuesta.observacion)

                if(respuesta.observacion){
                  $("#estatus-"+respuesta.id).removeClass('c-amarillo zmdi-dot-circle');
                  $("#estatus-"+respuesta.id).addClass('c-verde zmdi-check');
                }else{
                  $("#estatus-"+respuesta.id).removeClass('c-verde zmdi-check');
                  $("#estatus-"+respuesta.id).addClass('c-amarillo zmdi-dot-circle');
                }

                $('.modal').modal('hide')

                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;                                      
          
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
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
              }
              if(msj.responseJSON.status=="ERROR"){
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

  </script>

@stop