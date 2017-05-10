@extends('layout.master')

@section('css_vendor')

  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">

@stop

@section('js_vendor')

  <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
  <script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

@stop

@section('content')

@if(Auth::check())
  @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
    <a href="{{url('/')}}/blog/publicar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus" style="margin-top: 25%"></i></a>
  @endif
@endif

<section id="content">
  <div class="container">

  <div class="block-header">
      <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>

      <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

          <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                          
          <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                          
          <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                          
          <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                         
          <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
          
      </ul>
  </div>

  <div class="clearfix"></div>

    <div class="card">
      <div class="card-body p-b-20">
        <div class="row p-l-10 p-r-10">

          <div class="col-sm-9">

           <div class ="entradas">

            @foreach(array_slice($entradas, 0, 10) as $entrada)
              
              <div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                <div style="padding: 10px">

                  <a href="{{$entrada['url']}}" class="f-25 f-700">{{$entrada['titulo']}} 

                  @if(Auth::check())
                    @if($usuario_tipo == 1)
                      @if($entrada['boolean_mostrar'])
                        <i class="zmdi zmdi-check f-15 c-verde"></i>
                      @else
                        <i class="fa fa-hourglass f-15 c-youtube"></i>
                      @endif
                    @endif
                  @endif

                  </a>

                  <p class="f-15 f-400" style="color:#5e5e5e">

                    Creado el {{$entrada['fecha']}} por <b>{{$entrada['nombre']}}</b>

                    @if($entrada['usuario_imagen'])
                        <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/bloggers/{{$entrada['usuario_imagen']}}" alt="">
                      @else
                        <img class="lv-img-sm" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                    @endif

                    &nbsp; &nbsp; <i class="zmdi zmdi-eye"></i> {{$entrada['cantidad_visitas']}}</span> 
                  </p>


                  <div class="row">
                    <div class="col-sm-4 imagen-blog-contenedor">

                      <a href="{{$entrada['url']}}" class="imagen-blog-link">

                        @if($entrada['imagen'])
                          <img class="imagen-blog-img img-responsive" src="{{url('/')}}{{$entrada['imagen']}}" alt="">

                        @else

                          <img class="imagen-blog-img img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">

                        @endif

                        <br>

                      </a>

                    </div>

                    <div class="col-sm-8 contenido">
   
                      {!! $entrada['contenido'] !!}

                      <a href="{{$entrada['url']}}">Ver más</a>

                      @if(Auth::check())
                        @if($usuario_tipo == 1)

                          <a class="btn-blanco bottom-align-text" href="{{url('/')}}/blog/entrada/editar/{{$entrada['id']}}">Editar</a>
                   
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>


            @endforeach

          </div>

          @if(count($entradas) > 10)

            <div class="text-center mostrar_mas">

              <br><br>

              <span class="mostrar f-16 c-morado f-700 pointer">Mostrar más</span>

            </div>
          @endif
                        
           
        </div>

  

        <div class="col-sm-3" style="background: #f8f8f8 ;  min-height: 600px">
          <div style="padding-top:10px;">
            <div class="pmo-block pmo-contact hidden-xs">

                <div class="pmo-block pmo-contact hidden-xs">

                <h2 style="font-size: 16px; margin: 0 0 15px">Tópicos</h2>

                <a class="f-15 f-700" onclick="procesando()" href="{{url('/')}}/blog">Todas ({{$cantidad}})</a><br>

                @foreach($categorias as $categoria)

                  <a class="f-15 f-700" onclick="procesando()" href="{{url('/')}}/blog/categoria/{{$categoria['nombre']}}">{{$categoria['nombre']}} ({{$categoria['cantidad']}})</a><br>

                @endforeach

                <hr class="linea_transparente">

                  <div class="text-center">
                    <span class="recientes_populares c-azul pointer checked" id="recientes">Recientes</span> / <span class="recientes_populares c-negro pointer" id="populares">Populares</span>
                  </div>

                  <br><br>
                  
                  <div id="recientes_populares">

                    @foreach($recientes as $entrada)

                      <div class="row">
                        <div class="col-sm-5">

                          <a onclick="procesando()" href="{{url('/')}}/blog/entrada/{{$entrada['id']}}">

                            @if($entrada['imagen_poster'])
                              <img class="img-responsive" src="{{url('/')}}/assets/uploads/entradas/{{$entrada['imagen_poster']}}" alt="">

                            @else

                              <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">

                            @endif

                            <br>

                          </a>

                        </div>

                        <div class="col-sm-7">
       

                          <a onclick="procesando()" class ="f-15" href="{{url('/')}}/blog/entrada/{{$entrada['id']}}">{{$entrada['titulo']}}</a><br><br>


                        </div>

                      </div>

                    @endforeach

                  </div>

                  <hr class="linea_transparente">

                  <h2 style="font-size: 16px; margin: 0 0 15px">Contacto</h2>

                  <ul>
                    <li><i class="zmdi zmdi-email"></i> <a class ="enlace_gris" href="mailto:{{$academia->correo}}" target="_blank">{{$academia->correo}}</a></li>
                    
                    @if($academia->facebook)
                      @if (!filter_var($academia->facebook, FILTER_VALIDATE_URL) === false) 
                        <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="{{$academia->facebook}}">{{ str_limit($academia->facebook, $limit = 25, $end = '...') }}</a></li>
                      @else
                        <li><i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="https://www.facebook.com/{{$academia->facebook}}">https://www.facebook.com/...</a></li>
                      @endif
                    @endif

                    @if($academia->twitter)

                      @if (!filter_var($academia->twitter, FILTER_VALIDATE_URL) === false) 
                        <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="{{$academia->twitter}}">https://www.twitter.com/{{$academia->twitter}}</a></li>
                      @else
                        <li><i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="https://www.twitter.com/{{$academia->twitter}}">@ {{$academia->twitter}}</a></li>
                      @endif
                    @endif

                    @if($academia->instagram)
                      @if (!filter_var($academia->instagram, FILTER_VALIDATE_URL) === false) 
                        <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="{{$academia->instagram}}">{{$academia->instagram}}</a></li>
                      @else
                        <li><i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="https://www.instagram.com/{{$academia->instagram}}">@ {{$academia->instagram}}</a></li>
                      @endif
                    @endif

                    @if($academia->linkedin)
                    <li><i class="zmdi zmdi-linkedin-box"></i> <a class ="enlace_gris" href="{{$academia->linkedin}}">Linkedin</a></li>
                    @endif

                    @if($academia->youtube)
                    <li><i class="zmdi zmdi-collection-video"></i> <a class ="enlace_gris" href="{{$academia->youtube}}">Youtube</a></li>
                    @endif

                    @if($academia->pagina_web)
                    <li><i class="zmdi zmdi-google-earth"></i> <a class ="enlace_gris" href="{{$academia->pagina_web}}">Pagina Web</a></li>
                    @endif

                    @if($academia->direccion)
                    <li>
                        <i class="zmdi zmdi-pin"></i>
                        <address class="m-b-0 ng-binding">
                            {{$academia->direccion}}
                        </address>
                    </li>
                    @endif

                    @if($academia->celular)
                    <li>
                        <i class="icon_b-telefono"></i>
                            {{$academia->celular}} - {{$academia->telefono}}
                    </li>
                    @endif
                  </ul>
                </div>

                <div class="clearfix p-b-15"></div>

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

        var entradas = <?php echo json_encode($entradas);?>;
        var populares = <?php echo json_encode($populares);?>;
        var recientes = <?php echo json_encode($recientes);?>;

        var inicio = 10;
        var final = 13;

        $(document).ready(function(){

          contenidos = $('.contenido p:last');

          $.each(contenidos, function (index, array) {
            $(array).append('<span class="f-15 f-700">...</span>');
          });

        });


        $(document).on( 'click', '.entrada', function () {
          url = $(this).data('url');
          window.location = "{{url('/')}}"+url;
        });

        $(document).on( 'click', '.mostrar', function () {

          $(".mostrar_mas").remove();

          $.each(entradas, function (index, entrada) {

            if(entrada.contador >= inicio && entrada.contador <= final){

            }else{
              return;
            }

            contenido = '';

            if(entrada.imagen){
              imagen = entrada.imagen
            }else
            {
              imagen = "{{url('/')}}/assets/img/EASY_DANCE_3_.jpg"
            }

            if(entrada.usuario_imagen){
              usuario_imagen = "http://"+location.host+entrada.usuario_imagen;
            }      
            else{
              if(entrada.sexo == 'M'){
                usuario_imagen = "http://"+location.host+"/assets/img/profile-pics/4.jpg"
              }else{
                usuario_imagen = "http://"+location.host+"/assets/img/profile-pics/5.jpg"
              }
            }

            if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6){
              if(entrada.boolean_mostrar){
                icono = '<i class="zmdi zmdi-check f-15 c-verde"></i>'
              }
              else{
                icono ='<i class="fa fa-hourglass f-15 c-youtube"></i>'
              }
            }else{
              icono = ''
            }

            if("{{$usuario_tipo}}" == 1 || "{{$usuario_tipo}}" == 5 || "{{$usuario_tipo}}" == 6){
              editar = '<a class="btn-blanco bottom-align-text" href="{{url('/')}}/blog/entrada/editar/'+entrada.id+'">Editar</a>'
            }else{
              editar = ''
            }

            entrada_contenido = stripTags(entrada.contenido)
            entrada_contenido = entrada_contenido.substr(0, 350) + "..."

            contenido += '<div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">'
            contenido += '<div style="padding: 10px">'
            contenido += '<a onclick="procesando()" href="'+entrada.url+'" class="f-25 f-700">'+entrada.titulo+' '+icono+'</a>'
            contenido += '<p class="f-15 f-400" style="color:#5e5e5e">Creado el '+entrada.fecha+' por <b>'+entrada.nombre+' '+entrada.apellido+'</b>'
            contenido += '<img class="lv-img-sm" src="'+usuario_imagen+'" alt=""></p>'
            contenido += '<div class="row">'
            contenido += '<div class="col-sm-4 imagen-blog-contenedor">'
            contenido += '<a onclick="procesando()" href="'+entrada.url+'" class="imagen-blog-link">'
            contenido += '<img class="imagen-blog-img img-responsive" src="'+imagen+'" alt=""></a></div>'
            contenido += '<div class="col-sm-8">'
            contenido += '<p>'+entrada_contenido
            contenido += '</p><a onclick="procesando()" href="'+entrada.url+'">Ver mas</a>'
            contenido +=  editar
            contenido += '</div></div></div></div>'

            $(".entradas").append(contenido)


          });

          inicio = final;
          final = final + 4;

          if(inicio <= entradas.length){

            $(".entradas").append('<div class="text-center mostrar_mas"> <br><br> <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span> </div>');

          }

        });

        function stripTags (html) {
            return html.replace(/(<([^>]+)>)/ig,"");
        };

        $(document).on( 'click', '.recientes_populares', function () {

          if(!$(this).hasClass('checked')){

            $('#recientes_populares').empty();

            if($(this).attr('id') == 'populares'){

              $.each(populares, function (index, entrada) {

                contenido = '';
                url = "http://"+location.host+"/blog/entrada/"+entrada.id;

                if(entrada.imagen_poster){
                  imagen = "http://"+location.host+"/assets/uploads/entradas/"+entrada.imagen_poster;
                }else
                {
                  imagen = "{{url('/')}}/assets/img/EASY_DANCE_3_.jpg"
                }

                contenido += '<div class="row">'
                contenido += '<div class="col-sm-5">'
                contenido += '<a onclick="procesando()" href="'+url+'">'
                contenido += '<img class="img-responsive" src="'+imagen+'" alt=""><br></a></div>'
                contenido += '<div class="col-sm-7">'
                contenido += '<a onclick="procesando()" class ="f-15" href="'+url+'">'+entrada.titulo+'</a><br><br></div></div>'

                $('#recientes_populares').append(contenido)

              });

            }else{

              $.each(recientes, function (index, entrada) {

                contenido = '';
                url = "http://"+location.host+"/blog/entrada/"+entrada.id;

                if(entrada.imagen_poster){
                  imagen = "http://"+location.host+"/assets/uploads/entradas/"+entrada.imagen_poster;
                }else
                {
                  imagen = "{{url('/')}}/assets/img/EASY_DANCE_3_.jpg"
                }

                contenido += '<div class="row">'
                contenido += '<div class="col-sm-5">'
                contenido += '<a onclick="procesando()" href="'+url+'">'
                contenido += '<img class="img-responsive" src="'+imagen+'" alt=""><br></a></div>'
                contenido += '<div class="col-sm-7">'
                contenido += '<a onclick="procesando()" class ="f-15" href="'+url+'">'+entrada.titulo+'</a><br><br></div></div>'
                
                $('#recientes_populares').append(contenido)

              });
            }

            $('.recientes_populares').addClass('c-negro')
            $('.recientes_populares').removeClass('c-azul')
            $('.recientes_populares').removeClass('checked')
            $(this).addClass('checked')
            $(this).addClass('c-azul')
            $(this).removeClass('c-negro')

          }
        });
                                 
        </script>
@stop        