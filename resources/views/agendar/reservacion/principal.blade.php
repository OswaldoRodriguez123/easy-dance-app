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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/"><i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>
                     
                        @if($usuario_tipo == 1 OR $usuario_tipo == 5 || $usuario_tipo == 6)
                        
                            <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                                <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                                
                                <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                                
                                <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                                
                                <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                               
                                <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            </ul>
                        @endif
                    </div> 
                    
                    <div class="card">
                        <div class="card-header">
                              
                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-reservaciones f-25"></i> Secci??n de Reservaciones</p>
                            <hr class="linea-morada">

                            <div class="col-sm-6 text-left">
                                 
                              <label class="c-morado f-15">Filtro</label>

                              <div class="dropdown" id="dropdown_boton">
                                <a id="detalle_boton" role="button" data-toggle="dropdown" class="btn btn-blanco">
                                    Todos <span class="caret"></span>
                                </a>
                                <ul id="dropdown_principal" class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                  <li class="reservacion pointer" data-nombre="Todos" value="">
                                    <a>Todos</a>
                                  </li>

                                  @foreach($actividades as $actividad)
                                    <li class="reservacion pointer" data-nombre="{{$actividad['nombre']}}" value="{{$actividad['tipo']}}-{{$actividad['id']}}">
                                      <a>{{$actividad['nombre']}}</a>
                                    </li>
                                  @endforeach

                                </ul>
                              </div>

                          </div>

                            <div class="col-sm-6">
                                <div class="p-t-10 pull-right">
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="activas" value="1" type="radio" checked>
                                        <i class="input-helper"></i>  
                                        Activas <i id="activas2" name="activas2" class="zmdi zmdi-label-alt-outline zmdi-hc-fw c-verde f-20"></i>
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input name="tipo" id="finalizadas" value="0" type="radio">
                                        <i class="input-helper"></i>  
                                        Inactivas <i id="finalizadas2" name="finalizadas2" class="zmdi zmdi-check zmdi-hc-fw f-20"></i>
                                    </label>
                                </div>
                            </div>


                            <div class="clearfix"></div>
                  
                        </div>
                        <div class="table-responsive row">
                           <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                  <th class="text-center" data-column-id="estatus"></th>
                                  <th class="text-center" data-column-id="imagen">Imagen</th>
                                  <th class="text-center" data-column-id="nombres">Nombres</th>
                                  <th class="text-center" data-column-id="actividad">Actividad</th>
                                  <th class="text-center" data-column-id="sexo">Sexo</th>
                                  <th class="text-center" data-column-id="fecha_reservacion">Fecha Reservaci??n</th>
                                  <th class="text-center" data-column-id="fecha_vencimiento">Fecha Vencimiento</th>
                                  <th class="text-center" data-column-id="operacion">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                              @foreach ($reservaciones as $reservacion)
                                <?php 

                                    $id = $reservacion['id']; 

                                    $contenido = '';

                                    if($reservacion['imagen']){
                                        $imagen = '/assets/uploads/usuario/'.$reservacion['imagen'];
                                    }else{
                                        if($reservacion['sexo'] == 'F'){
                                            $imagen = '/assets/img/Mujer.jpg';
                                        }else{
                                            $imagen = '/assets/img/Hombre.jpg';
                                        }
                                    }


                                    $contenido = 
                                    '<p class="c-negro">' .
                                        $reservacion['nombre'] . ' ' . $reservacion['apellido'] . ' ' . ' ' .  '<img class="lv-img-lg" src="'.$imagen.'" alt=""><br><br>' .
                                        'N??mero M??vil: ' . $reservacion['celular'] . '<br>'.
                                        'Correo Electr??nico: ' . $reservacion['correo'] . '<br>'.
                                        'Provinencia: ' . $reservacion['provinencia'] . '<br>'.
                                    '</p>';

                                ?>
                                <tr data-trigger = "hover" data-toggle = "popover" data-placement = "top" data-content = "{{$contenido}}" data-original-title = "Ayuda &nbsp;&nbsp;&nbsp;&nbsp;" data-html = "true" data-container = "body" title= "" data-tipo="{{$reservacion['tipo_reservacion']}}" data-actividad_id="{{$reservacion['tipo_reservacion_id']}}" id="{{$id}}" class="seleccion">
                                  <td>
                                    <span style="display: none">{{$reservacion['estatus']}}</span>
                                    @if($reservacion['estatus'] == 0)
                                      @if($reservacion['boolean_confirmacion'])
                                        <i class="zmdi zmdi-check c-verde f-16"></i>
                                      @else
                                        <i class="zmdi zmdi-dot-circle c-amarillo f-16"></i>
                                      @endif
                                    @endif
                                  </td>
                                  <td class="text-center previa">
                                    <span style="display: none">{{$reservacion['tipo_reservacion']}}-{{$reservacion['tipo_reservacion_id']}}</span>
                                    @if($reservacion['imagen'])
                                        <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/uploads/usuario/{{$reservacion['imagen']}}" alt="">
                                      @else
                                          @if($reservacion['sexo'] == 'M')
                                            <img class="lv-img lazy" src="{{url('/')}}/assets/img/Hombre.jpg" data-image = "{{url('/')}}/assets/img/Hombre.jpg" alt="">
                                          @else
                                            <img class="lv-img lazy" src="{{url('/')}}/assets/img/Mujer.jpg" data-image = "{{url('/')}}/assets/img/Mujer.jpg" alt="">
                                      @endif
                                    @endif
                                  </td>
                                  <td class="text-center previa">{{$reservacion['nombre']}} {{$reservacion['apellido']}} </td>
                                  <td class="text-center previa">{{$reservacion['actividad']}}</td>
                                  <td class="text-center previa">
                                  @if($reservacion['edad'] >= 18)
                                      @if($reservacion['sexo']=='F')
                                          <span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>
                                      @else
                                          <span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>
                                      @endif
                                  @else
                                      @if($reservacion['sexo']=='F')
                                          <span style="display: none">F</span><i class="zmdi fa fa-child f-15 c-rosado"></i> </span>
                                      @else
                                          <span style="display: none">M</span><i class="zmdi fa fa-child f-15 c-azul"></i> </span>
                                      @endif
                                  @endif
                                  </td>
                                  <td class="text-center previa">{{$reservacion['fecha_reservacion']}}</td>
                                  <td class="text-center previa">{{$reservacion['fecha_vencimiento']}}</td>
                                  <td class="text-center">
                                    @if($reservacion['estatus'] == 1)
                                      <ul class="top-menu">
                                        <li class="dropdown" id="dropdown_{{$id}}">
                                            <a id="dropdown_toggle_{{$id}}" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                               <span class="f-15 f-700" style="color:black"> 
                                                    <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                               </span>
                                            </a>

                                              <div class="dropup" dropdown-append-to-body>
                                                <ul class="dropdown-menu dm-icon pull-right" style="z-index: 999">
                                                    <li class="hidden-xs pointer">
                                                        <a class="inscribir"><i class="zmdi zmdi-plus f-20"></i> Inscribir</a>
                                                    </li>

                                                    <li class="hidden-xs pointer">
                                                        <a class="ver_curso"><i class="zmdi zmdi-eye f-20"></i> Ver Curso</a>
                                                    </li>

                                                    <li class="hidden-xs pointer">
                                                        <a class="eliminar"><i class="zmdi zmdi-delete boton red f-20"></i> Eliminar</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>
                                      </ul>
                                    @endif
                                  </td>
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

    route_inscribir="{{url('/')}}/reservaciones/inscribir/";
    route_eliminar="{{url('/')}}/reservaciones/eliminar/";
    route_clase_grupal="{{url('/')}}/agendar/clases-grupales/participantes/";
    route_taller="{{url('/')}}/agendar/talleres/participantes/";
    route_enhorabuena="{{url('/')}}/agendar/clases-grupales/enhorabuena/";

    var estatus = 1
    var tipo_reservacion = ''

    $(document).ready(function(){

      t=$('#tablelistar').DataTable({
        processing: true,
        serverSide: false,
        bLengthChange: false,
        pageLength: 25,    
        order: [[5, 'asc']],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "text-center" );
          $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).addClass( "disabled" );
        },
        drawCallback: function(){
          loadImages();
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

      t
        .columns(0)
        .search(estatus)
        .columns(1)
        .search('')
        .draw();

      
    });

    function loadImages(){
      imagenes = $('.lazy')

      $.each(imagenes, function(){
          var row = $(this).closest('tr')
          var image = this;
          var src = $(image).data('image');
          image.src = src;
      });
    }

    $('#tablelistar tbody').on( 'click', '.ver_curso', function () {

      var row = $(this).closest('tr');
      var id = row.data('actividad_id');
      var tipo = row.data('tipo');

      if(tipo == 1){
        var route = route_clase_grupal + id
      }else{
        var route = route_taller + id
      }
      
      window.open(route, '_blank');
    });

    $('#tablelistar tbody').on( 'click', '.inscribir', function () {

      var id = $(this).closest('tr').attr('id');

      element = this;

      swal({   
          title: 'Desea inscribir al alumno?',   
          text: "Confirmar inscripci??n!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Inscribir!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {  
          inscribir(id,element);
        }
      });
    });
  
    function inscribir(id,element){

      procesando()
      var route = route_inscribir + id;
   
      var token = "{{ csrf_token() }}"
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: id,
        success:function(respuesta){
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){

            finprocesado();
            var nType = 'success';
            var nTitle="Ups! ";
            var nMensaje=respuesta.mensaje;

            notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);

            window.location = route_enhorabuena + respuesta.id;
          
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

    $('#tablelistar tbody').on( 'click', '.eliminar', function () {

      var id = $(this).closest('tr').attr('id');
      element = this;

      swal({   
          title: "Desea eliminar la reservaci??n?",   
          text: "Confirmar eliminaci??n!",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Eliminar!",  
          cancelButtonText: "Cancelar",         
          closeOnConfirm: true 
      }, function(isConfirm){   
        if (isConfirm) {  
          eliminar(id, element);
        }
      });
    });
      
    function eliminar(id, element){
      procesando()
      var route = route_eliminar + id;
      var token = "{{ csrf_token() }}"
      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: id,
        success:function(respuesta){
          var nFrom = $(this).attr('data-from');
          var nAlign = $(this).attr('data-align');
          var nIcons = $(this).attr('data-icon');
          var nAnimIn = "animated flipInY";
          var nAnimOut = "animated flipOutY"; 
          if(respuesta.status=="OK"){
            var nType = 'success';
            var nTitle="Ups! ";
            var nMensaje=respuesta.mensaje;

            t.row( $(element).parents('tr') )
              .remove()
              .draw();

            swal("Exito!","La reservaci??n ha sido eliminada!","success");

            finprocesado()
          
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

    $("#activas").click(function(){
        $( "#finalizadas2" ).removeClass( "c-verde" );
        $( "#activas2" ).addClass( "c-verde" );
    });

    $("#finalizadas").click(function(){
        $( "#finalizadas2" ).addClass( "c-verde" );
        $( "#activas2" ).removeClass( "c-verde" );
    });

    $("input[name='tipo']").on('change', function(){ 
      var estatus = $(this).val()
      t
        .columns(0)
        .search(estatus)
        .columns(1)
        .search(tipo_reservacion)
        .draw();
    });

    $('body').on('click','.reservacion',function(e){
            
        nombre = $(this).data('nombre')
        tipo_reservacion = $(this).attr('value')

        $('#detalle_boton').text(nombre)

        t
        .columns(0)
        .search(estatus)
        .columns(1)
        .search(tipo_reservacion)
        .draw();

        $('#dropdown_boton').removeClass('open')
        $('#detalle_boton').attr('aria-expanded',false);
    });

    $('#tablelistar tbody').on('mouseenter', 'a.dropdown-toggle', function () {

        var id = $(this).closest('tr').attr('id');
        var dropdown = $(this).closest('.dropdown')
        var dropdown_toggle = $(this).closest('.dropdown-toggle')

        $('.dropdown-toggle').attr('aria-expanded','false')
        $('.dropdown').removeClass('open')
        $('.table-responsive').css( "overflow", "auto" );

        if(!dropdown.hasClass('open')){
            dropdown.addClass('open')
            dropdown_toggle.attr('aria-expanded','true')
            $('.table-responsive').css( "overflow", "inherit" );
        }
     
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })

  </script>

@stop