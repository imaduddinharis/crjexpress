<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
    </div>
</div>
<div class="container-fluid mt--8">
    <form method="post" action="<?=base_url()?>branch-office/create">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card card-stats mb-4 mb-lg-0 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-uppercase text-default mb-0">Location Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                                <i class="ni ni-square-pin"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" id="province" name="province">
                                        <option value="">Province</option>
                                        <?php foreach($province->result as $prov):?>
                                        <option value="<?=$prov->id_province?>"><?=$prov->name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" id="city" name="city">
                                        <option value="">City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control form-control-alternative" id="district" name="district">
                                    <option value="">District</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control form-control-alternative" id="village" name="village">
                                        <option value="">Village</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-4 text-right">
                <button class="btn btn-icon btn-3 btn-primary" type="submit" name="submit">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Create Branch Office</span>
                </button>
            </div>
        </div>
    </form>

<script>
var baseurl = '<?=$this->API?>';
document.getElementById('province').addEventListener('change', getDataKabupaten);
document.getElementById('city').addEventListener('change', getDataKecamatan);
document.getElementById('district').addEventListener('change', getDataDesa);
        function getDataKabupaten(){
            var idProvinsi = document.getElementById('province').value;
            if(idProvinsi != ''){
                fetch(baseurl+'city?id_province='+idProvinsi)
                .then((res) => { return res.json() })
                .then((data) => {
                    // console.log(data);
                    let result = ``;
                    data.result.forEach((kabupatens) => {
                        const { id_city, id_province, name } = kabupatens
                        result +=
                            `<option value="${id_city}">${name}</option>`;
                                document.getElementById('city').innerHTML = result;
                    });
                })
            }else{
                let city = `<option value="">City</option>`;
                document.getElementById('city').innerHTML = city;
                let district = `<option value="">District</option>`;
                document.getElementById('district').innerHTML = district;
                let village = `<option value="">Village</option>`;
                document.getElementById('village').innerHTML = village;
            }
        }

        function getDataKecamatan(){
            var idKabupaten = document.getElementById('city').value;
            fetch(baseurl+'district?id_city='+idKabupaten)
            .then((res) => { return res.json() })
            .then((data) => {
                // console.log(data);
                let result = ``;
                data.result.forEach((kecamatans) => {
                    const { id_district, id_city, name } = kecamatans
                    result +=
                        `<option value="${id_district}">${name}</option>`;
                            document.getElementById('district').innerHTML = result;
                });
            })
        }

        function getDataDesa(){
            var idKecamatan = document.getElementById('district').value;
            fetch(baseurl+'village?id_district='+idKecamatan)
            .then((res) => { return res.json() })
            .then((data) => {
                // console.log(data);
                let result = ``;
                data.result.forEach((desas) => {
                    const { id_village, id_district, name } = desas
                    result +=
                        `<option value="${id_village}">${name}</option>`;
                            document.getElementById('village').innerHTML = result;
                });
            })
        }

</script>