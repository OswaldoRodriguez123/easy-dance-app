@extends('layout.master3')

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
<!--MERCADO PAGO MODAL -->
<script type="text/javascript" src="http://resources.mlstatic.com/mptools/render.js"></script>
@stop

@section('content')
<!--     
    <div style="background-color: #fff"> -->
      <div class="container" style="background-color: #fff; margin:0; width: 100%">
        <div class="block-header" style="padding-top: 5%">
            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/todos-con-robert" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i>Volver</a>
        </div> 
<!--       <div class="card"> -->
        <div class="card-header text-center">
                <span class="f-30 c-morado"><i class="icon_a-campana f-25"></i> Verificación de datos</span>
        </div>
        <div class="card-body">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="panel-body"> 
                <div role="tabpanel" class="tab">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane animated fadeInRight in" id="primero">
                            <div class="block-header text-center">

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
                                    <input type="hidden" name="nombre" value= "Prueba" >
                                    <input type="text" class="form-control caja" id="cambio" name="cambio"></input>
                                    <div class="has-error" id="error-cambio">
                                        <span >
                                            <small id="error-cambio_mensaje" class="help-block error-span" ></small>
                                        </span>
                                    </div>
                                                                             
                                    <div class="clearfix m-20 m-b-25"></div>

                                    <button type="button" class="btn-blanco m-r-10 f-25 guardar tercero" href="#segundo" aria-controls="segundo" role="tab" data-toggle="tab" name="segundo">Ok <i class="zmdi zmdi-check"></i></button>

                                    <span class="f-700">Pulsa Aqui</span>

                                    <div class="clearfix m-20 m-b-25"></div>
                                    <div class="clearfix m-20 m-b-25"></div>

                                </div> 
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane animated fadeInRight in" id="segundo">
                            
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
                              
                                        <span class="f-25 c-morado text-center">Gracias por tu Colaboración para "{{$campana->nombre}}"</span>
                                        <div class="clearfix p-b-15"></div>
                                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                          <span class="f-16 c-morado">Selecciona el patrocinador</span>
                                        @endif
                                </div>
                            </div><!-- END ROW -->

                            <hr>

                            <div class="row">


                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">

                                    @if(Auth::check())
                                       @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                                           <div class="fg-line">
                                              <div class="select">
                                                  <select class="selectpicker" id="alumno_id" name="alumno_id" title="Selecciona">
                                                      @foreach ( $alumnos as $alumno )
                                                        <option value = "{{ $alumno->id }}">{{ $alumno['nombre'] }} {{ $alumno['apellido'] }} {{ $alumno['identificacion'] }}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                                <div class="has-error" id="error-alumno_id">
                                                    <span>
                                                        <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                                    </span>
                                                </div>  
                                            </div>

                                            <div class="clearfix p-b-15"></div>

                                        @else
                                      
                                          <div class="text-center">
                                            <span class="f-18 c-morado text-center">{{$usuario_nombre}}</span>
                                          </div>  

                                          <div class="clearfix p-b-15"></div>
                                          <div class="clearfix p-b-15"></div>

                                        @endif
                                    @endif
                                   
                                                          
                                </div><!-- END COL-SM-8 -->
                                <div class="col-sm-2"></div> 

                                <div class="clearfix"></div>

                                <div class="col-sm-10 col-sm-offset-1">

                                    <div class="text-center c-morado f-30">Dime, ¿por cuanto será tu contribución? </div>
                                    <div class="clearfix m-20 m-b-25"></div>
                               
                                    <input type="text" class="form-control caja" id="monto" name="monto" data-mask="0000000000"></input>
                                    <div class="has-error" id="error-monto">
                                        <span >
                                            <small id="error-monto_mensaje" class="help-block error-span" ></small>
                                        </span>
                                     </div>

                                    @if(!Auth::check())
                                        <div class="clearfix m-20 m-b-25"></div>

                                        <div class="text-center c-morado f-30">Dime tu Correo Electronico</div>
                                        <div class="clearfix m-20 m-b-25"></div> 
                                        <input type="text" class="form-control caja" id="email_externo" name="email_externo"></input>
                                        <div class="has-error" id="error-email_externo">
                                            <span >
                                                <small id="error-email_externo_mensaje" class="help-block error-span" ></small>
                                            </span>
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
                            
                                </div> <!-- COL-SM-10 -->
   
                            </div><!-- END ROW -->

                            <hr>

                            <div class="clearfix p-b-15"></div>
                            <div class="text-center">
                         
                                <button type="button" class="btn-blanco m-r-10 f-25 guardar cuarto" href="#cuarto" aria-controls="cuarto" role="tab" data-toggle="tab" name="cuarto" id="cuarto">Ok <i class="zmdi zmdi-check"></i><i class="zmdi zmdi-replay zmdi-hc-spin-reverse"></i></button>
                                <span class="f-700">Pulsa Aqui</span>
                
                            </div><!-- TEXT-CENTER -->

                         </div><!-- TAB -->
                    </div><!-- TAB-CONTENT -->
                  </div> <!-- TAB-PANEL -->
                </div><!-- PANEL-BODY -->
                <div class="col-md-2"></div>
            
                </div>
              <!-- </div> -->
            </div>
        </div>


@stop


@section('js') 
            
	<script type="text/javascript">

    route_agregar="{{url('/')}}/registro";
    route_externo="{{url('/')}}/especiales/campañas/contribuir/participante-externo";
    route_usuario="{{url('/')}}/especiales/campañas/contribuir/mercadopago";

    $(document).ready(function(){

        if("{{Auth::check()}}" == 0){
            $(".card").height(1100)
        }else{
            $(".card").height(800)
        }

        $('#cambio').val('');
        $('#email_externo').val('');
        $('#monto').val('');

        if("{{$usuario_tipo}}" == ''){
            $('#primero').addClass('active')
        }else{
            $('#segundo').addClass('active')
        }

        $(".zmdi-hc-spin-reverse").css('visibility','hidden');

        $('#email').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $('#email_confirmation').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $('#password').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $('#password_confirmation').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $(".tercero").attr("disabled","disabled");
        $(".tercero").css({
          "opacity": ("0.2")
        });

        $(".cuarto").attr("disabled","disabled");
        $(".cuarto").css({
          "opacity": ("0.2")
        });

        $('#cambio').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {

            A: {pattern: /[A-Za-záéíóúÁÉÍÓÚ.,@*+_ñÑ ]/}
            }

        });
    });

        //PAGAR CAMPAÑA
        $("#cuarto").on("click",function(){
            procesando();
            var token = $('input:hidden[name=_token]').val();
            var nombre = $("input[name=nombre]").val();
            var sexo = $("input[name=sexo]").val();
            var monto = $("input[name=monto]").val();
            var email_externo = $("input[name=email_externo]").val();
            var alumno_id = $("#alumno_id").val();
            var campana_id = "{{$campana->id}}";
            var campana_nombre = "{{$campana->nombre}}";
            var academia_id = "{{$academia->id}}"
            limpiarMensaje();
            $(".zmdi-check").css('visibility','hidden');
            $(".zmdi-hc-spin-reverse").css('visibility','visible');

                $.ajax({
                    url: route_externo,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            nombre : nombre,
                            monto: monto,
                            campana_id : campana_id,
                            campana_nombre : campana_nombre,
                            academia_id : academia_id,
                            email_externo : email_externo,
                            alumno_id : alumno_id,
                            sexo: sexo
                        },
                    success:function(respuesta){
                        if(respuesta.status == 'OK'){
                            if("Auth::check()"){
                                window.location = route_usuario;
                            }else{
                                window.location = route_externo;
                            }
                           
                        }    
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        finprocesado();
                        $(".zmdi-check").css('visibility','visible');
                        $(".zmdi-hc-spin-reverse").css('visibility','hidden');
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
                        $(".cancelar").removeAttr("disabled");
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


    function errores(merror){
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1000);          

  }

    $('button[name="segundo"]').click(function(){       

        var nombre = $('#cambio').val();

        $("input[name=nombre]").val(nombre);
        $('#mostrar').text(nombre);

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


    //$("#monto").keyup(function(){
    $("#email_externo").keyup(function(){

            if($("#monto").val() != "" && $("#email_externo").val()!=""){

                $(".cuarto").removeAttr("disabled");
                $(".cuarto").css({
                  "opacity": ("1")
                 });
                  
            }else{

                $(".cuarto").attr("disabled","disabled");
                $(".cuarto").css({
                  "opacity": ("0.2")
                });
            }
    });

    $("#monto").keyup(function(){

            if($("#monto").val() != "" && $("#email_externo").val()!="" && $("#alumno_id").val() != ""){

                $(".cuarto").removeAttr("disabled");
                $(".cuarto").css({
                  "opacity": ("1")
                 });
                  
            }else{

                $(".cuarto").attr("disabled","disabled");
                $(".cuarto").css({
                  "opacity": ("0.2")
                });
            }

        
    });

    $("#alumno_id").change(function(){

         if($("#monto").val() != "" && $("#alumno_id").val() != "") {
                $(".cuarto").removeAttr("disabled");
                $(".cuarto").css({
                  "opacity": ("1")
                 });
          } else  {
                
                $(".cuarto").attr("disabled","disabled");
                $(".cuarto").css({
                  "opacity": ("0.2")
                });
          }
            
        });

    function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
                $.growl({
                    icon: icon,
                    title: titulo,
                    message: mensaje,
                    url: ''
                },{
                        element: 'body',
                        type: type,
                        allow_dismiss: true,
                        placement: {
                                from: from,
                                align: align
                        },
                        offset: {
                            x: 20,
                            y: 85
                        },
                        spacing: 10,
                        z_index: 1070,
                        delay: 2500,
                        timer: 2000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                                enter: animIn,
                                exit: animOut
                        },
                        icon_type: 'class',
                        template: '<div data-growl="container" class="alert" role="alert">' +
                                        '<button type="button" class="close" data-growl="dismiss">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '<span class="sr-only">Close</span>' +
                                        '</button>' +
                                        '<span data-growl="icon"></span>' +
                                        '<span data-growl="title"></span>' +
                                        '<span data-growl="message"></span>' +
                                        '<a href="#" data-growl="url"></a>' +
                                    '</div>'
                });
            };

     
    function limpiarMensaje(){
      var campo = ["email_externo", "monto"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var elemento="";
      var contador=0;
      $.each(merror, function (n, c) {
      if(contador==0){
      elemento=n;
      }
      contador++;

       $.each(this, function (name, value) {              
          var error=value;
          $("#error-"+n+"_mensaje").html(error);             
       });
    });       

  }

		</script>
@stop