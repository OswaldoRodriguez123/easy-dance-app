@extends('layout.master')

@section('content')
            
                    <section id="content">
                        <form name="agregar" method="POST" action="contacto/enviar" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre</label> 
                                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="">
                                    </div>
                                </div>
                               </div>

                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="fechanacimiento">Correo</label> </label>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="">
                                 </div>
                               </div>

                             <div class="clearfix"></div> 

                               <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="correo">Telefono</label>
                                    <input type="text" class="form-control input-sm" name="telefono" id="telefono" placeholder="">
                                 </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="direccion">Mensaje</label> </label>
                                    <input type="text" class="form-control input-sm" name="mensaje" id="mensaje" placeholder="">
                                 </div>
                               </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div></form>
                    </div>
                </div>
            </div>
            </section>
        </div>
    </div>
</div>
</div>
</div>                      
</div>
                    
                    
</div>
</section>
</section>
@stop


@section('js') 
            
		<script type="text/javascript">
            $(document).ready(function(){
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
                $id = this.id;
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
					}
            });
            });
			
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
		</script>
@stop

     