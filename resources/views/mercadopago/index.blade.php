@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="http://resources.mlstatic.com/mptools/render.js"></script>
@stop

@section('content')

<div class="container">

        <a href="{{ $datos['response']['init_point'] }}" name="MP-Checkout" class="btn-blanco m-r-10 f-18 guardar VeOn" mp-mode="modal" onreturn="respuesta_mercadopago">Pagar</a>
        <br><br><br>
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div id="test" class=""></div>
        <div class="clearfix"></div>
        <br><br><br>
        <div id="json"></div>
        
</div>




@stop

@section('js') 

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

            function respuesta_mercadopago(json) {

                $("#json").html(JSON.stringify(json));
                //alert(json);
                if (json.collection_status=='approved'){
                    $("#test").html('Pago acreditado');
                    $("#test").addClass('alert alert-success')
                } else if(json.collection_status=='pending'){
                    $("#test").html('El usuario no completó el pago');
                    $("#test").addClass('alert alert-warning')
                } else if(json.collection_status=='in_process'){    
                    $("#test").html('El pago está siendo revisado');
                    $("#test").addClass('alert alert-info')
                } else if(json.collection_status=='rejected'){
                    $("#test").html('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
                    $("#test").addClass('alert alert-danger')
                } else if(json.collection_status==null){
                    $("#test").html('El usuario no completó el proceso de pago, no se ha generado ningún pago');
                }
            }


        </script>
@stop        