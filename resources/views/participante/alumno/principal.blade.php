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

        <a href="{{url('/')}}/participante/alumno/agregar" class="btn bgm-green btn-float waves-effect m-btn"><i class="zmdi zmdi-plus"></i></a>
        <section id="content">
            <div class="container">
            
                <div class="block-header">
                    <a class="btn-blanco m-r-10 f-16" href="/" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>

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
                        <div class ="col-md-6 text-left">  
                            <ul class="top-menu p-l-40">
                                <li class="dropdown ">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft">
                                       <span class="f-15 f-700" style="color:black"> 
                                            <i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=''></i>
                                       </span>
                                    </a>
                                    <ul class="dropdown-menu dm-icon pull-right">
                                        <li class="hidden-xs">
                                            <a onclick="procesando()" href="{{url('/')}}/participante/alumno/eliminados"><i name="eliminados" id="eliminados" class="tm-icon zmdi zmdi-delete boton red f-25 pointer eliminados detalle"></i>&nbsp;Bandeja Eliminados</a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a onclick="procesando()" href="{{url('/')}}/participante/alumno/inactivos"><i name="inactivos" id="inactivos" class="tm-icon zmdi zmdi-label-alt-outline f-25 pointer inactivos detalle"></i> Bandeja Inactivos</a>
                                        </li>

                                        <li class="hidden-xs">
                                            <a onclick="procesando()" href="{{url('/')}}/participante/alumno/congelados"><i name="congelados" id="congelados" class="tm-icon zmdi zmdi-close-circle-o f-25 pointer congelados detalle"></i> Bandeja Congelados</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class ="col-md-6 text-right">                                

                            <span class="f-16 p-t-0 text-success">Agregar un Alumno <i class="p-l-5 zmdi zmdi-arrow-right zmdi-hc-fw f-25 "></i></span>

                        </div>

                        <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-alumnos f-25"></i> Sección de Alumnos</p>
                        <hr class="linea-morada">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nombre">Sexo</label>
                                <div class="fg-line">
                                  <div class="select">
                                    <select class="selectpicker" name="sexo" id="sexo" data-live-search="true">
                                        <option value = "T">Todos</option>
                                        <option value = "F">Mujeres</option>
                                        <option value = "M">Hombres</option>
                                    </select>
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div> 
                                                     
                    </div>
                    <div class="table-responsive row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered text-center " id="tablelistar" >
                            <thead>
                                <tr>
                                    <th class="text-center" data-column-id="confirmacion" data-type="numeric"></th>
                                    <th class="text-center" data-column-id="imagen">Imagen</th>
                                    <th class="text-center" data-column-id="id" data-type="numeric">Id</th>
                                    <th class="text-center" data-column-id="sexo">Sexo</th>
                                    <th class="text-center" data-column-id="nombre" data-order="desc">Nombres</th>
                                    <th class="text-center" data-column-id="estatu_e">Balance E</th>
                                    <th class="text-center" data-column-id="operacion">Acciones</th>
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

        route_detalle="{{url('/')}}/participante/alumno/detalle";
        route_operacion="{{url('/')}}/participante/alumno/operaciones";
        route_email="{{url('/')}}/correo/sesion";
        route_eliminar="{{url('/')}}/participante/alumno/eliminar/";
        route_principal="{{url('/')}}/participante/alumno";
        route_agregar="{{url('/')}}/participante/alumno/crear_cuenta/";
        route_listado = "{{url('/')}}/participante/alumno/listado"
        host = location.host
        var t
        var token = '{{ csrf_token() }}';
        $('#tablelistar').DataTable();
        
        getListado()

        function getListado(){
            procesando()
            $.ajax({
                url: route_listado,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                success:function(respuesta){
                    t = $('#tablelistar').DataTable({
                        data: respuesta,
                        processing: true,
                        serverSide: false,
                        pageLength: 25,    
                        deferRender: true,
                        order: [[4, 'asc']],
                        destroy: true,
                        drawCallback: function(){
                            loadImages();
                        },
                        columns: [
                            { data: 'activacion' },
                            { data: 'imagen' },
                            { data: 'identificacion' },
                            { data: 'edad' },
                            { data: 'nombre' },
                            { data: 'deuda' },
                            { data: 'deleted_at' },
                        ],
                        'createdRow': function( row, data, dataIndex ) {
                            id = data.id;
                            deuda = data.deuda
                            if(data.imagen != ''){
                                imagen = '/assets/uploads/usuario/'+data.imagen;
                            }else{
                                if(data.sexo == 'F'){
                                    imagen = '/assets/img/Mujer.jpg';
                                }else{
                                    imagen = '/assets/img/Hombre.jpg';
                                }
                            }
                            contenido =     '<p class="c-negro">'
                            contenido +=        data.nombre + ' ' + data.apellido + ' ' + ' ' +  '<img class="lv-img-lg" src="'+imagen+'" alt=""><br><br>'
                            contenido +=        'Cantidad que adeuda: ' + deuda  + '<br>'
                            contenido +=        'Número Móvil: ' + data.celular + '<br>'
                            contenido +=        'Correo Electrónico: ' + data.correo + '<br>'
                            contenido +=        'Edad: ' + data.edad + '<br>'
                            contenido +=    '</p>';

                            if(data.deleted_at == null){
                                tipo = 1
                                seleccion = 'seleccion'
                            }else{
                                tipo = 2
                                seleccion = 'seleccion seleccion_deleted'
                            }
                            $(row)
                                .data('trigger','hover')
                                .data('toggle','popover')
                                .data('placement','top')
                                .data('content',contenido)
                                .data('original-title',"Ayuda &nbsp;&nbsp;&nbsp;&nbsp;")
                                .data('html',"true")
                                .data('container',"body")
                                .data('tipo',tipo)
                                .addClass('text-center')
                                .addClass(seleccion)
                                .attr("id", id);
                        },
                        "columnDefs": [
                            {
                                "targets": 0,
                                "render": function (data, type, row) {
                                    if(data != '') {
                                        activacion = '<i class="zmdi zmdi-alert-circle-o zmdi-hc-fw c-youtube f-20" data-html="true" data-original-title="" data-content="Cuenta sin confirmar" data-toggle="popover" data-placement="right" title="" type="button" data-trigger="hover"></i>';
                                    }else{
                                        activacion = ''
                                    }
                                    return "<div class='previa'>"+ activacion +"</div>";
                                }
                            },
                            {
                                "targets": 1,
                                "render": function (data, type, row) {
                                    if(data != '') {
                                        imagen = '<img class="lv-img lazy" src="/assets/img/Hombre.jpg" data-image = "/assets/uploads/usuario/'+data+'" alt="">';
                                    }else{
                                        if(row.sexo == 'M') {
                                            imagen = '<img class="lv-img lazy" src="/assets/img/Hombre.jpg" data-image = "/assets/img/Hombre.jpg" alt="">'
                                        }else{
                                            imagen = '<img class="lv-img lazy" src="/assets/img/Hombre.jpg" data-image = "/assets/img/Hombre.jpg" alt="">'
                                        }
                                    }
                                    return "<div class='previa'>"+ imagen +"</div>";
                                }
                            },
                            {
                                "targets": 2,
                                "render": function (data, type, row) {
                                    return "<div class='previa'>"+ data +"</div>";
                                }
                            },
                            {
                                "targets": 3,
                                "render": function (data, type, row) {
                                    if(data >= 18) {
                                        if(row.sexo == 'F') {
                                            sexo = '<span style="display: none">F</span><i class="zmdi zmdi-female f-25 c-rosado"></i> </span>'
                                        }else{
                                            sexo = '<span style="display: none">M</span><i class="zmdi zmdi-male-alt f-25 c-azul"></i> </span>'
                                        }
                                    }else{
                                        if(row.sexo == 'F') {
                                            sexo = '<span style="display: none">F</span><i class="zmdi fa fa-child f-15 c-rosado"></i> </span>'
                                        }else{
                                            sexo = '<span style="display: none">M</span><i class="zmdi fa fa-child f-15 c-azul"></i> </span>'
                                        }
                                    }
                                    return "<div class='previa'>"+ sexo +"</div>";
                                }
                            },
                            {
                                "targets": 4,
                                "render": function (data, type, row) {
                                    nombre = row.nombre
                                    nombre = nombre.split(' ');
                                    nombre = nombre[0];
                                    apellido = row.apellido
                                    apellido = apellido.split(' ');
                                    apellido = apellido[0];
                                    return "<div class='previa'>"+ nombre + ' ' + apellido +"</div>";
                                }
                            },
                            {
                                "targets": 5,
                                "render": function (data, type, row) {
                                    if(data > 0) {
                                        deuda = '<i class="zmdi zmdi-money c-youtube zmdi-hc-fw f-20 p-r-3"></i>';
                                    }else{
                                        deuda = '<i class="zmdi zmdi-money c-verde zmdi-hc-fw f-20 p-r-3"></i>';
                                    }
                                    return "<div class='previa'>"+ deuda +"</div>";
                                }
                            },
                            {
                                "targets": 6,
                                "render": function (data, type, row) {
                                    id = row.id;
                                    if(data == null){
                                        Acciones = ''
                                        Acciones += '<ul class="top-menu">';
                                        Acciones +=     '<li class="dropdown" id="dropdown_"'+id+'>'
                                        Acciones +=         '<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="fadeInLeft fadeInLeft fadeInLeft fadeInLeft" id="dropdown_toggle_'+id+'">'
                                        Acciones +=             '<span class="f-15 f-700" style="color:black">'
                                        Acciones +=                 '<i id ="pop-operaciones" name="pop-operaciones" class="zmdi zmdi-wrench f-20 mousedefault" aria-describedby="popoveroperaciones" data-html="true" data-toggle="popover" data-placement="top" title="" type="button" data-original-title="" data-content=""></i>'
                                        Acciones +=             '</span>'
                                        Acciones +=         '</a>'
                                        Acciones +=         '<div class="dropup">'
                                        Acciones +=             '<ul class="dropdown-menu dm-icon pull-right">'

                                        if(row.deuda > 0){
                                            Acciones +=             '<li class="hidden-xs">'
                                            Acciones +=                 '<a href="/participante/alumno/deuda/'+id+'"><i class="icon_a-pagar f-16 m-r-10 boton blue"></i> Pagar</a>'
                                            Acciones +=             '</li>'
                                        }
                                        if(row.usuario){
                                            Acciones +=             '<li class="hidden-xs email pointer">'
                                            Acciones +=                 '<a><i class="zmdi zmdi-email f-16 boton blue"></i> Enviar Correo</a>'
                                            Acciones +=             '</li>'
                                        }else{
                                            Acciones +=             '<li class="hidden-xs usuario pointer">'
                                            Acciones +=                 '<a><i class="zmdi zmdi-alert-circle-o f-16 boton blue"></i> Crear Cuenta</a>'
                                            Acciones +=             '</li>'
                                            Acciones +=             '<li class="hidden-xs email pointer" style="display:none">'
                                            Acciones +=                 '<a><i class="zmdi zmdi-email f-16 boton blue"></i> Enviar Correo</a>'
                                            Acciones +=             '</li>'
                                        }

                                        Acciones +=                 '<li class="hidden-xs">'
                                        Acciones +=                     '<a href="/participante/alumno/transferir/'+id+'"><i class="zmdi zmdi-trending-up f-16 boton blue"></i> Transferir</a>'
                                        Acciones +=                 '</li>'
                                        
                                        Acciones +=                 '<li class="hidden-xs">'
                                        Acciones +=                     '<a href="/participante/alumno/evaluaciones/'+id+'"><i class="zmdi glyphicon glyphicon-search f-16 boton blue"></i>Valoración</a>'
                                        Acciones +=                 '</li>'

                                        Acciones +=                 '<li class="hidden-xs">'
                                        Acciones +=                     '<a href="/participante/alumno/llamadas/'+id+'"><i class="zmdi zmdi-phone f-16 boton blue"></i>Llamadas</a>'
                                        Acciones +=                 '</li>'

                                        Acciones +=                 '<li class="hidden-xs reservar pointer">'
                                        Acciones +=                     '<a><i class="zmdi icon_a-reservaciones f-16 boton blue"></i>Reservar</a>'
                                        Acciones +=                 '</li>'

                                        Acciones +=                 '<li class="hidden-xs eliminar pointer">'
                                        Acciones +=                     '<a><i class="zmdi zmdi-delete boton red f-20 boton red sa-warning"></i> Eliminar</a>'
                                        Acciones +=                 '</li>'

                                        Acciones +=             '</ul>'
                                        Acciones +=         '</div>'
                                        Acciones +=     '</li>'
                                        Acciones += '</ul>'
                                    }else{
                                        Acciones  = ''
                                    }
                                    return "<div style='text-align: center'>"+ Acciones +"</div>";
                                }
                            },
                        ],
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
                }
            });
            $('[data-toggle="popover"]').popover(); 
            finprocesado();
        }

        function loadImages(){
            imagenes = $('.lazy')

            $.each(imagenes, function(){
                var row = $(this).closest('tr')
                var image = this;
                var src = $(image).data('image');
                image.src = src;
            });
        }
        
        $(document).on('click', '.previa', function () {
            var row = $(this).closest('tr');
            var tipo = row.data('tipo');

            if(tipo == '1'){
                var id = row.attr('id');
                var route =route_detalle+"/"+id;
                window.open(route, '_blank');
            }
        });

        $("i[name=operacion").click(function(){
            var route =route_operacion+"/"+this.id;
            window.open(route, '_blank');;
        });

        $('#sexo').on('change', function(){

            if($(this).val() == 'T'){

                t
                .columns(3)
                .search('')
                .draw(); 

            }else{

                t
                .columns(3)
                .search($(this).val())
                .draw();

            }
    
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

        $('#tablelistar tbody').on('click', '.email', function () {

            var route = route_email;
            var id = $(this).closest('tr').attr('id');
                
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data:"&usuario_tipo=1&usuario_id="+id,
                success:function(respuesta){

                    procesando();
                    window.location="{{url('/')}}/correo/"+id  

                },
                error:function(msj){
                     
                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                }
            });
        });

        $('#tablelistar tbody').on('click', '.reservar', function () {

            procesando();
            var route = "{{url('/')}}/reservacion/guardar-tipo-usuario/1";
            var id = $(this).closest('tr').attr('id');
                
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                success:function(respuesta){
                    window.location = "{{url('/')}}/reservaciones/actividades/"+id

                },
                error:function(msj){
                    finprocesado();
                    swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                }
            });
        });

        $('#tablelistar tbody').on('click', '.eliminar', function () {
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea eliminar al alumno?",   
                text: "Confirmar eliminación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Eliminar!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
                if (isConfirm) {
                    var route = route_eliminar + id;
                        
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'DELETE',
                        dataType: 'json',
                        data:id,
                        success:function(respuesta){
                            procesando();
                            window.location = route_principal; 

                        },
                        error:function(msj){
                            swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                        }
                    });
                }
            });
        });

        $('#tablelistar tbody').on('click', '.usuario', function () {
            element = this;
            var id = $(this).closest('tr').attr('id');
            swal({   
                title: "Desea crearle la cuenta al alumno?",   
                text: "Confirmar creación!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Crear!",  
                cancelButtonText: "Cancelar",         
                closeOnConfirm: true 
            }, function(isConfirm){   
                if (isConfirm) {

                    procesando();
                    var route = route_agregar + id;
                        
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        success:function(respuesta){
                            finprocesado();
                            swal('Exito!','La cuenta ha sido creada','success');
                            $(element).hide();
                            $(element).closest('tr').find('.email').show();

                        },
                        error:function(msj){
                          swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                          finprocesado();
                        }
                    });
                }
            });
        });

    </script>

@stop