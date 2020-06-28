<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-book text-blue"></i></span>
            <span class="alert-inner--text"><strong>Resi : <?= $package->resi?></strong></span>
            <?php if($this->session->userdata('SESS_DATA')['role']== 'superuser' || $this->session->userdata('SESS_DATA')['role']== 'courier'):?>
            <form method="post" action="<?=base_url()?>package/pickup"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
                <input type="hidden" value="<?=$package->id_packages?>" name="id_package">
                <button class="btn icon icon-shape bg-primary text-white rounded-circle shadow" type="submit" data-toggle="tooltip" data-placement="top" name="pickup" title="Pick Up Package">
                    <!-- <div class="icon icon-shape bg-danger text-white rounded-circle shadow"> -->
                        <i class="ni ni-active-40"></i>
                    <!-- </div> -->
                </button>
            </form>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-sm-6 mb-4">
            <div class="card card-stats mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Package Information</h6>
                            <span class="h4 font-weight-bold mb-0">Type: <?=$package->package_type?></span>
                            <p class="text-muted text-sm">
                                <span class="h6 text-default mr-2">Weight: <?=$package->weight?> Kg</span><br>
                                <span class="h6 text-default mr-2">Packaging: <?=$package->packaging_type?></span><br>
                                <span class="h6 text-default mr-2">Notes: <?=$package->package_notes?></span><br>
                                <span class="h6 text-default mr-2">Insurance: <?=$package->insurance?></span><br>
                            </p>
                        </div>
                        <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                            <i class="ni ni-app"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-4">
            <div class="card card-stats mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Package Location</h6>
                            <span class="h4 font-weight-bold mb-0">Destination: <?=$package->city_name?></span>
                            <p class="text-muted text-sm">
                                <span class="h6 text-default mr-2">From: <?=$branch->city_name?></span><br>
                                <span class="h6 text-default mr-2">Sender: <?=$package->sender?></span><br>
                                <span class="h6 text-detault mr-2">Recipient: <?=$package->recipient?></span>
                            </p>
                        </div>
                        <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                            <i class="ni ni-square-pin"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-2">
            <div class="alert alert-primary" role="alert">
                <span class="alert-inner--icon"><i class="fas fa-truck"></i></span>
                <span class="alert-inner--text"><strong>Shipping Type: Regresif </strong></span>
            </div>
        </div>
        <div class="col-sm-6 mb-2">
            <div class="alert alert-warning" role="alert">
                <span class="alert-inner--icon"><i class="fas fa-dollar-sign"></i></span>
                <span class="alert-inner--text"><strong>Cost: Rp. <?= number_format($package->price,0)?> </strong></span>
            </div>
        </div>

        <div class="col-sm-12 mb-4">
            <div class="card card-stats bg-default mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0 text-lighter">History</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="text-muted text-sm">
                                    <?php foreach($history as $data):?>
                                        <span class="h6 text-lighter mr-2"><?=$data->status?>: <?=$data->notes?> - (<?=$data->pic?>)</span><br>
                                    <?php endforeach;?>
                                    </p>
                                </div>
                                <div class="col-sm-6 text-right">
                                <!-- <img src="http://localhost/project/development/crjexpress/api/assets/images/qrcode/db72de67cce43db47e57cc7d3022d6c5.PNG" style="width:120px"> -->
                                <img src="<?=$package->qrcode?>" style="width:120px">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                            <i class="fas fa-history"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-2">
            <div class="alert alert-primary" role="alert">
                <span class="alert-inner--icon"><i class="ni ni-delivery-fast"></i></span>
                <span class="alert-inner--text"><strong>Status: Delivered </strong></span>
            </div>
        </div>
        <div class="col-sm-6 mb-2">
            <div class="alert alert-warning" role="alert">
                <span class="alert-inner--icon"><i class="ni ni-square-pin"></i></span>
                <span class="alert-inner--text"><strong>Current Location: Medan </strong></span>
            </div>
        </div>
        <?php if($this->session->userdata('SESS_DATA')['role']== 'superuser' || $this->session->userdata('SESS_DATA')['role']== 'agent'):?>
            <div class="col-sm-12 md-2 text-center">
                <a href="<?=base_url()?>package/invoice/<?=$package->invoice?>">
                    <span class="text-uppercase h4">Invoice</span>
                </a>
            </div>
        <?php endif;?>
    </div>