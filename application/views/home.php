<?php $this->load->view('head'); ?>
<body>
    <header>
        <a href="#menu" class="menu-link">
            <span>toggle menu</span>
        </a>

        <nav id="menu" class="panel">
            <ul>
                <li>
                    <a href="<?php echo base_url(); ?>" class="active">Beranda</a>
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
    
    <?php $this->load->view('maps'); ?>
</body>