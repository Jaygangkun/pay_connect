<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>

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
            <button type="button" class="btn btn-primary btn-block" id="btn_modal_add_user">
              <i class="nav-icon fas fa-university"></i>&nbsp;&nbsp;&nbsp;Add User</button>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <table id="users" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>UserName</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Roles</th>
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

<!-- Add User Modal -->
<div class="modal fade" id="modal_add_user" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" placeholder="" id="user_name"/>
              </div>
            </div>
          </div>
  
          <div class="row mt-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" placeholder="" id="full_name"/>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="" id="email"/>
              </div>
            </div>
          </div>
  
          <div class="row mt-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Role</label>
                <select class="form-control select2" multiple="multiple" id="role">
                  <?php
                  foreach($user_roles as $role) {
                    ?>
                    <option value="<?php echo $role['id']?>"><?php echo strtoupper($role['name'])?></option>
                    <?php
                  }
                  ?>
                  <option value="-1">OTHERS</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department">
                  <?php 
                  foreach($departments as $department) {
                    ?>
                    <option value="<?php echo $department['id']?>"><?php echo $department['name']?></option>
                    <?php
                  }
                  ?>
                  <option value="-1">OTHERS</option>
                </select>
              </div>                
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Comments</label>
                <textarea class="form-control" id="comments"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="user_id" id="user_id">
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" id="btn_delete">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
        <button type="button" class="btn btn-primary" id="btn_update"><i class="fas fa-save"></i>&nbsp;&nbsp;Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Add User Modal -->

<!-- Add Department Modal -->
<div class="modal fade" id="modal_add_department" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="form-group">
            <label>Enter Department</label>
            <input type="text" class="form-control" placeholder="" id="department_name"/>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Discard</button>
        <button type="button" class="btn btn-primary" id="btn_department_save">
          <i class="fas fa-save"></i> &nbsp;&nbsp;Save
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Add Department Modal -->

<!-- Add User Role Modal -->
<div class="modal fade" id="modal_add_user_role" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="form-group">
            <label>Role Name</label>
            <input type="text" class="form-control" placeholder="" id="role_name"/>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Discard</button>
        <button type="button" class="btn btn-primary" id="btn_user_role_save">
          <i class="fas fa-save"></i> &nbsp;&nbsp;Save
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Add User Role Modal -->

<style>
#users_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
$('#modal_add_user #role').select2();
$('#modal_add_user #role').on('select2:select', function(e) {
  console.log('select:', e.params.data, $('#role').val());
  if(e.params.data.id == '-1') {
    var roles = $('#modal_add_user #role').val();
    roles = roles.filter(function(e) { return e != -1});
    $('#modal_add_user #role').val(roles).trigger('change');

    $('#modal_add_user_role').modal('toggle');
  }
});

var table_users = $('#users').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-users-load',
  }
});

$(document).on('click', '#btn_save', function() {

  $.ajax({
    url: base_url + 'api-user-add',
    type: 'post',
    dataType: 'json',
    data: {
      user_name: $('#user_name').val(),
      full_name: $('#full_name').val(),
      email: $('#email').val(),
      role: $('#role').val(),
      department: $('#department').val(),
      comments: $('#comments').val(),
    },
    success: function(resp) {
      if(resp.success) {
        // $('#modal_add_user').modal('toggle');
        // table_users.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })

  setTimeout(function(){
    $('#modal_add_user').modal('toggle');
    table_users.ajax.reload();
  }, 2000);
})

$(document).on('click', '#btn_update', function() {

  $.ajax({
    url: base_url + 'api-user-update',
    type: 'post',
    dataType: 'json',
    data: {
      user_id: $('#user_id').val(),
      user_name: $('#user_name').val(),
      full_name: $('#full_name').val(),
      email: $('#email').val(),
      role: $('#role').val(),
      department: $('#department').val(),
      comments: $('#comments').val(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_user').modal('toggle');
        table_users.ajax.reload();
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
      url: base_url + 'api-user-delete',
      type: 'post',
      dataType: 'json',
      data: {
        user_id: $('#user_id').val(),
      },
      success: function(resp) {
        if(resp.success) {
          $('#modal_add_user').modal('toggle');
          table_users.ajax.reload();
        }
        else {
          alert(resp.message);
        }
      }
    })
  }
})

$(document).on('click', '.btn-activate', function() {
  $.ajax({
    url: base_url + 'api-user-change-active',
    type: 'post',
    dataType: 'json',
    data: {
      user_id: $(this).attr('user-id'),
      status: 'active'
    },
    success: function(resp) {
      if(resp.success) {
        table_users.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '.btn-deactivate', function() {
  $.ajax({
    url: base_url + 'api-user-change-active',
    type: 'post',
    dataType: 'json',
    data: {
      user_id: $(this).attr('user-id'),
      status: 'deactive'
    },
    success: function(resp) {
      if(resp.success) {
        table_users.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_modal_add_user', function() {
  $('#modal_add_user #user_name').val('');
  $('#modal_add_user #full_name').val('');
  $('#modal_add_user #email').val('');
  $('#modal_add_user #role').val(null).trigger('change');
  $('#modal_add_user #department').val('');
  $('#modal_add_user #comments').val('');

  $('#modal_add_user #btn_delete').hide();
  $('#modal_add_user #btn_update').hide();
  $('#modal_add_user #btn_save').show();

  $('#modal_add_user').modal('toggle');
})

$('#users tbody').on('click', 'tr', function () {
  if(event.target.className.indexOf('btn') != -1) {
    return;
  }

  var row_data = table_users.row(this).data();
  if(row_data[11]) {
    // is admin
    return;
  }
  $('#modal_add_user #user_name').val(row_data[1]);
  $('#modal_add_user #full_name').val(row_data[2]);
  $('#modal_add_user #email').val(row_data[3]);
  var roles = row_data[8];
  if(roles.indexOf(',') != false) {
    roles = roles.split(',');
  }
  else {
    roles = [roles];
  }

  $('#modal_add_user #role').val(roles).trigger('change');
  $('#modal_add_user #department').val(row_data[7]);
  $('#modal_add_user #comments').val(row_data[9]);
  $('#modal_add_user #user_id').val(row_data[10]);

  $('#modal_add_user #btn_delete').show();
  $('#modal_add_user #btn_update').show();
  $('#modal_add_user #btn_save').hide();

  $('#modal_add_user').modal('toggle');
})


$(document).on('keyup', '#search', function() {
  table_users.search($(this).val()).draw(false);
})

$(document).on('change', '#department', function() {
  if($(this).val() == -1) {
    $('#modal_add_department').modal('toggle');
  }
})

$(document).on('click', '#btn_department_save', function() {
  if($('#department_name').val() == '') {
    alert('Please input department name');
    $('#department_name').focus();
    return;
  }

  $.ajax({
    url: base_url + 'api-department-add',
    type: 'post',
    dataType: 'json',
    data: {
      name: $('#department_name').val(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_department').modal('toggle');
        $('#department').html(resp.html);

        $('#department_name').val('');
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_user_role_save', function() {
  if($('#role_name').val() == '') {
    alert('Please input user role name');
    $('#role_name').focus();
    return;
  }

  $.ajax({
    url: base_url + 'api-user-role-add',
    type: 'post',
    dataType: 'json',
    data: {
      name: $('#role_name').val(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_user_role').modal('toggle');
        // $('#modal_add_user #role').append(new Option($('#role_name').val(), resp.role_id, true, true));
        var roles = $('#modal_add_user #role').val();
        $('#modal_add_user #role').select2("destroy");
        $('#role').html(resp.html);
        $('#modal_add_user #role').select2();
        $('#modal_add_user #role').val(roles).trigger('change');

        $('#role_name').val('');
      }
      else {
        alert(resp.message);
      }
    }
  })
})

</script>