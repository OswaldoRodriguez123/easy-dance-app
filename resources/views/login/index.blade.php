
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Easy Dance</title>

        <!-- Vendor CSS -->
        <link href="{{url('/')}}/assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

            
        <!-- CSS -->
        <link href="{{url('/')}}/assets/css/app.min.1.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/app.min.2.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/flaticon.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/habana.css" rel="stylesheet">
        <link href="{{url('/')}}/assets/css/david.css" rel="stylesheet">

        <link rel='shortcut icon' type='image/x-icon' href='http://easydancelatino.com/img/easy-dance.ico' />

    </head>

    <body class="login-content" >

        <!-- Login -->

        <!--<div class="lc-block toggled" id="l-login" style="padding:0px 0px 0px 0px; background: #4E1E43 !important;margin-bottom:0px;">
             <img src="{{url('/')}}/assets/img/logo.png" width="200" >
        </div>-->
        <div id="formlogin" >
        
        <div class="lc-block toggled"  style="padding:0px 0px 0px 0px; background: #4E1E43 !important;margin-bottom:10px; vertical-align: top; box-shadow: none;">
             <img id="imagen" src="{{url('/')}}/assets/img/logo.png" width="200" >
        </div><div class="clearfix"></div>
        <div class="lc-block toggled" id="l-login" style="margin-top:10px;vertical-align: top;">
             
             
       
            <!-- <form id="FormLogin"> -->
            <form  name="agregar" method="POST" action="{{ url('/login') }}" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="input-group m-b-30">
                    <span class="input-group-addon"><i class="zmdi zmdi-account zmdi-hc-2x"></i></span>
                    <div class="fg-line">

                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="input-group m-b-30">
                    <span class="input-group-addon"><i class="zmdi zmdi-lock zmdi-hc-2x"></i></span>
                    <div class="fg-line">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                
                <div class="clearfix"></div>
                
<!--                 <div class="col-sm-6">
                    <div class="checkbox">
                        <label class="f-14">
                            <input type="checkbox" value="">
                            <i class="input-helper"></i>
                            Recordarme
                        </label>
                    </div>
                </div> -->

                <div class="col-sm-6 ">
                    <label class="m-b-30 p-t-5 f-14">
                        <a href="{{url('/')}}/restablecer" data-block="#l-forget-password">Olvidaste tu contraseña?</a> 
                    </label>

                    <!--<ul class="login-navigation">
                        <li data-block="#l-forget-password" ><a href="">Olvidaste tu contraseña?</a></li>
                        <li data-block="#l-forget-password" class="bgm-orange">Forgot Password?</li>
                    </ul>-->

                </div>

                <button type= "submit" class="btn btn-login bgm-morado btn-float opaco-0-8"><i class="zmdi zmdi-arrow-forward"></i></button>
                @if (count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class = "help-block error-span c-youtube">{!! $error !!}</li>
                        @endforeach
                    </ul>
                @endif 

                @if(session('alert_confirmacion'))
                    <ul>
                        <li class = "help-block error-span c-youtube">{{ session('alert_confirmacion') }}</li>
                    </ul>
                @endif  
            


            </form>

            </div>



        </div>
        

        <!-- Forgot Password -->
        <div class="lc-block" id="l-forget-password">
            <div class="text-center f-18 f-700">No te preocupes</div>
            <p class="text-center f-16">Vamos a encontrar tu cuenta</p>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>
            
            <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>
            
            <!--<ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Login</li>
                <li data-block="#l-register" class="bgm-red">Register</li>
            </ul>-->
        </div>        


        <footer id="footer" style="padding-top: 20px;">

            <div class=" p-10 footer-text">
            <p> <b><a href="http://easydancelatino.com/" target="_blank" > www.easydancelatino.com </a></b></p> 


            <p class="f-35" >
                <a href="https://www.facebook.com/Easydancelatino/" target="_blank" title="Facebook">
                    <i class="zmdi zmdi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/easydancelatino/" target="_blank" title="Instagram">
                    <i class="zmdi zmdi-instagram"></i>
                </a>
                <a href="https://twitter.com/EasyDanceLatino" target="_blank" title="Twitter" >
                    <i class="zmdi zmdi-twitter" ></i>
                </a> 
                <a href="https://plus.google.com/u/0/104687135628887176910" target="_blank" title="Google+" >
                    <i class="zmdi zmdi-google-plus"></i>
                </a>
            </p>

        </footer>

        <!-- Register -->
        <!--<div class="lc-block" id="l-register">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Username">
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">
                    <i class="input-helper"></i>
                    Accept the license agreement
                </label>
            </div>
            
            <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>
            
            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Login</li>
                <li data-block="#l-forget-password" class="bgm-orange">Forgot Password?</li>
            </ul>
        </div>-->
        



        <!-- Forgot Password -->
        <!--<div class="lc-block" id="l-forget-password" data-ng-class="{ 'toggled': lctrl.forgot === 1 }" data-ng-if="lctrl.forgot === 1">
            <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>

            <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>

            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green" data-ng-click="lctrl.forgot = 0; lctrl.login = 1">Login</li>
                <li data-block="#l-register" class="bgm-red" data-ng-click="lctrl.forgot = 0; lctrl.register = 1">Register</li>
            </ul>
        </div>-->

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->



        <!-- Javascript Libraries -->
        <script src="{{url('/')}}/assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="{{url('/')}}/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>


        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="{{url('/')}}/assets/js/functions.js"></script>
        <script src="{{url('/')}}/assets/js/demo.js"></script>


    <!--<script type="text/javascript">

    route_login="{{url('/')}}/login";

        $("#logearme").on('click', function(){

            var route = route_login;
            var token = $('input:hidden[name=_token]').val();
            var datos = $( "#FormLogin" ).serialize();             
            //alert(datos);

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: datos,
                success: function(respuesta){
                    if(respuesta.status == 'success'){
                        window.location.href = '{{url('/')}}';
                    }
                    //console.log(datos);
                },
                error: function(msj){
                    if(msj.responseJSON.status=="ERROR CONTRASENA" || msj.responseJSON.status=='ERROR CORREO'){
                        //alert('Correo o Contraseña incorrectos, Intente de nuevo');

                        var nTitle=" Ups! ";
                        var nMensaje="Correo o Contraseña incorrectos, Intente de nuevo";
                        var nType = 'danger';
                    }else{
                        var nTitle="Ups! ";
                        var nMensaje="Ha ocurrido un error inesperado, Intente de nuevo";
                        var nType = 'danger';                        
                    }

                        var nFrom = 'top'; //$(this).attr('data-from');
                        var nAlign = 'center'; //$(this).attr('data-align');
                        var nIcons = 'zmdi zmdi-assignment-account zmdi-hc-2x'; //$(this).attr('data-icon');
                        var nType = 'danger';
                        var nAnimIn = "animated flipInY";
                        var nAnimOut = "animated flipOutY";                       
                        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut,nMensaje,nTitle);

                }
            })


        });


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


    </script>-->

         <script type="text/javascript">
            $(document).ready(function(){
                @if (count($errors) > 0)
                    var animation = 'shake';
                    var cardImg = $('#formlogin');
                    if (animation === "hinge") {
                        animationDuration = 20100;
                    }
                    else {
                        animationDuration = 20200;
                    }
                    
                    cardImg.removeAttr('class');
                    cardImg.addClass('animated '+animation);
                    
                    setTimeout(function(){
                        cardImg.removeClass(animation);
                    }, animationDuration);
                @endif                
            });
        </script>

        
    </body>
</html>
