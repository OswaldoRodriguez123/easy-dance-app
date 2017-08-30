@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
@stop

@section('content')

            <div class="modal fade" id="modalNombre-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_clase_personalizada" id="edit_nombre_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Salsa Casino">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_clase_personalizada" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCosto-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_clase_personalizada" id="edit_costo_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo</label>
                                    <input type="text" class="form-control input-sm input-mask" name="costo" id="costo" data-mask="00000000" placeholder="Ej. 5000" value="{{$clasepersonalizada->costo}}">
                                 </div>
                                 <div class="has-error" id="error-costo">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_costo_clase_personalizada" data-update="costo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalHora-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_hora_clase_personalizada" id="edit_hora_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label>Cantidad de Horas</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cantidad_horas" id="cantidad_horas" data-mask="000" placeholder="Ej. 10" value="{{$clasepersonalizada->cantidad_horas}}">
                                 </div>
                                 <div class="has-error" id="error-cantidad_horas">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_horas_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_hora_clase_personalizada" data-update="hora" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalEtiqueta-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_etiqueta_clasepersonalizada" id="edit_etiqueta_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="cp-container">
                                        <label for="fecha_cobro" id="id-color_etiqueta">Color de etiqueta</label>
                                        <div class="input-group form-group">

                                            <span class="input-group-addon"><i class="zmdi zmdi-invert-colors f-22"></i></span>
                                            <div class="fg-line dropdown">
                                                <input type="text" name="color_etiqueta" id="color_etiqueta" class="form-control cp-value proceso pointer" value="{{$clasepersonalizada->color_etiqueta}}" data-toggle="dropdown">
                                                    
                                                <div class="dropdown-menu">
                                                    <div class="color-picker" data-cp-default="{{$clasepersonalizada->color_etiqueta}}"></div>
                                                </div>
                                                
                                                <i class="cp-value"></i>
                                            </div>
                                            <div class="has-error" id="error-color_etiqueta">
                                                <span >
                                                      <small class="help-block error-span" id="error-color_etiqueta_mensaje" ></small>                                           
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_etiqueta_clasepersonalizada" data-update="etiqueta" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_clase_personalizada" id="edit_imagen_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div class="form-group fg-line">
                                        <label for="id">Cargar Imagen</label>
                                        <div class="clearfix p-b-15"></div>
                                        <input type="hidden" name="imageBase64" id="imageBase64">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput">
                                          @if($clasepersonalizada->imagen)
                                          <img src="{{url('/')}}/assets/uploads/clase_personalizada/{{$clasepersonalizada->imagen}}" style="line-height: 150px;">
                                          @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen" id="imagen" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="has-error" id="error-imagen">
                                      <span >
                                          <small id="error-imagen_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_clase_personalizada" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

             <div class="modal fade" id="modalExpiracion-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="width:70%">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_expiracion_clasepersonalizada" id="edit_expiracion_clasepersonalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="form-group">

                                    <div class="col-sm-12">
                                        <label for="tiempo_expiracion" id="id-tiempo_expiracion">Cancelación temprana/ tardía</label>
                                      </div>

                                        <div class="clearfix p-b-35"></div>
                                        
                                        <div class="col-sm-12" style="width:43%">
                                        <label for="tiempo_expiracion" id="id-tiempo_expiracion">Culmina el plazo de cancelación temprana en </label>
                                        </div>
                                        <div class="col-sm-12 text-center" style="width:10%">
                                        <input type="text" class="form-control input-sm input-mask" name="tiempo_expiracion" id="tiempo_expiracion" data-mask="00" placeholder="Ej. 24">
                                        </div>

                                        <div class="col-sm-12" style="width:45%">
                                        <label for="tiempo_expiracion"> horas antes del inicio de la clase personalizada</label>

                                      </div>

                                      <br><br>
                                  <div class="col-sm-12">
                                    <div class="has-error" id="error-tiempo_expiracion">
                                      <span >
                                          <small id="error-tiempo_expiracion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_expiracion_clasepersonalizada" data-update="tiempo_expiracion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDescripcion-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion_taller" id="edit_descripcion_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Descripción</label>
                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)">{{$clasepersonalizada->descripcion}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>
                                 </div>
                                    <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small id="error-descripcion_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$clasepersonalizada->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_descripcion_clase_personalizada" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <!-- END -->

            <div class="modal fade" id="modalPrecio-ClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title bg-gris-oscuro">Editar Clase Personalizada<button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_precio_clase_personalizada" id="edit_precio_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                        <div class="row p-l-10 p-r-10">
                              <div class="panel-body">
                                      <input type="hidden" name="id" id="id" value="{{$clasepersonalizada->id}}"></input>

                    
                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-6">
                                        <label for="nombre" id="id-participantes">Ingresa la cantidad de participantes</label>
                                        <input type="text" class="form-control input-sm" name="participantes" id="participantes" data-mask="0000" placeholder="Ej. 3" value="">
                                      </div>

                                      <div class="col-sm-6">
                                        <label for="nombre" id="id-precio">Ingresa el precio</label>
                                        <input type="text" class="form-control input-sm" name="precio" id="precio" data-mask="0000000000" placeholder="Ej. 35000" value="">
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="col-md-2">
                                  <button type="button" class="btn btn-blanco m-r-8 f-10" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                </div>

                                <div class="col-sm-6">
                                  <div class="has-error" id="error-participantes">
                                        <span >
                                          <small class="help-block error-span" id="error-participantes_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="has-error" id="error-precio">
                                        <span >
                                          <small class="help-block error-span" id="error-precio_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix p-b-35"></div>
                      

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="participantes">Participantes</th>
                                    <th class="text-center" data-column-id="precio">Precio</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($precios as $precio)
                                <?php $id = $precio->id; ?>
                                <tr id="{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$precio->participantes}}</td>
                                    <td class="text-center previa">{{$precio->precio}}</td>
                                    <td class="text-center"> <i class="zmdi zmdi-delete f-20 p-r-10"></i></i></td>
                                  </tr>
                            @endforeach 
                         
                            </tbody>
                          </table>

                        </div>
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

                                        <a class="btn-blanco m-r-5 f-12 dismiss" href="#" id="dismiss" name="dismiss" data-formulario="edit_precio_clase_personalizada" data-update="precio" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                                      </div>
                                  </div></form>
                        

                        </div>
                        </div>
                    </div>
                </div>
            </div> 


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/clases-personalizadas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección clase personalizada</a>

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
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
                            <div class="text-center p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a-clase-personalizada"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main-planilla">Vista Clase Personalizada</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo clase personalizada</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>

                                  <!-- <a href="{{url('/')}}/configuracion/clases-personalizadas/participantes/{{$clasepersonalizada->id}}"><i class="icon_a-participantes f-16 m-r-5 boton blue"  data-original-title="Participantes" data-toggle="tooltip" data-placement="bottom" title=""></i></a> -->
                                  <i class="zmdi zmdi-delete f-20 m-r-10 boton red sa-warning" id="{{$clasepersonalizada->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos de la Clase Personalizada</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                           <tr class="detalle" data-toggle="modal" href="#modalNombre-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($clasepersonalizada->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-clase-personalizada f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-nombre" class="capitalize">{{$clasepersonalizada->nombre}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCosto-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo" class="zmdi {{ empty($clasepersonalizada->costo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                               <span class="f-14"> Costo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-costo"><span>{{ number_format($clasepersonalizada->costo, 2, '.' , '.') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalHora-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad_horas" class="zmdi {{ empty($clasepersonalizada->cantidad_horas) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-time f-22"></i> </span>
                               <span class="f-14"> Cantidad de Horas </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-cantidad_horas"><span>{{$clasepersonalizada->cantidad_horas}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDescripcion-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($clasepersonalizada->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Descripción </span>
                             </td>
                             <td id="clasepersonalizada-descripcion" class="f-14 m-l-15" data-valor="{{$clasepersonalizada->descripcion}}" ><span ><span>{{ str_limit($clasepersonalizada->descripcion, $limit = 30, $end = '...') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEtiqueta-ClasePersonalizada">
                               <td>
                                 <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-color_etiqueta" class="zmdi  {{ empty($clasepersonalizada->color_etiqueta) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                                 <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-invert-colors f-22"></i> </span>
                                 <span class="f-14"> Color de Etiqueta  </span>
                               </td>
                               <td  class="f-14 m-l-15">
                                <span id="clasepersonalizada-color_etiqueta">{{$clasepersonalizada->color_etiqueta}}</span> &nbsp; <i id="color_etiqueta_container" class="color_etiqueta_container" style="background-color: {{$clasepersonalizada->color_etiqueta}}"></i><span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span>
                               
                                </td>
                              </tr> 
                              <tr class="detalle" data-toggle="modal" href="#modalImagen-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imageBase64" class="zmdi {{ empty($clasepersonalizada->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalExpiracion-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tiempo_expiracion" class="zmdi {{ empty($clasepersonalizada->tiempo_expiracion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-cancelacion-temprana-tardia zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Cancelación temprana/ tardía </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="clasepersonalizada-tiempo_expiracion">{{$clasepersonalizada->tiempo_expiracion}}</span> Horas <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalPrecio-ClasePersonalizada">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-precios" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-examen f-22"></i> </span>
                               <span class="f-14"> Opciones Avanzadas  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="clasepersonalizada-precios" ></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>


                           </table>

                          
                          <div class="clearfix"></div>   
               
           
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
    route_update="{{url('/')}}/configuracion/clases-personalizadas/update";
    route_eliminar="{{url('/')}}/configuracion/clases-personalizadas/eliminar/";
    route_principal="{{url('/')}}/configuracion/clases-personalizadas";
    route_cancelar="{{url('/')}}/configuracion/clases-personalizadas/cancelar/";
    route_cancelarpermitir="{{url('/')}}/configuracion/clases-personalizadas/cancelarpermitir/";

    route_agregar="{{url('/')}}/configuracion/clases-personalizadas/agregar_costo_fijo";
    route_delete="{{url('/')}}/configuracion/clases-personalizadas/eliminar_costo_fijo";

    $(document).ready(function(){

      $("#imagen").bind("change", function() {
            //alert('algo cambio');
            
            setTimeout(function(){
              var imagen = $("#imagena img").attr('src');
              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL("image/jpeg", 0.8);
              var image64 = $("input:hidden[name=imageBase64]").val(newimage);
            },500);

        });

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInLeftBig';
        //var cardImg = $(this).closest('#content').find('h1');
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        //$("h1").removeAttr('class');
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);

      });

    $('#modalNombre-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#clasepersonalizada-nombre").text()); 
    })

    $('#modalEtiqueta-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#color_etiqueta").val($("#clasepersonalizada-color_etiqueta").text()); 
    })

    $('#modalExpiracion-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#tiempo_expiracion").val($("#clasepersonalizada-tiempo_expiracion").text()); 
    })

    $('#modalHora-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#cantidad_horas").val($("#clasepersonalizada-cantidad_horas").text()); 
    })

    $('#modalPrecio-ClasePersonalizada').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#participantes").val(""); 
      $("#precio").val(""); 
    })

    function limpiarMensaje(){
        var campo = ["nombre", "fecha", "especialidades", "instructor", "alumno_id", "hora_inicio", "hora_final", "estudio", "cantidad_horas"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
      }

      function campoValor(form){
        $.each(form, function (n, c) {
          //alert(n +' '+ c.name);
          if(c.name=='sexo'){
            if(c.value=='M'){              
              var valor='<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#clasepersonalizada-"+c.name).data('valor',c.value);
            $("#clasepersonalizada-"+c.name).html(valor);
          }else if(c.name== 'color_etiqueta'){
              $("#clasepersonalizada-"+c.name).text(c.value);
              $("#color_etiqueta_container").css('background-color',c.value);
          }else if(c.name=='especialidad_id' || c.name=='estudio_id' || c.name=='instructor_id' || c.name=='alumno_id'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#clasepersonalizada-"+c.name).text(texto);
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='descripcion'){
             $("#clasepersonalizada-"+c.name).data('valor',c.value);
             $("#clasepersonalizada-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if(c.name=='tiempo_expiracion'){
             $("#clasepersonalizada-"+c.name).text(c.value + " Horas");
          }else{
            $("#clasepersonalizada-"+c.name).text(c.value);
          }

         if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }
          
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

    $(".guardar").click(function(){
        //$(this).data('formulario');
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        $(".guardar").attr("disabled","disabled");
         procesando();
        $("#guardar").css({
            "opacity": ("0.2")
        });
        $(".cancelar").attr("disabled","disabled");
        $(".procesando").removeClass('hidden');
        $(".procesando").addClass('show');
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#"+form ).serialize();
        var datos_array=  $( "#"+form ).serializeArray();
        console.log(datos_array);
        
        var route = route_update+"/"+update;
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: datos,                
            success: function (respuesta) {
              setTimeout(function() {
                if(respuesta.status=='OK'){
                  finprocesado(); 
                  campoValor(datos_array);            
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;                                      
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                 $(".procesando").removeClass('show');
                 $(".procesando").addClass('hidden');
                 $(".guardar").removeAttr("disabled");
                 finprocesado();
                $("#guardar").css({
                  "opacity": ("1")
                });
                 $(".cancelar").removeAttr("disabled");
                 $('.modal').modal('hide');
              }, 1000);  
            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                // if (typeof msj.responseJSON === "undefined") {
                //           window.location = "{{url('/')}}/error";
                //         }
                var nType = 'danger';
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
                  errores(msj.responseJSON.errores);
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }
                 notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  $(".procesando").removeClass('show');
                  $(".procesando").addClass('hidden');
                  $(".guardar").removeAttr("disabled");
                  finprocesado();
                  $("#guardar").css({
                    "opacity": ("1")
                  });
                  $(".cancelar").removeAttr("disabled");
              }, 1000);             
            }
        })
       
    })

    $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar la clase personalizada",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
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
                        // swal("Done!","It was succesfully deleted!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
          }
                });
            });
      function eliminar(id){
         var route = route_eliminar + id;
         var token = $('input:hidden[name=_token]').val();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){

                        window.location = route_principal; 

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

       $(".cancelar_clase").click(function(){
    
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
         var route = route_cancelar + "{{$clasepersonalizada->id}}";
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
                    var route = route_cancelarpermitir + "{{$clasepersonalizada->id}}";

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


    
                            }
                        });
                    }
                });
             }
         });
        }
      });
    });

      function countChar(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum').text(2000 - len);
        }
      };


      var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').hide();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         "Buscar:",
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

      $("#add").click(function(){

              var route = route_agregar;
                  var token = $('input:hidden[name=_token]').val();
                  var datos = $( "#edit_precio_clase_personalizada" ).serialize(); 
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
                            var nType = 'success';
                            var nTitle="Ups! ";
                            var nMensaje=respuesta.mensaje;

                            $("#participantes").val('');
                            $("#precio").val('');

                            var participantes = respuesta.participantes;
                            var precio = respuesta.precio;

                            var rowId=respuesta.id;
                            var rowNode=t.row.add( [
                            ''+participantes+'',
                            ''+precio+'',
                            '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                            ] ).draw(false).node();
                            $( rowNode )
                            .attr('id',rowId)
                            .addClass('seleccion');

                          }else{
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                          }                       
                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          $(".cancelar").removeAttr("disabled");
                          $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }, 1000);
                      },
                      error:function(msj){
                        setTimeout(function(){ 
                        //   if (typeof msj.responseJSON === "undefined") {
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
                          $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });
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
                 url: route_delete+"/"+id,
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

          $(".dismiss").click(function(){
            $('.modal').modal('hide');
          });

    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
