<?php
$page_name = "Dashboard";
$active_yourservers = "active";
require "auth/check_auth.php";
require "sidebar.php";

$url = "http://127.0.0.1:30458/page/dashboard";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$resp = curl_exec($curl);
curl_close($curl);
$response = json_decode($resp, true);

$staff_list = "";
foreach ($response["staff_list"] as $staff) {
  $staff_list = $staff_list."
  <div class='col-md-3'>
  <div class='card card-widget widget-user'>
    <div class='widget-user-header bg-".$staff["role_color"]."'>
      <h3 class='widget-user-username'>".$staff["username"]."</h3>
      <h5 class='widget-user-desc'>".$staff["role_name"]."</h5>
    </div>
    <div class='widget-user-image'>
      <img class='img-circle elevation-2' src='".$staff["avatar"]."' alt='User Avatar'>
    </div>
    <div class='card-footer'></div>
  </div>
</div>\n";
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-network-wired"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total GDPS count</span>
            <span id="server_count" class="info-box-number">
            <?php echo $response["total_gdps"] ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Registered users</span>
          <span id="player_count" class="info-box-number">
            <?php echo $response["total_users"] ?>
          </span>
        </div>
      </div>
      </div>
    </div>
    <h3 class="mt-4 mb-4">Staff team</h3>
    <div class="row">
      <?php echo $staff_list ?>
    </div>
</section>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<?php require "footer.php"; ?>
<script src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="dist/js/servers.js"></script>