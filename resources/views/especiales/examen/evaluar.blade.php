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
			<!-- PRINT BUTTON -->
			<button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
	        <div class="card">
	            <div class="card-header ch-alt text-center">
	                <!--<div class="f-45 f-500 text-center">Logo Academia</div>-->
	                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
	            </div>
		
				<div class="card-body card-padding">

                            <div class="row m-b-25">
                                <div class="col-xs-6">
                                    <div class="text-left m-l-25">
                                        <!--<p class="c-gray">Invoice from</p>-->
                                        
                                        <h4>Evaluación: "{{ $examen->nombre }}"</h4>
                                        <div class="clearfix"></div>
										<h4>Instructor: {{ $examen->instructor_nombre }} {{ $examen->instructor_apellido }}</h4>
										<div class="clearfix"></div>
										<h5>Seleccione un Alumno: 
					                    <div class="select">
					                        <select class="form-control selectpicker" data-live-search="true" id="alumno_id" name="alumno_id">
					                        @foreach ( $alumno as $alumnos )
					                        <option value = "{!! $alumnos->id !!}">{!! $alumnos->nombre !!} {!! $alumnos->apellido !!}</option>
					                        @endforeach 
					                        </select>

					                    </div>
					                    </h5>
		
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <div class="i-to">
                                        <h5>Fecha: {{ $fecha }}</h5>
										 <img class="img-responsive img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="">
                                    </div>
                                </div>
                                
                            </div>

                    <!-- SECCION ITEMS A EVALUAR --> 
					<div class="row">
						
						<hr>
						@foreach( $itemsExamenes as $items)
						<?php $id = $items->id ?>
						<div class="clearfix"></div>
						<div class="col-md-4">

							<div class="m-b-20 m-l-25">{{ $items->nombre }}</div>
							<div class="clearfix">
								<div class="input-slider m-b-25 m-l-25" id="slider{{$id}}"></div>
								<strong class="pull-right text-muted" id="value-lower{{$id}}"></strong>
			                </div>    
						</div>
						@endforeach
						
					</div><!-- END ROW ITEMS -->

					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="text-right m-r-25 f-20 f-500">Total: 
								<span class="f-30" id="eval_total">50</span>
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
                          <a href="{{url('/')}}/especiales/examenes"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>

                          <br>

                          <span class="f-700 opaco-0-8 f-16">Sección Pruebas</span>
                          
                           
                        </div>						
					</div>



					<div class="clearfix"></div>
					<div class="clearfix"></div>
					<br><br>
					<div class="row">
						<div class="col-md-6">
							<div class="f-20 f-500 text-right">Evaluado Por</div>
						</div>
						<div class="col-md-6">
							<div class="f-20 f-500 text-left">Supervisado Por</div>
						</div>
					</div>


				</div><!-- END CARD BODY -->
	            


	        </div>
		</div>
	</section>

@stop


@section('js') 

<script>
	
$(document).ready(function() {
	loadId({{$id}});
});


		function loadId(id){
			//alert(id);
		
		//var slider = document.getElementById('slider');

		//var slider = $(".input-slider").attr('id');
		//alert(slider);
		//function prueba(id){

			$('#slider{{$id}}').noUiSlider ({
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
	
		    $('#slider{{$id}}').Link('lower').to($('#value-lower{{$id}}'));

		}


		$("#alumno_id").on('change',function(){
			alert($("#alumno_id").val());
		});


</script>

@stop