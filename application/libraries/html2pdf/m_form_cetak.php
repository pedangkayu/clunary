<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'models/m_base_model.php');
class M_form_cetak extends M_base_model {

	var $nama_kepala_dinkes = "Drg. Febria Rachmanita";
	var $jabatan_kepala_dinkes = "Pembina Utama Muda";
	var $nip_kepala_dinkes = "196502281992032008";

	var $nama_kadisperindag = "Drs. Ec. Widodo Suryantoro,MM";
	var $nip_kadisperindag = "196404211989031011";

	public function __construct()
	{
		parent::__construct();
	}

	public function create_form($pk_id, $jenis)
	{
		$data['nama_kepala_dinkes']=$this->nama_kepala_dinkes;	
		$data['nip_kepala_dinkes']=$this->nip_kepala_dinkes;
		$data['jabatan_kepala_dinkes']=$this->jabatan_kepala_dinkes;

		$data['nama_kadisperindag']=$this->nama_kadisperindag;	
		$data['nip_kadisperindag']=$this->nip_kadisperindag;	
		$data['jabatan_kadisperindag']="Pembina Utama";	
		$data['pk_id']=$pk_id;	

		if ($jenis == 'e1_output') {
			$data2table['content_table']=$this->load->view('tab_form/pdf/v_e1_output_form',$data, TRUE);
		}
		elseif ($jenis == 'a1') {
			$data2table['content_table']=$this->load->view('pdf/v_rumahsakit_surat_ijin',$data, TRUE);
		} 
		elseif ($jenis == 'a1_1'){
			$data2table['content_table']=$this->load->view('pdf/v_rumahsakit_surat_permohonan',$data, TRUE);
		} 
		elseif ($jenis == 'a1_13'){
			$data2table['content_table']=$this->load->view('pdf/v_rumahsakit_surat_pernyataan',$data, TRUE);
		} 
		elseif ($jenis == 'a2'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_surat_ijin_operasional_sementara',$data, TRUE);
		}
		elseif ($jenis == 'a2_1'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_surat_permohonan',$data, TRUE);
		} 
		elseif ($jenis == 'a2_3'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_surat_pernyataan',$data, TRUE);
		} 
		elseif ($jenis == 'a2_4'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_kesanggupan_direktur',$data, TRUE);
		} 
		elseif ($jenis == 'a2_5'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_pernyataan_direktur',$data, TRUE);
		} 
		elseif ($jenis == 'a2_6'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_pernyataan_pemilik',$data, TRUE);
		} 
		elseif ($jenis == 'a2_7'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_daftar_karyawan',$data, TRUE);
		} 
		elseif ($jenis == 'a3'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_ijin',$data, TRUE);	
		} 
		elseif ($jenis == 'a3_1'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_permohonan',$data, TRUE);	
		} 
		elseif ($jenis == 'a3_2'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_pernyataan_pemohon',$data, TRUE);	
		} 
		elseif ($jenis == 'a3_3'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_kesanggupan',$data, TRUE);	
		} 
		elseif ($jenis == 'a3_4'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_keabsahan',$data, TRUE);	
		} 
		elseif ($jenis == 'a3_5'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_kepemilikan',$data, TRUE);
		} 
		elseif ($jenis == 'e3_15'){
			$data2table['content_table']=$this->load->view('pdf/v_siup_mb_surat_ijin',$data, TRUE);	
		} 
		elseif ($jenis == 'e3_14'){
			$data2table['content_table']=$this->load->view('pdf/v_siup_mb_pernyataan',$data, TRUE);
		}
		elseif ($jenis == 'e4_1'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_1_lampiran_iv_f',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_3'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_3_izin_prinsip',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_4'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4',$data, TRUE);	
		}
		elseif ($jenis == 'e4_5'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_5_surat_rekomendasi',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_6'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_6_izin_prinsip',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_7'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_7_izin_prinsip',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_8'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_8_izin_prinsip',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_10'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_melarang',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_11'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_2_rekomendasi_memperbolehkan',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_12'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_2_izin_prinsip',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_13'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_3_surat_permohonan',$data, TRUE);	
		} 
		elseif ($jenis == 'e4_14'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_4_izin_prinsip',$data, TRUE);	
		}
		
		elseif ($jenis == 'a5'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_ijin_penyelenggaraan',$data, TRUE);	
		}
		elseif ($jenis == 'a5_1'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_1_izin_penyelenggaraan_lab',$data, TRUE);	
		}
		elseif ($jenis == 'a5_10'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_10_surat_pernyataan',$data, TRUE);	
		}
		elseif ($jenis == 'a5_11'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_11_surat_pernyataan_analisis',$data, TRUE);	
		}
		elseif ($jenis == 'a5_12'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_12_surat_pernyataan_pemantapan_mutu',$data, TRUE);	
		}
		
		elseif ($jenis == 'a5_13'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_13',$data, TRUE);	
		}
		elseif ($jenis == 'a5_16'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_16',$data, TRUE);	
		}
		elseif ($jenis == 'a5_18'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_18',$data, TRUE);	
		}
		elseif ($jenis == 'a5_19'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_19',$data, TRUE);	
		}
		elseif ($jenis == 'a5_2'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_11_surat_pernyataan_analisis',$data, TRUE);	
		}
		elseif ($jenis == 'a5_21'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_21',$data, TRUE);	
		}
		elseif ($jenis == 'a5_26'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_26',$data, TRUE);	
		}
		elseif ($jenis == 'a5_9'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_a5_9_surat_penunjukan',$data, TRUE);	
		}
		
		elseif ($jenis == 'a6'){
			$data2table['content_table']=$this->load->view('pdf/v_optik_a6_surat_ijin_penyelenggaraan',$data, TRUE);	
		}
		elseif ($jenis == 'a6_1'){
			$data2table['content_table']=$this->load->view('pdf/v_optik_a6_1_ijin_penyelenggaraan',$data, TRUE);	
		}
		elseif ($jenis == 'a6_2'){
			$data2table['content_table']=$this->load->view('pdf/v_optik_a6_2_surat_permohonan',$data, TRUE);	
		}
		elseif ($jenis == 'a7'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7',$data, TRUE);	
		}
		elseif ($jenis == 'a7_2'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7_2',$data, TRUE);	
		}
		elseif ($jenis == 'a7_6'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7_6',$data, TRUE);	
		}
		elseif ($jenis == 'a7_7'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7_7',$data, TRUE);	
		}
		elseif ($jenis == 'a7_10'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7_10_apoteker',$data, TRUE);	
		}
		elseif ($jenis == 'a7_10_1'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7_10_pemiliksaranapotek',$data, TRUE);	
		}
		elseif ($jenis == 'a8'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8',$data, TRUE);	
		}
		elseif ($jenis == 'a8_1'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8_1',$data, TRUE);	
		}
		elseif ($jenis == 'a8_5'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8_5',$data, TRUE);	
		}
		elseif ($jenis == 'a8_6'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8_6',$data, TRUE);	
		}
		elseif ($jenis == 'a8_7'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8_7',$data, TRUE);	
		}
		elseif ($jenis == 'a9'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_surat_ijin',$data, TRUE);	
		}
		elseif ($jenis == 'a9_1'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_1_surat_permohonan',$data, TRUE);	
		}
		elseif ($jenis == 'a9_2'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_2_surat_pernyataan',$data, TRUE);	
		}
		elseif ($jenis == 'a9_7'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_7_surat_kesanggupan_pj_teknis',$data, TRUE);	
		}
		elseif ($jenis == 'a9_8'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_8_surat_pernyataan_uu',$data, TRUE);	
		}
		elseif ($jenis == 'a9_13'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_13_daftar_pelayanan',$data, TRUE);	
		}
		elseif ($jenis == 'a9_14'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_14_daftar_ketenagaan',$data, TRUE);	
		}
		elseif ($jenis == 'a9_17'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_17_daftar_alat',$data, TRUE);	
		}
		elseif ($jenis == 'a9_21'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_21_daftar_bahan',$data, TRUE);	
		}
		elseif ($jenis == 'a10'){
			$data2table['content_table']=$this->load->view('pdf/v_hama_a10',$data, TRUE);	
		}
		elseif ($jenis == 'a10_1'){
			$data2table['content_table']=$this->load->view('pdf/v_hama_a10_1',$data, TRUE);	
		}
		elseif ($jenis == 'a10_2'){
			$data2table['content_table']=$this->load->view('pdf/v_hama_a10_2',$data, TRUE);	
		}
		elseif ($jenis == 'b1'){
			$data2table['content_table']=$this->load->view('pdf/v_b1',$data, TRUE);	
		}
		elseif ($jenis == 'b2'){
			$data2table['content_table']=$this->load->view('pdf/v_b2',$data, TRUE);	
		}
		elseif ($jenis == 'b2_1'){
			$data2table['content_table']=$this->load->view('pdf/v_b2_1',$data, TRUE);	
		}
		elseif ($jenis == 'b2_6'){
			$data2table['content_table']=$this->load->view('pdf/v_b2_6',$data, TRUE);	
		}
		elseif ($jenis == 'b3'){
			$data2table['content_table']=$this->load->view('pdf/v_b3',$data, TRUE);	
		}
		elseif ($jenis == 'b3_a'){
			$data2table['content_table']=$this->load->view('pdf/v_b3_a',$data, TRUE);	
		}
		elseif ($jenis == 'b3_d'){
			$data2table['content_table']=$this->load->view('pdf/v_b3_d',$data, TRUE);	
		}
		elseif ($jenis == 'b3_i'){
			$data2table['content_table']=$this->load->view('pdf/v_b3_i',$data, TRUE);	
		}
		elseif ($jenis == 'a11'){
			$data2table['content_table']=$this->load->view('pdf/v_depo_airminum_a11',$data, TRUE);	
		}
		elseif ($jenis == 'a12'){
			$data2table['content_table']=$this->load->view('pdf/v_uji_alkes_a12_izin_sementara',$data, TRUE);	
		}
		elseif ($jenis == 'a12_1'){
			$data2table['content_table']=$this->load->view('pdf/v_uji_alkes_a12_1',$data, TRUE);	
		}
		elseif ($jenis == 'a13'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_alkes_a13_sk',$data, TRUE);	
		}
		elseif ($jenis == 'a13_1'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_alkes_a13_1',$data, TRUE);	
		}
		elseif ($jenis == 'a13_12'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_alkes_a13_12',$data, TRUE);	
		}
		elseif ($jenis == 'b4'){
			$data2table['content_table']=$this->load->view('pdf/v_boga_b4_sertifikat',$data, TRUE);	
		}
		elseif ($jenis == 'b4_1'){
			$data2table['content_table']=$this->load->view('pdf/v_boga_b4_1',$data, TRUE);	
		}
		elseif ($jenis == 'b4_7'){
			$data2table['content_table']=$this->load->view('pdf/v_boga_b4_7',$data, TRUE);	
		}
		elseif ($jenis == 'c1'){
			$data2table['content_table']=$this->load->view('pdf/v_c1_surat_rekom_rs',$data, TRUE);	
		}
		elseif ($jenis == 'c1_1'){
			$data2table['content_table']=$this->load->view('pdf/v_c1_1',$data, TRUE);	
		}
		elseif ($jenis == 'c2'){
			$data2table['content_table']=$this->load->view('pdf/v_c2',$data, TRUE);	
		}
		elseif ($jenis == 'c2_1'){
			$data2table['content_table']=$this->load->view('pdf/V_c2_1_lab_rekom_permohonan',$data, TRUE);	
		}
		elseif ($jenis == 'e1'){
			$data2table['content_table']=$this->load->view('pdf/v_e1_stpw',$data, TRUE);	
		}
		elseif ($jenis == 'e4_iupp'){
			$data2table['content_table']=$this->load->view('pdf/v_e5_iupp',$data, TRUE);	
		}
		elseif ($jenis == 'e4_iuppt'){
			$data2table['content_table']=$this->load->view('pdf/v_e5_iuppt',$data, TRUE);	
		}
		elseif ($jenis == 'e2'){
			$data2table['content_table']=$this->load->view('pdf/v_e2_pameran',$data, TRUE);	
		}
		elseif ($jenis == 'a11_1'){
			$data2table['content_table']=$this->load->view('pdf/v_depo_airminum_a11_1',$data, TRUE);	
		}
		elseif ($jenis == 'a11_7'){
			$data2table['content_table']=$this->load->view('pdf/v_depo_airminum_a11_7',$data, TRUE);	
		}
		elseif ($jenis == 'a11_8'){
			$data2table['content_table']=$this->load->view('pdf/v_depo_airminum_a11_8',$data, TRUE);	
		}

		return $data2table['content_table'];
	}

	public function create_form_sk($pk_id)
	{
		$data['nama_kepala_dinkes']=$this->nama_kepala_dinkes;	
		$data['nip_kepala_dinkes']=$this->nip_kepala_dinkes;
		$data['jabatan_kepala_dinkes']=$this->jabatan_kepala_dinkes;

		$data['nama_kadisperindag']=$this->nama_kadisperindag;	
		$data['nip_kadisperindag']=$this->nip_kadisperindag;	
		$data['jabatan_kadisperindag']="Pembina Utama";	
		$data['pk_id']=$pk_id;	

		$r_permohonan = $this->get_permohonan($pk_id)->row();
		$permohonan = $r_permohonan->PK_JENIS_PEMOHON;
			
		if ($permohonan == '201') {
			$data2table['content_table']=$this->load->view('pdf/v_e1_stpw',$data, TRUE);
		}
		elseif ($permohonan == '202'){
			$data2table['content_table']=$this->load->view('pdf/v_e2_pameran',$data, TRUE);	
		}
		elseif ($permohonan == '203'){
			$data2table['content_table']=$this->load->view('pdf/v_siup_mb_surat_ijin',$data, TRUE);	
		}
		elseif ($permohonan == '204'){
			$data2table['content_table']=$this->load->view('pdf/v_e5_iupp',$data, TRUE);
		}
		elseif ($permohonan == '205'){
			$data2table['content_table']=$this->load->view('pdf/v_e5_iuppt',$data, TRUE);
		}
		elseif ($permohonan == '206'){
			$data2table['content_table']=$this->load->view('pdf/v_iuts_e4_4_surat_ijin',$data, TRUE);
		}
		elseif ($permohonan == '207'){
			
		}
		elseif ($permohonan == '208'){
			
		}
		elseif ($permohonan == '209'){
			
		}
		// DINKESS
		elseif ($permohonan == '211'){
			$data2table['content_table']=$this->load->view('pdf/v_rumahsakit_surat_ijin',$data, TRUE);
		}
		elseif ($permohonan == '212'){
			$data2table['content_table']=$this->load->view('pdf/v_rs_penyelenggaraan_surat_ijin',$data, TRUE);
		}
		elseif ($permohonan == '213'){			
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_ijin',$data, TRUE);	
		}
		elseif ($permohonan == '214'){
			$data2table['content_table']=$this->load->view('pdf/v_klinik_surat_ijin',$data, TRUE);	
		}
		elseif ($permohonan == '215'){	
			$data2table['content_table']=$this->load->view('pdf/v_klinik_ijin_penyelenggaraan',$data, TRUE);	
		}
		elseif ($permohonan == '216'){
			
			$data2table['content_table']=$this->load->view('pdf/v_optik_a6_surat_ijin_penyelenggaraan',$data, TRUE);	
		}
		elseif ($permohonan == '217'){
			$data2table['content_table']=$this->load->view('pdf/v_apotek_a7',$data, TRUE);				
		}
		elseif ($permohonan == '218'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_obat_a8_1',$data, TRUE);	
		}
		elseif ($permohonan == '219'){
			$data2table['content_table']=$this->load->view('pdf/v_sarana_tradisional_a9_surat_ijin',$data, TRUE);	
		}
		elseif ($permohonan == '220'){
			$data2table['content_table']=$this->load->view('pdf/v_hama_a10',$data, TRUE);	
		}
		elseif ($permohonan == '221'){
			$data2table['content_table']=$this->load->view('pdf/v_depo_airminum_a11',$data, TRUE);	
		}
		elseif ($permohonan == '222'){
			$data2table['content_table']=$this->load->view('pdf/v_uji_alkes_a12_izin_sementara',$data, TRUE);	
		}
		elseif ($permohonan == '223'){
			$data2table['content_table']=$this->load->view('pdf/v_toko_alkes_a13_sk',$data, TRUE);	
		}
		elseif ($permohonan == '231'){
			$data2table['content_table']=$this->load->view('pdf/v_b1',$data, TRUE);	
		}
		elseif ($permohonan == '232'){
			$data2table['content_table']=$this->load->view('pdf/v_b2',$data, TRUE);	
		}
		elseif ($permohonan == '233'){
			$data2table['content_table']=$this->load->view('pdf/v_b3',$data, TRUE);	
		}
		elseif ($permohonan == '234'){
			$data2table['content_table']=$this->load->view('pdf/v_boga_b4_sertifikat',$data, TRUE);	
		}
		elseif ($permohonan == '235'){
			$data2table['content_table']=$this->load->view('pdf/v_c1_surat_rekom_rs',$data, TRUE);	
		}
		elseif ($permohonan == '236'){
			$data2table['content_table']=$this->load->view('pdf/v_c2',$data, TRUE);	
		}

		return $data2table['content_table'];	
	}

	public function get_permohonan($pk_id)
	{
		$this->db->where('PK_ID', $pk_id);
		return $this->db->get('T_PERMOHONAN');
	}
}

/* End of file m_pemohon.php */
/* Location: ./application/models/m_pemohon.php */