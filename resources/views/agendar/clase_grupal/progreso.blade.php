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


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <?php $url = "/agendar/clases-grupales" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-niveles f-25" id="id-clase_grupal_id"></i> Nivelaciones </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_clase_grupal" id="agregar_clase_grupal"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="id" value="{{ $id }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                              <div class="col-sm-12">
                                 
                                    

                              <div class="clearfix p-b-35"></div>
      

                               <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Basico</label>
                                    <div class="panel-group p-l-10" data-collapse-color="blue" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseBasico" aria-expanded="false" aria-controls="collapseBasico">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseBasico" class="collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>


                                    <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Basico 1</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingBasico1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseBasico1" aria-expanded="false" aria-controls="collapseBasico1">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseBasico1" class="collapse" role="tabpanel" aria-labelledby="headingBasico1">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b1c1-switch" type="checkbox" hidden="hidden">
                                          <label for="b1c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b1c1" name="b1c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b1c2-switch" type="checkbox" hidden="hidden">
                                          <label for="b1c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b1c2" name="b1c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b1c3-switch" type="checkbox" hidden="hidden">
                                          <label for="b1c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b1c3" name="b1c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b1c4-switch" type="checkbox" hidden="hidden">
                                          <label for="b1c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b1c4" name="b1c4" value="" hidden="hidden">

                                      </div>
           
                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseBasico1')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Basico 2</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseBasico2" aria-expanded="false" aria-controls="collapseBasico2">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseBasico2" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b2c1-switch" type="checkbox" hidden="hidden">
                                          <label for="b2c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b2c1" name="b2c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b2c2-switch" type="checkbox" hidden="hidden">
                                          <label for="b2c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b2c2" name="b2c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b2c3-switch" type="checkbox" hidden="hidden">
                                          <label for="b2c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b2c3" name="b2c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b2c4-switch" type="checkbox" hidden="hidden">
                                          <label for="b2c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b2c4" name="b2c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseBasico2')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Basico 3</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseBasico3" aria-expanded="false" aria-controls="collapseBasico3">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseBasico3" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b3c1-switch" type="checkbox" hidden="hidden">
                                          <label for="b3c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b3c1" name="b3c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b3c2-switch" type="checkbox" hidden="hidden">
                                          <label for="b3c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b3c2" name="b3c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b3c3-switch" type="checkbox" hidden="hidden">
                                          <label for="b3c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b3c3" name="b3c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="b3c4-switch" type="checkbox" hidden="hidden">
                                          <label for="b3c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="b3c4" name="b3c4" value="" hidden="hidden">

                                      </div>


                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseBasico3')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>
                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseBasico')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>
                    


                                 

                            <div class="clearfix p-b-35"></div>

                          <!--   INTERMEDIO -->

                                  <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Intermedio</label>
                                    <div class="panel-group p-l-10" data-collapse-color="blue" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseIntermedio" aria-expanded="false" aria-controls="collapseIntermedio">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseIntermedio" class="collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>


                                    <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Intermedio 1</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingBasico1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseIntermedio1" aria-expanded="false" aria-controls="collapseIntermedio1">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseIntermedio1" class="collapse" role="tabpanel" aria-labelledby="headingBasico1">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i1c1-switch" type="checkbox" hidden="hidden">
                                          <label for="i1c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i1c1" name="i1c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i1c2-switch" type="checkbox" hidden="hidden">
                                          <label for="i1c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i1c2" name="i1c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i1c3-switch" type="checkbox" hidden="hidden">
                                          <label for="i1c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i1c3" name="i1c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i1c4-switch" type="checkbox" hidden="hidden">
                                          <label for="i1c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i1c4" name="i1c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseIntermedio1')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Intermedio 2</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseIntermedio2" aria-expanded="false" aria-controls="collapseIntermedio2">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseIntermedio2" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i2c1-switch" type="checkbox" hidden="hidden">
                                          <label for="i2c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i2c1" name="i2c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i2c2-switch" type="checkbox" hidden="hidden">
                                          <label for="i2c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i2c2" name="i2c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i2c3-switch" type="checkbox" hidden="hidden">
                                          <label for="i2c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i2c3" name="i2c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i2c4-switch" type="checkbox" hidden="hidden">
                                          <label for="i2c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i2c4" name="i2c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseIntermedio2')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Intermedio 3</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseIntermedio3" aria-expanded="false" aria-controls="collapseIntermedio3">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseIntermedio3" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i3c1-switch" type="checkbox" hidden="hidden">
                                          <label for="i3c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i3c1" name="i3c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i3c2-switch" type="checkbox" hidden="hidden">
                                          <label for="i3c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i3c2" name="i3c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i3c3-switch" type="checkbox" hidden="hidden">
                                          <label for="i3c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i3c3" name="i3c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="i3c4-switch" type="checkbox" hidden="hidden">
                                          <label for="i3c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="i3c4" name="i3c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseIntermedio3')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>


                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseIntermedio')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>
                    


                                 

                            <div class="clearfix p-b-35"></div>

                            <!-- Avanzado -->
        

                              <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Avanzado</label>
                                    <div class="panel-group p-l-10" data-collapse-color="blue" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado" class="collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>


                                <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Avanzado 1</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingBasico1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado1" aria-expanded="false" aria-controls="collapseAvanzado1">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado1" class="collapse" role="tabpanel" aria-labelledby="headingBasico1">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a1c1-switch" type="checkbox" hidden="hidden">
                                          <label for="a1c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a1c1" name="a1c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a1c2-switch" type="checkbox" hidden="hidden">
                                          <label for="a1c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a1c2" name="a1c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a1c3-switch" type="checkbox" hidden="hidden">
                                          <label for="a1c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a1c3" name="a1c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a1c4-switch" type="checkbox" hidden="hidden">
                                          <label for="a1c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a1c4" name="a1c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseAvanzado1')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Avanzado 2</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado2" aria-expanded="false" aria-controls="collapseAvanzado2">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado2" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a2c1-switch" type="checkbox" hidden="hidden">
                                          <label for="a2c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a2c1" name="a2c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a2c2-switch" type="checkbox" hidden="hidden">
                                          <label for="a2c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a2c2" name="a2c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a2c3-switch" type="checkbox" hidden="hidden">
                                          <label for="a2c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a2c3" name="a2c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a2c4-switch" type="checkbox" hidden="hidden">
                                          <label for="a2c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a2c4" name="a2c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseAvanzado2')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Avanzado 3</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado3" aria-expanded="false" aria-controls="collapseAvanzado3">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado3" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a3c1-switch" type="checkbox" hidden="hidden">
                                          <label for="a3c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a3c1" name="a3c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a3c2-switch" type="checkbox" hidden="hidden">
                                          <label for="a3c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a3c2" name="a3c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a3c3-switch" type="checkbox" hidden="hidden">
                                          <label for="a3c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a3c3" name="a3c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="a3c4-switch" type="checkbox" hidden="hidden">
                                          <label for="a3c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="a3c4" name="a3c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseAvanzado3')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                        

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


                                <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Master</label>
                                    <div class="panel-group p-l-10" data-collapse-color="blue" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseMaster" aria-expanded="false" aria-controls="collapseMaster">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseMaster" class="collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                  
                                          <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Master 1</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingBasico1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseMaster1" aria-expanded="false" aria-controls="collapseMaster1">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseMaster1" class="collapse" role="tabpanel" aria-labelledby="headingBasico1">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m1c1-switch" type="checkbox" hidden="hidden">
                                          <label for="m1c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m1c1" name="m1c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m1c2-switch" type="checkbox" hidden="hidden">
                                          <label for="m1c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m1c2" name="m1c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m1c3-switch" type="checkbox" hidden="hidden">
                                          <label for="m1c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m1c3" name="m1c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m1c4-switch" type="checkbox" hidden="hidden">
                                          <label for="m1c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m1c4" name="m1c4" value="" hidden="hidden">

                                      </div>

                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseMaster1')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Master 2</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseMaster2" aria-expanded="false" aria-controls="collapseMaster2">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseMaster2" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m2c1-switch" type="checkbox" hidden="hidden">
                                          <label for="m2c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m2c1" name="m2c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m2c2-switch" type="checkbox" hidden="hidden">
                                          <label for="m2c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m2c2" name="m2c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m2c3-switch" type="checkbox" hidden="hidden">
                                          <label for="m2c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m2c3" name="m2c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m2c4-switch" type="checkbox" hidden="hidden">
                                          <label for="m2c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m2c4" name="m2c4" value="" hidden="hidden">

                                      </div>


                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseMaster2')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>

                           <div class="col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Master 3</label>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseMaster3" aria-expanded="false" aria-controls="collapseMaster3">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseMaster3" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 1</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m3c1-switch" type="checkbox" hidden="hidden">
                                          <label for="m3c1-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m3c1" name="m3c1" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 2</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m3c2-switch" type="checkbox" hidden="hidden">
                                          <label for="m3c2-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m3c2" name="m3c2" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 3</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m3c3-switch" type="checkbox" hidden="hidden">
                                          <label for="m3c3-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m3c3" name="m3c3" value="" hidden="hidden">

                                      </div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Clase 4</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i> <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="m3c4-switch" type="checkbox" hidden="hidden">
                                          <label for="m3c4-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>

                                      <input type="text" id="m3c4" name="m3c4" value="" hidden="hidden">

                                      </div>


                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseMaster3')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                           </div>


                           
                        

                                <div class="clearfix p-b-35"></div>
                                <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseMaster')" ></i></div>

                                <div class="clearfix p-b-35"></div>
                                          <hr></hr>


                                    </div>
                                </div>
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

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" id="guardar" href="#">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

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

    route_agregar="{{url('/')}}/agendar/clases-grupales/nivelaciones/agregar";
    route_principal="{{url('/')}}/agendar/clases-grupales/detalle/{{$id}}";


  $(document).ready(function(){

    if("{{$clase_1->clase_1}}" == 1){
      $("#b1c1").val('1');  //VALOR POR DEFECTO
      $("#b1c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_1->clase_2}}" == 1){
      $("#b1c2").val('1');  //VALOR POR DEFECTO
      $("#b1c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_1->clase_3}}" == 1){
      $("#b1c3").val('1');  //VALOR POR DEFECTO
      $("#b1c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_1->clase_4}}" == 1){
      $("#b1c4").val('1');  //VALOR POR DEFECTO
      $("#b1c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }



    if("{{$clase_2->clase_1}}" == 1){
      $("#b2c1").val('1');  //VALOR POR DEFECTO
      $("#b2c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_2->clase_2}}" == 1){
      $("#b2c2").val('1');  //VALOR POR DEFECTO
      $("#b2c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_2->clase_3}}" == 1){
      $("#b2c3").val('1');  //VALOR POR DEFECTO
      $("#b2c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_2->clase_4}}" == 1){
      $("#b2c4").val('1');  //VALOR POR DEFECTO
      $("#b2c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }


    if("{{$clase_3->clase_1}}" == 1){
      $("#b3c1").val('1');  //VALOR POR DEFECTO
      $("#b3c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_3->clase_2}}" == 1){
      $("#b3c2").val('1');  //VALOR POR DEFECTO
      $("#b3c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_3->clase_3}}" == 1){
      $("#b3c3").val('1');  //VALOR POR DEFECTO
      $("#b3c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_3->clase_4}}" == 1){
      $("#b3c4").val('1');  //VALOR POR DEFECTO
      $("#b3c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }



    if("{{$clase_4->clase_1}}" == 1){
      $("#i1c1").val('1');  //VALOR POR DEFECTO
      $("#i1c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_4->clase_2}}" == 1){
      $("#i1c2").val('1');  //VALOR POR DEFECTO
      $("#i1c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_4->clase_3}}" == 1){
      $("#i1c3").val('1');  //VALOR POR DEFECTO
      $("#i1c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_4->clase_4}}" == 1){
      $("#i1c4").val('1');  //VALOR POR DEFECTO
      $("#i1c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }


    if("{{$clase_5->clase_1}}" == 1){
      $("#i2c1").val('1');  //VALOR POR DEFECTO
      $("#i2c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_5->clase_2}}" == 1){
      $("#i2c2").val('1');  //VALOR POR DEFECTO
      $("#i2c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_5->clase_3}}" == 1){
      $("#i2c3").val('1');  //VALOR POR DEFECTO
      $("#i2c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_5->clase_4}}" == 1){
      $("#i2c4").val('1');  //VALOR POR DEFECTO
      $("#i2c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }


    if("{{$clase_6->clase_1}}" == 1){
      $("#i3c1").val('1');  //VALOR POR DEFECTO
      $("#i2c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_6->clase_2}}" == 1){
      $("#i3c2").val('1');  //VALOR POR DEFECTO
      $("#i2c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_6->clase_7}}" == 1){
      $("#i3c3").val('1');  //VALOR POR DEFECTO
      $("#i2c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_6->clase_4}}" == 1){
      $("#i3c4").val('1');  //VALOR POR DEFECTO
      $("#i3c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }



    if("{{$clase_7->clase_1}}" == 1){
      $("#a1c1").val('1');  //VALOR POR DEFECTO
      $("#a1c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_7->clase_2}}" == 1){
      $("#a1c2").val('1');  //VALOR POR DEFECTO
      $("#a1c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_7->clase_3}}" == 1){
      $("#a1c3").val('1');  //VALOR POR DEFECTO
      $("#a1c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_7->clase_4}}" == 1){
      $("#a1c4").val('1');  //VALOR POR DEFECTO
      $("#a1c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }


    if("{{$clase_8->clase_1}}" == 1){
      $("#a2c1").val('1');  //VALOR POR DEFECTO
      $("#a2c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_8->clase_2}}" == 1){
      $("#a2c2").val('1');  //VALOR POR DEFECTO
      $("#a2c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_8->clase_3}}" == 1){
      $("#a2c3").val('1');  //VALOR POR DEFECTO
      $("#a2c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_8->clase_4}}" == 1){
      $("#a2c4").val('1');  //VALOR POR DEFECTO
      $("#a2c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }


    if("{{$clase_9->clase_1}}" == 1){
      $("#a3c1").val('1');  //VALOR POR DEFECTO
      $("#a3c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_9->clase_2}}" == 1){
      $("#a3c2").val('1');  //VALOR POR DEFECTO
      $("#a3c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_9->clase_3}}" == 1){
      $("#a3c3").val('1');  //VALOR POR DEFECTO
      $("#a3c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_9->clase_4}}" == 1){
      $("#a3c4").val('1');  //VALOR POR DEFECTO
      $("#a3c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }



    if("{{$clase_10->clase_1}}" == 1){
      $("#m1c1").val('1');  //VALOR POR DEFECTO
      $("#m1c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_10->clase_2}}" == 1){
      $("#m1c2").val('1');  //VALOR POR DEFECTO
      $("#m1c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_10->clase_3}}" == 1){
      $("#m1c3").val('1');  //VALOR POR DEFECTO
      $("#m1c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_10->clase_4}}" == 1){
      $("#m1c4").val('1');  //VALOR POR DEFECTO
      $("#m1c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_11->clase_1}}" == 1){
      $("#m2c1").val('1');  //VALOR POR DEFECTO
      $("#m2c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_11->clase_2}}" == 1){
      $("#m2c2").val('1');  //VALOR POR DEFECTO
      $("#m2c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_11->clase_3}}" == 1){
      $("#m2c3").val('1');  //VALOR POR DEFECTO
      $("#m2c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_11->clase_4}}" == 1){
      $("#m2c4").val('1');  //VALOR POR DEFECTO
      $("#m2c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_12->clase_1}}" == 1){
      $("#m3c1").val('1');  //VALOR POR DEFECTO
      $("#m3c1-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_12->clase_2}}" == 1){
      $("#m3c2").val('1');  //VALOR POR DEFECTO
      $("#m3c2-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_12->clase_3}}" == 1){
      $("#m3c3").val('1');  //VALOR POR DEFECTO
      $("#m3c3-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    if("{{$clase_12->clase_4}}" == 1){
      $("#m3c4").val('1');  //VALOR POR DEFECTO
      $("#m3c4-switch").attr("checked", true); //VALOR POR DEFECTO
    }

    $("#b1c1-switch").on('change', function(){
      if ($("#b1c1-switch").is(":checked")){
        $("#b1c1").val('1');
      }else{
        $("#b1c1").val('0');
      }     
    });

    $("#b1c2-switch").on('change', function(){
      if ($("#b1c2-switch").is(":checked")){
        $("#b1c2").val('1');
      }else{
        $("#b1c2").val('0');
      }     
    });

    $("#b1c3-switch").on('change', function(){
      if ($("#b1c3-switch").is(":checked")){
        $("#b1c3").val('1');
      }else{
        $("#b1c3").val('0');
      }     
    });

    $("#b1c4-switch").on('change', function(){
      if ($("#b1c4-switch").is(":checked")){
        $("#b1c4").val('1');
      }else{
        $("#b1c4").val('0');
      }     
    });



    $("#b2c1-switch").on('change', function(){
      if ($("#b2c1-switch").is(":checked")){
        $("#b2c1").val('1');
      }else{
        $("#b2c1").val('0');
      }     
    });

    $("#b2c2-switch").on('change', function(){
      if ($("#b2c2-switch").is(":checked")){
        $("#b2c2").val('1');
      }else{
        $("#b2c2").val('0');
      }     
    });

    $("#b2c3-switch").on('change', function(){
      if ($("#b2c3-switch").is(":checked")){
        $("#b2c3").val('1');
      }else{
        $("#b2c3").val('0');
      }     
    });

    $("#b2c4-switch").on('change', function(){
      if ($("#b2c4-switch").is(":checked")){
        $("#b2c4").val('1');
      }else{
        $("#b2c4").val('0');
      }     
    });

    $("#b3c1-switch").on('change', function(){
      if ($("#b3c1-switch").is(":checked")){
        $("#b3c1").val('1');
      }else{
        $("#b3c1").val('0');
      }     
    });

    $("#b3c2-switch").on('change', function(){
      if ($("#b3c2-switch").is(":checked")){
        $("#b3c2").val('1');
      }else{
        $("#b3c2").val('0');
      }     
    });

    $("#b3c3-switch").on('change', function(){
      if ($("#b3c3-switch").is(":checked")){
        $("#b3c3").val('1');
      }else{
        $("#b3c3").val('0');
      }     
    });

    $("#b3c4-switch").on('change', function(){
      if ($("#b3c4-switch").is(":checked")){
        $("#b3c4").val('1');
      }else{
        $("#b3c4").val('0');
      }     
    });



     $("#i1c1-switch").on('change', function(){
      if ($("#i1c1-switch").is(":checked")){
        $("#i1c1").val('1');
      }else{
        $("#i1c1").val('0');
      }     
    });

     $("#i1c2-switch").on('change', function(){
      if ($("#i1c2-switch").is(":checked")){
        $("#i1c2").val('1');
      }else{
        $("#i1c2").val('0');
      }     
    });

     $("#i1c3-switch").on('change', function(){
      if ($("#i1c3-switch").is(":checked")){
        $("#i1c3").val('1');
      }else{
        $("#i1c3").val('0');
      }     
    });

     $("#i1c4-switch").on('change', function(){
      if ($("#i1c4-switch").is(":checked")){
        $("#i1c4").val('1');
      }else{
        $("#i1c4").val('0');
      }     
    });

    $("#i2c1-switch").on('change', function(){
      if ($("#i2c1-switch").is(":checked")){
        $("#i2c1").val('1');
      }else{
        $("#i2c1").val('0');
      }     
    });

    $("#i2c2-switch").on('change', function(){
      if ($("#i2c2-switch").is(":checked")){
        $("#i2c2").val('1');
      }else{
        $("#i2c2").val('0');
      }     
    });

    $("#i2c3-switch").on('change', function(){
      if ($("#i2c3-switch").is(":checked")){
        $("#i2c3").val('1');
      }else{
        $("#i2c3").val('0');
      }     
    });

    $("#i2c4-switch").on('change', function(){
      if ($("#i2c4-switch").is(":checked")){
        $("#i2c4").val('1');
      }else{
        $("#i2c4").val('0');
      }     
    });

    $("#i3c1-switch").on('change', function(){
      if ($("#i3c1-switch").is(":checked")){
        $("#i3c1").val('1');
      }else{
        $("#i3c1").val('0');
      }     
    });

    $("#i3c2-switch").on('change', function(){
      if ($("#i3c2-switch").is(":checked")){
        $("#i3c2").val('1');
      }else{
        $("#i3c2").val('0');
      }     
    });

    $("#i3c3-switch").on('change', function(){
      if ($("#i3c3-switch").is(":checked")){
        $("#i3c3").val('1');
      }else{
        $("#i3c3").val('0');
      }     
    });

    $("#i3c4-switch").on('change', function(){
      if ($("#i3c4-switch").is(":checked")){
        $("#i3c4").val('1');
      }else{
        $("#i3c4").val('0');
      }     
    });




    $("#a1c1-switch").on('change', function(){
      if ($("#a1c1-switch").is(":checked")){
        $("#a1c1").val('1');
      }else{
        $("#a1c1").val('0');
      }     
    });

    $("#a1c2-switch").on('change', function(){
      if ($("#a1c2-switch").is(":checked")){
        $("#a1c2").val('1');
      }else{
        $("#a1c2").val('0');
      }     
    });

    $("#a1c3-switch").on('change', function(){
      if ($("#a1c3-switch").is(":checked")){
        $("#a1c3").val('1');
      }else{
        $("#a1c3").val('0');
      }     
    });

    $("#a1c4-switch").on('change', function(){
      if ($("#a1c4-switch").is(":checked")){
        $("#a1c4").val('1');
      }else{
        $("#a1c4").val('0');
      }     
    });

    $("#a2c1-switch").on('change', function(){
      if ($("#a2c1-switch").is(":checked")){
        $("#a2c1").val('1');
      }else{
        $("#a2c1").val('0');
      }     
    });

    $("#a2c2-switch").on('change', function(){
      if ($("#a2c2-switch").is(":checked")){
        $("#a2c2").val('1');
      }else{
        $("#a2c2").val('0');
      }     
    });

    $("#a2c3-switch").on('change', function(){
      if ($("#a2c3-switch").is(":checked")){
        $("#a2c3").val('1');
      }else{
        $("#a2c3").val('0');
      }     
    });

    $("#a2c4-switch").on('change', function(){
      if ($("#a2c4-switch").is(":checked")){
        $("#a2c4").val('1');
      }else{
        $("#a2c4").val('0');
      }     
    });



    $("#a3c1-switch").on('change', function(){
      if ($("#a3c1-switch").is(":checked")){
        $("#a3c1").val('1');
      }else{
        $("#a3c1").val('0');
      }     
    });

    $("#a3c2-switch").on('change', function(){
      if ($("#a3c2-switch").is(":checked")){
        $("#a3c2").val('1');
      }else{
        $("#a3c2").val('0');
      }     
    });

    $("#a3c3-switch").on('change', function(){
      if ($("#a3c3-switch").is(":checked")){
        $("#a3c3").val('1');
      }else{
        $("#a3c3").val('0');
      }     
    });

    $("#a3c4-switch").on('change', function(){
      if ($("#a3c4-switch").is(":checked")){
        $("#a3c4").val('1');
      }else{
        $("#a3c4").val('0');
      }     
    });



    $("#m1c1-switch").on('change', function(){
      if ($("#m1c1-switch").is(":checked")){
        $("#m1c1").val('1');
      }else{
        $("#m1c1").val('0');
      }     
    });

    $("#m1c2-switch").on('change', function(){
      if ($("#m1c2-switch").is(":checked")){
        $("#m1c2").val('1');
      }else{
        $("#m1c2").val('0');
      }     
    });

    $("#m1c3-switch").on('change', function(){
      if ($("#m1c3-switch").is(":checked")){
        $("#m1c3").val('1');
      }else{
        $("#m1c3").val('0');
      }     
    });

    $("#m1c4-switch").on('change', function(){
      if ($("#m1c4-switch").is(":checked")){
        $("#m1c4").val('1');
      }else{
        $("#m1c4").val('0');
      }     
    });

    $("#m2c1-switch").on('change', function(){
      if ($("#m2c1-switch").is(":checked")){
        $("#m2c1").val('1');
      }else{
        $("#m2c1").val('0');
      }     
    });

    $("#m2c2-switch").on('change', function(){
      if ($("#m2c2-switch").is(":checked")){
        $("#m2c2").val('1');
      }else{
        $("#m2c2").val('0');
      }     
    });

    $("#m2c3-switch").on('change', function(){
      if ($("#m2c3-switch").is(":checked")){
        $("#m2c3").val('1');
      }else{
        $("#m2c3").val('0');
      }     
    });

    $("#m2c4-switch").on('change', function(){
      if ($("#m2c4-switch").is(":checked")){
        $("#m2c4").val('1');
      }else{
        $("#m2c4").val('0');
      }     
    });

    $("#m3c1-switch").on('change', function(){
      if ($("#m3c1-switch").is(":checked")){
        $("#m3c1").val('1');
      }else{
        $("#m3c1").val('0');
      }     
    });

    $("#m3c2-switch").on('change', function(){
      if ($("#m3c2-switch").is(":checked")){
        $("#m3c2").val('1');
      }else{
        $("#m3c2").val('0');
      }     
    });

    $("#m3c3-switch").on('change', function(){
      if ($("#m3c3-switch").is(":checked")){
        $("#m3c3").val('1');
      }else{
        $("#m3c3").val('0');
      }     
    });

    $("#m3c4-switch").on('change', function(){
      if ($("#m3c4-switch").is(":checked")){
        $("#m3c4").val('1');
      }else{
        $("#m3c4").val('0');
      }     
    });


  });

  $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_clase_grupal" ).serialize(); 
                procesando();      
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

                          window.location = route_principal
                          
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
            });

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

     

</script> 
@stop

