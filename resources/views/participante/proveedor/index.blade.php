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
     <div class="modal fade" id="modalOperacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bgm-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-blanco">Operaciones <button type="button" data-dismiss="modal" class="close c-blanco" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>                         
                        </div>
                        <div class="modal-body">
                            <div class="row p-t-30 p-b-30">
                               <div class="col-xs-4 text-center">
                                   <i class="zmdi zmdi-email f-35 boton blue sa-warning" data-original-title="Pagar" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i>                
                               </div>
                               <div class="col-xs-4 text-center">
                                   <i class="zmdi zmdi-email f-35 boton blue sa-warning" 
                                   data-original-title="Enviar Correo" data-toggle="tooltip" data-placement="bottom" title=""></i>
                               </div>
                               <div class="col-xs-4 text-center">
                                   <i  class="zmdi zmdi-delete f-35 boton red sa-warning" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""  ></i>                                       
                               </div>
                            </div>
                            <input type="hidden" id="operando" name="operando" value=""></input>                           
                        </div>
                        
                    </div>
                </div>
            </div>
     <div class="modal fade" id="modalNivel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bgm-morado p-t-10 p-b-10">
                            <h4 class="modal-title c-blanco">Nivelación <button type="button" data-dismiss="modal" class="close c-blanco" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>                         
                        </div>
                        <div class="modal-body">
                            <div class="row p-t-20 p-b-20">
                               <div class="col-sm-4">
                                <label class="checkbox checkbox-inline m-r-20">
                                    <input type="checkbox" name="nivel" value="option1">
                                    <i class="input-helper"></i>    
                                    Intermedio
                                </label>                            
                               </div>
                               <div class="col-sm-4">
                                <label class="checkbox checkbox-inline m-r-20">
                                    <input type="checkbox" name="nivel" value="option1">
                                    <i class="input-helper"></i>    
                                    Avanzado
                                </label>
                               </div>
                               <div class="col-sm-4">
                                    <label class="checkbox checkbox-inline m-r-20">
                                    <input type="checkbox" name="nivel" value="option1">
                                    <i class="input-helper"></i>    
                                    Master
                                </label>
                               </div>
                            </div>
                            <hr>
                            <div class="clearfix"></div>
                            <div class="checkbox m-b-0">
                                <label class="text-right">
                                    <input type="checkbox" checked="checked" value="">
                                    <i class="input-helper"></i>
                                    Enviar correo
                                </label>
                            </div>
                            <hr>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" style="z-index: 3000" id="modalRepresentante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bgm-morado p-t-10 p-b-10">
                            <h4 class="modal-title c-blanco">Agregar - Representante <button type="button" data-dismiss="modal" class="close c-blanco" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="alumno/agregar" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="r-identificacion" placeholder="">
                                    </div>
                                </div>
                               </div>
                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="r-nombre" placeholder="">
                                 </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="r-apellido" placeholder="">
                                 </div>
                               </div>

                              <div class="col-sm-6">
                                 <div class="form-group">
                                        <div class="fg-line">
                                        <label for="apellido">Parentesco</label>
                                            <div class="select">
                                                <select class="form-control">
                                                    <option>Select an Option</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                               </div>

                               <div class="col-sm-6 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="movil">Número móvil</label>
                                    <input type="text" class="form-control input-sm" name="numero" id="r-numero" placeholder="">
                                 </div>
                               </div>
                               <div class="col-sm-6 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo electrónico</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="r-correo" placeholder="">
                                 </div>
                               </div>

                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div></form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-morado p-t-10 p-b-10">
                            <h4 class="modal-title c-blanco">Agregar <button type="button" data-dismiss="modal" class="close c-blanco f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_proveedor" id="agregar_proveedor"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Ej. Valeria">
                                 </div>
                                 <div class="has-error" id="error-nombre">
                                      <span >
                                          <small class="help-block error-span" id="error-nombre_mensaje" ></small>                                
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="Ej. Sánchez">
                                 </div>
                                 <div class="has-error" id="error-apellido">
                                      <span >
                                          <small class="help-block error-span" id="error-apellido_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                              <div class="clearfix"></div> 

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="celular">Telefono Movil</label>
                                    <input type="text" class="form-control input-sm" name="celular" id="celular" placeholder="Ej. 04146662266">
                                 </div>
                                 <div class="has-error" id="error-celular">
                                      <span >
                                          <small class="help-block error-span" id="error-celular_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="telefono">Telefono Local</label>
                                    <input type="text" class="form-control input-sm" name="telefono" id="telefono" placeholder="Ej. 02617662266">
                                 </div>
                                 <div class="has-error" id="error-telefono">
                                      <span >
                                          <small class="help-block error-span" id="error-telefono_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 


                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="Ej. example@correo.com">
                                 </div>
                                 <div class="has-error" id="error-correo">
                                      <span >
                                          <small class="help-block error-span" id="error-correo_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>


                                <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="empresa">Empresa</label>
                                    <input type="text" class="form-control input-sm" name="empresa" id="empresa" placeholder="Ej. Habana Maracaibo">
                                 </div>
                                 <div class="has-error" id="error-empresa">
                                      <span >
                                          <small class="help-block error-span" id="error-empresa_mensaje"  ></small>                                           
                                      </span>
                                  </div>
                               </div>

                               <div class="clearfix"></div> 

                                <div class="col-sm-6">
                                 <div class="form-group fg-line ">
                                    <label for="sexo p-t-10">Sexo</label>
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="sexo" id="mujer" value="F" type="radio">
                                        <i class="input-helper"></i>  
                                        Mujer <i class="zmdi zmdi-female p-l-5 f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20 ">
                                        <input name="sexo" id="hombre" value="M" type="radio">
                                        <i class="input-helper"></i>  
                                        Hombre <i class="zmdi zmdi-male-alt p-l-5 f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                 <div class="has-error" id="error-sexo">
                                      <span >
                                          <small class="help-block error-span" id="error-sexo_mensaje" ></small>                                           
                                      </span>
                                  </div>
                               </div>


                               
                           </div>
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-7 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-5">                            
                              <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                              <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" id="modalAgregarBtn" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></button>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Participantes <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Proveedores </span></h4>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            
                            
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="celular" data-order="desc">Telefono Movil</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($proveedor as $proveedores)
                                <?php $id = $proveedores['id']; ?>
                                <tr id="row_{{$id}}" class="seleccion" >
                                    <td class="text-center previa">{{$proveedores['sexo']}}</td>
                                    <td class="text-center previa">{{$proveedores['nombre']}} {{$proveedores['apellido']}} </td>
                                    <td class="text-center previa">{{$proveedores['celular']}}</td>
                                    <td class="text-center"> <i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-filter-list f-20 p-r-10 operacionModal"></i></td>
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
            route_principal="{{url('/')}}/participante/proveedor";
            route_agregar="{{url('/')}}/participante/proveedor/agregar";
            route_eliminar="{{url('/')}}/participante/proveedor/eliminar";
            route_detalle="{{url('/')}}/participante/proveedor/detalle";
            
            $(document).ready(function(){

            t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
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
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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
      });
      $('.sa-warning').click(function(){          
          var id = $("#operando").val();
          var id_proveedor = id.split('_');

          var route = route_eliminar+"/"+id_proveedor[1];
          $('#modalOperacion').modal('hide');
          swal({   
            title: "Desea eliminar al proveedor?",   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: false,
            allowOutsideClick: false
          }, function(isConfirm){   
          //swal.disableButtons();
          if (isConfirm) {
            var token = $('input:hidden[name=_token]').val();
            $.ajax({
                 url: route,
                 headers: {'X-CSRF-TOKEN': token},
                 type: 'DELETE',
                 dataType: 'json',                
                success: function (data) {
                  if(data.status=='OK'){
                    setTimeout(function() {
                      $('#'+id).remove();
                      swal(
                        'Eliminado!',
                        '¡Excelente! se han eliminado satisfactoriamente.',
                        'success'
                      );  
                    }, 100);                      
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
            /*setTimeout(function(){ 
              
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nType = 'success';
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              swal("Eliminado!","Se han eliminado el alumno correctamete!","success");
              var nTitle="Ups! ";
              var nMensaje="¡Excelente! se han eliminado satisfactoriamente";

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
             }, 2000);*/
          }
        });
      });
      
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

            $('#modalAgregarBtn').click(function(){
                $("#agregar_proveedor")[0].reset();
                $("#mujer").prop("checked", true);
                limpiarMensaje(); 
            });  

            $(".operacionModal").click(function(){
              var i = $(this).closest('tr').attr('id');
              $('#operando').val(i);
              //console.log(i);
            });

            /*$(".previa").click(function(){
              var row = $(this).closest('tr').attr('id');
              var id_alumno = row.split('_');
              var route =route_detalle+"/"+id_alumno[1];
              window.location=route;
            });*/

            $('#modalOperacion').on('hidden.bs.modal', function (e) {
              $("#operando").val("");
            }) 

            //var myArray = myString.split(' ');

            $("#guardar").click(function(){

                
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_proveedor" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');
                limpiarMensaje();   
                var celular=$("#celular").val(); 
                var nombres=$("#nombre").val()+" "+$("#apellido").val(); 
                var sexo=$('input:radio[name=sexo]:checked').val();          

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
                          $("#agregar_proveedor")[0].reset();
                          $("#mujer").prop("checked", true);
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          var rowId="row_"+respuesta.id;
                            var rowNode=t.row.add( [
                                ''+sexo+'',
                                ''+nombres+'',
                                ''+celular+'',
                                '<i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-filter-list f-20 p-r-10 operacionModal"></i>'
                            ] ).draw(false).node();
 
                            $( rowNode )
                                //.css( 'color', '#4E1E43' ) 
                                //.css( 'font-weight', 'bold' )                               
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
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
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
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "sexo"];
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
        /*fLen = campo.length;
        for (i = 0; i < fLen; i++) {
          campo_e='merror.'+campo[i];          
          if (merror.campo[i] !== undefined){
              var error="";
              for (f = 0; f < merror.campo[i].length; i++) {
                error+=" "+merror.campo[i][f]; 
              }
              console.log(error);
              $("#error-"+campo[i]+"_mensaje").html(error);
          } 
        }*/

        /* 
        $.each(json, function () {
           $.each(this, function (name, value) {
              $("#error-"+e).html(error);
           });
        }); */              
      }

      /*$(".previa").click(function(){
              var row = $(this).closest('tr').attr('id');
              var id_alumno = row.split('_');
              var route =route_detalle+"/"+id_alumno[1];
              window.location=route;
      });*/
        
      function previa(t){
        var row = $(t).closest('tr').attr('id');
        var id_proveedor = row.split('_');
        var route =route_detalle+"/"+id_proveedor[1];
        window.location=route;
      }


    </script>
@stop

     