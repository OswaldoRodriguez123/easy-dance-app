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
      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
      <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
      </div> 
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><i class="zmdi zmdi-check zmdi-hc-5x c-morado"></i></div>
              <div class="c-morado f-50 text-center"> Validar </div>
              <div class="text-center f-18">Te invitamos a ingresar el código que deseas  validar, como por ejemplo, el de alguna  reservación, tarjeta de regalo, campaña, promoción o examen, de esta forma confirmarás cualquier operación que desees realizar.  </div>
              <div class="clearfix"></div><br><br>
              <div class="text-center f-30 c-morado">Ingresa el Serial y valida</div>
              <div class="clearfix m-20 m-b-25"></div>
              <div class="block-header text-center">
                <input type="text" class="form-control caja" name="codigo" id="codigo"></input>
                <div class="clearfix m-20 m-b-25"></div>
                <a class="btn-blanco m-r-10 f-20 guardar pointer" > Validar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
              </div> 
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
            route_validar="{{url('/')}}/validar";
            route_exitoso="{{url('/')}}/validar/exitoso";
            route_invalido="{{url('/')}}/validar/invalido";
            
            $(".guardar").click(function(){
                
                var route = route_validar;
                var token = "{{ csrf_token() }}";

                var codigo = $("#codigo").val();
                procesando();
           
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:"&codigo_reservacion="+codigo,
                    success:function(respuesta){
                      setTimeout(function(){ 

                        window.location = route_exitoso;

                     
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        
                        window.location = route_invalido;

                      }, 1000);
                    }
                });
            });


		</script>
@stop