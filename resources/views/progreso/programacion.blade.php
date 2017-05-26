@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">

<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/eosMenu.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/js/eosMenu.js"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
@stop
@section('content')

 <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"> <span id="nombre_modal">Nombre Video</span><button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12 m-b-20 text-center">                                   
                                  <iframe id="video_vimeo" src="https://player.vimeo.com/video/203096537" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>


                               <div class="clearfix"></div> 
                              
                          </div>
                           
                        </div>
                    
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/progreso" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <div class="col-sm-4">
                                <span class="f-16 opaco-0-8" style="text-decoration: underline;">PASO A PASO</span>
                            </div>


                            <div class="col-sm-4">
                             
                            </div>


                             <div class="col-sm-4 text-right">
                                <a class="pointer mostrar f-16 text-success f-700">MOSTRAR TODOS LOS CICLOS</a>
                                <div class="clearfix"></div>
                                <a class="pointer ocultar f-16 text-success f-700">Ocultar todos los ciclos</a>

                                                    
                            </div>

                            <div class="clearfix"></div>
                       
                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">

                                    <!-- NIVELACION 1 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/basico.jpg"></img>

                                     
                                        <div class="eos-menu" id="nivelacion_1">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 1</a>
                                            </li>
                                            <div class="eos-group-title">BÁSICO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961670">01. Ángulos Arriba

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v1" class="pull-right checkbox {{ empty($pasos['n1v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a> 
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961713">02. Ángulos Pa Alante

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v2" class="pull-right checkbox {{ empty($pasos['n1v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961777">03. Ángulos Diagonal Alante

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v3" class="pull-right checkbox {{ empty($pasos['n1v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961828">04. Ángulos Cruzados Alante

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v4" class="pull-right checkbox {{ empty($pasos['n1v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v5']) ? 'disabled' : 'video_url' }}" data-url="207961879">05. Ángulos Pa Atras

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v5" class="pull-right checkbox {{ empty($pasos['n1v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v6']) ? 'disabled' : 'video_url' }}" data-url="207961917">06. Ángulos Diagonal Atras

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v6" class="pull-right checkbox {{ empty($pasos['n1v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v7']) ? 'disabled' : 'video_url' }}" data-url="207961959">07. Ángulos Cruzados Atras

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v7" class="pull-right checkbox {{ empty($pasos['n1v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v8']) ? 'disabled' : 'video_url' }}" data-url="207961995">08. Ángulos Laterales

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v8" class="pull-right checkbox {{ empty($pasos['n1v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v9']) ? 'disabled' : 'video_url' }}" data-url="207962037">09. Ángulos Lateral Simple
                                                  
                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v9" class="pull-right checkbox {{ empty($pasos['n1v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v10']) ? 'disabled' : 'video_url' }}" data-url="207962075">10. Secuencia de Ángulos

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v10" class="pull-right checkbox {{ empty($pasos['n1v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v11']) ? 'disabled' : 'video_url' }}" data-url="207962158">11. Pa´ Arriba

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v11" class="pull-right checkbox {{ empty($pasos['n1v11']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v11']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif


                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v12']) ? 'disabled' : 'video_url' }}" data-url="207962201">12. Cachitos
                                                  
                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v12" class="pull-right checkbox {{ empty($pasos['n1v12']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v12']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v13']) ? 'disabled' : 'video_url' }}" data-url="207962248">13. Al Centro

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v13" class="pull-right checkbox {{ empty($pasos['n1v13']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v13']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v14']) ? 'disabled' : 'video_url' }}" data-url="207962287">14. Arriba

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v14" class="pull-right checkbox {{ empty($pasos['n1v14']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v14']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v15']) ? 'disabled' : 'video_url' }}" data-url="207962328">15. Abajo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v15" class="pull-right checkbox {{ empty($pasos['n1v15']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v15']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v16']) ? 'disabled' : 'video_url' }}" data-url="207962367">16. Son Montuno

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v16" class="pull-right checkbox {{ empty($pasos['n1v16']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v16']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                            </div>


                                            <div class="eos-group-title">BÁSICO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v1']) ? 'disabled' : 'video_url' }}" data-url="207962406">01. Danilo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v1" class="pull-right checkbox {{ empty($pasos['n2v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v2']) ? 'disabled' : 'video_url' }}" data-url="207962455">02. Exhíbela (Doble, 2 con 1)

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v2" class="pull-right checkbox {{ empty($pasos['n2v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v3']) ? 'disabled' : 'video_url' }}" data-url="207962506">03. Dile Que No

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v3" class="pull-right checkbox {{ empty($pasos['n2v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v4']) ? 'disabled' : 'video_url' }}" data-url="207962545">04. Yogurt

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v4" class="pull-right checkbox {{ empty($pasos['n2v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v5']) ? 'disabled' : 'video_url' }}" data-url="208048762">05. Enchufa y Pa´ Arriba

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v5" class="pull-right checkbox {{ empty($pasos['n2v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v6']) ? 'disabled' : 'video_url' }}" data-url="208048855">06. Dame (Otra, enchufa y dame)

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v6" class="pull-right checkbox {{ empty($pasos['n2v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v7']) ? 'disabled' : 'video_url' }}" data-url="208048928">07. Yogurt Con Fresa

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v7" class="pull-right checkbox {{ empty($pasos['n2v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                            </div>
 

                                            <div class="eos-group-title">BÁSICO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">

                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v1']) ? 'disabled' : 'video_url' }}" data-url="208049030">01. Enchufa y Evelyn

                                                  @if($usuario_tipo == 3)
                                                    <input id="n3v1" class="pull-right checkbox {{ empty($pasos['n3v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n3v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v2'])? 'disabled' : 'video_url' }}" data-url="208049132">02. Pa´ Ti Pa´ Mi

                                                  @if($usuario_tipo == 3)
                                                    <input id="n3v2" class="pull-right checkbox {{ empty($pasos['n3v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n3v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v3']) ? 'disabled' : 'video_url' }}" data-url="208049236">03. 70 (Alarde)

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v1" class="pull-right checkbox {{ empty($pasos['n1v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v4']) ? 'disabled' : 'video_url' }}" data-url="208049360">04. Doble Play

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v1" class="pull-right checkbox {{ empty($pasos['n1v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v5']) ? 'disabled' : 'video_url' }}" data-url="208049473">05. Dame Directo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v1" class="pull-right checkbox {{ empty($pasos['n1v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v6'])? 'disabled' : 'video_url' }}" data-url="208049560">06. Adiós Con La familia

                                                  @if($usuario_tipo == 3)
                                                    <input id="n3v6" class="pull-right checkbox {{ empty($pasos['n3v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n3v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                     <!-- NIVELACION 2 -->

                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/intermedio.jpg"></img>

                                        <div class="eos-menu" id="nivelacion_2">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 2</a>
                                            </li>
                                            <div class="eos-group-title">INTERMEDIO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v1']) ? 'disabled' : 'video_url' }}" data-url="208049665">01. El Uno /Dame

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v1" class="pull-right checkbox {{ empty($pasos['n4v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v2']) ? 'disabled' : 'video_url' }}" data-url="208049767">02. El Dos/Dame

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v2" class="pull-right checkbox {{ empty($pasos['n4v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v3']) ? 'disabled' : 'video_url' }}" data-url="208049875">03. Adiós Con la Prima

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v3" class="pull-right checkbox {{ empty($pasos['n4v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif


                                                </a>
                                              </li>
<!--                                               <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" data-url="208049965">05. Vacila y Dame</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v4']) ? 'disabled' : 'video_url' }}" data-url="208050059">04. 84

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v4" class="pull-right checkbox {{ empty($pasos['n4v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v5']) ? 'disabled' : 'video_url' }}" data-url="208050136">05. Enchufa y Raulín

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v5" class="pull-right checkbox {{ empty($pasos['n4v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif


                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v6']) ? 'disabled' : 'video_url' }}" data-url="208050223">06. Candado

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v6" class="pull-right checkbox {{ empty($pasos['n4v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v7']) ? 'disabled' : 'video_url' }}" data-url="208050311">07. Métele El Dedo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v7" class="pull-right checkbox {{ empty($pasos['n4v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
<!--                                               <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" data-url="208050392">10. Torniquete</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v8']) ? 'disabled' : 'video_url' }}" data-url="208050463">08. Media

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v8" class="pull-right checkbox {{ empty($pasos['n4v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v9']) ? 'disabled' : 'video_url' }}" data-url="208050544">09. Media Loca

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v9" class="pull-right checkbox {{ empty($pasos['n4v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v10']) ? 'disabled' : 'video_url' }}" data-url="208050626">10. Enchufa A Lo Moderno

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v10" class="pull-right checkbox {{ empty($pasos['n4v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">INTERMEDIO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v1']) ? 'disabled' : 'video_url' }}" data-url="208050687">01. Enchufa Con Palmas

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v1" class="pull-right checkbox {{ empty($pasos['n5v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v2']) ? 'disabled' : 'video_url' }}" data-url="208050765">02. Paséala por arriba

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v2" class="pull-right checkbox {{ empty($pasos['n5v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v3']) ? 'disabled' : 'video_url' }}" data-url="208050858">03. Paséala por abajo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v3" class="pull-right checkbox {{ empty($pasos['n5v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v4']) ? 'disabled' : 'video_url' }}" data-url="208213692">04. El dedo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v4" class="pull-right checkbox {{ empty($pasos['n5v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v5']) ? 'disabled' : 'video_url' }}" data-url="208213820">05. Coca Cola

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v5" class="pull-right checkbox {{ empty($pasos['n5v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v6']) ? 'disabled' : 'video_url' }}" data-url="208213950">06. Montaña

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v6" class="pull-right checkbox {{ empty($pasos['n5v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v7']) ? 'disabled' : 'video_url' }}" data-url="208214097">07. 72


                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v7" class="pull-right checkbox {{ empty($pasos['n5v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <!-- <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" data-url="208214263">08. 74</a>
                                                </li> -->
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v8']) ? 'disabled' : 'video_url' }}" data-url="208214436">08. Enchufa Mambo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v8" class="pull-right checkbox {{ empty($pasos['n5v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v9']) ? 'disabled' : 'video_url' }}" data-url="208214603">09. 7

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v9" class="pull-right checkbox {{ empty($pasos['n5v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_3->clase_4) || empty($pasos['n5v10']) ? 'disabled' : 'video_url' }}" data-url="208214716">10. Vacila Triple

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v10" class="pull-right checkbox {{ empty($pasos['n5v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                            </div>


                                            <div class="eos-group-title">INTERMEDIO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v1']) ? 'disabled' : 'video_url' }}" data-url="208214885">01. Abrázala

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v1" class="pull-right checkbox {{ empty($pasos['n6v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" data-url="208215025">11. Dame Por Las Manos</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v2']) ? 'disabled' : 'video_url' }}" data-url="208215132">02. Enchufa a Lo Cubano

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v2" class="pull-right checkbox {{ empty($pasos['n6v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v3'])? 'disabled' : 'video_url' }}" data-url="208215285">03. 69

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v3" class="pull-right checkbox {{ empty($pasos['n6v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" data-url="208215431">03. 71</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v4']) ? 'disabled' : 'video_url' }}" data-url="208215593">04. Dedo Guarapo y Bota

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v4" class="pull-right checkbox {{ empty($pasos['n6v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) || empty($pasos['n6v5']) ? 'disabled' : 'video_url' }}" data-url="208215737">05. Jessica

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v5" class="pull-right checkbox {{ empty($pasos['n6v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v6']) ? 'disabled' : 'video_url' }}" data-url="208215875">06. Abanico

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v6" class="pull-right checkbox {{ empty($pasos['n6v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v7']) ? 'disabled' : 'video_url' }}" data-url="208216007">07. Abanico y Bota

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v7" class="pull-right checkbox {{ empty($pasos['n6v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v8']) ? 'disabled' : 'video_url' }}" data-url="208216134">08. Sombrero Doble

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v8" class="pull-right checkbox {{ empty($pasos['n6v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v9']) ? 'disabled' : 'video_url' }}" data-url="208216270">09. 7 Coca Cola

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v9" class="pull-right checkbox {{ empty($pasos['n6v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v10']) ? 'disabled' : 'video_url' }}" data-url="208216376">10. El Beso

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v10" class="pull-right checkbox {{ empty($pasos['n6v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>


                                    <!-- NIVELACION 3 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/avanzado.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_3">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 3</a>
                                            </li>
                                            <div class="eos-group-title">AVANZADO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" data-url="208216522">11. 73</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v1'])? 'disabled' : 'video_url' }}" data-url="208216684">01. Cepillao

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v1" class="pull-right checkbox {{ empty($pasos['n7v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v2']) ? 'disabled' : 'video_url' }}" data-url="208216841">02. Tócale La T

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v2" class="pull-right checkbox {{ empty($pasos['n7v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v3']) ? 'disabled' : 'video_url' }}" data-url="208216997">03. Brazalete

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v3" class="pull-right checkbox {{ empty($pasos['n7v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" data-url="208217143">02. Sonia</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v4']) ? 'disabled' : 'video_url' }}" data-url="208217281">04. Trenza

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v4" class="pull-right checkbox {{ empty($pasos['n7v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" data-url="208217574">05. Matanzas</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v5']) ? 'disabled' : 'video_url' }}" data-url="208217734">05. Ciclón

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v5" class="pull-right checkbox {{ empty($pasos['n7v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v6']) ? 'disabled' : 'video_url' }}" data-url="208217894">06. Baracoa

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v6" class="pull-right checkbox {{ empty($pasos['n7v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v7']) ? 'disabled' : 'video_url' }}" data-url="208218040">07. 75

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v7" class="pull-right checkbox {{ empty($pasos['n7v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v8']) ? 'disabled' : 'video_url' }}" data-url="208218167">08. Sombrero Enganchado

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v8" class="pull-right checkbox {{ empty($pasos['n7v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif


                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" data-url="208218600">10. Palafitos</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v9']) ? 'disabled' : 'video_url' }}" data-url="208218751">09. La De Antonio

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v9" class="pull-right checkbox {{ empty($pasos['n7v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v10']) ? 'disabled' : 'video_url' }}" data-url="208219037">10. Atrevido

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v10" class="pull-right checkbox {{ empty($pasos['n7v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">AVANZADO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v1']) ? 'disabled' : 'video_url' }}" data-url="208218918">01. Coca Cola Por Detrás

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v1" class="pull-right checkbox {{ empty($pasos['n8v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v2']) ? 'disabled' : 'video_url' }}" data-url="208219144">02. Balsero

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v2" class="pull-right checkbox {{ empty($pasos['n8v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v3']) ? 'disabled' : 'video_url' }}" data-url="203096537">03. 7 Moderno

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v3" class="pull-right checkbox {{ empty($pasos['n8v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">02. Camagüey</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v4']) ? 'disabled' : 'video_url' }}" data-url="203096537">04. Juana La Cubana

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v4" class="pull-right checkbox {{ empty($pasos['n8v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Morón</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v5']) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Sombrero Por Debajo

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v5" class="pull-right checkbox {{ empty($pasos['n8v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">07. La Jugada</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v6']) ? 'disabled' : 'video_url' }}" data-url="203096537">06. El Puente

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v6" class="pull-right checkbox {{ empty($pasos['n8v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v7']) ? 'disabled' : 'video_url' }}" data-url="203096537">07. Cuchillo Y Córtala

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v7" class="pull-right checkbox {{ empty($pasos['n8v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v8']) ? 'disabled' : 'video_url' }}" data-url="203096537">08. El 12

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v8" class="pull-right checkbox {{ empty($pasos['n8v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v9']) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Tornado

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v9" class="pull-right checkbox {{ empty($pasos['n8v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v10']) ? 'disabled' : 'video_url' }}" data-url="203096537">10. La Jenny

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v10" class="pull-right checkbox {{ empty($pasos['n8v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">AVANZADO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. 7 70


                                                @if($usuario_tipo == 3)
                                                  <input id="n9v1" class="pull-right checkbox {{ empty($pasos['n9v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif


                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">03. 77</a>
                                              </li> -->
                                             <!--  
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Huracán</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v2']) ? 'disabled' : 'video_url' }}" data-url="203096537">02. Sombrero De Diana

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v2" class="pull-right checkbox {{ empty($pasos['n9v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v3']) ? 'disabled' : 'video_url' }}" data-url="203096537">03. 7 Loco

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v3" class="pull-right checkbox {{ empty($pasos['n9v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v4']) ? 'disabled' : 'video_url' }}" data-url="203096537">04. Azuquita

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v4" class="pull-right checkbox {{ empty($pasos['n9v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Ascensor</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v5']) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Sombrero De Regnier

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v5" class="pull-right checkbox {{ empty($pasos['n9v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v6']) ? 'disabled' : 'video_url' }}" data-url="203096537">06. Ponle Sabor

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v6" class="pull-right checkbox {{ empty($pasos['n9v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">12. Rumbita</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v7']) ? 'disabled' : 'video_url' }}" data-url="203096537">07. Paséala Y Complícate

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v7" class="pull-right checkbox {{ empty($pasos['n9v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v8']) ? 'disabled' : 'video_url' }}" data-url="203096537">08. Jimawa

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v8" class="pull-right checkbox {{ empty($pasos['n9v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v9']) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Rubenada

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v9" class="pull-right checkbox {{ empty($pasos['n9v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">04. 84 Complicado</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v10']) ? 'disabled' : 'video_url' }}" data-url="203096537">10. Oro Negro

                                                @if($usuario_tipo == 3)
                                                  <input id="n9v10" class="pull-right checkbox {{ empty($pasos['n9v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- NIVELACION 4 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/master.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_4">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 4</a>
                                            </li>
                                            <div class="eos-group-title">MASTER 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content"> 
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">06. Tormenta</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Consorte

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v1" class="pull-right checkbox {{ empty($pasos['n10v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">08. El Bebé</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v2']) ? 'disabled' : 'video_url' }}" data-url="203096537">02. 75 Con Gancho

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v2" class="pull-right checkbox {{ empty($pasos['n10v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">10. Tunturuntún</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v3']) ? 'disabled' : 'video_url' }}" data-url="203096537">03. La Cuñada

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v3" class="pull-right checkbox {{ empty($pasos['n10v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v4']) ? 'disabled' : 'video_url' }}" data-url="203096537">04. Copelia

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v4" class="pull-right checkbox {{ empty($pasos['n10v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Ola Brava</a>
                                              </li> -->
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">02. Niágara</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v5']) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Primo Hermano

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v5" class="pull-right checkbox {{ empty($pasos['n10v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v6']) ? 'disabled' : 'video_url' }}" data-url="203096537">06. 75 Derecho/Revés

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v6" class="pull-right checkbox {{ empty($pasos['n10v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Venezolano</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v7']) ? 'disabled' : 'video_url' }}" data-url="203096537">07. 70 Nuevo

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v7" class="pull-right checkbox {{ empty($pasos['n10v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v8']) ? 'disabled' : 'video_url' }}" data-url="203096537">08. La Tuya

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v8" class="pull-right checkbox {{ empty($pasos['n10v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v9']) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Dedo Saboreado

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v9" class="pull-right checkbox {{ empty($pasos['n10v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v10']) ? 'disabled' : 'video_url' }}" data-url="203096537">10. La Cuadra

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v10" class="pull-right checkbox {{ empty($pasos['n10v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">MASTER 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Sombrero de Magni

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v1" class="pull-right checkbox {{ empty($pasos['n11v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v2']) ? 'disabled' : 'video_url' }}" data-url="208217431">02. Sombréala

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v2" class="pull-right checkbox {{ empty($pasos['n11v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v3']) ? 'disabled' : 'video_url' }}" data-url="203096537">03. Uno Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v3" class="pull-right checkbox {{ empty($pasos['n11v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v4']) ? 'disabled' : 'video_url' }}" data-url="203096537">04. Sabrosura

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v4" class="pull-right checkbox {{ empty($pasos['n11v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v5']) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Sombrero De Cusco

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v5" class="pull-right checkbox {{ empty($pasos['n11v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v6']) ? 'disabled' : 'video_url' }}" data-url="203096537">06. 7 loco Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v6" class="pull-right checkbox {{ empty($pasos['n11v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v7']) ? 'disabled' : 'video_url' }}" data-url="203096537">07. Tijeras

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v7" class="pull-right checkbox {{ empty($pasos['n11v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v8']) ? 'disabled' : 'video_url' }}" data-url="203096537">08. 90

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v8" class="pull-right checkbox {{ empty($pasos['n11v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v9']) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Rumbera

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v9" class="pull-right checkbox {{ empty($pasos['n11v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v10']) ? 'disabled' : 'video_url' }}" data-url="203096537">10. Carnaval

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v10" class="pull-right checkbox {{ empty($pasos['n11v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Tenampa</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">05. 70 y Pescao</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">07. 70 y Pico</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">10. La Espuma</a>
                                              </li> -->
                                            </div>

                                            <div class="eos-group-title">MASTER 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Rubenada Complicada

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v1" class="pull-right checkbox {{ empty($pasos['n12v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v2']) ? 'disabled' : 'video_url' }}" data-url="203096537">02. Alrededor Del Mundo

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v2" class="pull-right checkbox {{ empty($pasos['n12v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v3']) ? 'disabled' : 'video_url' }}" data-url="203096537">03. Chocolate

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v3" class="pull-right checkbox {{ empty($pasos['n12v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v4']) ? 'disabled' : 'video_url' }}" data-url="203096537">04. Bacardí Con Limón

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v4" class="pull-right checkbox {{ empty($pasos['n12v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v5']) ? 'disabled' : 'video_url' }}" data-url="203096537">05. Terremoto

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v5" class="pull-right checkbox {{ empty($pasos['n12v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v6']) ? 'disabled' : 'video_url' }}" data-url="203096537">06. Candado Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v6" class="pull-right checkbox {{ empty($pasos['n12v6']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v6']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v7']) ? 'disabled' : 'video_url' }}" data-url="203096537">07. Abanico Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v7" class="pull-right checkbox {{ empty($pasos['n12v7']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v7']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v8']) ? 'disabled' : 'video_url' }}" data-url="203096537">08. Copelia Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v8" class="pull-right checkbox {{ empty($pasos['n12v8']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v8']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v9']) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Bacardí Complicado

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v9" class="pull-right checkbox {{ empty($pasos['n12v9']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v9']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v10']) ? 'disabled' : 'video_url' }}" data-url="203096537">10. Energía Latina

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v10" class="pull-right checkbox {{ empty($pasos['n12v10']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v10']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">05. La Vieja</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">06. Xioma</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">07. Mata 7</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">08. Angie</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">09. Gigante</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">10. Hormiguero</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">11. Nonna</a>
                                              </li> -->
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                 
                                <br><br><br>
                            
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
  <script type="text/javascript">

    route_update="{{url('/')}}/programacion/update/paso";

    $(document).ready(function(){

      $("#nivelacion_1").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_2").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_3").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_4").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $( ".eos-item" ).addClass( "detalle_oscuro" );

      @if($usuario_tipo != 3)

        $('.disabled').attr('data-trigger','hover');
        $('.disabled').attr('data-toggle','popover');
        $('.disabled').attr('data-placement','right');
        $('.disabled').attr('data-content','<p class="c-negro">Aún no posees la credencial para ver este vídeo</p>');
        $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
        $('.disabled').attr('data-html','true');
        $('.disabled').attr('title','');

        $('[data-toggle="popover"]').popover(); 
      @endif

      $('.ciclo').addClass('disabled');

    });

    var vi_player = new Vimeo.Player('video_vimeo');
    
    $('.eos-item').click(function(e) {

      target = $(e.target)

      if(target.hasClass('checkbox')){
        if(target.hasClass('checked')){
          target.removeClass('checked')
          target.addClass('unchecked')
          target.val('0');
        }else{
          target.val('1');
          target.removeClass('unchecked')
          target.addClass('checked')
        }

        $.ajax({
          url: route_update,
          headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
          type: 'POST',
          dataType: 'json',
          data:"&clase_grupal_id={{$id}}&id="+target.attr('id')+"&valor="+target.val(),              
          success: function (data) {
            if(data.status=='OK'){
              console.log('success');
            }else{
              console.log('error');
            }
          },
          error:function (xhr, ajaxOptions, thrownError){
            console.log('error');
          }
        })

      }else if(target.hasClass('video_url')){

        video_id = target.data('url');
        titulo = target.text()

        vi_player.loadVideo(video_id).then(function(id) {

        }).catch(function(error) {
            console.log('vi error', error.name);
        });

        $('#nombre_modal').text(titulo)

        $('#modalVideo').modal('show');
      }
    });

    $(".eos-group-title").click(function(e) {

      e.preventDefault();

      var icono = $(this).children('i');

      if($(icono).hasClass('glyphicon-plus'))
      {
        $(icono).removeClass('glyphicon-plus')
        $(icono).addClass('glyphicon-minus')
      }else{
        $(icono).removeClass('glyphicon-minus')
        $(icono).addClass('glyphicon-plus')
      }

    });

    $('#modalVideo').on('hidden.bs.modal', function () {

      vi_player.pause()

    });

    $(".mostrar").click(function(e) {

      $('.eos-menu-content').css('height','1360px')
      $('.eos-group-content').css('height','400px')

      $(".glyphicon").removeClass('glyphicon-plus')
      $(".glyphicon").addClass('glyphicon-minus')

    });

    $(".ocultar").click(function(e) {

      $('.eos-menu-content').css('height','160px')
      $('.eos-group-content').css('height','0px')

      $(".glyphicon").removeClass('glyphicon-minus')
      $(".glyphicon").addClass('glyphicon-plus')
      
    });
      
   </script>

@stop