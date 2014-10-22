<?php
$aksi="modul/mod_rekap_absensi_bulanan/aksi_rekap_absensi_bulanan.php";

   if(isset($_GET['tgl_cek'])){
   
   include "../../config/fungsi_combobox.php";   
   $bln_skrg = substr($_GET['tgl_cek'],5,2);
   $thn_skrg = substr($_GET['tgl_cek'],0,4);
   
   $tampil=mysql_query("SELECT a.id_pegawai,b.nama_pegawai,COUNT(*) masuk,DAY(LAST_DAY('".$_GET['tgl_cek']."-01'))-COUNT(*) absen
						FROM (
							SELECT id_pegawai, LEFT(TGL_ABSEN,10) tgl_absen 
							FROM absen_harian 
							WHERE LEFT(TGL_ABSEN,7) = '".$_GET['tgl_cek']."'
							GROUP BY id_pegawai, LEFT(TGL_ABSEN,10)) a,pegawai b
						WHERE a.id_pegawai = b.id_pegawai	
						GROUP BY a.id_pegawai,b.nama_pegawai");
					//echo $tampil.'#';	
					//die;
	}
	echo "<h2>Rekap Absensi Harian</h2>
          <form method=POST action='$aksi?module=agenda&act=input'>
          <table>
          <tr><td>Tgl Cek</td><td> : ";                  
          combonamabln(1,12,'bln_mulai',$bln_skrg);
          combothn(2000,$thn_sekarang,'thn_mulai',$thn_skrg);
		  
    echo "</td></tr>
          <tr><td colspan=2><input type=submit value=Cek></td></tr>
          </table>
          </form>";
	
	echo "<table>
          <tr><th>No</th><th>ID Pegawai</th><th>Nama Pegawai</th><th>Jml Masuk</th><th>Jml Absen</th></tr>"; 
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[id_pegawai]</td>
             <td>$r[nama_pegawai]</td>
		     <td>$r[masuk]</td>
			 <td>$r[absen]</td>			 
			 </tr>";
      $no++;
    }
    echo "</table>";

    break;

?>
