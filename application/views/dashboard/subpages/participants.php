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
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
          </div>

          <div class="col-md-5"></div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary btn-block" id="btn_modal_add_participant">
              <i class="nav-icon fas fa-university"></i>&nbsp;&nbsp;&nbsp;Add Participant</button>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <table id="participants" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ShortName</th>
                  <th>Bank Name</th>
                  <th>Sort Code</th>
                  <th>BIC Code</th>
                  <th>Account Number</th>
                  <th>Status</th>                    
                </tr>
              </thead>
              <tbody>
               
              </tbody>                  
            </table>                
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_upload"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Upload(CSV)</button>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Add Participant Modal -->
<div class="modal fade" id="modal_add_participant" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="bic_swift_code">BIC/SWIFT Code*</label>
                <div class="input-group">
                    <input type="text" name="bic_swift_code" id="bic_swift_code" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="sort_code">Sort-Code</label>
                <div class="input-group">
                    <input type="text" name="sort_code" id="sort_code" class="form-control" value="">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="short_name">*Short Name</label>
                <div class="input-group">
                    <input type="text" name="short_name" id="short_name" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="participant_name">*Participant Name</label>
                <div class="input-group">
                    <input type="text" name="participant_name" id="participant_name" class="form-control" value="">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="account_number">Account Number</label>
                <div class="input-group">
                    <input type="text" name="account_number" id="account_number" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="status">Status</label>
                <div class="input-group">
                  <select class="form-control" name="status" id="status">
                    <option value="Active">Active</option>
                    <option value="Suspended">Suspended</option>
                    <option value="Insolvent">Insolvent</option>
                    <option value="Liquidated">Liquidated</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="participant_id" id="participant_id">
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" id="btn_delete">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn_save">Save</button>
        <button type="button" class="btn btn-primary" id="btn_update">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.Add Participant Modal -->

<!-- Upload CSV Modal -->
<div class="modal fade" id="modal_upload" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <input type="file">
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="participant_id" id="participant_id">
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_upload">Upload</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.Upload CSV Modal -->

<style>
#participants_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
var table_participants = $('#participants').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-participants-load',
  }
});

$(document).on('click', '#btn_save', function() {

  if($('#short_name').val() == '') {
    alert('Please input value');
    $('#short_name').focus();
    return;
  }

  if((/\s/).test($('#short_name').val())) {
    alert('Please remove space');
    $('#short_name').focus();
    return;
  }

  if($('#bic_swift_code').val() == '') {
    alert('Please input value');
    $('#bic_swift_code').focus();
    return;
  }

  if((/\s/).test($('#bic_swift_code').val())) {
    alert('Please remove space');
    $('#bic_swift_code').focus();
    return;
  }

  if($('#bic_swift_code').val().length < 8) {
    alert('Please input more than 8 chars');
    $('#bic_swift_code').focus();
    return;
  }

  $.ajax({
    url: base_url + 'api-participant-add',
    type: 'post',
    dataType: 'json',
    data: {
      bic_swift_code: $('#bic_swift_code').val(),
      sort_code: $('#sort_code').val(),
      short_name: $('#short_name').val(),
      participant_name: $('#participant_name').val(),
      account_number: $('#account_number').val(),
      status: $('#status').val()
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_participant').modal('toggle');
        table_participants.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_update', function() {

  if($('#short_name').val() == '') {
    alert('Please input value');
    $('#short_name').focus();
    return;
  }

  if((/\s/).test($('#short_name').val())) {
    alert('Please remove space');
    $('#short_name').focus();
    return;
  }

  if($('#bic_swift_code').val() == '') {
    alert('Please input value');
    $('#bic_swift_code').focus();
    return;
  }

  if((/\s/).test($('#bic_swift_code').val())) {
    alert('Please remove space');
    $('#bic_swift_code').focus();
    return;
  }

  if($('#bic_swift_code').val().length < 8) {
    alert('Please input more than 8 chars');
    $('#bic_swift_code').focus();
    return;
  }

  $.ajax({
    url: base_url + 'api-participant-update',
    type: 'post',
    dataType: 'json',
    data: {
      participant_id: $('#participant_id').val(),
      bic_swift_code: $('#bic_swift_code').val(),
      sort_code: $('#sort_code').val(),
      short_name: $('#short_name').val(),
      participant_name: $('#participant_name').val(),
      account_number: $('#account_number').val(),
      status: $('#status').val()
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_participant').modal('toggle');
        table_participants.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_delete', function() {
  if(confirm('Are you sure to delete?')) {
    $.ajax({
      url: base_url + 'api-participant-delete',
      type: 'post',
      dataType: 'json',
      data: {
        participant_id: $('#participant_id').val(),
      },
      success: function(resp) {
        if(resp.success) {
          $('#modal_add_participant').modal('toggle');
          table_participants.ajax.reload();
        }
        else {
          alert(resp.message);
        }
      }
    })
  }
})
$(document).on('keyup', '#search', function() {
  table_participants.search($(this).val()).draw(false);
})

$(document).on('click', '#btn_modal_add_participant', function() {
  $('#modal_add_participant #short_name').val('');
  $('#modal_add_participant #participant_name').val('');
  $('#modal_add_participant #sort_code').val('');
  $('#modal_add_participant #bic_swift_code').val('');
  $('#modal_add_participant #account_number').val('');
  $('#modal_add_participant #status').val('');

  $('#modal_add_participant #btn_delete').attr('disabled', true);
  $('#modal_add_participant #btn_save').show();
  $('#modal_add_participant #btn_update').hide();

  $('#modal_add_participant').modal('toggle');
})

$('#participants tbody').on('click', 'tr', function () {
  var row_data = table_participants.row(this).data();
  $('#modal_add_participant #short_name').val(row_data[0]);
  $('#modal_add_participant #participant_name').val(row_data[1]);
  $('#modal_add_participant #sort_code').val(row_data[2]);
  $('#modal_add_participant #bic_swift_code').val(row_data[3]);
  $('#modal_add_participant #account_number').val(row_data[4]);
  $('#modal_add_participant #status').val(row_data[6]);
  $('#modal_add_participant #participant_id').val(row_data[7]);

  $('#modal_add_participant #btn_delete').attr('disabled', false);
  $('#modal_add_participant #btn_save').hide();
  $('#modal_add_participant #btn_update').show();
  $('#modal_add_participant').modal('toggle');
});


</script>