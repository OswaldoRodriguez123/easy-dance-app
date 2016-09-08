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

            <a href="{{url('/')}}/agendar/clases-personalizadas/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menu Principal</a>
                    </div> 
                    
                    <div class="card">


                        <div class="card-header">

                            <div class ="col-md-12 text-right">  
                                                      
                               <span class="f-16 p-t-0 text-success">Agregar una Clase Personalizada <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span> 

                            </div>

                        
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada f-25"></i> Sección de Clases Personalizadas</p>
                            <hr class="linea-morada">  

                            <div class="col-sm-7">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="activas" type="radio">
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="finalizadas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Finalizadas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="canceladas" value="canceladas" type="radio" checked >
                                        <i class="input-helper"></i>  
                                        Canceladas <i id="canceladas2" name="canceladas2" class="zmdi zmdi-close zmdi-hc-fw f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                 <div class="clearfix"></div>                                                      
                        </div>


                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <!--<th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>-->
                                    <th class="text-center" data-column-id="acepto" data-order="desc"></th>
                                    <th class="text-center" data-column-id="alumno" data-order="desc">Alumno</th>
                                    <th class="text-center" data-column-id="clase_personalizada" data-order="desc">Clase Personalizada</th>                           
                                    <th class="text-center" data-column-id="instructor" data-order="desc">Instructor</th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc" >Fecha</th>
                                    <th class="text-center" data-column-id="hora" data-order="desc" >Hora</th>
                                    <th class="text-center" data-column-id="operaciones" data-order="desc" >Operaciones</th>
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

        $("#activas").prop("checked", true);

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
        order: [[4, 'desc'], [5, 'desc']],
        fnDrawCallback: function() {
        if ("{{count($activas)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }
        },
        pageLength: 25,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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


        function countChar2(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum2').text(2000 - len);
        }
      };

      function countChar3(val) {
        var len = val.value.length;
        if (len >= 2000) {
          val.value = val.value.substring(0, 2000);
        } else {
          $('#charNum3').text(2000 - len);
        }
      };

      function countChar4(val) {
        var len = val.value.length;
        if (len >= 10000) {
          val.value = val.value.substring(0, 10000);
        } else {
          $('#charNum4').text(10000 - len);
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

    $("#activas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).addClass( "c-verde" );
        });

        $("#finalizadas").click(function(){
            $( "#finalizadas2" ).addClass( "c-verde" );
            $( "#canceladas2" ).removeClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });

        $("#canceladas").click(function(){
            $( "#finalizadas2" ).removeClass( "c-verde" );
            $( "#canceladas2" ).addClass( "c-verde" );
            $( "#activas2" ).removeClass( "c-verde" );
        });

        function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            console.log($(this).val());
            if ($(this).val()=='activas') {
                  tipo = 'activas';
                  rechargeActivas();
            } else if($(this).val()=='finalizadas')  {
                  tipo= 'finalizadas';
                  rechargeFinalizadas();
            }else{
                  tipo= 'canceladas';
                  rechargeCanceladas();
            }
         });

         function rechargeActivas(){
            var activas = <?php echo json_encode($activas);?>;

            $.each(activas, function (index, array) {

              if(array.boolean_alumno_aceptacion == 1){
                acepto = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-20"></i>'
              }else{
                acepto = '';
              }

                var rowNode=t.row.add( [
                ''+acepto+'' ,
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.clase_personalizada_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                '<i data-toggle="modal" name="operacion" class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeFinalizadas(){
            var finalizadas = <?php echo json_encode($finalizadas);?>;

            $.each(finalizadas, function (index, array) {

              if(array.boolean_alumno_aceptacion == 1){
                acepto = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-20"></i>'
              }else{
                acepto = '';
              }

                var rowNode=t.row.add( [
                ''+acepto+'' ,
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.clase_personalizada_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
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

                if(array.boolean_alumno_aceptacion == 1){
                  acepto = '<i class="zmdi c-verde zmdi-check zmdi-hc-fw f-20"></i>'
                }else{
                  acepto = '';
                }
                var rowNode=t.row.add( [
                ''+acepto+'' ,
                ''+array.alumno_nombre+' '+array.alumno_apellido+'' ,
                ''+array.clase_personalizada_nombre+'',
                ''+array.instructor_nombre+' '+array.instructor_apellido+'' ,
                ''+array.fecha_inicio+'',
                ''+array.hora_inicio+' - '+array.hora_final+'' ,
                '<i data-toggle="modal" name="operacion" class="zmdi zmdi-wrench f-20 p-r-10 pointer acciones"></i>'
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }


		</script>
@stop

     