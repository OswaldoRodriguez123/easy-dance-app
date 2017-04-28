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
                            $fecha_start=explode('-',$evento->fecha);
                            $fecha_end=explode('-',$evento->fecha);
                            $hora_start=explode(':',$evento->hora_inicio);
                            $hora_end=explode(':',$evento->hora_final);
                            ?>
                            id: 'evento-{{$evento->id}}',
                            title: "{{$evento->nombre}}" ,
                            start: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_start[0]}}, {{$hora_start[1]}}, {{$hora_start[2]}}),
                            end: new Date({{$fecha_start[0]}}, {{$fecha_start[1]-1}}, {{$fecha_start[2]}},{{$hora_end[0]}}, {{$hora_end[1]}}, {{$hora_end[2]}}),
                            allDay: false,
                            backgroundColor:'{{$evento->color_etiqueta}}',
                            className: 'actividad',
                            url: '{{url('/')}}/configuracion/eventos-laborales/detalle/{{$evento->id}}'
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

                    }
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

                    $("#frm_agendar").submit();
                     
                });

                $('.actividad').on('click', function(e){
                    e.preventDefault();
                     
                });

                function htmlEscape(s) {
                    return (s + '').replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/'/g, '&#039;')
                        .replace(/"/g, '&quot;')
                        .replace(/ì/g, '&igrave;')
                        .replace(/\n/g, '<br />');
                }

                $('.fc-toolbar').css('background-image',"url('{{url('/')}}/assets/img/eventos_laborales_header.jpg')");


            });                        
        </script>
@stop
