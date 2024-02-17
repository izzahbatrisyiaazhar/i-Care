<!--style 1 starts-->
<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>
<!--style 1 ends-->

<!-- Navbar -->

      <!--style 2 starts-->
      <style>
        #login-nav {
          position: fixed !important;
          top: 0 !important;
          z-index: 1038;
          padding: 0.3em 2.5em !important;
        }
        #top-Nav{
          top: 2.3em;
 
        }
        .text-sm .layout-navbar-fixed .wrapper .main-header ~ .content-wrapper, .layout-navbar-fixed .wrapper .main-header.text-sm ~ .content-wrapper {
          margin-top: calc(3.6) !important;
          padding-top: calc(3.2em) !important
      }
        .navbar-nav{
          margin-left:15rem;
        }

      </style>
      <!--style 2 ends-->

      <!--profile pic + name navbar starts-->
      <nav class="w-100 px-2 py-1 position-fixed top-0 bg-dark text-light" id="login-nav">
        <div class="d-flex justify-content-between w-100">
          <div>
            <p class="m-0 truncate-1"><small><?= $_settings->info('name') ?></small></p>
          </div>
          <div>
            <?php if($_settings->userdata('id') > 0 && $_settings->userdata('login_type') ==3): ?>
              
              <!-- <span class="mx-2">Howdy, <?= !empty($_settings->userdata('username')) ? $_settings->userdata('username') 
              : $_settings->userdata('email') ?></span>
              <span class="mx-1"><a href="<?= base_url.'classes/Login.php?f=logout_client' ?>"><i class="fa fa-power-off"></i></a></span> -->

              <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle text-reset text-decoration-none" 
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mx-2"><img src="<?= validate_image($_settings->userdata('avatar')) ?>" 
                class="img-thumbnail rounded-circle" alt="User Avatar" id="client-img-avatar">  
                <!--<span class="mx-2">Howdy, <//?= !empty($_settings->userdata('username')) ? 
                $_settings->userdata('username') : $_settings->userdata('email') ?></span>-->
                <span class="mx-2"><?= $_settings->userdata('firstname').' '.$_settings->userdata('lastname') ?></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="./?page=manage_account"><span class="fa fa-user"></span> My Account</a>
                  <a class="dropdown-item" href="<?= base_url.'classes/Login.php?f=logout_client' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
                </div>
              </div>
            <?php else: ?>
              <a href="./login.php" class="mx-2 text-light text-decoration-none font-weight-bolder">Donor Login</a> |
              <!--<a href="./vendor" class="mx-2 text-light text-decoration-none font-weight-bolder">Donor Login</a> |--> 
              <a href="./admin" class="mx-2 text-light text-decoration-none font-weight-bolder">Admin Login</a>
            <?php endif; ?>
          </div>
        </div>
      </nav>
      <!--profile pic + name navbar ends-->
<!-------------------------------------------------------------------------------------------------------------------------->

      <!--logo n navigation link starts-->
      <nav class="main-header navbar navbar-expand-md navbar-light border-0 text-sm bg-gradient-light shadow" id='top-Nav'>
        <!--logo starts-->
        <div class="container">
          <a href="./" class="navbar-brand">
            <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Site Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span style="color:#1f1f1f"><strong><?= $_settings->info('short_name') ?></strong></span>
          </a>
          <!--logo ends-->

          <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links default starts-->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="./" class="nav-link <?= isset($page) && $page =='home' ? "active" : "" ?>">Home</a>
              </li>
              <li class="nav-item">
                <a href="./?page=program" class="nav-link <?= isset($page) && $page =='program' ? "active" : "" ?>">Programs</a>
              </li>
              <li class="nav-item">
                <a href="./?page=about" class="nav-link <?= isset($page) && $page =='about' ? "active" : "" ?>">About Us</a>
              </li>
              <!-- Left navbar links default ends-->
              
              <?php if($_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 3): ?>
              <!--<li class="nav-item">
                <?php 
                //$cart_count = $conn->query("SELECT sum(quantity) FROM `cart_list` where client_id = '{$_settings->userdata('id')}'")->fetch_array()[0];
                //$cart_count = $cart_count > 0 ? $cart_count : 0;
                ?>
                <a href="./?page=orders/cart" class="nav-link <?//= isset($page) && $page =='orders/cart' ? "active" : "" ?>"><span class="badge badge-secondary rounded-cirlce">
                <?//= format_num($cart_count) ?></span> Cart</a>
              </li>-->
              <li class="nav-item">
                <a href="./?page=donation_history/my_donations" class="nav-link <?= isset($page) && $page =='donation_history/my_donations' ? "active" : "" ?>">My Donations</a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
          <!-- Right navbar links -->
          <!--<div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <button class="navbar-toggler order-1 border-0 text-sm" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>-->
        </div>
      </nav>
      <!-- /.navbar -->
      <script>
        $(function(){
          
        })
      </script>