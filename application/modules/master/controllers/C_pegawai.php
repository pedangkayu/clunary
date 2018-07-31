<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_pegawai extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_pegawai');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_pegawai');

		//session menu
		$url = array('url' => 'master/c_pegawai', 'menu_parent' => 'mastersystem');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_pegawai', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_pegawai->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['agama'] = $this->m_base->get_data('parameter_agama');
		$data['role'] = $this->m_base->get_data('parameter_role');
		$this->load->view('v_pegawai_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data            = array();
		$kode_pegawai    = $this->input->get('kode_pegawai');
		$data['mode']    = 'edit';
		$data['agama']   = $this->m_base->get_data('parameter_agama');
		$data['role']    = $this->m_base->get_data('parameter_role');
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $kode_pegawai));
		// echo $this->db->last_query();
		$this->load->view('v_pegawai_form', $data, FALSE);
	}

	public function form_view()
	{
		$data            = array();
		$kode_pegawai    = $this->input->get('kode_pegawai');
		$data['mode']    = 'view';
		$data['agama']   = $this->m_base->get_data('parameter_agama');
		$data['role']    = $this->m_base->get_data('parameter_role');
		$data['pegawai'] = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $kode_pegawai));
		// echo $this->db->last_query();
		$this->load->view('v_pegawai_form', $data, FALSE);
	}

	public function cek_kode()
	{
		$datetime_sekarang = date('Y/m/d H:i:s');
		$kode_pegawai      = $this->input->post('kode_pegawai');
		$id                = $this->input->post('id_pegawai');
		// var_dump($kode_pegawai==$id);
		if($id=='0'){
			$cek = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $kode_pegawai));
			if($cek->num_rows()>0){
				$result['stat']  = false;
				$result['pesan'] = 'Kode Pegawai tersebut sudah ada, silahkan ganti dengan Kode yang lain.';
			}else{
				$insert            = $this->m_base->insert_data('data_pegawai', array('kode_pegawai' => $kode_pegawai, 'dibuat_pada' => $datetime_sekarang));
				$result['stat']    = true;
				$result['pesan']   = 'Kode Pegawai tersebut dapat dipakai. Silahkan lanjutkan melengkapi Form.';
				$result['last_id'] = $kode_pegawai;
			}
		}else{
			if($id==$kode_pegawai){
				$result['stat']    = true;
				$result['pesan']   = 'Kode Pegawai tersebut dapat dipakai. Silahkan lanjutkan melengkapi Form.';
				$result['last_id'] = $kode_pegawai;
			}else{
				$cek = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $kode_pegawai));
				if($cek->num_rows()>0){
					$result['stat']  = false;
					$result['pesan'] = 'Kode Pegawai tersebut sudah ada, silahkan ganti dengan Kode yang lain.';
				}else{
					$update            = $this->m_base->update_data('data_pegawai', array('kode_pegawai' => $kode_pegawai), array('kode_pegawai' => $id));
					$result['stat']    = true;
					$result['pesan']   = 'Kode Pegawai tersebut dapat dipakai. Silahkan lanjutkan melengkapi Form.';
					$result['last_id'] = $kode_pegawai;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id             = $this->input->post('id_pegawai');
		$kode_pegawai   = $this->input->post('kode_pegawai');
		$password       = $this->input->post('password');
		$nama_lengkap   = $this->input->post('nama_lengkap');
		$nama_panggilan = $this->input->post('nama_panggilan');
		$tempat_lahir   = $this->input->post('tempat_lahir');
		$tanggal_lahir  = $this->input->post('tanggal_lahir');
		$gender         = $this->input->post('gender');
		$agama          = $this->input->post('agama');
		$telp1          = $this->input->post('telp1');
		$alamat         = $this->input->post('alamat');
		$mulai_bekerja  = $this->input->post('mulai_bekerja');
		$catatan        = $this->input->post('catatan');
		$jabatan        = $this->input->post('jabatan');
		$kode_role      = $this->input->post('kode_role');
		$data = array(
					'kode_pegawai'   => $kode_pegawai,
					'password'       => $password,
					'nama_lengkap'   => $nama_lengkap,
					'nama_panggilan' => $nama_panggilan,
					'tempat_lahir'   => $tempat_lahir,
					'tanggal_lahir'  => date('Y-m-d', strtotime($tanggal_lahir)),
					'gender'         => $gender,
					'agama'          => $agama,
					'telp1'          => $telp1,
					'alamat'         => $alamat,
					'mulai_bekerja'  => date('Y-m-d', strtotime($mulai_bekerja)),
					'catatan'        => $catatan,
					'kode_role'      => $kode_role,
					'jabatan'        => $jabatan,
			);

		if($id==$kode_pegawai){
			$result = $this->m_base->update_data('data_pegawai', $data, array('kode_pegawai' => $id));
		}else{
			$cek = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $kode_pegawai));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = 'Maaf, Kode pegawai tersebut sudah ada.';
			}else{
				$result = $this->m_base->update_data('data_pegawai', $data, array('kode_pegawai' => $id));
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$kode_pegawai = $this->input->get('kode_pegawai');
		$result = $this->m_base->update_data('data_pegawai', array('akt_stat' => 0), array('kode_pegawai' => $kode_pegawai));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function save_upload()
	{
		$id = $this->input->post('id_pegawai');
		$file_name = $this->input->post('file_name');
        $data = array(
            'foto' => $file_name
        );
        $result = $this->m_base->update_data('data_pegawai', $data, array('kode_pegawai' => $id));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_permanent()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$pegawai = $this->m_base->get_data('data_pegawai', array('kode_pegawai' => $id_pegawai))->row();
		if($pegawai->foto != ''){
			unlink('./uploads/pegawai/'.$pegawai->foto);
		}
		$result = $this->m_base->delete_data('data_pegawai', array('kode_pegawai' => $id_pegawai));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_pegawai.php */
/* Location: ./application/modules/pegawai/controllers/C_pegawai.php */