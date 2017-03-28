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
                        <h4><i class="zmdi zmdi-info p-r-5"></i> Información <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Acuerdo de servicio </span></h4>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center f-25 f-700">Acuerdo de Servicio al Cliente</div>
                            <hr>
                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                           <div class="col-md-10">
<div class="text-justify">
<div class="f-22 f-700"> 1. La Plataforma Easy Dance </div>
<div class="f-18 f-700"> a. Easy Dance Ofrenda </div>
<br>

<p>Easy dance ofrece una plataforma diseñada para aumentar los ingresos y racionalizar las operaciones de las organizaciones sociales. La Plataforma ofrece siempre-en escaparate virtual que permite a los visitantes a registrarse para las clases y actividades, renuevan membresías, comprar entradas para eventos, También cuenta con una base de datos robusta cliente / CRM, un motor de informes flexible ,y una colección de herramientas de promoción, el correo Easy dance está diseñado para ayudar a las organizaciones sociales a aumentar su alcance.</p>

<p>el Abuso o excesivamente peticiones frecuentes a Plataforma Easy dance través de la API puede resultar en la suspensión temporal o permanente de su acceso a la API. Easy Dance, a su única discreción, determinará el abuso o el uso excesivo de la API. Easy Dance hará un intento razonable por correo electrónico para que le avise antes de la suspensión.</p>

<p>Easy Dance se reserva el derecho en cualquier momento de modificar o interrumpir, temporal o permanentemente, el acceso a la API (o cualquier parte del mismo) con o sin previo aviso.</p>

<p>Easy Dance se reserva el derecho en cualquier momento de modificar o interrumpir, temporal o permanentemente, el acceso a la API (o cualquier parte del mismo) con o sin previo aviso.</p>

<div class="f-18 f-700">b. Easy Dance Ofrenda </div><br>

<p>Easy Dance le proporciona el apoyo para resolver cualquier problema relacionado con su cuenta de cliente Easy Dance ("Cuenta Cliente") y el uso de la Plataforma.</p>

<div class="f-18 f-700"> c. Seguridad </div><br>

<p>Easy Dance mantiene comercialmente procedimientos administrativos, técnicos y físicos razonables para proteger toda la información sobre usted que se almacena en los servidores Easy Dance del acceso no autorizado y la pérdida accidental o modificación. Sin embargo, Easy Dance no puede garantizar que terceros no autorizados no podrán derrotar a esas medidas o utilizar dicha información para fines impropios.</p>

<p>Easy Dance cumple con todas las leyes aplicables y las normas en relación con la recolección de datos de seguridad y la no difusión de la información de transacciones financiera personales.</p>

<p>Respecto a la información que se proporciona en su propio riesgo.</p>

<div class="f-18 f-700"> d. Disponibilidad </div><br>

<p>Easy Dance compromete a realizar esfuerzos comerciales razonables para operar y mantener la plataforma en general, disponibles las 24 horas del día, los 7 días de la semana, a excepción de tiempo de inactividad planificado que Easy Dance programará en la medida posible durante la noche y fines de semana para sus operaciones de mantenimiento.</p>

<div class="f-18 f-700"> e. Privacidad </div><br>

<p>En la prestación de la Plataforma, Easy Dance utiliza (i) cierta información de audio y visual, documentos, software y otras obras de autoría y (ii) otra tecnología, software (código fuente, código objeto y la documentación), productos, procesos, algoritmos, interfaces de usuario, know-how y otros secretos comerciales, técnicas, diseños, invenciones (patentables o no) y otros materiales e información técnica tangible o intangible, que está cubierta por derechos de propiedad intelectual propiedad de o licenciadas a Easy Dance. Al margen de lo que se establezca expresamente en este Acuerdo, ninguna licencia o cualquier otro derecho en o en la Plataforma se conceden a usted, y todas las licencias y los derechos están reservados expresamente.</p>

<div class="f-18 f-700"> f. Privacidad de los Otros </div><br>

<p>Si recibe información sobre otras academias a través de la utilización de la Plataforma, debe mantener dicha información confidencial y sólo lo uso en relación con la Plataforma. Usted no puede revelar o distribuir dicha información a terceros o utilizar dicha información para fines de marketing a menos que haya recibido el consentimiento expreso para ello.</p>

<div class="f-18 f-700"> g. Impuestos </div><br>

<p>Es su responsabilidad determinar qué, si los hubiera, los impuestos se aplican a la venta de su Ofrenda calificado en relación con el uso de la Plataforma. Es usted el único responsable de evaluar, recopilar, informe o remitir el impuesto correcto a la autoridad fiscal adecuada. Easy Dance no está obligado a, ni determinará si se aplican impuestos, o calcular, recopilar, informe o remitir los impuestos a cualquier autoridad fiscal derivada de cualquier transacción.</p>

<div class="f-18 f-700"> h. Registro </div><br>

<p>Para utilizar la Plataforma, primero tendrá que registrarse para obtener una cuenta de cliente. Easy Dance recopilará información básica como el nombre, la razón social, la ubicación, dirección de correo electrónico, número de identificación fiscal y número de teléfono. Si no lo ha hecho, usted también tendrá que proporcionar una dirección de correo electrónico y la contraseña para el administrador de su cuenta de cliente.</p>

<div class="f-18 f-700"> i. Verificación y Aseguramiento </div><br>

<p>Para verificar su identidad, Easy Dance puede requerir información adicional como: empresa rif- nit. Easy Dance también puede solicitar información adicional para verificar su identidad y determinar su riesgo de negocio incluyendo: facturas, licencia de conducta delictiva uotra identificación oficial, Su incumplimiento de cualquiera de estas solicitudes dentro de los cinco (5) días puede resultar en la suspensión o terminación de su cuenta de cliente.</p>

<p>Después Easy Dance ha recogido y verificado toda la información, Easy Dance determinará si usted es elegible para utilizar la Plataforma. Easy Dance le notificará una vez que su Cuenta Cliente ha sido aprobado o rechazado.</p>

<p>Al aceptar los términos de este Acuerdo, usted está proporcionando Easy Dance con autorización para recuperar información acerca de usted por el uso de terceros, incluidas las agencias de crédito y otros proveedores de información. Usted reconoce que dicha información recuperada puede incluir su nombre, el historial de direcciones, historial de crédito, y otros datos. Easy Dance puede actualizar periódicamente esta información para determinar si sigue cumpliendo con los requisitos de elegibilidad.</p>

<div class="f-18 f-700"> j. Término </div><br>

<p>Efectos de la Terminación</p>

<p>A la terminación y el cierre de su cuenta de cliente, vamos a suspender inmediatamente su acceso a la Plataforma. Usted se compromete a completar todas las transacciones pendientes y dejar de aceptar nuevas transacciones a través de la Plataforma. No se le reembolsará el resto de los cargos que ha pagado para la plataforma si su acceso o uso de la Plataforma se termina o se suspende.</p>

<p>Usted puede elegir o nosotros podemos invitarlos a presentar sus comentarios o ideas acerca de la Plataforma, incluyendo sin limitación acerca de cómo mejorar la Plataforma. Al enviar cualquier idea, usted acepta que su divulgación es gratuita, no solicitada y sin restricciones y no colocar Easy Dance bajo ninguna obligación fiduciaria u otro, y que somos libres de utilizar las ideas sin ningún tipo de compensación adicional para usted y / o divulgar las ideas sobre una base no confidencial o no a cualquiera. Además, reconoce que, por la aceptación de su presentación, Easy Dance no renuncia a ningún derecho de usar ideas similares o relacionadas previamente conocidas a Easy Dance, o desarrolladas por sus empleados, u obtenidos de fuentes distintas a la suya.</p>

<div class="f-18 f-700"> k. Su responsabilidad </div><br>

<p>Sin perjuicio de lo anterior, usted acepta defender, indemnizar y mantener indemne Easy Dance, sus respectivos empleados y agentes de y contra cualquier reclamación, litigio, demanda, pérdida, responsabilidad, daño, acción o procedimiento que surja de o esté relacionada con (i) su incumplimiento de cualquier disposición de este Acuerdo, y / o (ii) el uso de la Plataforma, incluyendo sin limitación cualquier reclamación, multas, tasas, multas y honorarios de abogados; (iii) su, o el de su empleado o agente, negligencia o dolo; o (iv) obligaciones de indemnización de terceros que incurramos como consecuencia directa o indirecta de sus actos u omisiones.</p>

<div class="f-18 f-700"> l. Representación y Garantías </div><br>

<p>Usted manifiesta y garantiza a nosotros que: (a) tiene por lo menos dieciocho (18) años de edad; (b) son elegibles para inscribirse y utilizar la Plataforma y el derecho, el poder y la capacidad de celebrar y cumplir el presente Acuerdo; (c) el nombre que usted identifique al registrarse es su nombre o razón social bajo la cual usted vende bienes y servicios ("Ofrendas Calificados"); (d) cualquier transacción de venta presentada por usted representará una venta de buena fe por usted; (e) cualquier transacción de venta enviados por usted será describir con precisión las Ofrendas calificados vendidas y entregadas a un cliente; (f) cumplirá con todas sus obligaciones para con cada cliente para el que se envía una transacción y resolverá cualquier disputa o queja de los consumidores directamente con el cliente; (g) todas las transacciones iniciadas por usted cumplirá con todas las leyes federales, estatales y locales leyes, reglas y regulaciones aplicables a su negocio, incluyendo las leyes y reglamentos tributarios aplicables; (h), excepto en el curso ordinario de los negocios, no hay transacción de venta presentada por usted a través de la Plataforma representará una venta a cualquier director, socio, propietario, o dueño de la entidad; (i) no utilizará la Plataforma, directa o indirectamente, por cualquier empresa fraudulenta o de cualquier manera con el fin de interferir con el uso de la Plataforma.</p>

<div class="f-18 f-700"> m. Plataformas de Terceros y enlaces a otros sitios web </div><br>

<p>Se le puede ofrecer servicios, productos y promociones proporcionados por terceros y no por nosotros. Si usted decide utilizar estos servicios de terceros, usted será responsable de revisar y comprender los términos y condiciones asociados a estos servicios. Usted acepta que no somos responsables de la realización de estos servicios. La página web Easy Dance puede contener enlaces a sitios web de terceros como una conveniencia para usted. La inclusión de cualquier enlace al sitio web sí implica una aprobación, respaldo, recomendación por nosotros. Usted acepta que el acceso a cualquier página web es bajo su propio riesgo, y que el sitio no se rige por los términos y condiciones contenidos en este Acuerdo. Renunciamos expresamente cualquier responsabilidad por estos sitios web. Por favor, recuerde que cuando usted utiliza un enlace para ir desde nuestro sitio web a otro sitio web, nuestra Política de Privacidad ya no está en vigor. Su navegación e interacción en cualquier otro sitio web, incluyendo los que tienen un enlace en nuestra página web, está sujeta a las propias reglas y políticas de ese sitio web. </p>

<div class="f-18 f-700"> n. Fuerza mayor </div><br>

<p>Ninguna de las partes será responsable de los retrasos en el procesamiento u otro incumplimiento causada por eventos tales como incendios, fallas de telecomunicaciones, fallas de servicios públicos, fallas eléctricas, fallas en los equipos, conflictos laborales, disturbios, guerras, no desempeño de nuestros proveedores o proveedores, causas de fuerza mayor u otras causas sobre las que la parte respectiva no tiene control razonable, excepto que nada en esta sección afectará o excusar sus responsabilidades, incluyendo sin limitación para las reclamaciones, multas, tasas, reembolsos o incumplida productos y servicios.</p>
</div>
              

                         </div>
                          <div class="col-md-1"></div>           
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