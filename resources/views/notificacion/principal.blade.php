@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
@stop

@section('content')


           <div class="modal fade" id="modalRespuesta" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                            <h4 class="modal-title c-negro"><i class="zmdi zmdi-edit m-r-5"></i> Responder Mensaje<button type="button" data-dismiss="modal" class="close c-gris f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <form name="form_respuesta" id="form_respuesta"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="modal-body">                           
                           <div class="row p-t-20 p-b-0">
                               <div class="col-sm-12">
                                 <div class="form-group fg-line">
                                    <label for="correo">Mensaje</label>
                                    <br><br>
                                    <textarea class="form-control caja" style="height: 100%" id="mensaje_usuario" name="mensaje_usuario" rows="8" placeholder="2500 Caracteres" disabled></textarea>
                                 </div>

                                 <br><br><br><br>
            
                                <label for="correo">Responder</label>
                                <br><br>
                               <div class="fg-line">
                                <textarea class="form-control caja" style="height: 100%" id="mensaje" name="mensaje" rows="8" placeholder="200 Caracteres" maxlength="200" onkeyup="countChar(this)"></textarea>
                                </div>
                                <div class="opaco-0-8 text-right">Resta <span id="charNum">200</span> Caracteres</div>
                                <div class="has-error" id="error-mensaje">
                                  <span >
                                    <small class="help-block error-span" id="error-mensaje_mensaje" ></small>                                           
                                  </span>
                                </div>
                                 
                               </div>

                               <div class="clearfix"></div> 

                               

                               <input type="hidden" name="usuario_id" id="usuario_id"></input>
                              

                               <div class="clearfix"></div> 

                               
                               
                           </div>
                           
                        </div>
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-12 text-left">
                              <div class="procesando hidden">
                              <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                              <div class="preloader pls-purple">
                                  <svg class="pl-circular" viewBox="25 25 50 50">
                                      <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                  </svg>
                              </div>
                              </div>
                            </div>
                            <div class="col-sm-12">                            

                              <a class="btn-blanco m-r-5 f-12 guardar" href="#" id="guardar">  Guardar <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div>
     
    
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                    @if(Auth::user()->usuario_tipo == 1 OR Auth::user()->usuario_tipo == 5 || Auth::user()->usuario_tipo == 6)
                       <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Inicio</a>
                       <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                      @endif
                    </div> 
                    
                    <div class="card">
                      <div class="card-header">

                           <p class="text-center opaco-0-8 f-22 m-b-25"><i class="zmdi zmdi-notifications f-22"></i> Sección de Notificaciones</p>

                          <hr class="linea-morada">
                       
                      </div>

                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">

					           	<div class="col-sm-12">

                          <div class="col-sm-12">
                           <table id="table_recomendacion" class="table table-striped table-bordered">
                           
                           @foreach(array_slice($recomendaciones, 0, 10) as $recomendacion)
                            
                            <tr class="detalle" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff" data-mensaje="{{$recomendacion['mensaje']}}" data-usuario="{{$recomendacion['usuario_id']}}">
                             <td width="10%"> 
                              <span class="m-l-10 m-r-5 f-16">{{$recomendacion['dia']}}</span>

                              <br><br><br>

                              <span class="m-l-10 m-r-5 f-16">{{$recomendacion['fecha']}}</span>

                              <br><br><br>       

                              <span class="m-l-10 m-r-5 f-16">{{$recomendacion['hora']}}</span>               
                  
                             </td>

                             <td width="20%"> 

                              <br><br><br>

                              @if($recomendacion['imagen'])
                                <img class="img-circle" width="60px" height="auto" src="{{url('/')}}/assets/uploads/usuario/{{$recomendacion['imagen']}}" alt="">
                                @else
                                    @if($recomendacion['sexo'] == 'M')
                                      <img class="img-circle" width="45px" height="auto" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">
                                    @else
                                      <img class="img-circle" width="45px" height="auto" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">
                                @endif
                              @endif   

                               <span class="m-l-10 m-r-5 f-16 p-t-20">{{$recomendacion['usuario_nombre']}} {{$recomendacion['usuario_apellido']}}</span>         
                  
                             </td>

                             <td width="20%"> 

                              <br><br><br>

                              <span class="m-l-10 m-r-5 f-16">

                              {{ str_limit($recomendacion['mensaje'], $limit = 50, $end = '...') }}

                              <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span>

                              </span>

                              
                            </tr>

                             @endforeach
                          
                           </table>

                          
                          <div class="clearfix"></div>  

                          @if(count($recomendaciones) > 10)

                            <br> 

                            <div class="col-sm-12 text-center">

                            <span id="span_izquierda">1</span> / <span id="span_derecha">1</span>

                            <div class="clearfix"></div>

                              <button id="izquierda" class="btn btn-blanco pagina" style="border:none; box-shadow: none" disabled><i class="zmdi zmdi-chevron-left zmdi-hc-fw f-20"></i></button> <button id="derecha" class="btn btn-blanco pagina" style="border:none; box-shadow: none"><i class="zmdi zmdi-chevron-right zmdi-hc-fw f-20"></i></button>

                            </div>

                          @endif
               
           
                          </div>

                         

                    
            


					                   </div>
                          </div>
                      </div>                       
                    </div>                   
                </div>
            </section>
@stop


@section('js') 
  <script type="text/javascript">

  route_enviar="{{url('/')}}/notificaciones";

  var total = 10;
  var recomendaciones = <?php echo json_encode($recomendaciones);?>;

  $(document).ready(function(){

    var derecha = Object.keys(recomendaciones).length / 10;

    if(derecha > parseInt(derecha)){
      derecha = parseInt(derecha) + 1
    }else{
      derecha = parseInt(derecha)
    }

    $('#span_derecha').text(derecha)

    $("#izquierda").attr("disabled","disabled");
    $("#derecha").removeAttr("disabled");

  });
   
   $(document).on( 'click', '.detalle', function () {
      var usuario_id = $(this).closest('tr').data('usuario');
      var mensaje = $(this).closest('tr').data('mensaje');

      $('#usuario_id').val(usuario_id)
      $('#usuario_id').val(usuario_id)
      $('#mensaje_usuario').val(mensaje)

      $('#modalRespuesta').modal('show');
      
    });

   $("#guardar").click(function(){

    var route = route_enviar;
    var token = $('input:hidden[name=_token]').val();
    var datos = $( "#form_respuesta" ).serialize();
    
    procesando();

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
              finprocesado();
              var nType = 'success';
              $("#form_respuesta")[0].reset();
              var nTitle="Ups! ";
              var nMensaje=respuesta.mensaje;
              $('#mensaje').val('')
              $('#charNum').text('200')
              $('#modalRespuesta').modal('hide');
            }else{
              var nTitle="Ups! ";
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              var nType = 'danger';

              finprocesado();
              
            }

            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);                      
            
          }, 1000);
        },
        error:function(msj){
          setTimeout(function(){ 

            if (typeof msj.responseJSON === "undefined") {
              //window.location = "{{url('/')}}/error";
            }

            if(msj.responseJSON.status=="ERROR"){
              console.log(msj.responseJSON.errores);
              errores(msj.responseJSON.errores);
              var nTitle="    Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
            }else{
              var nTitle="   Ups! "; 
              var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
            }                        
            finprocesado();
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

   function limpiarMensaje(){
      var campo = ["mensaje"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
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

  }

  function countChar(val) {
    var len = val.value.length;
    if (len >= 200) {
      val.value = val.value.substring(0, 200);
    } else {
      $('#charNum').text(200 - len);
    }
  };

  $(document).on( 'click', '.pagina', function () {

    $('#table_recomendacion').empty();

    valor = $('#span_izquierda').text()

    if(this.id == 'izquierda'){

      valor = parseInt(valor) - 1

      total = total - 10

    }else{

      valor = parseInt(valor) + 1

      total = total + 10
    }

    $('#span_izquierda').text(valor)

    if(total == 10){
      $("#izquierda").attr("disabled","disabled");
    }else{
      $("#izquierda").removeAttr("disabled");
    }
    if(total >= Object.keys(recomendaciones).length)
    {
      $("#derecha").attr("disabled","disabled");
    }else{
      $("#derecha").removeAttr("disabled");
    }

    
    $.each(recomendaciones, function (index, recomendacion) {

      if(recomendacion.contador >= total - 10 && recomendacion.contador<= total)
      {

        mensaje = recomendacion.mensaje

        if(recomendacion.imagen){
          imagen = '<img class="img-circle" width="60px" height="auto" src="{{url('/')}}/assets/uploads/usuario/'+recomendacion.imagen+'" alt="">'
        }else{
          if(recomendacion.sexo == 'M'){
            imagen = '<img class="img-circle" width="45px" height="auto" src="{{url('/')}}/assets/img/profile-pics/4.jpg" alt="">'
          }else{
            imagen = '<img class="img-circle" width="45px" height="auto" src="{{url('/')}}/assets/img/profile-pics/5.jpg" alt="">'
          }
        }  


        $("#table_recomendacion").append('<tr class="detalle" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff" data-mensaje="'+recomendacion.mensaje+'" data-usuario="'+recomendacion.usuario_id+'"><td width="10%"><span class="m-l-10 m-r-5 f-16">'+recomendacion.dia+'</span><br><br><br><span class="m-l-10 m-r-5 f-16">'+recomendacion.fecha+'</span><br><br><br><span class="m-l-10 m-r-5 f-16">'+recomendacion.hora+'</span></td><td width="20%"><br><br><br>'+imagen+'<span class="m-l-10 m-r-5 f-16 p-t-20">'+recomendacion.usuario_nombre+' '+recomendacion.usuario_apellido+'</span></td><td width="20%"><br><br><br><span class="m-l-10 m-r-5 f-16">'+mensaje.substr(0, 50)+'...<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span></span></tr>')

       }

    });


    // '<tr class="detalle" style="border: 1px solid rgba(0, 0, 0, 0.1); background-color:#fff" data-mensaje="'+recomendacion.mensaje+'" data-usuario="'+recomendacion.usuario_id+'">'
                             

    //  '<td width="10%"> '
    //   '<span class="m-l-10 m-r-5 f-16">'+recomendacion.dia+'</span>'

    //   '<br><br><br>'

    //   '<span class="m-l-10 m-r-5 f-16">'+recomendacion.fecha+'</span>'

    //   '<br><br><br>  '     

    //   '<span class="m-l-10 m-r-5 f-16">'+recomendacion.usuario_id+'</span>   '            

    //  '</td>'

    //  '<td width="20%"> '

    //   '<br><br><br>'


    //   imagen

    //    '<span class="m-l-10 m-r-5 f-16 p-t-20">'+recomendacion.usuario_nombre+' '+recomendacion.usuario_apellido+'</span>'         

    // '</td>'

    //  '<td width="20%"> '

    //   '<br><br><br>'

    //   '<span class="m-l-10 m-r-5 f-16">'

    //   mensaje.substr(0, 50) + "..."

    //   '<span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span>'

    //   '</span>'

      
    // '</tr>'


  });


  </script>

        
		
@stop
