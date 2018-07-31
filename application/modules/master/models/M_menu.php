<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

    function get() {
        $dataorder = array();
        $dataorder[1] = "nama_menu";
        $dataorder[2] = "nama_perusahaan";
        $dataorder[3] = "nama_kategori";
        $dataorder[4] = "alias_menu";
        $dataorder[5] = "deskripsi";
        $dataorder[6] = "harga";
        $dataorder[7] = "discount";
        $dataorder[8] = "flag_hapus";

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
        //         from data_meja_menu, (select @rownumber:=0) as tt where flag_aktif=1 ";

        $query = "select
                *
                from v_menu where flag_aktif=1 ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_kategori) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_menu) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(nama_perusahaan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(alias_menu) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(deskripsi) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR discount LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['kode_menu'];

            $edit = '';
            $delete = '';
            $edit='<a class="btn default btn-xs green" onclick="event.preventDefault();btn_edit(\''.$id.'\');" title="edit">
                    <i class="fa fa-edit"></i>
                </a>';
            $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete(\''.$id.'\');" title="hapus">
                    <i class="fa fa-trash-o"></i>
                </a>';
            $gambar = base_url().'uploads/menu/no-image.jpg';
            if($d['gambar_menu']!=''){
                $gambar = base_url().'uploads/menu/'.$d['gambar_menu'];
            }
            $status = '';
            if($d['flag_hapus']==0){
                $status = '<span class="label label-sm label-success"> Aktif </span>';
            }else{
                $status = '<span class="label label-sm label-warning"> Non Aktif </span>';
            }

            $r = array();
            $r[0] = '<a onclick="show_fancybox(\''.$gambar.'\')"><img src="'.$gambar.'" width="25" height="25"></a>';
            $r[1] = $d['nama_menu'];
            $r[2] = $d['nama_perusahaan'];
            $r[3] = $d['nama_kategori'];
            $r[4] = $d['alias_menu'];
            $r[5] = $d['deskripsi'];
            $r[6] = '<div align="right">'.number_format($d['harga'], 2, ',', '.').'</div>';
            $r[7] = '<div align="right">'.number_format($d['discount'], 2, ',', '.').'</div>';
            $r[8] = $status;
            $r[9] = $edit.$delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }   

    function get_bahanmenu() {
        $dataorder = array();
        $dataorder[1] = "nama_bahan";
        $dataorder[2] = "satuan";
        $dataorder[3] = "jumlah";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $kode_menu = $this->input->post("kode_menu");
        $mode = $this->input->post("mode");

        // param post
        // if($order){
        //     $order_sql = "order by
        //         ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        // }

        // $query = "
                
        //         select
        //         *,
        //         @rownumber := @rownumber + 1 as rn
        //         from data_meja_menu, (select @rownumber:=0) as tt where flag_aktif=1 ";

        $query = "select
                *
                from v_bahanmenu where kode_menu=".$kode_menu." ";
        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_bahan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(satuan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR jumlah LIKE '%".strtolower($search["value"])."%' ";
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
            $id = $d['id_bahanmenu'];

            $edit = '';
            $delete = '';
            if($mode=='add' || $mode=='edit'){
                $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete_bahanmenu(\''.$id.'\');">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_bahan'];
            $r[2] = $d['satuan'];
            $r[3] = $d['jumlah'];
            $r[4] = $delete;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    } 
}

/* End of file M_menu.php */
/* Location: ./application/modules/district/models/M_menu.php */