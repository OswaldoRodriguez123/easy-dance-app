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

    <div class="modal fade" id="modalAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title c-negro"> Registrar asistencia - Alumno (a) <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <form name="agregar_asistencia" id="agregar_asistencia"  >
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" name="pertenece" id="pertenece">
                   <input type="hidden" name="credencial" id="credencial">
                   <div class="modal-body">                           
                   <div class="row p-t-20 p-b-0">

                       <div class="col-sm-3">

                            <img name = "alumno_imagen" id ="alumno_imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                            <div class="clearfix p-b-15"></div>

                            <p class="p-l-10" id="asistencia-nombre-alumno"> </p>

                            <p class="p-l-10">Participa en :  </p>

                            <p class="p-l-10" id = "clases_grupales_alumno"></p>

                            <span class="f-16 f-700" id="acciones" name="acciones">Acciones</span>

                            <hr id="acciones_linea" name ="acciones_linea"></hr>
                            
                            <a id="url_pagar" name="url_pagar"><i class="icon_a-pagar f-25 m-r-5 boton blue sa-warning" data-original-title="Pagar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                              
                       </div>

                       <div class="col-sm-5">
                         <div class="form-group fg-line">

                            <table class="table table-striped table-bordered historial">
                             <tr class="detalle historial">
                             <td class = "historial"></td>
                             <td class="f-14 m-l-15 historial" data-original-title="" data-content="Ver historial" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-16 f-700 historial">Balance Económico: </span><span class = "f-16 f-700 historial" id="asistencia-estado_economico" name="asistencia-estado_economico"></span> <i class="zmdi zmdi-money f-20 m-r-5 historial" name="status_economico" id="status_economico"></i></td>
                            </tr>
                            </table>
                          </div>
                       </div>

                       <div class="col-sm-4">
                         <div class="form-group fg-line">
                            <label for="asistencia-estado_ausencia" class="f-16">Estado de ausencia</label>
                            <div class="clearfix p-b-15"></div>
                            <span class="text-center"><i id="asistencia-estado_ausencia" class="zmdi zmdi-label-alt-outline f-20"></i></span>
                         </div>
                       </div>
                       

                       <div class="col-sm-9">
                           <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                           <div class="fg-line">
                              <div class="select">
                                <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id" id="asistencia-clase_grupal_id" data-live-search="true">

                                  <option value="">Selecciona</option>
                                  
                                </select>
                              </div>
                            </div>
                            <div class="has-error text-danger" id="error-asistencia_clase_grupal_id_mensaje">
                              <span >
                                  <small class="help-block error-span" id="error-asistencia_clase_grupal_id_mensaje" ></small>                                
                              </span>
                          </div>


                       </div>

                       <div class="clearfix"></div> 

                   </div>
                   
                </div>
                <div class="modal-footer p-b-20 m-b-20">
                    <div class="col-sm-7 text-left">
                      <div class="procesando hidden">
                      <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                      <div class="preloader pls-purple">
                          <svg class="pl-circular" viewBox="25 25 50 50">
                              <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                          </svg>
                      </div>
                      </div>
                    </div>
                    <div class="col-sm-5">  
                      <input type="hidden" id="asistencia_id_alumno" name="asistencia_id_alumno" ></input>                          
                      <button type="button" class="btn-blanco btn m-r-10 f-16" id="permitir" name="permitir" > Permitir <i class="zmdi zmdi-check"></i></button>
                      <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div></form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalAsistenciaInstructor" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Registrar asistencia - Instructor (a) <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="agregar_asistencia_instructor" id="agregar_asistencia_instructor"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="es_instructor" id="es_instructor">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img id = "instructor_imagen" name = "instructor_imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <p class="p-l-10" id="asistencia-nombre-instructor"> </p>
                                                  
                                           </div>

                                           <div class="col-sm-9">
                                               <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id_instructor" id="asistencia-clase_grupal_id_instructor" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="has-error" id="error-asistencia_clase_grupal_id_mensaje">
                                                  <span >
                                                      <small class="help-block error-span" id="error-asistencia_clase_grupal_id_mensaje" ></small>                                
                                                  </span>
                                              </div>
                                            </div>
                                           

                                           <div class="clearfix"></div> 

                                           
                                           
                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-5">  
                                          <input type="hidden" id="asistencia_id_instructor" name="asistencia_id_instructor" ></input>                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16" id="permitir_instructor" name="permitir_instructor" > Permitir <i class="zmdi zmdi-check"></i></button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalAsistenciaStaff" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Registrar asistencia - Staff <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="agregar_asistencia_staff" id="agregar_asistencia_staff"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <p class="p-l-10" id="asistencia-nombre-staff"> </p>
                                                  
                                           </div>

                                           <div class="col-sm-9">
                                               <!-- <label for="asistencia-clase_grupal_id" class="f-16">Nombre de la clase</label>
                                               <div class="fg-line">
                                                  <div class="select">
                                                    <select class="selectpickeraaa form-control" name="asistencia_clase_grupal_id_instructor" id="asistencia-clase_grupal_id_instructor" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="has-error" id="error-asistencia_clase_grupal_id_mensaje">
                                                  <span >
                                                      <small class="help-block error-span" id="error-asistencia_clase_grupal_id_mensaje" ></small>                                
                                                  </span>
                                              </div> -->
                                            </div>
                                           

                                           <div class="clearfix"></div> 

                                           
                                           
                                       </div>
                                       
                                    </div>
                                    <div class="modal-footer p-b-20 m-b-20">
                                        <div class="col-sm-7 text-left">
                                          <div class="procesando hidden">
                                          <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                          <div class="preloader pls-purple">
                                              <svg class="pl-circular" viewBox="25 25 50 50">
                                                  <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                              </svg>
                                          </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-5">  
                                          <input type="hidden" id="asistencia_id_staff" name="asistencia_id_staff" ></input>                          
                                          <button type="button" class="btn-blanco btn m-r-10 f-16" id="permitir_staff" name="permitir_staff" > Generar <i class="zmdi zmdi-check"></i></button>
                                          <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div></form>
                                </div>
                            </div>
                        </div>
                <div class="container">
                
                    <!-- <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div>  -->
                    
                    <div class="card">
                        <div class="card-header">

                        <div class="pull-right">
                          <button class="btn btn-default btn-icon waves-effect waves-circle waves-float" name="listado" id="listado"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></button> <span class="f-14 p-t-20 text-success"><i class="p-l-5 zmdi zmdi-arrow-left zmdi-hc-fw f-16 "></i> Ver listado</span>

                        </div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                        <br>
                                                              
                        </div>

                            <div class="col-sm-12">
                               <div class="form-group fg-line ">
                                  <div class="p-t-10">
                                  <label class="radio radio-inline m-r-20">
                                      <input name="tipo" id="clases_grupales" value="clases_grupales" type="radio" checked >
                                      <i class="input-helper"></i>  
                                      Clases Grupales <i id="clases_grupales2" name="clases_grupales2" class="icon_a-clases-grupales c-verde f-20"></i>
                                  </label>
                                  <label class="radio radio-inline m-r-20">
                                      <input name="tipo" id="clases_personalizadas" value="clases_personalizadas" type="radio">
                                      <i class="input-helper"></i>  
                                      Clases Personalizadas <i id="clases_personalizadas2" name="clases_personalizadas2" class="icon_a-clase-personalizada f-20"></i>
                                  </label>
                                  <label class="radio radio-inline m-r-20">
                                      <input name="tipo" id="citas" value="citas" type="radio">
                                      <i class="input-helper"></i>  
                                      Citas <i id="citas2" name="citas2" class="zmdi zmdi-calendar-check f-20"></i>
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
                                    <th class="text-center" data-column-id="confirmacion" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="descripcion">Imagen</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Nombre</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Identificacion</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnosacademia as $alumno)
                                <?php $id = $alumno['id']; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$alumno['imagen']}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$alumno['nombre']}} {{$alumno['apellido']}}" data-identificacion-participante = "{{$alumno['identificacion']}}" data-tipo-participante = "alumno" data-sexo = "{{$alumno['sexo']}}" >

                                    <td class="text-center previa"> @if(isset($activacion[$id])) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">
                                        @if($alumno['imagen'])
                                          <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                        @else
                                            @if($alumno['sexo'] == 'M')
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                            @else
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}}</td>
                                    <td class="text-center previa">{{$alumno['identificacion']}}</td>

                                </tr>
                            @endforeach 

                            @foreach ($instructores as $instructor)
                                <?php $id = $instructor['id']; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$instructor['imagen']}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$instructor['nombre']}} {{$instructor['apellido']}}" data-identificacion-participante = "{{$instructor['identificacion']}}" data-sexo = "{{$instructor['sexo']}}" data-tipo-participante = "instructor" >
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">
                                        @if($instructor['imagen'])
                                          <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$instructor['imagen']}}" alt="">
                                        @else
                                            @if($instructor['sexo'] == 'M')
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                            @else
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$instructor['nombre']}} {{$instructor['apellido']}}</td>
                                    <td class="text-center previa">{{$instructor['identificacion']}} <i class="icon_a-instructor"></i></td>

                                </tr>
                            @endforeach 

                            @foreach ($staff as $alumno)
                                <?php $id = $alumno->id; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-id-participante = "{{$id}}" data-nombre-participante = "{{$alumno->nombre}} {{$alumno->apellido}}" data-identificacion-participante = "{{$alumno->identificacion}}" data-tipo-participante = "staff">
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">
                                        <!-- if($alumno['imagen'])
                                            <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/instructor/{{$alumno['imagen']}}" alt="">
                                        else -->
                                            <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                                        <!-- endif -->
                                    </td>
                                    <td class="text-center previa">{{$alumno->nombre}} {{$alumno->apellido}}</td>
                                    <td class="text-center previa">{{$alumno->identificacion}} <i class="icon_f-staff"></i></td>

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

      route_consultar_cg="{{url('/')}}/asistencia/consulta/clases-grupales";
      route_consultar_cp="{{url('/')}}/asistencia/consulta/clases-personalizadas";
      route_consultar_ci="{{url('/')}}/asistencia/consulta/citas";
      route_agregar_asistencia="{{url('/')}}/asistencia/agregar";
      route_agregar_asistencia_otros="{{url('/')}}/asistencia/agregar/otros";
      route_agregar_asistencia_instructor="{{url('/')}}/asistencia/agregar/instructor";
      route_agregar_asistencia_staff="{{url('/')}}/asistencia/agregar/staff";

      var estatus = <?php echo json_encode($estatus);?>;

      var tipo = 1;

        $(document).ready(function(){

          $("#clases_grupales").prop("checked", true);

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25,  
            order: [[1, 'asc']],
            fnDrawCallback: function() {
            if ("{{count($alumnosacademia)}}" < 25) {
                  $('.dataTables_paginate').hide();
                  $('#tablelistar_length').hide();
              }else{
                 $('.dataTables_paginate').show();
              }
            },
            pageLength: 25,
            language: {
                  searchPlaceholder: "Buscar"
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","buscar(this)" );
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

    // $('#buscar').on( 'keyup', function () {
    //   asistencia.search( this.value ).draw();
    // });

    $("#listado").on('click',function(){
      window.location = "{{url('/')}}/asistencia";
    });

    $("#permitir").on('click',function(){
      if(tipo == 1){
        var route = route_agregar_asistencia;
      }else{
        var route = route_agregar_asistencia_otros
      }
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia" ).serialize(); 
      limpiarMensaje();
      procesando();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
        success:function(respuesta){ 

          finprocesado();           
    
          $("#agregar_asistencia")[0].reset();
          $("#asistencia-horario").text("---");
          $('#modalAsistencia').modal('hide');
          swal("Permitido!", respuesta.mensaje, "success");
          $("#content").toggleClass("opacity-content");
          $("header").toggleClass("abierto");
          $("footer").toggleClass("opacity-content");

        },
        error:function(msj){
          errores(msj.responseJSON.errores);
          finprocesado();

          if(msj.responseJSON.status != 'ERROR'){

            swal({   
                title: "¿Desea permitir la entrada?",   
                text: msj.responseJSON.text,   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Permitir!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
              if (isConfirm) {
                $('#'+msj.responseJSON.campo).val(1)
                $('#permitir').click();
                
              }
            });  

          }else{
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";

            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          } 
        }
          
      });
  });


    $("#permitir_instructor").on('click',function(){
      var route = route_agregar_asistencia_instructor;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){  
            console.log(respuesta)          
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia_instructor")[0].reset();
              $("#asistencia-horario-instructor").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              $('#modalAsistenciaInstructor').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content"); 
            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              console.log(msj);
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }
          },
           error:function(msj){
          errores(msj.responseJSON.errores);
          finprocesado();

          if(msj.responseJSON.status != 'ERROR'){

            swal({   
                title: "¿Desea permitir la entrada como suplente?",   
                text: msj.responseJSON.text,   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Permitir!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
              if (isConfirm) {
                $('#'+msj.responseJSON.campo).val(1)
                $('#permitir_instructor').click();
                
              }
            });  

          }else{
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";

            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          } 
        }
     }); 
  });

$("#permitir_staff").on('click',function(){
      var route = route_agregar_asistencia_staff;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia_staff" ).serialize(); 
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){  
            console.log(respuesta)          
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia_staff")[0].reset();
              $("#asistencia-horario-staff").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              $('#modalAsistenciaStaff').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content"); 
            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              console.log(msj);
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }
          },
          error:function(msj){
            errores(msj.responseJSON.errores);
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            if(msj.responseJSON.status=="ERROR"){
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
            }
          }
        });
    });
    

    $('#asistencia-clase_grupal_id').on('change', function(){

      alumno_id = $('#asistencia_id_alumno').val();
      clase_grupal_id = $(this).val();
      $("#asistencia-estado_ausencia").removeClass('c-verde')
      $("#asistencia-estado_ausencia").removeClass('c-amarillo')
      $("#asistencia-estado_ausencia").removeClass('c-rojo')

      existe = false;

      $.each(estatus, function (index, array) { 

        if(array.alumno_id == alumno_id && array.clase_grupal_id == clase_grupal_id){
          existe = true;
          estatus = array.estatus
        }

      });

      if(existe == true){

        $("#asistencia-estado_ausencia").addClass(estatus)

      }

      if ($(this).val()=='') {
        $("#asistencia-horario").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario").text(valor[1]);
      }
    });


     $('#asistencia-clase_grupal_id_instructor').on('change', function(){
      if ($(this).val()=='') {
        $("#asistencia-horario-instructor").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario-instructor").text(valor[1]);
      }
    });

     function buscarStaff(t){
        procesando();

        var row = $(t).closest('tr');

        var id_instructor = $(row).data('id-participante');
        var nombre_instructor = $(row).data('nombre-participante');

        $('#asistencia_id_staff').val(id_instructor);
        $('#asistencia-nombre-staff').text(nombre_instructor);
        $("#asistencia-horario-staff").text("---");

        finprocesado();
        $('#modalAsistenciaStaff').modal('show');


      }

      function buscarInstructor(t){
        procesando();

        var row = $(t).closest('tr');

        var id_instructor = $(row).data('id-participante');
        var nombre_instructor = $(row).data('nombre-participante');
        var imagen = $(row).data('imagen');
        var sexo = $(row).data('sexo');

        if(imagen){
          $('#instructor_imagen').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
        }else{
          if(sexo == 'M'){
            $('#instructor_imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
          }else{
            $('#instructor_imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
          }
        }

        $('#asistencia_id_instructor').val(id_instructor);
        $('#asistencia-nombre-instructor').text(nombre_instructor);
        $("#asistencia-horario-instructor").text("---");

        var route = route_consultar_cg;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          success:function(respuesta){
            
            $('#asistencia-clase_grupal_id_instructor').empty();        
            $('#asistencia-clase_grupal_id_instructor').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) {                     
              $('#asistencia-clase_grupal_id_instructor').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id));

            });

            finprocesado();
            $('#modalAsistenciaInstructor').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });
      }


      function buscarAlumno(t){
        procesando();
        $('#clases_grupales_alumno').empty();

        var row = $(t).closest('tr');

        var id_alumno = $(row).data('id-participante');
        var nombre_alumno = $(row).data('nombre-participante');
        var imagen = $(row).data('imagen');
        var sexo = $(row).data('sexo');

        if(imagen){
          $('#alumno_imagen').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
        }else{
          if(sexo == 'M'){
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
          }else{
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
          }
        }

        $('#asistencia_id_alumno').val(id_alumno);
        $('#asistencia-nombre-alumno').text(nombre_alumno);
        $("#url_pagar").attr("href", "{{url('/')}}/participante/alumno/deuda/"+id_alumno);

        $("#asistencia-horario").text("---");

        if(tipo == 1){
          var route = route_consultar_cg;
        }else if(tipo == 2){
          var route = route_consultar_cp;
        }else{
          var route = route_consultar_ci;
        }

        console.log(route);
        
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: "&id="+id_alumno,
          success:function(respuesta){
            $.each(respuesta.inscripciones, function (index, array) { 
              if(array.diferencia > 1){
                restan = 'Restan '
                dias = ' dias'
              }else{
                restan = 'Resta '
                dias = ' dia'
              }
              $('#clases_grupales_alumno').append('<p>' + array.nombre + ' <br>' + array.hora_inicio + ' / ' + array.hora_final + ' <br> ' + array.dia)
              if(array.fecha_pago){
                $('#clases_grupales_alumno').append(' <br> ' + 'Fecha de Pago: ' + array.fecha_pago + ' <br> ' + restan + array.diferencia + dias + '</p>')
              }else{
                $('#clases_grupales_alumno').append('</p>')
              }
            });
            
            $('#asistencia-clase_grupal_id').empty();        
            $('#asistencia-clase_grupal_id').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) {                   
              $('#asistencia-clase_grupal_id').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id));
            });

            $('#asistencia-estado_economico').text(respuesta.deuda);
            if(respuesta.deuda > 0){
              $( "#url_pagar" ).show();
              $( "#acciones" ).show();
              $( "#acciones_linea" ).show();
              $("#status_economico").removeClass("c-verde");
              $("#status_economico").addClass("c-youtube");
            }else{
              $( "#url_pagar" ).hide();
              $( "#acciones" ).hide();
              $( "#acciones_linea" ).hide();
              $("#status_economico").removeClass("c-youtube");
              $("#status_economico").addClass("c-verde");
            }
            finprocesado();
            $('#modalAsistencia').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });

      }


      function permitir_instructor(){
        var route = route_agregar_asistencia_instructor_permitir;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:datos,
            success:function(respuesta){  
              console.log(respuesta)          
              if(respuesta.status=="OK"){
                $('#modalAsistencia').modal('hidden');
                
              }else{
                var nType = 'danger';
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }
              
            },
            error:function(msj){
              var nType = 'danger';
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              if(msj.responseJSON.status=="ERROR"){
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
              }
              
            }
            
          });
      }

      $('#modalAsistencia').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })

      $('#modalAsistenciaInstructor').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })

      $('#modalAsistenciaStaff').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })


    $('body').on('click', '#what_we_do, #menuTopConfig, #main,#content, footer, header.abierto', function(e){

            $("#content").removeClass("opacity-content");
            $("footer").removeClass("opacity-content");
            $("header").removeClass("abierto");
            $("#main").removeClass("opacity-content");
            $("#chat").removeClass("toggled");
            $("#what_we_do").removeClass("opacity-content");
            if($("#buscar").val() != '')
            {
              $("#buscar").val('');
              asistencia.search('').draw();
            }

        });
        // $('body').on('change', '#menu-trigger.open', function(e){

        //     $("#content").addClass("opacity-content");
        //     $("footer").addClass("opacity-content");
        //     $("header").addClass("abierto");
        //     console.log('aside');
        // });


        // $('body').on('click', '#chat-trigger', function(e){

        //   var cuerpo = '';
          
        //   if(!$('#chat').hasClass('toggled') && aside_loaded == 0){

        //     $.each(alumnos_aside, function (index, array) {

        //       id = array.id
        //       cuerpo += '<div class="listview">'
        //       cuerpo += '<a class="lv-item" href="javascript:void(0)"  >'
        //       cuerpo += '<div class="media">'
        //       cuerpo += '<div class="pull-left p-relative">'

        //       if(array.imagen){
        //         cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/'+array.imagen+'" alt="">'
        //       }else{
        //         if(array.sexo == 'M')
        //         {
        //           cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">'
        //         }else{
        //           cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">'
        //         }
        //       }

        //       cuerpo += '<i class="chat-status-busy"></i>'
        //       cuerpo += '</div>'
        //       cuerpo += '<div class="media-body">'
        //       cuerpo += '<div class="lv-title">'+array.nombre+' '+array.apellido+'</div>'
        //       cuerpo += '<small class="lv-small">'+array.identificacion+'</small>'
        //       cuerpo += '</div></div></a></div>'

        //       var rowNode=asistencia.row.add( [
        //         ''+cuerpo+''
        //       ] ).draw(false).node();
        //       $( rowNode )
        //         .attr('id','asistencia_alumno_row_'+id)
        //         .attr('data-imagen',array.imagen)
        //         .attr('data-id-participante',array.id)
        //         .attr('data-nombre-participante',array.nombre+' '+array.apellido)
        //         .attr('data-identificacion-participante',array.identificacion)
        //         .attr('data-tipo-participante',"alumno")
        //         .attr('data-sexo',array.sexo)
              

        //       $('#aside_body').append(cuerpo)

        //       cuerpo = '';
                
        //     }); 

        //     $.each(instructores_aside, function (index, array) {
   
        //       cuerpo += '<div class="listview">'
        //       cuerpo += '<a class="lv-item" href="javascript:void(0)"  >'
        //       cuerpo += '<div class="media">'
        //       cuerpo += '<div class="pull-left p-relative">'
        //       cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">'
               

        //       cuerpo += '<i class="chat-status-busy"></i>'
        //       cuerpo += '</div>'
        //       cuerpo += '<div class="media-body">'
        //       cuerpo += '<div class="lv-title">'+array.nombre+' '+array.apellido+'</div>'
        //       cuerpo += '<small class="lv-small">'+array.identificacion+' <i class="icon_a-instructor"></i></small>'
        //       cuerpo += '</div></div></a></div>'

        //       id = array.id
        //       var rowNode=asistencia.row.add( [
        //         ''+cuerpo+''
        //       ] ).draw(false).node();
        //       $( rowNode )
        //         .attr('id','asistencia_alumno_row_'+id)
        //         .attr('data-imagen',array.imagen)
        //         .attr('data-id-participante',array.id)
        //         .attr('data-nombre-participante',array.nombre+' '+array.apellido)
        //         .attr('data-identificacion-participante',array.identificacion)
        //         .attr('data-tipo-participante',"insctructor")
              

        //       cuerpo = '';
                
        //     }); 

        //     aside_loaded = 1;   

        //     setTimeout(function() {
        //       $('#mCSB_1_container').css('width', '');
        //       $('#mCSB_1_container').css('left', '');
        //     },2000);
        //     finprocesado();                                  
            
        //   }

        
            
        // });

    function buscar(t){

        var row = $(t).closest('tr');
        var tipo= $(row).data('tipo-participante');
        if(tipo=="alumno"){
          buscarAlumno(t);
        }else if(tipo=="instructor"){
          buscarInstructor(t);
        }else{
          buscarStaff(t);
        }

    }

     $("#clases_grupales").click(function(){
          $( "#clases_personalizadas2" ).removeClass( "c-verde" );
          $( "#citas2" ).removeClass( "c-verde" );
          $( "#clases_grupales2" ).addClass( "c-verde" );
          tipo = 1;
      });

      $("#clases_personalizadas").click(function(){
          $( "#clases_grupales2" ).removeClass( "c-verde" );
          $( "#citas2" ).removeClass( "c-verde" );
          $( "#clases_personalizadas2" ).addClass( "c-verde" );
          tipo = 2;
      });

      $("#citas").click(function(){
          $( "#clases_grupales2" ).removeClass( "c-verde" );
          $( "#clases_personalizadas2" ).removeClass( "c-verde" );
          $( "#citas2" ).addClass( "c-verde" );
          tipo = 3;
      });

      function limpiarMensaje(){
        var campo = ["asistencia_clase_grupal_id"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

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
          $("#error-"+n+"_mensaje").html(error);             
       });
    });     

  }

    </script>

@stop