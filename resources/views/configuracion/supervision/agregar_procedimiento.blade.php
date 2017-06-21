@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')

             <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Configuración<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_edit" id="form_edit"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre</label>
                                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="150 Caracteres">
                                    </div>
                                    <div class="has-error" id="error-nombre">
                                      <span >
                                          <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="supervision_id" id="supervision_id"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar_edicion">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/supervisiones/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
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
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_f-staff f-25" id="id-supervision"></i> Agregar Supervisión</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_procedimiento" id="agregar_procedimiento"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                                  <div class="col-sm-12">

                                    <label for="id">Supervisión</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de los distintos items de supervisión que posees en tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>

                                   <div class="form-group">
                                        <label for="id">Procedimiento</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el procedimiento de los distintos items de supervisión que posees en tu academia" title="" data-original-title="Ayuda"></i>

                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                          <div class="select">
                                            

                                              @if(!isset($config_supervision_id))

                                              <select class="selectpicker" name="config_supervision_id" id="config_supervision_id" data-live-search="true">

                                                <option value="">Selecciona</option>
                                                @foreach ( $procedimientos as $configuracion )
                                                  <option value = "{{ $configuracion['id'] }}">{{ $configuracion['nombre'] }}</option>
                                                @endforeach

                                              @else
                                                <input type="hidden" name="config_supervision_id" value="{{$config_supervision_id}}">
                                                <select disabled class="selectpicker" name="config_supervision_id" id="config_supervision_id" data-live-search="true">
                                                  <option value = "{{ $config_supervision->id }}">{{ $config_supervision->nombre }}</option>
                                              @endif

                                            
                                            </select>
                                        </div>
                                        </div>
                                     <div class="has-error" id="error-config_supervision_id">
                                          <span >
                                              <small class="help-block error-span" id="error-config_supervision_id_mensaje" ></small>                               
                                          </span>
                                      </div>
                                   </div>

                                   <div class="clearfix p-b-15"></div>

                                   <div class="form-group fg-line">
                                
                                    <label for="nombre_nivel" id="id-nombre_supervision">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del item de supervision que deseas agregar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_supervision" id="nombre_supervision" placeholder="Ej. Asistencia" maxlength="150">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_supervision">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_supervision_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>


                               <br>

                              <div class="card-header text-left">

                              <button type="button" class="btn btn-blanco m-r-10 f-10" name= "agregarsupervision" id="agregarsupervision" > Agregar Linea</button>

                              </div>


                        <div class="clearfix p-b-35"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                              @if(isset($config_supervision_id))
                                @foreach ($procedimientos as $procedimiento)

                                    <?php $id = $procedimiento->id; ?>
                                    <tr id="{{$id}}" class="seleccion" data-nombre="{{$procedimiento->nombre}}" >
                                        <td class="text-center previa">{{$procedimiento->nombre}}</td>
                                        <td class="text-center disabled"> <i id={{$id}} class="zmdi zmdi-delete f-20 p-r-10 pointer acciones"></i></td>
                                      </tr>
                                @endforeach 
                              @endif
                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>

                        <div class="clearfix p-b-35"></div>
  

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
                            <div class="col-sm-12 text-left">                           

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>
                              
                              @if(!isset($config_supervision_id))
                                <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>
                              @endif

                            </div>
                        </div></form>
                    </div>
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

  if("{{!isset($config_supervision_id)}}"){
      route_agregar_procedimiento = "{{url('/')}}/agregar_procedimiento";
      route_eliminar_procedimiento = "{{url('/')}}/eliminar_procedimiento/";

  }else{
      route_agregar_procedimiento = "{{url('/')}}/agregar_procedimiento_fijo";
      route_eliminar_procedimiento = "{{url('/')}}/eliminar_procedimiento_fijo/";
  }

  route_agregar="{{url('/')}}/guardar_procedimiento";
  route_principal="{{url('/')}}/configuracion/supervisiones/procedimientos/{{$id}}";
  route_cancelar = "{{url('/')}}/cancelar_procedimiento";

  var procedimientos = <?php echo json_encode($procedimientos);?>;
  var procedimientos_usados = <?php echo json_encode($procedimientos_usados);?>;

  $(document).ready(function(){

      $.each(procedimientos, function (index, supervision) {

        if(!$.inArray(procedimientos_usados, supervision.id)){

            $("#config_supervision_id option[value='"+supervision.id+"']").attr("disabled","disabled");
            $("#config_supervision_id option[value='"+supervision.id+"']").data("icon","glyphicon-remove");
        }

      });

      $('#config_supervision_id').selectpicker('refresh')

      t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false, 
      order: [[1, 'asc']],
      fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
        $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass("disabled");
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

    $("#agregarsupervision").click(function(){

      var datos = $( "#agregar_procedimiento" ).serialize(); 
      procesando();
      var route = route_agregar_procedimiento
      var token = $('input:hidden[name=_token]').val();
      limpiarMensaje();
      $.ajax({
          url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              dataType: 'json',
              data: datos ,
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

                var nombre = respuesta.array.nombre;

                var rowId=respuesta.array.id;
                var rowNode=t.row.add( [
                ''+nombre+'',
                '<i class="zmdi zmdi-delete f-20 p-r-10 pointer"></i>'
                ] ).draw(false).node();
                $( rowNode )
                .attr('id',rowId)
                .addClass('seleccion');

                $('#nombre_supervision').val('')

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $(".procesando").removeClass('show');
              $(".procesando").addClass('hidden');
              $("#guardar").removeAttr("disabled");
              finprocesado();
              $(".cancelar").removeAttr("disabled");

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }, 1000);
          },
          error:function(msj){
            setTimeout(function(){ 
              // if (typeof msj.responseJSON === "undefined") {
              //   window.location = "{{url('/')}}/error";
              // }
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
              $(".cancelar").removeAttr("disabled");
              finprocesado();
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

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
      var padre=$(this).parents('tr');
      var token = $('input:hidden[name=_token]').val();
      var id = $(this).closest('tr').attr('id');
      $.ajax({
           url: route_eliminar_procedimiento+id,
           headers: {'X-CSRF-TOKEN': token},
           type: 'POST',
           dataType: 'json',                
          success: function (data) {
            if(data.status=='OK'){
                
                                 
            }else{
              swal(
                'Solicitud no procesada',
                'Ha ocurrido un error, intente nuevamente por favor',
                'error'
              );
            }
          },
          error:function (xhr, ajaxOptions, thrownError){
            swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
          }
        })

        t.row( $(this).parents('tr') )
          .remove()
          .draw();
    });

    function limpiarMensaje(){
      var campo = ["config_supervision_id"];
      fLen = campo.length;
      for (i = 0; i < fLen; i++) {
          $("#error-"+campo[i]+"_mensaje").html('');
      }
    }

    $("#guardar").click(function(){

      procesando();

      if("{{!isset($config_supervision_id)}}"){

        var route = route_agregar;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#agregar_procedimiento" ).serialize(); 

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
                  // finprocesado();
                  // var nType = 'success';
                  // $("#agregar_alumno")[0].reset();
                  // var nTitle="Ups! ";
                  // var nMensaje=respuesta.mensaje;
                  window.location = route_principal;
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';

                  finprocesado();

                  notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                }                       
                
              }, 1000);
            },
            error:function(msj){
              setTimeout(function(){ 
                // if (typeof msj.responseJSON === "undefined") {
                //   window.location = "{{url('/')}}/error";
                // }
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
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
      }else{
        window.location = route_principal;
      }
  });

    $("#cancelar").click(function(){

      $('#nombre_supervision').val('')

        $.ajax({
            url: route_cancelar,
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                type: 'POST',
                dataType: 'json',
            success:function(respuesta){

              t
              .clear()
              .draw();
              
              $('html,body').animate({
                scrollTop: $("#id-supervision").offset().top-90,
              }, 1500)
            },
            error:function(msj){
              setTimeout(function(){ 

               }, 1000);
            }

        });
    });

</script> 
@stop

