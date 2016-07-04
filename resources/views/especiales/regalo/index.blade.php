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
     <div class="modal fade" id="modalOperacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Operaciones <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>                         
                        </div>
                        <div class="modal-body">
                            <div class="row p-t-30 p-b-30">
                               <div class="col-sm-4 text-center">
                                   <i class="zmdi zmdi-email f-35 boton blue sa-warning" data-original-title="Pagar" type="button" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="bottom" title=""></i>                
                               </div>
                               <div class="col-sm-4 text-center">
                                   <i class="zmdi zmdi-email f-35 boton blue sa-warning" 
                                   data-original-title="Enviar Correo" type="button" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="bottom" title=""></i>
                               </div>
                               <div class="col-sm-4 text-center">
                                   <i  class="zmdi zmdi-delete f-35 boton red sa-warning" data-original-title="Eliminar" type="button" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="bottom" title=""  ></i> 
                                                               
                               </div>
                            </div>                           
                        </div>
                        
                    </div>
                </div>
            </div>
     <div class="modal fade" id="modalNivel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Nivelación <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>                         
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
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Agregar - Representante <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="fiesta/agregar" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id - Pasaporte</label>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" placeholder="">
                                    </div>
                                </div>
                               </div>
                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="">
                                 </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="">
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
                                    <input type="text" class="form-control input-sm" name="numero" id="numero" placeholder="">
                                 </div>
                               </div>
                               <div class="col-sm-6 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo electrónico</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="">
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
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Agregar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar_regalo" id="agregar_regalo" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="">
                                 </div>
                               </div>

                              <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Costo</label>
                                    <input type="text" class="form-control input-sm" name="costo" id="costo" placeholder="">
                                 </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Descripcion</label>
                                    <input type="text" class="form-control input-sm" name="descripcion" id="descripcion" placeholder="">
                                 </div>
                               </div>

                              <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Dirigido a</label>
                                    <input type="text" class="form-control input-sm" name="dirigido_a" id="dirigido_a" placeholder="">
                                 </div>
                               </div>

                                <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">De parte de</label>
                                    <input type="text" class="form-control input-sm" name="de_parte_de" id="de_parte_de" placeholder="">
                                 </div>
                               </div>

                                <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="">
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
                               <h2 class="text-center f-700">Alumnos</h2>
                            </div>                  
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped table-vmiddle">
                            <tbody>

                          <form name="agregar_regalo" id="agregar_regalo" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="">
                                 </div>
                               </div>

                              <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Costo</label>
                                    <input type="text" class="form-control input-sm" name="costo" id="costo" placeholder="">
                                 </div>
                               </div>

                               <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="apellido">Descripcion</label>
                                    <input type="text" class="form-control input-sm" name="descripcion" id="descripcion" placeholder="">
                                 </div>
                               </div>

                              <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Dirigido a</label>
                                    <input type="text" class="form-control input-sm" name="dirigido_a" id="dirigido_a" placeholder="">
                                 </div>
                               </div>

                                <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">De parte de</label>
                                    <input type="text" class="form-control input-sm" name="de_parte_de" id="de_parte_de" placeholder="">
                                 </div>
                               </div>

                                <div class="col-sm-6">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Correo</label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="">
                                 </div>
                               </div>

                               <div class="clearfix"></div> 
                           </div>
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div></form>
                                                           
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
            route_principal="{{url('/')}}/especiales/regalos";
            route_agregar="{{url('/')}}/especiales/regalos/agregar";
            route_eliminar="{{url('/')}}/especiales/regalos/eliminar/";
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
                    title: "Desea eliminar la fiesta?",   
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
                var datos = $( "#agregar_regalo" ).serialize(); 

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

     