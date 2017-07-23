@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/select.bootstrap.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/select.dataTables.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>


<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot/jquery.flot.pie.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>                         
<script src="{{url('/')}}/assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{url('/')}}/assets/js/dataTables.select/dataTables.select.min.js"></script>

<script src="{{url('/')}}/assets/js/flot-charts/pie-chart.js"></script>

@stop
@section('content')

            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/correo" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Correos</a>

                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="zmdi zmdi-email f-25"></i> Enviar Correo: {{$correo->titulo}}</p>
                            <hr class="linea-morada">
                                                         
                        </div>

                        <div class="col-sm-12">
                            <form name="form_correo" id="form_correo">
                                <input type="hidden" id="boolean_fecha" name="boolean_fecha" value="0">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="correo_id" id="correo_id" value="{{$correo->id}}">

                                <div class="col-md-4">
                                    <label>Alumnos / Visitantes</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo" id="tipo">
                                            <option value="1">Alumnos</option>
                                            <option value="3">Visitantes Presenciales</option>
                                        </select>
                                      </div>
                                </div>                  

                                <div class="col-md-4">
                                    <label>Tipo</label>
                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="tipo2" id="tipo2">
                                            <option value="">Todos</option>
                                            <option value="1">Clases Grupales</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Fecha</label> &nbsp; &nbsp; &nbsp;

                                    <div class="select">
                                        <select class="selectpicker" data-live-search="true" name="fecha" id="fecha">
                                            <option value="1">Hoy</option>
                                            <option value="2">Mes Actual</option>
                                            <option value="3">Mes Pasado</option>
                                        </select>
                                      </div>
                                </div>

                               <div class="clearfix m-b-20"></div>

                                <div class="col-sm-4">
                                    <div class="form-group fg-line">
                                        <label for="nombre">Personalizar</label>
                                        <div class="panel-group p-l-10" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-collapse">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                          <i class="zmdi zmdi-square-down f-22 border-sombra m-r-10"></i>  Pulsa aquí 
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">

                                                        <div class="clearfix m-b-20"></div>
                                                    

                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                                            <div class="fg-line">
                                                                    <input type="text" name = "fecha2" id="fecha2" class="form-control" placeholder="Personalizar">
                                                            </div>
                                                        </div>

            

                                                        
                                                    </div>

                                                    <div class="clearfix p-b-35"></div>
                                                    <div class="col-sm-12 text-center"><i class="zmdi zmdi-minus-square f-22 pointer" onclick="collapse_minus('collapseTwo')" ></i></div>   

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <button type="button" class="btn btn-blanco m-l-10 f-10" id="filtrar" >Filtrar</button>

                                <div class ="clearfix m-b-10"></div>
                                <div class ="clearfix m-b-10"></div>

                            </form>
                        </div>

                        <div class ="clearfix"></div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th><input class="select-checkbox" name="select_all" id="select_all" type="checkbox"></th>
                                    <th class="text-center" data-column-id="fecha" data-order="desc">Fecha de Registro</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombre</th>
                                    <th class="text-center" data-column-id="nac" data-order="desc">Nacimiento</th>
                                    <th class="text-center" data-column-id="sexo" data-order="desc">Sexo</th>                    
                                    <th class="text-center" data-column-id="celular">Correo</th>
                                </tr>
                            </thead>
                            <tbody>

                              @if($usuario)

                                <tr id="{{$usuario[0]['id']}}" class="seleccion" >
                                  <td class="text-center previa"></td>
                                  <td class="text-center previa">{{$usuario[0]['fecha']}}</td>

                                  <?php 
                                      $tmp = explode(" ", $usuario[0]['nombre']);
                                      $nombre_alumno = $tmp[0];

                                      $tmp = explode(" ", $usuario[0]['apellido']);
                                      $apellido_alumno = $tmp[0];
                                  ?>

                                  <td class="text-center previa">{{$nombre_alumno}} {{$apellido_alumno}} </td>
                                  <td class="text-center previa">{{$usuario[0]['fecha_nacimiento']}}</td>
                                  <td class="text-center previa">
                                     
                                    @if($usuario[0]['sexo']=='F')
                                        <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                    @else
                                        <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                    @endif
                               
                                  </td>
                                  <td class="text-center previa">{{$usuario[0]['correo']}}</td>
                                </tr>
                              @endif
                                                           
                          </tbody>
                        </table>
                         </div>
                        </div>

                        <div class ="clearfix m-b-10"></div>
                        <div class ="clearfix m-b-10"></div>

                        <div class="col-sm-4 text-right pull-right m-t-20">                          

                          <button type="button" class="btn btn-blanco m-r-10 f-14" name= "enviar" id="enviar" >Enviar</button>
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

        route_filtrar="{{url('/')}}/correo/filtrar";
        route_enviar="{{url('/')}}/correo/enviar";

        var clases_grupales = <?php echo json_encode($clases_grupales);?>;  

        $(document).ready(function(){
          //DateRangePicker
          $('#fecha2').daterangepicker({
              "autoApply" : false,
              "opens": "right",
              "applyClass": "bgm-morado waves-effect",
              locale : {
                  format: 'DD/MM/YYYY',
                  applyLabel : 'Aplicar',
                  cancelLabel : 'Cancelar',
                  daysOfWeek : [
                      "Dom",
                      "Lun",
                      "Mar",
                      "Mie",
                      "Jue",
                      "Vie",
                      "Sab"
                  ],

                  monthNames: [
                      "Enero",
                      "Febrero",
                      "Marzo",
                      "Abril",
                      "Mayo",
                      "Junio",
                      "Julio",
                      "Agosto",
                      "Septiembre",
                      "Octubre",
                      "Noviembre",
                      "Diciembre"
                  ],        
              }

          });

            $('#select_all').prop('checked', false);
            $('#tipo').val(1)
            $('#tipo').selectpicker('refresh')
            rechargeAlumno()

        });

        t=$('#tablelistar').DataTable({
          columnDefs: [ {
            orderable: false,
            className: 'select-checkbox text-center',
            targets:   0
          } ],
          select: {
            style: 'multi',
            selector: 'td:first-child'
          },
          processing: true,
          serverSide: false,
          pageLength: 25, 
          order: [[1, 'desc']],
          fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).addClass( "text-center" );
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
                          },
                          select: {
                            rows: "%d registros seleccionados"
                          }
                      }


        });


        $("#tipo").change(function(){

            if($(this).val() == 1){
                rechargeAlumno();
            }else if($(this).val() == 3){
                rechargeVisitante()
            }
          
        });

        function rechargeAlumno(){

            $('#tipo2').empty();
            $('#tipo2').append('<option value="" data-content="Todos"></option>')
            $.each(clases_grupales, function (index, array) {
              $('#tipo2').append('<option value='+array.id+' data-content="'+array.nombre +'  -  '+array.dia+'  -  '+array.hora_inicio+' / '+array.hora_final + '  -  ' + array.instructor_nombre + ' ' + array.instructor_apellido+'"></option>');
            });

            $('#tipo2').selectpicker('refresh');

        }

        function rechargeVisitante(){

            $('#tipo2').empty();
            $('#tipo2').append('<option value="" data-content="Todos"></option>')
            $('#tipo2').append('<option value="1" data-content="Inscritos"></option>')
            $('#tipo2').append('<option value="2" data-content="No Inscritos"></option>')

            $('#tipo2').selectpicker('refresh');

        }

        $("#filtrar").click(function(){

          $('#select_all').prop('checked', false);
          t.clear().draw()

          procesando()

          var datos = $( "#form_correo" ).serialize();
          var token = $('input:hidden[name=_token]').val();

          $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            url: route_filtrar,
            type: 'POST',
            dataType: 'json',
            data: datos,
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

                  $.each(respuesta.usuarios, function (index, array) {
 
                    if(array.sexo=='F'){
                        sexo = '<i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                    }else{
                        sexo = '<i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                    }

                    var rowNode=t.row.add( [
                      '',
                      ''+array.fecha+'',
                      ''+array.nombre+ ' ' +array.apellido+'',
                      ''+array.fecha_nacimiento+'',
                      ''+sexo+'',
                      ''+array.correo+'',
                    ] ).draw(false).node();
                    $( rowNode )
                        .attr('id',array.id)
                  });

                }else{
                  var nTitle="Ups! ";
                  var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  var nType = 'danger';
                }

                finprocesado();
                notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
              }, 1000);
            },error:function(msj){
                setTimeout(function(){ 
                  if(msj.responseJSON.status=="ERROR"){
                    errores(msj.responseJSON.errores);
                    var nTitle="    Ups! "; 
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";            
                  }else{
                    var nTitle="   Ups! "; 
                    var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                  }                        
                  finprocesado();
                  var nType = 'danger';                      
                  notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);
              }, 1000);
            }
          });
        });

        $("#enviar").on('click', function(){

            var usuario_id = $('#usuario_id').val();
            var usuarios = '';
            var rows = $('tr.selected');

            $.each(rows,function(index,array){
              usuarios = usuarios + ',' + $(array).attr('id');
            });

            if(usuarios){

              procesando();
            
              var datos = $( "#form_correo" ).serialize();
              var token = $('input:hidden[name=_token]').val();

              $.ajax({
                  headers: {'X-CSRF-TOKEN': token},
                  url: route_enviar,
                  type: 'POST',
                  dataType: 'json',
                  data: datos+"&usuarios="+usuarios,
                  success:function(respuesta){
                    setTimeout(function(){ 
                      var nFrom = $(this).attr('data-from');
                      var nAlign = $(this).attr('data-align');
                      var nIcons = $(this).attr('data-icon');
                      var nAnimIn = "animated flipInY";
                      var nAnimOut = "animated flipOutY"; 
                      if(respuesta.status=="OK"){
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        var nType = 'success';
                        var nTitle="Ups! ";
                        var nMensaje="Tu correo ha sido enviado exitósamente";

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
            }else{

              var nTitle="    Ups! "; 
              var nMensaje="Debe seleccionar un usuario";            
              var nFrom = $(this).attr('data-from');
              var nAlign = $(this).attr('data-align');
              var nIcons = $(this).attr('data-icon');
              var nType = 'danger';
              var nAnimIn = "animated flipInY";
              var nAnimOut = "animated flipOutY";                       
              notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);

            }

        });

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

      t.on("click", "th.select-checkbox", function() {
          if ($("th.select-checkbox").hasClass("selected")) {
              t.rows().deselect();
              $("th.select-checkbox").removeClass("selected");
          } else {
              t.rows().select();
              $("th.select-checkbox").addClass("selected");
          }
      }).on("select deselect", function() {
          if (t.rows({
                  selected: true
              }).count() !== t.rows().count()) {
              $("th.select-checkbox").removeClass("selected");
          } else {
              $("th.select-checkbox").addClass("selected");
          }
      });

      function collapse_minus(collaps){
        $('#'+collaps).collapse('hide');
      }   

      $('#collapseTwo').on('show.bs.collapse', function () {
          $("#boolean_fecha").val('1');
          $("#fecha").attr('disabled',true);
          $("#fecha").addClass('disabled');
          $("#fecha").selectpicker('refresh');
          setTimeout(function(){ 
              $("#fecha2").click();
          }, 500);
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
          $("#fecha").attr('disabled',false);
          $("#fecha").removeClass('disabled');
          $("#fecha").selectpicker('refresh');
          $("#boolean_fecha").val('0');
      })




    </script>

@stop