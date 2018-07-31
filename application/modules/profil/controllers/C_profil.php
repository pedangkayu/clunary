<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_profil extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');

		//load model
		$this->load->model('m_profil');
		$this->load->model('user_management/m_karyawan');
		$this->load->model('user_management/m_user');
	}

	public function index()
	{
		$data = array();
		$karyawan_id = $this->session->userdata(base_url().'KARYAWAN_ID');
		$user_id = $this->session->userdata(base_url().'USER_ID');
		$filter = array('karyawan_id' => $karyawan_id);
		$data['karyawan'] = $this->m_karyawan->get_karyawan_where($filter);
		$data['user'] = $this->m_user->get_user_where(array('user_id' => $user_id));

		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_profil', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function change_pass()
	{
		$user_id = $this->session->userdata(base_url().'USER_ID');
		$pass_lama = $this->input->post('pass_lama');
		$pass_baru = $this->input->post('pass_baru');
		$pass_baru2 = $this->input->post('pass_baru2');

		if($pass_baru!=$pass_baru2){
			$result = array('stat' => false, 'pesan' => 'Ulangi password baru Anda.');
		}else{
			$cek_password = $this->m_user->get_user_where(array('user_id' => $user_id, 'user_password' => md5($pass_lama)));
			if($cek_password->num_rows()==0){
				$result = array('stat' => false, 'pesan' => 'Password Anda salah.');
			}else{
				$result['stat'] = $this->m_user->edit_user(array('user_id' => $user_id), array('user_password' => md5($pass_baru)));
				if($result['stat']){
					$result['url'] = site_url().'/front_office/c_login/logout';
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function save_profil()
	{
		$karyawan_id = $this->input->post('karyawan_id');
		$karyawan_tlp = $this->input->post('karyawan_tlp');
		$karyawan_email = $this->input->post('karyawan_email');
		$karyawan_alamat = $this->input->post('karyawan_alamat');

		$data = array('karyawan_tlp' => $karyawan_tlp,
					'karyawan_email' => $karyawan_email,
					'karyawan_alamat' => $karyawan_alamat);
		$result = $this->m_karyawan->update_karyawan_wp(array('karyawan_id' => $karyawan_id), $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_profil.php */
/* Location: ./application/modules/profil/controllers/C_profil.php */