@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
<!--                     <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Alumno</a>
                        <h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>
                    </div>  -->


                   

                      <div class="block-header">
                         <?php $url = "/participante/visitante/detalle/$visitante->id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                      </div> 

                    
                    <div class="card">
                        <div class="card-header text-center">
                        

                            <span class="f-25 c-morado"> {{$visitante_presencial->nombre}} </span> <br> <br>

                            <span class="f-25 c-morado"> Ayúdenos a mejorar, tu opinión Vale </span>


                            <img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px; margin-left:45%" class="img-responsive opaco-0-8" alt="">


                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="encuesta_evaluativa" id="encuesta_evaluativa"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="visitante_id" value="{{ $visitante->id }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                            
                                <div class="col-sm-12">

                                 
                                    <label for="apellido" id="id-rapidez">¿Con qué rapidez lo atendieron nuestros representantes de servicio al cliente?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="rapidez" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Muy Rápido
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="rapidez" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Rapido
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="rapidez" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Lento
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="rapidez" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        Muy Lento
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-rapidez">
                                      <span >
                                          <small class="help-block error-span" id="error-rapidez_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-calidad">¿Cómo considera usted la atención de nuestros representantes de servicio al cliente? </label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="calidad" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Excelente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="calidad" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Bueno
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="calidad" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Regular
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="calidad" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        Malo
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-calidad">
                                      <span >
                                          <small class="help-block error-span" id="error-calidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-satisfaccion">¿Recibió usted satisfactoriamente la información que solicitaba?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="satisfaccion" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Si, completamente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="satisfaccion" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        No de un todo
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="satisfaccion" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        No
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="satisfaccion" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        No lo sé
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-satisfaccion">
                                      <span >
                                          <small class="help-block error-span" id="error-satisfaccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-disponibilidad">¿Estaría dispuesto a realizar clases con nosotros?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="disponibilidad" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Absolutamente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="disponibilidad" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Posiblemente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="disponibilidad" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        No estoy seguro
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="disponibilidad" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        No
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-disponibilidad">
                                      <span >
                                          <small class="help-block error-span" id="error-disponibilidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                              
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               
                               <div class="clearfix p-b-35"></div>

                          <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-12 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-12 text-left">                           

                              <!-- <a class="btn-blanco m-r-10 f-18 guardar" href="#" id="guardar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a> -->

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div> 

          

                            </div>
                        </div>
                    </div>
                </div>
            </section>

@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/participante/visitante/impresion";
  route_principal="{{url('/')}}/participante/visitante";
  
  $(document).ready(function(){


    if("{{$visitante->rapidez}}" != 0){

      $("input[name=rapidez][value={{$visitante->rapidez}}]").attr('checked', 'checked');
      $("input[name=satisfaccion][value={{$visitante->satisfaccion}}]").attr('checked', 'checked');
      $("input[name=calidad][value={{$visitante->calidad}}]").attr('checked', 'checked');
      $("input[name=disponibilidad][value={{$visitante->disponibilidad}}]").attr('checked', 'checked');

    }

      
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
        //var cardImg = $(this).closest('#content').find('h1');
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        //$("h1").removeAttr('class');
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);


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

            $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#encuesta_evaluativa" ).serialize();

                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
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
                          window.location = route_principal;
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

                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                      
                        
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

      function limpiarMensaje(){
      var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "telefono", "celular", "correo", "direccion"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo", "telefono", "celular", "correo", "direccion"];
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


       $( "#cancelar" ).click(function() {
        $("#perfil_evaluativo")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-aprendizaje").offset().top-90,
        }, 1000);
      });


</script> 
@stop

