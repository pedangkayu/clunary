<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/***
    * Sistem Manajemen Keamanan PJB
    *
    * Aplikasi Keamanan Pembangkit Jawa Bali
    *
    * @package     base
    * @type        Controller
    * @author      Kurniawan (awank@ts.co.id)
    * @kode        
    * @desc        
***/

class C_template extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

	public function main_view($data = array())
    {
        $a="";
        if(isset($data['stat'])){
            $a=$data['stat'];
        }
        $data_left['stat'] = $a;
        if (!isset($data['left_layout'])) {
            $data['left_layout']=  modules::run('base/c_template/left_main_view',$data_left);
        }
        $this->load->view('v_main_view', $data);
    }

    public function left_main_view($data=array())
    {    
        $data = array();
        
        $this->load->view('v_left', $data);
    }

    public function main_view_kasir($data = array())
    {
        $this->load->model('m_base_kasir');
        $is_open_audit = $this->m_base_kasir->is_open_audit();
        $get = $this->m_base_kasir->getdata1dan2();
        $get2 = $this->m_base_kasir->getdata4();
        $get3 = $this->m_base_kasir->getpayed();
        $data_menu = array (
            'is_open_audit' => $is_open_audit,
            'showtable'     => $get,
            'showtable4'    => $get2,
            'showpayed' => $get3
            );
        $data['menu']=  modules::run('base/c_template/menu_kasir',$data_menu);
        $this->load->view('v_main_view_kasir', $data);
    }

    public function menu_kasir($data = array())
    {
        
        $this->load->view('v_menu_kasir', $data);
    }

    public function main_view_waiter($data = array())
    {
        $a="";
        if(isset($data['stat'])){
            $a=$data['stat'];
        }
        $data_left['stat'] = $a;
        $this->load->view('v_main_view_waiter', $data);
    }

}

/* End of file C_template.php */
/* Location: ./application/modules/base/controllers/C_template.php */