<?php 
require_once('php/ceksession.php');
$nama=$_SESSION['nama'];  
$pengguna=$_SESSION['nama_p']; 
$gambar = $_SESSION['filefoto'];

require_once('php/koneksidb.php');
$kon=new koneksidb;
$koneksi=$kon->konek();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Administrator</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <link href="css/cssperbaikan.css" rel="stylesheet" type="text/css">

  <link href="css/new.css" rel="stylesheet">
  
  <script src="js/jquery-2.1.1.js"></script>
  <script src="js/jquery-2.1.1.min.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZfY-JkAcnh_Oip-_6-MA6aecRwU_CMsw"></script> 
  <script src="js/maps2.js"></script>

</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top" onload="maps2()">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php">
      <!-- <img src="images/bpbd.png" width="20px" height="20px"/>  -->
      BPBD TOLI-TOLI</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="dashboard.php">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-file"></i>
              <span class="nav-link-text">Data</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseExamplePages">
              <li >
                <a class="nav-link" href="lokasibanjir.php">
                  <!-- <i class='fa fa-th '></i> -->
                  <span class="nav-link-text" >Lokasi Banjir</span>
                </a>
              </li>
              <li clas="menu">
                <a class="nav-link" href="lokasievakuasi.php">
                  <!-- <i class="fa fa-map-marker"></i> -->
                  <span class="nav-link-text" >Lokasi Evakuasi</span>
                </a>
              </li>
              <li clas="menu">
                <a class="nav-link" href="pemblokiranjalan.php">
                  <!-- <i class="fa fa-map-marker"></i> -->
                  <span class="nav-link-text" >Pemblokiran Akses Jalan</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Lokasi Evakuasi">
            <a class="nav-link" href="lihatlokasievakuasi.php">
              <i class="fa fa-map-marker"></i>
              <span class="nav-link-text">Lihat Lokasi Evakuasi</span>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto" >
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-user"></i>
              <span class="d-lg-none">
                <span class="badge badge-pill badge-primary">Profil</span>
              </span>
              <span class="indicator text-primary d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="messagesDropdown" style="width:10%">
              <center><h6 class="dropdown-header"><strong><?php echo $nama; ?></strong></h6></center>
              <div class="dropdown-divider"></div>
              <div class="dropdown-message small">
                <center><img style="width:50%; height:50%" src="<?php echo 'Uploads/'.$gambar; ?>" class="gamprofil" ></img></center>
              </div>

              <div class="dropdown-divider"></div>
                <center>
                  <a class="dropdown-header" style="cursor:pointer;" data-toggle="modal" data-target="#Modalakun">Settings</a>
                </center>
            </div>

          </li>
       
          <li class="nav-item">
            <a class="nav-link" href="login.php">
              <i class="fa fa-fw fa-sign-out"></i>Logout</a>
          </li>
        </ul>

    </div>
  </nav>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a style="text-decoration: none;" href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Map</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header" style="padding:10px;">
          Lokasi Evakuasi
        </div>
        <div class="card-body">
          <div id="kotaklokasievakuasi" style="width:100%; height:390px; border:1px solid black;">
           
          </div>
        </div>
        <div class="card-footer small text-muted">Lokasi Evakuasi Kecamatan Baolan</div>
      </div>
  </div>

  <footer class="sticky-footer">
    <div class="container">
    <div class="text-center">
      <small>Copyright © BPBD Kabupaten Toli-Toli 2019</small>
    </div>
    </div>
  </footer>

  <?php
    include('modalakun.php');
    include('modallokasievakuasi.php');
  ?>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
  <!-- Custom scripts for this page -->
  <script src="js/sb-admin-datatables.min.js"></script>

</body>

</html>

