<?php $this->load->view('head'); ?>
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
        padding: 3px;
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
                            <a href="<?php echo base_url(); ?>c_admin/laporan_jalan_admin/152"  class="active">Laporan Jalan</a>
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
            
            <div class="logo_wthree">
                <a href="index.html">
                    <i class="fab fa-node-js"></i>
                </a>
            </div>
        </header>
    </div>

    <div class="container">
        <div class="wthree-inner-sec">
            <h1 class="sec-title-w3 text-capitalize">Laporan jalan</h1>
            <span class="block"></span>
        </div><br>

        <div class="row">
            <div class="col-md-3" style="border-right: 3px solid #e6e6e6"><br>
            <h6><strong>Ketik untuk mencari jalan :</strong></h6>
            <input class="form-control" id="myInput" type="text" placeholder="Cari jalan"></input>
            <hr>
                <ul class="list-group" id="myList" style=" overflow: scroll; overflow-x: hidden; height: 510px">
                    <?php
                    foreach ($jalan as $jln) {
                        $active = '';
                        $link = base_url().'c_admin/laporan_jalan_admin/'.$jln->jid;
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
            <?= (isset($message['message']))? $message['message'] : ""; ?>
            <br>
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
                            <h3><?php  echo $a->nama ?> (+62<?php  echo $a->no_hp ?>)</h3>
                            <blockquote class="blockquote">
                            <p style="color: black"><i><?php echo $a->aduan; ?></i></p>
                            <?php if ($a->foto != NULL) { ?>
                                <a data-toggle="tooltip" title="Lihat Lampiran" onclick="tampilFoto('<?=$a->foto?>')"><img style="max-width: 20%" src="../../uploads/<?=$a->foto?>"></a>
                            <?php } ?>
                            <footer class="blockquote-footer"><?= $a->tanggal?></footer>
                            </blockquote>
                            <a class="icon-button" data-toggle="tooltip" title="Balas Aduan" onclick="fungsiBalas('<?= $a->lapid?>','<?= $this->session->userdata('user_id')?>')"><i class="fas fa-reply fa-lg"></i></a>
                            <a class="icon-button" data-toggle="tooltip" title="Hapus Aduan" onclick="fungsiHapus('<?php echo base_url().'c_admin/hapusLaporan/'.$a->lapid.'/'.$id_jalan?>')">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </a>

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
                            			<div class="modal-body">Apakah Anda Yakin Ingin Menghapusnya?</div>
                            			<div class="modal-footer">
                            				<a id="btnHapus" class="btn btn-danger">Ya</a>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                            			</div>
                            		</div>
                            	</div>
                            </div>

                            <div class="modal" id="replyModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Balas Aduan</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form id="formbalas" method="post" enctype="multipart/form-data" class="form-vertical" action="<?= base_url().'c_admin/submit_balasan/'.$id_jalan?>">
                                            <div class="modal-body">
                                                <input type="hidden" name="lapid" id="lapid">
                                                <input type="hidden" name="idUser" id="idUser">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="4" id="balasan" name="balasan" placeholder="Masukkan Tanggapan Anda"></textarea>
                                                </div>
                                                <label>Upload Foto : </label>
                                                <div class="custom-file">
                                                    <input type="file" id="foto" name="foto" class="custom-file-input form-control">
                                                    <label for="foto" class="custom-file-label">Pilih file (Max. 2 MB)</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="user-reply">
                        <?php foreach ($balas as $b) { 
                            if ($b['lapid'] == $a->lapid) { ?>
                                <div class="media p-3">
                                    <div class="media-body">
                                        <blockquote class="blockquote">
                                        <?php
                                        echo '<h5>'.$user[0]['nama_user'].'</h5>';
                                        echo '<p style="color: black"><i>'.$b['balasan'].'</i></p>';
                                        ?>
                                        <?php if ($b['foto'] != NULL) { ?>
                                            <a data-toggle="tooltip" title="Lihat Lampiran" onclick="fotoBalasan('<?=$b['foto']?>')"><img style="max-width: 20%" src="../../uploads/<?=$b['foto']?>"></a>
                                        <?php } ?>
                                        </blockquote>
                                        <a data-toggle="tooltip" title="Hapus Balasan" onclick="fungsiHapus('<?php echo base_url().'c_admin/hapus_balasan/'.$b['idbalas'].'/'.$id_jalan?>')"><i class="fas fa-trash-alt fa-lg"></i></a>
                                        <a data-toggle="tooltip" title="Edit Balasan" onclick="fungsiEdit('<?= $b['idbalas']?>','<?= $b['lapid']?>','<?= $b['id_user']?>','<?= $b['balasan']?>')"><i class="fas fa-edit fa-lg"></i></a>
                                        <hr>
                                    </div>
                                </div>
                                <?php } ?>
                        <?php } ?>
                        <div class="modal" id="editModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Balasan</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form id="formbalas" method="post" class="form-vertical" action="<?= base_url().'c_admin/edit_balasan/'.$id_jalan?>">
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_idbalas" id="edit_idbalas">
                                            <input type="hidden" name="edit_lapid" id="edit_lapid">
                                            <input type="hidden" name="edit_idUser" id="edit_idUser">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="4" id="edit_balasan" name="edit_balasan"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                $('[data-toggle="tooltip"]').tooltip();
            });

            function tampilFoto(url) {
                $('#fotoUpload').attr('src', '../../uploads/'+url);
                $('#fotoModal').modal();
                
            }

            function fotoBalasan(url) {
                $('#fotoUpload').attr('src', '../../uploads/'+url);
                $('#fotoModal').modal();
                
            }

            function fungsiHapus(url){
                $('#btnHapus').attr('href', url);
				$('#deleteModal').modal();
            }

            function fungsiBalas(lapid,id_user){
                document.getElementById('lapid').value = lapid;
                document.getElementById('idUser').value = id_user;
                $('#replyModal').modal();
            }

            function fungsiEdit(idbalas,lapid,id_user,balasan) {
                document.getElementById('edit_idbalas').value = idbalas;
                document.getElementById('edit_lapid').value = lapid;
                document.getElementById('edit_idUser').value = id_user;
                document.getElementById('edit_balasan').value = balasan;
                $('#editModal').modal();
            }

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
</body>