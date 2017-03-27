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
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">

              <div class="panel-body">

                    <div align="center"><i class="zmdi zmdi zmdi-rotate-right zmdi-hc-5x c-morado"></i></div>
                    <div class="c-morado f-40 text-center"> Restablece tu contraseña </div>
                    <div class="text-center f-22">Debe contener un mínimo de 6 caracteres de longitud</div>

                     <form name="form" id="form">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <input type="hidden" id="email" name="email" value="{{ $email or old('email') }}">
                        
                        <div class="col-md-7 col-md-offset-2">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                            <label class="col-md-12 control-label">Escribe tu contraseña nueva</label>

                            </div>
                            <div class="clearfix m-20 m-b-25"></div>

                            <div class="col-md-12">
                                <input type="password" class="form-control caja" id ="password" name="password">
                                <div class="has-error" id="error-password">
                                      <span >
                                          <small class="help-block error-span" id="error-password_mensaje" ></small>                                
                                      </span>
                                  </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-12 control-label">Escribe tu contraseña nueva una vez más</label>
                            <div class="clearfix m-20 m-b-25"></div>
                            <div class="col-md-12">
                                <input type="password" class="form-control caja" id ="password_confirmation" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix m-20 m-b-25"></div>
                        <div class="clearfix m-20 m-b-25"></div>
                        <div class="clearfix m-20 m-b-25"></div>

                        <div class="block-header text-center">
                                <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Enviar Contraseña</button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix m-20 m-b-25"></div>
            <div class="clearfix m-20 m-b-25"></div>
            <div class="clearfix m-20 m-b-25"></div>
            <div class="clearfix m-20 m-b-25"></div>
            <div class="clearfix m-20 m-b-25"></div>
            <div class="clearfix m-20 m-b-25"></div>

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

      $(document).ready(function(){

        url = window.location.href;
        split = url.split("=")
        email_tmp = split[1]
        email_split = email_tmp.split("%40")
        email = email_split[0] + "@" + email_split[1];

        $('#email').val(email);

        $('#password').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $('#password_confirmation').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

      });

        function errores(merror){
            console.log(merror);

          var campo = ["password"];
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

            $("#guardar").click(function(){

                var route = "{{ url('/password/reset') }}";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#form" ).serialize(); 

                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
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
                      // setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 

                        window.location = "{{url('/')}}/restablecer/completado"                     
                        
                      // }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){

                      if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
                        
                      if(msj.responseJSON.status=="TOKEN"){
                          
                          // var nTitle="    Ups! "; 
                          // var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          window.location = "{{ url('/restablecer/fallo') }}";           
                        }else{

                          errores(msj.responseJSON);
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        } 

                        // var nTitle="    Ups! "; 
                        // var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                      
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
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


		</script>
@stop