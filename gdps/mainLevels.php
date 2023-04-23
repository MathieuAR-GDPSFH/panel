<?php
$page_name = "";
$active_mainLevels = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);

$url = "http://127.0.0.1:30458/page/gdps/mainLevels?gdps_id=".$_GET["gdpsid"]."&user_id=".$user_id."&access_token=".$access_token;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$resp = curl_exec($curl);
curl_close($curl);
$response = json_decode($resp, true);

if (!$response["success"]) {
  exit($response["message"]);
}

$mainLevels = "";
foreach ($response["levels"] as $level) {
  $mainLevels = $mainLevels."
  <tr id='level-".$level["id"]."'>
    <td><button type='button' class='btn btn-default btn-sm fas fa-arrow-down mr-1' onclick=\"updateMainLevelPos('".$level["id"]."', 'down', this)\"></button><button type='button' class='btn btn-default btn-sm fas fa-arrow-up mr-1' onclick=\"updateMainLevelPos('".$level["id"]."', 'up', this)\"></button></td>
    <td>".$level["id"]."</td>
    <td>".$level["name"]."</td>
    <td>".$level["difficulty"]."</td>
    <td>".$level["stars"]."</td>
    <td>".$level["song"]."</td>
    <td><button type='button' class='btn btn-danger btn-sm fas fa-trash-alt mr-1' onclick=\"removeMainLevel('".$level["id"]."')\"></button></td>
  </tr>";
}

require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Main levels</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-addLevel">Add level</button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table" id="addLevel-table">
            <thead>
              <tr>
                <th>Position</th>
                <th>Level ID</th>
                <th>Name</th>
                <th>Difficulty</th>
                <th>Stars</th>
                <th>Song</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody id="main_levels">
              <?php echo $mainLevels; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-addLevel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add a level</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Level</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="levelID">Level ID</label>
                    <input class="form-control" id="levelID" placeholder="Enter the level ID...">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="addMainLevel()">Add level</button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require "footer.php"; ?>
<script src="../plugins/toastr/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script>
  function addMainLevel() {
    const levelID = document.getElementById("levelID").value
    $.ajax({
      url: "<?php echo $api_url ?>/addMainLevel",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        level_id: +levelID
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
          body: "Level added! Reloading page..."
        })

        setTimeout(function(){
          window.location.reload();
        }, 2000);
      }
    })
  }

  function removeMainLevel(levelID) {
    $.ajax({
      url: "<?php echo $api_url ?>/removeMainLevel",
      type: "DELETE",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        level_id: +levelID
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

        document.getElementById(`level-${levelID}`).remove()
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: "Level removed!"
        })
      }
    })
  }

  function updateMainLevelPos(levelID, position, element) {
    $.ajax({
      url: "<?php echo $api_url ?>/updateMainLevelPos",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        level_id: +levelID,
        position: position
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

        var rows = document.getElementById("main_levels").rows
        var index = element.parentElement.parentElement.rowIndex - 1
        parent = rows[index].parentNode;
        if (position === "up") {
          if (index > 0) {
            parent.insertBefore(rows[index],rows[index - 1]);
            index--;
          }
        }
        
        if (position === "down") {
          if (index < rows.length - 1) {
            parent.insertBefore(rows[index + 1],rows[index]);
            index++;
          }
        }

        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: "Level position changed!"
        })
      }
    })
  }
</script>