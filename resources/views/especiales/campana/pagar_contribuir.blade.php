@extends('layout.master')

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
  <!-- ENHORABUENA -->

  
    
    <div class="container">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                    <h4 class="modal-title">Verificación de datos<button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">
                    <div class="row p-l-10 p-r-10">

                    <div class="col-sm-5"></div>
                    <div class="col-sm-2"><i class="icon_a-acuerdo-de-pago f-75"></i> </div>
                    <div class="col-sm-5"></div>

                    <div class="clearfix p-b-15"></div>
                    <div class="text-center">
                        <span class="f-25 c-morado text-center">Gracias por tu colaboración para {{$recompensas->nombre}}</span>  
                        <br></br>   
                        <span class="f-16 c-morado">Selecciona el patrocinador</span>

                    </div>
                    <hr></hr>
                
                <div class="clearfix p-b-15"></div>
                <div class="col-sm-12">
                    <div class="fg-line">
                        <div class="select">
                            <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona">
                                @foreach ( $alumnos as $alumno )
                                  <option value = "{{ $alumno->id }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="has-error" id="error-alumno_id">
                        <span >
                            <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                        </span>
                    </div>
                </div>
                <div class="clearfix p-b-15"></div>

                <hr></hr>
              

                <div class="clearfix p-b-15"></div>

                <div class="text-center">

                    <!--<button type="button" class="btn-blanco m-r-10 f-25 guardar" id="guardar" name="guardar">Contribuir</button>-->

                    <a href="{{ $datos['response']['init_point'] }}" id="pagar" name="MP-Checkout" class="btn-blanco m-r-10 f-25 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Mercado Pago</a>




                </div>

                <div class="clearfix p-b-15"></div>
                   

                </div>
                </div>
            
            </div>
        

        </div>



    </div>


@stop


@section('js') 
            
	<script type="text/javascript">

        route_mercadopago="{{url('/')}}/especiales/campañas/contribuir_mercadopago";

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

            var id = $("#alumno_id").val();
            var recompensa_nombre = "{{$recompensas->nombre}}";
            var campana_id = "{{$campana->id}}";
            var monto = "{{$recompensas->cantidad}}"
            var route = route_mercadopago;
            var token = $('input:hidden[name=_token]').val();

            $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      json: response,
                      alumno: id,
                      recompensa : recompensa_nombre,
                      campana_id : campana_id,
                      monto : monto
                  },
              success:function(respuesta){

              },
              error:function(msj){

              }
            });

            setTimeout(function(){ window.location = "{{url('/')}}/especiales/campañas/progreso/"+{{$campana->id}}; },3000);

        }


	</script>
@stop