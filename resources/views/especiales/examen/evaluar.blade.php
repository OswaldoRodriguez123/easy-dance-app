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

        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
          <?php $url = "/especiales/examenes/detalle/$id" ?>
          <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    
          <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
              <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                              
              <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                              
              <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                              
              <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                             
              <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
          </ul>
        @else
            <a class="btn-blanco m-r-10 f-16" href="/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
        @endif
                
      </div>

	    <div class="card">
        <div class="card-header ch-alt text-center">
            @if ($academia->imagen)
              <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
            @else
              <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
            @endif
        </div>
		
				<div class="card-body card-padding">
					<form name="agregar_evaluacion" id="agregar_evaluacion">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="instructor_id" name="instructor_id" value="{{$examen->instructor_id}}">
            <input type="hidden" id="examen_id" name="examen_id" value="{{$examen->id}}">
            <div class="row m-b-25">
              <div class="col-xs-6">
                <div class="text-left m-l-25">
  
                  
                  <h4 id="id-evaluacion">Evaluaci??n: "{{ $examen->nombre }}"</h4>

                  <div class="clearfix"></div>
                	<h4>Instructor: {{ $examen->instructor_nombre }} {{ $examen->instructor_apellido }}</h4>
                	<div class="clearfix"></div>
                	<h4>Tipo de Evaluaci??n: {{ $tipo_de_evaluacion }}</h4>
                	<div class="clearfix"></div>
                	<h4>Generos: <div class="clearfix"></div> {{ $examen->generos }}</h4>
                	<div class="clearfix"></div>
                	<h5 id="id-alumno_id">Seleccione un Alumno: </h5>
                	<div class="clearfix"></div>
                  <div class="select">
                      <select class="form-control selectpicker" data-live-search="true" id="alumno_id" name="alumno_id">
                        <option value="">Seleccione</option>
                        @foreach ( $alumnos as $alumno )
                        	<option data-imagen = "{{$alumno['imagen']}}" data-sexo = "{{$alumno['sexo']}}" value = "{!! $alumno['id'] !!}">{!! $alumno['nombre'] !!} {!! $alumno['apellido'] !!} {!! $alumno['identificacion'] !!}</option>
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
                    <h5 id="id-fecha_vencimiento">Fecha de Vencimiento</h5>
                    <input name="fecha_vencimiento" id="fecha_vencimiento" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text">
                    <div class="has-error" id="error-fecha_vencimiento">
                      <span >
                          <small class="help-block error-span" id="error-fecha_vencimiento_mensaje" ></small>                                
                      </span>
                    </div>  

                    <div class="clearfix p-b-35"></div>
                    <div class="clearfix p-b-35"></div>

                    <img class="img-responsive img-circle" style="width:60px; height:60px" id="imagen_evaluar" src="" alt="">
                  </div>
              </div>
            </div>

	         <!-- SECCION ITEMS A EVALUAR --> 

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
                      <span id="span_{{$id}}" style="margin-right: 5px">Deshabilitar el item a evaluar</span> <input class="item_checkbox" style="opacity: 1; position: relative" id="checkbox_{{$id}}" type="checkbox" checked>
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
                  <span class="f-30" id="puntos_acumulados">0</span> acumulados de <span id="puntos_totales" class="f-30">{{$numero_de_items*10}}</span>
                  <div class="text-right" id="id-total"></div>
                  <input type="hidden" name="total_nota" id="total_nota" value="0">
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
               
                  <label for="observacion" id="id-observacion">Observaciones</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="ingresa las observaciones y detalles correspondientes a la evaluaci??n del alumno" title="" data-original-title="Ayuda"></i>
                  <br></br>

                  <textarea class="form-control caja" style="height:100%" id="observacion" name="observacion" rows="8" placeholder="2000 Caracteres" maxlength="2000" onkeyup="countChar(this)"></textarea>
                  <div class="opaco-0-8 text-right">Resta <span id="charNum">2000</span> Caracteres</div>

                  <div class="has-error" id="error-observacion">
                    <span >
                      <small class="help-block error-span" id="error-observacion_mensaje" ></small> 
                    </span>
                  </div>
                </div>

                <div class="clearfix p-b-35"></div>


                <!-- <div class="col-sm-12">
               <div class="form-group fg-line">
                  <label for="nombre">F??rmula</label>
                  <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-collapse">
                  <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                          <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
                            <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aqu?? 
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
                        <label id="id-cantidad_horas_practica" for="">Cantidad adicional de horas de pr??ctica semanales</label>
                        
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
                        <label id="id-taller_formula" for="">Asistencia en taller de preparaci??n especial</label>
                        
                        <br></br>
                        <input type="text" id="taller_formula" name="taller_formula" value="" hidden="hidden">
                        <div class="p-t-10">
                          <div class="toggle-switch" data-ts-color="purple">
                          <span class="p-r-10 f-700 f-16">No</span><input class="formula_switch" id="taller-switch" type="checkbox">
                          
                          <label for="taller-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                          </div>
                        </div>
                        
                     </div>
                   </div>

             
                  <div class="clearfix p-b-35"></div>

                  <div class="col-sm-12">
                     <div class="form-group fg-line ">
                        <label id="id-personalizada_formula">Pr??ctica de horas personalizadas</label >
                        
                        <br></br>
                        <input type="text" id="personalizada_formula" name="personalizada_formula" value="" hidden="hidden">
                        <div class="p-t-10">
                          <div class="toggle-switch" data-ts-color="purple">
                          <span class="p-r-10 f-700 f-16">No</span><input class="formula_switch" id="personalizada-switch" type="checkbox">
                          
                          <label for="personalizada-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                          </div>
                        </div>
                        
                     </div>
                  </div>

             
          <div class="clearfix p-b-35"></div>

          <div class="col-sm-12">
                     <div class="form-group fg-line ">
                        <label id="id-evento_formula">Participaci??n evento</label>
                        
                        <br></br>
                        <input type="text" id="evento_formula" name="evento_formula" value="" hidden="hidden">
                        <div class="p-t-10">
                          <div class="toggle-switch" data-ts-color="purple">
                          <span class="p-r-10 f-700 f-16">No</span><input class="formula_switch" id="evento-switch" type="checkbox">
                          
                          <label for="evento-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                          </div>
                        </div>
                        
                     </div>
                   </div>

             
          <div class="clearfix p-b-35"></div>


          <div class="col-sm-12">
                     <div class="form-group fg-line ">
                        <label  id="id-fiesta_formula">Participaci??n en fiesta social</label>
                        
                        <br></br>
                        <input type="text" id="fiesta_formula" name="fiesta_formula" value="" hidden="hidden">
                        <div class="p-t-10">
                          <div class="toggle-switch" data-ts-color="purple">
                          <span class="p-r-10 f-700 f-16">No</span><input class="formula_switch" id="fiesta-switch" type="checkbox">
                          
                          <label for="fiesta-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                          </div>
                        </div>
                        
                     </div>
                   </div>

                   <div class="clearfix p-b-35"></div>


                  @foreach( $formulas as $formula)

                    <div class="col-sm-12">
                      <label>{{$formula->nombre}}</label>
                      
                      <br></br>
                      <input type="text" id="{{$formula->id}}_formula" name="{{$formula->id}}_formula" value="" hidden="hidden">
                      <div class="p-t-10">
                        <div class="toggle-switch" data-ts-color="purple">
                        <span class="p-r-10 f-700 f-16">No</span><input class="formula_switch" id="{{$formula->id}}-switch" type="checkbox">
                        
                        <label class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                        </div>
                      </div>
                    </div>

                    <div class="clearfix p-b-35"></div>

                  @endforeach
                        
             
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
             </div> -->

						<hr>
						<!-- SECCION BOTONES --> 
						<div class="row">
			                <div class="col-sm-12 text-right">  
                        <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" data-estatus="0">Salvar y Continuar</button>
                        <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" data-estatus="1">Guardar Definitivamente</button>
			                  <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>
			                </div>
						</div>

						<div class="row">
              <div class="col-sm-12 text-center">
                <a href="{{url('/')}}/especiales/evaluaciones/{{$id}}"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>
                <br>
                <span class="f-700 opaco-0-8 f-16">Secci??n Pruebas</span>
              </div>						
						</div>

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
    @if($usuario_tipo != 3)
      route_principal="{{url('/')}}/especiales/evaluaciones";
    @else
      route_principal="{{url('/')}}/evaluaciones";
    @endif

    var arrayNotas = new Array();
    var items_a_evaluar = <?php echo json_encode($items_a_evaluar);?>;
    var sliders = <?php echo json_encode($sliders);?>;
    var cantidad_items = parseInt("{{$numero_de_items}}");
    var puntos_totales = parseInt("{{$numero_de_items*10}}")
    var nota_actual = 0;
    var puntos_acumulados = 0;

    $(document).ready(function() {

    	$("#agregar_evaluacion")[0].reset();

    	alumno_id = "{{{ $alumno_id or 'Default' }}}";

      if(alumno_id != 'Default'){
         $('#alumno_id').val(alumno_id)
         $('#alumno_id').selectpicker('refresh')
          
      }
      $("#agregar_evaluacion")[0].reset();

      $.each(sliders, function(index,id){

        $('#slider'+id).noUiSlider ({
          start: [ 0 ],
            //connect: true,
            //direction: 'rtl',
            behaviour: 'tap-drag',
            step: 1,
          range: {
            'min': 0,
            'max': 10
          }
        });

        $('#slider'+id).Link('lower').to($('#value-lower'+id));
      });
      
      for (var i = 0; i < cantidad_items; i++) {
        arrayNotas[i] = 0;
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

  	setInterval(porcentaje, 1000);

    function porcentaje(){

      porcetaje = (puntos_acumulados*100)/puntos_totales;
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

    $(".guardar").click(function(){
      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_evaluacion" ).serialize();
      var estatus = $(this).data('estatus')

      procesando();
      limpiarMensaje();
      $.ajax({
      	url: route,
      	headers: {'X-CSRF-TOKEN': token},
      	type: 'POST',
      	dataType: 'json',
      	data: datos+'&nota_detalle='+arrayNotas+'&nombre_detalle='+items_a_evaluar+'&estatus='+estatus,
        success:function(respuesta){
          setTimeout(function(){ 
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            if(respuesta.status=="OK"){
            	finprocesado();
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

      $.each(sliders, function(index,id){
        $('#slider'+id).find('.noUi-origin').css('left','0%');
        $('#value-lower'+id).text("0.00");
        $("#puntos_acumulados").html(0);
        puntos_acumulados = 0;
        $("#total_nota").val(0);
        $("#agregar_evaluacion")[0].reset();
      });

      $('html,body').animate({scrollTop: $("#id-alumno_id").
        offset().top-90,}, 800);
    });

    $('.item_checkbox').change(function(){
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
        cantidad_items++
        arrayNotas[id] = valor;

      }else{

        $('#span_'+id).addClass('text-success');
        $('#span_'+id).text('Habilitar el item a evaluar');

        $('.div_'+id).hide()
        $('#value-lower'+id).removeClass('slider-value-visible')
        $('#value-lower'+id).addClass('slider-value-invisible')

        puntos_totales = puntos_totales - 10
        puntos_acumulados = parseInt(puntos_acumulados) - valor;
        cantidad_items--
        arrayNotas[id] = 0;
      }

      $("#puntos_acumulados").html(puntos_acumulados);
      $("#puntos_totales").html(puntos_totales);
      $("#total_nota").val(puntos_totales);
    })

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

    $(".formula_switch").on('change', function(){
      id = $(this).attr('id')
      split = id.split("-"); 
      formula = '#'+split[0]+'_formula'
      if ($(this).is(":checked")){
        $(formula).val('1')
      }else{
        $(formula).val('0')
      }     
    });

    function collapse_minus(collaps){
      $('#'+collaps).collapse('hide');
    }

    function limpiarMensaje(){
      var campo = ["alumno_id"];
      fLen = campo.length;
      for (i = 0; i < fLen; i++) {
          $("#error-"+campo[i]+"_mensaje").html('');
      }
    }

    function countChar(val) {
      var len = val.value.length;
      if (len >= 2000) {
        val.value = val.value.substring(0, 2000);
      } else {
        $('#charNum').text(2000 - len);
      }
    };

  </script>

@stop