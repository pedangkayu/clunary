<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_menu extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_menu');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_menu');

		//session menu
		$url = array('url' => 'master/c_menu', 'menu_parent' => 'mastermenu');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_menu', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_menu->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_bahanmenu()
	{
		$records = $this->m_menu->get_bahanmenu();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['bahan'] = $this->db->query("select * from data_bahan where id_coa not in (17) and stat_aktif=1"); //all bahan selain BHP
		$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(''), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
		$data['perusahaan'] = $this->m_base->get_data('parameter_perusahaan', array(''), array('nama_kolom' => 'id_perusahaan', 'order' => 'asc'));
		$this->load->view('v_menu_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$kode_menu = $this->input->get('kode_menu');
		$data['mode'] = 'edit';
		$data['bahan'] = $this->db->query("select * from data_bahan where id_coa not in (17) and stat_aktif=1"); //all bahan selain BHP
		$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(''), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
		$data['perusahaan'] = $this->m_base->get_data('parameter_perusahaan', array(''), array('nama_kolom' => 'id_perusahaan', 'order' => 'asc'));
		$data['menu'] = $this->m_base->get_data('v_menu', array('kode_menu' => $kode_menu));
		$this->load->view('v_menu_form', $data, FALSE);
	}

	public function update()
	{
		$kode_menu     = $this->input->post('kode_menu');
		$id_perusahaan = $this->input->post('id_perusahaan');
		$kode_kategori = $this->input->post('kode_kategori');
		$nama_menu     = $this->input->post('nama_menu');
		$alias_menu    = $this->input->post('alias_menu');
		$deskripsi     = $this->input->post('deskripsi');
		$harga         = $this->input->post('harga');
		$discount      = $this->input->post('discount');
		$status_menu   = ($this->input->post('status_menu')=='on') ? 0 : 1;

		$data_menu = $this->m_base->get_data('data_menu', array('kode_menu' => $kode_menu))->row();
		$data_log_harga_menu = array();
		if($data_menu->harga != '' && $data_menu->harga != $harga){
			// insert log_harga_menu
			
		}

		$data = array(
					'id_perusahaan' => $id_perusahaan,
					'kode_kategori' => $kode_kategori,
					'nama_menu'     => $nama_menu,
					'alias_menu'    => $alias_menu,
					'deskripsi'     => $deskripsi,
					'harga'         => $harga,
					'discount'      => $discount,
					'flag_hapus'    => $status_menu,
			);
		$result = $this->m_base->update_data('data_menu', $data, array('kode_menu' => $kode_menu));
		if($result['stat']){
			$datetime_sekarang = date('Y-m-d H:i:s');
			if($data_menu->harga != '' && $data_menu->harga != $harga){
				$data_log_harga_menu = array(
											'tgl_update' => $datetime_sekarang,
											'kode_menu' => $kode_menu,
											'harga' => $harga,
											'kode_pegawai' => $this->session->userdata(base_url().'kode_pegawai'),
					);
				$insert_log_harga_menu = $this->m_base->insert_data('log_harga_menu', $data_log_harga_menu);
			}elseif($data_menu->harga == ''){
				$data_log_harga_menu = array(
											'tgl_update' => $datetime_sekarang,
											'kode_menu' => $kode_menu,
											'harga' => $harga,
											'kode_pegawai' => $this->session->userdata(base_url().'kode_pegawai'),
					);
				$insert_log_harga_menu = $this->m_base->insert_data('log_harga_menu', $data_log_harga_menu);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$kode_menu = $this->input->get('kode_menu');
		$result   = $this->m_base->update_data('data_menu', array('flag_aktif' => 0), array('kode_menu' => $kode_menu));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_permanent()
	{
		$kode_menu = $this->input->post('kode_menu');
		$menu = $this->m_base->get_data('data_menu', array('kode_menu' => $kode_menu))->row();
		if(!empty($menu->gambar_menu)){
			unlink('./uploads/menu/'.$menu->gambar_menu);
		}
		$result   = $this->m_base->delete_data('data_menu', array('kode_menu' => $kode_menu));
		$result   = $this->m_base->delete_data('data_bahanmenu', array('kode_menu' => $kode_menu));
		$hasil['stat'] = true;
		$this->output->set_content_type('application/json')->set_output(json_encode($hasil));
	}

	public function save_upload()
    {
    	$kode_menu = $this->input->post('kode_menu');
    	$file_name = $this->input->post('file_name');
        $data = array(
            'gambar_menu' => $file_name
        );
        if($kode_menu==0){
        	$result = $this->m_base->insert_data('data_menu', $data, true);
        }else{
        	$result = $this->m_base->update_data('data_menu', $data, array('kode_menu' => $kode_menu));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function insert_bahanmenu()
    {
		$kode_menu  = $this->input->post('kode_menu');
		$kode_bahan = $this->input->post('kode_bahan');
		$jumlah     = $this->input->post('jml_bahan');
    	$data = array(
					'kode_menu'  => $kode_menu,
					'kode_bahan' => $kode_bahan,
					'jumlah'     => $jumlah,
    				);
    	$result = $this->m_base->insert_data('data_bahanmenu', $data);
    	$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function delete_bahanmenu()
    {
    	$id_bahanmenu = $this->input->get('id_bahanmenu');
    	$result = $this->m_base->delete_data('data_bahanmenu', array('id_bahanmenu' => $id_bahanmenu));
    	$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function cek_bahanmenu()
    {
    	$kode_menu  = $this->input->post('kode_menu');
		$kode_bahan = $this->input->post('kode_bahan');
		$bahanmenu = $this->m_base->get_data('data_bahanmenu', array('kode_menu' => $kode_menu, 'kode_bahan' => $kode_bahan));
		$result['jml'] = $bahanmenu->num_rows();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function cek_komposisi()
    {
    	$kode_menu  = $this->input->post('kode_menu');
    	$bahanmenu = $this->m_base->get_data('data_bahanmenu', array('kode_menu' => $kode_menu));
		$result['jml'] = $bahanmenu->num_rows();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

/* End of file C_menu.php */
/* Location: ./application/modules/menu/controllers/C_menu.php */