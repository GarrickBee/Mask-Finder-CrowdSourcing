<?php defined('BASEPATH') or die('Unauthorized Access'); ?>
<!DOCTYPE html>
<html lang="en">
<?php echo isset($head)?$head:''; ?>
<body class="antialiased">
  <!-- Facebook SDK -->
  <?php if (!empty(FACBEOOK_APP_ID))
  {
    ?>
    <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?php echo FACBEOOK_APP_ID ?>',
        cookie     : true,
        xfbml      : true,
        version    : 'v6.0'
      });

      FB.AppEvents.logPageView();
    };
    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <?php
  }
  ?>
  <!-- Body Inner -->
  <div class="page">
    <!-- Header -->
    <?php echo isset($header)?$header:''; ?>
    <div class="content">
      <div class="container">
        <!-- Content -->
        <?php echo isset($content)?$content:''; ?>
      </div>
      <!-- Footer -->
      <?php echo isset($footer)?$footer:''; ?>
    </div>
  </div>
  <!-- Scroll top -->
  <a id="scrollTop"><i class="icon-chevron-up1"></i><i class="icon-chevron-up1"></i></a>
  <!-- Script -->
  <?php echo isset($script)?$script:''; ?>
</body>
</html>
