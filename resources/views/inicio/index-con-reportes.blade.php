@extends('layout.master')

@section('css_vendor')


	<link href="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">        
            
@stop

@section('js_vendor')

	<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
    <script src="{{url('/')}}/assets/vendors/sparklines/jquery.sparkline.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    
    <script src="{{url('/')}}/assets/vendors/bower_components/moment/min/moment.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
    <script src="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="{{url('/')}}/assets/js/index-con-reportes/flot-charts/curved-line-chart.js"></script>
    <script src="{{url('/')}}/assets/js/index-con-reportes/flot-charts/line-chart.js"></script>
    <script src="{{url('/')}}/assets/js/index-con-reportes/charts.js"></script>
    <script src="{{url('/')}}/assets/js/index-con-reportes/functions.js"></script>

@stop

@section('content')

	<section id="content">
    	<div class="container">

			<!-- <div class="card">
			    <div class="card-header">
			        <h2>Sales Statistics <small>Vestibulum purus quam scelerisque, mollis nonummy metus</small></h2>
			        
			        <ul class="actions">
			            <li>
			                <a href="#">
			                    <i class="zmdi zmdi-refresh-alt"></i>
			                </a>
			            </li>
			            <li>
			                <a href="#">
			                    <i class="zmdi zmdi-download"></i>
			                </a>
			            </li>
			            <li class="dropdown">
			                <a href="#" data-toggle="dropdown">
			                    <i class="zmdi zmdi-more-vert"></i>
			                </a>
			                
			                <ul class="dropdown-menu dropdown-menu-right">
			                    <li>
			                        <a href="#">Change Date Range</a>
			                    </li>
			                    <li>
			                        <a href="#">Change Graph Type</a>
			                    </li>
			                    <li>
			                        <a href="#">Other Settings</a>
			                    </li>
			                </ul>
			            </li>
			        </ul>
			    </div>
			    
			    <div class="card-body">
			        <div class="chart-edge">
			            <div id="curved-line-chart" class="flot-chart "></div>
			        </div>
			    </div>
			</div> -->
			
			<div class="block-header"></div>
	
			<div class="mini-charts">
			    <div class="row">
			        <div class="col-sm-6 col-md-3">
			            <div class="mini-charts-item bgm-green">
			                <div class="clearfix">
			                    <div class="chart stats-bar"></div>
			                    <div class="count">
			                        <small>Alumnos Activos</small>
			                        <h2 id="activos">0</h2>
			                    </div>
			                </div>
			            </div>
			        </div>
			        
			        <div class="col-sm-6 col-md-3">
			            <div class="mini-charts-item bgm-orange">
			                <div class="clearfix">
			                    <div class="chart stats-bar-2"></div>
			                    <div class="count">
			                        <small>Riesgo de Ausencia</small>
			                        <h2 id="riesgo">0</h2>
			                    </div>
			                </div>
			            </div>
			        </div>
			        
			        <div class="col-sm-6 col-md-3">
			            <div class="mini-charts-item bgm-red">
			                <div class="clearfix">
			                    <div class="chart stats-line"></div>
			                    <div class="count">
			                        <small>Alumnos Inactivos</small>
			                        <h2 id="inactivos">0</h2>
			                    </div>
			                </div>
			            </div>
			        </div>
			        
			        <div class="col-sm-6 col-md-3">
			            <div class="mini-charts-item bgm-bluegray">
			                <div class="clearfix">
			                    <div class="chart stats-line-2"></div>
			                    <div class="count">
			                        <small>Alumnos en General</small>
			                        <h2 id="general">0</h2>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>


			<div class="dash-widgets">
			    <div class="row">
			        <div class="col-md-4 col-sm-6">
			            <div id="site-visits" class="dash-widget-item bgm-teal">
			                <div class="dash-widget-header">
			                    <div class="p-20">
			                        <div class="dash-widget-visits"></div>
			                    </div>
			                    
			                    <div class="dash-widget-title">Ultimo mes de Visitantes Presenciales</div>
			                    
			                    <ul class="actions actions-alt">
			                        <li class="dropdown">
			                            <a href="#" data-toggle="dropdown">
			                                <i class="zmdi zmdi-more-vert"></i>
			                            </a>
			                            
			                            <ul class="dropdown-menu dropdown-menu-right">
			                                <li>
			                                    <a href="#">Refresh</a>
			                                </li>
			                                <li>
			                                    <a href="#">Manage Widgets</a>
			                                </li>
			                                <li>
			                                    <a href="#">Widgets Settings</a>
			                                </li>
			                            </ul>
			                        </li>
			                    </ul>
			                </div>
			                
			                <div class="p-20">
			                    
			                    <small>Damas</small>
			                    <h3 id="mujeres" class="m-0 f-400">{{$mujeres}}</h3>
			                    
			                    <br/>
			                    
			                    <small>Caballeros</small>
			                    <h3 id="hombres" class="m-0 f-400">{{$hombres}}</h3>
			                    
			                    <br/>
			                    
			                    <small>Total</small>
			                    <h3 id="total" class="m-0 f-400">{{$mujeres + $hombres}}</h3>
			                </div>
			            </div>
			        </div>
			        
			        <div class="col-md-4 col-sm-6">
			            <div id="pie-charts" class="dash-widget-item">
			                <div class="bgm-cyan c-white">
			                    <div class="dash-widget-header">
			                        <div class="dash-widget-title">Ingresos</div>
			                    </div>
			                    
			                    <div class="clearfix"></div>
			                    
			                    <div class="text-center p-20 m-t-25">
			                        <div class="easy-pie main-pie mousedefault" data-percent="{{$porcentaje_ingreso_general}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($ingresos_generales, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
			                            <div class="percent">{{$porcentaje_ingreso_general}}</div>
			                            <div class="pie-title">Academia</div>
			                        </div>
			                    </div>
			                			                
				                <div class="p-t-20 p-b-20 text-center">
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_ingreso_evento}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($ingresos_eventos, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_ingreso_evento}}</div>
				                        <div class="pie-title">Eventos</div>
				                    </div>
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_ingreso_taller}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($ingresos_talleres, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_ingreso_taller}}</div>
				                        <div class="pie-title">Talleres</div>
				                    </div>
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_ingreso_campana}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($ingresos_campanas, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_ingreso_campana}}</div>
				                        <div class="pie-title">Campañas</div>
				                    </div>
				                </div>

			                </div>

			            </div>
			        </div>

			        <div class="col-md-4 col-sm-6">
			            <div id="pie-charts" class="dash-widget-item">
			                <div class="bgm-lightgreen c-white">
			                    <div class="dash-widget-header">
			                        <div class="dash-widget-title">Egresos</div>
			                    </div>
			                    
			                    <div class="clearfix"></div>
			                    
			                    <div class="text-center p-20 m-t-25">
			                        <div class="easy-pie main-pie mousedefault" data-percent="{{$porcentaje_general}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($egresos_generales, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
			                            <div class="percent">{{$porcentaje_general}}</div>
			                            <div class="pie-title">Academia</div>
			                        </div>
			                    </div>
			                			                
				                <div class="p-t-20 p-b-20 text-center">
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_evento}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($egresos_eventos, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_evento}}</div>
				                        <div class="pie-title">Eventos</div>
				                    </div>
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_taller}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($egresos_talleres, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_taller}}</div>
				                        <div class="pie-title">Talleres</div>
				                    </div>
				                    <div class="easy-pie sub-pie-2 mousedefault" data-percent="{{$porcentaje_campana}}" data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "Cantidad: {{ number_format($egresos_campanas, 2, '.' , '.') }}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "">
				                        <div class="percent">{{$porcentaje_campana}}</div>
				                        <div class="pie-title">Campañas</div>
				                    </div>
				                </div>

			                </div>

			            </div>
			        </div>
			    
			    </div>
			</div>

			<div class="row">
			    <div class="col-sm-6">
			        <!-- Recent Items -->
			        <div class="card">
			            <div class="card-header">
			                <h2>Tutoriales Recientes</h2>
			            </div>
			            
			            <div class="card-body m-t-0">
			                <table class="table table-inner table-vmiddle">
			                    <thead>
			                        <tr>
			                            <th><span style="margin-left: 10px">Nombre</span></th>
			                            <th style="width: 60px">Accion</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                        <tr>
			                            <td><span style="margin-left: 10px">Samsung Galaxy Mega</span></td>
			                            <td class="f-500 c-cyan">Ver</td>
			                        </tr>
			                        <tr>
			                            <td><span style="margin-left: 10px">Huawei Ascend P6</span></td>
			                            <td class="f-500 c-cyan">Ver</td>
			                        </tr>
			                        <tr>
			                            <td><span style="margin-left: 10px">HTC One M8</span></td>
			                            <td class="f-500 c-cyan">Ver</td>
			                        </tr>
			                        <tr>
			                            <td><span style="margin-left: 10px">Samsung Galaxy Alpha</span></td>
			                            <td class="f-500 c-cyan">Ver</td>
			                        </tr>
			                        <tr>
			                            <td><span style="margin-left: 10px">LG G3</span></td>
			                            <td class="f-500 c-cyan">Ver</td>
			                        </tr>
			                    </tbody>
			                </table>
			            </div>
			            <div id="recent-items-chart" class="flot-chart"></div>
			        </div>
			        
			    </div>
			    
			    <div class="col-sm-6">
			        <!-- Calendar -->
			        <div id="calendar-widget"></div>
			        <input type="hidden" id="tipo" name="tipo" value="0" />

		        </div>
		    </div>
		</div>
	</section>
	@include('layout.footer')

@stop

@section('js') 
            
    <script type="text/javascript">

        route_consulta="{{url('/')}}/agendar/clases-grupales/consulta-estatus-alumnos";
        route_principal="{{url('/')}}/agendar";
        route_activar="{{url('/')}}/agendar/clases-grupales/eliminar-cancelacion/";
        route_update="{{url('/')}}/agendar/clases-grupales/actualizar-cancelacion";

        $(document).ready(function(){

        	 $("#activar").prop("checked", false);

            setTimeout(function(){ 

		      	var route = route_consulta;
		      	var token = "{{ csrf_token() }}";

		      	$.ajax({
		          	url: route,
		            headers: {'X-CSRF-TOKEN': token},
		            type: 'POST',
		          	dataType: 'json',
		          success:function(respuesta){

		              $('#activos').text(respuesta.activos)
		              $('#riesgo').text(respuesta.riesgo)
		              $('#inactivos').text(respuesta.inactivos)
		              $('#general').text(parseInt(respuesta.activos + respuesta.riesgo + respuesta.inactivos))

		          },
		          error:function (msj, ajaxOptions, thrownError){
		            setTimeout(function(){ 
		              // if (typeof msj.responseJSON === "undefined") {
		              //   window.location = "{{url('/')}}/error";
		              // }
		              var nType = 'danger';
		              if(msj.responseJSON.status=="ERROR"){
		                errores(msj.responseJSON.errores);
		                var nTitle=" Ups! "; 
		                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
		              }else{
		                var nTitle=" Ups! "; 
		                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
		              }
		              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
		                
		            }, 1000);             
		          }
		      });
		    
            }, 1000); 

        });
           

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

        var cId = $('#calendar-widget'); //Change the name if you want. I'm also using thsi add button for more actions

        //Generate the Calendar
        cId.fullCalendar({
        	lang: 'es',
        	contentHeight: 'auto',
            header: {
                right: '',
                center: 'prev, title, next',
                left: ''
            },

            theme: true, //Do not remove this as it ruin the design
            selectable: true,
            selectHelper: true,
            editable: false,

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


        $('body').click(function() {
            $('[data-toggle="popover"]').popover(); 
        });

    </script>
@stop