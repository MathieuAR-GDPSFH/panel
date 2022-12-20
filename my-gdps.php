<?php
$page_name = "My GDPS";
$active_mygdps = "active";
require "auth/check_auth.php";
require "sidebar.php";

$url = "http://127.0.0.1:30458/page/mygdps?user_id=".$user_id."&access_token=".$access_token;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$resp = curl_exec($curl);
curl_close($curl);
$response = json_decode($resp, true);

$gdps_list = "";
foreach ($response as $gdps) {
  $gdps_owner = "Error";
  $role_color = "danger";
  if ($gdps["role"] == "Owner") {
      $gdps_owner = $username;
  } else {
      $gdps_owner = $gdps["username"];
      $role_color = "blue";
  }

  $status = "Error";
  $status_color = "danger";
  if ($gdps["status"] == 0) {
    $status = "Creating";
    $status_color = "yellow";
  } else if ($gdps["status"] == 1) {
    $status = "Online";
    $status_color = "success";
  }

  $date = date('d/m/Y', $gdps["created_on"]);

  $gdps_list = $gdps_list."
  <tr>
    <td><a href='/gdps?gdpsid=".$gdps["id"]."'>".$gdps["name"]."</a></td>
    <td>".$gdps_owner."</td>
    <td>".$date."</td>
    <td><span class='badge bg-".$status_color."'>".$status."</span></td>
    <td><span class='badge bg-".$role_color."'>".$gdps["role"]."</span></td>
  </tr>\n";
}
?>

<section class="content">
  <div class="container-fluid">
  <div class="row">
          <div class="col-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Your GDPS & Managed GDPS</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Made by</th>
                      <th>Creation date</th>
                      <th>Status</th>
                      <th>Role</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $gdps_list; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
  </div>
</section>

<?php require "footer.php"; ?>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script>
  const selectElement = document.getElementById('customUrl');

  selectElement.addEventListener('keydown', (event) => {
    const result = document.getElementById('customUrlUpdate');
    let key = event.code
    let value = event.target.value
    if (!event.code.startsWith("Key") && !event.code.startsWith("Digit") && !event.code.startsWith("Numpad")) {
      key = ""
      if (event.code === "Backspace") {
        value = value.slice(0, -1)
      }
    } else {
      key = event.key
    }
    result.textContent = `GDPS Custom URL (${value}${key}.ps.fhgdps.com)`;
  });
</script>
script