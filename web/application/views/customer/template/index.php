<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$title?></title>
	<link rel="icon" href="<?=$asset?>img/Fevicon.png" type="image/png">

  <link rel="stylesheet" href="<?=$asset?>vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/linericon/style.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="<?=$asset?>css/magnific-popup.css">
  <link rel="stylesheet" href="<?=$asset?>vendors/flat-icon/font/flaticon.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
  <link rel="stylesheet" href="<?=$asset?>css/style.css">
</head>
<body>

  <?=$content?>
  <!-- ================ start footer Area ================= -->
  <footer class="footer-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-3  col-md-6 col-sm-6">
          <div class="single-footer-widget">
            <h6>About CRJExpress</h6>
            <p>
            CRJExpress is a logistics company that provides freight forwarding services for both national and international shipping of goods, CRJExpress has its head office in Riau.
            </p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="single-footer-widget">
            <h6>Navigation Links</h6>
            <div class="row">
              <div class="col">
                <ul>
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Tracking</a></li>
                </ul>
              </div>									
            </div>							
          </div>
        </div>							
        <div class="col-lg-3  col-md-6 col-sm-6">
          <div class="single-footer-widget">
            <h6>Newsletter</h6>
            <p>
              For business professionals caught between high OEM price and mediocre print and graphic output.									
            </p>								
            <div id="mc_embed_signup">
              <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscription relative">
                <div class="input-group d-flex flex-row">
                  <input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                  <button class="btn bb-btn"><span class="lnr lnr-location"></span></button>		
                </div>									
                <div class="mt-10 info"></div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3  col-md-6 col-sm-6">
          <div class="single-footer-widget mail-chimp">
            <h6 class="mb-20">Partners & Sponsors</h6>
            <ul class="instafeed d-flex flex-wrap">
              <li><img src="<?=$asset?>img/instagram/i1.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i2.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i3.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i4.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i5.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i6.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i7.jpg" alt=""></li>
              <li><img src="<?=$asset?>img/instagram/i8.jpg" alt=""></li>
            </ul>
          </div>
        </div>						
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row align-items-center">
          <p class="col-lg-8 col-sm-12 footer-text m-0 text-center text-lg-left"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="https://colorlib.com" target="_blank">Colorlib</a> | <a href="https://colorlib.com" target="_blank">Technology Digital Art</a> | 
          <div class="col-lg-4 col-sm-12 footer-social text-center text-lg-right">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-dribbble"></i></a>
            <a href="#"><i class="fab fa-behance"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- ================ End footer Area ================= -->




  <script src="<?=$asset?>vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="<?=$asset?>vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="<?=$asset?>vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="<?=$asset?>vendors/Magnific-Popup/jquery.magnific-popup.min.js"></script>
  <script src="<?=$asset?>js/jquery.ajaxchimp.min.js"></script>
  <script src="<?=$asset?>js/mail-script.js"></script>
  <!-- <script src="<?=$asset?>js/countdown.js"></script> -->
  <script src="<?=$asset?>js/jquery.magnific-popup.min.js"></script>	
  <script src="<?=$asset?>js/main.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" type="text/javascript" ></script>
  <script>
  $(document).ready( function () {
      if($('#table_id').length>0){
        $('#table_id').DataTable();
      }
  } );
  </script>
  <script type="text/javascript">
    
      function check_status(){
            var baseurl = '<?=$this->API?>';
            var base = '<?=base_url()?>';
            var id = "<?=$this->session->userdata('SESS_DATA')['cust_id']?>";
    
            fetch(baseurl+'ppob_history?id='+id+'&action=checking')
            .then((res) => { return res.json() })
            .then((data) => {
                // console.log(data.result);
                let result = ``;
                data.result.forEach((history) => {
                    const { id_ppob_history, id_ppob_customer, sid, description, amount, status, created_at, deleted_at } = history
                    if(status == "berhasil"){
                        window.location = base+'topup-saldo?status=success';
                    }
                });
            })
            
        }

        function check_status_ppob(){
            var baseurl = '<?=$this->API?>';
            var base = '<?=base_url()?>';
            var id = "<?=$this->session->userdata('SESS_DATA')['cust_id']?>";
    
            fetch(baseurl+'ppob_history?id='+id+'&action=checking_ppob')
            .then((res) => { return res.json() })
            .then((data) => {
                // console.log(data.result);
                let result = ``;
                data.result.forEach((history) => {
                    const { id_ppob_history, id_ppob_customer, sid, description, amount, status, created_at, deleted_at } = history
                    if(status == "SUCCESS" || status == "PAYMENT SUCCESS" ){
                        window.location = base+'feature-crj-express/top-up/success';
                    }
                });
            })
            
        }
        $(document).ready(function(){
        if($('#loading').length){
          setInterval(function() { check_status() }, 3000);
        }else if($('#loading1').length){
          setInterval(function() { check_status_ppob() }, 3000);
        }
      });
</script>

</body>
</html>