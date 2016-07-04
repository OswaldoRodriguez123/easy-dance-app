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

	        <div class="card">
	            <div class="card-header">
	                <div class="f-45 f-500 text-center">Iniciar Prueba</div>
	            </div>
				<hr>
			
				<div class="card-body card-padding">

					<div class="row">
						
					
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<label>Seleccione un Alumno</label>
		                    <div class="select">
		                        <select class="form-control selectpicker" data-live-search="true" id="alumno_id" name="alumno_id">
		                        @foreach ( $alumno as $alumnos )
		                        <option value = "{!! $alumnos['id'] !!}">{!! $alumnos->nombre !!} {!! $alumnos->apellido !!}</option>
		                        @endforeach 
		                        </select>
		                      </div> 
		                </div>
		                <div class="col-md-4"></div>      
						<div class="clearfix"></div>
						<hr>

					</div>

					<div class="row">
						<div class="f-25">SubTitulo</div>
						<hr>
						<div class="clearfix"></div>
						<div class="col-md-4">
							<div class="m-b-20">Prueba 1</div>
							<div class="clearfix">
								<div class="input-slider m-b-25" id="slider"></div>
								<strong class="pull-right text-muted" id="value-lower"></strong>
			                    <!--<strong class="pull-left text-muted" id="value-upper"></strong>-->
			                    
			                </div>    
						</div>
						<div class="col-md-4">
							<div class="fg-line"><input type="text" name="nota" id="nota" class="form-control"></div>
						</div>
						<div class="col-md-4">
							<div class="fg-line"><input type="text" name="" class="form-control"></div>
						</div>

					</div>



				</div><!-- END CARD BODY -->
	            
	            <!--<div class="card-body card-padding">
	                <p class="f-500 c-black m-b-20">Basic Example</p>
	                
	                <div class="input-slider m-b-25" id="slider"></div>
	                
	                <br/>
	                
	                <p class="f-500 c-black m-b-20">Range Slider</p>
	                
	                <div class="input-slider-range m-b-25"></div>
	                
	                <br/>
	                
	                <p class="f-500 c-black m-b-20">Output Value with tap and drag</p>
	                
	                <div class="m-b-20 clearfix">
	                    <div class="input-slider-values m-b-15"></div>
	                    <strong class="pull-left text-muted" id="value-upper"></strong>
	                    <strong class="pull-right text-muted" id="value-lower"></strong>
	                </div>
	                
	                <br/>
	                
	                <p class="f-500 c-black m-b-5">Optional ColoR Schemes</p>
	                <small>Use the given data attribute to change the color scheme of the Toggle Switch</small>
	                
	                <br/>
	                <br/>
	                <br/>
	                
	                <div class="input-slider m-b-25" data-is-start="35" data-is-color="red"></div>
	                
	                <br/>
	                
	                <div class="input-slider m-b-25" data-is-color="blue" data-is-start="95"></div>
	                
	                <br/>
	                
	                <div class="input-slider m-b-25" data-is-color="cyan" data-is-start="20"></div>
	                
	                <br/>
	                
	                <div class="input-slider m-b-25" data-is-color="amber" data-is-start="55"></div>
	                
	                <br/>
	                
	                <div class="input-slider m-b-25" data-is-color="green" data-is-start="70"></div>
	                
	            </div>-->
	        </div>
		</div>
	</section>

@stop


@section('js') 

<script>
	
	//var slider = document.getElementById('slider');

	$('#slider').noUiSlider ({
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
	
	$('#slider').Link('lower').to($('#value-lower'));
    //$('#slider').Link('upper').to($('#value-upper'), 'html');
    //$("#nota").val($('#slider').Link('lower').to($('#value-lower')));


var inputFormat = document.getElementById('nota');

$("#slider").noUiSlider('update', function( values, handle ) {
	$("#nota").value = values[handle];
});

$("#nota").addEventListener('change', function(){
	$("#slider").noUiSlider.set(this.value);
});



</script>

@stop