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
                                        <input type="text" name="batch_ref" id="batch_ref" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-default btn-ref-generate" ref-id="batch_ref">
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
                                        <input type="text" name="transaction_ref" id="transaction_ref" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-default btn-ref-generate" ref-id="transaction_ref">
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
                                        <option>Mashruuca RCRF</option>
                                        <option>SCORE Project</option>
                                        <option>Wasaaradda Arrimaha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="benef_bank">Beneficiary Bank</label>
                                    <select class="form-control" name="benef_bank" id="benef_bank">
                                        <option>PBSMSOSM PREMIER</option>
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
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_discard">Discard</button>
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
$(document).on('click', '.btn-ref-generate', function() {
    var ref_id = $(this).attr('ref-id');
    $.ajax({
        url: base_url + 'api-ref-generate',
        type: 'get',
        success: function(resp) {
            $('#' + ref_id).val(resp);
        }
    })
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
            department: $('#department').val(),
            benef_bank: $('#benef_bank').val(),
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