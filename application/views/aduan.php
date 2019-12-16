<?php foreach ($aduan as $key) { ?>
	<table class="table table-hover" style="width: 100%">
	    <tr class="info">
	      <th>ADUAN UNTUK JALAN KENANGAN</th>
	    </tr>

	    <tr>
	    	<td>Nama Pelapor</td>
	    	<td><?=$key->nama?></td>
	    </tr>

	    <tr>
	    	<td>Titik Kerusakan</td>
	    	<td><?=$key->titik?></td>
	    </tr>
	    
	    <tr>
	    	<td>Yang Diadukan</td>
	    	<td><?=$key->aduan?></td>
	    </tr>
  	</table>
<?php } ?>