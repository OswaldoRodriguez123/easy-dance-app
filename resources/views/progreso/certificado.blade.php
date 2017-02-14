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
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
@stop
@section('content')

    <section id="content">
        <div class="container">        
            <div class="card">
                <div class="card-body p-b-20">
                    <div class="row">
                        <div class="container">
                            <div class="col-sm-5">

                                <br><br><br><br>

                                <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/{{$certificado}}"></img>


                            </div>

                            <div class="col-sm-7 text-center">

                                @if ($academia->imagen)
                                    <img class="i-logo" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                                @else
                                    <img class="i-logo" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                                @endif

                                <div class="clearfix m-b-20"></div>

                                <h3><b>NOS ENORGULLESE EN HACER ENTREGA DEL SIGUIENTE</b></h3>

                                <br>

                                <h1 style="font-family: 'Pacifico', cursive">CERTIFICADO</h1>

                                <h1>A:</h1>

                                <h1>{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h1>

                                <hr style="border-color:black" class="opaco-0-8">

                                <br>

                                <h4><b>POR HABER CULMINADO SATISFACTORIAMENTE EL CICLO {{$nivel}}</b></h4>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop