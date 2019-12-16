<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class C_user extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('m_user');
		$this->load->library('form_validation');
	}

	public function index(){
		$this->load->view('home');
	}

	public function info_jalan($jid){
		$this->load->model('m_user');
		$data['jalan'] = $this->m_user->getJalan($jid);
		$this->load->view('info_jalan', $data);
	}

	public function jalan_lengkap($jid){
		$this->load->model('m_user');
		$data['jalan'] = $this->m_user->getJalan($jid);
		$this->load->view('jalan_lengkap',$data);
	}

	public function form_laporan(){
		$this->load->helper('form');
		$message = $this->session->flashdata();
        $this->load->view('form_laporan', $message);
	}

	public function aduan(){
		$this->load->model('m_user');
		$data['aduan'] = $this->m_user->getAllLaporan();
		$this->load->view('aduan',$data);
	}

	public function data_jalan($jid){
		$data['jln_jalan'] = $this->m_user->tampil_data();
		$data['jalan'] = $this->m_user->getJalan($jid);
		$data['riwayat'] = $this->m_user->getRiwayat($jid);
		$data['photo'] = $this->m_user->getFoto($jid);
		// $temp[] = array();
		// $i = 1;
		// foreach ($this->m_user->fungsiJalan() as $key) {
		// 	$id = $key['jid'];
		// 	foreach ($this->m_user->cariFungsi($id)->result_array() as $keys) {
		// 		array_push($temp, $keys['data']);
		// 	}
		// 	$data['data'][] = $temp[$i];
		// 	$i++;
		// }
		$data['fungsi'] = $this->m_user->cariFungsi($jid);
		$this->load->view('data_jalan',$data);
	}

	public function laporan_jalan($jid){
		$this->load->model('m_user');
		$data['jalan'] = $this->m_user->tampil_data();
		$data['aduan'] = $this->m_user->getAllLaporan($jid);
		$this->load->view('laporan_jalan', $data);
	}
	
	public function view_grafik(){
		$temp[] = array();
		$i = 1;
		foreach ($this->m_user->getKecamatan() as $key) {
			$id = $key['kid'];
			foreach ($this->m_user->sumPanjang($id)->result_array() as $keys) {
				array_push($temp, $keys['total']);
			}
			$data['grafik2'][] = (float)$temp[$i];
			$i++;
		}

		foreach ($this->m_user->getJalanRusak()->result_array() as $key) {
			$data['grafik'][]=(float)$key['count(baik)'];
			$data['grafik'][]=(float)$key['count(sedang)'];
			$data['grafik'][]=(float)$key['count(rusak)'];
			$data['grafik'][]=(float)$key['count(rusakberat)'];
		}
		$this->load->view('view_grafik', $data);
	}

	public function login(){
		$data['message'] = $this->session->flashdata();
		$this->load->view('login', $data);
	}

	public function submit($jid){
		date_default_timezone_set("Asia/Jakarta");
        $this->form_validation->set_rules('nama', 'Name', 'required');
        $this->form_validation->set_rules('noHp', 'noHp', 'required');
        $this->form_validation->set_rules('titik', 'titik', 'required');
        $this->form_validation->set_rules('aduan', 'aduan', 'required');
        $run = $this->form_validation->run();
        if ($run) {
            $data = array(
                'jid' => $jid,
                'tanggal' => date('d M Y, H:i'),
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('noHp'),
                'titik' => $this->input->post('titik'),
                'aduan' => $this->input->post('aduan'),
                'foto' => $this->uploadFile(),
                'status' => NULL
            );
            $result = $this->m_user->laporanMasuk($data);
            if (!$result) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Terjadi kesalahan pada database</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success">Berhasil menambahkan aduan anda!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error! Data kurang lengkap</span>');
        }
        redirect('c_user/form_laporan/'.$jid);
        // var_dump($this->input->post());
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