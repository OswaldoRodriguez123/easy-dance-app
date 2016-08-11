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
                    
                    <div class="card">
                        <div class="card-header text-center">

                        <div class="col-xs-12 text-left">
                          <ul class="tab-nav tn-justified" role="tablist">
                                    <li class="waves-effect"><a href="{{url('/')}}/participante/instructor/detalle/{{$id}}" aria-controls="home11" onclick="procesando()"><div class="zmdi zmdi-account f-30"></div><p style=" margin-bottom: -2px;">Perfil</p></a></li>
                                    <li class="waves-effect active"><a href="{{url('/')}}/participante/instructor/experiencia/{{$id}}" aria-controls="home11" onclick="procesando()"><div class="icon_a-instructor f-30"></div><p style=" margin-bottom: -2px;">Experiencia como Instructor</p></a></li>
                                    
                            </ul>
                            </div>

                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>

                            <span class="f-25 c-morado"><i class="icon_a-instructor f-25"></i> Experiencia como instructor </span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="perfil_evaluativo" id="perfil_evaluativo"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="id" value="{{ $id }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                            
                                <div class="col-sm-12">

                                <span class="f-30 text-center c-morado" id="id-perfil_instructor"> Perfil Instructor </span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div> 
                                 
                                    <label for="apellido" id="id-tiempo_experiencia_instructor">Años de experiencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica cuanto tiempo de experiencia tiene como instructor de baile" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="tiempo_experiencia_instructor" id="tiempo_experiencia_instructor" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-tiempo_experiencia_instructor">
                                      <span >
                                          <small class="help-block error-span" id="error-tiempo_experiencia_instructor_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-genero_instructor">Géneros que domina</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica en  la cantidad de géneros y estilos de baile  que dominas" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="genero_instructor" id="genero_instructor" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-genero_instructor">
                                      <span >
                                          <small class="help-block error-span" id="error-genero_instructor_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>


                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-cantidad_horas">Cantidad de horas impartidas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la cantidad de horas aproximada  realizadas en su carrera como instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="cantidad_horas" id="cantidad_horas" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-cantidad_horas">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_horas_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-titulos_instructor">Títulos y reconocimientos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica aproximadamente la cantidad de títulos y/o reconocimientos que ha recibido  durante su carrera como instructor " title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="titulos_instructor" id="titulos_instructor" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-titulos_instructor">
                                      <span >
                                          <small class="help-block error-span" id="error-titulos_instructor_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                                    <span class="f-30 text-center c-morado" id="id-span_nivel"> Sección General </span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div>
                                 
                                    <label for="apellido" id="id-invitacion_evento">Invitaciones a eventos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la cantidad de  eventos que ha organizados  o que ha contribuido como coordinador y apoyo en  la organización de eventos" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="invitacion_evento" id="invitacion_evento" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-invitacion_evento">
                                      <span >
                                          <small class="help-block error-span" id="error-invitacion_evento_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-organizador">Organizador de eventos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la cantidad de invitaciones a  eventos o actividades  importantes que has recibido en calidad de instructor" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="organizador" id="organizador" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-organizador">
                                      <span >
                                          <small class="help-block error-span" id="error-organizador_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12"> 

                                  <span class="f-30 text-center c-morado" id="id-perfil_bailador"> Perfil como bailador/bailarín </span>
                                

                                    <hr></hr>

                                    <div class="clearfix p-b-35"></div>
                                 
                                    <label for="apellido" id="id-tiempo_experiencia_bailador">Años de experiencia</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica cuanto tiempo de experiencia tiene como bailador o bailarín" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="tiempo_experiencia_bailador" id="tiempo_experiencia_bailador" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-tiempo_experiencia_bailador">
                                      <span >
                                          <small class="help-block error-span" id="error-tiempo_experiencia_bailador_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-genero_bailador">Géneros que domina</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica en  la cantidad de géneros y estilos de baile  que domina" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="genero_bailador" id="genero_bailador" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-genero_bailador">
                                      <span >
                                          <small class="help-block error-span" id="error-genero_bailador_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-participacion_coreografia">Participación en coreografías</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la cantidad de participaciones que ha tenido como bailador o bailarín" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="participacion_coreografia" id="participacion_coreografia" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-participacion_coreografia">
                                      <span >
                                          <small class="help-block error-span" id="error-participacion_coreografia_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-montajes">Montajes coreográficos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica la cantidad aproximada de montajes coreográficos que ha realizado en su carrera" title="" data-original-title="Ayuda"></i>

                                   <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="montajes" id="montajes" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-montajes">
                                      <span >
                                          <small class="help-block error-span" id="error-montajes_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-titulos_bailador">Títulos y reconocimientos</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica aproximadamente la  cantidad de títulos y/o reconocimientos que ha recibido durante su carrera como bailador o bailarín" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="titulos_bailador" id="titulos_bailador" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-titulos_bailador">
                                      <span >
                                          <small class="help-block error-span" id="error-titulos_bailador_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-participacion_escenario">Participación en escenarios y shows</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Indica aproximadamente la  cantidad de participación que ha participado durante su carrera como bailador o bailarín" title="" data-original-title="Ayuda"></i>

                                    <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="participacion_escenario" id="participacion_escenario" data-mask="0000000000" placeholder="Ej: 3">
                                      </div>
                                 <div class="has-error" id="error-participacion_escenario">
                                      <span >
                                          <small class="help-block error-span" id="error-participacion_escenario_mensaje" ></small>                                
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

                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

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

  route_agregar="{{url('/')}}/participante/instructor/experiencia";
  
  $(document).ready(function(){



        $("#tiempo_experiencia_instructor").val("{{$perfil->tiempo_experiencia_instructor}}");
        $("#genero_instructor").val("{{$perfil->genero_instructor}}");
        $("#cantidad_horas").val("{{$perfil->tiempo_experiencia_instructor}}");
        $("#titulos_instructor").val("{{$perfil->titulos_instructor}}");
        $("#invitacion_evento").val("{{$perfil->invitacion_evento}}");
        $("#organizador").val("{{$perfil->organizador}}");
        $("#tiempo_experiencia_bailador").val("{{$perfil->tiempo_experiencia_bailador}}");
        $("#genero_bailador").val("{{$perfil->genero_bailador}}");
        $("#participacion_coreografia").val("{{$perfil->participacion_coreografia}}");
        $("#montajes").val("{{$perfil->montajes}}");
        $("#titulos_bailador").val("{{$perfil->titulos_bailador}}");
        $("#participacion_escenario").val("{{$perfil->participacion_escenario}}");
   
      
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
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                        } 

                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
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
      var campo = ["tiempo_experiencia_instructor", "genero_instructor", "cantidad_horas", "titulos_instructor", "invitacion_evento", "organizador", "tiempo_experiencia_bailador", "genero_bailador", "participacion_coreografia", "montajes", "titulos_bailador", "participacion_escenario"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["tiempo_experiencia_instructor", "genero_instructor", "cantidad_horas", "titulos_instructor", "invitacion_evento", "organizador", "tiempo_experiencia_bailador", "genero_bailador", "participacion_coreografia", "montajes", "titulos_bailador", "participacion_escenario"];
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
        scrollTop: $("#id-perfil_instructor").offset().top-90,
        }, 1000);
      });


</script> 
@stop

