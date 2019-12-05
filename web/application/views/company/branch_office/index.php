<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
        <a href="<?=base_url()?>branch-office/add"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
            <button class="btn icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Add New Branch Office" type="button">
                <!-- <div class="icon icon-shape bg-danger text-white rounded-circle shadow"> -->
                    <i class="ni ni-fat-add"></i>
                <!-- </div> -->
            </button>
        </a>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">    
        <div class="col-sm-12 mb-4">
            <div class="card card-stats mb-4 mb-lg-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title text-uppercase text-muted mb-3">Banch Office</h4>
                            <div class="table-responsive">
                                <div>
                                    <table id="table_id" class="table align-items-center table-dark display hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Office</th>
                                                <th>Address</th>
                                                <th>PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color:#333">
                                            <?php 
                                            $no = 1;
                                            foreach($boffice->result as $data):?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$data->branch_office->id_branch_offices?></td>
                                                <td><?=$data->branch_office->village_name?>, <?=$data->branch_office->district_name?>, <?=$data->branch_office->city_name?>, <?=$data->branch_office->province_name?></td>
                                                <?php if(count($data->pic)>0):?>
                                                <td><?=$data->pic[0]->pic_name?></td>
                                                <?php else:?>
                                                <td><a href="<?=base_url()?>manage-user/add">create manager</a></td>
                                                <?php endif;?>
                                            </tr>
                                            <?php 
                                            $no++;
                                            endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            
        </div>
    </div>    

