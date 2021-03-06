@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop
@section('content')
    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-morado">Recomendaciones  para el video<button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="modal-body">
                        <div class="row p-l-10 p-r-10">

                        <div class="col-sm-5"></div>
                        <div class="col-sm-2"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 130px; max-width: 130px;" class="img-responsive opaco-0-8" alt=""></div>
                        <div class="col-sm-5"></div>

                        <div class="clearfix p-b-15"></div>
                        <div class="text-center">
                            <span class="f-25 c-morado text-center">Hola {{Auth::user()->nombre}}</span>  
                            <br></br>   
                            <span class="f-16 c-morado">Estoy aqui para hacerte unas recomendaciones</span>  
                        </div>

                        <hr></hr>

                        <p><span class="f-20 f-700">Los colaboradores financian ideas que los apasionan y a la gente en la que confían. Estas son algunas cosas que puedes hacer en esta sección:</span></p>
                            
                            <div class="f-16">
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Preséntate y cuenta tu historia.</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Describe brevemente tu campaña  y explica por qué es importante para ti.</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Expresa la magnitud de lo que logrará la ayuda de los colaboradores.</p>

                            <p class="c-morado">Recuerda, sé breve pero personal. Pregúntate: si alguien dejara de leer aquí, ¿estaría listo para colaborar?</p>
                            </div>

                            <hr></hr>

                            <p><span class="f-20 f-700">Lo que necesitamos y lo que obtienes</span></p>
                            
                            <div class="f-16">
                            <p>Explica cuánto financiamiento necesitas y a dónde va. Sé transparente y específico, la gente necesita confiar en ti para que quiera financiarte.</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Cuéntale a la gente sobre tus recompensas exclusivas. ¡Haz que se entusiasmen!</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Describe a dónde van los fondos si no logras la meta total.</p>
                            </div>

                            <hr></hr>

                            <p><span class="f-20 f-700">El impacto</span>
                            
                            <div class="f-16">
                            <p>Explica tu campaña en mayor detalle y cuéntale a la gente la diferencia que hará su contribución:</p>

                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Explica por qué tu proyecto es valioso para el colaborador y para el mundo.</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Describe tu historial de éxito en proyectos como este (si lo tienes).</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Haz que la gente lo sienta real y genera confianza.</p>
                            </div>

                            <hr></hr>

                            <p><span class="f-20 f-700">Riesgos y desafíos</span>

                            <div class="f-16">
                            <p>Las personas valoran la transparencia. Sé abierto y destácate al ofrecer perspectivas sobre los riesgos y obstáculos que puedes enfrentar en el camino hacia lograr tu meta.</p>

                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Comparte lo que hace que te destaques para superar estos obstáculos.</p>
                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Describe tu plan para solucionar estos desafíos.</p>
                            </div>
                           
                            <hr></hr>

                            <p><span class="f-20 f-700">Otras formas en las que puedes ayudar</span>
                            
                            <div class="f-16">
                            <p>Algunas personas no pueden colaborar, pero eso no significa que no puedan ayudar:</p>

                            <p><i class="zmdi zmdi-check zmdi-hc-fw"></i> Pídele a la gente que difunda tu campaña y que genere eco.</p>
                            </div>
                            
                            <p><span class="f-20 c-morado">Hazlo...</span></p>

                            <div class="text-right"><i onclick="subir()" class="zmdi zmdi-caret-up-circle zmdi-hc-fw f-30 c-morado pointer"></i></div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Campaña</a><ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        
                    </div> 
                    
                      <div class="card">
                        <div class="card-header text-center">
                            <span class="f-30 c-morado"><i class="icon_a-campana f-25" id="id-clase_grupal_id"></i> Comienza una campaña </span>     
                        </div>
                        


                        <div class="card-body p-b-20">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                                <div class="col-sm-12">

                                <span class="f-30 text-center c-morado">Recauda fondos para tu proyecto creativo e inspirador</span>
                                    
                                <hr></hr>

                                <div class="clearfix p-b-15"></div>

                                <div class="col-sm-12">
                                 <form name="agregar_campana" id="agregar_campana"  >
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                 
                                    <label for="nombre" id="id-cantidad">¿Cuánto dinero deseas recaudar?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la cantidad máxima que aspiras recaudar en tu campaña" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-pagar f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="0000000000" placeholder="Ej. 50000">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">¿Cuál es el título de tu campaña?</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la campaña" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-campana f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="50 Caracteres">
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
                            <label for="apellido" id="id-imagen">Imagen principal de la campaña</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                            
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
                                 
                                    <span class="f-30 text-center c-morado">Fundamento e Historia</span>
                                  

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div>
                                    
                                    <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-historia">Historia</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Cuéntale más a los posibles colaboradores sobre de tu campaña. Preséntate y proporciona detalles que motiven a las personas a colaborar. Una buena explicación es convincente, informativa y fácil de resumir" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="historia" name="historia" rows="8" placeholder="500 Caracteres" maxlength="500" onkeyup="countChar(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum">500</span> Caracteres</div>
                                 <div class="has-error" id="error-historia">
                                      <span >
                                          <small class="help-block error-span" id="error-historia_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                              <div class="clearfix p-b-35"></div>
                                    <div class="col-sm-12">
                                    
                                    <label for="nombre" id="id-eslogan">Eslogan</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Diseña tu eslogan y dale una mejor presencia al concepto de tu campaña" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-flash zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="eslogan" id="eslogan" placeholder="Ej. Todos unidos por una sola causa">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-eslogan">
                                      <span >
                                          <small class="help-block error-span" id="error-eslogan_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">

                                    <label for="nombre" id="id-plazo">Plazo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="En este campo podrás determinar la cantidad de dias de la duración de la campaña, recomendamos un plazo entre 30 y 45 dias. Las campañas no pueden excederse de un máximo de 60 dias" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-hourglass-alt zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">

                                      <input type="text" class="form-control input-sm input-mask" name="plazo" id="plazo" data-mask="00" placeholder="Ej. 35">

                                      </div>
                                    </div>
                                 <div class="has-error" id="error-plazo">
                                      <span >
                                          <small class="help-block error-span" id="error-plazo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                  <label for="id" id="id-link_video">Ingresa url del video promocional</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Haz un video promocional no mayor a dos minutos, mientras mejor desarrolles tu video, tendrás  más oportunidad de persuadir a tus clientes a contribuir con el logro de tus objetivos" title="" data-original-title="Ayuda"></i>
                                  <br></br>

                                  <span class="f-16">Antes de crear el video, te sugerimos las siguientes recomendaciones que hemos creado para ti.</span> <span data-toggle="modal" id="modalAgregarBtn" href="#modalAgregar" class="f-14 p-t-0 text-success pointer">Ver Recomendaciones</span>

                                  <div class="clearfix p-b-35"></div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="link_video" id="link_video" placeholder="Ingresa la url">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-link_video">
                                    <span >
                                     <small id="error-link_video_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>
                                
                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-presentacion">Presentación general de la campaña</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Preséntate, presenta tus antecedentes, tu campaña y por qué es importante para ti. Expresa la magnitud de lo que te ayudarán a lograr tus colaboradores" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control" id="presentacion" name="presentacion" rows="8" placeholder="500 Caracteres" maxlength="500" onkeyup="countChar2(this)"></textarea>
                                  </div>
                                  <div class="opaco-0-8 text-right">Resta <span id="charNum2">500</span> Caracteres</div>
                                 <div class="has-error" id="error-presentacion">
                                      <span >
                                          <small class="help-block error-span" id="error-presentacion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                            <label for="apellido" id="id-imagen_presentacion">Imagen de la presentación general</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                            
                            <div class="clearfix p-b-15"></div>
                              
                              <input type="hidden" name="imagePresentacionBase64" id="imagePresentacionBase64">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div id="imagenb" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px"></div>
                                <div>
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="imagen_presentacion" id="imagen_presentacion" >
                                    </span>
                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                </div>
                            </div>
                              <div class="has-error" id="error-imagen_presentacion">
                              <span >
                                  <small class="help-block error-span" id="error-imagen_presentacion_mensaje"  ></small>
                              </span>
                            </div>
                          </div>

                          <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="condiciones" id="id-condiciones">Condiciones y Normativas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las condiciones necesarias, dichas condiciones serán vistas por tus clientes y de esa forma podrás mantener una comunicación clara y transparente en cuanto a las normativas que rigen en tus actividades" title="" data-original-title="Ayuda"></i>
                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" style="height: 100%" id="condiciones" name="condiciones" rows="8" placeholder="1500 Caracteres"  maxlength="1500" onkeyup="countChar3(this)"></textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum3">1500</span> Caracteres</div>
                                    <div class="has-error" id="error-condiciones">
                                      <span >
                                        <small class="help-block error-span" id="error-condiciones_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>


                                
                                <div class="clearfix p-b-35"></div>   

                                <div class="col-sm-12">
                                   <div class="form-group fg-line ">
                                      <label for="">Promocionar en la web</label id="id-boolean_promocionar"> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Mostrar la clase grupal en la web" title="" data-original-title="Ayuda"></i>
                                      
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
 

                              </div>
                            </form>
                            
                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Recompensa</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-html="true" data-content="Las recompensas son incentivos que se ofrecen a los colaboradores a cambio de su apoyo. Puedes editar una recompensa hasta antes de que sea reclamada por un colaborador. A continuación presentaremos el tipo de recompensa que no debes ofrecer: 
                                    <br>
                                    1.- Capital, patrimonio neto u otra participación en una empresa o negocio.
                                    <br>
                                    2.- Todo producto para el consumo de alcohol.
                                    <br>
                                    3.- Sustancia controlada o parafernalia de fármacos.
                                    <br>
                                    4.- Armas, municiones y accesorios relacionados.
                                    <br>
                                    5.- Toda forma de lotería o juego de apuestas" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <form name="agregar_recompensa" id="agregar_recompensa">

                                    <label for="nombre_estudio" id="id-nombre_recompensa">Título</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="El título para esta recompensa es lo que aparecerá en tu página de la campaña de Easy Dance . Crear un título que describa bien el contenido de lo que ofrece esta recompensa" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-estudio-salon f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_recompensa" id="nombre_recompensa" placeholder="Ej. Pase VIP">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_recompensa">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_recompensa_mensaje" ></small>                               
                                      </span>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <label for="cantidad_recompensa" id="id-cantidad_recompensa">Precio</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Este monto representa lo que deseas recaudar  de los patrocinadores que busquen esta recompensa, por los elementos incluidos en este campo" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-collection-item-1 f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="cantidad_recompensa" id="cantidad_recompensa" data-mask="0000000" placeholder="Ej. 50">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-cantidad_recompensa">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_recompensa_mensaje" ></small>                               
                                      </span>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <label for="descripcion_recompensa" id="id-descripcion_recompensa">Descripción</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Describe los detalles de esta recompensa. Sé creativo, esta es tu oportunidad de  orientar a tus seguidores  sobre lo que recibirán después de que reclamen esta recompensa" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b-cuentales-historia f-22"></i></span>
                                      <div class="fg-line">
                                        <input type="text" class="form-control input-sm input-mask" name="descripcion_recompensa" id="descripcion_recompensa" placeholder="Ingresa la descripción">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-descripcion_recompensa">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_recompensa_mensaje" ></small>                               
                                      </span>
                                  </div></form>
                               </div>

                              <br>

                              <div class="card-header text-left">
                              <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="add" >Agregar Linea</button>
                              </div>

                              <br></br>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    
                                    <th class="text-center" data-column-id="recompensa"></th>
                                    <th class="text-center" data-column-id="cantidad" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="descripcion"></th>
                                    <th class="text-center" data-column-id="operaciones"></th>

                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                            </table>

                            </div>
                            </div>

                            <div class="clearfix p-b-35"></div>
                            <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>

                            <div class="clearfix p-b-35"></div>
                                      <hr></hr>


                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>

                               

                               <div class="clearfix p-b-35"></div>


                                <div class="col-sm-12">



                                    <div class="form-group fg-line">
                                    <label for="nombre">Datos Bancarios</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los datos personales o jurídicos correspondientes a tu cuenta, de esa forma, tus alumnos podrán gestionar sus cancelaciones de manera directa a tu cuenta bancaria" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseDatos" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseDatos" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <form name="agregar_datos" id="agregar_datos">


                                    <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre_banco">Nombre del banco</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la identidad bancaria a la que deseas que tus clientes y alumnos realicen sus aportes" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_c-piggy-bank f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_banco" id="nombre_banco" placeholder="Ej. Banco del Tesoro">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_banco">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_banco_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                              <div class="clearfix p-b-35"></div>
                                    <div class="col-sm-12">
                                    
                                    <label for="nombre" id="id-tipo_cuenta">Tipo de Cuenta</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el tipo de cuenta que representa tu identidad bancaria" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_c-credit-cards f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="tipo_cuenta" id="tipo_cuenta" placeholder="Ej. Cuenta Corriente">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-tipo_cuenta">
                                      <span >
                                          <small class="help-block error-span" id="error-tipo_cuenta_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">

                                    <label for="nombre" id="id-numero_cuenta">Número de Cuenta</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de cuenta que representa tu identidad bancaria" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_c-money f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="numero_cuenta" id="numero_cuenta" data-mask="0000-0000-00-0000000000" placeholder="Ingresa Número de Cuenta">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-numero_cuenta">
                                      <span >
                                          <small class="help-block error-span" id="error-numero_cuenta_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                                    <label for="nombre" id="id-rif">Rif - Cédula</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la identidad legal del número de cuenta" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="rif" id="rif" placeholder="Ej. Rif: J-298324278">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-rif">
                                      <span >
                                          <small class="help-block error-span" id="error-rif_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                    <label for="nombre" id="id-nombre_creador">Nombre</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre de la identidad legal del número de cuenta" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre_creador" id="nombre_creador" placeholder="Ej. Valeria Zambrano">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre_creador">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_creador_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div></form>


                               <div class ="col-sm-12">

                                 <br><br>

                                 <div class="card-header text-left">
                                <button type="button" class="btn btn-blanco m-r-10 f-10 guardar" id="adddatos" >Agregar Linea</button>
                                </div>

                                <br></br>

                              </div>

                              <div class="clearfix"></div>

                          <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tabledatos" >
                            <thead>
                                <tr>
                                    
                                    <th class="text-center" data-column-id="nombre_banco"></th>
                                    <th class="text-center" data-column-id="tipo" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="numero"></th>
                                    <th class="text-center" data-column-id="rif"></th>
                                    <th class="text-center" data-column-id="nombre_creador"></th>
                                    <th class="text-center" data-column-id="operaciones"></th>

                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                            </table>

                            </div>
                            </div>


                               <div class="clearfix p-b-35"></div>
                              <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseDatos')" ></i></div>

                              <div class="clearfix p-b-35"></div>
                                      <hr></hr>

                                 </div>
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

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Lanza la Campaña</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar">Cancelar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div> 

          

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/especiales/campañas/agregar";
  route_principal="{{url('/')}}/especiales/campañas";
  route_recompensa="{{url('/')}}/especiales/campañas/agregarrecompensa";
  route_eliminar="{{url('/')}}/especiales/campañas/eliminarrecompensa";
  route_datos_agregar="{{url('/')}}/especiales/campañas/agregardatos";
  route_datos_eliminar="{{url('/')}}/especiales/campañas/eliminardatos";
  
  $(document).ready(function(){

        $("#boolean_promocionar").val('1');  //VALOR POR DEFECTO
        $("#promocionar").attr("checked", true); //VALOR POR DEFECTO

        $("#promocionar").on('change', function(){
          if ($("#promocionar").is(":checked")){
            $("#boolean_promocionar").val('1');
          }else{
            $("#boolean_promocionar").val('0');
          }    
        });

        document.getElementById("cantidad").focus();
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
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

        $("#imagen_presentacion").bind("change", function() {
            setTimeout(function(){
              var imagen = $("#imagenb img").attr('src');
              var canvas = document.createElement("canvas");
     
              var context=canvas.getContext("2d");
              var img = new Image();
              img.src = imagen;
              
              canvas.width  = img.width;
              canvas.height = img.height;

              context.drawImage(img, 0, 0);
       
              var newimage = canvas.toDataURL("image/jpeg", 0.8);
              var image64 = $("input:hidden[name=imagePresentacionBase64]").val(newimage);
            },500);

        });
      }); 

  setInterval(porcentaje, 1000);

  function porcentaje(){
    var campo = ["nombre", "cantidad", "imagen", "historia", "eslogan", "plazo", "link_video", "condiciones", "presentacion", "imagen_presentacion"];
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
    //console.log(porcetaje);
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
    //$("#barra-progreso").s

  }

  var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
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

    var h=$('#tabledatos').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        order: [[0, 'asc']],
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

            $("#add").click(function(){

                var route = route_recompensa;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_recompensa" ).serialize();

                $("#add").attr("disabled","disabled");
                $("#add").css({
                      "opacity": ("0.2")
                }); 

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

                          $("#agregar_recompensa")[0].reset();

                          var recompensa = respuesta.array[0].recompensa;
                          var cantidad = respuesta.array[0].cantidad;
                          var descripcion = respuesta.array[0].descripcion;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+recompensa+'',
                          ''+cantidad+'',
                          ''+descripcion+'',
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }
                        $("#add").removeAttr("disabled");
                        $("#add").css({
                            "opacity": ("1")
                        });                     

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
                        $("#add").removeAttr("disabled");
                        $("#add").css({
                            "opacity": ("1")
                        });
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
                   url: route_eliminar+"/"+id,
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

    $("#adddatos").click(function(){

              $("#adddatos").attr("disabled","disabled");
              $("#adddatos").css({
                  "opacity": ("0.2")
              }); 

                var route = route_datos_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_datos" ).serialize(); 

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
                          $("#agregar_datos")[0].reset();

                          $("#adddatos").removeAttr("disabled");
                          $("#adddatos").css({
                              "opacity": ("1")
                          });

                          var nombre_banco = respuesta.array[0].nombre_banco;
                          var tipo_cuenta = respuesta.array[0].tipo_cuenta;
                          var numero_cuenta = respuesta.array[0].numero_cuenta;
                          var rif = respuesta.array[0].rif;
                          var nombre = respuesta.array[0].nombre;

                          var rowId=respuesta.id;
                          var rowNode=h.row.add( [
                          ''+nombre_banco+'',
                          ''+tipo_cuenta+'',
                          ''+numero_cuenta+'',
                          ''+rif+'',
                          ''+nombre+'',
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $("#add").removeAttr("disabled");
                        $("#add").css({
                            "opacity": ("1")
                        });

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
                        $("#adddatos").removeAttr("disabled");
                        $("#adddatos").css({
                            "opacity": ("1")
                        });
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

    $('#tabledatos tbody').on( 'click', 'i.zmdi-delete', function () {
        var padre=$(this).parents('tr');
        var token = $('input:hidden[name=_token]').val();
        var id = $(this).closest('tr').attr('id');
              $.ajax({
                   url: route_datos_eliminar+"/"+id,
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

                h.row( $(this).parents('tr') )
                  .remove()
                  .draw();
            });

  $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_campana" ).serialize(); 
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
                        if(msj.responseJSON.status=="ERROR"){
                          if (typeof msj.responseJSON === "undefined") {
                            window.location = "{{url('/')}}/error";
                          }
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
        var campo = ["nombre", "cantidad", "imagen", "historia", "eslogan", "plazo", "link_video", "nombre_banco", "tipo_cuenta", "numero_cuenta", "rif", "correo", "condiciones"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
      var campo = ["nombre", "cantidad", "imagen", "historia", "eslogan", "plazo", "link_video", "nombre_banco", "tipo_cuenta", "numero_cuenta", "rif", "correo", "condiciones"];
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

      $('#collapseDatos').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseDatos').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

       $( "#cancelar" ).click(function() {
        $("#agregar_campana")[0].reset();
        $("#agregar_recompensa")[0].reset();
        $("#agregar_datos")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-clase_grupal_id").offset().top-90,
        }, 1500);
        $("#cantidad").focus();
      });

  function subir(){
    $('#modalAgregar').animate({ scrollTop: 0 }, 'slow');
  }

  function countChar(val) {
    var len = val.value.length;
    if (len >= 500) {
      val.value = val.value.substring(0, 500);
    } else {
      $('#charNum').text(500 - len);
    }
  };

  function countChar2(val) {
    var len = val.value.length;
    if (len >= 500) {
      val.value = val.value.substring(0, 500);
    } else {
      $('#charNum2').text(500 - len);
    }
  };

  function countChar3(val) {
    var len = val.value.length;
    if (len >= 1500) {
      val.value = val.value.substring(0, 1500);
    } else {
      $('#charNum3').text(1500 - len);
    }
  };


</script> 
@stop

