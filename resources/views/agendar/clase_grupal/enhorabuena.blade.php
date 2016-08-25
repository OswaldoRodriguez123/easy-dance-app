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
    
    <!-- <div class="container">
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>

            <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x c-morado"></i></div>
            <div class="c-morado f-50 text-center"> Muy Bien Hecho! </div>
            <div class="text-center f-25">Has ingresado al alumno de manera exitosa</div>
            <div class="clearfix"></div><br>
            <div class="text-center f-22">¿Deseas gestionar su pago?</div>
            <div class="clearfix"></div>
            <br>

        </div>
        <div class="card-padding card-body">

            <div class="btn-demo">
              <div class="block-header text-center">
                <a class="btn-blanco m-r-10 f-20" href="{{url('/')}}/participante/alumno/deuda/{{$id}}" > Llevame <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
                <a class="btn-morado m-r-10 f-20" href="{{url('/')}}/"> Ir a menú</a>
              </div> 
            </div>
          
        </div>
      <div class="clearfix m-20 m-b-25"></div>
      <div class="clearfix m-20 m-b-25"></div>
      </div>

    </div> -->

    <div class="container">

    <?php $url = "/" ?>

        <div class="card">
        <div class="card-header">
              <div class="clearfix"></div><br>

            <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x c-morado"></i></div>
            <div class="c-morado f-50 text-center"> Muy Bien Hecho! </div>
            <div class="text-center f-25">Has ingresado al alumno de manera exitosa</div>
            
            <div class="clearfix"></div>
            <br>

            <div class="f-30 text-center">
              Ahora cuéntanos ¿que deseas hacer?
            </div>
        </div>
        <div class="card-body">
            <div class="clearfix"></div>

            <div class="text-center guia">
              <hr>
              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a href="{{url('/')}}/participante/alumno/deuda/{{$id}}" >Gestionar su pago <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                <i class="icon_a-pagar f-50 padding"></i> </a>
                </p> 

              <div class="clearfix"></div><br>
              <hr>

              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" >Agregar otro participante <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>   <i class="zmdi zmdi-account-add f-50 padding-talleres"></i> </a></p>
              <div class="clearfix"></div><br>
              <hr>

              <div class="clearfix"></div><br>
              <p class="m-t-5 m-b-5 f-22"><a  href="{{url('/')}}/">Ir al menu <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i> <i class="zmdi f-50 zmdi-format-align-justify zmdi-hc-fw"></i> </a></p> 
              <div class="clearfix p-b-15"></div>
              <div class="clearfix p-b-15"></div>
              <div class="clearfix p-b-15"></div>
       

            </div>
        </div>
      </div>
    </div>


@stop