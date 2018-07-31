<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendapatan extends CI_Model {

	function get() {
        $dataorder = array();
        $dataorder[1] = "date_submit";
        $dataorder[2] = "total_system";
        $dataorder[3] = "total_real";
        $dataorder[4] = "total_selisih";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "
                SELECT
                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
                    sum(saldo_system) AS total_system,
                    sum(saldo_akhir) AS total_real,
                    sum(selisih) AS total_selisih
                FROM
                    data_audit
                WHERE
                    data_audit.stat_audit = 2  
        ";
        // var_dump($query);
        // if (!empty($search)) {
        //     $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
        //     $query .= " ( total_system LIKE '%".$search["value"]."%' ";
        //     $query .= " OR total_real LIKE '%".strtolower($search["value"])."%' ";
        //     $query .= " OR total_selisih LIKE '%".strtolower($search["value"])."%' ";
        //     $query .= " ) ";
        // }

        if (!empty($tgl_mulai) || !empty($tgl_sampai)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " DATE_FORMAT(date_submit, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
        }

        $query .= " GROUP BY date_format(date_submit, '%Y-%m-%d') ";
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
            $id = 0;
            $view = '';
            $edit = '';
            $delete = '';
            $view='<a class="btn default btn-xs blue" title="detail" onclick="event.preventDefault();btn_view_pendapatan(\''.$d['date_submit'].'\');">
                    <i class="fa fa-search"></i>
                    
                </a>';
            $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
                    <i class="fa fa-edit"></i>
                    
                </a>';
            $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                    
                </a>';
            $r = array();
            $r[0] = $i;
            $r[1] = date('d F Y', strtotime($d['date_submit']));
            $r[2] = '<div align="right">'.number_format($d['total_system'], 2, ',', '.').'</div>';
            $r[3] = '<div align="right">'.number_format($d['total_real'], 2, ',', '.').'</div>';
            $r[4] = '<div align="right">'.number_format($d['total_selisih'], 2, ',', '.').'</div>';
            $r[5] = $view;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    function get_pendapatanpesanan() {
        $dataorder = array();
        $dataorder[1] = "nama_menu";
        $dataorder[2] = "nama_perusahaan";
        $dataorder[3] = "harga";
        $dataorder[4] = "jml_menu";
        $dataorder[5] = "total";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $str_ar_audit = $this->input->post("str_ar_audit");

        $data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit asc
                    ")->row();
        $open_audit = $data_audit->date_submit;
        $data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit desc
                    ")->row();
        $close_audit = $data_audit->date_modify;

        $query = "
                    SELECT
                        kode_menu,
                        A.id_perusahaan,
                        C.nama_perusahaan,
                        nama_menu,
                        harga,
                        count(kode_menu) as jml_menu,
                        sum(harga) AS total
                    FROM
                        data_pemesanan_menu A
                    JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
                    JOIN parameter_perusahaan C ON (A.id_perusahaan = C.id_perusahaan)
                    WHERE
                        status_pemesanan = 5
                    AND (
                        B.submit_pada BETWEEN '$open_audit'
                        AND '$close_audit'
                    )
                    
        ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_menu) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_perusahaan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga LIKE '%".$search["value"]."%' ";
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
            $r[2] = $d['nama_perusahaan'];
            $r[3] = $d['harga'];
            $r[4] = $d['jml_menu'];
            $r[5] = $d['total'];
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    } 

    function get_pendapatandetail() {
        $dataorder = array();
        $dataorder[1] = "payment_method";
        $dataorder[2] = "jumlah_trans";
        $dataorder[3] = "total_trans";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $str_ar_audit = $this->input->post("str_ar_audit");

        $query = "select
                payment_method,
                sum(jumlah_trans) as jumlah_trans,
                sum(total_trans) as total_trans
                from data_audit_detail where id_audit in ($str_ar_audit) ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(payment_method) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR jumlah_trans LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR total_trans LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }
        $query .= " GROUP BY payment_method ";
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

/* End of file M_pendapatan.php */
/* Location: ./application/modules/keuangan/models/M_pendapatan.php */