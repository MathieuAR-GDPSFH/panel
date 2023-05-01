<?php
$page_name = "Levels";
$active_levels = "active";
require "../auth/check_auth.php";
check_gdps_owner($user_id);
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-network-wired"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total levels</span>
          <span id="server_count" class="info-box-number">
            69
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-server"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total rated</span>
          <span id="player_count" class="info-box-number">
            18
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-server"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total featured</span>
          <span id="player_count" class="info-box-number">
            2
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-server"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total epic</span>
          <span id="player_count" class="info-box-number">
            1
          </span>
        </div>
      </div>
    </div>

    <div class="clearfix hidden-md-up"></div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Levels</h3>
          </div>
          <div class="card-body">
            <table id="levels-list" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Difficulty</th>
                  <th>Author</th>
                  <th>Description</th>
                  <th>Upload date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <tr>
                  <td>15</td>
                  <td>Gulag</td>
                  <td>Easy</td>
                  <td>MathieuAR</td>
                  <td>bup</td>
                  <td>a 100 years ago</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">Actions</button>
                      <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="#">Change difficulty</a>
                        <a class="dropdown-item" href="#">Change stars</a>
                        <a class="dropdown-item" href="#">Change name</a>
                        <a class="dropdown-item" href="#">Change description</a>
                        <a class="dropdown-item" href="#">Change name</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Change owner</a>
                        <a class="dropdown-item bg-danger" href="#"> Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
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
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $('#levels-list').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>