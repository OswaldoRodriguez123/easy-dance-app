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
                                <span class="f-16 opaco-0-8" style="text-decoration: underline;">PROGRAMACIÓN DE LAS CLASES</span>
                            </div>


                            <div class="col-sm-4">
                             
                            </div>


                             <div class="col-sm-4 text-right">
                                <a class="pointer mostrar f-16 text-success f-700">MOSTRAR TODAS LAS NIVELACIONES</a>
                                <div class="clearfix"></div>
                                <a class="pointer ocultar f-16 text-success f-700">Ocultar todas las nivelaciones</a>

                                                    
                            </div>

                            <div class="clearfix"></div>
                       
                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">
                                    <div class="clearfix" style="margin-bottom: 50px"></div>

                                    <!-- NIVELACION 1 -->
                                    
                                    <div class="col-sm-3">
                                        <div class="eos-menu" id="nivelacion_1">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a href="#">NIVELACIÓN 1</a>
                                            </li>
                                            <div class="eos-group-title">BASICO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">01. Introducción Teórica</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">02. Ángulos</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">03. Tiempos Musicales</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">04. Secuencia de Ángulos</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">05. Arriba/Abajo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">06. Pa´ Arriba</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">07. Pa´ Abajo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">08. Son Montuno</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">09. Danilo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">10. Exhíbela (Doble, 2 con 1)</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">11. Dile Que No</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">12. Espejo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" href="203096537">13. Yogurt</a>
                                              </li>
                                            </div>


                                            <div class="eos-group-title">BASICO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Enchufa y Pa´ Arriba</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Dame (Otra, enchufa y dame)</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Yogurt Con Fresa</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Enchufa Doble/Triple</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Adiós/ Doble</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Enchufa y Evelyn</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Pa´ Ti Pa´ Mi</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Vacila/Con Ella</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. 70 (Alarde)</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Doble Play</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Adiós Con La Hermana</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12.  Pelotas (1,2,3)</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">13. Sombrero (Una Mano)</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">14. Dame Directo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">15. Pelota Loca</a>
                                              </li>
                                            </div>
 

                                            <div class="eos-group-title">BASICO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Adiós Con La familia</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. El Uno /Dame</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. El Dos/Dame</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Adiós Con la Prima</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Vacila y Dame</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. 84</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Enchufa y Raulín</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Candado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Métele El Dedo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Torniquete</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Media/Loca</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Una Pa´ Arriba</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">13. Enchufa A Lo Moderno</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">14. Enchufa Con Palmas</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">15. Paséala</a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                     <!-- NIVELACION 2 -->

                                    
                                    <div class="col-sm-3">
                                        <div class="eos-menu" id="nivelacion_2">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a href="#">NIVELACIÓN 2</a>
                                            </li>
                                            <div class="eos-group-title">INTERMEDIO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. El dedo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Dame Directo Doble</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Coca Cola</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Montaña</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. 72</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. 74</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Enchufa Mambo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Serrucho</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. 7</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Vacila Triple</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Abrázala</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Dame Por Las Manos</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">13. Patín</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">14. Patineta</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">15. Paséense</a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">INTERMEDIO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Enchufa a Lo Cubano</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. 69</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. 71</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Dedo Guarapo y Bota</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Jessica</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. 70 Por Las Manos</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Abanico y Bota</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Sombrero Doble</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. 7 Coca Cola</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10.  El Beso</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. 73</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Cepillao</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">13. Chinita</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">14. Tócale La T</a>
                                              </li>
                                            </div>


                                            <div class="eos-group-title">INTERMEDIO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Brazalete</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Sonia</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Trenza</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Sombréala</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Matanzas</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Ciclón</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Baracoa</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. 75</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Sombrero Enganchado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Palafitos</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. La De Antonio</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Atrevido</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">13. Coca Cola Por Detrás</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">14. Balsero</a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>


                                    <!-- NIVELACION 3 -->
                                    
                                    <div class="col-sm-3">
                                        <div class="eos-menu" id="nivelacion_3">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a href="#">NIVELACIÓN 3</a>
                                            </li>
                                            <div class="eos-group-title">AVANZADO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. 7 Moderno</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Camagüey</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Sombrero de Magni</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Juana La Cuabana</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Morón</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Sombrero Por Debajo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. La Jugada</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. El Puente</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Cuchillo Y Córtala</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Candado Complicado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. El 12</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Tornado</a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">AVANZADO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. La Jenny</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. 7 70</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. 77</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Terremoto</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Huracán</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Sombrero De Diana</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. 7 Loco</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Azuquita</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Ascensor</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Sombrero De Regnier</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Ponle Sabor</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Rumbita</a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">AVANZADO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Paséala Y Complícate</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Jimawa</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Rubenada</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. 84 Complicado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Oro Negro</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Tormenta</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Consorte</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. El Bebé</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. 75 Con Gancho</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Tunturuntún</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. La Cuñada</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Copelia</a>
                                              </li>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- NIVELACION 4 -->
                                    
                                    <div class="col-sm-3">
                                        <div class="eos-menu" id="nivelacion_4">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a href="#">NIVELACIÓN 4</a>
                                            </li>
                                            <div class="eos-group-title">MASTER 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Ola Brava</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Niágara</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Primo Hermano</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. 75 Derecho/Revés</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. Venezolano</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. 70 Nuevo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. La Tuya</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Dedo Saboreado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. La Cuadra</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Abanico Complicado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Copelia Complicado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Bacardí Complicado</a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">MASTER 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Tenampa</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Sabrosura</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Sombrero De Cusco</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. 7 loco Complicado</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. 70 y Pescao</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Tijeras</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. 70 y Pico</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. 90</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Rumbera</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. La Espuma</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Carnaval</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Uno Complicado</a>
                                              </li>
                                            </div>

                                            <div class="eos-group-title">MASTER 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">01. Rubenada Complicada</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">02. Alrededor Del Mundo</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">03. Chocolate</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">04. Bacardí Con Limón</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">05. La Vieja</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">06. Xioma</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">07. Mata 7</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">08. Angie</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">09. Gigante</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">10. Hormiguero</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">11. Nonna</a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) ? 'disabled' : 'video_url' }}" href="203096537">12. Energía Latina</a>
                                              </li>
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

        
      });
    



    var vi_player = new Vimeo.Player('video_vimeo');

    $(".video_url").click(function(e) {

      e.preventDefault();

      video_id = $(this).attr('href');
      titulo = $(this).text()

      vi_player.loadVideo(video_id).then(function(id) {

      }).catch(function(error) {
          console.log('vi error', error.name);
      });

      $('#nombre_modal').text(titulo)

      $('#modalVideo').modal('show');
    });

    $(".disabled").click(function(e) {

      e.preventDefault();

    });

    $('#modalVideo').on('hidden.bs.modal', function () {

      vi_player.pause()

    });

    $(".mostrar").click(function(e) {

      $('.eos-menu-content').css('height','1880px')
      $('.eos-group-content').css('height','520px')

    });

    $(".ocultar").click(function(e) {

      $('.eos-menu-content').css('height','160px')
      $('.eos-group-content').css('height','0px')

    });



        
     </script>

@stop