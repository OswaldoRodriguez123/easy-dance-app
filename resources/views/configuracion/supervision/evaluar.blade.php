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
		<div class="container">
			<div class="block-header">
		        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/detalle/{{$id}}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

		        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
		            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
		                            
		            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
		                            
		            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
		                            
		            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
		                           
		            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
		        </ul>
		                
		    </div>

			<div class="card">

		        <div class="card-header ch-alt text-center">

		            @if ($academia->imagen_academia)
		                <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_academia}}" alt="">
		            @else
		                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
		            @endif
		        </div>
		
				<div class="card-body card-padding">
					<form name="agregar_evaluacion" id="agregar_evaluacion">
			            <input type="hidden" name="supervision_id" value="{{$id}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

			            <div class="row m-b-25">
			            	<div class="col-xs-6">
				                <div class="text-left m-l-25">
				  
					                <h5 id="id-supervisor_id">Supervisor: </h5>
					                <div class="clearfix"></div>
					                <div class="select">
					                    <select class="form-control selectpicker" data-live-search="true" id="supervisor_id" name="supervisor_id">
					                        @foreach ( $staffs as $staff )
					                          <option value = "{!! $staff['id'] !!}">{!! $staff['nombre'] !!} {!! $staff['apellido'] !!}</option>
					                        @endforeach 
					                    </select>
					                </div>
					                <div class="has-error" id="error-supervisor_id">
				                     	<span >
				                        	<small class="help-block error-span" id="error-supervisor_id_mensaje" ></small>                                
				                      	</span>
				                  	</div>  
					                <h4>Cargo a Supervisar: {{ $cargo }}</h4>
					                <div class="clearfix"></div>
				                	<h4>Staff a Supervisar: {{ $nombre }}</h4>
				                	<div class="clearfix"></div>     
				                </div>
			            	</div>
			                
			              	<div class="col-xs-6">
			                	<div class="i-to">
			                    	<h5>Fecha: {{ $fecha }}</h5>
			                  	</div>
			              	</div>
			            </div>

						<div class="row">
							
							<hr>

							<?php 
								$i = 0;
								$j = 1;
								$sliders = array();
							?>

							@foreach( $items_a_evaluar as $item)
	  							<?php $id = $i ?>

	  							<div class="col-md-4 m-b-25">

	                  				<div class="m-b-20 m-l-25">
		                  				@if(strlen($item) <= 30)

		                  					{{$item}}
		                  				@else
											{{ str_limit($item, $limit = 30, $end = '') }} <span class="mousedefault" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="{{$item}}" title="" data-original-title="Ayuda">... <span class="c-azul">Ver mas</span></span> 
		                  				@endif
	                  				</div>
	  								<div class="clearfix"></div>  
	  								<div class="input-slider m-b-25 m-l-25 slider-mov div_{{$id}}" id="slider{{$id}}"></div>
	  								<strong class="pull-right text-muted slider-value slider-value-visible div_{{$id}}" id="value-lower{{$id}}"></strong>

	  								<div class="text-center p-t-10">
		  								<div class="checkbox">
		  									<span id="span_{{$id}}" style="margin-right: 5px">Deshabilitar el item a evaluar</span> <input style="opacity: 1; position: relative" id="checkbox_{{$id}}" type="checkbox" checked>
		  								</div>
	  								</div>
	  							</div>


	  							<?php 

	  								if($j == 3){
	  									echo '<div class="clearfix"></div>';
	  									$j = 0;
	  								}

				                  	$sliders[$i] = $i; 
				                  	$i++;
				                  	$j++;
				                ?>
							@endforeach
							
						</div><!-- END ROW ITEMS -->

						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="text-right m-r-25 f-20 f-500">Total: 
									<span class="f-30" id="puntos_acumulados">{{count($items_a_evaluar)}}</span> acumulados de <span id="puntos_totales" class="f-30">{{(count($items_a_evaluar))*10}}</span>
									<div class="text-right" id="id-total"></div>
									<input type="hidden" name="total_nota" id="total_nota" value="{{count($items_a_evaluar)}}">
								</div>

				               <div class="has-error" id="error-total_nota">
				                    <span >
				                        <small class="help-block error-span" id="error-total_nota_mensaje" ></small>                                
				                    </span>
				                </div>

							</div>
						</div>
						<!-- observaciones -->
						<div class="clearfix p-b-35"></div>

                       	<div class="col-sm-12">
                         
                            <label for="observacion" id="id-observacion">Observaciones</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="ingresa las observaciones y detalles correspondientes a la evaluación del alumno" title="" data-original-title="Ayuda"></i>
                            <br></br>

                            <div class="fg-line">
                              <textarea class="form-control" id="observacion" name="observacion" rows="2" placeholder="1000 Caracteres"></textarea>
                            </div>
                            <div class="has-error" id="error-observacion">
                              <span >
                                <small class="help-block error-span" id="error-observacion_mensaje" ></small> 
                              </span>
                            </div>
                       	</div>


						<hr>
						<!-- SECCION BOTONES --> 
						<div class="row">
			                <div class="col-sm-12 text-right">                           
			                  <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>
			                  <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>
			                </div>
						</div>

						<div class="row">
	                        <div class="col-sm-12 text-center">
	                         
	                          <!-- <i class="zmdi zmdi-cloud zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Guardar" data-toggle="tooltip" data-placement="bottom" title=""></i> -->
	                          <a href="{{url('/')}}/configuracion/supervisiones/evaluaciones"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>
	                          <br>
	                          <span class="f-700 opaco-0-8 f-16">Sección Pruebas</span>
		                    </div>						
						</div>



						<div class="clearfix"></div>
						<div class="clearfix"></div>
						<br><br>
						<nav class="navbar navbar-default navbar-fixed-bottom">
              				<div class="container">
                            	<div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
		            				<div class="col-xs-11">
		              					<div class="clearfix p-b-20"></div>
		              					<div class="progress-fino progress-striped m-b-10">
		                				<div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		                				<div class="clearfix"></div>
		                				<input type="hidden" name="barra_de_progreso" id="barra_de_progreso">
		                				<div id="msj_porcentaje" class="m-b-20 m-l-25" style="text-align: center">0% de la nota</div>
		              				</div>
                				</div>
              				</div>
            			</nav>
					</form>	
				</div><!-- END CARD BODY -->
	
	        </div>
		</div>
	</section>

@stop


@section('js') 

	<script>

		route_agregar="{{url('/')}}/configuracion/supervisiones/evaluar";
		route_principal="{{url('/')}}/configuracion/supervisiones/evaluaciones";

		var puntos_acumulados = parseInt("{{count($items_a_evaluar)}}");
		var numero_items = parseInt("{{$numero_de_items}}");
		var puntos_totales = parseInt("{{(count($items_a_evaluar))*10}}")
		var arrayNotas = new Array();
		var items_a_evaluar = <?php echo json_encode($items_a_evaluar);?>;
		var sliders = <?php echo json_encode($sliders);?>;
		var nota_actual = 0;

		$(document).ready(function() {

		    nota_actual = $("#total_nota").attr("value");

			$("#agregar_evaluacion")[0].reset();

		  	$("#supervisor_id").val("{{$supervision->supervisor_id}}")
		  	$("#supervisor_id").selectpicker('render');

		  	$.each(sliders,function(index,id){

			  	$('#slider'+id).noUiSlider ({
					start: [ 1 ],
				    //connect: true,
				    //direction: 'rtl',
				    behaviour: 'tap-drag',
				    step: 1,
					range: {
						'min': 1,
						'max': 10
					}
				});

			    $('#slider'+id).Link('lower').to($('#value-lower'+id));
			});


			$("#barra-progreso").css({
		    	"width": ("{{$numero_de_items}}" + "%")
		 	});
			
			for (var i = 0; i < "{{count($items_a_evaluar)}}"; i++) {
				arrayNotas[i]=1;
			}

			$('.slider-mov').change(function() {
				notas = $('.slider-value-visible').text();
				//Divido la cadena usando el separador
				//punto (.) de las notas		
				arrayNotas = notas.split(".");
				puntos_acumulados = 0;
				for (var i = 0; i < arrayNotas.length-1; i++) {
				    puntos_acumulados += arrayNotas[i] << 0;
				}

				$("#puntos_acumulados").html(puntos_acumulados);
				$("#total_nota").val(puntos_acumulados);

			});

		});


		//READY

		setInterval(porcentaje, 1000);

	  	function porcentaje(){

		    var nota_total = numero_items*10;
		    
		    porcetaje = (puntos_acumulados*100)/nota_total;
		    porcetaje = porcetaje.toFixed(2);
		    $("#barra_de_progreso").attr("value",porcetaje);
		    $("#text-progreso").text(porcetaje+"%");
		    $("#barra-progreso").css({
		      "width": (porcetaje + "%")
		   	});
		    
		    if(porcetaje<="25"){
		      $("#barra-progreso").removeClass('progress-bar-success');
		      $("#barra-progreso").addClass('progress-bar-morado');
		      $("#barra-progreso").css("background-color","red");
		      $("#msj_porcentaje").html("Debe mejorar");
		    }else if(porcetaje<="50"){
		      $("#barra-progreso").removeClass('progress-bar-success');
		      $("#barra-progreso").addClass('progress-bar-morado');
		      $("#barra-progreso").css("background-color","orange");
		      $("#msj_porcentaje").html("Regular");
		    }else if(porcetaje<="75"){
		      $("#barra-progreso").removeClass('progress-bar-success');
		      $("#barra-progreso").addClass('progress-bar-morado');
		      $("#barra-progreso").css("background-color","gold");
		      $("#msj_porcentaje").html("Bueno");
		    }else{
		      $("#barra-progreso").removeClass('progress-bar-success');
		      $("#barra-progreso").addClass('progress-bar-morado');
		      $("#barra-progreso").css("background-color","greenyellow ");
		      $("#msj_porcentaje").html("Muy bueno");
		    }

		    if(porcetaje=="100" || porcetaje=="100.00"){
		      $("#barra-progreso").removeClass('progress-bar-morado');
		      $("#barra-progreso").addClass('progress-bar-success');
		      $("#barra-progreso").css("background-color","green");
		      $("#msj_porcentaje").html("Excelente");
		    }else{
		      $("#barra-progreso").removeClass('progress-bar-success');
		      $("#barra-progreso").addClass('progress-bar-morado');
		    }
	  	}

		//GUARDAR EXAMEN
	  		$("#guardar").click(function(){
	                var route = route_agregar;
	                var token = $('input:hidden[name=_token]').val();
	                var datos = $( "#agregar_evaluacion" ).serialize();

	                procesando();
	                limpiarMensaje();
	                $.ajax({

	      						url: route,
	      						headers: {'X-CSRF-TOKEN': token},
	      						type: 'POST',
	      						dataType: 'json',
	      						data: datos+'&nota_detalle='+arrayNotas+'&nombre_detalle='+items_a_evaluar,
	                    success:function(respuesta){
	                      setTimeout(function(){ 
	                        var nFrom = $(this).attr('data-from');
	                        var nAlign = $(this).attr('data-align');
	                        var nIcons = $(this).attr('data-icon');
	                        var nAnimIn = "animated flipInY";
	                        var nAnimOut = "animated flipOutY"; 
	                        if(respuesta.status=="OK"){

	                        	var nType = 'success';
	                        	$("#agregar_evaluacion")[0].reset();
	                        	var nTitle="Ups! ";
	                        	var nMensaje=respuesta.mensaje;
	                        	window.location = route_principal;
	                          	
	                        }else{
	                          var nTitle="Ups! ";
	                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
	                          var nType = 'danger';
	                          finprocesado();
	                          
	                        } 

	                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                      
	                        
	                      }, 1000);
	                    },
	                    error:function(msj){
	                      setTimeout(function(){ 
	                        if(msj.responseJSON.status=="ERROR"){
	                          console.log(msj.responseJSON.errores);
	                          errores(msj.responseJSON.errores);
	                          var nTitle="    Ups! "; 
	                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
	                        }else{
	                          var nTitle="   Ups! "; 
	                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
	                        }                        
	                        finprocesado();
	                        var nFrom = $(this).attr('data-from');
	                        var nAlign = $(this).attr('data-align');
	                        var nIcons = $(this).attr('data-icon');
	                        var nType = 'danger';
	                        var nAnimIn = "animated flipInY";
	                        var nAnimOut = "animated flipOutY";                       
	                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
	                      }, 1000);
	                    }
	                });
	            });


				function errores(merror){
					var elemento="";
					var contador=0;
					$.each(merror, function (n, c) {
						if(contador==0){
						elemento=n;
						}
						contador++;

						$.each(this, function (name, value) {              
						  var error=value;
						  $("#error-"+n+"_mensaje").html(error);             
						});
					});

					$('html,body').animate({
					    scrollTop: $("#id-"+elemento).offset().top-90,
					}, 800);

				}
				$("#cancelar").click(function(){

					$.each(sliders,function(index,array){
						$('#slider'+array).find('.noUi-origin').css('left','0%');
						$('#value-lower'+array).text("1.00");
						$("#puntos_acumulados").html(sliders.length);
						$("#total_nota").val(sliders.length);
						$("#agregar_evaluacion")[0].reset();
					});

			        $("#supervisor_id").val("{{$supervision->supervisor_id}}")
			        $("#supervisor_id").selectpicker('render');

					$('html,body').animate({scrollTop: $("#id-supervisor_id").
						offset().top-90,}, 800);
				});

	  	function limpiarMensaje(){
	    	var campo = ["supervisor_id"];
	    	fLen = campo.length;
	    	for (i = 0; i < fLen; i++) {
	        	$("#error-"+campo[i]+"_mensaje").html('');
	    	}
	  	}

	  	$('input[type="checkbox"]').change(function(){
	  		id = $(this).attr('id')
	  		explode = id.split('_')
	  		id = explode[1];
	  		valor = parseInt($("#value-lower"+id).text());

	  		if($(this).is(':checked')){

	  			$('#span_'+id).removeClass('text-success');
	  			$('#span_'+id).text('Deshabilitar el item a evaluar');

	  			$('.div_'+id).show()
	  			$('#value-lower'+id).addClass('slider-value-visible')
	  			$('#value-lower'+id).removeClass('slider-value-invisible')
	  			
	  			puntos_totales = puntos_totales + 10
	  			puntos_acumulados =  parseInt(puntos_acumulados) + valor;
	  			numero_items++
	  			arrayNotas[id] = valor;

	  		}else{

	  			$('#span_'+id).addClass('text-success');
	  			$('#span_'+id).text('Habilitar el item a evaluar');

	  			$('.div_'+id).hide()
	  			$('#value-lower'+id).removeClass('slider-value-visible')
	  			$('#value-lower'+id).addClass('slider-value-invisible')

	  			puntos_totales = puntos_totales - 10
	  			puntos_acumulados = parseInt(puntos_acumulados) - valor;
	  			numero_items--
	  			arrayNotas[id] = 0;
	  		}

	  		$("#puntos_acumulados").html(puntos_acumulados);
	  		$("#puntos_totales").html(puntos_totales);
			$("#total_nota").val(puntos_totales);
	  	})

	</script>

@stop