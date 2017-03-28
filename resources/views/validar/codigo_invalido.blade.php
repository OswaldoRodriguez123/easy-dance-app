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

            <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x text-danger"></i></div>
            <div class="f-30 text-center text-danger"> UPSS, lo sentimos  El cogido ingresado es inválido </div>
            <div class="text-center f-22 text-danger">Posiblemente has ingresado el dígito de manera incorrecta o el  código ha expirado </div>
            <div class="clearfix"></div><br><br>

            <div class="block-header text-center">
                <!--<input type="text" class="caja"></input>-->
                <a class="btn-blanco m-r-10 f-20" href="{{url('/')}}/validar" > Inténtalo de nuevo <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
                <a class="btn-morado m-r-10 f-20" href="{{url('/')}}/"> Volver a Menú</a>

              </div> 


        </div>
        <div class="form-control card-body">

              

              <div class="clearfix m-20 m-b-25"></div>

          
        </div>

      </div>
      
      <div class="clearfix"></div><br><br>
      <br><br>
      <br><br>

    </div>



@stop