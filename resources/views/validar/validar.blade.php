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
  <!-- ENHORABUENA -->

   <div class="modal fade" id="addNew-event" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!--<h4 class="modal-title">Agendar</h4>-->
                                    <i class="icon_a-agendar f-35" ></i>
                                    <button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body m-b-20">
                                    <p class="text-center p-t-0 f-700 opaco-0-8 f-25">Hey {{Auth::user()->nombre}}. Que bueno tenerte aquí...</p> 
                                    <p class="text-center p-b-20 f-700 opaco-0-8 f-22">¿Listo para validar? Empieza yaaa...</p>

                                    <form id="frm_fecha" name="frm_fecha" class="addFecha" role="form" method="POST" action="guardar-fecha">
                                        <input type="hidden" id="fecha_inicio" name="fecha_inicio" />
                                    </form>
                                    <form id="frm_validar" name="frm_validar" class="addEvent" role="form" method="POST" action="{{url('/')}}/validar">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="codigo_validacion" id="codigo_validacion">
                                    <div class="col-sm-3">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#" class="agendar" data-agendar="reservacion">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-clases-grupales"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Reservaciones</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Validar ya!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-3">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#" class="agendar" data-agendar="regalo">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-clase-personalizada"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Regalos</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Validar ya!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-3">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#" class="agendar" data-agendar="referido" >
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="icon_a-talleres"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Referido</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Validar ya!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="col-sm-3">
                                      <ul class="ca-menu" style="margin: 0 auto;">
                                        <li style="height: 250px;">
                                            <a href="#" class="agendar" data-agendar="promocion">
                                                <span class="ca-icon" style="line-height: 60px, top: 35%;"><i class="zmdi zmdi-calendar-check"></i></span>
                                                <div class="ca-content" style="top: 35%;">
                                                    <h2 class="ca-main f-20">Promoción</h2>
                                                    <h3 class="ca-sub" style="line-height: 20px;">Validar ya!</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    </div>

                                    <div class="clearfix p-b-10"></div>
                                        <input type="hidden" id="validar" name="validar" />
                                    </form>
                                </div>
                                
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>

    
    <div class="container">
    <div class="block-header">
      <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
      <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
      <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
      </div> 
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div align="center"><i class="zmdi zmdi-check zmdi-hc-5x c-morado"></i></div>
              <form>
                <div class="c-morado f-50 text-center"> Validar </div>
                <div class="text-center f-18">Te invitamos a ingresar el código que deseas  validar, como por ejemplo, el de alguna  reservación, tarjeta de regalo, campaña, promoción o examen, de esta forma confirmarás cualquier operación que desees realizar.  </div>
                <div class="clearfix"></div><br><br>
                <div class="text-center f-30 c-morado">Ingresa el Serial y valida</div>
                <div class="clearfix m-20 m-b-25"></div>
                <div class="block-header text-center">
                  <input type="text" class="form-control caja" name="codigo" id="codigo"></input>
                  <div class="has-error" id="error-codigo">
                    <span >
                        <small class="help-block error-span" id="error-codigo_mensaje" ></small>                                
                    </span>
                  </div>
                  <div class="clearfix m-20 m-b-25"></div>
                  <a class="btn-blanco m-r-10 f-20 guardar pointer" > Validar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
                </div> 
              </form>
            </div>
            <div class="col-md-2"></div>
            
        </div>
        <div class="card-body">
         <div class="clearfix"></div>  
        </div>
      <div class="clearfix m-20 m-b-25"></div>
      </div>
      
      <!--<div class="clearfix"></div>-->

    </div>


@stop


@section('js') 
            
		<script type="text/javascript">
            route_validar="{{url('/')}}/validar";
            route_exitoso="{{url('/')}}/validar/exitoso";
            route_invalido="{{url('/')}}/validar/invalido";
            route_deuda = "{{url('/')}}/participante/alumno/deuda/"

            $(".guardar").click(function(){
              $('#error-codigo_mensaje').html('')
              codigo = $('#codigo').val()

              if(codigo.trim() != ''){

                $('#codigo_validacion').val(codigo)
                $('#addNew-event').modal('show')

              }else{
                $('#error-codigo_mensaje').html('Ups! El codigo es requerido')
              }
            });
            
            // $(".guardar").click(function(){
                
            //     var route = route_validar;
            //     var token = "{{ csrf_token() }}";
            //     var codigo = $("#codigo").val();
            //     procesando();
           
            //     $.ajax({
            //         url: route,
            //             headers: {'X-CSRF-TOKEN': token},
            //             type: 'POST',
            //             dataType: 'json',
            //             data: "&codigo_validacion="+codigo,
            //         success:function(respuesta){
            //           setTimeout(function(){ 

            //             if(respuesta.route == 1)
            //             {
            //               window.location = route_deuda + respuesta.alumno_id;
            //             }else{
            //               window.location = route_exitoso;
            //             }
                     
            //           }, 1000);
            //         },
            //         error:function(msj){
            //           setTimeout(function(){ 
                        
            //             window.location = route_invalido;

            //           }, 1000);
            //         }
            //     });
            // });

            $('.agendar').on('click', function(e){
                    e.preventDefault();
                    console.log("estoy aqui");
                    var agendar = $(this).data('agendar');

                    $('#validar').val(agendar);

                    $("#frm_validar").submit();
                     
                });


		</script>
@stop