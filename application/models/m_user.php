<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class m_user extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	function logged_id(){
        return $this->session->userdata('user_id');
    }

    function check_login($table, $field1, $field2)
    {
        // $this->db->query("SELECT * FROM admin WHERE username = '$field1' AND password = '$field2'");
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

	function getJalan($jid){
		$sql = $this->db->query("SELECT * FROM jln_jalan WHERE jid = '$jid'");
		return $sql->result();
	}

	function laporanMasuk($data){
		if(!empty($data)){
	        $this->db->insert('laporan', $data);
	        $ins_id = $this->db->insert_id();
	        return $ins_id;
	    } else {
	    	return false;
	    }
	}

	function tampil_data(){
		$sql = $this->db->query("SELECT * FROM jln_jalan ORDER BY nama ASC");
		return $sql->result();
	}

	function getJalanRusak(){
		$sql=$this->db->query("SELECT count(baik), count(sedang), count(rusak), count(rusakberat) FROM jln_jalannilai");
		return $sql;
	}

	function getLaporan()
    {
        $sql = $this->db->query("SELECT * FROM laporan");
        return $sql->result();
    }

	function getAllLaporan($jid){
		$sql = $this->db->query("SELECT * FROM laporan WHERE jid = '$jid' AND status = 'active'");
		return $sql->result();
	}

	function getKecamatan(){
		$sql = $this->db->query("SELECT * FROM inf_kecamatan");
		return $sql->result_array();
	}

	function sumPanjang($kid){
		$sql = $this->db->query("SELECT SUM(panjang) AS total FROM jln_jalan AS J, jln_kecamatan AS K WHERE J.jid = K.jid AND kid = '$kid'");
		return $sql;
	}

	function cariFungsi($jid){
		$sql = $this->db->query("SELECT nama FROM jln_tipefungsi AS J, jln_fungsi AS F WHERE J.fid = F.fid AND jid = '$jid'");
		return $sql->result_array();
	}

	function balasan(){
		$sql = $this->db->query("SELECT * FROM laporan_balas");
		return $sql->result_array();
	}

	function admin_balas($id){
		$sql = $this->db->query("SELECT nama_user FROM user_account WHERE id_user = '$id'");
		return $sql->result_array();
	}

	function set_status($lapid, $status)
	{
		$sql = $this->db->query("UPDATE laporan SET status = '$status' WHERE lapid = '$lapid'");
		return $sql;
	}

	function hapus_laporan($lapid){
		$sql = $this->db->query("UPDATE laporan SET status = 'nonactive' WHERE lapid = '$lapid'");
		return $sql;
	}

	function upload(){
        $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "jpg|png|jpeg|gif",
            'encrypt_name' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            // 'max_height' => "768",
            // 'max_width' => "1024"
        );

        $this->load->library('upload', $config);

        if($this->upload->do_upload('foto')){
            return array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        } else {
            return array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
        }
    }

    function getRiwayat($jid)
    {
    	$sql = $this->db->query("SELECT * FROM jln_riwayat WHERE jid = '$jid' ORDER BY tahun DESC");
		return $sql->result_array();
    }

    function delBalasan($idbalas)
    {
    	return $this->db->query("DELETE FROM laporan_balas WHERE idbalas = '$idbalas'");
    	
    }

    function tambahBalasan($data){
    	if(!empty($data)){
	        $this->db->insert('laporan_balas', $data);
	        $ins_id = $this->db->insert_id();
	        return $ins_id;
	    } else {
	    	return false;
	    }
    }

    function editBalasan($data)
    {
    	return $this->db->replace('laporan_balas', $data);
    }

    function getFoto($jid)
    {
    	$sql = $this->db->query("SELECT * FROM jln_foto WHERE jid = '$jid'");
		return $sql->result_array();
    }
}
?>