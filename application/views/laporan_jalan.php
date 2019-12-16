<?php $this->load->view('head');
$this->load->model('m_user'); ?>
<style>
    a {
        cursor: pointer;
    }
    .icon-button {
        color: black;
    }
    .user-reply {
        margin: 0px;
        margin-left: 40px;
        padding: 0px;
        border-left: 3px solid #e6e6e6;
    }
    a{
        margin-left: 5px;
    }
    a.active{
        color: white;
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
                            <a href="<?php echo base_url(); ?>c_user/laporan_jalan/152" class="active">Laporan Jalan</a>
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
                </ul>
            </nav>
        </header>
    </div>

    <div class="container">
        <div class="wthree-inner-sec">
            <h1 class="sec-title-w3 text-capitalize">laporan jalan</h1>
            <span class="block"></span>
        </div><br><br>

        <div class="row">
            <div class="col-md-3" style="border-right: 3px solid #e6e6e6"><br>
            <h6><strong>Ketik untuk mencari jalan :</strong></h6>
            <input class="form-control" id="myInput" type="text" placeholder="Cari jalan"></input>
            <hr>
                <ul class="list-group" id="myList" style=" overflow: scroll; overflow-x: hidden; height: 510px">
                    <?php
                    foreach ($jalan as $jln) {
                        $active = '';
                        $link = base_url().'c_user/laporan_jalan/'.$jln->jid;
                        if ($jln->jid == $this->uri->segment(3)) {
                            $active = 'active';
                        }
                        echo '<li class="list-group-item '.$active.'"><a href='.$link.' class="'.$active.'">'.$jln->nama.'</a></li>';
                    }?>
                </ul>
            </div>
            <div class="col-md-9"><br>
            <?php foreach ($jalan as $jln) {
                if ($this->uri->segment(3) == $jln->jid) {
                    $id_jalan = $jln->jid;
                    echo '<h2>Aduan untuk jalan : '.$jln->nama.'</h2>';
                }
            } ?>
            <hr>
            <?php $balas = $this->m_user->balasan();
                foreach ($balas as $key) {
                    $id = $key['id_user'];
                    $user = $this->m_user->admin_balas($id);
                }
            ?>

                <?php foreach ($aduan as $a) {?>
                <div class="media border p-3">
                    <div class="media-body">
                        <div style="background-color: #d9d9d9; padding: 10px">
                        <h3><?php  echo $a->nama ?></h3>
                            <blockquote class="blockquote">
                            <p style="color: black"><i><?php echo $a->aduan; ?></i></p>
                            <?php if ($a->foto != NULL) { ?>
                                <a data-toggle="tooltip" title="Lihat Lampiran" onclick="tampilFoto('<?=$a->foto?>')"><img style="max-width: 20%" src="../../uploads/<?=$a->foto?>"></a>
                            <?php } ?>
                            <footer class="blockquote-footer"><?= $a->tanggal?></footer>
                            </blockquote>
                        </div>

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

                        <div class="user-reply">
                        <?php foreach ($balas as $b) { 
                            if ($b['lapid'] == $a->lapid) { ?>
                                <div class="media p-3">
                                    <div class="media-body" style="border-bottom: 2px solid #cccccc">
                                        <blockquote class="blockquote">
                                        <?php
                                        echo '<h5>'.$user[0]['nama_user'].'</h5>';
                                        echo '<p style="color: black"><i>'.$b['balasan'].'</i></p>';
                                        ?>
                                        <?php if ($b['foto'] != NULL) { ?>
                                            <a data-toggle="tooltip" title="Lihat Lampiran" onclick="fotoBalasan('<?=$b['foto']?>')"><img style="max-width: 20%" src="../../uploads/<?=$b['foto']?>"></a>
                                        <?php } ?>
                                        </blockquote>
                                    </div>
                                </div>
                                <?php } ?>
                        <?php } ?>
                        </div>
                    </div>                    
                </div><br>
                <?php } ?>
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
                $('#fotoUpload').attr('src', '../../uploads/'+url);
                $('#fotoModal').modal();
            }
            
            function fotoBalasan(url) {
                $('#fotoUpload').attr('src', '../../uploads/'+url);
                $('#fotoModal').modal();
                
            }
        </script>
</body>