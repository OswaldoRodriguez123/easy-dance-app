@extends('layout.master')

@section('css_vendor')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
  <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
@stop

@section('js_vendor')
  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="{{url('/')}}/assets/js/jquery.iconmenu.js"></script>
@stop

@section('content')

  <div style="margin-top: -50px;"></div>
  
  <a href="{{url('/')}}/invitar"> <img class="opaco-0-8 img-responsive" src="{{url('/')}}/assets/img/banner_tuclasedebaile.jpg" alt=""></a>

  <a id="scrollup" href="#" class="scroll-top pi-active" style="display: block;"><i class="tam-1-2 fa fa-chevron-up"></i></a>

  <div class="back-blanco p-t-30 p-b-30">

    <div class="row p-60">
      <div class="col-sm-6 vcenter text-center">

        <div class="clearfix m-b-30"></div>
        <div class="clearfix m-b-30"></div>

        <p class="f-25 f-700">Sobre el programa</p>

        <p class="f-20">Líderes en acción es un programa de lealtad colaborativo entre la academia y nuestros alumnos, abierto a cualquier persona natural que participe dentro nuestra academia <b>TU CLASE DE BAILE</b>.</p> 
      </div>

      <div class="col-sm-6 vcenter text-center">
        <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="display:initial;"></img>
      </div>
    </div>
    
    <div class="row p-60 fondo-clouds">
      <div class="col-sm-12 f-20">
        <div class="text-center">
          <p class="f-25 f-700">Beneficios de ser parte del programa líderes en acción</p>
        </div>

        <i class="fa fa-check c-morado"></i>  Podrás participar en las actividades, eventos, capacitaciones y reuniones que organiza la comunidad para reforzar el aprendizaje de todos los involucrados.<br>

        <i class="fa fa-check c-morado"></i>  Podrás canjear nuestros servicios y productos, tales como, clases personalizadas, clases grupales, camisetas y otros servicios que ofrece la academia.<br>

        <i class="fa fa-check c-morado"></i>  Desarrollo del componente de liderazgo, a través de talleres que ayudan al crecimiento del voluntario en este influyente aspecto.<br>

        <i class="fa fa-check c-morado"></i>  Participación activa en las entregas de donaciones, viviendo experiencias en cuanto a logros y métodos, que posteriormente podemos compartir.<br>

        <i class="fa fa-check c-morado"></i>  Establecer alianzas sociales y artísticas con instituciones similares.<br>


        <div class="m-t-30 text-center">
          <a href="{{url('/')}}/lideres-en-accion/empezar" class="btn btn-morado f-22">Empezar</a>
        </div>

      </div>
    </div>

    <div class="row p-60 p-b-30" id="catalogo">
      
        <div class="col-sm-12 text-center">
          <p class="f-30 f-700">Catálogo de puntos</p>
        </div>

      <div class="col-sm-11 col-sm-offset-1 f-20">
        <ul id="sti-menu" class="sti-menu">

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Boletas para eventos
                <br>
                <span class="f-15">35.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_1 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Boletas para fiestas
                <br>
                <span class="f-15">25.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_2 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Camiseta de la academia
                <br>
                <span class="f-15">35.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_3 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Programación de la academia

                <br>
                <span class="f-15">20.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_4 sti-item"></span>
            </a>
          </li>

          <div class="clearfix m-b-30"></div>
          <div class="clearfix m-b-30"></div>
          <div class="clearfix m-b-30"></div>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Talleres especiales
                <br>
                <span class="f-15">45.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_5 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Talleres de liderazgo
                <br>
                <span class="f-15">35.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_6 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                1 Hora de clase personalizada
                <br>
                <span class="f-15">45.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_7 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Clases de repaso

                <br>
                <span class="f-15">20.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_8 sti-item"></span>
            </a>
          </li>

          <div class="clearfix m-b-30"></div>
          <div class="clearfix m-b-30"></div>
          <div class="clearfix m-b-30"></div>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                5 credenciales
                <br>
                <span class="f-15">35.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_9 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                10 credenciales
                <br>
                <span class="f-15">45.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_10 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                20 credenciales
                <br>
                <span class="f-15">55.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_11 sti-item"></span>
            </a>
          </li>

          <li data-hovercolor="#FFF">
            <a class="disabled">
              <h2 data-type="mText" class="sti-item">

                Compra de una tarjeta de regalo

                <br>
                <span class="f-15">20.000</span>

              </h2>
              <span data-type="icon" class="sti-icon sti-icon-lideres_12 sti-item"></span>
            </a>
          </li>

        </ul>
    
      </div>
      <div class="clearfix m-b-30"></div>
      <div class="clearfix m-b-30"></div>
      <div class="clearfix m-b-30"></div>
      <div class="clearfix m-b-30"></div>
    </div>

    <div class="row p-60 fondo-clouds">
      <div class="col-sm-12">

        <div class="text-left">
          <p class="f-700">
            <span class="f-25">¿Cómo obtener puntos?</span> <br>
            <span class="f-22">Nuestros alumnos cuentan con 7 formas de ganar puntos en el programa de líderes en acción</span>
          </p>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="icon_a-alumnos f-50"></i> <span class="f-700">Inscripción</span></span><br>
          <span class="f-22">Al momento de hacerse parte del programa la academia ofrece de bienvenida la cantidad de <b>5.000</b> puntos.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="icon_a-clase-personalizada f-50"></i> <span class="f-700">Referir a un amigo</span></span><br>
          <span class="f-22">Cada participante inscrito en la academia podrá invitar a participar a sus amistades y familiares a través del código de referencia que se le asigna de manera automática, por cada persona inscrita a través del código acumulará <b>25.000</b> puntos.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="icon_a-tarjeta-de-regalo f-50"></i> <span class="f-700">Compra de tarjetas de regalo</span></span><br>
          <span class="f-22"> En nuestra academia ofrecemos a la venta Gift Card (tarjetas de regalo) cada participante que compre una tarjeta de regalo recibirá de manera automática la cantidad de <b>20.000</b> puntos.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="icon_b-fecha-de-nacimiento f-50"></i> <span class="f-700">Regalo de cumpleaños</span></span><br>
          <span class="f-22">Para nosotros es muy importante festejar junto a nuestros alumnos su fecha de cumpleaños, por tal motivo, todo alumno que se encuentre en un estatus activo recibirá en su fecha de cumpleaños un obsequio de parte de la academia de la suma de <b>10.000</b> puntos.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="icon_f-staff f-50"></i> <span class="f-700">Contribuir como logística</span></span><br>
          <span class="f-22">Nuestra organización se encuentra de manera periódica en la organización de actividades, tales como, talleres, eventos, fiestas entre otros, todo participante activo en nuestra academia que desee apoyarnos en las áreas de logísticas para dichas actividades recibirá el beneficio de <b>20.000</b> puntos por una ejecución completa y satisfactoria.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="zmdi zmdi-facebook f-50"></i> <span class="f-700">Invita a tus amigos a través de las redes sociales</span></span><br>
          <span class="f-22">La referencia e invitación a sus amigos en las redes sociales en Tu clase de baile no las tomamos muy en serio, por tal motivo por cada 10 veces que sean compartidas nuestras distintas actividades en las redes sociales en Facebook o twitter, más la invitación hacia sus contactos a invitarlos a seguirnos en nuestras redes sociales, recibirá el beneficio de parte de la academia de <b>10.000</b> puntos.</span>
        </div>

        <br>

        <div class="p-t-10 p-b-10">
          <span class="f-25"><i class="glyphicon glyphicon-book f-50"></i> <span class="f-700">Escribe en nuestro blog</span></span><br>
          <span class="f-22">Invitamos a nuestra comunidad hacerse parte de nuestro equipo de blogueros colaboradores escribiendo sobre experiencias, novedades, actividades, consejos, herramientas, eventos, atuendos, bailarines, Perfiles, entrevistas y artículos de interés del gremio del baile de una manera sencilla y dinámica con artículos que aporten contenidos de valor para nuestro ecosistema en el gremio del baile. Por cada cinco (5) artículos recibirás de <b>10.000</b> puntos, además del beneficio de proyección y reconocimiento público como bloguero de nuestra comunidad</span>
        </div>

      </div>
    </div>

    <div class="row p-t-30 p-b-30  p-l-20 p-r-20">
      <div class="col-sm-6 vcenter text-center p-b-10 p-t-10">
        <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="display:initial;"></img>
      </div>

      <div class="col-sm-6 vcenter text-center">

        <div class="clearfix m-b-30"></div>
        <div class="clearfix m-b-30"></div>

        <p class="f-25 f-700">¿Cómo empiezo?</p>

        <p class="f-20"> 
          Es muy sencillo, sólo debes aceptar <br> el reto y empezar a generar puntos                                           
        </p> 

        <div class="m-t-30 text-center">
          <a href="{{url('/')}}/lideres-en-accion/empezar" class="btn btn-morado f-22">Empezar</a>
        </div>

      </div>
    </div>
  </div> 

  <div style="margin-top: -35px;"></div>
     


@stop

@include('layout.footer')

@section('js') 
            
  <script type="text/javascript">

    $(document).ready(function(){

        ToggleScrollUp();
        $('#scrollup').fadeOut();

        $(window).scroll(function () {
            ToggleScrollUp();
        });

        $('#scrollup').click(function () {
            $("html, body").animate({ scrollTop: 0 }, 2000);
            return false;
        });

        function ToggleScrollUp() {
            if ($("#catalogo").offset().top < $(window).scrollTop()) {
                $('#scrollup').fadeIn();
            } else {
                $('#scrollup').fadeOut();
            }
        }

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
    });

  </script>

@stop

