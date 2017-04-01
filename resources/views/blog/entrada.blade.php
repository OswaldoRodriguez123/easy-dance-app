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
              <span class="f-15 f-400" style="color:#5e5e5e">Creado el {{$entrada['fecha']}} por {{$entrada['nombre']}} {{$entrada['apellido']}}</span>
            </p>

            <hr style="border-bottom: 1px solid #ccc">

            <p class="f-15 f-700">{!! nl2br($entrada['contenido']) !!}</p>
                        
           
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