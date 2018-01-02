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


            <section id="content">
                <div class="container">

                <div id="calendar"></div>
                <input type="hidden" id="cargo" name="cargo" value="0" />
                    
                
                      
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

                    theme: true, 
                    selectable: true,
                    selectHelper: true,
                    editable: false,
                    lang: 'es',

    
                    events: [

                        @foreach ($eventos as $evento)
                        {
                            <?php
                        
                                $fecha_start=explode('-',$evento["fecha"]);
                                $fecha_end=explode('-',$evento["fecha"]);
                                $hora_start=explode(':',$evento["hora_inicio"]);

                                if(\Carbon\Carbon::parse($evento['fecha']) >= \Carbon\Carbon::now()->subDay()){
                                    $etiqueta = $evento['color_etiqueta'];
                                    $actividad = 'actividad';
                                    $url = "detalle/{$evento['id']}";
                                }else{
                                    $etiqueta = '#B8B8B8';
                                    $actividad = 'disabled';
                                    $url = '';
                                }
                       
                            ?>
                            id: 'evento-{{$evento["id"]}}',
                            title: "{{$evento['nombre']}}" ,
                            start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                            end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                            allDay: false,
                            backgroundColor:'{{$etiqueta}}',
                            className: '{{$actividad}}',
                            url: '{{$url}}',
                            cargo: '{{$evento["cargo"]}}',
                            dia: '{{$evento["dia"]}}',
                            sexo: '{{$evento["sexo"]}}',
                            staff: '{{$evento["staff"]}}',
                            clase_grupal_nombre: '{{$evento["clase_grupal_nombre"]}}',
                            instructor: '{{$evento["instructor"]}}',
                            especialidad: '{{$evento["especialidad"]}}',
                            nivel: '{{$evento["nivel"]}}',
                            hora: '{{$evento["hora"]}}',
                            descripcion: <?php echo json_encode(title_case($evento['descripcion'])) ?>,
                        },
                        @endforeach 
            
                    ],
                                     
                    //On Day Select
                    select: function(start, end, allDay) {

                        var d = new Date();
                        var timestamp = d.getTime(); 


                        if(end>timestamp){

                            var token = "{{ csrf_token() }}";

                            $.ajax({
                                url: "{{url('/')}}/guardar-fecha",
                                    headers: {'X-CSRF-TOKEN': token},
                                    type: 'POST',
                                dataType: 'json',
                                data:"fecha_inicio="+end._d,
                                success:function(respuesta){

                                    window.location = "{{url('/')}}/configuracion/eventos-laborales/agregar"

                                }
                            });
                        }else{
                           //console.log('error');
                           $('#modalFechaPasada').modal('show');                            
                        }

                        
                    },
                    eventClick: function(calEvent, jsEvent, view) {

                        // console.log(calEvent.id);
                        // //console.log(jsEvent);
                        // //console.log(view);
                        // 
                        $('#fecha_inicio').val(calEvent.start);
                        var token = "{{ csrf_token() }}";

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

                    },
                    eventRender: function(event, eventElement) {

                        var staff = event.staff
                        var imagen = event.imagen
                        var sexo = event.sexo
                        var dia = event.dia

                        if(imagen){
                            imagen = '/assets/uploads/instructor/'+imagen

                        }else{
                            if(sexo == 'F'){
                                imagen = '/assets/img/Mujer.jpg'
                            }else{
                                imagen = '/assets/img/Hombre.jpg'
                            }
                        }

                        var contenido = staff + ' <img class="lv-img-sm" src="http://'+location.host+imagen+'" alt="">' + '<br>'

                        contenido += 'Evento: ' + event.title + '<br>'
                        contenido += 'Dia de Semana: ' + dia + '<br>'
                        contenido += 'Descripción: ' + event.descripcion + '<br>'

                        if(event.clase_grupal_nombre){
                            contenido += event.clase_grupal_nombre + '<br>'
                            contenido += event.instructor + '<br>'
                            contenido += event.especialidad + '<br>'
                            contenido += event.nivel + '<br>'
                            contenido += event.hora + '<br>'
                        }
                       
                        $(eventElement).attr('data-trigger','hover');
                        $(eventElement).attr('data-toggle','popover');
                        $(eventElement).attr('data-placement','top');
                        $(eventElement).attr('data-content','<p class="c-negro">'+contenido+'</p>');
                        $(eventElement).attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
                        $(eventElement).attr('data-container','body');
                        $(eventElement).attr('data-html','true');
                        $(eventElement).attr('title','');
                        
                        cargo = $('#cargo').val();

                        if(cargo != 0){
                            return cargo.indexOf(event.cargo) >= 0
                        }

                    },
                });

                
                $('.agendar').on('click', function(e){
                    e.preventDefault();

                    $("#frm_agendar").submit();
                     
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
                                            @foreach($cargos as $cargo)
                                                '<li>' +
                                                    '<a class="pointer" data-cargo="{{$cargo->id}}">{{$cargo->nombre}}</a>' +
                                                '</li>' +
                                            @endforeach
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

                $('.disabled').attr('data-trigger','hover');
                $('.disabled').attr('data-toggle','popover');
                $('.disabled').attr('data-placement','top');
                $('.disabled').attr('data-content','<p class="c-negro">Esta actividad esta vencida</p>');
                $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
                $('.disabled').attr('data-container','body');
                $('.disabled').attr('data-html','true');
                $('.disabled').attr('title','');

                $('[data-toggle="popover"]').popover(); 

                function htmlEscape(s) {
                    return (s + '').replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/'/g, '&#039;')
                        .replace(/"/g, '&quot;')
                        .replace(/ì/g, '&igrave;')
                        .replace(/\n/g, '<br />');
                }

                $(".dropdown-menu a").unbind('click').bind('click', function(e) {
                    cargo = $(this).data('cargo')
                    $('#cargo').val(cargo)
                    cId.fullCalendar('rerenderEvents');
                    $('.dropdown').removeClass('open')
                });

                $('.fc-toolbar').css('background-image',"url('{{url('/')}}/assets/img/eventos_laborales_header.jpg')");


            }); 

            $('body').click(function() {
                $('[data-toggle="popover"]').popover(); 
            });                       
        </script>
@stop
