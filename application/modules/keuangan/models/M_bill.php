<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bill extends CI_Model {

	function get() {
        $dataorder = array();
        $dataorder[1] = "kode_pemesanan";
        $dataorder[2] = "check_in_pada";
        $dataorder[3] = "payment_method";
        $dataorder[4] = "counter_nota";
        $dataorder[5] = "total_biaya_after_tax";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "
                SELECT
                    *
                FROM
                    data_pemesanan
                WHERE
                   	status_pemesanan in (4,5) and stat_bill=0 and counter_nota is not null
        ";
        // 2016-06-12 00:35:38
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
            $query .= " DATE_FORMAT(check_in_pada, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
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
            $id = 0;
            $view = '';
            $edit = '';
            $delete = '';
            $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
                    <i class="fa fa-edit"></i>
                    
                </a>';
            $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                    
                </a>';
            $r = array();
            $r[0] = $i;
            $r[1] = $d['kode_pemesanan'];
            $r[2] = date('d F Y', strtotime($d['check_in_pada']));
            $r[3] = $d['payment_method'];
            $r[4] = $d['counter_nota'];
            $r[5] = '<div align="right">'.number_format($d['total_biaya_after_tax'], 2, ',', '.').'</div>';
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    function get_sudah() {
        $dataorder = array();
		$dataorder[1] = "date_payed_bill";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "
                SELECT DISTINCT
					date_payed_bill,
					COUNT(date_payed_bill) * 1000 AS total
				FROM
					data_pemesanan
				WHERE
					stat_bill = 1
				
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
            $query .= " DATE_FORMAT(date_payed_bill, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
        }

        $query .= "GROUP BY
                    date_payed_bill ";

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
            $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
                    <i class="fa fa-edit"></i>
                    
                </a>';
            $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                    
                </a>';
            $r = array();
            $r[0] = $i;
            $r[1] = date('d F Y (H:i:s)', strtotime($d['date_payed_bill']));
            $r[2] = '<div align="right">'.number_format($d['total'], 2, ',', '.').'</div>';
            $r[3] = $view;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

}

/* End of file M_bill.php */
/* Location: ./application/modules/keuangan/models/M_bill.php */