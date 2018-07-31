<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_pindahbuku extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'keuangan/c_pindahbuku');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_pindahbuku');

		//session menu
		$url = array('url' => 'keuangan/c_pindahbuku', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_pindahbuku', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_pindahbuku->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode']             = 'add';
		$data['param_coa_ledger'] = $this->m_base->get_data('parameter_coa_ledger', array('stat_aktif' => 1));
		$data['pegawai']          = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$this->load->view('v_pindahbuku_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$id_log_coa_ledger = $this->input->get('id_pindahbuku');
		$data['mode'] = 'edit';
		$data['param_coa_ledger'] = $this->m_base->get_data('parameter_coa_ledger', array('stat_aktif' => 1));
		$data['pegawai']          = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$data['pindahbuku'] = $this->m_base->get_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->load->view('v_pindahbuku_form', $data, FALSE);
	}

	public function insert()
	{
		$datetime_sekarang = date('Y-m-d H:i:s');
		$kode_pegawai      = $this->session->userdata(base_url().'kode_pegawai');
		$date_pindahbuku   = str_replace('-','',$this->input->post('date_pindahbuku'));
		$kode_eksekutor    = $this->input->post('kode_eksekutor');
		$source_reg        = $this->input->post('source_reg');
		$destination_reg   = $this->input->post('destination_reg');
		$nominal_reg       = $this->input->post('nominal_reg');
		$selisih           = $this->input->post('selisih');
		$catatan           = $this->input->post('catatan');

		if(!is_numeric($nominal_reg) || !is_numeric($selisih)){
			$result['stat'] = false;
			$result['pesan'] = 'Nominal dan selisih harus angka, gunakan titik sebagai separator.';
		}elseif($source_reg==$destination_reg){
			$result['stat'] = false;
			$result['pesan'] = 'Sumber dan Tujuan tidak boleh sama.';
		}else{
			$data = array(
						'date_pindahbuku' => date('Y-m-d H:i', strtotime($date_pindahbuku)),
						'date_confirmed'  => $datetime_sekarang,
						'kode_eksekutor'  => $kode_eksekutor,
						'kode_pegawai'    => $kode_pegawai,
						'source_reg'      => $source_reg,
						'destination_reg' => $destination_reg,
						'nominal_reg'     => $nominal_reg,
						'selisih'         => $selisih,
						'catatan'         => $catatan,
				);
			$result = $this->m_base->insert_data('log_coa_ledger', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id                = $this->input->post('id');
		$datetime_sekarang = date('Y-m-d H:i:s');
		$kode_pegawai      = $this->session->userdata(base_url().'kode_pegawai');
		$date_pindahbuku   = str_replace('-','',$this->input->post('date_pindahbuku'));
		$kode_eksekutor    = $this->input->post('kode_eksekutor');
		$source_reg        = $this->input->post('source_reg');
		$destination_reg   = $this->input->post('destination_reg');
		$nominal_reg       = $this->input->post('nominal_reg');
		$selisih           = $this->input->post('selisih');
		$catatan           = $this->input->post('catatan');

		if(!is_numeric($nominal_reg) || !is_numeric($selisih)){
			$result['stat']  = false;
			$result['pesan'] = 'Nominal dan selisih harus angka, gunakan titik sebagai separator.';
		}elseif($source_reg==$destination_reg){
			$result['stat']  = false;
			$result['pesan'] = 'Sumber dan Tujuan tidak boleh sama.';
		}else{
			$data = array(
						'date_pindahbuku' => date('Y-m-d H:i', strtotime($date_pindahbuku)),
						'date_confirmed'  => $datetime_sekarang,
						'kode_eksekutor'  => $kode_eksekutor,
						'kode_pegawai'    => $kode_pegawai,
						'source_reg'      => $source_reg,
						'destination_reg' => $destination_reg,
						'nominal_reg'     => $nominal_reg,
						'selisih'         => $selisih,
						'catatan'         => $catatan,
				);
			$result = $this->m_base->update_data('log_coa_ledger', $data, array('id_log_coa_ledger' => $id));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$id_log_coa_ledger = $this->input->get('id_log_coa_ledger');
		$result   = $this->m_base->update_data('log_coa_ledger', array('stat_aktif' => 0), array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function export()
	{
		$jenis_laporan = $this->input->get('jenis_laporan');
		$tgl_mulai     = $this->input->get("tgl_mulai");
		$tgl_sampai    = $this->input->get("tgl_sampai");

		$data['jenis_laporan'] = $jenis_laporan;
		if($jenis_laporan==1){ //harian
	        $query = "
	                select
	                *
	                from v_pindahbuku where stat_aktif=1
	        ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(date_pindahbuku) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= "order by date_pindahbuku asc ";

		    $data['pindahbuku'] = $this->db->query($query);
		    $this->load->view('v_excel_pindahbuku', $data, FALSE);
		}elseif($jenis_laporan==2){
			$bulan_mulai = date('Y-m', strtotime($tgl_mulai));
			$bulan_sampai = date('Y-m', strtotime($tgl_sampai));
			$query = "
	                SELECT
	                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
	                    sum(saldo_system) AS total_system,
	                    sum(saldo_akhir) AS total_real,
	                    sum(selisih) AS total_selisih
	                FROM
	                    data_audit
	                WHERE
	                    data_audit.stat_audit = 2  
	                	AND
						date_format(date_submit, '%Y-%m') BETWEEN '".$bulan_mulai."' AND '".$bulan_sampai."'
					GROUP BY
						date_format(date_submit, '%Y-%m')
					ORDER BY
						date_submit ASC
	        ";

			$data['pendapatan'] = $this->db->query($query);
		    $this->load->view('v_excel_pendapatan', $data, FALSE);
		    // $data_detail = modules::run('keuangan/c_pendapatan/get_data_pendapatan_detail_bulanan', '2016-03');
		}

	}
}

/* End of file C_pindahbuku.php */
/* Location: ./application/modules/pindahbuku/controllers/C_pindahbuku.php */