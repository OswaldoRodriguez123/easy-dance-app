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

            <div class="modal fade" id="modalPatrocinador" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1100 !important;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Editar Patrocinador <span id="patrocinador_nombre"></span><button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="edit_patrocinador" id="edit_patrocinador"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="monto">Monto</label>
                                    <input type="text" class="form-control input-sm input-mask" name="monto" id="monto" data-mask="00000000" placeholder="Ej. 5000">
                                 </div>
                                 <div class="has-error" id="error-monto">
                                      <span >
                                          <small class="help-block error-span" id="error-monto_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix m-b-20"></div> 

                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" class="form-control input-sm input-mask" name="cantidad" id="cantidad" data-mask="000" placeholder="Ej. 15">
                                 </div>
                                 <div class="has-error" id="error-cantidad">
                                      <span >
                                          <small class="help-block error-span" id="error-cantidad_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>


                               <input type="hidden" id="id" name="id"></input>
                              

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
                            <div class="col-sm-12">                            
                              <button type="button" class="btn btn-blanco m-r-10 f-12" id="guardar" name="guardar">Guardar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/especiales/campañas/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_c-money f-25"></i> Sección de Patrocinadores</p>
                            <hr class="linea-morada">                                                         
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="monto" data-order="desc">Monto</th>
                                    <th class="text-center" data-column-id="monto" data-order="desc">Cantidad</th>
                                    <!-- <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th> -->
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($patrocinadores as $patrocinador)

                                <?php $id = $patrocinador->id; ?>
                                <tr id="{{$id}}" class="seleccion" data-patrocinador ="{{$patrocinador->nombre}} {{$patrocinador->apellido}}" data-monto ="{{$patrocinador->monto}}" data-cantidad ="{{$patrocinador->cantidad}}">
                                    <td class="text-center previa">{{$patrocinador->nombre}} {{$patrocinador->apellido}}</td>
                                    <td class="text-center previa">{{$patrocinador->monto}}</td>
                                    <td class="text-center previa">{{$patrocinador->cantidad}}</td>
                                    <!-- <td class="text-center"> <i data-toggle="modal" class="zmdi zmdi-delete eliminar f-20 p-r-10"></i> <i data-toggle="modal" class="zmdi zmdi-email f-20 p-r-10"></i></td> -->
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

        route_update="{{url('/')}}/especiales/campañas/patrocinadores/update/patrocinador";
        route_eliminar="{{url('/')}}/especiales/campañas/patrocinadores/eliminar/";
        route_enviar="{{url('/')}}/especiales/campañas/patrocinadores/enviar/";

        $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,
        //bPaginate: false,    
        order: [[0, 'asc']],
        fnDrawCallback: function() {
        if ("{{count($patrocinadores)}}" < 25) {
              $('.dataTables_paginate').hide();
              $('#tablelistar_length').hide();
          }else{
             $('.dataTables_paginate').show();
          }
        },
        pageLength: 25,
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2)', nRow).attr( "onclick","previa(this)" );
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

            });


      $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {

                var id = $(this).closest('tr').attr('id');
                // var temp = row.split('_');
                // var id = temp[1];
                element = this;

                swal({   
                    title: "Desea eliminar al patrocinador?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        procesando();
                        eliminar(id, element);
          }
                });
            });
      
        function eliminar(id, element){

        var route = route_eliminar + id;
        var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          t.row( $(element).parents('tr') )
                            .remove()
                            .draw();

                        swal("Exito!","El patrocinador ha sido eliminado!","success");
                        
                        }
                    },
                    error:function(msj){
                                // $("#msj-danger").fadeIn(); 
                                // var text="";
                                // console.log(msj);
                                // var merror=msj.responseJSON;
                                // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                // $("#msj-error").html(text);
                                // setTimeout(function(){
                                //          $("#msj-danger").fadeOut();
                                //         }, 3000);
                                swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                }
                });
      }

      $('#tablelistar tbody').on( 'click', 'i.zmdi-email', function () {

        var id = $(this).closest('tr').attr('id');
        element = this;

        swal({   
            title: "Desea re-enviar el correo de patrocinador?",   
            text: "Confirmar re-envio!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Re-Enviar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: true 
        }, function(isConfirm){   
          if (isConfirm) {

            procesando();

            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
        
            var route = route_enviar + id;
            var token = "{{ csrf_token() }}";
                
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:id,
                success:function(respuesta){
                    var nFrom = $(this).attr('data-from');
                    var nAlign = $(this).attr('data-align');
                    var nIcons = $(this).attr('data-icon');
                    var nAnimIn = "animated flipInY";
                    var nAnimOut = "animated flipOutY"; 
                    if(respuesta.status=="OK"){
                        
                        swal("Exito!","El correo ha sido enviado!","success");
                    
                    }
                },
                error:function(msj){
                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                }
            });
            
            finprocesado();
            }
        });
    });
      


      function previa(t){
        var row = $(t).closest('tr');
        
        var id = row.attr('id')
        var monto = row.data('monto')
        var cantidad = row.data('cantidad')
        var patrocinador = row.data('patrocinador')

        $('#id').val(id)
        $('#monto').val(monto)
        $('#cantidad').val(cantidad)
        $('#patrocinador').text(patrocinador)


        $('#modalPatrocinador').modal('show')
      }

      $("#guardar").click(function(){
            swal({   
                    title: "¿Seguro deseas modificar al patrocinador ?",   
                    text: "Confirmar el cambio",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#ec6c62",   
                    confirmButtonText: "Sí, modificar",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
            if (isConfirm) {

                var route = route_update;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#edit_patrocinador" ).serialize(); 
                procesando();      
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

                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          
                          var tr_edicion = $("#"+respuesta.patrocinador.id);

                          tr_edicion.find("td").eq(1).text(respuesta.patrocinador.monto);
                          tr_edicion.find("td").eq(2).text(respuesta.patrocinador.cantidad);

                          tr_edicion.data('cantidad', respuesta.patrocinador.cantidad)
                          tr_edicion.data('monto', respuesta.patrocinador.monto)

                          finprocesado();
                          $('#modalPatrocinador').modal('hide');
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';

                          $(".procesando").removeClass('show');
                          $(".procesando").addClass('hidden');
                          finprocesado();
                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

                        }                       
                        
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        // if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "{{url('/')}}/error";
                        // }
                        finprocesado();
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }            

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
              }
            });
        });

    function limpiarMensaje(){
        var campo = ["monto", "cantidad"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

    function errores(merror){
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


    </script>
@stop