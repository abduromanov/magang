<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class C_admin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->library('form_validation');
	}

	function logged_in(){
		if($this->m_user->logged_id()) {
            redirect(base_url());
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == TRUE) {
            
	            $username = $this->input->post("username", TRUE);
	            $password = MD5($this->input->post('password', TRUE));
	            
	            $checking = $this->m_user->check_login('user_account', array('username' => $username), array('password' => $password));
	            
	            if ($checking != FALSE) {
	                foreach ($checking as $apps) {
	                    $session_data = array(
	                        'user_id'   => $apps->id_user,
	                        'user_name' => $apps->username,
	                        'user_pass' => $apps->password,
	                    );
	                    $this->session->set_userdata($session_data);
	                    redirect(base_url());
                	}
	            } else {
	                $data['message'] = $this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Username atau Password Salah!</div>');
	                redirect('login');
	            }
	        } else {
	        	$data['message'] = $this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Tidak Dapat Melakukan Login!</div>');
	            redirect('login');
        	}
    	}
	}
	
	public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function laporan_jalan_admin($jid){
		$this->load->model('m_user');
		$data['jalan'] = $this->m_user->tampil_data();
		$data['aduan'] = $this->m_user->getAllLaporan($jid);
		$data['message'] = $this->session->flashdata();
		$this->load->view('laporan_jalan_admin', $data);
	}

	public function laporan_masuk()
	{
		$data['laporan'] = $this->m_user->getLaporan();
		$data['message'] = $this->session->flashdata();
		$this->load->view('laporan_masuk', $data);
	}

	public function set_status($lapid, $status)
	{
		$data['lap'] = $this->m_user->set_status($lapid, $status);
        if ($data == TRUE && $status == 'active') {
        	$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil mempublikasikan aduan!</div>');
        } else if($data == TRUE && $status == 'nonactive'){
        	$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil Menghapus aduan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus aduan!</div>');
        }
        redirect('c_admin/laporan_masuk');
	}

	public function hapusLaporan($lapid,$jid) {
        $data['lap'] = $this->m_user->hapus_laporan($lapid);
        if ($data == TRUE) {
        	$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil Menghapus aduan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus aduan!</div>');
        }
        redirect('c_admin/laporan_jalan_admin/'.$jid);
    }

	public function data_jalan_admin($jid){
		$data['jln_jalan'] = $this->m_user->tampil_data();
		$data['jalan'] = $this->m_user->getJalan($jid);
		$data['fungsi'] = $this->m_user->cariFungsi($jid);
		$data['riwayat'] = $this->m_user->getRiwayat($jid);
		$data['message'] = $this->session->flashdata();
		$data['photo'] = $this->m_user->getFoto($jid);
		$this->load->view('data_jalan_admin',$data);
	}

	public function submit_balasan($jid){
		$this->form_validation->set_rules('balasan', 'balasan', 'required');
		$run = $this->form_validation->run();
		if ($run) {
			$data = array(
				'lapid' => $this->input->post('lapid'),
				'id_user' => $this->input->post('idUser'),
				'balasan' => $this->input->post('balasan'),
				'foto' => $this->uploadFile()
			);

			if ($this->m_user->tambahBalasan($data) == TRUE) {
				$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil membalas aduan!</div>');
			}
			else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Terjadi kesalahan pada database</div>');
			}
		}
		else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Balasan anda kosong</div>');
		}
		redirect('c_admin/laporan_jalan_admin/'.$jid);
	}

	public function hapus_balasan($idbalas, $jid)
	{
		if ($this->m_user->delBalasan($idbalas)) {
			$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil Menghapus Balasan!</div>');
		}
		else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Tidak Bisa Menghapus Balasan</div>');
		}
		redirect('c_admin/laporan_jalan_admin/'.$jid);
	}

	public function edit_balasan($jid){
		$this->form_validation->set_rules('edit_balasan', 'edit_balasan', 'required');
		$run = $this->form_validation->run();
		if ($run) {
			$data = array(
				'idbalas' => $this->input->post('edit_idbalas'),
				'lapid' => $this->input->post('edit_lapid'),
				'id_user' => $this->input->post('edit_idUser'),
				'balasan' => $this->input->post('edit_balasan'),
			);

			if ($this->m_user->editBalasan($data) == TRUE) {
				$this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil mengubah balasan!</div>');
			}
			else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Terjadi kesalahan pada database</div>');
			}
		}
		else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Tidak bisa mengubah balasan</div>');
		}
		redirect('c_admin/laporan_jalan_admin/'.$jid);
	}

	public function uploadFile() {
        $upload = $this->m_user->upload();
        if($upload['result'] == "success"){
            return $upload['file']['file_name'];
        } else { 
            return null;
        }
    }
}

?>