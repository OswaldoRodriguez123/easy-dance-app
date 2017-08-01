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
        <div class="block-header">
        <a class="btn-blanco m-r-10 f-16" href="{{$_SERVER['HTTP_REFERER']}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Alumno</a>
                        
        </div>

        <div class="card">
        <div class="card-header">
              <div class="clearfix"></div><br>

            <div align="center"><i class="zmdi zmdi-trending-up  zmdi-hc-5x c-morado"></i></div>
            <div class="c-morado f-50 text-center"> ¿Deseas transferirlo? </div>
            
            <div class="clearfix"></div>
            <br>

            <div class="f-30 text-center">
              Ahora cuéntanos ¿a dónde deseas direccionarlo?
            </div>
        </div>
        <div class="card-body">
            <div class="clearfix"></div>

            <div class="text-center guia">
              <hr>
              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a href="{{ url('agendar/clases-grupales') }}" >Transferir al  participante a una clase grupal <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                <i class="icon_a-clases-grupales f-50 padding"></i> </a>
                </p> 

              <div class="clearfix"></div><br>
              <hr>

              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a href="{{ url('agendar/talleres') }}" >Transferir al  participante  a un Taller <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>   <i class="icon_a-talleres f-50 padding-talleres"></i> </a></p>
              <div class="clearfix"></div><br>
              <hr>

              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a  href="{{ url('agendar/clases-personalizadas') }}">Transferir al  participante a una Clase Personalizada <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i> <i class="icon_a-clase-personalizada f-50 padding-promocion"></i> </a></p> 
              <div class="clearfix p-b-15"></div>
              <div class="clearfix p-b-15"></div>
              <div class="clearfix p-b-15"></div>
       

            </div>
        </div>
      </div>
    </div>


@stop