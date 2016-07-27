            <!--
              BEGIN
              MODAL AYUDA
            -->     
            <div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> ESTAMOS AQUÍ PARA AYUDARTE<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>

                        <form name="moda_ayuda" id="modal_ayuda"  >
                           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                           	<div class="modal-body">
                           		<div class="row">
                           			<div class="col-md-1"></div>
                           			<div class="col-md-10">
		                           		<div class="clearfix"></div>
		                           		<div class="col-md-offset-4">
		                           		<div class="text-center"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 150px; max-width: 150px;" class="img-responsive opaco-0-8" alt=""></div>
		                           		</div>
		                           		<div class="clearfix"></div>
										<p class="text-justify p-t-10 p-b-10 f-18">Si tiene cualquier pregunta, comentario o preocupación con respecto a su cuenta Easy Dance, no dudes en contactarnos. Tus apreciaciones y comentarios son  bienvenidos, al igual que nuevas ideas, para que podamos seguir mejorando nuestros servicios.</p>
										<div class="clearfix"></div>

		                                <div class="fg-line">
		                                    <textarea class="form-control" rows="5" placeholder="Dejanos tu comentario...." id="mensaje_ayuda" name="mensaje_ayuda"></textarea>
		                                </div>                           				
                           			</div>
                           			<div class="col-md-1"></div>
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

	                             <a class="btn-blanco m-r-5 f-12 guardar" id="guardarAyuda" href="#">  Enviar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

	                            </div>
	                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END -->


<footer id="footer">

		    <div class="bg-gris p-10 footer-text" >
			<p> <b><a href="http://easydancelatino.com/" target="_blank" > www.easydancelatino.com </a></b></p> 


			<p class="f-35">
			    <a href="https://www.facebook.com/Easydancelatino/" target="_blank" title="Facebook">
			    	<i class="flaticon-facebook"></i>
			    </a>
			    <a href="https://www.instagram.com/easydancelatino/" target="_blank" title="Instagram">
			    	<i class="flaticon-instagram"></i>
			    </a>
			    <a href="https://twitter.com/EasyDanceLatino" target="_blank" title="Twitter" >
			    	<i class="flaticon-twitter" ></i>
			    </a> 
			    <a href="https://plus.google.com/u/0/104687135628887176910" target="_blank" title="Google+" >
			    	<i class="flaticon-google-plus"></i>
			    </a>
			</p>
            
            <section id="content" >
        <div class="container">
			<div class="col-sm-4">
			    <h4>Empresa</h4>

			    <p class="m-t-5 m-b-5"><a href="{{url('empresa/sobre-la-empresa')}}" class="enlace-footer"  >Sobre la empresa</a></p> 

			    <p class="m-t-5 m-b-5"><a href="{{url('empresa/sobre-la-empresa')}}"  >Nuestro equipo</a></p>

			    <p class="m-t-5 m-b-5"><a href="{{url('empresa/sobre-la-empresa')}}"  >FAQs</a></p> 

			    <p class="m-t-5 m-b-5"><a href="{{url('empresa/embajadores')}}" >Embajadores</a></p>
			 
			    <p class="m-t-5 m-b-5"><a href="http://easydancelatino.com/#/noticias" target="_blank" >Noticias</a></p>

			</div>

			<!--<div class="col-sm-3">
			    
			    <h4>Easy Dance</h4>

			    <p class="m-t-5 m-b-5"  ><a href="http://easydancelatino.com" target="_blank" >Para academias</a></p> 

			    <p class="m-t-5 m-b-5"  ><a  >Para alumnos </a></p>

			    <p class="m-t-5 m-b-5"  ><a  >Para instructores </a></p> 

			</div>-->

			<div class="col-sm-4">
			    
			    <h4>Contáctanos</h4>

			    <p class="m-t-5 m-b-5">Venezuela , Maracaibo, centro comercial Salto Ángel en la avenida 3 Y – entre la calle 78 y 79 <br><b><a href="mailto:info@easydancelatino.com">info@easydancelatino.com</a></b></p>      
			    
			</div>

			<div class="col-sm-4">

			    <h4>Soporte</h4>

			    <p class="m-t-5 m-b-5"><a data-toggle="modal" href="#modalAyuda" >Ayuda / Soporte</a></p> 			  
			    <p  class="m-t-5 m-b-5" ><a  target="_blank" >Manuales de procedimiento</a></p>

			    <p  class="m-t-5 m-b-5" ><a  target="_blank" >Normas de mi academia</a></p>

			    <p  class="m-t-5 m-b-5" ><a href="{{url('soporte/acuerdo')}}" data-ui-sref="info.acuerdos" >Acuerdos de servicio</a></p>

			    <p  class="m-t-5 m-b-5" ><a href="{{ url('soporte/politicas') }}" data-ui-sref="info.politicas">Políticas de uso</a></p> 

			    <p class="m-t-5 m-b-5"><a href="{{ url('soporte/normas') }}" data-ui-sref="info.normas" >Normas de la comunidad</a></p> 



			</div>

			</div>

			</section>

			<br>

			<small class="c-negro">Copyright &copy; 2016 Easy Dance, todos los derechos reservados.  </small>



			</div>
        </footer>


@section('js') 

	<script type="text/javascript">
		route_ayuda = "{{url('/')}}/correo/ayuda"
        $("#guardarAyuda").on('click', function(){
        	//alert(prueba);
            var token = $('input:hidden[name=_token]').val();
            var datos = $("#modal_ayuda").serialize();

            $.ajax({
              url: route_ayuda,
                  headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: datos,
              success:function(respuesta){

              },
              error:function(msj){

              }
            });

            /*setTimeout(function(){ window.location = "{{url('/')}}/especiales/campañas/progreso/"+{{--$campana->id--}}; },3000);*/

        });
    </script>
@stop