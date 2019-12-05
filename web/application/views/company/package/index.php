<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <form method="get" action="" class="row">
            <div class="col-md-8 col-sm-8 col-8">
                <div class="form-group">
                    <div class="input-group input-group-alternative mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control form-control-alternative" placeholder="Type Resi Number" name="search" type="text">
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-4">
                <button class="btn btn-icon btn-2 btn-primary" type="submit">
                    <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                </button>
            </div>
        </form>
        <?php if($this->session->userdata('SESS_DATA')['role']== 'superuser' || $this->session->userdata('SESS_DATA')['role']== 'agent'):?>
        <a href="<?=base_url()?>package/new-package"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
            <button class="btn icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Add New Package" type="button">
                <!-- <div class="icon icon-shape bg-danger text-white rounded-circle shadow"> -->
                    <i class="ni ni-fat-add"></i>
                <!-- </div> -->
            </button>
        </a>
        <?php endif;?>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
    <?php 
        foreach($package->result as $pck):
            ?>
            <a href="<?=base_url()?>package/detail/<?=$pck->id_packages?>" class="col-sm-4 mb-2">
                <!-- <div class="col-sm-4 mb-2"> -->
                    <div class="card card-stats mb-4 mb-lg-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6 class="card-title text-uppercase text-muted mb-0">Sender: <?=$pck->sender?></h6>
                                    <span class="h5 font-weight-bold mb-0">Resi: <?=$pck->resi?></span>
                                    <p class="text-muted text-sm">
                                        <span class="h6 text-default mr-2">Package: <?=$pck->package_type?> (<?=$pck->packaging_type?>)</span><br>
                                        <span class="h6 text-default mr-2">Service: <?=$pck->service_name?> (<?=$pck->service_description?>)</span><br>
                                        <span class="h6 text-default mr-2">Weight: <?=$pck->weight?> Kg</span><br>
                                        <span class="h6 text-info mr-2">Status: <?=$pck->status?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </a>
        <?php endforeach; ?>
        </div>