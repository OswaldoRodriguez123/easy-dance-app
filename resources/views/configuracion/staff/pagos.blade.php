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

                        <?php $url = "/configuracion/staff/detalle/$id" ?>
                        <a class="btn-blanco m-r-10 f-16" href="{{ empty($_SERVER['HTTP_REFERER']) ? $url : $_SERVER['HTTP_REFERER'] }}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-reservaciones f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>

                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-file-text zmdi-hc-fw p-r-5 f-25"></i> Sección de Pagos</p>
                        <hr class="linea-morada">
                                                              
                        </div>


                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)

	                        <div class="col-md-offset-10">
	                          <button type="button" class="btn btn-blanco m-r-10 f-14 guardar" name= "pagar" id="pagar" > Pagar <i class="icon_a-pagar"></i></button>
	                        </div>

                        @endif

                        <div class="col-sm-5">
                                 <div class="form-group fg-line ">
                                    <div class="p-t-10">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pendientes" value="pendientes" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        Pendientes por Pagar <i id="pendientes2" name="pendientes2" class="zmdi zmdi-forward zmdi-hc-fw f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="pagadas" value="pagadas" type="radio">
                                        <i class="input-helper"></i>  
                                        Pagadas <i id="pagadas2" name="pagadas2" class="zmdi zmdi-money-box zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    </div>
                                    
                                 </div>
                                </div> 

                                <div class="clearfix"></div>
                                
                                <div class="col-md-12">
                                  <span id="monto" class ="f-700 f-16 opaco-0-8">Pendiente por cobrar : <span id="total">{{ number_format($total, 2) }}</span></span>
                                </div>
                                <br><br>
                                <!-- <div class="clearfix"></div> -->

                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
 
                                    <th style="width:7%;"><input style="margin-left:49%;" name="select_all" value="1" id="select_all" type="checkbox" /></th>
                                    <th class="text-center" data-column-id="fecha" data-order="asc">Fecha</th>
                                    <th class="text-center" data-column-id="clase">Servicio</th>
                                    <th class="text-center" data-column-id="monto">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                                           
                            </tbody>
                        </table>
                         </div>
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

        route_pagar="{{url('/')}}/configuracion/staff/pagar";

        tipo = 'pagadas';

        var total = "{{$total}}"

        var por_pagar = <?php echo json_encode($por_pagar);?>;
        var pagadas = <?php echo json_encode($pagadas);?>;

        function formatmoney(n) {
            return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        } 

        $(document).ready(function(){

          $("#pagar").attr("disabled","disabled");
            
          $("#pagar").css({
              "opacity": ("0.2")
          });

          $("#pendientes").prop("checked", true);

          t=$('#tablelistar').DataTable({
          "columnDefs": [ {
            "targets": [ 0 ],
            "orderable": false
          } ],
          processing: true,
          serverSide: false,
          pageLength: 50, 
          order: [[1, 'desc'], [3, 'desc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
          },
          language: {
                          processing:     "Procesando ...",
                          search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                          searchPlaceholder: "BUSCAR",
                          lengthMenu:     " ",
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


          rechargeProforma();

        });

         function clear(){

            t.clear().draw();
            // t.destroy();
         }

         $('input[name="tipo"]').on('change', function(){
            clear();
            if ($(this).val()=='pagadas') {
                  tipo = 'pagadas';
                  rechargeFactura();
                  $('#pagar').hide();
            } else  {
                  tipo= 'proformas';
                  rechargeProforma();
                  $('#pagar').show();
            }
         });

        function rechargeFactura(){

            $('#monto').css('opacity', '0');
            $('#select_all').hide();

            $.each(pagadas, function (index, array) {
                var rowNode=t.row.add( [
                  ''+ ' ' +'',
                  ''+array.fecha+'',
                  ''+array.servicio+'',
                  ''+formatmoney(parseFloat(array.monto))+'',
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('seleccion');
            });
        }

        function rechargeProforma(){
            

            $('#monto').css('opacity', '1');

            if("{{$usuario_tipo}}" != 3)
            {
            	$('#select_all').show();
            	checkbox = '<input name="select_check" id="select_check" type="checkbox" />'
            }else{
            	checkbox = ''
            }

            $.each(por_pagar, function (index, array) {
                var rowNode=t.row.add( [
                  ''+checkbox+'', 
                  ''+array.fecha+'',
                  ''+array.servicio+'',
                  ''+formatmoney(parseFloat(array.monto))+'',
                ] ).draw(false).node();
                $( rowNode )
                    .attr('id',array.id)
                    .addClass('text-center');
            });
        }

        $("#pagadas").click(function(){
            $( "#pendientes2" ).removeClass( "c-verde" );
            $( "#pagadas2" ).addClass( "c-verde" );
        });

        $("#pendientes").click(function(){
            $( "#pagadas2" ).removeClass( "c-verde" );
            $( "#pendientes2" ).addClass( "c-verde" );
        });

        $('#tablelistar tbody').on( 'click', 'i.icon_a-pagar', function () {
            var id = $(this).closest('tr').attr('id');
            window.location = route_gestion + id;
        });

        $('#tablelistar tbody').on( 'click', 'i.zmdi-email', function () {

                var id = $(this).closest('tr').attr('id');
                element = this;

                swal({   
                    title: "Desea re-enviar la factura por correo electrónico?",   
                    text: "Confirmar re-envio!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Re-Enviar!",  
                    cancelButtonText: "Cancelar",         
                    closeOnConfirm: true 
                }, function(isConfirm){   
          if (isConfirm) {
            var nFrom = $(this).attr('data-from');
            var nAlign = $(this).attr('data-align');
            var nIcons = $(this).attr('data-icon');
            var nType = 'success';
            var nAnimIn = $(this).attr('data-animation-in');
            var nAnimOut = $(this).attr('data-animation-out')
                        swal("Exito!","El correo ha sido enviado!","success");
                        // notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
                        enviar(id, element);
          }
                });
            });
      
        function enviar(id, element){
         var route = route_enviar + id;
         var token = "{{ csrf_token() }}";
                
                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                    dataType: 'json',
                    data:id,
                    success:function(respuesta){
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          // finprocesado();
                          var nType = 'success';
                          var nTitle="Ups! ";
                          var nMensaje=respuesta.mensaje;

                          // t.row( $(element).parents('tr') )
                          //   .remove()
                          //   .draw();
                        
                        }
                    },
                    error:function(msj){
                                $("#msj-danger").fadeIn(); 
                                var text="";
                                console.log(msj);
                                var merror=msj.responseJSON;
                                text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                $("#msj-error").html(text);
                                setTimeout(function(){
                                         $("#msj-danger").fadeOut();
                                        }, 3000);
                                }
                });
      }

      
    $("#pagar").click(function(){


      // procesando();

      var route = route_pagar;
      var token = "{{ csrf_token() }}";
      var datos = "&pagos="+getChecked();
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
                var nType = 'success';
                var nTitle="Ups! ";
                var nMensaje=respuesta.mensaje;

                $.each(respuesta.array, function (index, id) {

                  var pago = $.grep(por_pagar, function(e){ return e.id == id; });

                  pagadas.push(pago[0]);

                  indexes = $.map(por_pagar, function(obj, index) {
                      if(obj.id == id){
                          por_pagar.splice( $.inArray(por_pagar[index], por_pagar), 1 );

                          t.row( $('#'+id) )
                            .remove()
                            .draw();

                          total = total - obj.monto;

                          $('#total').text(total);


                      }
                  })
                });

                $('#clase_grupal_id').val('');
                $('#clase_grupal_id').selectpicker('refresh');
                

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       
              $("#add").removeAttr("disabled");
                $("#add").css({
                  "opacity": ("1")
                });

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }, 1000);
          },
          error:function(msj){
            setTimeout(function(){ 
              if (typeof msj.responseJSON === "undefined") {
                window.location = "{{url('/')}}/error";
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

    function limpiarMensaje(){
      var campo = ["monto"];
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

  }

  function getChecked(){
      var checked = [];
      $('#tablelistar tr').each(function (i, row) {
          var actualrow = $(row);
          checkbox = actualrow.find('input:checked').val();
          if(checkbox == 'on')
          {
            var id = $(actualrow).attr('id');
            checked[i] = id;
          }
      });

      return checked;
    }


  $('#select_all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = t.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);

      values = getChecked();

      if(values.length > 0){

        $("#pagar").removeAttr("disabled");
        $("#pagar").css({
          "opacity": ("1")
        });

      }else{
        $("#pagar").attr("disabled","disabled");
        $("#pagar").css({
          "opacity": ("0.2")
        });
      }

   });

  $('#tablelistar tbody').on( 'click', 'input[type="checkbox"]', function () {
      values = getChecked();

      if(values.length > 0){

        $("#pagar").removeAttr("disabled");
        $("#pagar").css({
          "opacity": ("1")
        });

      }else{
        $("#pagar").attr("disabled","disabled");
        $("#pagar").css({
          "opacity": ("0.2")
        });
      }


  });


    </script>

@stop