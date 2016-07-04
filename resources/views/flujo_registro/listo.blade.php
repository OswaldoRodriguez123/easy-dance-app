@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('css')

<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">

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
              <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x text-success"></i></div>
              <div class="c-morado f-40 text-center"> ¡Felicitaciones ya empieza  tu nuevo rumbo al éxito! </div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="text-center f-20">Te recomendamos antes de iniciar que revises la sección  de <a href="{{url('/')}}/configuracion"> configuración general </a></div>
              <div class="text-center f-20">desde allí podrás personalizar  tu academia  y así  tendrás  una excelente  comprensión de Easy Dance</div>

              <div class="clearfix m-20 m-b-25"></div>
              <div class="clearfix m-20 m-b-25"></div>
              
              <div align="center">
              <button type="submit" class="butp button5" onclick="configuracion()">Llévame a configuración general</button>
              <button type="submit" class="but2 button55" onclick="atras()"><span>Más Tarde</span></button><br><br><br>
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
      
      function configuracion(){
      procesando();
      window.location = "{{url('/')}}/configuracion";
      }
     
     function atras(){
      procesando();
      window.location = "{{url('/')}}/inicio";
     }
            

		</script>
@stop