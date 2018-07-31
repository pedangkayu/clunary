<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "kode_pegawai";
        $dataorder[2] = "nama_lengkap";
        $dataorder[3] = "nama_panggilan";
        $dataorder[4] = "gender";
        $dataorder[5] = "alamat";
        $dataorder[6] = "jabatan";
        $dataorder[7] = "mulai_bekerja";
        $dataorder[8] = "catatan";

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
        //         from data_pegawai_pegawai, (select @rownumber:=0) as tt where flag_aktif=1 ";

        $query = "select
                *
                from data_pegawai where akt_stat=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(kode_pegawai) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_lengkap) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_panggilan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(alamat) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(jabatan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(catatan) LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['kode_pegawai'];

            $view = '';
            $edit = '';
            $delete = '';
            $view='<a class="btn default btn-xs blue" title="view" onclick="event.preventDefault();btn_view(\''.$id.'\');" title="view">
                    <i class="fa fa-search"></i>
                    
                </a>';
            $edit='<a class="btn default btn-xs green" onclick="event.preventDefault();btn_edit(\''.$id.'\');" title="edit">
                    <i class="fa fa-edit"></i>
                </a>';
            
            if(!in_array($d['kode_role'], array(4,5))){
                $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete(\''.$id.'\');" title="hapus">
                    <i class="fa fa-trash-o"></i>
                </a>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['kode_pegawai'];
            $r[2] = $d['nama_lengkap'];
            $r[3] = $d['nama_panggilan'];
            $r[4] = $d['gender'];
            $r[5] = $d['alamat'];
            $r[6] = $d['jabatan'];
            $r[7] = ($d['mulai_bekerja']=='') ? '' : date('d M Y', strtotime($d['mulai_bekerja']));
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
}

/* End of file M_pegawai.php */
/* Location: ./application/modules/district/models/M_pegawai.php */