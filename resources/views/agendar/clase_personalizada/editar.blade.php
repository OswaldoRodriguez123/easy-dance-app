@extends('layout.master')

@section('content')
<div class="modal fade" id="modalIdent" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/id" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id- identificación</label>
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" placeholder="" value= "{{$instructor['identificacion']}}">
                                    </div>
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
            <div class="modal fade" id="modalNombre" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/nombre" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Nombre</label>
                                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="" value= "{{$instructor['nombre']}}">
                                    </div>
                                </div>
                               </div>
                                <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Apellido</label>
                                        <input type="text" class="form-control input-sm" name="apellido" id="apellido" placeholder="" value= "{{$instructor['apellido']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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
            <div class="modal fade" id="modalFecha" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/fecha" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Fecha de nacimiento</label>
                                        <input type="text" class="form-control input-sm" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" value= "{{$instructor['fecha_nacimiento']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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

             <div class="modal fade" id="modalSexo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/sexo" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Sexo</label>
                                        <input type="text" class="form-control input-sm" name="sexo" id="sexo" placeholder="" value= "{{$instructor['sexo']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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

            <div class="modal fade" id="modalCorreo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/correo" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Correo electrónico</label>
                                        <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="" value= "{{$instructor['correo']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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
            <div class="modal fade" id="modalTelefono" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/telefono" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Teléfono Local</label>
                                        <input type="text" class="form-control input-sm" name="telefono" id="telefono" placeholder="" value= "{{$instructor['telefono']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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
            <div class="modal fade" id="modalCelular" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/celular" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Teléfono Celular</label>
                                        <input type="text" class="form-control input-sm" name="celular" id="celular" placeholder="" value= "{{$instructor['celular']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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
            <div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/direccion" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Direccion</label>
                                        <input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="" value= "{{$instructor['direccion']}}">
                                        <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
                                    </div>
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

            <div class="modal fade" id="modalDiag" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/diagnostico" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="diferenciacion_musical">Diferenciación musical</label>
                                    <input type="text" class="form-control input-sm" name="diferenciacion_musical" id="diferenciacion_musical" placeholder="" value= "{{$instructor['diferenciacion_musical']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="coordinacion">Coordinación</label>
                                    <input type="text" class="form-control input-sm" name="coordinacion" id="coordinacion" placeholder="" value= "{{$instructor['coordinacion']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="nivel_baile">Nivel de baile</label>
                                    <input type="text" class="form-control input-sm" name="nivel_baile" id="nivel_baile" placeholder="" value= "{{$instructor['nivel_baile']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="desplazamiento">Desplazamiento</label>
                                    <input type="text" class="form-control input-sm" name="desplazamiento" id="desplazamiento" placeholder="" value= "{{$instructor['desplazamiento']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="expresion_corporal">Expresión corporal</label>
                                    <input type="text" class="form-control input-sm" name="expresion_corporal" id="expresion_corporal" placeholder="" value= "{{$instructor['expresion_corporal']}}">
                                 </div>
                               </div>
                             <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="dominio_pareja">Dominio de pareja</label>
                                    <input type="text" class="form-control input-sm" name="dominio_pareja" id="dominio_pareja" placeholder="" value= "{{$instructor['dominio_pareja']}}">
                                    <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
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
            <div class="modal fade" id="modalFicha" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bgm-orange p-t-10 p-b-10">
                            <h4 class="modal-title">Editar <button type="button" data-dismiss="modal" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="agregar" method="POST" action="{{url('/')}}/instructor/update/ficha" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="alergia">Alergia</label>
                                    <input type="text" class="form-control input-sm" name="alergia" id="alergia" placeholder="" value= "{{$instructor['alergia']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="asma">Asma</label>
                                    <input type="text" class="form-control input-sm" name="asma" id="asma" placeholder="" value= "{{$instructor['asma']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="convulsiones">Convulsiones</label>
                                    <input type="text" class="form-control input-sm" name="convulsiones" id="convulsiones" placeholder="" value= "{{$instructor['convulsiones']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="cefalea">Cefalea</label>
                                    <input type="text" class="form-control input-sm" name="cefalea" id="cefalea" placeholder="" value= "{{$instructor['cefalea']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="hipertension">Hipertensión</label>
                                    <input type="text" class="form-control input-sm" name="hipertension" id="hipertension" placeholder="" value= "{{$instructor['hipertension']}}">
                                 </div>
                               </div>
                             <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="lesiones">Lesiones</label>
                                    <input type="text" class="form-control input-sm" name="lesiones" id="lesiones" placeholder="" value= "{{$instructor['lesiones']}}">
                                    <input type ="hidden" value =  "{{$instructor['id']}}" name = "id">
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
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">
                                <div class="col-sm-4">
                                    <div class="thumbnail">
                                        <img src="img/300x200.gif" alt="">                                        
                                    </div>
                                    <div class="caption">
                                        <h4>Nombre:</h4>
                                        <p>...</p>                                
                                    </div>
                                    <div class="caption">
                                        <h4>CI:</h4>
                                        <p>...</p>                                
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-2">
                                       <button class="btn bgm-lightblue btn-icon waves-effect waves-circle waves-float"><i class="zmdi zmdi-check"></i></button>
                                      </div>
                                      <div class="col-sm-3 p-t-20">
                                        <div class="row">
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                  <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                      </div>
                                      <div class="col-sm-2 ">
                                        <button class="btn bgm-lightgreen btn-icon waves-effect waves-circle waves-float"><i class="zmdi zmdi-check"></i></button>
                                      </div>
                                      <div class="col-sm-3 p-t-20">
                                        <div class="row">
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                  <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-2">
                                       <button class="btn bgm-orange btn-icon waves-effect waves-circle waves-float"><i class="zmdi zmdi-check"></i></button>
                                      </div>                                      
                                    </div>
                                    <div class="row p-t-10">
                                      <div class="col-sm-4 text-left">
                                        Intermedio
                                      </div>
                                      <div class="col-sm-4 text-center">
                                        Avanzado
                                      </div>
                                      <div class="col-sm-4 text-right">
                                        Master
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                  <section id="content">
                            @@if (count($errors) > 0)                  
                               @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                               @endforeach                  
                            @endif
                        <form name="agregar" method="POST" action="instructor/agregar" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group fg-line">
                                        <label for="id">Id- identificación</label> <a data-toggle="modal" href="#modalIdent">Editar</a>
                                        <input type="text" class="form-control input-sm" name="identificacion" id="identificacion" placeholder="" value= "{{$instructor['identificacion']}}">
                                    </div>
                                </div>
                               </div>
                               <div class="col-sm-4">
                                 <div class="form-group fg-line">
                                    <label for="nombre">Nombre</label> </label> <a data-toggle="modal" href="#modalNombre">Editar</a>
                                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="" value= "{{$instructor['nombre']}} {{$instructor['apellido']}}">
                                 </div>
                               </div>
                               <div class="clearfix"></div> 

                               
                               <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail orange" data-trigger="fileinput"></div>
                                        <div>
                                            <span class="btn btn-info btn-file waves-effect">
                                                <span class="fileinput-new">Selecionar Imagenes</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="imagen" id="imagen" >
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists waves-effect" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="fechanacimiento">Fecha de nacimiento</label> </label> <a data-toggle="modal" href="#modalFecha">Editar</a>
                                    <input type="text" class="form-control input-sm" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="" value= "{{$instructor['fecha_nacimiento']}}">
                                 </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="sexo">Sexo</label> </label> <a data-toggle="modal" href="#modalSexo">Editar</a>
                                    <input type="text" class="form-control input-sm" name="sexo" id="sexo" placeholder="" value= "{{$instructor['sexo']}}">
                                 </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="correo">Correo electrónico</label> </label> <a data-toggle="modal" href="#modalCorreo">Editar</a>
                                    <input type="text" class="form-control input-sm" name="correo" id="correo" placeholder="" value= "{{$instructor['correo']}}">
                                 </div>
                               </div>
                               <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="telefonomovil">Teléfono Móvil</label> </label> <a data-toggle="modal" href="#modalCelular">Editar</a>
                                    <input type="text" class="form-control input-sm" name="celular" id="celular" placeholder="" value= "{{$instructor['celular']}}">
                                 </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="telefonolocal">Teléfono Local</label> </label> <a data-toggle="modal" href="#modalTelefono">Editar</a>
                                    <input type="text" class="form-control input-sm" name="telefono" id="telefono" placeholder="" value= "{{$instructor['telefono']}}">
                                 </div>
                               </div>
                                <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="direccion">Direccion</label> </label> <a data-toggle="modal" href="#modalDireccion">Editar</a>
                                    <input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="" value= "{{$instructor['direccion']}}">
                                 </div>
                               </div>
                           </div>
                        </div>
                        <label for="fichaM"> Ficha Médica  ----------------------------------------------------------------- </label> </label> <a data-toggle="modal" href="#modalFicha">Editar</a>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="alergia">Alergia</label>
                                    <input type="text" class="form-control input-sm" name="alergia" id="alergia" placeholder="" value= "{{$instructor['alergia']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="asma">Asma</label>
                                    <input type="text" class="form-control input-sm" name="asma" id="asma" placeholder="" value= "{{$instructor['asma']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="convulsiones">Convulsiones</label>
                                    <input type="text" class="form-control input-sm" name="convulsiones" id="convulsiones" placeholder="" value= "{{$instructor['convulsiones']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="cefalea">Cefalea</label>
                                    <input type="text" class="form-control input-sm" name="cefalea" id="cefalea" placeholder="" value= "{{$instructor['cefalea']}}">
                                 </div>
                               </div>
                            <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="hipertension">Hipertensión</label>
                                    <input type="text" class="form-control input-sm" name="hipertension" id="hipertension" placeholder="" value= "{{$instructor['hipertension']}}">
                                 </div>
                               </div>
                             <div class="col-sm-4 p-t-10">
                                 <div class="form-group fg-line">
                                    <label for="lesiones">Lesiones</label>
                                    <input type="text" class="form-control input-sm" name="lesiones" id="lesiones" placeholder="" value= "{{$instructor['lesiones']}}">
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
                    title: "Desea eliminar al instructor?",   
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

     