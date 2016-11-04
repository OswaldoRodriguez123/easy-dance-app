@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>          
<script src="{{url('/')}}/assets/vendors/bootgrid/jquery.bootgrid.min.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/participante/alumno/detalle/{{$alumno->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Vista Previa</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <span class="f-16 p-t-0 c-morado">{{$alumno->nombre}} {{$alumno->apellido}} {{$alumno->identificacion}}</span>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-money f-25"></i> Selecciona los ítems a pagar</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-md-offset-10">

                        <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" > Pagar <i class="icon_a-pagar"></i></button>
                        </div>

                        <br>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped" id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="factura" data-type="numeric" data-identifier="true">#</th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha de Vencimiento</th>
                                    <th class="text-center" data-column-id="descripcion">Descripcion</th>
                                    <th class="text-center" data-column-id="cantidad" data-order="desc">Cantidad</th>
                                    <th class="text-center" data-column-id="total">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                             @foreach ($proforma as $proforma)
                                <?php $id = $proforma->id; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$proforma->id}}</td>
                                    <td class="text-center previa"><span>{{$proforma->fecha_vencimiento}} {{ empty($proforma->vencido) ? '' : "&nbsp;&nbsp;(Factura Vencida)" }}</span></td>
                                    <td class="text-center previa">{{$proforma->nombre}}</td>
                                    <td class="text-center previa">{{$proforma->cantidad}}</td>
                                    <td class="text-center previa">{{ number_format($proforma->importe_neto, 2) }}</td>
                                    
                                </tr>
                            @endforeach 

                                                           
                            </tbody>
                        </table>
                         </div>
                        </div>
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                
                              </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
        <script type="text/javascript">
            route_factura="{{url('/')}}/administrativo/pagos/gestion";
            route_operacion="{{url('/')}}/participante/alumno/operaciones";

            var selected = '';
            var alumno_id = "{{$alumno->id}}"

        $(document).ready(function (){
            $("#pagar").attr("disabled","disabled");
            
            $("#pagar").css({
                "opacity": ("0.2")
            });
           
           $("#tablelistar").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true,
                    navigation: false
                }).on("selected.rs.jquery.bootgrid", function(e, rows)
                {

                    // var rowIds = [];
                    // for (var i = 0; i < rows.length; i++)
                    // {
                    //     rowIds.push(rows[i].id);
                    // }
                    // alert("Select: " + rowIds.join(","));
                    selected = $("#tablelistar").bootgrid("getSelectedRows");

                    if(selected.length === 0){
                        $("#pagar").attr("disabled","disabled");
                        $("#pagar").css({
                            "opacity": ("0.2")
                        });
                    }

                    else{
                        $("#pagar").removeAttr("disabled");
                        $("#pagar").css({
                          "opacity": ("1")
                        });
                    }

                }).on("deselected.rs.jquery.bootgrid", function(e, rows)
                {
                    // var rowIds = [];
                    // for (var i = 0; i < rows.length; i++)
                    // {
                    //     rowIds.push(rows[i].id);
                    // }
                    // alert("Deselect: " + rowIds.join(","));
                    selected = $("#tablelistar").bootgrid("getSelectedRows");
    
                    if(selected.length === 0){
                        $("#pagar").attr("disabled","disabled");
                        $("#pagar").css({
                            "opacity": ("0.2")
                        });
                    }

                    else{
                        $("#pagar").removeAttr("disabled");
                        $("#pagar").css({
                          "opacity": ("1")
                        });
                    }
                });

                // $('#tablelistar tr').each(function(index, element){

                //         var tmp = $(element).find("td").eq(1).html();
                //         console.log(tmp);
                //         // var split = tmp.split('-');
                //         // var vencimiento = split[1];

                //     });

        });

        $("#pagar").click(function(){

                var route = route_factura;
                var token = "{{ csrf_token() }}";
                procesando();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:"&items_factura="+selected+"&alumno_id="+alumno_id,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          // var nType = 'success';
                          // var nTitle="Ups! ";
                          // var nMensaje=respuesta.mensaje;
                          
                          window.location = "{{url('/')}}/administrativo/pagos/gestion";

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        // finprocesado();
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        
                        if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }

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


        </script>

@stop