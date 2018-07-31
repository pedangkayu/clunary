<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_inventorybahan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'transaksi/c_inventorybahan');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_inventorybahan');

		//session menu
		$url = array('url' => 'transaksi/c_inventorybahan', 'menu_parent' => 'transaksi');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_inventorybahan', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_inventorybahan->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_stock()
	{
		$records = $this->m_inventorybahan->get_stock();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['bahan'] = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['perubahan'] = $this->m_base->get_data('parameter_perubahan_stock');
		$this->load->view('v_inventorybahan_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$id = $this->input->get('id');
		$data['mode'] = 'edit';
		$data['bahan'] = $this->m_base->get_data('data_bahan', array('stat_aktif' => 1));
		$data['perubahan'] = $this->m_base->get_data('parameter_perubahan_stock');
		$data['inventorybahan'] = $this->m_base->get_data('data_bahan_stock', array('id' => $id));
		$data_inventory = $data['inventorybahan']->row();
		if($data_inventory->jenis_perubahan=='IN'){
			$data['log'] = $this->m_base->get_data('log_bahan_in', array('id_bahan_stock' => $id));
		}elseif($data_inventory->jenis_perubahan=='USE'){
			$data['log'] = $this->m_base->get_data('log_bahan_out_resto', array('id_bahan_stock' => $id));
		}
		$this->load->view('v_inventorybahan_form', $data, FALSE);
	}

	public function next_insert()
	{
		$datetime_sekarang = date('Y-m-d H:i:s');
		$jenis_perubahan = $this->input->post('jenis_perubahan');
		$id_bahan        = $this->input->post('id_bahan');
		$qty             = $this->input->post('qty');

		$data_bahan = $this->m_base->get_data('data_bahan', array('id_bahan' => $id_bahan))->row();

		if($jenis_perubahan != 'SUM'){
			$data = array(
						'jenis_perubahan' => $jenis_perubahan,
						'id_bahan'        => $id_bahan,
						'qty'             => $qty,
						'tgl_update'      => $datetime_sekarang,
						'harga'           => $data_bahan->harga_bahan,
				);
		}else{
			$get_sum = $this->db->query('select sum(qty) as jumlah from data_bahan_stock where id_bahan='.$id_bahan)->row();
			$delete_data = $this->m_base->delete_data('data_bahan_stock', array('id_bahan' => $id_bahan));
			$data = array(
						'jenis_perubahan' => $jenis_perubahan,
						'id_bahan'        => $id_bahan,
						'qty'             => $get_sum->jumlah,
						'tgl_update'      => $datetime_sekarang,
				);
		}
		
		$result = $this->m_base->insert_data('data_bahan_stock', $data, true);
		if($result['stat']){
			if($jenis_perubahan=='IN'){
				$in_use_to = $this->input->post('in_use_to');
				$data_log = array(
								'id_bahan_stock' => $result['last_id'], 
								'waktu' => $datetime_sekarang, 
								'kode_bahan' => $id_bahan, 
								'qty' => $qty, 
								'harga' => $data_bahan->harga_bahan, 
								'dari' => $in_use_to, 
								);
				$insert_log = $this->m_base->insert_data('log_bahan_in', $data_log);
			}elseif($jenis_perubahan=='USE'){
				$in_use_to = $this->input->post('in_use_to');
				$data_log = array(
								'id_bahan_stock' => $result['last_id'], 
								'waktu' => $datetime_sekarang, 
								'kode_bahan' => $id_bahan, 
								'qty' => $qty, 
								'harga' => $data_bahan->harga_bahan, 
								'out_to' => $in_use_to, 
								);
				$insert_log = $this->m_base->insert_data('log_bahan_out_resto', $data_log);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$jenis_perubahan = $this->input->post('jenis_perubahan');
		$qty             = $this->input->post('qty');

		if($jenis_perubahan=='IN'){
			if($qty<=0){
				$result['stat'] = false;
				$result['pesan'] = 'Jenis Perubahan "IN", Jumlah harus bernilai diatas 0.';
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}else{
				$this->next_insert();
			}
		}elseif(in_array($jenis_perubahan, array('USE', 'RET'))){
			if($qty>=0){
				$result['stat'] = false;
				$result['pesan'] = 'Jenis Perubahan "USE" atau "RET", Jumlah harus bernilai dibawah 0 (negatif).';
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}else{
				$this->next_insert();
			}
		}else{
			$this->next_insert();
		}
	}

	public function next_update()
	{
		$id             = $this->input->post('id');
		$datetime_sekarang = date('Y-m-d H:i:s');
		$jenis_perubahan = $this->input->post('jenis_perubahan');
		$id_bahan        = $this->input->post('id_bahan');
		$qty             = $this->input->post('qty');
		
		$data_bahan = $this->m_base->get_data('data_bahan', array('id_bahan' => $id_bahan))->row();

		$data = array(
					'jenis_perubahan' => $jenis_perubahan,
					'id_bahan'        => $id_bahan,
					'qty'             => $qty,
					'tgl_update'      => $datetime_sekarang,
			);
		
		$result = $this->m_base->update_data('data_bahan_stock', $data, array('id' => $id));
		if($result['stat']){
			if($jenis_perubahan=='IN'){
				$in_use_to = $this->input->post('in_use_to');
				$data_log = array(
								'waktu' => $datetime_sekarang, 
								'kode_bahan' => $id_bahan, 
								'qty' => $qty, 
								'harga' => $data_bahan->harga_bahan, 
								'dari' => $in_use_to, 
								);
				$update_log = $this->m_base->update_data('log_bahan_in', $data_log, array('id_bahan_stock' => $id));
			}elseif($jenis_perubahan=='USE'){
				$in_use_to = $this->input->post('in_use_to');
				$data_log = array(
								'waktu' => $datetime_sekarang, 
								'kode_bahan' => $id_bahan, 
								'qty' => $qty, 
								'harga' => $data_bahan->harga_bahan, 
								'out_to' => $in_use_to, 
								);
				$update_log = $this->m_base->update_data('log_bahan_out_resto', $data_log, array('id_bahan_stock' => $id));
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$jenis_perubahan = $this->input->post('jenis_perubahan');
		$qty             = $this->input->post('qty');

		if($jenis_perubahan=='IN'){
			if($qty<=0){
				$result['stat'] = false;
				$result['pesan'] = 'Jenis Perubahan "IN", Jumlah harus bernilai diatas 0.';
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}else{
				$this->next_update();
			}
		}elseif(in_array($jenis_perubahan, array('USE', 'RET'))){
			if($qty>=0){
				$result['stat'] = false;
				$result['pesan'] = 'Jenis Perubahan "USE" atau "RET", Jumlah harus bernilai dibawah 0 (negatif).';
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}else{
				$this->next_update();
			}
		}else{
			$this->next_update();
		}
	}

	public function delete()
	{
		$kode_meja = $this->input->get('kode_meja');
		$result = $this->m_base->update_data('data_meja', array('stat_meja' => 0), array('kode_meja' => $kode_meja));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function export() {
		$mode = $this->input->get('mode');
		if($mode=='unduh_transaksi'){
	        $tgl_mulai = $this->input->get("tgl_mulai");
	        $tgl_sampai = $this->input->get("tgl_sampai");

	        $query = "select * from v_transaksibahanstock ";

		    if($tgl_mulai!='' || $tgl_sampai!=''){
		      $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
		      $query .= " (DATE(tgl_update) between '".$tgl_mulai."' and '".$tgl_sampai."') ";
		    }
		    $query .= "order by tgl_update desc ";
		    $data['inventorybahan'] = $this->db->query($query);	
		    $this->load->view('v_excel_transaksibahanstock', $data, FALSE);
		}elseif($mode=='unduh_stock'){
			$filterstatus = $this->input->get('filterstatus');
			$query = "select * from v_bahanstock ";

			if ($filterstatus!='all' && !empty($filterstatus)) {
	            if($filterstatus=='kurang'){
	                $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
	                $query .= " jml_stock <= minimum_stock_alert ";
	            }elseif($filterstatus=='aman'){
	                $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
	                $query .= " jml_stock > minimum_stock_alert ";
	            }
	        }

			$data['bahanstock'] = $this->db->query($query);	
		    $this->load->view('v_excel_bahanstock', $data, FALSE);
		}
	}
}

/* End of file C_meja.php */
/* Location: ./application/modules/meja/controllers/C_meja.php */