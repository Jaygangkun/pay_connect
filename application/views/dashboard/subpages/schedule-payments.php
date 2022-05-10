<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-body">
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
                  <th>Action</th>  
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
<script>
  var table_batch_files = $('#batch_files').DataTable({
		"pagingType": 'full_numbers',
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
    'ajax': {
      url: base_url + 'api-load-batch-files-submitted',
    }
	});

  $(document).on('click', '.action-view', function() {
    location.href = base_url + 'batch-file-view/' + $(this).attr('data-id');
  })
</script>