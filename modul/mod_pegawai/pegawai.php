<?php
  $aksi="modul/mod_pegawai/aksi_pegawai.php";
switch($_GET[act]){
  // Tampil pegawai
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil = mysql_query("SELECT * FROM pegawai ORDER BY nama_pegawai");
      echo "<h2>pegawai</h2>
          <input type=button value='Tambah pegawai' onclick=\"window.location.href='?module=pegawai&act=tambahpegawai';\">";
    }
    
    echo "<table>
          <tr><th>no</th><th>nama_pegawai</th><th>aksi</th></tr>"; 
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nama_pegawai]</td>             
             <td><a href=?module=pegawai&act=editpegawai&id=$r[id_pegawai]>Edit</a></td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  case "tambahpegawai":
    if ($_SESSION[leveluser]=='admin'){
    echo "<h2>Tambah pegawai</h2>
          <form method=POST action='$aksi?module=pegawai&act=input'>
          <table>
          <tr><td>nama_pegawai</td>     <td> : <input type=text name='nama_pegawai'></td></tr>    
		  <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>		  
          </table></form>";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
    }
     break;
    
  case "editpegawai":
    $edit=mysql_query("SELECT * FROM pegawai WHERE id_pegawai='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
    echo "<h2>Edit pegawai</h2>
          <form method=POST action=$aksi?module=pegawai&act=update>
          <input type=hidden name=id value='$r[id_pegawai]'>
          <table>
          <tr><td>nama_pegawai</td>     <td> : <input type=text name='nama_pegawai' value='$r[nama_pegawai]' ></td></tr>
          ";
    
    echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
    }
    else{
    echo "<h2>Edit pegawai</h2>
          <form method=POST action=$aksi?module=pegawai&act=update>
          <input type=hidden name=id value='$r[id_pegawai]'>
          <input type=hidden name=blokir value='$r[blokir]'>
          <table>
          <tr><td>nama_pegawai</td>     <td> : <input type=text name='nama_pegawai' value='$r[nama_pegawai]' ></td></tr>";    
    echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
    }
    break;  
}

?>
