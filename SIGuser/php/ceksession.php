<?php
session_start();
 
if (!isset($_SESSION['nama_p']) || empty($_SESSION['nama_p']) || !isset($_SESSION['filefoto']) || empty($_SESSION['filefoto'])) 
{
    header('location:login.php');
}

?>