<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
    <head>
         <meta charset="utf-8" />
        <title>Login | <?=@$this->site_title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?=site_url('assets/images/favicon.ico')?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="<?=site_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=site_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body class="authentication-bg">
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="<?=site_url()?>" class="mb-5 d-block auth-logo">
                                <img src="<?=site_url(@$this->site_logo)?>" alt="" height="100" class="logo logo-dark">
                                <img src="<?=site_url(@$this->site_logo)?>" alt="" height="100" class="logo logo-light">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to <?=@$this->site_title?>.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="loginform">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" value="<?php if(!empty($remember_me_token)){echo $userdata->username;}?>" id="username" name="username" placeholder="Enter username">
                                        </div>
                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="#" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" id="password" value="<?php if(!empty($remember_me_token)){echo $userdata->password;}?>" name="password" placeholder="Enter password">
                                            <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember_me" value="1" id="remember_me" <?php if(!empty($remember_me_token)){echo 'checked';}?>>
                                            <label class="form-check-label" for="remember_me">Remember me</label>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" onclick="submitLogin()" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p><?=@$this->copyright?></p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <script src="<?=site_url('assets/libs/jquery/jquery.min.js')?>"></script>
        <script src="<?=site_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                input = $(this).parent().find("input");
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        </script>
    <style>.toggle-password {float: right;cursor: pointer;margin-right: 15px;margin-top: -25px;font-size: 14px;}</style>
    <script>
        function submitLogin() {
            $('#loginform').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "<?=site_url('user_controller/backend_login')?>",
                        type: 'POST',
                        data: new FormData(form),
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {
                            $("#loginform").append('<div class="preloaderremove"><div class="preloader"><div class="spinner"></div></div></div>');
                        },
                        success: function(data) {
                            if(data == 'true') {
                                toastr.success('Login Successfully !!!');
                                window.location.href = '<?=site_url('backend')?>';
                            } else if(data == 'emailexist') {
                                toastr.warning('Uername or Password incorrect !!!');
                            } else{
                                toastr.error('Something wrong happened !!!')
                            }
                            $("#loginform .preloaderremove").remove();
                        }
                    });
                }
            });
        }
    </script>
    <style>
        form {
            position: relative;
        }
        .preloaderremove .preloader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(245 246 248 / 62%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9;
        }
        .preloaderremove .spinner {
            border: 4px solid rgba(0, 0, 0, 0.3);
            border-top: 4px solid #4d62c5; 
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    </body>
</html>
