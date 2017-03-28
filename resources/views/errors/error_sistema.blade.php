@extends('layout.master')

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
  <!-- ENHORABUENA -->

  <?php $url = "/" ?>

    <div class="container">
      <div class="card">
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><img src="{{url('/')}}/assets/img/error.png" style="line-height: 150px; width: 600px; height:200px; "></i></div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="c-morado f-30 text-center"> UPSS, ALGO ANDA MAL HA OCURRIDO UN ERROR </div>
              <div class="text-center f-22">Para continuar, recarga la página o direcciona a otra página del sistema  </div>
              <br>
              <div class="text-center f-18"> <a href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" class="f-25">Refrescar <i class="zmdi zmdi-refresh-alt zmdi-hc-fw"></i></a></div>
              <br>
              <div class="text-center f-18">Para notificar el incidente comunícate a través de <a href="mailto:soporte@easydance.com" target="_blank">soporte@easydance.com</a>.</div>

              <div class="clearfix m-20 m-b-25"></div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="clearfix m-20 m-b-25"></div>

            </div>
            <div class="col-md-2"></div>
            
        </div>
        <div class="card-body">
         <div class="clearfix"></div>  
        </div>
      <div class="clearfix m-20 m-b-25"></div>
      </div>
      
      <!--<div class="clearfix"></div>-->

    </div>


@stop