<?php
class M_dashboard extends CI_Model {
	public function viewme($filter, $periode){
		$waktu = explode(" AND ", $periode);
		$view = "custom";
		if(strtolower($filter) == "hari ini"){
			$view = "jam";
		}else if(strtolower($filter) == "kemarin"){
			$view = "jam";
		}else if(strtolower($filter) == "7 hari terakhir"){
			$view = "hari";
		}else if(strtolower($filter) == "30 hari terakhir"){
			$view = "minggu";
		}else if(strtolower($filter) == "bulan ini"){
			$view = "minggu";
		}else if(strtolower($filter) == "bulan kemarin"){
			$view = "minggu";
		}else{//custom range 
			 $start = strtotime(str_replace("'","",$waktu[0]));
			 $end = strtotime(str_replace("'","",$waktu[1]));
			 $datediff = $end - $start;
			 $days = floor($datediff/(60*60*24));
			
			if($days == 0){
				$view = "jam";
			}else if($days >0 && $days <7){
				$view = "hari";
			}else if($days >7 && $days <30){
				$view = "minggu";
			}else if($days >30 && $days <365){
				$view = "bulan";
			}else{
				$view = "tahun";
			}
		}
		
		return $view;
	}
	public function get_count($gate_id='',$karyawan_id=''){
		if(!empty($karyawan_id)){
			$sql = "SELECT
						COUNT (thg.history_gate_id) jumlah
					FROM
						t_history_gate thg
					WHERE
						thg.gate_id = ".$gate_id." 
						AND thg.history_gate_date::date BETWEEN ".$_POST['period']." 
						AND thg.karyawan_id = ".$karyawan_id." ";
		}else{
			$sql = "SELECT
						COUNT (thg.history_gate_id) jumlah
					FROM
						v_history thg
					WHERE
						thg.history_gate_date::date BETWEEN ".$_POST['period']."
					AND thg.gate_id = ".$gate_id."
					";
		}
			
		$query = $this->db->query($sql);
		// var_dump($sql);
		return $query->row_array();
	}

	public function get_count_all_person()
	{
		$date = date('Y-m-d');
		$awal = substr(urldecode($_POST['period']), 1,10);
		$akhir = substr(urldecode($_POST['period']), 24,10);

		if((date('Y-m-d', strtotime($awal)) == $date) && (date('Y-m-d', strtotime($akhir)) == $date)){
			// $sql_inside = "
			// 		SELECT
			// 			count (kar.karyawan_id) jumlah
			// 		FROM
			// 			m_karyawan kar
			// 		WHERE
			// 			kar.last_gate_date::date = '".$date."' and kar.last_gate_id not in (4,5,6) and
			// 			(last_history_gate_status = 'Valid' or
			// 			last_history_gate_status = 'Valid TAG ' or
			// 			last_history_gate_status = 'Valid oleh satpam' or
			// 			last_history_gate_status = 'Valid Access' or
			// 			last_history_gate_status = 'Valid TAG  or  ANPR Not Valid')

			// ";
			$sql_inside = "
					SELECT
						count (kar.karyawan_id) jumlah
					FROM
						m_karyawan kar
					WHERE
						kar.last_gate_date::date = '".$date."' and kar.last_gate_id not in (4,5,6) and
						(last_history_gate_status in ('4','5','6','7','12','13'))

			";
		}else{
			$sql_inside = "
					SELECT COUNT (*) jumlah FROM
					(SELECT DISTINCT
						ON (karyawan_id, history_gate_tanggal) karyawan_id, history_gate_tanggal,
						a.*
					FROM
						(
							SELECT
								*,
								TO_CHAR(history_gate_date, 'YYYY-MM-DD') AS history_gate_tanggal
							FROM
								t_history_gate
							WHERE
								gate_id IN (1, 2, 3)
							AND history_gate_date BETWEEN ".$_POST['period']."
							AND (history_gate_status_id in ('4','5','6','7','12','13'))
							ORDER BY
								history_gate_id DESC
						) a) b
			";
		}
		$query = $this->db->query($sql_inside);
		return $query->result_array();
	}

	public function get_count_all_roda($gate_id)
	{
		$date = date('Y-m-d');
		$awal = substr(urldecode($_POST['period']), 1,10);
		$akhir = substr(urldecode($_POST['period']), 24,10);

		if((date('Y-m-d', strtotime($awal)) == $date) && (date('Y-m-d', strtotime($akhir)) == $date)){
			$sql_inside = "
					SELECT
						count (kar.karyawan_id) jumlah
					FROM
						m_karyawan kar
					WHERE
						kar.last_gate_date_kendaraan::date = '".$date."' and kar.last_gate_id_kendaraan = '".$gate_id."' and
						(last_history_gate_status_kendaraan in ('4','5','6','7','12','13'))

			";
		}else{
			$sql_inside = "
					SELECT COUNT (*) jumlah FROM
					(SELECT DISTINCT
						ON (karyawan_id, history_gate_tanggal) karyawan_id, history_gate_tanggal,
						a.*
					FROM
						(
							SELECT
								*,
								TO_CHAR(history_gate_date, 'YYYY-MM-DD') AS history_gate_tanggal
							FROM
								t_history_gate
							WHERE
								gate_id = ".$gate_id."
							AND history_gate_date BETWEEN ".$_POST['period']."
							AND (history_gate_status_id in ('4','5','6','7','12','13'))
							ORDER BY
								history_gate_id DESC
						) a) b
			";
		}
		$query = $this->db->query($sql_inside);
		return $query->result_array();
	}

	public function get_count_all_rodaXX($gate_id)
	{
		$date = date('Y-m-d');
		$sql_inside = "
				SELECT
					count (kar.karyawan_id) jumlah
				FROM
					m_karyawan kar
				WHERE
					kar.last_gate_date::date = '".$date."' and kar.last_gate_id_kendaraan = '".$gate_id."' and
					(last_history_gate_status_kendaraan = 'Valid' or
					last_history_gate_status_kendaraan = 'Valid TAG ' or
					last_history_gate_status_kendaraan = 'Valid oleh satpam' or
					last_history_gate_status_kendaraan = 'Valid Access' or
					last_history_gate_status_kendaraan = 'Valid TAG  or  ANPR Not Valid')
		";
		$query = $this->db->query($sql_inside);
		return $query->result_array();
	}

	public function count_wp(){
		$sql = "SELECT
					COUNT (wp.working_permit_id) jumlah
				FROM
					m_working_permit wp
				where wp.working_permit_tgl_mulai BETWEEN ".$_POST['period']."
				or wp.working_permit_tgl_sampai BETWEEN ".$_POST['period']."";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function count_kunjungan(){
		$sql = "SELECT
					COUNT (kun.kunjungan_id) jumlah
				FROM
					t_kunjungan kun
				where kun.kunjungan_tanggal BETWEEN ".$_POST['period']."
				or kun.kunjungan_tanggal BETWEEN ".$_POST['period']."";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function pie_in(){
		$sql = "SELECT
					mg.GATE_ID,
					mg.GATE_NAME,
					COALESCE(history.jumlah, 0) as jumlah
				FROM
					m_gate mg
				left join(SELECT
					COUNT (thg.history_gate_id) jumlah,
				thg.gate_id
				FROM
					t_history_gate thg
				WHERE
					thg.history_gate_date BETWEEN ".$_POST['period']."
				AND thg.gate_id IN ('1', '2', '3')
				GROUP BY
					thg.gate_id) history on (history.gate_id = mg.gate_id)
				WHERE
					mg.GATE_ID IN ('1', '2', '3')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function pie_out(){
		$sql = "SELECT
					mg.GATE_ID,
					mg.GATE_NAME,
					COALESCE(history.jumlah, 0) as jumlah
				FROM
					m_gate mg
				left join(SELECT
					COUNT (thg.history_gate_id) jumlah,
				thg.gate_id
				FROM
					t_history_gate thg
				WHERE
					thg.history_gate_date BETWEEN ".$_POST['period']."
				AND thg.gate_id IN ('4', '5', '6')
				GROUP BY
					thg.gate_id) history on (history.gate_id = mg.gate_id)
				WHERE
					mg.GATE_ID IN ('4', '5', '6')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function master_line(){
		$p = $this->viewme($_POST['fildate'], $_POST['period']);
		if($p == 'jam'){
			for($ik=0; $ik<=23; $ik++){
				if($ik<10){
					$rtn[$ik]['periode'] = "0".$ik;	
				}else{
					$rtn[$ik]['periode'] = $ik;	
				}
			}
			return $rtn;
		}else{
		$start = explode("AND", $_POST['period']);
		// var_dump(substr(str_replace(' ', '', $start[1]),1,10));
		$sql = "SELECT DISTINCT
					f_settime ('".$p."', CURRENT_DATE + i) AS periode, f_settime_order ('".$p."', CURRENT_DATE + i) AS orderan
				FROM
					generate_series (
						DATE '".substr(str_replace(' ', '', $start[0]),1,10)."' - CURRENT_DATE,
						DATE '".substr(str_replace(' ', '', $start[1]),1,10)."' - CURRENT_DATE
						
					) i
				ORDER BY
					orderan";
		$query = $this->db->query($sql);
		return $query->result_array();
		}
	}
	public function line_in(){
		$p = $this->viewme($_POST['fildate'], $_POST['period']);
		$sql="SELECT
					A .gate_id,
					SUM (A .jumlah) jumlah,
					A .periode
				FROM
					(
						SELECT
							gate_id,
							COUNT (gate_id) AS jumlah,
							f_settime ('".$p."', history_gate_date) AS periode
						FROM
							t_history_gate
						WHERE
							gate_id IN ('1', '2', '3')
						AND history_gate_date BETWEEN ".$_POST['period']."
						GROUP BY
							gate_id,
							periode
					) A
				GROUP BY
					A .gate_id,
					A .periode
				ORDER BY
					gate_id,
					periode ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function line_out(){
		$p = $this->viewme($_POST['fildate'], $_POST['period']);
		$sql="SELECT
					A .gate_id,
					SUM (A .jumlah) jumlah,
					A .periode
				FROM
					(
						SELECT
							gate_id,
							COUNT (gate_id) AS jumlah,
							f_settime ('".$p."', history_gate_date) AS periode
						FROM
							t_history_gate
						WHERE
							gate_id IN ('4', '5', '6')
						AND history_gate_date BETWEEN ".$_POST['period']."
						GROUP BY
							gate_id,
							periode
					) A
				GROUP BY
					A .gate_id,
					A .periode
				ORDER BY
					gate_id,
					periode ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_gate($filter='')
	{
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->order_by('gate_id', 'asc');
		return $this->db->get('m_gate');
	}

	public function get_last($filter='')
	{
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->order_by('history_gate_date', 'desc');
		return $this->db->get('v_history');
	}

	public function get_count_history($gate_id_in='',$gate_id_out='')
	{
		$date = date('Y-m-d');
		$sql_in = "
				SELECT
					count (thg.history_gate_id) jumlah
				FROM
					v_history thg
				WHERE
					thg.history_gate_date::date BETWEEN ".$_POST['period']." and thg.gate_id = '".$gate_id_in."'
		";
		$result_in = $this->db->query($sql_in)->row_array();

		$sql_out = "
				SELECT
					count (thg.history_gate_id) jumlah
				FROM
					v_history thg
				WHERE
					thg.history_gate_date::date BETWEEN ".$_POST['period']." and thg.gate_id = '".$gate_id_out."'
		";
		$result_out = $this->db->query($sql_out)->row_array();
		$existing = $result_in['jumlah']+$result_out['jumlah'];
		return $existing;
	}

	public function get()
	{
		$dataorder = array();
        $dataorder[1] = "gate_name";
        $dataorder[2] = "karyawan_nama";
        $dataorder[3] = "perusahaan_nama";
        $dataorder[4] = "card_keterangan";
		$dataorder[5] = "history_gate_date";
		$dataorder[6] = "history_gate_status_new";
        
        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        if($order){
            $order_sql = "order by
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }

        $query = "select
                *,
                row_number() over (".$order_sql.") rn
                from \"v_history\" ";

        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(gate_name) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(karyawan_nama) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(perusahaan_nama) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(card_keterangan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(history_gate_status_new) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        $mode = $this->input->post('mode');
        if($mode == 'history'){
			$gate_id_in = $this->input->post('gate_id_in');
			$gate_id_out = $this->input->post('gate_id_out');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_sampai = $this->input->post('tgl_sampai');

			if($tgl_mulai!='' || $tgl_sampai!=''){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "(history_gate_date::date BETWEEN '".$tgl_mulai."' AND '".$tgl_sampai."') ";
			}
			if($perusahaan_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "perusahaan_id = '".$perusahaan_id."' ";
			}

			$arr_gate_id = array($gate_id_in,$gate_id_out);
			$string_ar_gate = implode(",",$arr_gate_id);

			$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
			$query .= "gate_id in (".$string_ar_gate.") ";
			// $this->db->where_in('gate_id', $arr_gate_id);
			// $this->db->where('gate_id', $gate_id_out);
        }elseif($mode == 'more'){
			//filter
			$gate_id = $this->input->post('gate_id');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_sampai = $this->input->post('tgl_sampai');

			if($tgl_mulai!='' || $tgl_sampai!=''){
				// $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				// $query .= "history_gate_date::date <= '".$tgl_sampai."' ";
				// $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				// $query .= "history_gate_date::date >= '".$tgl_mulai."' ";
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "(history_gate_date::date BETWEEN '".$tgl_mulai."' AND '".$tgl_sampai."') ";
			}
			if($gate_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "gate_id = '".$gate_id."' ";
			}
			if($perusahaan_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "perusahaan_id = '".$perusahaan_id."' ";
			}

        }elseif($mode == 'existing_all_person'){
			//filter
			$date = date('Y-m-d');

			$awal = substr(urldecode($_POST['period']), 1,10);
			$akhir = substr(urldecode($_POST['period']), 24,10);

			if((date('Y-m-d', strtotime($awal)) == $date) && (date('Y-m-d', strtotime($akhir)) == $date)){
				$sql = "
					SELECT
						kar.last_history_gate_id
					FROM
						m_karyawan kar
					WHERE
						kar.last_gate_date::date = '".$date."' and kar.last_gate_id not in (4,5,6) and (last_history_gate_status in ('4','5','6','7','12','13'))
				";
				$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['last_history_gate_id']);
				}
			}else{
				$sql = "
	        			SELECT DISTINCT
							ON (karyawan_id, history_gate_tanggal) karyawan_id, history_gate_tanggal,
							a.*
						FROM
							(
								SELECT
									*,
									TO_CHAR(history_gate_date, 'YYYY-MM-DD') AS history_gate_tanggal
								FROM
									t_history_gate
								WHERE
									gate_id IN (1, 2, 3)
								AND history_gate_date BETWEEN ".urldecode($_POST['period'])."
								AND (history_gate_status_id in ('4','5','6','7','12','13'))
								ORDER BY
									history_gate_id DESC
							) a
	        	";
	        	$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['history_gate_id']);
				}
			}

			// $query2 = $this->db->query($sql);
			// $arr_history_gate_id = array();
			// foreach ($query2->result_array() as $q) {
			// 	array_push($arr_history_gate_id, $q['history_gate_id']);
			// }
			// var_dump($arr_history_gate_id);	
			$string_ar_history_id = implode(",", $arr_history_gate_id);

			$gate_id = $this->input->post('gate_id');
			$perusahaan_id = $this->input->post('perusahaan_id');
			
			if(count($arr_history_gate_id)>0){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "history_gate_id in (".$string_ar_history_id.") ";
			}

			if($gate_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "gate_id = '".$gate_id."' ";			  
			}
			if($perusahaan_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "perusahaan_id = '".$perusahaan_id."' ";	
			}
        }elseif($mode == 'existing_all_roda'){
			//filter
        	$date = date('Y-m-d');
        	// var_dump($date);
			$awal = substr(urldecode($_POST['period']), 1,10);
			$akhir = substr(urldecode($_POST['period']), 24,10);
			$gate_id_roda = $this->input->post('gate_id_roda');

			if((date('Y-m-d', strtotime($awal)) == $date) && (date('Y-m-d', strtotime($akhir)) == $date)){
				$sql = "
					SELECT
						kar.last_history_gate_id_kendaraan
					FROM
						m_karyawan kar
					WHERE
						kar.last_gate_date_kendaraan::date = '".$date."' and kar.last_gate_id_kendaraan = ".$gate_id_roda."
						AND (last_history_gate_status in ('4','5','6','7','12','13'))
				";
				// var_dump($query2);
				$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['last_history_gate_id_kendaraan']);
				}
			}else{
	        	$sql = "
	        			SELECT DISTINCT
							ON (karyawan_id, history_gate_tanggal) karyawan_id, history_gate_tanggal,
							a.*
						FROM
							(
								SELECT
									*,
									TO_CHAR(history_gate_date, 'YYYY-MM-DD') AS history_gate_tanggal
								FROM
									t_history_gate
								WHERE
									gate_id = ".$gate_id_roda."
								AND history_gate_date BETWEEN ".urldecode($_POST['period'])."
								AND (history_gate_status_id in ('4','5','6','7','12','13'))
								ORDER BY
									history_gate_id DESC
							) a
	        	";
	        	$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['history_gate_id']);
				}
			}
	        	

				

			$string_ar_history_id = implode(",", $arr_history_gate_id);

			$perusahaan_id = $this->input->post('perusahaan_id');
			
			if(count($arr_history_gate_id)>0){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "history_gate_id in (".$string_ar_history_id.") ";
			}
			
			if($perusahaan_id!='all'){
			  // $this->db->where('perusahaan_id', $perusahaan_id);
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "perusahaan_id = '".$perusahaan_id."' ";	
			}
        }elseif($mode=='more_spesific'){
        	//filter
			$gate_id = $this->input->post('gate_id');
			$karyawan_id = $this->input->post('karyawan_id');
			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_sampai = $this->input->post('tgl_sampai');

			$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
			$query .= "gate_id = '".$gate_id."' ";
			$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
			$query .= "karyawan_id = '".$karyawan_id."' ";

			if($tgl_mulai!='' || $tgl_sampai!=''){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "(history_gate_date::date BETWEEN '".$tgl_mulai."' AND '".$tgl_sampai."') ";
			}
        }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS numrows FROM (".$query.") A")->row()->numrows;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        // var_dump($query);
        $main_query = "select * from (".$query.") s
            where rn between " . ($start + 1) . " and " . (($start) + $iDisplayLength) . "
            ";

        $data = $this->db->query($main_query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $id = $d['history_gate_id'];
                
            $view='<a class="btn default btn-xs blue" onclick="btn_view2('.$id.');">
			<i class="fa fa-search"></i>
			Detail
			</a>';

            $r = array();
            $r[0] = $i;
            $r[1] = $d['gate_name'].'<br>'.$d['gate_keterangan'];
            $r[2] = $d['karyawan_nama'];
            $r[3] = $d['perusahaan_nama'];
            $r[4] = ($d['card_keterangan']) ? $d['card_keterangan'] : $d['encodeID'];
            $r[5] = date('d M Y', strtotime($d['history_gate_date'])).' ('.date('H:i', strtotime($d['history_gate_date'])).')';
            $r[6] = $d['history_gate_status_new'];
            $r[7] = $view;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	public function get_existing_roda()
	{
		$dataorder = array();
        $dataorder[1] = "gate_name";
        $dataorder[2] = "karyawan_nama";
        $dataorder[3] = "anpr_capture";
        $dataorder[4] = "perusahaan_nama";
        $dataorder[5] = "card_keterangan";
		$dataorder[6] = "history_gate_date";
		$dataorder[7] = "history_gate_status";
        
        $start = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        $gate_id_roda = $this->input->post('gate_id_roda');

        if($order){
            $order_sql = "order by
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }

        $query = "select
                *,
                row_number() over (".$order_sql.") rn
                from \"v_history\" ";

        if (!empty($search)) {
            $query .= preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
            $query .= " ( LOWER(gate_name) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(karyawan_nama) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(anpr_capture) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(perusahaan_nama) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(card_keterangan) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " OR LOWER(history_gate_status) LIKE '%".strtolower($search["value"])."%' ";
            $query .= " ) ";
        }

        $mode = $this->input->post('mode');
        // var_dump($mode);
        if($mode == 'existing_all_roda'){
			//filter
        	$date = date('Y-m-d');
        	$awal = substr(urldecode($_POST['period']), 1,10);
			$akhir = substr(urldecode($_POST['period']), 24,10);

			if((date('Y-m-d', strtotime($awal)) == $date) && (date('Y-m-d', strtotime($akhir)) == $date)){
				$sql = "
					SELECT
						kar.last_history_gate_id_kendaraan
					FROM
						m_karyawan kar
					WHERE
						kar.last_gate_date_kendaraan::date = '".$date."' and kar.last_gate_id_kendaraan = ".$gate_id_roda."
						AND (last_history_gate_status_kendaraan in ('4','5','6','7','12','13')) 
				";
				// var_dump($sql);
				$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['last_history_gate_id_kendaraan']);
				}
				if(count($arr_history_gate_id)>0){
					$string_ar_history_id = implode(",", $arr_history_gate_id);
					$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
					$query .= "history_gate_id in (".$string_ar_history_id.") ";

					$perusahaan_id = $this->input->post('perusahaan_id');
					
					if($perusahaan_id!='all'){
					  // $this->db->where('perusahaan_id', $perusahaan_id);
						$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
						$query .= "perusahaan_id = '".$perusahaan_id."' ";	
					}
				}else{
					$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
					$query .= "history_gate_id in (0) ";
				}
			}else{
	        	$sql = "
	        			SELECT DISTINCT
							ON (karyawan_id, history_gate_tanggal) karyawan_id, history_gate_tanggal,
							a.*
						FROM
							(
								SELECT
									*,
									TO_CHAR(history_gate_date, 'YYYY-MM-DD') AS history_gate_tanggal
								FROM
									t_history_gate
								WHERE
									gate_id = ".$gate_id_roda."
								AND history_gate_date BETWEEN ".urldecode($_POST['period'])."
								AND (history_gate_status_id in ('4','5','6','7','12','13'))
								ORDER BY
									history_gate_id DESC
							) a
	        	";
	        	$query2 = $this->db->query($sql);
				$arr_history_gate_id = array();
				foreach ($query2->result_array() as $q) {
					array_push($arr_history_gate_id, $q['history_gate_id']);
				}
				if(count($arr_history_gate_id)>0){
					$string_ar_history_id = implode(",", $arr_history_gate_id);
					$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
					$query .= "history_gate_id in (".$string_ar_history_id.") ";

					$perusahaan_id = $this->input->post('perusahaan_id');
					
					if($perusahaan_id!='all'){
					  // $this->db->where('perusahaan_id', $perusahaan_id);
						$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
						$query .= "perusahaan_id = '".$perusahaan_id."' ";	
					}
				}else{
					$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
					$query .= "history_gate_id in (0) ";
				}
			}
        }elseif($mode=='more'){
			//filter
			// $gate_id = $this->input->post('gate_id');
			$gate_id_roda = $this->input->post('gate_id');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_sampai = $this->input->post('tgl_sampai');

			if($tgl_mulai!='' || $tgl_sampai!=''){
				// $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				// $query .= "history_gate_date::date <= '".$tgl_sampai."' ";
				// $query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				// $query .= "history_gate_date::date >= '".$tgl_mulai."' ";
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "(history_gate_date::date BETWEEN '".$tgl_mulai."' AND '".$tgl_sampai."') ";
			}
			if($gate_id_roda!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "gate_id = '".$gate_id_roda."' ";
			}
			if($perusahaan_id!='all'){
				$query .=preg_match("/WHERE/i", $query) ? " AND " : " WHERE ";
				$query .= "perusahaan_id = '".$perusahaan_id."' ";
			}
		}

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS numrows FROM (".$query.") A")->row()->numrows;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        // var_dump($query);
        $main_query = "select * from (".$query.") s
            where rn between " . ($start + 1) . " and " . (($start) + $iDisplayLength) . "
            ";

        $data = $this->db->query($main_query)->result_array();
        $i = 0;
        $result = array();
        foreach ($data as $d) {
            $i++;
            $id = $d['history_gate_id'];
            $karyawan_id = $d['karyawan_id'];
            $gate_id = $d['gate_id'];
            if(in_array($gate_id, array(2,3,5,6))){
            	$query2 = "select * from t_kendaraan where t_kendaraan_karyawan_id='".$karyawan_id."' AND m_kendaraan_id='".$gate_id_roda."'";
            	$k = $this->db->query($query2)->row_array();
            }
                
            $view='<a class="btn default btn-xs blue" onclick="btn_view2('.$id.');">
			<i class="fa fa-search"></i>
			Detail
			</a>';

            $r = array();
            $r[0] = $i;
            $r[1] = $d['gate_name'].'<br>'.$d['gate_keterangan'];
            $r[2] = $d['karyawan_nama'];
            // $r[3] = @$k['t_kendaraan_plat'];
            $r[3] = $d['anpr_capture'];
            $r[4] = $d['perusahaan_nama'];
            $r[5] = $d['card_keterangan'];
            $r[6] = date('d M Y', strtotime($d['history_gate_date'])).' ('.date('H:i', strtotime($d['history_gate_date'])).')';
            $r[7] = $d['history_gate_status_new'];
            $r[8] = $view;
            array_push($result, $r);
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	function get2($start, $pagecount = 6,$count_all=false) {
        $dataorder = array();
        $dataorder[0] = "history_gate_id";
        $dataorder[1] = "gate_name";
        $dataorder[2] = "karyawan_nama";
        $dataorder[3] = "perusahaan_nama";
        $dataorder[4] = "card_keterangan";
		$dataorder[5] = "history_gate_date";

        $order = $this->input->post('order');
        $search = $this->input->post("search");

        if (!empty($search["value"])) {
            $this->db->or_like('LOWER(gate_name)', strtolower($search["value"]));
            $this->db->or_like('LOWER(karyawan_nama)', strtolower($search["value"]));
            $this->db->or_like('LOWER(perusahaan_nama)', strtolower($search["value"]));
            $this->db->or_like('LOWER(card_keterangan)', strtolower($search["value"]));
        }
        
        $mode = $this->input->post('mode');
        if($mode == 'existing'){
			$gate_id_in = $this->input->post('gate_id_in');
			$gate_id_out = $this->input->post('gate_id_out');
			$arr_gate_id = array($gate_id_in,$gate_id_out);
			$this->db->where('history_gate_date >', date('Y-m-d'));
			$this->db->where_in('gate_id', $arr_gate_id);
			// $this->db->where('gate_id', $gate_id_out);
        }elseif($mode == 'more'){
			//filter
			$gate_id = $this->input->post('gate_id');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tgl_mulai = $this->input->post('tgl_mulai');
			$tgl_sampai = $this->input->post('tgl_sampai');

			if($gate_id!='all'){
			  $this->db->where('gate_id', $gate_id);
			}
			if($perusahaan_id!='all'){
			  $this->db->where('perusahaan_id', $perusahaan_id);
			}

			if($tgl_mulai!='' || $tgl_sampai!=''){
			  $this->db->where('history_gate_date <=', $tgl_sampai);
			  $this->db->where('history_gate_date >=', $tgl_mulai);
			// $this->db->where('history_gate_date between '.$tgl_mulai.'and '.$tgl_sampai);
			}
        }elseif($mode == 'existing_all_person'){
			//filter
        	$date = date('Y-m-d');
        	$sql = "
				SELECT
					kar.last_history_gate_id
				FROM
					m_karyawan kar
				WHERE
					kar.last_gate_date::date = '".$date."' and kar.last_gate_id in (1,2,3)
			";

			$query = $this->db->query($sql);
			$arr_history_gate_id = array();
			foreach ($query->result_array() as $q) {
			array_push($arr_history_gate_id, $q['last_history_gate_id']);
			}

			$gate_id = $this->input->post('gate_id');
			$perusahaan_id = $this->input->post('perusahaan_id');

			$this->db->where_in('history_gate_id', $arr_history_gate_id);
			if($gate_id!='all'){
			  $this->db->where('gate_id', $gate_id);
			}
			if($perusahaan_id!='all'){
			  $this->db->where('perusahaan_id', $perusahaan_id);
			}
        }elseif($mode == 'existing_all_roda'){
			//filter
			$gate_id_roda = $this->input->post('gate_id_roda');
        	$date = date('Y-m-d');
        	$sql = "
				SELECT
					kar.last_history_gate_id
				FROM
					m_karyawan kar
				WHERE
					kar.last_gate_date::date = '".$date."' and kar.last_gate_id = ".$gate_id_roda."
			";

			$query = $this->db->query($sql);
			$arr_history_gate_id = array();
			foreach ($query->result_array() as $q) {
			array_push($arr_history_gate_id, $q['last_history_gate_id']);
			}

			
			$perusahaan_id = $this->input->post('perusahaan_id');

			
			if($perusahaan_id!='all'){
			  $this->db->where('perusahaan_id', $perusahaan_id);
			}
        } 

        if ($count_all) {
            return $this->db->count_all_results('v_history');
        }else{
            if ($order) {
                $this->db->order_by( $dataorder[$order[0]["column"]],  $order[0]["dir"]);
            }
            $result = $this->db->get('v_history',$pagecount,$start);
            return $result;
        } 
    }	
    
    function count_all(){
        return $this->get(null,null,true);
    }
}




/* End of file M_dashboard.php */
/* Location: ./application/modules/dashboard/models/M_dashboard.php */
?>