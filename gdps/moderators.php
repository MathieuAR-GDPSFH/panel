<?php
$page_name = "Moderators / Roles";
$active_gdpsmoderators = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "./sidebar.php";

$url = "http://127.0.0.1:30458/page/gdps/moderators?gdps_id=".$_GET["gdpsid"]."&user_id=".$user_id."&access_token=".$access_token;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$resp = curl_exec($curl);
curl_close($curl);
$response = json_decode($resp, true);

$roles = "";
$role_options = "";
foreach ($response["roles"] as $role) {
  $badge = "Unknown";
  if ($role["badge"] === 2) {
    $badge = "<img src='../dist/img/gd/badges/elder_mod.png' width='25px' height='25px'>";
  } elseif ($role["badge"] === 1) {
    $badge = "<img src='../dist/img/gd/badges/mod.png' width='25px' height='25px'>";
  } elseif ($role["badge"] === 0) {
    $badge = "No badge";
  }

  $comment_color = "No color";
  if ($role["comment_color"] !== "000,000,000") {
    $comment_color = "<div class='color-palette-set' style='color:rgb(".$role["comment_color"].");'>Color preview</div>";
  }

  $delete_disabled = "";
  if ($role["default"] === 1) {
    $delete_disabled = "disabled";
  } else {
    $role_options = $role_options."
    <option value='".$role["id"]."'>".$role["name"]."</option>
    ";
  }

  $roles = $roles."
  <tr id='role-".$role["id"]."'>
    <td>".$role["priority"]."</td>
    <td>".$role["name"]."</td>
    <td>".$badge."</td>
    <td>".$comment_color."</td>
    <td><button type='button' class='btn btn-default btn-sm fas fa-edit mr-1' onclick='removeRole()' title='Edit role' disabled></button><button type='button' class='btn btn-danger btn-sm fas fa-trash-alt mr-1 ".$delete_disabled."' onclick='deleteRole(".$role["id"].")' title='Delete role'></button></td>
  </tr>
  ";
}

$moderators = "";
foreach ($response["moderators"] as $mod) {
  $moderators = $moderators."
  <tr id='moderator-".$mod["assign_id"]."' roleid='".$mod["role_id"]."'>
    <td>".$mod["name"]."</td>
    <td>".$mod["role_name"]."</td>
    <td><button type='button' class='btn btn-default btn-sm fas fa-edit mr-1' onclick='removeRole()' title='Edit moderator' disabled></button><button type='button' class='btn btn-danger btn-sm fas fa-trash-alt mr-1' onclick='removeMod(".$mod["assign_id"].")' title='Remove moderator'></button></td>
  </tr>
  ";
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="clearfix hidden-md-up"></div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Moderators</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-addmod">Add moderator</button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>Moderator</th>
                    <th>Role</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody id="moderators-list">
                  <?php echo $moderators; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Roles</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-addrole">Create a role</button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table" id="subusers-table">
                <thead>
                  <tr>
                    <th>Priority</th>
                    <th>Name</th>
                    <th>Badge</th>
                    <th>Comment color</th>
                    <th>Edit</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo $roles; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-addmod">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add a moderator</h4>
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
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>User</label>
                    <select class="form-control user-selection" style="width: 100%; height: 400px;" id="userSelection">
                      <option value="" selected disabled>Select a user...</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control select2" style="width: 100%;" id="roleSelection">
                      <option value="" selected disabled>Select a role...</option>
                      <?php echo $role_options; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="addMod()">Add moderator</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-addrole">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create a role</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Role options</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="roleName">Name</label>
                    <input class="form-control" id="roleName" placeholder="Enter the role name...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Badge</label>
                    <select class="form-control select2" style="width: 100%;" id="roleBadge">
                      <option value="0">No badge</option>
                      <option value="2">Elder mod</option>
                      <option value="1">Moderator</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rolePriority">Priority</label>
                    <input class="form-control" id="rolePriority" placeholder="Enter number...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Comment color</label>
                    <div class="input-group role-color">
                      <input type="text" class="form-control" id="roleColor">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Permissions</h3>
            </div>
            <div class="card-body">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="rateCommand">
                <label class="custom-control-label" for="rateCommand">!rate command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="featureCommand">
                <label class="custom-control-label" for="featureCommand">!feature command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="epicCommand">
                <label class="custom-control-label" for="epicCommand">!epic command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="unEpicCommand">
                <label class="custom-control-label" for="unEpicCommand">!unepic command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="verifyCoinsCommand">
                <label class="custom-control-label" for="verifyCoinsCommand">!verifycoins command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="dailyCommand">
                <label class="custom-control-label" for="dailyCommand">!daily command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="weeklyCommand">
                <label class="custom-control-label" for="weeklyCommand">!weekly command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="deleteCommand">
                <label class="custom-control-label" for="deleteCommand">!delete command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="setAccCommand">
                <label class="custom-control-label" for="setAccCommand">!setacc command</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="renameCommandOwn" checked>
                <label class="custom-control-label" for="renameCommandOwn">!rename command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="renameCommandAll">
                <label class="custom-control-label" for="renameCommandAll">!rename command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="passCommandOwn" checked>
                <label class="custom-control-label" for="passCommandOwn">!pass command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="passCommandAll">
                <label class="custom-control-label" for="passCommandAll">!pass command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="descriptionCommandOwn" checked>
                <label class="custom-control-label" for="descriptionCommandOwn">!description command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="descriptionCommandAll">
                <label class="custom-control-label" for="descriptionCommandAll">!description command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="publicCommandOwn" checked>
                <label class="custom-control-label" for="publicCommandOwn">!public command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="publicCommandAll">
                <label class="custom-control-label" for="publicCommandAll">!public command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="unlistCommandOwn" checked>
                <label class="custom-control-label" for="unlistCommandOwn">!unlist command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="unlistCommandAll">
                <label class="custom-control-label" for="unlistCommandAll">!unlist command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="shareCpCommandOwn" checked>
                <label class="custom-control-label" for="shareCpCommandOwn">!sharecp command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="shareCpCommandAll">
                <label class="custom-control-label" for="shareCpCommandAll">!sharecp command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="songCommandOwn" checked>
                <label class="custom-control-label" for="songCommandOwn">!song command for own levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="songCommandAll">
                <label class="custom-control-label" for="songCommandAll">!song command for all levels</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="rateDemon">
                <label class="custom-control-label" for="rateDemon">Rate demon</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="rateStars">
                <label class="custom-control-label" for="rateStars">Rate stars</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="rateDifficulty">
                <label class="custom-control-label" for="rateDifficulty">Rate difficulty</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="requestMod">
                <label class="custom-control-label" for="requestMod">Use req button</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="suggestRate">
                <label class="custom-control-label" for="suggestRate">Suggest rate</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="deleteComment">
                <label class="custom-control-label" for="deleteComment">Delete comments</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="leaderboardBan">
                <label class="custom-control-label" for="leaderboardBan">Leaderboard ban</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="createPackTool">
                <label class="custom-control-label" for="createPackTool">Use create pack tool</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="createQuestsTool">
                <label class="custom-control-label" for="createQuestsTool">Use create quests tool</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="modActionsTool">
                <label class="custom-control-label" for="modActionsTool">Use mod actions tool</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="suggestListTool">
                <label class="custom-control-label" for="suggestListTool">Use suggest list tool</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="dashboardModTools">
                <label class="custom-control-label" for="dashboardModTools">Use mod tools on the dashboard</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="modIpCategory">
                <label class="custom-control-label" for="modIpCategory">Mod ip category</label>
              </div>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="profileCommandDiscord">
                <label class="custom-control-label" for="profileCommandDiscord">profileCommandDiscord</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="createRole()">Create role</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<?php require "./footer.php"; ?>
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="../plugins/toastr/toastr.min.js"></script>
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  let clicked = false
  function createRole() {
    if (clicked === true) return;
    const role_badge = document.getElementById("roleBadge").value
    const role_priority = document.getElementById("rolePriority").value
    const role_name = document.getElementById("roleName").value
    const role_color = document.getElementById("roleColor").value

    const permissionElements = ["rateCommand",
                                "featureCommand",
                                "epicCommand",
                                "unEpicCommand",
                                "verifyCoinsCommand",
                                "dailyCommand",
                                "weeklyCommand",
                                "deleteCommand",
                                "setAccCommand",
                                "renameCommandOwn",
                                "renameCommandAll",
                                "passCommandOwn",
                                "passCommandAll",
                                "descriptionCommandOwn",
                                "descriptionCommandAll",
                                "publicCommandOwn",
                                "publicCommandAll",
                                "unlistCommandOwn",
                                "unlistCommandAll",
                                "shareCpCommandOwn",
                                "shareCpCommandAll",
                                "songCommandOwn",
                                "songCommandAll",
                                "rateDemon",
                                "rateStars",
                                "rateDifficulty",
                                "requestMod",
                                "suggestRate",
                                "deleteComment",
                                "leaderboardBan",
                                "createPackTool",
                                "createQuestsTool",
                                "modActionsTool",
                                "suggestListTool",
                                "dashboardModTools",
                                "modIpCategory",
                                "profileCommandDiscord"
                              ];
    const requestData = [];

    for (const elementId of permissionElements) {
      requestData[elementId] = +document.getElementById(elementId).checked;
    }

    $.ajax({
      url: "<?php echo $api_url ?>/createRole",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        gdps_name: role_name,
        badge: role_badge,
        priority: role_priority,
        comment_color: role_color,
        ...requestData
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
        clicked = true

        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: "Role created! Reloading page..."
        })

        setTimeout(function(){
          window.location.reload();
        }, 2000);
      }
    })
  }

  function addMod() {
    const mod_id = document.getElementById("userSelection").value
    const role_id = document.getElementById("roleSelection").value
    $.ajax({
      url: "<?php echo $api_url ?>/addmoderator",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        mod_id: mod_id,
        role_id: role_id
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
          body: "Moderator added! Reloading page..."
        })

        setTimeout(function(){
          window.location.reload();
        }, 2000);
      }
    })
  }

  function deleteRole(role_id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo $api_url ?>/deleterole",
          type: "DELETE",
          data: JSON.stringify({
            access_token: "<?php echo $access_token ?>",
            user_id: "<?php echo $user_id ?>",
            gdps_id: <?php echo $_GET["gdpsid"] ?>,
            role_id: role_id
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

            document.getElementById(`role-${role_id}`).remove()
            const mod_list = document.getElementById(`moderators-list`)
            var tableRow = mod_list.getElementsByTagName('tr');
            for (var t = 0; t < tableRow.length; t++){
              if (Number(tableRow[t].getAttribute("roleid")) === role_id) {
                tableRow[t].remove()
              }
            }
            Swal.fire(
              'Role deleted!',
              '',
              'success'
            )
          }
        })
      }
    })
  }

  function removeMod(assign_id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo $api_url ?>/removemoderator",
          type: "DELETE",
          data: JSON.stringify({
            access_token: "<?php echo $access_token ?>",
            user_id: "<?php echo $user_id ?>",
            gdps_id: <?php echo $_GET["gdpsid"] ?>,
            assign_id: assign_id
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

            document.getElementById(`moderator-${assign_id}`).remove()
            Swal.fire(
              'Moderator removed!',
              '',
              'success'
            )
          }
        })
      }
    })
  }

  $(function () {
    $('.select2').select2()
    $('.user-selection').select2({
      ajax: {
        url: "<?php echo $api_url ?>/getgdpsusers",
        type: "GET",
        data: function (params) {
          var query = {
            access_token: "<?php echo $access_token ?>",
            user_id: "<?php echo $user_id ?>",
            gdps_id: <?php echo $_GET["gdpsid"] ?>,
            search_username: params.term
          }

          return query
        },
        processResults: function (data) {
          return {
            results: data.users
          };
        }
      }
    });

    $('.role-color').colorpicker()
    $('.role-color').on('colorpickerChange', function(event) {
      $('.role-color .fa-square').css('color', event.color.toString());
    })

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>