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


                    @if(Auth::user()->usuario_tipo != 2 AND Auth::user()->usuario_tipo != 4)

                      <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$perfil->alumno_id}}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                      </div> 

                    @endif
                    
                    <div class="card">
                        <div class="card-header text-center">

                        @if(Auth::user()->usuario_tipo == 2 OR Auth::user()->usuario_tipo == 4)

                        <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect"><a href="{{url('/')}}/perfil" aria-controls="home11" onclick="procesando()"><div class="zmdi zmdi-account f-30"></div><p style=" margin-bottom: -2px;">Perfil</p></a></li>
                                    <li class="waves-effect active"><a href="{{url('/')}}/perfil-evaluativo" aria-controls="home11" onclick="procesando()"><div class="icon_a-alumnos f-30"></div><p style=" margin-bottom: -2px;">Perfil Evaluativo</p></a></li>
                                    
                            </ul>
                            </div>

                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                          @endif

                            <span class="f-25 c-morado"><i class="icon_a-alumnos f-25"></i> Perfil Evaluativo </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="perfil_evaluativo" id="perfil_evaluativo"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="usuario_id" value="{{ $perfil->usuario_id }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                            
                                <div class="col-sm-12">

                                <span class="f-30 text-center c-morado" id="id-span_motivacion"> Motivación </span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <label for="apellido" id="id-aprendizaje">Cuál es tu motivación para aprender a bailar</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="aprendizaje" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Mi vida profesional
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="aprendizaje" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Mi vida social
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="aprendizaje" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Mi vida personal
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="aprendizaje" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        No lo sé
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-aprendizaje">
                                      <span >
                                          <small class="help-block error-span" id="error-aprendizaje_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-actividad">¿Tienes próximamente alguna actividad especial que te ha motivado aprender a bailar ? </label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="actividad" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Si, un evento/ fiesta  
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="actividad" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        No tengo ninguna actividad que me motive 
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-actividad">
                                      <span >
                                          <small class="help-block error-span" id="error-actividad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-beneficio">Cuál es mayor beneficio que recibirás al momento de aprender a bailar</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="beneficio" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Mejor estatus social
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="beneficio" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Superación personal
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="beneficio" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Mayor reconocimiento público
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="beneficio" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        No lo sé
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-beneficio">
                                      <span >
                                          <small class="help-block error-span" id="error-beneficio_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-motivado">¿Quién te ha estimulado aprender a bailar?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="motivado" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Familiares
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="motivado" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Novio (a)
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="motivado" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Cónyuge o pareja
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="motivado" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        Amigos
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="motivado" id="5" value="5" type="radio">
                                        <i class="input-helper"></i>  
                                        Nadie
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-motivado">
                                      <span >
                                          <small class="help-block error-span" id="error-motivado_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-dedicacion">¿Cuántas horas a la semana puedes dedicarte aprender a bailar?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="dedicacion" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        0-1 horas
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="dedicacion" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        2-4 horas
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="dedicacion" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        4-6 horas
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="dedicacion" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        6-8 horas
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="dedicacion" id="5" value="5" type="radio">
                                        <i class="input-helper"></i>  
                                        8-10 en horas adelante
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-dedicacion">
                                      <span >
                                          <small class="help-block error-span" id="error-dedicacion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-velocidad">¿Con que velocidad te gustaría aprender?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="velocidad" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Se me hace urgente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="velocidad" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Mi objetivo es a mediano plazo
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="velocidad" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        No tengo prisa
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="velocidad" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        No lo he pensado 
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-velocidad">
                                      <span >
                                          <small class="help-block error-span" id="error-velocidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                               <span class="f-30 text-center c-morado" id="id-span_nivel"> Nivel de baile y experiencia </span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <label for="apellido" id="id-seguridad">¿Cuán seguro te sientes al momento de bailar?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="seguridad" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        No sé bailar
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="seguridad" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Puedo bailar con esfuerzo
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="seguridad" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Bailo pero con fallas
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="seguridad" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        Bailo muy bien 
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-seguridad">
                                      <span >
                                          <small class="help-block error-span" id="error-seguridad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-participacion">¿Has participado anteriormente en otra academia?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="participacion" id="1" value="1" type="radio">
                                        <i class="input-helper"></i>  
                                        Nunca
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="participacion" id="2" value="2" type="radio">
                                        <i class="input-helper"></i>  
                                        Si pero aprendí muy poco
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="participacion" id="3" value="3" type="radio">
                                        <i class="input-helper"></i>  
                                        Si aprendí lo suficiente
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="participacion" id="4" value="4" type="radio">
                                        <i class="input-helper"></i>  
                                        Si me hice muy diestro
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-participacion">
                                      <span >
                                          <small class="help-block error-span" id="error-participacion_mensaje" ></small>                                
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

  route_agregar="{{url('/')}}/perfil-evaluativo";
  route_perfil="{{url('/')}}/perfil";
  
  $(document).ready(function(){


    if("{{$perfil->aprendizaje}}" != 0){

      $("input[name=aprendizaje][value={{$perfil->aprendizaje}}]").attr('checked', 'checked');
      $("input[name=actividad][value={{$perfil->actividad}}]").attr('checked', 'checked');
      $("input[name=beneficio][value={{$perfil->beneficio}}]").attr('checked', 'checked');
      $("input[name=motivado][value={{$perfil->motivado}}]").attr('checked', 'checked');
      $("input[name=dedicacion][value={{$perfil->dedicacion}}]").attr('checked', 'checked');
      $("input[name=velocidad][value={{$perfil->velocidad}}]").attr('checked', 'checked');
      $("input[name=seguridad][value={{$perfil->seguridad}}]").attr('checked', 'checked');
      $("input[name=participacion][value={{$perfil->participacion}}]").attr('checked', 'checked');

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
                var datos = $( "#perfil_evaluativo" ).serialize();

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
                          window.location = route_perfil;
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

