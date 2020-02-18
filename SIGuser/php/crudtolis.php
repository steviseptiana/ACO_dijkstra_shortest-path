<?php
require_once('koneksidb.php');

class crudtolis
{
	private $koneksi;

	function __construct()
	{
		$kon=new koneksidb;
		$this->koneksi=$kon->konek();
	}

	function login()
	{
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
				$n=$_POST['nama_p'];
				header("location:../login.php?error=3&nama=$n");
				//break;
			}
			else
			{
				$namap=$_POST['nama_p'];
				$kata_s=$_POST['kata_s'];
				$query 	= mysqli_query($this->koneksi, "SELECT * FROM pengguna where nama_pengguna='$namap' and kata_sandi='$kata_s'");

				$result   = mysqli_num_rows($query);
				if($result>0)
				{
				    $rows = mysqli_fetch_array($query);
				    session_start();
					$_SESSION['nama_p']=$rows['nama_pengguna'];
					$_SESSION['filefoto']=$rows['filefoto'];
					$_SESSION['nama']=$rows['nama'];
					header("location:../dashboard.php");
				}
				else
				{
					$n=$_POST['nama_p'];
				    header("location:../login.php?error=4&nama=$n");
				}
					
			}
						
		}
	}


	function prosesdataakun()
	{
		if(isset($_POST['tsimpan']))
		{
			$namaat=$_POST['namal'];
			$namap=$_POST['nama_p'];
			$pass=$_POST['pass'];
			$file=basename( $_FILES["file"]["name"]);
			$gambar=$_POST['gambar'];

			$target_dir = "../Uploads/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Cek

			$check = getimagesize($_FILES["file"]["tmp_name"]);
			if($check !== false) 
			{
				$uploadOk = 1;
			} 
			else 
			{
				header('location:../dashboard.php?error');
			}

			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
			{
        		$simpangambar=$file;
	        } 		
	        else
	        {
	        	$simpangambar=$gambar;
	        }	

			
			$query=mysqli_query($this->koneksi, "UPDATE pengguna set nama='$namaat',nama_pengguna='$namap',kata_sandi='$pass',filefoto='$simpangambar'") or die(mysqli_error($this->koneksi));
			session_start();
			unset($_SESSION['filefoto']);
			unset($_SESSION['nama_p']);
			unset($_SESSION['nama']);
			session_unset();
			session_start();
			$_SESSION['filefoto']=$simpangambar;
			$_SESSION['nama_p']=$namap;
			$_SESSION['nama']=$namaat;
			header('location:../dashboard.php?success');
			
		}
	}

	function prosesdatalokasibanjir()
	{
		if(isset($_POST['tsimpan']))
		{
			$id_banjir=$_POST['id_banjir'];
			$lokasi_banjir=$_POST['lokasi_banjir'];
			$ket=$_POST['ket'];
			$radio=$_POST['pilihstatusbanjir'];

			if($radio=="Aktif")
			{
				$status="Aktif";
			}
			else
			{
				$status="Tidak Aktif";
			}

			$query=mysqli_query($this->koneksi, "INSERT INTO lokasibanjir values('$id_banjir','$lokasi_banjir','$ket','$status')") or die(mysqli_error($this->koneksi));	

			header('location:../lokasibanjir.php?success=1');
		}

		if(isset($_POST['tubah']))
		{
			$id_banjir=$_POST['id_banjir'];
			$lokasi_banjir=$_POST['lokasi_banjir'];
			$ket=$_POST['ket'];
			$radio=$_POST['pilihstatusbanjir'];

			if($radio=="Aktif")
			{
				$status="Aktif";
			}
			else
			{
				$status="Tidak Aktif";
			}

			$query=mysqli_query($this->koneksi, "UPDATE lokasibanjir SET lokasi_banjir='$lokasi_banjir',ket='$ket',status='$status' where id_lokbanjir='$id_banjir'") or die(mysqli_error($this->koneksi));	

			header('location:../lokasibanjir.php?success=2');
		}

		if(isset($_POST['thapus']))
		{
			$id_banjir=$_GET['id'];
			$query=mysqli_query($this->koneksi, "DELETE from lokasibanjir where id_lokbanjir='$id_banjir'") or die(mysqli_error($this->koneksi));	

			header('location:../lokasibanjir.php?success=3');
		}
	}

	function prosesdatalokasievakuasi()
	{
		if(isset($_POST['tsimpan']))
		{
			$id_evk=$_POST['id_evk'];
			$lat=$_POST['latitude'];
			$lng=$_POST['longitude'];
			$radio=$_POST['pilihstatusevk'];

			if($radio=="Aktif")
			{
				$status="Aktif";
			}
			else
			{
				$status="Tidak Aktif";
			}

			$query=mysqli_query($this->koneksi, "INSERT INTO lokasievakuasi values('$id_evk','$lat','$lng','$status')") or die(mysqli_error($this->koneksi));	

			header('location:../lokasievakuasi.php?success=1');
		}

		if(isset($_POST['tubah']))
		{
			$id_evk=$_POST['id_evk'];
			$lat=$_POST['latitude'];
			$lng=$_POST['longitude'];
			$radio=$_POST['pilihstatusevk'];

			if($radio=="Aktif")
			{
				$status="Aktif";
			}
			else
			{
				$status="Tidak Aktif";
			}

			$query=mysqli_query($this->koneksi, "UPDATE lokasievakuasi SET latitude='$lat',longitude='$lng',status='$status' where id_lokevakuasi='$id_evk'") or die(mysqli_error($this->koneksi));	

			header('location:../lokasievakuasi.php?success=2');
		}

		if(isset($_POST['thapus']))
		{
			$id_evk=$_GET['id'];
			$query=mysqli_query($this->koneksi, "DELETE from lokasievakuasi where id_lokevakuasi='$id_evk'") or die(mysqli_error($this->koneksi));	

			header('location:../lokasievakuasi.php?success=3');
		}
	}
}

$obj=new crudtolis;
if($_GET['action']=="login")
{
	$obj->login();
}
else if($_GET['action']=='dataakun')
{
	$tesdata=$obj->prosesdataakun();
}
else if($_GET['action']=='datalokasibanjir')
{
	$tesdata=$obj->prosesdatalokasibanjir();
}
else if($_GET['action']=='datalokasievakuasi')
{
	$tesdata=$obj->prosesdatalokasievakuasi();
}
?>