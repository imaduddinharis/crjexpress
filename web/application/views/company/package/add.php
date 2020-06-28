<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <span class="alert-inner--icon"><i class="fas fa-shipping-fast text-blue"></i></span>
            <span class="alert-inner--text"><strong>CRJExpress </strong></span>
        </div>
    </div>
</div>
<div class="container-fluid mt--8">
    <form method="post" action="<?=base_url()?>package/create">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card card-stats mb-4 mb-lg-0 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-uppercase text-default mb-0">Customer Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Customer Information">
                                <i class="fas fa-user"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="sender_name" name="sender_name" placeholder="Sender Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="recipient_name" name="recipient_name" placeholder="Recipient Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="sender_phone" name="sender_phone" placeholder="Sender Phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="recipient_phone" name="recipient_phone" placeholder="Recipient Phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-alternative" id="sender_mail" name="sender_mail" placeholder="Sender Mail" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-alternative" id="recipient_mail" name="recipient_mail" placeholder="Recipient Mail (Optional)">
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
                                <h3 class="card-title text-uppercase text-default mb-0">Package Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Information">
                                <i class="ni ni-app"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <h4 class="text-primary">Service: </h4>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="service" class="custom-control-input" id="service_regular" type="radio" value="2" checked>
                                    <label class="custom-control-label" for="service_regular">CRJ Regular</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="service" class="custom-control-input" id="service_fast" value="1" type="radio">
                                    <label class="custom-control-label" for="service_fast">CRJ Fast</label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mt-4">
                            <div class="col-md-2">
                                <h4 class="text-primary">Shipping Type: </h4>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="shipping_type" class="custom-control-input" id="shipping_type_progresif" type="radio">
                                    <label class="custom-control-label" for="shipping_type_progresif">Progresif</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="shipping_type" class="custom-control-input" id="shipping_type_regresif" value="ST01" type="radio" checked>
                                    <label class="custom-control-label" for="shipping_type_regresif">Regresif</label>
                                </div>
                            </div>
                        </div> -->
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <h4 class="text-primary">Package Type: </h4>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="package_type" class="custom-control-input" id="package_type_makanan" value="makanan" type="radio" checked>
                                    <label class="custom-control-label" for="package_type_makanan">Makanan</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="package_type" class="custom-control-input" id="package_type_surat" value="surat" type="radio">
                                    <label class="custom-control-label" for="package_type_surat">Surat</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-control-alternative custom-radio">
                                    <input name="package_type" class="custom-control-input" id="package_type_elektronik" value="elektronik" type="radio">
                                    <label class="custom-control-label" for="package_type_elektronik">Elektronik</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="length" placeholder="Length (cm)" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="width" placeholder="Width (cm)" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="height" placeholder="Height (cm)" required>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="package_notes" name="package_notes" placeholder="Notes">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-alternative" id="weight" name="weight" placeholder="Weight (kg)" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" name="packaging_type" id="packaging_type">
                                        <option value="bubble-wrap">Bubble Wrap</option>
                                        <option value="plastic-wrap">Plastic Wrap</option>
                                        <option value="wooden-box">Wooden Box</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                    <input class="custom-control-input" id="insurance" name="insurance" type="checkbox">
                                    <label class="custom-control-label" for="insurance">Insurance</label>
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
                                <h3 class="card-title text-uppercase text-default mb-0">Location Information</h3>
                            </div>
                            <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Package Type">
                                <i class="ni ni-square-pin"></i>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" id="province" name="province">
                                        <option value="">Province</option>
                                        <?php foreach($province->result as $prov):?>
                                        <option value="<?=$prov->id_province?>"><?=$prov->name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control form-control-alternative" id="city" name="city">
                                        <option value="">City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-alternative" id="district" name="district">
                                    <option value="">District</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-alternative" id="village" name="village">
                                        <option value="">Village</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="address_detail" name="address_detail" placeholder="Address Detail">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-4 text-right">
                <button class="btn btn-icon btn-3 btn-primary" type="submit" name="submit">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Create Package</span>
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