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
    
    <div class="container">

    <div class="block-header">
            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/campañas/progreso/{{$campana->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i>Volver</a>
        </div> 

        <div class="card">
            <div class="card-header text-center">
                <span class="f-30 c-morado"><i class="icon_a-campana f-25"></i> Verificación de datos</span>
            </div>
            <div class="card-body">
            
            <div class="panel-body">
                    
                <div role="tabpanel" class="tab">
                   
                    <div class="tab-content ">

            <div role="tabpanel" class="tab-pane animated fadeInRight in" id="primero">

                    <div class="row">

                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    
                    <img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;  margin: 0 auto;" class="img-responsive opaco-0-8" alt="">
                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="text-center">
                      
                    <p class="f-30">Hola, mi nombre es Peggy de Easy dance</p> 
                    <p class="f-25">Estás aquí porqué apoyas la campaña de {{$academia->nombre}} </p> 
                    <p class="f-25">Llamada, <span class="f-700" style="color:black">{{$campana->nombre}}</span></p>
                    <div class="text-center c-morado f-30">Dime,  ¿Cuál es tu nombre? </div>
                    <br>
                    <div class="clearfix m-20 m-b-25"></div>
                    <div class="clearfix m-20 m-b-25"></div>

                    <div class="col-sm-8 col-sm-offset-2">
                    <input type="hidden" name="nombre" value= "Prueba" >
                    <input type="text" class="form-control caja" id="cambio" name="cambio"></input>
                    <div class="has-error" id="error-cambio">
                        <span >
                            <small id="error-cambio_mensaje" class="help-block error-span" ></small>
                        </span>
                     </div>
                     </div>
                                                             

                    <div class="clearfix m-20 m-b-25"></div>

                     <button type="button" class="btn-blanco m-r-10 f-25 guardar tercero" href="#segundo" aria-controls="segundo" role="tab" data-toggle="tab" name="segundo">Ok <i class="zmdi zmdi-check"></i></button>

                     <!-- <button type="button" class="btn-blanco m-r-10 f-25 guardar" name="tercero">Ok <i class="zmdi zmdi-check"></i></button> -->


                     <span class="f-700">Pulsa Aqui</span>

                     <div class="clearfix m-20 m-b-25"></div>
                     <div class="clearfix m-20 m-b-25"></div>
                     </div>
                     <div class="col-md-1"></div>


                    </div> 
                  </div>

                 </div>



                 <div role="tabpanel" class="tab-pane  animated fadeInRight in" id="segundo">

                 <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2 text-center">
                    @if(Auth::check())
                      <i class="icon_a-acuerdo-de-pago f-75"></i>
                    @else

                     <img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;  margin: 0 auto;" class="img-responsive opaco-0-8" alt="">
                     @endif
                    </div>
                    <div class="col-sm-5"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="text-center">

                    @if(!Auth::check())
                      <p class="f-30">Muy bien <span class="f-700" id="mostrar">Nombre</span></p> 
                    @endif
              
                        <span class="f-25 c-morado text-center">Gracias por tu Colaboración para "{{$recompensas->nombre}}"</span>
                        <div class="clearfix p-b-15"></div>
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                          <span class="f-16 c-morado">Selecciona el patrocinador</span>
                        @endif
                    </div>
                </div><!-- END ROW -->

                <hr>

                <div class="row">

                  

                    <div class="col-sm-10 col-sm-offset-1">

                    @if(!Auth::check())

                     <!-- <p class="f-25">Te estaré re direccionado para la página de mercadopago, en el que puedes a través de tu tarjeta de crédito <br> pagar de forma rápida y segura @if(!Auth::check()), ademas necesitamos tu correo electrónico @endif</p> -->
                      

                        <div class="col-sm-8 col-sm-offset-2">
                          <div class="text-center c-morado f-30">Dime tu Correo Electronico</div>
                          <div class="clearfix m-20 m-b-25"></div> 
                          <input type="text" class="form-control caja" id="email_externo" name="email_externo"></input>
                          <div class="has-error" id="error-email_externo">
                              <span >
                                  <small id="error-email_externo_mensaje" class="help-block error-span" ></small>
                              </span>
                           </div>
                         </div>

                         <div class="clearfix m-20 m-b-25"></div>

                         <div class="col-sm-8 col-sm-offset-2">
                                 
                            <div class="text-center c-morado f-30" id="id-sexo">Dime tu Sexo</div>
                            <div class="clearfix m-20 m-b-25"></div>
                                <div class="text-center">
                                    <div class="input-group">
                                      <span class="input-group-addon"></span>
                                      <div class="p-t-10">
                                      <label class="radio radio-inline m-r-20">
                                          <input name="sexo" id="mujer" value="F" type="radio" checked>
                                          <i class="input-helper"></i>  
                                          <span class="f-20">Mujer</span> <i class="zmdi zmdi-female p-l-5 f-25"></i>
                                      </label>
                                      <label class="radio radio-inline m-r-20 ">
                                          <input name="sexo" id="hombre" value="M" type="radio">
                                          <i class="input-helper"></i>  
                                          <span class="f-20">Hombre</span> <i class="zmdi zmdi-male-alt p-l-5 f-25"></i>
                                      </label>
                                      </div>
                                    </div>
                                     <div class="has-error" id="error-sexo">
                                          <span >
                                              <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                          </span>
                                      </div>
                                  </div>
                              </div>
                      
                      @endif
                    </div>

                    
                     
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">

                        <div class="fg-line">
                        @if(Auth::check())
                           @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                              <div class="select">
                                  <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona">
                                      @foreach ( $alumnos as $alumno )
                                        <option value = "{{ $alumno->id }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                      @endforeach
                                  </select>
                              </div>

                              @else
                          
                              <div class="text-center">
                                <span class="f-18 c-morado text-center">{{$usuario_nombre}}</span>
                                <input type="hidden" value="" name="alumno_id" id="alumno_id">
                              </div>  


                              
                          @endif
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
                  <!--  
                    Aqui se esta usando una regla de acceso llamada
                    "view-mercadopago-button" usando reglas de Acceso ACL o
                    Policies, usando el metodo can()
                  -->
                 
                    <a href="{{ $datos['response']['init_point'] }}" id="pagar" name="MP-Checkout" class="btn-blanco m-r-10 f-25 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Mercado Pago</a>
        
                    <!-- <button type="button" class="btn-blanco m-r-10 f-25 guardar" id="guardar" name="guardar">Contribuir</button> -->

                  </div>

                 </div>

                 </div>
                 </div>
                 </div>

                
                <div class="clearfix p-b-20"></div>
                <div class="clearfix p-b-20"></div>

                
            </div><!-- END CARD BODY -->
        </div><!-- END CARD -->
    </div><!-- END CONTAINER -->


@stop

@section('js') 
            
	<script type="text/javascript">

        route_mercadopago="{{url('/')}}/especiales/campañas/contribuir/mercadopago";
        route_agregar="{{url('/')}}/especiales/campañas/contribuir";

        $(document).ready(function(){

          $('#cambio').val('');
          $('#email_externo').val('');

          $(".tercero").attr("disabled","disabled");
          $(".tercero").css({
            "opacity": ("0.2")
          });

          if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 3 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == ''){

            $("#pagar").attr("disabled","disabled");
            $("#pagar").css({
              "opacity": ("0.2")
            });

          }


          if("{{$usuario_tipo}}" == '')
          {
            $('#primero').addClass('active')
          }else{
            $('#segundo').addClass('active')
          }

          $('#cambio').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

              A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
              }

            });

        });


        $("#email_externo").keyup(function(){

            if($("#email_externo").val()!=""){

                $("#pagar").removeAttr("disabled");
                $("#pagar").css({
                  "opacity": ("1")
                 });
                  
            }else{

                $("#pagar").attr("disabled","disabled");
                $("#pagar").css({
                  "opacity": ("0.2")
                });
            }

        
        });

        $("#alumno_id").change(function(){

          if ($("#alumno_id").val()=='') {
                $("#pagar").attr("disabled","disabled");
                $("#pagar").css({
                  "opacity": ("0.2")
                });
          } else  {
                $("#pagar").removeAttr("disabled");
                $("#pagar").css({
                  "opacity": ("1")
                 });
          }
            
        });


        $('button[name="segundo"]').click(function(){       

              var nombre = $('#cambio').val();

              $("input[name=nombre]").val(nombre);
              $('#mostrar').text(nombre);

        });

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
          
            var recompensa_nombre = "{{$recompensas->nombre}}";
            var campana_id = "{{$campana->id}}";
            var monto = "{{$recompensas->cantidad}}"
            var route = route_mercadopago;
            var token = $('input:hidden[name=_token]').val();
            var nombre = $("input[name=nombre]").val();
            var email_externo = $('#email_externo').val();
            var campana_nombre = "{{$campana->nombre}}";
            var academia_id = "{{$academia->id}}";
            var alumno_id = $("#alumno_id").val();
            var sexo = $("input[name=sexo]").val();

            $.ajax({
              url: route,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      json: response,
                      recompensa : recompensa_nombre,
                      campana_id : campana_id,
                      monto : monto,
                      nombre: nombre,
                      email_externo: email_externo,
                      academia_id: academia_id,
                      alumno_id: alumno_id,
                      campaña_nombre: campaña_nombre,
                      sexo: sexo

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

                          if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6)
                          {
                            window.location = "{{url('/')}}/participante/alumno/deuda/" + respuesta.id;
                          }else{
                            window.location = "{{url('/')}}/administrativo";
                          }

                          

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
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
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

      $("#cambio").keyup(function(){

        if($("#cambio").val() != ""){

        $(".tercero").removeAttr("disabled");
        $(".tercero").css({
          "opacity": ("1")
         });
          
      }
      else{

        $(".tercero").attr("disabled","disabled");
        $(".tercero").css({
          "opacity": ("0.2")
        });
      }
    });


	</script>
@stop