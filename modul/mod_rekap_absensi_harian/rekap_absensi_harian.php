<?php
$aksi="modul/mod_rekap_absensi_harian/aksi_rekap_absensi_harian.php";

   if(isset($_GET['tgl_cek'])){
   
   include "../../config/fungsi_combobox.php";
   $tgl_skrg =  substr($_GET['tgl_cek'],9,2);
   $bln_skrg = substr($_GET['tgl_cek'],5,2);
   //if (substr($bln_skrg,0,1) == '0'){
	 //$bln_skrg = substr($bln_skrg,1,1);
   //}
   //echo $bln_skrg.' bln_skrg';
   $thn_skrg = substr($_GET['tgl_cek'],0,4);
   $tampil=mysql_query("SELECT z3.hadir,z3.tidak_hadir,z4.tepat_waktu,z4.terlambat
						FROM
						(SELECT SUM(hadir) hadir,SUM(tidak_hadir) tidak_hadir
						FROM (
							SELECT CASE WHEN (SELECT COUNT(*) FROM absen_harian WHERE id_pegawai = b.id_pegawai AND LEFT(TGL_ABSEN,10) = '".$_GET['tgl_cek']."') > 0 THEN
								1
								   ELSE
								0
								   END hadir,			
								   CASE WHEN (SELECT COUNT(*) FROM absen_harian WHERE id_pegawai = b.id_pegawai AND LEFT(TGL_ABSEN,10) = '".$_GET['tgl_cek']."') = 0 THEN
								1
								   ELSE
								0
								   END tidak_hadir
							FROM pegawai b) z1) z3,
						(SELECT SUM(tepat_waktu) tepat_waktu,SUM(terlambat) terlambat
						FROM (
							SELECT CASE WHEN HOUR(MIN(tgl_absen)) >= 8 AND MINUTE(MIN(tgl_absen)) > 0 THEN
								  0
								   ELSE
								  1
								   END tepat_waktu,
								   CASE WHEN HOUR(MIN(tgl_absen)) >= 8 AND MINUTE(MIN(tgl_absen)) > 0 THEN
								  1
								   ELSE
								  0
								   END terlambat
							FROM absen_harian a,pegawai b
							WHERE LEFT(TGL_ABSEN,10) = '".$_GET['tgl_cek']."'
							AND a.id_pegawai = b.id_pegawai
							GROUP BY a.id_pegawai,b.nama_pegawai
						) z2) z4");
					//echo $tampil.'#';	
					//die;
	}					   
	//echo $tampil.'crap';	
    echo "<h2>Rekap Absensi Harian</h2>
          <form method=POST action='$aksi?module=agenda&act=input'>
          <table>
          <tr><td>Tgl Cek</td><td> : ";        
          combotgl(1,31,'tgl_mulai',$tgl_skrg);
          combonamabln(1,12,'bln_mulai',$bln_skrg);
          combothn(2000,$thn_sekarang,'thn_mulai',$thn_skrg);
		  
    echo "</td></tr>
          <tr><td colspan=2><input type=submit value=Cek></td></tr>
          </table>
          </form>";
	$r=mysql_fetch_array($tampil);	  
	?>
	<table>
	  <tr>
		  <td>URUT</td>
		  <td>KETERANGAN</td>
		  <td>JML PEGAWAI</td>
	  </tr>    
	  <tr>
		  <td>1</td>
		  <td>HADIR</td>
		  <td><?php echo $r['hadir'];?></td>
	  </tr>
	  <tr>
		  <td>2</td>
		  <td>TIDAK HADIR</td>
		  <td><?php echo $r['tidak_hadir'];?></td>
	  </tr>
	  <tr>
		  <td>3</td>
		  <td>TEPAT WAKTU</td>
		  <td><?php echo $r['tepat_waktu'];?></td>
	  </tr>
	  <tr>
		  <td>4</td>
		  <td>TERLAMBAT</td>
		  <td><?php echo $r['terlambat'];?></td>
	  </tr>		
    </table>
	<?php	
	if(isset($_GET['tgl_cek'])){
   
   include "../../config/fungsi_combobox.php";
   
   $tampil=mysql_query("SELECT a.id_pegawai,b.nama_pegawai,MIN(tgl_absen) datang,MAX(tgl_absen) pulang,
							   CONCAT(
							   CASE WHEN HOUR(MIN(tgl_absen)) >= 8 AND MINUTE(MIN(tgl_absen)) > 0 THEN
								  'Datang Terlambat '
							   ELSE
							  'Datang Tepat Waktu '
							   END,
							   CASE WHEN HOUR(MAX(tgl_absen)) < 17 THEN
								  'Pulang Sebelum Waktunya'
							   ELSE
							  ''
							   END) keterangan  
						FROM absen_harian a,pegawai b
						WHERE LEFT(TGL_ABSEN,10) = '".$_GET['tgl_cek']."'
						AND a.id_pegawai = b.id_pegawai
						GROUP BY a.id_pegawai,b.nama_pegawai
");
					//echo $tampil.'#';	
					//die;
	}	  
	echo "<table>
          <tr><th>No</th><th>ID Pegawai</th><th>Nama Pegawai</th><th>Tgl Masuk</th><th>Tgl Pulang</th><th>Keterangan</th></tr>"; 
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[id_pegawai]</td>
             <td>$r[nama_pegawai]</td>
		     <td>$r[datang]</td>
			 <td>$r[pulang]</td>
			 <td>$r[keterangan]</td>
			 </tr>";
      $no++;
    }
    echo "</table>";

    break;

?>
