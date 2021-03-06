
@extends('layout.master')

@section('js_vendor')
    <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
@stop

@section('content')



    <section id="content">

        <div class="container">
        
            <div class="block-header">
                <a class="btn-blanco m-r-10 f-16 volver pointer" onclick="procesando()"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Menú Principal</a>
                <ul class="tab-nav tab-menu" role="tablist" data-menu-color="azul" style="float: right; margin-top: -10px; width: 40%;">
                    <li><a href="#modalParticipantes" class="azul" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-participantes f-30 text-center" style="color:#2196f3;"></div><p style=" font-size: 10px; color:#2196f3;">Participantes</p></a></li>
                                    
                    <li role="presentation" name="agendar"><a class="amarillo" href="#modalAgendar" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-agendar f-30 text-center" style="color:#FFD700;"></div><p style=" font-size: 10px; color:#FFD700;">Agendar</p></a></li>
                                    
                    <li role="presentation"><a href="#modalEspeciales" class="rosa" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_a icon_a-especiales f-30 text-center" style="color:#e91e63;"></div><p style=" font-size: 10px; color:#e91e63;">Especiales</p></a></li>
                                    
                    <li role="presentation"><a class="verde" href="{{url('/')}}/administrativo/pagos/generar" aria-controls="punto_venta" style="padding:0 5px 0 0;"><div class="icon_a icon_a-punto-de-venta f-30 text-center" style="color:#4caf50;"></div><p style=" font-size: 10px; color:#4caf50;">Punto de Venta</p></a></li>
                                   
                    <li role="presentation"><a class="rojo" href="#modalReportes" data-toggle="modal" style="padding:0 5px 0 0;"><div class="icon_d icon_d-reporte f-30 text-center" style="color:#f44336;"></div><p style=" font-size: 10px; color:#f44336;">Reportes</p></a></li>
                </ul>
            </div>
            
            
            <div class="card">

                <div class="clearfix p-b-35"></div>

                <div class="text-center" id="configuracion">
                    <i class="tm-icon zmdi zmdi-settings f-60 text-center c-morado"></i>
                </div>

                <div class="col-md-5"></div>
                    
                <div class="col-md-5"></div>


                <div class="clearfix p-b-35"></div>
                
                <div class="f-700 f-25 text-center">{{Auth::user()->nombre}}  ¿Estás 

                    @if(Auth::user()->sexo == 'M')
                      Preparado
                    @else
                      Preparada
                    @endif

                para personalizar tu academia?</div>
                
                <br>

                <div class="opaco-0-8 f-20 text-center">Con sólo 4 pasos fáciles y listo.</div>

                <div class="clearfix p-b-35"></div>


                <div class="clearfix p-b-35"></div>



                <div class="row">
        			<ul class="ca-menu-j">
        			
        		        <div class="col-sm-12" style="margin-left: 2%">
                    
                            <li>  
                                <a href="{{url('/')}}/configuracion/academia">
                                    <span class="ca-icon-j" > <i class="icon_d-personaliza"></i> </span>
                                    <div class="ca-content-j">
                                        <h2 class="ca-main-j">Personaliza tu academia </h2>
                                        <h3 class="ca-sub-j">Paso 1  </h3>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/')}}/configuracion/clases-grupales" class="mousehand">
                                    <span class="ca-icon-j"><i class="icon_a-clases-grupales"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main-j">Crea tus clases grupales</h2>
                                        <h3 class="ca-sub-j">Paso 2</h3>

                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/')}}/configuracion/clases-personalizadas" class="mousehand">
                                    <span class="ca-icon-j"><i class="icon_a-clase-personalizada"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main-j">Crea tus clases personalizadas</h2>
                                        <h3 class="ca-sub-j">Paso 3</h3>
                                    </div>
                                </a>
                            </li>
                          
        				   <li>
                                <a href="{{url('/')}}/configuracion/herramientas">
                                    <span class="ca-icon-j" style=""><i class="zmdi zmdi-settings"></i></span>
                                    <div class="ca-content-j">
                                        <h2 class="ca-main-j">Herramientas Administrativas</h2>
                                        <h3 class="ca-sub-j">Paso 4</h3>
                                    </div>
                                </a>
                            </li>
        			   </div>
        			 </ul>

                    <div class="clearfix p-b-35"></div>

                    <ul class="ca-menu-j" >
                        <div class="col-sm-12" style="margin-left: 2%">
                        
                            <li style="height: 50px; width: 230px; -moz-transform: none; background-color: white; border: 0px; box-shadow: none">  
                                <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                    <div id="personaliza_tu_academia" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentajeAcademia}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeAcademia}}%;"></div>
                                </div>
                                <p class="text-center f-700" >{{$porcentajeAcademia}} %</p>
                            </li>

                            <li style="height: 50px; width: 230px; -moz-transform: none; background-color: white; border: 0px; box-shadow: none">
                                <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                    <div id="crea_tus_clases_grupales" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentajeGrupales}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeGrupales}}%;"></div>
                                </div>
                                <p class="text-center f-700" >{{$porcentajeGrupales}} %</p>
                            </li>

                            <li style="height: 50px; width: 230px; -moz-transform: none; background-color: white; border: 0px; box-shadow: none">
                               <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                    <div id="crea_tus_clases_personalizadas" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentajePersonalizado}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajePersonalizado}}%;"></div>
                                </div>
                                <p class="text-center f-700" >{{$porcentajePersonalizado}} %</p>
                            </li>

                            <li style="height: 50px; width: 230px; -moz-transform: none; background-color: white; border: 0px; box-shadow: none">
                                <div class="progress progress-striped m-b-10" style="border:1px solid; color:#4E1E43">
                                    <div id="incluye_servicios" class="progress-bar progress-bar-morado" role="progressbar" aria-valuenow="{{$porcentajeServicios}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajeServicios}}%;"></div>
                                </div>
                                <p class="text-center f-700" >{{$porcentajeServicios}} %</p>
                            </li>       
                        </div>
                    </ul>
                                 
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>
                     <div class="clearfix p-b-35"></div>

                </div>
            </div>
        </div>
    </section>			
			  		
				
@stop


@section('js') 

<script>

    $(document).ready(function(){
        if({{$porcentajeAcademia}}==100){
            $("#personaliza_tu_academia").removeClass('progress-bar-morado');
            $("#personaliza_tu_academia").addClass('progress-bar-success');
        }
        if({{$porcentajeGrupales}}==100){
            $("#crea_tus_clases_grupales").removeClass('progress-bar-morado');
            $("#crea_tus_clases_grupales").addClass('progress-bar-success');
        }
        if({{$porcentajePersonalizado}}==100){
            $("#crea_tus_clases_personalizadas").removeClass('progress-bar-morado');
            $("#crea_tus_clases_personalizadas").addClass('progress-bar-success');
        }
        if({{$porcentajeServicios}}>=100){
            $("#incluye_servicios").removeClass('progress-bar-morado');
            $("#incluye_servicios").addClass('progress-bar-success');
        }

        setTimeout(function(){ 

            $('html,body').animate({
                scrollTop: $("#configuracion").offset().top-90,
            }, 1000);

        }, 1000);

    });

    $(".volver").click(function(){

        window.location="/";

    });


    function pocentajecompletado(){

        var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "telefono", "celular", "correo", "direccion"];
        fLen = campo.length;
        var porcetaje=0;
        var cantidad =0;

    }

    function porcentaje(){
    var campo = ["identificacion", "nombre", "apellido", "fecha_nacimiento", "telefono", "celular", "correo", "direccion"];
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

</script>
@stop