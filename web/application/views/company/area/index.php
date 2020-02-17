<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
        <a href="<?=base_url()?>office-area/add"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
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
                            <h4 class="card-title text-uppercase text-muted mb-3">Office Area</h4>
                            <div class="table-responsive">
                                <div>
                                    <table id="table_id" class="table align-items-center table-dark display hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Area Name</th>
                                                <th>Description</th>
                                                <th>Office</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color:#333">
                                            <?php 
                                            $no = 1;
                                            foreach($area->result as $data):?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$data->office_area->area_name?></td>
                                                <td><?=$data->office_area->area_description?></td>
                                                <td>BO<?=$data->office_area->office_id?> (<?=$data->office_area->city_name?>,<?=$data->office_area->district_name?>)</td>
                                                <td class="text-right">
                                                <span class="text-primary"><a href="<?=base_url()?>office-area/detail/<?=$data->office_area->office_id?>"><i class="fa fa-eye"></i></a></span>
                                                <!-- <span class="text-primary"><a href="#"><i class="fa fa-edit"></i></a></span>
                                                <span class="text-primary"><a href="#"><i class="fa fa-trash"></i></a></span> -->
                                                </td>
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

