@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>


<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/mensajes/detalle/{{$mensaje->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Vista Previa</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-smartphone f-25"></i> Enviar Mensaje: {{$mensaje->titulo}}</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="form_mensaje" id="form_mensaje">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="mensaje_id" id="mensaje_id" value="{{$mensaje->id}}">

                                <div class="col-md-4">
                                    <label>Alumnos / Visitantes</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">Alumnos</option>
                                            <option value="3">Visitantes Presenciales</option>
                                        </select>
                                      </div>
                                </div>                  

                                <div class="col-md-4">
                                    <label>Tipo</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo2" id="tipo2">
                                            <option value="1">Todos</option>
                                            <option value="2">Clases Grupales</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label id="id-usuarios">Alumno / Visitante</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="usuario_id" id="usuario_id" multiple="" data-max-options="5" title="Todos">
                                            @foreach($alumnos as $alumno)
                                                <option value="{{$alumno->id}}">{{$alumno->nombre}} {{$alumno->apellido}} {{$alumno->identificacion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="has-error" id="error-usuarios">
                                        <span>
                                            <small class="help-block error-span" id="error-usuarios_mensaje" ></small>      
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix m-b-20"></div>  

                                <button type="button" class="btn btn-blanco m-l-10 f-10" id="enviar" >Enviar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
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

        route_mensaje="{{url('/')}}/mensajes/enviar";

        var alumnos = <?php echo json_encode($alumnos);?>;  
        var visitantes = <?php echo json_encode($visitantes);?>;  

        $(document).ready(function(){

            $('#tipo').val(1)
            $('#tipo').selectpicker('refresh')
            rechargeAlumno();

        });


        $("#tipo").change(function(){

            if($(this).val() == 1){
                rechargeAlumno();
            }else if($(this).val() == 3){
                rechargeVisitante()
            }
          
        });

        function rechargeAlumno(){

            $('#tipo2').empty();
            $('#tipo2').append('<option value="1" data-content="Todos"></option>')
            $('#tipo2').append('<option value="2" data-content="Clases Grupales"></option>')

            $('#tipo2').selectpicker('refresh');

            $('#usuario_id').empty();

            $.each(alumnos, function (index, array) {
              $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+ " " + array.identificacion+'"></option>')
            });

            $('#usuario_id').selectpicker('refresh');

        }

        function rechargeVisitante(){

            $('#tipo2').empty();
            $('#tipo2').append('<option value="1" data-content="Todos"></option>')
            $('#tipo2').append('<option value="2" data-content="Inscritos"></option>')
            $('#tipo2').append('<option value="3" data-content="No Inscritos"></option>')

            $('#tipo2').selectpicker('refresh');

            $('#usuario_id').empty();

            $.each(visitantes, function (index, array) {
              $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+'"></option>');
            });

            $('#usuario_id').selectpicker('refresh');

        }

        $("#tipo2").change(function(){

            value = $(this).val()

            $('#usuario_id').empty();

            if($('#tipo').val() == 1){
                $.each(alumnos, function (index, array) {
                    if(value == 1){
                        $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+ " " + array.identificacion+'"></option>')
                    }else{
                        if(array.clase_grupal_id > 0){
                            $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+ " " + array.identificacion+'"></option>')
                        }
                    }
                });
            }else{
                $.each(visitantes, function (index, array) {
                    if(value == 1){
                        $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+'"></option>');
                    }else if(value == 2){
                        if(array.cliente){
                            $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+'"></option>');
                        }
                    }else{
                        if(!array.cliente){
                            $('#usuario_id').append('<option value='+array.id+' data-content="'+array.nombre + " " + array.apellido+'"></option>');
                        }
                    }
                });
            }

            $('#usuario_id').selectpicker('refresh');
        });

        $("#enviar").on('click', function(){

            procesando();
            
            var datos = $( "#form_mensaje" ).serialize();
            var token = $('input:hidden[name=_token]').val();
            var usuario_id = $('#usuario_id').val();
            var usuarios = '';
            
            if(usuario_id){
              for(var i = 0; i < usuario_id.length; i += 1) {
                usuarios = usuarios + ',' + usuario_id[i];
              }
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: route_mensaje,
                type: 'POST',
                dataType: 'json',
                data: datos+"&usuarios="+usuarios,
                success:function(respuesta){
                  setTimeout(function(){ 
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY"; 
                    if(respuesta.status=="OK"){
                      var nFrom = $(this).attr('data-from');
                      var nAlign = $(this).attr('data-align');
                      var nIcons = $(this).attr('data-icon');
                      var nAnimIn = "animated flipInY";
                      var nAnimOut = "animated flipOutY"; 
                      var nType = 'success';
                      var nTitle="Ups! ";
                      var nMensaje="Tu mensaje ha sido enviado exitósamente";

                      finprocesado();

                    }else{
                      var nTitle="Ups! ";
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                      var nType = 'danger';
                    }                       
                    finprocesado();
                    notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  }, 1000);
                },
                error:function(msj){
                  setTimeout(function(){ 
                    if(msj.responseJSON.status=="ERROR"){
                      console.log(msj.responseJSON.errores);
                      errores(msj.responseJSON.errores);
                      var nTitle="    Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                    }else{
                      var nTitle="   Ups! "; 
                      var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                    }                        
                    finprocesado();
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

        function errores(merror){
          var elemento="";
          var contador=0;
          $.each(merror, function (n, c) {
          if(contador==0){
          elemento=n;
          }
          contador++;

           $.each(this, function (name, value) {              
              var error=value;
              $("#error-"+n+"_mensaje").html(error);             
           });
        });

          $('html,body').animate({
                scrollTop: $("#id-"+elemento).offset().top-90,
          }, 1500);          

      }

      function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
        $.growl({
            icon: icon,
            title: titulo,
            message: mensaje,
            url: ''
        },{
          element: 'body',
          type: type,
          allow_dismiss: true,
          placement: {
                  from: from,
                  align: align
          },
          offset: {
              x: 20,
              y: 85
          },
          spacing: 10,
          z_index: 1070,
          delay: 2500,
          timer: 2000,
          url_target: '_blank',
          mouse_over: false,
          animate: {
                  enter: animIn,
                  exit: animOut
          },
          icon_type: 'class',
          template: '<div data-growl="container" class="alert" role="alert">' +
                          '<button type="button" class="close" data-growl="dismiss">' +
                              '<span aria-hidden="true">&times;</span>' +
                              '<span class="sr-only">Close</span>' +
                          '</button>' +
                          '<span data-growl="icon"></span>' +
                          '<span data-growl="title"></span>' +
                          '<span data-growl="message"></span>' +
                          '<a href="#" data-growl="url"></a>' +
                      '</div>'
          });
        };


    </script>

@stop