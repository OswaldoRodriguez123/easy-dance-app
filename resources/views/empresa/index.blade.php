@extends('layout.master4')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">

@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>

<script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

@section('content')

<!-- <div class="container"> -->
<!-- 
    @if(isset($_SERVER['HTTP_REFERER']))


        <div class="block-header" style="padding-top: 5%; padding-bottom: 5%; background-color: #fff; margin-bottom:0">

             <a class="btn-blanco m-r-10 f-16" href="{{$_SERVER['HTTP_REFERER']}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i>Volver</a>
             <br>
        </div> 

    @endif -->

    <div class="card" id="profile-main" style="margin-bottom: 0px">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        <img class="img-responsive" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                    </a>

                </div>

            </div>

            <div class="pmo-block pmo-contact hidden-xs">
                <h2>Contacto</h2>

                <ul>
                    <li><i class="zmdi zmdi-email"></i> info@easydancelatino.com</li>
                    <li><i class="zmdi zmdi-facebook-box"></i> Easydancelatino</li>
                    <li><i class="zmdi zmdi-twitter"></i> EasyDanceLatino</li>
                    <li>
                        <i class="zmdi zmdi-pin"></i>
                        <address class="m-b-0 ng-binding">
                            Centro Comercial Salto Ángel, <br>
                            en la avenida 3 Y – entre la <br> calle 78 y 79 <br>
                            Maracaibo, Venezuela <br>
                        </address>
                    </li>
                </ul>
                <img class="img-responsive p-t-10" src="{{url('/')}}/assets/img/maracaibo.jpg">

                <div class="embed-responsive embed-responsive-4by3 m-t-20 p-t-20">
                <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1960.447821977337!2d-71.60560501363508!3d10.665207673161563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e8998e8cf7201ff%3A0xc730a94a91c6f7f2!2sCentro+Comercial+Salto+Angel%2C+Avenida+3Y%2C+Maracaibo!5e0!3m2!1ses-419!2sve!4v1456871046860" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                </div>
            </div>

        </div>

        <div class="pm-body clearfix" id="id-tabs">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <!-- <ul class="tab-nav tn-justified efecto-hover" role="tablist">
                <li class="active waves-effect"><a id ="tab_empresa" href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab">Empresa</a></li>
                <li class="waves-effect"><a id ="tab_nosotros" href="#nuestro-equipo" aria-controls="nuestro-equipo" role="tab" data-toggle="tab">Nuestro Equipo</a></li>
                <li class="waves-effect"><a id ="tab_faqs" href="#faqs" aria-controls="faqs" role="tab" data-toggle="tab">FAQs</a></li>

            </ul> -->
            
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">

                        <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/caracteristicas-principal.jpg">

                        <div class="f-700 f-30" id="offset_empresa">Empresa</div>
                        <hr class="linea-morada">

                        <p class="f-14">Easy dance llega con el objetivo resolver los problemas organizativos, que surgen a través de las múltiples características específicas en el ecosistema del baile , tales como , clases grupales y privadas , show de las compañías de baile , eventos de exhibición y competencia , graduaciones, inscripción , reserva y compra en línea ,presupuesto de montajes coreográficos ,entre otras actividades, que impactan en gran medida a nuestros gremio , que se ve afectado por la falta de herramientas organizacional .</p>

                        <div class="f-700 f-30">Misión</div>
                         <hr class="linea-morada">
                        <p class="f-14">Hacer del ecosistema del baile un mejor lugar, más organizado y transparente a nivel global, aprovechando el uso de la tecnología para brindar en gran medida valor a los usuarios, directores de academia, bailarines e instructores.</p>

                        <div class="f-700 f-30">Visión</div>
                         <hr class="linea-morada">
                        <p class="f-14">Easy dance trazará una nueva forma y estilo a nivel internacional, todos conectados en una gran comunidad, vemos a cientos de miles de persona compartiendo a través de la aplicación.</p>
                        <hr>
                        <div class="f-700 f-30">Resumen</div>
                        <hr class="linea-morada">
                        <p class="f-14">Easy Dance es una aplicación Online dirigida a la gestión de las academias de baile, con el propósito de organizar las actividades que involucran a: Directores de academias, instructores de baile, alumnos y todas aquellas personas interesadas en aprender a bailar de una manera más fácil. La aplicación se encuentra en una etapa temprana, hemos lanzado al mercado la primera fase del proyecto, en el que pondremos a prueba la adaptabilidad del mercado con el uso de las nuevas tecnologías. Nuestro equipo se encuentra laborando arduamente para ir incrementando las características de manera periódica y de ese modo ir creando de la aplicación una herramienta más completa que contribuya de manera sustancial con el ecosistema del baile.</p>

                        <p class="f-14">Easy dance se encuentra en un proceso de periodo de prueba (Fase Beta) completamente abierta para cualquier academia de baile que desee integrarse, haciendo uso y prueba de nuestro proyecto piloto. Por tal motivo invitamos a toda la comunidad de baile a participar generando invitaciones a todas aquellas academias que aún no conocen la herramienta.</p>

                        <p class="f-14">Así que los invitamos a estar muy atentos de todos nuestros avances, semanalmente estaremos haciendo nuevos anuncios de todas las características que se estarán actualizando dentro de la plataforma para el disfrute y organización en el ambiente del baile.</p>

                    </div>

                </div>

                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="nuestro-equipo">

                    <div class="pmb-block m-t-0 p-t-0">

                        <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/nosotros.jpg">

                        <div class="f-700 f-30" id="offset_nosotros">Nuestro Equipo</div>
                        <hr class="linea-morada">



                            <div class="timeline">
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <img class="img-responsive" src="{{url('/')}}/assets/img/profile-pics/robert.png" alt="">
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block">Robert Virona</strong>
                                            <small class="c-gray">Fundador CEO</small>
                                        </div>
                                        

                                    </div>
                                    <div class="tv-body">
                                        <p>Con 20 años de experiencia en el gremio del baile, primero como bailador, luego como profesor y hoy día como director de academia, organizador de eventos y asesor en temas gerenciales, se ha apasionado en generar un producto que brinde soluciones a escala global a la mayor cantidad de personas que sea posible en todo el ecosistema danzario y bailes social,generando un alto contenido de valor ,haciendo la vida de las personas más sencilla, práctica y organizada.</p>
                                    
                                        <p>Vive en Maracaibo – Venezuela.</p>
                                    
                                        <div class="clearfix"></div>
                                    
                                        <a href="https://www.facebook.com/profile.php?id=100010495963282&amp;ref=bookmarks" target="_blank">
                                        <i class="zmdi zmdi-facebook-box f-22"></i>
                                        </a>

                                        <a href="https://www.linkedin.com/in/robert-virona-gonzalez-885a6a68" target="_blank">
                                        <i class="zmdi zmdi-linkedin-box f-22"></i>
                                        </a>

                                    </div>

                                </div>
                                
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <img class="img-responsive" src="{{url('/')}}/assets/img/profile-pics/oswaldo.jpg" alt="">
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block">Oswaldo Rodriguez</strong>
                                            <small class="c-gray">Cargo</small>
                                        </div>
                                        
                                    </div>
                                    <div class="tv-body">

                                        <p>Es ingeniero en informática, es una pieza fundamental en el equipo Easy Dance, debido a sus capacidades de adaptación con las nuevas tecnologías, es reconocido por su alta velocidad en la ejecución de códigos, aporta al equipo energía, celeridad y adaptabilidad.</p>

                                        <p>Vive en Maracaibo - Venezuela.</p>
                                                                        
                                        <div class="clearfix"></div>
                                        

                                       

                                        <a href=" https://www.facebook.com/oswaldorodriguez20" target="_blank">
                                        <i class="zmdi zmdi-facebook-box f-22"></i>
                                        </a>

                                        <a href="https://ve.linkedin.com/in/oswaldorodriguez20" target="_blank">
                                        <i class="zmdi zmdi-linkedin-box f-22"></i>
                                        </a>


                                    </div>

                                </div>
                                
                               <!--  <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <img class="img-responsive" src="{{url('/')}}/assets/img/profile-pics/henry_fuenmayor.png" alt="">
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block">Henry Fuenmayor</strong>
                                            <small class="c-gray">Relaciones públicas</small>
                                        </div>
                                        
                                    </div>
                                    <div class="tv-body">
                                       
                                        <p>Henry se encuentra muy involucrado con el proyecto Easy dance, con más de 10 años de experiencia como director de academia de baile , ha brindado grandes aportes con sus conocimientos en la materia , su función principal es dar a conocer el producto a la mayor cantidad de directores de academias que sea posible , dándoles las herramientas necesarias para que puedan aprovechar al máximo el uso de la aplicación.</p>

                                        <p>Vive en Pereira –Colombia.</p>
                                                                        
                                        <div class="clearfix"></div>
                                    
                                        <a href="https://www.facebook.com/profile.php?id=100010485076620" target="_blank">
                                        <i class="zmdi zmdi-facebook-box f-22"></i>
                                        </a>

                                    </div>

                                </div> -->
                                
                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <img class="img-responsive" src="{{url('/')}}/assets/img/profile-pics/alejandro.jpg" alt="">
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block">Alejandro Garcia</strong>
                                            <small class="c-gray">Desarrollador Web - diseño de interfaces</small>
                                        </div>

                                    </div>
                                    <div class="tv-body">
                                        
                                        <p><!-- Es ingeniero en sistema con un excelente manejo en el desarrollo de interfaces con el uso y aprovechamiento de las altas tecnologías, él es el responsable de crear el diseño del software, Alejandro tiene un alto nivel como desarrollador , tiene más de 10 años de experiencia , siempre se encuentra en la búsqueda de nuevos aprendizaje. -->
                                        Es ingeniero, con más de 10 años de experiencia en el área de programación web, es el CTO de Easy Dance, orienta al equipo a la toma de decisiones y el uso adecuado de las tecnologías, sus conocimientos enrutan a Easy Dance por el camino del éxito.
                                        </p>

                                        <p>Vive en San Francisco - Venezuela.</p>
                                                                        
                                        <div class="clearfix"></div>
                                    
                                        <a href="https://www.facebook.com/Programador-Web-Php-Mysql-Javascript-etc-188486624557495" target="_blank">
                                        <i class="zmdi zmdi-facebook-box f-22"></i>
                                        </a>

                                        <a href="https://twitter.com/aleprog" target="_blank">
                                        <i class="zmdi zmdi-linkedin-box f-22"></i>
                                        </a>

                                    </div>

                                </div>
                            
                                <div class="clearfix"></div>

                                <div class="t-view" data-tv-type="text">
                                    <div class="tv-header media">
                                        <a href="" class="tvh-user pull-left">
                                            <img class="img-responsive" src="{{url('/')}}/assets/img/profile-pics/foto-david.jpg" alt="">
                                        </a>
                                        <div class="media-body p-t-5">
                                            <strong class="d-block">David Acurero</strong>
                                            <small class="c-gray">Cargo</small>
                                        </div>

                                    </div>
                                    <div class="tv-body">
                                        
                                        <p>Es programador con alta experiencia en el área web, es T.S.U. en informática. Se caracteriza por contar con un alto nivel de desarrollo, domina una alta gama de herramientas tecnológicas aportándole un alto nivel de contenido al crecimiento de la aplicación, se especializa en el diseño y la lógica del sistema.</p>

                                        <p>Vive en Maracaibo - Venezuela.</p>
                                                                        
                                        <div class="clearfix"></div>
                                    
                                        <a href="https://www.facebook.com/Programador-Web-Php-Mysql-Javascript-etc-188486624557495" target="_blank">
                                        <i class="zmdi zmdi-facebook-box f-22"></i>
                                        </a>

                                        <a href="https://twitter.com/aleprog" target="_blank">
                                        <i class="zmdi zmdi-linkedin-box f-22"></i>
                                        </a>

                                    </div>

                                </div>
                            

                            </div>



                    </div>
                    
                </div>


                <div role="tabpanel" class="tab-pane animated fadeInUp in" id="faqs">

                    <div class="pmb-block m-t-0 p-t-0">

                        <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/preguntas-frecuentes.jpg">


                        <div class="f-700 f-30 text-center" id="offset_faqs">Preguntas Frecuentes</div>
                        <br>
                        <div class="f-700 f-30">Generales</div>
                        <hr class="linea-morada">
                        <!--<div class="f-500 f-20">1. ¿Qué es Easy dance?</div>-->
                        <br>


                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <div class="f-500 f-20">1. ¿Qué es Easy dance?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        Easy Dance, es la aplicación para el gremio del baile ( alumnos, instructores, bailarines y directores de academias) que realiza el trabajo organizativo, informativo y de estadísticas en tiempo real, haciendo la vida de las personas más sencilla.
                                    </div>
                                </div>
                            </div>

                        <!--<p>Easy Dance, es la aplicación para el gremio del baile ( alumnos, instructores, bailarines y directores de academias) que realiza el trabajo organizativo, informativo y de estadísticas en tiempo real, haciendo la vida de las personas más sencilla.</p>-->

                        <!--<div class="f-500 f-20">2. ¿Qué necesito para usar Easy dance?</div>
                        <br>
                        <p>Lo único que necesitas para dar inicio es una computadora y una conexión a internet.</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="f-500 f-20">2. ¿Qué necesito para usar Easy dance?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        Lo único que necesitas para dar inicio es una computadora y una conexión a internet.
                                    </div>
                                </div>
                            </div>                        

                        <!--<div class="f-500 f-20">3. ¿Cuánto cuesta Easy dance?</div>
                        <br>
                        <p>Para los alumnos, instructores y bailarines es completamente gratis, para los directores de academias de baile, tendrán su primer mes de uso gratuito, si desean profundizar en los precios le invitamos a ver nuestras tarifas</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <div class="f-500 f-20">3. ¿Cuánto cuesta Easy dance?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        Para los alumnos, instructores y bailarines es completamente gratis, para los directores de academias de baile, tendrán su primer mes de uso gratuito, si desean profundizar en los precios le invitamos a ver nuestras tarifas
                                    </div>
                                </div>
                            </div>                        

                        <!--<div class="f-500 f-20">4. ¿Por qué Easy dance no está en mi país?</div>
                        <br>
                        <p>Somos una start –up (empresa) en una etapa de inicio, estamos trabajando de manera consecuente y comprometida para expandirnos rápidamente por diversos países.</p>-->


                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <div class="f-500 f-20">4. ¿Por qué Easy dance no está en mi país?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour">
                                    <div class="panel-body">
                                        Somos una start –up (empresa) en una etapa de inicio, estamos trabajando de manera consecuente y comprometida para expandirnos rápidamente por diversos países.
                                    </div>
                                </div>
                            </div>

                        <!--<div class="f-500 f-20">5. En mi academia no usan Easy dance, ¿de igual manera puedo registrarme?</div>
                        <br>
                        <p>Por ahora todos nuestros usuarios deberán estar adscritos a una academia en particular, si estás en una academia y no usan Easy Dance, ve y cuéntales que ya existe una manera inteligente para bailar.</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <div class="f-500 f-20">5. En mi academia no usan Easy dance, ¿de igual manera puedo registrarme?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingFive">
                                    <div class="panel-body">
                                        Por ahora todos nuestros usuarios deberán estar adscritos a una academia en particular, si estás en una academia y no usan Easy Dance, ve y cuéntales que ya existe una manera inteligente para bailar.
                                    </div>
                                </div>
                            </div>

                        <!--<div class="f-500 f-20">6. ¿Quién está detrás de Easy dance?</div>
                        <br>
                        <p>Somos un equipo muy comprometido con el éxito de nuestros clientes, te invitamos a conocernos, equipo de trabajo</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingSix">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <div class="f-500 f-20">6. ¿Quién está detrás de Easy dance?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="collapse" role="tabpanel" aria-labelledby="headingSix">
                                    <div class="panel-body">
                                        Somos un equipo muy comprometido con el éxito de nuestros clientes, te invitamos a conocernos, equipo de trabajo
                                    </div>
                                </div>
                            </div>

                        <!--<div class="f-500 f-20">7. ¿Están contratando personal?</div>
                        <br>
                        <p>Nos apasiona trabajar con personas talentosas y que les guste el trabajo duro, que estén dispuestos a cambiar al mundo, si tú eres uno de esos, envíanos tu CV a info@easydancelatino.com</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingSeven">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                            <div class="f-500 f-20">7. ¿Están contratando personal?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="collapse" role="tabpanel" aria-labelledby="headingSeven">
                                    <div class="panel-body">
                                        Nos apasiona trabajar con personas talentosas y que les guste el trabajo duro, que estén dispuestos a cambiar al mundo, si tú eres uno de esos, envíanos tu CV a info@easydancelatino.com
                                    </div>
                                </div>
                            </div>

                        <div class="f-700 f-30">Directores</div>
                        <hr class="linea-morada">
                        <!--<div class="f-500 f-20">8. Soy director de una academia y deseo registrarme?</div>
                        <br>
                        <p>Para registrarte es muy sencillo, sólo debes llenar el formulario on line con los datos de tu academia y de esa forma podrás ingresar, te invitamos a conocernos regístrate</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingEigth">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseEigth" aria-expanded="false" aria-controls="collapseEigth">
                                            <div class="f-500 f-20">8. Soy director de una academia y deseo registrarme?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseEigth" class="collapse" role="tabpanel" aria-labelledby="headingEigth">
                                    <div class="panel-body">
                                        Para registrarte es muy sencillo, sólo debes llenar el formulario on line con los datos de tu academia y de esa forma podrás ingresar, te invitamos a conocernos regístrate
                                    </div>
                                </div>
                            </div>

                        <!--<div class="f-500 f-20">9. ¿Cómo obtengo un mes de prueba gratis?</div>
                        <br>
                        <p>Nuestro software te brinda un mes de prueba sin costo alguno.</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingNine">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                            <div class="f-500 f-20">9. ¿Cómo obtengo un mes de prueba gratis?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseNine" class="collapse" role="tabpanel" aria-labelledby="headingNine">
                                    <div class="panel-body">
                                        Nuestro software te brinda un mes de prueba sin costo alguno.
                                    </div>
                                </div>
                            </div>

                        <!--<div class="f-500 f-20">10. ¿Tengo que comprometerme con un contrato?</div>
                        <br>
                        <p>No. En Easy Dance no hay contrato, podrás entrar y salir cuando lo creas necesario.</p>-->

                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="headingTen">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                            <div class="f-500 f-20">10. ¿Tengo que comprometerme con un contrato?</div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTen" class="collapse" role="tabpanel" aria-labelledby="headingTen">
                                    <div class="panel-body">
                                        No. En Easy Dance no hay contrato, podrás entrar y salir cuando lo creas necesario.
                                    </div>
                                </div>
                            </div>

                        
                    </div>

                </div>

                    <ul class="fw-footer pagination wizard">
                        <!--<li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                        <li class="previous"><a class="a-prevent" href="" onclick="irArriba('tabs')"><i class="zmdi zmdi-arrow-back"></i></a></li>
                        <li class="next"><a class="a-prevent" href="" onclick="irArriba('tabs')"><i class="zmdi zmdi-arrow-forward"></i></a></li>
                        <!--<li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>-->
                    </ul>

            </div> <!-- Tab Content -->
            </div>
            </div><!-- Tab Nav end -->

            <!--<data ui-view></data>-->
        </div>
    </div>
<!-- </div> -->




@stop

@section('js') 

        <!-- Following is only for demo purpose. You may ignore this when you implement -->
        <script type="text/javascript">

        $("#navbar li a").click(function(event) {
            $('.navbar-collapse').collapse('hide');
        });
        

        $('#tab_empresa').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_empresa").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_nosotros').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_nosotros").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_faqs').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_faqs").offset().top-90,
                }, 1000);

          }, 1000);
        })
            function irArriba(elemento){
                $('html,body').animate({
                        scrollTop: $("#id-"+elemento).offset().top-90,
                }, 300); 
            }
        </script>
@stop        