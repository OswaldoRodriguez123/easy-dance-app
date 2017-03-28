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

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                       <h4><i class="zmdi zmdi-info p-r-5"></i> Información <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state">Planilla Academias </span></h4>
                    </div> 
                    
                    <div class="card">
                      <div class="card-header">
                            
                            
                      </div>
                      <div class="card-body p-b-20">
                        <div class="row">
                        <div class="container">
                         <div class="col-sm-3">
          					        <div class="text-center p-t-30">       
          					          <div class="row p-b-15">
          					            <div class="col-md-12" data-src="/assets/img/ayuda-configuracion.jpg">
          					              <div class="">
          					                <img src="{{url('/')}}/assets/img/detalle_clases_grupales.jpg" class="img-responsive opaco-0-8" alt="">
          					              </div>
          					            </div>                
          					          </div>
          					          <p class="text-justify">Desde esta área Easy Dance te brinda la oportunidad de actualizar los datos creados en tu planilla de registro.</p>
          					                
          					      </div>
					           </div>

					           	<div class="col-sm-9">

                         <div class="col-sm-12">
                              <h4 class="text-center">Datos de la Academia</h4>
                          </div>

                          <div class="col-sm-12">
                           <table class="table table-striped table-bordered">
                           <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-nombre"><span>{{$academia->usuario_nombre}} {{$academia->usuario_apellido}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Correo </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-email"><span>{{$academia->usuario_email}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Telefono </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="usuario-telefono"><span>{{$academia->usuario_telefono}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr class="f-28">
                             <td class="text-center">
                               <span class="text-center"> Datos de la Academia </span>
                             </td>
                            </tr>


                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Nombre </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-nombre"><span>{{$academia->academia_nombre}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Pais </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-pais"><span>{{$academia->pais}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Estado / Provincia </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-estado"><span>{{$academia->estado}}</span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> </td>
                            </tr>

                            <tr>
                             <td>
                               <span class="m-l-10 m-r-10"> <i class="zmdi zmdi-accounts-alt f-22"></i> </span>
                               <span class="f-14"> Estatus Economico </span>
                             </td>
                             <td class="f-14 m-l-15" ><span id="academia-estado"><span>
                              <label class="label label-success f-13">Bien</label></span></span> <span class="pull-right c-blanco"><i class="zmdi zmdi-edit f-22"></i></span> 
                              </td>
                            </tr>

                           </table>

                          
                          <div class="clearfix"></div>   
               
           
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
    route_update="{{url('/')}}/agendar/cursos/update";


    $('#modalNombre-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nombre").val($("#clasegrupal-Nombre").text()); 
    })
    $('#modalFechaInicio-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#fecha_inicio").val($("#clasegrupal-FechaInicio").text()); 
    })
    $('#modalEspecialidades-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#especialidades option:selected").val($("#clasegrupal-especialidades").text()); 

    })
    $('#modalInstructor-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#instructor option:selected").val($("#clasegrupal-instructor").text()); 
    })


    $('#modalNivelBaile-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#nivel_baile option:selected").val($("#clasegrupal-nivel_baile").text()); 
    })

    $('#modalHorario-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#hora_inicio").val($("#clasegrupal-hora_inicio").text());
      $("#hora_final").val($("#clasegrupal-hora_final").text());
    })

    $('#modalEstudio-ClaseGrupal').on('show.bs.modal', function (event) {
      limpiarMensaje();
      $("#estudio option:selected").val($("#clasegrupal-estudio").text()); 
    })

    function limpiarMensaje(){
        var campo = ["fecha_inicio", "especialidades", "instructor", "nivel_baile", "hora_inicio", "hora_final"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["fecha_inicio", "especialidades", "instructor", "nivel_baile", "hora_inicio", "hora_final"];
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
      }

      function campoValor(form){
        $.each(form, function (n, c) {
          if(c.name=='sexo'){
            if(c.value=='M'){              
              var valor='<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>';                              
            }else if(c.value=='F'){
              var valor='<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>';
            }
            $("#clasegrupal-"+c.name).data('valor',c.value);
            $("#clasegrupal-"+c.name).html(valor);
          }else{
            $("#clasegrupal-"+c.name).text(c.value);
          }

          $("#estatus-"+c.name).removeClass('c-amarillo');
          $("#estatus-"+c.name).addClass('c-verde');
        });
      }

    function notify(from, align, icon, type, animIn, animOut, mensaje, titulo){
                $.growl({
                    icon: icon,
                    title: titulo,
                    message: mensaje,
                    url: ''
                },{
                        element: 'body',
                        type: type,
                        allow_dismiss: true,
                        placement: {
                                from: from,
                                align: align
                        },
                        offset: {
                            x: 20,
                            y: 85
                        },
                        spacing: 10,
                        z_index: 1070,
                        delay: 2500,
                        timer: 2000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                                enter: animIn,
                                exit: animOut
                        },
                        icon_type: 'class',
                        template: '<div data-growl="container" class="alert f-700" role="alert">' +
                                        '<button type="button" class="close" data-growl="dismiss">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '<span class="sr-only">Close</span>' +
                                        '</button>' +
                                        '<span data-growl="icon"></span>' +
                                        '<span data-growl="title"></span>' +
                                        '<span data-growl="message"></span>' +
                                        '<a href="#" data-growl="url"></a>' +
                                    '</div>'
                });
    };

    $(".guardar").click(function(){
        //$(this).data('formulario');
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nAnimIn = "animated flipInY";
        var nAnimOut = "animated flipOutY"; 
        limpiarMensaje();
        $(".guardar").attr("disabled","disabled");
        $(".cancelar").attr("disabled","disabled");
        $(".procesando").removeClass('hidden');
        $(".procesando").addClass('show');
        form=$(this).data('formulario');
        update=$(this).data('update');
        var token = $('input:hidden[name=_token]').val();
        var datos = $( "#"+form ).serialize();
        var datos_array=  $( "#"+form ).serializeArray();
        console.log(datos_array);
        
        var route = route_update+"/"+update;
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: datos,                
            success: function (respuesta) {
              setTimeout(function() {
                if(respuesta.status=='OK'){  
                  campoValor(datos_array);        
                  var nType = 'success';
                  var nTitle="Ups! ";
                  var nMensaje=respuesta.mensaje;                                      
                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                 $(".procesando").removeClass('show');
                 $(".procesando").addClass('hidden');
                 $(".guardar").removeAttr("disabled");
                 $(".cancelar").removeAttr("disabled");
                 $('.modal').modal('hide');
              }, 1000);  
            },
            error:function (msj, ajaxOptions, thrownError){
              setTimeout(function(){ 
                var nType = 'danger';
                if(msj.responseJSON.status=="ERROR"){
                  console.log(msj.responseJSON.errores);
                  errores(msj.responseJSON.errores);
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                }else{
                  var nTitle=" Ups! "; 
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                }
                 notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                  $(".procesando").removeClass('show');
                  $(".procesando").addClass('hidden');
                  $(".guardar").removeAttr("disabled");
                  $(".cancelar").removeAttr("disabled");
              }, 1000);             
            }
        })
       
    })
    
   </script> 

   <!--<script src="{{url('/')}}/assets/js/script/alumno-planilla.js"></script>-->        
		
@stop
