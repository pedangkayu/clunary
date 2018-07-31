<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendingbill extends CI_Model {

	function get() {
        $dataorder = array();
        $dataorder[1] = "kode_pemesanan";
        $dataorder[2] = "check_in_pada";
        $dataorder[3] = "kode_pegawai";
        $dataorder[4] = "total";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        $query = "
        			SELECT
						A.*, B.total
					FROM
						data_pemesanan A
					LEFT JOIN (
						SELECT
							id_pesanan,
							sum(subtotal) AS total
						FROM
							data_pemesanan_menu
						GROUP BY
							id_pesanan
					) B ON (A.id_pesanan = B.id_pesanan)
					WHERE
						A.status_pemesanan = 3
        ";
        // var_dump($query);

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
            $id = $d['id_pesanan'];

            $edit = '';
            $delete = '';
            
            $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                    Delete
                </a>';

            $r = array();
            $r[0] = $i;
            $r[1] = $d['kode_pemesanan'];
            $r[2] = date('d M Y (H:i)', strtotime($d['check_in_pada']));
            $r[3] = $d['kode_pegawai'];
            $r[4] = $d['total'];
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

/* End of file M_pendingbill.php */
/* Location: ./application/modules/keuangan/models/M_pendingbill.php */