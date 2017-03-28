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
                        <h4><i class="zmdi zmdi-info p-r-5"></i> Información <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Normas </span></h4>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center f-25 f-700">Normas de la comunidad</div>
                            <hr>
                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                           <div class="col-md-10">
<div class="text-justify">

<p><b>Respeto:</b> en Easy dance promovemos el respeto , y nuestro compromiso es brindar el mayor respeto a nuestros clientes ,por tal motivo , te pedimos de igual manera que si deseas generar algún comentario, consulta ,queja, molestia o duda u otra actividad que deseas generar , esperamos que sea en un tono respetuoso.</p>

<p><b>Educado:</b> Usa un lenguaje acorde a las etiquetas sociales del uso y conducta del buen comportamiento.</p>

<p><b>Objetivo:</b> Genera comentarios apegados a los que a su criterio se considera justo y correcto a sus principios y costumbres,con independencia de la propia manera de pensar o de sentir</p>

<p><b>Útil:</b> Podemos ser una comunidad grande y respetada a medida que generemos comentarios de valor y enfilados al crecimiento colectivo,todo aporte que generes para el crecimiento de la aplicación es valorado y agradecido, en nuestra comunidad creemos en ti como recurso humano para contribuir a ser mejores personas.</p>

<p><b>Nota:</b> nuestro trabajo es promover la calidad del servicio para nuestros usuarios, por tal motivo todo aquello que se aparte de los códigos de la normas de la comunidad y/u otros elementos de los Términos del uso, podremos considerar la expulsión de nuestra comunidad y el cierre de su cuenta sin previo aviso.</p>


</div>
              

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