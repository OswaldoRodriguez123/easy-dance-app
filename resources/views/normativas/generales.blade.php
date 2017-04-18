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
  <!-- ENHORABUENA -->
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/normativas" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                      <div class="card-header">
                        <div class="text-center f-25 f-700">Políticas de privacidad, (Normativas de la academia)</div>
                        <hr>
                      </div>
                      <div class="col-md-1"></div>

                      <div class="col-md-10">
                        <div class="text-justify">

                          <p>Bienvenido a "Tu Clase de Baile", nos complace ofrecerle nuestro programa de baile, al momento de acceder y utilizar nuestros servicios usted acepta los términos y políticas de privacidad. Si no está de acuerdo con los términos o las políticas de privacidad, por favor no utilice el servicio.</p>

                          <div class="f-22 f-700">Condiciones generales</div>
                          <br>

                          <div class="f-18 f-700">1- Duración</div>
                          <br>

                          <p>Comprende perfectamente que usted participa en un programa de baile con una duración de (3) meses o la culminación de tres (3) niveles.</p>

                          <div class="f-18 f-700">2- Autoridad</div>
                          <br>

                          <p>Entiende que los propietarios/directores, empleados y profesores de la academia de baile "Tu Clase de Baile" tienen el derecho de negar la entrada a clases a cualquier alumno que se encuentre retrasado en la matrícula de pago.</p>

                          <div class="f-18 f-700">3- Asistencia</div>
                          <br>

                          <p>Usted debe confirmar su asistencia en el área de recepción cada vez que asista a sus clases y así constatar su presencia y horario de llegada.</p>


                          <div class="f-18 f-700">4- Respeto a la autoridad</div><br>

                          <p>Deberá respetarse la autoridad de la logística, líderes de la institución, coordinadores y directores, bajo ninguna circunstancia se podrá desacatar las normas y deberes propuestos por la organización de parte de los alumnos.</p>

                          <div class="f-18 f-700">5- Inasistencia</div><br>

                          <p>En el caso que usted falte a sus clases de baile, por cualquier hecho, la academia no se obliga a reponer sus clases perdidas.</p>


                          <div class="f-18 f-700">6- Seguridad</div><br>

                          <p>En "Tu clase de baile", nos preocupamos por la integridad física de usted y sus representados, ponemos a disposición medidas de control y de seguridad para resguardar su integridad y la de sus pertenencias dentro de la institución, sin embargo no podemos garantizarle que extraños o propios violen los sistemas de seguridad con fines vandálicos, que atenten contra la integridad física de los presentes o de cualquier elemento material, tales como, teléfonos, prendas, carteras, entre otros, por lo tanto usted comprende que es responsable de su propio bienestar y cuidado o el de su representado.</p>


                          <div class="f-18 f-700">7- Previsión</div><br>

                          <p>Nuestra organización no se responsabiliza por alumnos que permanezcan en los alrededores de la academia, en caso que el alumno sea menor de edad, recomendamos que sus representantes estén presentes al momento de culminar la clase. Al finalizar la jornada laboral la a academia brindará 30 minutos adicionales para realizar el cierre de sus instalaciones (agradecemos tomar previsiones).</p>


                          <div class="f-18 f-700">8- Reclamos</div><br>

                          <p>Todos los reclamos que presente en la administración, recepción u otros departamentos serán tomados en consideración y atendidos según las circunstancias, siempre y cuando usted se encuentre al día con sus responsabilidades económicas dentro de la academia, de lo contrario su reclamo no tendrá validez.</p>

                          <div class="f-18 f-700">9- Venta de marca</div><br>

                          <p>No podrá reproducir artículos, suvenir para la venta u obsequio con la imagen corporativa de nuestra academia dentro o fuera de las instalaciones sin ser autorizado.</p>

                          <div class="f-18 f-700">10- Hechos fortuitos</div><br>

                          <p>En caso de hechos fortuitos naturales, problemas eléctricos o racionamientos implementados por el gobierno, marchas o trancas de avenidas o calles por temas políticos y sociales, días feriados  entre otras diversas  circunstancias que pudieran presentarse y que no representan responsabilidad directa de  nuestra organización, la academia se compromete en la búsqueda de una solución rápida y efectiva que se encuentre a nuestro alcance, sin embargo la academia no se obliga a reponer ni a responsabilizarse  por las clases perdidas.</p>

                          <div class="f-18 f-700">11- Buen uso</div><br>

                          <p>Usted deberá cumplir con el uso y cuidado adecuado de las instalaciones de la academia, en caso de que incurra en daños a elementos u objetos de las instalaciones por un uso o conducta inadecuada, el alumno pagará por el valor comercial del elemento dañado o perdido o el precio del arreglo, siempre y cuando este sea posible a juicio de "Tu Clase de Baile", este podrá ser descontado de deducido de sus acuerdos de pago.</p>

                          <div class="f-18 f-700">12- Comercializar</div><br>

                          <p>No se permite la comercialización (venta o compra) de artículos o productos dentro de las instalaciones de la academia de ninguna índole.</p>

                          <div class="f-18 f-700">13- Conducta</div><br>

                          <p>Dentro de las instalaciones el alumno debe asumir una postura apegada al respeto, disciplina y orden, no se permiten dispositivos de audio con altos niveles de volumen, tertulias en tonos elevados, o reuniones y conversaciones telefónicas dentro de las áreas del baño, siendo este exclusivo para las necesidades fisiológicas de los clientes.</p>

                          <div class="f-18 f-700">14-  Requisito de edad</div><br>

                          <p>Usted debe tener al menos 18 años de edad para convenir y aceptar estos términos de servicio en nombre propio. Si es menor de 18 años, su padre, madre o tutor legal debe aceptar estos términos de servicio y registrarse en nombre de usted.</p>

                          <div class="f-18 f-700">15-  Niveles de apertura</div><br>

                          <p>La academia diseñará y ofrecerá los niveles de apertura en las fechas de cada mes, en caso de que la cuota de alumnos se logre antes de la fecha prevista o en su defecto la cantidad de alumnos inscritos no cumpla con el mínimo previsto, la academia podrá adelantar o extender la fecha de inicio, sin o con el consentimiento de los alumnos inscritos.</p>

                          <div class="f-18 f-700">16- Acuerdo de pago</div><br>

                          <p>Usted acepta pagar por todo el contenido de "Tu Clase de Baile" que no se obtenga por medio de un código de promoción o que la compañía no le haya ofrecido en forma gratuita.</p>

                          <div class="f-18 f-700">17- Fechas de pago</div><br>

                          <p>Usted deberá realizar sus pagos los días quince (15) o último según corresponda su fecha de pago, la administración brindará cinco (5) días de tolerancia para realizar este proceso, en caso de la no emisión del mismo se le recargará una mora del 15 % del total de la cuota que corresponda.</p>

                          <div class="f-18 f-700">18-  Política de reembolso</div><br>

                          <p>En caso de que el alumno desee retirarse después de haber iniciado la primera clase que brinde la programación de la academia, esta no se obliga a devolver el valor inicial del programa seleccionado; si el alumno realizado pagos adicionales de sus cuotas o el pago general del programa, la academia tendrá 15 días hábiles para la devolución del dinero.</p> 

                          <p>Luego de haber transcurridos tres (3) días desde la fecha de inicio del curso, los pagos o cargos realizados no son reembolsables. Si el alumno no ha dado inicio a sus clases y desea retirarse por voluntad propia o por motivos ajenos a su voluntad, la academia ofrece la oportunidad de que el cliente pueda transferir su cupo a otra persona, el cual tendrá seis meses desde el anuncio de su retiro para poder brindarle el uso a su cupo adquirido.</p>

                          <div class="f-18 f-700">19- Terminación</div><br>

                          <p>La Compañía se reserva el derecho a dar por terminada su AFILIACIÓN en "Tu Clase de Baile" en caso de infringir con los términos de servicio y normativas de la institución; su membrecía y suscripción(es) del servicio, no serán reembolsables, ni las cuotas o cargos mensuales.</p>

                          <div class="f-18 f-700">20- El derecho de la Compañía “las políticas de matrículas”.</div><br>

                          <p> La Compañía se reserva el derecho, a su discreción, de cambiar, modificar, añadir o eliminar partes de estas políticas de matrículas,  en cualquier momento, sin previo aviso a usted. Todos los cambios entrarán en vigor de inmediato. En caso de algún cambio sustancial, haremos todos los esfuerzos comercialmente razonables para notificárselo  antes de implementar dichos cambios. Le recomendamos que consulte estos Términos de Servicio en forma periódica para ver si se han registrado cambios. El uso continuado del Servicio por parte suya después de la publicación de dichos cambios implica la aceptación de los mismos.</p>

                          <div class="f-18 f-700">21- El derecho de la compañía sobre políticas de matrículas.</div><br>

                          <p>La compañía se reserva el derecho, a su discreción, de cambiar, modificar, añadir o eliminar partes de estas políticas de matrículas, en cualquier momento, sin previo aviso a usted, todos los cambios entrarán en vigor de inmediato. En caso de algún cambio sustancial, haremos todos los esfuerzos comercialmente razonables para notificárselo antes de implementar dichos cambios. Le recomendamos que consulte estos términos de servicio en forma periódica para verificar si se han registrado cambios. El uso continuado del servicio por parte suya después de la publicación de dichos cambios implica la aceptación de los mismos.</p>

                          <div class="f-18 f-700">22- Especiales para niños y CEF</div><br>

                          <p>Todo integrante del grupo de niños o CEF deberá asistir a sus prácticas con el uniforme establecido por la institución, sin ningún tipo de prendas, ni dispositivos tecnológicos de valor, además las niñas y adultas con el cabello recogido en forma de dona.</p>

                          <div class="f-18 f-700">23- El derecho de la compañía a efectuar cambios al servicio</div><br>

                          <p>La Compañía puede agregar, cambiar, terminar, remover o suspender cualquier sistema o programa de baile incorporado al servicio, incluyendo características, precios y especificaciones de los productos descritos o reseñados en el mismo, en forma temporal o permanente, en cualquier momento, sin previo aviso y sin responsabilidad de notificación alguna.</p>

                          <div class="f-18 f-700">24- Derechos de imagen</div><br>

                          <p>Aceptando estos términos autorizo a la academia Tu Clase de Baile para que haga uso de mis derechos de imagen para incluirlos sobre fotografías, procedimientos análogos a la fotografía, producciones audiovisuales (Videos); así como de los derechos de autor, conexos y en general todos aquellos de propiedad intelectual que tengan que ver con el derecho de imagen; para ser utilizada en formato o soporte material en ediciones impresas, en medio electrónico, óptico, magnético, en redes (intranet e internet), mensajes de datos o similares y en general para cualquier medio o soporte conocido o por conocer en el futuro. La publicación podrá efectuarse de manera directa o a través de un tercero designado para tal fin, sin limitación geográfica o territorial alguna. De igual forma esta autorización no implicará exclusividad y me reserva el derecho de otorgar autorizaciones de usos similares en los mismos términos en favor de terceros.</p>

                          <div class="f-18 f-700">25- Participantes grupales</div><br>

                          <p>En caso de que un grupo ya iniciado o por iniciar carezca de la cantidad mínima establecida de participantes activos (11 participantes), la institución tiene la posibilidad de cerrar dicho curso y reubicar a los participantes según su nivel, con o sin el consentimiento de los participantes. La academia hará todos los esfuerzos posibles para realizar este proceso de manera armoniosa y benéfica para cada uno de los alumnos, y de esta no frenar el proceso de aprendizaje.</p>

                          <div class="f-18 f-700">26- Pagos a crédito</div><br>

                          <p>Todas aquellas personas que adquieran paquetes o productos de cualquier tipo con el beneficio de realizar el pago a crédito, deberán cumplir con el pago de todas las cuotas establecidas por la institución y acordadas con el alumno, aun cuando este decida no finalizar el programa escogido o no dar uso al producto adquirido sea cual fuere la razón, sirviendo esto como soporte para la institución ante cualquier entidad legal.</p>

                          <div class="f-18 f-700">27- Uso de plataforma web</div><br>

                          <p>A través de nuestra plataforma web cada participante podrá disfrutar de las todas las ventajas y beneficios que nuestra academia brinda de manera gratuita, siempre que el alumno cumpla con todas las normas académicas y administrativas recientes o por crearse en "Tu Clase de Baile", todo el material de imagen, videos, recreación, apoyo académico, productos, promociones, citas, valoraciones, campañas o cualquier otro ítem habilitado en la plataforma, tendrán un costo adicional al paquete seleccionado que lo incluya cuando el alumno incumpla con los protocolos y normativas establecidas y deberá pagar las cuotas indicadas por la institución para hacerse acreedor de los servicios o productos perdidos, los montos podrán variar según lo disponga el departamento administrativo. "Tu Clase de Baile" no se encuentra en la obligación de reponer productos o servicios perdidos por el alumno debido al incumplimiento de las normas y protocolos institucionales.</p>

                          <div class="f-18 f-700">28. Consulta</div><br>

                          <p>Si tiene alguna pregunta o comentario sobre estos términos de servicio, no dude en contactarnos por vía telefónica a los números que aparecen en nuestro sitio web <a href="www.tuclasedebaile.com.co">www.tuclasedebaile.com.co</a></p>

                          <div class="f-18 f-700">29. Repaso</div><br>

                          <p>Todo integrante que se vea en la necesidad de reforzar sus conocimientos o prácticas de clases de baile, debido a la carencia de habilidades o por inasistencias recurrente a las clases , el alumno deberá asistir a las actividades  de repaso o tomar clases personalizadas, con el objetivo  de mantener la armonía del aprendizaje grupal , el instructor de planta  o profesor de diagnóstico recomendará dichas actividades según el caso personal de cada integrante, es importante resaltar  que para continuar su avance y certificación por cada nivel , deberá estar avalado por los profesores de la institución , de lo contrario nuestros profesores podrán  solicitar que el integrante repita la nivelación  en los horarios disponibles que la academia al momento posea. </a></p>

                        </div>
                      </div>

                      <div class="col-md-1"></div>           

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