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
                            <div class="text-center f-25 f-700">Normativas de diagnósticos de ingresos</div>
                            <hr>
                        </div>
                        <div class="col-md-1"></div>
                          <div class="col-md-10">
                            <div class="text-justify">

                              <p>La organización ofrece un diagnóstico de ingreso completamente gratis en los horarios establecidos por la misma, estos serán anunciados y agendados con anticipación para la preparación del cliente y el buen desarrollo de los procesos organizativos:</p>

                              <p>1. Las fechas y horarios de los diagnósticos de ingresos serán ofrecidos por parte de la organización, en caso que el alumno no posea disponibilidad de tiempo para el horario establecido, podrá agendar en un horario diferente y de su preferencia; esta cita será considerada con un estatus de cita exclusiva, el cual, tiene un valor económico adicional por la atención y procesos adicionales.</p>

                              <p>2. Todos los participantes disfrutarán del uso y grandes ventajas de la aplicación tecnológica Easy Dance, sólo desde el momento de haber realizado su diagnóstico de ingreso.</p>

                              <p>3. En caso de que un participante llegue tarde a su cita de diagnóstico de ingreso, podrá acceder sólo en caso de existir cupos disponibles para los siguientes horarios del día, así mismo deberá asumir una cuota de retraso valorada y anunciada por la organización.</p>

                              <p>4. Después que el participante haya agendado su cita de diagnóstico de ingreso a los horarios que establece la organización , y este (el cliente) no pueda asistir por razones propias o ajenas a su voluntad, perderá el derecho de recibir dicha valoración de manera gratuita, la cita podrá ser agendada una vez más por el cliente en mutuo acuerdo con la organización, cambiandola (la cita) a estatus de <b>Cita exclusiva</b>  </p>

                              <p>5. En caso de que el alumno desee realizar un cambio de horario de su diagnóstico, deberá comunicarse con la organización con un mínimo de 08 horas de anticipación y solicitar dicho cambio, este cambio podrá ser posible en caso de existir disponibilidad en la agenda de citas, de lo contrario el participante deberá aplicar el estatus de cita exclusiva.</p>

                              <div class="f-18 f-700"> Tipos de citas  </div><br>

                              <p>✔  Estatus de cita exclusiva: 10.000 $ <br>
                                ✔ Cita retraso: 4.000$ <br>
                              </p>

              

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