<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <div class="card card-stats mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="card-title text-left mb-0 ml-3">
                                        <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
                                        <span class="alert-inner--text"><strong>CRJExpress </strong></span>
                                        <p class="text-sm font-weight-bold">
                                            CRJExpress Bandung<br>
                                            <span class="h6" style="padding:0;margin:0;line-height:0">Jl. Sukabirus Univ Telkom<br>
                                            Bandung<br>
                                            Telp: 12312332123
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h6 class="card-title text-uppercase text-center mb-0">
                                        <!-- <img src="http://localhost/project/development/crjexpress/api/assets/images/qrcode/db72de67cce43db47e57cc7d3022d6c5.PNG" style="width:120px"> -->
                                        <img src="<?=$package->result[0]->qrcode?>" style="width:120px">
                                        <!-- <br><?=$package->result[0]->resi?> -->
                                    </h6>
                                </div>
                            </div>
                            <hr class="bg-primary">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row ml-2"><span class="col-sm-6 h5">Kantor Cabang </span><span class="h5 col-sm-6">: <?=$branch->result[0]->city_name?></span></div>
                                    <div class="row ml-2"><span class="col-sm-12 h5">Tujuan </span></div>
                                    <div class="row ml-2"><span class="col-sm-6 h5">Desa/Kelurahan </span><span class="h5 col-sm-6">: <?=$package->result[0]->village_name?></span></div>
                                    <div class="row ml-2"><span class="col-sm-6 h5">Kecamatan </span><span class="h5 col-sm-6">: <?=$package->result[0]->district_name?></span></div>
                                    <div class="row ml-2"><span class="col-sm-6 h5">Kota/Kabupaten </span><span class="h5 col-sm-6">: <?=$package->result[0]->city_name?></span></div>
                                    <div class="row ml-2"><span class="col-sm-6 h5">Provinsi </span><span class="h5 col-sm-6">: <?=$package->result[0]->province_name?></span></div>
                                    <div class="row ml-2"><span class="col-sm-6 h5">Alamat Detail </span><span class="h5 col-sm-6">: <?=$package->result[0]->detail?></span></div>
                                </div>
                            </div>
                            <hr class="bg-primary">
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <div class="card card-stats mb-4 mb-lg-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="card-title text-uppercase text-muted mb--3">Pengirim</h4><hr class="bg-primary">
                                                    <div class="row"><span class="col-sm-6 h5">Nama </span><span class="h5 col-sm-6">: <?=$package->result[0]->sender?></span></div>
                                                    <div class="row"><span class="col-sm-6 h5">Tlp. </span><span class="h5 col-sm-6">: <?=$package->result[0]->sender_phone?></span></div>
                                                    <div class="row"><span class="col-sm-6 h5">Email </span><span class="h5 col-sm-6">: <?=$package->result[0]->sender_mail?></span></div>
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
                                                <h4 class="card-title text-uppercase text-muted mb--3">Penerima</h4><hr class="bg-primary">
                                                    <div class="row"><span class="col-sm-6 h5">Nama </span><span class="h5 col-sm-6">: <?=$package->result[0]->recipient?></span></div>
                                                    <div class="row"><span class="col-sm-6 h5">Tlp. </span><span class="h5 col-sm-6">: <?=$package->result[0]->recipient_phone?></span></div>
                                                    <div class="row"><span class="col-sm-6 h5">Email </span><span class="h5 col-sm-6">: <?=$package->result[0]->recipient_mail?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-0 bg-primary">
                            <div class="row">
                                <div class="col-sm-3">
                                    <span class="h5 text-uppercase">Layanan : <?= $package->result[0]->service_name?> (<?= $package->result[0]->service_description?>)</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="h5 text-uppercase">Paket : <?= $package->result[0]->package_type?> (<?= $package->result[0]->packaging_type?>)</span>
                                </div>
                                <div class="col-sm-3">
                                    <?php if($package->result[0]->insurance == 'on'){$insurance = 'Ya';}else{$insurance = 'Tidak';}?>
                                    <span class="h5 text-uppercase">Asuransi : <?= $insurance?></span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="h5 text-uppercase">Berat : <?= $package->result[0]->weight?> Kg</span>
                                </div>
                                <div class="col-sm-8 mt-3">
                                    <div class="alert alert-primary" role="alert">
                                        <span class="alert-inner--icon"><i class="fas fa-info-circle"></i></span>
                                        <span class="alert-inner--text"><strong>Catatan : </strong> <?= $package->result[0]->package_notes?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <div class="alert alert-secondary text-right" role="alert">
                                        <span class="alert-inner--text h3"><strong>Rp. <?= number_format($package->result[0]->price,0)?></strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                            <i class="ni ni-app"></i>
                        </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-2 text-right">
            <button class="btn btn-icon btn-3 btn-default" type="button">
                <span class="btn-inner--icon"><i class="fas fa-print"></i></span>
                <span class="btn-inner--text">Print</span>
            </button>
        </div>
    </div>