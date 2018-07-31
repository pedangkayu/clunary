<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_base extends MX_Controller {
	var $targetPath = './uploads/';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_base');
	}

	public function index()
	{
		$data = array();
		$this->load->view('v_base', $data, FALSE);
	}

	public function cek_akses($url_menu)
	{
		$kode_role = $this->session->userdata(base_url().'kode_role');
		$filter = array(
						'kode_role' => $kode_role,
						'url_menu' => $url_menu,
						'stat_aktif' => 1,
						);
		$cek = $this->m_base->get_data('data_akses_menu', $filter);
		// var_dump($filter);
		if($cek->num_rows()==0){
			redirect('404');
		}
	}

	public function create_session($url)
	{
		$array = array(
			base_url().'url' => $url['url'],
			base_url().'menu_parent' => $url['menu_parent'],
		);
		
		$this->session->set_userdata( $array );
	}

	function upload_img()
    {
    	$tipeupload = $this->input->post('tipeupload');
    	$foto_awal = $this->input->post('foto_awal');
    	$uploadid = 'menu/';
    	$jml_upload_dir = strlen(base_url().'uploads/'.$uploadid);
    	

        $this->targetPath = $this->targetPath.$uploadid;
        if (!is_dir($this->targetPath)) {
            mkdir($this->targetPath, 0755, TRUE);
        }
        if ($tipeupload == 'manual') {
	        $config['upload_path'] = $this->targetPath;
	        $config['allowed_types'] = '*';
	        $config['max_size'] = '5000';


	        $this->load->library('upload');
	        $this->upload->initialize($config);

	        
	        if (!$this->upload->do_upload('cover')) {
	            $error = array('error' => $this->upload->display_errors());
	            $result = array(
	                'stats' => false,
	                'data' => $error
	            );
	        } else {
	            $upload_data = $this->upload->data();
	            $targetFile = $upload_data['full_path'];
	            $result = array(
	                'stats' => true,
	                'data' => $upload_data
	            );
	            if(!empty($foto_awal)){
        		 	$foto_awal = substr($foto_awal, $jml_upload_dir);
        		 	if($foto_awal!='no-image.jpg'){
        		 		unlink($this->targetPath.'/'.$foto_awal);
        		 	}
        		}
	        }
        } 
        $this->output->set_content_type('application/json')->set_output(json_encode($result));    
    }

    function upload_logo()
    {
    	$tipeupload = $this->input->post('tipeupload');
    	$foto_awal = $this->input->post('foto_awal');
    	$uploadid = 'system/';
    	$jml_upload_dir = strlen(base_url().'uploads/'.$uploadid);
        $this->targetPath = $this->targetPath.$uploadid;
        if (!is_dir($this->targetPath)) {
            mkdir($this->targetPath, 0755, TRUE);
        }
        if ($tipeupload == 'manual') {
	        $config['upload_path'] = $this->targetPath;
	        $config['allowed_types'] = '*';
	        $config['max_size'] = '5000';


	        $this->load->library('upload');
	        $this->upload->initialize($config);

	        
	        if (!$this->upload->do_upload('cover')) {
	            $error = array('error' => $this->upload->display_errors());
	            $result = array(
	                'stats' => false,
	                'data' => $error
	            );
	        } else {
	            $upload_data = $this->upload->data();
	            $targetFile = $upload_data['full_path'];
	            $result = array(
	                'stats' => true,
	                'data' => $upload_data
	            );
	            if(!empty($foto_awal)){
        		 	$foto_awal = substr($foto_awal, $jml_upload_dir); //41
        		 	if($foto_awal!='avatar.png'){
        		 		unlink($this->targetPath.'/'.$foto_awal);
        		 	}
        		}
	        }
        } 
        $this->output->set_content_type('application/json')->set_output(json_encode($result));    
    }

    function upload_pegawai()
    {
    	$tipeupload = $this->input->post('tipeupload');
    	$foto_awal = $this->input->post('foto_awal');
    	$uploadid = 'pegawai/';
    	$jml_upload_dir = strlen(base_url().'uploads/'.$uploadid);
        $this->targetPath = $this->targetPath.$uploadid;
        if (!is_dir($this->targetPath)) {
            mkdir($this->targetPath, 0755, TRUE);
        }
        if ($tipeupload == 'manual') {
	        $config['upload_path'] = $this->targetPath;
	        $config['allowed_types'] = '*';
	        $config['max_size'] = '5000';


	        $this->load->library('upload');
	        $this->upload->initialize($config);

	        
	        if (!$this->upload->do_upload('cover')) {
	            $error = array('error' => $this->upload->display_errors());
	            $result = array(
	                'stats' => false,
	                'data' => $error
	            );
	        } else {
	            $upload_data = $this->upload->data();
	            $targetFile = $upload_data['full_path'];
	            $result = array(
	                'stats' => true,
	                'data' => $upload_data
	            );
	            if(!empty($foto_awal)){
        		 	$foto_awal = substr($foto_awal, $jml_upload_dir); //43
        		 	if($foto_awal!='avatar.png'){
        		 		unlink($this->targetPath.'/'.$foto_awal);
        		 	}
        		}
	        }
        } 
        $this->output->set_content_type('application/json')->set_output(json_encode($result));    
    }
}

/* End of file c_base.php */
/* Location: ./application/modules/base/controllers/c_base.php */