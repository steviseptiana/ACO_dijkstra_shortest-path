<?php
	class xdijkstra
	{

		private $graph=array();
		private $daftartitikbelumdikunjungi=array();
		private $daftartitiksudahdikunjungi=array();
		private $daftarbobot=array();

		function dijkstra($titik)
		{
			//echo "<pre>"; print_r($this->daftartitikbelumdikunjungi);
			$this->daftartitikbelumdikunjungi=array_diff($this->daftartitikbelumdikunjungi, array($titik));

			//$best=99999999;

			$param=true;
			$pembanding=array();
			foreach ($this->daftartitiksudahdikunjungi as $key1 => $value1) 
			{
				foreach ($this->graph[$value1] as $key => $value2) 
				{
					$bobot=$this->daftarbobot[$value1]['Bobot']+$value2;
					$pembanding[$value1][$key]=$bobot;
				}
			}

			//echo "<pre>"; print_r($pembanding);
			//echo $titik

			$titikpilih=-1;
			$best=99999999;
			foreach ($pembanding as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $value) 
				{
					if($best>$value and !in_array($key2,$this->daftartitiksudahdikunjungi) and !in_array($key2,$this->daftarbuntu)) //membandingkan nilai terkecil yang terubung dengan titik yang sudah dipilih teteapi tidak memilih titik yang sudah dikunjungi
					{
						$best=$value;
						$titik1=$key1;
						$titikpilih=$key2;
					}
				}	
			}
			
			if($titikpilih!=-1)
			{
				$this->daftarbobot[$titikpilih]['Bobot']=$best;
				
				$this->daftarbobot[$titikpilih]['Sumber']=$this->daftarbobot[$titik1]['Sumber'];
				$i=count($this->daftarbobot[$titikpilih]['Sumber'])-1;
				$this->daftarbobot[$titikpilih]['Sumber'][$i++]=$titik1;
				$this->daftarbobot[$titikpilih]['Sumber'][$i++]=$titikpilih;
				
			
				if(!array_key_exists($titikpilih, $this->graph))
				{
					array_push($this->daftarbuntu,$titikpilih);
				}
				else
				{
					array_push($this->daftartitiksudahdikunjungi,$titikpilih);

				}

				$titikterpilih=$titikpilih;
			}
			else
			{
				$titikterpilih=-1;
			}

			return $titikterpilih;
	
		}

		private $daftarbuntu=array();

		function main($titikawal,$titiktujuan,$graph)
		{
			$mulai = microtime(true);

			//graph
			$this->graph=$graph;
			$this->daftartitikbelumdikunjungi=array();
			$this->daftartitiksudahdikunjungi=array();
			$this->daftarbobot=array();
			$this->daftarbuntu=array();

			//menandai titik yang belum dikunjungi
			array_push($this->daftartitikbelumdikunjungi,$titikawal);
			foreach ($this->graph as $key => $value) 
			{
				if($key==$titikawal or $key==$titiktujuan)
					continue;
				else
					array_push($this->daftartitikbelumdikunjungi,$key);
			}

			foreach ($this->graph as $key1 => $arr) 
			{
				foreach ($arr as $key2 => $value) 
				{
					if(in_array($key2,$this->daftartitikbelumdikunjungi))
						continue;
					else
						array_push($this->daftartitikbelumdikunjungi,$key2);
				}
				
			}

			array_push($this->daftartitikbelumdikunjungi,$titiktujuan);
			
			$titikcari=$titikawal;
			array_push($this->daftartitiksudahdikunjungi,$titikcari);
			$this->daftarbobot[$titikcari]['Bobot']="0";
			$i=0;
			$this->daftarbobot[$titikcari]['Sumber'][$i++]=$titikcari;
			$this->daftarbobot[$titikcari]['Sumber'][$i++]=$titikcari;
			for ($i=0; $i < 1; $i++) 
			{ 
				$pemilihantitik=$this->dijkstra($titikcari);
				$titikcari=$pemilihantitik;

				if($pemilihantitik!=-1)
				{
					
					if($titikcari==$titiktujuan)
					{
						break;
					}
					else
					{
						--$i;
					}

				}
				else
				{
					break;
				}
				
			}

			// echo "<pre>"; print_r($this->daftarbobot);

			if($titikcari==$titiktujuan)
			{

				unset($this->daftarbobot[$titiktujuan]["Sumber"][0]);
				$ruteterpendek['Ruteterpendek']=$this->daftarbobot[$titiktujuan]["Sumber"];
				$ruteterpendek['Bobot']=$this->daftarbobot[$titiktujuan]["Bobot"];
				$akhir = microtime(true);
				$waktu = $akhir - $mulai;
				$ruteterpendek['Waktu']=$waktu;
				return $ruteterpendek;
			}
			else
			{
				$ruteterpendek='Tidak menemukan titik tujuan yang dicari';
				return $ruteterpendek;
			}
			
			
		}
	}


	// $obj=new dijkstra;
	// echo "<pre>"; print_r($obj->main(7,14));

?>