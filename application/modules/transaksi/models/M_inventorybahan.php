<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inventorybahan extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "nama_bahan";
        $dataorder[2] = "satuan";
        $dataorder[3] = "tgl_update";
        $dataorder[4] = "jenis_perubahan";
        $dataorder[5] = "perubahan";
        $dataorder[6] = "qty";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "select
                *
                from v_transaksibahanstock ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(satuan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(jenis_perubahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(perubahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR qty LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if (!empty($tgl_mulai) || !empty($tgl_sampai)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " DATE_FORMAT(tgl_update, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
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
        $arr_perubahan = array('IN','USE','ADJ','RET');
        foreach ($data as $d) {
            $i++;
            $id = $d['id'];

            $edit = '';
            $delete = '';
            $noaksi = '';
            if(in_array($d['jenis_perubahan'], $arr_perubahan)){
                $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
                        <i class="fa fa-edit"></i>
                        
                    </a>';
                $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                        <i class="fa fa-trash-o"></i>
                        
                    </a>';
            }else{
                $noaksi = '<i>No Aksi</i>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_bahan'];
            $r[2] = $d['satuan'];
            $r[3] = date('d F Y (H:i)', strtotime($d['tgl_update']));
            $r[4] = $d['jenis_perubahan'];
            $r[5] = $d['perubahan'];
            $r[6] = '<div align="right">'.number_format($d['qty'], 2, ',', '.').'</div>';
            $r[7] = $edit.$delete.$noaksi;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   

    function get_stock() {
        $dataorder = array();
        $dataorder[1] = "nama_bahan";
        $dataorder[2] = "minimum_stock_alert";
        $dataorder[3] = "jml_stock";
        $dataorder[4] = "satuan";
        $dataorder[5] = "harga_bahan";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $filterstatus = $this->input->post("filterstatus");

        $query = "select
                *
                from v_bahanstock ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(satuan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga_bahan LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR minimum_stock_alert LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR jml_stock LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if ($filterstatus!='all' && !empty($filterstatus)) {
            if($filterstatus=='kurang'){
                $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
                $query .= " jml_stock <= minimum_stock_alert ";
            }elseif($filterstatus=='aman'){
                $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
                $query .= " jml_stock > minimum_stock_alert ";
            }
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
        
        $data = $this->db->query($query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $edit = '';
            $delete = '';
            $status = '';
            if($d['jml_stock']<=$d['minimum_stock_alert']){
                $status = '<span class="label label-sm label-warning"> Kurang </span>';
            }else{
                $status = '<span class="label label-sm label-success"> Aman </span>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_bahan'];
            $r[2] = '<div align="right">'.number_format($d['minimum_stock_alert'], 2, ',', '.').'</div>';
            $r[3] = '<div align="right">'.number_format($d['jml_stock'], 2, ',', '.').'</div>';
            $r[4] = $d['satuan'];
            $r[5] = '<div align="right">'.number_format($d['harga_bahan'], 2, ',', '.').'</div>';
            $r[6] = $status;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   
}

/* End of file M_meja.php */
/* Location: ./application/modules/district/models/M_meja.php */