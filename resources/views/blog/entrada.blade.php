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

  <div class="container">
    <div class="card">
      <div class="card-body p-b-20">
        <div class="row p-l-10 p-r-10">

          <div class="col-sm-9">

            <p class="f-25 f-700" style="color:#5e5e5e">
              @if($entrada['imagen'])
                <img src="{{url('/')}}{{$entrada['imagen']}}" class="img-responsive opaco-0-8" alt="">
                <br>
              @endif
              <span class="f-25 f-700" style="color:#5e5e5e">{{$entrada['titulo']}}</span><br>
              <span class="f-15 f-400" style="color:#5e5e5e">Creado el {{$entrada['fecha']}} por <b>{{$entrada['nombre']}} {{$entrada['apellido']}}</b></span> 
              @if($entrada['usuario_imagen'])
                  <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$entrada['imagen']}}" alt="">
                @else
                    @if($entrada['sexo'] == 'M')
                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                    @else
                      <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                @endif
              @endif
            </p>

            <hr style="border-bottom: 1px solid #ccc">

            <p class="f-15 f-700">{!! nl2br($entrada['contenido']) !!}</p>

            <div class="clearfix"></div>
                        
           
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