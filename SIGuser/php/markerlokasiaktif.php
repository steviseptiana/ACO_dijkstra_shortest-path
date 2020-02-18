<?php
	require_once("koneksidb.php");

	class tampil
	{
		private $koneksi;
		function __construct()
		{
			$x=new koneksidb;
			$this->koneksi=$x->konek();
		}

		function dataevk()
		{
			$array=array();
			$i=0;
			$query=mysqli_query($this->koneksi,"SELECT* FROM lokasievakuasi");
			while ($rows=mysqli_fetch_array($query)) 
			{
				$id=$rows['id_lokevakuasi'];
				$lat=$rows['latitude'];
				$lng=$rows['longitude'];
				$status=$rows['status'];

				if($status=="Aktif")
				{
					$array[$i++]=array("id"=>$id,"lat"=>$lat,"lng"=>$lng,"status"=>$status);
				}
			}
			// echo "<pre>"; print_r($array);
			echo json_encode($array);
		}
	}

	$obj=new tampil;
	$obj->dataevk();
?>