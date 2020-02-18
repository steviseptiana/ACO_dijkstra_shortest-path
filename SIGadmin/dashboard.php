<?php 
require_once('php/ceksession.php');
$nama=$_SESSION['nama'];  
$pengguna=$_SESSION['nama_p']; 
$gambar = $_SESSION['filefoto'];
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

</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top">
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
              <i class="fa fa-fw fa-user" ></i>
              <span class="d-lg-none">
                <span class="badge badge-pill badge-primary">Profil</span>
              </span>
              <span class="indicator text-primary d-none d-lg-block" >
                <i class="fa fa-fw fa-circle" ></i>
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
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a style="text-decoration: none;" href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>

     
      <div class="row">
        <div class="col-lg-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              Data lokasi banjir
            </div>
            <div class="panel-body" style="text-align:justify;">
              <p>Halaman untuk mengelola data lokasi-lokasi banjir di Kecamatan Baolan, Kabupaten Toli-Toli. 
                Administrator dapat menginputkan, mengubah dan menghapus informasi banjir meliputi 
                lokasi, kedalaman dan informasi banjir lainnya.
              </p>
            </div>
            <div class="panel-footer">
              <a style="text-decoration: none; font-size: 15px;" href="lokasibanjir.php">
                Klik disini
              </a>
            </div>
          </div>
        </div>

         <div class="col-lg-4">
          <div class="panel panel-success">
            <div class="panel-heading">
              Data lokasi evakuasi
            </div>
            <div class="panel-body" style="text-align:justify;">
              <p >Halaman untuk mengelola data lokasi-lokasi evakuasi banjir di Kecamatan Baolan, Kabupaten Toli-Toli. 
                Administrator dapat menginputkan, mengubah dan menghapus data lokasi evakuasi. Administrator
                juga dapat mengaktifkan status lokasi evakuasi ketika terjadi banjir.
              </p>
            </div>
            <div class="panel-footer">
              <a style="text-decoration: none; font-size: 15px;" href="lokasievakuasi.php">
               Klik disini
              </a>
            </div>
          </div>
        </div>
      </div>
            
      
      
    </div>
  </div>

  <footer class="sticky-footer">
    <div class="container">
    <div class="text-center">
      <small>Copyright © BPBD Kabupaten Toli-Toli 2019</small>
    </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>-->
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
  <!-- Custom scripts for this page
  <script src="js/sb-admin-datatables.min.js"></script>
  <script src="js/sb-admin-charts.min.js"></script>-->

  <?php
    include('modalakun.php');
  ?>
  
  <?php
    if(isset($_GET['error']))
    {
      ?><script>alert('Maaf, terjadi kesalahan. Data tidak terimpan')</script><?php
    }
    if(isset($_GET['success']))
    {
      ?><script>alert('Data administrator tersimpan')</script><?php
    }
  ?>
  
</body>

</html>
