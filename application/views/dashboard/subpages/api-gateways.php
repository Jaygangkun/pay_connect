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
            <button type="button" class="btn btn-primary btn-block" id="btn_modal_add_gateway">
              <i class="nav-icon fas fa-university"></i>&nbsp;&nbsp;&nbsp;Add Gateway</button>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <table id="gateways" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ShortName</th>
                  <th>Description</th>
                  <th>Direction</th>
                  <th>EndPoint</th>
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

<!-- Add Gateway Modal -->
<div class="modal fade" id="modal_add_gateway" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Gateway</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Short Name</label>
                <input type="text" class="form-control" placeholder="" id="short_name"/>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" placeholder="" id="description"/>
              </div>
            </div>
          </div>
  
          <div class="row mt-2">
            <div class="col-sm-12">
              <div class="form-group">
                <label>EndPoint - URL</label>
                <input type="text" class="form-control" placeholder="" id="endpoint"/>
              </div>
            </div>
          </div>
  
          <div class="row mt-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Message Direction</label>
                <select class="form-control" id="direction">
                  <option>OUTWARD</option>
                  <option>INWARD</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status">
                  <option>Active</option>
                  <option>Suspended</option>
                </select>
              </div>                
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="gateway_id" id="gateway_id">
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
<!-- /.Add Gateway Modal -->
<style>
#gateways_wrapper .row:first-of-type {
  display: none;
}
</style>
<script>
var table_gateways = $('#gateways').DataTable({
  "pagingType": 'full_numbers',
  "paging": true,
  "lengthChange": false,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "responsive": true,
  'ajax': {
    url: base_url + 'api-gateways-load',
  }
});

$(document).on('click', '#btn_save', function() {

  $.ajax({
    url: base_url + 'api-gateway-add',
    type: 'post',
    dataType: 'json',
    data: {
      short_name: $('#short_name').val(),
      description: $('#description').val(),
      endpoint: $('#endpoint').val(),
      direction: $('#direction').val(),
      status: $('#status option:selected').text(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_gateway').modal('toggle');
        table_gateways.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '#btn_update', function() {

  $.ajax({
    url: base_url + 'api-gateway-update',
    type: 'post',
    dataType: 'json',
    data: {
      gateway_id: $('#gateway_id').val(),
      short_name: $('#short_name').val(),
      description: $('#description').val(),
      endpoint: $('#endpoint').val(),
      direction: $('#direction').val(),
      status: $('#status option:selected').text(),
    },
    success: function(resp) {
      if(resp.success) {
        $('#modal_add_gateway').modal('toggle');
        table_gateways.ajax.reload();
      }
      else {
        alert(resp.message);
      }
    }
  })
})

$(document).on('click', '.btn-delete', function(event) {
  event.preventDefault();
  event.stopPropagation();
  if(confirm('Are you sure to delete?')) {
    $.ajax({
      url: base_url + 'api-gateway-delete',
      type: 'post',
      dataType: 'json',
      data: {
        gateway_id: $(this).attr('gateway-id'),
      },
      success: function(resp) {
        if(resp.success) {
          table_gateways.ajax.reload();
        }
        else {
          alert(resp.message);
        }
      }
    })
  }
})

$(document).on('click', '#btn_modal_add_gateway', function() {
  $('#modal_add_gateway #short_name').val('');
  $('#modal_add_gateway #description').val('');
  $('#modal_add_gateway #endpoint').val('');
  $('#modal_add_gateway #direction').val('');
  $('#modal_add_gateway #status').val('');

  $('#modal_add_gateway #btn_save').show();
  $('#modal_add_gateway #btn_update').hide();

  $('#modal_add_gateway').modal('toggle');
})

$(document).on('keyup', '#search', function() {
  table_gateways.search($(this).val()).draw(false);
})

$('#gateways tbody').on('click', 'tr', function (event) {
  
  if(event.target.className.indexOf('btn-delete') != -1) {
    return;
  }

  var row_data = table_gateways.row(this).data();

  $('#modal_add_gateway #short_name').val(row_data[0]);
  $('#modal_add_gateway #description').val(row_data[1]);
  $('#modal_add_gateway #endpoint').val(row_data[3]);
  $('#modal_add_gateway #direction').val(row_data[2]);
  $('#modal_add_gateway #status').val(row_data[6]);
  $('#modal_add_gateway #gateway_id').val(row_data[7]);
  
  $('#modal_add_gateway #btn_save').hide();
  $('#modal_add_gateway #btn_update').show();

  $('#modal_add_gateway').modal('toggle');
});

</script>