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
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="clearfix m-20 m-b-25"></div>
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><i class="zmdi zmdi-mood zmdi-hc-5x c-morado"></i></div>
              <div class="c-morado f-40 text-center"> ¡Felicitaciones!  </div>
              <div class="text-center f-22">Has cambiado tu contraseña exitosamente.</div>
              <div class="clearfix m-20 m-b-25"></div>
              
              <div class="text-center guia">
              
              <hr>
              <div class="clearfix"></div><br>

              <div class="col-md-12 f-22 c-morado"><!-- <a href="{{ url('agendar/clases-grupales') }}" >Continuar en Easy Dance <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i><img src="{{url('/')}}/assets/img/icono_easydance1 - copia.png" style="max-height: 30px; max-width: 30px;" class="img-responsive opaco-0-8" alt=""></a> -->
              <button type="submit" class="btn-blanco m-r-10 f-20" onclick="continuar()"> Continuar en Easy Dance </button>

              </div> 

              <div class="clearfix"></div><br>
              <hr>

              </div>

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


@section('js') 
            
		<script type="text/javascript">
    

    function continuar(){
      window.location = "{{url('/')}}/inicio";
     }


		</script>
@stop