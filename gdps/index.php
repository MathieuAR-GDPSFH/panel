<?php
$page_name = "Dashboard";
$active_gdpsdashboard = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "./sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    in progress
  </div>
</section>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<?php require "./footer.php"; ?>
<script src="../plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="dist/js/servers.js"></script>