<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
    </div>
</div>
<div class="container-fluid mt--8">
    <form method="post" action="<?=base_url()?>price-rules/location/create">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card card-stats mb-4 mb-lg-0 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-uppercase text-default mb-0">Price Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Price Information">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" name="branch_office" id="branch_office">
                                        <?php foreach($branch_office->result as $data):?>
                                        <option value="<?=$data->branch_office->id_branch_offices?>">BO: <?=$data->branch_office->village_name?>,<?=$data->branch_office->district_name?>, <?=$data->branch_office->city_name?>, <?=$data->branch_office->province_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" name="destination" id="destination">
                                        <?php foreach($city->result as $data):?>
                                        <option value="<?=$data->id_city?>"><?=$data->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="price" name="price" placeholder="Price" required>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mb-4 text-right">
                <button class="btn btn-icon btn-3 btn-primary" type="submit" name="submit">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Create Price</span>
                </button>
            </div>
        </div>
    </form>
