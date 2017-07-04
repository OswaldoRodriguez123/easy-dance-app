
@extends('layout.master')

@section('js_vendor')
<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
<!-- <link href="{{url('/')}}/assets/css/css_jn_02.css" rel="stylesheet" type="text/css"> -->
@stop

@section('content')

    <section id="content">
        <div class="container">     
            <div class="block-header">
                <a class="btn-blanco m-r-10 f-16 volver pointer" onclick="procesando()" href="{{url('/')}}/"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                    <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                    
                    <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                    
                    <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                    
                    <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                   
                    <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                </ul>
            </div>
                    
                    
            <div class="card">
                <div class="card-header">
                    <div class="col-xs-12 text-left">
                      <ul class="tab-nav tn-justified" role="tablist">
                            <li class="waves-effect"><a href="{{url('/')}}/administrativo/pagos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-pagar f-30"></div><p style=" margin-bottom: -2px;">Pagos</p></a></li>
                            <li class="waves-effect"><a href="{{url('/')}}/administrativo/acuerdos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-acuerdo-de-pago f-30"></div><p style=" margin-bottom: -2px;">Acuerdos</p></a></li>
                            <li class="waves-effect"><a href="{{url('/')}}/administrativo/presupuestos/generar" aria-controls="home11" onclick="procesando()"><div class="icon_a icon_a-presupuesto f-30"></div><p style=" margin-bottom: -2px;">Presupuestos</p></a></li>
                            <li class="waves-effect active"><a data-toggle="modal" href="{{url('/')}}/administrativo/egresos"><div class="fa fa-money f-30"></div><p style=" margin-bottom: -2px;">Egresos</p></a></li>
                                
                        </ul>
                    </div>

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                </div>

                <div class="clearfix p-b-35"></div>

                <div class="text-center">
                    <i class="tm-icon fa fa-money f-60 text-center c-morado" id="egreso"></i>
                </div>

                <div class="col-md-5"></div>
                <div class="col-md-5"></div>


                <div class="clearfix p-b-35"></div>
                
                <div class="f-700 f-25 text-center">{{Auth::user()->nombre}} ¿Cual egreso deseas agregar?</div>
                
                <br>

                <!-- <div class="opaco-0-8 f-20 text-center">Con sólo 4 pasos fáciles y listo.</div> -->

                <div class="clearfix p-b-35"></div>
                <div class="clearfix p-b-35"></div>

                
				<div class="row">
					<ul class="ca-menu-j">
				        <div class="col-sm-12" style="margin-left: 2%">
                            <li>  
                                <a href="{{url('/')}}/administrativo/egresos/generales">
                                    <span class="ca-icon-j" > <i class="icon_d-personaliza"></i> </span>
                                    <div class="ca-content-j">
                                        <h2 class="ca-main-j">Academia</h2>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/')}}/administrativo/egresos/talleres" class="mousehand">
                                    <span class="ca-icon-j"><i class="icon_a-talleres"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main-j">Talleres</h2>

                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/')}}/administrativo/egresos/fiestas" class="mousehand">
                                    <span class="ca-icon-j"><i class="icon_a-fiesta"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main-j">Fiestas y Eventos</h2>
                                    </div>
                                </a>
                            </li>
                          
        					<li>
                                <a href="{{url('/')}}/administrativo/egresos/campañas">
                                    <span class="ca-icon-j" style=""><i class="icon_a-campana"></i></span>
                                    <div class="ca-content-j">
                                        <h2 class="ca-main-j">Campañas</h2>
                                    </div>
                                </a>
                            </li>
					   </div>
					</ul>

                     
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>

                </div>
            </div>
        </div>
    </section>			
			  		
				
@stop


@section('js') 

<script>

    $(document).ready(function(){

        setTimeout(function(){ 

            $('html,body').animate({
                scrollTop: $("#egreso").offset().top-90,
            }, 1000);

        }, 1000);

    });

</script>


@stop