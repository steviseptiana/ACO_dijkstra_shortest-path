<?php
	require_once('koneksi.php');

	class Point 
	{
	    public $lat;
	    public $long;
	    function Point($lat, $long) 
	    {
	        $this->lat = $lat;
	        $this->long = $long;
	    }
	}

	class crudjalan
	{
		private $koneksi;

		function __construct()
		{
			$obj=new koneksi;
			$this->koneksi=$obj->konek();
		}

		function id()
		{
			$cek="SELECT * from blokir_simpul";
            $cek2=mysqli_query($this->koneksi,$cek);
            $cek3=mysqli_num_rows($cek2);
                                      
            if ($cek3>0)
            {                        
                $sqll="SELECT MAX(id) from blokir_simpul";
                $hasill = mysqli_query($this->koneksi,$sqll);
                $dataa = mysqli_fetch_array($hasill);
               	$maxid=$dataa[0];
                $maxid++;
                $no=$maxid++; 
            }
            else
            {
                $no='BLK_0000001';
            }

            return $no;
		}

		function simpanjalan($simpulawal,$simpultujuan)
		{
			$query1=mysqli_query($this->koneksi,"SELECT *from graph where simpul_awal='$simpulawal' and simpul_tujuan='$simpultujuan'");
			$query2=mysqli_query($this->koneksi,"SELECT *from graph where simpul_awal='$simpultujuan' and simpul_tujuan='$simpulawal'");

			
			if(mysqli_num_rows($query1)>0)
			{
				$no=$this->id();
				$rowsk=mysqli_fetch_array($query1);
				$koord=$rowsk['koordinat'];
				$querysimpan=mysqli_query($this->koneksi, "INSERT INTO blokir_simpul values ('$no','$simpulawal','$simpultujuan','$koord')");
			}

			if(mysqli_num_rows($query2)>0)
			{
				$no=$this->id();
				$rowsk=mysqli_fetch_array($query2);
				$koord=$rowsk['koordinat'];
				$querysimpan=mysqli_query($this->koneksi, "INSERT INTO blokir_simpul values ('$no','$simpultujuan','$simpulawal','$koord')");
			}

			header('location:../pemblokiranjalan.php?success=1');
		}

		function simpanjalancekpoli($str)
		{
			$koord=$this->explodearray(array('[', ',', ']'),$str);

			$query=mysqli_query($this->koneksi,"SELECT *from koordinatawal");

			$poligon=array();
			// $points_polygon = count($koord['lng']) - 1;
			foreach ($koord['lat'] as $key => $value) 
			{
				array_push($poligon,new Point($koord['lat'][$key],$koord['lng'][$key]));
			}

			$simpulpoli=array();
		
			while ($rows=mysqli_fetch_array($query)) 
			{
				$simpul=$rows['simpul'];
				$lat=$rows['lat'];
				$lng=$rows['lng'];

				$ll=$lat.','.$lng;
    			($this->pointInPolygon(new Point($lat,$lng), $poligon)) ? array_push($simpulpoli,$simpul) : '';

			}

			foreach ($simpulpoli as $key => $value) 
			{
				$query=mysqli_query($this->koneksi,"SELECT *from graph where simpul_awal='$value'");
				while ($rows=mysqli_fetch_array($query)) 
				{
					$no=$this->id();
					$simpula=$rows['simpul_awal'];
					$simpult=$rows['simpul_tujuan'];
					$koord=$rows['koordinat'];
					$querysimpan=mysqli_query($this->koneksi, "INSERT INTO blokir_simpul values ('$no','$simpula','$simpult','$koord')");
				}
			}

			header('location:../pemblokiranjalan.php?success=1');
		}

		function hapus($id)
		{
			$query=mysqli_query($this->koneksi,"DELETE from blokir_simpul where id='$id' ");
			header('location:../pemblokiranjalan.php?success=2');
		}

		function hapussemua()
		{
			$query=mysqli_query($this->koneksi,"DELETE from blokir_simpul");
			header('location:../pemblokiranjalan.php?success=3');
		}

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

		//the Point in Polygon function
		function pointInPolygon($p, $polygon) 
		{
		    //if you operates with (hundred)thousands of points
		    set_time_limit(60);
		    $c = 0;
		    $p1 = $polygon[0];
		    $n = count($polygon);

		    for ($i=1; $i<=$n; $i++) {
		        $p2 = $polygon[$i % $n];
		        if ($p->long > min($p1->long, $p2->long)
		            && $p->long <= max($p1->long, $p2->long)
		            && $p->lat <= max($p1->lat, $p2->lat)
		            && $p1->long != $p2->long) {
		                $xinters = ($p->long - $p1->long) * ($p2->lat - $p1->lat) / ($p2->long - $p1->long) + $p1->lat;
		                if ($p1->lat == $p2->lat || $p->lat <= $xinters) {
		                    $c++;
		                }
		        }
		        $p1 = $p2;
		    }
		    // if the number of edges we passed through is even, then it's not in the poly.
		    return $c%2!=0;
		}


	}

	$obj=new crudjalan;
	if(isset($_GET['simpan']) and !empty($_GET['simpan']))
	{
		if($_GET['simpan']==1)
		{
			$simpulawal=$_GET['simpul1'];
			$simpultujuan=$_GET['simpul2'];
			$obj->simpanjalan($simpulawal,$simpultujuan);
		}
		else
		{
			$str=$_GET['string'];
			$obj->simpanjalancekpoli($str);
		}
	}


	if(isset($_GET['id']) and !empty($_GET['id']))
	{
		$id=$_GET['id'];
		$obj->hapus($id);
	}

	if(isset($_GET['hapussemua']) and !empty($_GET['hapussemua']))
	{
		$obj->hapussemua($id);
	}
?>