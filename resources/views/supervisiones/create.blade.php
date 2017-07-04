@extends('layout.master')

@section('css_vendor')
<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/farbtastic/farbtastic.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
<link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
<link href="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@stop

@section('js_vendor')
<script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.es.js"></script>-->
<script src="{{url('/')}}/assets/vendors/farbtastic/farbtastic.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
<script src="{{url('/')}}/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

@stop
@section('content')


            <section id="content">
                <div class="container">
                
                    <div class="block-header">
                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/supervisiones" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Supervisión</a>
                        <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">

                            <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                            
                            <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                            
                            <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                            
                            <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                           
                            <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                            
                        </ul>
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="f-25 c-morado"><i class="icon_f-staff f-25" id="id-supervision"></i> Agregar Supervisión</span>                                                         
                        </div>
                        
                        <div class="card-body p-b-20">
                          <form name="agregar_supervision" id="agregar_supervision"  >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row p-l-10 p-r-10">
                            <hr>
                            <div class="clearfix p-b-15"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-supervisor_id">Supervisor</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el supervisor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="select">
                                        <select class="selectpicker bs-select-hidden" name="supervisor_id" id="supervisor_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $staffs as $staff )
                                          <option value = "{{ $staff['id'] }}">{{ $staff['nombre'] }} {{ $staff['apellido'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    <div class="has-error" id="error-supervisor_id">
                                      <span >
                                        <small class="help-block error-span" id="error-supervisor_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                               <div class="clearfix p-b-35"></div>

                               <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-cargo">Cargo a Supervisar</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el cargo a supervisar" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="select">
                                        <select class="selectpicker" name="cargo" id="cargo" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $config_staff as $cargo )
                                          <option value = "{{ $cargo['id'] }}">{{ $cargo['nombre'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    <div class="has-error" id="error-cargo">
                                      <span >
                                        <small class="help-block error-span" id="error-cargo_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                              </div>

                              <div class="clearfix p-b-35"></div>

                              <div class="col-sm-12">
                                 
                                    <label for="cargo" id="id-staff_id">Staff a Supervisar</label> <span class="c-morado f-700 f-16">*</span> <i class="p-l-5 tm-icon zmdi zmdi-help ayuda mousedefault" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Selecciona el supervisor" title="" data-original-title="Ayuda"></i>

                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="icon_f-staff f-22"></i></span>
                                      <div class="select">
                                        <select class="selectpicker" name="staff_id" id="staff_id" data-live-search="true">
                                          <option value="">Selecciona</option>
                                          @foreach ( $staffs_instructores as $staff_instructor )
                                            <option value = "{{$staff_instructor['id']}}-{{$staff_instructor['tipo']}}">{{ $staff_instructor['nombre'] }} / {{ $staff_instructor['cargo'] }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    <div class="has-error" id="error-staff_id">
                                      <span >
                                        <small class="help-block error-span" id="error-staff_id_mensaje" ></small>                                           
                                      </span>
                                    </div>
                                  </div>
                               </div>

                        <div class="clearfix p-b-35"></div>

                    
  

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
                            <div class="col-sm-12 text-left">                           

                              <button type="button" class="btn btn-blanco m-r-10 f-18 guardar" id="guardar" >Guardar</button>

                              <button type="button" class="cancelar btn btn-default" id="cancelar" name="cancelar">Cancelar</button>

                            </div>
                        </div></form>
                    </div>
                </div>
            </div> 

          

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="navbar navbar-default navbar-fixed-bottom">
              <div class="container">
                
                <div class="col-xs-1 p-t-15 f-700 text-center" id="text-progreso" >40%</div>
                <div class="col-xs-11">
                  <div class="clearfix p-b-20"></div>
                  <div class="progress-fino progress-striped m-b-10">
                    <div class="progress-bar progress-bar-morado" id="barra-progreso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  </div>
                </div>
              </div>
            </nav>
@stop
@section('js') 
<script type="text/javascript">

  route_agregar="{{url('/')}}/supervisiones/agregar";
  route_principal="{{url('/')}}/supervisiones";

  var staffs = <?php echo json_encode($staffs);?>;
  var staffs_instructores = <?php echo json_encode($staffs_instructores);?>;
  var checkbox;

  $(document).ready(function(){

    frecuencias = $('input[type="checkbox"].frecuencia');
    supervisiones = $('input[type="checkbox"].supervision');

    $('#fecha').daterangepicker({
            "autoApply" : false,
            "opens": "left",
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

      
        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInDownBig';
        //var cardImg = $(this).closest('#content').find('h1');
        if (animation === "hinge") {
        animationDuration = 3100;
        }
        else {
        animationDuration = 3200;
        }
        //$("h1").removeAttr('class');
        $(".container").addClass('animated '+animation);

            setTimeout(function(){
                $(".card-body").removeClass(animation);
            }, animationDuration);


      });

  setInterval(porcentaje, 1000);

   function porcentaje(){
    var campo = ["staff_id", "supervisor_id", "cargo"];
    fLen = campo.length;
    var porcetaje=0;
    var cantidad =0;
    var porciento= fLen / fLen;
    for (i = 0; i < fLen; i++) {
      var valor="";
      valor=$("#"+campo[i]).val();
      valor=valor.trim();
      if(campo[i]=="color_etiqueta"){
        if ( valor.length > 6 ){        
          cantidad=cantidad+1;
        }else if (valor.length == 0){
          $("#"+campo[i]).val('#');
        }
      }else{
        if ( valor.length > 0 ){        
          cantidad=cantidad+1;
        }
      }
      
    }

    porcetaje=(cantidad/fLen)*100;
    porcetaje=porcetaje.toFixed(2);
    //console.log(porcetaje);
    $("#text-progreso").text(porcetaje+"%");
    $("#barra-progreso").css({
      "width": (porcetaje + "%")
   });
    

    if(porcetaje=="100" || porcetaje=="100.00"){
      $("#barra-progreso").removeClass('progress-bar-morado');
      $("#barra-progreso").addClass('progress-bar-success');
    }else{
      $("#barra-progreso").removeClass('progress-bar-success');
      $("#barra-progreso").addClass('progress-bar-morado');
    }
    //$("#barra-progreso").s

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

            $("#guardar").click(function(){

                var route = route_agregar;
                var token = $('input:hidden[name=_token]').val();
                var datos = $( "#agregar_supervision" ).serialize();

                var inputs = $('.supervision');

                var items_a_evaluar = [];

                $.each(inputs, function (index, array) {
                  if(array.checked){
                    items_a_evaluar.push(array.dataset.id);
                  }
                });

                procesando();     
                limpiarMensaje();

                $.ajax({
                    url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:datos + "&items_a_evaluar="+items_a_evaluar,
                    success:function(respuesta){
                      setTimeout(function(){ 
                        var nFrom = $(this).attr('data-from');
                        var nAlign = $(this).attr('data-align');
                        var nIcons = $(this).attr('data-icon');
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY"; 
                        if(respuesta.status=="OK"){
                          $("#agregar_supervision")[0].reset();
                          window.location = route_principal;
                        }else{
                          var nTitle="Ups! ";
                          var nMensaje="Ha ocurrido un error, intente nuevamente por favor";
                          var nType = 'danger';
                          finprocesado();

                          notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje);
                        }                       
                        
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
      var campo = ["staff_id", "supervisor_id", "cargo"];
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

      function collapse_minus(collaps){
       $('#'+collaps).collapse('hide');
      }

      $('#collapseTwo').on('show.bs.collapse', function () {
        $("#guardar").attr("disabled","disabled");
        $("#guardar").css({"opacity": ("0.2")});
      })

      $('#collapseTwo').on('hide.bs.collapse', function () {
        $("#guardar").removeAttr("disabled");
        $("#guardar").css({"opacity": ("1")});
      })

      $('#supervisor_id').on('change', function(){

        id = $(this).val();

        if(id != ''){
          $("#staff_id option[value='"+id+"-1']").attr("disabled","disabled");
          $("#staff_id option[value='"+id+"-1']").data("icon","glyphicon-remove");
        }

        $("#staff_id option[value!='"+id+"-1']").removeAttr("disabled","disabled");
        $("#staff_id option[value!='"+id+"-1']").data("icon","");

            
        $('#staff_id').selectpicker('refresh');
      });

      $('#staff_id').on('change', function(){

        explode = $(this).val();
        id = explode.split('-')

        if(id != ''){
          if(id[1] == '1'){
            $("#supervisor_id option[value='"+id[0]+"']").attr("disabled","disabled");
            $("#supervisor_id option[value='"+id[0]+"']").data("icon","glyphicon-remove");
            $("#supervisor_id option[value!='"+id[0]+"']").removeAttr("disabled","disabled");
            $("#supervisor_id option[value!='"+id[0]+"']").data("icon","");
          }else{
            $("#supervisor_id option[value!='"+explode+"']").removeAttr("disabled","disabled");
            $("#supervisor_id option[value!='"+explode+"']").data("icon","");
          }
        }

        $('#supervisor_id').selectpicker('refresh');

      });

      $('#cargo').on('change', function(){

        $.each(supervisiones, function (index, array) {
          $(array).prop('checked', false)
          check = $(array).attr('id');
          explode = check.split('_')
          id = explode[1];
          $('#supervision_'+id).val('');
        });

        id = $(this).val();

        $('.supervisiones').hide();
        $('.cargo_'+id).show();
        $('#staff_id').empty();

        var staff = $.grep(staffs_instructores, function(e){ return e.cargo_id == id; });

        $('#staff_id').append( new Option("Selecciona",""));

        $.each(staff, function (index, arreglo) {
          $('#staff_id').append( new Option(arreglo.nombre + ' / ' +  arreglo.cargo,arreglo.id+'-'+arreglo.tipo));
        });

        id = $('#supervisor_id').val();

        if(id != ''){
          $("#staff_id option[value='"+id+"-1']").attr("disabled","disabled");
          $("#staff_id option[value='"+id+"-1']").data("icon","glyphicon-remove");
        }
        
        $("#staff_id option[value!='"+id+"-1']").removeAttr("disabled","disabled");
        $("#staff_id option[value!='"+id+"-1']").data("icon","");
            
        $('#staff_id').selectpicker('refresh');

      });


      $('.frecuencia').on('change', function(){

        $('#frecuencia').val('');
        checked = false;
        $.each(frecuencias, function (index, array) {
          check = $(array).attr('id');
          explode = check.split('_')
          id = explode[1];
          if ($(array).is(":checked")){
            checked = true
            $('#dia_'+id).val(1);
            $('#frecuencia').removeAttr('disabled');
          }else{
            $('#dia_'+id).val(0);
            if(checked == false){
              $('#frecuencia').attr('disabled', 'disabled');
            }
          }   
        });


        $('#frecuencia').selectpicker('refresh');

      });

      $('.supervision').on('change', function(){

        check = $(this).attr('id');
        explode = check.split('_')
        id = explode[1];

        if ($(this).is(":checked")){
          $('#supervision_'+id).val(id);
        }else{
          $('#supervision_'+id).val('');
        }  

      });

      $( "#cancelar" ).click(function() {

        $('html,body').animate({
          scrollTop: $("#id-supervision").offset().top-90,
        }, 2000);

        $("#agregar_supervision")[0].reset();
        $('#supervisor_id').selectpicker('refresh')
        $('#cargo').selectpicker('refresh')
        $('#staff_id').selectpicker('refresh')
        limpiarMensaje();
      });



</script> 
@stop

