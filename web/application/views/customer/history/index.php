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
              <li class="nav-item active"><a class="nav-link" href="<?=base_url()?>history">History</a></li>
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

  
  <!-- ================Hero Banner Area Start =================-->
  <section class="hero-banner">
    <div class="container text-center">
      <h2>Your History Transactions</h2>
      <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">History</li>
        </ol>
      </nav>
    </div>
  </section>
  <!--================Hero Banner Area End ================= -->


  <!--================ Innovation section Start =================-->
  <section class="section-padding--small bg-gray">
    <div class="container">
      <div class="row">
        <div class="section-intro text-center">
            <p class="section-intro__title">CRJExpress</p>
            <h2 class="primary-text">History</h2>
            <img src="<?=$asset?>img/home/section-style.png" alt="">
        </div>
        <div class="col-sm-12 mb-4 mt-4">
            <div class="card card-stats mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!-- <h4 class="card-title text-uppercase text-muted mb-3">Branch Office</h4> -->
                            <div class="table-responsive">
                                <div>
                                    <table id="table_id" class="table align-items-center table-dark display hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Destination ID</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Datetime</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color:#333">
                                                <?php $no = 1; foreach($trx as $data):
                                                  if($data->status != 'CHECK'):?>
                                                    <tr>
                                                        <td><?=$no?></td>
                                                        <td><?=$data->ppob_account?></td>
                                                        <td><?=$data->ppob_type?></td>
                                                        <td><?=$data->qty?></td>
                                                        <td><?=$data->price?></td>
                                                        <td><?=$data->status?></td>
                                                        <td><?=date('d F Y H:i:s', strtotime($data->created_at))?></td>
                                                    </tr>
                                                <?php $no++; endif;endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ Innovation section End =================-->