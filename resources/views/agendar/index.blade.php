@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>


@stop

@section('content')

<div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                                        <h4 class="modal-title c-negro"> Clase Cancelada <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                                    </div>
                                    <form name="cancelar_clase" id="cancelar_clase"  >
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       <input type="hidden" name="id" id="id">
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img id="imagen" src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-9">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                                            <p class="f-16">Fecha: <span class="f-700 span_fecha"></span></p> 

                                           <div class="clearfix"></div> 
                                           <div class="clearfix p-b-15"></div>
                                            

                                            @if($usuario_tipo != 2 && $usuario_tipo != 4)
                                                <div class="col-sm-12 text-right">
                                                    <label for="">Activar Clase</label>
                                                  
                                                    <br></br>
                                                    <div class="p-t-10">
                                                        <div class="toggle-switch" data-ts-color="purple">
                                                        <span class="p-r-10 f-700 f-16">No</span><input id="activar" type="checkbox">
                                                        
                                                        <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                           </div>

                                           
                                       </div>

                                       <div class="row p-t-20 p-b-0">

                                       <hr style="margin-top:5px">

                                       <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelación</label>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2"></textarea>
                                          </div>
                                      </div>

                                       </div>
                                       </div>


                                        
                                        @if($usuario_tipo != 2 && $usuario_tipo != 4)
                                            <div class="modal-footer p-b-20 m-b-20">
                                                <div class="col-sm-12">                          
                                                  <button type="button" class="btn-blanco btn m-r-10 f-16 guardar" > Actualizar</button>
                                                  <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Volver</button>
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>


            <section id="content">
                <div class="container">

                <?php //dd($talleres[0]->nombre); ?>


                <div id="calendar"></div>
                <input type="hidden" id="tipo" name="tipo" value="0" />
                    
                    <!-- Add event -->
                    <div class="modal fade" id="addNew-event" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!--<h4 class="modal-title">Agendar</h4>-->
                                    <i class="icon_a-agendar f-35" ></i>
                                    <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body m-b-20">
                                    <p class="text-center p-t-0 f-700 opaco-0-8 f-25">Hey {{Auth::user()->nombre}}. Que bueno tenerte aquí... </p> 
                                    <p class="text-center p-b-20 f-700 opaco-0-8 f-22">¿Listo para agendar? Empieza yaaa...</p>

                                    <form id="frm_fecha" name="frm_fecha" class="addFecha" role="form" method="POST" action="guardar-fecha">
                                        <input type="hidden" id="fecha_inicio" name="fecha_inicio" />
                                    </form>
                                    <form id="frm_agendar" name="frm_agendar" class="addEvent" role="form" method="POST" action="{{url('/')}}/agendar">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="col-sm-3">
                                    	<ul class="ca-menu" style="margin: 0 auto;">
		                                    <li style="height: 250px;">
		                                        <a href="#" class="agendar" data-agendar="clases-grupales">
		                                            <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-clases-grupales"></i></span>
		                                            <div class="ca-content" style="top: 35%;">
		                                                <h2 class="ca-main f-20">Clases Grupales</h2>
		                                                <h3 class="ca-sub" style="line-height: 20px;">Actívate ya!</h3>
		                                            </div>
		                                        </a>
		                                    </li>
		                                </ul>
                                    </div>

                                    <div class="col-sm-3">
                                    	<ul class="ca-menu" style="margin: 0 auto;">
		                                    <li style="height: 250px;">
		                                        <a href="#" class="agendar" data-agendar="clases-personalizadas">
		                                            <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-clase-personalizada"></i></span>
		                                            <div class="ca-content" style="top: 35%;">
		                                                <h2 class="ca-main f-20">Clases Personalizadas</h2>
		                                                <h3 class="ca-sub" style="line-height: 20px;">Actívate ya!</h3>
		                                            </div>
		                                        </a>
		                                    </li>
		                                </ul>
                                    </div>

                                    <div class="col-sm-3">
                                    	<ul class="ca-menu" style="margin: 0 auto;">
		                                    <li style="height: 250px;">
		                                        <a href="#" class="agendar" data-agendar="talleres" >
		                                            <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-talleres"></i></span>
		                                            <div class="ca-content" style="top: 35%;">
		                                                <h2 class="ca-main f-20">Talleres</h2>
		                                                <h3 class="ca-sub" style="line-height: 20px;">Actívate ya!</h3>
		                                            </div>
		                                        </a>
		                                    </li>
		                                </ul>
                                    </div>

                                    <div class="col-sm-3">
                                    	<ul class="ca-menu" style="margin: 0 auto;">
		                                    <li style="height: 250px;">
		                                        <a href="#" class="agendar" data-agendar="citas">
		                                            <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="zmdi zmdi-calendar-check"></i></span>
		                                            <div class="ca-content" style="top: 35%;">
		                                                <h2 class="ca-main f-20">Citas</h2>
		                                                <h3 class="ca-sub" style="line-height: 20px;">Actívate ya!</h3>
		                                            </div>
		                                        </a>
		                                    </li>
		                                </ul>
                                    </div>

                                    <div class="clearfix p-b-10"></div>


                                    	
                                        
                                        <!--<div class="form-group">
                                            <label for="eventName">Event Name</label>
                                            <div class="fg-line">
                                                <input type="text" class="input-sm form-control" id="eventName" placeholder="eg: Sports day">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="eventName">Event Name</label>
                                            <div class="fg-line">
                                                <input type="text" class="input-sm form-control" id="eventName" placeholder="eg: Sports day">
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="eventName">Tag Color</label>
                                            <div class="event-tag">
                                                <span data-tag="bgm-teal" class="bgm-teal selected"></span>
                                                <span data-tag="bgm-red" class="bgm-red"></span>
                                                <span data-tag="bgm-pink" class="bgm-pink"></span>
                                                <span data-tag="bgm-blue" class="bgm-blue"></span>
                                                <span data-tag="bgm-lime" class="bgm-lime"></span>
                                                <span data-tag="bgm-green" class="bgm-green"></span>
                                                <span data-tag="bgm-cyan" class="bgm-cyan"></span>
                                                <span data-tag="bgm-orange" class="bgm-orange"></span>
                                                <span data-tag="bgm-purple" class="bgm-purple"></span>
                                                <span data-tag="bgm-gray" class="bgm-gray"></span>
                                                <span data-tag="bgm-black" class="bgm-black"></span>
                                            </div>
                                        </div>-->
                                        
                                        <input type="hidden" id="getStart" name="getStart" />
                                        <input type="hidden" id="getEnd" name="getEnd" />
                                        <input type="hidden" id="agendar" name="agendar" />
                                    </form>
                                </div>
                                
                                <div class="modal-footer">
                                    <!--<button type="submit" class="btn btn-link" id="addEvent">Add Event</button>
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                                </div>
                            </div>
                        </div>
                    </div>


        <div class="modal fade" id="modalFechaPasada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Información <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="text-center">
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>
                        <div align="center"><i class="zmdi zmdi-calendar-close zmdi-hc-fw f-60 c-morado"></i></div>

                        <div class="clearfix p-b-15"></div>
                        
                        <div class="col-md-12">
                         <span class="f-20 opaco-0-8">¡ Ups lo sentimos, no puedes agendar en una fecha vencida. !</span>
                         </div>

                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>
                         <div class="clearfix p-b-15"></div>


                        </div>
                       
                    </div>
                </div>
            </div>


    </div>
</section>
@stop

@section('js')
<script type="text/javascript">

            route_principal="{{url('/')}}/agendar";
            route_activar="{{url('/')}}/agendar/clases-grupales/eliminar-cancelacion/";
            route_update="{{url('/')}}/agendar/clases-grupales/actualizar-cancelacion";

            $(document).ready(function() {

                $("#activar").prop("checked", false);

                $("#activar").on('change', function(){

                    swal({   
                        title: "Desea activar esta clase grupal",   
                        text: "Confirmar activación!",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#DD6B55",   
                        confirmButtonText: "Activar!",  
                        cancelButtonText: "Cancelar",         
                        closeOnConfirm: true 
                    }, function(isConfirm){   
                        if (isConfirm) {
                            var nFrom = $(this).attr('data-from');
                            var nAlign = $(this).attr('data-align');
                            var nIcons = $(this).attr('data-icon');
                            var nType = 'success';
                            var nAnimIn = $(this).attr('data-animation-in');
                            var nAnimOut = $(this).attr('data-animation-out')

                            activar();
                        }else{
                            $("#activar").prop("checked", false)
                        }
                    });
                });

                function activar(){
                    procesando();
                    var route = route_activar + $('#id').val();
                    var token = $('input:hidden[name=_token]').val();
                        
                    $.ajax({
                        url: route,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'DELETE',
                        dataType: 'json',
                        success:function(respuesta){

                            window.location=route_principal; 

                        },
                        error:function(msj){
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
                    });
                }

                $(".guardar").on('click', function(){

                    swal({   
                        title: "Desea actualizar el bloqueo",   
                        text: "Confirmar actualización!",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#DD6B55",   
                        confirmButtonText: "Actualizar!",  
                        cancelButtonText: "Cancelar",         
                        closeOnConfirm: true 
                    }, function(isConfirm){   
                        if (isConfirm) {

                            procesando();
                            var route = route_update;
                            var token = $('input:hidden[name=_token]').val();
                            var datos = $( "#cancelar_clase" ).serialize(); 
                                
                            $.ajax({
                                url: route,
                                    headers: {'X-CSRF-TOKEN': token},
                                    type: 'POST',
                                dataType: 'json',
                                data: datos,
                                success:function(respuesta){

                                    window.location=route_principal; 

                                },
                                error:function(msj){
                                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                            });
                        }
                    });
                });

                function activar(){
                    procesando();
                    var route = route_activar + $('#id').val();
                    var token = $('input:hidden[name=_token]').val();
                        
                    $.ajax({
                        url: route,
                            headers: {'X-CSRF-TOKEN': token},
                            type: 'DELETE',
                        dataType: 'json',
                        success:function(respuesta){

                            window.location=route_principal; 

                        },
                        error:function(msj){
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
                    });
                }

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                

                var cId = $('#calendar'); //Change the name if you want. I'm also using thsi add button for more actions

                //Generate the Calendar
                cId.fullCalendar({

                    header: {
                        right: '',
                        center: 'prev, title, next',
                        left: ''
                    },

                    theme: true, //Do not remove this as it ruin the design
                    selectable: true,
                    selectHelper: true,
                    editable: false,
                    lang: 'es',

                    //Add Events

                    events: [
                        @foreach ($talleres as $taller)
                            {
                                <?php
                                    $fecha_start=explode('-',$taller['fecha_inicio']);
                                    $fecha_end=explode('-',$taller['fecha_final']);
                                    $hora_start=explode(':',$taller['hora_inicio']);
                                    $hora_end=explode(':',$taller['hora_final']);
                                ?>
                                id: 'taller-{{$taller['id']}}',
                                title: '{{$taller['nombre']}}',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$taller['etiqueta']}}',
                                className: 'actividad',
                                url: '{{url('/')}}{{$taller['url']}}',
                                tipo: 'talleres'
                            },
                        @endforeach

                        @foreach ($clases_grupales as $clase)
                            {

                                <?php
                                    $fecha_start=explode('-',$clase['fecha_inicio']);
                                    $fecha_end=explode('-',$clase['fecha_final']);
                                    $hora_start=explode(':',$clase['hora_inicio']);
                                    $hora_end=explode(':',$clase['hora_final']);

                                    if(!isset($clase['inicio'])){
                                        $tipo = 'clases-grupales';
                                        
                                    }else{
                                        if(\Carbon\Carbon::parse($clase['fecha_inicio']) >= \Carbon\Carbon::now()->subDay()){
                                            $tipo = 'nueva-clase-grupal';
                                        }else{
                                            $tipo = 'clases-grupales';
                                        }
                                    }

                                    if(\Carbon\Carbon::parse($clase['fecha_inicio']) >= \Carbon\Carbon::now()->subDay()){
                                        $etiqueta = $clase['etiqueta'];
                                        $actividad = 'actividad';
                                        $url = $clase['url'];
                                    }else{
                                        $etiqueta = '#B8B8B8';
                                        $actividad = 'disabled';
                                        $url = '';
                                    }
                                ?>

                                id: 'clase-{{$clase['id']}}',
                                title: '{{$clase['nombre']}}',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$etiqueta}}',
                                className: '{{$actividad}}',
                                url: '{{$url}}',
                                tipo: '{{$tipo}}',
                                nombre_clase: '{{$clase['nombre_clase']}}',
                            },
                        @endforeach

                        @foreach ($clases_personalizadas as $clasepersonalizada)
                            {
                                <?php
                                    $fecha_start=explode('-',$clasepersonalizada['fecha_inicio']);
                                    $fecha_end=explode('-',$clasepersonalizada['fecha_final']);
                                    $hora_start=explode(':',$clasepersonalizada['hora_inicio']);
                                    $hora_end=explode(':',$clasepersonalizada['hora_final']);
                                ?>
                                id: 'clasepersonalizada-{{$clasepersonalizada['id']}}',
                                title: '{{$clasepersonalizada['nombre']}}',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$clasepersonalizada['etiqueta']}}',
                                className: 'actividad',
                                url: '{{url('/')}}{{$clasepersonalizada['url']}}',
                                tipo: 'clases-personalizadas'
                            },
                        @endforeach

                        @foreach ($fiestas as $fiesta)
                            {
                                <?php
                                    $fecha_start=explode('-',$fiesta['fecha_inicio']);
                                    $fecha_end=explode('-',$fiesta['fecha_final']);
                                    $hora_start=explode(':',$fiesta['hora_inicio']);
                                    $hora_end=explode(':',$fiesta['hora_final']);
                                ?>
                                id: 'fiesta-{{$fiesta['id']}}',
                                title: '{{$fiesta['nombre']}}',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$fiesta['etiqueta']}}',
                                className: 'actividad',
                                url: '{{url('/')}}{{$fiesta['url']}}',
                                tipo: 'fiestas-eventos'
                            },
                        @endforeach

                        @foreach ($citas as $cita)
                            {
                                <?php
                                    $fecha_start=explode('-',$cita['fecha_inicio']);
                                    $fecha_end=explode('-',$cita['fecha_final']);
                                    $hora_start=explode(':',$cita['hora_inicio']);
                                    $hora_end=explode(':',$cita['hora_final']);
                                ?>
                                id: 'cita-{{$cita['id']}}',
                                title: '{{$cita['nombre']}}',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$cita['etiqueta']}}',
                                className: 'actividad',
                                url: '{{url('/')}}{{$cita['url']}}',
                                tipo: 'citas'
                            },
                        @endforeach

                        @foreach ($transmisiones as $transmision)
                            {
                                <?php
                                    $fecha_start=explode('-',$transmision['fecha']);
                                    $fecha_end=explode('-',$transmision['fecha']);
                                    $hora_start=explode(':',$transmision['hora']);
                                    $hora_end=explode(':',$transmision['hora']);
                                ?>
                                id: 'transmision-{{$transmision['id']}}',
                                title: 'Transmisión',
                                start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                                end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                                allDay: false,
                                backgroundColor:'{{$transmision['etiqueta']}}',
                                className: 'actividad',
                                url: "{{url('/')}}{{$transmision['url']}}",
                                tipo: 'transmisiones'

                            },
                        @endforeach
                    ],
                     
                    //On Day Select
                    select: function(start, end, allDay) {

                        var d = new Date();
                        var timestamp = d.getTime(); 

                        if(end>timestamp){

                            if("{{$usuario_tipo}}" != 2 && "{{$usuario_tipo}}" != 4){
                                $('#addNew-event').modal('show');   
                                $('#addNew-event input:text').val('');
                                $('#getStart').val(start);
                                $('#getEnd').val(end);

                            }else{

                                var agendar = 'clases-personalizadas';
                                $('#agendar').val(agendar);
                                $("#frm_agendar").submit();
                           }
                        }else{
                           $('#modalFechaPasada').modal('show');                            
                        }

                        
                    },
                    eventClick: function(calEvent, jsEvent, view) {

                        if(!$(this).hasClass('disabled')){

                            var check = calEvent.url
                            var tmp = check.split("!"); 
                            var title = calEvent.title

        
                            if(title != 'CANCELADA'){

                                if("{{$usuario_tipo}}" != 2 && "{{$usuario_tipo}}" != 4)
                                {
                                    $('#fecha_inicio').val(calEvent.start);
                                    var token = $('input:hidden[name=_token]').val();

                                    $.ajax({
                                        url: "{{url('/')}}/guardar-fecha",
                                            headers: {'X-CSRF-TOKEN': token},
                                            type: 'POST',
                                        dataType: 'json',
                                        data:"fecha_inicio="+$('#fecha_inicio').val(),
                                        success:function(respuesta){

                                            window.location = calEvent.url

                                        }
                                    });
                                }else{
                                    if(calEvent.tipo != 5 && calEvent.tipo != 6){

                                        $('#fecha_inicio').val(calEvent.start);
                                        var token = $('input:hidden[name=_token]').val();

                                        $.ajax({
                                            url: "{{url('/')}}/guardar-fecha",
                                                headers: {'X-CSRF-TOKEN': token},
                                                type: 'POST',
                                            dataType: 'json',
                                            data:"fecha_inicio="+$('#fecha_inicio').val(),
                                            success:function(respuesta){

                                                window.location = calEvent.url

                                            }
                                        });
                                    }
                                }

                            }else{
                                var fecha = tmp[3]
                                var hora = tmp[4]
                                var sexo = tmp[6]
                                var imagen = tmp[5]
                                var instructor = tmp[2]
                                var cancelacion = tmp[1]
                                var id = tmp[0]
                                $('#id').val(id);
                                $('.span_fecha').text(fecha)
                                $('.span_hora').text(hora)
                                $('.span_instructor').text(instructor)
                                $('#razon_cancelacion').text(cancelacion)

                                if(imagen){

                                    $('#imagen').attr('src', "{{url('/')}}/assets/uploads/instructor/"+imagen)

                                }else{
                                    if(sexo == 'F'){
                                        $('#imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
                                    }else{
                                        $('#imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
                                    }
                                }
                                $("#modalCancelar" ).modal('show');
                            }
                        }

                    },
                    eventRender: function(event, eventElement) {
                        var id = event.id
                        var tipo = id.split("-"); 
                        if (tipo[0] == 'transmision') {

                            var tmp = id.split("!"); 

                            var tmp2 = tmp[0].split('-')
                            var tema = tmp2[1]
                            var fecha = tmp[1]
                            var hora = tmp[2]
                            var presentador = tmp[3]


                            var contenido = 'Tema: ' + tema + '<br>'
                            contenido += 'Fecha: ' + fecha + '<br>'
                            contenido += 'Hora: ' + hora + '<br>'
                            contenido += 'Presentador: ' + presentador + '<br>'

                            eventElement.find(".fc-title").append("  <i class='zmdi zmdi-camera-add'></i>");
                        }else if (tipo[0] == 'taller'){

                            titulo = eventElement.find(".fc-title").text()

                            var tmp = id.split("!"); 
                
                            var tmp2 = tmp[0].split('-')
                            var nombre = tmp2[1]
                            var especialidad = tmp[1]
                            var imagen_instructor = tmp[2]
                            var sexo = tmp[3]
                            var hora = tmp[4]

                            if(imagen_instructor){
                                imagen = '/assets/uploads/instructor/'+imagen_instructor

                            }else{
                                if(sexo == 'F'){
                                    imagen = '/assets/img/Mujer.jpg'
                                }else{
                                    imagen = '/assets/img/Hombre.jpg'
                                }
                            }

                            if(sexo == 'F'){
                                sexo_instructor = 'Instructora:'
                            }else{
                                sexo_instructor = 'Instructor:'
                            }


                            var contenido = titulo + '<br>'
                            contenido += sexo_instructor + ' ' + nombre + ' <img class="lv-img-sm" src="http://'+location.host+imagen+'" alt="">' + '<br>'
                            contenido += 'Especialidad: ' + especialidad + '<br>'
                            contenido += 'Hora: ' + hora + '<br>'

                            eventElement.find(".fc-title").append("  <i class='icon_a-talleres'></i>");
                            
                            
                        }else if (tipo[0] == 'clase'){
                            titulo = eventElement.find(".fc-title").text()

                            if(titulo != "CANCELADA"){

                                var tmp = id.split("!"); 
                    
                                var tmp2 = tmp[0].split('-')
                                var nombre = tmp2[1]
                                var especialidad = tmp[1]
                                var nivel = tmp[2]
                                var imagen_instructor = tmp[3]
                                var sexo = tmp[4]
                                var hora = tmp[5]
                                var nombre_clase = event.nombre_clase

                                if(imagen_instructor){
                                    imagen = '/assets/uploads/instructor/'+imagen_instructor

                                }else{
                                    if(sexo == 'F'){
                                        imagen = '/assets/img/Mujer.jpg'
                                    }else{
                                        imagen = '/assets/img/Hombre.jpg'
                                    }
                                }

                                if(sexo == 'F'){
                                    sexo_instructor = 'Instructora:'
                                }else{
                                    sexo_instructor = 'Instructor:'
                                }


                                var contenido = nombre_clase + '<br>'
                                contenido += sexo_instructor + ' ' + nombre + ' <img class="lv-img-sm" src="http://'+location.host+imagen+'" alt="">' + '<br>'
                                contenido += 'Especialidad: ' + especialidad + '<br>'
                                contenido += 'Nivel: ' + nivel + '<br>'
                                contenido += 'Hora: ' + hora + '<br>'

                                eventElement.find(".fc-title").append("  <i class='icon_a-clases-grupales'></i>");
                            }else{

                                var check = event.url

                                var tmp = check.split("!");

                                if(tmp[1]){
                                    var contenido = tmp[1].substr(0, 50) + '...'
                                }else{
                                    contenido = ''
                                }
                
                                eventElement.find(".fc-title").append("  <i class='zmdi zmdi-close-circle f-15'></i>");
                            }
                            
                        }
                        else if (tipo[0] == 'clasepersonalizada'){

                            var tmp = id.split("!"); 
                    
                            var tmp2 = tmp[0].split('-')
                            var instructor = tmp2[1]
                            var especialidad = tmp[1]
                            var nombre = tmp[2]

                            var imagen_instructor = tmp[3]
                            var sexo = tmp[4]
                            var hora = tmp[5]

                            if(imagen_instructor){
                                imagen = '/assets/uploads/instructor/'+imagen_instructor

                            }else{
                                if(sexo == 'F'){
                                    imagen = '/assets/img/Mujer.jpg'
                                }else{
                                    imagen = '/assets/img/Hombre.jpg'
                                }
                            }

                            if(sexo == 'F'){
                                sexo_instructor = 'Instructora:'
                            }else{
                                sexo_instructor = 'Instructor:'
                            }


                            var contenido = sexo_instructor + ' ' + instructor + ' <img class="lv-img-sm" src="http://'+location.host+imagen+'" alt="">' + '<br>'
                            contenido += 'Especialidad: ' + especialidad + '<br>'
                            contenido += 'Nombre: ' + nombre + '<br>'
                            contenido += 'Hora: ' + hora + '<br>'

                            eventElement.find(".fc-title").append("  <i class='icon_a-clase-personalizada'></i>");
                        }
                        else if (tipo[0] == 'taller'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-talleres'></i>");
                        }
                        else if (tipo[0] == 'fiesta'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-fiesta'></i>");
                        }else if (tipo[0] == 'cita') {

                            var tmp = id.split("!"); 
                    
                            var tmp2 = tmp[0].split('-')
                            var instructor = tmp2[1]
                            var tipo = tmp[1]
                            var imagen_instructor = tmp[2]
                            var sexo = tmp[3]
                            var hora = tmp[4]
                            var tipo_pago = tmp[5]

                            if(imagen_instructor){
                                imagen = '/assets/uploads/instructor/'+imagen_instructor

                            }else{
                                if(sexo == 'F'){
                                    imagen = '/assets/img/Mujer.jpg'
                                }else{
                                    imagen = '/assets/img/Hombre.jpg'
                                }
                            }

                            if(sexo == 'F'){
                                sexo_instructor = 'Instructora:'
                            }else{
                                sexo_instructor = 'Instructor:'
                            }

                            var contenido = sexo_instructor + ' ' + instructor + ' <img class="lv-img-sm" src="http://'+location.host+imagen+'" alt="">' + '<br>'
                            contenido += 'Tipo: ' + tipo + '<br>'
                            contenido += 'Hora: ' + hora + '<br>'
                            contenido += 'Modalidad de Pago: ' + tipo_pago + '<br>'

                            eventElement.find(".fc-title").append("  <i class='zmdi zmdi-calendar-check'></i>");
                        }

                        $(eventElement).attr('data-trigger','hover');
                        $(eventElement).attr('data-toggle','popover');
                        $(eventElement).attr('data-placement','top');
                        $(eventElement).attr('data-content','<p class="c-negro">'+contenido+'</p>');
                        $(eventElement).attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
                        $(eventElement).attr('data-container','body');
                        $(eventElement).attr('data-html','true');
                        $(eventElement).attr('title','');

                        tipo = $('#tipo').val();

                        if(tipo != 0){
                            return tipo.indexOf(event.tipo) >= 0
                        }

                    },
                });

                //Create and ddd Action button with dropdown in Calendar header. 
                var actionMenu = '<ul class="actions actions-alt" id="fc-actions">' +
                                    '<li class="dropdown">' +
                                        '<a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>' +
                                        '<ul class="dropdown-menu dropdown-menu-right">' +
                                            '<li class="active">' +
                                                '<a data-view="month" href="">Vista Mensual</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a data-view="basicWeek" href="">Vista Semanal</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a data-view="agendaWeek" href="">Vista Agenda Semanal</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a data-view="basicDay" href="">Vista Diaria</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a data-view="agendaDay" href="">Vista Agenda Diaria</a>' +
                                            '</li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</li>';


                cId.find('.fc-toolbar').append(actionMenu);

                var actionMenu = '<ul class="actions actions-alt" id="fc-tipo">' +
                                    '<li class="dropdown">' +
                                        '<a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>' +
                                        '<ul class="dropdown-menu dropdown-menu-left">' +
                                            '<li>' +
                                                '<a class="pointer active" data-tipo="0">Todos</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="clases-grupales">Clases Grupales</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="clases-personalizadas">Clases Personalizadas</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="fiestas-eventos">Fiestas y Eventos</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="talleres">Talleres</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="citas">Citas</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="transmisiones">Transmisiones</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a class="pointer" data-tipo="nueva-clase-grupal">Clases de Nuevo Inicio</a>' +
                                            '</li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</li>';

                cId.find('.fc-clear').after(actionMenu);
                
                //Event Tag Selector
                (function(){
                    $('body').on('click', '.event-tag > span', function(){
                        $('.event-tag > span').removeClass('selected');
                        $(this).addClass('selected');
                    });
                })();
            
                //Add new Event
                $('body').on('click', '#addEvent', function(){
                    var eventName = $('#eventName').val();
                    var tagColor = $('.event-tag > span.selected').attr('data-tag');
                        
                    if (eventName != '') {
                        //Render Event
                        $('#calendar').fullCalendar('renderEvent',{
                            title: eventName,
                            start: $('#getStart').val(),
                            end:  $('#getEnd').val(),
                            allDay: true,
                            className: tagColor
                            
                        },true ); //Stick the event
                        
                        $('#addNew-event form')[0].reset()
                        $('#addNew-event').modal('hide');
                    }
                    
                    else {
                        $('#eventName').closest('.form-group').addClass('has-error');
                    }
                });   

                //Calendar views
                $('body').on('click', '#fc-actions [data-view]', function(e){
                    e.preventDefault();
                    var dataView = $(this).attr('data-view');
                    
                    $('#fc-actions li').removeClass('active');
                    $(this).parent().addClass('active');
                    cId.fullCalendar('changeView', dataView);  
                });

                $('body').on('click', '#fc-tipo', function(e){
                    e.preventDefault();
                });


                $(".dropdown-menu a").unbind('click').bind('click', function(e) {
                    tipo = $(this).data('tipo')
                    $('#tipo').val(tipo)
                    cId.fullCalendar('rerenderEvents');
                    $('.dropdown').removeClass('open')
                });


                $('.agendar').on('click', function(e){
                    e.preventDefault();
                    var agendar = $(this).data('agendar');

                    $('#agendar').val(agendar);
                    $("#frm_agendar").submit();
                     
                });

                $('.actividad').on('click', function(e){
                    e.preventDefault();
                     
                });

                $('.disabled').attr('data-trigger','hover');
                $('.disabled').attr('data-toggle','popover');
                $('.disabled').attr('data-placement','top');
                $('.disabled').attr('data-content','<p class="c-negro">Esta clase esta vencida</p>');
                $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
                $('.disabled').attr('data-container','body');
                $('.disabled').attr('data-html','true');
                $('.disabled').attr('title','');

                $('[data-toggle="popover"]').popover(); 

        

            });   

            $('body').click(function() {
                $('[data-toggle="popover"]').popover(); 
            });

                  
        </script>
@stop
