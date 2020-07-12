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
/**
* $Id: backend.php,v 1.6 2005/09/22 12:30:43 malanciault Exp $
* Module: Pages
* Author: The SmartFactory <www.smartfactory.ca>
* Adaptation : philou for the pages module
* Licence: GNU
*/

include_once("header.php");

include_once XOOPS_ROOT_PATH.'/class/template.php';
if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}

$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : -1 ;

if ($categoryid != -1) {
	$categoryObj = $smartsection_category_handler->get($categoryid);
}

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(0);
if (!$tpl->is_cached('db:pages_rss.html')) {
	$channel_category =  $xoopsModule->name();
	// Check if ML Hack is installed, and if yes, parse the $content in formatForML
	if (method_exists($myts, 'formatForML')) {
		$xoopsConfig['sitename'] = $myts->formatForML($xoopsConfig['sitename']);
		$channel_category =  $myts->formatForML($channel_category);		
	}
	$tpl->assign('channel_title', xoops_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
	$tpl->assign('channel_link', XOOPS_URL);
	$tpl->assign('channel_desc', xoops_utf8_encode(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
	$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
	$tpl->assign('channel_editor', $xoopsConfig['adminmail']);
	
	if ($categoryid != -1) {
		$channel_category .= " > " . $categoryObj->name();
	}
	
	$tpl->assign('channel_category', $channel_category);
	$tpl->assign('channel_generator', 'XOOPS');
	$tpl->assign('channel_language', _LANGCODE);
	$tpl->assign('image_url', XOOPS_URL.'/images/logo.gif');
	$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');
	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);

//philou
    $sql = "SELECT CID, pagetitle, pageheadline, weight, publishdate FROM " . $xoopsDB -> prefix( "pages" ) . " WHERE (publishdate > 0 AND publishdate <= " . time() . ") AND (expiredate = 0 OR expiredate > " . time() . ") ORDER BY weight";
    $result = $xoopsDB -> query( $sql, 10, 0 );
    if ( !$result )
    {
        echo "An error occured";
    } 
    else
    {

        while ( $myrow = $xoopsDB -> fetchArray( $result ) )
        {
            $myrow = str_replace( "(", "-", $myrow );
            $myrow = str_replace( ")", "-", $myrow );
            $myrow = str_replace( "'", "", $myrow );
        
       			$tpl->append('items', 
			      array('title' => xoops_utf8_encode(htmlspecialchars($myrow['pagetitle'], ENT_QUOTES)), 
			            'link' => XOOPS_URL . "/modules/pages/index.php?pagenum=" . $myrow['CID'] . "\">" .$myrow['pagetitle'], 
			            'guid' => $myrow['CID'], 
			            'pubdate' => formatTimestamp($myrow['publishdate'], 'rss'), 
			            'description' => xoops_utf8_encode(htmlspecialchars($myrow['pageheadline'], ENT_QUOTES))));
        
        
        } 
    } 
}
$tpl->display('db:pages_rss.html');
?>