<?php
session_start();
include "../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Input user
if ( $act=='input'){  
  mysql_query("INSERT INTO pegawai(nama_pegawai) 
	                       VALUES('$_POST[nama_pegawai]')");
  header('location:../../media.php?module='.$module);
}

// Update user
elseif ( $act=='update'){
  
    mysql_query("UPDATE pegawai SET nama_pegawai   = '$_POST[nama_pegawai]'  
                           WHERE  id_pegawai     = '$_POST[id]'");
  
  header('location:../../media.php?module='.$module);
}
?>
