<?php defined('BASEPATH') or die('Unauthorized Access'); ?>
<nav class="navbar navbar-expand-lg navbar-primary navbar-vertical-narrow navbar-light" id="navbar-primary">
  <div class="container">
    <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-vertical">
      <img src="<?php echo image_url("assets/images/logo/horizontal_light.png") ?>" alt="Tabler" class="navbar-brand-logo navbar-brand-logo-large">
      <img src="<?php echo image_url("assets/images/logo/logo_small.png") ?>" alt="Tabler" class="navbar-brand-logo navbar-brand-logo-small">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url() ?>">
            <span class="nav-link-icon">
              <img src="https://img.icons8.com/material-outlined/24/000000/home--v2.png"/>
            </span>
            <span class="nav-link-title">Home</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#/">
            <span class="nav-link-icon">
              <img src="https://img.icons8.com/small/32/000000/sugar-cubes.png"/>
            </span>
            <span class="nav-link-title">Blog</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav mr-0 ml-auto">
        <li class="navbar-nav dropdown pl-3">
          <?php if (check_user_login()): ?>
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0 text-left" data-toggle="dropdown">
              <span class="avatar" style="background-image: url(<?php echo $_SESSION['maskfinder_user']['profile_image'] ?>)"></span>
              <div class="d-none d-lg-block pl-2">
                <div><?php echo $_SESSION['maskfinder_user']['first_name'] ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="#" onClick="user_logout()"  >Log Out</a>
            </div>
          </li>
        <?php else: ?>
          <a class="nav-link" href="#" data-target="#login_modal" data-toggle="modal"  >Log In</a>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
