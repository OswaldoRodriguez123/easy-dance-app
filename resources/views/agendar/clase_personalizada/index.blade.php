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

            <div class="modal fade" id="modalCancelada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"> Clase Cancelada <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                         <div class="modal-body">                           
                         <div class="row p-t-20 p-b-0">

                             <div class="col-sm-3">

                                  <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                  <div class="clearfix p-b-15"></div>

                                  <span class="f-15 f-700 span_instructor"></span>

                                    
                             </div>

                             <div class="col-sm-9">
                               
                              <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                              <p class="f-16">Fecha: <span class="f-700 span_fecha"></span></p> 

                                 <div class="clearfix"></div> 
                                 <div class="clearfix p-b-15"></div>


                             </div>

                             
                         </div>

                         <div class="row p-t-20 p-b-0">

                           <hr style="margin-top:5px">
                           <div class="col-sm-12">
                     
                            <label class ="razon_cancelacion" for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelación</label>
                            <br></br>

                            <div class="fg-line">
                              <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" disabled></textarea>
                              </div>
                          </div>

                         </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"> Cancelar una clase <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="cancelar_clase" id="cancelar_clase"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="clasepersonalizada_id" id="clasepersonalizada_id"></input>  
                          <input type="hidden" name="tipo" id="tipo" value="1"></input>  
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">

                             <div class="col-sm-3">

                                  <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                  <div class="clearfix p-b-15"></div>

                                  <span class="f-15 f-700 span_instructor"></span>

                                    
                             </div>

                             <div class="col-sm-9">
                               
                              <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                              <p class="f-16">Fecha: <span class="f-700 span_fecha"></span></p> 

                                 <div class="clearfix"></div> 
                                 <div class="clearfix p-b-15"></div>


                             </div>

                             
                          </div>

                           <div class="row p-t-20 p-b-0">

                           <hr style="margin-top:5px">

                           <div class="col-sm-12">
                     
                            <label for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelar la clase</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica las razones por el cual estás cancelando o bloqueando la clase" title="" data-original-title="Ayuda"></i>
                            <br></br>

                            <div class="fg-line">
                              <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" placeholder="Ej. No podré  asistir por razones ajenas a mi voluntad"></textarea>
                              </div>
                            <div class="has-error" id="error-razon_cancelacion">
                              <span >
                                <small class="help-block error-span" id="error-razon_cancelacion_mensaje" ></small>                                           
                              </span>
                            </div>
                          </div>

                           </div>
                           
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-6 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-6">                          
                              <button type="button" class="btn-blanco btn m-r-10 f-16 cancelar_clase" id="cancelar_clase" name="cancelar_clase" > Completar la cancelación</button>
                              <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <a href="{{url('/')}}/agendar/clases-personalizadas/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">


                        <div class="card-header">

                            <div class ="col-md-12 text-right">  
                                                      
                               <span class="f-16 p-t-0 text-success">Agregar una Clase Personalizada <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 

                            </div>

                        
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada f-25"></i> Sección de Clases Personalizadas</p>
                            <hr class="linea-morada">  

                            <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="A" type="radio">
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="F" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="canceladas" value="C" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-close zmdi-hc-fw f-20"></i>
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
                                    <th class="text-center" data-column-id="acepto" data-order="desc"></th>
                                    <th class="text-center" data-column-id="alumno" data-order="desc">Alumno</th>
                                    <th class="text-center" data-column-id="clase_personalizada" data-order="desc">Clase</th>
                                    <th class="text-center" data-column-id="horas" data-order="desc">Horas Restantes</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc" >Fecha</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc" >Hora</th>
                                    <th class="text-center" data-column-id="operaciones" data-order="desc" id="operaciones">Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                              @foreach($clases_personalizadas as $clase_personalizada)

                                <?php 

                                  $id = $clase_personalizada['id'];
                                  $tipo = $clase_personalizada['tipo'];

                                  if($clase_personalizada['cantidad_horas'] > 1){
                                    $horas = 'Horas';
                                  }else{
                                    $horas = 'Hora';
                                  }

                                ?>

                                <tr id="{{$id}}" class="seleccion" data-tipo = "{{$tipo}}">

                                  @if($tipo == 'F')

                                    @if(isset($asistencias[$id]))
                                      <td class="text-center previa"><span style="display: none">{{$tipo}}</span><i class="zmdi c-verde zmdi-check zmdi-hc-fw f-20"></i></td>
                                    @else

                                      <td class="text-center previa"><span style="display: none">{{$tipo}}</span><i class="zmdi c-youtube zmdi-close zmdi-hc-fw f-20"></i></td>
                                    @endif
                                  @else
                                    <td class="text-center previa"><span style="display: none">{{$tipo}}</span></td>
                                  @endif

                                  <td class="text-center previa">{{$clase_personalizada['alumno_nombre']}} {{$clase_personalizada['alumno_apellido']}}</td>
                                  <td class="text-center previa">{{$clase_personalizada['clase_personalizada_nombre']}}</td>
                                  <td class="text-center previa">{{$clase_personalizada['cantidad_horas']}} {{$horas}}</td>
                                  <td class="text-center previa">{{$clase_personalizada['instructor_nombre']}} {{$clase_personalizada['instructor_apellido']}}</td>
                                  <td class="text-center previa">{{$clase_personalizada['fecha_inicio']}}</td>
                                  <td class="text-center previa">{{$clase_personalizada['hora_inicio']}} - {{$clase_personalizada['hora_final']}}</td>
                                  @if($tipo == 'A')
                                    <td class="text-center previa">

                                      <!-- <i data-toggle="modal" name="operacion" class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i> -->

                                      <ul class="top-menu">
                                          <li class="dropdown" id="dropdown_{{$id}}">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_{{$id}}">
                                                 <span class="f-15 f-700" style="color:black"> 
                                                      <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                                 </span>
                                              </a>
                                              <div class="dropup">
                                                  <ul class="dropdown-menu dm-icon pull-right">

                                                      <li class="hidden-xs">
                                                          <a onclick="procesando()" href="{{url('/')}}/agendar/clases-personalizadas/multihorario/{{$id}}"><i class="zmdi zmdi-calendar-note f-16 boton blue"></i> Multihorario</a>
                                                      </li>

                                                      <li class="hidden-xs">
                                                          <a onclick="procesando()" href="{{url('/')}}/agendar/clases-personalizadas/agenda/{{$id}}"><i class="zmdi zmdi-eye f-16 boton blue"></i> Agenda</a>
                                                      </li>

                                                      <li class="hidden-xs cancelar">
                                                          <a><i class="zmdi zmdi-close-circle-o f-16 c-youtube"></i> Cancelar Clase</a>
                                                      </li>


                                                      <li class="hidden-xs eliminar">
                                                          <a class="pointer eliminar"><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>
                                                      </li>

                                                  </ul>
                                              </div>
                                          </li>
                                      </ul>

                                    </td>

                                  @else
                                    <td class="text-center previa"></td>
                                  @endif

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
            
        route_detalle="{{url('/')}}/agendar/clases-personalizadas/detalle"
        route_operacion="{{url('/')}}/agendar/clases-personalizadas/operaciones"
        route_configuracion="{{url('/')}}/agendar/clases-personalizadas/configurar"
        route_eliminar="{{url('/')}}/agendar/clases-personalizadas/eliminar/";
        route_principal="{{url('/')}}/agendar/clases-personalizadas";
        route_cancelar="{{url('/')}}/agendar/clases-personalizadas/cancelar";
        route_cancelarpermitir="{{url('/')}}/agendar/clases-personalizadas/cancelarpermitir";
            
        $(document).ready(function(){

        $("#activas").prop("checked", true);

         $("#imagen_principal").bind("change", function() {
            
            setTimeout(function(){
              var fileinput = $("#imagena img").attr('src');
              var image64 = $("input:hidden[name=imageBase64]").val(fileinput);
            },500);

        });

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,  
        order: [[5, 'asc'], [6, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
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
          .columns(0)
          .search('A')
          .draw(); 
    
			});
        
      function previa(t){
        
        var row = $(t).closest('tr');

        if(row.data('tipo') == 'A'){

          var id = $(row).attr('id');
          var route =route_detalle+"/"+id;
          window.open(route, '_blank');


        }else if(row.data('tipo') == 'C'){

          var fecha = $(row).find('td').eq(4).html();
          var hora = $(row).find('td').eq(5).html();
          var instructor = $(row).find('td').eq(3).html();
          var cancelacion = row.data('cancelacion');
          $('.span_fecha').text(fecha)
          $('.span_hora').text(hora)
          $('.span_instructor').text(instructor)
          $('.razon_cancelacion').text(cancelacion)
          $("#modalCancelada" ).modal('show');

        }
      }

      $('.cancelar').on('click', function(){
        var row = $(this).closest('tr');
        var id = $(row).attr('id')

        var fecha = $(row).find('td').eq(4).html();
        var hora = $(row).find('td').eq(5).html();
        var instructor = $(row).find('td').eq(3).html();
        $('.span_fecha').text(fecha)
        $('.span_hora').text(hora)
        $('.span_instructor').text(instructor)
        $('#clasepersonalizada_id').val(id)

        $("#modalCancelar" ).modal('show');
      })



      $('#tablelistar tbody').on( 'click', 'i.zmdi-wrench', function () {

            var id = $(this).closest('tr').attr('id');
            var route =route_operacion+"/"+id;
            window.open(route, '_blank');;
         });


      function countChar2(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum2').text(2000 - len);
        }
      };

      function countChar3(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum3').text(2000 - len);
        }
      };

      function countChar4(val) {
        var len = val.value.length;
        if (len >= 10000) {
          val.value = val.value.substring(0, 10000);
        } else {
          $('#charNum4').text(10000 - len);
        }
      };

      $("#guardar").click(function(){

                var route = route_configuracion;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#configuracion_clase_personalizada" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
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
                          finprocesado();
                          var nType = 'success';
                          // $("#agregar_alumno")[0].reset();
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        } 

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");
                          $('.modal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                                              
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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

        function limpiarMensaje(){
        var campo = ["imagen", "descripcion", "video_promocional", "ventajas", "imagen1", "imagen2", "imagen3"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
      var campo = ["imagen", "descripcion", "video_promocional", "ventajas", "imagen1", "imagen2", "imagen3"];
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });   

  }

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
                        template: '<div data-growl="container" class="alert f-700" role="alert">' +
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

        if($(this).val() == 'A'){

            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );

            t
            .columns(0)
            .search($(this).val())
            .draw(); 

        }else if($(this).val() == 'F'){

            $( "#finalizadas2" ).addClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );

            t
            .columns(0)
            .search($(this).val())
            .draw();

        }else{

            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).addClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );

            t
            .columns(0)
            .search($(this).val())
            .draw();

        }

    });

     $(".eliminar").click(function(){
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar la clase personalizada?",   
                text: "Tenga en cuenta que los horarios creados para esta clase personalizada tambien seran eliminados!",    
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
      if (isConfirm) {
        var route = route_eliminar + id;
        var token = '{{ csrf_token() }}';
            
            $.ajax({
                url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'DELETE',
                dataType: 'json',
                data:id,
                success:function(respuesta){

                    procesando();
                    window.location = route_principal; 

                },
                error:function(msj){
                            // $("#msj-danger").fadeIn(); 
                            // var text="";
                            // console.log(msj);
                            // var merror=msj.responseJSON;
                            // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                            // $("#msj-error").html(text);
                            // setTimeout(function(){
                            //          $("#msj-danger").fadeOut();
                            //         }, 3000);
                            finprocesado()
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                            }
            });
            }
        });
    });

     $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

        var id = $(this).closest('tr').attr('id');
        var dropdown = $(this).closest('.dropdown')
        var dropdown_toggle = $(this).closest('.dropdown-toggle')

        $('.dropdown-toggle').attr('aria-expanded','false')
        $('.dropdown').removeClass('open')
        $('.table-responsive').css( "overflow", "auto" );

        if(!dropdown.hasClass('open')){
            dropdown.addClass('open')
            dropdown_toggle.attr('aria-expanded','true')
            $('.table-responsive').css( "overflow", "inherit" );
        }
     
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
      $('.table-responsive').css( "overflow", "auto" );
   }) 

    $(".cancelar_clase").click(function(){

        var id = $('#clasepersonalizada_id').val()
    
         swal({   
                    title: "Desea cancelar la clase personalizada",   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
          procesando();
         var route = route_cancelar;
         var token = '{{ csrf_token() }}';
         var datos = $( "#cancelar_clase" ).serialize(); 
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        window.location = route_principal; 

                    },
                    error:function(msj){
                    if (typeof msj.responseJSON === "undefined") {
                      window.location = "{{url('/')}}/error";
                    }
                    $(".modal").modal('hide');
                    finprocesado();
                    swal({ 
                    title: 'El estatus de esta clase es de "cancelación tardía", al cancelarla de igual manera será debitada económicamente al participante. ¿ Desea proceder ?',   
                    text: "Confirmar cancelación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Confirmar cancelación!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true,
                    html: true
                }, function(isConfirm){   
                  if (isConfirm) {
                    procesando();
                    var route = route_cancelarpermitir + id;

                    $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){

                        window.location = route_principal; 

                    },
                    error:function(msj){

                            // if (typeof msj.responseJSON === "undefined") {
                            //     window.location = "{{url('/')}}/error";
                            //  }


    
                            }
                        });
                    }
                });
             }
         });
        }
      });
    });


		</script>
@stop

     