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
              <li class="nav-item active"><a class="nav-link" href="<?=base_url()?>feature-crj-express">Features</a></li> 
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
      <span class="hero-banner-icon"><i class="fas fa-mobile-alt text-danger"></i></span>
      <?=$response?>
    </div>
  </section>
  <!--==================End Data Area=======================-->
  <!--================ Innovation section Start =================-->
  <section class="section-padding--small bg-gray">
    <div class="container">
      <div class="row">
        <div class="section-intro text-center pb-98px">
            <p class="section-intro__title">CRJExpress</p>
            <h2 class="primary-text">Buy & Pay Easily</h2>
            <img src="<?=$asset?>img/home/section-style.png" alt="">
        </div>
        <ul class="clockdiv text-center" id="clockdiv">
            <a href="<?=base_url()?>feature-crj-express/pulsa-pra-bayar">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-mobile-alt" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">PRABAYAR</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/pulsa-pasca-bayar">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-mobile-alt" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson;font-size:11px">PASCABAYAR</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/listrik-pra-bayar">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-bolt" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">TOKEN</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/listrik-pasca-bayar">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-bolt" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">TAGIHAN</span>
                    </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/voucher-games">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-gamepad" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">GAMES</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/e-money">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-money-check-alt" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">WALLET</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/tagihan-bpjs">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-briefcase-medical" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">BPJS</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/tagihan-gas">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-gas-pump" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">GAS</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/tagihan-pdam">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-water" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">PDAM</span>
                </li>
            </a>
            <a href="<?=base_url()?>feature-crj-express/tagihan-telkom">
                <li class="clockdiv-single clockdiv-minute">
                    <h4 class="mb-0"><i class="fa fa-rss" style="color:crimson"></i></h4>
                    <span class="font-weight-bold" style="color:crimson; font-size:11px">TELKOM</span>
                </li>
            </a>
          </ul>
      </div>
    </div>
  </section>
  <!--================ Innovation section End =================-->
  