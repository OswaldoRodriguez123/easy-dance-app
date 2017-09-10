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

<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gris-oscuro p-t-10 p-b-10">
                <h4 class="modal-title c-negro">Agregar <button type="button" data-dismiss="modal" class="close c-negro f-25" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <form name="form_agregar" id="form_agregar"  >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="tipo_id" value="{{$id}}">
                <input type="hidden" name="tipo" value="2">
                <div class="modal-body">                           
                    <div class="row p-t-20 p-b-0">

                       <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-group fg-line">
                                <label for="factura" id="id-factura">Factura</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el número de la factura" title="" data-original-title="Ayuda"></i>
                                <input type="text" class="form-control input-sm" name="factura" id="factura" data-mask="00000000000000000000" placeholder="Ej. 16234987">
                            </div>
                            <div class="has-error" id="error-factura">
                              <span >
                                  <small id="error-factura_mensaje" class="help-block error-span" ></small>                                           
                              </span>
                            </div>
                        </div>
                       </div>

                       <div class="clearfix m-b-20"></div> 

                       <div class="col-sm-12">
                                 
                          <label for="config_tipo" id="id-config_tipo">Tipo</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el tipo de egreso" title="" data-original-title="Ayuda"></i>


                          <div class="fg-line">
                            <div class="select">
                              <select class="selectpicker" name="config_tipo" id="config_tipo" data-live-search="true">
                                <option value="">Selecciona</option>
                                @foreach ( $config_egresos as $tipo )
                                <option value = "{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="has-error" id="error-config_tipo">
                            <span >
                              <small class="help-block error-span" id="error-config_tipo_mensaje" ></small>                                           
                            </span>
                          </div>
                        </div>
     
                      <div class="clearfix p-b-35"></div>

                      <div class="col-sm-12">
                         <div class="form-group fg-line">
                            <label for="proveedor" id="id-proveedor">Proveedor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el proveedor de la factura" title="" data-original-title="Ayuda"></i>
                            <input type="text" class="form-control input-sm" name="proveedor" id="proveedor" placeholder="Ej. Sillas">
                         </div>
                         <div class="has-error" id="error-proveedor">
                              <span >
                                  <small class="help-block error-span" id="error-proveedor_mensaje" ></small>                                
                              </span>
                          </div>
                       </div>
     
                      <div class="clearfix p-b-35"></div>

                       <div class="col-sm-12">
                         <div class="form-group fg-line">
                            <label for="concepto" id="id-concepto">Concepto</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el concepto de la factura" title="" data-original-title="Ayuda"></i>
                            <input type="text" class="form-control input-sm" name="concepto" id="concepto" placeholder="Ej. Sillas">
                         </div>
                         <div class="has-error" id="error-concepto">
                              <span >
                                  <small class="help-block error-span" id="error-concepto_mensaje" ></small>                                
                              </span>
                          </div>
                       </div>

                       <div class="clearfix m-b-20"></div>


                       <div class="col-sm-12">
                         <div class="form-group fg-line">
                            <label for="cantidad" id="id-cantidad">Cantidad</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el monto" title="" data-original-title="Ayuda"></i> 
                            <input type="text" class="form-control input-sm" name="cantidad" id="cantidad" data-mask="00000000000000000000" placeholder="Ej. 50000">
                         </div>
                         <div class="has-error" id="error-cantidad">
                              <span >
                                  <small class="help-block error-span" id="error-cantidad_mensaje"  ></small>                                           
                              </span>
                          </div>
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="col-sm-12">      
                          <label for="fecha" id="id-fecha">Fecha</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona la fecha en la que se realizó la factura" title="" data-original-title="Ayuda"></i>
    
                          <div class="dtp-container fg-line">
                            <input name="fecha" id="fecha" class="form-control date-picker proceso pointer" placeholder="Seleciona" type="text">
                          </div>

                          <div class="has-error" id="error-fecha">
                              <span >
                                  <small class="help-block error-span" id="error-fecha_mensaje" ></small>                                           
                              </span>
                          </div>
                        </div>

                        <div class="clearfix p-b-35"></div>

                        <div class="col-sm-12">
                         <div class="form-group fg-line">
                            <label for="nit" id="id-nit">Nit</label> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Ingresa el nit de la factura" title="" data-original-title="Ayuda"></i>
                            <input type="text" class="form-control input-sm" name="nit" id="nit" placeholder="Ej. Sillas">
                         </div>
                         <div class="has-error" id="error-nit">
                              <span >
                                  <small class="help-block error-span" id="error-nit_mensaje" ></small>                                
                              </span>
                          </div>
                        </div>

              

                        <div class="clearfix"></div> 

 
                        <div class="modal-footer p-b-20 m-b-20">
                            <div class="col-sm-7 text-left">
                                <div class="procesando hidden">
                                    <span class="text-top p-t-20 m-t-0 f-15 p-r-10">Procesando</span>
                                    <div class="preloader pls-purple">
                                        <svg class="pl-circular" viewBox="25 25 50 50">
                                            <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">                            
                                <button type="button" class="btn btn-blanco m-r-5 f-16 agregar" id="agregar" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<a data-toggle="modal" href="#modalAgregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/agendar/fiestas/detalle/{{$fiesta->id}}" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                        
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">

                            <div class="col-sm-6">
                                <span class="f-16">Total: <span id="total">{{ number_format($total, 2, '.' , '.') }}</span></span>
                            </div>

                            <div class="col-sm-6 text-right">
                                <span class="f-16 p-t-0 text-success agregar">Agregar<i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>
                            </div>

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="fa fa-money f-25"></i></i> Sección de Egresos</p>
                            <hr class="linea-morada">                                                           
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="factura" data-order="desc">Factura</th>
                                    <th class="text-center" data-column-id="tipo">Tipo</th>
                                    <th class="text-center" data-column-id="concepto">Concepto</th>
                                    <th class="text-center" data-column-id="cantidad" data-order="desc">Cantidad</th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha</th>
                                    <th class="text-center" data-column-id="nit" data-order="desc">Nit</th>
                                    <th class="text-center" data-column-id="operacion" data-order="desc" >Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" >

                            @foreach ($egresos as $egreso)
                                <?php 

                                    $id = $egreso->id; 
                                    $contenido = '';

                                    $contenido = 
                                        'Proveedor: ' . $egreso->proveedor . '<br>'.
                                        'Hora: ' . $egreso->hora . '<br>'.
                                        'Concepto: ' . $egreso->concepto . '<br>';
                    
                                ?>

                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" id="{{$id}}" class="seleccion"> 
                                    <td class="text-center previa">{{$egreso->factura}}</td>
                                    <td class="text-center previa">{{$egreso->config_tipo}}</td>
                                    <td class="text-center previa">{{ str_limit($egreso->concepto, $limit = 30, $end = '...') }}</td>
                                    <td class="text-center previa">{{ number_format($egreso->cantidad, 2, '.' , '.') }}</td>
                                    <td class="text-center previa">{{$egreso->fecha}}</td>
                                    <td class="text-center previa">{{$egreso->nit}}</td>
                                    <td class="text-center disabled"> <i class="zmdi zmdi-delete boton red pointer f-20 p-r-10"></i></td>
                                </tr>
                            @endforeach     
                                                           
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

    route_agregar="{{url('/')}}/administrativo/egresos/agregar";
    route_eliminar="{{url('/')}}/administrativo/egresos/eliminar/";
    route_detalle="{{url('/')}}/administrativo/egresos/detalle/";

    var total = parseFloat("{{$total}}")

    if(!total){
        total = 0
    }

    $(document).ready(function(){

        t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 25,   
        order: [[5, 'desc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)', nRow).attr( "onclick","previa(this)" );
        },
        language: {
                        processing:     "Procesando ...",
                        search:         '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                        searchPlaceholder: "BUSCAR",
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

    });

    $("#agregar").click(function(){

      var route = route_agregar;
      var token = $('input:hidden[name=_token]').val();
      var datos = $( "#form_agregar" ).serialize(); 
      limpiarMensaje();
      procesando();

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

                var config_tipo = respuesta.array.config_tipo;

                expresion = "#config_tipo option[value="+config_tipo+"]";
                config_tipo = $(expresion).text();

                concepto = toTitleCase(respuesta.array.concepto)

                var contenido = 'Proveedor: ' + respuesta.array.proveedor + '<br>'
                contenido += 'Hora: ' + respuesta.array.hora + '<br>'
                contenido += 'Concepto: ' + respuesta.array.concepto + '<br>'

                if(concepto.length > 30){
                    concepto = concepto.substr(0, 30) + "..."
                }

                var rowId=respuesta.array.id;

                var rowNode=t.row.add( [
                  ''+respuesta.array.factura+'',
                  ''+config_tipo+'',
                  ''+concepto+'',
                  ''+formatmoney(parseFloat(respuesta.array.cantidad))+'',
                  ''+respuesta.fecha+'',
                  ''+respuesta.array.nit+'',
                  '<i class="zmdi zmdi-delete boton red f-20 p-r-10"></i>'
                ] ).draw(false).node();

                $( rowNode )
                  .attr('data-trigger','hover')
                  .attr('data-toggle','popover')
                  .attr('data-placement','top')
                  .attr('data-original-title','Ayuda &nbsp;&nbsp;&nbsp;&nbsp;')
                  .attr('data-html','true')
                  .attr('data-container','body')
                  .attr('title','')
                  .attr('data-content',contenido)
                  .attr('id',rowId)
                  .addClass('seleccion');

                $('[data-toggle="popover"]').popover(); 

                total = total + parseFloat(respuesta.array.cantidad)
                $("#form_agregar")[0].reset();
                $('#config_tipo').selectpicker('refresh');
                $('#total').text(formatmoney(parseFloat(total)))

                $('.modal').modal('hide');
             

              }else{
                var nTitle="Ups! ";
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                var nType = 'danger';
              }                       

              finprocesado();

              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
            }, 1000);
          },
          error:function(msj){
            setTimeout(function(){ 
              // if (typeof msj.responseJSON === "undefined") {
              //   window.location = "{{url('/')}}/error";
              // }
              if(msj.responseJSON.status=="ERROR"){
                console.log(msj.responseJSON.errores);
                errores(msj.responseJSON.errores);
                var nTitle="    Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
              }else{
                var nTitle="   Ups! "; 
                var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
              }                    
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nType = 'danger';
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY"; 
              finprocesado();
                      
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
            }, 1000);
          }
      });

    });

    $('#tablelistar tbody').on( 'click', 'i.zmdi-delete', function () {
      var id = $(this).closest('tr').attr('id');
      element = this;

      swal({   
          title: "Para eliminar el egreso necesita colocar la clave de supervisión",   
          text: "Confirmar eliminación!",   
          type: "input",  
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Aceptar",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: false,
          animation: "slide-from-top",
          inputPlaceholder: "Coloque la clave de supervisión"
      }, function(inputValue){
        if (inputValue === false) return false;
        
        if (inputValue === "") {
          swal.showInputError("Ups! La clave de supervisión es requerida");
          return false
        }else{

          var route = route_eliminar;
          var token = $('input:hidden[name=_token]').val();
          var datos = "&id="+id+"&password_supervision="+inputValue
          procesando();
          
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data:datos,
            success:function(respuesta){

              swal("Exito!","El egreso ha sido eliminado!","success");

              total = total - parseFloat(respuesta.cantidad)
              $('#total').text(formatmoney(parseFloat(total)))

              t.row( $(element).parents('tr') )
                  .remove()
                  .draw();
              finprocesado()

            },
            error:function(msj){
              finprocesado();
              if(msj.responseJSON.status == "ERROR-PASSWORD"){
                swal.showInputError("Ups! La clave de supervisión es incorrecta");
              }else{
                swal('Solicitud no procesada','Ups! Ha ocurrido un error, intente nuevamente','error');
              }
            }
          });
        }
      });
  });

    $('#modalAgregar').on('show.bs.modal', function (event) {
        $('#factura').val('')
        $('#cantidad').val('')
        $('#concepto').val('')
    });

    function limpiarMensaje(){
        var campo = ["factura", "tipo", "concepto", "cantidad"];
        fLen = campo.length;
        for (i = 0; i < fLen; i++) {
            $("#error-"+campo[i]+"_mensaje").html('');
        }
    }

    function formatmoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    function previa(t){
      var id = $(t).closest('tr').attr('id');
      var route =route_detalle + id;
      window.open(route, '_blank');;
    }

    function toTitleCase(str)
    {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
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
        }, 1500);          

    }

    </script>
@stop