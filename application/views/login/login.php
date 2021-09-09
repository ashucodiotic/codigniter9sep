<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css')?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/dist/css/adminlte.min.css')?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css')?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery-confirm.min.css')?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Adhoc</b> Admin</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login In</p>

                <form class="login-form" method="post">
                    <div class="input-group mb-3">
                        <input name="admin_email" type="text" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12 mt-3">
                            <a href="/index.html"><button type="submit" class="btn btn-primary btn-block">Login In</button></a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-secondary">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap-notify.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-confirm.min.js') ?>"></script>
    <!-- AdminLTE for demo purposes -->

    <script type="text/javascript">
        var siteurl = "<?=site_url();?>"

        function showMessage(type,msg){
            var i   = '';
            if (type == 'danger') {
                i   = 'fa fa-exclamation-circle';
            }else if(type == 'success'){
                i   = 'fa fa-check-circle';
            }
            $.notify({
                icon : i,
                message:msg,    
                },{
                    type:type,
                    timer:1000,
                    delay: 5000,
                    placement:{from:'bottom',align:'center'}
                }
              )
        };
    </script>
    
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js')?>"></script>
    <script src="<?= base_url('assets/js/handlebars.js')?>"></script>

    <!-- select 2 start -->
    <script src="<?= base_url('assets/js/select2.min.js')?>"></script>
    <!-- select 2 end -->
    <script src="<?= base_url('assets/js/halper_script.js')?>"></script>
    <script src="<?= base_url('assets/js/validation.js')?>"></script>
    <script src="<?= base_url('assets/js/script.js')?>"></script>


    <script type="text/javascript">

        //add item 
        $('body').on('submit','.login-form',function(e){
          e.preventDefault();
              var password             =   $('body').find('input[name=password]');
              var admin_email              =   $('body').find('input[name=admin_email]');

              password = _passwordReg(password,"Invalid password.")
              admin_email = _emailReg(admin_email,"Invalid email.")

              if (password&&admin_email) {
                  var data    =   new FormData(this);
                  var url     = 'admin-login';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    $(this).trigger('reset')
                    //window.location = "<?=site_url('dashboard')?>";
                  }
              }
          
        });

    </script>

</body>

</html>