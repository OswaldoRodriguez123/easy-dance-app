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

<div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Configuracion Clase Personalizada<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="configuracion_clase_personalizada" id="configuracion_clase_personalizada"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                                <div class="col-sm-12">
                                    <label for="apellido" id="id-imagen_principal">Diseño principal</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Carga una imagen horizontal  para que sea utilizada cuando compartes en Facebook.  Resolución recomendada: 1200 x 630, resolución mínima: 600 x 315" title="" data-original-title="Ayuda"></i>
                                    
                                    <div class="clearfix p-b-15"></div>
                                      
                                      <input type="hidden" name="imageBase64" id="imageBase64">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div id="imagena" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:450px">
                                        @if($config_clase_personalizada->imagen_principal)
                                          <img src="{{url('/')}}/assets/uploads/clase_personalizada/{{$config_clase_personalizada->imagen_principal}}" style="line-height: 150px;">
                                        @endif</div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen_principal" id="imagen_principal" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                      <div class="has-error" id="error-imagen_principal">
                                      <span >
                                          <small class="help-block error-span" id="error-imagen_principal_mensaje"  ></small>
                                      </span>
                                    </div>
                                  </div>

                                  <div class="clearfix p-b-35"></div>

                                  <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-descripcion">Descripción</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Presenta los objetivos de las clases personalizadas e infórmales del método que usan para lograr el objetivo" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" style="height: 100%" id="descripcion" name="descripcion" rows="8" placeholder="1000 Caracteres" onkeyup="countChar2(this)">{{$config_clase_personalizada->descripcion}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum2">1000</span> Caracteres</div>
                                 <div class="has-error" id="error-descripcion">
                                      <span >
                                          <small class="help-block error-span" id="error-descripcion_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                  <label for="id" id="id-video_promocional">Ingresa url del video promocional</label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa un video promocional de tus clases de baile como instructor o bailarín, esmérate en hacer una buena producción visual, de esa forma te ayudaremos a impulsar tu marca personal de mejor manera" title="" data-original-title="Ayuda"></i>
                                  
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="zmdi zmdi-videocam f-20 c-morado"></i>
                                    </span>  

                                    <div class="fg-line">                       
                                      <input type="text" class="form-control caja input-sm" name="video_promocional" id="video_promocional" placeholder="Ingresa la url" value="{{$config_clase_personalizada->video_promocional}}">
                                    </div>
                                   </div>
                                   
                                   <div class="has-error" id="error-video_promocional">
                                    <span >
                                     <small id="error-video_promocional_mensaje" class="help-block error-span" ></small>                                           
                                    </span>
                                    </div>                                          
                                </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="nombre" id="id-ventajas">Programación ventajas y beneficios </label><i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa la programación, ventajas y beneficios que ofrece tu plan de clases personalizadas" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" style="height: 100%" id="ventajas" name="ventajas" rows="8" placeholder="1000 Caracteres" onkeyup="countChar3(this)">{{$config_clase_personalizada->ventajas}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum3">1000</span> Caracteres</div>
                                 <div class="has-error" id="error-ventajas">
                                      <span >
                                          <small class="help-block error-span" id="error-ventajas_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-12">
                                 
                                    <label for="condiciones" id="id-condiciones">Condiciones y Normativas</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa las condiciones necesarias, dichas condiciones serán vistas por tus clientes y de esa forma podrás mantener una comunicación clara y transparente en cuanto a las normativas que rigen en tus actividades" title="" data-original-title="Ayuda"></i>

                                    <br></br>

                                    <div class="fg-line">
                                      <textarea class="form-control caja" style="height: 100%" id="condiciones" name="condiciones" rows="8" placeholder="1000 Caracteres" onkeyup="countChar4(this)">{{$config_clase_personalizada->condiciones}}</textarea>
                                    </div>
                                    <div class="opaco-0-8 text-right">Resta <span id="charNum4">1000</span> Caracteres</div>
                                 <div class="has-error" id="error-condiciones">
                                      <span >
                                          <small class="help-block error-span" id="error-condiciones_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>
                            

                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-12 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>

                            <div class="col-sm-4 text-left"> 
                          
                            </div>

                            <div class="col-sm-4 text-center">
                             
                              <!-- <i class="zmdi zmdi-cloud zmdi-hc-fw f-20 m-r-5 boton blue sa-warning" data-original-title="Guardar" data-toggle="tooltip" data-placement="bottom" title=""></i> -->
                              <a href="{{url('/')}}/agendar/clases-personalizadas/progreso/{{Auth::user()->academia_id}}"><i class="zmdi zmdi-eye zmdi-hc-fw f-30 boton blue sa-warning"></i></a>

                              <br>

                              <span class="f-700 opaco-0-8 f-16">Ver Progreso</span>
                              
                               
                            </div>

                            <div class="col-sm-4">                            

                              <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" id="guardar" >Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
     
            <a href="{{url('/')}}/agendar/clases-personalizadas/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                    </div> 
                    
                    <div class="card">


                        <div class="card-header">


                          <div class ="col-md-6 text-left"> 
                                                      
                               <a data-toggle="modal" href="#modalConfiguracion"><i class="tm-icon zmdi zmdi-calendar-check f-25 pointer detalle" data-html="true" data-original-title="" data-content=" <br> Levantar Promoción" data-toggle="popover" data-placement="bottom" title="" type="button" data-trigger="hover"></i></a>

                            </div>


                            <div class ="col-md-6 text-right">  
                                                      
                               <span class="f-16 p-t-0 text-success">Agregar una Clase Personalizada <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 

                            </div>

                        
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada f-25"></i> Sección de Clases Personalizadas</p>
                            <hr class="linea-morada">                                                        
                        </div>

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="activas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="canceladas" value="canceladas" type="radio">
                                        <i class="input-helper"></i>  
                                        Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>                                 
                                    <th class="text-center" data-column-id="alumno" data-order="desc">Alumno</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc">Hora [Inicio - Fin]</th>
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >


                                                           
                            </tbody>
                        </table>
                         </div>
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
            
        route_detalle="{{url('/')}}/agendar/clases-personalizadas/detalle"
        route_operacion="{{url('/')}}/agendar/clases-personalizadas/operaciones"
        route_configuracion="{{url('/')}}/agendar/clases-personalizadas/configurar"

        tipo = 'activas';
            
        $(document).ready(function(){

         $("#imagen_principal").bind("change", function() {
            //alert('algo cambio');
            
            setTimeout(function(){
              var fileinput = $("#imagena img").attr('src');
              //alert(fileinput);
              var image64 = $("input:hidden[name=imageBase64]").val(fileinput);
            },500);

        });

        $("#activas").prop("checked", true);

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[1, 'asc']],
        fnDrawCallback: function() {
        if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
        },
        pageLength: 25,
        paging: false,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3)', nRow).attr( "onclick","previa(this)" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                        searchPlaceholder: "BUSCAR",
                        lengthMenu:     "Mostrar _MENU_ Registros",
                        info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
                        infoFiltered:   "(filtrada de _MAX_ registros en total)",
                        infoPostFix:    "",
                        loadingRecords: "...",
                        zeroRecords:    "No se encontraron registros coincidentes",
                        emptyTable:     "No hay datos disponibles en la tabla",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        },
                        aria: {
                            sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
                            sortDescending: ": habilitado para ordenar la columna en orden descendente"
                        }
                    }
        });
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    }
                });

                rechargeActivas();
			});
        
      function previa(t){
        var row = $(t).closest('tr').attr('id');
        var route =route_detalle+"/"+row;
        window.location=route;
      }

      $('#tablelistar tbody').on( 'click', 'i.zmdi-wrench', function () {

            var id = $(this).closest('tr').attr('id');
            var route =route_operacion+"/"+id;
            window.location=route;
         });

       function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='activas') {
                  tipo = 'activas';
                  rechargeActivas();
            } else  {
                  tipo= 'canceladas';
                  rechargeCanceladas();
            }
         });


       $("#activas").click(function(){
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#canceladas").click(function(){
            $( "#activas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).addClass( "c-verde" );
        });


        function rechargeActivas(){
            var activas = <?php echo json_encode($activas);?>;

            $.each(activas, function (index, array) {

                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.alumno_nombre+ ' '+array.alumno_apellido+'',
                ''+array.hora_inicio+ ' - '+array.hora_final+'',
                ''+array.instructor_nombre+ ' '+array.instructor_apellido+'',
                '<i data-toggle="modal" name="operacion" class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeCanceladas(){
            var canceladas = <?php echo json_encode($canceladas);?>;

            $.each(canceladas, function (index, array) {
                var rowNode=t.row.add( [
                ''+array.fecha_inicio+'',
                ''+array.alumno_nombre+ ' '+array.alumno_apellido+'',
                ''+array.hora_inicio+ ' - '+array.hora_final+'',
                ''+array.instructor_nombre+ ' '+array.instructor_apellido+'',
                '<i data-toggle="modal" name="operacion" class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('text-center');
            });
        }

        function countChar2(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        } else {
          $('#charNum2').text(1000 - len);
        }
      };

      function countChar3(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        } else {
          $('#charNum3').text(1000 - len);
        }
      };

      function countChar4(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        } else {
          $('#charNum4').text(1000 - len);
        }
      };

      $("#guardar").click(function(){

                var route = route_configuracion;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#configuracion_clase_personalizada" ).serialize(); 
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
                          finprocesado();
                          var nType = 'success';
                          // $("#agregar_alumno")[0].reset();
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        } 

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          $("#guardar").removeAttr("disabled");
                          finprocesado();
                          $("#guardar").css({
                            "opacity": ("1")
                          });
                          $(".cancelar").removeAttr("disabled");
                          $('.modal').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                                              
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        // if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
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
        var campo = ["imagen", "descripcion", "video_promocional", "ventajas", "imagen1", "imagen2", "imagen3"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
      var campo = ["imagen", "descripcion", "video_promocional", "ventajas", "imagen1", "imagen2", "imagen3"];
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
                        template: '<div data-growl="container" class="alert f-700" role="alert">' +
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

     