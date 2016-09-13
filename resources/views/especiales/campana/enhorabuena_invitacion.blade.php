@extends('layout.master3')

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
                <div class="container">
                    
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                            <div class="col-md-10">


                            
                            <div class="text-center"><i class="zmdi zmdi-mood zmdi-hc-5x text-center c-amarillo"></i></div>
                            


                            <div class="clearfix p-b-35"></div>
                            
                            <div class="f-700 f-30 text-center">¡Felicidades!  Haz acumulado puntos</div>
                            
                            <br>

                            <div class="opaco-0-8 f-22 text-center">Tu invitación ha sido enviada correctamente  </div>

                            <div class="clearfix p-b-35"></div>

                            <hr class="c-morado">

                            <div class="clearfix p-b-35"></div>

                            <div class="opaco-0-8 f-20 text-center">Mientras  más directores se agregas a la plataforma, más crece tu ranking en Easy Dance
                            </div>

                            <div class="opaco-0-8 f-20 text-center">Continúa así
                            </div>
                                    


                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="block-header text-center">
                                        <a class="btn-blanco m-r-10 f-20 pointer" href="{{url('/')}}/especiales/campañas/invitar/{{$id}}" > INVITAR A OTRA PERSONA</a>
                                    </div> 
              
                            </div>
                          <div class="col-md-1"></div>           
                        </div>

                          <div class="clearfix p-b-35"></div>
                          <div class="clearfix p-b-35"></div>
                          <div class="clearfix p-b-35"></div>

                        
                    </div>
                    
                    
                </div>
            </section>

@stop