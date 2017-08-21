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

                        <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/blog"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Blog</a>

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

                            <br><br><p class="text-center opaco-0-8 f-22"><i class="glyphicon glyphicon-book f-25"></i> Directorio de Blogeros</p>
                            <hr class="linea-morada">                                                         
                        </div>

                        <div class="card-body p-b-20">
                            <div class="row">
                              <div class="container">


                              @if(count($bloggers) > 0)

                                  @foreach($bloggers as $blogger)
                  
                                      <div class="pointer opaco-0-8" style="border: 1px solid rgba(0, 0, 0, 0.1)">

                                        @if($blogger['imagen'])
                                            <div class="col-sm-2"><img src="{{url('/')}}/assets/uploads/bloggers/{{$blogger['imagen']}}" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>
                                        @else

                                            <div class="col-sm-2"><img src="{{url('/')}}/assets/img/EASY_DANCE_3_.jpg" style="line-height: 150px; height:150px; width: 150px; padding: 10px"></div>

                                        @endif

                                        <div class="col-sm-7">

                                            <p class="f-15" style="color:#5e5e5e">{{$blogger['descripcion']}}...</p>

                                            <br>

                                            <div>
                                                
                                                @if($blogger->facebook)
                                                  @if (!filter_var($blogger->facebook, FILTER_VALIDATE_URL) === false) 
                                                    <a href="{{$blogger->facebook}}" target="_blank"><i class="zmdi zmdi-facebook-box f-25 c-facebook m-l-5"></i></a>
                                                  @else
                                                    <a href="https://www.facebook.com/{{$blogger->facebook}}" target="_blank"><i class="zmdi zmdi-facebook-box f-25 c-facebook m-l-5"></i></a>
                                                  @endif
                                                @endif

                                                @if($blogger->twitter)
                                                  @if (!filter_var($blogger->twitter, FILTER_VALIDATE_URL) === false) 
                                                    <a href="{{$blogger->twitter}}" target="_blank"><i class="zmdi zmdi-twitter-box f-25 c-twitter m-l-5"></i></a>
                                                  @else
                                                    <a href="https://www.twitter.com/{{$blogger->twitter}}" target="_blank"><i class="zmdi zmdi-twitter-box f-25 c-twitter m-l-5"></i></a>
                                                  @endif
                                                @endif

                                                @if($blogger->instagram)
                                                  @if (!filter_var($blogger->instagram, FILTER_VALIDATE_URL) === false) 
                                                    <a href="{{$blogger->instagram}}" target="_blank"><i class="zmdi zmdi-instagram f-25 c-instagram m-l-5"></i></a>
                                                  @else
                                                    <a href="https://www.instagram.com/{{$blogger->instagram}}" target="_blank"><i class="zmdi zmdi-instagram f-25 c-instagram m-l-5"></i></a>
                                                  @endif
                                                @endif

                                                @if($blogger->linkedin)
                                                  @if (!filter_var($blogger->linkedin, FILTER_VALIDATE_URL) === false) 
                                                    <a href="{{$blogger->linkedin}}" target="_blank"><i class="zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5"></i></a>
                                                  @else
                                                    <a href="https://www.linkedin.com/{{$blogger->linkedin}}" target="_blank"><i class="zmdi zmdi-linkedin-box f-25 c-linkedin m-l-5"></i></a>
                                                  @endif
                                                @endif

                                                @if($blogger->youtube)
                                                  @if (!filter_var($blogger->youtube, FILTER_VALIDATE_URL) === false) 
                                                    <a href="{{$blogger->youtube}}" target="_blank"><i class="zmdi zmdi-collection-video f-25 c-youtube m-l-5"></i></a>
                                                  @else
                                                    <a href="https://www.youtube.com/{{$blogger->youtube}}" target="_blank"><i class="zmdi zmdi-collection-video f-25 c-youtube m-l-5"></i></a>
                                                  @endif
                                                @endif

                                                @if($blogger->pagina_web)
                                                    @if (!filter_var($blogger->pagina_web, FILTER_VALIDATE_URL) === false) 
                                                      <a href="{{$blogger->pagina_web}}" target="_blank"><i class="zmdi zmdi-google-earth f-25 c-verde m-l-5"></i></a>
                                                    @endif
                                                @endif

                                            </div>

                                        </div>

                                        <div class="col-sm-3">

                                        <div style="padding-top: 50px">
                                            <button type="button" class="btn btn-blanco m-r-10 f-18 previa" id="{{$blogger['id']}}">Ver todos sus posts<i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></button>
                                        </div>

                                        </div>

                                                    
                                    
                                    </div>

                                    <div class="clearfix"></div>

                                @endforeach

                                <hr style="margin-top: 1px">

                                @else

                               <div class="col-sm-10 col-sm-offset-1 error_general" style="padding-bottom: 300px">


                                  <div align="center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x c-morado"></i></div>
                                  <div class="c-morado f-30 text-center"> Ups! lo sentimos, la academia <b>{{$academia->nombre}}</b> actualmente no ha registrado ningun blogero. </div>


                             </div>




                            @endif

                            <br><br><br>
                        
                        
                    </div>
                    
                    
                </div>
            </section>
@stop

@section('js') 
            
    <script type="text/javascript">

    route_entradas="{{url('/')}}/blog/entradas";

    $(document).on( 'click', '.previa', function () {
        var id = this.id;
        procesando();

        window.open(route, '_blank');_entradas+"/"+id;

      });

    

     </script>

@stop