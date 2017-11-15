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
    <div class="block-header">
        @if(Auth::check())
            <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                
                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                
                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                
                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                               
                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
            </ul>
        @endif
    </div> 

    <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><i class="zmdi zmdi-check zmdi-hc-5x c-morado"></i></div>
              <form>
                <div class="c-morado f-50 text-center"> Validar </div>
                <div class="text-center f-18">Te invitamos a ingresar el código de validación del certificado deseas validar.</div>
                <div class="clearfix"></div><br><br>
                <div class="text-center f-30 c-morado">Ingresa el Código y valida</div>
                <div class="clearfix m-20 m-b-25"></div>
                <div class="block-header text-center">
                  <input type="text" class="form-control caja" name="codigo" id="codigo"></input>
                  <div class="has-error" id="error-codigo">
                    <span >
                        <small class="help-block error-span" id="error-codigo_mensaje" ></small>                                
                    </span>
                  </div>
                  <div class="clearfix m-20 m-b-25"></div>
                  <a class="btn-blanco m-r-10 f-20 guardar pointer" > Validar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
                </div> 
              </form>
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

        route_validar="{{url('/')}}/validar-certificado/";
        route_certificado="{{url('/')}}/certificado/";

        $(document).ready(function(){
            $('#codigo').val('')
        });
        
        $(".guardar").click(function(){

            $('#error-codigo_mensaje').html('')
            codigo = $('#codigo').val()

            if(codigo.trim() != ''){
                
                var route = route_validar + codigo;
                var token = "{{ csrf_token() }}";
                var codigo = $("#codigo").val();
                procesando();
           
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                    success:function(respuesta){
                        setTimeout(function(){ 

                            window.location = route_certificado + codigo;
                        
                        }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 

                        finprocesado()

                        swal(
                            'Solicitud no procesada',
                            'El código de validación es invalido, verifique por favor',
                            'error'
                        );

                      }, 1000);
                    }
                });
            }else{
                $('#error-codigo_mensaje').html('Ups! El codigo es requerido')
            }
        });


	</script>
@stop