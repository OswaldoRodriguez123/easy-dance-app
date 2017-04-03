@extends('layout.master')

@section('css_vendor')

  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
  <link href="{{url('/')}}/assets/css/rrssb.css" rel="stylesheet"/>

@stop

@section('js_vendor')

  <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
  <script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

@stop

@section('content')

@if(Auth::check())
  @if(Auth::user()->usuario_tipo == 1)
    <a href="{{url('/')}}/blog/publicar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
  @endif
@endif

  <div class="container">
    <div class="card">
      <div class="card-body p-b-20">
        <div class="row p-l-10 p-r-10">

          <div class="col-sm-9">

           <div class ="entradas">

            @foreach(array_slice($entradas, 0, 10) as $entrada)
            <!-- foreach(array_slice(entradas, 0, 4) as entrada) -->
              
              <div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                <div style="padding: 10px">

                  <a href="{{$entrada['url']}}" class="f-25 f-700">{{$entrada['titulo']}}</a>
                  <p class="f-15 f-400" style="color:#5e5e5e">

                    Creado el {{$entrada['fecha']}} por <b>{{$entrada['nombre']}} {{$entrada['apellido']}}</b>

                    @if($entrada['usuario_imagen'])
                        <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$entrada['usuario_imagen']}}" alt="">
                      @else
                          @if($entrada['sexo'] == 'M')
                            <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                          @else
                            <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                      @endif
                    @endif
                  </p>


                  <div class="row">
                    <div class="col-sm-4 imagen-blog-contenedor">

                      <a href="{{$entrada['url']}}" class="imagen-blog-link">

                        @if($entrada['imagen'])
                          <img class="imagen-blog-img img-responsive" src="{{url('/')}}{{$entrada['imagen']}}" alt="">

                          <br>

                        @else

                          <img class="imagen-blog-img img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">

                          <br>

                        @endif

                      </a>

                    </div>

                    <div class="col-sm-8">

                      
   

                      <p>{!! nl2br(str_limit($entrada['contenido'], $limit = 350, $end = '...')) !!}</p>

                      <div class="clearfix"></div>


                      <a href="{{$entrada['url']}}">Ver mas</a>

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

                <h2 style="font-size: 16px; margin: 0 0 15px">Categorias</h2>

                @foreach($categorias as $categoria)

                  <a href="{{url('/')}}/blog/categoria/{{$categoria['nombre']}}">{{$categoria['nombre']}} ({{$categoria['cantidad']}})</a><br>

                @endforeach

                <br>


                  <h2 style="font-size: 16px; margin: 0 0 15px">Articulos Recientes</h2>

                  @foreach(array_slice($entradas, 0, 4) as $tmp)

                    <a class ="f-15 f-700" href="{{url('/')}}/blog/entrada/{{$tmp['id']}}">{{$tmp['titulo']}}</a><br><br>

                  @endforeach

                  <br>

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


@stop

@extends('layout.footer')

@section('js') 
        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        var entradas = <?php echo json_encode($entradas);?>;

        var inicio = 10;
        var final = 13;

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

            entrada_contenido = nl2br(entrada.contenido)
            entrada_contenido = entrada_contenido.toLowerCase().substr(0, 350) + "..."

            contenido += '<div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">'
            contenido += '<div style="padding: 10px">'
            contenido += '<a href="'+entrada.url+'" class="f-25 f-700">'+entrada.titulo+'</a>'
            contenido += '<p class="f-15 f-400" style="color:#5e5e5e">Creado el '+entrada.fecha+' por <b>'+entrada.nombre+' '+entrada.apellido+'</b>'
            contenido += '<img class="lv-img-sm" src="'+usuario_imagen+'" alt=""></p>'
            contenido += '<div class="row">'
            contenido += '<div class="col-sm-4 imagen-blog-contenedor">'
            contenido += '<a href="'+entrada.url+'" class="imagen-blog-link">'
            contenido += '<img class="imagen-blog-img img-responsive" src="'+imagen+'" alt=""></a></div>'
            contenido += '<div class="col-sm-8">'
            contenido += '<p>'+entrada_contenido
            contenido += '</p><a href="'+entrada.url+'">Ver mas</a>'
            contenido += '</div></div></div></div>'


            $(".entradas").append(contenido)


          });

          inicio = final;
          final = final + 4;

          if(inicio <= entradas.length){

            $(".entradas").append('<div class="text-center mostrar_mas"> <br><br> <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span> </div>');

          }

        });

        function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
        }

        </script>
@stop        