<?php
$page_name = "";
$active_premium = "active";
require "auth/check_auth.php";
require "sidebar.php";
?>

<section class="content">
  <div class="container-fluid">
    <main>
      <div class="container">
        <h1 class="text-center pricing-table-title">Premium tiers</h1>
        <div class="row">
          <div class="col-md-4">
            <div class="card pricing-card pricing-plan-basic">
              <div class="card-body">
                <i class="mdi mdi-cube-outline pricing-plan-icon"></i>
                <p class="pricing-plan-title">Basic</p>
                <h3 class="pricing-plan-cost ml-auto">FREE</h3>
                <ul class="pricing-plan-features">
                  <li>Max 1 GDPS</li>
                  <li>1Gb Storage</li>
                </ul>
                <a href="#!" class="btn pricing-plan-purchase-btn">Free</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card pricing-card pricing-card-highlighted  pricing-plan-pro">
              <div class="card-body">
                  <i class="mdi mdi-trophy pricing-plan-icon"></i>
                <p class="pricing-plan-title">Pro</p>
                <h3 class="pricing-plan-cost ml-auto">$3/mo</h3>
                <ul class="pricing-plan-features">
                  <li>Max 2 GDPS</li>
                  <li>5Gb Storage</li>
                  <li>Limited custom rate notifier</li>
                  <li>Reupload levels from other GDPS</li>
                  <li>No ads on the website</li>
                </ul>
                <a href="#!" class="btn pricing-plan-purchase-btn">Purchase</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card pricing-card pricing-plan-enterprise">
              <div class="card-body">
                <i class="mdi mdi-wallet-giftcard pricing-plan-icon"></i>
                <p class="pricing-plan-title">Big GDPS</p>
                <h3 class="pricing-plan-cost ml-auto">$5/mo</h3>
                <ul class="pricing-plan-features">
                  <li>Max 5 GDPS</li>
                  <li>15Gb Storage</li>
                  <li>Fully custom rate notifier</li>
                  <li>Reupload levels from other GDPS</li>
                  <li>Reupload music from youtube</li>
                  <li>Discord bot hosting</li>
                  <li>All perks from Pro Tier</li>
                </ul>
                <a href="#!" class="btn pricing-plan-purchase-btn">Purchase</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</section>

<?php require "footer.php"; ?>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script>
  function createGDPS() {
    const custom_url = document.getElementById('customUrl').value;
    const gdps_name = document.getElementById('name').value;
    $.ajax({
      url: "http://127.0.0.1:30458/creategdps",
      type: "POST",
      data: JSON.stringify({
        access_token: "<?php echo $access_token ?>",
        user_id: "<?php echo $user_id ?>",
        custom_url: custom_url,
        name: gdps_name,
        version: "2.1"
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
          body: "GDPS creation starting! Redirecting soon..!"
        })

        setTimeout(function(){
          window.location.replace("http://localhost/my-gdps.php");
        }, 3000);
      }
    })
  }
</script>