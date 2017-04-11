@extends('layout.master')

@section('css_vendor')

  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
  <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">



@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

@section('content')

  <div class="container">
    <div class="card">
      <div class="card-body p-b-20">
        <div class="row p-l-10 p-r-10">

          <div class="col-sm-9">

            <p class="f-25 f-700" style="color:#5e5e5e">
              @if($entrada['imagen'])
                <img src="{{url('/')}}/assets/uploads/entradas/{{$entrada['imagen']}}" class="img-responsive opaco-0-8" alt="">
                <br>
              @endif
              <span class="f-25 f-700" style="color:#5e5e5e">{{$entrada['titulo']}} </span>


              @if(Auth::check())
                @if(Auth::user()->usuario_tipo == 1)
                  @if($entrada['boolean_mostrar'])
                    <i class="zmdi zmdi-check f-15 c-verde"></i>
                  @else
                    <i class="fa fa-hourglass f-15 c-youtube"></i>
                  @endif
                @endif
              @endif
              
              <br>

              <span class="f-15 f-400" style="color:#5e5e5e">Creado el {{$entrada['fecha']}} por <b>{{$blogger->nombre}}</b>

              <img class="lv-img-sm" src="{{url('/')}}/{{$usuario_imagen}}" alt=""> &nbsp; &nbsp; <i class="zmdi zmdi-eye"></i> {{$entrada['cantidad_visitas']}}</span> 

            </p>

            <hr style="border-bottom: 1px solid #ccc">

            <p class="f-15 f-700">{!! nl2br($entrada['contenido']) !!}</p>

            <div class="clearfix p-b-20"></div>

            
            <table class="table_blogger">
              <tbody>
                <tr>
                  <td>
                    <img class="img_blogger" src="{{url('/')}}/{{$usuario_imagen}}?size=250" alt="{{$blogger->nombre}}" width="70" height="70" />Autor: <b><a title="{{$blogger->nombre}}" href="{{ empty($blogger->pagina_web) ? 'http://tuclasedebaile.com.co' : $blogger->pagina_web}}" target="_blank">{{$blogger->nombre}}</a></b> {{$blogger->descripcion}} <br><br>


                    @if($blogger->facebook)
                      @if (!filter_var($blogger->facebook, FILTER_VALIDATE_URL) === false) 
                        <a href="{{$blogger->facebook}}" target="_blank"><i class="zmdi zmdi-facebook-box f-25 c-facebook m-l-5"></i></a>
                      @else
                        <a href="https://www.facebook.com/{{$blogger->facebook}}" target="_blank"><i class="zmdi zmdi-facebook-box f-25 c-facebook m-l-5"></i></a>
                      @endif
                    @endif

                    @if($blogger->twitter)
                      @if (!filter_var($academia->twitter, FILTER_VALIDATE_URL) === false) 
                        <a href="{{$blogger->twitter}}" target="_blank"><i class="zmdi zmdi-twitter-box f-25 c-twitter m-l-5"></i></a>
                      @else
                        <a href="https://www.twitter.com/{{$blogger->twitter}}" target="_blank"><i class="zmdi zmdi-twitter-box f-25 c-twitter m-l-5"></i></a>
                      @endif
                    @endif

                    @if($blogger->instagram)
                      @if (!filter_var($blogger->instagram, FILTER_VALIDATE_URL) === false) 
                        <a href="{{$blogger->instagram}}" target="_blank"><i class="zmdi zmdi-instagram f-25 c-instagram m-l-5"></i></a>
                      @else
                        <a href="https://www.instagram.com/{{$blogger->instagram}}" target="_blank"><i class="zmdi zmdi-instagram f-25 c-instagram m-l-5"></i></a>
                      @endif
                    @endif

                    @if($blogger->linkedin)
                      @if (!filter_var($blogger->linkedin, FILTER_VALIDATE_URL) === false) 
                        <a href="{{$blogger->linkedin}}" target="_blank"><i class="zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5"></i></a>
                      @else
                        <a href="https://www.linkedin.com/{{$blogger->linkedin}}" target="_blank"><i class="zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5"></i></a>
                      @endif
                    @endif

                    @if($blogger->youtube)
                      @if (!filter_var($blogger->youtube, FILTER_VALIDATE_URL) === false) 
                        <a href="{{$blogger->youtube}}" target="_blank"><i class="zmdi zmdi-collection-video f-25 c-youtube m-l-5"></i></a>
                      @else
                        <a href="https://www.youtube.com/{{$blogger->youtube}}" target="_blank"><i class="zmdi zmdi-collection-video f-25 c-youtube m-l-5"></i></a>
                      @endif
                    @endif

                    @if($blogger->pagina_web)
                        @if (!filter_var($blogger->pagina_web, FILTER_VALIDATE_URL) === false) 
                          <a href="{{$blogger->pagina_web}}" target="_blank"><i class="zmdi zmdi-google-earth f-25 c-verde m-l-5"></i></a>
                        @endif
                    @endif

                    <br><br><br>

                    <a class="btn-blanco m-t-10" href="{{url('/')}}/blog/entradas/{{$blogger->id}}">Ver todos sus posts</a>

                  </td>
                </tr>
              </tbody>
            </table>

           
          </div>

          <div class="col-sm-3" style="background: #f8f8f8 ;  min-height: 600px">
            <div style="padding-top:10px;">
              <div class="pmo-block pmo-contact hidden-xs">


                  <div class="pmo-block pmo-contact hidden-xs">

                  <h2 style="font-size: 16px; margin: 0 0 15px">Tópicos</h2>

                  <a class="f-15 f-700" href="{{url('/')}}/blog">Todas ({{$cantidad}})</a><br>

                  @foreach($categorias as $categoria)

                    <a class="f-15 f-700" href="{{url('/')}}/blog/categoria/{{$categoria['nombre']}}">{{$categoria['nombre']}} ({{$categoria['cantidad']}})</a><br>

                  @endforeach

                  <hr class="linea_transparente">


                  <h2 style="font-size: 16px; margin: 0 0 15px">Articulos Recientes</h2>

                  @foreach(array_slice($entradas, 0, 4) as $tmp)

                    
                    <div class="row">
                      <div class="col-sm-5">

                        <a onclick="procesando()" href="{{url('/')}}/blog/entrada/{{$tmp['id']}}">

                          @if($tmp['imagen_poster'])
                            <img class="img-responsive" src="{{url('/')}}/assets/uploads/entradas/{{$tmp['imagen_poster']}}" alt="">

                          @else

                            <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">

                          @endif

                          <br>

                        </a>

                      </div>

                      <div class="col-sm-7">
     

                        <a onclick="procesando()" class ="f-15" href="{{url('/')}}/blog/entrada/{{$tmp['id']}}">{{$tmp['titulo']}}</a><br><br>


                      </div>

                    </div>

                  @endforeach

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


@stop   

@extends('layout.footer')