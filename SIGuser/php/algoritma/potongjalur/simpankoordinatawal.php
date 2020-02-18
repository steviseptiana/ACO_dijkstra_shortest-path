<?php
ini_set('max_execution_time', 0); 
ini_set('memory_limit', '2000M');   
require_once("koneksi.php");

class simpankoordinatawal
{
	public $koneksi;

	function __construct()
	{
		$kon = new koneksi();
		$this->koneksi = $kon->konekkoordinat();
	}

	function multiexplode ($delimiters,$string) 
	{   
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}

	function simpan()
	{
		$array=array();
		$query=mysqli_query($this->koneksi, "SELECT *from graph");

		while ($rows=mysqli_fetch_array($query)) 
		{
			$simpulawal=$rows['simpul_awal'];
			$koordinatawal=$rows['koordinat'];
			$array[$simpulawal]=$koordinatawal;
		}

		//echo'<pre>'; print_r($array);
		foreach ($array as $key => $value) 
		{
			$pisah = $this->explodeX(array('[', ']', ',' ), $value);
			$kordawal[$key][0]=$pisah[1];
			$kordawal[$key][1]=$pisah[2];
		}

		//echo'<pre>'; print_r($pisah);
		//echo'<pre>'; print_r($kordawal);
		//
		foreach ($kordawal as $key1 => $arr) 
		{
			$lat=$kordawal[$key1][0];
			$lng=$kordawal[$key1][1];
			$query2=mysqli_query($this->koneksi,"INSERT into koordinatawal (simpul,lat, lng) values('$key1','$lat','$lng')");
		}
		
	}

	function explodeX( $delimiters, $string )
	{
	    return explode( chr( 1 ), str_replace( $delimiters, chr( 1 ), $string ) );
	}
}

$tes= new simpankoordinatawal;
$tes->simpan();


?>