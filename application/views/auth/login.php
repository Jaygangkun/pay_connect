<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/dist/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/dist/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/dist/img/favicon-16x16.png">

    <title>Pay Connect Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="mb-1 text-right">
            <a href="#" target="_blank">FAQ</a>
        </div>
    
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url() ?>" class="h1"><img src="<?= base_url() ?>assets/dist/img/logo.png" style="width:100%"/></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login to the Portal</p>
                <?php if($this->session->flashdata('warning')): ?>
                    <div class="alert alert-danger">
                    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> -->
                    <?=$this->session->flashdata('warning')?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?=$this->session->flashdata('success')?>
                    </div>
                <?php endif; ?>
                <?php echo form_open(base_url('/login'), 'class="login-form" '); ?>
                    <div class="input-group mb-3">
                        <input type="text" name="user_name" class="form-control" placeholder="User Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <p class="mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block" value="login">Login</button>
                    </p>

                    <div class="row">
                        <div class="col-12 text-center">            
                            <a href="<?= base_url('/recovery-password') ?>">Forgot Password</a>            
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets/custom/app.js?v=<?php echo time()?>"></script>
</body>
</html>
