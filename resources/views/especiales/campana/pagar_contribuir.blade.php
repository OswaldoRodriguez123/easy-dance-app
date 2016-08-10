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
  <!-- PAGO RECOMPENSA MERCADOPAGO -->
    
    <div class="container">

        <div class="card">
            <div class="card-header text-center">
                <span class="f-30 c-morado"><i class="icon_a-campana f-25"></i> Verificación de datos {{$campana->id}}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2 text-center"><i class="icon_a-acuerdo-de-pago f-75"></i></div>
                    <div class="col-sm-5"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="text-center">
                        <span class="f-25 c-morado text-center">Gracias por su Colaboración para "{{$recompensas->nombre}}"</span>
                        <div class="clearfix p-b-15"></div>
                        <span class="f-16 c-morado">Selecciona el patrocinador</span>
                    </div>
                </div><!-- END ROW -->
                <hr>

                <div class="row">
                     
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="fg-line">
                        @if(Auth::user()->isType()=='admin')
                            <div class="select">
                                <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona">
                                    @foreach ( $alumnos as $alumno )
                                      <option value = "{{ $alumno->id }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="text-center">
                              <span class="f-18 c-morado text-center">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</span>
                              <input type="hidden" value="{{Auth::user()->id}}" name="alumno_id" id="alumno_id">
                            </div>  
                        @endif    
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
                    <a href="{{ $datos['response']['init_point'] }}" id="pagar" name="MP-Checkout" class="btn-blanco m-r-10 f-25 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Mercado Pago</a>

                    <button type="button" class="btn-blanco m-r-10 f-25 guardar" id="guardar" name="guardar">Contribuir</button>

                </div>
                <div class="clearfix p-b-20"></div>
                <div class="clearfix p-b-20"></div>

                
            </div><!-- END CARD BODY -->
        </div><!-- END CARD -->
    </div><!-- END CONTAINER -->

@stop

@section('js') 
            
	<script type="text/javascript">

        route_mercadopago="{{url('/')}}/especiales/campañas/contribuir_mercadopago";
        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

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

              //PAGO NORMAL, VERSION ANTERIOR
              $("#guardar").click(function(){

                procesando();
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = "&recompensa_id="+{{$recompensas->id}}+"&campana_id={{$campana->id}}&alumno_id="+$("#alumno_id").val(); 
                $("#guardar").attr("disabled","disabled");
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                procesando();
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          window.location = "{{url('/')}}/participante/alumno/deuda/" + respuesta.id;

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        // finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        // if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar").removeAttr("disabled");
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        finprocesado();
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
                      }, 1000);
                    }
                });
            });




	</script>
@stop