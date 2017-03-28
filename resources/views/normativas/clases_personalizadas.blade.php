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
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/normativas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center f-25 f-700">Normativas de las clases personalizadas</div>
                            <hr>
                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                           <div class="col-md-10">
<div class="text-justify">


<div class="f-18 f-700"> 1. Principal   </div>
<br>

<p>Al momento de hacer la reserva, al alumno comprende que envía una solicitud a la academia  y no una confirmación de la  clase, la reserva  deberá ser verificada y constatada   por un representante  la academia, por medio de la  plataforma o través de una llamada telefónica.</p>


<div class="f-18 f-700">2.  Reservar  </div><br>

<p>Todas las clases personalizadas o paquetes de su elección, deberán ser  apartadas con el 50% del costo total, al momento de asistir deberá pagar  el resto de la  totalidad de la clase, dicha pago podrá ser ejecutado a través de la plataforma o enviando el Boucher del  pago generado  a través, de la cuenta de banco establecida por la academia. </p>

<div class="f-18 f-700"> 3. Asistencia  </div><br>

<p>El alumno deberá asistir en el horario establecido en la reservación, en caso de atraso de parte del alumno, la academia no se responsabiliza ni se obliga  a reponer el tiempo perdido. </p>


<div class="f-18 f-700"> 4. Inasistencia  </div><br>

<p>En caso de que el alumnos no pueda asistir a su clase programada  deberá notificarlo con 08 horas de antelación a través de la plataforma, o confirmar a través de una llamada telefónica su cancelación, de lo contrario, la clase obtendrá un estatus de <b>“cancelación tardía”</b>, lo que significa que esta será percibida como una  clase vista, por tal motivo, esta deberá ser pagada en su totalidad, sin derecho a reprogramar dicha clase, esta podrá ser reprogramada siempre y cuando la cancelación sea superior a las 08 horas de límite que estable la institución.  </p>

<div class="f-18 f-700"> 5. Dinámica </div><br>

<p>Usted comprende que el instructor podrá realizar una clase personalizada, con dos partipantes en una misma sección u hora de clases. </p>

              

                         </div>
                          <div class="col-md-1"></div>           
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