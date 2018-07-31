<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_belanjabahan extends CI_Model {

	function get() {
        $dataorder = array();
        $dataorder[1] = "tgl_update";
        $dataorder[2] = "nama_bahan";
        $dataorder[3] = "satuan";
        $dataorder[4] = "qty";
        $dataorder[5] = "harga";
        $dataorder[6] = "total_harga";


        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_sampai = $this->input->post("tgl_sampai");

        $query = "
                SELECT
                    p.id_bahan,
                    nama_bahan,
                    satuan,
                    date_format(tgl_update, '%Y-%m-%d') AS tgl_update,
                    qty,
                    harga,
                    harga*qty as total_harga
                FROM
                    data_bahan_stock p
                JOIN data_bahan q ON (p.id_bahan = q.id_bahan)
                WHERE
                    jenis_perubahan = 'IN' 
        ";
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( lower(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR lower(satuan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR qty LIKE '%".$search["value"]."%' ";
            $query .= " OR harga LIKE '%".$search["value"]."%' ";
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
        foreach ($data as $d) {
            $i++;
            $id = 0;
            $view = '';
            $edit = '';
            $delete = '';
            $view='<a class="btn default btn-xs blue" title="detail" onclick="event.preventDefault();btn_view(\''.$id.'\');">
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
            $r[1] = date('d F Y', strtotime($d['tgl_update']));
            $r[2] = $d['nama_bahan'];
            $r[3] = $d['satuan'];
            $r[4] = '<div align="right">'.number_format($d['qty'], 2, ',', '.').'</div>';
            $r[5] = '<div align="right">'.number_format($d['harga'], 2, ',', '.').'</div>';
            $r[6] = '<div align="right">'.number_format($d['total_harga'], 2, ',', '.').'</div>';
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    function get_logbelanja() {
        $dataorder = array();
        $dataorder[1] = "date_pindahbuku";
        $dataorder[2] = "nama_eksekutor";
        $dataorder[3] = "nominal_reg";
        $dataorder[4] = "selisih";
        $dataorder[5] = "catatan";
        $dataorder[6] = "stat_aktif";


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
                    v_logbelanja where stat_aktif in (0,1)
        ";
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( lower(nama_eksekutor) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR lower(catatan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR nominal_reg LIKE '%".$search["value"]."%' ";
            $query .= " OR selisih LIKE '%".$search["value"]."%' ";
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
            $view = '';
            $edit = '';
            $delete = '';
            $view='<a class="btn default btn-xs blue" title="detail" onclick="event.preventDefault();btn_view(\''.$id.'\');">
                    <i class="fa fa-search"></i>
                </a>';
            $verifikasi='<a class="btn btn-warning btn-xs" title="verifikasi" onclick="event.preventDefault();btn_verifikasi(\''.$id.'\');">
                    <i class="fa fa-check"></i>
                </a>';
            $edit='<a class="btn default btn-xs green" title="edit" onclick="event.preventDefault();btn_edit(\''.$id.'\');">
                    <i class="fa fa-edit"></i>
                </a>';
            $delete='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                </a>';

            $delete_permanent='<a class="btn default btn-xs red" title="delete" onclick="event.preventDefault();btn_delete_permanent(\''.$id.'\');">
                    <i class="fa fa-trash-o"></i>
                </a>';

            $status = '';
            $btn_aksi = '';
            if($d['stat_aktif']==0){
                $status = '<span class="label label-sm label-warning"> Unverified </span>';
                $btn_aksi = $view.$verifikasi.$edit.$delete_permanent;
            }elseif($d['stat_aktif']==1){
                $status = '<span class="label label-sm label-success"> Verified </span>';
                $btn_aksi = $view.$delete;
            }
            $r = array();
            $r[0] = $i;
            $r[1] = ($d['date_pindahbuku']=='') ? '': date('d F Y', strtotime($d['date_pindahbuku']));
            $r[2] = $d['nama_eksekutor'];
            $r[3] = '<div align="right">'.number_format($d['nominal_reg'], 2, ',', '.').'</div>';
            $r[4] = '<div align="right">'.number_format($d['selisih'], 2, ',', '.').'</div>';
            $r[5] = $d['catatan'];
            $r[6] = $status;
            $r[7] = $btn_aksi;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    function get_item_log() {
        $dataorder = array();
        $dataorder[1] = "nama_bahan";
        $dataorder[2] = "satuan";
        $dataorder[3] = "harga";
        $dataorder[4] = "qty";
        $dataorder[5] = "harga_total_belanja";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $id_log_coa_ledger = $this->input->post("id_log_coa_ledger");
        $mode = $this->input->post("mode");

        $query = "select
                    *
                from
                    v_item_logbelanja
                where
                    id_log_coa_ledger=".$id_log_coa_ledger." ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(satuan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR qty LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga_total_belanja LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['id'];

            $edit = '';
            $delete = '';
            if($mode=='add' || $mode=='edit'){
                $aksi='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete_item_log(\''.$id.'\');">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>';
            }else{
                $aksi = '<i>Tidak ada aksi</i>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_bahan'];
            $r[2] = $d['satuan'];
            $r[3] = '<div align="right">'.number_format($d['harga'], 2, ',', '.').'</div>';
            $r[4] = '<div align="right">'.number_format($d['qty'], 2, ',', '.').'</div>';
            $r[5] = '<div align="right">'.number_format($d['harga_total_belanja'], 2, ',', '.').'</div>';
            $r[6] = $aksi;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    } 

    public function get_total_belanja($id_log_coa_ledger)
    {
        $item_log = $this->m_base->get_data('data_bahan_stock', array('id_log_coa_ledger' => $id_log_coa_ledger));
        $total_belanja_nominal = 0;
        foreach ($item_log->result() as $r) {
            $total_belanja_nominal += $r->harga_total_belanja;
        }
        return $total_belanja_nominal;
    }

    public function update_harga_bahan($id_bahan, $harga)
    {
        // from c_belanja_bahan/verifikasi
        $kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
        $datetime_sekarang = date('Y-m-d H:i:s');
        $data = array(
                    'tgl_update' => $datetime_sekarang,
                    'id_bahan' => $id_bahan,
                    'harga' => $harga,
                    'kode_pegawai' => $kode_pegawai,
                    );
        $insert_log_harga_bahan = $this->m_base->insert_data('log_harga_bahan', $data);

        $update_data_bahan = $this->m_base->update_data('data_bahan', array('harga_bahan' => $harga), array('id_bahan' => $id_bahan));
    }

}

/* End of file M_belanjabahan.php */
/* Location: ./application/modules/keuangan/models/M_belanjabahan.php */