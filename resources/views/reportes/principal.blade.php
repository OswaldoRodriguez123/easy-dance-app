@extends('layout.master')

@section('css_vendor')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
@stop

@section('js_vendor')
  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery.iconmenu.js"></script>
@stop

@section('content')

  <section id="content">
    <div class="container">
 <!--      <div class="block-header">
          <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

              <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                              
              <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                              
              <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                              
              <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                             
              <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
              
          </ul>
      </div> 
         -->
      <div class="card">
        <div class="card-body text-center">
          <div class="col-sm-12">
            <div role="tabpanel" class="tab">
                <ul class="tab-nav tab-menu" role="tablist" data-menu-color="naranja">
                  <li role="presentation"><a href="#modalParticipantes" class="azul" aria-controls="participantes" role="tab" data-toggle="modal"><div class="icon_a icon_a-participantes f-30" style="color:#2196f3;  " ></div><p style=" margin-bottom: -2px ; color:#2196f3;">Participantes</p></a></li>
                  
                  <li role="presentation" name="agendar"><a href="#modalAgendar" class="amarillo" href="#agendar" aria-controls="agendar" role="tab" data-toggle="modal"><div class="icon_a icon_a-agendar f-30" style="color:#FFD700;  " ></div><p style=" margin-bottom: -2px; color:#FFD700;">Agendar</p></a></li>
                  
                  <li role="presentation"><a href="#modalEspeciales" class="rosa" aria-controls="especiales" role="tab" data-toggle="modal"><div class="icon_a icon_a-especiales f-30" style="color:#e91e63;  " ></div><p style=" margin-bottom: -2px; color:#e91e63;">Especiales</p></a></li>
                 
                  
                  <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta"><div class="icon_a icon_a-punto-de-venta f-30" style="color:#4caf50;  "></div><p style=" margin-bottom: -2px; color:#4caf50;">Punto de Venta</p></a></li>
                 
                  <li class="active" role="presentation"><a class="rojo" href="{{url('/')}}/reportes" aria-controls="reportes" role="tab"><div class="icon_a icon_a-reservaciones f-30" style="color:#f44336;  "></div><p style=" margin-bottom: -2px; color:#f44336;">Reportes</p></a></li>   
                </ul>
            </div>
            <div class="tab-content ">
              <div role="tabpanel" class="tab-pane  animated active fadeInRight in" id="reportes">
                <div id="id-reporte" class="text-center icon_a icon_a-reservaciones f-40" style="color:#f44336;  margin-bottom: -20px;"><p class="f-18">Reportes</p></div>
                <ul id="sti-menu"  class="sti-menu">
                  <li data-hovercolor="#f44336">
                      <a href="{{url('/')}}/reportes/asistencias"><h2 data-type="mText" class="sti-item">Asistencias</h2><span data-type="icon" class="sti-icon sti-icon-reportes5 sti-item"></span></a>
                  </li>
                  <li data-hovercolor="#f44336">
                      <a href="{{url('/')}}/reportes/diagnosticos"><h2 data-type="mText" class="sti-item">Valoración</h2><span data-type="icon" class="sti-icon sti-icon-reportes8 sti-item"></span></a>
                  </li>    
                  <li data-hovercolor="#f44336">
                      <a href="{{url('/')}}/reportes/presenciales"><h2 data-type="mText" class="sti-item">Presenciales </h2><span data-type="icon" class="sti-icon sti-icon-reportes2 sti-item"></span></a>
                  </li>
                  <li data-hovercolor="#f44336">
                      <a data-toggle="modal" href="{{url('/')}}/reportes/estatus-alumnos"><h2 data-type="mText" class="sti-item">Estatus de alumnos</h2><span data-type="icon" class="sti-icon sti-icon-reportes4 sti-item"></span></a>
                  </li>

                  <div class="clearfix"></div>

                  <li data-hovercolor="#f44336">
                    <a href="{{url('/')}}/reportes/inscritos"><h2 data-type="mText" class="sti-item">Inscritos</h2><span data-type="icon" class="sti-icon sti-icon-reportes1 sti-item"></span></a>
                  </li>
                  <li data-hovercolor="#f44336">
                      <a href="{{url('/')}}/reportes/camisetas-programacion"><h2 data-type="mText" class="sti-item">Camisetas y Programación </h2><span data-type="icon" class="sti-icon sti-icon-reportes6 sti-item"></span></a>
                  </li>    
                  <li data-hovercolor="#f44336">
                      <a href="{{url('/')}}/reportes/referidos"><h2 data-type="mText" class="sti-item">Referidos </h2><span data-type="icon" class="sti-icon sti-icon-reportes9 sti-item"></span></a>
                  </li>
                  <li data-hovercolor="#f44336">
                      <a data-toggle="modal" href="{{url('/')}}/reportes/reservaciones"><h2 data-type="mText" class="sti-item">Reservaciones</h2><span data-type="icon" class="sti-icon sti-icon-reportes3 sti-item"></span></a>
                  </li>

                  <div class="clearfix"></div>

                  <li data-hovercolor="#f44336">
                      <a data-toggle="modal" href="{{url('/')}}/reportes/credenciales"><h2 data-type="mText" class="sti-item">Credenciales</h2><span data-type="icon" class="sti-icon sti-icon-reportes7 sti-item"></span></a>
                  </li>


                  <li data-hovercolor="#f44336">
                      <a data-toggle="modal" href="{{url('/')}}/reportes/administrativo"><h2 data-type="mText" class="sti-item">Administrativo</h2><span data-type="icon" class="sti-icon sti-icon-reportes11 sti-item"></span></a>
                  </li>

                  <li data-hovercolor="#f44336">
                      <a data-toggle="modal" href="{{url('/')}}/reportes/master"><h2 data-type="mText" class="sti-item">Master</h2><span data-type="icon" class="sti-icon sti-icon-reportes10 sti-item"></span></a>
                  </li>
                </ul>
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

    $(document).ready(function(){

      $('body').css('background', "#fff")

      $('a[data-toggle="tab"]').click( function (e) {
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

      setTimeout(function(){ 

      $('html,body').animate({
            scrollTop: $("#id-reporte").offset().top-90,
            }, 1000);

      }, 1000);
    });

  </script>

@stop