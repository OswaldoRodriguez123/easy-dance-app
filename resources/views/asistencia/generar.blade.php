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

    <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                  <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Estatus de Pago<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="table-responsive row">
                    <div class="col-md-12">
                      <table class="table table-striped table-bordered text-center " id="tabledeudas" >
                        <thead>
                          <tr>
                            <th class="text-center" data-column-id="nombre">Producto o Servicio</th>
                            <th class="text-center" data-column-id="cantidad">Cantidad</th>
                            <th class="text-center" data-column-id="precio_neto">Precio Neto</th>
                            <th class="text-center" data-column-id="impuesto">Cantidad</th>
                            <th class="text-center" data-column-id="importe_neto" data-order="desc">Importe (Neto)</th>
                            <th class="text-center" data-column-id="fecha_vencimiento" data-order="desc">Fecha Vencimiento</th>
                            <th class="text-center" data-column-id="estatus" data-order="desc">Estatus</th>
                          </tr>
                        </thead>
                        <tbody>
                                                     
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div><!--  COL-SM-12 -->
              </div><!-- ROW -->

              <div class="clearfix p-b-35"></div>

              <div class="clearfix"></div> 
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

                    <a class="btn-blanco m-r-5 f-12 boton_pagar"> Pagar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                    <div class="clearfix p-b-35"></div>

                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

  <div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="modalNota-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Nota Administrativa<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_nota" id="agregar_nota"  >
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="nota_administrativa_alumno_id" id="nota_administrativa_alumno_id">
                          <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              
                              <div class="col-sm-12">
                                <div class="form-group">
      

                                <div class="clearfix p-b-35"></div>
                                
                                <label id="id-descripcion">Nota Administrativa</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la nota administrativa" title="" data-original-title="Ayuda"></i>

            
                                <div class="fg-line">
                                  <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="Ingresa la nota"></textarea>
                                </div>

                             <div class="has-error" id="error-descripcion">
                                  <span >
                                      <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                               
                                  </span>
                              </div>
                           </div>

                          <br>

                          <div class="card-header text-left">
                            <button type="button" class="btn btn-blanco m-r-10 f-10" id="añadirnota" name="añadirnota" >Agregar Linea</button>
                          </div>
                          
                          <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                            <div class="col-md-12">
                              <table class="table table-striped table-bordered text-center " id="tablenota" >
                              <thead>
                                  <tr>
                                    <th class="text-center" data-column-id="usuario">Usuario</th>
                                    <th class="text-center" data-column-id="fecha">Fecha</th>
                                    <th class="text-center" data-column-id="hora">Hora</th>
                                    <th class="text-center" data-column-id="descripcion">Descripción</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
                                  </tr>
                              </thead>
                              <tbody>

                     
                              </tbody>
                            </table>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>



                    <div class="clearfix p-b-35"></div>

                      <div class="clearfix"></div> 
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

                              <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


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


                            <span class="f-16 f-700" id="acciones" name="acciones">Acciones</span>

                            <hr id="acciones_linea" name ="acciones_linea"></hr>
                            
                            <a class="boton_pagar" ><i class="icon_a-pagar f-25 m-r-5 boton blue sa-warning" data-original-title="Pagar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                            <a data-toggle="modal" href="#modalPago"><i class="zmdi zmdi-label-alt-outline f-25 m-r-5 boton blue sa-warning pointer" data-original-title="Ver Estatus" data-toggle="tooltip" data-placement="bottom" title=""></i></a>

                            <div class="nota_menu">
                              <a data-toggle="modal" href="#modalNota">
                                <i class="zmdi zmdi-assignment f-25 m-r-5 boton blue sa-warning pointer" data-original-title="Notas Administrativas" data-toggle="tooltip" data-placement="bottom" title=""></i>
                              <i class="nota_cantidad">0</i>
                              </a>
                            </div>
                              
                       </div>

                       <div class="col-sm-4">
                         <div class="form-group fg-line">

                            <table class="table table-striped table-bordered historial">
                             <tr class="detalle historial">
                             <td class = "historial"></td>
                             <td class="f-14 m-l-15 historial" data-original-title="" data-content="Ver historial" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-16 f-700 historial">Balance Económico: </span><span class = "f-16 f-700 historial" id="asistencia-estado_economico" name="asistencia-estado_economico"></span> <i class="zmdi zmdi-money f-20 m-r-5 historial" name="status_economico" id="status_economico"></i></td>
                            </tr>
                            </table>
                          </div>
                       </div>

                       <div class="col-sm-5">
                          <div class="col-sm-6">
                            <label for="asistencia-estado_ausencia" class="f-16">Estatus de C</label>
                            <div class="clearfix p-b-15"></div>
                            <span class="text-center"><i id="asistencia-estado_ausencia" class="zmdi zmdi-label-alt-outline f-20"></i></span>
                          </div>
                          <div class="col-sm-6">
                            <label for="asistencia-credenciales" class="f-16">Credenciales</label>
                            <div class="clearfix p-b-15"></div>
                            <span class="text-center" id="asistencia-credenciales">0</span>
                          </div>
                       </div>
                       

                      <div class="col-sm-9">
                        <label for="asistencia_clase_grupal_id" class="f-16">Nombre de la clase</label>
                        <div class="select">
                          <select class="selectpicker form-control" name="asistencia_clase_grupal_id" id="asistencia_clase_grupal_id" data-live-search="true">
                            <option value="">Selecciona</option>
                          </select>
                        </div>
                        <div class="has-error text-danger" id="error-asistencia_clase_grupal_id">
                          <span >
                            <small class="help-block error-span" id="error-asistencia_clase_grupal_id_mensaje" ></small>
                          </span>
                        </div>

                        <p class="p-l-10">Participa en :  </p>
                        <p class="p-l-10" id = "clases_grupales_alumno"></p>

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
                                               <label for="asistencia_clase_grupal_id_instructor" class="f-16">Nombre de la clase</label>
                                                  <div class="select">
                                                    <select class="selectpicker form-control" name="asistencia_clase_grupal_id_instructor" id="asistencia_clase_grupal_id_instructor" data-live-search="true">

                                                      <option value="">Selecciona</option>
                                                      
                                                    
                                                    </select>
                                                  </div>
                                                <div class="has-error" id="error-asistencia_clase_grupal_id_instructor">
                                                  <span >
                                                      <small class="help-block error-span" id="error-asistencia_clase_grupal_id_instructor_mensaje" ></small>                                
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
                
                    
                    <div class="block-header">

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
               
                       <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    <div class="clearfix"></div>
                    
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

                            @foreach ($alumnos as $alumno)
                              <?php $id = $alumno['id']; 

                                if($alumno['imagen']){
                                        $imagen = '/assets/uploads/usuario/'.$alumno['imagen'];
                                    }else{
                                        if($alumno['sexo'] == 'F'){
                                            $imagen = '/assets/img/Mujer.jpg';
                                        }else{
                                            $imagen = '/assets/img/Hombre.jpg';
                                        }
                                    }


                                $contenido = 
                                '<p class="c-negro">' .
                                    $alumno['nombre'] . ' ' . $alumno['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .

                                'Clase Grupal: ' . $alumno['nombre_clase']  . '<br>'.
                                'Día: ' . $alumno['dia_clase'] . '<br>'.
                                'Hora: ' . $alumno['hora_clase'] . '<br>'.
                                'Instructor: ' . $alumno['instructor_clase'] . '<br></p>';

                              ?>


                              <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$alumno['imagen']}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$alumno['nombre']}} {{$alumno['apellido']}}" data-identificacion-participante = "{{$alumno['identificacion']}}" data-tipo-participante = "alumno" data-sexo = "{{$alumno['sexo']}}" >

                                <td class="text-center previa"> @if(isset($activacion[$id])) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                <td class="text-center previa">
                                  @if($alumno['imagen'])
                                    <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$alumno['imagen']}}" alt="">
                                  @else
                                    @if($alumno['sexo'] == 'M')
                                      <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                    @else
                                      <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                    @endif
                                  @endif
                                </td>
                                <td class="text-center previa">{{$alumno['nombre']}} {{$alumno['apellido']}}</td>
                                <td class="text-center previa">{{$alumno['identificacion']}}</td>

                              </tr>
                            @endforeach 

                            @foreach ($instructores as $instructor)

                              <?php $id = $instructor['id']; 

                                if($instructor['imagen']){
                                        $imagen = '/assets/uploads/usuario/'.$instructor['imagen'];
                                    }else{
                                        if($instructor['sexo'] == 'F'){
                                            $imagen = '/assets/img/Mujer.jpg';
                                        }else{
                                            $imagen = '/assets/img/Hombre.jpg';
                                        }
                                    }


                                $contenido = 
                                '<p class="c-negro">' .
                                    $instructor['nombre'] . ' ' . $instructor['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br></p>';

                              ?>
                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$instructor['imagen']}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$instructor['nombre']}} {{$instructor['apellido']}}" data-identificacion-participante = "{{$instructor['identificacion']}}" data-sexo = "{{$instructor['sexo']}}" data-tipo-participante = "instructor" >
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">
                                      @if($instructor['imagen'])
                                        <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$instructor['imagen']}}" alt="">
                                      @else
                                        @if($instructor['sexo'] == 'M')
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                        @else
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$instructor['nombre']}} {{$instructor['apellido']}}</td>
                                    <td class="text-center previa">{{$instructor['identificacion']}} <i class="icon_a-instructor"></i></td>

                                </tr>
                            @endforeach 

                            @foreach ($staffs as $staff)

                                <?php $id = $staff['id']; 

                                if($staff['imagen']){
                                        $imagen = '/assets/uploads/usuario/'.$staff['imagen'];
                                    }else{
                                        if($staff['sexo'] == 'F'){
                                            $imagen = '/assets/img/Mujer.jpg';
                                        }else{
                                            $imagen = '/assets/img/Hombre.jpg';
                                        }
                                    }


                                $contenido = 
                                '<p class="c-negro">' .
                                    $staff['nombre'] . ' ' . $staff['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br></p>';

                              ?>

                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" id="asistencia_alumno_row_{{$id}}" class="seleccion" data-id-participante = "{{$id}}" data-nombre-participante = "{{$staff['nombre']}} {{$staff['apellido']}}" data-tipo-participante = "staff">
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">
                                      @if($staff['imagen'])
                                        <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$staff['imagen']}}" alt="">
                                      @else
                                        @if($staff['sexo'] == 'M')
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                        @else
                                          <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$staff['nombre']}} {{$staff['apellido']}}</td>
                                    <td class="text-center previa">{{$staff['identificacion']}} <i class="icon_f-staff"></i></td>

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
      route_historial = "{{url('/')}}/participante/alumno/historial/";
      route_agregar_nota="{{url('/')}}/participante/alumno/agregar-nota-administrativa";
      route_actualizar_nota="{{url('/')}}/participante/alumno/actualizar-nota-administrativa";
      route_eliminar_nota="{{url('/')}}/participante/alumno/eliminar-nota-administrativa/";

      var tipo = 1;

      $(document).ready(function(){
        $("#clases_grupales").prop("checked", true);
          
      })

      t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,  
        order: [[2, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","buscar(this)" );
        },
        drawCallback: function(){
          loadImages();
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

      d=$('#tabledeudas').DataTable({
        processing: true,
        serverSide: false,
        bPaginate: false,
        bInfo:false,
        bFilter:false,
        order: [[0, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
          $('td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "disabled");
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

      n=$('#tablenota').DataTable({
          processing: true,
          serverSide: false,
          pageLength: 25,  
          paging: false,
          searching:false,
          order: [[1, 'desc'],[2, 'desc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "text-center" );
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "disabled" );
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

      function loadImages(){
        imagenes = $('.lazy')

        $.each(imagenes, function(){
            var this_image = this;
            var src = $(this_image).data('image');
            this_image.src = src;
        });
      };

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
      procesando();
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){  
            finprocesado();      
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
            finprocesado();
            if(msj.responseJSON.status != 'ERROR'){

              swal({   
                  title: "¿Desea permitir la entrada como suplente?",   
                  text: msj.responseJSON.mensaje,   
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
              swal("Error!", msj.responseJSON.mensaje, "error");
            } 
          }
       }); 
    });

  $("#permitir_staff").on('click',function(){
    var route = route_agregar_asistencia_staff;
    var token = $('input:hidden[name=_token]').val();
    var datos = $( "#agregar_asistencia_staff" ).serialize(); 
    procesando();
    $.ajax({
      url: route,
      headers: {'X-CSRF-TOKEN': token},
      type: 'POST',
      dataType: 'json',
      data:datos,
        success:function(respuesta){  
          finprocesado();      
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
          finprocesado();
          swal("Error!", msj.responseJSON.mensaje, "error");
        }
      });
    });
    

    $('#asistencia_clase_grupal_id').on('change', function(){
        if ($(this).val()=='') {
          $("#asistencia-horario").text("---");           
        }else{
          $var = valor=$(this).val().split('-');
          $("#asistencia-horario").text(valor[1]);
        }
    });

    $('#asistencia_clase_grupal_id_instructor').on('change', function(){
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
          data: "&id="+id_instructor,
          success:function(respuesta){
            
            $('#asistencia_clase_grupal_id_instructor').empty();        
            $('#asistencia_clase_grupal_id_instructor').append( new Option("Selecciona",""));

            $.each(respuesta.clases_grupales, function (index, array) { 

              var opt = document.createElement('option');
              opt.value = array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id;

              if(!array.bloqueado){
                if(!array.asistencia){
                  valor = array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor
                }else{
                  valor = "<span title='Ya posee una asistencia' class='c-youtube'><i class='glyphicon glyphicon-remove'></i> "+array.nombre +"  -   Desde:"+array.hora_inicio+"  /   Hasta:"+array.hora_final + "  -  "+ array.instructor+"</span>"
                  opt.setAttribute('disabled', true);
                }
              }else{
                valor = "<span title='Clase Bloqueada' class='c-youtube'><i class='glyphicon glyphicon-remove'></i> "+array.nombre +"  -   Desde:"+array.hora_inicio+"  /   Hasta:"+array.hora_final + "  -  "+ array.instructor+"</span>"
                opt.setAttribute('disabled', true);
              } 

              opt.setAttribute('data-content', valor);

              $('#asistencia_clase_grupal_id_instructor').append(opt);    

            });

            $('#asistencia_clase_grupal_id_instructor').selectpicker('refresh')

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
        d.clear().draw();

        var row = $(t).closest('tr');

        var alumno_id = $(row).data('id-participante');
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

        $('#asistencia_id_alumno').val(alumno_id);
        $('#asistencia-nombre-alumno').text(nombre_alumno);
        $(".boton_pagar").attr("href", "{{url('/')}}/participante/alumno/deuda/"+alumno_id);

        $("#asistencia-horario").text("---");

        if(tipo == 1){
          var route = route_consultar_cg;
        }else if(tipo == 2){
          var route = route_consultar_cp;
        }else{
          var route = route_consultar_ci;
        }
        
        var token = "{{ csrf_token() }}";

        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: "&id="+alumno_id,
          success:function(respuesta){
            $.each(respuesta.inscripciones, function (index, array) { 

              if(array.nota_administrativa){
                nota_administrativa = '<i class="zmdi zmdi-assignment f-20 m-l-15" data-original-title="" data-content="Nota Administrativa: '+array.nota_administrativa+'" data-toggle="popover" data-placement="top" title="" type="button" data-trigger="hover">'
              }else{
                nota_administrativa = '';
              }

              $('#clases_grupales_alumno').append('<div class="col-sm-12" style="padding-left:0px">' + array.nombre + ' <br>' + array.hora_inicio + ' / ' + array.hora_final + ' <br> ' + array.dia + ' ' + nota_administrativa + '</div>')
              $('#clases_grupales_alumno').append('<div class="clearfix p-b-35"></div>')

            });

            $('[data-toggle="popover"]').popover(); 
            
            $('#asistencia_clase_grupal_id').empty();   
            $('#asistencia_clase_grupal_id').append( new Option("Selecciona",""));

            $.each(respuesta.clases_grupales, function (index, array) { 

              var opt = document.createElement('option');
              opt.value = array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id;

              if(!array.bloqueado){

                if(!array.asistencia){
                  valor = array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor
                }else{
                  valor = "<span title='Ya posee una asistencia' class='c-youtube'><i class='glyphicon glyphicon-remove'></i> "+array.nombre +"  -   Desde:"+array.hora_inicio+"  /   Hasta:"+array.hora_final + "  -  "+ array.instructor+"</span>"
                  opt.setAttribute('disabled', true);
                }
              }else{
                valor = "<span title='Clase Bloqueada' class='c-youtube'><i class='glyphicon glyphicon-remove'></i> "+array.nombre +"  -   Desde:"+array.hora_inicio+"  /   Hasta:"+array.hora_final + "  -  "+ array.instructor+"</span>"
                opt.setAttribute('disabled', true);
              } 

              opt.setAttribute('data-content', valor);

              $('#asistencia_clase_grupal_id').append(opt);    
            });

            $('#asistencia_clase_grupal_id').selectpicker('refresh')
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

            $("#asistencia-estado_ausencia").removeClass('c-verde')
            $("#asistencia-estado_ausencia").removeClass('c-amarillo')
            $("#asistencia-estado_ausencia").removeClass('c-rojo')
            $('#pertenece').val('')
            $('#credencial').val('')
            $("#asistencia-estado_ausencia").addClass(respuesta.estatus)
            $("#asistencia-credenciales").text(respuesta.credenciales)

            $.each(respuesta.items, function (index, array) {

              if(array[0].estatus == 0){
                estatus = '<span class="c-youtube">Vencida</span>'
              }else{
                estatus = '<span>Por Cobrar</span>'
              }

              nombre = array[0].nombre;

              if(nombre.length > 15){
                nombre = nombre.substr(0, 30) + "..."
              }

              var rowId=array[0].id;
              var rowNode=d.row.add( [
                ''+nombre+'',
                ''+array[0].cantidad+'',
                ''+formatmoney(parseFloat(array[0].precio_neto))+'',
                ''+array[0].impuesto+'',
                ''+formatmoney(parseFloat(array[0].importe_neto))+'',
                ''+array[0].fecha_vencimiento+'',
                ''+estatus+'',
              ] ).draw(false).node();
              $( rowNode )
              .attr('id',rowId)
              .attr('fecha_vencimiento',array[0].fecha_vencimiento)
              .attr('tipo',array[0].tipo)
              .addClass('seleccion')
              .attr('data-trigger','hover')
              .attr('data-toggle','popover')
              .attr('data-placement','top')
              .attr('data-content','<p class="c-negro">'+array[0].nombre+'</p>')
              .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;')
              .attr('data-container','body')
              .attr('data-html','true')
              .attr('title','');
         
            });

            cantidad_notas = 0;
            n.clear().draw();

            $.each(respuesta.notas_administrativas, function (index, array) {

              var usuario = array.usuario;
              var fecha = array.fecha;
              var hora = array.hora;
              var descripcion = array.descripcion;

              var contenido = 'Descripcion: ' + descripcion + '<br>'

              if(descripcion.length > 30){
                  descripcion = descripcion.substr(0, 30) + "..."
              }

              if(!array.boolean_visto){
                cantidad_notas++;
                operacion = '<input class="mini-checkbox" type="checkbox">'
              }else{
                operacion = '<input class="mini-checkbox" type="checkbox" checked>'
              }

              operacion += ' <i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'

              var rowId=array.id;
              var rowNode=n.row.add( [
                ''+usuario+'',
                ''+fecha+'',
                ''+hora+'',
                ''+descripcion+'',
                ''+operacion+''
              ] ).draw(false).node();

              $( rowNode )
                .attr('id',rowId)
                .attr('data-trigger','hover')
                .attr('data-toggle','popover')
                .attr('data-placement','top')
                .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;&nbsp;')
                .attr('data-html','true')
                .attr('data-container','#modalNota-content')
                .attr('title','')
                .attr('data-content',contenido);

            });

            if(cantidad_notas > 0){
              $('.nota_cantidad').removeClass('nota_vacia')
            }else{
              $('.nota_cantidad').addClass('nota_vacia')
            }

            $('.nota_cantidad').text(cantidad_notas)

            $('[data-toggle="popover"]').popover();

            finprocesado();

            $('#nota_administrativa_alumno_id').val(alumno_id);
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
                $('#modalAsistencia').modal('hide');
                
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
        $("#asistencia-estado_ausencia").removeClass('c-verde')
        $("#asistencia-estado_ausencia").removeClass('c-amarillo')
        $("#asistencia-estado_ausencia").removeClass('c-rojo')
        $('#asistencia-credenciales').text(0)
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

  $(".historial").click(function(){
      alumno_id = $('#asistencia_id_alumno').val();
      if(alumno_id){
        window.location = route_historial + alumno_id;
      }
      
  });

  $("#añadirnota").click(function(){

      $("#añadirnota").attr("disabled","disabled");
      $("#añadirnota").css({
        "opacity": ("0.2")
      });

      var datos = $( "#agregar_nota" ).serialize(); 
      var route = route_agregar_nota;
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
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

                var usuario = respuesta.usuario;
                var fecha = respuesta.nota_administrativa.fecha;
                var hora = respuesta.nota_administrativa.hora;
                var descripcion = respuesta.nota_administrativa.descripcion;

                var contenido = 'Descripcion: ' + descripcion + '<br>'

                if(descripcion.length > 30){
                    descripcion = descripcion.substr(0, 30) + "..."
                }

                cantidad_notas = parseInt($('.nota_cantidad').text())
                cantidad_notas++;

                operacion = '<input class="mini-checkbox" type="checkbox">'
                operacion += ' <i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'

                $('.nota_cantidad').text(cantidad_notas)
                $('.nota_cantidad').removeClass('nota_vacia')
                
                var rowId=respuesta.nota_administrativa.id;
                var rowNode=n.row.add( [
                  ''+usuario+'',
                  ''+fecha+'',
                  ''+hora+'',
                  ''+descripcion+'',
                  ''+operacion+''
                ] ).draw(false).node();

                $( rowNode )
                  .attr('id',rowId)
                  .attr('data-trigger','hover')
                  .attr('data-toggle','popover')
                  .attr('data-placement','top')
                  .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;&nbsp;')
                  .attr('data-html','true')
                  .attr('data-container','#modalNota-content')
                  .attr('title','')
                  .attr('data-content',contenido)
                  .addClass('seleccion');

                $('[data-toggle="popover"]').popover();

                $("#agregar_nota")[0].reset();

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }  

              $("#añadirnota").removeAttr("disabled");
              $("#añadirnota").css({
                "opacity": ("1")
              });   

              $(".procesando").removeClass('show');
              $(".procesando").addClass('hidden');
              $("#guardar").removeAttr("disabled");

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

              $("#añadirnota").removeAttr("disabled");
              $("#añadirnota").css({
                "opacity": ("1")
              });  

              $("#guardar").removeAttr("disabled");
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

  $('#tablenota tbody').on( 'click', 'i.zmdi-delete', function () {
    var padre=$(this).parents('tr');
    var token = $('input:hidden[name=_token]').val();
    var id = $(this).closest('tr').attr('id');
    var route = route_eliminar_nota+id;
    swal({   
        title: "Desea eliminar la nota?",   
        text: "Confirmar eliminación!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Eliminar!",  
        cancelButtonText: "Cancelar",         
        closeOnConfirm: true 
    }, function(isConfirm){   
    if (isConfirm) {
        procesando();
        $.ajax({
             url: route,
             headers: {'X-CSRF-TOKEN': token},
             type: 'POST',
             dataType: 'json',                
            success: function (data) {
              if(data.status=='OK'){

                swal("Hecho!","Eliminado con éxito!","success");
                n.row($(padre))
                  .remove()
                  .draw();

                if(!data.boolean_visto){
                  cantidad_notas = parseInt($('.nota_cantidad').text())
                  cantidad_notas--;

                  $('.nota_cantidad').text(cantidad_notas)

                  if(cantidad_notas == 0){
                    $('.nota_cantidad').addClass('nota_vacia')
                  }
                }
                
                finprocesado();
                           
              }else{
                swal(
                  'Solicitud no procesada',
                  'Ha ocurrido un error, intente nuevamente por favor',
                  'error'
                );
                finprocesado();
              }
            },
            error:function (xhr, ajaxOptions, thrownError){
              swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
            }
          })
        }
      });   
    });

  $('#tablenota tbody').on( 'click', 'input[type="checkbox"]', function () {
    var padre=$(this).parents('tr');
    var token = $('input:hidden[name=_token]').val();
    var id = $(this).closest('tr').attr('id');

    if($(this).is(':checked')){
      boolean_visto = 1
    }else{
      boolean_visto = 0
    }

    var route = route_actualizar_nota

    $.ajax({
       url: route,
       headers: {'X-CSRF-TOKEN': token},
       type: 'POST',
       dataType: 'json', 
       data: "&id="+id+"&boolean_visto="+boolean_visto,               
      success: function (data) {
        if(data.status=='OK'){

          cantidad_notas = parseInt($('.nota_cantidad').text())

          if(boolean_visto){
            cantidad_notas--;
          }else{
            cantidad_notas++;
          }

          $('.nota_cantidad').text(cantidad_notas)

          if(cantidad_notas == 0){
            $('.nota_cantidad').addClass('nota_vacia')
          }else{
            $('.nota_cantidad').removeClass('nota_vacia')
          }

        }else{
          swal(
            'Solicitud no procesada',
            'Ha ocurrido un error, intente nuevamente por favor',
            'error'
          );
          finprocesado();
        }
      },
      error:function (xhr, ajaxOptions, thrownError){
        swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
      }
    })
  });   

  $(".dismiss").click(function(){
      procesando()
      setTimeout(function(){
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = 'success';
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out')
        var nMensaje="¡Excelente! Los cambios se han actualizado satisfactoriamente";
        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

        $('#modalNota').modal('hide');
        finprocesado();
      }, 3000);
    });

  function formatmoney(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }

  $(document).on({
    'show.bs.modal': function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    },
    'hidden.bs.modal': function() {
        if ($('.modal:visible').length > 0) {
            // restore the modal-open class to the body element, so that scrolling works
            // properly after de-stacking a modal.

          if($('.modal').hasClass('in')) {
            $('body').addClass('modal-open');
          }    

        }
    }
  }, '.modal');

  </script>

@stop