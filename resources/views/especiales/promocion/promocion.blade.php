@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@stop

@section('content')
 
            <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Agregar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_promocion" id="agregar_promocion" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                    <label for="especialidad">Promociones</label>

                                      <div class="select">
                                          <select class="form-control" id="promocion_id" name="promocion_id">
                                          @foreach ( $promocion as $promociones )
                                          <option value = "{{ $promociones['id'] }}">{{ $promociones['nombre'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div>                                    

                                    </div>
                                    <div class="has-error" id="error-promocion_id">
                                      <span >
                                          <small class="help-block error-span" id="error-promocion_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                </div>

                                  <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                    <label for="especialidad">Alumnos</label>

                                      <div class="select">
                                          <select class="form-control" id="alumno_id" name="alumno_id">
                                          @foreach ( $alumno as $alumnos )
                                          <option value = "{{ $alumnos['id'] }}">{{ $alumnos['nombre'] }} {{ $alumnos['apellido'] }}</option>
                                          @endforeach 
                                          </select>
                                      </div>                                    

                                    </div>
                                    <div class="has-error" id="error-alumno_id">
                                      <span >
                                          <small class="help-block error-span" id="error-alumno_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                </div>

                               <div class="clearfix"></div> 

                           </div>
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div></form>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" id="modalAgregarBtn" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></button>
            <section id="content">
                <div class="container">
                

                
                    <div class="block-header">
                        <h2>Certificacion</h2>              
                        
                        
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                            <div class="col-sm-12">
                               <h2 class="text-center f-700">Promociones</h2>
                            </div>                  
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-type="numeric">Id</th>
                                    <th data-column-id="sexo">Sexo</th>
                                    <th data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_c" data-order="desc">Estatus C</th>
                                    <th class="text-center" data-column-id="estatu_e" data-order="desc">Estatus E</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                        </table>
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
            route_agregar="{{url('/')}}/especiales/promociones/generarcodigo";
            $(document).ready(function(){
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
                id = this.id;
                swal({   
                    title: "Desea eliminar al alumno?",   
                    text: "Confirmar eliminación!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Eliminar!",  
                    cancelButtonText: "Cancelar",					
                    closeOnConfirm: false 
                }, function(isConfirm){   
					if (isConfirm) {
						var nFrom = $(this).attr('data-from');
						var nAlign = $(this).attr('data-align');
						var nIcons = $(this).attr('data-icon');
						var nType = 'success';
						var nAnimIn = $(this).attr('data-animation-in');
						var nAnimOut = $(this).attr('data-animation-out')
                        swal("Done!","It was succesfully deleted!","success");
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        eliminar(id);
					}
                });
            });
			function eliminar(id){
         var route = route_eliminar + id;
         var token = $('input:hidden[name=_token]').val();
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){
                        $("form")[0].reset();
                        $("#msj-success").fadeIn(); 
                        $("#msj").html(" <i class='glyphicon glyphicon-plus-sign'></i> Agregado exitosamente el Registro ")
                        setTimeout(function(){
                         $("#msj-success").fadeOut();
                        }, 3000);           
                    },
                    error:function(msj){
                                $("#msj-danger").fadeIn(); 
                                var text="";
                                console.log(msj);
                                var merror=msj.responseJSON;
                                text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                $("#msj-error").html(text);
                                setTimeout(function(){
                                         $("#msj-danger").fadeOut();
                                        }, 3000);
                                }
                });
      }
			function notify(from, align, icon, type, animIn, animOut){
                $.growl({
                    icon: icon,
                    title: ' Bootstrap Growl ',
                    message: 'Turning standard Bootstrap alerts into awesome notifications',
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
                        z_index: 1031,
                        delay: 2500,
                        timer: 1000,
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
                $("#mujer").prop("checked", true); 
            });    

            $("#guardar").click(function(){

                console.log('guardar');
                /*limpiarMensaje();*/
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_promocion" ).serialize(); 

                console.log(datos);
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:datos,
                    success:function(respuesta){
                        $("form")[0].reset();
                        $("#msj-success").fadeIn(); 
                        $("#msj").html(" <i class='glyphicon glyphicon-plus-sign'></i> Agregado exitosamente el Registro ")
                        setTimeout(function(){
                         $("#msj-success").fadeOut();
                        }, 3000);           
                    },
                    error:function(msj){
                                $("#msj-danger").fadeIn(); 
                                var text="";
                                console.log(msj);
                                var merror=msj.responseJSON;
                                text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                $("#msj-error").html(text);
                                setTimeout(function(){
                                         $("#msj-danger").fadeOut();
                                        }, 3000);
                                }
                });
            });
		</script>
@stop

     