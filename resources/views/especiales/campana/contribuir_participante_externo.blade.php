@extends('layout.master3')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
@stop


@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<!--MERCADO PAGO MODAL -->
<script type="text/javascript" src="http://resources.mlstatic.com/mptools/render.js"></script>
@stop

@section('content')
  <!-- PAGO RECOMPENSA MERCADOPAGO -->
    
  <div class="container" style="background-color: #fff; margin:0; width: 100%">
        <div class="block-header" style="padding-top: 5%">
            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas/contribuir/campaña/{{$usuario_ext['campana_id']}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i>Volver</a>
        </div> 

        <!-- <div class="card"> -->
            <div class="card-header text-center">
                <span class="f-30 c-morado"><i class="icon_a-campana f-25"></i> Verificación de datos</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2 text-center"><i class="icon_a-acuerdo-de-pago f-75"></i></div>
                    <div class="col-sm-5"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="text-center">
                        <span class="f-25 c-morado text-center">Gracias por su Colaboración para la Campaña "{{ $usuario_ext['campana_nombre'] }}"</span>
                        <div class="clearfix p-b-15"></div>
                    </div>
                </div><!-- END ROW -->
                <hr>
                <div class="row">
                     
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="fg-line">
                            <div class="text-center">
                              <span class="f-18 c-morado text-center">{{$usuario_ext['nombre']}} </span>
                            </div>  
                        </div>
                        <div class="has-error" id="error-alumno_id">
                            <span >
                                <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                            </span>
                        </div>                        
                    </div><!-- END COL-SM-4 -->
                    <div class="col-sm-3"></div>    
                    
                </div><!-- END ROW -->
                <hr>
                <div class="clearfix p-b-15"></div>
                <div class="text-center">
                    <a href="{{$datos['response']['init_point'] }}" id="pagar" name="MP-Checkout" class="btn-blanco m-r-10 f-25 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Mercado Pago</a>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                    <div class="clearfix p-b-20"></div>
                </div>

                
            </div><!-- END CARD BODY -->
  <!--       </div>END CARD -->
    </div><!-- END CONTAINER -->

@stop

@section('js') 
            
	<script type="text/javascript">

        route_mercadopago="{{url('/')}}/especiales/campañas/contribuir/mercadopago";

        //RETURN DE MERCADOPAGO
        function respuesta_mercadopago(json) {

            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY";                       

            var response = JSON.stringify(json);
            if (json.collection_status=='approved'){
              var nTitle = 'Pago acreditado!';
              var nMensaje = ' Hemos recibido su pago satisfactoriamente, gracias';
              var nType = 'success';
            } else if(json.collection_status=='pending'){
              var nTitle = 'Oops';
              var nMensaje = ' El usuario no completó el pago';
              var nType = 'warning';              
            } else if(json.collection_status=='in_process'){    
              var nTitle = 'Pago en Proceso';
              var nMensaje = ' El pago está siendo revisado';
              var nType = 'info';
            } else if(json.collection_status=='rejected'){
              var nTitle = 'Oops';
              var nMensaje = ' El pago fué rechazado, el usuario puede intentar nuevamente el pago';
              var nType = 'warning';              
            } else if(json.collection_status==null){
              var nTitle = 'Proceso Imcompleto!';
              var nMensaje = ' El usuario no completó el proceso de pago, no se ha generado ningún pago';
              var nType = 'warning';
              
            }
            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
            procesar_mercadopago(json);
        }

        function procesar_mercadopago(response){

            //var id = $("#alumno_id").val();
            //var recompensa_nombre = "{{--$recompensas->nombre--}}";
            var campana_id = "{{ $usuario_ext['campana_id'] }}";
            var campana_nombre = "{{ $usuario_ext['campana_nombre'] }}";
            var monto = "{{ $usuario_ext['monto'] }}";
            var academia_id = "{{ $usuario_ext['academia_id'] }}";
            var nombre = "{{ $usuario_ext['nombre'] }}";
            var sexo = "{{ $usuario_ext['sexo'] }}";
            var email_externo = "{{ $usuario_ext['email_externo']}}";
            var route = route_mercadopago;
            var token = $('input:hidden[name=_token]').val();

            $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      json: response,
                      nombre: nombre,
                      academia_id : academia_id,
                      campana_id : campana_id,
                      campana_nombre : campana_nombre,
                      monto : monto,
                      email_externo : email,
                      sexo: sexo
                  },
              success:function(respuesta){

              },
              error:function(msj){

              }
            });

            setTimeout(function(){ window.location = "{{url('/')}}/especiales/campañas/progreso/"+{{ $usuario_ext['campana_id'] }}; },3000);

        }

	</script>
@stop