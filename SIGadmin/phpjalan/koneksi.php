<?php
	class koneksi
	{
		function konek()
		{
			return $koneksi = mysqli_connect('', '', '', '');
		}
	}

?>