<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_belanjabahan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'keuangan/c_belanjabahan');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_belanjabahan');

		//session menu
		$url = array('url' => 'keuangan/c_belanjabahan', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_belanjabahan', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_belanjabahan->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_logbelanja()
	{
		$records = $this->m_belanjabahan->get_logbelanja();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_item_log($value='')
	{
		$records = $this->m_belanjabahan->get_item_log();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data['mode']    = 'add';
		$data['bahan']   = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$this->load->view('v_logbelanja_form', $data, FALSE);
	}

	public function change_eksekutor()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$kode_eksekutor    = $this->input->post('kode_eksekutor');
		$kode_pegawai      = $this->session->userdata(base_url().'kode_pegawai');
		$data = array(
					'kode_eksekutor' => $kode_eksekutor,
					'kode_pegawai'   => $kode_pegawai,
					'destination_reg'     => 'Stock',
					'stat_aktif'     => 0,
					);
		if($id_log_coa_ledger==0){
			$insert                = $this->m_base->insert_data('log_coa_ledger', $data, true);
			$new_id_log_coa_ledger = $insert['last_id'];
		}else{
			$update                = $this->m_base->update_data('log_coa_ledger', $data, array('id_loig_coa_ledger' => $id_log_coa_ledger));
			$new_id_log_coa_ledger = $id_log_coa_ledger;
		}
		$result['stat']              = true;
		$result['new_id_log_coa_ledger'] = $new_id_log_coa_ledger;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function cek_bahan()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$id_bahan    = $this->input->post('id_bahan');
		$bahan_stock = $this->m_base->get_data('data_bahan_stock', array('id_log_coa_ledger' => $id_log_coa_ledger, 'id_bahan' => $id_bahan));
		$result['jml'] = $bahan_stock->num_rows();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert_item_log()
	{
		$id_log_coa_ledger   = $this->input->post('id_log_coa_ledger');
		$id_bahan            = $this->input->post('id_bahan');
		$harga               = $this->input->post('harga');
		$jml_bahan           = $this->input->post('jml_bahan');
		$harga_total_belanja = $harga*$jml_bahan;
		$data = array(
					'id_log_coa_ledger'   => $id_log_coa_ledger,
					'id_bahan'            => $id_bahan,
					'harga'               => $harga,
					'qty'                 => $jml_bahan,
					'harga_total_belanja' => $harga_total_belanja,
					'stat_log'            => 0,
					);
		$result = $this->m_base->insert_data('data_bahan_stock', $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_item_log()
	{
		$id = $this->input->get('id');
		$result = $this->m_base->delete_data('data_bahan_stock', array('id' => $id));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_permanent()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$result = $this->m_base->delete_data('data_bahan_stock', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$result = $this->m_base->delete_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_total_belanja_nominal()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		
		$result['total_belanja_nominal'] = $this->m_belanjabahan->get_total_belanja($id_log_coa_ledger);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function cek_item_log()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$item_log = $this->m_base->get_data('data_bahan_stock', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$log_coa_ledger = $this->m_base->get_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger))->row();
		$result['jml'] = $item_log->num_rows();
		$result['jml_item_belanja'] = $log_coa_ledger->jml_item_belanja;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$date_pindahbuku   = $this->input->post('date_pindahbuku');
		$kode_eksekutor    = $this->input->post('kode_eksekutor');
		$kode_pegawai      = $this->session->userdata(base_url().'kode_pegawai');
		$selisih           = $this->input->post('selisih');
		$catatan           = $this->input->post('catatan');
		if(!is_numeric($selisih)){
			$result['stat'] = false;
			$result['pesana'] = 'Selisih harus angka.';
		}else{
			$nominal_reg = $this->m_belanjabahan->get_total_belanja($id_log_coa_ledger);
			$data = array(
						'date_pindahbuku' => date('Y-m-d H:i:s', strtotime($date_pindahbuku)),
						'source_reg'      => 'Kas',
						'nominal_reg'     => $nominal_reg,
						'kode_eksekutor'  => $kode_eksekutor,
						'kode_pegawai'    => $kode_pegawai,
						'selisih'         => $selisih,
						'catatan'         => $catatan,
						);
			$result = $this->m_base->update_data('log_coa_ledger', $data, array('id_log_coa_ledger' => $id_log_coa_ledger));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function form_edit()
	{
		$id_log_coa_ledger = $this->input->get('id_log_coa_ledger');
		$data['mode']    = 'edit';
		$data['bahan']   = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$data['log_coa_ledger'] = $this->m_base->get_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->load->view('v_logbelanja_form', $data, FALSE);
	}

	public function form_view()
	{
		$id_log_coa_ledger = $this->input->get('id_log_coa_ledger');
		$data['mode'] = 'view';
		$data['bahan']   = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$data['log_coa_ledger'] = $this->m_base->get_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->load->view('v_logbelanja_form', $data, FALSE);
	}

	public function form_verifikasi()
	{
		$id_log_coa_ledger = $this->input->get('id_log_coa_ledger');
		$data['mode'] = 'verifikasi';
		$data['bahan']   = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('akt_stat' => 1));
		$data['log_coa_ledger'] = $this->m_base->get_data('log_coa_ledger', array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->load->view('v_logbelanja_form', $data, FALSE);
	}

	public function verifikasi()
	{
		$tgl_update        = date('Y-m-d H:i:s');
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$item_log          = $this->m_base->get_data('data_bahan_stock', array('id_log_coa_ledger' => $id_log_coa_ledger));
		foreach ($item_log->result() as $r) {
			$id_stock   = $r->id;
			$id_bahan   = $r->id_bahan;
			$qty        = $r->qty;
			$harga      = $r->harga;
			$data_bahan = $this->m_base->get_data('data_bahan', array('id_bahan' => $id_bahan))->row();
			$harga_awal = $data_bahan->harga_bahan;
			if($harga!=$harga_awal){
				$this->m_belanjabahan->update_harga_bahan($id_bahan, $harga);
			}
			$data = array(
						'stat_log'        => 1,
						'jenis_perubahan' => 'IN',
						'tgl_update'      => $tgl_update,
						);
			$update_data_bahan_stock = $this->m_base->update_data('data_bahan_stock', $data, array('id' => $id_stock));
			$data_log = array(
							'id_bahan_stock' => $id_stock,
							'waktu' => $tgl_update,
							'kode_bahan' => $id_bahan,
							'qty' => $qty,
							'harga' => $harga,
							'dari' => 'Log Belanja',
							);
			$insert_log_bahan_in = $this->m_base->insert_data('log_bahan_in', $data_log);
		}
		$data = array(
					'stat_aktif' => 1,
					'date_confirmed' => $tgl_update,
					'jml_item_belanja' => $item_log->num_rows(),
					);
		$update_log_coa_ledger = $this->m_base->update_data('log_coa_ledger', $data, array('id_log_coa_ledger' => $id_log_coa_ledger));
		$this->output->set_content_type('application/json')->set_output(json_encode($update_log_coa_ledger));
	}

	public function delete()
	{
		$id_log_coa_ledger = $this->input->post('id_log_coa_ledger');
		$result = $this->m_base->update_data('log_coa_ledger', array('stat_aktif' => 3), array('id_log_coa_ledger' => $id_log_coa_ledger));
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
	                SELECT
						p.id_bahan,
						nama_bahan,
						date_format(tgl_update, '%Y-%m-%d') AS tgl_update,
						qty,
						harga,
						harga*qty as total_harga
					FROM
						data_bahan_stock p
					JOIN data_bahan q ON (p.id_bahan = q.id_bahan)
					WHERE
						jenis_perubahan = 'IN'
	        ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(tgl_update) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= "order by tgl_update asc ";

		    $data['belanjabahan'] = $this->db->query($query);
		    $this->load->view('v_excel_belanjabahan', $data, FALSE);
		}elseif($jenis_laporan==2){
			$bulan_mulai = date('Y-m', strtotime($tgl_mulai));
			$bulan_sampai = date('Y-m', strtotime($tgl_sampai));
			$query = "
	                SELECT
	                    p.id_bahan,
						nama_bahan,
						date_format(tgl_update, '%Y-%m') AS tgl_update,
						sum(qty) as total_qty,
						sum(harga*qty) as total_harga
	                FROM
	                    data_bahan_stock p
					JOIN data_bahan q ON (p.id_bahan = q.id_bahan)
					WHERE
						jenis_perubahan = 'IN' 
						AND
						date_format(tgl_update, '%Y-%m') BETWEEN '".$bulan_mulai."' AND '".$bulan_sampai."' 
					GROUP BY
						date_format(tgl_update, '%Y-%m'), id_bahan
					ORDER BY
						tgl_update ASC
	        ";

			$data['belanjabahan'] = $this->db->query($query);
		    $this->load->view('v_excel_belanjabahan', $data, FALSE);
		    // $data_detail = modules::run('keuangan/c_belanjabahan/get_data_belanjabahan_detail_bulanan', '2016-03');
		}

	}
}

/* End of file C_belanjabahan.php */
/* Location: ./application/modules/keuangan/controllers/C_belanjabahan.php */