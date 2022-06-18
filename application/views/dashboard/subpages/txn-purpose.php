<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <div class="input-group">
              <input type="text" class="form-control" id="search" placeholder="Search">
              <div class="input-group-append">
                  <button class="btn btn-default">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
            </div>
          </div>
          <div class="col-md-5"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary btn-block" id="btn_modal_add_txn_purpose">
              <i class="nav-icon fas fa-university"></i>&nbsp;&nbsp;&nbsp;Add Purpose</button>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <table id="txn_purpose" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Purpose Code</th>
                  <th>Description</th>
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

<!-- Add Purpose Modal -->
<div class="modal fade" id="modal_add_txn_purpose" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Purpose</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Purpose Code</label>
                <input type="text" class="form-control" placeholder="" id="code"/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Purpose Description</label>
                <input type="text" class="form-control" placeholder="" id="description"/>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn_save">
          <i class="fas fa-save"></i> &nbsp;&nbsp;Save
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.Add Purpose Modal -->
<style>
#txn_purpose_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
var table_txn_purpose = $('#txn_purpose').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-txn-purpose-load',
  }
});

$(document).on('click', '#btn_save', function() {
  $.ajax({
    url: base_url + 'api-txn-purpose-add',
    type: 'post',
    dataType: 'json',
    data: {
      code: $('#code').val(),
      description: $('#description').val(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_txn_purpose').modal('toggle');
        table_txn_purpose.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '.btn-delete', function() {
  if(confirm('Are you sure to delete?')) {
    $.ajax({
      url: base_url + 'api-txn-purpose-delete',
      type: 'post',
      dataType: 'json',
      data: {
        txn_purpose_id: $(this).attr('txn-purpose-id'),
      },
      success: function(resp) {
        if(resp.success) {
          table_txn_purpose.ajax.reload();
        }
        else {
          alert(resp.message);
        }
      }
    })
  }
})

$(document).on('keyup', '#search', function() {
  table_txn_purpose.search($(this).val()).draw(false);
})

$(document).on('click', '#btn_modal_add_txn_purpose', function() {
  $('#modal_add_txn_purpose #code').val('');
  $('#modal_add_txn_purpose #description').val('');
  
  $('#modal_add_txn_purpose').modal('toggle');
})

</script>