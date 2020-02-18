<?php
ini_set('max_execution_time', 0);
require_once("ACSjp.php");
require_once('potongjalur/simpulbaru.php');
require_once('../koneksidb2.php');
require_once('../koneksidb.php');

class panggiljp
{
	private $koneksi;
	private $koneksi2;
	private $ruteterpendek=array();

	function __construct()
	{
		$kon=new koneksidb;
		$this->koneksi=$kon->konek();
		$kon2=new koneksidb2;
		$this->koneksi2=$kon2->konek2();
	}

	function buattablesementara()
	{
		$query4=mysqli_query($this->koneksi2,"INSERT graphsementara SELECT*FROM graph");
		$query2=mysqli_query($this->koneksi2,"INSERT koordinatawalsementara SELECT*FROM koordinatawal");

	}

	
	function hapustablesementara()
	{
		$query1=mysqli_query($this->koneksi2,"DELETE FROM graphsementara");
		$query2=mysqli_query($this->koneksi2,"DELETE FROM koordinatawalsementara");
		
	}

	function main($latawal,$lngawal)
	{
		$mulai = microtime(true);

		$this->hapustablesementara();
		$this->buattablesementara();

		// tujuan
		$lokasievakuasi=array();
		$count=0;
		$query=mysqli_query($this->koneksi,"SELECT *FROM lokasievakuasi where status='Aktif'");
		while ($rows=mysqli_fetch_array($query)) 
		{
			$lokasievakuasi[$count][0]=$rows['latitude'];
			$lokasievakuasi[$count][1]=$rows['longitude'];
			$lokasievakuasi[$count][2]=$rows['id_lokevakuasi'];
			$count++;
		}


		//potongsimpul
		$simpulbaru=new simpulbaru;		
		$simpulcount=3001;

		$titikawal=$simpulbaru->main($latawal, $lngawal, 3000);
		

		//jalur terpendek
		$obj=new inisialisasi;
		$hasilruteterpendek=array();
		foreach ($lokasievakuasi as $key => $value) 
		{
			$titiktujuan=$simpulbaru->main($lokasievakuasi[$key][0], $lokasievakuasi[$key][1], $simpulcount);
			$ruteterpendek=$obj->main($titikawal,$titiktujuan);
			$hasilruteterpendek[$lokasievakuasi[$key][2]]= $ruteterpendek;
			
			if($hasilruteterpendek[$lokasievakuasi[$key][2]]!='Tidak menemukan titik tujuan yang dicari')
			{
				$hasilruteterpendek[$lokasievakuasi[$key][2]]['Koordinat']=$this->gambar($ruteterpendek);
			}

			$simpulcount++;
		}

		//membandingkan bobot terbaik untuk memilih lokasi evakuasi terdekat
		$best=999999999;
		$keyterbaik=-1;
		foreach ($hasilruteterpendek as $key => $value) 
		{
			if($hasilruteterpendek[$key]!='Tidak menemukan titik tujuan yang dicari')
			{
				if($hasilruteterpendek[$key]['Bobot']<=$best)
				{
					$best=$hasilruteterpendek[$key]['Bobot'];
					$keyterbaik=$key;
				}
			}
		}

		//rute evakuasi terdekat
		if($keyterbaik!=-1)
		{
			$ruteevakuasiterdekat=$hasilruteterpendek[$keyterbaik];
			$hasilkoordinat=$this->gambar($ruteevakuasiterdekat);
			session_start(); 
			$_SESSION['array'] = $hasilkoordinat;
			$_SESSION['lat']=$latawal;
			$_SESSION['lng']=$lngawal;
			$_SESSION['bobot']=$ruteevakuasiterdekat['Bobot'];
			$_SESSION['idevk']=$keyterbaik;
			// unset($hasilruteterpendek[$keyterbaik]);

			$_SESSION['Ruteevk']=$hasilruteterpendek;
			
			// echo "<pre>"; print_r($hasilruteterpendek);
			header('location:../../lihatrutecustom.php?berhasil=1');
		}
		else
		{
			session_start(); 
			$_SESSION['lokevk'] = $lokasievakuasi;
			$_SESSION['lat']=$latawal;
			$_SESSION['lng']=$lngawal;
			header('location:../../lihatrutecustom.php?error=1');
		}

	}


	function gambar($ruteterpendek)
	{	
		$koordinatfix=array();
		foreach ($ruteterpendek['Ruteterpendek'] as $key => $value) 
		{
			if($key<count($ruteterpendek['Ruteterpendek']))
			{
				$index1=$ruteterpendek['Ruteterpendek'][$key];
				$index2=$ruteterpendek['Ruteterpendek'][$key+1];
				$query=mysqli_query($this->koneksi2,"SELECT *from graphsementara where simpul_awal='$index1' and simpul_tujuan='$index2'");
				while ($rows=mysqli_fetch_array($query))
				{
					$koordinat=$rows['koordinat'];
					$koordinatfix[$index1][$index2]=$koordinat;
				}
			}
			else
			{
				break;
			}
					
		}

		return 	$koordinatfix;
	}


}

if(isset($_GET['latawal']) and isset($_GET['lngawal']))
{
	//lokasi awal
	$latawal=$_GET['latawal'];
	$lngawal=$_GET['lngawal'];
	$obj=new panggiljp;
	$obj->main($latawal,$lngawal);
}


?>