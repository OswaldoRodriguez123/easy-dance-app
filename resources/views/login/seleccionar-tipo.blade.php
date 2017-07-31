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

  <div class="container">

    <div class="card">
      <div class="card-header">
          <div class="clearfix"></div><br>

          <div align="center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 130px; max-width: 130px;" class="img-responsive opaco-0-8" alt=""></div>
          <div class="c-morado f-50 text-center"> Saludos! </div>
          <div class="text-center f-25">Hemos detectado que posees multi cuenta</div>
          
          <div class="clearfix"></div>
          <br>

          <div class="f-30 text-center">
            Ahora cuéntanos ¿Con que cuenta deseas acceder?
          </div>
      </div>
      <div class="card-body">
          <div class="clearfix"></div>

          <div class="text-center guia">

            @foreach($tipos as $tipo)

              @if($tipo->tipo == 1 OR $tipo->tipo == 5)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="1" href="#" >Entrar como Administrador <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @elseif($tipo->tipo == 2)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="2" href="#" >Entrar como Alumno <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @elseif($tipo->tipo == 3)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="3" href="#" >Entrar como Instructor <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @elseif($tipo->tipo == 4)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="4" href="#" >Entrar como Representante <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @elseif($tipo->tipo == 6)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="6" href="#" >Entrar como Recepcionista <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @elseif($tipo->tipo == 8)
                <hr>
                <div class="clearfix"></div><br>
                <p class="m-t-5 m-b-5 f-22"><a class="usuario_tipo" id="6" href="#" >Entrar como Staff <i class="zmdi zmdi-arrow-right zmdi-hc-fw"></i>  
                  <i class="zmdi zmdi-thumb-up f-50 padding"></i> </a>
                </p>
              @endif
            @endforeach 

            <div class="clearfix p-b-15"></div>
            <div class="clearfix p-b-15"></div>
            <div class="clearfix p-b-15"></div>
     

          </div>
      </div>
    </div>
  </div>


@stop

@section('js') 
            
  <script type="text/javascript">

    route_seleccionar="{{url('/')}}/seleccionar-tipo/";
    route_principal="{{url('/')}}/inicio";

    $('.usuario_tipo').on( 'click', function () {
      var id = $(this).attr('id');
      
      var route = route_seleccionar + id;
      var token = "{{ csrf_token() }}"
      procesando();
            
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        success:function(respuesta){
          window.location=route_principal; 
        },
        error:function(msj){
          swal('Solicitud no procesada','Error','error');
        }
      });
    });

  </script>

@stop