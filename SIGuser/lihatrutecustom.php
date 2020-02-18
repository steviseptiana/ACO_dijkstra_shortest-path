<?php 
  require_once('php/koneksidb.php');

  $kon=new koneksidb;
  $koneksi=$kon->konek();
  session_start();

  $sql=mysqli_query($koneksi,"SELECT* from lokasievakuasi where status='Aktif'");

  if(mysqli_num_rows($sql)<=0)
  {
    header('location:index.php'); 
  }

  $param=true;

  if(!empty($_GET['berhasil'])) 
  {
    if(!isset($_SESSION['lat'])) 
    {
      header('location:lihatrutecustom.php'); 
    }
    
    if(!isset($_SESSION['berhasil'])==1)
    {
      $param=true;
    }
  }

  if(!empty($_GET['error']))
  {
    if(!isset($_SESSION['lokevk']))
    {
      header('location:lihatrutecustom.php'); 
    }

    if(!isset($_SESSION['error'])==1)
    {
      $param=false;
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
  <title>User</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <link href="css/cssperbaikan.css" rel="stylesheet" type="text/css">

  <link href="css/new1.css" rel="stylesheet">
  
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZfY-JkAcnh_Oip-_6-MA6aecRwU_CMsw&libraries=geometry"></script>
  <script src="js/jquery-2.1.1.js"></script>
  <script src="js/infobox.js"></script>
  <script src="js/mapscustom.js"></script>
  
</head>

<body class="bg-light" id="page-top" style="background-color: white; !important" onload="maps()">
  <div class="content-wrapper" style="margin-left:0px;">
      <div class="container-fluid">

          <div class="row" style="padding:0px;">
            <div class="col-lg-12" >
              <div style="text-align:center; height:40px; ">
                 <table>
                        <tr>
                          <td style="background-color:white;">
                            <center>
                            <div class="kotakkecil">
                              <a href="index.php" style="cursor:pointer;" title="Home">
                                <img src="images/home.png" width="30px" height="30px"/>
                              </a>
                            </div> 
                            </center>
                          </td>
                          <td style="background-color:white;">
                            <center>
                            <div class="kotakkecil">
                              <?php
                                if($param==true)
                                {
                              ?>
                              <a href="lihatrutecustom.php?berhasil=1" style="cursor:pointer;" title="Refresh">
                                <img src="images/refresh.png" width="25px" height="25px"/>
                              </a>
                              <?php
                                }
                                else
                                {
                                  ?>
                                <a href="lihatrutecustom.php?error=1" style="cursor:pointer;" title="Refresh">
                                  <img src="images/refresh.png" width="25px" height="25px"/>
                                </a>
                              <?php
                                }
                              ?>
                            </div>
                            </center> 
                          </td>
                          <td width="100%" style="color:white;">
                            <div style="background-color:#4682B4; padding:6px; height:40px; letter-spacing: -1px;">
                               Rute Evakuasi
                            </div> 
                          </td>
                        </tr>
                  </table>
              </div>
            </div>
          </div>        
          
          <div class="row" style="margin-top:8px;">
            <div class="col-lg-12">
                <div id="kotakrute" style="width:100%; height:450px;"></div>
                <?php 
                    if (empty($_GET['berhasil']) and empty($_GET['error'])) 
                    {
                ?>
                  <text style="color:grey; font-size:0.8em; letter-spacing: -1px;">*klik peta untuk memilih lokasi secara custom</text>
                  <br>
                <?php
                    }
                ?>
                
                  <text style="color:grey; font-size:0.8em; letter-spacing: -1px;">*Jalan berwarna merah tidak dapat dilewati</text>
                
            </div>
          </div>

          <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="panel panel-info" id="divevk" style="visibility:hidden; display:none;">
                    <div class="panel-heading" style="padding:10px; letter-spacing: -1px;">
                      <center>Informasi rute lokasi evakuasi Kecamatan Baolan</center>
                    </div>
                    <div class="panel-body" style="text-align:justify; padding-top: 0px;">
                      <table width="100%" cellspacing="0">
                      <tbody>
                          <?php

                            if (!empty($_GET['berhasil'])) 
                            {
                              if ($_GET['berhasil'] == 1 and isset($_SESSION['Ruteevk'])) 
                              {

                                $rute=$_SESSION['Ruteevk'];
                                $notrute=[];
                                foreach ($rute as $key => $value) 
                                {
                                  if($value=='Tidak menemukan titik tujuan yang dicari')
                                  {
                                    array_push($notrute,$key);
                                    unset($rute[$key]);
                                  }
                                }

                                $asc=[];

                                //asc bobot
                                foreach ($rute as $key => $row) 
                                {
                                    $asc[$key]  = $row['Bobot'];
                                }
                                array_multisort($asc, SORT_ASC, $rute);

                                foreach ($asc as $key => $value) 
                                {
                                   
                          ?>
                        <tr>
                          <td style=" padding:10px; padding-top:10px; font-size:0.9em;">Lokasi Evakuasi <?php echo $key." (".round($value/1000,3)." KM)"; ?></td>
                          <!-- <td style="padding:10px;"><button class="btn btn-info btn-block btn-sm" id="ruteevk" value="<?php //echo $key ?>" onclick="customrute()">Lihat Rute</button></td> -->
                          <td style="padding:10px;"><button class="open-homeEvents btn btn-info btn-block btn-sm" id="ruteevk" data-id="<?php echo $key ?>">Lihat Rute</button></td>
                        </tr>
                       
                         <?php
                              }
                          

                              foreach ($notrute as $key => $value) 
                              {
                                ?>
                                  <tr>
                                    <td style=" padding:10px; padding-top:10px; font-size:0.9em;">Lokasi Evakuasi <?php echo $value." (0 KM)"; ?></td>
                                    <td style="padding:10px;"><button class="open-homeEvents btn btn-info btn-block btn-sm" disabled>Lihat Rute</button></td>
                                  </tr>
                                <?php
                              }

                            }
                          }

                          if(!empty($_GET['error'])) 
                          {
                            $lokevakuasi=$_SESSION['lokevk'];
                            ?>
                            <div style="padding-top:10px; font-weight:bold; font-size:1em">Tidak ditemukan jalur menuju lokasi evakuasi</div>
                            <?php
                            foreach ($lokevakuasi as $key => $value) 
                            {                              
                            ?>

                              <tr>
                                <td style=" padding:10px; padding-top:10px; font-size:0.9em;">Lokasi Evakuasi <?php echo $lokevakuasi[$key][2]." (0 KM)"; ?></td>
                                <td style="padding:10px;"><button class="open-homeEvents btn btn-info btn-block btn-sm" disabled>Lihat Rute</button></td>
                              </tr>
                            <?php
                            }
                          }
                          ?>


                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
          </div>
          
          <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading" style="padding:10px; letter-spacing: -1px;">
                      <center>Informasi lokasi terjadi banjir </center>
                    </div>
                    <div class="panel-body" style="text-align:justify; padding-top: 0px;">
                      <table width="100%" cellspacing="0">
                      <tbody>
                          <?php
                            $sql=mysqli_query($koneksi,"SELECT* from lokasibanjir where status='Aktif'");
                            while ($rows=mysqli_fetch_array($sql)) 
                            {
                              $lokban=$rows['lokasi_banjir'];
                              $ket=$rows['ket'];
                          ?>
                        <tr>
                          <td style="padding-top:10px; font-weight:bold; font-size:1em"><?php echo $lokban; ?></td>
                        </tr>
                        <tr>
                          <td style="font-size:0.9em; padding-left:20px;"><?php echo nl2br($ket); ?></td>
                        </tr>

                         <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="panel-footer" style="text-align:center; letter-spacing: -1px;">
                      <small>Copyright © BPBD Kabupaten Toli-Toli 2019</small>
                    </div>
                </div>
            </div>
          </div>

    </div>
  </div>


    <?php

      if(!empty($_GET['error'])) 
      {
        if($_GET['error']==1)
        {
          $lat=$_SESSION['lat'];
          $lng=$_SESSION['lng'];
          ?>
          <script>
            lat = <?php echo json_encode($lat); ?>;
            lng= <?php echo json_encode($lng); ?>;
            paramerror=true;
            document.getElementById('divevk').style="visibility:visible; display:block;";  
            alert('Jalur menuju lokasi evakuasi tidak ditemukan')
           </script>

      <?php

          }
        }
      
      
      if (!empty($_GET['berhasil'])) 
      {
        if ($_GET['berhasil'] == 1 and isset($_SESSION['Ruteevk'])) 
        {
            
          $koordinat=$_SESSION['array'];
          $lat=$_SESSION['lat'];
          $lng=$_SESSION['lng'];
          $bobot=$_SESSION['bobot'];
          $idevk=$_SESSION['idevk'];
          //echo "<pre>";print_r($koordinat);
          $array=array();
          foreach ($koordinat as $key => $arr) 
          {
            foreach ($arr as $key => $value) 
            {
              array_push($array,"[".$value."]");
            }
          }
      ?>

          <script type="text/javascript">
              document.getElementById('divevk').style="visibility:visible; display:block;";
                        
              var obj = <?php echo json_encode($array); ?>;
              lat = <?php echo json_encode($lat); ?>;
              lng= <?php echo json_encode($lng); ?>;
              bobot= <?php echo json_encode($bobot); ?>;
              idevk= <?php echo json_encode($idevk); ?>;
              rute= <?php echo json_encode($rute); ?>;
              param=true;
              paramklikpeta=true;

           </script>

      <?php

          }
        }
        

      ?>


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

  
</body>

</html>
