<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_audit extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_audit');

		//session menu
		$url = array('url' => 'keuangan/c_audit', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_audit', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_audit->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_auditdetail()
	{
		$records = $this->m_audit->get_auditdetail();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_auditdetailpesanan()
	{
		$records = $this->m_audit->get_auditdetailpesanan();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_view()
	{
		$id_audit = $this->input->get('id');
		$data['mode'] = 'view';
		$data['audit'] = $this->m_base->get_data('v_audit', array('id_audit' => $id_audit));
		$detail_audit = $this->m_base->get_data('data_audit_detail', array('id_audit' => $id_audit));
		$data['detail_audit'] = $detail_audit;

		$total_transaksi = 0;
		foreach ($detail_audit->result() as $r) {
			$total_transaksi += $r->total_trans;
		}
		$data['total_transaksi'] = $total_transaksi;
		$this->load->view('v_audit_form', $data, FALSE);
	}

	public function delete()
	{
		$id_audit = $this->input->get('id');
		$result = $this->m_base->update_data('data_audit', array('stat_audit' => 0), array('id_audit' => $id_audit));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function form_edit()
	{
		$id_audit = $this->input->get('id');
		$data['mode'] = 'edit';
		$data['audit'] = $this->m_base->get_data('v_audit', array('id_audit' => $id_audit));
		$detail_audit = $this->m_base->get_data('data_audit_detail', array('id_audit' => $id_audit));
		$data['detail_audit'] = $detail_audit;

		$total_transaksi = 0;
		foreach ($detail_audit->result() as $r) {
			$total_transaksi += $r->total_trans;
		}
		$data['total_transaksi'] = $total_transaksi;
		$this->load->view('v_audit_form', $data, FALSE);
	}

	public function update()
	{
		$id_audit     = $this->input->post('id_audit');
		$saldo_awal   = $this->input->post('saldo_awal');
		$saldo_system = $this->input->post('saldo_system');
		$saldo_akhir  = $this->input->post('saldo_akhir');
		$selisih      = $this->input->post('selisih');
		$data = array(
					'saldo_awal' => $saldo_awal,
					'saldo_system' => $saldo_system,
					'saldo_akhir' => $saldo_akhir,
					'selisih' => $selisih,
					);
		$result = $this->m_base->update_data('data_audit', $data, array('id_audit' => $id_audit));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function export()
	{
		$jenis_laporan = $this->input->get('jenis_laporan');
		$tgl_mulai     = $this->input->get("tgl_mulai");
		$tgl_sampai    = $this->input->get("tgl_sampai");

		$data['jenis_laporan'] = $jenis_laporan;
		if($jenis_laporan==1){ //harian
	        $query = "select * from v_audit ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(date_submit) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= "order by date_submit asc ";
		    $data['audit'] = $this->db->query($query);
		    $this->load->view('v_excel_audit', $data, FALSE);
		}elseif($jenis_laporan==2){
			$bulan_mulai = date('Y-m', strtotime($tgl_mulai));
			$bulan_sampai = date('Y-m', strtotime($tgl_sampai));
			$query = "
				SELECT
					date_format(date_submit, '%Y-%m') AS date_submit,
					sum(saldo_system) AS total_system,
					sum(saldo_akhir) AS total_akhir,
					sum(selisih) AS total_selisih
				FROM
					data_audit
				WHERE
					stat_audit = 2
					AND
					date_format(date_submit, '%Y-%m') BETWEEN '".$bulan_mulai."' AND '".$bulan_sampai."'
				GROUP BY
					date_format(date_submit, '%Y-%m')
				ORDER BY
					date_submit ASC
			";
			$data['audit'] = $this->db->query($query);
		    $this->load->view('v_excel_audit', $data, FALSE);
		    // $data_detail = modules::run('keuangan/c_audit/get_data_audit_detail_bulanan', '2016-03');
		}

	}

	public function get_data_audit_detail($id_audit='')
	{
		$data = $this->m_base->get_data('data_audit_detail', array('id_audit' => $id_audit));
		return $data;
	}

	public function get_data_audit_detail_bulanan($bulan='')
	{
		$query = "
				SELECT
					id_audit,
					date_format(date_submit, '%Y-%m') AS date_submit
				FROM
					data_audit
				WHERE
					stat_audit = 2
					AND
					date_format(date_submit, '%Y-%m') = '".$bulan."'
				ORDER BY
					date_submit ASC
			";
		$data_audit = $this->db->query($query);
		$ar_id_audit = array();
		foreach ($data_audit->result() as $r) {
			array_push($ar_id_audit, $r->id_audit);
		}

		$query = "
				SELECT
					payment_method,
					sum(jumlah_trans) as total_jumlah_trans,
					sum(total_trans) as total_trans
				FROM
					data_audit_detail
				WHERE
					id_audit in (".implode(',',$ar_id_audit).")
				GROUP BY
					payment_method
				ORDER BY
					payment_method ASC
			";
		return $this->db->query($query);
	}

}

/* End of file C_audit.php */
/* Location: ./application/modules/keuangan/controllers/C_audit.php */