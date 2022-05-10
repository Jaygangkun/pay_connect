<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/dist/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/dist/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/dist/img/favicon-16x16.png">

    <title>Pay Connect Recovery Password</title>

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
            	<a href="index.html" class="h1"><img src="<?= base_url() ?>assets/dist/img/logo.png" style="width:100%"/></a>
            </div>
            <div class="card-body">
				<?php if($this->session->flashdata('warning')): ?>
					<div class="alert alert-danger">
						<?=$this->session->flashdata('warning')?>
					</div>
				<?php endif; ?>
				<?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success">
						<?=$this->session->flashdata('success')?>
					</div>
				<?php endif; ?>
				<?php echo form_open(base_url('/recovery-password'), 'class="recovery-password-form" id="recovery_password_form"'); ?>
					<div class="input-group mb-3">
						<input type="email" class="form-control" name="email" placeholder="Email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" name="submit" value="send" id="btn_send" class="btn btn-primary btn-block">Send</button>
						</div>
						<!-- /.col -->
					</div>

					<div class="row mt-2">
						<div class="col-12">
							<p class="text-right">Didn't Receive OTP? <a href="javascript:void(0)" id="btn_resend">Resend</a></p>
						</div>
					</div>
				<?php echo form_close(); ?>
				<p class="mt-3 mb-1 text-center">
					<a href="<?= base_url('/login') ?>">Login</a>
				</p>
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
	<script>
	$(document).on('click', '#btn_resend', function() {
		// $('#recovery_password_form').submit();
		$('#btn_send').trigger('click');
	})
	</script>
</body>
</html>
