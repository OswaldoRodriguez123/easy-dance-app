@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/summernote/dist/summernote.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/summernote/dist/summernote-updated.min.js"></script>-->
<script src="{{url('/')}}/assets/vendors/summernote/dist/lang/summernote-es-ES.js"></script>

@stop

@section('content')


            <div class="modal fade" id="modalGeneral" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Reglamentos Generales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row">

                        <div class="col-sm-10 col-sm-offset-1 error_general">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>

                          <div class="col-sm-10 col-sm-offset-1 show_general">

                          <div style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc">

                          <p style="font-size: 12px" name="pre_general" id="pre_general"></p>

                          </div>
                          
                          </div>

                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>


                        </div>
                       


                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalClaseGrupal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Reglamentos Clases Grupales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row p-t-20 p-b-0" style="padding-left: 2%">

                        <div class="col-sm-10 col-sm-offset-1 error_clase_grupal">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>
                        
                        <div class="show_clase_grupal">
                        
                        @foreach($clases_grupales as $clase_grupal)

                        <div class="col-sm-12">

                        <span class="f-20 opaco-0-8 clase_grupal c-morado pointer f-700" id="{{$clase_grupal->id}}">{{$clase_grupal->nombre}}</span>

                        </div>


                        @endforeach

                        </div>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        </div>

                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalClaseGrupalMostrar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro" id="titulo_clase_grupal" name="titulo_clase_grupal">Reglamentos Generales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row">

                        <div class="col-sm-10 col-sm-offset-1 error_general">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>

                          <div class="col-sm-10 col-sm-offset-1 show_general">
                          
                          <div style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc">

                            <span name="pre_clase_grupal" id="pre_clase_grupal" style="font-size: 12px"></span>

                          </div>


                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                          
                          </div>

                        </div>
                       


                        </div>
                       
                    </div>
                </div>
            </div>

           <div class="modal fade" id="modalClasePersonalizada" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Reglamentos Clases Personalizadas <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row">

                         <div class="col-sm-10 col-sm-offset-1 error_clase_personalizada">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>

                          <div class="col-sm-10 col-sm-offset-1 show_clase_personalizada">

                          <div style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc">

                          <p style="font-size: 12px" name="pre_personalizada" id="pre_personalizada"></p>

                          </div>


                          
                          </div>

                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                        </div>
                       


                        </div>
                       
                    </div>
                </div>
            </div>

             <div class="modal fade" id="modalFiesta" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Reglamentos Fiestas o Eventos <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row p-t-20 p-b-0" style="padding-left: 2%">

                        <div class="col-sm-10 col-sm-offset-1">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>
                        

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        </div>

                        </div>
                       
                    </div>
                </div>
            </div>

             <div class="modal fade" id="modalTaller" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro">Reglamentos Talleres <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row p-t-20 p-b-0" style="padding-left: 2%">

                        <div class="col-sm-10 col-sm-offset-1 error_taller">


                          <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                          <div class="c-morado f-30 text-center"> No se encontraron resultados </div>


                         </div>
                        
                        <div class="show_taller">
                        @foreach($talleres as $taller)

                        <div class="col-sm-12">

                        <span class="f-20 opaco-0-8 taller c-morado pointer f-700" id="{{$taller->id}}">{{$taller->nombre}}</span>

                        </div>


                        @endforeach

                        </div>

                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        </div>

                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTallerMostrar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro" id="titulo_taller" name="titulo_taller">Reglamentos Generales <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div>
                        <div class="clearfix p-b-15"></div>
                        <div class="clearfix p-b-15"></div>

                        <div class="row">

                          <div class="col-sm-10 col-sm-offset-1">

                          <div style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc">

                            <span name="pre_taller" id="pre_taller" style="font-size: 12px"></span>

                          </div>


                          <div class="clearfix p-b-15"></div>
                          <div class="clearfix p-b-15"></div>

                          
                          </div>

                        </div>
                       


                        </div>
                       
                    </div>
                </div>
            </div>


<div class="container">

<div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/inicio" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
    
    <div class="card">
                <div class="card-body p-b-20">
                    <div class="row">
                        <div class="container">
                          <div class="col-sm-3">
                            <div class="p-t-30">       
                              <div class="row p-b-15 ">
                                <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
                                  <!--<div class="text-center">
                                    <img src="{{url('/')}}/assets/img/detalle_alumnos.jpg" class="img-responsive img-efecto text-center" alt="">
                                  </div>-->
                                  <ul class="ca-menu-planilla">
                                    <li>
                                        <a href="#" class="disabled">
                                            <span class="ca-icon-planilla"><i class="icon_a icon_a-tutoriales"></i></span>
                                            <div class="ca-content-planilla">
                                                <h2 class="ca-main-planilla">Normativas</h2>
                                                <h3 class="ca-sub-planilla">Sección de reglamentos</h3>
                                            </div>
                                        </a>
                                    </li>
                                  </ul>

                                  <div class="clearfix p-b-15"></div>
                                  <div class="clearfix p-b-15"></div>


                                    
                                   
                                </div>

                                </div>                
                              </div>
                              <!--<p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>-->
                                    
                          </div>

                        <div class="pm-body clearfix col-sm-9">
                            <div class="timeline">
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-tutoriales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">REGLAMENTOS GENERALES </strong>

                                        </div>
                                    </div>
                                    <div class="tv-body">
               
                                    
                                        <div class="clearfix"></div>

<!--                                         <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/normativas/generales" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-clases-grupales f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">CLASES GRUPALES   </strong>


                                        </div>
                                    </div>
                                    <div class="tv-body">
                
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/normativas/clases-grupales" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-clase-personalizada f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">CLASES PERSONALIZADAS    </strong>
                                          
                                        </div>
                                    </div>
                                    <div class="tv-body">
      
                                        <div class="clearfix"></div>

                                        <!-- <span class="f-700 f-16 opaco-0-8"> Automatizar</span>

                                        <br>
                                    
                                        <div class="p-t-10">
                                            <div class="toggle-switch" data-ts-color="purple">
                                            <span class="p-r-10 f-700 f-16">No</span><input id="estilo-switch" type="checkbox" hidden="hidden">
                                            <label for="estilo-switch" class="ts-helper"></label><span class="m-t-0 p-t-0 p-l-10 f-700 f-16">Si</span>
                                            </div>
                                        </div> -->
                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/normativas/clases-personalizadas" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</a>
                                        </div>
                                    </div>
                                </div>

            <!--                     <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-fiesta f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">FIESTA EVENTOS</strong>

 
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                       
                                    
                                        <div class="clearfix"></div>


                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" href="#modalFiesta" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</span>
                                        </div>
                                    </div>
                                </div> -->
<!-- 
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-talleres f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">TALLERES     </strong>


                                        </div>
                                    </div>
                                    <div class="tv-body">
                                       
                                    
                                        <div class="clearfix"></div>
                                        
                                        <br>

                                        <div class="text-right">
                                            <span data-toggle="modal" href="#modalTaller" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</span>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <i class="icon_a icon_a-examen f-30 m-r-5 boton blue sa-warning"></i>
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block f-20">DIAGNÓSTICO Y VALORACIONES</strong>

 
                                        </div>
                                    </div>
                                    <div class="tv-body">
                                       
                                    
                                        <div class="clearfix"></div>


                                        
                                        <br>

                                        <div class="text-right">
                                            <a href="{{url('/')}}/normativas/diagnostico" class="f-18 p-t-0 c-morado pointer"> Ver Normativas</a>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop

@section('js') 

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;
        var talleres = <?php echo json_encode($talleres);?>;

        $(document).ready(function() {

            var general = <?php echo json_encode($academia->normativa);?>;

            if(general){

            $("#pre_general").html(nl2br(general));

                $(".show_general").show();
                $(".error_general").hide();

            }else{

                $(".show_general").hide();
                $(".error_general").show();

            }

            if(clases_grupales.length > 0){

                $(".show_clase_grupal").show();
                $(".error_clase_grupal").hide();

            }else{

                $(".show_clase_grupal").hide();
                $(".error_clase_grupal").show();

            }

            var clase_personalizada = <?php echo json_encode($config_clase_personalizada->condiciones);?>;

            if(clase_personalizada){

                $(".show_clase_personalizada").show();
                $("#pre_personalizada").html(nl2br(clase_personalizada));
                $(".error_clase_personalizada").hide();

            }else{

                $(".show_clase_personalizada").hide();
                $(".error_clase_personalizada").show();

            }

            if(talleres.length > 0){

                $(".show_taller").show();
                $(".error_taller").hide();

            }else{

                $(".show_taller").hide();
                $(".error_taller").show();

            }

        });

        $( ".clase_grupal" ).click(function() {

          id = this.id;

          var clase_grupal = $.grep(clases_grupales, function(e){ return e.id == id; });

          $.each(clase_grupal, function (index, array) {

            $("#titulo_clase_grupal").text(array.nombre);
            $("#pre_clase_grupal").html(nl2br(array.condiciones));

          });


          $('#modalClaseGrupalMostrar').modal('show');

        });


        $( ".taller" ).click(function() {

          id = this.id;

          var taller = $.grep(talleres, function(e){ return e.id == id; });

          $.each(taller, function (index, array) {

            $("#titulo_taller").text(array.nombre);
            $("#pre_taller").html(nl2br(array.condiciones));

          });


          $('#modalTallerMostrar').modal('show');

        });

        function nl2br (str, is_xhtml) {   
          var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
          return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      }

        </script>
@stop        