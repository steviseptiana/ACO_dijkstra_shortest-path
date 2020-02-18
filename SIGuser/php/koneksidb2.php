<?php
class koneksidb2
{
	public function konek2()
	{
		return $koneksi = mysqli_connect('', '', '', '');
	}
}

?>