<?php
/**
* My Handy Restaurant
*
* http://www.myhandyrestaurant.org
*
* My Handy Restaurant is a restaurant complete management tool.
* Visit {@link http://www.myhandyrestaurant.org} for more info.
* Copyright (C) 2003-2005 Fabio De Pascale
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* @author		Fabio 'Kilyerd' De Pascale <public@fabiolinux.com>
* @package		MyHandyRestaurant
* @copyright		Copyright 2003-2005, Fabio De Pascale
* @copyright	Copyright 2006-2012, Gjergj Sheldija
*/

class table extends object {
	function table($id=0) {
		$this->db = 'common';
		$this->table='sources';
		$this->id=$id;
		$this->title = ucphr('TABLES');
		$this->file=ROOTDIR.'/admin/admin.php';
		$this->fields_show=array('id','ordernum','name','takeaway','visible','locktouser');
		$this->fields_names=array(	'id'=>ucphr('ID'),
								'ordernum'=>ucphr('ORDER'),
								'name'=>ucphr('NAME'),
								'takeaway'=>ucphr('TAKEAWAY'),
								'visible'=>ucphr('VISIBLE'),
								'locktouser'=>ucphr('locktouser'));
		$this->fields_width=array(	'name'=>'100%');
		$this->allow_single_update = array ('takeaway','visible');
		$this->fields_boolean=array('takeaway','visible');
		$this->fetch_data();
	}
	
	function list_search ($search) {
		$query = '';
		
		$table = $this->table;
		$lang_table = $table."_".$_SESSION['language'];
		
		$query="SELECT
				$table.`id`,
				$table.`name`,
				RPAD('".ucphr('TABLES')."',30,' ') as `table`,
				'".TABLE_TABLES."' as `table_ID`
				FROM `$table`
				WHERE $table.`name` LIKE '%$search%'
				";
		
		return $query;
	}
	
	function list_query_all () {
		$table = "sources";
		
		$query="SELECT
				$table.`id`,
				$table.`ordernum`,
				$table.`name`,
				$table.`locktouser`,
				IF($table.`takeaway`='0','".ucphr('NO')."','".ucphr('YES')."') as `takeaway`,
				IF($table.`visible`='0','".ucphr('NO')."','".ucphr('YES')."') as `visible`
				 FROM `$table`
				";
		
		return $query;
	}
	
	//RTG: included for performance, better than generic get that imply one query
	//see use in
	function getToClose() {
		return $this->fields_boolean['toclose'];   
	}
	
	function is_empty (){
		$query = "SELECT * FROM `orders` WHERE `sourceid`='".$this->id."'";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return true;
		
		return !mysql_num_rows($res);
	}
	
	function total ($discount=0) {
		$total=0;
		$query ="SELECT * FROM `orders` WHERE `sourceid`='".$this->id."'";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return 0;
		while ($arr = mysql_fetch_array ($res)) {
			$total=$total+$arr['price'];
		}
		
		if($discount) {
			$this->get("discount");
			$total=$total+$discount;
		}

		$total=sprintf("%01.2f",$total);
		return $total;
	}

	function list_orders($output='orders_list',$orderid=0,$mods=false) {
		if($this->is_empty()) return 1;
		
		global $tpl;
		
		$tmp = '
		<table bgcolor="'.COLOR_TABLE_GENERAL.'">';
		$tpl -> append ($output,$tmp);
		
		if(!$orderid) {
			$tmp = '
		<thead>
		<tr>
		<th scope=col><font size="-1">'.ucfirst(phr('NUMBER_ABBR')).'</font></th>
		<th scope=col><font size="-1">'.ucfirst(phr('NAME')).'</font> </th>
		<th scope=col></th>
		<th scope=col><font size="-1">'.ucfirst(phr('PRICE')).'</font></th>
		<th scope=col><font size="-1">'.ucfirst(phr('PRIORITY_ABBR')).'</font></th>
		<th scope=col></th>
		<th scope=col> </th>
		</tr>
		</thead>
';
			$tpl -> append ($output,$tmp);
		} else {
			$tmp = '
		<thead>
		<tr height="10px">
		<th colspan="9"><font size="-2">'.ucfirst(phr('LAST_OPERATION')).'</font></th>
		</tr>
		</thead>
';
			$tpl -> append ($output,$tmp);
		}
		
		$tmp = '
		<tbody>';
		$tpl -> append ($output,$tmp);
		
		$query="SELECT * FROM `orders` WHERE `sourceid`='".$this->id."'";
		if($orderid && $mods) $query .= " AND `associated_id`='".$orderid."'";
		elseif($orderid && !$mods) $query .= " AND `id`='".$orderid."'";
		
		if(!get_conf(__FILE__,__LINE__,"orders_show_deleted")) $query .= " AND `deleted`='0'";
		$query .=" ORDER BY priority ASC, associated_id ASC, dishid DESC, id ASC";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$dishnames[] =$ord ->  table_row_name ($arr);
			unset ($ord);
		}

		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$tmp = $ord -> table_row ($arr);
			$tpl -> append ($output,$tmp);
			unset ($ord);
		}
		
		$class = COLOR_TABLE_TOTAL;
		
		// prints a line with the grand total
		$tmp = '
		<tr>
		<td bgcolor="'.$class.'"></td>
		<td bgcolor="'.$class.'">'.ucfirst(phr('TOTAL')).'</td>
		<td bgcolor="'.$class.'"></td>
		<td bgcolor="'.$class.'">'.$this->total().'</td>
		<td bgcolor="'.$class.'"></td>
		<td bgcolor="'.$class.'"></td>
		<td bgcolor="'.$class.'"></td>
		</tr>
		</tbody>
		</table>
		';
		if(!$orderid) $tpl -> append ($output,$tmp);

		// prints a line with the grand total
		$tmp = '
		</tbody>
		</table>
		';
		if($orderid) $tpl -> append ($output,$tmp);
		
		return 0;
	}

	
	function list_orders_only_pos($orderid=0,$mods=false) {
		global $tpl;
		$tpl->clearTemplate();
		
		if($this->is_empty()) return 1;

		$tmp = '
		<table class="receipt-table">';

		if(!$orderid) {
			$tmp .= '
				<thead>
				<tr>
				<th scope=col>'.ucfirst(phr('NUMBER_ABBR')).'</th>
				<th scope=col> </th>
				<th scope=col>'.ucfirst(phr('NAME')).'</th>
				<th scope=col>'.ucfirst(phr('PRIORITY_ABBR')).'</th>
				<th scope=col>'.ucfirst(phr('PRICE')).'</th>
				<th scope=col> </th>
				<th scope=col> </th>
				<th scope=col> </th>
				</tr>
				</thead>';
		} else {
			$tmp .= '
				<thead>
				<tr height="10px">
				<th colspan="9">'.ucfirst(phr('LAST_OPERATION')).'</th>
				</tr>
				</thead>';
		}

		$tmp .= '
		<tbody>';

		$query="SELECT * FROM `orders` WHERE `sourceid`='".$this->id."'";
		if($orderid && $mods) $query .= " AND `associated_id`='".$orderid."'";
		elseif($orderid && !$mods) $query .= " AND `id`='".$orderid."'";

		if(!get_conf(__FILE__,__LINE__,"orders_show_deleted")) $query .= " AND `deleted`='0'";
		$query .=" ORDER BY priority ASC, associated_id ASC, dishid DESC, id ASC";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();

		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$dishnames[] = $ord->table_row_name ($arr);
			unset ($ord);
		}

		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();

		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$tmp .= $ord->table_row_pos ($arr);
			unset ($ord);
		}

		$class = COLOR_TABLE_TOTAL;

		// prints a line with the grand total
		$tmp .= '
			<tr>
			<td class="alt">&nbsp;</td>
			<td><strong>'.ucfirst(phr('TOTAL')).'</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong>'.$this->total().'</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</tbody>
			</table>';

		// prints a line with the grand total
		$tmp .= '
			</tbody>
			</table>';
		return $tmp;
	}
	
	function list_orders_pos($output='orders_list',$orderid=0,$mods=false) {
		if($this->is_empty()) return 1;
		global $tpl;

		$tmp = '
		<table class="receipt-table">';
		$tpl->append ($output,$tmp);
		
		if(!$orderid) {
			$tmp = '
				<thead>
					<tr>
						<th scope=col>'.ucfirst(phr('NUMBER_ABBR')).'</th>
						<th scope=col>'.ucfirst(phr('NAME')).'</th>
						<th scope=col> </th>
						<th scope=col>'.ucfirst(phr('PRIORITY_ABBR')).'</th>
						<th scope=col>'.ucfirst(phr('PRICE')).'</th>
						<th scope=col> </th>
						<th scope=col> </th>
						<th scope=col> </th>
					</tr>
				</thead>';
			$tpl->append ($output,$tmp);
		} else {
			$tmp = '
				<thead>
				<tr height="10px">
				<th colspan="9"><font size="-2">'.ucfirst(phr('LAST_OPERATION')).'</font></th>
				</tr>
				</thead>';
			$tpl->append ($output,$tmp);
		}
		
		$tmp = '
		<tbody>';
		$tpl->append ($output,$tmp);
		
		$query="SELECT * FROM `orders` WHERE `sourceid`='".$this->id."'";
		if($orderid && $mods) $query .= " AND `associated_id`='".$orderid."'";
		elseif($orderid && !$mods) $query .= " AND `id`='".$orderid."'";
		
		if(!get_conf(__FILE__,__LINE__,"orders_show_deleted")) $query .= " AND `deleted`='0'";
		$query .=" ORDER BY priority ASC, associated_id ASC, dishid DESC, id ASC";
		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$dishnames[] =$ord->table_row_name ($arr);
			unset ($ord);
		}

		$res=common_query($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		while ($arr = mysql_fetch_array ($res)) {
			$ord = new order ($arr['id']);
			$tmp = $ord->table_row_pos ($arr);
			$tpl->append ($output,$tmp);
			unset ($ord);
		}
		
		$class = COLOR_TABLE_TOTAL;
		
		// prints a line with the grand total
		$tmp = '
			<tr>
			<td>&nbsp;</td>
			<td><strong>'.ucfirst(phr('TOTAL')).'</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong>'.$this->total().'</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</tbody>
			</table>';
		if(!$orderid) $tpl->append ($output,$tmp);

		// prints a line with the grand total
		$tmp = '
			</tbody>
			</table>';
		if($orderid) $tpl->append ($output,$tmp);
		return 0;
	}	
	
	function move_list_tables ($cols=1){
		global $tpl;
		
		$query = "SELECT * FROM `sources` WHERE `userid`='0'";
		$query .= " AND `toclose` = '0'";
		$query .= " AND `discount` = '0.00'";
		$query .= " AND `paid` = '0'";
		$query .= " AND `catprinted` = ''";
		$query .= " AND `takeaway` = '0'";
		$query .= " AND `visible` = '1'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		if(!mysql_num_rows($res)) return 1;
	
		$output .= ucfirst(phr('ALL_TABLES')).':';
	
		$output .= '
<table cellspacing="2" bgcolor="'.COLOR_TABLE_GENERAL.'" width="100%">
	<tbody>'."\n";
	
		while ($arr = mysql_fetch_array ($res)) {
			$output .= '
	<tr>'."\n";
			for ($i=0;$i<$cols;$i++){
	
				if(!$tmp = $this->move_list_cell ($arr)) {
					$i--;
				} else $output .= $tmp;
				
				if($i != ($cols - 1)) {
					$arr = mysql_fetch_array ($res);
				}
			}
		$output .= '
	</tr>';
		}

		$output .= '
	</tbody>
</table>
';
	$tpl -> assign ('tables',$output);

	return 0;	
	}

	function move_list_cell ($arr){
		$query = "SELECT * FROM `orders` WHERE `sourceid`='".$arr['id']."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return '';
		
		if(table_there_are_orders($arr['id'])) return '';
		
		$link = 'orders.php?command=move&amp;data[id]='.$arr['id'];
		$output .= '
		<td bgcolor="'. COLOR_TABLE_FREE.'" onclick="redir(\''.$link.'\');">
			<a href="'.$link.'">'.$arr['name'].'</a>
		</td>';
	
		return $output;
	}
		
	function move($destination){
		
		// copies old table info
		$query="SELECT * FROM `sources` WHERE `id`='".$this->id."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		$arr_old = mysql_fetch_array($res,MYSQL_ASSOC);
		
		//delete the info we don't want to copy
		unset ($arr_old['id']);
		unset ($arr_old['name']);
		unset ($arr_old['takeaway']);
		
		$query="SELECT * FROM `sources` WHERE `id`='".$destination."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		$arr_new=mysql_fetch_array($res,MYSQL_ASSOC);
	
		// last check before begin: is the table really empty?
		if($arr_new['userid']!=0
			|| $arr_new['toclose']!=0
			|| $arr_new['discount']!=0
			|| $arr_new['paid']!=0
			|| $arr_new['catprinted']!=''){
			return 1;
		}
	
		// moves all the orders
		$query="UPDATE `orders` SET `sourceid` = '".$destination."' WHERE `sourceid`='".$this->id."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
	
		// copies table properties
		$query="UPDATE `sources` SET ";
		foreach ($arr_old as $key => $value ) {
			$query.="`".$key."`='".$value."',";
		}
		// strips the last comma that has been put
		$query = substr ($query, 0, strlen($query)-1);
		$query.=" WHERE `id`='".$destination."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
		
		// empties the old table
		$query = "UPDATE `sources` SET `userid`='0',`toclose`='0',`discount` = '0.00',`paid` = '0',`catprinted` = '',`last_access_userid` = '0' WHERE `id` = '".$this->id."'";
		$res=common_query ($query,__FILE__,__LINE__);
		if(!$res) return mysql_errno();
	
		return 0;
	}
	
}
?>