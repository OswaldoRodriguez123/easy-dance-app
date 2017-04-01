@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

<!--     <link href="{{url('/')}}/assets/css/styles.min.css" rel="stylesheet"> -->
    <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
    <!-- <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet"> -->


@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

@section('content')


<a href="{{url('/')}}/blog/publicar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>

  <div class="container">
    <div class="card">
      <div class="card-body p-b-20">
        <div class="row p-l-10 p-r-10">

          <div class="col-sm-9">

           <div class ="entradas">

            @foreach($entradas as $entrada)
            <!-- foreach(array_slice(entradas, 0, 4) as entrada) -->
              
              <div class="opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                <div style="padding: 10px">

                  <a href="{{$entrada['url']}}" class="f-25 f-700">{{$entrada['titulo']}}</a>
                  <p class="f-15 f-400" style="color:#5e5e5e">Creado el {{$entrada['fecha']}} por {{$entrada['nombre']}} {{$entrada['apellido']}}</p>

                  <div class="row">
                    <div class="col-sm-4 imagen-blog-contenedor">

                      <a href="{{$entrada['url']}}" class="imagen-blog-link">

                        @if($entrada['imagen'])
                          <img class="imagen-blog-img" src="{{url('/')}}{{$entrada['imagen']}}" class="img-responsive" alt="">

                          <br>

                        @else

                          <img class="imagen-blog-img" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" class="img-responsive" alt="">

                          <br>

                        @endif

                      </a>

                    </div>

                    <div class="col-sm-8">

                      
                      @if($entrada['contenido'])

                        <p class="f-15 f-700">{!! nl2br(str_limit($entrada['contenido'], $limit = 350, $end = '...')) !!}</p>

                      @endif

                      <a href="{{$entrada['url']}}">Ver mas</a>

                    </div>

                  </div>
                
                </div>

              </div>


            @endforeach

          </div>

          <!-- if(count($entradas) > 4)

            <div class="text-center mostrar_mas">

              <br><br>



              <span class="mostrar f-16 c-morado f-700 pointer">Mostrar más</span>

            </div>
          endif -->
                        
           
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

        var inicio = 4;
        var final = 7;

        $(document).on( 'click', '.entrada', function () {
          url = $(this).data('url');
          window.location = "{{url('/')}}"+url;
        });

        $(document).on( 'click', '.mostrar', function () {

          $(".mostrar_mas").remove();

          var entrada = $.grep(entradas, function(e){ return (e.contador >= inicio && e.contador <= final) });

          $.each(entrada, function (index, array) {

            if(array.tipo == 1){
              console.log('entro')
              fecha_inicio = "<p class='f-15 f-700'> Fecha de Inicio : "+array.fecha_inicio+"</p>"
            }else{
              fecha_inicio = ''
            }

            $(".entradas").append('<div class="text-left pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)"><div class="enlace" name="enlace" id="enlace" data-url="'+array.url+'"><div style="padding: 10px"><p class="f-25 f-700" style="color:#5e5e5e">'+array.nombre+'<span class="f-16 c-youtube">'+array.disponible+'</span></p><p class="f-15 f-700">'+array.descripcion.substr(0, 150) + "..."+ '</p><img src="{{url('/')}}'+array.imagen+'" class="img-responsive" alt=""> <br>'+fecha_inicio+'</div></div><hr style="margin-bottom:5px"><div class="col-sm-3"><span class="f-13 f-700">Comparte</span><ul class="rrssb-buttons clearfix"><li class="rrssb-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}'+array.facebook+'" class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span><span class="rrssb-text"></span></a></li><li class="rrssb-twitter"><a href="https://twitter.com/intent/tweet?text='+array.twitter+' {{url('/')}}'+array.twitter_url+'"class="popup"><span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span><span class="rrssb-text"></span></a></li></ul></div><br><br><br></div>')


          });

          inicio = final;
          final = final + 4;

          if(inicio <= entradas.length){

            $(".entradas").append('<div class="text-center mostrar_mas"> <br><br> <span class="mostrar f-16 c-morado f-700 pointer">Mostrar mas</span> </div>');

          }

        });

        </script>
@stop        