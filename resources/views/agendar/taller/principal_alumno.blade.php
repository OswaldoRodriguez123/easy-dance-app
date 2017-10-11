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
                            <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>

                        @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-taller f-25"></i> Sección de Talleres</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">


                              @if(count($talleres) > 0)

                                  @foreach($talleres as $taller)
                  
                                      <div class="pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                                        @if($taller['imagen'])
                                            <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/taller/{{$taller['imagen']}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                                        @else

                                            <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                                        @endif

                                        <div class="col-sm-7">

                                        <p class="f-25 f-700" style="color:#5e5e5e">{{$taller['nombre']}}</p>
                                    
                                        <p class="f-15 f-700">{{ str_limit($taller['descripcion'], $limit = 250, $end = '...') }}</p>

                                        <p class="f-15 f-700">Fecha : {{ \Carbon\Carbon::createFromFormat('Y-m-d',$taller['fecha_inicio'])->format('d-m-Y')}}</p>

                                        <p class="f-15 f-700">Dias del taller : {{$taller['dias_de_semana']}}</p>

                                        <p class="f-15 f-700">Especialidad : {{$taller['especialidad']}}</p>

                                        <p class="f-15 f-700">Instructor : {{$taller['instructor_nombre']}} {{$taller['instructor_apellido']}}</p>
                                        
                                        <p class="f-15 f-700">Hora : {{$taller['hora_inicio']}} - {{$taller['hora_final']}}</p>

                                        @if($taller['costo'])
                                            <p class="f-15 f-700">Costo : {{ number_format($taller['costo'], 2, '.' , '.') }}</p>
                                        @endif

                                        </div>

                                        <div class="col-sm-3">

                                            <div style="padding-top: 50px;margin-left: 15%">
                                                <button type="button" class="btn btn-blanco m-r-10 f-18 previa" id="{{$taller['id']}}">Conocer más<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                            </div>

                                        </div>

                                                    
                                    
                                    </div>

                                    <div class="clearfix"></div>

                                @endforeach

                                <hr style="margin-top: 1px">

                                @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado talleres. </div>


                             </div>




                            @endif

                            <br><br><br>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_progreso="{{url('/')}}/agendar/talleres/progreso";

    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        window.open(route_progreso+"/"+id, '_blank');

      });

    

     </script>

@stop