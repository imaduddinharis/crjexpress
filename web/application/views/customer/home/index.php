<!--================ Header Menu Area start =================-->
<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <a class="navbar-brand logo_h" href="<?=base_url()?>home"><img src="<?=$asset?>img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav justify-content">
              <li class="nav-item active"><a class="nav-link" href="<?=base_url()?>home">Home</a></li> 
              <li class="nav-item"><a class="nav-link" href="<?=base_url()?>service-crj-express">About Us</a></li> 
              <li class="nav-item"><a class="nav-link" href="<?=base_url()?>feature-crj-express">Features</a></li> 
              <li class="nav-item"><a class="nav-link" href="<?=base_url()?>tracking-crj-express">Tracking</a></li>
              <?php if($this->session->userdata('IS_LOGIN_PPOB')):?>
              <li class="nav-item"><a class="nav-link" href="<?=base_url()?>history">History</a></li>
              <?php endif; ?>
            </ul>

            <ul class="nav-right text-center text-lg-right py-4 py-lg-0">
              <?php if($this->session->userdata('IS_LOGIN_PPOB')):?>
                <li><a href="<?=base_url()?>profile"><?=$cust->username?></a> | <a href="<?=base_url()?>topup-saldo">Rp.<span class="ml-2"><?= number_format($cust->balance,0)?></span></a></li>
              <?php else:?>
                <li><a href="<?=base_url()?>login">login</a></li>
              <?php endif; ?>
            </ul>
          </div> 
        </div>
      </nav>
    </div>
  </header>
  <!--================Header Menu Area =================-->

  
  <!--================Hero Banner Area Start =================-->
  <section class="hero-banner">
    <div class="container text-center">
      <span class="hero-banner-icon"><i class="fas fa-shipping-fast"></i></span>
      <p>Track your package here</p>
      <form method="post" action="<?=base_url()?>tracking-crj-express" class="form-row mt-3">
        <!-- <center> -->
        <div class="col-2"></div>
        <div class="input-group mb-2 col-md-7 col-sm-7 col-12">
            <input type="text" class="form-control" name="resi" placeholder="input your resi">
        </div>
        <div class="input-group mb-2 col-md-2 col-sm-2 col-12">
            <button class="btn btn-danger" type="submit" name="track">Track it!</button>
        </div>
        <!-- </center> -->
      </form>
    </div>
  </section>
  <!--================Hero Banner Area End =================-->


  <!--================ Innovation section Start =================-->
  <section class="section-padding--small bg-gray">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center mb-5 mb-lg-0">
          <div class="innovative-wrapper">
            <h3 class="primary-text">Buy & Pay Easily</h3>
            <p class="h4 primary-text2 mb-3">PPOB System</p>
            <p>CRJExpress provides services for you to buy digital products or pay various bills</p>
          </div>
        </div>
        <div class="col-lg-6 pl-xl-5">

          <div>
            <img src="<?=$asset?>img/ppob.jpg" class="rounded float-right img-fluid" alt="...">
          </div>
          
          <div class="clockdiv-content text-center">
            <!-- <p class="h4 primary-text2 mb-2">January 20 -22, 2019 in Buffelo City</p> -->
            <a class="button button-link mt-2" href="#">Purchase now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ Innovation section End =================-->


  <!--================ Join section Start =================-->
  <section class="section-margin">
    <div class="container">
      <div class="section-intro text-center pb-98px">
        <p class="section-intro__title">CRJExpress</p>
        <h2 class="primary-text">Why Using CRJExpress</h2>
        <img src="<?=$asset?>img/home/section-style.png" alt="">
      </div>


      <div class="d-lg-flex justify-content-between">
        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-hands" style="color:crimson"></i>
          </div>
          <h3>Customer Care</h3>
          <p>CRJExpress has a help center if the customer requires, immediately every day during business hours, and 7x24 to wait a while</p>
        </div>

        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-shield-alt" style="color:crimson"></i>
          </div>
          <h3>Reliable Couriers</h3>
          <p>all CRJExpress couriers have been verified by our party and have a good responsibility, complaints about the courier can also be conveyed directly to customer care </p>
        </div>

        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-handshake" style="color:crimson"></i>
          </div>
          <h3>Features & Services</h3>
          <p>CRJExpress has the best service and features that make it easy for customers to search packages, as well as providing services for buying credit, vouchers, and paying bills on this website.</p>
        </div>
      </div>
      <!-- <div class="row mt-5">
        <div class="col-12 text-center">
          <a class="button mr-3 mb-2" href="#">Learn More</a>
          <a class="button mb-2" href="#">Buy Ticket</a>
        </div>
      </div> -->
    </div>
  </section>
  <!--================ Join section End =================-->
