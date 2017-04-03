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
                  <p class="f-15 f-400" style="color:#5e5e5e">Creado el {{$entrada['fecha']}} por {{$entrada['nombre']}} {{$entrada['apellido']}}</p>

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

            entrada_contenido = nl2br(entrada.contenido)
            entrada_contenido = entrada_contenido.toLowerCase().substr(0, 350) + "..."

            contenido += '<div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">'
            contenido += '<div style="padding: 10px">'
            contenido += '<a href="'+entrada.url+'" class="f-25 f-700">'+entrada.titulo+'</a>'
            contenido += '<p class="f-15 f-400" style="color:#5e5e5e">Creado el '+entrada.fecha+' por '+entrada.nombre+' '+entrada.apellido+'</p>'
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