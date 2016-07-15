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
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Alumno</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_a-alumnos f-25"></i> Agregar Alumno</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_alumno" id="agregar_alumno"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="identificacion" id="id-identificacion">Id - Pasaporte</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de cédula o pasaporte del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="identificacion" id="identificacion" data-mask="0000000000" placeholder="Ej: 16133223">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-identificacion">
                                      <span >
                                          <small class="help-block error-span" id="error-identificacion_mensaje" ></small>                        
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-nombre">Nombre</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nombre del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-apellido">Apellido</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el apellido del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-nombres f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="apellido" id="apellido" placeholder="Ej. Zambrano">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>
                               <div class="col-sm-12">
                                    
                                      <label for="fecha_nacimiento" id="id-fecha_nacimiento">Fecha de Nacimiento</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la fecha de nacimiento del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-calendar-check f-22"></i></span>
                                      <div class="dtp-container fg-line">
                                              <input name="fecha_nacimiento" id="fecha_nacimiento" class="form-control date-picker proceso pointer" placeholder="Selecciona" type="text">
                                          </div>

                                    </div>
                                    <div class="has-error" id="error-fecha_nacimiento">
                                        <span >
                                            <small class="help-block error-span" id="error-fecha_nacimiento_mensaje" ></small>                                           
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-sexo">Sexo</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el sexo del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-sexo f-22"></i></span>
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">

                               <label for="apellido" id="id-correo">Correo Electrónico</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el correo electrónico del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_a icon_a-correo f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="correo" id="correo" placeholder="Ej. easydance@gmail.com">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               
                              <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-celular">Teléfono Móvil</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número del teléfono movil del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="celular" id="celular" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                                <div class="col-sm-12">

                                <label for="apellido" id="id-telefono">Teléfono Local</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número del teléfono local del participante" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_b icon_b-telefono f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm input-mask" name="telefono" id="telefono" data-mask="(000)000-0000" placeholder="Ej: (426)367-0894">
                                      </div>
                                    </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="direccion" id="id-direccion">Dirección</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la dirección del participante" title="" data-original-title="Ayuda"></i>
                                      <div class="input-group">
                                      <span class="input-group-addon"><i class="zmdi zmdi-pin-drop zmdi-hc-fw f-22"></i></span>
                                      <div class="fg-line">
                                      <input type="text" class="form-control input-sm proceso" name="direccion" id="direccion" placeholder="Calle santa marta, Av 23" maxlength="180" onkeyup="countChar(this)">
                                      </div>
                                     <div class="opaco-0-8 text-right">Resta <span id="charNum">180</span> Caracteres</div>
                                    </div>
                                 <div class="has-error" id="error-direccion">
                                      <span >
                                          <small class="help-block error-span" id="error-direccion_mensaje" ></small>                                
                                      </span>
                                  </div>
                                </div>
                              </div>
                               

                               <div class="clearfix p-b-35"></div>
  
                              <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre" id="id-ficha">Ficha Médica</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa los datos o estado de salud del participante" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                      <div class="panel-body">
                                      

                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Alergia</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">
                                      
                                      <input type="text" id="alergia" name="alergia" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="alergia-switch" type="checkbox" hidden="hidden">
                                          <label for="alergia-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>




                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Asma</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="asma" name="asma" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="asma-switch" type="checkbox" hidden="hidden">
                                          <label for="asma-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Convulsiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="convulsiones" name="convulsiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="convulsiones-switch" type="checkbox" hidden="hidden">
                                          <label for="convulsiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Cefalea</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="cefalea" name="cefalea" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="cefalea-switch" type="checkbox" hidden="hidden">
                                          <label for="cefalea-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Hipertensión</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="hipertension" name="hipertension" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="hipertension-switch" type="checkbox" hidden="hidden">
                                          <label for="hipertension-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>


                                       <div class="col-sm-3 text-left">

                                      <span class="f-20 f-700">Lesiones</span> <i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i>

                                      </div>
                                      
                                      <div class="col-sm-3 text-left">

                                      <input type="text" id="lesiones" name="lesiones" value="" hidden="hidden">
                                      <div class="toggle-switch" data-ts-color="purple">
                                          <span class="p-r-10 f-700 f-16">No</span><input id="lesiones-switch" type="checkbox" hidden="hidden">
                                          <label for="lesiones-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                      </div>
                                      </div>

                                      <div class="clearfix p-b-35"></div>
                                      <div class="clearfix p-b-35"></div>
                                      
                                      <div class="clearfix p-b-35"></div>

                                      <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>

                                      <div class="clearfix p-b-35"></div>
                                      <hr></hr>



                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                 </div>
                               </div>

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

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/participante/alumno/agregar";
  route_enhorabuena="{{url('/')}}/participante/alumno/enhorabuena/";
  
  $(document).ready(function(){


      $('#nombre').mask('AAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z]/}
        }

      });

      $('#apellido').mask('AAAAAAAAAAAAAA', {'translation': {

        A: {pattern: /[A-Za-z]/}
        }

      });

      
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

        document.getElementById("identificacion").focus();

      });

  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "telefono", "celular", "correo", "direccion"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }
    //$("#barra-progreso").s

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

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_alumno" ).serialize();

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
                          // finprocesado();
                          // var nType = 'success';
                          // $("#agregar_alumno")[0].reset();
                          // var nTitle="Ups! ";
                          // var nMensaje=respuesta.mensaje;
                          window.location = route_enhorabuena + respuesta.id;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
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

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      $('#collapseTwo').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#collapseDireccion').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseDireccion').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

       $( "#cancelar" ).click(function() {
        $("#agregar_alumno")[0].reset();
        limpiarMensaje();
        $('html,body').animate({
        scrollTop: $("#id-identificacion").offset().top-90,
        }, 1000);
        document.getElementById("identificacion").focus();
      });

    function addFieldText(newLat, newLng){
      $('#coord').val(newLat+', '+newLng);
    }

      $("#alergia-switch").on('change', function(){
          if ($("#alergia-switch").is(":checked")){
            $("#alergia").val('1');
          }else{
            $("#alergia").val('0');
          }     
        });

      $("#asma-switch").on('change', function(){
          if ($("#asma-switch").is(":checked")){
            $("#asma").val('1');
          }else{
            $("#asma").val('0');
          }     
        });

      $("#convulsiones-switch").on('change', function(){
          if ($("#convulsiones-switch").is(":checked")){
            $("#convulsiones").val('1');
          }else{
            $("#convulsiones").val('0');
          }     
        });

      $("#cefalea-switch").on('change', function(){
          if ($("#cefalea-switch").is(":checked")){
            $("#cefalea").val('1');
          }else{
            $("#cefalea").val('0');
          }     
        });

      $("#lesiones-switch").on('change', function(){
          if ($("#lesiones-switch").is(":checked")){
            $("#lesiones").val('1');
          }else{
            $("#lesiones").val('0');
          }     
        });

      $("#hipertension-switch").on('change', function(){
          if ($("#hipertension-switch").is(":checked")){
            $("#hipertension").val('1');
          }else{
            $("#hipertension").val('0');
          }     
        });


    function countChar(val) {
        var len = val.value.length;
        if (len >= 180) {
          val.value = val.value.substring(0, 180);
        } else {
          $('#charNum').text(180 - len);
        }
      };

</script> 
@stop

