<!-- Daterange picker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
<!-- daterangepicker -->
<script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="card card-primary">
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-sm-4">
						<!-- Date -->
						<div class="form-group row">
							<label for="date_from" class="col-sm-3 col-form-label">From Date:</label>
							<div class="col-sm-9">
								<div class="input-group date" id="date_from" data-target-input="nearest">
									<input type="text" class="form-control datetimepicker-input" data-target="#date_from"/>
									<div class="input-group-append" data-target="#date_from" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>
					</div><!-- /.col -->
					<div class="col-sm-4">
						<!-- Date -->
						<div class="form-group row">
							<label for="date_to" class="col-sm-3 col-form-label">To Date:</label>
							<div class="col-sm-9">
								<div class="input-group date" id="date_to" data-target-input="nearest">
									<input type="text" class="form-control datetimepicker-input" data-target="#date_to"/>
									<div class="input-group-append" data-target="#date_to" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>   
					</div><!-- /.col -->
					<div class="col-sm-2"></div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-primary btn-block" id="btn_search">
						<i class="nav-icon fas fa-search"></i>&nbsp;&nbsp;Search
						</button>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</div>
	</div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Small boxes (Stat box) -->
		<?php
		if($_SESSION['user']['role'] == 1) {
			// Admin
			?>
				<div class="row">
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['processed'] : ''?></h3>

								<p>PROCESSED</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['total'] : ''?></h3>

								<p>TOTAL</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['pending'] : ''?></h3>

								<p>PENDING</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			<?php
		}
		else {
			?>
				<div class="row">
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['processed'] : ''?></h3>

								<p>PROCESSED</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['pending'] : ''?></h3>

								<p>PENDING</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?php echo isset($batch_files) ? $batch_files['acked'] : ''?></h3>

								<p>ACKED</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
			<?php
		}
		?>
		
		<div class="card card-primary">
			<div class="card-body">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<div class="input-group">
							<input type="search" class="form-control" id="search" placeholder="Search">
							<div class="input-group-append">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="col-md-2"></div>
				</div>

				<div class="row mt-4">
					<div class="col-md-12">
						<table id="batch_files" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>S/N</th>
									<th>Settlement Account</th>
									<th>Batch Date</th>
									<th>Batch Reference</th>
									<th>Batch Total Amt</th>
									<th>Batch Currency</th>
									<th>Total Records</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							</tbody>                  
						</table>                
					</div>
				</div>              
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<style>
#batch_files_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
//Date picker
$('#date_from').datetimepicker({
  format: 'L'
});

$('#date_to').datetimepicker({
  format: 'L'
});

var table_batch_files = $('#batch_files').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-load-payment-activities',
    data: function(d) {
      d.date_from = $('#date_from input').val();
      d.date_to = $('#date_to input').val();
    }
  }
});

$(document).on('keyup', '#search', function() {
  console.log($(this).val());
  table_batch_files.search($(this).val()).draw(false);
  // table_batch_files.cell($(this).val()).invalidate();
})

$(document).on('click', '#btn_search', function() {
  table_batch_files.ajax.reload();
})
</script>