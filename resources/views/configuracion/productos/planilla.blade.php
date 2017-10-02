@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@stop

@section('content')
     
          
            <div class="modal fade" id="modalNombre-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_producto" id="edit_nombre_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Gomas de Baile">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$producto->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_producto" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCosto-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_costo_producto" id="edit_costo_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="costo">Costo</label>
                                    <input type="text" class="form-control input-sm input-mask" name="costo" id="costo" data-mask="00000000" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-costo">
                                      <span >
                                          <small class="help-block error-span" id="error-costo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$producto->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_costo_producto" data-update="costo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCantidad-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_cantidad_producto" id="edit_cantidad_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" id="cantidad" name="cantidad">
                           <input type="hidden" name="id" value="{{$producto->id}}"></input>
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                              
                          <div class="col-sm-12">
                            <div class="form-group fg-line">
      

                                <label for="cantidad_producto" id="id-cantidad_producto">Cantidad</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de productos a agregar" title="" data-original-title="Ayuda"></i>

                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                    <div class="fg-line">
                                    <input type="text" class="form-control input-sm input-mask proceso" data-mask="00000" name="cantidad_producto" id="cantidad_producto" placeholder="Ej. 50">
                                    </div>
                                  </div>
                               <div class="has-error" id="error-cantidad_producto">
                                    <span >
                                        <small class="help-block error-span" id="error-cantidad_producto_mensaje" ></small>                               
                                    </span>
                                </div>
                             </div>

                              <br>

                              <div class="card-header text-left">

                                <button type="button" class="btn btn-blanco m-r-10 f-10" name= "agregar_cantidad" id="agregar_cantidad" > Agregar Linea</button>

                              </div>
                              <div class="clearfix p-b-35"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="cantidad"></th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" ></th>
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" name="guardar" data-formulario="edit_cantidad_producto" data-update="cantidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImagen-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_imagen_producto" id="edit_imagen_producto"  >
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
                                        @if($producto->imagen)
                                          <img src="{{url('/')}}/assets/uploads/producto/{{$producto->imagen}}" style="line-height: 150px;">
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

                               <input type="hidden" name="id" value="{{$producto->id}}"></input>
                              

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

                              <a class="btn-morado m-r-5 f-12 guardar" id="guardar" href="#" data-formulario="edit_imagen_producto" data-update="imagen" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDescripcion-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_descripcion_producto" id="edit_descripcion_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="8" placeholder="80 Caracteres" maxlength="80" onkeyup="countChar(this)"></textarea>
                                 </div>
                                 <div class="opaco-0-8 text-right">Resta <span id="charNum">80</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$producto->id}}"></input>

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_descripcion_producto" data-update="descripcion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImpuesto-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_impuesto_producto" id="edit_impuesto_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                          <label for="">Incluye impuestos fiscales (IVA)</label id="id-iva">
                                          
                                          <br></br>
                                          <input type="text" id="incluye_iva" name="incluye_iva" value="" hidden="hidden">
                                          <div class="p-t-10 text-center">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="iva" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                       </div>
                                 <div class="has-error" id="error-incluye_iva">
                                      <span >
                                          <small class="help-block error-span" id="error-incluye_iva_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$producto->id}}"></input>

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_impuesto_producto" data-update="impuesto" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTipo-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipo_producto" id="edit_tipo_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                    <label for="tipo">Categoría</label>
                                    <div class="select">
                                          <select class="form-control" id="tipo" name="tipo">
                                            <option value="2">Academia Recepción</option>
                                            <option value="11">Campaña</option>
                                            <option value="14">Fiesta y Eventos</option>
                                            <option value="5">Taller</option>
                                            
                                          </select>
                                      </div> 
                                    </div>
                                    <div class="has-error" id="error-tipo">
                                      <span >
                                          <small id="error-tipo_mensaje" class="help-block error-span" ></small>                                           
                                      </span>
                                    </div>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$producto->id}}"></input>
                              

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

                             <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tipo_producto" data-update="tipo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalMostrar-Producto" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Producto<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_mostrar_producto" id="edit_mostrar_producto"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                 <div class="form-group fg-line ">
                                    <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar esta clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                    
                                    <br></br>
                                    <input type="text" id="boolean_promocionar" name="boolean_promocionar" value="" hidden="hidden">
                                    <div class="p-t-10">
                                      <div class="toggle-switch" data-ts-color="purple">
                                      <span class="p-r-10 f-700 f-16">No</span><input id="promocionar" type="checkbox">
                                      
                                      <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-boolean_promocionar">
                                      <span >
                                          <small class="help-block error-span" id="error-boolean_promocionar_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>


                              <input type="hidden" name="id" value="{{$producto->id}}"></input>
                        

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_mostrar_producto" data-update="mostrar" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/productos" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Producto</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_f-productos"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Producto</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo producto</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <i class="zmdi zmdi-delete boton red f-20 m-r-10 boton red sa-warning" id="{{$producto->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>

                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              </div>
                              </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Producto</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($producto->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_d-servicios f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-nombre" class="capitalize">{{$producto->nombre}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCosto-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-costo" class="zmdi {{ empty($producto->costo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                               <span class="f-14"> Costo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-costo"><span>{{ number_format($producto->costo, 2, '.' , '.') }}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCantidad-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-cantidad" class="zmdi {{ empty($producto->cantidad) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-costo f-22"></i> </span>
                               <span class="f-14"> Cantidad </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-cantidad"><span>{{$producto->cantidad}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImagen-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-imagen" class="zmdi {{ empty($producto->imagen) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-collection-folder-image zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Imagen </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-imagen"><span></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDescripcion-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-descripcion" class="zmdi {{ empty($producto->descripcion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-cuentales-historia f-22"></i> </span>
                               <span class="f-14"> Descripción </span>
                             </td>
                             <td id="producto-descripcion" class="f-14 m-l-15 capitalize" data-valor="{{$producto->descripcion}}">{{ str_limit($producto->descripcion, $limit = 30, $end = '...') }} <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTipo-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipo" class="zmdi {{ empty($producto->tipo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Categoría </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-tipo" data-valor="{{$producto->tipo}}">{{$tipo}}</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalImpuesto-Producto">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-impuesto" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-city-alt zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Incluye impuestos fiscales (IVA) </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-incluye_iva">
                             @if($producto->incluye_iva==1)
                                  Si </span>
                             @else
                                  No </span>
                             @endif</span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalMostrar-Campana">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-estatus" class="zmdi c-verde zmdi-check zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="icon_a-estatus-de-clases f-20"></i> </span>
                              <span class="f-14"> Mostrar en la Web </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="producto-boolean_promocionar" data-valor="{{$producto->boolean_promocionar}}">
                               @if($producto->boolean_promocionar==1)
                                  <i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i> </span>
                               @else
                                  <i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i></span>
                               @endif
                             <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
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
    route_update="{{url('/')}}/productos/update";
    route_eliminar="{{url('/')}}/productos/eliminar/";
    route_agregar_cantidad="{{url('/')}}/productos/agregar_cantidad";
    route_eliminar_cantidad="{{url('/')}}/productos/eliminar_cantidad/";
    route_principal="{{url('/')}}/productos";

    function formatmoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    } 

    $(document).ready(function(){


      $('#cantidad').val("{{$producto->cantidad}}")

      $("#promocionar").on('change', function(){
        if ($("#promocionar").is(":checked")){
          $("#boolean_promocionar").val('1');
        }else{
          $("#boolean_promocionar").val('0');
        }    
      });


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

      if("{{$producto->incluye_iva}}" == 1){
          $("#incluye_iva").val('1');  //VALOR POR DEFECTO
          $("#iva").attr("checked", true); //VALOR POR DEFECTO
        }
        
        $("#iva").on('change', function(){
          if ($("#iva").is(":checked")){
            $("#incluye_iva").val('1');
          }else{
            $("#incluye_iva").val('0');
          }   
          console.log($("#incluye_iva").val());     
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

    $('#modalNombre-Producto').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#producto-nombre").text()); 
    })

    $('#modalCosto-Producto').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#costo").val($("#producto-costo").text()); 
    })

    $('#modalTipo-Producto').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var tipo=$("#producto-tipo").data('valor');
      $("#tipo").val(tipo); 
    })

    $('#modalDescripcion-Producto').on('show.bs.modal', function (event) {
      limpiarMensaje();
       var descripcion=$("#producto-descripcion").data('valor');
       $("#descripcion").val(descripcion);
      //$("#direccion").val($("#alumno-direccion").text());
    })


    function limpiarMensaje(){
        var campo = ["nombre", "costo", "descripcion", "imagen", "cantidad"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["nombre", "costo", "descripcion", "imagen", "cantidad"];
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
          if(c.name=='descripcion' || c.name=='nombre'){
             $("#producto-"+c.name).data('valor',c.value);
             $("#producto-"+c.name).html(c.value.toLowerCase().substr(0, 30) + "...");
            //$("#alumno-"+c.name).text(c.value.substr(0, 30));
          }else if (c.name=='incluye_iva'){
            if(c.value ==1){
              $("#producto-"+c.name).text('Si');
            }else{
              $("#producto-"+c.name).text('No');
            }
          }else if(c.name=='boolean_promocionar'){
            if(c.value==1){              
              var valor='<i class="zmdi zmdi-mood zmdi-hc-fw f-22 c-verde"></i>';                   
            }else{
              var valor='<i class="zmdi zmdi-mood-bad zmdi-hc-fw f-22 c-youtube"></i>';
            }
            $("#producto-"+c.name).html(valor);
          }else if (c.name=='tipo'){

            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();
            
            $("#producto-"+c.name).text(texto);

          }else if(c.name==='costo'){
             $("#producto-"+c.name).text(formatmoney(parseFloat(c.value)));
          }else if(c.name==='cantidad'){
             $("#producto-"+c.name).text(c.value);
          }else{
            $("#producto-"+c.name).text(c.value.toLowerCase());
          }

          $("#estatus-"+c.name).removeClass('c-amarillo');
          $("#estatus-"+c.name).addClass('c-verde');
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
                //   window.location = "{{url('/')}}/error";
                // }
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
                    title: "Desea eliminar el producto?",   
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

      function countChar(val) {
        var len = val.value.length;
        if (len >= 80) {
          val.value = val.value.substring(0, 80);
        } else {
          $('#charNum').text(80 - len);
        }
      };

      $("#agregar_cantidad").click(function(){


        var datos = $( "#edit_cantidad_producto" ).serialize(); 
        procesando();
        var route = route_agregar_cantidad;
        var token = $('input:hidden[name=_token]').val();
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

                  cantidad = parseInt(respuesta.cantidad);
                  cantidad_actual = parseInt($('#cantidad').val());
                  cantidad_total = cantidad + cantidad_actual;

                  $('#cantidad').val(cantidad_total);

                  var rowId=respuesta.id;
                  var rowNode=t.row.add( [
                  ''+cantidad+'',
                  '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                  ] ).draw(false).node();
                  $( rowNode )
                  .attr('id',rowId)
                  .addClass('seleccion');

                  $('#cantidad_producto').val('')

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
                 url: route_eliminar_cantidad+id,
                 headers: {'X-CSRF-TOKEN': token},
                 type: 'POST',
                 dataType: 'json',                
                success: function (data) {
                  if(data.status=='OK'){

                    cantidad = parseInt(data.cantidad);
                    cantidad_actual = parseInt($('#cantidad').val());
                    cantidad_total = cantidad_actual - cantidad;
                  
                    $('#cantidad').val(cantidad_total);
                      
                                       
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

      var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
          //$('td:eq(1)', nRow).attr("onClick","eliminar(this)" );
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
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
