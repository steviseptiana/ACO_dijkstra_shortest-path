<?php
	ini_set('max_execution_time', 0);
	require_once("dijztra.php");
	// require_once('../koneksidb2.php');
	
	class jalurterpendekacs
	{
		//graph
		private $graph;

		//parameter
		private $jumlahsemut;
		private $beta;
		private $qo;
		private $gamma;
		private $rho;
		private $alpha;
		private $iterasi;

		//inversjarak dan pheromone
		private $inversjarak;
		private $pheromone;

		//titik awal dan tujuan
		private $titikawal;
		private $titiktujuan;

		//tabulist
		private $tabulist=array();


		function random($min, $max, $desimal = '0')
		{
		    $desimal = +('1'.$desimal);
		    $min = floor($min*$desimal);
		    $max = floor($max*$desimal);
		    $rand = mt_rand($min, $max) / $desimal;
		    return $rand;
		}

		// function parameter()
		// {
		// 	$this->jumlahsemut=500;//5000
		// 	$this->beta=2;
		// 	$this->qo=0.5;
		// 	$this->gamma=0.1;
		// 	$this->rho=0.001; //0-1, 1-100%, 0,5 brarti 50% penguapan
		// 	$this->alpha=0.1;
		// 	$this->iterasi=200;
		// }

		function transisistatus($titik)
		{
			 //panjang array ttik terhubung
			$q=$this->random(0,1,'00'); //random q
			$pembanding1=-999999999999999;
			$pembanding2=9999999999999999;
			
			$titikterpilih=-1; //sebagai parameter saja, kalau titiknya tidak terhubung k manapun
			
			//pemilihan persamaan transisi status dan update pheromone lokal
			if ($q<=$this->qo)
			{

				foreach ($this->graph[$titik] as $key => $value) 
				{
					$transisistatus1=$this->pheromone[$titik][$key]*pow($this->inversjarak[$titik][$key],$this->beta);
				
					if(round($pembanding1,1000)<round($transisistatus1,1000) and round($pembanding1,1000)!=0 and !(in_array($key, $this->tabulist)) and !(in_array($key, $this->jalanbuntu))) //pembanding lebih kecil dari hasil transisi status dan titik nya tidak ada dalam tabu list
					{
						$pembanding1=$transisistatus1;
						$titikterpilih=$key;
					}
					
				}

				//$titikterpilih=array_search(max($simpannilaits1),$simpannilaits1);
			}
			else
			{
				
				$transisistatuspembagi=array();
				$sigmatransisistatus=0;

				$randommaxmin=array('Max','Min');
				$random=array_rand($randommaxmin,1);

				foreach ($this->graph[$titik] as $key => $value) 
				{
					$sigmatransisistatus+=$this->pheromone[$titik][$key]*pow($this->inversjarak[$titik][$key],$this->beta);
					$transisistatuspembagi[$key]=$this->pheromone[$titik][$key]*pow($this->inversjarak[$titik][$key],$this->beta);
					
				}


				if (round($sigmatransisistatus,1000)<=0)
				{
					$titikterpilih=-1;
					
				// 	//sebenarnya jumlah pheromone tidak 0 tapi php tidak bisa handle 0 koma yang terlalu besar jadi nilai pheromonenya di baca 0 oleh php
				}
				else
				{
					//echo "hai<br>";
					foreach ($this->graph[$titik] as $key => $value) 
					{
						$transisistatus2=round($transisistatuspembagi[$key],1000)/round($sigmatransisistatus,1000);
						if ($random==0) //mengambil nilai max
						{
							if(round($pembanding1,1000)<round($transisistatus2,1000) and !(in_array($key, $this->tabulist)) and !(in_array($key, $this->jalanbuntu))) //pembanding lebih kecil dari hasil transisi status dan titik nya tidak ada dalam tabu list
							{
								$pembanding1=$transisistatus2;
								$titikterpilih=$key;
							}
						}
						else
						{
							if(round($pembanding2,1000)>round($transisistatus2,1000) and !(in_array($key, $this->tabulist)) and !(in_array($key, $this->jalanbuntu))) //pembanding lebih kecil dari hasil transisi status dan titik nya tidak ada dalam tabu list
							{
								$pembanding2=$transisistatus2;
								$titikterpilih=$key;
							}
						}
					}

				}
			}

			if ($titikterpilih<>-1)
			{
				$this->updatepheromonelokal($titik,$titikterpilih);
			}
			return $titikterpilih;
		}

		function updatepheromonelokal($titik1,$titik2)
		{
			//echo $titik1." ".$titik2;
			$pheromoneterhubung=array();
			foreach ($this->pheromone[$titik1] as $key => $value) 
			{
				$pheromoneterhubung[$key]=$value;
			}

			$maxpheromone=max($pheromoneterhubung); //max pheromone yg terhubung dengan titik awal
			
			if(array_key_exists($titik1,$this->graph))
			{
				if (array_key_exists($titik2, $this->graph[$titik1])) 
				{
					$this->pheromone[$titik1][$titik2]=((1-$this->rho)*$this->pheromone[$titik1][$titik2]) + ($this->rho*($this->gamma*$maxpheromone));
					//$this->pheromone[$titik1][$titik2]=((1-$this->rho)*$this->pheromone[$titik1][$titik2]) + ($this->rho*(1/(count($this->graph)*$this->graph[$titik1][$titik2])));
					//ganti rumus
					
				}
			}

			if(array_key_exists($titik2,$this->graph))
			{
				if (array_key_exists($titik1, $this->graph[$titik2])) 
				{
					$this->pheromone[$titik2][$titik1]=((1-$this->rho)*$this->pheromone[$titik2][$titik1]) + ($this->rho*($this->gamma*$maxpheromone));
					//$this->pheromone[$titik2][$titik1]=((1-$this->rho)*$this->pheromone[$titik2][$titik1]) + ($this->rho*(1/(count($this->graph)*$this->graph[$titik2][$titik1])));
				
				}
			}

		
		}

		function updatepheromoneglobal($array)
		{
			//jalurterbaik
			if(!empty($array))
			{
				foreach ($array['Perjalanan'] as $key => $arr) 
				{
					if( $key<count($array['Perjalanan'])-1)
					{
						$a=$array['Perjalanan'][$key];
						$b=$array['Perjalanan'][$key+1];

						if (array_key_exists($b, $this->pheromone[$a])) 
						{
							$this->pheromone[$a][$b]=((1-$this->alpha)*$this->pheromone[$a][$b])+($this->alpha*(1/$array['Jarak']));
						}
						if (array_key_exists($a, $this->pheromone[$b])) 
						{
							$this->pheromone[$b][$a]=((1-$this->alpha)*$this->pheromone[$b][$a])+($this->alpha*(1/$array['Jarak']));
						}

						$cek1[$a]=$b;
						$cek2[$b]=$a;
					}
				}

				//bukan jalur terbaik
				//$alpha=$this->alpha;
				foreach ($this->pheromone as $key1 => $arr) 
				{
					foreach ($arr as $key2 => $value) 
					{
						if (array_key_exists($key1, $cek1) and $cek1[$key1]==$key2) 
						{
							continue;
						}
						else if (array_key_exists($key1, $cek2) and $cek2[$key1]==$key2) 
						{
							continue;
						}
						else
						{
							$this->pheromone[$key1][$key2]=((1-$this->alpha)*$this->pheromone[$key1][$key2])+($this->alpha*0);
						}
					}
				}
			}
			else
			{
				//bukan jalur terbaik
				//$alpha=$this->alpha;
				foreach ($this->pheromone as $key1 => $arr) 
				{
					foreach ($arr as $key2 => $value) 
					{
						$this->pheromone[$key1][$key2]=((1-$this->alpha)*$this->pheromone[$key1][$key2])+($this->alpha*0);
					}
				}
			}
			
		}

		private $jalanbuntu=array();
		function jp($titikawal,$titiktujuan)
		{
			
			$perjalanansemut=array();
			$semutterbaik=array();

			//echo "<pre>"; print_r($this->pheromone);
			//melakukan transisistatus dan pembaruan pheromone
			for ($i=1; $i <=$this->jumlahsemut ; $i++) 
			{ 

				$this->tabulist=array();
				array_push($this->tabulist, $titikawal);
				$titikpencarian=$this->titikawal;
				for ($j=0; $j <1; $j++) 
				{ 
					$pilihtitik=$this->transisistatus($titikpencarian);
					$titikpencarian=$pilihtitik;

					if($pilihtitik==-1) //jika titik terpilih adalah -1 (sbg parameter saja) mksudnya jika titik trsebut tdak trhubung kmanapun atau sdah tidak ada titik yg bisa dipilih(masuk dalam tabulist smua)
					{
						break;
					}

					if(!array_key_exists($pilihtitik,$this->graph)) //jika titik terpilih tidak ada dalam graph (biasanya jalan searah yang tidak terhubung dengan titik manapun, biasanya simpul buntu atau simpul ujung)
					{
						array_push($this->tabulist, $pilihtitik);
						break;
					}

					if ($pilihtitik==$this->titiktujuan)
					{
						array_push($this->tabulist, $pilihtitik);
						break;
					}
					else
					{
						--$j; 
					}

					array_push($this->tabulist, $pilihtitik);

				}

				$perjalanansemut[$i]=array('Semut'=>$i,'Perjalanan'=>$this->tabulist);

				if(!in_array($this->titiktujuan,$perjalanansemut[$i]['Perjalanan']))
				{
					$last=count($perjalanansemut[$i]['Perjalanan'])-1;
					//echo $perjalanansemut['Perjalanan'][$last]."<br>";
					if($perjalanansemut[$i]['Perjalanan'][$last]!=$titikawal and $perjalanansemut[$i]['Perjalanan'][$last]!=$titiktujuan)
						array_push($this->jalanbuntu, $perjalanansemut[$i]['Perjalanan'][$last]);
				}

			}
			
			//menghitung jarak masing2 perjalanan semut
			
			foreach ($perjalanansemut as $key => $value) 
			{
				
					$jarak=0;
					foreach ($perjalanansemut[$key]['Perjalanan'] as $keyx => $value) 
					{
						if($keyx<(count($perjalanansemut[$key]['Perjalanan'])-1)) //jika indexnya kurang dari count perjalanan semut
						{
							$index=$perjalanansemut[$key]['Perjalanan'][$keyx+1];
							$jarak+=$this->graph[$value][$index];
						}

					}
					$perjalanansemut[$key]['Jarak']=$jarak;
					//echo "<pre>"; print_r($perjalanansemut[$key]);
				
			}	

			// echo "<pre>"; print_r($perjalanansemut);	

			$jarakminimal=9999999999999;
			$keyminimal;
			$param=false;

			for ($i=1; $i <=$this->jumlahsemut ; $i++) 
			{ 
				if(in_array($this->titiktujuan,$perjalanansemut[$i]['Perjalanan']))
				{
					foreach ($perjalanansemut[$i] as $key => $value) 
					{
						$jarak=$perjalanansemut[$i]['Jarak'];
						if($jarakminimal>$jarak)
						{
							$jarakminimal=$jarak;
							$keyminimal=$i;
						}
					}
					$param=true;
				}
			}	

			if($param==true)
			{
				$semutterbaik=$perjalanansemut[$keyminimal];
				$this->updatepheromoneglobal($semutterbaik);
			}
			else
			{
				$tsemutterbaik=array();
				$this->updatepheromoneglobal($tsemutterbaik);
				$semutterbaik='Tidak menemukan tujuan';
				// echo "<pre>"; print_r($perjalanansemut);
			}

			// echo "<pre>"; print_r($perjalanansemut);
			return $semutterbaik;
		}

		function main($titikawal,$titiktujuan,$inversjarak,$pheromoneawal,$graph)
		{
			$mulai = microtime(true);
			$this->graph=$graph;
			$this->titikawal=$titikawal;
			$this->titiktujuan=$titiktujuan;
			$this->inversjarak=$inversjarak;
			$this->pheromone=$pheromoneawal;
			$this->jalanbuntu=array();
			$hasiliterasi=array();
		
			// $this->jumlahsemut=5;
			// $this->beta=1;
			// $this->qo=0.99;
			// $this->gamma=0.1;
			// $this->rho=0.1; //0-1, 1-100%, 0,5 brarti 50% penguapan
			// $this->alpha=0.1;
			// $this->iterasi=5;
			$this->jumlahsemut=5;
			$this->beta=1;
			$this->qo=0.99;
			$this->gamma=0.1;
			$this->rho=0.1; //0-1, 1-100%, 0,5 brarti 50% penguapan
			$this->alpha=0.1;
			$this->iterasi=5;

			$iterasiterbaik=array();

			for ($i=1; $i <=$this->iterasi ; $i++) 
			{ 
				$hasiliterasi[$i]=$this->jp($this->titikawal,$this->titiktujuan);
			}
			
			$pembanding=999999999999;
			$param=false;
			foreach ($hasiliterasi as $key => $value) 
			{
				if ($hasiliterasi[$key]=='Tidak menemukan tujuan')
					continue;
				else
				{
					if(round($pembanding,1000)>round($hasiliterasi[$key]['Jarak'],1000))
					{
						$pembanding=$hasiliterasi[$key]['Jarak'];
						$keyminimal=$key;
					}

					$param=true;
				}
			}

			if($param==true)
			{
				$iterasiterbaik[$keyminimal]=$hasiliterasi[$keyminimal];
			}
			else
			{
				$iterasiterbaik='Tidak menemukan titik tujuan yang dicari';
			}

			$i=1;
			$ruteterpendek=array();
			// echo "JARAK TERBAIK";
			// echo "<pre>"; print_r($iterasiterbaik);
			if($iterasiterbaik<>'Tidak menemukan titik tujuan yang dicari')
			{
				foreach ($iterasiterbaik as $key1 => $value) 
				{
					foreach ($iterasiterbaik[$key1]['Perjalanan'] as $key => $value) 
					{
						$ruteterpendek['Ruteterpendek'][$i++]=$value;
					}
					
				}

				$ruteterpendek['Bobot']=$iterasiterbaik[$key1]['Jarak'];

				$akhir = microtime(true);
				$waktu = $akhir - $mulai;
				// $ruteterpendek['Waktu']=$waktu;
				$ruteterpendek['Ket']="Hasil terbaik iterasi ke ".$keyminimal." dan semut ke ".$iterasiterbaik[$key1]['Semut']." dengan parameter : "."Jumlah semut = ".$this->jumlahsemut.", iterasi = ".$this->iterasi.", beta = ".$this->beta.", qo = ".$this->qo.", rho = ".$this->rho.", gamma = ".$this->gamma.", alpha = ".$this->alpha;
				$ruteterpendek['Waktu']=$waktu;
			}
			else
			{
				$ruteterpendek='Tidak menemukan titik tujuan yang dicari';
			}

			return $ruteterpendek;
			
		}
			
	}
	

class inisialisasi
{
	private $koneksi2;

	function __construct()
	{
		$kon2=new koneksi;
		$this->koneksi2=$kon2->konekkoordinat();	
	}

	function inversjarak($graph)
	{
		$inversjarak=array();
		foreach ($graph as $key1 => $arr) 
		{
			foreach ($arr as $key2 => $value) 
			{
				$inversjarak[$key1][$key2]=1/$value;
			}
		}
		return $inversjarak;
		
	}

	function dj($titikawal,$titiktujuan,$graph)
	{
		$jumlahtitik=count($graph);
		$d=new xdijkstra;
		$Hasil=$d->main($titikawal,$titiktujuan,$graph);

		return $Hasil;
	}

	function pheromoneawal($Hasil,$graph)
	{
		$pheromoneawal=array();
		
		foreach ($graph as $key1 => $arr) 
		{
			foreach ($arr as $key2 => $value) 
			{
				$pheromoneawal[$key1][$key2]=0.0001;
			}
		}

		foreach ($Hasil['Ruteterpendek'] as $key => $value) 
		{
			if($key<count($Hasil['Ruteterpendek']))
			{
				$pheromoneawal[$value][$Hasil['Ruteterpendek'][$key+1]]=0.1;
			}
		}

		return $pheromoneawal;	
	}

	public $fixgraph=array();
	function graphjarak()
	{		
		$blokgraph=$this->blokjalan();

		$query=mysqli_query($this->koneksi2,"SELECT *from graphsementara");
		$array=array();
		while ($rows=mysqli_fetch_array($query))
		{
			$simpul_awal=$rows['simpul_awal'];
			$simpul_tujuan=$rows['simpul_tujuan'];
			$jarak=$rows['bobot_jarak'];

			if(array_key_exists($simpul_awal,$blokgraph) and array_key_exists($simpul_tujuan,$blokgraph[$simpul_awal]))
			{
				continue;
			}
			else
			{
				$array[$simpul_awal][$simpul_tujuan]=$jarak;
			}
			
		}

		return $array;
	}

	function blokjalan()
	{
		$array=array();
		$query=mysqli_query($this->koneksi2,"SELECT *from blokir_simpul");
		while ($rows=mysqli_fetch_array($query))
		{
			$simpul_awal=$rows['simpul_awal'];
			$simpul_tujuan=$rows['simpul_tujuan'];
			$array[$simpul_awal][$simpul_tujuan]=0;
		}

		return $array;
	}



	// $lat1,$lng1,$lat2,$lng2
	function main($titikawal,$titiktujuan)
	{
		$graph=$this->graphjarak();
		$dj=$this->dj($titikawal,$titiktujuan,$graph);
		
		if($dj=='Tidak menemukan titik tujuan yang dicari')
		{
			return $dj;
		}
		else
		{
			$phe=$this->pheromoneawal($dj,$graph);
			$inv=$this->inversjarak($graph);
			$objjalurterpendekacs= new jalurterpendekacs;
			$jp=$objjalurterpendekacs->main($titikawal,$titiktujuan,$inv,$phe,$graph);
		}
		
		return $jp;
	}
}


?>

