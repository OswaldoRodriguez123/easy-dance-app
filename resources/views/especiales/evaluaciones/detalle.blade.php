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
                        <?php $url = "/inicio" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        @if($usuario_tipo == 1 || $usuario_tipo == 5 || $usuario_tipo == 6)
                            <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/especiales/evaluaciones/{{$examen->examen_id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Secci??n de evaluaciones</a> -->

                            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                                
                                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                                
                                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                                
                                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                               
                                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            </ul>
                        @else
                            <!-- <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/evaluaciones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Secci??n de evaluaciones</a> -->
                        @endif
                        
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
                                <div class="col-sm-12 f-16 f-700">

                                <span class="f-18 text-center c-morado"> DATOS PERSONALES </span>


                                <hr class="linea-morada">

                                ???   Nombre : {{$alumno->nombre}} {{$alumno->apellido}} <br> 
                                ???   Identificaci??n : {{$alumno->identificacion}} <br>
                                ???   Correo electr??nico : {{$alumno->correo}} <br>
                                ???   N??mero telef??nico : {{$alumno->telefono}} {{$alumno->celular}} <br>
                                ???   Sexo : {{$alumno->sexo}} <br>
                                ???   Fecha de nacimiento : {{$alumno->fecha_nacimiento}} <br>
                                ???   Direcci??n : {{$alumno->direccion}} <br>
                                ???   Edad :  {{$edad}} a??os de edad <br>

                                <br>

                                <span class="f-18 text-center c-morado"> DATOS ACAD??MICOS </span>


                                <hr class="linea-morada">

                                ???   Fecha de ingreso : {{$fecha_ingreso}} <br> 
                                ???   Clase Actual : {{$clase_grupal_nombre}} <br>
                                ???   Instructor : {{$instructor}}<br>
                                ???   D??as y horarios de clases  : {{$horario}}<br>

                             

                            <div class="clearfix"></div>
                            

                            
                            <div class="clearfix"></div>

                            <br>



                            <span class="f-18 f-700 text-center c-morado"> RESULTADOS </span>


                            <hr class="linea-morada">

                        
                            
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

                            </table>
                            </div>
                            </div>
                            
                            <div class="clearfix"></div><hr />

                            <div class ="f-16 f-700 pull-right">

                            Resultado final : {{$nota_final}} puntos de {{(count($detalle_notas))*10}}<br>

                            <div class="rating-list">
                                <div class="rl-star">
                                    @if($porcentaje >= 20)
                                        <i class="zmdi zmdi-star active"></i>
                                    @else
                                        <i class="zmdi zmdi-star"></i>
                                    @endif

                                    @if($porcentaje >= 40)
                                        <i class="zmdi zmdi-star active"></i>
                                    @else
                                        <i class="zmdi zmdi-star"></i>
                                    @endif

                                    @if($porcentaje >= 60)
                                        <i class="zmdi zmdi-star active"></i>
                                    @else
                                        <i class="zmdi zmdi-star"></i>
                                    @endif

                                    @if($porcentaje >= 80)
                                        <i class="zmdi zmdi-star active"></i>
                                    @else
                                        <i class="zmdi zmdi-star"></i>
                                    @endif

                                    @if($porcentaje >= 100)
                                        <i class="zmdi zmdi-star active"></i>
                                    @else
                                        <i class="zmdi zmdi-star"></i>
                                    @endif
                                    
                                </div>
                            </div>

                            Nivel de progreso : {{$porcentaje}} <br>
                            Fecha pr??xima evaluaci??n : {{$fecha_siguiente}} <br>

                            </div>

                            <label for="observacion" id="id-observacion">Observaciones</label>
                            <div class="fg-line">
                              <textarea class="form-control" id="observacion" name="observacion" rows="2" disabled>{{$observacion}}</textarea>
                            </div>
                            <div class="clearfix p-b-20"></div>
                            <div class="clearfix p-b-20"></div>

                            <!-- <span class="f-18 f-700 text-center c-morado"> F??rmula de ??xito </span>


                            <hr class="linea-morada">

                            @if($examen->cantidad_horas_practica)

                                ???   Cantidad adicional de horas de pr??ctica semanales: {{$examen->cantidad_horas_practica}} Horas </br>


                            @endif

                            @if($examen->asistencia_taller)

                                ???   Asistencia en taller de preparaci??n especial:   <b class="text-success">--Recomendado--</b></br>


                            @endif
                           

                            @if($examen->practica_horas_personalizadas)

                                 ???   Pr??ctica de horas personalizadas:  <b class="text-success">--Recomendado--</b></br>

                            @endif


                            @if($examen->participacion_evento)

                                ???   Participaci??n evento: <b class="text-success">--Recomendado--</b></br>
                                
                            @endif

                            
                            @if($examen->participacion_fiesta_social)

                                ???   Participaci??n en fiesta social: <b class="text-success">--Recomendado--</b></br>

                            @endif

                            @foreach($formulas as $formula)

                                ???   {{$formula->nombre}}: <b class="text-success">--Recomendado--</b></br>

                            @endforeach


                            <br><br> -->

                            Realizado por : {{$examen->instructor_nombre}} {{$examen->instructor_apellido}}

                            @if($examen->telefono OR $examen->celular)

                            <br><br>

                            Telefonos : {{$examen->telefono}} / {{$examen->celular}}

                            @endif

                            <br><br>


                          @if($examen->facebook)
                          @if (!filter_var($examen->facebook, FILTER_VALIDATE_URL) === false) 
                            <i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="{{$examen->facebook}}">{{$examen->facebook}}</a>
                          @else
                            <i class="zmdi zmdi-facebook-box"></i> <a class ="enlace_gris" href="https://www.facebook.com/{{$examen->facebook}}">https://www.facebook.com/{{$examen->facebook}}</a>
                          @endif
                          <br>
                        @endif

                        @if($examen->twitter)

                          @if (!filter_var($examen->twitter, FILTER_VALIDATE_URL) === false) 
                            <i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="{{$examen->twitter}}">https://www.twitter.com/{{$examen->twitter}}</a><
                          @else
                            <i class="zmdi zmdi-twitter"></i> <a class ="enlace_gris" href="https://www.twitter.com/{{$examen->twitter}}">@ {{$examen->twitter}}</a>
                          @endif
                          <br>
                        @endif

                        @if($examen->instagram)
                          @if (!filter_var($examen->instagram, FILTER_VALIDATE_URL) === false) 
                            <i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="{{$examen->instagram}}">{{$examen->instagram}}</a>
                          @else
                            <i class="zmdi zmdi-instagram"></i> <a class ="enlace_gris" href="https://www.instagram.com/{{$examen->instagram}}">@ {{$examen->instagram}}</a>
                          @endif
                          <br>
                        @endif

                        


                             <div class="row m-b-25">
                                <div class="col-sm-12 f-16 text-center" style="margin-top: 100px">

                                 <hr class="linea-morada">

                                <span class="f-16"> Academia <b>{{$academia->academia_nombre}}</b>, Direcci??n: {{$academia->direccion}}, N??meros telef??nico ( {{$academia->telefono}} / {{$academia->celular}} )  </br>

                                {{$academia->correo}} </br></br>

                                <b>NOS ENCANTA VERTE BAILAR</b>


                                </span>

                                </div>
                                </div>

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
        bPaginate: false,
        bInfo:false,
        bFilter:false,
        pageLength: 25,   
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
          $("#msj_porcentaje").html("Excelente");
        }
    }
</script>


@stop