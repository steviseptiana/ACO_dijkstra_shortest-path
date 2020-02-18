<?php
 
if (isset($_SESSION['nama_p']) and isset($_SESSION['nama']) and isset($_SESSION['filefoto'])) 
{
    session_start();
    unset($_SESSION['filefoto']);
    unset($_SESSION['nama_p']);
    unset($_SESSION['nama']);
    session_unset();
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
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
</head>

<body class="bg-light">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header" style="background-color:#4682B4; color:white; font-weight:bold; text-align:center;">LOGIN</div>
      <div class="card-body">
        <form action="php/crudtolis.php?action=login" method="POST">
          <div class="form-group">
            <label >Username</label>
            <input name="nama_p" value="<?php if(!empty($_GET['nama'])){ echo $_GET['nama'];}?>" class="form-control" type="input"  placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label >Password</label>
            <input id="p" name="kata_s" class="form-control" type="password" placeholder="Password">
            
            <script>
              document.getElementById("p").value=""; 
            </script>
          </div>          
          <input class="btn btn-primary btn-block" type="submit" name="tmasuk" value="Login">
        </form>
       
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <?php
    if(!empty($_GET['error']))
    {
      if($_GET['error']==1)
      {
        ?><script>alert('Username dan password masih kosong');</script>
        <?php
      }
      elseif($_GET['error']==2)
      {
        ?><script>alert('Username masih kosong');</script>
        <?php
      }
      elseif($_GET['error']==3)
      {
        ?><script>alert('Password masih kosong');</script>
        <?php
      }
      elseif($_GET['error']==4)
      {
        ?><script>alert('Akun tidak terdaftar');</script>
        <?php
      }
    }
  ?>
</body>

</html>
