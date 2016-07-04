
@extends('layout.master')
 
<div class="myback2">
@section('css')
<link href="{{url('/')}}/assets/css/habana.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/vaquero.css" rel="stylesheet">
@stop

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
@stop
@section('content')


            <div class="modal fade" id="modalDios" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                   <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                     <h4 class="modal-title c-negro"> <h4>
                      <div class="iconox-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                          <title>Confirma tu academia</title>
                          <circle fill="#692A5A" cx="16" cy="16" r="16"/>
                            <img src="{{url('/')}}/assets/img/icono_easydance2.png"  height="26" width="28" style="margin-top: -30px; margin-left: 3px;"/></svg>
                            </div>Sección no permitida </h4> <!-- <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> --></h4>
                            </div>
                                  
                            <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">

                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x text-success"></i></div>
                              <div class="c-morado f-40 text-center"> ¡Dios mioooooo! </div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="text-center f-20">Hemos detectado que deseas crear un registro sin haber personalizado tu academia</div>
                              <div class="text-center f-20">No te preocupes te ayudaremos a personalizar tu academia</div>

                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              
                              <div align="center">
                              <button type="submit" class="butp button5" onclick="configuracion()">Quiero personalizar mi academia</button>
                              <button type="submit" class="but2 button55" onclick="atras()"><span>En otro momento</span></button><br><br><br>
                              </div>
                              

                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>

                            </div>
                            <div class="col-md-2"></div>


                    
                            </div>
                            </div>
                            </div>
                    </div>
                </div>



<div style="margin-top: -50px;">
<!-- <div class="i-numbers i-visibility myback" ><br><br>
<div class="i-hiw-header f-25" >Recauda dinero creando  una campaña. </div>
</div> -->
</div>
<div id="what_we_do" class="i-stage myback2">
<br><br><br>
<div class="clearfix p-b-15"></div>

  <div class="i-stage-dream-header">
    <div class="f-700 f-25 text-center">A través de la plataforma Easy dance, podrás generar y  recaudar fondos.</div>
    <br>

    <div class="opaco-0-8 f-22 text-center">Para el crecimiento económico de tu academia.</div>
  </div>
  <br><br><br>
<text Style="margin-left:280px; auto; ">Piénsalo</text>
<text Style="margin-left:330px; auto;">Despega</text>
<text Style="margin-left:328px; auto;">Difúndelo</text>
<div style="margin-top: -40px;">
<img style="display:block; height:40px; width:800px; margin:60px auto 0; background-repeat:no-repeat;"  src="{{url('/')}}/assets/img/menu-/d36.png"  />
</div>
  <div class="i-stage-dream-header" Style="margin-top:100px;">
    
    <div class="opaco-0-8 f-22 text-center">Te ayudaremos en cada paso que des para recaudar los fondos económicos que necesites</div>

  </div>
  <div align="center" Style="margin-top:100px;">
<button data-ripplecator type="button" class="ripple-btn light-ripples f-22" onclick="campaña()">Empezar una campaña </button>

</div>
</div>

<div id="what_we_do" class="i-tools">
  <p class="c-negro f-700 f-30 text-center">Clases grupales</p> 

  <p class="c-negro f-700 f-22 text-center"> Organiza tus clases de baile y cuéntales a todos de tus nuevos horarios.</p>
</div>

<div class="i-stage myback2">

  <!-- <div class="i-tools-container"> -->
	<!-- <div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"   Style="" src="{{url('/')}}/assets/img/card/Vaquero.png">
    </div> -->
	<!-- <div class="i-img-material "> -->
   <!-- <img class="materialboxed i-img-cuadro z-depth-1" -->
   <div class="col-sm-5">
   </div>
   <div class="col-sm-2">
   <i class="flaticon flaticon-cowboy-on-desert f-150 text-center"></i>

   </div>
   <div class="col-sm-5">
   </div>
   <div class="clearfix p-b-35"></div>

  <div class="col-sm-3">
   </div>
   <div class="col-sm-6">
   <p class="i-hiw-header">¡ Heyy vaquero! esto parece un desierto. Empieza agregar clases, o tus alumnos te lanzarán flechas</p>

   </div>
   <div class="col-sm-3">
   </div>
   <br></br>
   
   

	  <!-- <img class="" style="max-height: 300px; max-width: 300px; "    src="{{url('/')}}/assets/img/card/Vaquero.png"> -->
    <!-- </div> -->
<!-- <div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/Vaquero.png">
    </div> -->
<!-- </div> -->
  <div align="center" Style="margin-top:100px;">

<button data-ripplecator type="button" class="ripple-btn light-ripples f-22" id="clase" name="clase" onclick="clase()">Agregar  clases grupales </button>

<!-- <a class="btn-blanco m-r-5 f-22" href="{{url('/')}}/agendar/clases-grupales/agregar" id="guardar">  Agregar  clases grupales</a> -->
</div>
<br>

</div>
<!-- <div id="what_we_do" class="i-stage myback2">
<br><br><br>
  <div class="i-stage-dream-header">
    <div class="i-hiw-header">Tips gerenciales</div>
    <div class="i-hiw-header">“Herramientas para mejorar la organización  de tu academia”</div>
  </div>
</div>
<div class="i-tools myback2" style="margin-top: -70px;">
  <div class="i-tools-container">
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="/../easy-dance-proyect/public/assets/img/card/fedora.png">
    </div>
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="/../easy-dance-proyect/public/assets/img/card/gaggle.jpg">
    </div>
<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="/../easy-dance-proyect/public/assets/img/card/caliber.png">
    </div>
</div>
<div align="center" Style="margin-top:100px;">
<button class="btn-blanco2" >Ver más </button>
</div>
</div> -->
<div id="what_we_do" class="i-stage myback">
<br><br><br>
  <div class="i-stage-dream-header ">
    <div class="i-hiw-header">''HAZTE PARTE DE NUESTRO GRAN EQUIPO DE EMBAJADORES''</div>
     </div>
<div class="i-tools myback" style="margin-top: -40px;">
  <div class="i-tools-container">
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/absurdoburger.jpg">
    </div>
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/rdxsports.png">
    </div>
<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/straphq.png">
    </div>
</div>
  <div class="i-tools-container">
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/ocloud.png">
    </div>
	<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/makoframework.png">
    </div>
<div class="i-img-material ">
	  <img class="materialboxed i-img-cuadro z-depth-1"    src="{{url('/')}}/assets/img/card/simplebooklet.jpg">
    </div>
</div>
</div>
  <div align="center" Style="margin-top:20px;">
<button data-ripplecator type="button" class="ripple-btn light-ripples f-22" id="embajadores" name="embajadores" onclick="embajadores()" >YO QUIERO  </button>
</div>
</div>
<div class="i-tools myback2">
   <div class="i-stage-dream-header">
    <div class="i-hiw-header2">CONCURSO PARA LAS ACADEMIAS DE BAILE  MÁS DESTACADAS</div>
   <div class="i-hiw-header2"> EN LATINO AMÉRICA  </div>
     <div class="titulotests" align="center" style="margin-top: 70px;">¡Al ser un usuario activo en Easy Dance ya participas en el evento!</div>
	 <p  class="spantest"  align="center" style="margin-top: 5px;"> Las diez  (10) academias  de baile  con el mayor crecimiento en el año 2016 en los tópicos de  proyección, crecimiento  </p>
	  <p class="spantest" align="center" style="margin-top: -19px;" > económico  y organización gerencial, serán premiadas con el reconocimiento anual  llamado “LATAM SIN BARRERAS”. </p>
  </div>
  <br><br><br>
  <div class="i-tools-container">
  <div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="text-center">
      <i class="icon_d-concurso f-45"></i>
      </div>
      <div class="i-tools-svg">Concurso</div>
      <div class="clearfix p-b-15"></div>
      <div>
        <div class="i-tools-description ng-binding">El primer y único evento competitivo de gerencia para academias de baile en LATAM, participa y demuestra que tan grande es tu crecimiento.</div>
      </div>
    </div><div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="text-center">
      <i class="icon_d-premio f-45"></i>
      </div>
      <div class="i-tools-svg">Premios</div>
      <div class="clearfix p-b-15"></div>
      <div>
        <div class="i-tools-description ng-binding">Recibe grandes beneficios para el crecimiento de tu academia ,tales como , prestigioso, proyección , membrecías y premios económicos </div>
      </div>
    </div><div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="text-center">
      <i class="icon_d-objetivo f-45"></i>
      </div>
      <div class="i-tools-svg">Objetivos </div>
      <div class="clearfix p-b-15"></div>
      <div>
        <div class="i-tools-description ng-binding">Promover e incrementar  el nivel gerencial , organizacional  y de crecimiento económico para las academias de baile en Latinoamérica </div>
      </div>
</div>
</div>
  <div align="center" Style="margin-top:100px;">
<!--  <a class="i-cta-1 i-button" href="">Conocer  más</a> -->
 <button data-ripplecator type="button" class="ripple-btn light-ripples f-22" onclick="latam()">Conocer  más</button>

</div>
</div>

@stop

@include('layout.footer')

@section('js') 
<script>


     function campaña(){
      window.location = "{{url('/')}}/especiales/campañas/agregar";
     }
     function clase(){
      window.location = "{{url('/')}}/agendar/clases-grupales/agregar";
     }
     function embajadores(){
      window.location = "{{url('/')}}/empresa/embajadores";
     }
     function latam(){
      window.location = "{{url('/')}}/latam";
     }

     $("#guardar").click(function(){

                var route = "{{url('/')}}/configuracion/academia/primerpaso";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#configurarAcademia" ).serialize(); 
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

                          window.location = "{{url('/')}}/listo";

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
                  var campo = ["nombre", "especialidad_id", "pais_id", "estado"];
                    fLen = campo.length;
                    for (i = 0; i < fLen; i++) {
                        $("#error-"+campo[i]+"_mensaje").html('');
                    }
                  }

                  function errores(merror){
                  var campo = ["nombre", "especialidad_id", "pais_id", "estado"];
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

                  // $('html,body').animate({
                  //       scrollTop: $("#id-"+elemento).offset().top-90,
                  // }, 1500);          

              }

           function configuracion(){
            procesando();
            window.location = "{{url('/')}}/configuracion";
            }
           
           function atras(){
            $('#modalDios').modal('hide');
           }

	  </script>
		
	</div>			
@stop