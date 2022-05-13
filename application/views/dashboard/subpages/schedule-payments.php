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

  $(document).on('click', '.action-resubmit', function() {
    <?php
    if(ableUpload($_SESSION['user']['role'])) {
      ?>
      var btn_group_wrap = $(this).parents('.btn-group-wrap');
      $(btn_group_wrap).addClass('loading');
      $(btn_group_wrap).find('.btn').addClass('disabled');
      
      $.ajax({
        url: base_url + 'api-submit-batch-file',
        type: 'post',
        dataType: 'json',
        data: {
          id: $(this).attr('data-id')
        },
        success: function(resp) {
          $(btn_group_wrap).removeClass('loading');
          $(btn_group_wrap).find('.btn').removeClass('disabled');
          if(resp.success) {
            table_batch_files.ajax.reload();
          }
          else {
            alert(resp.message);
          }
        }
      })
      <?php
    }
    else {
      ?>
      alert('No Sufficient Privilege to Submit Batch')
      <?php
    }
    ?>
    
  })

  $(document).on('click', '.action-authorise', function() {
    var status = $(this).attr('data-status');
    if(status.toLowerCase() == 'submitted') {
      alert('Batch already Submitted');
      return;
    }
    <?php
    if(ableAuthorise($_SESSION['user']['role'])) {
      ?>
      var btn_group_wrap = $(this).parents('.btn-group-wrap');
      $(btn_group_wrap).addClass('loading');
      $(btn_group_wrap).find('.btn').addClass('disabled');
      $.ajax({
        url: base_url + 'api-authorise-batch-file',
        type: 'post',
        dataType: 'json',
        data: {
          id: $(this).attr('data-id')
        },
        success: function(resp) {
          $(btn_group_wrap).removeClass('loading');
          $(btn_group_wrap).find('.btn').removeClass('disabled');
          if(resp.success) {
            table_batch_files.ajax.reload();
          }
          else {
            alert(resp.message);
          }
        }
      })
      <?php
    }
    else {
      ?>
      alert('No Allowed to Authorise Batch')
      <?php
    }
    ?>
  })

  $(document).on('click', '.action-delete', function() {
    var status = $(this).attr('data-status');
    if(status.toLowerCase() == 'submitted') {
      alert('Cannot delete Submitted Batch');
    }
    else {
      if(confirm('Are you sure to delete?')) {
        $.ajax({
          url: base_url + "api-delete-batch-file",
          type: 'post',
          dataType: 'json',
          data: {
            id: $(this).attr('data-id')
          },
          success: function(resp) {
            if(resp.success) {
              table_batch_files.ajax.reload();
            }
            else {
              alert(resp.message);
            }
          }
        })
      }
    }
  })

</script>