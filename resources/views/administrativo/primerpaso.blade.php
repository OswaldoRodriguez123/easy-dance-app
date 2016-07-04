@extends('layout.master')

@section('content')
            <section id="content">
                <div class="container">
                    <div class="block-header">
                        <h2>Perfil</h2>              
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                            <div class="col-sm-12">
                               <h2 class="text-center f-700">Editar</h2>
                            </div>                  
                            </div>
                            
                        </div>

                        <form name="agregar" method="POST" action="{{url('/')}}/administrativo/segundo-paso">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">

                               <div class="card-body card-padding">
                                      <div class="col-sm-6">
                                          <p class="c-black f-500 m-b-20">Alumno</p>
                                          <div class="form-group">
                                              <div class="fg-line">
                                                  <div class="select">
                                                      <select class="form-control" id="alumno_id" name="alumno_id">
                                                      @foreach ($alumnos as $alumno)
                                                      <option value = "{{$alumno['id']}}">{{$alumno['nombre']}} {{$alumno['apellido']}} {{$alumno['identificacion']}}</option>
                                                      @endforeach 
                                                      </select>
                                                  </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                                    
                </div>
                </div>
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

     