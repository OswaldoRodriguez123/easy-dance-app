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

                    <div class="card">


                        <div style="margin-left:45%"><img src="{{url('/')}}/assets/img/PEGGY.png" style="max-height: 130px; max-width: 130px;" class="img-responsive opaco-0-8" alt=""></div>

                        <div class="clearfix p-b-15"></div>
                        <div class="text-center">
                            <span class="f-25 c-morado text-center">Hola <b>{{Auth::user()->nombre}}</b></span>  
                            <br></br>   
                            <span class="f-16 c-morado">Bienvenido a la Academia <b>{{$academia->nombre}}</b></span> 

                            <br></br>   
                            <span class="f-16 c-morado">A traves de la aplicacion <b>Easy Dance</b> podras reservar clases, ver asistencias, <br> reportes administrativas, agendar activdades y otras funcionalidades mas.</span> 

                            <br><br><br>

                            <span class="f-25 c-morado text-center"><b>Condiciones Generales</b></span> 

                            <br><br><br>
                        </div>



                    <div style="margin-left: 25%">
                        <div class="col-sm-8" style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc; overflow-y: auto; height:400px">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones">


                                    <div class="text-center f-25 f-700">Políticas de privacidad, (Normativas de la academia)</div>
                                        <hr>
                                    <div class="col-md-1"></div>
                                       <div class="col-md-10">
                                      <div class="text-justify">

                                      <p>Bienvenidos a "Tu clase de baile" nos complace ofrecerle nuestro  programa de baile, al momento de acceder y utilizar nuestros servicios  usted acepta los términos y políticas de privacidad. Si no está de acuerdo con los términos o las políticas de privacidad, por favor  no utilice el servicio</p>
                                      <div class="f-22 f-700"> Condiciones generales  </div>
                                      <br>
                                      <div class="f-18 f-700"> 1- Asistencia  </div>
                                      <br>

                                      <p>Usted debe confirmar su asistencia en el área de recepción cada vez que asista a sus clases y así constatar su presencia y horario de llegada 5 minutos antes del inicio, en caso de retraso a sus clase tendrá 15 minutos de tolerancia, en caso de asistir sobre la hora establecida, podrá acceder a la clase, sólo en calidad de oyente (si el instructor lo permite).</p>

                                      <div class="f-18 f-700"> 2- Pagos  </div>
                                      <br>

                                      <p>Los alumnos realizarán sus pagos para la fecha que corresponda o que se haya acordado en el proceso de inscripción, en caso de retraso de sus pagos la administración brindará 5 días de tolerancia para gestionar sus pagos, en caso de la no emisión del mismo, la administración una mora correspondiente al 10 % de sus actividades o pasivos económicos.</p>


                                      <div class="f-18 f-700">3-  Acato de normas  </div><br>

                                      <p>Deberá respetarse la autoridad de la logística, líderes de la institución, coordinadores y directores, bajo ninguna circunstancia se podrá desacatar las normas y deberes propuesta por la organización de parte de los alumnos. </p>

                                      <div class="f-18 f-700"> 4- Inasistencia  </div><br>

                                      <p>En el caso  que usted falte a sus clases de baile, por cualquier hecho,  la academia no se obliga a reponer sus  clases perdidas. </p>


                                      <div class="f-18 f-700"> 5- Seguridad </div><br>

                                      <p>En "Tu clase de baile", nos preocupamos por la integridad física de usted y sus representados ,  ponemos a disposición medidas de controles y de seguridad para resguardar su integridad y la de sus pertenecías  dentro de la institución, sin embargo no podemos garantizarle que extraños o propios violen los sistemas de seguridad con fines vandálicos , o que atenten contra la integridad física o de cualquier elemento material  tales como, teléfono, prendas, carteras entre otros,  por lo tanto usted comprende que es responsable de su propio bienestar y cuidado o el de su representado.</p>

                                      <div class="f-18 f-700"> 6- Responsabilidades </div><br>

                                      <p>Nuestra organización no se responsabiliza  por alumnos que permanezcan  en los alrededores  de la academia, en caso que el alumno sea menor de edad, recomendamos que sus representantes estén presente al momento de culminar la clase. Al finalizar la jornada laboral la a academia brindará 20 minutos adicionales para realizar el cierre de sus instalaciones.  (Agradecemos tomar previsiones).</p>

                                      <div class="f-18 f-700"> 7- Reclamos  </div><br>

                                      <p>Todos los reclamos que presente en la administración, recepción u otros departamentos  serán tomados en consideración y atendidos según las circunstancia, siempre y cuando usted se encuentre al día con sus responsabilidades económicas dentro de  la academia, de lo contrario su reclamo no tendrá validez.</p>

                                      <div class="f-18 f-700"> 8- Derecho a Marca </div><br>

                                      <p>No podrá reproducir artículos, suvenir para la venta u obsequio con la imagen corporativa de nuestra academia dentro o fuera de las instalaciones  sin ser autorizado.</p>

                                      <div class="f-18 f-700"> 9- Incidencias  </div><br>

                                      <p>En caso de hechos fortuitos naturales, problemas eléctricos o razonamientos implementados por el gobierno, marchas o trancas de avenidas o calles por temas políticos y sociales, entre otras diversas  circunstancias que pudieran presentarse , las cuales no representan responsabilidad directa de  nuestra organización, La academia se compromete a la búsqueda de solución rápida y efectiva que se encuentre a nuestro alcance, sin embargo la academia no se obliga a reponer ni a responsabilizarse  por las clases perdidas.</p>

                                      <div class="f-18 f-700"> 10- Cuido de pertenencias </div><br>

                                      <p>Usted deberá cumplir con el uso y cuidado adecuado de las instalaciones  de la academia, en caso de que  incurra  en daños a elementos u objetos de  las instalaciones por un uso o conducta  inadecuada, el alumno pagará por el valor comercial  del elemento dañado o perdido o el precio del arreglo, siempre y cuando este sea posible a juicio de "Tu clase de baile", este podrá ser descontado de deducido de sus acuerdos de pago.</p>

                                      <div class="f-18 f-700"> 11- Adquisición de productos </div><br>

                                      <p> El participante deberá adquirir el ticket de compra de las bebidas hidratantes y golosinas  y hacerle entrega al instructor en el horario de descanso o cuando el instructor lo crea pertinente Queda terminantemente prohibido acceder a las bebidas hidratantes y golosinas, dicha sección es de manejo exclusivo de los propietarios / directores, empleados y profesores de la academia.</p>

                                      <div class="f-18 f-700"> 12- Venta particular </div><br>

                                      <p>No se permite, la comercialización (venta o compra) de artículos o producto dentro de las instalaciones de la academia de ninguna índole.</p>

                                      <div class="f-18 f-700"> 13-  Postura y comportamiento </div><br>

                                      <p>Dentro de las instalaciones el alumno debe asumir una postura apegada al respeto , disciplina y orden , no se permiten dispositivos de audio con altos niveles de volumen , tertulias en tonos elevados , o reuniones y  conversaciones telefónicas dentro de las áreas del baño , siendo este (el baño ) exclusivo para las necesidades fisiológicas de los clientes . </p>

                                      <div class="f-18 f-700"> 14-  Requisito de edad  </div><br>

                                      <p>Usted debe tener al menos 18 años de edad para convenir y aceptar estos Términos de Servicio en nombre propio. Si es menor de 18 años, su padre, madre o tutor legal debe aceptar estos Términos de Servicio y registrarse para el Servicio en nombre de usted.</p>

                                      <div class="f-18 f-700"> 15-  Niveles de apertura  </div><br>

                                      <p>La academia diseñará y ofrecerá los niveles de apertura en las fechas de cada mes, en caso de que la cuota de alumnos se llene antes de la fecha prevista o en su defecto la cantidad de alumnos inscrito  no cumple con el  mínimo previsto, la academia podrá adelantar o extender la fecha de inicio, sin o con el consentimiento de los alumnos inscritos. </p>

                                      <div class="f-18 f-700"> 16- Acuerdo de pago </div><br>

                                      <p>Usted acepta pagar por todo el Contenido de Tu clase de baile que no se obtenga por medio de un código de promoción o que la Compañía no le haya ofrecido en forma gratuita. </p>

                                      <p>Usted deberá realizar su cancelación 15/ o último según corresponda su fecha de pago, en el caso de no realizarla en el tiempo establecido, la administración brindará 5 días de tolerancia, en caso de superar los días de tolerancia, es decir, que arribe al día quinto (5) día sin haber ejecutado el pago, el sistema administrativo de manera automática generará una mora del 10%.</p>

                                      <p>El participante entiende que los propietarios / directores, empleados y profesores de la academia  "Tu clase de baile" tienen el derecho de negar la entrada al salón de clases en el caso que se encuentre retrasado por más de una semana en concepto de su mensualidad.</p>

                                      <div class="f-18 f-700"> 17-  Política de reembolso. Retiro  </div><br>

                                      <p>Luego de haber transcurridos tres (3) días desde la fecha de inicio del Curso, los pagos o cargos realizados no son reembolsables.  Si el alumno no ha dado inicio a sus  clases y desea retirarse por voluntad propia o por  motivos ajenos  a su voluntad, la academia ofrece la oportunidad de que el cliente pueda  transferir su cupo  a otra persona, el cliente tendrá seis meses   desde el anuncio de su retiro para poder brindarle el uso a su cupo adquirido, así mismo en el caso que el alumno desee retirarse después de haber iniciado la primera clase que  brinde la programación de la academia   , esta ( la academia )  no se obliga a devolver el costo del valor  inicial del programa seleccionado  ,  en caso que el alumno haya realizado cancelaciones adicionales  de sus cuota de inscripción o mensualidad ; La academia tendrá 15 días Hábiles para generar la devolución del dinero.</p>

                                      <div class="f-18 f-700"> 18- Terminación </div><br>

                                      <p>La Compañía se reserva el derecho a dar por terminada su AFILIACIÓN EN Tu "clase de baile" en caso de infringir con  los Términos de Servicio y normativas de la institución; Su membrecía y suscripción(s) del servicio, no serán reembolsables,  como a su vez, las cuotas ni los cargos mensuales.</p>

                                      <div class="f-18 f-700"> 19- El derecho de la Compañía </div><br>

                                      <p>“las políticas de matrículas”. La Compañía se reserva el derecho, a su discreción, de cambiar, modificar, añadir o eliminar partes de estas políticas de matrículas,  en cualquier momento, sin previo aviso a usted. Todos los cambios entrarán en vigor de inmediato. En caso de algún cambio sustancial, haremos todos los esfuerzos comercialmente razonables para notificárselo  antes de implementar dichos cambios. Le recomendamos que consulte estos Términos de Servicio en forma periódica para ver si se han registrado cambios. El uso continuado del Servicio por parte suya después de la publicación de dichos cambios implica la aceptación de los mismos. El derecho de la Compañía a efectuar cambios al Servicio. La Compañía puede agregar, cambiar, terminar, remover o suspender cualquier sistema o programa de baile  incorporado al Servicio, incluyendo características, precios y especificaciones de los productos descritos o reseñados en el mismo, en forma temporal o permanente, en cualquier momento, sin previo aviso y sin responsabilidad  de notificación alguna.</p>

                                      </div>
                                    </div>

                                    
                                    
                                    </p>

                                  </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="col-sm-12 text-center">


                                  <input type="checkbox" id="condiciones" name="condiciones" style="width: 5%">  <span class="f-16 f-700 opaco-0-8">  Acepto los  términos</span> <br><br>
                       
                                  <button type="button" class="btn btn-blanco m-r-10 f-20 guardar"> Guardar</button>

                                </div>

                              <div class="clearfix p-b-15"></div>



                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>
                            <div class="clearfix p-b-15"></div>


                           </div>
                    </div>
            </section>

@stop


@section('js') 
            
		<script type="text/javascript">
            route_principal="{{url('/')}}/inicio";
            route_aceptar="{{url('/')}}/inicio/condiciones";
   
            $(document).ready(function(){

            $(".guardar").attr("disabled","disabled");

              $(".guardar").css({
                  "opacity": ("0.2")
              });

            $("#condiciones").on('change', function(){
              if ($("#condiciones").is(":checked")){
                 $(".guardar").removeAttr("disabled");
                               
                 $(".guardar").css({
                    "opacity": ("1")
                 });
              }else{
                $(".guardar").attr("disabled","disabled");
                $(".guardar").css({
                    "opacity": ("0.2")
                });
              }    
            });

          });

             $(".guardar").click(function(){

                var route = route_aceptar;
                var token = "{{ csrf_token() }}"
                procesando();

                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                          window.location = route_principal;

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

           


		</script>
@stop