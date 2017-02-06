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
    
    <div class="container">
      <div class="card">
        <div class="card-header">
            <div class="clearfix"></div><br>

            <div align="center"><i class="zmdi zmdi-mood zmdi-hc-5x c-verde"></i></div>
            <!--<div class="c-morado f-50 text-center"> Validar </div>-->
            <div class="text-center f-30 c-verde">Siii, el codigo ingresado es valido, A Bailar.  </div>
            <div class="clearfix"></div><br><br>

            <div class="block-header text-center">
                <!--<input type="text" class="caja"></input>-->
                <a class="btn-blanco m-r-10 f-20" href="{{url('/')}}/validar"> Validar otro Codigo <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </a>
                <a class="btn-morado m-r-10 f-20" href="{{url('/')}}/"> Volver a Menú</a>
              </div> 


        </div>
        <div class="form-control card-body">

              
          
        </div>

      </div>
      
      <div class="clearfix"></div><br><br>
      <br><br>
      <br><br>

    </div>



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
        pageLength: 25,   
        order: [[0, 'asc']],
        fnDrawCallback: function() {
          $('.dataTables_paginate').show();
          /*if ($('#tablelistar tr').length < 25) {
              $('.dataTables_paginate').hide();
          }
          else{
             $('.dataTables_paginate').show();
          }*/
        },
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