<h1>Data Gambar</h1><hr>
<table border="1" cellpadding="8">
<tr>
  <th>Gambar</th>
  <th>Deskripsi</th>
  <th>Nama File</th>
  <th>Ukuran File</th>
  <th>Tipe File</th>
</tr>
<?php
if( ! empty($gambar)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
  foreach($gambar as $data){ // Lakukan looping pada variabel gambar dari controller
    echo "<tr>";
    echo "<td><img src='".base_url("images/".$data->file_name)."' width='100' height='100'></td>";
    // echo "<td>".$data->deskripsi."</td>";
    // echo "<td>".$data->nama_file."</td>";
    // echo "<td>".$data->ukuran_file." kB</td>";
    // echo "<td>".$data->tipe_file."</td>";
    echo "</tr>";
  }
}else{ // Jika data tidak ada
  echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
}
?>
</table>

<div style="color: red;"><?php echo (isset($message))? $message : ""; ?></div>
<form method="post" action="<?php echo base_url().'c_user/uploadFile'?>" enctype="multipart/form-data">
	<label for="foto">Input foto : </label>
	<input type="file" name="foto">
	<input type="submit" name="submit" value="submit">
</form>