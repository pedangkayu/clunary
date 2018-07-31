<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kasir extends CI_Model {

	function constanta($a){
		$query = mysql_query("SELECT * FROM constants WHERE variabel='$a'") or die(mysql_error());
		$r = mysql_fetch_assoc($query);
		$b=$r['var_value'];
		$a=$b/100;
		return $a;
	}

}

/* End of file M_kasir.php */
/* Location: ./application/modules/kasir/models/M_kasir.php */