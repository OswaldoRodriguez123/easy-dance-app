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
                        <div class="table-responsive row">
                        <div class="col-md-1"></div>
                           <div class="col-md-10">
<div class="text-justify">

<p>Bienvenidos a "Tu clase de baile" nos complace ofrecerle nuestro  programa de baile, al momento de acceder y utilizar nuestros servicios  usted acepta los términos y políticas de privacidad. Si no está de acuerdo con los términos o las políticas de privacidad, por favor  no utilice el servicio</p>
<div class="f-22 f-700"> Condiciones generales  </div>
<br>
<div class="f-18 f-700"> 1- Asistencia  </div>
<br>

<p>Usted debe confirmar su asistencia en el área de recepción  cada vez que asista a sus clases  y así constatar su presencia y horario de llegada.</p>


<div class="f-18 f-700">2-  Acato de normas  </div><br>

<p>Deberá respetarse la autoridad de la logística, líderes de la institución, coordinadores y directores, bajo ninguna circunstancia se podrá desacatar las normas y deberes propuesta por la organización de parte de los alumnos. </p>

<div class="f-18 f-700"> 3- Inasistencia  </div><br>

<p>En el caso  que usted falte a sus clases de baile, por cualquier hecho,  la academia no se obliga a reponer sus  clases perdidas. </p>


<div class="f-18 f-700"> 4- Seguridad </div><br>

<p>En "Tu clase de baile", nos preocupamos por la integridad física de usted y sus representados ,  ponemos a disposición medidas de controles y de seguridad para resguardar su integridad y la de sus pertenecías  dentro de la institución, sin embargo no podemos garantizarle que extraños o propios violen los sistemas de seguridad con fines vandálicos , o que atenten contra la integridad física o de cualquier elemento material  tales como, teléfono, prendas, carteras entre otros,  por lo tanto usted comprende que es responsable de su propio bienestar y cuidado o el de su representado.</p>

<div class="f-18 f-700"> 5- Responsabilidades </div><br>

<p>Nuestra organización no se responsabiliza  por alumnos que permanezcan  en los alrededores  de la academia, en caso que el alumno sea menor de edad, recomendamos que sus representantes estén presente al momento de culminar la clase. Al finalizar la jornada laboral la a academia brindará 20 minutos adicionales para realizar el cierre de sus instalaciones.  (Agradecemos tomar previsiones).</p>

<div class="f-18 f-700"> 6- Reclamos  </div><br>

<p>Todos los reclamos que presente en la administración, recepción u otros departamentos  serán tomados en consideración y atendidos según las circunstancia, siempre y cuando usted se encuentre al día con sus responsabilidades económicas dentro de  la academia, de lo contrario su reclamo no tendrá validez.</p>

<div class="f-18 f-700"> 7- Derecho a Marca </div><br>

<p>No podrá reproducir artículos, suvenir para la venta u obsequio con la imagen corporativa de nuestra academia dentro o fuera de las instalaciones  sin ser autorizado.</p>

<div class="f-18 f-700"> 8- Incidencias  </div><br>

<p>En caso de hechos fortuitos naturales, problemas eléctricos o razonamientos implementados por el gobierno, marchas o trancas de avenidas o calles por temas políticos y sociales, entre otras diversas  circunstancias que pudieran presentarse , las cuales no representan responsabilidad directa de  nuestra organización, La academia se compromete a la búsqueda de solución rápida y efectiva que se encuentre a nuestro alcance, sin embargo la academia no se obliga a reponer ni a responsabilizarse  por las clases perdidas.</p>

<div class="f-18 f-700"> 9- Cuido de pertenencias </div><br>

<p>Usted deberá cumplir con el uso y cuidado adecuado de las instalaciones  de la academia, en caso de que  incurra  en daños a elementos u objetos de  las instalaciones por un uso o conducta  inadecuada, el alumno pagará por el valor comercial  del elemento dañado o perdido o el precio del arreglo, siempre y cuando este sea posible a juicio de "Tu clase de baile", este podrá ser descontado de deducido de sus acuerdos de pago.</p>

<div class="f-18 f-700"> 10- Adquisición de productos </div><br>

<p> El participante deberá adquirir el ticket de compra de las bebidas hidratantes y golosinas  y hacerle entrega al instructor en el horario de descanso o cuando el instructor lo crea pertinente Queda terminantemente prohibido acceder a las bebidas hidratantes y golosinas, dicha sección es de manejo exclusivo de los propietarios / directores, empleados y profesores de la academia.</p>

<div class="f-18 f-700"> 11- Venta particular </div><br>

<p>No se permite, la comercialización (venta o compra) de artículos o producto dentro de las instalaciones de la academia de ninguna índole.</p>

              

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


@section('js') 
            
		<script type="text/javascript">
            route_principal="{{url('/')}}/agendar/cursos";
            route_agregar="{{url('/')}}/agendar/cursos/agregar";
            route_eliminar="{{url('/')}}/agendar/cursos/eliminar";
            route_detalle="{{url('/')}}/agendar/cursos/detalle";
            
            $(document).ready(function(){

            t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,    
        order: [[0, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).attr( "onclick","previa(this)" );
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
    

            if($('.chosen')[0]) {
                $('.chosen').chosen({
                    width: '100%',
                    allow_single_deselect: true
                });
            }
            if ($('.date-time-picker')[0]) {
               $('.date-time-picker').datetimepicker();
            }

            if ($('.date-picker')[0]) {
                $('.date-picker').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            }

                //Basic Example
                $("#data-table-basica").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    }
                });
			});
			$('.sa-warning').click(function(){          
          var id = $("#operando").val();
          var id_clasegrupal = id.split('_');

          var route = route_eliminar+"/"+id_clasegrupal[1];
          $('#modalOperacion').modal('hide');
          swal({   
            title: "Desea eliminar la clase grupal?",   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",					
            closeOnConfirm: false,
            allowOutsideClick: false
          }, function(isConfirm){   
          //swal.disableButtons();
					if (isConfirm) {
            var token = $('input:hidden[name=_token]').val();
            $.ajax({
                 url: route,
                 headers: {'X-CSRF-TOKEN': token},
                 type: 'DELETE',
                 dataType: 'json',                
                success: function (data) {
                  if(data.status=='OK'){
                    setTimeout(function() {
                      $('#'+id).remove();
                      swal(
                        'Eliminado!',
                        '¡Excelente! se han eliminado satisfactoriamente.',
                        'success'
                      );  
                    }, 100);                      
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
            /*setTimeout(function(){ 
              
  						var nFrom = $(this).attr('data-from');
  						var nAlign = $(this).attr('data-align');
  						var nIcons = $(this).attr('data-icon');
  						var nType = 'success';
  						var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              swal("Eliminado!","Se han eliminado el alumno correctamete!","success");
              var nTitle="Ups! ";
              var nMensaje="¡Excelente! se han eliminado satisfactoriamente";

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
             }, 2000);*/
					}
        });
      });
			
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
                        template: '<div data-growl="container" class="alert" role="alert">' +
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

            $('#modalAgregarBtn').click(function(){
                $("#agregar_clasegrupal")[0].reset();
                $("#mujer").prop("checked", true);
                limpiarMensaje(); 
            });  

            $(".operacionModal").click(function(){
              var i = $(this).closest('tr').attr('id');
              $('#operando').val(i);
              //console.log(i);
            });

            /*$(".previa").click(function(){
              var row = $(this).closest('tr').attr('id');
              var id_alumno = row.split('_');
              var route =route_detalle+"/"+id_alumno[1];
              window.location=route;
            });*/

            $('#modalOperacion').on('hidden.bs.modal', function (e) {
              $("#operando").val("");
            }) 

            //var myArray = myString.split(' ');

            $("#guardar").click(function(){

                
                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_clasegrupal" ).serialize(); 
                $("#guardar").attr("disabled","disabled");
                $(".cancelar").attr("disabled","disabled");
                $(".procesando").removeClass('hidden');
                $(".procesando").addClass('show');
                limpiarMensaje();   
                var nombre=$("#clase_grupal_id option:selected").text();
                var especialidad=$("#especialidad_id option:selected").text();
                var hora=$("#hora_inicio").val()+" "+$("#hora_inicio").val(); 

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
                          var nType = 'success';
                          $("#agregar_clasegrupal")[0].reset();
                          //$("#mujer").prop("checked", true);
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;
                          var rowId="row_"+respuesta.id;
                            var rowNode=t.row.add( [
                                ''+nombre+'',
                                ''+especialidad+'',
                                ''+hora+'',
                                '<i data-toggle="modal" href="#modalOperacion" class="zmdi zmdi-filter-list f-20 p-r-10 operacionModal"></i>'
                            ] ).draw(false).node();
 
                            $( rowNode )
                                //.css( 'color', '#4E1E43' ) 
                                //.css( 'font-weight', 'bold' )                               
                                .attr('id',rowId)
                                .addClass('seleccion');    


                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                        }                       
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");

                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                      }, 1000);
                    },
                    error:function(msj){
                      setTimeout(function(){ 
                        if(msj.responseJSON.status=="ERROR"){
                          console.log(msj.responseJSON.errores);
                          errores(msj.responseJSON.errores);
                          var nTitle="    Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                        }else{
                          var nTitle="   Ups! "; 
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                        }                        
                        $("#guardar").removeAttr("disabled");
                        $(".cancelar").removeAttr("disabled");
                        $(".procesando").removeClass('show');
                        $(".procesando").addClass('hidden');
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
        var campo = ["clase_grupal_id", "fecha_inicio", "especialidad_id", "nivel_baile_id", "instructor_id","estudio_id","hora_inicio","hora_final"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
      }

      function errores(merror){
        console.log(merror);
        var campo = ["clase_grupal_id", "fecha_inicio", "especialidad_id", "nivel_baile_id", "instructor_id","estudio_id","hora_inicio","hora_final"];
         $.each(merror, function (n, c) {
             console.log(n);
           $.each(this, function (name, value) {
              //console.log(this);
              var error=value;
              $("#error-"+n+"_mensaje").html(error);
              console.log(value);
           });
        });
        /*fLen = campo.length;
        for (i = 0; i < fLen; i++) {
          campo_e='merror.'+campo[i];          
          if (merror.campo[i] !== undefined){
              var error="";
              for (f = 0; f < merror.campo[i].length; i++) {
                error+=" "+merror.campo[i][f]; 
              }
              console.log(error);
              $("#error-"+campo[i]+"_mensaje").html(error);
          } 
        }*/

        /* 
        $.each(json, function () {
           $.each(this, function (name, value) {
              $("#error-"+e).html(error);
           });
        }); */              
      }

      /*$(".previa").click(function(){
              var row = $(this).closest('tr').attr('id');
              var id_alumno = row.split('_');
              var route =route_detalle+"/"+id_alumno[1];
              window.location=route;
      });*/
        
      function previa(t){
        var row = $(t).closest('tr').attr('id');
        var id_clasegrupal = row.split('_');
        var route =route_detalle+"/"+id_clasegrupal[1];
        window.location=route;
      }


		</script>
@stop