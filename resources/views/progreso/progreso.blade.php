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
                            <div class="col-sm-3">
                                <span class="f-22 opaco-0-8">Mi Progreso</span>
                            </div>

                            <div class="col-sm-6">
                                <span class="f-16 opaco-0-8" style="margin-right: 8%; padding-top: 5px; float:left">Nivel <span id="nivel">1</span> de 16</span> 

   

                                <div id="nivel_1" class="circulo_nivelacion"></div>
                                <div id="nivel_2" class="circulo_nivelacion"></div>
                                <div id="nivel_3" class="circulo_nivelacion"></div>
                                <div id="nivel_4" class="circulo_nivelacion"></div>
                                <div id="nivel_5" class="circulo_nivelacion"></div>
                                <div id="nivel_6" class="circulo_nivelacion"></div>
                                <div id="nivel_7" class="circulo_nivelacion"></div>
                                <div id="nivel_8" class="circulo_nivelacion"></div>
                                <div class="clearfix"></div>
                                <div id="nivel_9" class="circulo_nivelacion" style="margin-left: 26.7%"></div>
                                <div id="nivel_10" class="circulo_nivelacion"></div>
                                <div id="nivel_11" class="circulo_nivelacion"></div>
                                <div id="nivel_12" class="circulo_nivelacion"></div>
                                <div id="nivel_13" class="circulo_nivelacion"></div>
                                <div id="nivel_14" class="circulo_nivelacion"></div>
                                <div id="nivel_15" class="circulo_nivelacion"></div>
                                <div id="nivel_16" class="circulo_nivelacion"></div>

                            </div>

                            <div class="col-sm-3 text-right">
                                <a href="{{url('/')}}/programacion" class="f-16 text-success f-700">Ver programación de las clases</a>
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

                                        <span class="f-14 opaco-0-8 f-700"><span id="barra_1_span">0</span> % COMPLETADA</span>
                                    
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43; height: 25px";>
                                            <div id="barra_1" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
    
                                        <br>

                                        <span class="f-14 opaco-0-8 f-700"><span id="barra_2_span">0</span> % COMPLETADA</span>
                                         
                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43;height: 25px">
                                            <div id="barra_2" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>

                                        <br>

                                        <span class="f-14 opaco-0-8 f-700"><span id="barra_3_span">0</span> % COMPLETADA</span>

                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43;height: 25px">
                                            <div id="barra_3" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>

                                        <br>

                                        <span class="f-14 opaco-0-8 f-700"><span id="barra_4_span">0</span> % COMPLETADA</span>

                                        <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43;height: 25px">
                                            <div id="barra_4" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </div>

                                  
                                <div class="col-sm-4"></div>

                                 
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
    var clase_13 = <?php echo json_encode($clase_13);?>;
    var clase_14 = <?php echo json_encode($clase_14);?>;
    var clase_15 = <?php echo json_encode($clase_15);?>;
    var clase_16 = <?php echo json_encode($clase_16);?>;

    $(document).ready(function() {
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
            i++;

        }
        if(clase_13['clase_4'] == 1){
            $('#nivel_13').css('background', '#67bd6a');
            i++;

        }
        if(clase_14['clase_4'] == 1){
            $('#nivel_14').css('background', '#67bd6a');
            i++;

        }
        if(clase_15['clase_4'] == 1){
            $('#nivel_15').css('background', '#67bd6a');
            i++;

        }
        if(clase_16['clase_4'] == 1){
            $('#nivel_16').css('background', '#67bd6a');
            i++;

        }

        $('#nivel').text(i);
        $('#span_nivel').text(i);

        if(window["clase_"+i]['clase_1'] == 1){

            $('#barra_1').css('width', '100%')
            $('#barra_1').css('background', '#67bd6a')
            $('#barra_1_span').text(100);
        }

        if(window["clase_"+i]['clase_2'] == 1){

            $('#barra_2').css('width', '100%')
            $('#barra_2').css('background', '#67bd6a')
            $('#barra_2_span').text(100);
        }

        if(window["clase_"+i]['clase_3'] == 1){

            $('#barra_3').css('width', '100%')
            $('#barra_3').css('background', '#67bd6a')
            $('#barra_3_span').text(100);
        }

        if(window["clase_"+i]['clase_4'] == 1){

            $('#barra_4').css('width', '100%')
            $('#barra_4').css('background', '#67bd6a')
            $('#barra_4_span').text(100);
        }
    });

    route_progreso="{{url('/')}}/progreso";

    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        procesando();

        window.location=route_progreso+"/"+id;

      });

    $("button").click(function(){
        var id = this.id
        var arr = id.split('_')
        var i = arr[1];

        if(window["clase_"+i]['clase_1'] == 1){

            $('#barra_1').css('width', '100%')
            $('#barra_1').css('background', '#67bd6a')
            $('#barra_1_span').text(100);
        }else{
            $('#barra_1').css('width', '0%')
            $('#barra_1').css('background', '#4E1E43')
            $('#barra_1_span').text(0);
        }

        if(window["clase_"+i]['clase_2'] == 1){

            $('#barra_2').css('width', '100%')
            $('#barra_2').css('background', '#67bd6a')
            $('#barra_2_span').text(100);
        }else{
            $('#barra_2').css('width', '0%')
            $('#barra_2').css('background', '#4E1E43')
            $('#barra_2_span').text(0);
        }

        if(window["clase_"+i]['clase_3'] == 1){

            $('#barra_3').css('width', '100%')
            $('#barra_3').css('background', '#67bd6a')
            $('#barra_3_span').text(100);
        }else{
            $('#barra_3').css('width', '0%')
            $('#barra_3').css('background', '#4E1E43')
            $('#barra_3_span').text(0);
        }

        if(window["clase_"+i]['clase_4'] == 1){

            $('#barra_4').css('width', '100%')
            $('#barra_4').css('background', '#67bd6a')
            $('#barra_4_span').text(100);
        }else{
            $('#barra_4').css('width', '0%')
            $('#barra_4').css('background', '#4E1E43')
            $('#barra_4_span').text(0);
        }

        $('#nivel').text(i);
        $('#span_nivel').text(i);

    });

    

     </script>

@stop