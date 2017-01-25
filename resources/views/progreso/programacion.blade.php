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
@stop
@section('content')

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
                                <a href="#" class="f-16 text-success f-700">MOSTRAR TODAS LAS NIVELACIONES</a>
                                <div class="clearfix"></div>
                                <a href="#" class="f-16 text-success f-700">Ocultar todas las nivelaciones</a>

                                                    
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
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">BASICO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 3-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 3-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">BASICO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
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
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">INTERMEDIO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 3-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 3-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">INTERMEDIO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
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
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">AVANZADO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 3-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 3-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">AVANZADO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
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
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">MASTER 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 3-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 3-2</a>
                                              </li>
                                            </div>
                                            <div class="eos-group-title">MASTER 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a href="#">Menu 2-1</a>
                                              </li>
                                              <li class="eos-item">
                                                <a href="#">Menu 2-2</a>
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

        $("#nivelacion_1").eosMenu({
          fontSize : '14px',
          color : '#eee',
          hoverColor: '#eee',
          background: '#2F4050',
          subBackground: '#263442',
          hoverBackground: '#293744',
          height: '40px',
          lineHeight: '40px',
          borderColor: '#293744',
          hoverborderColor: '#293744',
          isAutoUrl: 1,
          defaultUrl: '#html',
          zIndex: 10,
          onItemClick: null,
          onMenuTitleClick: null,
          onGroupTitleClick: null,
        });

        $("#nivelacion_2").eosMenu({
          fontSize : '14px',
          color : '#eee',
          hoverColor: '#eee',
          background: '#2F4050',
          subBackground: '#263442',
          hoverBackground: '#293744',
          height: '40px',
          lineHeight: '40px',
          borderColor: '#293744',
          hoverborderColor: '#293744',
          isAutoUrl: 1,
          defaultUrl: '#html',
          zIndex: 10,
          onItemClick: null,
          onMenuTitleClick: null,
          onGroupTitleClick: null,
        });

        $("#nivelacion_3").eosMenu({
          fontSize : '14px',
          color : '#eee',
          hoverColor: '#eee',
          background: '#2F4050',
          subBackground: '#263442',
          hoverBackground: '#293744',
          height: '40px',
          lineHeight: '40px',
          borderColor: '#293744',
          hoverborderColor: '#293744',
          isAutoUrl: 1,
          defaultUrl: '#html',
          zIndex: 10,
          onItemClick: null,
          onMenuTitleClick: null,
          onGroupTitleClick: null,
        });

        $("#nivelacion_4").eosMenu({
          fontSize : '14px',
          color : '#eee',
          hoverColor: '#eee',
          background: '#2F4050',
          subBackground: '#263442',
          hoverBackground: '#293744',
          height: '40px',
          lineHeight: '40px',
          borderColor: '#293744',
          hoverborderColor: '#293744',
          isAutoUrl: 1,
          defaultUrl: '#html',
          zIndex: 10,
          onItemClick: null,
          onMenuTitleClick: null,
          onGroupTitleClick: null,
        });
    

     </script>

@stop