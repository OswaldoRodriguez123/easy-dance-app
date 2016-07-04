@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('css')

<link href="{{url('/')}}/assets/css/demo.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/noJS.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/style.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/vaquero.css" rel="stylesheet">

@stop

@section('js')

<script src="{{url('/')}}/assets/js/jquery.hoverdir.js"></script>
<script src="{{url('/')}}/assets/js/modernizr.custom.97074.js"></script>

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
        
        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Premiación <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="text-center">
                        <div class="clearfix p-b-15"></div>
                        <i class="icon_d-premio f-150 opaco-0-8"> </i>

                        <div class="clearfix p-b-15"></div>

                         <span class="f-25 opaco-0-8">¡Próximamente anunciaremos los premios para las 10 academia  ganadoras!</span>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>


                        </div>
                       
                    </div>
                </div>
            </div>


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        
                        <div class="card-body p-b-20">

                        <div class="row p-l-10 p-r-10">

                        <div class="col-sm-5"></div>
                        <div class="col-sm-2"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 130px; max-width: 130px;" class="img-responsive opaco-0-8" alt=""></div>
                        <div class="col-sm-5"></div>

                        <div class="clearfix p-b-15"></div>
                        <div class="text-center">
                            <span class="f-25 c-morado text-center">Hola Oswaldo</span>  
                            <br></br>   
                            <span class="f-25 c-morado">¡Conviértete  en la academia número 1 en Latinoamérica!</span>  
                        </div>

                        <hr></hr>

                        <div class="col-sm-10 col-md-offset-1">

                        <div>
                            <span class="f-20 c-morado">Nuestro principal interés es ayudarte a crecer y que tengas éxito como gerente de tu academia de baile, para alcanzar este objetivo hemos diseñado una competencia internacional de  puntos para monitorizar  tu progreso como gerente y de esa forma puedas optar por la participación de las 10 academias más destacadas en Latinoamérica 
                            Cuanto más progreso tengas en tu academia, puntos ganarás, Easy dance se encargará que  todo el proceso sea automatizado, así que sólo tendrás que  preocuparte por llevar tu organización al éxito.
                          </span>  
                        </div>
                        </div>

                        <div class="clearfix p-b-15"></div>

                        <div class="col-md-offset-2">

                  <ul id="da-thumbs" class="da-thumbs">
                  <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 1- </span> <i class="zmdi zmdi-calendar-check f-100"> </i> <span class="f-40"> Fecha de selección</span>
                            <div><span><p>El evento y selección de las academias más destacadas  se realizará una vez al año en el mes de junio, en el aniversario de la aplicación Easy Dance.</p>
                           <p> Ítems a evaluar (información  que saldrá al pulsar el cursor por las imágenes )</p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 2- </span> <i class="zmdi zmdi-share zmdi-hc-fw f-100"> </i> <span class="f-40">Redes sociales</span>
                            <div><span><p>Seleccionaremos  el buen manejo de las redes sociales , acompañado del ranking de posicionamiento en los motores de búsqueda de Google (SEO)</p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 3- </span> <i class="icon_a-examen f-100"> </i> <span class="f-40">Inscripciones</span>
                            <div><span><p>Mientras más inscripciones  realices al año , obtendrás mayor puntaje</p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 4- </span> <i class="icon_a-campana f-100"> </i> <span class="f-40">Campañas</span>
                            <div><span><p>Optimiza tus campañas y recauda la mayor cantidad de dinero posible , recomendamos realizar un máximo de 3 campañas anuales </p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 5- </span> <i class="icon_a-tarjeta-de-regalo f-100"> </i> <span class="f-40">Giftcard</span>
                            <div><span><p>Haz que clientes puedan ofrecer las tarjetas de regalo  a mayor cantidad de tarjetas , mayor oportunidad de incrementar tu ranking</p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    <div class="col-sm-12 text-center">
                    <li>
                        <a href="http://dribbble.com/shots/505046-Menu">
                            <!-- <img src="{{url('/')}}/assets/img/PEGGY.png" /> -->
                            <span class="f-40"> 6- </span> <i class="zmdi zmdi-ticket-star zmdi-hc-fw f-100"> </i> <span class="f-40">Presencia en perfiles</span>
                            <div><span><p>Nos interesa que te esmeres en la calidad de los diseños e imagen, por tal motivo nuestro equipo de diseño, seleccionará las academias que tengan mejor presencia en páginas web, diseños gráficos y  videos.</p>
                            </span></div>
                        </a>
                    </li>
                    </div>
                    
                </ul>

                <div class="col-sm-12 text-center">

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                    <button class="btn-blanco f-22" data-toggle="modal" href="#modalAgregar" id="clase" name="clase"> Ver premiaciones </button>

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    
                    <span class="f-30 c-morado text-center">¡Suerte y que gane el mejor!</span>
                </div>

                </div>

                        
                            

                          
                            
                        
                    </div>
                </div>
            </div> 

          

    
            </section>

            
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/participante/alumno/agregar";
  route_enhorabuena="{{url('/')}}/participante/alumno/enhorabuena";
  
  $(document).ready(function(){

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
                          window.location = route_enhorabuena;
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

</script> 
@stop

