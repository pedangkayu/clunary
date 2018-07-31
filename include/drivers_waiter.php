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
*/

function driver_apply($driver,$msg) {
	$debug = _FUNCTION_.' - Applying driver '.$driver.' - to msgline '.$msg.' '."\n"; 
	debug_msg(__FILE__,__LINE__,$debug);
	
	$driver_function='driver_'.$driver;
	if(function_exists($driver_function)) {
		$msg = $driver_function ($msg);
	} else {
		echo 'driver not found: '.$driver.'<br>'."\n";
		$debug = _FUNCTION_.' - driver '.$driver.' not found'."\n"; 
		error_msg(__FILE__,__LINE__,$debug);
	}

	if (!CONF_DEBUG_PRINT_MARKUP) {
		// cleans all not used markups
		$msg = preg_replace ("/{[^}]*}/", "", $msg);
	}

	return $msg;
}

?>