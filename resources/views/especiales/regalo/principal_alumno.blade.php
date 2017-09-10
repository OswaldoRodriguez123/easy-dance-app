@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop

@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        @if(Auth::check())

                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>

                        @else

                            <a class="btn-blanco m-r-10 f-16" href="{{$_SERVER['HTTP_REFERER'] }}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        @endif
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">


                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-tarjeta-de-regalo f-25"></i> Sección de Regalos</p>
                            <hr class="linea-morada">                                                         
                        </div>




                        
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">


                              @if(count($regalos) > 0)

                                  @foreach($regalos as $regalo)
                  
                                      <div class="pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                                        @if($regalo->imagen)
                                        <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/regalo/{{$regalo->imagen}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                                        @else

                                        <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                                        @endif

                                        <div class="col-sm-8">

                                        <p class="f-25 f-700" style="color:#5e5e5e">{{$regalo['nombre']}}</p>
                                    
                                        <p class="f-15 f-700">{{ str_limit($regalo['descripcion'], $limit = 250, $end = '...') }}</p>

                                        <p class="f-15 f-700">{{ number_format($regalo['costo'], 2, '.' , '.') }}</p>

                                        </div>

                                        <div class="col-sm-2">

                                        <div style="padding-top: 50px">
                                            <button type="button" class="btn btn-blanco m-r-10 f-18 previa" id="{{$regalo->id}}">Dar Regalo</button>
                                        </div>

                                        </div>

                                                    
                                    
                                    </div>

                                    <div class="clearfix"></div>

                                @endforeach

                                <hr style="margin-top: 1px">

                                @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado regalos. </div>


                             </div>




                            @endif

                            <br><br><br>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_detalle="{{url('/')}}/especiales/regalos/detalle";
    route_enviar="{{url('/')}}/especiales/regalos/enviar";
  
    $(document).on( 'click', '.previa', function () {
        var row = this.id;
        procesando();


        var route =route_enviar+"/"+row;

        window.open(route, '_blank');;
      });

    

     </script>

@stop