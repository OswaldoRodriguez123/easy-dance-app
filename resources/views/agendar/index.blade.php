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
                                       <div class="modal-body">                           
                                       <div class="row p-t-20 p-b-0">

                                           <div class="col-sm-3">
  
                                                <img src="{{url('/')}}/assets/img/Hombre.jpg" style="width: 140px; height: 140px;" class="img-responsive opaco-0-8" alt="">

                                                <div class="clearfix p-b-15"></div>
    
                                                <span class="f-15 f-700 span_instructor"></span>

                                                  
                                           </div>

                                           <div class="col-sm-9">
                                             
                                            <p class="f-16">Horario: <span class="f-700 span_hora"></span></p>

                                            <p class="f-16">Fecha: <span class="f-700 span_fecha"></span></p> 

                                               <div class="clearfix"></div> 
                                               <div class="clearfix p-b-15"></div>


                                           </div>

                                           
                                       </div>

                                       <div class="row p-t-20 p-b-0">

                                       <hr style="margin-top:5px">

                                       <div class="col-sm-12">
                                 
                                        <label for="razon_cancelacion" id="id-razon_cancelacion">Razones de cancelación</label>
                                        <br></br>

                                        <div class="fg-line">
                                          <textarea class="form-control" id="razon_cancelacion" name="razon_cancelacion" rows="2" disabled></textarea>
                                          </div>
                                      </div>

                                       </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>


            <section id="content">
                <div class="container">

                <?php //dd($talleres[0]->nombre); ?>
<div id="calendar"></div>
                    
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
            $(document).ready(function() {
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

                    /*
                    events: [
                        {
                            title: 'Hangout with friends',
                            start: new Date(y, m, 1),
                            allDay: true,
                            className: 'bgm-cyan'
                        },
                        {
                            title: 'Meeting with client',
                            start: new Date(y, m, 10),
                            allDay: true,
                            className: 'bgm-orange'
                        },
                        {
                            title: 'Repeat Event',
                            start: new Date(y, m, 18),
                            allDay: true,
                            className: 'bgm-amber'
                        },
                        {
                            title: 'Semester Exam',
                            start: new Date(y, m, 20),
                            allDay: true,
                            className: 'bgm-green'
                        },
                        {
                            title: 'Soccor match',
                            start: new Date(y, m, 5),
                            allDay: true,
                            className: 'bgm-lightblue'
                        },
                        {
                            title: 'Coffee time',
                            start: new Date(y, m, 21),
                            allDay: true,
                            className: 'bgm-orange'
                        },
                        {
                            title: 'Job Interview',
                            start: new Date(y, m, 5),
                            allDay: true,
                            className: 'bgm-amber'
                        },
                        {
                            title: 'IT Meeting',
                            start: new Date(y, m, 5),
                            allDay: true,
                            className: 'bgm-green'
                        },
                        {
                            title: 'Brunch at Beach',
                            start: new Date(y, m, 1),
                            allDay: true,
                            className: 'bgm-lightblue'
                        },
                        {
                            title: 'Live TV Show',
                            start: new Date(y, m, 15),
                            allDay: true,
                            className: 'bgm-cyan'
                        },
                        {
                            title: 'Software Conference',
                            start: new Date(y, m, 25),
                            allDay: true,
                            className: 'bgm-lightblue'
                        },
                        {
                            title: 'Coffee time',
                            start: new Date(y, m, 30),
                            allDay: true,
                            className: 'bgm-orange'
                        },
                        {
                            title: 'Job Interview',
                            start: new Date(y, m, 30),
                            allDay: true,
                            className: 'bgm-green'
                        },
                    ],*/
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
                            url: '{{url('/')}}{{$taller['url']}}'
                            },
                        @endforeach

                        @foreach ($clases_grupales as $clase)
                            {
                            <?php
                                $fecha_start=explode('-',$clase['fecha_inicio']);
                                $fecha_end=explode('-',$clase['fecha_final']);
                                $hora_start=explode(':',$clase['hora_inicio']);
                                $hora_end=explode(':',$clase['hora_final']);

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
                            url: '{{$url}}'
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
                            url: '{{url('/')}}{{$clasepersonalizada['url']}}'
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
                            url: '{{url('/')}}{{$fiesta['url']}}'
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
                            url: '{{url('/')}}{{$cita['url']}}'
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
                                url: '{{url('/')}}/agendar/transmisiones/operaciones/{{$transmision['id']}}',

                            },
                        @endforeach
                    ],
                     
                    //On Day Select
                    select: function(start, end, allDay) {
                        //console.log(start + ' --- ' + end);

                        var d = new Date();
                        var timestamp = d.getTime(); 

                        if(end>timestamp){
                           $('#addNew-event').modal('show');   
                           $('#addNew-event input:text').val('');
                           $('#getStart').val(start);
                           $('#getEnd').val(end);
                           //console.log('bien');
                        }else{
                           //console.log('error');
                           $('#modalFechaPasada').modal('show');                            
                        }

                        
                    },
                    eventClick: function(calEvent, jsEvent, view) {

                        // console.log(calEvent.start);
                        // 
                        // 

                        if(!$(this).hasClass('disabled')){

                            var check = calEvent.url
                            var tmp = check.split("!"); 
                            console.log(tmp)

                            if(!tmp[1]){

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
                                var fecha = tmp[3]
                                var hora = tmp[4]
                                var instructor = tmp[2]
                                var cancelacion = tmp[1]
                                $('.span_fecha').text(fecha)
                                $('.span_hora').text(hora)
                                $('.span_instructor').text(instructor)
                                $('#razon_cancelacion').text(cancelacion)
                                $("#modalCancelar" ).modal('show');
                            }
                        }
                        //console.log(jsEvent);
                        //console.log(view);

                    },
                    eventRender: function(event, eventElement) {
                        var id = event.id
                        var tipo = id.split("-"); 
                        if (tipo[0] == 'transmision') {
                            eventElement.find(".fc-title").append("  <i class='zmdi zmdi-camera-add'></i>");
                        }else if (tipo[0] == 'clase'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-clases-grupales'></i>");
                        }
                        else if (tipo[0] == 'clasepersonalizada'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-clase-personalizada'></i>");
                        }
                        else if (tipo[0] == 'taller'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-talleres'></i>");
                        }
                        else if (tipo[0] == 'fiesta'){
                            eventElement.find(".fc-title").append("  <i class='icon_a-fiesta'></i>");
                        }else if (tipo[0] == 'cita') {
                            eventElement.find(".fc-title").append("  <i class='zmdi zmdi-calendar-check'></i>");
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


                $('.agendar').on('click', function(e){
                    e.preventDefault();
                    console.log("estoy aqui");
                    var agendar = $(this).data('agendar');

                    $('#agendar').val(agendar);

                    $("#frm_agendar").submit();
                     
                });

                $('.actividad').on('click', function(e){
                    e.preventDefault();
                     
                });

                $('.disabled').attr('data-trigger','hover');
                $('.disabled').attr('data-toggle','popover');
                $('.disabled').attr('data-placement','right');
                $('.disabled').attr('data-content','<p class="c-negro">Esta clase esta vencida</p>');
                $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
                $('.disabled').attr('data-html','true');
                $('.disabled').attr('title','');

                $('[data-toggle="popover"]').popover(); 

        

            });   

                  
        </script>
@stop
