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
  <!--==================Data Area=======================-->
  
  <section class="section-padding--small bg-gray">
    <div class="container text-center">
      <span class="hero-banner-icon"><i class="fas fa-user text-danger"></i></span>
      <p>Your Account Info</p>
    </div>
    <div class="container">
      <form>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" value="<?=$cust->email?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" value="<?=$cust->username?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="fullname" value="<?=$cust->fullname?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="phone_number" value="<?=$cust->phone_number?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="balance" class="col-sm-2 col-form-label">Balance</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="balance" value="Rp. <?=number_format($cust->balance,0)?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="status" value="<?=$cust->status?>" readonly>
            </div>
        </div>
        
        <div class="form-group row text-right">
            <div class="col-sm-12">
                <a href="<?=base_url()?>logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
        </form>
    </div>
  </section>
  <!--==================End Data Area=======================-->
  