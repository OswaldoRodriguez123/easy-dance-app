@extends('layout.master3')

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
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                            <div class="col-md-10">


                            <div class="col-md-5"></div>
                            <div class="col-md-1"><i class="icon_d-invitar f-60 text-center c-morado"></i></div>
                            <div class="col-md-6"></div>


                            <div class="clearfix p-b-35"></div>
                            
                            <div class="f-700 f-30 text-center">Háblales a tus amigos de la fiesta y así también puedes contribuir</div>
                            
                            <br>

                            <div class="opaco-0-8 f-22 text-center" id="id-linea">Puedes crear varias invitaciones a través de correos electrónico</div>

                            <div class="clearfix p-b-35"></div>

                            <hr>

                            <div class="clearfix p-b-35"></div>
                            <div class="clearfix p-b-35"></div>
                                    


                                    <form name="formComparte" id="formComparte" class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="col-sm-6">
                                            <label id="id-nombre_invitado">Ingresa el nombre</label>
                                            <div class="input-group input-group-lg">

                                                <span class="input-group-addon"><i class="icon_b icon_b-nombres"></i></span>
                                                <div class="fg-line">
                                                    <input class="form-control input-lg" name="nombre_invitado" id="nombre_invitado" placeholder="ej: Valeria" required="required">
                                                </div>
                                            </div>
                                            <div class="has-error" id="error-nombre_invitado">
                                              <span >
                                                  <small class="help-block error-span" id="error-nombre_invitado_mensaje" ></small>                                
                                              </span>
                                          </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <label id="id-correo_invitado">Ingresa su correo electrónico </label>
                                            <div class="input-group input-group-lg">

                                                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                                <div class="fg-line">
                                                    <input class="form-control input-lg" name="correo_invitado" id="correo_invitado" placeholder="ej: info@easydancelatino.com" type="email" required="required">
                                                    <input type="hidden" value="" id="alm-email">
                                                </div>

                                            </div>
                                            <div class="has-error" id="error-correo_invitado">
                                              <span >
                                                  <small class="help-block error-span" id="error-correo_invitado_mensaje" ></small>                                
                                              </span>
                                          </div>
                                        </div>

                                        <div class="clearfix p-b-35"></div>
                                        <div class="clearfix p-b-35"></div>

                                        <div class="col-sm-2">

                                          <button type="button" class="btn btn-blanco m-r-8 f-10 guardar" name= "add" id="add" > Agregar Linea <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>

                                        </div>

                                      <div class="col-sm-4">
                                        <div class="has-error" id="error-linea">
                                              <span >
                                                <small class="help-block error-span" id="error-linea_mensaje" ></small>                                           
                                              </span>
                                          </div>
                                      </div>


                                    </form>

                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>
                                    

                                    <div class="table-responsive row">
                                       <div class="col-md-12">
                                        <table class="table table-striped table-bordered text-center " id="tablelistar" >
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                                <th class="text-center" data-column-id="correo">Correo</th>
                                                <th class="text-center" data-column-id="operacion">Acciones</th>
                                            </tr>
                                        </thead>
                                          <tbody>
                                                                         
                                          </tbody>
                                        </table>


                                      </div>
                                    </div>

                                    <div class="clearfix p-b-35"></div>
                                    <div class="clearfix p-b-35"></div>

                                    <div class="block-header text-right">
                                        <a class="btn-blanco m-r-10 f-25 pointer" id="guardar" name="guardar"> Enviar</a>
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


@section('js') 
            
    <script type="text/javascript">

            route_enviar="{{url('/')}}/agendar/fiestas/invitar";
            route_agregar="{{url('/')}}/agendar/fiestas/invitar/agregar";
            route_eliminar="{{url('/')}}/agendar/fiestas/invitar/eliminar";
            route_enhorabuena="{{url('/')}}/agendar/fiestas/invitacion/enhorabuena/";


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
                        template: '<div data-growl="container" class="alert" role="alert">' +
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
			
            $("#add").click(function(){

                $("#add").attr("disabled","disabled");
                    $("#add").css({
                      "opacity": ("0.2")
                });

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#formComparte").serialize(); 
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

                          $("#formComparte")[0].reset();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          var nombre = respuesta.array[0].nombre;
                          var email = respuesta.array[0].email;

                          var rowId=respuesta.id;
                          var rowNode=t.row.add( [
                          ''+nombre+'',
                          ''+email+'',
                          '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        //  if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
                        if(msj.responseJSON.status=="ERROR"){
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar").removeAttr("disabled");
                        $("#guardar").css({
                          "opacity": ("1")
                        });
                        $("#add").removeAttr("disabled");
                          $("#add").css({
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

    $("#guardar").click(function(){

                var route = route_enviar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#formComparte" ).serialize(); 
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
                          // finprocesado();
                          // var nType = 'success';
                          // $("#agregar_alumno")[0].reset();
                          // var nTitle="Ups! ";
                          // var nMensaje=respuesta.mensaje;
                          window.location = route_enhorabuena + "{{ $id }}";
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
                         if (typeof msj.responseJSON === "undefined") {
                          window.location = "{{url('/')}}/error";
                        }
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
      var campo = ["nombre_invitado", "correo_invitado", "linea"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
      var campo = ["nombre", "correo"];
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

      $('html,body').animate({
            scrollTop: $("#id-"+elemento).offset().top-90,
      }, 1000);          

  }

  var t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         "Buscar:",
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

        $('#tablelistar tbody').on( 'click', 'i.zmdi-delete boton red', function () {
                  var padre=$(this).parents('tr');
                  var token = $('input:hidden[name=_token]').val();
                  var id = $(this).closest('tr').attr('id');
                        $.ajax({
                             url: route_eliminar+"/"+id,
                             headers: {'X-CSRF-TOKEN': token},
                             type: 'POST',
                             dataType: 'json',                
                            success: function (data) {
                              if(data.status=='OK'){

                                    
                              }else{
                                swal(
                                  'Solicitud no procesada',
                                  'Ha ocurrido un error, intente nuevamente por favor',
                                  'error'
                                );
                              }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                              swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                            }
                          })

                        t.row( $(this).parents('tr') )
                            .remove()
                            .draw();
                                                
                    });      
			
    </script>
@stop