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
  
  <?php if($isSelected == 1):?>
    <section class="section-padding--small bg-gray">
    <div class="container text-center">
      <span class="hero-banner-icon"><i class="fas fa-gamepad text-danger"></i></span>
      <p>Voucher Games
      <?php if($gameid->status == 1):?>
        Username: <span class="text-primary font-weight-bold"><?=$gameid->username?></span>
      </p>
      <?php elseif($gameid->status == 2):?>
      <br><p class="text-danger font-weight-bold mb-3 mt-3">INCORECT DESTINATION NUMBER</p><br>
       <a class="btn btn-danger" href="<?=base_url()?>feature-crj-express/voucher-games">Back</a>
      <?php endif;?>
      <?php if($gameid->status == 1):?>
      <form method="post" action="<?=base_url()?>feature-crj-express/voucher-games/topup" class="form-row mt-3" onsubmit="return confirm('Do you really want to buy?');">
        <div class="col-2"></div>
        <div class="input-group mb-2 col-md-7 col-sm-7 col-12">
            <input type="hidden" class="form-control" name="phone" placeholder="ID Game" value="<?=$phone?>">
            <select class="form-control" name="nominal" placeholder="">
                <?php foreach($option as $data):?>
                  <option value="<?=$data->pulsa_code?>|<?=$data->pulsa_price?>"><?=$data->pulsa_nominal?>, Rp.<?=number_format($data->pulsa_price,0)?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="input-group mb-2 col-md-2 col-sm-2 col-12">
            <button class="btn btn-danger" type="submit" name="buy">Buy</button>
        </div>
      </form>
      <?php endif;?>
    </div>
  </section>
  <?php else:?>
  <section class="section-padding--small bg-gray">
    <div class="container text-center">
      <span class="hero-banner-icon"><i class="fas fa-gamepad text-danger"></i></span>
      <p>Select Games</p>
      <form method="post" action="<?=base_url()?>feature-crj-express/voucher-games" class="form-row mt-3">
        <!-- <center> -->
        <div class="col-2"></div>
        <div class="input-group mb-2 col-md-4 col-sm-4 col-12">
            <input type="text" class="form-control" name="phone" placeholder="ID Game">
        </div>
        <div class="input-group mb-2 col-md-3 col-sm-3 col-12">
            <select class="form-control" name="select" placeholder="08xxxxxxxx">
                <?php foreach($games as $data):?>
                  <option value="<?=$data['code']?>|<?=$data['game_code']?>"><?=$data['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="input-group mb-2 col-md-2 col-sm-2 col-12">
            <button class="btn btn-danger" type="submit" name="next">Next</button>
        </div>
        <!-- </center> -->
      </form>
      <small>
      Input ID Game Instructions <br>
      Mobile Legend = <span class="text-primary">userid</span>|<span class="text-primary">zoneid</span><br>
      Ragnarok M: Eternal Love = <span class="text-primary">userid</span>|<span class="text-primary">eternal</span><br>
      Ragnarok M: Midnight Party = <span class="text-primary">userid</span>|<span class="text-primary">midnight</span><br>
      Arena of Valor, Free Fire, Speed Drifters = <span class="text-primary">userid</span><br>
      Bleach Mobile 3D, Era of Celestials = <span class="text-primary">rolename</span>|<span class="text-primary">userid</span>|<span class="text-primary">serverid</span><br>
      Dragon Nest = <span class="text-primary">rolename</span>|<span class="text-primary">serverid</span><br>

      </small>
    </div>
  </section>
  <?php endif;?>
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
  