<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
    </div>
</div>
<div class="container-fluid mt--8">
    <form method="post" action="<?=base_url()?>manage-user/create">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card card-stats mb-4 mb-lg-0 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-uppercase text-default mb-0">Employee Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Employee Information">
                                <i class="fas fa-user"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="fullname" name="fullname" placeholder="FullName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-alternative" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    <select class="form-control form-control-alternative" name="position" id="position">
                                        <option value="agent">Agent</option>
                                        <option value="courier">Courier</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="address" name="address" placeholder="Address">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-4">
                <div class="card card-stats mb-4 mb-lg-0 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-uppercase text-default mb-0">Account Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Account Information">
                                <i class="fas fa-user"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="username" name="username" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-alternative" id="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-4 text-right">
                <button class="btn btn-icon btn-3 btn-primary" type="submit" name="submit">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Create User</span>
                </button>
            </div>
        </div>
    </form>
