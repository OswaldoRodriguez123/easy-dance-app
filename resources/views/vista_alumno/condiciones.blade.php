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
                            <span class="f-16 c-morado">

                            @if(Auth::user()->sexo == 'M')
                              Bienvenido
                            @else
                              Bienvenida
                            @endif


                            a la Academia <b>{{$academia->nombre}}</b></span> 

                            <br></br>   
                            <span class="f-16 c-morado">A traves de la aplicacion <b>Easy Dance</b> podras reservar clases, ver asistencias, <br> reportes administrativas, agendar activdades y otras funcionalidades mas.</span> 

                            <br><br><br>

                            <span class="f-25 c-morado text-center"><b>Condiciones Generales</b></span> 

                            <br><br><br>
                        </div>



                    <div style="margin-left: 25%">
                        <div class="col-sm-8" style ="background-color:#f5f5f5; color:#333333; padding:8.5px; margin: 0 0 9px; border-radius: 2px; border:1px solid #cccccc; overflow-y: auto; height:400px">

                                  <p style="font-size: 12px" name="pre_condiciones" id="pre_condiciones">


                                    <div class="text-center f-25 f-700">Pol??ticas de privacidad, (Normativas de la academia)</div>
                                        <hr>
                                    <div class="col-md-1"></div>
                                       <div class="col-md-10">
                                      <div class="text-justify">

                                      <p>Bienvenido a "Tu Clase de Baile", nos complace ofrecerle nuestro programa de baile, al momento de acceder y utilizar nuestros servicios usted acepta los t??rminos y pol??ticas de privacidad. Si no est?? de acuerdo con los t??rminos o las pol??ticas de privacidad, por favor no utilice el servicio.</p>
                                      
                                      <div class="f-22 f-700">Condiciones generales</div>
                                      <br>

                                      <div class="f-18 f-700">1- Duraci??n</div>
                                      <br>

                                      <p>Comprende perfectamente que usted participa en un programa de baile con una duraci??n de (3) meses o la culminaci??n de tres (3) niveles.</p>

                                      <div class="f-18 f-700">2- Autoridad</div>
                                      <br>

                                      <p>Entiende que los propietarios/directores, empleados y profesores de la academia de baile "Tu Clase de Baile" tienen el derecho de negar la entrada a clases a cualquier alumno que se encuentre retrasado en la matr??cula de pago.</p>

                                      <div class="f-18 f-700">3- Asistencia</div>
                                      <br>

                                      <p>Usted debe confirmar su asistencia en el ??rea de recepci??n cada vez que asista a sus clases y as?? constatar su presencia y horario de llegada.</p>


                                      <div class="f-18 f-700">4- Respeto a la autoridad</div><br>

                                      <p>Deber?? respetarse la autoridad de la log??stica, l??deres de la instituci??n, coordinadores y directores, bajo ninguna circunstancia se podr?? desacatar las normas y deberes propuestos por la organizaci??n de parte de los alumnos.</p>

                                      <div class="f-18 f-700">5- Inasistencia</div><br>

                                      <p>En el caso que usted falte a sus clases de baile, por cualquier hecho, la academia no se obliga a reponer sus clases perdidas.</p>


                                      <div class="f-18 f-700">6- Seguridad</div><br>

                                      <p>En "Tu clase de baile", nos preocupamos por la integridad f??sica de usted y sus representados, ponemos a disposici??n medidas de control y de seguridad para resguardar su integridad y la de sus pertenencias dentro de la instituci??n, sin embargo no podemos garantizarle que extra??os o propios violen los sistemas de seguridad con fines vand??licos, que atenten contra la integridad f??sica de los presentes o de cualquier elemento material, tales como, tel??fonos, prendas, carteras, entre otros, por lo tanto usted comprende que es responsable de su propio bienestar y cuidado o el de su representado.</p>


                                      <div class="f-18 f-700">7- Previsi??n</div><br>

                                      <p>Nuestra organizaci??n no se responsabiliza por alumnos que permanezcan en los alrededores de la academia, en caso que el alumno sea menor de edad, recomendamos que sus representantes est??n presentes al momento de culminar la clase. Al finalizar la jornada laboral la a academia brindar?? 30 minutos adicionales para realizar el cierre de sus instalaciones (agradecemos tomar previsiones).</p>


                                      <div class="f-18 f-700">8- Reclamos</div><br>

                                      <p>Todos los reclamos que presente en la administraci??n, recepci??n u otros departamentos ser??n tomados en consideraci??n y atendidos seg??n las circunstancias, siempre y cuando usted se encuentre al d??a con sus responsabilidades econ??micas dentro de la academia, de lo contrario su reclamo no tendr?? validez.</p>

                                      <div class="f-18 f-700">9- Venta de marca</div><br>

                                      <p>No podr?? reproducir art??culos, suvenir para la venta u obsequio con la imagen corporativa de nuestra academia dentro o fuera de las instalaciones sin ser autorizado.</p>

                                      <div class="f-18 f-700">10- Hechos fortuitos</div><br>

                                      <p>En caso de hechos fortuitos naturales, problemas el??ctricos o racionamientos implementados por el gobierno, marchas o trancas de avenidas o calles por temas pol??ticos y sociales, d??as feriados  entre otras diversas  circunstancias que pudieran presentarse y que no representan responsabilidad directa de  nuestra organizaci??n, la academia se compromete en la b??squeda de una soluci??n r??pida y efectiva que se encuentre a nuestro alcance, sin embargo la academia no se obliga a reponer ni a responsabilizarse  por las clases perdidas.</p>

                                      <div class="f-18 f-700">11- Buen uso</div><br>

                                      <p>Usted deber?? cumplir con el uso y cuidado adecuado de las instalaciones de la academia, en caso de que incurra en da??os a elementos u objetos de las instalaciones por un uso o conducta inadecuada, el alumno pagar?? por el valor comercial del elemento da??ado o perdido o el precio del arreglo, siempre y cuando este sea posible a juicio de "Tu Clase de Baile", este podr?? ser descontado de deducido de sus acuerdos de pago.</p>

                                      <div class="f-18 f-700">12- Comercializar</div><br>

                                      <p>No se permite la comercializaci??n (venta o compra) de art??culos o productos dentro de las instalaciones de la academia de ninguna ??ndole.</p>

                                      <div class="f-18 f-700">13- Conducta</div><br>

                                      <p>Dentro de las instalaciones el alumno debe asumir una postura apegada al respeto, disciplina y orden, no se permiten dispositivos de audio con altos niveles de volumen, tertulias en tonos elevados, o reuniones y conversaciones telef??nicas dentro de las ??reas del ba??o, siendo este exclusivo para las necesidades fisiol??gicas de los clientes.</p>

                                      <div class="f-18 f-700">14-  Requisito de edad</div><br>

                                      <p>Usted debe tener al menos 18 a??os de edad para convenir y aceptar estos t??rminos de servicio en nombre propio. Si es menor de 18 a??os, su padre, madre o tutor legal debe aceptar estos t??rminos de servicio y registrarse en nombre de usted.</p>

                                      <div class="f-18 f-700">15-  Niveles de apertura</div><br>

                                      <p>La academia dise??ar?? y ofrecer?? los niveles de apertura en las fechas de cada mes, en caso de que la cuota de alumnos se logre antes de la fecha prevista o en su defecto la cantidad de alumnos inscritos no cumpla con el m??nimo previsto, la academia podr?? adelantar o extender la fecha de inicio, sin o con el consentimiento de los alumnos inscritos.</p>

                                      <div class="f-18 f-700">16- Acuerdo de pago</div><br>

                                      <p>Usted acepta pagar por todo el contenido de "Tu Clase de Baile" que no se obtenga por medio de un c??digo de promoci??n o que la compa????a no le haya ofrecido en forma gratuita.</p>

                                      <div class="f-18 f-700">17- Fechas de pago</div><br>

                                      <p>Usted deber?? realizar sus pagos los d??as quince (15) o ??ltimo seg??n corresponda su fecha de pago, la administraci??n brindar?? cinco (5) d??as de tolerancia para realizar este proceso, en caso de la no emisi??n del mismo se le recargar?? una mora del 15 % del total de la cuota que corresponda.</p>

                                      <div class="f-18 f-700">18-  Pol??tica de reembolso</div><br>

                                      <p>En caso de que el alumno desee retirarse despu??s de haber iniciado la primera clase que brinde la programaci??n de la academia, esta no se obliga a devolver el valor inicial del programa seleccionado; si el alumno realizado pagos adicionales de sus cuotas o el pago general del programa, la academia tendr?? 15 d??as h??biles para la devoluci??n del dinero.</p> 

                                      <p>Luego de haber transcurridos tres (3) d??as desde la fecha de inicio del curso, los pagos o cargos realizados no son reembolsables. Si el alumno no ha dado inicio a sus clases y desea retirarse por voluntad propia o por motivos ajenos a su voluntad, la academia ofrece la oportunidad de que el cliente pueda transferir su cupo a otra persona, el cual tendr?? seis meses desde el anuncio de su retiro para poder brindarle el uso a su cupo adquirido.</p>

                                      <div class="f-18 f-700">19- Terminaci??n</div><br>

                                      <p>La Compa????a se reserva el derecho a dar por terminada su AFILIACI??N en "Tu Clase de Baile" en caso de infringir con los t??rminos de servicio y normativas de la instituci??n; su membrec??a y suscripci??n(es) del servicio, no ser??n reembolsables, ni las cuotas o cargos mensuales.</p>

                                      <div class="f-18 f-700">20- El derecho de la Compa????a ???las pol??ticas de matr??culas???.</div><br>

                                      <p> La Compa????a se reserva el derecho, a su discreci??n, de cambiar, modificar, a??adir o eliminar partes de estas pol??ticas de matr??culas,  en cualquier momento, sin previo aviso a usted. Todos los cambios entrar??n en vigor de inmediato. En caso de alg??n cambio sustancial, haremos todos los esfuerzos comercialmente razonables para notific??rselo  antes de implementar dichos cambios. Le recomendamos que consulte estos T??rminos de Servicio en forma peri??dica para ver si se han registrado cambios. El uso continuado del Servicio por parte suya despu??s de la publicaci??n de dichos cambios implica la aceptaci??n de los mismos.</p>

                                      <div class="f-18 f-700">21- El derecho de la compa????a sobre pol??ticas de matr??culas.</div><br>

                                      <p>La compa????a se reserva el derecho, a su discreci??n, de cambiar, modificar, a??adir o eliminar partes de estas pol??ticas de matr??culas, en cualquier momento, sin previo aviso a usted, todos los cambios entrar??n en vigor de inmediato. En caso de alg??n cambio sustancial, haremos todos los esfuerzos comercialmente razonables para notific??rselo antes de implementar dichos cambios. Le recomendamos que consulte estos t??rminos de servicio en forma peri??dica para verificar si se han registrado cambios. El uso continuado del servicio por parte suya despu??s de la publicaci??n de dichos cambios implica la aceptaci??n de los mismos.</p>

                                      <div class="f-18 f-700">22- Especiales para ni??os y CEF</div><br>

                                      <p>Todo integrante del grupo de ni??os o CEF deber?? asistir a sus pr??cticas con el uniforme establecido por la instituci??n, sin ning??n tipo de prendas, ni dispositivos tecnol??gicos de valor, adem??s las ni??as y adultas con el cabello recogido en forma de dona.</p>

                                      <div class="f-18 f-700">23- El derecho de la compa????a a efectuar cambios al servicio</div><br>

                                      <p>La Compa????a puede agregar, cambiar, terminar, remover o suspender cualquier sistema o programa de baile incorporado al servicio, incluyendo caracter??sticas, precios y especificaciones de los productos descritos o rese??ados en el mismo, en forma temporal o permanente, en cualquier momento, sin previo aviso y sin responsabilidad de notificaci??n alguna.</p>

                                      <div class="f-18 f-700">24- Derechos de imagen</div><br>

                                      <p>Aceptando estos t??rminos autorizo a la academia Tu Clase de Baile para que haga uso de mis derechos de imagen para incluirlos sobre fotograf??as, procedimientos an??logos a la fotograf??a, producciones audiovisuales (Videos); as?? como de los derechos de autor, conexos y en general todos aquellos de propiedad intelectual que tengan que ver con el derecho de imagen; para ser utilizada en formato o soporte material en ediciones impresas, en medio electr??nico, ??ptico, magn??tico, en redes (intranet e internet), mensajes de datos o similares y en general para cualquier medio o soporte conocido o por conocer en el futuro. La publicaci??n podr?? efectuarse de manera directa o a trav??s de un tercero designado para tal fin, sin limitaci??n geogr??fica o territorial alguna. De igual forma esta autorizaci??n no implicar?? exclusividad y me reserva el derecho de otorgar autorizaciones de usos similares en los mismos t??rminos en favor de terceros.</p>

                                      <div class="f-18 f-700">25- Participantes grupales</div><br>

                                      <p>En caso de que un grupo ya iniciado o por iniciar carezca de la cantidad m??nima establecida de participantes activos (11 participantes), la instituci??n tiene la posibilidad de cerrar dicho curso y reubicar a los participantes seg??n su nivel, con o sin el consentimiento de los participantes. La academia har?? todos los esfuerzos posibles para realizar este proceso de manera armoniosa y ben??fica para cada uno de los alumnos, y de esta no frenar el proceso de aprendizaje.</p>

                                      <div class="f-18 f-700">26- Pagos a cr??dito</div><br>

                                      <p>Todas aquellas personas que adquieran paquetes o productos de cualquier tipo con el beneficio de realizar el pago a cr??dito, deber??n cumplir con el pago de todas las cuotas establecidas por la instituci??n y acordadas con el alumno, aun cuando este decida no finalizar el programa escogido o no dar uso al producto adquirido sea cual fuere la raz??n, sirviendo esto como soporte para la instituci??n ante cualquier entidad legal.</p>

                                      <div class="f-18 f-700">27- Uso de plataforma web</div><br>

                                      <p>A trav??s de nuestra plataforma web cada participante podr?? disfrutar de las todas las ventajas y beneficios que nuestra academia brinda de manera gratuita, siempre que el alumno cumpla con todas las normas acad??micas y administrativas recientes o por crearse en "Tu Clase de Baile", todo el material de imagen, videos, recreaci??n, apoyo acad??mico, productos, promociones, citas, valoraciones, campa??as o cualquier otro ??tem habilitado en la plataforma, tendr??n un costo adicional al paquete seleccionado que lo incluya cuando el alumno incumpla con los protocolos y normativas establecidas y deber?? pagar las cuotas indicadas por la instituci??n para hacerse acreedor de los servicios o productos perdidos, los montos podr??n variar seg??n lo disponga el departamento administrativo. "Tu Clase de Baile" no se encuentra en la obligaci??n de reponer productos o servicios perdidos por el alumno debido al incumplimiento de las normas y protocolos institucionales.</p>


                                      <div class="f-18 f-700">28. Repaso</div><br>

                                      <p>Todo integrante que se vea en la necesidad de reforzar sus conocimientos o pr??cticas de clases de baile, debido a la carencia de habilidades o por inasistencias recurrente a las clases , el alumno deber?? asistir a las actividades  de repaso o tomar clases personalizadas, con el objetivo  de mantener la armon??a del aprendizaje grupal , el instructor de planta  o profesor de diagn??stico recomendar?? dichas actividades seg??n el caso personal de cada integrante, es importante resaltar  que para continuar su avance y certificaci??n por cada nivel , deber?? estar avalado por los profesores de la instituci??n , de lo contrario nuestros profesores podr??n  solicitar que el integrante repita la nivelaci??n  en los horarios disponibles que la academia al momento posea. </a></p>

                                      <div class="f-18 f-700">29. Congelar</div><br>

                                      <p>Todo participante activo de la academia que haya ingresado por un curso pago y no a trav??s de una membrec??a u obsequio, tendr?? la posibilidad congelar el ciclo en el que se encuentra, para validar esta actividad deber?? considerar los siguientes pasos:<br> 
                                      ??? El participante deber?? formalizar su proceso de congelamiento en el ??rea de recepci??n.<br>
                                      ??? La organizaci??n ofrecer?? tres (meses) para la reactivaci??n de su cupo.<br>
                                      ??? Al momento de reactivar su cupo deber?? gestionar un pago en la secci??n de administraci??n por concepto de reinicio de $20.000.<br>
                                      ??? Una vez que sea activado su cupo s??lo podr?? ingresar a un curso que est?? en el nivel del que congel?? o una clase inferior, en caso que desee continuar en el curso que se encontraba o de un nivel superior deber?? recibir clases personalizadas hasta ser nivelado en el curso que aspire. <br>
                                      ??? La actividad de congelar un curso, s??lo es v??lido en un rango de una vez por a??o.<br>
                                      ??? Despu??s que el alumno haya aplicado la actividad de congelar un curso en que se encuentre activo, perder?? el privilegio del uso de transferencia de su cupo a otra persona durante la etapa que ha sido congelada su clase grupal.</p>

                                      <div class="f-18 f-700">30. Canje de servicio</div><br>

                                      <p>Todo integrante inscrito en <b>Tu Clase de Baile</b>, tendr?? la posibilidad de solicitar un canje de su paquete o servicio que haya sido obtenido por gesti??n de pago, este podr?? ser aplicado siempre y cuando no le haya brindado el uso del mismo, en dicho caso la organizaci??n brinda la oportunidad de canjear el servicio a otra l??nea que ofrezca la academia, si por el contrario el participante haya dado inicio a sus clases o actividades el servicio de canje no ser?? v??lido.</p>

                                      <div class="f-18 f-700">31. Membrec??as</div><br>

                                      <p>Todos aquellos servicios que han sido obtenido por medio de una promoci??n, membrec??as, premios u otros completamente gratis, la academia se abstiene en brindar los beneficios de canjes, congelar ciclo y transferencias.</p>

                                      <div class="f-18 f-700">32. Valoraci??n recurrente</div><br>

                                      <p>Todo integrante para ascender de nivel deber?? ser valorado por el instructor de diagn??stico en la secci??n de <b>Valoraci??n recurrente</b>, en caso que el alumno no asista a la clase del festejo (en el que se realiza su valoraci??n) deber?? realizar un diagn??stico en calidad de <b>cita exclusiva</b> y de esta forma ser valorado por el instructor, para as?? continuar con su proceso de aprendizaje en la clase que le corresponde.</p>

                                      <div class="f-18 f-700">33. Derecho de imagen</div><br>

                                      <p>El alumno autoriza a la academia a ceder los derechos de explotaci??n sobre las fotograf??as, im??genes o videos  a que indistintamente puedan utilizar todo el material visual y gr??fico para fines publicitarios de proyecci??n e imagen.</p>

                                      <div class="f-18 f-700">34. Transferencia</div><br>

                                      <p>En caso que un alumno desee realizar una transferencia de un curso a otro, despu??s de haber iniciado sus clases recurrentes, la academia buscar?? la posibilidad de aplicar dicha transferencia siempre y cuando cuente con los horarios y cupos de disponibilidad como a su vez que cuente con un grupo que maneje la misma nivelaci??n o alguna inferior, en caso que la academia no posea dichas caracter??sticas y el alumno no pueda o no desee continuar en los horarios en el que est?? inscrito, la academia no se obliga a devolver el monto o parte del plan de inscripci??n o mensualidad que el alumno haya realizado.</p>
 

                                      <div class="f-18 f-700">35. Consulta</div><br>

                                      <p>Si tiene alguna pregunta o comentario sobre estos t??rminos de servicio, no dude en contactarnos por v??a telef??nica a los n??meros que aparecen en nuestro sitio web <a href="www.tuclasedebaile.com.co">www.tuclasedebaile.com.co</a></p>

                                      </div>
                                    </div>

                                    
                                    
                                    </p>

                                  </div>
                                </div>

                                <div class="clearfix"></div> 

                                <div class="col-sm-12 text-center">


                                  <input type="checkbox" id="condiciones" name="condiciones" style="width: 5%">  <span class="f-16 f-700 opaco-0-8">  Acepto los  t??rminos</span> <br><br>
                       
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