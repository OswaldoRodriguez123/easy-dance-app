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

                                    <div class="f-700 f-30 text-center">GANA 10 DÓLARES MENSUALES POR ACADEMIA</div>
                                    <br>
                                    <p>Exclusivo para directores de academias de baile, Por cada director que acepte tu invitación e inicie en la plataforma y genere su pago recurrente, el equipo de Easy dance te premiará con 20 dólares de manera mensual,no olvides que entre más invites más ganas, de esta forma Easy Dance no sólo contribuye como herramienta organizativa, pues también te ayuda a incrementar tu flujo de ganancia económica.</p>
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
                                    <div class="f-700 f-30 text-center">“SI TE GUSTA EASY DANCE COMPARTE Y GANA”</div>
                                    <br>    
                                    <p>Adicionalmente por cada Director de academia que consigas que se sume a nuestra aplicación, te obsequiaremos un mes gratis en EASY DANCE. Nuestro equipo buscará los directores más destacados y comprometidos, para que formen parte de los selectos EMBAJADORES, de esta forma podrás recibir beneficios de primera línea de manera gratuita para tu academia y clientes.</p>

                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseConocerMas" aria-expanded="false" aria-controls="collapseConocerMas">
                                            Conocer Más
                                        </button>
                                    </div>

                                    <div class="collapse m-t-10" id="collapseConocerMas">

                                        <div class="f-700 f-30 text-center">PROYECTO EMBAJADORES</div>
                                        <hr>
                                        <div class="text-justify">    
                                            <p>La estrategia del equipo de trabajo de Easy dance tiene como objetivo posicionar la aplicación web como la herramienta organizativa y de procesos estandarizados cómo la número 1 de latino américa.</p>

                                            <p>En los años de experiencia y búsqueda de herramientas organizativas que ofrecieran soluciones a las múltiples funcionalidades que gestionamos en nuestra academia, no encontramos soluciones que se adaptarán a nuestras necesidades, por tal motivo, y por lo antes mencionado en Easy dance, tenemos cuatro (4) objetivos claramente trazados que dirigirán el baile a un nivel organizativo y de oportunidades que anteriormente no hubiese sido posible crearlas.</p>
                                        </div>

                                        <div class="f-22 f-500 text-center">Objetivos principales del plan de embajadores de Marca en Easy Dance</div>
                                        <br>
                                        <p>La estrategia del equipo de trabajo de Easy dance tiene como objetivo posicionar la aplicación web como la herramienta organizativa y de procesos estandarizados cómo la número 1 de latino américa.</p>

                                        <p><i class="zmdi zmdi-check"></i> Expansión de la aplicación en Latinoamérica</p>

                                        <p><i class="zmdi zmdi-check"></i> Ser la herramienta que contribuya con la organización de todas las academias de baile en el continente latinoamericano.</p>

                                        <p><i class="zmdi zmdi-check"></i> Generar que la aplicación contribuya como intermediaria de las múltiples gestiones y servicios que pudieran realizarse entre academias, clientes, bailarines y coreógrafos.</p>

                                         <p><i class="zmdi zmdi-check"></i>Hacer de la aplicación una fuente de educación en el que los diversos directores, bailarines, instructores y coreógrafos más destacados desarrollen cursos de bailes en conferencias a través de webinar, tutoriales y otros.</p>

                                        <p>De esa forma por lo antes mencionado la organización pone a disposición el nuevo plan de crecimiento llamado EMBAJADORES y así estimular la expansión de la aplicación, generando beneficios directo a todos aquellos postulados que sean parte de nuestro equipo de embajadores.</p>

                                        <div class="f-22 f-500 text-center">Resultado que aspiramos obtener</div>
                                        <br>
                                        <p>Hacer que la mayor cantidad de usuarios (directores de academias, instructores y clientes) logren unificarse a través de la aplicación, y que a su vez podamos generar la comunidad del baile más grande de Latinoamérica.</p>

                                        <div class="f-18 f-200">Participantes</div>
                                        <br>
                                        <p>Podrán iniciar todos aquellos directores de academias de baile mayores de dieciocho años de edad que deseen participar en el impulso, ganancia económica y promoción de la aplicación.</p>

                                        <div class="f-18 f-200">Beneficios</div>
                                        <br>
                                        <p>Todo participante disfrutará de múltiples beneficios, el cual , estarán titulados de la siguiente manera.</p>


                                        <div class="f-22 f-500 text-center">Tipo de embajadores</div>
                                        <br>
                                        <div class="f-18 f-200">1. Embajador nivel de entrega</div>
                                        <br>
                                        <p>Es aquel embajador que se dispone a multiplicar la noticia y el uso de la aplicación a través de la sección de compartir, en el que por medio de la herramienta invita a colegas y amigos directores de academias de baile.</p>

                                        <div class="f-18 f-200">2. Embajador experto</div>
                                        <br>
                                        <p>Considerado como el embajador de mayor relevancia, por su condición, recibirá mayores beneficios tanto económicos como de proyección y privilegios dentro de la aplicación.</p>


                                        <div class="f-22 f-500 text-center">Preguntas frecuentes</div>
                                        <br>
                                        <div class="f-18 f-200">¿Que necesito para ser Embajador de entrega?</div>
                                        <br>    
                                        <p>Sólo necesitas invitar a las academias a participar en la aplicación, y ya eso te convierte en un embajador de entrega, cada academia que active su cuenta gracias a la invitación recibida de parte del embajador el sistema Easy Dance le sumará un punto de manera automática.</p>

                                        <div class="f-18 f-200">¿Qué beneficios tienen ser embajador de entrega?</div>
                                        <br>
                                        <p>Por cada punto que acumules en Easy Dance contarás con el siguiente beneficio: por cada director de academia de baile que el embajador invite a participar y logre la conversión del invitado, el equipo Easy Dance premiará al embajador con la cantidad recurrente de veinte (20) dólares mensuales, adicional a un mes completamente gratis en la aplicación de la academia que representa.</p>


                                        <div class="f-18 f-200">¿Que necesito para ser Embajador de nivel experto?</div>
                                        <br>
                                        <p>Tener el nivel experto no sólo comprende cumplir con el alcance de los objetivos y las metas, sino que el embajador de marca debe alcanzar un nivel de evangelización del producto, siendo un defensor de la marca, contribuyendo en gran medida a su expansión y crecimiento. Además Lograr la conversión mayor o igual a 12 academias de baile que usen de manera recurrente el servicio.</p>

                                        <div class="f-18 f-200">¿Qué beneficios tienen ser embajador de experto?</div>
                                        <br>
                                        <p><b>1.</b> Exoneración de la cuota mensual.</p>

                                        <p><b>2.</b> Inserción pública del nombre de la academia y director en el banner principal de la interfaz en Easy dance, en el que todos los clientes y usuarios tendrán visualización del mismo, proyectando su academia y marca personal a miles de usuarios en general.</p>

                                        <p><b>3.</b> Entrega del plan Easy Gold.</p>

                                        <p><b>4.</b> Entrevista del perfil del director y academia, el cual, será publicada en nuestro blog de noticias, que será visualizado por todos los usuarios adscritos a la herramienta o todos aquellos que visiten nuestra página web.</p>

                                        <p><b>5.</b> Plan de pago por academia de 25 dólares de todas las academias que generen la conversión con la aplicación.</p>

                                        <div class="f-18 f-200">¿Desde cuándo mis puntos se convierten en válidos?</div>
                                        <br>
                                        <p>Los puntos se convierten en válidos desde que la aplicación Easy Dance reciba el pago de la academia afiliada, de esa forma el equipo Easy Dance realizará la cancelación mensual de la cantidad total acumulada por el embajador, de igual manera aplica para la exoneración de la cuota mensual que se otorga como premio por academia.</p>

                                        <div class="f-18 f-200">¿Cómo puedo iniciar?</div>
                                        <br>
                                        <p>Muy fácil dirígete al campo comparte ubicado en el menú principal,ingresa el correo electrónico de la academia de baile o director que invitarás y pulsas el botón enviar, de esa forma ya has invitado a un amigo.</p>

                                        <p>Para mayor información visítanos a www.easydancelatino.com o puedes escribirnos a info@easydancelatino.com y nos comunicaremos contigo de manera inmediata.</p>

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
                                    <p>Ingresa el correo electrónico de tus amigos y colegas y con sólo presionar el botón enviar, tus amigos recibirán tu invitación, al momento de que ellos ( los directores)activen su cuenta, la aplicación Easy Dance, te enviará una notificación informándote que ya esa cuenta ha sido activada gracias a tu recomendación.</p>
                                    <br>


                                    <form name="formComparte" id="formComparte" class="">
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <label>Ingresa su correo electrónico </label>
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