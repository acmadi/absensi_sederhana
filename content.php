<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";

// Bagian Home
if ($_GET[module]=='pegawai'){
  if ($_SESSION[leveluser]=='admin' OR $_SESSION[leveluser]=='user'){
    include "modul/mod_pegawai/pegawai.php";
  }
}

// Bagian Kategori
elseif ($_GET[module]=='rekap_absen_bulanan'){
  if ($_SESSION[leveluser]=='admin'){  
    include "modul/mod_rekap_absensi_bulanan/rekap_absensi_bulanan.php";
  }
}


// Bagian Kategori
elseif ($_GET[module]=='rekap_absen_harian'){
  if ($_SESSION[leveluser]=='admin'){  
    include "modul/mod_rekap_absensi_harian/rekap_absensi_harian.php";
  }
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>WELCOME TO APLIKASI ABSENSI BERBASIS WEB</b></p>";
}
?>
