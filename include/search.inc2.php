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
// original file search created by Hervé Thouzard                            //
// ------------------------------------------------------------------------- //

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

function page_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsUser;

	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname('pages');
	$modid= $module->getVar('mid');
    	$searchparam='';

	$gperm_handler =& xoops_gethandler('groupperm');
	if (is_object($xoopsUser)) {
	    $groups = $xoopsUser->getGroups();
	} else {
		$groups = XOOPS_GROUP_ANONYMOUS;
	}

	$sql = "SELECT CID, pagetitle, pageheadline, search created FROM ".$xoopsDB->prefix("pages")." WHERE (publishdate>0 AND expiredate<=".time().") ";
	
	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND  ((pagetitle LIKE '%$queryarray[0]%' OR pageheadline LIKE '%$queryarray[0]%' OR search LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(pagetitle LIKE '%$queryarray[$i]%' OR pageheadline  LIKE '%$queryarray[$i]%' OR search LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}

	$sql .= "ORDER BY publishdate DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
		$display=true;
		if($modid && $gperm_handler) {
			if ($restricted && !$gperm_handler->checkRight("news_view", $myrow['topicid'], $groups, $modid)) {
				$display=false;
			}
		}

		if ($display) {
			$ret[$i]['link'] = "index.php?pagenum=".$myrow['CID']."".$searchparam;
			$ret[$i]['title'] = $myrow['pagetitle']." - ".$myrow['pageheadline'];
			$ret[$i]['time'] = $myrow['created'];
			
			$i++;
		}
	}

	// Set this var to FALSE to not use the search in the comments
	$searchincomments=true;

	if($searchincomments && (isset($limit) && $i<=$limit)) {
		include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
		$ind=$i;
		$sql = "SELECT com_id, com_modid, com_itemid, com_created, com_uid, com_title, com_text, com_status FROM ".$xoopsDB->prefix("xoopscomments")." WHERE (com_id>0) AND (com_modid=$modid) AND (com_status=".XOOPS_COMMENT_ACTIVE.") ";
		if ( $userid != 0 ) {
			$sql .= " AND com_uid=".$userid." ";
		}

		if ( is_array($queryarray) && $count = count($queryarray) ) {
			$sql .= " AND ((com_title LIKE '%$queryarray[0]%' OR com_text LIKE '%$queryarray[0]%')";
			for($i=1;$i<$count;$i++){
				$sql .= " $andor ";
				$sql .= "(com_title LIKE '%$queryarray[$i]%' OR com_text LIKE '%$queryarray[$i]%')";
			}
			$sql .= ") ";
		}
		$i=$ind;
		$sql .= "ORDER BY com_created DESC";
		$result = $xoopsDB->query($sql,$limit,$offset);
		while($myrow = $xoopsDB->fetchArray($result)) {
			$display=true;
			if($modid && $gperm_handler) {
				if ($restricted && !$gperm_handler->checkRight("Page_permissions", $myrow['com_itemid'], $groups, $modid)) {
					$display=false;
				}
			}
			if($i+1>$limit) {
				$display=false;
			}

			if ($display) {
				$ret[$i]['link'] = "index.php?pagenum=".$myrow['com_itemid']."".$searchparam;
				$ret[$i]['title'] = $myrow['com_title'];
				$ret[$i]['time'] = $myrow['com_created'];
				$ret[$i]['uid'] = $myrow['com_uid'];
				$i++;
			}
		}
	}

	return $ret;
}
?>