<!-- dropzonejs -->
<script src="<?= base_url() ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary" id="card1">
      <div class="card-body">
        <div id="dropzone">
          <form class="dropzone1 needsclick" id="demo-upload" action="/upload">
            <div class="dz-message needsclick">    
              <i class="fas fa-upload"></i>

              <p>Drop files here to Upload</p>
            </div>
          </form>
        </div>

        <div id="actions" class="row">
          <div class="col-lg-6 mx-auto">
            <div class="btn-group w-100">
              <span class="btn btn-success col fileinput-button">
                <i class="fas fa-plus"></i>
                <span>Upload File</span>
              </span>
            </div>
          </div>
          <div class="col-lg-6 d-flex1 align-items-center d-none">
            <div class="fileupload-process w-100">
              <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
              </div>
            </div>
          </div>
        </div>
        <div class="table table-striped files" id="previews">
          <div id="template" class="row mt-2">
            <div class="col-auto">
              <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
            </div>
            <div class="col-5">
              <p class="mb-0 mr-3">
                <span class="lead" data-dz-name></span>
                (<span data-dz-size></span>)
              </p>
              <strong class="error text-danger" data-dz-errormessage></strong>
              <strong class="error text-success" data-dz-successmessage></strong>
            </div>
            <div class="col-4 d-flex align-items-center">
              <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
              </div>
            </div>
            <div class="col-auto d-flex align-items-center">
              <div class="btn-group">
                <button class="btn btn-primary start">
                  <i class="fas fa-upload"></i>
                  <span>Start</span>
                </button>
                <button data-dz-remove class="btn btn-warning cancel">
                  <i class="fas fa-times-circle"></i>
                  <span>Cancel</span>
                </button>
                <button data-dz-remove class="btn btn-danger delete">
                  <i class="fas fa-trash"></i>
                  <span>Delete</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-primary" id="card2">
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
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)
  var myDropzone = new Dropzone(".dropzone1", { // Make the whole body a dropzone
    url: base_url + "api-upload", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
    uploadMultiple: false,
    maxFiles: 1,
    acceptedFiles: '.csv, .txt'
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  myDropzone.on("success", function(file, message) {
    console.log("success", message);

    for (let node of file.previewElement.querySelectorAll(
        "[data-dz-successmessage]"
    )) {
      node.textContent = 'Successfully!';
    }

    table_batch_files.ajax.reload();
  })

  myDropzone.on("error", function(file, message) {
    console.log("error", file, message);
    if (file.previewElement) {
      file.previewElement.classList.add("dz-error");
      if (typeof message !== "string" && message.error) {
        message = message.error;
      }
      for (let node of file.previewElement.querySelectorAll(
        "[data-dz-errormessage]"
      )) {
        node.innerHTML = message;
      }
    }

  })

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
      url: base_url + 'api-load-batch-files',
    }
	});
  
  $(document).on('click', '.action-submit', function() {
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
      alert('Cannot authorise Submitted Batch');
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

  $(document).on('click', '.action-view', function() {
    location.href = base_url + 'batch-file-view/' + $(this).attr('data-id');
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