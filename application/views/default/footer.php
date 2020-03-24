<?php defined('BASEPATH') or die('Unauthorized Access'); ?>
<footer class="footer mt-5" style="background-color: #181818;">
  <div class="container my-3">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h3 class="text-white">Mask Finder</h3>
        <p class="mb-5">Built with love by  <a class="text-primary" href="https://garrickbee.github.io/">Garrick</a><br>All rights reserved. Copyright © 2019 - <?php echo date("Y") ?>. Mask Finder</p>
      </div>
      <div class="col-lg-6">
        <div class="widget clearfix widget-newsletter">
          <h4 class="widget-title"><i class="fa fa-envelope"></i> Sign Up For a Newsletter</h4>
          <p>Weekly breaking news, analysis about corona virus.</p>
          <form  id="email_subscribe_form" action="" class="p-r-40"  method="post">
            <div class="input-group">
              <input id="subscriber_email" name="subscriber_email" class="form-control required" placeholder="Enter your Email" type="email" required>
              <span class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="text-center my-3" >© 2019 - <?php echo date("Y") ?> Mask Finder. All Rights Reserved.
      <a href="https://beerosolutions.com" target="_blank">Beero Solutions</a>
    </div>
  </div>
</footer>
<!-- Login Modal  -->
<div id="login_modal" class="modal fade" id="modal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-label">Login</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div id="google_login_button"></div>
            <!-- <div class="g-signin2" data-onsuccess="google_login" data-onfailure="google_login_failed" data-theme="light" data-height="50" data-longtitle=true data-scope="email"></div> -->
          </div>
          <div class="col-12 text-center text-muted my-3">
            - OR -
          </div>
          <div class="col-12">
            <a href="#" class="btn btn-facebook btn-block" onClick="logInWithFacebook()" style="height:50px">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor">
                <path d="M22.676 0H1.324C.593 0 0 .593 0 1.324v21.352C0 23.408.593 24 1.324 24h11.494v-9.294H9.689v-3.621h3.129V8.41c0-3.099 1.894-4.785 4.659-4.785 1.325 0 2.464.097 2.796.141v3.24h-1.921c-1.5 0-1.792.721-1.792 1.771v2.311h3.584l-.465 3.63H16.56V24h6.115c.733 0 1.325-.592 1.325-1.324V1.324C24 .593 23.408 0 22.676 0"></path>
              </svg>
              Sign In with Facebook
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-b" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
