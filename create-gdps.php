<?php
$page_name = "Create a GDPS";
$active_creategdps = "active";
require "auth/check_auth.php";

$card = "";
if (isset($_POST["name"]) && isset($_POST["custom_url"])) {
  $url = "http://127.0.0.1:30458/creategdps?name=".$_POST["name"]."&custom-url=".$_POST["custom_url"]."&version=2.1&user_id=$user_id"."&access_token=".$access_token;
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

  $resp = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($resp, true);

  if (!$response["success"]) {
    $card = "<script type='text/javascript'>$(document).Toasts('create', {
      class: 'bg-danger',
      title: 'GDPSFH',
      body: \"".$response["message"]."\"
    })</script>";
  } else if ($response["success"]) {
    header("Location: /my-gdps.php");
    die();
  }
}

require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Create GDPS</h3>
      </div>
      <form action="/create-gdps.php" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">GDPS Name</label>
                <input class="form-control" name="name" id="name" placeholder="GDPS Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label id="customUrlUpdate" for="custom_url">GDPS Custom URL (.ps.fhgdps.com)</label>
                <input id="customUrl" class="form-control" name="custom_url" id="custom_url" placeholder="Example: greencatgdps">
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-primary">Submit</button>
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
<?php
echo $card;
?>