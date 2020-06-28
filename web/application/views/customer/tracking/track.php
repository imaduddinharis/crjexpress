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
              <li class="nav-item active"><a class="nav-link" href="<?=base_url()?>tracking-crj-express">Tracking</a></li>
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
      <span class="hero-banner-icon"><i class="fas fa-search text-danger"></i></span>
      <p>Track your resi number</p>
      <form method="post" action="<?=base_url()?>tracking-crj-express" class="form-row mt-3">
        <!-- <center> -->
        <div class="col-2"></div>
        <div class="input-group mb-2 col-md-7 col-sm-7 col-12">
            <input type="text" class="form-control" name="resi" placeholder="Input Resi Number">
        </div>
        
        <div class="input-group mb-2 col-md-2 col-sm-2 col-12">
            <button class="btn btn-danger" type="submit" name="track">Track it!</button>
        </div>
        <!-- </center> -->
      </form>
    </div>
    <div class="container mt-3">
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading text-center">Tracking Result</h4>
            <div class="container row">
                <div class="alert alert-light col-md-12 col-sm-12 col-12 " role="alert">
                    <h6>Resi : <?=$package[0]->resi?></h6>
                </div>
                <div class="alert alert-light col-md-12 col-sm-12 col-12" role="alert">
                    <h6>Sender : <?=$package[0]->sender?></h6>
                </div>
                <div class="alert alert-light col-md-12 col-sm-12 col-12" role="alert">
                    <h6>Recipient : <?=$package[0]->recipient?></h6>
                </div>
            </div>
            
            <hr>
            <div class="container row">
                <?php foreach($history as $data):?>
                    <div class="alert alert-light col-md-12 col-sm-12 col-12 " role="alert">
                        <h6><?=$data->status?>: <?=$data->notes?> - (<?=$data->pic?>) : <small class="text-muted"><?= date('d F Y H:i:s', strtotime($data->created_at))?></small></h6>
                    </div>
                <?php endforeach;?>
            </div>
            
            <hr>
            <p class="mb-0 text-right">tracking result</p>
        </div>
    </div>
  </section>
  <!--==================End Data Area=======================-->
  