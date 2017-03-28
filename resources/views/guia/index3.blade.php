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
    
    <div class="container">
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>

            <div align="center"><i class="zmdi zmdi-check-circle zmdi-hc-5x c-morado"></i></div>
            <div class="c-morado f-50 text-center"> Listo! </div>
            <div class="text-center f-25">Su pago se ha gestionado efectivamente</div>
            <div class="clearfix"></div><br>
            <div class="text-center f-22">Ahora  dinos a  donde quieres ir</div>
            <div class="clearfix"></div>
            <br>

        </div>


        <div class="card-body">
            <div class="clearfix"></div>

            <div class="text-center guia">
              <hr>
              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-15 f-22"><a href="{{ url('agendar/cursos') }}" >Ir a Menú <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                <i class="zmdi zmdi-view-headline f-50 padding-go-menu"></i> </a>
                </p> 

              <div class="clearfix"></div><br>
              <hr>

              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a  >Quedarme en punto de venta <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>   <i class="icon_a-punto-de-venta f-50 padding-punto"></i> </a></p>
              <div class="clearfix"></div><br>
              <hr>


            </div>


        </div>
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-25"></div>

      </div>


    </div>


@stop