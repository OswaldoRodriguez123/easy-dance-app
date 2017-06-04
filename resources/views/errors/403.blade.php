
<!DOCTYPE html>
    <html class="login-content" data-ng-app="materialAdmin">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Material Admin</title>

        <!-- Vendor CSS -->
        <link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

            
        <!-- CSS -->
        <link href="{{url('/')}}/assets/css/app.min.1.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/app.min.2.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/flaticon.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/easydance.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/david.css" rel="stylesheet">

    </head>

    <body class="four-zero-content" >

        <div class="four-zero">
            <h2>ERROR 403</h2>
            <small>Acceso Prohibido</small>
            
            <footer>
                <a href="{{url()->previous()}}"><i class="zmdi zmdi-arrow-back"></i></a>
                <a href="{{url('/')}}"><i class="zmdi zmdi-home"></i></a>
            </footer>
        </div>

        
    </body>
</html>
