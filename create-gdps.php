<?php
$page_name = "Create a GDPS";
$active_creategdps = "active";
require "auth/check_auth.php";
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Create GDPS</h3>
      </div>
      <form action="#">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">GDPS Name</label>
                <input class="form-control" id="name" placeholder="GDPS Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label id="customUrlUpdate" for="custom_url">GDPS Custom URL (.ps.fhgdps.com)</label>
                <input id="customUrl" class="form-control" id="custom_url" placeholder="Example: greencatgdps">
              </div>
            </div>
            <div>
              <button type="button" class="btn btn-primary" onclick="createGDPS()">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<?php require "footer.php"; ?>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script>
  const selectElement = document.getElementById('customUrl');
  const delay = ms => new Promise(resolve => setTimeout(resolve, ms))

  selectElement.addEventListener('keydown', async (event) => {
    if (event.target.value.length >= 11) {
      if (event.key !== "Backspace" && !event.key.startsWith("Arrow") && event.key !== "Delete") {
        event.preventDefault()
        return
      }
    }
    const result = document.getElementById('customUrlUpdate');
    await delay(1)
    const element = document.getElementById('customUrl');

    result.textContent = `GDPS Custom URL (${element.value}.ps.fhgdps.com)`;
  });
</script>
<script>
  function createGDPS() {
    const custom_url = document.getElementById('customUrl').value;
    const gdps_name = document.getElementById('name').value;
    $.ajax({
      url: "http://127.0.0.1:30458/creategdps",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        custom_url: custom_url,
        name: gdps_name,
        version: "2.1"
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
          body: "GDPS creation starting! Redirecting soon..!"
        })

        setTimeout(function(){
          window.location.replace("http://localhost/my-gdps.php");
        }, 3000);
      }
    })
  }
</script>