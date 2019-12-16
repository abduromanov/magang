<?php $this->load->view('head')?>
<body>
	<div class="inner-banner-agile">
		<header>
			<a href="#menu" class="menu-link">
				<span>toggle menu</span>
			</a>

			<nav id="menu" class="panel">
				<ul>
					<li>
                        <a href="<?php echo base_url(); ?>">Beranda</a>
                    </li>
                    <li>
	                    <?php if ($this->m_user->logged_id()) {
	                        $username = $this->session->userdata('username');?>
	                        <a href="<?php echo base_url(); ?>c_admin/data_jalan_admin/152">Data Jalan</a>
	                    <?php } else {?>
	                        <a href="<?php echo base_url(); ?>c_user/data_jalan/152">Data Jalan</a>
	                    <?php } ?>
	                </li>
	                <li>
	                    <?php if ($this->m_user->logged_id()) {
	                        $username = $this->session->userdata('username');?>
	                        <a href="<?php echo base_url(); ?>c_admin/laporan_jalan_admin/152">Laporan Jalan</a>
	                    <?php } else {?>
	                        <a href="<?php echo base_url(); ?>c_user/laporan_jalan/152">Laporan Jalan</a>
	                    <?php } ?>
	                </li>
	                <li>
	                	<?php if($this->m_user->logged_id()){
	                		$username = $this->session->userdata('username');?>
	                        <a href="<?php echo base_url(); ?>c_admin/laporan_masuk" class="active">Daftar Laporan Masuk</a>
	                        <?php } else {?>
	                        <a href="<?php echo base_url(); ?>view_grafik">Grafik Jalan</a>
	                	<?php } ?>
	                </li>
                    <li>
	                    <?php if ($this->m_user->logged_id()) { 
		                    $username = $this->session->userdata('user_name');?>
		                    <a href="<?php echo base_url(); ?>logout">Logout (<?= $username?>)</a>
		                <?php } else { ?>
		                    <a href="<?php echo base_url(); ?>login">Login</a>
		                <?php } ?>
		            </li>
				</ul>
			</nav>
		</header>
	</div>

	<div class="container">
        <div class="wthree-inner-sec">
            <h1 class="sec-title-w3 text-capitalize">Daftar Laporan Masuk</h1>
            <span class="block"></span>
        </div><br><br><br>
        <div class="row">
        <div class="container">
        	<?=(isset($message['message']))? $message['message'] : "";?>
    		<table class="table">
    			<tr align="center">
    				<th width="15%">Nama Pelapor</th>
    				<th>No. Handphone</th>
    				<th>Isi aduan</th>
    				<th>Foto</th>
    				<th>Waktu</th>
    				<th>Action</th>
    			</tr>
	    		<?php foreach ($laporan as $lap) { 
	    			if($lap->status == NULL){ ?>
	    			<tr align="center">
			    		<td><?=$lap->nama?></td>
			    		<td>+62<?=$lap->no_hp?></td>
			    		<td align="justify"><?=$lap->aduan?></td>
			    		<td>
			    			<?php if($lap->foto == NULL){ ?>
			    			<button type="button" class="btn btn-info disabled"><i class="fa fa-image"></i></button>
			    			<?php } else { ?>
			    			<button type="button" class="btn btn-info" onclick="tampilFoto('<?=$lap->foto?>')"><i class="fa fa-image"></i></button>
				    		<?php } ?>
			    		</td>
			    		<td><?=$lap->tanggal?></td>
			    		<td>
			    			<a href="<?=base_url().'c_admin/set_status/'.$lap->lapid.'/active'?>" class="btn btn-success"><i class="fa fa-check"></i></a>
			    			<button id="btnHapus" class="btn btn-danger" onclick="fungsiHapus('<?=base_url().'c_admin/set_status/'.$lap->lapid.'/nonactive'?>')"><i class="fa fa-times"></i></button>
			    		</td>
				    </tr>

				    <div class="modal" id="fotoModal">
				        <div class="modal-dialog">
				            <div class="modal-content">
				                <div class="modal-header">
				                    <h4 class="modal-title">Foto Lampiran</h4>
				                     <button type="button" class="close" data-dismiss="modal">&times;</button>
				                </div>
				                <div class="modal-body">
				                    <img id="fotoUpload" style="max-width: 100%">
				                </div>
				            </div>
				        </div>
				    </div>

				    <div class="modal" id="deleteModal">
				    	<div class="modal-dialog">
				    		<div class="modal-content">
				    			<div class="modal-header">
				    				<h4 class="modal-title">Hapus</h4>
				                    <button type="button" class="close" data-dismiss="modal">&times;</button>
				    			</div>
				    			<div class="modal-body">Hapus Aduan?</div>
				    			<div class="modal-footer">
				    				<a id="btnHapus" class="btn btn-danger">Ya</a>
				    				<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
				    			</div>
				    		</div>
				    	</div>
				    </div>
		    	<?php }
		    } ?>
    		</table>
	    </div>
        </div>
        <br><br><br><br><br>
    </div>

    

</body>
<script>
	function tampilFoto(url) {
        $('#fotoUpload').attr('src', '../uploads/'+url);
        $('#fotoModal').modal();
    }

    function fungsiHapus(url){
        $('#btnHapus').attr('href', url);
		$('#deleteModal').modal();
    }
</script>
<?php $this->load->view('footer')?>