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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/examenes/detalle/{{$id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de Examen</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
            </div>
			<!-- PRINT BUTTON -->
			<button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
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
				                        @foreach ( $alumnosacademia as $alumnos )
				                        <option value = "{!! $alumnos->id !!}">{!! $alumnos->nombre !!} {!! $alumnos->apellido !!}</option>
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
									 <img class="img-responsive img-circle" style="width:60px; height:60px" id="imagen_evaluar" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="">
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
									<span class="f-30" id="eval_total">{{count($itemsExamenes)}}</span>
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
					</form>	
				</div><!-- END CARD BODY -->
	
	        </div>
		</div>
	</section>
	<nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    <div class="clearfix"></div>
                    <div id="msj_porcentaje" class="m-b-20 m-l-25" style="text-align: center">0% de la nota</div>
                  </div>
                </div>
              </div>
            </nav>

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
	    $("#text-progreso").text(porcetaje+"%");
	    $("#barra-progreso").css({
	      "width": (porcetaje + "%")
	   	});
	    
	    if(porcetaje<="25"){
	      $("#barra-progreso").removeClass('progress-bar-success');
	      $("#barra-progreso").addClass('progress-bar-morado');
	      $("#barra-progreso").css("background-color","red");
	      $("#msj_porcentaje").html("debajo 25% de la nota");
	    }else if(porcetaje<="50"){
	      $("#barra-progreso").removeClass('progress-bar-success');
	      $("#barra-progreso").addClass('progress-bar-morado');
	      $("#barra-progreso").css("background-color","orange");
	      $("#msj_porcentaje").html("debajo 50% de la nota");
	    }else if(porcetaje<="75"){
	      $("#barra-progreso").removeClass('progress-bar-success');
	      $("#barra-progreso").addClass('progress-bar-morado');
	      $("#barra-progreso").css("background-color","gold");
	      $("#msj_porcentaje").html("debajo 75% de la nota");
	    }else{
	      $("#barra-progreso").removeClass('progress-bar-success');
	      $("#barra-progreso").addClass('progress-bar-morado');
	      $("#barra-progreso").css("background-color","greenyellow ");
	      $("#msj_porcentaje").html("debajo 100% de la nota");
	    }

	    if(porcetaje=="100" || porcetaje=="100.00"){
	      $("#barra-progreso").removeClass('progress-bar-morado');
	      $("#barra-progreso").addClass('progress-bar-success');
	      $("#barra-progreso").css("background-color","green");
	      $("#msj_porcentaje").html("100% maxima nota");
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
				var alumnos = <?php echo json_encode($alumnosacademia);?>;

				id = $(this).val();

				var alumno = $.grep(alumnos, function(e){ return e.id == id; });

				var imagen = alumno[0].imagen;
		        var sexo = alumno[0].imagen;

		        if(imagen){
		          $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
		        }else{
		          if(sexo == 'M'){
		            $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
		          }else{
		            $('#imagen_evaluar').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
		          }
		        }
			});

</script>

@stop