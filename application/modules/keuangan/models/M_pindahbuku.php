<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pindahbuku extends CI_Model {

	function get() {
        $dataorder = array();
        $dataorder[1] = "date_pindahbuku";
        $dataorder[2] = "nama_eksekutor";
        $dataorder[3] = "source_reg";
        $dataorder[4] = "destination_reg";
        $dataorder[5] = "nominal_reg";
        $dataorder[6] = "selisih";
        $dataorder[7] = "catatan";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "select
                *
                from v_pindahbuku where stat_aktif=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_eksekutor) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(source_reg) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(destination_reg) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR nominal_reg LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR selisih LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(catatan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        if (!empty($tgl_mulai) || !empty($tgl_sampai)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " DATE_FORMAT(date_pindahbuku, '%Y-%m-%d') between '".$tgl_mulai."' and '".$tgl_sampai."' ";
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
            $id = $d['id_log_coa_ledger'];

            $edit = '';
            $delete = '';
            $noaksi = '';
            if($d['destination_reg']=='Stock'){
            	$noaksi = '<i>No Aksi</i>';
            }else{
	            $edit='<a class="btn default btn-xs green" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
	                    <i class="fa fa-edit"></i>
	                    Edit
	                </a>';
	            $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
	                    <i class="fa fa-trash-o"></i>
	                    Delete
	                </a>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = date('d M Y (H:i)', strtotime($d['date_pindahbuku']));
            $r[2] = $d['nama_eksekutor'];
            $r[3] = $d['source_reg'];
            $r[4] = $d['destination_reg'];
            $r[5] = '<div align="right">'.number_format($d['nominal_reg'], 2, ',', '.').'</div>';
            $r[6] = '<div align="right">'.number_format($d['selisih'], 2, ',', '.').'</div>';
            $r[7] = $d['catatan'];
            $r[8] = $edit.$delete.$noaksi;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   

}

/* End of file M_pindahbuku.php */
/* Location: ./application/modules/keuangan/models/M_pindahbuku.php */