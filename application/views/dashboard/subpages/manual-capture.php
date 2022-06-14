<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
          
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="batch_ref">Batch Ref Number</label>
                                    <div class="input-group">
                                        <input type="text" name="batch_ref" id="batch_ref" class="form-control" value="<?php echo genBatchNumber()?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-default" id="btn_batch_ref">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="transaction_ref">Txn Reference Number</label>
                                    <div class="input-group">
                                        <input type="text" name="transaction_ref" id="transaction_ref" class="form-control" value="<?php echo genTransactionRef(null)?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-default" id="btn_transaction_ref">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="account_number">Beneficiary Account Number</label>
                                    <input type="text" name="account_number" id="account_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="beneficiary_name">Beneficiary Name</label>
                                    <input type="text" name="beneficiary_name" id="beneficiary_name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="department">Depart/Ministry</label>
                                    <select class="form-control" name="department" id="department">
                                        <?php
                                        foreach($departments as $department) {
                                            ?>
                                            <option value="<?php echo $department['id']?>"><?php echo $department['name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="benef_bank">Beneficiary Bank</label>
                                    <select class="form-control" name="benef_bank" id="benef_bank">
                                        <?php
                                        foreach($participants as $participant) {
                                            ?>
                                            <option value="<?php echo $participant['bic_swift_code']?>"><?php echo $participant['participant_name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="amount_pay">Amount to Pay</label>
                                    <input type="text" name="amount_pay" id="amount_pay" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="modal-footer justify-content-between">
                                    <a type="button" class="btn btn-default" href="<?php echo base_url('dashboard')?>">Discard</a>
                                    <button type="button" class="btn btn-primary" id="btn_submit">Submit</button>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Add More Modal -->
<div class="modal fade" id="modal_add_more" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-body">
                <div class="container-fluid">
                
                    <div class="text-center">
                        <h3>Capture More Payments? </h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_yes">Yes - More Entries</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Add Modal -->
<script>

function pad(num, size) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}

$(document).on('click', '#btn_transaction_ref', function() {
    var transaction_ref_cur = $('#transaction_ref').val();
    var transaction_ref_new = transaction_ref_cur.substring(transaction_ref_cur.length - 4);
    transaction_ref_new = parseInt(transaction_ref_new) + 1;
    $('#transaction_ref').val(transaction_ref_cur.substring(0, transaction_ref_cur.length - 4) + pad(transaction_ref_new, 4));
})

$(document).on('click', '#btn_batch_ref', function() {
    var batch_ref_cur = $('#batch_ref').val();
    var batch_ref_new = batch_ref_cur.substring(batch_ref_cur.length - 4);
    batch_ref_new = parseInt(batch_ref_new) + 1;
    batch_ref_new = batch_ref_cur.substring(0, batch_ref_cur.length - 4) + pad(batch_ref_new, 4);
    $('#batch_ref').val(batch_ref_new);

    $('#transaction_ref').val(batch_ref_new + '-' + pad(1, 4));

})

$(document).on('click', '#btn_submit', function() {
    $.ajax({
        url: base_url + 'api-upload-manual',
        type: 'post',
        dataType: 'json',
        data: {
            batch_ref: $('#batch_ref').val(),
            transaction_ref: $('#transaction_ref').val(),
            account_number: $('#account_number').val(),
            beneficiary_name: $('#beneficiary_name').val(),
            department: $('#department option:selected').text(),
            benef_bank: $('#benef_bank option:selected').text(),
            bank_biccode: $('#benef_bank').val(),
            amount_pay: $('#amount_pay').val(),
        },
        success: function(resp) {
            if(resp.success) {
                $('#modal_add_more').modal('toggle');
            }
            else {
                alert(resp.message);
            }
        }
    })
    
})

$(document).on('click', '#btn_yes', function() {
    location.reload();
})
</script>