<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'models/m_base_my_model.php');
class C_mail extends MX_Controller {

    var $sender = 'inovasi@semenindonesia.com';

	function __construct()
    {
        parent::__construct();

    }
    
    function kirim_email($mail_from="inovasi@semenindonesia.com",$mail_to,$mail_subject,$mail_message)
    {
        if($this->config->item('site_send_mail')):

            if($this->config->item('server_mail') == 1){
                $config = Array(
                    'smtp_host' => 'webmail1.semenindonesia.com',
                );
            }else{
                $config = Array(
                   'protocol' => 'smtp',
                   'smtp_host' => 'ssl://smtp.gmail.com',
                   'smtp_port' => 465,
                   'smtp_user' => 'support@ts.co.id',
                   'smtp_pass' => 'Support123456',
               );
                $mail_to = "ali@ts.co.id";
               
               
            }
            
             
           
            
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            if($mail_to != ""){
                $this->email->to($mail_to);
                $this->email->from($mail_from);
                $this->email->subject($mail_subject);
                $this->email->message($mail_message);
                if ( ! $this->email->send())
                {
                    // Generate error
                    echo $this->email->print_debugger();
                }else{
                    echo $this->email->print_debugger();
                    
                }
            }
            
        endif;
    }
    public function tes($message="hi",$send_to="")
    {   
        //$this->mail_verif_need(2400);
        if (!empty($send_to)) {
            $send_to = urldecode($send_to);
        }else{
            $send_to="jarot@ts.co.id";
        }
        $mail_to=$send_to;
        $mail_subject="tes";
        $mail_message=$message;
        $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
    }

    // Done Implemented
    function mail_invite_for_team($tim_id=null,$user_id=null){
        //ambil data user untuk send mail to
        $this->db->where('USER_ID',$user_id);
        $data_user = $this->db->get('v_user');
        $row_user = $data_user->row();

        if($this->config->item('site_send_mail')):
            $w2 = array(
                'TEAM_ID'   => $tim_id,
            );
            $this->db->where($w2); 
            $this->db->from('v_team'); 
            $invite_tim = $this->db->get();
            $r_invite_tim = $invite_tim->row();
          
            $mail_to=  $row_user->MK_EMAIL;
            $mail_subject='Invite Anggota Tim';
            
            $mail_message ="Selamat Anda telah tergabung dalam tim ".$r_invite_tim->TEAM_NAME;
            $mail_message .="\nNama Tim\t: ".$r_invite_tim->TEAM_NAME;
            $mail_message .="\nCreator Tim\t: ".$r_invite_tim->EMPLOYEE_NAME;
            // $mail_message .="\nDeskripsi Tim\t: ".$r_invite_tim->TEAM_DES;
            $mail_message .="\nKeterangan lebih lanjut dapat mengakses Aplikasi Innovation Management System Semen Indonesia
                            \n(IMS-SI).";
 
            $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
        endif;
    }

    //Done Implemented
    function mail_user_create_inovasi($inovasi_id){
        if($this->config->item('site_send_mail')):
            //ambil data inovasi
            $this->db->select('INOVASI_ID,TEAM_ID,TEAM_NAME,INOVASI_TITLE,INOVASI_REGISTER_DATE,INOVASI_PIMPINAN');
            $this->db->where('INOVASI_ID',$inovasi_id);
            $data_inovasi = $this->db->get('v_inovasi');
            $row_inovasi = $data_inovasi->row();

            $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
            $this->db->where($w2); 
            $this->db->from('v_member_inovasi'); 
            $tim = $this->db->get();

            foreach ($tim->result() as $r_tim) {
                $mail_subject='Inovasi Terdaftar - IMS';
                $mail_message="Inovasi Anda telah teregister dalam Aplikasi ".$this->config->item("site_nickname").":
                                \n
                                \nNama Tim : ".$row_inovasi->TEAM_NAME."
                                \nJudul Inovasi : ".$row_inovasi->INOVASI_TITLE."
                                \nDiterima tanggal : ".$row_inovasi->INOVASI_REGISTER_DATE."
                                \nSelanjutnya, menunggu persetujuan atasan yang berwenang
                                \n
                                \nSalam INOVASI,
                                \nInnovation Council";
                $mail_to=$r_tim->MK_EMAIL;
                //echo $mail_message;
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            }

            
        endif;        
    }
   

    //Done Implemented
    function mail_approve_need($inovasi_id=null){
        

        //ambil data inovasi
        $this->db->select('INOVASI_ID,TEAM_ID,TEAM_NAME,INOVASI_TITLE,INOVASI_REGISTER_DATE,INOVASI_PIMPINAN,CATEGORY_NAME');
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        //ambil data user untuk send mail
        $this->db->where('EMPLOYEE_ID',$row_inovasi->INOVASI_PIMPINAN);
        $data_user = $this->db->get('v_user');
        $row_user = $data_user->row();

        if($this->config->item('site_send_mail')):
            
            $mail_to        = $row_user->MK_EMAIL;
            $mail_subject   = 'Persetujuan Inovasi';
            $mail_message   = "
            Mohon Persetujuan atas Inovasi berikut :
            
            \nNama Tim           : ".$row_inovasi->TEAM_NAME."
            \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
            \nKategori           : ".$row_inovasi->CATEGORY_NAME."

            \nSelanjutnya, Klik Icon berikut untuk persetujuan 
            http://ims.sggrp.com
            \n
            ";
            $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
        endif;
    }


    function mail_approve_need_file($inovasi_id=null,$jadwal_id=null){
        

        //ambil data inovasi
        $this->db->select('INOVASI_ID,TEAM_ID,TEAM_NAME,INOVASI_TITLE,INOVASI_REGISTER_DATE,INOVASI_PIMPINAN,CATEGORY_NAME');
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $this->db->select('GANTT_FILE');
        $this->db->where('INOVASI_ID',$inovasi_id);
        $this->db->where('JADWAL_ID',$jadwal_id);
        $data_gantt = $this->db->get('SIQC_GANTT');
        $row_gantt = $data_gantt->row();

        //ambil data user untuk send mail
        $this->db->where('EMPLOYEE_ID',$row_inovasi->INOVASI_PIMPINAN);
        $data_user = $this->db->get('v_user');
        $row_user = $data_user->row();

        if($this->config->item('site_send_mail')):
            
            $mail_to        = $row_user->MK_EMAIL;
            $mail_subject   = 'Persetujuan File';
            $mail_message   = "
            Mohon persetujuan atas file inovasi berikut :
            
            \nNama Tim           : ".$row_inovasi->TEAM_NAME."
            \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
            \nKategori           : ".$row_inovasi->CATEGORY_NAME."
            \nJudul FIle           : ".$row_gantt->GANTT_FILE."

            \nSelanjutnya, Klik Icon berikut untuk persetujuan 
            http://ims.sggrp.com
            \n
            ";
            $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
        endif;
    }

    //Done Implemented
    function mail_approve_not($inovasi_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Status Penerimaan Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nKategori           : ".$row_inovasi->CATEGORY_NAME."
                \nStatus             : DITOLAK
                \nComment            : ".$r_revisi->INOVASI_REVISI_COMMENT."
                \nKegagalan Anda merupakan awal kesuksesan Anda             
                \n
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }
    //Done Implemented
    function mail_approve_ok($inovasi_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Status Penerimaan Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nKategori           : ".$row_inovasi->CATEGORY_NAME."
                \nStatus             : DISETUJUI
                \nSilahkan melanjutkan Inovasi anda ke tahap selanjutnya
                \n
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }
    //Done Implemented
    function mail_approve_revisi($inovasi_id=null){


        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Status Penerimaan Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nKategori           : ".$row_inovasi->CATEGORY_NAME."
                \nStatus             : REVISI
                \nComment            : ".$r_revisi->INOVASI_REVISI_COMMENT."
                \nSilahkan menindak lanjuti Comment revisi dari atasan anda
                \n
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_register_award($inovasi_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                $mail_to        = $r_tim->MK_EMAIL;

                $mail_subject   = 'Status Penerimaan Inovasi';
                $mail_message   = "
                Selamat, Inovasi Anda telah teregister dalam Awarding ".date("Y")." :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nDiterima Tanggal   : ".$row_inovasi->INOVASI_AWARD_DATE."
                \n
                \nSilahkan melanjutkan ke tahap selanjutnya
                \n
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
        $this->mail_verif_need($inovasi_id);
    }

    function mail_verif_need($inovasi_id=null){        

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        //ambil data user untuk send mail
        $this->db->distinct();
        $this->db->select('MK_EMAIL');
        $this->db->where('USERGROUP_ID',7);
        $this->db->where('USER_ACTIVE','y');
        $this->db->where('COMPANY',$row_inovasi->UNIT);
        $this->db->like('USER_VERIF_CATEGORY', $row_inovasi->CATEGORY_ID); 
        $data_user = $this->db->get('v_user');
        
        foreach ($data_user->result() as $row_user) {
           
            if($this->config->item('site_send_mail')):
                
                $mail_to        = $row_user->MK_EMAIL;
                $mail_subject   = 'Verifikasi Inovasi';
                $mail_message   = "
                Mohon verifikasi atas Inovasi berikut :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nKategori           : ".$row_inovasi->CATEGORY_NAME."

                \nSelanjutnya, Klik Icon berikut untuk persetujuan http://ims.sggrp.com
                \n
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }

        
    }

    function mail_verif_note($inovasi_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $this->db->order_by('INOVASI_REVISI_CREATED_DATE', 'asc');
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Verifikasi Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nComment Verifikator : ".$r_revisi->INOVASI_REVISI_COMMENT."
                \n
                \nSilahkan menindak lanjuti comment dari verifikator
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_evaluator_need($inovasi_id=null){        

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        //ambil data user untuk send mail
        $this->db->distinct();
        $this->db->select('MK_EMAIL');
        $this->db->where('USERGROUP_ID',4);
        $this->db->where('USER_ACTIVE','y');
        $data_user = $this->db->get('v_user');
        
        foreach ($data_user->result() as $row_user) {
           
            if($this->config->item('site_send_mail')):
                
                $mail_to        = $row_user->MK_EMAIL;
                $mail_subject   = 'Evaluasi Inovasi';
                $mail_message   = "
                Mohon evaluasi atas Inovasi berikut :
                
                \nNama Tim           : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi      : ".$row_inovasi->INOVASI_TITLE."
                \nKategori           : ".$row_inovasi->CATEGORY_NAME."

                \nSelanjutnya, Klik Icon berikut untuk persetujuan http://ims.sggrp.com
                \n
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }

        
    }

    function mail_become_nominator($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'NOMINATOR Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus              : BERHASIL Sebagai NOMINATOR
                \n
                \nSilahkan melanjutkan ke tahap Selanjutnya
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_become_nominator_not($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'NOMINATOR Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus              : BELUM BERHASIL Sebagai NOMINATOR
                \n
                \nKegagalan Anda merupakan awal dari kesuksesan Anda
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_final_not($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'FINALIS Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus              : BELUM BERHASIL Sebagai FINALIS
                \n
                \nKegagalan Anda merupakan awal dari kesuksesan Anda
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_final_ok($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'FINALIS Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus              : BERHASIL Sebagai FINALIS
                \n
                \nSilahkan melanjutkan ke tahap selanjutnya
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_final_winner($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'FINALIS Inovasi';
                $juara="";
                if ($row_inovasi->INOVASI_STATUS_ID == 6003) {
                    $juara="JUARA I";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6004) {
                    $juara="JUARA II";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6005) {
                    $juara="JUARA III";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6006) {
                    $juara="THE BEST INNOVATION";
                }

                $mail_message   = "
                Selamat, Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus Kejuaraan    : (".$juara.")
                \n
                \nKami menantikan KEBERLANJUTAN INOVASI ANDA
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

//==========================================================================================
//==========================================================================================
//==========================================================================================
//==========================================================================================
//==========================================================================================


    function mail_approve_need_siqc($inovasi_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        //ambil data user untuk send mail
        $this->db->where('EMPLOYEE_ID',$row_inovasi->INOVASI_PIMPINAN);
        $data_user = $this->db->get('v_user');
        $row_user = $data_user->row();

        if($this->config->item('site_send_mail')):
            
            $mail_to        = $row_user->MK_EMAIL;
            $mail_subject   = 'Pendaftaran Inovasi SIQC';
            $mail_message   = "Mohon persetujuan atas Inovasi berikut:
                                \nNama Tim :".$row_inovasi->TEAM_NAME."
                                \nJudul Inovasi : ".$row_inovasi->INOVASI_TITLE."
                                \nKategori : ".$row_inovasi->CATEGORY_NAME."
                                \nSelanjutnya silahkan klik link berikut http://ims.sggrp.com untuk persetujuan.
            ";
            $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
        endif;
    }

    function mail_approve_siqc_not($inovasi_id=null,$message=null,$langkah=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Pendaftaran Inovasi SIQC';
                $mail_message   = "
                            Pengajuan inovasi Anda :
                            \nNama Tim : ".$row_inovasi->TEAM_NAME."
                            \nJudul Inovasi :".$row_inovasi->INOVASI_TITLE."
                            \nKategori :".$row_inovasi->CATEGORY_NAME."
                            \nStatus : DITOLAK";
                if(!empty($message)){
                    $mail_message   =$mail_message."\nComment :".$message;
                }else{
                    $mail_message   =$mail_message."\nComment :".$r_revisi->INOVASI_REVISI_COMMENT;
                }
                if(!empty($langkah)){
                    $mail_message   =$mail_message."\nLangkah :".$langkah;
                }
                $mail_message   =$mail_message."
                            \nKegagalan Anda merupakan awal dari Kesuksesan Anda
                            \n
                            \nSalam INOVASI,
                            \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_approve_siqc_ok($inovasi_id=null,$message=null,$langkah=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Pendaftaran Inovasi SIQC';
                $mail_message   = "
                    Pengajuan inovasi Anda :
                    \nNama Tim : ".$row_inovasi->TEAM_NAME."
                    \nJudul Inovasi : ".$row_inovasi->INOVASI_TITLE."
                    \nKategori : ".$row_inovasi->CATEGORY_NAME."
                    \nStatus : DISETUJUI";

                $mail_message   =$mail_message."
                    \nSilahkan melanjutkan Inovasi anda ke tahap selanjutnya
                    \n  
                    \nSalam INOVASI,
                    \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_approve_siqc_revisi($inovasi_id=null,$message=null,$langkah=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Pendaftaran Inovasi SIQC';
                $mail_message   = "
                    Pengajuan inovasi Anda :
                    \nNama Tim : ".$row_inovasi->TEAM_NAME."
                    \nJudul Inovasi : ".$row_inovasi->INOVASI_TITLE."
                    \nKategori : ".$row_inovasi->CATEGORY_NAME."
                    \nStatus : DIREVISI";
                if(!empty($message)){
                    $mail_message   =$mail_message."\nComment :".$message;
                }else{
                    $mail_message   =$mail_message."\nComment :".$r_revisi->INOVASI_REVISI_COMMENT;
                }
                if(!empty($langkah)){
                    $mail_message   =$mail_message."\nLangkah :".$langkah;
                }
                $mail_message   =$mail_message."
                    \nSilahkan menindak lanjuti comment revisi dari Atasan Anda
                    \n
                    \nSalam INOVASI,
                    \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_approve_siqc_revisi_file($inovasi_id=null,$message=null,$langkah=null,$jadwal_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        $this->db->select('GANTT_FILE');
        $this->db->where('INOVASI_ID',$inovasi_id);
        $this->db->where('JADWAL_ID',$jadwal_id);
        $data_gantt = $this->db->get('SIQC_GANTT');
        $row_gantt = $data_gantt->row();

        //ambil data inovasi revisi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $revisi = $this->db->get('T_INOVASI_REVISI');
        $r_revisi = $revisi->last_row();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Revisi File Inovasi';
                $mail_message   = "
                    Pengajuan inovasi Anda :
                    \nNama Tim : ".$row_inovasi->TEAM_NAME."
                    \nJudul Inovasi : ".$row_inovasi->INOVASI_TITLE."
                    \nKategori : ".$row_inovasi->CATEGORY_NAME."
                    \nJudul File : ".$row_gantt->GANTT_FILE."
                    \nStatus : DIREVISI";
                if(!empty($message)){
                    $mail_message   =$mail_message."\nComment :".$message;
                }else{
                    $mail_message   =$mail_message."\nComment :".$r_revisi->INOVASI_REVISI_COMMENT;
                }
                if(!empty($langkah)){
                    $mail_message   =$mail_message."\nLangkah :".$langkah;
                }
                $mail_message   =$mail_message."
                    \nSilahkan menindak lanjuti comment revisi dari Atasan Anda
                    \n
                    \nSalam INOVASI,
                    \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_juara_siqc($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Juara Inovasi';
                $juara="";
                if ($row_inovasi->INOVASI_STATUS_ID == 6003) {
                    $juara="JUARA I";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6004) {
                    $juara="JUARA II";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6005) {
                    $juara="JUARA III";
                }else if ($row_inovasi->INOVASI_STATUS_ID == 6006) {
                    $juara="THE BEST INNOVATION";
                }

                $mail_message   = "
                Selamat, Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus Kejuaraan    : (".$juara.")
                \n
                \nKami menantikan KEBERLANJUTAN INOVASI ANDA
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_juara_siqc_not($inovasi_id=null){
        
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'INOVASI_ID'   => $inovasi_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_member_inovasi'); 
        $tim = $this->db->get();

        foreach ($tim->result() as $r_tim) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_tim->MK_EMAIL;
                $mail_subject   = 'Seleksi Inovasi';
                $mail_message   = "
                Pengajuan Inovasi Anda :
                
                \nNama Tim            : ".$row_inovasi->TEAM_NAME."
                \nJudul Inovasi       : ".$row_inovasi->INOVASI_TITLE."
                \nKategori            : ".$row_inovasi->CATEGORY_NAME."
                \nStatus              : BELUM BERHASIL Sebagai JUARA
                \n
                \nSilahkan melanjutkan ke tahap selanjutnya
                \n
                \nSalam Inovasi
                \nInnovation Council
                ";
                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }

    function mail_approve_need_step_siqc($inovasi_id=null,$user_id=null){
        $this->mail_approve_need($inovasi_id,$user_id);
    }

    function mail_request_lihat_inovasi($inovasi_id=null,$user_id=null){
        //ambil data user untuk send mail
        if(!empty($user_id)):
            $this->db->where('USER_ID',$user_id);
            $data_user = $this->db->get('v_user');
            $row_user = $data_user->row();
        endif;
        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        if($this->config->item('site_send_mail')):
            
            if(!empty($user_id)):
                $mail_to        = $row_user->MK_EMAIL;
            else:
                $mail_to        = $this->sender;
            endif;
            
            $mail_subject   = 'Request Lihat Inovasi';
            $mail_message   = 'Tindak Lanjuti permohonan lihat inovasi dari sistem SMI
            ';
            $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
        endif;
    }

    function request_reject($inovasi_id=null,$user_id=null){

        //ambil data inovasi
        $this->db->where('INOVASI_ID',$inovasi_id);
        $data_inovasi = $this->db->get('v_inovasi');
        $row_inovasi = $data_inovasi->row();

        $w2 = array(
                'USER_ID'   => $user_id,
            );
        $this->db->where($w2); 
        $this->db->from('v_user'); 
        $user = $this->db->get();


        foreach ($user->result() as $r_user) {

            if($this->config->item('site_send_mail')):
                
                $mail_to        = $r_user->MK_EMAIL;
                $mail_subject   = 'Permintaan Dokumen';
                $mail_message   = "
                    Permintaan dokumen anda ditolak :
                    \nJudul Dokumen : ".$row_inovasi->INOVASI_TITLE."
                    \nNama Tim : ".$row_inovasi->TEAM_NAME."
                    \nKategori : ".$row_inovasi->CATEGORY_NAME."
                    \nOpco : ".$row_inovasi->UNIT_TITLE."";


                $this->kirim_email($this->sender,$mail_to,$mail_subject,$mail_message);
            endif;
        }
    }



}
?>