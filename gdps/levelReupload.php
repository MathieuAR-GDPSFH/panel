<?php
$page_name = "";
$active_levelReupload = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title" style="text-align: center">Reupload Level</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <div class="row">
                <div class="form-group">
                  <label for="name">Level ID</label>
                  <input class="form-control" id="level_id" placeholder="Example: 4284013">
                </div>
              </div>
              <div class="row">
                <button id="reupload_button" type="button" class="btn btn-info btn-sm" onclick="reuploadLevel()">Reupload</button>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>
</section>

<?php require "footer.php"; ?>
<script src="plugins/toastr/toastr.min.js"></script>
<script>
  function reuploadLevel() {
    const button = document.getElementById("reupload_button")
    button.innerHTML = `
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Reuploading...
    `

    const level_id = document.getElementById("level_id").value
    $.ajax({
      url: "<?php echo $api_url ?>/gdps/reuploadLevel",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        level_id: level_id
      }),
      contentType: 'application/json',
      dataType: "json",
      processData: false,
      success: function(response) {
        button.innerHTML = "Reupload"
        if (!response["success"]) {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'GDPSFH',
            body: response["message"]
          })
          return
        }

        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: `Level reuploaded! ID: ${response["message"]}`
        })
      }
    })
  }
</script>