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

		//explode masih gak ngerti
		function explodearray($delimiters, $array,$kv = '=>')
	  	{
	    	$a=true;
	    	$b=0;
	    	$c=0;
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
			        			$ka['lat'][$b++] = trim($s);
			        			$a=false;
			        		}
			        		else
			        		{
			        			$ka['lng'][$c++] = trim($s);
			        			$a=true;
			        		}
			          		
			          	}
			     	}
			    }
			    return $ka;
			}
	  	}

		function linemarkertampil()
		{

			$koor=array();

			$query=mysqli_query($this->koneksidb,"SELECT *FROM blokir_simpul") or die(mysqli_error($this->koneksidb));
			while ($rows=mysqli_fetch_array($query))
			{
				$koordinat=$rows['koordinat'];
				$simpul_awal=$rows['simpul_awal'];
				$simpul_tujuan=$rows['simpul_tujuan'];
				$koor[$simpul_awal][$simpul_tujuan]=$koordinat;
			}


			ksort($koor);

			// Menghapus graph double misal 1-0, 0-1. jadi tinggal 1-0
			foreach ($koor as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $value) 
				{
					if(array_key_exists($key2,$koor) and array_key_exists($key1,$koor[$key2]))
						unset($koor[$key1][$key2]);
				}


				if(empty($koor[$key1]))
					unset($koor[$key1]);

			}
			
			//proses memisahkan [,] . lalu di masukan menjadi data array
			foreach ($koor as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $value) 
				{
					$explode=$this->explodearray(array('[', ',', ']'),$koor[$key1][$key2]);
					$hasilkoor[$key1][$key2]=$explode;
				}
			}

			// echo '<pre>'; print_r($koor);
			echo json_encode($hasilkoor);
		}

	}

	$tes=new maps;
	$tes->linemarkertampil();
?>