<?php $this->load->view('head'); ?>
<?php
  foreach ($jalan as $key) {
?>
  <table class="table table-hover" style="width: 100%">
    <tr class="info">
      <th colspan="2">Jalan <?=$key->nama?></th>
    </tr>

    <tr>
      <td>No. Ruas</td>
      <td><?=$key->ruas?></td>
    </tr>
    
    <tr>
    	<td>Pangkal</td>
    	<td><?=$key->pangkal?></td>
    </tr>
    
    <tr>
    	<td>Ujung</td>
    	<td><?=$key->ujung?></td>
    </tr>
    
    <tr>
    	<td>Panjang</td>
    	<td><?=$key->panjang?></td>
    </tr>
    
    <tr>
    	<td>Lebar</td>
    	<td><?=$key->lebar?></td>
    </tr>
  </table>
  
  <?php if ($this->m_user->logged_id()) {
    $username = $this->session->userdata('username');?>
      <a class="btn btn-sm btn-info" href="<?php echo base_url().'c_admin/data_jalan_admin/'.$key->jid?>">LEBIH LENGKAP</a>
  <?php } else {?>
      <a class="btn btn-sm btn-info" href="<?php echo base_url().'c_user/data_jalan/'.$key->jid?>">LEBIH LENGKAP</a>
  <?php } ?>
  
  <a class="btn btn-sm btn-warning" href="<?php echo base_url().'c_user/form_laporan/'.$key->jid?>">LAPORKAN JALAN</a>
<?php }?>