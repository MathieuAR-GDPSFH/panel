<?php
$page_name = "Gauntlets";
$active_gauntlets = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);

$url = "http://127.0.0.1:30458/page/gdps/gauntlets?gdps_id=".$_GET["gdpsid"]."&user_id=".$user_id."&access_token=".$access_token;
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

$gauntlets = "";
foreach ($response["gauntlets"] as $gauntlet) {
  $gauntlets = $gauntlets."
  <tr id='gauntlet-".$gauntlet["id"]."'>
    <td>".$gauntlet["name"]."</td>
    <td>".$gauntlet["level1"]."</td>
    <td>".$gauntlet["level2"]."</td>
    <td>".$gauntlet["level3"]."</td>
    <td>".$gauntlet["level4"]."</td>
    <td>".$gauntlet["level5"]."</td>
    <td><button type='button' class='btn btn-default btn-sm fas fa-edit mr-1 disabled' onclick=\"editGauntlet('".$gauntlet["id"]."')\"></button><button type='button' class='btn btn-danger btn-sm fas fa-trash-alt mr-1' onclick=\"deleteGauntlet('".$gauntlet["id"]."')\"></button></td>
  </tr>";
}

require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Gauntlets</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-addGauntlet">Add gauntlet</button>
            </div>
          </div>
          <div class="card-body p-0">
            <table class="table" id="addGauntlet-table">
              <thead>
                <tr>
                  <th>Gauntlet</th>
                  <th>Level 1</th>
                  <th>Level 2</th>
                  <th>Level 3</th>
                  <th>Level 4</th>
                  <th>Level 5</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody id="gauntlets">
                <?php echo $gauntlets; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-addGauntlet">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create a gauntlet</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Gauntlet options</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Gauntlet</label>
                    <select class="form-control select2" style="width: 100%;" id="gauntlet">
                      <option value="0">Select...</option>
                      <option value="1">Fire</option>
                      <option value="2">Ice</option>
                      <option value="3">Poison</option>
                      <option value="4">Shadow</option>
                      <option value="5">Lava</option>
                      <option value="6">Bonus</option>
                      <option value="7">Chaos</option>
                      <option value="8">Demon</option>
                      <option value="9">Time</option>
                      <option value="10">Crystal</option>
                      <option value="11">Magic</option>
                      <option value="12">Spike</option>
                      <option value="13">Monster</option>
                      <option value="14">Doom</option>
                      <option value="15">Death</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="level1">Level 1</label>
                    <input class="form-control" id="level1" placeholder="Enter a level id...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="level2">Level 2</label>
                    <input class="form-control" id="level2" placeholder="Enter a level id...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="level3">Level 3</label>
                    <input class="form-control" id="level3" placeholder="Enter a level id...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="level4">Level 4</label>
                    <input class="form-control" id="level4" placeholder="Enter a level id...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="level5">Level 5</label>
                    <input class="form-control" id="level5" placeholder="Enter a level id...">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="createGauntlet()">Create gauntlet</button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require "footer.php"; ?>
<script>
    function createGauntlet() {
    const gauntlet = document.getElementById("gauntlet").value
    const level1 = document.getElementById("level1").value
    const level2 = document.getElementById("level2").value
    const level3 = document.getElementById("level3").value
    const level4 = document.getElementById("level4").value
    const level5 = document.getElementById("level5").value
    $.ajax({
      url: "<?php echo $api_url ?>/createGauntlet",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        gauntlet: +gauntlet,
        level1: +level1,
        level2: +level2,
        level3: +level3,
        level4: +level4,
        level5: +level5
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
          body: "Gauntlet added! Reloading page..."
        })

        setTimeout(function(){
          window.location.reload();
        }, 2000);
      }
    })
  }

  function deleteGauntlet(gauntlet) {
    $.ajax({
      url: "<?php echo $api_url ?>/deleteGauntlet",
      type: "DELETE",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        gdps_id: <?php echo $_GET["gdpsid"] ?>,
        gauntlet: +gauntlet
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

        document.getElementById(`gauntlet-${gauntlet}`).remove()
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'GDPSFH',
          body: "Gauntlet removed!"
        })
      }
    })
  }
</script>