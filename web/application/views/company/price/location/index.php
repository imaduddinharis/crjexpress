<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
        <a href="<?=base_url()?>price-rules/location/add"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
            <button class="btn icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Add New User" type="button">
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
                            <h4 class="card-title text-uppercase text-muted mb-3">Location - Price</h4>
                            <div class="table-responsive">
                                <div>
                                    <table id="table_id" class="table align-items-center table-dark display hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Office</th>
                                                <th>City</th>
                                                <th>Destination</th>
                                                <th>City</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color:#333">
                                            <?php 
                                            $no = 1;
                                            foreach($location->result as $data):?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$data->location_price->branch_office?></td>
                                                <td><?=$data->bo_detail[0]->city?></td>
                                                <td><?=$data->location_price->destination?></td>
                                                <td><?=$data->dest_detail[0]->city?></td>
                                                <td>Rp. <?=number_format($data->location_price->price,0)?></td>
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

