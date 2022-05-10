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
                    <textarea name="batch_ref" id="batch_ref" class="form-control" readonly></textarea>
                </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Transaction Ref</th>
                  <th>Beneficiary Name</th>
                  <th>Account Number</th>
                  <th>Account to Pay</th>
                  <th>Department</th>
                  <th>Benef Bank</th>
                  <th>Bank BICCODE</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $record_index = 0;
                foreach($records as $record) {
                  ?>
                  <tr>
                    <td><?php echo $record['transaction_ref']?></td>
                    <td><?php echo $record['beneficiary_name']?></td>
                    <td><?php echo $record['account_number']?></td>
                    <td><?php echo $record['amount_pay']?></td>
                    <td><?php echo $record['department']?></td>
                    <td><?php echo $record['benef_bank']?></td>
                    <td><?php echo $record['bank_biccode']?></td>
                    <td>
                      <?php
                      if($record['status'] == '1') {
                        echo "Submitted";
                      }
                      else if($record['status'] == '2') {
                        echo "Error";
                      }
                      else if($record['status'] == '3') {
                        echo "Pending";
                      }
                      ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->