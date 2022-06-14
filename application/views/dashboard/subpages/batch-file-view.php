<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <h3>Processing Status:
            <?php
            echo "<span class='text-".statusColor($batch_file['status'])."'>".$batch_file['status']."</span>";
            ?>
            </h3>
            <div class="form-group">
                <label for="batch_ref">File Name</label>
                <div class="input-group">
                    <input type="text" name="batch_ref" id="batch_ref" class="form-control" readonly value="<?php echo isset($batch_file) ? $batch_file['file_name'] : ''?>">
                </div>
            </div>
            <div class="form-group">
                <label for="batch_ref">Uploaded Date/Time</label>
                <div class="input-group">
                    <input type="text" name="batch_ref" id="batch_ref" class="form-control" readonly value="<?php echo isset($batch_file) ? $batch_file['date'] : ''?>">
                </div>
            </div>
            <div class="form-group">
                <label for="batch_ref">Records in Batch</label>
                <div class="input-group">
                    <input type="text" name="batch_ref" id="batch_ref" class="form-control" readonly value="<?php echo isset($batch_file) ? $batch_file['total_records'] : ''?>">
                </div>
            </div>
            <div class="form-group">
                <label for="batch_ref">Total Amount</label>
                <div class="input-group">
                    <input type="text" name="batch_ref" id="batch_ref" class="form-control" readonly value="<?php echo isset($batch_file) ? $batch_file['currency'] : ''?>">
                    <input type="text" name="batch_ref" id="batch_ref" class="form-control" readonly value="<?php echo isset($batch_file) ? $batch_file['batch_amount'] : ''?>">
                </div>
            </div>
            <div class="form-group">
                <label for="batch_ref">Error Message</label>
                <div class="input-group">
                    <textarea name="batch_ref" id="batch_ref" class="form-control" readonly><?php echo isset($batch_file) ? str_replace("<br>", "\n", $batch_file['error_msg']) : ''?></textarea>
                </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <table id="batch_records" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Transaction Ref</th>
                  <th>Beneficiary Name</th>
                  <th>Account Number</th>
                  <th>Amount to Pay</th>
                  <th>Department</th>
                  <th>Benef Bank</th>
                  <th>Bank BICCODE</th>
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
<script>
  var table_batch_records = $('#batch_records').DataTable({
		"pagingType": 'full_numbers',
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
    'ajax': {
      url: base_url + 'api-load-batch-records/<?php echo $batch_file_id?>',
    }
	});
</script>