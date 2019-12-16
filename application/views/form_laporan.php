<?php $this->load->view('head'); ?>
<style>
	input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
	    -webkit-appearance: none;
	    margin: 0;
	}
	input[type="file"]{
		cursor: pointer;
	}
	textarea{
		resize: none;
	}
	label{
		color: white;
	}
	#googleMap{
		height: 60%;
		padding-left: 20px;
	}
</style>

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
	                        <a href="<?php echo base_url(); ?>c_admin/laporan_masuk">Daftar Laporan Masuk</a>
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

	<section class="main-sec-w3 pb-5">
		<div class="container">
			<div class="wthree-inner-sec">
				<?php $id = $this->uri->segment(3); ?>
				<div class="sec-head">
					<?php $name =  $this->m_user->getJalan($id);?>
					<h1 class="sec-title-w3 text-capitalize">Laporkan Jalan <?= $name[0]->nama ?></h1>
					<span class="block"></span>
				</div>

				<div class=""><br>
					<h4><?= (isset($message))? $message : ""; ?></h4><br>
					<?php $this->load->view('maps_aduan'); ?>
				</div>

				<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url().'c_user/submit/'.$id;?>">

					<div class="form-group">
						<label for="name" >Nama* : </label>
						<input type="input" name="nama" class="form-control" placeholder="Masukkan nama anda">
					</div>

					<div class="form-group">
						<label for="name" class="control-label">No. Handphone* : </label>
						<input type="number" name="noHp" class="form-control" placeholder="Masukkan no. HP anda">
					</div>

					<div class="form-group">
						<label for="name" class="control-label">Titik : </label>
						<input type="input" name="titik" id="titik" class="form-control" placeholder="Geser marker pada peta untuk merubah titik" readonly>
					</div>

					<div class="form-group">
						<label for="name" class="control-label">Aduan anda* : </label>
						<textarea name="aduan" id="aduan" class="form-control" rows="6" placeholder="Masukkan aduan anda"></textarea>
					</div>

					<label>Upload Foto : </label>
					<div class="custom-file">
						<input type="file" id="foto" name="foto" class="custom-file-input form-control">
						<label for="foto" class="custom-file-label">Pilih file (Max. 2 MB)</label>
					</div><br><br>

					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary">&nbsp;&nbsp;Submit&nbsp;&nbsp;</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<?php $this->load->view('footer'); ?>
</body>
<script>
	$('#foto').on('change',function(e){
        // var fileName = $(this).val();
        var fileName = e.target.files[0].name;
        $(this).next('.custom-file-label').html(fileName);
        if (e.target.files[0].size > 2048000) {
        	alert('Gambar maksimal 2 MB');
        	$(this).next('.custom-file-label').html('Pilih file (Max. 2 MB)');
        }
    })
</script>