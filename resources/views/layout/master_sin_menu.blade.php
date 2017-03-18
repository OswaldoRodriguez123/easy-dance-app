<!DOCTYPE html>
<html>
    <head>

			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Easy Dance</title>
			
			<!-- Vendor CSS -->
			<link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/bootstrap-dropdownhover.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stylew.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/stimenu.css" />
      <link href="{{url('/')}}/assets/css/css_jn.css" rel="stylesheet">
			
			@yield('css_vendor')
				
			<!-- CSS -->
			<link href="{{url('/')}}/assets/css/app.min.1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/app.min.2.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_0.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_1.css" rel="stylesheet">
			<link href="{{url('/')}}/assets/css/easy_dance_ico_2.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easy_dance_ico_4.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/easy_dance_ico_6.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.min.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/datatable/datatables.bootstrap.css" rel="stylesheet">
      <link href="{{url('/')}}/assets/css/habana.css" rel="stylesheet">

      <link rel='shortcut icon' type='image/x-icon' href='http://easydancelatino.com/img/easy-dance.ico' />

			@yield('css')
		
	</head>
  <body>

		@include('layout.header_sin_menu') 


		<section id="main" data-layout="layout-1">
	
			@yield('content')
		 
		</section>

		

  		<!-- Page Loader -->
          <div class="page-loader">
              <div class="preloader pls-blue">
                  <svg class="pl-circular" viewBox="25 25 50 50">
                      <circle class="plc-path" cx="50" cy="50" r="20" />
                  </svg>

                  <p>Cargando...</p>
              </div>
          </div>
  		
  		<!-- Javascript Libraries -->

      <!-- Procesando -->
      <div id="loader-procesando" tg-loader="" class="loader">
        <div class="progress progress-striped active">
          <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 8px;">
          <span class="sr-only">45% Complete</span>
          </div>
        </div>

      <div class="container">
        <p class="f-25"><div class="clearfix"></div>
        <div class="preloader pl-xl">
          <span class="f-16">Procesando...</span>
          <svg class="pl-circular" viewBox="25 25 50 50">
          <circle class="plc-path" cx="50" cy="50" r="20"></circle>
          </svg>
        </div></p>
        </div>
      </div>

  
<!-- Procesando -->
		
        <script src="{{url('/')}}/assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{url('/')}}/assets/js/bootstrap-dropdownhover.min.js"></script>
        

        <script src="{{url('/')}}/assets/vendors/datatable/jquery.dataTables.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/datatable/datatables.bootstrap.js"></script>
        <script src="{{url('/')}}/assets/js/functions.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/moment/min/moment.min.js"></script>
       
 
        <script src="{{url('/')}}/assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    		<script src="{{url('/')}}/assets/vendors/fileinput/fileinput.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/input-mask/input-mask.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/languages/es.js"></script>

		
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
       
    </body>
</html>