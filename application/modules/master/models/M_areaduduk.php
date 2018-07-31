<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_areaduduk extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "kode_areaduduk";
        $dataorder[2] = "nama_area";
        $dataorder[3] = "lantai";
        $dataorder[4] = "deskripsi";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        // param post
        // if($order){
        //     $order_sql = "order by
        //         ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        // }

        // $query = "
                
        //         select
        //         *,
        //         @rownumber := @rownumber + 1 as rn
        //         from data_meja_areaduduk, (select @rownumber:=0) as tt where flag_aktif=1 ";

        $query = "select
                *
                from data_meja_areaduduk where flag_aktif=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(kode_areaduduk) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_area) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(lantai) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(deskripsi) LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['kode_areaduduk'];

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
            $r[1] = $d['kode_areaduduk'];
            $r[2] = $d['nama_area'];
            $r[3] = $d['lantai'];
            $r[4] = $d['deskripsi'];
            $r[5] = $edit.$delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   
}

/* End of file M_areaduduk.php */
/* Location: ./application/modules/district/models/M_areaduduk.php */