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
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/lideres-en-accion"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
            </div> 
            
            <div class="card">

                <div class="card-header text-right">

                    <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clases-grupales f-25"></i> Sección de Clases Grupales</p>
                    <hr class="linea-morada">                                                         
                </div>

                
                <div class="card-body p-b-20 p-l-20 p-r-20">
                    <div class="row p-l-10 p-r-10">
                  
                        <div class="col-sm-12 opaco-0-8 m-t-10 p-10" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                            <span class="f-25"><i class="icon_a-clase-personalizada"></i> <span class="f-700">Referir a un amigo</span></span><br>

                             <span class="f-22">Cada participante inscrito en la academia podrá invitar a participar a sus amistades y familiares a través del código de referencia que se le asigna de manera automática, por cada persona inscrita a través del código acumulará <b>25.000</b> puntos.</span>

                            <div class="checkbox bottom-align-text">
                                <div class="toggle-switch p-l-10 m-l-10" data-ts-color="purple">
                                    <input type="hidden" name="referir">
                                    <span class="p-r-10 f-700 f-16">No</span><input id="referir" type="checkbox" hidden="hidden" value="Referir a un amigo">
                                    <label for="referir" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                </div>
                            </div>

                        </div>

                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_progreso="{{url('/')}}/agendar/clases-grupales/progreso";

    $("input:checkbox[name=type]:checked").each(function(){
        selected = array();

        selected.push($(this).val());
    });

    $("input:checkbox").on('change', function(){
        
        if ($(this).is(":checked")){
            valor = $(this).val()
        }else{
            valor = ''
        }

        nombre = $(this).attr('id')
        $('input[name='+nombre+']').val(valor)

        console.log($('input[name='+nombre+']').val())
    });

    

     </script>

@stop