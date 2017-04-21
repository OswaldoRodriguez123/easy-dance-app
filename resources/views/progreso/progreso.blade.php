@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/progreso"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <!-- <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Selecciona la clase grupal</p> -->
                            <div class="col-sm-2">
                                <span class="f-22 opaco-0-8">Mi Progreso</span>
                            </div>

                            <div class="col-sm-7">
                                <span class="f-16 opaco-0-8" style="margin-right: 4%; padding-top: 5px; float:left">Nivel <span id="nivel">1</span> de 12</span> 

   

                                <div id="nivel_1" class="circulo_nivelacion"></div>
                                <div id="nivel_2" class="circulo_nivelacion"></div>
                                <div id="nivel_3" class="circulo_nivelacion"></div>
                                <div id="nivel_4" class="circulo_nivelacion"></div>
                                <div id="nivel_5" class="circulo_nivelacion"></div>
                                <div id="nivel_6" class="circulo_nivelacion"></div>
                                <div id="nivel_7" class="circulo_nivelacion"></div>
                                <div id="nivel_8" class="circulo_nivelacion"></div>
                                <div id="nivel_9" class="circulo_nivelacion"></div>
                                <div id="nivel_10" class="circulo_nivelacion"></div>
                                <div id="nivel_11" class="circulo_nivelacion"></div>
                                <div id="nivel_12" class="circulo_nivelacion"></div>
                            </div>

                            <div class="col-sm-3 text-right">
                                <a href="{{url('/')}}/programacion/{{$id}}" class="f-16 text-success f-700">Ver programación de las clases</a>
                            </div>

                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">
                                    <div class="clearfix" style="margin-bottom: 50px"></div>
                                    
                                    <div class="col-sm-4 text-center">

                                        <span class="f-16 opaco-0-8 text-center" style="margin-right: 8%; padding-top: 5px;">NIVEL <span id="span_nivel">1</span> PROGRESO</span> 

                                        <br><br>
                                        
                                        @if(Auth::user()->imagen)
                                            <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/uploads/usuario/{{Auth::user()->imagen}}" alt="" width="250px" height="auto">  
                                        @else
                                         @if(Auth::user()->sexo=='F')
                                              <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/1.jpg" alt="" width="250px" height="auto">        
                                           @else
                                              <img id="foto_perfil" class="img-circle" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="" width="250px" height="auto">
                                           @endif
                                        @endif

                                    </div>

                                    <div class="col-sm-4">
                                    
                                        <span id="titulo_1" class="f-14 opaco-0-8 f-700"> TITULO 1</span> <span class="pull-right f-14 opaco-0-8 f-700"><span id="barra_1_span">0</span> % COMPLETADA</span>

                                                                            
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43; height: 25px";>
                                            <div id="barra_1" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>

                                        <div id="titulo_1_estrellas" class="rating-list text-center" style="display: none">
                                            <div class="rl-star">
                                                <span id="titulo_1_puntaje" class="f-15 m-r-5"></span>
                                                <i id="titulo_1_estrella_1" class="zmdi zmdi-star"></i>
                                                <i id="titulo_1_estrella_2" class="zmdi zmdi-star"></i>
                                                <i id="titulo_1_estrella_3" class="zmdi zmdi-star"></i>
                                                <i id="titulo_1_estrella_4" class="zmdi zmdi-star"></i>
                                                <i id="titulo_1_estrella_5" class="zmdi zmdi-star"></i>
                                       
                                            </div>
                                        </div>


                                        <div class="clearfix m-b-10"></div>

                                        <span id="titulo_2" class="f-14 opaco-0-8 f-700"> TITULO 2</span> <span class="pull-right f-14 opaco-0-8 f-700"><span id="barra_2_span">0</span> % COMPLETADA</span>
                                    
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43; height: 25px";>
                                            <div id="barra_2" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>

                                        <div id="titulo_2_estrellas" class="rating-list text-center" style="display: none">
                                            <div class="rl-star">
                                                <span id="titulo_2_puntaje" class="f-15 m-r-5"></span>
                                                <i id="titulo_2_estrella_1" class="zmdi zmdi-star"></i>
                                                <i id="titulo_2_estrella_2" class="zmdi zmdi-star"></i>
                                                <i id="titulo_2_estrella_3" class="zmdi zmdi-star"></i>
                                                <i id="titulo_2_estrella_4" class="zmdi zmdi-star"></i>
                                                <i id="titulo_2_estrella_5" class="zmdi zmdi-star"></i>
                                       
                                            </div>
                                        </div>

                                        <div class="clearfix m-b-10"></div>

                                        <span id="titulo_3" class="f-14 opaco-0-8 f-700"> TITULO 3</span> <span class="pull-right f-14 opaco-0-8 f-700"><span id="barra_3_span">0</span> % COMPLETADA</span>
                                    
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43; height: 25px";>
                                            <div id="barra_3" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>

                                        <div id="titulo_3_estrellas" class="rating-list text-center" style="display: none">
                                            <div class="rl-star">
                                                <span id="titulo_3_puntaje" class="f-15 m-r-5"></span>
                                                <i id="titulo_3_estrella_1" class="zmdi zmdi-star"></i>
                                                <i id="titulo_3_estrella_2" class="zmdi zmdi-star"></i>
                                                <i id="titulo_3_estrella_3" class="zmdi zmdi-star"></i>
                                                <i id="titulo_3_estrella_4" class="zmdi zmdi-star"></i>
                                                <i id="titulo_3_estrella_5" class="zmdi zmdi-star"></i>
                                       
                                            </div>
                                        </div>
                                    </div>

                                  
                                <div class="col-sm-4">

                                    <div style="margin-left: 30% ; padding: 5% ; border:1px solid" class="opaco-0-3">
                                        <h4 class="text-center">ESTÁS BAILANDO PARA OBTENER ESTE CERTIFICADO PARA EL CICLO BÁSICO</h4>

                                        <div class="clearfix"></div>

                                        <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/basico.jpg"></img>
                                    </div>

                                    <br>


                                    <!-- <div style="margin-left: 15%; padding: 5% ; border:1px solid " class="col-sm-12 text-center opaco-0-3">

                                        @if ($academia->imagen)
                                            <img height="50px" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                                        @else
                                            <img height="50px" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                                        @endif

                                        <div class="clearfix m-b-20"></div>

                                        <h6><b>NOS ENORGULLESE EN HACER ENTREGA DEL SIGUIENTE</b></h6>

                                        <br>

                                        <h6 style="font-family: 'Pacifico', cursive">CERTIFICADO</h6>

                                        <h6>A:</h6>

                                        <h6>{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h6>

                                        <hr style="border-color:black" class="opaco-0-8">

                                        <br>

                                        <h6><b>POR HABER CULMINADO SATISFACTORIAMENTE EL CICLO BÁSICO</b></h6>

                                        <div class="clearfix m-b-25"></div>
                                        <div class="clearfix m-b-25"></div>


                                        <div class="col-sm-4">
                                            
                                            <hr style="border-color:black" class="opaco-0-8">
                                            <span style="font-family: 'Pacifico', cursive">Henry Fuenmayor</span>
                                            <h6>Director General</h6>
                                        </div>

                                        <div class="col-sm-4 col-sm-offset-4">
                                            
                                            <hr style="border-color:black" class="opaco-0-8">
                                            <span style="font-family: 'Pacifico', cursive">Robert Virona</span>
                                            <h6>Gerente General</h6>
                                        </div>

                                    </div>
                                     -->
                                   

                              
                                </div>

                                 
                                <br><br><br>
                            
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    var i = 1;
    var j = 1;

    var evaluaciones = <?php echo json_encode($evaluaciones);?>;
    var clase_1 = <?php echo json_encode($clase_1);?>;
    var clase_2 = <?php echo json_encode($clase_2);?>;
    var clase_3 = <?php echo json_encode($clase_3);?>;
    var clase_4 = <?php echo json_encode($clase_4);?>;
    var clase_5 = <?php echo json_encode($clase_5);?>;
    var clase_6 = <?php echo json_encode($clase_6);?>;
    var clase_7 = <?php echo json_encode($clase_7);?>;
    var clase_8 = <?php echo json_encode($clase_8);?>;
    var clase_9 = <?php echo json_encode($clase_9);?>;
    var clase_10 = <?php echo json_encode($clase_10);?>;
    var clase_11 = <?php echo json_encode($clase_11);?>;
    var clase_12 = <?php echo json_encode($clase_12);?>;

    $(document).ready(function() {
        var total = 0;
        if(clase_1['clase_4'] == 1){
            $('#nivel_1').css('background', '#67bd6a');
            i++;

        }
        if(clase_2['clase_4'] == 1){
            $('#nivel_2').css('background', '#67bd6a');
            i++;

        }
        if(clase_3['clase_4'] == 1){
            $('#nivel_3').css('background', '#67bd6a');
            i++;
            j = 4;

        }
        if(clase_4['clase_4'] == 1){
            $('#nivel_4').css('background', '#67bd6a');
            i++;

        }
        if(clase_5['clase_4'] == 1){
            $('#nivel_5').css('background', '#67bd6a');
            i++;

        }
        if(clase_6['clase_4'] == 1){
            $('#nivel_6').css('background', '#67bd6a');
            i++;
            j = 7;

        }
        if(clase_7['clase_4'] == 1){
            $('#nivel_7').css('background', '#67bd6a');
            i++;

        }
        if(clase_8['clase_4'] == 1){
            $('#nivel_8').css('background', '#67bd6a');
            i++;

        }
        if(clase_9['clase_4'] == 1){
            $('#nivel_9').css('background', '#67bd6a');
            i++;
            j = 10;

        }
        if(clase_10['clase_4'] == 1){
            $('#nivel_10').css('background', '#67bd6a');
            i++;

        }
        if(clase_11['clase_4'] == 1){
            $('#nivel_11').css('background', '#67bd6a');
            i++;

        }

        if(clase_12['clase_4'] == 1){
            $('#nivel_12').css('background', '#67bd6a');

        }

        if(j == 1){
            $('#titulo_1').text('BASICO I')
            $('#titulo_2').text('BASICO II')
            $('#titulo_3').text('BASICO III')
        }else if(j == 4){
            $('#titulo_1').text('INTERMEDIO I')
            $('#titulo_2').text('INTERMEDIO II')
            $('#titulo_3').text('INTERMEDIO III')
        }else if(j == 7){
            $('#titulo_1').text('AVANZADO I')
            $('#titulo_2').text('AVANZADO II')
            $('#titulo_3').text('AVANZADO III')
        }else{
            $('#titulo_1').text('MASTER I')
            $('#titulo_2').text('MASTER II')
            $('#titulo_3').text('MASTER III')
        }

        $('#nivel').text(i);
        $('#span_nivel').text(i);

        j2 = j+1;
        j3 = j+2;

        if(evaluaciones[j]){
            porcentaje = evaluaciones[j]
            $('#titulo_1_puntaje').text(porcentaje+"%");
            $('#titulo_1_estrellas').show();
            if(porcentaje >= 20){
                $('#titulo_1_estrella_1').addClass('active')
            }

            if(porcentaje >= 40){
                $('#titulo_1_estrella_2').addClass('active')
            }

            if(porcentaje >= 60){
                $('#titulo_1_estrella_3').addClass('active')
            }

            if(porcentaje >= 80){
                $('#titulo_1_estrella_4').addClass('active')
            }

            if(porcentaje >= 100){
                $('#titulo_1_estrella_5').addClass('active')
            }
        }

        if(evaluaciones[j2]){
            porcentaje = evaluaciones[j2]
            $('#titulo_2_puntaje').text(porcentaje+"%");
            $('#titulo_2_estrellas').show();
            if(porcentaje >= 20){
                $('#titulo_2_estrella_1').addClass('active')
            }

            if(porcentaje >= 40){
                $('#titulo_2_estrella_2').addClass('active')
            }

            if(porcentaje >= 60){
                $('#titulo_2_estrella_3').addClass('active')
            }

            if(porcentaje >= 80){
                $('#titulo_2_estrella_4').addClass('active')
            }

            if(porcentaje >= 100){
                $('#titulo_2_estrella_5').addClass('active')
            }
        }

        if(evaluaciones[j3]){
            porcentaje = evaluaciones[j3]
            $('#titulo_3_puntaje').text(porcentaje+"%");
            $('#titulo_3_estrellas').show();
            if(porcentaje >= 20){
                $('#titulo_3_estrella_1').addClass('active')
            }

            if(porcentaje >= 40){
                $('#titulo_3_estrella_2').addClass('active')
            }

            if(porcentaje >= 60){
                $('#titulo_3_estrella_3').addClass('active')
            }

            if(porcentaje >= 80){
                $('#titulo_3_estrella_4').addClass('active')
            }

            if(porcentaje >= 100){
                $('#titulo_3_estrella_5').addClass('active')
            }
        }

        if(window["clase_"+j]['clase_1'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j]['clase_2'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j]['clase_3'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j]['clase_4'] == 1){

            total = total + 25;
        }

        $('#barra_1').css('width', total+'%')
        $('#barra_1_span').text(total);

        if(total == 100){
            $('#barra_1').css('background', '#67bd6a')
        }

        total = 0

        if(window["clase_"+j2]['clase_1'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j2]['clase_2'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j2]['clase_3'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j2]['clase_4'] == 1){

            total = total + 25;
        }

        $('#barra_2').css('width', total+'%')
        $('#barra_2_span').text(total);

        if(total == 100){
            $('#barra_2').css('background', '#67bd6a')
        }

        total = 0

        if(window["clase_"+j3]['clase_1'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j3]['clase_2'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j3]['clase_3'] == 1){

            total = total + 25;
        }

        if(window["clase_"+j3]['clase_4'] == 1){

            total = total + 25;
        }

        $('#barra_3').css('width', total+'%')
        $('#barra_3_span').text(total);

        if(total == 100){
            $('#barra_3').css('background', '#67bd6a')
        }

        $('#nivel_'+i).css('background', '#3b5998');

    });

    route_progreso="{{url('/')}}/progreso";

    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        procesando();

        window.location=route_progreso+"/"+id;

      });

    // $("button").click(function(){
    //     var id = this.id
    //     var arr = id.split('_')
    //     var i = arr[1];

    //     if(window["clase_"+i]['clase_1'] == 1){

    //         $('#barra_1').css('width', '100%')
    //         $('#barra_1').css('background', '#67bd6a')
    //         $('#barra_1_span').text(100);
    //     }else{
    //         $('#barra_1').css('width', '0%')
    //         $('#barra_1').css('background', '#4E1E43')
    //         $('#barra_1_span').text(0);
    //     }

    //     if(window["clase_"+i]['clase_2'] == 1){

    //         $('#barra_2').css('width', '100%')
    //         $('#barra_2').css('background', '#67bd6a')
    //         $('#barra_2_span').text(100);
    //     }else{
    //         $('#barra_2').css('width', '0%')
    //         $('#barra_2').css('background', '#4E1E43')
    //         $('#barra_2_span').text(0);
    //     }

    //     if(window["clase_"+i]['clase_3'] == 1){

    //         $('#barra_3').css('width', '100%')
    //         $('#barra_3').css('background', '#67bd6a')
    //         $('#barra_3_span').text(100);
    //     }else{
    //         $('#barra_3').css('width', '0%')
    //         $('#barra_3').css('background', '#4E1E43')
    //         $('#barra_3_span').text(0);
    //     }

    //     if(window["clase_"+i]['clase_4'] == 1){

    //         $('#barra_4').css('width', '100%')
    //         $('#barra_4').css('background', '#67bd6a')
    //         $('#barra_4_span').text(100);
    //     }else{
    //         $('#barra_4').css('width', '0%')
    //         $('#barra_4').css('background', '#4E1E43')
    //         $('#barra_4_span').text(0);
    //     }

    //     $('#nivel').text(i);
    //     $('#span_nivel').text(i);

    // });

    

     </script>

@stop