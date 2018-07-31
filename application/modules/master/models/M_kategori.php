<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "kode_kategori";
        $dataorder[2] = "nama_kategori";
        $dataorder[3] = "order_kategori";

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
        //         from data_meja_kategori, (select @rownumber:=0) as tt where flag_aktif=1 ";

        $query = "select
                *
                from data_menu_kategori ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(kode_kategori) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_kategori) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR order_kategori LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if($order){
            $query.= " order by 
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }
        // var_dump($query);
        
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
            $id = $d['kode_kategori'];

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
            $r[1] = $d['kode_kategori'];
            $r[2] = $d['nama_kategori'];
            $r[3] = $d['order_kategori'];
            $r[4] = $edit.$delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   
}

/* End of file M_kategori.php */
/* Location: ./application/modules/district/models/M_kategori.php */