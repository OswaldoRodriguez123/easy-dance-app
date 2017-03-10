@extends('layout.master5')

@section('css_vendor')
  <link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
  <link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('/')}}/assets/css/rrssb.css" />
  <link href="{{url('/')}}/assets/css/soon.min.css" rel="stylesheet"/>
@stop

@section('js_vendor')
  <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
  <script src="{{url('/')}}/assets/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
@stop

<meta content='{{$fiesta->nombre}}' property='og:title'/>
@if($fiesta->imagen)
  <meta content="{{url('/')}}/assets/uploads/fiesta/{{$fiesta->imagen}}" property='og:image'/>
@endif

@section('content')


<div style="padding:0 ; background: url('{{url('/')}}/assets/uploads/fiesta/{{$fiesta->imagen}}');  height: 0;
    padding-bottom: 35%; background-repeat: no-repeat; background-size: cover; background-position: center;" ></div>

    <div class="clearfix"></div>

    <div class="card" id="profile-main" style="margin-bottom: 0px">
        <div class="pm-overview c-overflow">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="">
                        @if($academia->imagen)
                          <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/uploads/academia/{{$academia->imagen}}" alt="">
                        @else
                          <img class="img-responsive opaco-0-8" src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" alt="">
                        @endif
                    </a>

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>

                    <p class="text-center f-700" >Compartir en</p>

                    <ul class="rrssb-buttons clearfix">

                      <li class="rrssb-facebook">
                        <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header: https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/agendar/fiesta/progreso/{{$id}}" class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg></span>
                          <span class="rrssb-text">facebook</span>
                        </a>
                      </li>

                      <li class="rrssb-twitter">
                        <!-- Replace href with your Meta and URL information  -->
                        <a href="https://twitter.com/intent/tweet?text=Participa en la fiesta {{$fiesta->nombre}} te invita @EasyDanceLatino {{url('/')}}/agendar/fiesta/progreso/{{$id}}"
                        class="popup">
                          <span class="rrssb-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg></span>
                          <span class="rrssb-text">twitter</span>
                        </a>
                      </li>
                    </ul>

                </div>

            </div>

            <div class="pmo-block pmo-contact hidden-xs" style="padding-top:15px">
                            
              <div class="text-center f-700" >Tiempo restante para la fiesta</div>
              <hr class="linea-morada opaco-0-8">

                <style type="text/css">
                      @import url(http://fonts.googleapis.com/css?family=Comfortaa);
                      #my-soon-watch-red {background-color:#030303;}
                      #my-soon-watch-red .soon-reflection {background-color:#030303;background-image:linear-gradient(#030303 25%,rgba(3,3,3,0));}
                      #my-soon-watch-red {color:#ffffff;}
                      #my-soon-watch-red .soon-label {color:#ffffff;color:rgba(255,255,255,0.75);}
                      #my-soon-watch-red {font-family:"Comfortaa",sans-serif;}
                      #my-soon-watch-red .soon-ring-progress {background-color:#410918;}
                      #my-soon-watch-red .soon-ring-progress {border-top-width:14px;}
                      #my-soon-watch-red .soon-ring-progress {border-bottom-width:13px;}
                  </style>
                  <div class="soon" id="my-soon-watch-red"
                       data-layout="group tight label-uppercase label-small"
                       data-format="d,h,m,s"
                       data-face="slot"
                       data-padding="false"
                       data-visual="ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0">
                  </div>
                 
                <div class="clearfix p-b-15"></div>

                <div style="border: 1px solid;">
                  <div style="width:100%; padding:5px;background-color:#4E1E43;color:#fff" class="text-center f-16">Datos Generales</div>
                    <div class="col-sm-12">

                      <div class="clearfix p-b-15"></div>
                      <label class="text-left opaco-0-8"><i class="zmdi zmdi-calendar f-22"></i> Fecha:</label>
                      <p class="text-left opaco-0-8 f-16">{{$fiesta->fecha_inicio}}</p>

                      <hr class="linea-morada opaco-0-8">

                      <label class="text-left opaco-0-8" ><i class="icon_a-estudio-salon f-22"></i> Lugar o Sitio:</label>
                      <p class="text-left f-16">{{$fiesta->lugar}}</p> 

                       <hr class="linea-morada opaco-0-8">

                      <label class="text-left opaco-0-8" ><i class="zmdi zmdi-alarm f-22"></i> Horario:</label>
                      <p class="text-left f-16">{{$fiesta->hora_inicio}} - {{$fiesta->hora_final}}</p>

                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                    <div class="clearfix p-b-15"></div>
                  </div>
                </div>
              </div>
        </div>

        <div class="pm-body clearfix" id="id-tabs">
            <div role="tabpanel">
            <div class="form-wizard-basic fw-container">
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active animated fadeInUp in" id="empresa">

                    <div class="pmb-block m-t-0 p-t-0">
                      
                        <p class="text-center f-30 f-700 opaco-0-8" id="offset_nombre">{!! nl2br($fiesta->nombre) !!}</p>

                        <div class="clearfix p-b-20"></div>


                        @if($fiesta->descripcion)

                          <div class="f-700 f-30">Descripción</div>
                          <hr class='linea-morada'>

                          <p class="text-center f-20">{!! nl2br($fiesta->descripcion) !!}</p>

                        @endif
                        

                        @if($link_video)
                        <div class="clearfix p-b-20"></div>
                        <div class="clearfix p-b-20"></div>
                          <div class="col-sm-offset-1 col-sm-10 m-b-20">                                   
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{$link_video}}"></iframe>
                            </div>
                          </div>
                        @endif

                        <div class="clearfix p-b-20"></div>

                        @if($fiesta->presentacion)

                          <div class="f-700 f-30">Presentación general de la fiesta</div>
                          <hr class='linea-morada'>

                          @if($fiesta->imagen_presentacion)
                            <img src="{{url('/')}}/assets/uploads/fiesta/{{$fiesta->imagen_presentacion}}" class="img-responsive opaco-0-8" alt="">
                          @endif

                          <br>

                          <p class="text-center f-20">{!! nl2br($fiesta->presentacion) !!}</p>

                        @endif


                        <div class="clearfix p-b-35"></div>
                        

                    </div>

                </div>

               


                <div class="clearfix p-b-35"></div>

 
                    <footer id="footer" style="position:relative">

                          <div class=" p-10 footer-text">
                          <p> <b><a href="http://easydancelatino.com/" target="_blank" > www.easydancelatino.com </a></b></p> 


                          <p class="f-35" >
                              <a href="https://www.facebook.com/Easydancelatino/" target="_blank" title="Facebook">
                                  <i class="zmdi zmdi-facebook"></i>
                              </a>
                              <a href="https://www.instagram.com/easydancelatino/" target="_blank" title="Instagram">
                                  <i class="zmdi zmdi-instagram"></i>
                              </a>
                              <a href="https://twitter.com/EasyDanceLatino" target="_blank" title="Twitter" >
                                  <i class="zmdi zmdi-twitter" ></i>
                              </a> 
                              <a href="https://plus.google.com/u/0/104687135628887176910" target="_blank" title="Google+" >
                                  <i class="zmdi zmdi-google-plus"></i>
                              </a>
                          </p>

                          </div>

                      </footer><br><br>


            </div> <!-- Tab Content -->
            </div>
            </div><!-- Tab Nav end -->

            <!--<data ui-view></data>-->
        </div>
    </div>
<!-- </div>
 -->



@stop

@section('js') 
        

        
        <script src="{{url('/')}}/assets/js/rrssb.min.js" data-auto="false"></script>
        <script src="{{url('/')}}/assets/js/soon.min.js" data-auto="false"></script>

        <script type="text/javascript">

        //route_agregar="{{url('/')}}/especiales/campañas/contribuir";
        route_agregar="{{url('/')}}/especiales/campañas/contribuir/recompensa";
        route_agregar_unsign="{{url('/')}}/especiales/campañas/contribuir/campaña";
        route_agregar_contribucion="{{url('/')}}/especiales/campañas/contribuir/contribucion";
        route_enhorabuena="{{url('/')}}/especiales/campañas/contribuir/enhorabuena/";

        route_enviar_invitacion="{{url('/')}}/especiales/campañas/invitar";
        route_agregar_invitacion="{{url('/')}}/especiales/campañas/invitar/agregar";
        route_eliminar_invitacion="{{url('/')}}/especiales/campañas/invitar/eliminar";
        route_enhorabuena_invitacion="{{url('/')}}/especiales/campañas/invitacion/enhorabuena/";

        var recompensa = 0;

            $(document).ready(function() {

              $("#navbar li a").click(function(event) {
                 $('.navbar-collapse').collapse('hide');
              });

              $('body,html').animate({scrollTop : 0}, 500);
              var animation = 'fadeInDownBig';
              //var cardImg = $(this).closest('#content').find('h1');
              if (animation === "hinge") {
              animationDuration = 3100;
              }
              else {
              animationDuration = 3200;
              }
              $(".container").addClass('animated '+animation);

                  setTimeout(function(){
                      $(".card-body").removeClass(animation);
                  }, animationDuration);
              $(".soon").soon({
                  due:"{{$fiesta->fecha_inicio}}",
                  //layout:"group"
                  layout:"group tight label-uppercase label-small",
                  format:"d,h,m,s",
                  face:"slot",
                  padding:"false",
                  visual:"ring cap-round invert progressgradient-fb1a1b_fc1eda ring-width-custom align-center gap-0"
              });


          });

        var h=$('#tableañadir').DataTable({
        processing: true,
        serverSide: false, 
        bPaginate: false, 
        bFilter:false, 
        bSort:false, 
        bInfo:false,
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         "Buscar:",
                        lengthMenu:     "Mostrar _MENU_ Registros",
                        info:           "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        infoEmpty:      "Mostrando 0 a 0 de 0 Registros",
                        infoFiltered:   "(filtrada de _MAX_ registros en total)",
                        infoPostFix:    "",
                        loadingRecords: "...",
                        zeroRecords:    "No se encontraron registros coincidentes",
                        emptyTable:     "No hay datos disponibles en la tabla",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        },
                        aria: {
                            sortAscending:  ": habilitado para ordenar la columna en orden ascendente",
                            sortDescending: ": habilitado para ordenar la columna en orden descendente"
                        }
                    }
            });

            $(".recompensa_confirmar").click(function(){
              $('#modalConfirmar').modal('show');
            })

        function limpiarMensaje(){
          var campo = ["nombre", "nombre_banco", "tipo_cuenta", "numero_cuenta", "correo", "telefono", "nombre_invitado", "correo_invitado", "invitacion_nombre", "linea", "monto", "coordinador", "sexo"];
          fLen = campo.length;
          for (i = 0; i < fLen; i++) {
              $("#error-"+campo[i]+"_mensaje").html('');
          }
        }

      function errores(merror){
        $('#collapseTwo').collapse('show');
        var elemento="";
        var contador=0;
        $.each(merror, function (n, c) {
          if(contador==0){
          elemento=n;
          }
          contador++;

           $.each(this, function (name, value) {              
              var error=value;
              $("#error-"+n+"_mensaje").html(error);             
           });
        });

        $('html,body').animate({
              scrollTop: $("#id-"+elemento).offset().top-90,
        }, 1000); 

        $("#modalConfirmar").scrollTop(0);         

      }


        $(".recompensa").click(function(){   

          procesando();         
      
          recompensa = this.id;            
         
          var route=route_agregar+"/"+recompensa;             
          window.location=route;    
      
        });

         $(".recompensa_otra").click(function(){   

          procesando();         
      
          recompensa = this.id;            
  
          campana = "1"    
          var route=route_agregar_unsign+"/"+campana;   
          window.location=route;    
   
      
          });

        $(".a-prevent").click(function(){

          $('body,html').animate({scrollTop : 0}, 500);


        });

        function irArriba(elemento){
                $('html,body').animate({
                        scrollTop: $("#id-"+elemento).offset().top-90,
                }, 300); 
        }


        $('#tab_campana').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_nombre").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_patrocinador').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_patrocinador").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_datos').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_datos").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_invitar').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_invitar").offset().top-90,
                }, 1000);

          }, 1000);
        })

        $('#tab_pago').click(function (){

          setTimeout(function(){ 

          $('html,body').animate({
                scrollTop: $("#offset_pago").offset().top-90,
                }, 1000);

          }, 1000);
        })


        $("#add").click(function(){

                $("#add").attr("disabled","disabled");
                    $("#add").css({
                      "opacity": ("0.2")
                });

                $("#guardar_invitacion").attr("disabled","disabled");
                    $("#guardar_invitacion").css({
                      "opacity": ("0.2")
                });

                var route = route_agregar_invitacion;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#formComparte").serialize(); 
                limpiarMensaje();

                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){

                           $('html,body').animate({
                              scrollTop: $("#tableañadir").offset().top-90,
                            }, 1000);

                          $("#formComparte")[0].reset();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          var nombre = respuesta.array[0].nombre;
                          var email = respuesta.array[0].email;

                          var rowId=respuesta.id;
                          var rowNode=h.row.add( [
                          ''+nombre+'',
                          ''+email+'',
                          '<i class="zmdi zmdi-delete f-20 p-r-10"></i>'
                          ] ).draw(false).node();
                          $( rowNode )
                          .attr('id',rowId)
                          .addClass('seleccion');

                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $("#guardar_invitacion").removeAttr("disabled");
                        $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });
                        $("#guardar_invitacion").css({
                          "opacity": ("1")
                        });

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        //  if (typeof msj.responseJSON === "undefined") {
                        //   window.location = "http://localhost:8000/error";
                        // }
                        if(msj.responseJSON.status=="ERROR"){
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar_invitacion").removeAttr("disabled");
                        $("#guardar_invitacion").css({
                          "opacity": ("1")
                        });
                        $("#add").removeAttr("disabled");
                          $("#add").css({
                            "opacity": ("1")
                          });
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

           $('#tableañadir tbody').on( 'click', 'i.zmdi-delete', function () {
                  var padre=$(this).parents('tr');
                  var token = $('input:hidden[name=_token]').val();
                  var id = $(this).closest('tr').attr('id');
                        $.ajax({
                             url: route_eliminar_invitacion+"/"+id,
                             headers: {'X-CSRF-TOKEN': token},
                             type: 'POST',
                             dataType: 'json',                
                            success: function (data) {
                              if(data.status=='OK'){

                                    
                              }else{
                                swal(
                                  'Solicitud no procesada',
                                  'Ha ocurrido un error, intente nuevamente por favor',
                                  'error'
                                );
                              }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                              swal('Solicitud no procesada','Ha ocurrido un error, intente nuevamente por favor','error');
                            }
                          })

                        h.row( $(this).parents('tr') )
                            .remove()
                            .draw();
                                                
                    });   

                    $("input[name=tipo_cuenta]").change(function(){

                      limpiarMensaje();

                      if($(this).val() == 1){
                        $('#numero_cuenta').val('');
                        $('#nombre_banco').val('');
                        $('#div_identidad').hide();
                        $('#div_numero').hide()

                      }
                      else{
                        $('#div_identidad').show();
                        $('#div_numero').show()
                      }

                    });

                    $("input[name=tipo_contribuyente]").change(function(){

                      limpiarMensaje();

                      if($(this).val() == 1){
                        $('#id-nombre').text('Nombre y Apellido');
                        $('#nombre').attr('placeholder','Ej: Valeria Zambrano');
                        $('#div_nombre').show();
                        $('#div_sexo').show();
                        $('#div_correo').show();
                        $('#div_telefono').show();
                        $('#div_coordinador').hide();
    
                      }
                      else if($(this).val() == 2){
                        $('#id-nombre').text('Apellidos');
                        $('#nombre').attr('placeholder','Ej: Zambrano Rivera');
                        $('#div_nombre').show();
                        $('#div_sexo').hide();
                        $('#div_correo').show();
                        $('#div_telefono').show();
                        $('#div_coordinador').hide();
                      }else if($(this).val() == 3){
                        $('#id-nombre').text('Nombre');
                        $('#nombre').attr('placeholder','Ej: Habana Maracaibo');
                        $('#div_nombre').show();
                        $('#div_sexo').hide();
                        $('#div_correo').show();
                        $('#div_telefono').show();
                        $('#div_coordinador').show();
                      }else{
                        $('#div_nombre').hide();
                        $('#div_sexo').hide();
                        $('#div_correo').hide();
                        $('#div_telefono').hide();
                        $('#div_coordinador').hide();
                      }

                    });

        </script>
@stop        