<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
        <a href="<?=base_url()?>manage-user/add"style="position:fixed; z-index:99999; bottom:20px; right:10px;">
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
                            <h4 class="card-title text-uppercase text-muted mb-3">Employees</h4>
                            <div class="table-responsive">
                                <div>
                                    <table id="table_id" class="table align-items-center table-dark display hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Fullname</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Office Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color:#333">
                                            <?php 
                                            $no = 1;
                                            foreach($users as $data):?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$data->fullname?></td>
                                                <td><?=$data->position?></td>
                                                <td><?=$data->branch_office?></td>
                                                <td><?=$data->office_district?>, <?=$data->office_city?></td>
                                                <td class="text-right">
                                                <!-- <span class="text-primary"><a href="#"><i class="fa fa-edit"></i></a></span> -->
                                                <form method="post" action="<?=base_url()?>manage-user/delete" onsubmit="return confirm('are you sure delete this user?');">
                                                <input type="hidden" value="<?=$data->id_users?>" name="id_users">
                                                <input type="hidden" value="<?=$data->id_employees?>" name="id_employees">
                                                <button type="submit" name="delete" style="cursor:pointer"><i class="fa fa-trash"></i></button>
                                                </form>
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

