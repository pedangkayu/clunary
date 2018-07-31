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

function common_allowed_ip($host) {
	// next is an IP-based access control
	// reads IPs from the allowed_clients table
	// and only allows IPs present in that table to go on
	// if the table is empty, any host is allowed
	
	$query="SELECT * FROM `allowed_clients`";
	$res=common_query($query,__FILE__,__LINE__);
	if(!$res) return 0;
	// table is empty, everyone is allowed
	if(mysql_num_rows($res)==0) return true;
	
	$host=sprintf("%u",ip2long($host));
	
	$query="SELECT * FROM `allowed_clients` WHERE `host`='".$host."'";
	$res=common_query($query,__FILE__,__LINE__);
	if(!$res) return 0;
	
	return mysql_num_rows($res);
}

?>