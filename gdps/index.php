<?php
$page_name = "Dashboard";
$active_gdpsdashboard = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="callout callout-danger">
      <h5><i class="fas fa-info"></i> Information:</h5>
      In response to our poll, the website is currently open in early-access. Due to our tools being unfinished, most of the buttons aren't functional. Please avoid asking for the functionality of our tools.
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-network-wired"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total users</span>
            <span id="total_users" class="info-box-number">
              69
            </span>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-network-wired"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total levels</span>
            <span id="total_users" class="info-box-number">
              69
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Registrations this week</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="registered_users" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Uploaded levels this week</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="uploaded_levels" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<?php require "./footer.php"; ?>
<script src="../plugins/toastr/toastr.min.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>
<script>
  $(function () {
    var registeredUsersCanvas = $('#registered_users').get(0).getContext('2d')

    var registeredUsersData = {
      labels  : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      datasets: [
        {
          label               : 'Registered users',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [80, 20, 68, 10, 45, 78, 24]
        }
      ]
    }

    var registeredUsersOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    
    new Chart(registeredUsersCanvas, {
      type: 'line',
      data: registeredUsersData,
      options: registeredUsersOptions
    })

    //
    var UploadedLevelsCanvas = $('#uploaded_levels').get(0).getContext('2d')

    var UploadedLevelsData = {
      labels  : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      datasets: [
        {
          label               : 'Registered users',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [12, 9, 14, 2, 7, 10, 18]
        }
      ]
    }

    var UploadedLevelsOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(UploadedLevelsCanvas, {
      type: 'line',
      data: UploadedLevelsData,
      options: UploadedLevelsOptions
    })
  })
</script>