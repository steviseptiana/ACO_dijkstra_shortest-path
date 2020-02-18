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

			$query=mysqli_query($this->koneksidb,"SELECT *FROM graph3") or die(mysqli_error($this->koneksidb));
			while ($rows=mysqli_fetch_array($query))
			{
				$koordinat=$rows['koordinat'];
				$simpul_awal=$rows['simpul_awal'];
				$simpul_tujuan=$rows['simpul_tujuan'];
				$koor[$simpul_awal][$simpul_tujuan]=$koordinat;
			}

			ksort($koor);

			
			//echo '<pre>'; print_r(array_unique($koor, SORT_REGULAR));

			//echo '<pre>'; print_r($koor);

			//koor itu graph
			//
			//Menghapus graph double misal 1-0, 0-1. jadi tinggal 1-0
			$a=0;

			foreach ($koor as $key1 => $arr) 
			{
				$b=array();

				//masukan key 2 atau node awal yg terhubung dengan beberapa node
				foreach ($arr as $key2 => $value) 
				{
					array_push($b, $key2);
				}

				//cek apakah node2 yg terhubung sama dengan a=0 dan nilai a di ganti terus menerus sesuai key
				foreach ($b as $key => $value) 
				{
					if($a==$value)
					{
						unset($koor[$key1][$value]);
					}
				}

				$a=$key1;
				
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

			//echo '<pre>'; print_r($hasilkoor);
			echo json_encode($hasilkoor);
		}


		function coba()
		{
			$array=array(0 => array(1=>13), 1=> array(0=>13,2=>4,5=>90,10=>12), 2=> array(1=>4,3=>23),3=> array(2=>23),10=> array(1=>12,4=>13,9=>56));
			foreach ($array as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $value) 
				{
					foreach ($array as $key => $value) 
					{
						
					}
				}
			}
			echo '<pre>'; print_r($array);
		}


	}

	$tes=new maps;
	$tes->linemarkertampil();
?>