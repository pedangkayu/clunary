<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_waiter extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('base/m_base');
    }

	function get_listorder() {
        $dataorder = array();
        $dataorder[1] = "nama_menu";
        $dataorder[2] = "harga";
        $dataorder[3] = "discount";
        $dataorder[4] = "jml_menu";
        $dataorder[5] = "total";

        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");
        $id_pesanan = $this->input->post("id_pesanan");
        $mode = $this->input->post("mode");

        if($mode!='view'){
            $query = "select
                    *
                    from v_temp_listorder where id_pesanan=".$id_pesanan." ";
        }else{
            $query = "select
                    *
                    from v_listorder where id_pesanan=".$id_pesanan." ";
        }

        // var_dump($query);
        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(nama_menu) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR harga LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR discount LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR jml_menu LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR total LIKE '%".strtolower($search["value"])."%' ";
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
            $edit = '';
            $delete = '';
            $aksi = '';
            if($mode=='add' || $mode=='edit'){
            	$edit='<a class="btn default btn-xs green" onclick="event.preventDefault();btn_edit_listorder('.$d['id_pesanan'].','.$d['kode_menu'].');">
                        <i class="fa fa-pencil"></i>
                        Edit
                    </a>';
                $delete='<a class="btn default btn-xs red" onclick="event.preventDefault();btn_delete_listorder('.$d['id_pesanan'].','.$d['kode_menu'].');">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>';
            }elseif($mode=='view' || $mode=='confirm'){
            	$aksi = '<i>No Aksi</i>';
            }

            $r = array();
            $r[0] = $i;
            $r[1] = $d['nama_menu'];
            $r[2] = '<div align="right">'.number_format($d['harga'], 2, ',', '.').'</div>';
            $r[3] = '<div align="right">'.number_format($d['discount'], 2, ',', '.').'</div>';
            $r[4] = '<div align="right">'.$d['jml_menu'].'</div>';
            $r[5] = '<div align="right">'.number_format($d['total'], 2, ',', '.').'</div>';
            $r[6] = $edit.$delete.$aksi;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
    }

    public function cek_sebelum_pesan($jenis_form='')
    {
        $id_pesanan = $this->input->post('id_pesanan');
        $kode_menu  = $this->input->post('kode_menu');
        $jml_menu   = $this->input->post('jml_menu');
        if($id_pesanan==0){
            $q_kebutuhan_pemesanan = '
                                    SELECT
                                        kode_menu,
                                        kode_bahan,
                                        nama_bahan,
                                        jumlah,
                                        jumlah*'.$jml_menu.' AS qty_bahan
                                    FROM
                                        data_bahanmenu b
                                    JOIN data_bahan ON (kode_bahan = id_bahan)
                                    WHERE
                                        kode_menu = '.$kode_menu.'
                                    GROUP BY
                                        kode_bahan
                    ';
            $kebutuhan_pemesanan = $this->db->query($q_kebutuhan_pemesanan);
            $flag_menu_pemesanan = true;
            foreach ($kebutuhan_pemesanan->result() as $r) {
                if($flag_menu_pemesanan){
                    $get_stok_bahan = $this->m_base->get_data('v_bahanstock', array('id_bahan' => $r->kode_bahan, 'stat_aktif' => 1 ));
                    if($get_stok_bahan->num_rows()>0){
                        $jml_stok_sekarang = $get_stok_bahan->row()->jml_stock;

                        if($jml_stok_sekarang < $r->qty_bahan){
                            $flag_menu_pemesanan = false;
                        }
                    }else{
                        $flag_menu_pemesanan = false;
                    }
                    // var_dump($jml_stok_sekarang);
                }
            }
        }else{
            $data_tamp_pemesanan_menu = $this->m_base->get_data('data_temp_pemesanan_menu', array('id_pesanan' => $id_pesanan, 'kode_menu' =>$kode_menu));
            if(!empty($jenis_form)){
                $jml_menu = $jml_menu; //
            }else{
                $jml_menu = $jml_menu+$data_tamp_pemesanan_menu->num_rows();
            }

            $q_kebutuhan_pemesanan = '
                                    SELECT
                                        kode_menu,
                                        kode_bahan,
                                        nama_bahan,
                                        jumlah,
                                        jumlah*'.$jml_menu.' AS qty_bahan
                                    FROM
                                        data_bahanmenu b
                                    JOIN data_bahan ON (kode_bahan = id_bahan)
                                    WHERE
                                        kode_menu = '.$kode_menu.'
                                    GROUP BY
                                        kode_bahan
                    ';
            $kebutuhan_pemesanan = $this->db->query($q_kebutuhan_pemesanan);
            $flag_menu_pemesanan = true;
            foreach ($kebutuhan_pemesanan->result() as $r) {
                if($flag_menu_pemesanan){
                    $get_stok_bahan = $this->m_base->get_data('v_bahanstock', array('id_bahan' => $r->kode_bahan, 'stat_aktif' => 1 ));
                    if($get_stok_bahan->num_rows()>0){
                        $jml_stok_sekarang = $get_stok_bahan->row()->jml_stock;
                        if($jml_stok_sekarang < $r->qty_bahan){
                            $flag_menu_pemesanan = false;
                        }
                    }else{
                        $flag_menu_pemesanan = false;
                    }
                }
            }
        }


        if($flag_menu_pemesanan){
            $result['stat'] = true;
        }else{
            $result['stat'] = false;
            $result['pesan'] = 'Menu ini tidak dapat dipesan dengan jumlah '.$jml_menu.'.';
        }
        return $result;
    }

    public function cek_sebelum_ke_kasir($id_pesanan)
    {
        // $result['stat'] = true;
        // return $result;
        $kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
        
        $q_temp_stok_bahan = '
                            SELECT
                                data_bahan_stock.id_bahan AS id_bahan,
                                sum(data_bahan_stock.qty) AS jml_stock,
                                data_bahan.stat_aktif AS stat_aktif
                            FROM
                                data_bahan_stock
                            JOIN data_bahan ON (
                                data_bahan_stock.id_bahan = data_bahan.id_bahan
                            )
                            WHERE
                                data_bahan.stat_aktif = 1
                            GROUP BY
                                data_bahan_stock.id_bahan
                            ';
        $temp_stok_bahan = $this->db->query($q_temp_stok_bahan);
        foreach ($temp_stok_bahan->result() as $r) {
            $data = array(
                        'kode_pegawai' => $kode_pegawai,
                        'id_pesanan' => $id_pesanan,
                        'id_bahan' => $r->id_bahan,
                        'jml_stok' => $r->jml_stock,
                );
            $insert_temp_bahanstok = $this->m_base->insert_data('temp_stokbahan_waiter', $data);
        }

        $menu_dapat_dipesan = array();
        $q_data_pemesanan_menu = '
                                select kode_menu, sum(kode_menu) as jml_menu
                                from data_temp_pemesanan_menu
                                where id_pesanan='.$id_pesanan.'
                                order by kode_menu asc
                                ';
        $data_pemesanan_menu = $this->db->query($q_data_pemesanan_menu);
        foreach ($data_pemesanan_menu->result() as $r) {
            $data = array(
                        'kode_menu' => $r->kode_menu,
                        'jml_menu'  => $r->jml_menu,
                );
            array_push($menu_dapat_dipesan, $data);
        }

        $q_kebutuhan_pemesanan = '
                    select kode_pemesanan,b.kode_menu, nama_menu, kode_bahan, nama_bahan,b.jumlah,count(kode_bahan) as jumlah_item, sum(jumlah) as qty_bahan
                    from data_bahanmenu b
                    JOIN data_temp_pemesanan_menu m ON (b.kode_menu=m.kode_menu)
                    JOIN data_bahan d ON (b.kode_bahan=d.id_bahan)
                    WHERE m.id_pesanan='.$id_pesanan.'
                    group by kode_pemesanan, nama_menu, nama_bahan,b.jumlah
                    order by b.kode_menu asc
                ';
        $kebutuhan_pemesanan = $this->db->query($q_kebutuhan_pemesanan);
        
        $ar_pesan_konfirmasi = '';
        $flag_menu_pemesanan = true;
        $kode_menu_pemesanan = '';
        $ar_temp_jml_stok_bahan = array();
        foreach ($kebutuhan_pemesanan->result() as $r) {
            if($kode_menu_pemesanan != $r->kode_menu){
                $nama_menu_pemesanan = $r->nama_menu;
                $kode_menu_pemesanan = $r->kode_menu;
                $ar_temp_jml_stok_bahan = array();
                $flag_menu_pemesanan = true;

                if($kode_menu_pemesanan != '' && $flag_menu_pemesanan){ // lakukan update
                    for ($i=0; $i < count($ar_temp_jml_stok_bahan); $i++) { 
                        $data = array(
                                    'jml_stok' => $ar_temp_jml_stok_bahan[$i]['jml_stok'],
                                    );
                        $filter = array(
                                        'kode_pegawai' => $kode_pegawai,
                                        'id_pesanan'   => $id_pesanan,
                                        'id_bahan'     => $ar_temp_jml_stok_bahan[$i]['id_bahan'],
                                        );
                        $update_temp_stokbahan_waiter = $this->m_base->update_data('temp_stokbahan_waiter', $data, $filter);
                    }
                }
            }else{
                if($flag_menu_pemesanan){ //jika false maka tidak perlu melakukan pengecekan bahan lagi pada menu yang sama
                    $id_bahan              = $r->kode_bahan;
                    $jml_bahan_permenu     = $r->jumlah;
                    $jml_item_pesanan      = $r->jumlah_item;
                    $total_bahan_pemesanan = $r->qty_bahan;

                    $get_temp_stokbahan_waiter = $this->m_base->get_data('temp_stokbahan_waiter', array('kode_pegawai' => $kode_pegawai, 'id_bahan' => $id_bahan));
                    if($get_temp_stokbahan_waiter->num_rows()>0){
                        if($get_temp_stokbahan_waiter->row()->jml_stok >= $total_bahan_pemesanan){
                            //update temp_stokbahan_waiter
                            $stok_bahan_awal = $get_temp_stokbahan_waiter->row()->jml_stok;
                            $stok_bahan_sekarang = $stok_bahan_awal - $total_bahan_pemesanan;
                            $data = array(
                                        'id_bahan' => $id_bahan,
                                        'jml_stok' => $stok_bahan_sekarang,
                                        );
                            array_push($ar_temp_jml_stok_bahan, $data);
                        }else{
                            $flag_menu_pemesanan = false;
                            $pesan_konfirmasi = $nama_menu_pemesanan." tidak bisa dipesan dengan jumlah ".$jml_item_pesanan.". \n";
                            $ar_pesan_konfirmasi += $pesan_konfirmasi;
                        }
                    }else{
                        $flag_menu_pemesanan = false;
                        $pesan_konfirmasi = $nama_menu_pemesanan." tidak bisa dipesan dengan jumlah ".$jml_item_pesanan.". \n";
                        $ar_pesan_konfirmasi .= $pesan_konfirmasi;
                    }
                }
            }
        }

        $filter = array(
                        'kode_pegawai' => $kode_pegawai,
                        'id_pesanan'   => $id_pesanan,
                        );
        $delete_temp_stokbahan_waiter = $this->m_base->delete_data('temp_stokbahan_waiter', $filter);
        if(!empty($ar_pesan_konfirmasi)){
            $result['stat'] = false;
            $result['pesan'] = $ar_pesan_konfirmasi;
        }else{
            $result['stat'] = true;
        }
        return $result;
    }

    public function update_stok_bahan($id_pesanan)
    {
        $datetime_skrg = date('Y-m-d H:i');
        $q_kebutuhan_pemesanan = '
                    select kode_pemesanan,b.kode_menu, nama_menu, kode_bahan, harga_bahan, nama_bahan,b.jumlah,count(kode_bahan) as jumlah_item, sum(jumlah) as qty_bahan
                    from data_bahanmenu b
                    JOIN data_pemesanan_menu m ON (b.kode_menu=m.kode_menu)
                    JOIN data_bahan d ON (b.kode_bahan=d.id_bahan)
                    WHERE m.id_pesanan='.$id_pesanan.'
                    group by kode_pemesanan, nama_menu, nama_bahan,b.jumlah
                    order by b.kode_menu asc
                ';
        $kebutuhan_pemesanan = $this->db->query($q_kebutuhan_pemesanan);
        // var_dump($kebutuhan_pemesanan->num_rows());
        foreach ($kebutuhan_pemesanan->result() as $r) {
            $id_bahan = $r->kode_bahan;
            $harga_bahan = $r->harga_bahan;
            $jumlah_bahan_permenu = $r->jumlah;

            $data = array(
                        'id_bahan' => $id_bahan,
                        'tgl_update' => $datetime_skrg,
                        'jenis_perubahan' => 'SOLD',
                        'qty' => -1 * $jumlah_bahan_permenu,
                        'harga' => $harga_bahan,
                        'id_pesanan' => $id_pesanan,
                        );
            $update_stok = $this->m_base->insert_data('data_bahan_stock', $data);
        }
    }

}

/* End of file M_waiter.php */
/* Location: ./application/modules/waiter/models/M_waiter.php */