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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div align="center"><i class="zmdi zmdi zmdi-mood-bad zmdi-hc-5x c-youtube"></i></div>
                    <div class="f-40 text-center"> Easy Dance </div>

                    <div class="clearfix m-20 m-b-25"></div>

                    <div class="text-center f-25 c-youtube">Ups! El enlace de restablecimiento en el que has hecho clic ha expirado. Por favor, solicita uno nuevo.  </div>

                    <form name="form" id="form">
                        <!-- {!! csrf_field() !!} -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="clearfix m-20 m-b-25"></div>
                        <div class="clearfix m-20 m-b-25"></div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="text-center f-22">Ingresa tu correo electrónico </div>

                            <div class="clearfix m-20 m-b-25"></div>

                            <div class="col-md-12">
                                <input type="email" class="form-control caja" name="email" value="{{ old('email') }}">

                                <div class="has-error" id="error-email">
                                      <span >
                                          <small class="help-block error-span f-16" id="error-email_mensaje" ></small>                                
                                      </span>
                                  </div>
                            </div>
                        </div>

                        <div class="clearfix m-20 m-b-25"></div>
                        
                    <div class="block-header text-center">
                                <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Enviar</button>
                      </div>

                    </form>
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

    route_redireccionar="{{url('/')}}/restablecer/confirmar";


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

                var route = "{{ url('/password/email') }}";
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
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 

                        window.location = route_redireccionar;                      
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        
                        $("#error-email_mensaje").html("Ups! No Hemos encontrado la siguiente información del correo  asociada a tu cuenta"); 

                        var nTitle="    Ups! "; 
                        var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                      
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