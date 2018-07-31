<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 

class C_login extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('base/m_base');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata(base_url().'is_logged_in');
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
            redirect('front_office/c_login/login');    
        }

    }

    public function login()
    {
        $data = array();

        $this->load->view('v_login', $data, FALSE);
    }

    public function cek_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $filter = array(
                        'kode_pegawai' => $username,
                        'password'     => $password,
                        'akt_stat'     => 1,
                        );
        // cek
        $loginpegawai = $this->m_base->get_data('data_pegawai', $filter);
        if($loginpegawai->num_rows()>0){
            $pegawai = $loginpegawai->row();
            $array = array(
                base_url().'is_logged_in'   => true,
                base_url().'kode_pegawai'   => $pegawai->kode_pegawai,
                base_url().'kode_role'      => $pegawai->kode_role,
                base_url().'nama_lengkap'   => $pegawai->nama_lengkap,
                base_url().'nama_panggilan' => $pegawai->nama_panggilan,
                base_url().'jabatan'        => $pegawai->jabatan,
                base_url().'foto'           => $pegawai->foto,
            );
            $this->session->set_userdata( $array );
            // var_dump($pegawai->kode_role);

            if($pegawai->kode_role=='5' || $pegawai->kode_role=='4'){ // admin
                $output = array(
                            'stat' => true,
                            'pesan' => '',
                            'url'=> site_url('dashboard'), 
                );
            }elseif($pegawai->kode_role=='1'){ // kasir
                 $output = array(
                            'stat' => true,
                            'pesan' => '',
                            'url'=> site_url('order/0'), 
                );
            }elseif($pegawai->kode_role=='2'){ // waiter
                $output = array(
                            'stat' => true,
                            'pesan' => '',
                            'url'=> site_url('kasir'), 
                );
            }

        }else{
            $output = array(
                        'stat' => false,
                        'pesan' => 'Username dan Password tida ditemukan.',
            );
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function logout()
    {
        $this->session->sess_destroy(); 
        redirect(site_url());
    }
}

/* End of file C_login.php */
/* Location: ./application/modules/front_office/controllers/C_login.php */