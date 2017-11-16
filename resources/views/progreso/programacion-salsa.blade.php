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
                                  <div class="embed-responsive embed-responsive-4by3" name="video_promocional_frame" id="video_promocional_frame">
                                    <iframe name="video_promocional" id="video_promocional" class="embed-responsive-item" src=""></iframe>
                                  </div>
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
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/1.jpg"></img>

                                     
                                        <div class="eos-menu" id="nivelacion_1">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 1</a>
                                            </li>
                                            <div class="eos-group-title">BÁSICO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 1 && $paso->ciclo == 1)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                            </div>


                                            <div class="eos-group-title">BÁSICO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">

                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 1 && $paso->ciclo == 2)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_1->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>
 

                                            <div class="eos-group-title">BÁSICO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 1 && $paso->ciclo == 3)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_2->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                     <!-- NIVELACION 2 -->

                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/2.jpg"></img>

                                        <div class="eos-menu" id="nivelacion_2">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 2</a>
                                            </li>
                                            <div class="eos-group-title">INTERMEDIO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 2 && $paso->ciclo == 1)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_3->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              

                                            </div>

                                            <div class="eos-group-title">INTERMEDIO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                                @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 2 && $paso->ciclo == 2)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_4->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                                
                                            </div>


                                            <div class="eos-group-title">INTERMEDIO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 2 && $paso->ciclo == 3)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_5->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>


                                    <!-- NIVELACION 3 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/3.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_3">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 3</a>
                                            </li>
                                            <div class="eos-group-title">AVANZADO 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 3 && $paso->ciclo == 1)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_6->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                             
                                            </div>

                                            <div class="eos-group-title">AVANZADO 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 3 && $paso->ciclo == 2)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_7->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>

                                            <div class="eos-group-title">AVANZADO 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 3 && $paso->ciclo == 3)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_8->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- NIVELACION 4 -->
                                    
                                    <div class="col-sm-3">
                                    <img class="img-responsive" src="{{url('/')}}/assets/img/certificados/4.jpg"></img>
                                        <div class="eos-menu" id="nivelacion_4">
                                          <div class="eos-menu-title">Welcome To eosMenu</div>
                                          <div class="eos-menu-content">
                                            <li class="eos-item text-center">
                                              <a class="ciclo">CICLO 4</a>
                                            </li>
                                            <div class="eos-group-title">MASTER 1 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content"> 
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 4 && $paso->ciclo == 1)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_9->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                            </div>

                                            <div class="eos-group-title">MASTER 2 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 4 && $paso->ciclo == 2)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_10->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
                                    
                                            </div>

                                            <div class="eos-group-title">MASTER 3 <i class="glyphicon glyphicon-plus pull-right f-12" style="padding-top: 6%"></i></div>
                                            <div class="eos-group-content">
                                              @foreach($pasos as $paso)
                                                @if($paso->nivel_id == 4 && $paso->ciclo == 3)
                                                  <li class="eos-item">
                                                    <a class="{{ empty($clase_11->clase_4) || empty($permisos[$paso->id]) ? 'disabled' : 'video_url' }}" data-url="{{$paso->link_video}}">{{$paso->nombre}}

                                                      @if($usuario_tipo == 3)
                                                        <input id="{{$paso->id}}" class="pull-right checkbox {{ empty($permisos[$paso->id]) ? 'unchecked' : 'checked' }}" {{ empty($permisos[$paso->id]) ? '' : 'checked="checked"' }} style="width: 10%; margin-top: 6%" type="checkbox">
                                                      @endif

                                                    </a>
                                                  </li>
                                                @endif
                                              @endforeach
                                              
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

      $("#nivelacion_1").eosMenu({
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

      $("#nivelacion_2").eosMenu({
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

      $("#nivelacion_3").eosMenu({
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

      $("#nivelacion_4").eosMenu({
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

        // $('.disabled').attr('data-trigger','hover');
        // $('.disabled').attr('data-toggle','popover');
        // $('.disabled').attr('data-placement','right');
        // $('.disabled').attr('data-content','<p class="c-negro">Aún no posees la credencial para ver este vídeo</p>');
        // $('.disabled').attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;');
        // $('.disabled').attr('data-html','true');
        // $('.disabled').attr('title','');

        // $('[data-toggle="popover"]').popover(); 

        $('.disabled').addClass('video_url');
        $('.video_url').removeClass('disabled')
      @endif

      $('.ciclo').addClass('disabled');

    });
    
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

        url = target.data('url');
        console.log(url)
        titulo = target.text()

        var link_video = youtube_parser(url)

        $("#video_promocional").attr('src', "http://www.youtube.com/embed/"+link_video);

        $('#nombre_modal').text(titulo)

        $('#modalVideo').modal('show');
      }
    });

    function youtube_parser(url){
      var regExp = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
      var match = url.match(regExp);
      if (match && match[1].length == 11) {
        return match[1];
      } else {
        console.log('error')
      }
    }

    $('#modalVideo').on('hidden.bs.modal', function () {

      $("#modalVideo iframe").attr("src", $("#modalVideo iframe").attr("src"));

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