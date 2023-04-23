<?php
$page_name = "";
$active_rateNotifications = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title" style="text-align: center">Rate Notifications</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div>
              <div class="form-group">
                <label for="name">Discord webhook URL</label>
                <input class="form-control" id="webhook_url" placeholder="URL">
              </div>
              <div class="form-group">
                <label for="name">GDPS Path <a href="#" onclick="openGuide()">(READ BEFORE USING)</a></label>
                <input class="form-control" id="folder_path" placeholder="/" value="/">
              </div>
              <p class="text-muted">
                <button id="submit_button" type="button" class="btn btn-info btn-sm" onclick="setupNotifications()">Submit</button>
                <button id="delete_button" type="button" class="btn btn-danger btn-sm" onclick="deleteNotification()">Delete webhook</button>
              </p>
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script>
  function setupNotifications() {
    const webhook_url = document.getElementById("webhook_url").value
    const path = document.getElementById("folder_path").value
    $.ajax({
      url: "<?php echo $api_url ?>/setupIgNotifications",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        webhook: webhook_url,
        path: path
      }),
      contentType: 'application/json',
      dataType: "json",
      processData: false,
      success: function(response) {
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
          body: response["message"]
        })
      }
    })
  }

  function deleteNotification() {
    $(document).Toasts('create', {
      class: 'bg-danger',
      title: 'GDPSFH',
      body: "Will be implemented really soon."
    })
  }

  function openGuide() {
    $(document).Toasts('create', {
      class: 'bg-info',
      title: 'GDPSFH',
      body: "If for example you are using a custom domain and decided to put your GDPS in another folder then please specify it here, otherwise don't touch it!!<br><br>If you never touched FTP before then you don't have to change it, just leave it as default.<br><br>Example: if you moved your gdps in /public_html/database then please put whats after /public_html in the GDPS path so here its /database/ (Don't forthe the / at the end)"
    })
  }
</script>