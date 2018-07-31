<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pendapatan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'keuangan/c_pendapatan');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_pendapatan');

		//session menu
		$url = array('url' => 'keuangan/c_pendapatan', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_pendapatan', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_pendapatan->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_pendapatandetail()
	{
		$records = $this->m_pendapatan->get_pendapatandetail();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_pendapatanpesanan()
	{
		$records = $this->m_pendapatan->get_pendapatanpesanan();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function export()
	{
		$jenis_laporan = $this->input->get('jenis_laporan');
		$tgl_mulai     = $this->input->get("tgl_mulai");
		$tgl_sampai    = $this->input->get("tgl_sampai");

		$data['jenis_laporan'] = $jenis_laporan;
		if($jenis_laporan==1){ //harian
	        $query = "
	                SELECT
	                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
	                    sum(saldo_awal) AS saldo_awal,
	                    sum(saldo_system) AS saldo_system,
	                    sum(pendapatan_fonte) AS pendapatan_fonte,
	                    sum(diskon_fonte) AS diskon_fonte,
	                    sum(pendapatan_suteki) AS pendapatan_suteki,
	                    sum(diskon_suteki) AS diskon_suteki,
	                    sum(total_service) AS total_service
	                FROM
	                    data_audit
	                WHERE
	                    data_audit.stat_audit = 2  
	        ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(date_submit) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= " GROUP BY date_format(date_submit, '%Y-%m-%d') ";
		    $query .= "order by date_submit asc ";

		    $data['pendapatan'] = $this->db->query($query);
		    $this->load->view('v_excel_pendapatan', $data, FALSE);
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

	public function export2()
	{
		$jenis_laporan = $this->input->get('jenis_laporan');
		$tgl_mulai     = $this->input->get("tgl_mulai");
		$tgl_sampai    = $this->input->get("tgl_sampai");

		$data['jenis_laporan'] = $jenis_laporan;
		if($jenis_laporan==1){ //harian
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
	        ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(date_submit) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= " GROUP BY date_format(date_submit, '%Y-%m-%d') ";
		    $query .= "order by date_submit asc ";

		    $data['pendapatan'] = $this->db->query($query);
		    $this->load->view('v_excel_pendapatan', $data, FALSE);
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

	public function form_view()
	{
		$tgl_submit = trim($this->input->get('tgl_submit'));
		$data['mode'] = 'view';

		$data['pendapatan'] = $this->db->query("
								SELECT
				                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
				                    sum(saldo_system) AS total_system,
				                    sum(saldo_akhir) AS total_real,
				                    sum(selisih) AS total_selisih
				                FROM
				                    data_audit
				                WHERE
				                    date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and data_audit.stat_audit = 2
				                GROUP BY 
				                	date_format(date_submit, '%Y-%m-%d')
							");

		$data_audit = $this->db->query("
							select * from data_audit where date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and stat_audit=2 
						");
		$ar_audit = array();
		foreach ($data_audit->result() as $r) {
			array_push($ar_audit, $r->id_audit);
		}
		$str_ar_audit = implode(",", $ar_audit);
		$data['str_ar_audit'] = $str_ar_audit;

		$detail_audit = $this->db->query("select * from data_audit_detail where id_audit in ($str_ar_audit) ");

		$total_transaksi = 0;
		foreach ($detail_audit->result() as $r) {
			$total_transaksi += $r->total_trans;
		}
		$data['total_transaksi'] = $total_transaksi;
		$this->load->view('v_pendapatan_form', $data, FALSE);
	}

}

/* End of file C_pendapatan.php */
/* Location: ./application/modules/keuangan/controllers/C_pendapatan.php */