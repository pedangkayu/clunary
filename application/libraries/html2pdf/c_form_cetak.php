<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_form_cetak extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_form_cetak');
		$this->load->model('m_public_function');
	}

	public function cetak($pk_id,$jenis,$orientasi)
	{
		$data_main['content_table']=$this->m_form_cetak->create_form($pk_id,$jenis);

		$data_main['size']="folio";
		$data_main['oriented']=$orientasi;
		// echo $data_main['content_table'];
		$this->load->view('pdf/v_main_pdf',$data_main);	
	}

	public function cetak_sk($pk_id)
	{
		$data_main['content_table']=$this->m_form_cetak->create_form_sk($pk_id);

		$data_main['size']=array(54, 85);
		$data_main['oriented']='P';
		// echo $data_main['content_table'];
		$this->load->view('pdf/v_main_pdf',$data_main);	
	}
}

/* End of file c_sk_pdf.php */
/* Location: ./application/controllers/c_sk_pdf.php */