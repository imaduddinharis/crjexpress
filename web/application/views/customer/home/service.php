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
              <li class="nav-item"><a class="nav-link" href="<?=base_url()?>home">Home</a></li> 
              <li class="nav-item active"><a class="nav-link" href="<?=base_url()?>service-crj-express">About Us</a></li> 
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
      <h2>Our Services</h2>
      <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">About Us</li>
        </ol>
      </nav>
    </div>
  </section>
  <!--================Hero Banner Area End =================-->


  
  <!--================ Join section Start =================-->
  <section class="section-margin">
    <div class="container">
      <div class="section-intro text-center pb-98px">
        <p class="section-intro__title">CRJExpress</p>
        <h2 class="primary-text">Services</h2>
        <img src="<?=$asset?>img/home/section-style.png" alt="">
      </div>


      <div class="d-lg-flex justify-content-between">
        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-hands" style="color:crimson"></i>
          </div>
          <h3>Fast</h3>
          <p>send your package in the best way that only takes a maximum of 1 day </p>
        </div>

        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-shield-alt" style="color:crimson"></i>
          </div>
          <h3>Regular</h3>
          <p>send your package in the best way possible in groups that require 2-3 working days</p>
        </div>

        <div class="card-feature mb-5 mb-lg-0">
          <div class="feature-icon">
            <i class="fas fa-handshake" style="color:crimson"></i>
          </div>
          <h3>Insurance</h3>
          <p>insure your package to maintain security in the event of unwanted things </p>
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
