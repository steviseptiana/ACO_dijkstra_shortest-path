<?php 
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

  <link href="css/new.css" rel="stylesheet">

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZfY-JkAcnh_Oip-_6-MA6aecRwU_CMsw&libraries=geometry"></script> 
  <script src="js/maps.js"></script>

  
</head>

<body class="bg-light" id="page-top" onload="maps()">
  
  <div class="row float-right" style="margin-top:10px; ">
    <div class="col-lg-12">
      <div style="margin-right:10px; width:28px; height:30px; background-color:#4682B1; padding-left:5px; border-radius:20%;" >
        <a href="index.php" style="cursor:pointer;" title="Refresh">
          <img src="images/refresh.png" width="18px" height="18px"/>
         </a>
      </div> 
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12" id="vertical-center" style="padding:20px;" >
      <div id="kotakmaps">
      
      </div>
      <center>  
        <button type="button" id="tombol" class="btn btn-danger btn-circle btn-xl" style="font-size:0.9em;" onclick="klikklik()"> 
          <img src="images/evakuasi1.png" width="60%" height="60%"/><br>
          Rute Evakuasi
        </button>
      </center>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin.min.js"></script>
  
  <?php
        function url_exists($url) 
        {
            if (!$fp = curl_init($url)) return false;
            return true;
        }
        
        $file = 'http://google.com';
        $file_headers = @get_headers($file);

        $sql=mysqli_query($koneksi,"SELECT* from lokasievakuasi where status='Aktif'");
  ?>

  <script>
    function klikklik()
    {
      <?php
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') 
        {
            ?>
              alert('Tidak ada koneksi internet');
            <?Php
        }
        else 
        {
            if(mysqli_num_rows($sql)<=0)
            {
              ?>
                alert('Tidak ada lokasi evakuasi yang aktif');
              <?Php
            }
            else
            {
              ?>
              document.getElementById('tombol').classList.toggle("anim");
              klikbutton();
              <?php
            }
        }
      ?>
    }
  </script>
  
  

</body>

</html>
