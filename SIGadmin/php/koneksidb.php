<?php
class koneksidb
{
	public function konek()
	{
		return $koneksi = mysqli_connect('', '', '', '');
	}
}

?>