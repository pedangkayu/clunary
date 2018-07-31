<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_audit extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('base/m_base');
    }

	function get() {
        $dataorder = array();
        $dataorder[1] = "date_submit";
        $dataorder[2] = "date_modify";
        $dataorder[3] = "nama_lengkap";
        $dataorder[4] = "saldo_awal";
        $dataorder[5] = "saldo_system";
        $dataorder[6] = "saldo_akhir";
        $dataorder[7] = "selisih";
        $dataorder[8] = "catatan";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "select
                *
                from v_audit where stat_audit=2 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_lengkap) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(kode_pegawai) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(catatan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR saldo_awal LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR saldo_system LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR saldo_akhir LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR selisih LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if (!empty($tgl_mulai) || !empty($tgl_sampai)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " DATE_FORMAT(date_submit, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
        }

        if($order){
            $query.= " order by 
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }
        
        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS numrows FROM (".$query.") A")->row()->numrows;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        // $main_query = "select * from (".$query.") s
        //     where rn between " . ($start + 1) . " and " . (($start) + $iDisplayLength) . "
        //     ";
        
        $data = $this->db->query($query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $id = $d['id_audit'];

            $view = '';
            $edit = '';
            $delete = '';
            $view='<a class="btn default btn-xs blue" title="detail" onclick="event.preventDefault();btn_view_audit(\''.$id.'\');">
                    <i class="fa fa-search"></i>
                    
                </a>';
            $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit_audit(\''.$id.'\');">
                    <i class="fa fa-edit"></i>
                    
                </a>';
            $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete_audit(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                    
                </a>';
            $r = array();
            $r[0] = $i;
            $r[1] = date('d F Y (H:i)', strtotime($d['date_submit']));
            $r[2] = date('d F Y (H:i)', strtotime($d['date_modify']));
            $r[3] = $d['nama_lengkap'].' ('.$d['kode_pegawai'].')';
            $r[4] = '<div align="right">'.number_format($d['saldo_awal'], 2, ',', '.').'</div>';
            $r[5] = '<div align="right">'.number_format($d['saldo_system'], 2, ',', '.').'</div>';
            $r[6] = '<div align="right">'.number_format($d['saldo_akhir'], 2, ',', '.').'</div>';
            $r[7] = '<div align="right">'.number_format($d['selisih'], 2, ',', '.').'</div>';
            $r[8] = $d['catatan'];
            $r[9] = $view.$edit.$delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    function get_auditdetailpesanan() {
        $dataorder = array();
        $dataorder[1] = "nama_menu";
        $dataorder[2] = "harga";
        $dataorder[3] = "jml_menu";
        $dataorder[4] = "total";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $id_audit = $this->input->post("id_audit");

        $data_audit = $this->m_base->get_data('data_audit', array('id_audit' => $id_audit))->row();
        $open_audit = $data_audit->date_submit;
        $close_audit = $data_audit->date_modify;
        $kode_pegawai = $data_audit->kode_pegawai;

        $query = "
                    SELECT
                        kode_menu,
                        nama_menu,
                        harga,
                        count(kode_menu) as jml_menu,
                        sum(harga) AS total
                    FROM
                        data_pemesanan_menu A
                    JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
                    WHERE
                        B.submit_oleh = '$kode_pegawai'
                    AND status_pemesanan = 5
                    AND (
                        B.submit_pada BETWEEN '$open_audit'
                        AND '$close_audit'
                    )
                    
        ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_menu) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga LIKE '%".$search["value"]."%' ";
            // $query .= " OR jml_menu LIKE '%".$search["value"]."%' ";
            // $query .= " OR total LIKE '%".$search["value"]."%' ";
            $query .= " ) ";
        }
        $query .= " GROUP BY kode_menu ";

        if($order){
            $query.= " order by 
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }
        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS numrows FROM (".$query.") A")->row()->numrows;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        // $main_query = "select * from (".$query.") s
        //     where rn between " . ($start + 1) . " and " . (($start) + $iDisplayLength) . "
        //     ";
        
        $data = $this->db->query($query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_menu'];
            $r[2] = $d['harga'];
            $r[3] = $d['jml_menu'];
            $r[4] = $d['total'];
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    } 

    function get_auditdetail() {
        $dataorder = array();
        $dataorder[1] = "payment_method";
        $dataorder[2] = "jumlah_trans";
        $dataorder[3] = "total_trans";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $id_audit = $this->input->post("id_audit");

        $query = "select
                *
                from data_audit_detail where id_audit=$id_audit ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(payment_method) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR jumlah_trans LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR total_trans LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if($order){
            $query.= " order by 
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }
        
        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS numrows FROM (".$query.") A")->row()->numrows;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        // $main_query = "select * from (".$query.") s
        //     where rn between " . ($start + 1) . " and " . (($start) + $iDisplayLength) . "
        //     ";
        
        $data = $this->db->query($query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $r = array();
            $r[0] = $i;
            $r[1] = $d['payment_method'];
            $r[2] = '<div align="right">'.number_format($d['jumlah_trans'], 2, ',', '.').'</div>';
            $r[3] = '<div align="right">'.number_format($d['total_trans'], 2, ',', '.').'</div>';
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }  

}

/* End of file M_audit.php */
/* Location: ./application/modules/keuangan/models/M_audit.php */