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

                    <?php $instructor_id = Session::get('instructor_id');
                          if ($instructor_id){
                            $url = "/instructores/detalle/$instructor_id";
                          }else{
                            $url = "/agendar/clases-personalizadas/progreso/$academia->id";
                          }
                        ?>


                        <a class="btn-blanco m-r-10 f-16" href="{{$url}}"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Volver</a>

                        <!--<h4><i class="zmdi zmdi-accounts-alt p-r-5"></i> Agendar <span class="breadcrumb-ico m-t-10 p-l-5 p-r-5"> <i class="zmdi zmdi-caret-right"></i> </span> <span class="active-state"><i class="flaticon-alumnos"></i> Clases Grupales </span></h4>-->
                    </div> 
                    
                    <div class="card">
                        <div class="card-header text-right">

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="icon_a-clase-personalizada f-25"></i> Sección de Clases Personalizadas</p>
                            <hr class="linea-morada">                                                         
                        </div>




                        
                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">


                              @if(count($clases_personalizadas) > 0)

                                  @foreach($clases_personalizadas as $clase_personalizada)
                  
                                      <div class="pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                                        @if($clase_personalizada->imagen)
                                        <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/clase_personalizada/{{$clase_personalizada->imagen}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                                        @else

                                        <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                                        @endif

                                        <div class="col-sm-7">

                                        <p class="f-25 f-700" style="color:#5e5e5e">{{$clase_personalizada['nombre']}}</p>
                                    
                                        <p class="f-15 f-700">{{ str_limit($clase_personalizada['descripcion'], $limit = 250, $end = '...') }}</p>

                                        <p class="f-15 f-700">{{ number_format($clase_personalizada['costo'], 2, '.' , '.') }}</p>

                                        </div>

                                        <div class="col-sm-3">

                                        <div style="padding-top: 50px">
                                            <button type="button" class="btn btn-blanco m-r-10 f-18 previa" id="{{$clase_personalizada['id']}}">¡ Quiero Reservar Ya !</button>
                                        </div>

                                        </div>

                                                    
                                    
                                    </div>

                                    <div class="clearfix"></div>

                                @endforeach

                                <hr style="margin-top: 1px">

                                @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado clases personalizadas. </div>


                             </div>




                            @endif

                            <br><br><br>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_detalle="{{url('/')}}/agendar/clases-personalizadas/detalle";
    route_enviar="{{url('/')}}/agendar/clases-personalizadas/agregar";
    route_reserva="{{url('/')}}/reservacion/";
  
    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        procesando();

        if("{{Auth::check()}}")
        {
            window.open(route, '_blank');_enviar+"/"+id;
        }

        else{
             var route = route_reserva + 3;
             var token = $('input:hidden[name=_token]').val();
                  
                  $.ajax({
                      url: route,
                          headers: {'X-CSRF-TOKEN': token},
                          type: 'POST',
                      dataType: 'json',
                      data:"&tipo_reservacion=3",
                      success:function(respuesta){

                          window.open(route, '_blank');_reserva+id; 

                      },
                      error:function(msj){
                                  // $("#msj-danger").fadeIn(); 
                                  // var text="";
                                  // console.log(msj);
                                  // var merror=msj.responseJSON;
                                  // text += " <i class='glyphicon glyphicon-remove'></i> Por favor verifique los datos introducidos<br>";
                                  // $("#msj-error").html(text);
                                  // setTimeout(function(){
                                  //          $("#msj-danger").fadeOut();
                                  //         }, 3000);
                                  swal('Solicitud no procesada',msj.responseJSON.error_mensaje,'error');
                                  }


                 });
          
        }

        
      });

    

     </script>

@stop