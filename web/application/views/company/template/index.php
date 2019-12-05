<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    <?=$title?>
  </title>
  <!-- Favicon -->
  <link href="<?=$asset?>img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?=$asset?>js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="<?=$asset?>js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?=$asset?>css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="./index.html">
        <img src="<?=$asset?>img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?=$asset?>img/theme/team-1-800x800.jpg
">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <!-- <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Activity</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a> -->
            <div class="dropdown-divider"></div>
            <a href="<?=base_url()?>auth/logout" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./index.html">
                <img src="<?=$asset?>img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <!-- <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form> -->
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item  class=" active" ">
          <a class=" nav-link active " href="<?=base_url()?>"> <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <?php if($this->session->userdata('SESS_DATA')['role']== 'superuser' || $this->session->userdata('SESS_DATA')['role']== 'manager'):?>
          <li class="nav-item">
            <a class="nav-link " href="<?=base_url()?>manage-user">
              <i class="fas fa-users text-blue"></i> Manage User
            </a>
          </li>
          <?php endif;?>
          <li class="nav-item">
            <a class="nav-link " href="<?=base_url()?>package">
              <i class="ni ni-app text-blue"></i> Package
            </a>
          </li>
          <?php if($this->session->userdata('SESS_DATA')['role']== 'superuser' || $this->session->userdata('SESS_DATA')['role']== 'manager'):?>
          <li class="nav-item">
            <a class="nav-link " href="<?=base_url()?>price-rules/location">
              <i class="ni ni-square-pin text-red"></i> Price by Location
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="<?=base_url()?>price-rules/service">
              <i class="fas fa-truck text-red"></i> Price by Service
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url()?>branch-office">
              <i class="fas fa-building text-red"></i> Branch Office
            </a>
          </li>
          <?php endif;?>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">Documentation</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://documenter.getpostman.com/view/4364954/SW7bzmeV">
              <i class="ni ni-spaceship"></i> API Doc
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://github.com/imaduddinharis/crjexpress">
              <i class="ni ni-palette"></i> Github
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://crjexpress.id">
              <i class="ni ni-ui-04"></i> CRJExpress
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./../"><?=$title?></a>
        <!-- Form -->
        <!-- <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input class="form-control" placeholder="Search" type="text">
            </div>
          </div>
        </form> -->
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <!-- <img alt="Image placeholder" src="<?=$asset?>img/theme/team-4-800x800.jpg"> -->
                  <i class="fas fa-user"></i>
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?=$this->session->userdata('SESS_DATA')['username']?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h5 class="text-overflow m-0">CRJExpress</h5>
              </div>
              <!-- <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a>
              <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-calendar-grid-58"></i>
                <span>Activity</span>
              </a>
              <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-support-16"></i>
                <span>Support</span>
              </a> -->
              <div class="dropdown-divider"></div>
              <a href="<?=base_url()?>auth/logout" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <?=$content?>
      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
            © <?=date('Y')?> <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">CRJExpress IT</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core   -->
  <script src="<?=$asset?>js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="<?=$asset?>js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="<?=$asset?>js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="<?=$asset?>js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="<?=$asset?>js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  
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

  <script>
    // window.TrackJS &&
    //   TrackJS.install({
    //     token: "ee6fab19c5a04ac1a32a645abde4613a",
    //     application: "argon-dashboard-free"
    //   });
  </script>
</body>

</html>