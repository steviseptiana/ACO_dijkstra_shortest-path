<?php
require_once("koneksidb.php");
//include("koneksidb.php");

class login
{
	function masuk()
	{
		// $kon = new koneksidb();
		// $koneksi = $kon->konek();
		
		$kon=new koneksidb;
		$koneksi=$kon->konek();

		if(isset($_POST['tmasuk']))
		{
			if (empty($_POST['nama_p']) and empty($_POST['kata_s']))
			{
				header('location:../login.php?error=1');
				//break;
			}
			else if (empty($_POST['nama_p'])) 
			{
				header('location:../login.php?error=2');
				//break;
			} 
			else if (empty($_POST['kata_s'])) 
			{
				header('location:../login.php?error=3');
				//break;
			}
			else
			{
				$namap=$_POST['nama_p'];
				$kata_s=$_POST['kata_s'];
				$query 	= mysqli_query($koneksi, "SELECT * FROM login where nama_pengguna='$namap' and kata_sandi='$kata_s'");

				$result   = mysqli_num_rows($query);
				if($result>0)
				{
				    $rows = mysqli_fetch_array($query);
				    session_start();
					$_SESSION['nama_p']=$rows['nama'];
					$_SESSION['filefoto']=$rows['filefoto'];
					$user=$_SESSION['nama_p'];
					header("location:../index.php");
				}
				else
				{
				    header('location:../login.php?error=4');
				}
					
			}
						
		}

		if(!empty($_GET['logout']))
		{
			if($_GET['logout']=='ya')
			{
				session_start(); unset($_SESSION['filefoto']); unset($_SESSION['nama_p']);  
				header("location:../login.php");
			}
		}
	}
	
}

$log=new login;
$log->masuk();
?>


			