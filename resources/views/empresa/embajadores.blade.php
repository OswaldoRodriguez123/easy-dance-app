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
                
                    <div class="block-header">
                        <h4><i class="zmdi zmdi-share p-r-5"></i> Comparte <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Embajador </span></h4>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <img class="img-responsive p-b-10" src="{{url('/')}}/assets/img/embajadores_easy.png">
                                <div class="clearfix"></div>

                                    <div class="f-700 f-30 text-center">GANA 10 D??LARES MENSUALES POR ACADEMIA</div>
                                    <br>
                                    <p>Exclusivo para directores de academias de baile, Por cada director que acepte tu invitaci??n e inicie en la plataforma y genere su pago recurrente, el equipo de Easy dance te premiar?? con 20 d??lares de manera mensual,no olvides que entre m??s invites m??s ganas, de esta forma Easy Dance no s??lo contribuye como herramienta organizativa, pues tambi??n te ayuda a incrementar tu flujo de ganancia econ??mica.</p>
                                    <p><b>Nota:</b> No aplica para academias en Venezuela</p>



                                    <div class="row">
                                        <div class="col-xs-offset-3 col-xs-6 col-sm-3 col-sm-offset-3">
                                        <img src="{{url('/')}}/assets/img/porce.png" class="img-responsive" width="150">

                                        </div>
                                        <div class="col-xs-offset-3 col-xs-6 col-sm-offset-0 col-sm-3 ">
                                        <img src="{{url('/')}}/assets/img/dolares.png" class="img-responsive" width="150">

                                        </div>
                                    
                                    </div>
                                    <br>    
                                    <div class="f-700 f-30 text-center">???SI TE GUSTA EASY DANCE COMPARTE Y GANA???</div>
                                    <br>    
                                    <p>Adicionalmente por cada Director de academia que consigas que se sume a nuestra aplicaci??n, te obsequiaremos un mes gratis en EASY DANCE. Nuestro equipo buscar?? los directores m??s destacados y comprometidos, para que formen parte de los selectos EMBAJADORES, de esta forma podr??s recibir beneficios de primera l??nea de manera gratuita para tu academia y clientes.</p>

                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseConocerMas" aria-expanded="false" aria-controls="collapseConocerMas">
                                            Conocer M??s
                                        </button>
                                    </div>

                                    <div class="collapse m-t-10" id="collapseConocerMas">

                                        <div class="f-700 f-30 text-center">PROYECTO EMBAJADORES</div>
                                        <hr>
                                        <div class="text-justify">    
                                            <p>La estrategia del equipo de trabajo de Easy dance tiene como objetivo posicionar la aplicaci??n web como la herramienta organizativa y de procesos estandarizados c??mo la n??mero 1 de latino am??rica.</p>

                                            <p>En los a??os de experiencia y b??squeda de herramientas organizativas que ofrecieran soluciones a las m??ltiples funcionalidades que gestionamos en nuestra academia, no encontramos soluciones que se adaptar??n a nuestras necesidades, por tal motivo, y por lo antes mencionado en Easy dance, tenemos cuatro (4) objetivos claramente trazados que dirigir??n el baile a un nivel organizativo y de oportunidades que anteriormente no hubiese sido posible crearlas.</p>
                                        </div>

                                        <div class="f-22 f-500 text-center">Objetivos principales del plan de embajadores de Marca en Easy Dance</div>
                                        <br>
                                        <p>La estrategia del equipo de trabajo de Easy dance tiene como objetivo posicionar la aplicaci??n web como la herramienta organizativa y de procesos estandarizados c??mo la n??mero 1 de latino am??rica.</p>

                                        <p><i class="zmdi zmdi-check"></i> Expansi??n de la aplicaci??n en Latinoam??rica</p>

                                        <p><i class="zmdi zmdi-check"></i> Ser la herramienta que contribuya con la organizaci??n de todas las academias de baile en el continente latinoamericano.</p>

                                        <p><i class="zmdi zmdi-check"></i> Generar que la aplicaci??n contribuya como intermediaria de las m??ltiples gestiones y servicios que pudieran realizarse entre academias, clientes, bailarines y core??grafos.</p>

                                         <p><i class="zmdi zmdi-check"></i>Hacer de la aplicaci??n una fuente de educaci??n en el que los diversos directores, bailarines, instructores y core??grafos m??s destacados desarrollen cursos de bailes en conferencias a trav??s de webinar, tutoriales y otros.</p>

                                        <p>De esa forma por lo antes mencionado la organizaci??n pone a disposici??n el nuevo plan de crecimiento llamado EMBAJADORES y as?? estimular la expansi??n de la aplicaci??n, generando beneficios directo a todos aquellos postulados que sean parte de nuestro equipo de embajadores.</p>

                                        <div class="f-22 f-500 text-center">Resultado que aspiramos obtener</div>
                                        <br>
                                        <p>Hacer que la mayor cantidad de usuarios (directores de academias, instructores y clientes) logren unificarse a trav??s de la aplicaci??n, y que a su vez podamos generar la comunidad del baile m??s grande de Latinoam??rica.</p>

                                        <div class="f-18 f-200">Participantes</div>
                                        <br>
                                        <p>Podr??n iniciar todos aquellos directores de academias de baile mayores de dieciocho a??os de edad que deseen participar en el impulso, ganancia econ??mica y promoci??n de la aplicaci??n.</p>

                                        <div class="f-18 f-200">Beneficios</div>
                                        <br>
                                        <p>Todo participante disfrutar?? de m??ltiples beneficios, el cual , estar??n titulados de la siguiente manera.</p>


                                        <div class="f-22 f-500 text-center">Tipo de embajadores</div>
                                        <br>
                                        <div class="f-18 f-200">1. Embajador nivel de entrega</div>
                                        <br>
                                        <p>Es aquel embajador que se dispone a multiplicar la noticia y el uso de la aplicaci??n a trav??s de la secci??n de compartir, en el que por medio de la herramienta invita a colegas y amigos directores de academias de baile.</p>

                                        <div class="f-18 f-200">2. Embajador experto</div>
                                        <br>
                                        <p>Considerado como el embajador de mayor relevancia, por su condici??n, recibir?? mayores beneficios tanto econ??micos como de proyecci??n y privilegios dentro de la aplicaci??n.</p>


                                        <div class="f-22 f-500 text-center">Preguntas frecuentes</div>
                                        <br>
                                        <div class="f-18 f-200">??Que necesito para ser Embajador de entrega?</div>
                                        <br>    
                                        <p>S??lo necesitas invitar a las academias a participar en la aplicaci??n, y ya eso te convierte en un embajador de entrega, cada academia que active su cuenta gracias a la invitaci??n recibida de parte del embajador el sistema Easy Dance le sumar?? un punto de manera autom??tica.</p>

                                        <div class="f-18 f-200">??Qu?? beneficios tienen ser embajador de entrega?</div>
                                        <br>
                                        <p>Por cada punto que acumules en Easy Dance contar??s con el siguiente beneficio: por cada director de academia de baile que el embajador invite a participar y logre la conversi??n del invitado, el equipo Easy Dance premiar?? al embajador con la cantidad recurrente de veinte (20) d??lares mensuales, adicional a un mes completamente gratis en la aplicaci??n de la academia que representa.</p>


                                        <div class="f-18 f-200">??Que necesito para ser Embajador de nivel experto?</div>
                                        <br>
                                        <p>Tener el nivel experto no s??lo comprende cumplir con el alcance de los objetivos y las metas, sino que el embajador de marca debe alcanzar un nivel de evangelizaci??n del producto, siendo un defensor de la marca, contribuyendo en gran medida a su expansi??n y crecimiento. Adem??s Lograr la conversi??n mayor o igual a 12 academias de baile que usen de manera recurrente el servicio.</p>

                                        <div class="f-18 f-200">??Qu?? beneficios tienen ser embajador de experto?</div>
                                        <br>
                                        <p><b>1.</b> Exoneraci??n de la cuota mensual.</p>

                                        <p><b>2.</b> Inserci??n p??blica del nombre de la academia y director en el banner principal de la interfaz en Easy dance, en el que todos los clientes y usuarios tendr??n visualizaci??n del mismo, proyectando su academia y marca personal a miles de usuarios en general.</p>

                                        <p><b>3.</b> Entrega del plan Easy Gold.</p>

                                        <p><b>4.</b> Entrevista del perfil del director y academia, el cual, ser?? publicada en nuestro blog de noticias, que ser?? visualizado por todos los usuarios adscritos a la herramienta o todos aquellos que visiten nuestra p??gina web.</p>

                                        <p><b>5.</b> Plan de pago por academia de 25 d??lares de todas las academias que generen la conversi??n con la aplicaci??n.</p>

                                        <div class="f-18 f-200">??Desde cu??ndo mis puntos se convierten en v??lidos?</div>
                                        <br>
                                        <p>Los puntos se convierten en v??lidos desde que la aplicaci??n Easy Dance reciba el pago de la academia afiliada, de esa forma el equipo Easy Dance realizar?? la cancelaci??n mensual de la cantidad total acumulada por el embajador, de igual manera aplica para la exoneraci??n de la cuota mensual que se otorga como premio por academia.</p>

                                        <div class="f-18 f-200">??C??mo puedo iniciar?</div>
                                        <br>
                                        <p>Muy f??cil dir??gete al campo comparte ubicado en el men?? principal,ingresa el correo electr??nico de la academia de baile o director que invitar??s y pulsas el bot??n enviar, de esa forma ya has invitado a un amigo.</p>

                                        <p>Para mayor informaci??n vis??tanos a www.easydancelatino.com o puedes escribirnos a info@easydancelatino.com y nos comunicaremos contigo de manera inmediata.</p>

                                        <div class="text-center">
                                            <button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#collapseConocerMas" aria-expanded="false" aria-controls="collapseConocerMas">
                                                Menos
                                            </button>
                                        </div>
                                        <hr>
                                    </div>
                                    <br>
                                    <div class="f-700 f-30 text-center">"PARA RECOMENDARNOS, ES MUY SENCILLO"</div>
                                    <br>
                                    <p>Ingresa el correo electr??nico de tus amigos y colegas y con s??lo presionar el bot??n enviar, tus amigos recibir??n tu invitaci??n, al momento de que ellos ( los directores)activen su cuenta, la aplicaci??n Easy Dance, te enviar?? una notificaci??n inform??ndote que ya esa cuenta ha sido activada gracias a tu recomendaci??n.</p>
                                    <br>


                                    <form name="formComparte" id="formComparte" class="">
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <label>Ingresa su correo electr??nico </label>
                                            <div class="input-group input-group-lg">

                                                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                                <div class="fg-line">
                                                    <input class="form-control input-lg" name="email" id="email" placeholder="ej: info@easydancelatino.com" type="email" required="required">
                                                    <input type="hidden" value="" id="alm-email">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                          <button type="button" id="ingresar" class="btn bgm-morado m-t-30 waves-effect">Ingresar</button>
                                        </div>

                                    </form>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <div id="test" class="f-18 c-morado"></div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div><br>
                                    
                                    <hr>

                                    <div class="block-header">
                                        <a class="btn-blanco m-r-10 f-25" > Enviar <i class="zmdi zmdi-check"></i></a>
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