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

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">


                        <span class="f-14 p-t-20 text-success">Ver listado <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-16 "></i></span> <button class="btn btn-default btn-icon waves-effect waves-circle waves-float" style="margin-left:2%" name="listado" id="listado"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></button>  

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-shield-check zmdi-hc-fw f-25"></i> Registro de asistencia</p>
                        <hr class="linea-morada">
                        <br>
                                                              
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="confirmacion" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="descripcion">Imagen</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Nombre</th>
                                    <th class="text-center" data-column-id="costo" data-type="numeric">Identificacion</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($alumnosacademia as $alumno)
                                <?php $id = $alumno->id; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$alumno->imagen}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$alumno->nombre}} {{$alumno->apellido}}" data-identificacion-participante = "{{$alumno->identificacion}}" data-tipo-participante = "alumno">

                                    <td class="text-center previa"> @if(isset($activacion[$id])) <i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i> @endif</td>
                                    <td class="text-center previa">
                                        @if($alumno->imagen)
                                        <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/{{$alumno->imagen}}" alt="">
                                        @else
                                            @if($alumno->sexo == 'M')
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                            @else
                                              <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                        @endif
                                      @endif
                                    </td>
                                    <td class="text-center previa">{{$alumno->nombre}} {{$alumno->apellido}}</td>
                                    <td class="text-center previa">{{$alumno->identificacion}}</td>

                                </tr>
                            @endforeach 

                            @foreach ($instructores as $alumno)
                                <?php $id = $alumno->id; ?>
                                <tr id="asistencia_alumno_row_{{$id}}" class="seleccion" data-imagen = "{{$alumno->imagen}}" data-id-participante = "{{$id}}" data-nombre-participante = "{{$alumno->nombre}} {{$alumno->apellido}}" data-identificacion-participante = "{{$alumno->identificacion}}" data-tipo-participante = "insctructor">
                                    <td class="text-center previa"></td>
                                    <td class="text-center previa">
                                        <!-- if($alumno['imagen'])
                                            <img class="lv-img-sm" src="{{url('/')}}/assets/uploads/instructor/{{$alumno['imagen']}}" alt="">
                                        else -->
                                            <img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">
                                        <!-- endif -->
                                    </td>
                                    <td class="text-center previa">{{$alumno->nombre}} {{$alumno->apellido}}</td>
                                    <td class="text-center previa">{{$alumno->identificacion}} <i class="icon_a-instructor"></i></td>

                                </tr>
                            @endforeach 
                                                           
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

      route_consultar_cg="{{url('/')}}/asistencia/consulta/clases-grupales";
      route_agregar_asistencia="{{url('/')}}/asistencia/agregar";
      route_agregar_asistencia_permitir="{{url('/')}}/asistencia/agregar/permitir";
      route_agregar_asistencia_instructor="{{url('/')}}/asistencia/agregar/instructor";
      route_agregar_asistencia_instructor_permitir="{{url('/')}}/asistencia/agregar/instructor/permitir";

        $(document).ready(function(){

            t=$('#tablelistar').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 25,  
            order: [[1, 'asc']],
            fnDrawCallback: function() {
            if ("{{count($alumnosacademia)}}" < 25) {
                  $('.dataTables_paginate').hide();
                  $('#tablelistar_length').hide();
              }else{
                 $('.dataTables_paginate').show();
              }
            },
            pageLength: 25,
            language: {
                  searchPlaceholder: "Buscar"
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
              $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
              $('td:eq(0),td:eq(1),td:eq(2)', nRow).attr( "onclick","buscar(this)" );
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
        });

    // $('#buscar').on( 'keyup', function () {
    //   asistencia.search( this.value ).draw();
    // });

    $("#listado").on('click',function(){
      window.location = "{{url('/')}}/asistencia";
    });

    $("#permitir").on('click',function(){
      var route = route_agregar_asistencia;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia" ).serialize(); 
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){            
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia")[0].reset();
              $("#asistencia-horario").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;

              $('#modalAsistencia').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content");


            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }
            
          },
          error:function(msj){
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            if(msj.responseJSON.status=="ERROR"){
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
            }else if(msj.responseJSON.status=="ERROR_ASOCIADO"){
              swal({   
                    title: "¿Desea permitir la entrada?",   
                    text: "El alumno no se encuentra asociado a esta clase!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Permitir!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
                if (isConfirm) {
                    var route = route_agregar_asistencia_permitir;
                    var token = $('input:hidden[name=_token]').val();
                    var datos = $( "#agregar_asistencia" ).serialize(); 
                    $.ajax({
                      url: route,
                      headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data:datos,
                        success:function(respuesta){  
                          console.log(respuesta)          
                          if(respuesta.status=="OK"){
                            $('#modalAsistencia').modal('hide');
                            swal("Permitido!", respuesta.mensaje, "success");
                            $("#content").toggleClass("opacity-content");
                            $("header").toggleClass("abierto");
                            $("footer").toggleClass("opacity-content");                                              
                          }else{
                            var nType = 'danger';
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                          }
                          
                        },
                        error:function(msj){
                          var nType = 'danger';
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
                          
                        }
                        
                      });
                  
                  
                }
              });

            }else if(msj.responseJSON.status=="ERROR_REGISTRADO"){
              var nType = 'info';
              var nTitle="    Ups! "; 
              var nMensaje="El alumno no ha formalizado su inscripción"; 
            } 
            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          }
          
        });
    });


    $("#permitir_instructor").on('click',function(){
      var route = route_agregar_asistencia_instructor;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:datos,
          success:function(respuesta){  
            console.log(respuesta)          
            if(respuesta.status=="OK"){
              var nType = 'success';
              $("#agregar_asistencia_instructor")[0].reset();
              $("#asistencia-horario-instructor").text("---");
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              $('#modalAsistenciaInstructor').modal('hide');
              swal("Permitido!", respuesta.mensaje, "success");
              $("#content").toggleClass("opacity-content");
              $("header").toggleClass("abierto");
              $("footer").toggleClass("opacity-content"); 
            }else{
              var nType = 'danger';
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';
              console.log(msj);
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }
          },
          error:function(msj){
            var nType = 'danger';
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nAnimIn = "animated flipInY";
            var nAnimOut = "animated flipOutY"; 
            var nTitle="Ups! ";
            if(msj.responseJSON.status=="ERROR"){
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
            }else if(msj.responseJSON.status=="ERROR_ASOCIADO"){

              swal({   
                    title: "¿Desea permitir la entrada como suplente?",   
                    text: "El instructor no se encuentra asociado a esta clase!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Permitir!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: false 
                }, function(isConfirm){   
                if (isConfirm) {
                    var route = route_agregar_asistencia_instructor_permitir;
                    var token = $('input:hidden[name=_token]').val();
                    var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
                    $.ajax({
                      url: route,
                      headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data:datos,
                        success:function(respuesta){  
                          console.log(respuesta)          
                          if(respuesta.status=="OK"){
                            $('#modalAsistenciaInstructor').modal('hide');
                            swal("Permitido!", respuesta.mensaje, "success");
                            $("#content").toggleClass("opacity-content");
                            $("header").toggleClass("abierto");
                            $("footer").toggleClass("opacity-content");                                              
                          }else{
                            var nType = 'danger';
                            var nTitle="Ups! ";
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                            var nType = 'danger';
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                            //console.log(msj);
                          }
                          
                        },
                        error:function(msj){
                          var nType = 'danger';
                          var nFrom = $(this).attr('data-from');
                          var nAlign = $(this).attr('data-align');
                          var nIcons = $(this).attr('data-icon');
                          var nAnimIn = "animated flipInY";
                          var nAnimOut = "animated flipOutY"; 
                          var nTitle="Ups! ";
                          if(msj.responseJSON.status=="ERROR"){
                            var nTitle="    Ups! "; 
                            var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                            // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
                          }else{

                           
                          }
                          
                        }
                        
                      });
                  
                  
                }
              });
              /*
              var nType = 'warning';
              var nTitle="    Ups! "; 
              var nMensaje="El instructor no se encuentra asociado a la clase"; 
              */
            }
            //notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
          }
          
        });
    });
    

    $('#asistencia-clase_grupal_id').on('change', function(){
      if ($(this).val()=='') {
        $("#asistencia-horario").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario").text(valor[1]);
      }
    });


     $('#asistencia-clase_grupal_id_instructor').on('change', function(){
      if ($(this).val()=='') {
        $("#asistencia-horario-instructor").text("---");           
      }else{
        $var = valor=$(this).val().split('-');
        $("#asistencia-horario-instructor").text(valor[1]);
      }
    });

      function buscarInstructor(t){
        procesando();

        var row = $(t).closest('tr');

        var id_instructor = $(row).data('id-participante');
        var nombre_instructor = $(row).data('nombre-participante');

        $('#asistencia_id_instructor').val(id_instructor);
        $('#asistencia-nombre-instructor').text(nombre_instructor);
        $("#asistencia-horario-instructor").text("---");

        var route = route_consultar_cg;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          success:function(respuesta){
            
            $('#asistencia-clase_grupal_id_instructor').empty();        
            $('#asistencia-clase_grupal_id_instructor').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) {                     
              $('#asistencia-clase_grupal_id_instructor').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id));

            });

            finprocesado();
            $('#modalAsistenciaInstructor').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });
      }


      function buscarAlumno(t){
        procesando();
        $('#clases_grupales_alumno').empty();

        var row = $(t).closest('tr');

        var id_alumno = $(row).data('id-participante');
        var nombre_alumno = $(row).data('nombre-participante');
        var imagen = $(row).data('imagen');
        var sexo = $(row).data('sexo');

        if(imagen){
          $('#alumno_imagen').attr('src', "{{url('/')}}/assets/uploads/usuario/"+imagen)
        }else{
          if(sexo == 'M'){
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Hombre.jpg")
          }else{
            $('#alumno_imagen').attr('src', "{{url('/')}}/assets/img/Mujer.jpg")
          }
        }

        $('#asistencia_id_alumno').val(id_alumno);
        $('#asistencia-nombre-alumno').text(nombre_alumno);
        $("#url_pagar").attr("href", "{{url('/')}}/participante/alumno/deuda/"+id_alumno);

        $("#asistencia-horario").text("---");
        var route = route_consultar_cg;
        var token = $('input:hidden[name=_token]').val();
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          data: "&id="+id_alumno,
          success:function(respuesta){
            $.each(respuesta.inscripciones, function (index, array) { 
              if(array.diferencia > 1){
                restan = 'Restan '
                dias = ' dias'
              }else{
                restan = 'Resta '
                dias = ' dia'
              }
              $('#clases_grupales_alumno').append('<p>' + array.nombre + ' <br>' + array.hora_inicio + ' / ' + array.hora_final + ' <br> ' + array.dia + ' <br> ' + 'Fecha de Pago: ' + array.fecha_pago + ' <br> ' + restan + array.diferencia + dias + '</p>')
            });
            
            $('#asistencia-clase_grupal_id').empty();        
            $('#asistencia-clase_grupal_id').append( new Option("Selecciona",""));
            $.each(respuesta.clases_grupales, function (index, array) {                   
              $('#asistencia-clase_grupal_id').append( new Option(array.nombre +'  -   Desde:'+array.hora_inicio+'  /   Hasta:'+array.hora_final + '  -  ' + array.instructor,array.id+'-Desde:'+array.hora_inicio+' Hasta:'+array.hora_final+'-'+array.tipo+'-'+array.tipo_id));
            });

            $('#asistencia-estado_economico').text(respuesta.deuda);
            if(respuesta.deuda > 0){
              $( "#url_pagar" ).show();
              $( "#acciones" ).show();
              $( "#acciones_linea" ).show();
              $("#status_economico").removeClass("c-verde");
              $("#status_economico").addClass("c-youtube");
            }else{
              $( "#url_pagar" ).hide();
              $( "#acciones" ).hide();
              $( "#acciones_linea" ).hide();
              $("#status_economico").removeClass("c-youtube");
              $("#status_economico").addClass("c-verde");
            }
            finprocesado();
            $('#modalAsistencia').modal('show');
          },
          error:function(msj){
            finprocesado();
            console.log(msj);

          } 
        });

      }


      function permitir_instructor(){
        var route = route_agregar_asistencia_instructor_permitir;
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#agregar_asistencia_instructor" ).serialize(); 
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:datos,
            success:function(respuesta){  
              console.log(respuesta)          
              if(respuesta.status=="OK"){
                $('#modalAsistencia').modal('hidden');
                
              }else{
                var nType = 'danger';
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
              }
              
            },
            error:function(msj){
              var nType = 'danger';
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              var nTitle="Ups! ";
              if(msj.responseJSON.status=="ERROR"){
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";  
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);          
              }else{

               
              }
              
            }
            
          });
      }

      $('#modalAsistencia').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })

      $('#modalAsistenciaInstructor').on('hidden.bs.modal', function (e) {
        $("#content").removeClass("opacity-content");
        $("header").removeClass("abierto");
        $("footer").removeClass("opacity-content");
        $("#main").removeClass("opacity-content");
        $("#chat").removeClass("toggled");
        $("#what_we_do").removeClass("opacity-content");
      })


    $('body').on('click', '#what_we_do, #menuTopConfig, #main,#content, footer, header.abierto', function(e){

            $("#content").removeClass("opacity-content");
            $("footer").removeClass("opacity-content");
            $("header").removeClass("abierto");
            $("#main").removeClass("opacity-content");
            $("#chat").removeClass("toggled");
            $("#what_we_do").removeClass("opacity-content");
            if($("#buscar").val() != '')
            {
              $("#buscar").val('');
              asistencia.search('').draw();
            }

        });
        // $('body').on('change', '#menu-trigger.open', function(e){

        //     $("#content").addClass("opacity-content");
        //     $("footer").addClass("opacity-content");
        //     $("header").addClass("abierto");
        //     console.log('aside');
        // });


        // $('body').on('click', '#chat-trigger', function(e){

        //   var cuerpo = '';
          
        //   if(!$('#chat').hasClass('toggled') && aside_loaded == 0){

        //     $.each(alumnos_aside, function (index, array) {

        //       id = array.id
        //       cuerpo += '<div class="listview">'
        //       cuerpo += '<a class="lv-item" href="javascript:void(0)"  >'
        //       cuerpo += '<div class="media">'
        //       cuerpo += '<div class="pull-left p-relative">'

        //       if(array.imagen){
        //         cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/uploads/usuario/'+array.imagen+'" alt="">'
        //       }else{
        //         if(array.sexo == 'M')
        //         {
        //           cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">'
        //         }else{
        //           cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">'
        //         }
        //       }

        //       cuerpo += '<i class="chat-status-busy"></i>'
        //       cuerpo += '</div>'
        //       cuerpo += '<div class="media-body">'
        //       cuerpo += '<div class="lv-title">'+array.nombre+' '+array.apellido+'</div>'
        //       cuerpo += '<small class="lv-small">'+array.identificacion+'</small>'
        //       cuerpo += '</div></div></a></div>'

        //       var rowNode=asistencia.row.add( [
        //         ''+cuerpo+''
        //       ] ).draw(false).node();
        //       $( rowNode )
        //         .attr('id','asistencia_alumno_row_'+id)
        //         .attr('data-imagen',array.imagen)
        //         .attr('data-id-participante',array.id)
        //         .attr('data-nombre-participante',array.nombre+' '+array.apellido)
        //         .attr('data-identificacion-participante',array.identificacion)
        //         .attr('data-tipo-participante',"alumno")
        //         .attr('data-sexo',array.sexo)
              

        //       $('#aside_body').append(cuerpo)

        //       cuerpo = '';
                
        //     }); 

        //     $.each(instructores_aside, function (index, array) {
   
        //       cuerpo += '<div class="listview">'
        //       cuerpo += '<a class="lv-item" href="javascript:void(0)"  >'
        //       cuerpo += '<div class="media">'
        //       cuerpo += '<div class="pull-left p-relative">'
        //       cuerpo += '<img class="lv-img-sm" src="{{url('/')}}/assets/img/profile-pics/2.jpg" alt="">'
               

        //       cuerpo += '<i class="chat-status-busy"></i>'
        //       cuerpo += '</div>'
        //       cuerpo += '<div class="media-body">'
        //       cuerpo += '<div class="lv-title">'+array.nombre+' '+array.apellido+'</div>'
        //       cuerpo += '<small class="lv-small">'+array.identificacion+' <i class="icon_a-instructor"></i></small>'
        //       cuerpo += '</div></div></a></div>'

        //       id = array.id
        //       var rowNode=asistencia.row.add( [
        //         ''+cuerpo+''
        //       ] ).draw(false).node();
        //       $( rowNode )
        //         .attr('id','asistencia_alumno_row_'+id)
        //         .attr('data-imagen',array.imagen)
        //         .attr('data-id-participante',array.id)
        //         .attr('data-nombre-participante',array.nombre+' '+array.apellido)
        //         .attr('data-identificacion-participante',array.identificacion)
        //         .attr('data-tipo-participante',"insctructor")
              

        //       cuerpo = '';
                
        //     }); 

        //     aside_loaded = 1;   

        //     setTimeout(function() {
        //       $('#mCSB_1_container').css('width', '');
        //       $('#mCSB_1_container').css('left', '');
        //     },2000);
        //     finprocesado();                                  
            
        //   }

        
            
        // });

    function buscar(t){

        var row = $(t).closest('tr');
        var tipo= $(row).data('tipo-participante');
        if(tipo=="alumno"){
          buscarAlumno(t);
        }else if(tipo=="insctructor"){
          buscarInstructor(t);
        }

    }

    </script>

@stop