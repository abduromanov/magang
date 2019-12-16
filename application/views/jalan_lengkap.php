<!DOCTYPE>
<html>
	<?php $this->load->view('head'); ?>
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
                        <a href="<?php echo base_url(); ?>view_grafik">Grafik Jalan</a>
                    </li>
                    <li>
                        <?php if ($this->m_user->logged_id()) { 
                            $username = $this->session->userdata('user_name');?>
                            <a href="<?php echo base_url(); ?>logout">Logout (<?= $username?>)</a>
                        <?php } else { ?>
                            <a href="<?php echo base_url(); ?>login">Login</a>
                        <?php } ?>
                    </li>
            </nav>
			</header>
		</div>

		<section class="main-sec-w3 pb-5">
			<div class="container">
				<div class="wthree-inner-sec">
					<div class="sec-head">
						<?php foreach ($jalan as $d) {?>
							<h1 class="sec-title-w3 text-capitalize">jalan <?php echo $d->nama ?></h1>
							<span class="block"></span>
							<table style="color:white" border="5";>
								<tr>
									<th>Pangkal Jalan</th>
									<th>Ujung Jalan</th>
									<th>Panjang Jalan</th>
									<th>Lebar Jalan</th>
								</tr>
								<tr>
									<td><?php echo $d->pangkal ?></td>
									<td><?php echo $d->ujung ?></td>
									<td><?php echo $d->panjang ?></td>
									<td><?php echo $d->lebar ?></td>
								</tr>
							</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
		<?php $this->load->view('footer'); ?>
	</body>
</html>