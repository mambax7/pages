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
* $Id: metagen.php,v 1.2 2004/09/02 14:26:57 malanciault Exp $
* Module: Edito
* Author: The SmartFactory
* Licence: GNU
*/

function findKeyWordsInSting($text, $minChar)
{
//	$myts =& MyTextSanitizer::getInstance();

$MIN_SIZE = $minChar;
$MIN_OCCURENCES = 2;
$MAX_OCCURENCES = rand(4, 9);

$arr = spliti("[^a-z0-9]+",$text);

 $idx = array();
 foreach($arr as $word)
	{
	trim($word);

	if(strlen($word) >= $MIN_SIZE) {;
			$word = strtolower($word);
			@$idx[$word]++;
		}
	}

 arsort ($idx);
 $tab=array();
 $i=0;
 foreach($idx as $word => $cnt)
	{

	if ($cnt >= $MIN_OCCURENCES AND $cnt <= $MAX_OCCURENCES)
		{
		$tab[$i++] = $word;

//	echo "[".$i."]".$word.$cnt."<br />";
 	if( $i == 40 ) { return $tab; }
		}
	}
return $tab;
}

function createMetaTags($title, $content, $online, $minChar = 4)
{
	global $xoopsTpl, $xoopsModule, $xoopsModuleConfig;
	$myts =& MyTextSanitizer::getInstance();

	$ret = '';

	$title = strip_tags($title);
	$title = $myts->displayTarea($title);
	$title = strip_tags($title);
	$title = $myts->undoHtmlSpecialChars($title);

	$content = strip_tags($content);
	$content = $myts->displayTarea($content);
	$content = strip_tags($content);
	$content = $myts->undoHtmlSpecialChars($content);

	// Creating Meta Keywords from content
	If (isset($content)) {
		$keywords = str_replace("d'", "", $title." ".$content);
		$keywords = str_replace("l'", "", $keywords);
		$keywords = str_replace("t'", "", $keywords);
		$keywords = str_replace("m'", "", $keywords);
		$keywords = str_replace("s'", "", $keywords);
		$keywords = str_replace("n'", "", $keywords);
		$keywords = eregi_replace("[[:punct:]]"," ", $keywords);
 		$keywords = eregi_replace("[[:digit:]]"," ", $keywords);
		$keywords = trim($keywords);

		$keywords = findKeyWordsInSting($keywords, $minChar);

	// Add module custom keywords - if any
		If (isset($xoopsModuleConfig) && isset($xoopsModuleConfig['moduleMetaKeywords']) && $xoopsModuleConfig['moduleMetaKeywords'] != '') {
			$moduleKeywords = explode(",", $xoopsModuleConfig['moduleMetaKeywords']);
			foreach ($moduleKeywords as $moduleKeyword) {
				If (!in_array($moduleKeyword, $keywords)) {
					$keywords[] = trim($moduleKeyword);
				}
			}
		}

		$keywordsCount = count($keywords);
		for ($i = 0; $i < $keywordsCount AND $i < 40; $i++) {
			$ret .= $keywords[$i];
			if ($i < $keywordsCount -1 AND $i < 39) {
				$ret .= ', ';
			}
		}

		$xoopsTpl->assign('xoops_meta_keywords', $ret);
	}

	// Creating Meta Description
	If (isset($xoopsModuleConfig) && isset($xoopsModuleConfig['moduleMetaDescription']) && $xoopsModuleConfig['moduleMetaDescription'] != '') {
		$xoopsTpl->assign('xoops_meta_description', $xoopsModuleConfig['moduleMetaDescription']);
	}

	// Creating Page Title
	$tmpvar=$xoopsModule->name();
	$moduleName = $myts->displayTarea($tmpvar);
	If (isset($xoopsModule)) {
		$ret = '';

If ($online) { $ret = $moduleName  .' - ' ; }

		If (isset($title) && ($title != '') && (strtoupper($title) != strtoupper($moduleName))) {
			$ret .= $title;
		}
		$xoopsTpl->assign('xoops_pagetitle', $ret);
	}

}

?>