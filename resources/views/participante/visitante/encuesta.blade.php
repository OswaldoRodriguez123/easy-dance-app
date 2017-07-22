@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>

@stop

@section('content')

   
        
            <section id="content">
                <div class="container invoice">

                    <div class="block-header hidden-print">
                        <?php $url = "/participante/visitante/detalle/$visitante->id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">

                        <div class="card-header ch-alt text-center">
                            @if ($academia->imagen)
                                <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                            @else
                                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                            @endif

                            <div class="clearfix m-b-20"></div>
                        </div>
                        
                        <div class="card-body card-padding">
                          <div class="row m-b-25">
                              <div class="col-xs-6">
                                  <div class="text-right">
                                      <p class="c-gray">Academia</p>
                                      
                                      <h4>{{ $academia->nombre }}</h4>
                                      
                                      <span class="text-muted">
                                          <address>
                                              {{ $academia->direccion }}<br>
                                              {{ $academia->pais }}
                                          </address>
              
                                          {{ $academia->telefono }}<br/>
                                          {{ $academia->correo }}
                                      </span>
                                  </div>
                              </div>
                              
                              <div class="col-xs-6">
                                  <div class="i-to">
                                      <p class="c-gray">Visitante</p>
                                      
                                      <h4>{{ $visitante->nombre }}</h4>
                                      
                                      <span class="text-muted">
                                          <address>
                                              {{ str_limit($visitante->direccion, $limit = 30, $end = '...') }}
                                          </address>
              
                                          {!! $visitante->telefono !!}<br/>
                                          {!! $visitante->correo !!}
                                      </span>
                                  </div>
                              </div>
                            </div>

                            <div class="clearfix m-b-20"></div>
                            <div class="clearfix m-b-20"></div>
                            
                            <div class="row m-b-25">
                                                            
                                <div class="col-sm-12">

                                    <label for="apellido" id="id-rapidez">¿Con qué rapidez lo atendieron nuestros representantes de servicio al cliente?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        Muy Rápido
                                        <i id="pregunta_1_respuesta_1"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Rápido
                                        <i id="pregunta_1_respuesta_2"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Lento
                                        <i id="pregunta_1_respuesta_3"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">  
                                        Muy Lento
                                        <i id="pregunta_1_respuesta_4"></i>
                                    </label>
                                    </div>
                                    </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-calidad">¿Cómo considera usted la atención de nuestros representantes de servicio al cliente? </label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        Excelente
                                        <i id="pregunta_2_respuesta_1"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Bueno
                                        <i id="pregunta_2_respuesta_2"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Regular
                                        <i id="pregunta_2_respuesta_3"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Malo
                                        <i id="pregunta_2_respuesta_4"></i>
                                    </label>
                                    </div>
                                    </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-satisfaccion">¿Recibió usted satisfactoriamente la información que solicitaba?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        Si, completamente
                                        <i id="pregunta_3_respuesta_1"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        No de un todo
                                        <i id="pregunta_3_respuesta_2"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        No
                                        <i id="pregunta_3_respuesta_3"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 "> 
                                        No lo sé
                                        <i id="pregunta_3_respuesta_4"></i>
                                    </label>
                                    </div>
                                    </div>
                               </div>

                               <div class="clearfix p-b-35"></div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="apellido" id="id-disponibilidad">¿Estaría dispuesto a realizar clases con nosotros?</label>

                                    <div class="input-group">
                                      <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        Absolutamente
                                        <i id="pregunta_4_respuesta_1"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        Posiblemente
                                        <i id="pregunta_4_respuesta_2"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        No estoy seguro
                                        <i id="pregunta_4_respuesta_3"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        No
                                        <i id="pregunta_4_respuesta_4"></i>
                                    </label>
                                    </div>
                                    </div>
                               </div>
                              
                               <div class="clearfix"></div>

                          </div>
                      </div>
                  </div> 
          </section>

          

@stop
@section('js') 
<script type="text/javascript">
  
  $(document).ready(function(){

    if("{{$visitante->rapidez}}" == 1){
      $('#pregunta_1_respuesta_1').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->rapidez}}" == 2){
      $('#pregunta_1_respuesta_2').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->rapidez}}" == 3){
      $('#pregunta_1_respuesta_3').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->rapidez}}" == 4){
      $('#pregunta_1_respuesta_4').addClass('zmdi zmdi-check c-verde')
    }

    if("{{$visitante->calidad}}" == 1){
      $('#pregunta_2_respuesta_1').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->calidad}}" == 2){
      $('#pregunta_2_respuesta_2').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->calidad}}" == 3){
      $('#pregunta_2_respuesta_3').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->calidad}}" == 4){
      $('#pregunta_2_respuesta_4').addClass('zmdi zmdi-check c-verde')
    }

    if("{{$visitante->satisfaccion}}" == 1){
      $('#pregunta_3_respuesta_1').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->satisfaccion}}" == 2){
      $('#pregunta_3_respuesta_2').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->satisfaccion}}" == 3){
      $('#pregunta_3_respuesta_3').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->satisfaccion}}" == 4){
      $('#pregunta_3_respuesta_4').addClass('zmdi zmdi-check c-verde')
    }

    if("{{$visitante->disponibilidad}}" == 1){
      $('#pregunta_4_respuesta_1').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->disponibilidad}}" == 2){
      $('#pregunta_4_respuesta_2').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->disponibilidad}}" == 3){
      $('#pregunta_4_respuesta_3').addClass('zmdi zmdi-check c-verde')
    }else if("{{$visitante->disponibilidad}}" == 4){
      $('#pregunta_4_respuesta_4').addClass('zmdi zmdi-check c-verde')
    }
  });

</script> 
@stop

