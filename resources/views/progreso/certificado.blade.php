@extends('layout.master')

@section('css_vendor')
    <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet"> 
@stop

@section('js_vendor')
    <script src="{{url('/')}}/assets/js/jspdf.min.js"></script>
    <script src="{{url('/')}}/assets/js/html2canvas.min.js"></script>
@stop

@section('content')

    <section id="content">
        <?php

            if($certificado->nivel == 'BASICO'){
                $nivel = 'BÁSICO';
                $border = '#4C7C40';

            }else if($certificado->nivel == 'INTERMEDIO'){
                $nivel = 'INTERMEDIO';
                $border = '#1E3E77';

            }else if($certificado->nivel == 'AVANZADO'){
                $nivel = 'AVANZADO';
                $border = '#B3602A';

            }else{
                $nivel = 'MASTER';
                $border = '#D0C17C';

            }

        ?>
        <div class="container">        
            <div id ="card" class="card no_margin_buttom certificado_border" style="border-color: {{$border}}">
                <div class="card-body p-b-20">
                    <div class="row p-20">
                        <div class="col-sm-5 text-center">

                            <br><br><br>

                            <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/{{$certificado->nivel}}.jpg"></img>

                            <h4>Fecha: {{$fecha}}</h4>


                        </div>

                        <div class="col-sm-7 text-center">

                            <br>

                            @if ($certificado->imagen)
                                <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$certificado->imagen}}" alt="">
                            @else
                                <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                            @endif

                            <div class="clearfix m-b-20"></div>

                            <h3><b>NOS ENORGULLECE EN HACER ENTREGA DEL SIGUIENTE</b></h3>

                            <br>

                            <h1 class="pacifico">CERTIFICADO</h1>

                            <h1>A:</h1>

                            <h1>{{$certificado->nombre}} {{$certificado->apellido}}</h1>

                            <hr class="linea_negra opaco-0-8">

                            <br>

                            <h4><b>POR HABER CULMINADO SATISFACTORIAMENTE EL CICLO {{$nivel}}</b></h4>

                            <div class="clearfix m-b-25"></div>
                            <div class="clearfix m-b-25"></div>


                            <div class="col-sm-4">
                                
                                <hr class="linea_negra opaco-0-8">
                                <span class="f-16">Henry Fuenmayor</span>
                                <h6>Director General</h6>
                            </div>

                            <div class="col-sm-4 col-sm-offset-4">
                                
                                <hr class="linea_negra opaco-0-8">
                                <span class="f-16">Robert Virona</span>
                                <h6>Gerente General</h6>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <br>
            
            <div class="card">
                <div class="card-body p-b-20">
                    <div class="row p-20">
                        <div class="col-sm-12 f-20 p-10">
                            NOTA: Si desea puede verificar la autenticidad de este certificado a través de <b><a href="{{url('/')}}/verificar-certificado" target="_blank">{{url('/')}}/verificar-certificado</a></b> e ingresando el siguiente código
                            de validación: {{$certificado->hash_id}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <button class="btn btn-float bgm-red m-btn" id="getPdf"><i class="zmdi zmdi-print"></i></button>
@stop

@section('js') 

    <script type="text/javascript">

        $(document).ready(function(){
            var pdf = new jsPDF();
            var specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true;
                }
            };

            $('#getPdf').click(function () {
                pdf.addHTML($('#card')[0], 0, 0, function () {
                    pdf.save('{{$certificado->hash_id}}.pdf');
                });
            });


        });

    </script>
@stop