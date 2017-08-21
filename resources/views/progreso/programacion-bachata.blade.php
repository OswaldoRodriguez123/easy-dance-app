@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/eosMenu.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/js/eosMenu.js"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
@stop
@section('content')

 <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"> <span id="nombre_modal">Nombre Video</span><button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12 m-b-20 text-center">                                   
                                  <iframe id="video_vimeo" src="https://player.vimeo.com/video/203096537" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>


                               <div class="clearfix"></div> 
                              
                          </div>
                           
                        </div>
                    
                    </div>
                </div>
            </div>

            <section id="content">
                <div class="container">
                
                    <div class="block-header">

                        <?php $url = "/progreso" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <div class="col-sm-4">
                                <span class="f-16 opaco-0-8" style="text-decoration: underline;">PASO A PASO</span>
                            </div>


                            <div class="col-sm-4">
                             
                            </div>


                             <div class="col-sm-4 text-right">
                                <a class="pointer mostrar f-16 text-success f-700">MOSTRAR TODOS LOS CICLOS</a>
                                <div class="clearfix"></div>
                                <a class="pointer ocultar f-16 text-success f-700">Ocultar todos los ciclos</a>

                                                    
                            </div>

                            <div class="clearfix"></div>
                       
                            <hr class="linea-morada">                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                            <div class="row">
                                <div class="container">

                                    <!-- NIVELACION 1 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/basico.jpg"></img>

                                     
                                        <div class="eos-menu" id="nivelacion_5">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">BACHATA TRADICIONAL</a>
                                            </li>
                                            <div class="eos-group-title">NIVEL 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961670">01. Ángulos Arriba

                                                  <!-- @if($usuario_tipo == 3)
                                                    <input id="n1v1" class="pull-right checkbox {{ empty($pasos['n1v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif -->

                                                </a> 
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961713">02. Ángulos Pa Alante

                                                 <!--  @if($usuario_tipo == 3)
                                                    <input id="n1v2" class="pull-right checkbox {{ empty($pasos['n1v2']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v2']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif -->

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961777">03. Ángulos Diagonal Alante

                                                  <!-- @if($usuario_tipo == 3)
                                                    <input id="n1v3" class="pull-right checkbox {{ empty($pasos['n1v3']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v3']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif -->

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="video_url" data-url="207961828">04. Ángulos Cruzados Alante

                                                  <!-- @if($usuario_tipo == 3)
                                                    <input id="n1v4" class="pull-right checkbox {{ empty($pasos['n1v4']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v4']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif -->

                                                </a>
                                              </li>
                                              <li class="eos-item">
                                                <a class="{{ empty($pasos['n1v5']) ? 'disabled' : 'video_url' }}" data-url="207961879">05. Ángulos Pa Atras

                                                  @if($usuario_tipo == 3)
                                                    <input id="n1v5" class="pull-right checkbox {{ empty($pasos['n1v5']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n1v5']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              


                                            </div>


                                            <div class="eos-group-title">NIVEL 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">

                                              <li class="eos-item">
                                                <a class="{{ empty($clase_1->clase_4) || empty($pasos['n2v1']) ? 'disabled' : 'video_url' }}" data-url="207962406">01. Danilo

                                                  @if($usuario_tipo == 3)
                                                    <input id="n2v1" class="pull-right checkbox {{ empty($pasos['n2v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n2v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              
                                            </div>

                                            <div class="eos-group-title">NIVEL 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_2->clase_4) || empty($pasos['n3v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. 7 70


                                                @if($usuario_tipo == 3)
                                                  <input id="n9v1" class="pull-right checkbox {{ empty($pasos['n9v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n3v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif


                                                </a>
                                              </li>
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                     <!-- NIVELACION 2 -->

                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/intermedio.jpg"></img>

                                        <div class="eos-menu" id="nivelacion_6">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">BACHATA DOMINICANA</a>
                                            </li>
                                            <div class="eos-group-title">NIVEL 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_3->clase_4) || empty($pasos['n4v1']) ? 'disabled' : 'video_url' }}" data-url="208049665">01. El Uno /Dame

                                                  @if($usuario_tipo == 3)
                                                    <input id="n4v1" class="pull-right checkbox {{ empty($pasos['n4v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n4v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                </a>
                                              </li>
                                              

                                            </div>

                                            <div class="eos-group-title">NIVEL 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                                <li class="eos-item">
                                                  <a class="{{ empty($clase_4->clase_4) || empty($pasos['n5v1']) ? 'disabled' : 'video_url' }}" data-url="208050687">01. Enchufa Con Palmas

                                                  @if($usuario_tipo == 3)
                                                    <input id="n5v1" class="pull-right checkbox {{ empty($pasos['n5v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n5v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                  @endif

                                                  </a>
                                                </li>
                                                
                                            </div>


                                            <div class="eos-group-title">NIVEL 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_5->clase_4) || empty($pasos['n6v1']) ? 'disabled' : 'video_url' }}" data-url="208214885">01. Abrázala

                                                @if($usuario_tipo == 3)
                                                  <input id="n6v1" class="pull-right checkbox {{ empty($pasos['n6v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n6v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>


                                    <!-- NIVELACION 3 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/avanzado.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_7">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">KIZOMBA</a>
                                            </li>
                                            <div class="eos-group-title">NIVEL 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_4->clase_4) ? 'disabled' : 'video_url' }}" data-url="208216522">11. 73</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_6->clase_4) || empty($pasos['n7v1'])? 'disabled' : 'video_url' }}" data-url="208216684">01. Cepillao

                                                @if($usuario_tipo == 3)
                                                  <input id="n7v1" class="pull-right checkbox {{ empty($pasos['n7v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n7v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                             

                                            </div>

                                            <div class="eos-group-title">NIVEL 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_7->clase_4) || empty($pasos['n8v1']) ? 'disabled' : 'video_url' }}" data-url="208218918">01. Coca Cola Por Detrás

                                                @if($usuario_tipo == 3)
                                                  <input id="n8v1" class="pull-right checkbox {{ empty($pasos['n8v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n8v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              
                                            </div>

                                            <div class="eos-group-title">NIVEL 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) || empty($pasos['n9v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. 7 70


                                                @if($usuario_tipo == 3)
                                                  <input id="n9v1" class="pull-right checkbox {{ empty($pasos['n9v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n9v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif


                                                </a>
                                              </li>
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- NIVELACION 4 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/master.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_8">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">BACHATA COMERCIAL</a>
                                            </li>
                                            <div class="eos-group-title">NIVEL 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content"> 
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">06. Tormenta</a>
                                              </li> -->
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_9->clase_4) || empty($pasos['n10v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Consorte

                                                @if($usuario_tipo == 3)
                                                  <input id="n10v1" class="pull-right checkbox {{ empty($pasos['n10v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n10v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              <!-- <li class="eos-item">
                                                <a class="{{ empty($clase_8->clase_4) ? 'disabled' : 'video_url' }}" data-url="203096537">08. El Bebé</a>
                                              </li> -->
                                              
                                            </div>

                                            <div class="eos-group-title">NIVEL 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_10->clase_4) || empty($pasos['n11v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Sombrero de Magni

                                                @if($usuario_tipo == 3)
                                                  <input id="n11v1" class="pull-right checkbox {{ empty($pasos['n11v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n11v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              
                                    
                                            </div>

                                            <div class="eos-group-title">NIVEL 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              <li class="eos-item">
                                                <a class="{{ empty($clase_11->clase_4) || empty($pasos['n12v1']) ? 'disabled' : 'video_url' }}" data-url="203096537">01. Rubenada Complicada

                                                @if($usuario_tipo == 3)
                                                  <input id="n12v1" class="pull-right checkbox {{ empty($pasos['n12v1']) ? 'unchecked' : 'checked' }}" {{ empty($pasos['n12v1']) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                @endif

                                                </a>
                                              </li>
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                 
                                <br><br><br>
                            
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@stop

@section('js') 
            
  <script type="text/javascript">

    route_update="{{url('/')}}/programacion/update/paso";

    $(document).ready(function(){

      $("#nivelacion_5").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_6").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_7").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $("#nivelacion_8").eosMenu({
        fontSize : '14px',
        height: '40px',
        lineHeight: '40px',
        isAutoUrl: 1,
        defaultUrl: '#html',
        zIndex: 10,
        onItemClick: null,
        onMenuTitleClick: null,
        onGroupTitleClick: null,
      });

      $( ".eos-item" ).addClass( "detalle_oscuro" );

      @if($usuario_tipo != 3)

        $('.disabled').attr('data-trigger','hover');
        $('.disabled').attr('data-toggle','popover');
        $('.disabled').attr('data-placement','right');
        $('.disabled').attr('data-content','<p class="c-negro">Aún no posees la credencial para ver este vídeo</p>');
        $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
        $('.disabled').attr('data-html','true');
        $('.disabled').attr('title','');

        $('[data-toggle="popover"]').popover(); 
      @endif

      $('.ciclo').addClass('disabled');

    });

    var vi_player = new Vimeo.Player('video_vimeo');
    
    $('.eos-item').click(function(e) {

      target = $(e.target)

      if(target.hasClass('checkbox')){
        if(target.hasClass('checked')){
          target.removeClass('checked')
          target.addClass('unchecked')
          target.val('0');
        }else{
          target.val('1');
          target.removeClass('unchecked')
          target.addClass('checked')
        }

        $.ajax({
          url: route_update,
          headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
          type: 'POST',
          dataType: 'json',
          data:"&clase_grupal_id={{$id}}&id="+target.attr('id')+"&valor="+target.val(),              
          success: function (data) {
            if(data.status=='OK'){
              console.log('success');
            }else{
              console.log('error');
            }
          },
          error:function (xhr, ajaxOptions, thrownError){
            console.log('error');
          }
        })

      }else if(target.hasClass('video_url')){

        video_id = target.data('url');
        titulo = target.text()

        vi_player.loadVideo(video_id).then(function(id) {

        }).catch(function(error) {
            console.log('vi error', error.name);
        });

        $('#nombre_modal').text(titulo)

        $('#modalVideo').modal('show');
      }
    });

    $(".eos-group-title").click(function(e) {

      e.preventDefault();

      var icono = $(this).children('i');

      if($(icono).hasClass('glyphicon-plus'))
      {
        $(icono).removeClass('glyphicon-plus')
        $(icono).addClass('glyphicon-minus')
      }else{
        $(icono).removeClass('glyphicon-minus')
        $(icono).addClass('glyphicon-plus')
      }

    });

    $('#modalVideo').on('hidden.bs.modal', function () {

      vi_player.pause()

    });

    $(".mostrar").click(function(e) {

      $('.eos-menu-content').css('height','1360px')
      $('.eos-group-content').css('height','400px')

      $(".glyphicon").removeClass('glyphicon-plus')
      $(".glyphicon").addClass('glyphicon-minus')

    });

    $(".ocultar").click(function(e) {

      $('.eos-menu-content').css('height','160px')
      $('.eos-group-content').css('height','0px')

      $(".glyphicon").removeClass('glyphicon-minus')
      $(".glyphicon").addClass('glyphicon-plus')
      
    });
      
   </script>

@stop