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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Valoración</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
            </div>
	        <div class="card">
	            <div class="card-header ch-alt text-center">
	                <!--<div class="f-45 f-500 text-center">Logo Academia</div>-->
	                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
	            </div>
		
				<div class="card-body card-padding">
					<form
					 name="agregar_evaluacion" id="agregar_evaluacion">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="row m-b-25">
	                        <div class="col-xs-6">
	                            <div class="text-left m-l-25">
	                                <!--<p class="c-gray">Invoice from</p>-->
	                                
	                                <h4 id="id-evaluacion">Evaluación: "{{ $examen->nombre }}"</h4>
	                                <div class="clearfix"></div>
									<h4>Instructor: {{ $examen->instructor_nombre }} {{ $examen->instructor_apellido }}</h4>
									<div class="clearfix"></div>
									<h4>Tipo de Evaluación: {{ $tipo_de_evaluacion }}</h4>
									<div class="clearfix"></div>
									<h4>Generos: <div class="clearfix"></div> {{ $examen->generos }}</h4>
									<div class="clearfix"></div>
									<h5 id="id-alumno_id">Seleccione un Alumno: </h5>
									<div class="clearfix"></div>
				                    <div class="select">
				                        <select class="form-control selectpicker" data-live-search="true" id="alumno_id" name="alumno_id">
				                        <option value="">Seleccione</option>
				                        @foreach ( $alumnos as $alumno )
				                        <option data-imagen = "{{$alumno->imagen}}" data-sexo = "{{$alumno->sexo}}" value = "{!! $alumno->id !!}">{!! $alumno->nombre !!} {!! $alumno->apellido !!} {!! $alumno->identificacion !!}</option>
				                        @endforeach 
				                        </select>
				                    </div>

	                                 <div class="has-error" id="error-alumno_id">
	                                      <span >
	                                          <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                
	                                      </span>
	                                  </div>				                    

	                            </div>
	                        </div>
	                        
	                        <div class="col-xs-6">
	                            <div class="i-to">
	                                <h5>Fecha: {{ $fecha }}</h5>
									 <img class="img-responsive img-circle" style="width:60px; height:60px" id="imagen_evaluar" src="" alt="">
	                            </div>
	                        </div>
	                    </div>

	                    <!-- SECCION ITEMS A EVALUAR --> 
						<div class="row">
							
							<hr>
							{{--$itemsExamenes--}}
							<?php $i=0 ?>
							@foreach( $itemsExamenes as $items)
							<?php $id = $i ?>
							<div class="clearfix"></div>
							<div class="col-md-4">

								<div class="m-b-20 m-l-25">{{ $items }}</div>
								<div class="clearfix">
									<div class="input-slider m-b-25 m-l-25 slider-mov" id="slider{{$id}}"></div>
									<strong class="pull-right text-muted slider-value" id="value-lower{{$id}}"></strong>
				                </div>    
							</div>
							<?php $item[$i] = $i ?>
							<?php $i++ ?>
							@endforeach
							
						</div><!-- END ROW ITEMS -->

						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="text-right m-r-25 f-20 f-500">Total: 
									<span class="f-30" id="eval_total">{{count($itemsExamenes)}}</span> acumulados de <span class="f-30">{{(count($itemsExamenes))*10}}</span>
									<div class="text-right" id="id-total"></div>
									<input type="hidden" name="total_nota" id="total_nota" value="{{count($itemsExamenes)}}">
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


                                  <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Fórmula</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Desde este campo podrás crear distintos instructores, especialidades, horarios y días de la semana de la clase personalizada" title="" data-original-title="Ayuda"></i>
                                    <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
                                              <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvanzado" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                    
                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                           
                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label id="id-cantidad_horas_practica" for="">Cantidad adicional de horas de práctica semanales</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
		                                      <div class="fg-line">
		                                      <input type="text" class="form-control input-sm input-mask" name="cantidad_horas_practica" id="cantidad_horas_practica" data-mask="0000" placeholder="Ej: 3">
		                                      </div>

                                          
                                       </div>
                                       <div class="has-error" id="error-cantidad_horas_practica">
                                            <span >
                                                <small class="help-block error-span" id="error-cantidad_horas_practica_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                                     <div class="clearfix p-b-35"></div>

                                     <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label id="id-asistencia_taller" for="">Asistencia en taller de preparación especial</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="asistencia_taller" name="asistencia_taller" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="taller-switch" type="checkbox">
                                            
                                            <label for="taller-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-asistencia_taller">
                                            <span >
                                                <small class="help-block error-span" id="error-asistencia_taller_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                               
                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label id="id-practica_horas_personalizadas">Práctica de horas personalizadas</label > <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="practica_horas_personalizadas" name="practica_horas_personalizadas" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="personalizada-switch" type="checkbox">
                                            
                                            <label for="personalizada-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-practica_horas_personalizadas">
                                            <span >
                                                <small class="help-block error-span" id="error-practica_horas_personalizadas_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                               
                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label id="id-participacion_evento">Participación evento</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="participacion_evento" name="participacion_evento" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="evento-switch" type="checkbox">
                                            
                                            <label for="evento-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-participacion_evento">
                                            <span >
                                                <small class="help-block error-span" id="error-participacion_evento_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                               
                            <div class="clearfix p-b-35"></div>


                            <div class="col-sm-12">
                                       <div class="form-group fg-line ">
                                          <label  id="id-participacion_fiesta_social">Participación en fiesta social</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda pointer" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Los clientes  podrán ver tu perfil como bailarín o instructor  al compartir las actividades en las res sociales" title="" data-original-title="Ayuda"></i>
                                          
                                          <br></br>
                                          <input type="text" id="participacion_fiesta_social" name="participacion_fiesta_social" value="" hidden="hidden">
                                          <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="fiesta-switch" type="checkbox">
                                            
                                            <label for="fiesta-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                          </div>
                                          
                                       </div>
                                       <div class="has-error" id="error-participacion_fiesta_social">
                                            <span >
                                                <small class="help-block error-span" id="error-participacion_fiesta_social_mensaje" ></small>                                           
                                            </span>
                                        </div>
                                     </div>

                               
                            <div class="clearfix p-b-35"></div>
                            <div class="clearfix p-b-35"></div>

                            <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseAvanzado')" ></i></div>
                            
                            <div class="clearfix p-b-35"></div>
                               <hr></hr>


                                        </div>
                                    </div>
                                    </div>
                                    </div>
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
	                          <a href="{{url('/')}}/especiales/evaluaciones"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>
	                          <br>
	                          <span class="f-700 opaco-0-8 f-16">Sección Pruebas</span>
		                    </div>						
						</div>



						<div class="clearfix"></div>
						<div class="clearfix"></div>
						<br><br>
						<!-- <div class="row">
							<div class="col-md-6">
								<div class="f-20 f-500 text-right">Evaluado Por</div>
							</div>
							<div class="col-md-6">
								<div class="f-20 f-500 text-left">Supervisado Por</div>
							</div>
						</div> -->
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

route_agregar="{{url('/')}}/especiales/evaluaciones/agregar";
route_principal="{{url('/')}}/especiales/evaluaciones";

var arrayNotas = new Array();

$(document).ready(function() {
	$("#agregar_evaluacion")[0].reset();
	$("#alumno_id").selectpicker('render');
	@foreach( $item as $items)
		loadId({{$items}});
	@endforeach

	$("#barra-progreso").css({
	      "width": ({{$numero_de_items}} + "%")
	   	});
	
	for (var i = 0; i < {{count($itemsExamenes)}}; i++) {
		arrayNotas[i]=1;
	}
	$('.slider-mov').change(function() {
		notas = $('.slider-value').text();
		//Divido la cadena usando el separador
		//punto (.) de las notas		
		arrayNotas = notas.split(".");
		var total = 0;
		for (var i = 0; i < arrayNotas.length-1; i++) {
		    total += arrayNotas[i] << 0;
		}
		$("#eval_total").html(total);
		$("#total_nota").val(total);
	});

});
	//Aqui cargo las barra de Slide	
	function loadId(id){

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
	}


		/*$("#alumno_id").on('change',function(){
			console.log($("#alumno_id").val());
			console.log($(".sexo-alumno").html());

		});*/

	setInterval(porcentaje, 1000);

  	function porcentaje(){

  		var numero_items = {{$numero_de_items}};
	    var nota_total = numero_items*10;
	    var nota_actual =$("#total_nota").attr("value");
	    
	    porcetaje = (nota_actual*100)/nota_total;
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

	   	
	    //$("#barra-progreso").s
  	}

	//GUARDAR EXAMEN
  		$("#guardar").click(function(){
  				//alert(items);
                var route = route_agregar;
                var instructor = {{$examen->instructor_id}}
                //var total = $("#eval_total").text();
                //var alumno = $("#alumno_id").val();
                var academia = {{$examen->academia_id}}
                var examen = {{$examen->id}}
                var itemsExamenes = <?php echo json_encode($itemsExamenes);?>;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_evaluacion" ).serialize()+'&academia='+academia+'&instructor='+instructor+'&examen='+examen+'&nota_detalle='+arrayNotas+'&nombre_detalle='+itemsExamenes; 
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');
                //limpiarMensaje();
                $.ajax({

						url: route,
						headers: {'X-CSRF-TOKEN': token},
						type: 'POST',
						dataType: 'json',
						data: datos,
						/*data: {
							datos: datos,
                        	instructor : instructor,
                        	academia : academia,
                        	examen : examen
						},*/


                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          	//finprocesado();
                          	var nType = 'success';
                          	$("#agregar_evaluacion")[0].reset();
                          	var nTitle="Ups! ";
                          	var nMensaje=respuesta.mensaje;
							notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                          	
                          	window.location = route_principal 
                          	
                          	
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
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
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
				var campo = ["alumno_id","total_nota"];
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
				var items_examen = <?php echo json_encode($item);?>;
				$.each(items_examen,function(index,array){
					$('#slider'+array).find('.noUi-origin').css('left','0%');
					$('#value-lower'+array).text("1.00");
					$("#eval_total").html(items_examen.length);
					$("#total_nota").val(items_examen.length);
					$("#agregar_evaluacion")[0].reset();
					$("#alumno_id").selectpicker('render');
				});
				$('html,body').animate({scrollTop: $("#id-evaluacion").
					offset().top-90,}, 800);
			});

			$("#alumno_id").change(function(){

				imagen = $(this).find("option:selected").attr("data-imagen");

		        if(imagen){
		          $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
		        }else{
		        	sexo = $(this).find("option:selected").attr("data-sexo");
		          if(sexo == 'M'){
		            $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
		          }else{
		            $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
		          }
		        }
			});

	  $('#collapseAvanzado').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseAvanzado').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $("#taller-switch").on('change', function(){
	      if ($("#taller-switch").is(":checked")){
	        $("#asistencia_taller").val('1');
	      }else{
	        $("#asistencia_taller").val('0');
	      }     
	    });

      $("#personalizada-switch").on('change', function(){
	      if ($("#personalizada-switch").is(":checked")){
	        $("#practica_horas_personalizadas").val('1');
	      }else{
	        $("#practica_horas_personalizadas").val('0');
	      }     
	    });

      $("#evento-switch").on('change', function(){
	      if ($("#evento-switch").is(":checked")){
	        $("#participacion_evento").val('1');
	      }else{
	        $("#participacion_evento").val('0');
	      }     
	    });

      $("#fiesta-switch").on('change', function(){
	      if ($("#fiesta-switch").is(":checked")){
	        $("#participacion_fiesta_social").val('1');
	      }else{
	        $("#participacion_fiesta_social").val('0');
	      }     
	    });

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

</script>

@stop