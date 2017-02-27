@extends('layout.master')

@section('css_vendor')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/easy_dance_ico_0.css" />
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/easy_dance_ico_1.css" />
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
<style type="text/css">
  body {
    background-color: #FFFFFF !important;
  }
</style>
@stop

@section('js_vendor')
  

  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery.iconmenu.js"></script>
  <script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
  <script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop

@section('content')
  <!-- ENHORABUENA -->
<div class="myback2" style="margin-top:-30px;" >


<a href="{{url('/')}}/agendar" class="btn bgm-blue btn-float waves-effect m-btn" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="" title="" data-original-title="Calendario"><i class="zmdi zmdi-calendar"></i></a>

<section id="content">
    
    <!--<div class="container">-->
      <div class="card">
        <div class="clearfix m-0 m-b-25"></div>
        
        <div class="card-header">
            
            <div class="col-sm-12">
              
                                    <div role="tabpanel" class="tab">

                                    <div class="text-center">
                                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul">
                                           
                                            <li class="active"><a href="#participantes" class="azul" aria-controls="participantes" role="tab" data-toggle="tab"><div class="icon_a icon_a-participantes f-30" style="color:#2196f3;  " ></div><p style=" margin-bottom: -2px ; color:#2196f3;">Participantes</p></a></li>
                                            
                                            <li role="presentation" name="agendar"><a class="amarillo" href="#agendar" aria-controls="agendar" role="tab" data-toggle="tab"><div class="icon_a icon_a-agendar f-30" style="color:#FFD700;  " ></div><p style=" margin-bottom: -2px; color:#FFD700;">Agendar</p></a></li>
                                            
                                            <li role="presentation"><a href="#especiales" class="rosa" aria-controls="especiales" role="tab" data-toggle="tab"><div class="icon_a icon_a-especiales f-30" style="color:#e91e63;  " ></div><p style=" margin-bottom: -2px; color:#e91e63;">Especiales</p></a></li>
                                           
                                            <!-- <li role="presentation"><a class="gris" href="{{url('/')}}/invitar" aria-controls="invitar" ><div class="icon_d-invitar f-30" style="color:#b4a9a4; " ></div><p style=" margin-bottom: -2px; color:#b4a9a4;">Invitar</p></a></li> -->
                                            
                                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta"><div class="icon_a icon_a-punto-de-venta f-30" style="color:#4caf50;  "></div><p style=" margin-bottom: -2px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                                            <li role="presentation"><a class="rojo" href="{{url('/')}}/reportes"  aria-controls="reportes" role="tab"><div class="icon_a icon_a-reservaciones f-30" style="color:#f44336;  "></div><p style=" margin-bottom: -2px; color:#f44336;">Reportes</p></a></li>
                                        </ul>
                                      </div>
                                        <div class="tab-content ">
                     
                                        <div role="tabpanel" class="tab-pane  animated active fadeInRight in" id="participantes">
                    
                    <div class="text-center icon_a icon_a-participantes f-40" style="color:#2196f3;  margin-bottom: -20px;"><p class="f-18">Gestiona el tipo de participante que desees </p></div>
                                    <ul id="sti-menu" class="sti-menu roww">
                               
                    <li data-hovercolor="#2196f3"><a href="{{url('/')}}/participante/alumno"><h2 data-type="mText" class="sti-item">Alumno </h2><span data-type="icon" class="sti-icon sti-icon-alumno sti-item"></span></a></li>
                              
                      <li data-hovercolor="#2196f3"><a href="{{url('/')}}/participante/instructor"><h2 data-type="mText" class="sti-item" align="center">Instructor </h2><span data-type="icon" class="sti-icon sti-icon-instructores sti-item"></span></a></li>
                               
                      <li data-hovercolor="#2196f3"><a href="{{url('/')}}/participante/visitante"><h2 data-type="mText" class="sti-item ">Visitante Presencial </h2><span data-type="icon" class="sti-icon sti-icon-visitantes sti-item"></span></a></li>
      
                                  <li data-hovercolor="#2196f3"><a a href="{{url('/')}}/participante/familia"><h2 data-type="mText" class="sti-item">Familia </h2><span data-type="icon" class="sti-icon sti-icon-family sti-item"></span></a></li>
                    
                    </ul>
                    
                                        </div>
                    
                    
                                         <div role="tabpanel" class="tab-pane  animated fadeInRight" name="agendar" style="!important;" id="agendar">
        
                                       <div class="text-center icon_a icon_a-agendar f-40" style="color:#FFD700;  margin-bottom: -20px;"><p class="f-18">Agendar</p></div>
                                  
                                         <ul id="sti-menu2" class="sti-menu roww">
                     
                                 <li data-hovercolor="#FFEB3B"> <a href="{{url('/')}}/agendar/clases-grupales"><h2 data-type="mText" class="sti-item">Clases Grupales </h2><span data-type="icon" class="sti-icon sti-icon-clases-grupales sti-item"></span></a></li>
                     
                     <li data-hovercolor="#FFEB3B"><a href="{{url('/')}}/agendar/clases-personalizadas"><h2 data-type="mText" class="sti-item">Clase Personalizada</h2><span data-type="icon" class="sti-icon sti-icon-clase_p sti-item"></span></a></li>
        
                                 <li data-hovercolor="#FFEB3B"><a href="{{url('/')}}/agendar/fiestas"><h2 data-type="mText" class="sti-item">Fiesta Eventos </h2><span data-type="icon" class="sti-icon sti-icon-fiesta_eventos sti-item"></span></a></li>
        
                                 <li data-hovercolor="#FFEB3B"><a href="{{url('/')}}/agendar/talleres"><h2 data-type="mText" class="sti-item">Talleres </h2><span data-type="icon" class="sti-icon sti-icon-talleres sti-item"></span></a></li>
                                        
                    </ul>


                      </div>
                                         <div role="tabpanel" class="tab-pane  animated fadeInRight" id="especiales">
                      <div class="text-center">
                      <div class="text-center icon_a icon_a-especiales f-40" style="color:#e91e63;  margin-bottom: -20px;"><p class="f-18">Especiales</p></div>
                                  
                        <ul id="sti-menu3" class="sti-menu roww">
                    
                          <li data-hovercolor="#e91e63"><a href="{{url('/')}}/especiales/regalos"><h2 data-type="mText" class="sti-item">Tarjeta de Regalo </h2><span data-type="icon" class="sti-icon sti-icon-tjregalo sti-item"></span></a></li>
          
                          <li data-hovercolor="#e91e63"><a href="{{url('/')}}/especiales/campañas"><h2 data-type="mText" class="sti-item">Campaña</h2><span data-type="icon" class="sti-icon sti-icon-campana sti-item"></span></a></li>
                    
                          <li data-hovercolor="#e91e63"><a href="{{url('/')}}/especiales/promociones"><h2 data-type="mText" class="sti-item">Promocion </h2><span data-type="icon" class="sti-icon sti-icon-promocion sti-item"></span></a></li>
      
                          <li data-hovercolor="#e91e63"><a data-toggle="modal" href="{{url('/')}}/especiales/examenes""><h2 data-type="mText" class="sti-item">Valoración</h2><span data-type="icon" class="sti-icon sti-icon-cexamen sti-item"></span></a></li>
      
                        </ul>
                       </div></div>
                       
                       
                                            <div role="tabpanel" class="tab-pane animated fadeInRight" id="validar">
                    <div class="text-center icon_a icon_a-checador f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Validar</p></div>
                                    
                                        <ul id="sti-menu4" class="sti-menu roww">    
                         
                               <p>Morbi mattis ullamcorper velit. Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus.</p>
                                  </ul>

                      </div>
                      
                      
                                        <div role="tabpanel" class="tab-pane animated fadeInRight" id="punto_venta">
                      
                      <div class="text-center icon_a icon_a-punto-de-venta f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Punto de Venta</p></div>
                                    <ul id="sti-menu5" class="sti-menu roww">

                               <p>Morbi mattis ullamcorper velit. Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus.</p>
                                  </ul>
                  
                      
                      
                                               
                      
                    </div>
                                            <div role="tabpanel" class="tab-pane animated fadeInRight" id="reportes">
                      
                      <div class="text-center icon_a icon_a-reservaciones f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Reportes</p></div>
                      
                      
                      <ul id="sti-menu6" class="sti-menu roww">

                        <li data-hovercolor="#f44336"><a href="{{url('/')}}/reportes/diagnosticos"><h2 data-type="mText" class="sti-item">Diagnosticos</h2><span data-type="icon" class="sti-icon sti-icon-reportes1 sti-item"></span></a></li>
                        
                        
                        <li data-hovercolor="#f44336"><a href="{{url('/')}}/reportes/presenciales"><h2 data-type="mText" class="sti-item">Presenciales</h2><span data-type="icon" class="sti-icon sti-icon-reportes2 sti-item"></span></a></li>
                        
                        <!-- <li data-hovercolor="#f44336"><a href="{{url('/')}}/reportes/contactos"><h2 data-type="mText" class="sti-item">Guía de contactos </h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a></li> -->

                        <li data-hovercolor="#f44336"><a href="{{url('/')}}/reportes/promotores"><h2 data-type="mText" class="sti-item">Promotores</h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a></li>

                        <li data-hovercolor="#f44336"><a data-toggle="modal" href="{{url('/')}}/reportes/estatus_alumnos"><h2 data-type="mText" class="sti-item">Estatus de alumnos</h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a></li>

                      </ul>

                      </div>
                                    </div>
                                </div>
                            </div>
            
        </div>
        <div class="card-body">

            
           
         <div class="clearfix"></div>  
        </div>
      <div class="clearfix m-20 m-b-25"></div>
      </div>
      
      <!--<div class="clearfix"></div>-->

    <!--</div>-->

    </div>
    </section>


@stop


@section('js') 


  <script type="text/javascript">

    $(document).ready(function(){

      $('a[data-toggle="tab"]').click( function (e) {
        //console.log(e.currentTarget.attributes.href);
          var tabs = e.currentTarget.hash;

          if(tabs == '#participantes'){
            $('[data-menu-color]').attr('data-menu-color', 'azul');
          }
          if(tabs == '#agendar'){
            $('[data-menu-color]').attr('data-menu-color', 'amarillo');
          }
          if(tabs == '#especiales'){
            $('[data-menu-color]').attr('data-menu-color', 'morado');
          }
          if(tabs == '#validar'){
            $('[data-menu-color]').attr('data-menu-color', 'naranja');
          }       
          if(tabs == '#punto_venta'){
            $('[data-menu-color]').attr('data-menu-color', 'verde');
          }       
          if(tabs == '#reportes'){
            $('[data-menu-color]').attr('data-menu-color', 'rojo');
          }       
          //console.log(menuLen);
      });

          $('div.tab-pane').each(function () {
              $(this).addClass("active");
          });

          $('.sti-menu').iconmenu({
              animMouseenter: {
                  'mText': {speed: 500, easing: 'easeOutExpo', delay: 200, dir: -1},
                  'sText': {speed: 500, easing: 'easeOutExpo', delay: 200, dir: -1},
                  'icon': {speed: 700, easing: 'easeOutBounce', delay: 0, dir: 1}
              },
              animMouseleave: {
                  'mText': {speed: 400, easing: 'easeInExpo', delay: 0, dir: -1},
                  'sText': {speed: 400, easing: 'easeInExpo', delay: 0, dir: 1},
                  'icon': {speed: 400, easing: 'easeInExpo', delay: 0, dir: -1}
              }
          });
          $('div.tab-pane').each(function () {
              $(this).removeClass("active");
          });

          $("div.tab-pane").first().addClass("active");

    //  var result = "";
    //  var tmp = result.split('/');
    //  var route = tmp[3];

    //  console.log(route);

    //  // $('a[href="#' + route + '"]').click()

    //  $('a[href="#' + route + '"]').trigger('click');


    // });

    // $( "body" ).click(function( event ) {
    //  console.log(event.target);
    });

      $(function () {

        
      });
  </script>
@stop