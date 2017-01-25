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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/buscador"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Alumno: {{$alumno->nombre}} {{$alumno->apellido}}</p>
                            

                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">
                                    <div class="clearfix" style="margin-bottom: 50px"></div>
                                    
                                    <div class="col-sm-4 text-center">

                                        @if($imagen)
                                            <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/uploads/usuario/{{$imagen}}" alt="" width="250px" height="auto">  
                                        @else
                                         @if($alumno->sexo =='F')
                                              <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="" width="250px" height="auto">        
                                           @else
                                              <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="" width="250px" height="auto">
                                           @endif
                                        @endif

                                        <br>

                                        <p class="p-l-10">Participa en :  </p>

                                        @foreach($inscripciones as $array)

                                          <p>{{$array['nombre']}} <br> 
                                          {{$array['hora_inicio']}} / {{$array['hora_final']}} <br> 
                                          {{$array['dia']}}
                                          @if($array['fecha_pago'])
                                            <br> 

                                            Fecha de Pago: {{$array['fecha_pago']}} <br> 
                                            Restan {{$array['diferencia']}} dias</p>
                                          @else
                                            </p>
                                          @endif
                                        @endforeach


                                        @if($deuda)

                                            <span class="f-16 f-700" id="acciones" name="acciones">Acciones</span>

                                            <hr id="acciones_linea" name ="acciones_linea"></hr>
                                        
                                            <a id="url_pagar" name="url_pagar" href="{{url('/')}}/participante/alumno/deuda/{{$id}}"><i class="icon_a-pagar f-25 m-r-5 boton blue sa-warning" data-original-title="Pagar" data-toggle="tooltip" data-placement="bottom" title=""></i></a>

                                        @endif

                                    </div>

                                    <div class="col-sm-4">
                                             <div class="form-group fg-line">

                                                <table class="table table-striped table-bordered historial">
                                                 <tr class="detalle historial">
                                                 <td class = "historial"></td>
                                                 <td class="f-14 m-l-15 historial" data-original-title="" data-content="Ver historial" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"><span class="f-16 f-700 historial">Balance Económico: </span><span class = "f-16 f-700 historial" id="asistencia-estado_economico" name="asistencia-estado_economico">{{$deuda}}</span> 

                                                 <i class="zmdi zmdi-money f-20 m-r-5 {{ empty($deuda) ? 'c-verde' : 'c-youtube' }}" name="status_economico" id="status_economico"></i></td>
                                                </tr>
                                                </table>
                                              </div>
                                           </div>

                                           <div class="col-sm-4">
                                             <div class="form-group fg-line">
                                                <label for="asistencia-estado_ausencia" class="f-16">Estado de ausencia</label>
                                                <div class="clearfix p-b-15"></div>
                                                <span class="text-center" id="asistencia-estado_ausencia"> --</span>
                                             </div>
                                           </div>

                                 
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

        route_historial = "{{url('/')}}/participante/alumno/historial/";


       $(".historial").click(function(){

          var alumno = "{{$alumno->id}}";
          window.location = route_historial + alumno;
          
      }); 
    

     </script>

@stop