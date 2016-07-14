
@extends('layout.master')

@section('js_vendor')
<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
<!-- <link href="{{url('/')}}/assets/css/css_jn_02.css" rel="stylesheet" type="text/css"> -->
@stop
{{-- <div class="myback2" > --}}
@section('content')

					<!-- <div align="left" style="margin-left: 50px;">
					
					<h2 class="titulotest2"> Valeria  ¿Estás Preparado(a)  para personalizar  tu academia?</h2>
				
					<text class="subtitulos1" style="margin-left: 149px; ">Con sólo 4 pasos fáciles y listo.</text>
					</div>  -->


                    <section id="content">
                    {{--<div style="margin-bottom: 50px;">--}}

                    <div class="container">
                    
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16 volver pointer" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                    </div>
                    
                    
                    <div class="card">

                    <div class="clearfix p-b-35"></div>

                    <div class="text-center"><i class="tm-icon zmdi zmdi-settings f-60 text-center c-morado"></i></div>

                    <div class="col-md-5"></div>
                            
                            <div class="col-md-5"></div>


                            <div class="clearfix p-b-35"></div>
                            
                            <div class="f-700 f-25 text-center">{{Auth::user()->nombre}}  ¿Estás Preparado(a)  para personalizar  tu academia?</div>
                            
                            <br>

                            <div class="opaco-0-8 f-20 text-center">Con sólo 3 pasos fáciles y listo.</div>

                            <div class="clearfix p-b-35"></div>


                            <div class="clearfix p-b-35"></div>



<!-- <div class="col-md-12"align="right" style="margin-top: -70px; padding-right: 50px;">	 -->	

<!-- <section class="roww row"style=" margin-top: 3cm;"> -->

                
				<div class="row">
					<ul class="ca-menu-j">
					
				    <div class="col-sm-9 col-md-offset-2">
                    
                    <li>  
                        <a href="{{url('/')}}/configuracion/academia">
                            <span class="ca-icon-j" > <i class="icon_d-personaliza"></i> </span>
                            <div class="ca-content-j">
                                <h2 class="ca-main-j">Personaliza tu academia </h2>
                                <h3 class="ca-sub-j">Paso 1  </h3>
                            </div>
                        </a>
                    </li>

                    <!-- <ul class="ca-menu-planilla"> -->
                                    <!-- <li>
                                        <a href="{{url('/')}}/configuracion/academia">
                                            <span class="ca-icon"><i class="icon_d-personaliza"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main">Personaliza tu academia</h2>
                                                <h3 class="ca-sub">Paso 1</h3>
                                            </div>
                                        </a>
                                    </li> -->
                                  <!-- </ul> -->


                                    <li>
                                        <a href="{{url('/')}}/configuracion/clases-grupales" class="mousehand">
                                            <span class="ca-icon-j"><i class="icon_a-clases-grupales"></i></span>
                                            <div class="ca-content">
                                                <h2 class="ca-main-j">Crea tus clases grupales</h2>
                                                <h3 class="ca-sub-j">Paso 2</h3>
                                            </div>
                                        </a>
                                    </li>
                                  
					   <li>
                        <a href="{{url('/')}}/configuracion/servicios">
                            <span class="ca-icon-j" style=""><i class="demo-icon-j">&#xe802;</i></span>
                            <div class="ca-content-j">
                                <h2 class="ca-main-j">Incluye  servicios</h2>
                                <h3 class="ca-sub-j">Paso 3</h3>
                            </div>
                        </a>
                    </li>
					    <!-- <li>
                        <a href="{{url('/')}}/configuracion/productos">
                            <span class="ca-icon-j"style=" margin-top: 50px; "><i class="demo-icon-j">&#xe803;</i> </span>
                            <div class="ca-content-j">
                                <h2 class="ca-main-j ">Ingresa  productos</h2>
                                <h3 class="ca-sub-j">Paso 4</h3>
                            </div>
                        </a>
                    </li> -->
					   </div>
					   </div>
					 </ul>
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>

                     </div>
			</section>			
			  		
				
@stop
{{-- </div> --}}


@section('js') 

<script>

    $(".volver").click(function(){

        window.location="/";

    });

</script>
@stop