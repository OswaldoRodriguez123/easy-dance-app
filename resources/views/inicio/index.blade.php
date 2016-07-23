@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>



@stop

@section('content')

<div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"> <h4>
          <!-- <div class="iconox-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
              <title>Confirma tu academia</title>
              <circle fill="#692A5A" cx="16" cy="16" r="16"/>
<img src="{{url('/')}}/assets/img/icono_easydance2.png"  height="26" width="28" style="margin-top: -30px; margin-left: 3px;"/></svg>
</div> -->Confirma tu academia </h4> <!-- <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> --></h4>
                        </div>
                                  
<form name="configurarAcademia" id="configurarAcademia">
<div class="modal-body">                           
<div class="row p-t-20 p-b-0">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-md-offset-5">
                    <div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;" class="img-responsive opaco-0-8" alt=""></div>
                    </div>

                    <div class="clearfix m-20 m-b-25"></div>

<div class="col-sm-11"><br>
<p align="left" style="font-size: 20px;">Bienvenid@, <b> {{Auth::user()->nombre}} </b><br>
<text style="font-size: 16px;">Dedica un momento para ayudarnos a configurar la  cuenta de tu academia.</text></p>
</div>

<div class="clearfix m-20 m-b-25"></div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-sm-7">
                                <div class="form-group ">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre de la academia </label> 
                                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Baila para todos">
                                    </div>
                                </div>
                                <div class="has-error" id="error-nombre">
                                    <span >
                                     <small id="error-nombre_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>
                      </div>

                      <div class="clearfix m-20 m-b-25"></div>

                      <div class="col-sm-7">
                                <div class="form-group ">
                                    <div class="form-group fg-line">
                                        <label for="id">Identificación </label> 
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" placeholder="Ej. J-27283354-7">
                                    </div>
                                </div>
                                <div class="has-error" id="error-identificacion">
                                    <span >
                                     <small id="error-identificacion_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>
                      </div>

                      <div class="clearfix m-20 m-b-25"></div>

                      <div class="col-sm-7">
                                           <label>Especialidad </label>
                                          <div class="form-group">
                                              <div class="fg-line">
                                                  <div class="select">
                                                      <select class="form-control" id="especialidades_id" name="especialidades_id" placeholder="seleccione>>">
                                                      <option value="">Selecciona</option>
                                                      @foreach ( $especialidades as $especialidad )
                                                      <option value = "{{ $especialidad['id'] }}">{{ $especialidad['nombre'] }}</option>
                                                      @endforeach
                                                      </select>
                                                  </div> </div></div> 
                                                  <div class="has-error" id="error-especialidades_id">
                                                  <span >
                                                   <small id="error-especialidades_id_mensaje" class="help-block error-span" ></small>                                           
                                                  </span>
                                                  </div>
                                                </div>

                                                  <div class="clearfix m-20 m-b-25"></div>
                                        
                                        <div class="col-sm-7">
                                           <label>País </label>
                                          <div class="form-group">
                                              <div class="fg-line">
                                                  <div class="select">
                                                      <select class="form-control" id="pais_id" name="pais_id" placeholder="seleccione">
                                                      <option value="">Selecciona</option>
                                                      @foreach ( $paises as $pais )
                                                      <option value = "{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                                                      @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="has-error" id="error-pais_id">
                                                  <span >
                                                   <small id="error-pais_id_mensaje" class="help-block error-span" ></small>                                           
                                                  </span>
                                                </div>
                                       </div> 

                                 <div class="clearfix m-20 m-b-25"></div>
                                 
                                 <div class="col-sm-7">
                                <div class="form-group ">
                                    <div class="form-group fg-line">
                                        <label for="id">Estado / Provincia/  Región </label> 
                                        <input type="text" class="form-control input-sm" name="estado" id="estado" placeholder="Ej. Caracas ">
                                      </div>
                                  </div>
                                  <div class="has-error" id="error-estado">
                                                  <span >
                                                   <small id="error-estado_mensaje" class="help-block error-span" ></small>                                           
                                                  </span>
                                                </div>
                              </div>
                               <div class="col-sm-12 col-sd-12 text-center"><br><br><br>
                              <!-- <a class="btn-blanco2 btn-blanco1._largesubmit  m-r-5 f-16 " type="submit"   data-formulario="edit_cupo_taller" data-update="cupo" style=" margin-top: 20px; " >Enviar </a> -->

                              <button type="button" class="btn-blanco m-r-10 f-16 guardar" id="guardar" name ="guardar" onclick="procesando()">Enviar</button>

                            <br><br><br><br>
                            </div>
                            </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDios" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                   <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                     <h4 class="modal-title c-negro"> <h4>
                      <div class="iconox-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                          <title>Confirma tu academia</title>
                          <circle fill="#692A5A" cx="16" cy="16" r="16"/>
                            <img src="{{url('/')}}/assets/img/icono_easydance2.png"  height="26" width="28" style="margin-top: -30px; margin-left: 3px;"/></svg>
                            </div>Sección no permitida </h4> <!-- <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> --></h4>
                            </div>
                                  
                            <div class="modal-body">                           
                            <div class="row p-t-20 p-b-0">

                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <div align="center"><i class="zmdi zmdi-thumb-up zmdi-hc-5x text-success"></i></div>
                              <div class="c-morado f-40 text-center"> ¡Dios mioooooo! </div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="text-center f-20">Hemos detectado que deseas crear un registro sin haber personalizado tu academia</div>
                              <div class="text-center f-20">No te preocupes te ayudaremos a personalizar tu academia</div>

                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              
                              <div align="center">
                              <button type="submit" class="butp button5" onclick="configuracion()">Quiero personalizar mi academia</button>
                              <button type="submit" class="but2 button55" onclick="atras()"><span>En otro momento</span></button><br><br><br>
                              </div>
                              

                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>
                              <div class="clearfix m-20 m-b-25"></div>

                            </div>
                            <div class="col-md-2"></div>


                    
                            </div>
                            </div>
                            </div>
                    </div>
                </div>
            

            <div style="margin-top: -50px;"></div>

            <div id="what_we_do" class="i-stage back-blanco">
              <br><br><br>
              <div class="clearfix p-b-15"></div>

                <div class="i-stage-dream-header">
                  <div class="f-700 f-25 text-center">A través de la plataforma Easy dance, podrás generar y  recaudar fondos.</div>
                  <br>

                  <div class="opaco-0-8 f-22 text-center">Para el crecimiento económico de tu academia.</div>
                </div>
                <br><br><br>



              <!-- <div class="col-md-2 col-md-offset-2"> Piénsalo</div>
              <div class="col-md-2 col-md-offset-1"> Despega</div>
              <div class="col-md-2 col-md-offset-1"> Difúndelo</div> -->
              <!-- <text Style="margin-left:21%; auto; ">Piénsalo</text>
              <text Style="margin-left:23%; auto;">Despega</text>
              <text Style="margin-left:24%; auto;">Difúndelo</text> -->
              <div style="margin-top: -40px;">
              <img style="display:block; height:70px; width:800px; margin:60px auto 0; background-repeat:no-repeat;"  class="img-responsive" src="{{url('/')}}/assets/img/menu-/d36.png"  />
              </div>
                <div class="i-stage-dream-header" Style="margin-top:100px;">
                  
                  <div class="opaco-0-8 f-22 text-center">Te ayudaremos en cada paso que des para la organización de tu academia</div>
                  <div class="clearfix p-b-15"></div>
                  <div class="clearfix p-b-15"></div>
                  <div class="clearfix p-b-15"></div>
                  <br>




                </div>
              </div>

              <div style="margin-top: -35px;"></div>
@include('layout.footer')
@stop



@section('js') 
<script>

    $(document).ready(function(){
    // $('.materialboxed').materialbox();
    
    if(!"{{$academia->nombre}}")

    {
      setTimeout(function(){ 

        $("#modalConfiguracion").modal({

              backdrop: 'static',

              keyboard: false

          });

        $('#modalConfiguracion').modal('show'); 

        }, 3000);
    }

    });

         $("#guardar").click(function(){

                var route = "{{url('/')}}/configuracion/academia/primerpaso";
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#configurarAcademia" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                procesando();
                $("#guardar").css({
                  "opacity": ("0.2")
                });
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');         
                limpiarMensaje();
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                          window.location = "{{url('/')}}/listo";

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
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
                        $("#guardar").removeAttr("disabled");
                        finprocesado();
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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

            function limpiarMensaje(){
                  var campo = ["nombre", "especialidad_id", "pais_id", "estado"];
                    fLen = campo.length;
                    for (i = 0; i < fLen; i++) {
                        $("#error-"+campo[i]+"_mensaje").html('');
                    }
                  }

                  function errores(merror){
                  var campo = ["nombre", "especialidad_id", "pais_id", "estado"];
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

                  // $('html,body').animate({
                  //       scrollTop: $("#id-"+elemento).offset().top-90,
                  // }, 1500);          

              }

           function configuracion(){
            procesando();
            window.location = "{{url('/')}}/configuracion";
            }
           
           function atras(){
            $('#modalDios').modal('hide');
           }

    </script>

@stop

