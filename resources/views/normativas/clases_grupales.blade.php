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

                        <?php $url = "/normativas" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center f-25 f-700">Etiqueta dentro del salón de clases</div>
                            <hr>
                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                           <div class="col-md-10">
<div class="text-justify">

<p>Queremos que todos nuestros alumnos tengan una experiencia de baile agradable y educativa. Trataremos a usted  y/o sus hijos con cortesía y respeto. Esperamos que haya una conducta reciproca hacia   sus profesores, el personal  compañeros y bailadores. Solicitamos que  observes  las siguientes reglas sencillas:</p>
<div class="f-18 f-700"> 1- Vestimenta   </div>
<br>

<p>Venga preparado para bailar - vestimenta, el aseo, la actitud, la ambición, la energía!.</p>


<div class="f-18 f-700">2-  Horario  </div><br>

<p>Debe llegar a la academia con tiempo suficiente antes de comenzar la clase. Aquellos alumnos presenten de diez o más minutos de retraso, serán bienvenidos pero  a observar la clase; sin embargo, no se les permitirá participar a menos que haya una circunstancia atenuante. </p>

<div class="f-18 f-700"> 3- Disciplina   </div><br>

<p>Deberá mantener absoluto respeto y disciplina dentro de las instalaciones y salón de clases, no se permiten conductas inapropiadas que se aparten de las  buenas costumbres y buenos modales, al igual que consumo de alimentos y bebidas dentro de la pista de baile. </p>


<div class="f-18 f-700"> 4- Retirada </div><br>

<p>Si el alumno debe retirarse antes  de  finalizar  la clase, debe notificar a su instructor  antes de que comience, de lo contrario los alumnos no deben  salir del salón de clases sin el consentimiento del instructor. </p>

<div class="f-18 f-700"> 5-  Teléfonos  </div><br>

<p>Se prohíbe el uso de dispositivos celulares o aparatos  tecnológicos  dentro de las clases, los teléfonos deben permanecer apagados o en silencio.</p>

<div class="f-18 f-700"> 6-  Calzados   </div><br>

<p>El calzado debe ser tenis, prohibido el uso de tacones, pantuflas, zapatos de vestir, descalzo u otros.</p>

<div class="f-18 f-700"> 7-  Visitantes  </div><br>

<p>No se permiten visitantes dentro del salón de clases.</p>

<div class="f-18 f-700"> 8- Sonido  </div><br>

<p>El manejo del sonido es exclusivo del personal o de instructores, por tal motivo, los alumnos tienen estrictamente prohibido el uso y manejo de los equipos de sonido e iluminación.</p>

<div class="f-18 f-700"> 9- Pertenencias </div><br>

<p>El alumno es responsable de sus pertenecías, tales como, carteras, bolsos, celulares entre otros.</p>
              

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