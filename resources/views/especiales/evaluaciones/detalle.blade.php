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
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/evaluaciones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección de evaluaciones</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header ch-alt text-center">
                            @if ($academia->imagen_academia)
                            <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen_academia}}" alt="">
                            @endif
                        </div>
                        
                        <div class="card-body card-padding">
                            <div class="row m-b-25">
                                <div class="col-xs-6">
                                    <div class="text-right">
                                        <p class="c-gray">Instructor</p>
                                        <h4>{{ $instructor->instructor_nombre }} {{ $instructor->instructor_apellido }}</h4>
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <div class="i-to">
                                        <p class="c-gray">Alumno</p>
                                        <h4>{{ $alumno->alumno_nombre }} {{ $alumno->alumno_apellido }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-25">
                                <div class="col-xs-6">
                                    <div class="text-right">
                                        <p class="c-gray">Fecha de la realizacion de la evaluacion</p>
                                        <h4>{{$fecha}}</h4>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="">
                                        <p class="c-gray">Generos musicales evaluados</p>
                                        <h4>{{$genero_examen}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            

                            
                            <div class="clearfix"></div>
                            
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                <thead class="text-uppercase">
                                    <th class="c-gray">NOMBRE</th>
                                    <th class="highlight">NOTA</th>
                                </thead>
                                
                                <tbody>
 

                                    @foreach ($detalle_notas as $detalle)
                                        
                                      <?php $id = $detalle->item_id ?>
                                        <tr id="row_{{$id}}" class="seleccion" >
                                            <td class="text-center disabled">{{ $detalle->nombre}}</td>
                                            <td class="highlight disabled"> {{ $detalle->nota}} </td>
                                            <!--<td class="text-center previa"><label class="label label-success f-13">Activo</label></td>
                                            <td class="text-center previa"><label class="label label-success f-13">Bien</label></td>-->
                                            <!--<td class="text-center"> <i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-wrench f-20 p-r-10 operacionModal"></i></td>-->
                                        </tr>
                                       
                                    @endforeach 
                                    
                            


                                </tbody>

                                <thead class="text-uppercase">

                                <tr>
                            
                                            <td> NOTA FINAL </td>
                                            <td class="highlight">{{$nota_final}}</td>
                                    </tr>

                                    </thead>
                            </table>
                            </div>
                            </div>
                            
                            <div class="clearfix"></div><hr />
                            <label for="observacion" id="id-observacion">Observaciones</label>
                            <div>{{$observacion}}</div>
                            <div class="clearfix p-b-20"></div>
                            <div class="clearfix p-b-20"></div>

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

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[0, 'desc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
        },
        pageLength: 25,
        paging: false,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1)', nRow).addClass( "text-center" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                        searchPlaceholder: "BUSCAR",
                        lengthMenu:     "Mostrar _MENU_ Registros",
                        info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
                        infoFiltered:   "(filtrada de _MAX_ registros en total)",
                        infoPostFix:    "",
                        loadingRecords: "...",
                        zeroRecords:    "No se encontraron registros coincidentes",
                        emptyTable:     "No hay datos disponibles en la tabla",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        },
                        aria: {
                            sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
                            sortDescending: ": habilitado para ordenar la columna en orden descendente"
                        }
                    }
        });

        $("#refresh").on("click", function(){
            location.reload(true);
        });

        porcentaje();
    });

    function porcentaje(){

        
        porcentaje ={{$porcentaje}};
        $("#text-progreso").text(porcentaje+"%");
        $("#barra-progreso").css({
          "width": (porcentaje + "%")
        });        
        
        if(porcentaje<="25"){
          $("#barra-progreso").css("background-color","red");
          $("#msj_porcentaje").html("Debe mejorar");
        }else if(porcentaje<="50"){
          $("#barra-progreso").css("background-color","orange");
          $("#msj_porcentaje").html("Regular");
        }else if(porcentaje<="75"){
          $("#barra-progreso").css("background-color","gold");
          $("#msj_porcentaje").html("Bueno");
        }else if(porcentaje<"100"){
          $("#barra-progreso").css("background-color","greenyellow ");
          $("#msj_porcentaje").html("Muy bueno");
        }else{
          $("#barra-progreso").css("background-color","green");
          $("#msj_porcentaje").html("excelente");
        }
    }
</script>


@stop