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

                    <div class="block-header">
                        <h2>Presupuesto <!--<small>Print ready simple and sleek invoice template. Please use Google Chrome or any other Webkit browsers for better printing.</small>--></h2>
                
                        <!-- <ul class="actions">
                            <li>
                                <a href="#">
                                    <i class="zmdi zmdi-trending-up"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="zmdi zmdi-check-all"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="#" id="refresh">Refresh</a>
                                    </li>

                                </ul>
                            </li>
                        </ul> -->
                
                    </div>
                    
                    <div class="card">
                        <div class="card-header text-center header-invoice">
                            @if ($academia->imagen_academia)
                            <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_academia}}" alt="">
                            @else
                            <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_academia}}" alt="">
                            @endif
                        </div>
                        
                        <div class="card-body card-padding">
                            <div class="row m-b-25">
                                <div class="col-xs-6">
                                    <div class="text-right">
                                        <p class="c-gray">Presupuesto de</p>
                                        
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
                                        <p class="c-gray">Presupuesto para</p>
                                        
                                        <h4>{{ $alumno->alumno_nombre }} {{ $alumno->alumno_apellido }}</h4>
                                        
                                        <span class="text-muted">
                                            <address>
                                                {{ str_limit($alumno->direccion, $limit = 30, $end = '...') }}
                                            </address>
                
                                            {!! $alumno->telefono !!}<br/>
                                            {!! $alumno->email !!}
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="row m-t-25 p-0 m-b-25">
                                <div class="col-xs-3">
                                    <div class="bgm-amber brd-2 p-15">
                                        <div class="c-white m-b-5">Número de Presupuesto</div>
                                        <h4 class="m-0 c-white f-300">{!! $facturas->id !!}</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-blue brd-2 p-15">
                                        <div class="c-white m-b-5">Subtotal</div>
                                        <h4 class="m-0 c-white f-300">Bs {{ number_format($subtotal,2,",",".") }}</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-green brd-2 p-15">
                                        <div class="c-white m-b-5">Porcentaje de IVA</div>
                                        <h4 class="m-0 c-white f-300">Bs {{ number_format($iva,2,",",".") }} ({{ $porcentajeIVA }}%)</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-3">
                                    <div class="bgm-red brd-2 p-15">
                                        <div class="c-white m-b-5">Total VEF</div>
                                        <h4 class="m-0 c-white f-300">Bs {{ number_format($total,2,",",".") }} </h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <table class="table i-table m-t-25 m-b-25">
                                <thead class="text-uppercase">
                                    <th class="c-gray">ITEM ID</th>
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
                                            <td class="text-center previa">{{ $detalle->item_id }}</td>
                                            <td class="">{!! $detalle->nombre !!}</td>
                                            <td class="">{{ $detalle->cantidad }}</td>
                                            <td class="">Bs {{ number_format($detalle->importe_neto,2,",",".") }}</td>
                                            <td class="">% {{$detalle->impuesto}} </td>
                                            <td class="highlight">Bs {{ number_format($detalle->importe_neto,2,",",".")  }} </td>
                                            <!--<td class="text-center previa"><label class="label label-success f-13">Activo</label></td>
                                            <td class="text-center previa"><label class="label label-success f-13">Bien</label></td>-->
                                            <!--<td class="text-center"> <i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-wrench f-20 p-r-10 operacionModal"></i></td>-->
                                        </tr>
                                       
                                    @endforeach 
                                        <tr>
                                            <td colspan="4"></td>
                                            <td> TOTAL PRESUPUESTO </td>
                                            <td class="highlight">Bs {{ number_format($total,2,",",".") }}</td>
                                        </tr>
                                    </thead>




                                <!--    <thead>
                                        <tr>
                                            <td width="50%">
                                                <h5 class="text-uppercase f-400">Curabitur lobortis</h5>
                                                <p class="text-muted">Nullam consectetur dolor nec ullamcorper finibus. Quisque a porta mauris, non venenatis mi. Pellentesque habitant morbi tristique</p>
                                            </td>
                                            
                                            <td>$450.00</td>
                                            <td>05</td>
                                            <td class="highlight">$2250.00</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <h5 class="text-uppercase f-400">Phasellus idarcu suscipit nun</h5>
                                                <p class="text-muted">Pellentesque habitant morbi tristique senectus</p>
                                            </td>
                                            <td>$20.00</td>
                                            <td>02</td>
                                            <td class="highlight">$40.00</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <h5 class="text-uppercase f-400">Vivamus</h5>
                                                <p class="text-muted">Maecenas nec faucibus lectus. Ut cursus elit ante, rutrum pretium augue tincidunt ut. Suspendisse ultrices sapien sit amet</p>
                                            </td>
                                            <td>$2322.00</td>
                                            <td>01</td>
                                            <td class="highlight">$2322.00</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <h5 class="text-uppercase f-400">Nullam consectetur dolor</h5>
                                                <p class="text-muted">Quisque a porta mauris, non venenatis mi. Pellentesque habitant morbi</p>
                                            </td>
                                            <td>$1290.00</td>
                                            <td>12</td>
                                            <td class="highlight">$15,480.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="highlight">$20,092.00</td>
                                        </tr>
                                    </thead> -->
                                </tbody>
                            </table>
                            
                            <div class="clearfix"></div>
                            
                            <!-- <div class="p-25">
                                <h4 class="c-green f-400">REMARKS</h4>
                                <p class="c-gray">Ornare non tortor. Nam quis ipsum vitae dolor porttitor interdum. Curabitur faucibus erat vel ante fermentum lacinia. Integer porttitor laoreet suscipit. Sed cursus cursus massa ut pellentesque. Phasellus vehicula dictum arcu, eu interdum massa bibendum.</p>
                                
                                <br/>
                                
                                <h4 class="c-green f-400">MERCY FOR YOUR BUSINESS</h4>
                                <p class="c-gray">Proin ac iaculis metus. Etiam nisi nulla, fermentum blandit consectetur sed, ornare non tortor. Nam quis ipsum vitae dolor porttitor interdum. Curabitur faucibus erat vel ante fermentum lacinia. Integer porttitor laoreet suscipit. Sed cursus cursus massa ut pellentesque. Phasellus vehicula dictum arcu, eu interdum massa bibendum sit amet.</p>
                            </div> -->
                        </div>
                        
                        <!-- <footer class="m-t-15 p-20">
                            <ul class="list-inline text-center list-unstyled">
                                <li class="m-l-5 m-r-5"><small>support@company.com</small></li>
                                <li class="m-l-5 m-r-5"><small>00971 452 9900</small></li>
                                <li class="m-l-5 m-r-5"><small>www.company.com</small></li>
                            </ul>
                        </footer> -->
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