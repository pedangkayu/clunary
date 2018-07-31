<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_base extends CI_Model {

    public function get_data($nama_table, $filter='', $order_by='')
    {
        if(!empty($filter)){
            $this->db->where($filter);
        }

        if(!empty($order_by)){
            $this->db->order_by($order_by['nama_kolom'], $order_by['order']);
        }
        return $this->db->get($nama_table);
    }


    public function insert_data($nama_table, $data, $get_id='')
    {
        $this->db->insert($nama_table, $data);
        if($this->db->affected_rows()>0){
            $result['stat'] = true;
            if($get_id){
                $result['last_id'] = $this->db->insert_id();
            }
        }else{
            $result['stat'] = false;
        }
        return $result;
    }

    public function update_data($nama_table, $data, $filter)
    {
        $this->db->where($filter);
        $this->db->update($nama_table, $data);
        $result['stat'] = true;
        return $result;
    }

    public function delete_data($nama_table, $filter)
    {
        $this->db->where($filter);
        $this->db->delete($nama_table);
        if($this->db->affected_rows()>0){
            $result['stat'] = true;
        }else{
            $result['stat'] = false;
        }
        return $result;
    }

    public function read_excel($file='', $jenis='', $other='')
    {
        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        // $objPHPExcel->setReadDataOnly(true); 
        
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        if($jenis=='upload_karyawan'){
            $district_id            = $other['district_id'];
            
            for ($row = 2; $row <= $highestRow;$row++) 
            {
                $karyawan_nip             = $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
                $karyawan_nama            = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                $karyawan_photo           = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                $motor1                   = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                $ket_motor1               = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                $motor2                   = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue();
                $ket_motor2               = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue();
                $motor3                   = $objPHPExcel->getActiveSheet()->getCell('H'.$row)->getValue();
                $ket_motor3               = $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
                $motor4                   = $objPHPExcel->getActiveSheet()->getCell('J'.$row)->getValue();
                $ket_motor4               = $objPHPExcel->getActiveSheet()->getCell('K'.$row)->getValue();
                $motor5                   = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getValue();
                $ket_motor5               = $objPHPExcel->getActiveSheet()->getCell('M'.$row)->getValue();
                $mobil1                   = $objPHPExcel->getActiveSheet()->getCell('N'.$row)->getValue();
                $ket_mobil1               = $objPHPExcel->getActiveSheet()->getCell('O'.$row)->getValue();
                $mobil2                   = $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getValue();
                $ket_mobil2               = $objPHPExcel->getActiveSheet()->getCell('Q'.$row)->getValue();
                $mobil3                   = $objPHPExcel->getActiveSheet()->getCell('R'.$row)->getValue();
                $ket_mobil3               = $objPHPExcel->getActiveSheet()->getCell('S'.$row)->getValue();
                $mobil4                   = $objPHPExcel->getActiveSheet()->getCell('T'.$row)->getValue();
                $ket_mobil4               = $objPHPExcel->getActiveSheet()->getCell('U'.$row)->getValue();
                $mobil5                   = $objPHPExcel->getActiveSheet()->getCell('V'.$row)->getValue();
                $ket_mobil5               = $objPHPExcel->getActiveSheet()->getCell('W'.$row)->getValue();

                $data_karyawan = array('karyawan_nip' => $karyawan_nip,
                                        'karyawan_nama' => $karyawan_nama,
                                        'karyawan_photo' => $karyawan_photo,
                                        'perusahaan_id' => 1,
                                        'district_id' => $district_id
                );
                $this->db->insert('m_karyawan', $data_karyawan);
                $karyawan_id = $this->db->insert_id();

                // data kendaraan
                $data_kendaraan = array();
                for ($i=1; $i <= 5; $i++) { 
                    if(!empty(${'motor'.$i})){
                        $kendaraan = array('t_kendaraan_karyawan_id' => $karyawan_id,
                                            'm_kendaraan_id' => 2,
                                            't_kendaraan_keterangan' => ${'ket_motor'.$i},
                                            't_kendaraan_plat' => ${'motor'.$i}
                            );
                        array_push($data_kendaraan, $kendaraan);
                    }
                    
                    if(!empty(${'mobil'.$i})){
                        $kendaraan = array('t_kendaraan_karyawan_id' => $karyawan_id,
                                            'm_kendaraan_id' => 3,
                                            't_kendaraan_keterangan' => ${'ket_mobil'.$i},
                                            't_kendaraan_plat' => ${'mobil'.$i}
                            );
                        array_push($data_kendaraan, $kendaraan);
                    }
                }
                if(!empty($data_kendaraan)){
                    $this->db->insert_batch('t_kendaraan', $data_kendaraan);
                }
            }
        }
        
    }

}

/* End of file M_base.php */
/* Location: ./application/modules/base/models/M_base.php */