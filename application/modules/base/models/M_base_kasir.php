<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_base_kasir extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->model('m_base');
	}

	function getdata1dan2(){
		//echo "ini model get data";
		$get = $this->db->query('select * from data_pemesanan where status_pemesanan in (1,2,3) order by status_pemesanan desc');
		return $get->result_array();
	}
	
	function getdata4(){
		//echo "ini model get data";
		$get = $this->db->query('select * from data_pemesanan where status_pemesanan ="3"');
		return $get->result_array();
	}

	function getpayed(){
		//echo "ini model get data";
		$get = $this->db->query('select * from data_pemesanan where status_pemesanan ="4" and join_parent is null');
		return $get->result_array();
	}

	public function is_open_audit()
	{
		$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
		$cek = $this->m_base->get_data('data_audit', array('kode_pegawai' => $kode_pegawai, 'stat_audit' => 1));
		if($cek->num_rows()==0){
			return false;
		}else{
			return true;
		}
	}
}

/* End of file M_base_kasir.php */
/* Location: ./application/modules/base/models/M_base_kasir.php */