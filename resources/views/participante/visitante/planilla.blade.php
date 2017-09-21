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

          <div class="modal fade" id="modalPromotor-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_promotor_alumno" id="edit_promotor_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Promotor</label>

                                      <div class="select">
                                          <select class="form-control" id="instructor_id" name="instructor_id">
                                          @foreach ( $instructores as $instructor )
                                          <option value = "{{ $instructor['id'] }}">{{ $instructor['nombre'] }} {{ $instructor['apellido'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-edit_especialidades_clasegrupal" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_promotor_alumno" data-update="promotor" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


     
           <div class="modal fade" id="modalNombre-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_nombre_alumno" id="edit_nombre_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="Ej. Sánchez">
                                 </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_nombre_alumno" data-update="nombre" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalFechaNacimiento-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_fecha_nacimiento_alumno" id="edit_fecha_nacimiento_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <label for="apellido">Fecha de Nacimiento</label>
                                            <div class="dtp-container fg-line">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker pointer" placeholder="Seleciona" type="text">
                                        </div>
                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                      </span>
                                 </div>
                               </div>

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_fecha_nacimiento_alumno" data-update="fecha_nacimiento" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSexo-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_sexo_alumno" id="edit_sexo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Sexo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  

                                        Mujer 

                                        @if($edad >= 18)
                                          <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                        @else
                                          <i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                        @endif
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre 

                                        @if($edad >= 18)
                                          <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                        @else
                                          <i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                        @endif
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_sexo_alumno" data-update="sexo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalCorreo-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_correo_alumno" id="edit_correo_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. example@correo.com">
                                 </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_correo_alumno" data-update="correo" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTelefono-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_telefono_alumno" id="edit_telefono_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Telefono Local</label>
                                    <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                 </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="celular">Telefono Celular</label>
                                    <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                 </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_telefono_alumno" data-update="telefono" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDireccion-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_direccion_alumno" id="edit_direccion_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Dirección</label>
                                    <input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="Ej. Avenida 10 con Calle 70" maxlength="180" onkeyup="countChar(this)">
                                 </div>
                                 
                                 <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                                     

                               <div class="clearfix"></div> 

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>

                               
                               
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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_direccion_alumno" data-update="direccion" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEspecialidades-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_especialidades_alumno" id="edit_especialidades_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Especialidad de interés</label>

                                      <div class="select">
                                          <select class="selectpicker bs-select-hidden" id="especialidad_id" name="especialidad_id" multiple="" data-max-options="5" title="Selecciona">
                                          @foreach ( $config_especialidades as $especialidad )
                                          <option value = "{{ $especialidad['id'] }}">{{ $especialidad['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-edit_especialidades_clasegrupal" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_especialidades_alumno" data-update="especialidad" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalComoseentero-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_como_se_entero_alumno" id="edit_como_se_entero_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">¿Cómo se enteró?</label>

                                      <div class="select">
                                          <select class="form-control" id="como_nos_conociste_id" name="como_nos_conociste_id">
                                          @foreach ( $como_nos_conociste as $conociste )
                                          <option value = "{{ $conociste['id'] }}">{{ $conociste['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-edit_especialidades_clasegrupal" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_como_se_entero_alumno" data-update="como_se_entero" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDias-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_dias_alumno" id="edit_dias_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Días de interés</label>

                                      <div class="select">
                                          <select class="form-control" id="dias_clase_id" name="dias_clase_id">
                                          @foreach ( $dias_de_semana as $dia )
                                            <option value = "{{ $dia['id'] }}">{{ $dia['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-especialidades">
                                      <span >
                                          <small class="help-block error-span" id="error-edit_especialidades_clasegrupal" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_dias_alumno" data-update="dias" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInteres-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_interes_alumno" id="edit_interes_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Sexo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="interes_id" id="adulto" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Adulto <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="interes_id" id="niño" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Niño <i class="zmdi fa fa-child p-l-5 f-15"></i>
                                    </label>
                                    </div>
                                  </div>
                               <div class="has-error" id="error-interes_id">
                                    <span >
                                        <small class="help-block error-span" id="error-interes_id_mensaje" ></small>                                
                                    </span>
                                </div>
                               </div>

                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                              

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_interes_alumno" data-update="interes" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                             
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTipologia-Visitante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Visitante<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_tipologia_visitante" id="edit_tipologia_visitante"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="tipologia_id">Perfil del Cliente</label>

                                      <div class="select">
                                          <select class="form-control" id="tipologia_id" name="tipologia_id">
                                            <option value="">Selecciona</option>
                                            @foreach ( $tipologias as $tipologia )
                                              <option value = "{{ $tipologia['id'] }}">{{ $tipologia['nombre'] }}</option>
                                            @endforeach 
                                          </select>
                                      </div> 

                                 </div>
                                 <div class="has-error" id="error-tipologia_id">
                                      <span >
                                          <small class="help-block error-span" id="error-tipologia_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" name="id" value="{{$visitante->id}}"></input>
                            

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

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar" data-formulario="edit_tipologia_visitante" data-update="tipologia" >  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
    
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/visitante" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Visitante</a>
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
                                            <span class="ca-icon-planilla"><i class="icon_a-visitante-presencial"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Vista Visitante</h2>
                                                <h3 class="ca-sub-planilla">Personaliza el campo visitante</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="col-sm-12 text-center"> 

                                  <br></br>

                                  <span class="f-16 f-700">Acciones</span>

                                  <hr></hr>
                                  
                                  <a class="email"><i class="zmdi zmdi-email f-20 m-r-5 boton blue sa-warning" data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="impresion"><i class="icon_a-examen f-20 m-r-5 boton blue sa-warning" data-original-title="Realizar encuesta" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a href="{{url('/')}}/participante/alumno/agregar/{{$visitante->id}}"><i class="zmdi zmdi-trending-up zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Transferir" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a href="{{url('/')}}/participante/visitante/llamadas/{{$visitante->id}}"><i class="zmdi zmdi-phone zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Llamadas" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <a class="reservar"><i class="icon_a-reservaciones zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Reservar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>
                                  <i class="zmdi zmdi-delete boton red f-20 m-r-10 boton red sa-warning" id="{{$visitante->id}}" name="eliminar" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""></i>
                                  <br></br>
                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>
                     </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <p class="text-center opaco-0-8 f-22">Datos del Visitante</p>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                           <tr class="detalle" data-toggle="modal" href="#modalPromotor-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-instructor_id" class="zmdi {{ empty($visitante->instructor_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-instructor f-22"></i> </span>
                               <span class="f-14"> Promotor </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-instructor_id" class="capitalize">{{$visitante->instructor_nombre}} {{$visitante->instructor_apellido}}</span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalNombre-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-nombre" class="zmdi {{ empty($visitante->nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombres </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-nombre" class="capitalize">{{$visitante->nombre}}</span> <span id="visitante-apellido" class="capitalize">{{$visitante->apellido}}</span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalFechaNacimiento-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-fecha_nacimiento" class="zmdi {{ empty($visitante->fecha_nacimiento) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-fecha-de-nacimiento f-22"></i> </span>
                               <span class="f-14"> Fecha de nacimiento  </span>
                             </td>
                             <td  class="f-14 m-l-15" id="visitante-fecha_nacimiento" >{{ \Carbon\Carbon::createFromFormat('Y-m-d',$visitante->fecha_nacimiento)->format('d/m/Y')}}</span></td>
                            </tr>
                             <tr class="detalle" data-toggle="modal" href="#modalSexo-Visitante">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-sexo" class="zmdi {{ empty($visitante->sexo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-male-female f-22"></i> </span>
                              <span class="f-14"> Sexo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-sexo" data-valor="{{$visitante->sexo}}">
                               @if($visitante->sexo=='F')
                                  <i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                               @else
                                  <i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                               @endif
                             </span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalCorreo-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-correo" class="zmdi {{ empty($visitante->correo) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-correo f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-correo"><span>{{$visitante->correo}}</span></span> <span class="pull-right c-blanco"></td>
                            </tr>
                            <tr id="tr_contacto" data-valor="{{$visitante->celular}}" class="detalle" data-toggle="modal" href="#modalTelefono-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-telefono" class="zmdi {{ empty($visitante->telefono) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b icon_b-telefono f-22"></i> </span>
                               <span class="f-14"> Contacto </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-telefono">{{$visitante->telefono}}</span> / <span id="visitante-celular">{{$visitante->celular}}</span><span class="pull-right c-blanco"></td>
                            </tr>
                              <tr class="detalle" data-toggle="modal" href="#modalComoseentero-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-como_nos_conociste_id" class="zmdi {{ empty($visitante->como_nos_conociste_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_b-como-se-entero f-22"></i> </span>
                               <span class="f-14"> ¿Cómo se Enteró? </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-como_nos_conociste_id"><span>{{$visitante->como_nos_conociste_nombre}}</span></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalEspecialidades-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-especialidad_id" class="zmdi {{ empty($especialidades) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-especialidad f-22"></i> </span>
                               <span class="f-14"> Especialidad de Interés </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-especialidad_id">{{$especialidades}}</span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDias-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-dias_clase_id" class="zmdi {{ empty($visitante->dia_nombre) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a icon_a-agendar-1 f-22"></i> </span>
                               <span class="f-14"> Días de Interés </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-dias_clase_id">{{$visitante->dia_nombre}}</span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalDireccion-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-direccion" class="zmdi {{ empty($visitante->direccion) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i> </span>
                               <span class="f-14"> Dirección </span>
                             </td>
                             <td id="visitante-direccion" class="f-14 m-l-15" data-valor="{{$visitante->direccion}}" ><span ><span>{{ str_limit($visitante->direccion, $limit = 30, $end = '...') }}</span></span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalInteres-Visitante">
                             <td> 
                              <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-interes_id" class="zmdi {{ empty($visitante->interes_id) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                              <span class="m-l-10 m-r-10"> <i class="zmdi icon_a-especialidad f-22"></i> </span>
                              <span class="f-14"> Tipo de Interes </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-interes_id" data-valor="{{$visitante->interes_id}}">
                              @if($visitante->interes_id=='1')
                                <i class="zmdi zmdi-male-alt p-l-5 f-25"></i> </span>
                                  
                              @else
                                <i class="zmdi fa fa-child p-l-5 f-20"></i> </span>
                              @endif
                             </span></td>
                            </tr>
                            <tr class="detalle" data-toggle="modal" href="#modalTipologia-Visitante">
                             <td>
                               <span  class="m-l-10 m-r-5 f-16" ><i id="estatus-tipologia_id" class="zmdi {{ empty($visitante->tipologia) ? 'c-amarillo zmdi-dot-circle' : 'c-verde zmdi-check' }} zmdi-hc-fw"></i></span>
                               <span class="m-l-10 m-r-10"> <i class="icon_a-clases-grupales f-22"></i> </span>
                               <span class="f-14"> Perfil del Cliente </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="visitante-tipologia_id" class="capitalize">{{$visitante->tipologia}}</span></td>
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

    route_update="{{url('/')}}/participante/visitante/update";
    route_email="{{url('/')}}/correo/sesion";
    route_impresion="{{url('/')}}/participante/visitante/impresion/";
    route_enviar="{{url('/')}}/participante/visitante/enviar-correo";
    route_eliminar="{{url('/')}}/participante/visitante/eliminar/";
    route_principal="{{url('/')}}/participante/visitante";

    $(document).ready(function(){

      if($('#tr_contacto').data('valor') != ''){
        $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
        $("#estatus-telefono").addClass('c-verde zmdi-check');
      }

      $('#nombre').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
        }

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

    $('#modalNombre-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#visitante-nombre").text()); 
      $("#apellido").val($("#visitante-apellido").text());
    })
    $('#modalFechaNacimiento-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_nacimiento").val($("#visitante-fecha_nacimiento").text()); 
    })
    $('#modalSexo-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var sexo=$("#visitante-sexo").data('valor');
      if(sexo=="M"){
        $("#hombre").prop("checked", true);
      }else{
        $("#mujer").prop("checked", true);
      }
      
    })

    $('#modalCorreo-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#correo").val($("#visitante-correo").text()); 
    })

    $('#modalTelefono-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#telefono").val($("#visitante-telefono").text());
      $("#celular").val($("#visitante-celular").text()); 
    })

    $('#modalDireccion-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var direccion=$("#visitante-direccion").data('valor');
       $("#direccion").val(direccion);
    })

    $('#modalEstatus-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var status= $("#visitante-estatus").data('valor');
      if(status==1){
        $("#activo").prop("checked", true);
      }else{
        $("#inactivo").prop("checked", true);
      }
      
    })

    $('#modalInteres-Visitante').on('show.bs.modal', function (event) {
      limpiarMensaje();
      var interes=$("#visitante-interes_id").data('valor');
      if(interes=="1"){
        $("#adulto").prop("checked", true);
      }else{
        $("#niño").prop("checked", true);
      }
      
    })

    function limpiarMensaje(){
        var campo = ["nombre", "apellido", "fecha_nacimiento", "sexo", "correo", "telefono", "celular", "direccion", "estatus", 'tipologia_id'];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
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
          if(c.name=='sexo'){

            if("{{$edad}}" >= 18){

              if(c.value=='M'){ 

                var valor='<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>';                              
              }else if(c.value=='F'){
                var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
              }
            }else{
              if(c.value=='M'){ 

                var valor='<i class="zmdi fa fa-child f-15 c-azul"></i> </span>';                              
              }else if(c.value=='F'){
                var valor='<i class="zmdi fa fa-child f-15 c-rosado"></i> </span>';
              }
            }
            $("#visitante-"+c.name).data('valor',c.value);
            $("#visitante-"+c.name).html(valor);
          }if(c.name=='interes_id'){       
                                
            if(c.value=='1'){              
              var valor='<i class="zmdi zmdi-male-alt p-l-5 f-25"></i> </span>';                              
            }else if(c.value=='2'){
              var valor='<i class="zmdi fa fa-child p-l-5 f-20"></i> </span>';
            }
            $("#visitante-"+c.name).data('valor',c.value);
            $("#visitante-"+c.name).html(valor);
          }else if(c.name=='direccion'){
             $("#visitante-"+c.name).data('valor',c.value);
             $("#visitante-"+c.name).html(c.value.substr(0, 30) + "...");
          }else if(c.name=='como_nos_conociste_id' || c.name=='especialidad_id' || c.name=='dias_clase_id' | c.name=='instructor_id' || c.name=='tipologia_id'){
            
            expresion = "#"+c.name+ " option[value="+c.value+"]";
            texto = $(expresion).text();

            $("#visitante-"+c.name).text(texto);

          }else{
            $("#visitante-"+c.name).text(c.value.toLowerCase());
          }

          if(c.value == ''){
            $("#estatus-"+c.name).removeClass('c-verde zmdi-check');
            $("#estatus-"+c.name).addClass('c-amarillo zmdi-dot-circle');
          }
          else{
            $("#estatus-"+c.name).removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-"+c.name).addClass('c-verde zmdi-check');
          }

          if(c.name == 'celular'){
            $('#tr_contacto').data('valor') == c.value;
          }

          if(c.name == 'celular' && $('#tr_contacto').data('valor') != ''){
            $("#estatus-telefono").removeClass('c-amarillo zmdi-dot-circle');
            $("#estatus-telefono").addClass('c-verde zmdi-check');
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
                if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
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
                    title: "Desea eliminar al visitante?",   
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

    $(".email").click(function(){
         var route = route_email;
         var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:"&usuario_tipo=3&usuario_id={{$id}}",
                    success:function(respuesta){

                        procesando();
                        window.location="{{url('/')}}/correo/{{$id}}"  

                    },
                    error:function(msj){
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      });

        $(".impresion").click(function(){
        procesando();
        window.location = route_impresion + "{{$visitante->id}}";
      });

        $(".informacion").click(function(){
                id = "{{$visitante->id}}";
                swal({   
                    title: "Desea enviar la informacion al visitante?",   
                    text: "Confirmar envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Enviar!",  
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
            procesando();
            var route = route_enviar;
            var token = '{{ csrf_token() }}';
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data: "&id="+id,
                    success:function(respuesta){
                        
                        finprocesado();
                        swal("Listo!","La información fue enviada con exito!","success");

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
                                finprocesado();
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
                
                }
            });
      });

        function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };

      $(".reservar").click(function(){

        procesando();
        var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/2";
        var token = '{{ csrf_token() }}';
            
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
            dataType: 'json',
            success:function(respuesta){
                window.location = "{{url('/')}}/agendar/reservaciones/actividades/{{$id}}"

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
                        finprocesado();
                        swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
        });
    });

      $("i[name=eliminar]").click(function(){
                id = this.id;
                swal({   
                    title: "Desea eliminar al alumno?",   
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

            eliminar(id);
          }
                });
      });

      function eliminar(id){
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

                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
              }
          });
      }
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
