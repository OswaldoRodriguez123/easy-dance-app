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
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/moment.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')

<div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Condiciones y Normativas<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button></h4>
                        </div>
                        <form name="configuracion_clase_personalizada" id="configuracion_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                                <div class="col-sm-12">

                                <div style="margin-left: 25%">
                                    
                                <div class="col-sm-8" style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc; overflow-y: auto; height:400px">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones">
                                    
                                            <div class="text-center f-25 f-700">Normativas de las clases personalizadas</div>
                                        <hr>
                                    <div class="table-responsive row">
                                    <div class="col-md-1"></div>
                                       <div class="col-md-10">
                                      <div class="text-justify">

                                      <div class="f-18 f-700"> 1. Principal   </div>
                                      <br>

                                      <p>Al momento de hacer la reserva, al alumno comprende que env??a una solicitud a la academia  y no una confirmaci??n de la  clase, la reserva  deber?? ser verificada y constatada   por un representante  la academia, por medio de la  plataforma o trav??s de una llamada telef??nica.</p>


                                      <div class="f-18 f-700">2.  Reservar  </div><br>

                                      <p>Todas las clases personalizadas o paquetes de su elecci??n, deber??n ser  apartadas con el 50% del costo total, al momento de asistir deber?? pagar  el resto de la  totalidad de la clase, dicha pago podr?? ser ejecutado a trav??s de la plataforma o enviando el Boucher del  pago generado  a trav??s, de la cuenta de banco establecida por la academia. </p>

                                      <div class="f-18 f-700"> 3. Asistencia  </div><br>

                                      <p>El alumno deber?? asistir en el horario establecido en la reservaci??n, en caso de atraso de parte del alumno, la academia no se responsabiliza ni se obliga  a reponer el tiempo perdido. </p>


                                      <div class="f-18 f-700"> 4. Inasistencia  </div><br>

                                      <p>En caso de que el alumnos no pueda asistir a su clase programada  deber?? notificarlo con 08 horas de antelaci??n a trav??s de la plataforma, o confirmar a trav??s de una llamada telef??nica su cancelaci??n, de lo contrario, la clase obtendr?? un estatus de <b>???cancelaci??n tard??a???</b>, lo que significa que esta ser?? percibida como una  clase vista, por tal motivo, esta deber?? ser pagada en su totalidad, sin derecho a reprogramar dicha clase, esta podr?? ser reprogramada siempre y cuando la cancelaci??n sea superior a las 08 horas de l??mite que estable la instituci??n.  </p>

                                      <div class="f-18 f-700"> 5. Din??mica </div><br>

                                      <p>Usted comprende que el instructor podr?? realizar una clase personalizada, con dos partipantes en una misma secci??n u hora de clases. </p>

                                      </div>
                                      </div>
                                      </div>

                                  </p>

                                  </div>

                                  </div>

                                </div>

                                <div class="col-sm-3" style="margin-left: 39%">

                                <input type="checkbox" id="condiciones" name="condiciones">  <span class="f-16 f-700 opaco-0-8">  Acepto los  t??rminos</span> <br><br>

                                <div class="text-center">

                                  <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name="guardar" id="guardar" >Agendar</button>

                                </div>

                              </div>
                            

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

                        </div></form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInstructor" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar Instructor <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button></h4>
                        </div>
                        <form name="form_instructor" id="form_instructor"  class="form">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               

                                    <div class="col-sm-12">
                                 
                                    <label for="identificacion" id="id-identificacion">Id - Pasaporte</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero de c??dula o pasaporte del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="identificacion" id="identificacion" data-mask="00000000000000000000" placeholder="Ej: 16133223">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small class="help-block error-span" id="error-identificacion_mensaje" ></small>                        
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-apellido">Apellido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el apellido del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="apellido" id="apellido" placeholder="Ej. Zambrano">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                    
                                      <label for="fecha_nacimiento" id="id-fecha_nacimiento">Fecha de Nacimiento</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de nacimiento del instructor" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b-fecha-de-nacimiento f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                               <label for="apellido" id="id-correo">Correo Electr??nico</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electr??nico del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="correo" id="correo" placeholder="Ej. easydance@gmail.com">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-celular">Tel??fono M??vil</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero del tel??fono movil del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                <label for="apellido" id="id-telefono">Tel??fono Local</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el n??mero del tel??fono local del instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="direccion" id="id-direccion">Direcci??n</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la direcci??n del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="direccion" id="direccion" placeholder="Calle santa marta, Av 23" maxlength="180" onkeyup="countChar(this)">
                                      </div>
                                      <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
                                    </div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>       
                                 </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                    <label for="apellido" id="id-imagen_perfil">Imagen de Perfil</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona una imagen del instructor desde tu ordenador, soporta formato en JPG, JPEG Y PNG, el tama??o de la imagen debe ser menor o igual a 1 MB. Nota: im??genes grandes o mayor a 230 x 120 se reducir??n" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="clearfix p-b-15"></div>
                                      
                                      <input type="hidden" name="imagePerfilBase64" id="imagePerfilBase64">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_perfil" id="imagen_perfil" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                      <div class="has-error" id="error-imagen_perfil">
                                      <span >
                                          <small class="help-block error-span" id="error-imagen_perfil_mensaje"  ></small>
                                      </span>
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre" id="id-ficha">Ficha M??dica</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los datos o estado de salud del instructor" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aqu?? 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                      <div class="panel-body">
                                      

                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Alergia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">
                                      
                                      <input type="text" id="alergia" name="alergia" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="alergia-switch" type="checkbox" hidden="hidden">
                                          <label for="alergia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>




                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Asma</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="asma" name="asma" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asma-switch" type="checkbox" hidden="hidden">
                                          <label for="asma-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Convulsiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="convulsiones" name="convulsiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="convulsiones-switch" type="checkbox" hidden="hidden">
                                          <label for="convulsiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Cefalea</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="cefalea" name="cefalea" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="cefalea-switch" type="checkbox" hidden="hidden">
                                          <label for="cefalea-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Hipertensi??n</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="hipertension" name="hipertension" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="hipertension-switch" type="checkbox" hidden="hidden">
                                          <label for="hipertension-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Lesiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="lesiones" name="lesiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="lesiones-switch" type="checkbox" hidden="hidden">
                                          <label for="lesiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>
                                      
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>

                                      <div class="clearfix p-b-35"></div>
                                      <hr></hr>



                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               </div>
                          <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Opciones Avanzadas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podr??s crear distintos instructores, especialidades, horarios y d??as de la semana de la clase personalizada" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aqu?? 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                    <label for="apellido" id="id-imagen">Imagen art??stica</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resoluci??n recomendada: 1200 x 630, resoluci??n m??nima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="clearfix p-b-15"></div>
                                      
                                      <input type="hidden" name="imageBase64" id="imageBase64">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen" id="imagen" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                      <div class="has-error" id="error-imagen">
                                      <span >
                                          <small class="help-block error-span" id="error-imagen_mensaje"  ></small>
                                      </span>
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Perfil del instructor</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe tu perfil como instructor, habla de tu personalidad en el baile, ??c??mo iniciaste? en que te has especializado?   Porqu?? te gusta ense??ar o bailar, cu??ntales a tus clientes y p??blico en general cu??les son tus fortalezas  al momento de ense??ar o bailar" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="2000 Caracteres" onkeyup="countChar2(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum2">2000</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                  <label for="id" id="id-video_promocional">Ingresa url del video promocional</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa un video promocional de tus clases de baile como instructor o bailar??n, esm??rate en hacer una buena producci??n visual, de esa forma te ayudaremos a impulsar tu marca personal de mejor manera" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_promocional" id="video_promocional" placeholder="Ingresa la url">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_promocional">
                                    <span >
                                     <small id="error-video_promocional_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-resumen_artistico">Resumen art??stico</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe la formaci??n art??stica que has recibido, cu??ntale a los alumnos de tus logros, tus haza??as en el gremio del baile" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="resumen_artistico" name="resumen_artistico" rows="2" placeholder="2000 Caracteres" onkeyup="countChar3(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum3">2000</span> Caracteres</div>
                                 <div class="has-error" id="error-resumen_artistico">
                                      <span >
                                          <small class="help-block error-span" id="error-resumen_artistico_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                  <label for="id" id="id-video_testimonial">Ingresa url del video testimonial</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional de tus alumnos , maestros , directores de academias ,personas influyentes , seguidores  entre otros , no mayor a 4  minutos , en el que ellos inviten  a seguir  tu trabajo. No olvides que la mejor publicidad proviene de las recomendaciones de terceros" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_testimonial" id="video_testimonial" placeholder="Ingresa la url">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_testimonial">
                                    <span >
                                     <small id="error-video_testimonial_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podr??n ver tu perfil como bailar??n o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
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

                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Permitir Reservar Clases Personalizadas</label id="id-boolean_disponibilidad"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podr??n ver tu perfil como bailar??n o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_disponibilidad" name="boolean_disponibilidad" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="disponibilidad" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_disponibilidad">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_disponibilidad_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>


                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label for="">Mostrar todas las clases grupales en el sistema</label id="id-boolean_disponibilidad"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Al activar dicha funci??n brindas el privilegio al instructor de operar las clases que se encuentren agendadas en el sistema" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="boolean_administrador" name="boolean_administrador" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="administrador" type="checkbox">
                                            
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-boolean_administrador">
                                            <span >
                                                <small class="help-block error-span" id="error-boolean_administrador_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                               
                            <div class="clearfix p-b-35"></div>
                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseAvanzado')" ></i></div>
                            
                            <div class="clearfix p-b-35"></div>
                               <hr></hr>


                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               </div>

                               <div class="clearfix p-b-35"></div>


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

                              <a class="btn-blanco m-r-5 f-12" href="#" id="guardar_instructor">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="modalEstudio" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar Estudio<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button></h4>
                        </div>
                        <form name="edit_estudio_academia" id="edit_estudio_academia"  class="form">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">
                              <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Estudios /Salones</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre y la capacidad de personas dentro de tu sal??n o salones de bailes." title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                
                                    
                                    <label for="nombre_estudio" id="id-nombre_estudio">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del Sal??n" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_estudio" id="nombre_estudio" placeholder="Ej. Sal??n">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_estudio">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_estudio_mensaje" ></small>                               
                                      </span>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <label for="cantidad_estudio" id="id-cantidad_estudio">Cantidad</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad de personas del Sal??n" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="cantidad_estudio" id="cantidad_estudio" placeholder="Ej. 50">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-cantidad_estudio">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_estudio_mensaje" ></small>                               
                                      </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      
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

                              <a class="btn-blanco m-r-5 f-12" href="#" id="a??adirestudio">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalNivel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Agregar Nivel <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button></h4>
                        </div>
                        <form name="edit_nivel_academia" id="edit_nivel_academia"  class="form">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               

                                    <div class="col-sm-12">
                                    <div class="form-group fg-line">
                                    <label for="id">Niveles de baile</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de los distintos niveles de baile que ofreces en tu academia" title="" data-original-title="Ayuda"></i>

                                    <div class="clearfix p-b-35"></div>
                                    
                                    <label for="nombre_nivel" id="id-nombre_nivel">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del nivel que deseas asignar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-niveles f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_nivel" id="nombre_nivel" placeholder="Ej. Basico">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_nivel">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_nivel_mensaje" ></small>                               
                                      </span>
                                  </div>
                               </div>

                              <br>

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

                              <a class="btn-blanco m-r-5 f-12" href="#" id="a??adirniveles">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                              <div class="clearfix p-b-35"></div>
                      

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/agendar" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

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
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-clase-personalizada f-25" id="id-clase_grupal_id"></i> Agendar clase personalizada </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_clasepersonalizada" id="agregar_clasepersonalizada">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                            @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                            <div class="col-sm-12">
                           
                              <label for="instructor" id="id-promotor">Promotor</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un promotor" title="" data-original-title="Ayuda"></i>

                              <div class="input-group">
                                <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                <div class="select">
                                  <select class="selectpicker bs-select-hidden" multiple="" data-max-options="5" name="promotor" id="promotor" data-live-search="true" title="Selecciona">
                                    @foreach ( $promotores as $promotor )
                                      <option value = "{{ $promotor['id'] }}" data-content="{{ $promotor['nombre'] }} {{ $promotor['apellido'] }} {!!$promotor['icono']!!}"></option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="has-error" id="error-promotor">
                                  <span >
                                    <small class="help-block error-span" id="error-promotor_mensaje" ></small>                                           
                                  </span>
                                </div>
                              </div>
                            </div>

                            <div class="clearfix p-b-35"></div>

                          @endif

                            @if($usuario_tipo == 1 || $usuario_tipo == 3 || $usuario_tipo == 5 || $usuario_tipo == 6)

                                <div class="col-sm-12">
                                 

                                  <label for="alumno_id" id="id-alumno_id">Seleccionar Alumno</label> <span class="c-morado f-700 f-16">*</span> 

                                  <i name = "pop-alumno" id = "pop-alumno" aria-describedby="popoverinstructor" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un participante, en caso de no poseerlo o deseas crear un nuevo registro, dir??gete a la secci??n de alumnos y procede a registrarlo. Desde esta secci??n puedes crearla <br> <a data-toggle='modal' href='#modalAlumno' class='redirect pointer'> Crear <i class='icon_a-alumnos f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                   <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_a-alumnos f-22"></i></span>
                                  <div class="fg-line">
                                    <div class="select">
                                      <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona" data-live-search="true">

                                       @foreach ( $alumnos as $alumno )
                                        <option value = "{{ $alumno['id'] }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-alumno_id">
                                    <span >
                                      <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                    </span>
                                  </div>
                                </div>
                             </div>

                              <div class="clearfix p-b-35"></div>

                            @endif


                            <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-clase_personalizada_id">Nombre</label> <span class="c-morado f-700 f-16">*</span> 

                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                      <i name = "pop-nombre_clase" id = "pop-nombre_clase" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de la clase personalizada, en caso de no haberla registrado o deseas crear un nuevo registro, debes dirigirte al ??rea de configuraci??n general en la secci??n de clases personalizadas y procede a crear el registro, o desde esta secci??n puedes crearla <br> <a data-toggle='modal' href='#modalNombre' class='redirect pointer'> Crear <i class='icon_b icon_b-nombres f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                    @else

                                      <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" aria-describedby="popoverclase" data-toggle="popover" data-placement="right" data-content="Selecciona el nombre de la clase a la que deseas asistir" title="" data-original-title="Ayuda"></i>

                                    @endif

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="clase_personalizada_id" id="clase_personalizada_id" data-live-search="true" onchange="porcentaje" >

                                          <option value="">Selecciona</option>
                                          @foreach ( $clases_personalizadas as $clase_personalizada )
                                          <option data-precio = "{{ $clase_personalizada['costo'] }}" value = "{{ $clase_personalizada['id'] }}">{{ $clase_personalizada['nombre'] }}</option>
                                          @endforeach
                                        
                                        </select>
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-clase_personalizada_id">
                                      <span >
                                          <small class="help-block error-span" id="error-clase_personalizada_id_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                              @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                <div class="col-sm-12 paquete" style="display:none">
                                 
                                  <label for="nombre">Paquete</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el paquete" title="" data-original-title="Ayuda" data-html="true"></i>
                                    
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                    <div class="select">
                                      <select name="precio_id" id="precio_id">
                                      </select>
                                    </div>
                                  </div>
                                  <div class="has-error" id="error-precio_id">
                                      <span >
                                        <small class="help-block error-span" id="error-precio_id_mensaje" ></small>
                                      </span>
                                  </div>
                                  <div class="clearfix p-b-35"></div>
                                </div>

                               @endif

                               


                                <div class="col-sm-12">
                                 
                                      <label for="fecha" id="id-fecha">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la fecha de inicio y final de la clase personalizada" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="fg-line">
                                              <input type="text" id="fecha" name="fecha" class="form-control pointer" placeholder="Selecciona la fecha" >
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-fecha">
                                      <span >
                                          <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
    
                                <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                 
                                    <label for="especialidad" id="id-especialidad_id">Especialidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Easy dance te ofrece una selecci??n de diversas especialidades" title="" data-original-title="Ayuda"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-especialidad f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="especialidad_id" id="especialidad_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $especialidad as $especialidades )
                                          <option value = "{{ $especialidades['id'] }}">{{ $especialidades['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-especialidad_id">
                                      <span >
                                        <small class="help-block error-span" id="error-especialidad_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               @if($usuario_tipo == 1 || $usuario_tipo == 2 ||  $usuario_tipo == 4 || $usuario_tipo == 5 || $usuario_tipo == 6)

                                  
                                  <div class="col-sm-12">
                                 
                                    <label for="instructor" id="id-instructor_id">Instructor</label> <span class="c-morado f-700 f-16">*</span> 


                                    @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

                                      <i name = "pop-instructor" id = "pop-instructor" aria-describedby="popoverinstructor" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un instructor, en caso de no poseerlo o deseas crear un nuevo registro, dir??gete a la secci??n de instructores y procede a registrarlo. Desde esta secci??n puedes crearla <br> <a data-toggle='modal' href='#modalInstructor' class='redirect pointer'> Crear <i class='icon_a-instructor f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                    @else

                                      <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona un instructor para la clase personalizada" title="" data-original-title="Ayuda"></i>

                                    @endif

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-instructor f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" name="instructor_id" id="instructor_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $instructores as $instructores )
                                          <option value = "{{ $instructores['id'] }}">{{ $instructores['nombre'] }} {{ $instructores['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-instructor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-instructor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               @else
                                <input type="hidden" name="instructor_id" value="{{ $usuario_id }}">
                               @endif

                               @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                <div class="col-sm-12">
                                 
                                     <label for="nivel_baile" id="id-estudio_id">Sala / Estudio</label> <span class="c-morado f-700 f-16">*</span> <i name = "pop-salon" id = "pop-salon" aria-describedby="popoversalon" class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la sala o estudio de tu academia, en caso de no haberla asignado o deseas crear un nuevo registro, dir??gete a la secci??n de sala o estudio e ingresa la informaci??n en el ??rea de configuraci??n general. Desde esta secci??n podemos redireccionarte <br> <a data-toggle='modal' href='#modalEstudio' class='redirect pointer'> Ll??vame <i class='icon_a-estudio-salon f-22'></i></a>" title="" data-original-title="Ayuda" data-html="true"></i>

                                     <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a-estudio-salon f-22"></i></span>
                                    <div class="fg-line">
                                      <div class="select">
                                        <select class="selectpicker" id="estudio_id" name="estudio_id" data-live-search="true">

                                          <option value="">Selecciona</option>
                                          @foreach ( $config_estudios as $estudios )
                                          <option value = "{{ $estudios['id'] }}">{{ $estudios['nombre'] }}</option>
                                          @endforeach

                                        </select>
                                      </div>
                                    </div>
                                    <div class="has-error" id="error-estudio_id">
                                      <span >
                                        <small class="help-block error-span" id="error-estudio_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                                <div class="clearfix p-b-35"></div>

                                @endif
                                    
                               <div class="col-xs-6">
                                 
                                      <label for="fecha_inicio" id="id-hora_inicio">Horario</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Define la hora de inicio y final de la clase personalizada" title="" data-original-title="Ayuda"></i>

                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_inicio" id="hora_inicio" class="form-control time-picker pointer" placeholder="Desde" type="text">
                                          </div>
                                 <div class="has-error" id="error-hora_inicio">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_inicio_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                               </div>

                               <div class="col-xs-6">
                                      <label for="fecha_inicio" id="id-hora_final">&nbsp;</label>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-time f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="hora_final" id="hora_final" class="form-control time-picker pointer" placeholder="Hasta" type="text">
                                          </div>
                                 <div class="has-error" id="error-hora_final">
                                      <span >
                                          <small class="help-block error-span" id="error-hora_final_mensaje" ></small>                                
                                      </span>
                                     </div>
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
                              <a class="btn btn-blanco m-r-10 f-18 reservar">Guardar</a>
                              <button type="button" class="cancelar btn btn-default" id="cancelar">Cancelar</button>
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

            <!-- <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav> -->
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/agendar/clases-personalizadas/reservar";
  route_inscribir="{{url('/')}}/agendar/clases-personalizadas/inscribir";
  route_completado="{{url('/')}}/agendar/clases-personalizadas/completado";
  route_enhorabuena="{{url('/')}}/agendar/clases-personalizadas/enhorabuena/";
  route_principal="{{url('/')}}/agendar/clases-personalizadas";

  var precios = <?php echo json_encode($precios);?>;

  $(document).ready(function(){

        $('#fecha').daterangepicker({
            "autoApply" : false,
            "opens": "left",
            "applyClass": "bgm-morado waves-effect",
            locale : {
                format: 'DD/MM/YYYY',
                applyLabel : 'Aplicar',
                cancelLabel : 'Cancelar',
                daysOfWeek : [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],        
            }
        });

      instructor_id = "{{{ $instructor_id or 'Default' }}}";
      clase_personalizada_id = "{{{ $clase_personalizada_id or 'Default' }}}";
      alumno_id = "{{{ $alumno_id or 'Default' }}}";

     if(alumno_id != 'Default'){
        $('#alumno_id').val(alumno_id)
        $('#alumno_id').selectpicker('refresh')
        
     }

      if(instructor_id != 'Default')
      {
        $("#instructor_id").val(instructor_id);
        $('#instructor_id').selectpicker('refresh');

      }

      if(clase_personalizada_id != 'Default')
      {

        $("#clase_personalizada_id").val(clase_personalizada_id);
        $('#clase_personalizada_id').selectpicker('refresh');

      }

      $(".guardar").attr("disabled","disabled");

      $(".guardar").css({
          "opacity": ("0.2")
      });

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);

      });


  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["fecha", "especialidad_id", "instructor_id", "hora_inicio", "hora_final", "estudio_id", "clase_personalizada_id", "alumno_id"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }

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

        $(".reservar").click(function(){

          if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6 ){
                $(".guardar").click();
              }else{
                $('#modalConfiguracion').modal('show');
              }

        });

        $("#guardar").click(function(){

          var id = $("#alumno_id").val();
          var values = $('#promotor').val();
          var promotores = '';

          if(values){
            for(var i = 0; i < values.length; i += 1) {
              promotores = promotores + ',' + values[i];
            }
          }
          
          if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6 ){
            var route = route_inscribir;
          }else{
            var route = route_agregar;
          }
          var token = $('input:hidden[name=_token]').val();
          var datos = $( "#agregar_clasepersonalizada" ).serialize(); 
          procesando();       
          limpiarMensaje();
          $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data:datos+"&promotores="+promotores,
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
                    if(respuesta.id){
                      window.location = route_enhorabuena + respuesta.id;
                    }
                    else{
                      window.location = route_completado;
                    }
                    
                  }else{
                    var nTitle="Ups! ";
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                    var nType = 'danger';

                    $(".procesando").removeClass('show');
                    $(".procesando").addClass('hidden');
                    $("#guardar").removeAttr("disabled");
                    finprocesado();
                    $("#guardar").css({
                      "opacity": ("1")
                    });
                    $(".cancelar").removeAttr("disabled");

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
                    $(".modal").modal('hide');
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
        var campo = ["fecha", "especialidad_id", "instructor_id", "hora_inicio", "hora_final", "estudio_id", "clase_personalizada_id", "alumno_id"];
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

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1000);          

  }


       $( "#cancelar" ).click(function() {
        $("#agregar_clasepersonalizada")[0].reset();
        $('.selectpicker').selectpicker('refresh')
        $('.paquete').hide()
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
      });

        function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      $('#collapseTwo').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseEstatus').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseEstatus').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseAvanzado').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseAvanzado').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseDireccion').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseDireccion').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

       $("#condiciones").on('change', function(){
          if ($("#condiciones").is(":checked")){
             $(".guardar").removeAttr("disabled");
                           
             $(".guardar").css({
                "opacity": ("1")
             });
          }else{
            $(".guardar").attr("disabled","disabled");
            $(".guardar").css({
                "opacity": ("0.2")
            });
          }    
        });

       $("#clase_personalizada_id").on('change', function(){
        
        $('#precio_id').empty();

        var id = $(this).val();
        var costo = $(this).find(':selected').attr('data-precio')

        if(id){

          $('#precio_id').append( new Option("1 Participante - " + costo,'1-'+id));

          var tmp = $.grep(precios, function(e){ return e.id == id; });
          $.each(tmp, function (index, array) {
  
            $('#precio_id').append( new Option(array.participantes + " Participantes - " + array.precio,'2-'+array.precio_id));

          });

          $('#precio_id').selectpicker('refresh');
          $('.paquete').show()    

        }else{

          $('#precio_id').empty();
          $('#precio_id').selectpicker('refresh');
          $('.paquete').hide()

        }    
      });

       function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      }

      $("#a??adirestudio").click(function(){

      var datos = $( "#edit_estudio_academia" ).serialize(); 
      var route = "{{url('/')}}/configuracion/academia/estudio";
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
      limpiarMensaje();
      procesando();
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

                $('#estudio_id').append('<option value="'+respuesta.array.id+'">'+respuesta.array.nombre+'</option>');
                $('#estudio_id').val(respuesta.array.id)
                $('.selectpicker').selectpicker('refresh')

                $("#edit_estudio_academia")[0].reset();
                $('.modal').modal('hide')
                finprocesado()
                
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
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

    $("#a??adirniveles").click(function(){

      var datos = $( "#edit_nivel_academia" ).serialize(); 
      var route = "{{url('/')}}/configuracion/academia/nivel";
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
      limpiarMensaje();
      procesando();
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

                $('#nivel_baile_id').append('<option value="'+respuesta.array.id+'">'+respuesta.array.nombre+'</option>');
                $('#nivel_baile_id').val(respuesta.array.id)
                $('.selectpicker').selectpicker('refresh')

                $("#edit_nivel_academia")[0].reset();
                $('.modal').modal('hide')
                finprocesado()
                
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
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

    $("#guardar_clase_personalizada").click(function(){

      var datos = $( "#form_nombre" ).serialize(); 
      var route = "{{url('/')}}/configuracion/clases-personalizadas/agregar";
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
      limpiarMensaje();
      procesando();
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

                $('#clase_personalizada_id').append('<option value="'+respuesta.array.id+'">'+respuesta.array.nombre+'</option>');
                $('#clase_personalizada_id').val(respuesta.array.id)
                $('.selectpicker').selectpicker('refresh')

                $("#form_nombre")[0].reset();
                $('.modal').modal('hide')
                finprocesado()
                
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
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

    $("#guardar_instructor").click(function(){

      var datos = $( "#form_instructor" ).serialize(); 
      var route = "{{url('/')}}/participante/instructor/agregar";
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
      limpiarMensaje();
      procesando();
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

                $('#instructor_id').append('<option value="'+respuesta.array.id+'">'+respuesta.array.nombre+ ' ' +respuesta.array.apellido+'</option>');
                $('#instructor_id').val(respuesta.array.id)
                $('.selectpicker').selectpicker('refresh')

                $("#form_instructor")[0].reset();
                $('.modal').modal('hide')
                finprocesado()
                
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
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

    $("#guardar_alumno").click(function(){

      var datos = $( "#form_alumno" ).serialize(); 
      var route = "{{url('/')}}/participante/alumno/agregar";
      var token = $('input:hidden[name=_token]').val();
      var datos = datos;
      limpiarMensaje();
      procesando();
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

                $('#alumno_id').append('<option value="'+respuesta.array.id+'">'+respuesta.array.nombre+ ' ' +respuesta.array.apellido+'</option>');
                $('#alumno_id').val(respuesta.array.id)
                $('.selectpicker').selectpicker('refresh')

                $("#form_alumno")[0].reset();
                $('.modal').modal('hide')
                finprocesado()
                
              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
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

    $("#alergia-switch").on('change', function(){
          if ($("#alergia-switch").is(":checked")){
            $("#alergia").val('1');
          }else{
            $("#alergia").val('0');
          }     
        });

      $("#asma-switch").on('change', function(){
          if ($("#asma-switch").is(":checked")){
            $("#asma").val('1');
          }else{
            $("#asma").val('0');
          }     
        });

      $("#convulsiones-switch").on('change', function(){
          if ($("#convulsiones-switch").is(":checked")){
            $("#convulsiones").val('1');
          }else{
            $("#convulsiones").val('0');
          }     
        });

      $("#cefalea-switch").on('change', function(){
          if ($("#cefalea-switch").is(":checked")){
            $("#cefalea").val('1');
          }else{
            $("#cefalea").val('0');
          }     
        });

      $("#lesiones-switch").on('change', function(){
          if ($("#lesiones-switch").is(":checked")){
            $("#lesiones").val('1');
          }else{
            $("#lesiones").val('0');
          }     
        });

      $("#hipertension-switch").on('change', function(){
          if ($("#hipertension-switch").is(":checked")){
            $("#hipertension").val('1');
          }else{
            $("#hipertension").val('0');
          }     
        });

      function countChar(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(2000 - len);
        }
      };

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

      $('#pop-nombre_clase').popover({
                html: true,
                trigger: 'manual'
            }).on( "mouseenter", function(e) {

                $(this).popover('show');
                
                e.preventDefault();
      });

      $('#pop-instructor').popover({
                  html: true,
                  trigger: 'manual'
              }).on( "mouseenter", function(e) {

                  $(this).popover('show');
                  
                  e.preventDefault();
        });

        $('#pop-alumno').popover({
                  html: true,
                  trigger: 'manual'
              }).on( "mouseenter", function(e) {

                  $(this).popover('show');

                  e.preventDefault();
        });

        $('#pop-salon').popover({
                    html: true,
                    trigger: 'manual'
                }).on( "mouseenter", function(e) {

                    $(this).popover('show');

                    e.preventDefault();
          });
              
        $('body').on('click', function (e) {
          $('[data-toggle="popover"]').each(function () {
              //the 'is' for buttons that trigger popups
              //the 'has' for icons within a button that triggers a popup
              if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                  $(this).popover('hide');
              }
          });
      });

      $('.ayuda').on('mouseenter', function(e) {
        $('.ayuda').not(this).popover('hide')
      })

  </script> 
@stop

