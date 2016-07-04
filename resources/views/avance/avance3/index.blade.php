
@extends('layout.master')
 @section('css')
<link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
@stop
<div class="myback2">   
@section('content')
 <section class="myback2" >
 <h2 class="titulotest22 f-30" > Easy dance, es la nueva aplicación del baile que te hace la vida más fácil  </h2>
  <br><br><br><br>
   <div align="center" >
   <div class="i-tools-container">
 <div class="i-videoprom" >
video promo
 </div>
  <div class="i-videopromtext" >
<text> Desde la aplicación podrás </text><br><br>
<text>Reservación de  clases </text><br>
<text>Adquirir tarjetas de regalo </text><br>
<text>Agendar clases  grupales y privadas </text><br>
<text>Verificar tus pagos en línea. </text><br>
<text>Y mucho más…. </text><br>
 </div>
  </div>
<br><br><br>
</div><br><br><br>
<div class="myback"><br> 
 <h2 class="titulotest22 f-25" > Clases grupales en tu academia   </h2>
 
 
 
   <div class="i-tools-container">
    <!-- ngRepeat: tool in tools --><div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="i-tools-svg"><svg-icon class="ng-isolate-scope" icon="icon-icon-flag"><svg><use xlink:href="#icon-icon-flag"></use></svg></svg-icon></div>
      
      <div>
         <div class="i-tools-header ng-binding" align="center">acciones</div>
       <!--  <div class="i-tools-description ng-binding">acciones</div>-->
      </div>
    </div><!-- end ngRepeat: tool in tools --><div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="i-tools-svg"><svg-icon class="ng-isolate-scope" icon="icon-icon-share"><svg><use xlink:href="#icon-icon-share"></use></svg></svg-icon></div>
      
      <div>
        <div class="i-tools-header ng-binding" align="center">acciones</div>
       <!--  <div class="i-tools-description ng-binding">acciones</div>-->
	   </div>
    </div><!-- end ngRepeat: tool in tools --><div class="i-tools-card ng-scope" ng-repeat="tool in tools" ng-click="showModal(tool.view)">
      <div class="i-tools-svg"><svg-icon class="ng-isolate-scope" icon="icon-icon-analytics"><svg><use xlink:href="#icon-icon-analytics"></use></svg></svg-icon></div>
    
      <div>
       <div class="i-tools-header ng-binding" align="center">acciones</div>
       <!--  <div class="i-tools-description ng-binding">acciones</div>-->
	   </div>
   


</div>
</div>
<br><br>
   <div class="text-center">
   <br><br>
    <a class="btn-blanco2" href="">Ver más </a>
   <br><br>  <br><br>
</div>
</div>







  <div class="myback2">
    <br> 
 <h2 class="titulotest22 " > Prueba hoy  </h2>
  <h2 class="titulotest22 " >Obséquiale una Giftcard de baile  a la persona que quieres   </h2>
   <h2 class="titulotest22 " >Y que empiece a bailar contigo   </h2>
   <div class="text-center">
   <br><br>
    <a class="btn-blanco2" href="">Dar regalo </a>
   <br><br>
</div>
</div>























</section>



 




@stop


@section('js') 
            
		
		
	</div>	

@stop

  