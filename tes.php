<?php
public function get($table, $filter='')
{
	if(!empty($filter)){
		$this->db->where($filter);
	}
	$this->db->get($table);
}
?>