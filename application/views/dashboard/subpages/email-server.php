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
            <button type="button" class="btn btn-primary btn-block" id="btn_modal_add_email_server">
              <i class="nav-icon fas fa-university"></i>&nbsp;&nbsp;&nbsp;Add Email Server</button>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <table id="email_servers" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Host</th>
                  <th>Username</th>
                  <th>Sender Name</th>
                  <th>Port</th>
                  <th>SSL/TLS</th>
                  <th>Default</th>
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

<!-- Add Email Server Modal -->
<div class="modal fade" id="modal_add_email_server" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Email Server</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Host Name</label>
                <input type="text" class="form-control" placeholder="" id="host"/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Port No</label>
                <input type="text" class="form-control" placeholder="" id="port"/>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" placeholder="" id="user"/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="" id="password"/>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Sender Name</label>
                <input type="text" class="form-control" placeholder="" id="sender"/>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="ssl_tls">
                  <label for="ssl_tls" class="custom-control-label">SSL/TLS</label>
                </div>

              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="default">
                  <label for="default" class="custom-control-label">Set as Default</label>
                </div>
              </div>
            </div>          
          </div>
        </div>
      </div>
      <input type="hidden" name="email_server_id" id="email_server_id">
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn_save">
          <i class="fas fa-save"></i> &nbsp;&nbsp;Save
        </button>
        <button type="button" class="btn btn-primary" id="btn_update">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.Add Email Server Modal -->
<style>
#email_servers_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
var table_email_servers = $('#email_servers').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-email-servers-load',
  }
});

$(document).on('click', '#btn_save', function() {
  $.ajax({
    url: base_url + 'api-email-server-add',
    type: 'post',
    dataType: 'json',
    data: {
      host: $('#host').val(),
      port: $('#port').val(),
      user: $('#user').val(),
      password: $('#password').val(),
      sender: $('#sender').val(),
      ssl_tls: $('#ssl_tls').prop('checked') ? 1 : 0,
      default: $('#default').prop('checked') ? 1 : 0,
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_email_server').modal('toggle');
        table_email_servers.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_update', function() {

  $.ajax({
    url: base_url + 'api-email-server-update',
    type: 'post',
    dataType: 'json',
    data: {
      email_server_id: $('#email_server_id').val(),
      host: $('#host').val(),
      port: $('#port').val(),
      user: $('#user').val(),
      password: $('#password').val(),
      sender: $('#sender').val(),
      ssl_tls: $('#ssl_tls').prop('checked') ? 1 : 0,
      default: $('#default').prop('checked') ? 1 : 0,
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_email_server').modal('toggle');
        table_email_servers.ajax.reload();
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
      url: base_url + 'api-email-server-delete',
      type: 'post',
      dataType: 'json',
      data: {
        server_id: $(this).attr('server-id'),
      },
      success: function(resp) {
        if(resp.success) {
          table_email_servers.ajax.reload();
        }
        else {
          alert(resp.message);
        }
      }
    })
  }
})

$(document).on('click', '#btn_modal_add_email_server', function() {
  $('#modal_add_email_server #host').val('');
  $('#modal_add_email_server #port').val('');
  $('#modal_add_email_server #user').val('');
  $('#modal_add_email_server #password').val('');
  $('#modal_add_email_server #sender').val('');
  $('#modal_add_email_server #ssl_tls').prop('checked', false);
  $('#modal_add_email_server #default').prop('checked', false);

  $('#modal_add_email_server #btn_save').show();
  $('#modal_add_email_server #btn_update').hide();

  $('#modal_add_email_server').modal('toggle');
})

$(document).on('keyup', '#search', function() {
  table_email_servers.search($(this).val()).draw(false);
})

$('#email_servers tbody').on('click', 'tr', function () {
  var row_data = table_email_servers.row(this).data();
  
  if(event.target.className.indexOf('btn-delete') != -1) {
    return;
  }
  
  $('#modal_add_email_server #host').val(row_data[1]);
  $('#modal_add_email_server #port').val(row_data[4]);
  $('#modal_add_email_server #user').val(row_data[2]);
  $('#modal_add_email_server #password').val(row_data[8]);
  $('#modal_add_email_server #sender').val(row_data[3]);
  $('#modal_add_email_server #ssl_tls').prop('checked', row_data[9]);
  $('#modal_add_email_server #default').prop('checked', row_data[10]);
  $('#modal_add_email_server #email_server_id').val(row_data[11]);
  
  $('#modal_add_email_server #btn_save').hide();
  $('#modal_add_email_server #btn_update').show();

  $('#modal_add_email_server').modal('toggle');
});

</script>