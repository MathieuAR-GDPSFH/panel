<?php
$page_name = "GDPS Management";
$active_management = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "./sidebar.php";

$url = "http://127.0.0.1:30458/page/gdps/management?gdps_id=".$_GET["gdpsid"]."&user_id=".$user_id."&access_token=".$access_token;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$resp = curl_exec($curl);
curl_close($curl);
$response = json_decode($resp, true);

$subusers = "";
foreach ($response["subusers"] as $subuser) {
  $permissions = "";
  foreach ($subuser["permissions"] as $perm) {
    $permissions = $permissions."
    <span class='badge bg-".$perm["color"]."'>".$perm["name"]."</span>\n";
  }

  $subusers = $subusers."
  <tr>
    <td>".$subuser["user_name"]."</td>
    <td>".$permissions."</td>
    <td><button type='button' class='btn btn-danger btn-sm fas fa-trash-alt mr-1'></button></td>
  </tr>";
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">GDPS informations</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-user mr-1"></i> FTP & Database username</strong>

            <p class="text-muted">gdps_<?php echo $gdps_curl; ?></p>

            <hr>

            <strong><i class="fas fa-key mr-1"></i> FTP & Database password</strong>

            <p class="text-muted">
              <button type="button" id="password" onclick="copyPassword()" class="btn btn-default btn-sm">Copy password</button>
              <button type="button" class="btn btn-danger btn-sm disabled">Reset password</button>
            </p>

            <hr>

            <strong><i class="fas fa-book mr-1"></i> GDPS links</strong>

            <p class="text-muted">
              <button onclick="window.open('https://<?php echo $gdps_curl; ?>.ps.fhgdps.com/')" type="button" class="btn btn-default btn-sm">Main page</button>
              <button onclick="window.open('https://<?php echo $gdps_curl; ?>.ps.fhgdps.com/tools')" type="button" class="btn btn-default btn-sm">Tools</button>
              <button onclick="window.open('https://pma.fhgdps.com/')" type="button" class="btn btn-default btn-sm">phpMyAdmin</button>
            </p>

            <hr>

            <strong><i class="fas fa-shield-alt mr-1"></i> Management</strong>

            <p class="text-muted">
            <button type="button" class="btn btn-danger btn-sm disabled">Reset GDPS</button>
              <button type="button" class="btn btn-danger btn-sm disabled">Disable GDPS</button>
              <button type="button" class="btn btn-danger btn-sm disabled">Delete GDPS</button>
            </p>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">GDPS subusers</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-subusers">Add subuser</button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Access</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php echo $subusers; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-2">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">FTP informations</h3>
          </div>
          <div class="card-body">
            <strong><i class="fas fa-user mr-1"></i> Hostname</strong>

            <p class="text-muted">ftp.fhgdps.com</p>

            <hr>

            <strong><i class="fas fa-key mr-1"></i> Port</strong>

            <p class="text-muted">21</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-subusers">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add a subuser</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">User</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="discordId">Discord id</label>
                <input class="form-control" id="discordId" placeholder="Enter a discord id">
              </div>
            </div>
          </div>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Permissions</h3>
            </div>
            <div class="card-body">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="allPerms">
                <label class="custom-control-label" for="allPerms">All permissions</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageLevels">
                <label class="custom-control-label" for="manageLevels">Manage levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="managementPerm">
                <label class="custom-control-label" for="managementPerm">See management page</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageMapPacks">
                <label class="custom-control-label" for="manageMapPacks">Manage map packs</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageGauntlets">
                <label class="custom-control-label" for="manageGauntlets">Manage gauntlets</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageQuests">
                <label class="custom-control-label" for="manageQuests">Manage quests</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageUsers">
                <label class="custom-control-label" for="manageUsers">Manage users</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="manageModerators">
                <label class="custom-control-label" for="manageModerators">Manage moderators</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="seeSentLevels">
                <label class="custom-control-label" for="seeSentLevels">See levels sent</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="seeModActions">
                <label class="custom-control-label" for="seeModActions">See mod actions</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="addSubUser()">Add subuser</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</section>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<?php require "./footer.php"; ?>
<script src="../plugins/toastr/toastr.min.js"></script>
<script>
  function copyPassword() {
    $.ajax({
      url: "http://127.0.0.1:30458/getgdpspassword",
      type: "GET",
      data: {
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>
      },
      contentType: "text/plain",
      dataType: "json",
      success: function(response) {
        if (!response["success"]) {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'GDPSFH',
            body: response["message"]
          })
          return
        }

        navigator.clipboard.writeText(response["password"]);
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: "Password copied!"
        })
      }
    })
  }

  function addSubUser() {
    const subuser_id = document.getElementById("discordId").value
    const allPerms = document.getElementById("allPerms").checked
    const managementPerm = document.getElementById("managementPerm").checked
    const manageLevels = document.getElementById("manageLevels").checked
    const manageMapPacks = document.getElementById("manageMapPacks").checked
    const manageGauntlets = document.getElementById("manageGauntlets").checked
    const manageQuests = document.getElementById("manageQuests").checked
    const manageUsers = document.getElementById("manageUsers").checked
    const manageModerators = document.getElementById("manageModerators").checked
    const seeSentLevels = document.getElementById("seeSentLevels").checked
    const seeModActions = document.getElementById("seeModActions").checked

    $.ajax({
      url: "http://127.0.0.1:30458/addsubuser",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        subuser_id: subuser_id,
        allPerms: +allPerms,
        managementPerm: +managementPerm,
        manageLevels: +manageLevels,
        manageMapPacks: +manageMapPacks,
        manageGauntlets: +manageGauntlets,
        manageQuests: +manageQuests,
        manageUsers: +manageUsers,
        manageModerators: +manageModerators,
        seeSentLevels: +seeSentLevels,
        seeModActions: +seeModActions,
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
          body: "Subuser created! Reloading page..."
        })

        setTimeout(function(){
          window.location.reload();
        }, 2000);
      }
    })
  }
</script>