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
  <!-- ENHORABUENA -->

  
    
    <div class="container" style="background-color: #fff; margin:0; height: 100%; width: 100%">
    <!--   <div class="card"> -->
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x text-success"></i></div>
              <div class="c-morado f-40 text-center"> Listo, lo has logrado </div>
              <div class="text-center f-22">Confirma tu correo electrónico </div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="text-center f-18">Hola <b>{{$nombre}}</b>, Nuestro equipo de trabajo estará confirmando en las próximas horas tu contribución, después de ser confirmada, podrás ver tu contribución en la plataforma <a href ="{{url('/')}}/especiales/campañas/progreso/{{$id}}" >Easy Dance</a>, agradecemos dirigirte a tu correo electrónico y confirma tu solicitud.</div>

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
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-10"></div>
      </div>
      
      <!--<div class="clearfix"></div>-->

    <!-- </div> -->


@stop