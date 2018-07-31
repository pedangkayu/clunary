<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bahan extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "nama_bahan";
        $dataorder[2] = "coa_name";
        $dataorder[3] = "satuan";
        $dataorder[4] = "harga_bahan";
        $dataorder[5] = "minimum_stock_alert";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        $query = "select
                *
                from v_bahan where stat_aktif=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(coa_name) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga_bahan LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR minimum_stock_alert LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(satuan) LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['id_bahan'];

            $edit = '';
            $delete = '';
            $edit='<a class="btn default btn-xs green" onclick="event.preventDefault();btn_edit(\''.$id.'\');" title="edit">
                    <i class="fa fa-edit"></i>
                </a>';
            $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete(\''.$id.'\');" title="hapus">
                    <i class="fa fa-trash-o"></i>
                </a>';

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_bahan'];
            $r[2] = $d['coa_name'];
            $r[3] = $d['satuan'];
            $r[4] = '<div align="right">'.number_format($d['harga_bahan'], 2, ',', '.').'</div>';
            $r[5] = '<div align="right">'.number_format($d['minimum_stock_alert'], 2, ',', '.').'</div>';
            $r[6] = $edit.$delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   
}

/* End of file M_bahan.php */
/* Location: ./application/modules/district/models/M_bahan.php */