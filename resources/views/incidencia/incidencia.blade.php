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
        <div class="container invoice">
            <div class="block-header hidden-print">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>

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

                    <br>

                    <span class="f-22 f-700">Academia {{$academia->academia_nombre}}</span>

                    <div class="clearfix"></div>

                    <span class="f-16 f-700 pull-right">R: {{$academia->identificacion}}</span>

                    <div class="clearfix"></div>

                    <hr class="linea-morada">   
                </div>
                
                <div class="card-body card-padding">
                    <div class="row m-b-25">
                        <div class="col-sm-12 f-16 f-700 p-b-30">

                            ✔   Dirigido a : {{$usuario->nombre}} {{$usuario->apellido}} <br> 
                            ✔   Fecha : {{$fecha}} <br>
                            ✔   Hora : {{$hora}} <br>

                            <div class="clearfix p-b-20"></div>
                     

                            <hr class="linea-morada">
                        </div>


                        <div class="col-sm-12 text-center p-t-30">
                            <span class="f-22 f-700 c-morado"> INCIDENCIA </span>
                            <hr class="linea-morada">
                        </div>


                        <div class="col-sm-12 f-16 f-700">
                            
                            <div class="clearfix p-b-20"></div>

                            <div class="col-sm-12 text-center">
                                {!! nl2br($incidencia->mensaje) !!}
                            </div>
                            
                            
                            <div class="clearfix p-b-20"></div>
                            <div class="clearfix p-b-20"></div>
                            <div class="clearfix p-b-20"></div>
                            <div class="clearfix p-b-20"></div>

                            <hr class="linea-morada">

                            Realizado por : {{$administrador->nombre}} {{$administrador->apellido}}

                            @if($administrador->telefono OR $administrador->celular)

                                <br><br>

                                Telefonos : {{$administrador->telefono}} / {{$administrador->celular}}

                            @endif

                            <br><br>

                            <div class="row m-b-25">
                                <div class="col-sm-12 f-16 text-center" style="margin-top: 100px">

                                     <hr class="linea-morada">

                                    <span class="f-16"> Academia <b>{{$academia->academia_nombre}}</b>, Dirección: {{$academia->direccion}}, Números telefónico ( {{$academia->telefono}} / {{$academia->celular}} )  </br>

                                    {{$academia->correo}} </br></br>

                                    <b>En nuestra tripulación actuamos apegados a nuestros valores </b>


                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
  

    </section>


@stop