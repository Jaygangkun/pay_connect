<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/dist/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/dist/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/dist/img/favicon-16x16.png">

    <title>Pay Connect Reset Password</title>

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
				<?php if($this->session->flashdata('warning')): ?>
					<div class="alert alert-danger">
						<?=$this->session->flashdata('warning')?>
					</div>
				<?php endif; ?>
                <?php echo form_open(base_url('/reset-password'.'/'.$reset_token), 'class="reset-password-form" '); ?>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="re_password" class="form-control" placeholder="Re-enter Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block" value="save">Save</button>
                    </p>
					<div class="row">
                        <div class="col-12 text-center">            
                            <a href="<?= base_url('/login') ?>">Discard</a>            
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
    <script src="dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets/custom/app.js?v=<?php echo time()?>"></script>
</body>
</html>
