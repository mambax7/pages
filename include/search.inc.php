<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

function page_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
	
	$sql = "SELECT CID, pagetitle, pageheadline, page, created FROM ".$xoopsDB->prefix("pages")." WHERE ";
    list($CID, $pagetitle, $pageheadline, $page, $htmlfile ) = $xoopsDB->fetchrow($sql);

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " ((pagetitle LIKE '%$queryarray[0]%' OR pageheadline LIKE '%$queryarray[0]%' OR page LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(pagetitle LIKE '%$queryarray[$i]%' OR pageheadline  LIKE '%$queryarray[$i]%' OR page LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY created DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['link'] = "index.php?pagenum=".$myrow['CID']."";
		$ret[$i]['title'] = $myrow['pagetitle'];
		$ret[$i]['time'] = $myrow['created'];
		$i++;
	}
	return $ret;
}
?>