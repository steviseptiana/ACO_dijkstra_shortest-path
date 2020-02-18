<?php
	require_once("koneksi.php");

	class maps
	{
		private $koneksidb;

		function __construct()
		{
			$db=new koneksi;
			$this->koneksidb=$db->konek();
		}

		function linemarkertampil()
		{

			$hasilmarker=array();
			$nomorsimpul=array();
			$query=mysqli_query($this->koneksidb,"SELECT *FROM blokir_simpul") or die(mysqli_error($this->koneksidb));
			while ($rows=mysqli_fetch_array($query))
			{
				$simpulawal=$rows['simpul_awal'];
				$simpultujuan=$rows['simpul_tujuan'];
				$nomorsimpul[$simpulawal]=$simpulawal;
				$nomorsimpul[$simpultujuan]=$simpultujuan;
			}

			foreach ($nomorsimpul as $key => $value) 
			{
				$query=mysqli_query($this->koneksidb,"SELECT *FROM koordinatawal where simpul='$key'") or die(mysqli_error($this->koneksidb));
				while ($rows=mysqli_fetch_array($query))
				{
					$koordinat=$rows['simpul'];
					$hasilmarker[$koordinat]['lat']=$rows['lat'];
					$hasilmarker[$koordinat]['lng']=$rows['lng'];
				}
			}

			echo json_encode($hasilmarker);
		}


		
	}

	$tes=new maps;
	$tes->linemarkertampil();
?>