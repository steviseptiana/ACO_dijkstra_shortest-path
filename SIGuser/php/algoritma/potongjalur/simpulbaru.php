<?php
	require_once("koneksi.php");
	require_once("titikpermeter.php"); 

	class simpulbaru
	{
		public $koneksi;
		//private $titikpermeter;

		function __construct()
		{
			$kon = new koneksi();
			$this->koneksi = $kon->konekkoordinat();
		}

		//explode karakter dengan lebih dari satu batasan
	    function explodemulti($pembatas, $string)
		{
		    return explode( chr( 1 ), str_replace( $pembatas, chr( 1 ), $string ) );
		}


		function jarak($lat1, $lon1, $lat2, $lon2) 
		{  
		    $radius = 6378.137;  

		    $delta_Rad_Lat = deg2rad($lat2 - $lat1);  
		    $delta_Rad_Lon = deg2rad($lon2 - $lon1);  
		    $rad_Lat1 = deg2rad($lat1);  
		    $rad_Lat2 = deg2rad($lat2);  

		    $sq_Half_Chord = sin($delta_Rad_Lat / 2) * sin($delta_Rad_Lat / 2) + cos($rad_Lat1) * cos($rad_Lat2) * sin($delta_Rad_Lon / 2) * sin($delta_Rad_Lon / 2);  
		    $ang_Dist_Rad = 2 * asin(sqrt($sq_Half_Chord));  
		    $distance = $radius * $ang_Dist_Rad;  

		    return $distance*1000;  
		} //https://stackoverflow.com/questions/8696755/php-returning-nan

		//mencari titik awal terdekat dari database
		function pointerdekat($lat,$lng)
		{
			$hasil=array();
			$query=mysqli_query($this->koneksi,"SELECT id, simpul, (3959 * acos (cos ( radians('$lat') )* cos( radians( lat ) )* cos( radians( lng ) - radians('$lng') )+ sin ( radians('$lat') ) * sin( radians( lat ) ))) AS distance FROM koordinatawalsementara HAVING distance < 6000000000000 ORDER BY distance LIMIT 0 , 20");
			
			while ($rows=mysqli_fetch_array($query)) 
			{
				//$id=$rows['id'];
				$simpul=$rows['simpul'];
				array_push($hasil,$simpul);
			}

			
			//10 titik terdekat dari koordinatx
			return $hasil;
		}

		function koordinat($titik)
		{
			//echo '<pre>'; print_r($titik);
			$param=true;
			$titikkord=array();
			$titikkoordinat=array();
			


			//mengambil koordinat tiap poin terhubung pada 10 titik tedekat
			foreach ($titik as $key => $value) 
			{
				$query=mysqli_query($this->koneksi,"SELECT * FROM graphsementara where simpul_awal='$value'");
				
				while ($rows=mysqli_fetch_array($query)) 
				{
					//mengubah string koordinat menjadi array
					$i=0;
					$koord=$this->explodemulti(array('[', ']', ',' ),$rows['koordinat']);
					//echo '<pre>'; print_r($koord);
					
					foreach ($koord as $key => $value) 
					{
						if(empty($koord[$key]))
						{
							unset($koord[$key]);
						}
						else
						{
							if($param==true)
							{
								$titikkord[$i][0]=$value;
								$param=false;
							}
							else
							{
								$titikkord[$i][1]=$value;
								$param=true;
								$i++;
							}

						}
						
					}

					$titikkoordinat[$rows['simpul_awal']][$rows['simpul_tujuan']]=$titikkord;
					$titikkord=array();
				}
			}

		
			return $titikkoordinat;
		}

		function buattitikpermeter($array)
		{
			$titikpm=new titikkoordinat;

			foreach ($array as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $arrr) 
				{
					foreach ($arrr as $key3 => $value) 
					{
						//echo count($arrr);
						$x=$array[$key1][$key2][$key3][0].",".$array[$key1][$key2][$key3][1].",".$array[$key1][$key2][$key3+1][0].",".$array[$key1][$key2][$key3+1][1];
						$titikpermeter[$key1][$key2][$x]=$titikpm->titikm($array[$key1][$key2][$key3][0],$array[$key1][$key2][$key3][1],$array[$key1][$key2][$key3+1][0],$array[$key1][$key2][$key3+1][1]);
						if ($key3==(count($arrr)-2))
						{
							break;
						}
					}
				}
			}

			//echo '<pre>'; print_r($titikpermeter);
			return $titikpermeter;
			
		}




		function cektitikterdekatdariverteks($lat,$lng,$array)
		{
			//echo '<pre>'; print_r($array);
			//
			$jaraktertinggi=9999999999;
			$txt1="";

			//membandingkan jarak koordinatx dengan semua koordinat lalu mengambil satu kordinat tunggal sebagai hasil terdekat
			foreach ($array as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $arrr) 
				{
					foreach ($arrr as $key3 => $arrrr) 
					{
						foreach ($arrrr as $key4 => $value) 
						{
							$jarak=$this->jarak($lat,$lng,$array[$key1][$key2][$key3][$key4][0],$array[$key1][$key2][$key3][$key4][1]);
							if ($jarak<$jaraktertinggi)
							{
								$jaraktertinggi=$jarak;
								$a=$key1;
								$b=$key2;
								$c=$key3;
								$d=$array[$key1][$key2][$key3][$key4]; //titik baru
							}

							// $txt="[".$array[$key1][$key2][$key3][$key4][0].",".$array[$key1][$key2][$key3][$key4][1]."]";
							// $txt1=$txt1.",".$txt;
						}
					}
				}
			}

			$koordinattxt=$this->explodemulti(array(","),$c);
			$koordinatt=array();
			$i=0;
			$param=true;

			//menyatukan koordinat  $koordinattxt dan koordinat baru $d dalam satu array
			foreach ($koordinattxt as $key => $value) 
			{
				if($param==true)
				{
					$koordinatt[$i][0]=$value;
					$param=false;
				}
				else
				{
					$koordinatt[$i][1]=$value;
					$param=true;
					$i++;

					// if(!next($koordinattxt))
					// {
					// 	$koordinatt[$i][0]=$d[0];
					// 	$koordinatt[$i][1]=$d[1];
					// }
					$koordinatt[2][0]=$d[0];
					$koordinatt[2][1]=$d[1];
				
				}

				
			}


			$pointerdekat=array();
			$query=mysqli_query($this->koneksi,"SELECT * FROM graphsementara where simpul_awal='$a' and simpul_tujuan='$b'");	
			while ($rows=mysqli_fetch_array($query)) 
			{
				$i=0;
				$koord=$this->explodemulti(array('[', ']', ',' ),$rows['koordinat']);
					
				foreach ($koord as $key => $value) 
				{
					if(empty($koord[$key]))
					{
						unset($koord[$key]);
					}
					else
					{
						if($param==true)
						{
							$titikkord[$i][0]=$value;
							$param=false;
						}
						else
						{
							$titikkord[$i][1]=$value;
							$param=true;
							$i++;
						}
					}
			
				}

				$koordinatt[3][$rows['simpul_awal']][$rows['simpul_tujuan']]=$titikkord;
			}

		
			return $koordinatt;
			//index 0 dan 1 merupakan pengapit
			//index 2 titik baru
			//index 3 simpul terpilih 

		}

		function potongjalur($titikterdekatverteks,$simpulbaru)
		{
			// echo '<pre>'; print_r($titikterdekatverteks);
			// echo '<pre>'; print_r($koordinatterdekat);
			
			$koordinatterdekat=$titikterdekatverteks[3];
			unset($titikterdekatverteks[3]);

			$koordawal_tengah=array();
			$koordtengah_awal=array();

			// $query=mysqli_query($this->koneksi,"SELECT max(simpul_awal) as simpul_awal from polyline_gis2");
			// $row=mysqli_fetch_array($query);
			// $simpulbaru=$row['simpul_awal']+1;

			$fix['simpulbaru']=$simpulbaru;

			//memotong simpul dari awal sampai tengah kemudian tengah sampai akhir
			$param=true;
			$i=0;
			foreach ($koordinatterdekat as $key1 => $arr) 
			{
				$fix['simpul1']=$key1;
				//penggunaannya saat query penyimpanan simpul baru
				$simpul_awal=$key1;
				foreach ($arr as $key2 => $arrr) 
				{
					$fix['simpul2']=$key2;
					//penggunaannya saat query penyimpanan simpul baru
					$simpul_tujuan=$key2;
					foreach ($arrr as $key3 => $arrrr) 
					{
						//$koordawal_tengah
						if($param==true)
						{
							$koordawal_tengah[$key1][$simpulbaru][$i]=$arrrr;

							if($arrrr==$titikterdekatverteks[0])
							{
								$koordawal_tengah[$key1][$simpulbaru][$i]=$arrrr;
								$koordawal_tengah[$key1][$simpulbaru][$i+1]=$titikterdekatverteks[2];

								$i=0;
								$koordtengah_akhir[$simpulbaru][$key2][$i]=$titikterdekatverteks[2];
								$param=false;
							}

							$i++;
						}
						//$koordtengah_akhir
						else
						{
							$koordtengah_akhir[$simpulbaru][$key2][$i++]=$arrrr;
						}
						
						
					}
				}
			}

			$bobotjarak=0;
			$txt="";
			$tx="";
			$txt1="";
			$tx1="";

			foreach ($koordawal_tengah as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $arrr) 
				{
					foreach ($arrr as $key3 => $value) 
					{
						$bobotjarak+=$this->jarak($value[0],$value[1],$koordawal_tengah[$key1][$key2][$key3+1][0],$koordawal_tengah[$key1][$key2][$key3+1][1]);
						
						if ($key3==(count($arrr)-2))
						{
							$tx="[".$value[0].",".$value[1]."]";
							$txt=$txt.$tx.",";
							$tx="[".$koordawal_tengah[$key1][$key2][$key3+1][0].",".$koordawal_tengah[$key1][$key2][$key3+1][1]."]";
							$txt=$txt.$tx;
							break;
						}
						else
						{
							$tx="[".$value[0].",".$value[1]."]";
							$txt=$txt.$tx.",";
						}

					}

					//membalik simpul
					//balik koordinat gunakan array reserve
					foreach (array_reverse($arrr) as $key4 => $value) 
					{
						$tx1="[".$value[0].",".$value[1]."]";
						if(!next($arrr))
						{
							$txt1=$txt1.$tx1;
						}
						else
						{
							$txt1=$txt1.$tx1.",";
						}
					}
				}

				$koordawal_tengah['jarak']=$bobotjarak;
				
				///simpan dalam array fix;
				$fix['simpul']['koordawal_tengah']=array('simpul_awal'=>$key1,'simpul_tujuan'=>$key2, 'jalur'=>$key1.'-'.$key2,'koordinat'=>$txt,'bobot_jarak'=>$bobotjarak);
				$fix['simpul']['koordtengah_awal']=array('simpul_awal'=>$key2,'simpul_tujuan'=>$key1, 'jalur'=>$key2.'-'.$key1,'koordinat'=>$txt1,'bobot_jarak'=>$bobotjarak);
				$fix['graph'][$key1][$key2]=$bobotjarak;
				$fix['graph'][$key2][$key1]=$bobotjarak;
			}

			$bobotjarak=0;
			$txt="";
			$tx="";
			$txt1="";
			$tx1="";

			
			foreach ($koordtengah_akhir as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $arrr) 
				{
					foreach ($arrr as $key3 => $value) 
					{
						$bobotjarak+=$this->jarak($value[0],$value[1],$koordtengah_akhir[$key1][$key2][$key3+1][0],$koordtengah_akhir[$key1][$key2][$key3+1][1]);
						
						if ($key3==(count($arrr)-2))
						{
							$tx="[".$value[0].",".$value[1]."]";
							$txt=$txt.$tx.",";
							$tx="[".$koordtengah_akhir[$key1][$key2][$key3+1][0].",".$koordtengah_akhir[$key1][$key2][$key3+1][1]."]";
							$txt=$txt.$tx;
							break;
						}
						else
						{
							$tx="[".$value[0].",".$value[1]."]";
							$txt=$txt.$tx.",";
						}

					}

					//membalik simpul
					//balik koordinat gunakan array reserve
					foreach (array_reverse($arrr) as $key4 => $value) 
					{
						$tx1="[".$value[0].",".$value[1]."]";
						if(!next($arrr))
						{
							$txt1=$txt1.$tx1;
						}
						else
						{
							$txt1=$txt1.$tx1.",";
						}
					}
				}

				$koordtengah_akhir['jarak']=$bobotjarak;
				
				///simpan dalam array fix;
				$fix['simpul']['koordtengah_akhir']=array('simpul_awal'=>$key1,'simpul_tujuan'=>$key2, 'jalur'=>$key1.'-'.$key2,'koordinat'=>$txt,'bobot_jarak'=>$bobotjarak);
				$fix['simpul']['koordakhir_tengah']=array('simpul_awal'=>$key2,'simpul_tujuan'=>$key1, 'jalur'=>$key2.'-'.$key1,'koordinat'=>$txt1,'bobot_jarak'=>$bobotjarak);
				$fix['graph'][$key1][$key2]=$bobotjarak;
				$fix['graph'][$key2][$key1]=$bobotjarak;
			}

			$fix['koordinatsimpulbaru']=array('lat'=>$titikterdekatverteks[2][0],'lng'=>$titikterdekatverteks[2][1]);


			return $fix;
		}


		function savedb($array)
		{
			
			$query1=mysqli_query($this->koneksi,"SELECT * from graphsementara WHERE simpul_awal=".$array['simpul1']." AND simpul_tujuan=".$array['simpul2']);
			$query2=mysqli_query($this->koneksi,"SELECT * from graphsementara WHERE simpul_awal=".$array['simpul2']." AND simpul_tujuan=".$array['simpul1']);
			if (mysqli_num_rows($query1)==1)
			{
				$querysimpan3=mysqli_query($this->koneksi,"INSERT INTO graphsementara (id,simpul_awal,simpul_tujuan,jalur,koordinat,bobot_jarak) VALUES('',".$array['simpul']['koordawal_tengah']['simpul_awal'].",".$array['simpul']['koordawal_tengah']['simpul_tujuan'].",'".$array['simpul']['koordawal_tengah']['jalur']."','".$array['simpul']['koordawal_tengah']['koordinat']."',".$array['simpul']['koordawal_tengah']['bobot_jarak'].")") or die(mysqli_error($this->koneksi));
				$querysimpan4=mysqli_query($this->koneksi,"INSERT INTO graphsementara (id,simpul_awal,simpul_tujuan,jalur,koordinat,bobot_jarak) VALUES('',".$array['simpul']['koordtengah_akhir']['simpul_awal'].",".$array['simpul']['koordtengah_akhir']['simpul_tujuan'].",'".$array['simpul']['koordtengah_akhir']['jalur']."','".$array['simpul']['koordtengah_akhir']['koordinat']."',".$array['simpul']['koordtengah_akhir']['bobot_jarak'].")") or die(mysqli_error($this->koneksi));
				$querydelete2=mysqli_query($this->koneksi,"DELETE from graphsementara WHERE simpul_awal=".$array['simpul1']." AND simpul_tujuan=".$array['simpul2']);
			
			}
			if (mysqli_num_rows($query2)==1)
			{
				$querysimpan3=mysqli_query($this->koneksi,"INSERT INTO graphsementara (id,simpul_awal,simpul_tujuan,jalur,koordinat,bobot_jarak) VALUES('',".$array['simpul']['koordakhir_tengah']['simpul_awal'].",".$array['simpul']['koordakhir_tengah']['simpul_tujuan'].",'".$array['simpul']['koordakhir_tengah']['jalur']."','".$array['simpul']['koordakhir_tengah']['koordinat']."',".$array['simpul']['koordakhir_tengah']['bobot_jarak'].")") or die(mysqli_error($this->koneksi));
				$querysimpan4=mysqli_query($this->koneksi,"INSERT INTO graphsementara (id,simpul_awal,simpul_tujuan,jalur,koordinat,bobot_jarak) VALUES('',".$array['simpul']['koordtengah_awal']['simpul_awal'].",".$array['simpul']['koordtengah_awal']['simpul_tujuan'].",'".$array['simpul']['koordtengah_awal']['jalur']."','".$array['simpul']['koordtengah_awal']['koordinat']."',".$array['simpul']['koordtengah_awal']['bobot_jarak'].")") or die(mysqli_error($this->koneksi));
				$querydelete2=mysqli_query($this->koneksi,"DELETE from graphsementara  WHERE simpul_awal=".$array['simpul2']." AND simpul_tujuan=".$array['simpul1']);
			
			}

			$query3=mysqli_query($this->koneksi,"INSERT INTO koordinatawalsementara (id,simpul,lat,lng) values ('', ".$array['simpulbaru'].",".$array['koordinatsimpulbaru']['lat'].",".$array['koordinatsimpulbaru']['lng'].")");
			
			return $array['simpulbaru'];
		}

		function main($lat,$lng,$simpulbaru)
		{
			$pointerdekat=$this->pointerdekat($lat,$lng); //mencari 10 poin terdekat dari koordinatx
			$koordinat=$this->koordinat($pointerdekat); //menyimpan koordinat antar point terdekat x dalam array
			$titikpermeter=$this->buattitikpermeter($koordinat); //membuat titik permeter dari satu jalur tunggal
			$titikterdekatverteks=$this->cektitikterdekatdariverteks($lat,$lng,$titikpermeter);
			$potongjalur=$this->potongjalur($titikterdekatverteks,$simpulbaru); //potongjalur
			
			$simpandtbase=$this->savedb($potongjalur);
			return $simpandtbase;
		}
	}

	// $obj=new simpulbaru;
	// $x=$obj->main(1.0554860574324576,120.79991840275795,3000);
	// echo '<pre>'; print_r($x);

?>