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

    
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 

                    <div class="block-header">
                        <h2>Factura</h2>
                    </div>
                    
                    <div class="card">
                        <div class="card-header ch-alt text-center">
                            @if ($academia->imagen_academia)
                                <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_academia}}" alt="">
                            @else
                                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                            @endif

                            <div class="clearfix m-b-20"></div>

                            <span class="c-gray">Fecha: {{ \Carbon\Carbon::createFromFormat('Y-m-d',$factura->fecha)->format('d-m-Y')}}</span>
                        </div>
                        
                        <div class="card-body card-padding">
                            <div class="row m-b-25">
                                <div class="col-xs-6">
                                    <div class="text-right">
                                        <p class="c-gray">Factura de</p>
                                        
                                        <h4>{{ $academia->academia_nombre }}</h4>
                                        
                                        <span class="text-muted">
                                            <address>
                                                {{ $academia->academia_direccion }}<br>
                                                {{ $academia->academia_pais }}
                                            </address>
                
                                            {{ $academia->academia_telefono }}<br/>
                                            {{ $academia->academia_email }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <div class="i-to">
                                        <p class="c-gray">Factura para</p>
                                        
                                        <h4>{{ $usuario->nombre }}</h4>
                                        
                                        <span class="text-muted">
                                            <address>
                                                {{ str_limit($usuario->direccion, $limit = 30, $end = '...') }}
                                            </address>
                
                                            {!! $usuario->telefono !!}<br/>
                                            {!! $usuario->correo !!}
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="row m-t-25 p-0 m-b-25">
                                <div class="col-xs-3">
                                    <div class="bgm-amber brd-2 p-15">
                                        <div class="c-white m-b-5">Número de Factura</div>
                                        <h4 class="m-0 c-white f-300">{!! str_pad($factura->numero_factura, 10, "0", STR_PAD_LEFT) !!}</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-blue brd-2 p-15">
                                        <div class="c-white m-b-5">Subtotal</div>
                                        <h4 class="m-0 c-white f-300">{{$academia->pais_moneda}} {{ number_format($subtotal,2,",",".") }}</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-green brd-2 p-15">
                                        <div class="c-white m-b-5">Porcentaje de IVA</div>
                                        <h4 class="m-0 c-white f-300">{{$academia->pais_moneda}} {{ number_format($iva,2,",",".") }} ({{ $porcentajeIVA }}%)</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-red brd-2 p-15">
                                        <div class="c-white m-b-5">Total {{$academia->pais_abreviatura}}</div>
                                        <h4 class="m-0 c-white f-300">{{$academia->pais_moneda}} {{ number_format($total,2,",",".") }} </h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <table class="table i-table m-t-25 m-b-25">
                                <thead class="text-uppercase">
                                    <th class="c-gray">NOMBRE</th>
                                    <th class="c-gray">CANTIDAD</th>
                                    <th class="c-gray">NETO</th>
                                    <th class="c-gray">IVA</th>
                                    <th class="highlight">TOTAL PRODUCTO</th>
                                </thead>
                                
                                <tbody>

                                    
                                    <thead>
                                    @foreach ($detalleFactura as $detalle)
                                        
                                      <?php $id = $detalle->item_id ?>
                                        <tr id="row_{{$id}}" class="seleccion" >
                                            <td class="disabled">{{ $detalle->nombre }}</td>
                                            <td class="disabled">{{ $detalle->cantidad }}</td>
                                            <td class="disabled">{{ $academia->pais_moneda }} {{ number_format($detalle->importe_neto,2,",",".") }}</td>
                                            <td class="disabled">% {{$detalle->impuesto}} </td>
                                            <td class="highlight disabled">{{$academia->pais_moneda}} {{ number_format($detalle->importe_neto,2,",",".")  }} </td>
                                        </tr>
                                       
                                    @endforeach 
                                        <tr>
                                            <td colspan="3"></td>
                                            <td> TOTAL FACTURA </td>
                                            <td class="highlight">{{$academia->pais_moneda}} {{ number_format($total,2,",",".") }}</td>
                                        </tr>
                                </tbody>
                            </table>
                            
                            <div class="clearfix"></div>
                            
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-float bgm-red m-btn" data-action="print"><i class="zmdi zmdi-print"></i></button>
  

            </section>


@stop


@section('js') 

<script>
    $(document).ready(function() {
        $("#refresh").on("click", function(){
            location.reload(true);
        })
    });
</script>


@stop