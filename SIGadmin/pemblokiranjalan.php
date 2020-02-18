<?php 
require_once('php/ceksession.php');
$nama=$_SESSION['nama'];  
$pengguna=$_SESSION['nama_p']; 
$gambar = $_SESSION['filefoto'];

require_once('phpjalan/koneksi.php');
$kon=new koneksi;
$koneksi=$kon->konek();


  function explodearray($delimiters, $array,$kv = '=>')
  {
    $a=true;
    $b=0;
    $c=0;
    $ka['lat']='';
    $ka['lng']='';
    if ($a = explode(chr( 1 ), str_replace( $delimiters, chr( 1 ), $array))) 
    { // create parts
          foreach ($a as $s) 
          { // each part
              if ($s) 
              {
                if ($pos = strpos($s, $kv)) 
                { // key/value delimiter
                    $ka[trim(substr($s, 0, $pos))] = trim(substr($s, $pos + strlen($kv)));
                } 
                else 
                { // key delimiter not found
                  if ($a==true)
                  {
                    $ka['lat'] = $ka['lat'].'#'.trim($s);
                    $a=false;
                  }
                  else
                  {
                    $ka['lng'] = $ka['lng'].'#'.trim($s);
                    $a=true;
                  }
                    
                  }
            }
          }
          return $ka;
    }
  }
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
  <script src="js/mapsaksesjalan.js"></script>
  <script src="js/mapslihatjalan.js"></script>

  <script type="text/javascript">
    function strToObj(str)
    {
       var obj = {};
       if(str||typeof str ==='string'){
           var objStr = str.match(/\{(.)+\}/g);
           eval("obj ="+objStr);
       }

       return obj
    }


    $(document).on("click", ".open-homeEvents", function () {
      var eventId = $(this).data('id');
      objdata=strToObj(eventId);
      koordinatlat=objdata.lat;
      koordinatlng=objdata.lng;
      ta=objdata.a;
      tt=objdata.t;
      mapslihatjalan();
      
      $('#Modallihatjalan').modal('show'); 
    });
    </script>

</head>

<body class="fixed-nav sticky-footer bg-light" id="page-top" onload="mapsaksesjalan()">
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
        <li class="breadcrumb-item active">Tables</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header" style="padding:10px;">
          <table width="100%">
            <tr>
              <td>
                <i class="fa fa-table"></i> Data Pemblokiran Akses Jalan
              </td>
               <td style="float:right;">
                <button class="btn btn-primary btn-info btn-sm" data-toggle="modal" data-target="#Modalpemblokiran"> Tambah Data </button>
              </td>
               <td style="float:right;">
                <button onclick="callbuttonjalan()" class="btn btn-primary btn-info btn-sm"> Lihat Pemblokiran </button>
              </td>
              <td style="float:right;">
                <form method="POST" action="phpjalan/crudjalan.php?hapussemua=1">
                  <input type="submit" class="btn btn-primary btn-info btn-sm" value="Hapus Semua Data" /> 
                </form>
              </td>
            </table>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Simpul Awal</th>
                  <th>Simpul Tujuan</th>
                  <th></th>
                </tr>
              </thead>
             
              <tbody>
                <tr>

                  <?php
                    $sql=mysqli_query($koneksi,'SELECT* from blokir_simpul');
                    while ($rows=mysqli_fetch_array($sql)) 
                    {

                      $id=$rows['id'];
                      $a=$rows['simpul_awal'];
                      $t=$rows['simpul_tujuan'];
                      $k=$rows['koordinat'];
                  ?>

                  <td><?php echo $id; ?></td>
                  <td><?php echo $a; ?></td>
                  <td><?php echo $t; ?></td>

                  <?php
                   
                    $koor[$a][$t]=$k;
                    $hasilkoor=array();
                    foreach ($koor as $key1 => $arr) 
                    {
                      foreach ($arr as $key2 => $value) 
                      {
                        $explode=explodearray(array('[', ',', ']'),$koor[$key1][$key2]);
                        $hasilkoor[$key1][$key2]=$explode;
                      }
                    }
                    
                    $lat=$hasilkoor[$key1][$key2]['lat'];
                    $lng=$hasilkoor[$key1][$key2]['lng'];

                    // echo "<pre>"; print_r($hasilkoor);

                  ?>
                  <td width="8%">
                    <form method="POST" action="phpjalan/crudjalan.php?id=<?php echo $id; ?>">
                      <input type="submit" style="margin:2px;" class="btn btn-danger btn-block btn-sm" name="thapus" value="Hapus"/>
                    </form>
                    <button id="tombol" class="open-homeEvents btn btn-primary btn-info btn-sm" data-id="{'lat':'<?php echo $lat; ?>','lng':'<?php echo $lng; ?>','a':'<?php echo $a; ?>','t':'<?php echo $t; ?>'}" >Lihat Jalan</button>
                  </td>
                </tr>

                 <?php
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Pemblokiran akses jalan</div>
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
    include('modalpemblokiranjalan.php');
    include('modallihatjalan.php');
    include('modallihatsemuajalan.php');
  ?>

   <?php
    if(isset($_GET['success']))
    {
      if($_GET['success']==1)
      {
        ?><script>alert('Data tersimpan')</script><?php
      }
      else if($_GET['success']==2)
      {
        ?><script>alert('Data terhapus')</script><?php
      }
      else if($_GET['success']==3)
      {
        ?><script>alert('Data terhapus semua')</script><?php
      }
    }
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

