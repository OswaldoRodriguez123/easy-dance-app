@extends('layout.master')

@section('css_vendor')

<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">

@stop


@section('content')
<section id="content">
        <div class="container">
           <div class="block-header">
                <a class="btn-blanco m-r-10 f-16" href="{{url('/')}}/configuracion/coreografias"> <i class="zmdi zmdi-chevron-left zmdi-hc-fw"></i> Sección Coreografia</a>
            </div> 
            
            <h4 class ="c-morado text-right">Coreografia: {{$coreografia->nombre_coreografia}}</h4>
            <br><br><h1 class="text-center c-morado"><i class="zmdi zmdi-wrench p-r-5"></i> Sección de Operaciones</h1>
            <hr class="linea-morada">
            <br>
            <div class="card-body p-b-20">
            <div>

            <div class = "col-sm-4"></div>

			<ul class="ca-menu-c col-sm-4" style="width: 720px;">
        		<li data-ripplecator class ="dark-ripples">
                        <a class="participantes">
                            <span class="ca-icon-c"><i class="icon_a-participantes f-35 boton blue sa-warning" data-original-title="Ver Participantes" type="button" data-toggle="tooltip" data-placement="bottom" title=""></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c f-20">Participantes</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>
                    <li data-ripplecator class ="dark-ripples">
                        <a href="#" class="eliminar">
                            <span class="ca-icon-c"><i  class="zmdi zmdi-delete f-35 boton red sa-warning" name="eliminar" id="{{$id}}" data-original-title="Eliminar" data-toggle="tooltip" data-placement="bottom" title=""  ></i></span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Eliminar</h2>
                                <h3 class="ca-sub-c"></h3>
                            </div>
                        </a>
                    </li>

                    <!--<li>
                        <a href="#">
                            <span class="ca-icon-c">A</span>
                            <div class="ca-content-c">
                                <h2 class="ca-main-c">Exceptional Service</h2>
                                <h3 class="ca-sub-c">Personalized to your needs</h3>
                            </div>
                        </a>
                    </li>-->
                    


                    
                </ul>

                <div class = "col-sm-4"></div>
                
                </div>
            </div>
        </div>
</section>
@stop
@section('js') 
	<script type="text/javascript">

    route_eliminar="{{url('/')}}/configuracion/coreografias/eliminar/";
    route_principal="{{url('/')}}/configuracion/coreografias";

    $(document).ready(function(){

        $('body,html').animate({scrollTop : 0}, 500);
        var animation = 'fadeInUpBig';
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
		function setAnimation(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 2000); 

            console.log("entro");
  }

  function setAnimationRapido(animation, target) {
             $('#'+target).addClass(animation);

            setTimeout(function(){
              $('#'+target).removeClass(animation);
            }, 500); 
  }

  $(".participantes").click(function(){
    
    window.location = "{{url('/')}}/configuracion/coreografias/participantes/{{$id}}";

  });

  $(".eliminar").click(function(){
        id = this.id;
        swal({   
            title: "Desea eliminar la coreografia",   
            text: "Confirmar eliminación!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Eliminar!",  
            cancelButtonText: "Cancelar",         
            closeOnConfirm: false 
        }, function(isConfirm){   
  if (isConfirm) {
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = 'success';
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out')

        eliminar("{{$id}}");
    }
    });
});

function eliminar(id){
     var route = route_eliminar + id;
     var token = $('input:hidden[name=_token]').val();
        
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
            dataType: 'json',
            data:id,
            success:function(respuesta){

                window.location=route_principal; 

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
  setAnimation('fadeInUp', 'content');
	</script>
@stop