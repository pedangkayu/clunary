<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_meja extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "nama_area";
        $dataorder[2] = "kode_meja";
        $dataorder[3] = "kapasitas";
        $dataorder[4] = "dipesan";
        $dataorder[5] = "digunakan";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

       
        $query = "select
                *
                from v_meja where stat_meja=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(kode_meja) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_area) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR kapasitas LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR dipesan LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR digunakan LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['kode_meja'];

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
            $r[1] = $d['nama_area'];
            $r[2] = $d['kode_meja'];
            $r[3] = $d['kapasitas'].' Org';
            $r[4] = $d['dipesan'];
            $r[5] = $d['digunakan'];
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

/* End of file M_meja.php */
/* Location: ./application/modules/district/models/M_meja.php */