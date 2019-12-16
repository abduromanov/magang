<?php $this->load->view('head'); ?>
<style>
    p {
        color: white;
    }
    #table2 th {
        text-align: center;
    }
    a {
        margin-left: 5px;
        cursor: pointer;
    }
    a.active{
        color: white;
    }
    .row::after {
        content: "";
        clear: both;
        display: table;
    }
    .column {
        float: left;
        width: 335px;
        height: auto;
        margin: 5px;
    }
    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute center;
        transform: translate(0%, -100%);
        -ms-transform: translate(0%, -100%);
    }
    .middle:hover{
        opacity: 1;
    }
    .text {
        background-color: #ffffff;
        color: black;
        font-size: 16px;
        padding: 7px;
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
                            <a href="<?php echo base_url(); ?>c_admin/data_jalan_admin/152" class="active">Data Jalan</a>
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
            <h1 class="sec-title-w3 text-capitalize">data jalan</h1>
            <span class="block"></span>
        </div><br><br>

        <div class="row">
            <div class="col-md-3" style="border-right: 3px solid #e6e6e6"><br>
                <h6><strong>Ketik untuk mencari jalan :</strong></h6>
                <input class="form-control" id="myInput" type="text" placeholder="Cari Jalan">
                <hr>
                <ul class="list-group" id="myList" style=" overflow: scroll; overflow-x: hidden; height: 700px">
                    <?php 
                    foreach ($jln_jalan as $j) {
                        $active = '';
                        $link = base_url().'c_admin/data_jalan_admin/'.$j->jid;
                        if ($j->jid == $this->uri->segment(3)) {
                            $active = 'active';
                        }
                        echo '<li class="list-group-item '.$active.'"><a href='.$link.' class="'.$active.'">'.$j->nama.'</a></li>';
                    }?>
                </ul>
            </div>
        
            <div class="col-md-9">
               <?php foreach ($jalan as $jl) {?>
                    <h2><center>Jalan <?php echo $jl->nama ?></center></h2>
                    <hr>
                    <h4><b>Data Jalan</b></h4>
                    <table id="table1" class="table table-borderless table-hover">
                        <tr>
                            <th><i class="fas fa-road"></i> Nomor Ruas</th>
                            <td><?php echo $jl->ruas ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-arrows-alt-h"></i> Pangkal</th>
                            <td><?php echo $jl->pangkal ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-arrows-alt-h"></i> Ujung</th>
                            <td><?php echo $jl->ujung ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-truck"></i> Panjang</th>
                            <td><?php echo $jl->panjang ?> kilometer</td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-taxi"></i> Lebar</th>
                            <td><?php echo $jl->lebar ?> meter</td>
                        </tr>
                        <tr>
                            <?php foreach ($fungsi as $d) { ?>
                                <th><i class="far fa-check-circle"></i> Fungsi Jalan</th>
                                <td><?php echo $d['nama'] ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                
                    <hr><br><hr>
                    <h4><b>Riwayat Jalan</b></h4>
                    <table id="table2" class="table table-bordered table-hover">
                        <tr>
                            <th>Tahun</th>
                            <th>Pekerjaan</th>
                            <th>Pelaksana</th>
                            <th>Keterangan</th>
                        </tr>
                        <?php foreach ($riwayat as $r) {
                        ?>
                            <tr>
                                <td><?php echo $r['tahun'] ?></td>
                                <td><?php echo $r['pekerjaan'] ?></td>
                                <td><?php echo $r['pelaksana'] ?></td>
                                <td><?php echo $r['keterangan'] ?></td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                    <hr><br><hr>

                    <h4><b>Foto Jalan</b></h4>
                    <?php foreach ($photo as $ph) { ?>
                        <div class="column">
                            <a onclick="tampilFoto('<?=$ph['path']?>')">
                                <img style="max-width: 75%" src="../..<?php echo $ph['path']; ?>">
                            </a>
                        </div>
                    <?php } ?>
                    
                    <div class="modal" id="fotoModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Foto Jalan</h4>
                                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <img id="fotoJalan" style="max-width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>
               <?php
               } ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('footer'); ?>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function(){
                var value = $(this).val().toLowerCase();
                $("#myList li").filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }); 
        });

        function tampilFoto(url) {
            $('#fotoJalan').attr('src', '../..'+url);
            $('#fotoModal').modal();
        }
    </script>
</body>