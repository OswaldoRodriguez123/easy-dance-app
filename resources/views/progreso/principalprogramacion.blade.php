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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Selecciona la clase grupal</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">


                                    @if($clase_grupal_join)

                                        @foreach($clase_grupal_join as $clase_grupal)

                                            <?php 
                                                $id = $clase_grupal['id'];
                                                $tipo = $clase_grupal['tipo'];
                                            ?>
                      
                                            <div class="pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                                                @if($clase_grupal['imagen'])
                                                    <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/clase_grupal/{{$clase_grupal['imagen']}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                                                @else

                                                    <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                                                @endif

                                                <div class="col-sm-7">

                                                    <p class="f-25 f-700" style="color:#5e5e5e">{{$clase_grupal['clase_grupal_nombre']}}</p>
                                                
                                                    <p class="f-15 f-700">{{ str_limit($clase_grupal['descripcion'], $limit = 250, $end = '...') }}</p>

                                                </div>

                                                <div class="col-sm-3">

                                                    <div style="padding-top: 50px; padding-left: 25%">
                                                        <button type="button" class="btn btn-blanco m-r-10 f-18 previa" id="{{$id}}-{{$tipo}}">Ver progreso<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                                    </div>

                                                </div>    
                                        
                                            </div>

                                            <div class="clearfix"></div>

                                        @endforeach

                                        <hr style="margin-top: 1px">

                                    @else

                                        <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                            <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                            <div class="c-morado f-30 text-center"> Ups! lo sentimos, no estas inscrito en ninguna clase grupal. </div>


                                        </div>

                                    @endif

                                    <br><br><br>
                        
                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_progreso="{{url('/')}}/programacion";

    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        var route = route_progreso+"/"+id
        window.open(route, '_blank');;
      });

    

     </script>

@stop