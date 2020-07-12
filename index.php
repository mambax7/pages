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

include("header.php");
include_once(XOOPS_ROOT_PATH . "/header.php");

$op = '';
$pagenum = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_GET['pagenum'])) $pagenum = $_GET['pagenum'];
$storypage = isset($_GET['page']) ? intval($_GET['page']) : 0;

/**
  * get module permissions
*/
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler = &xoops_gethandler('groupperm');

if (!$gperm_handler->checkRight("Page_permissions", $pagenum, $groups, $xoopsModule->getVar('mid'))) {
	redirect_header(XOOPS_URL."/index.php", 3, _MD_NORIGHTTOVIEWPAGE);
  exit();
}

function display_menus()
{
	global $xoopsDB, $myts, $xoopsModule, $xoopsModuleConfig, $xoopsUser, $xoopsTpl, $groups, $gperm_handler;

	/**
  * get menu items if current page is default
  */

	if ($xoopsModuleConfig['displaymenu'] == 1)
	{
		include_once XOOPS_ROOT_PATH."/modules/pages/include/functions.php";
		//type of the bottom menu
		if ($xoopsModuleConfig['menunav'] == _MI_CHAN_MENUNAVTYPV)
		{ $xoopsTpl->assign('menunav', 'VERT');}
		else
		{ $xoopsTpl->assign('menunav', 'HORIZ');}

    $xoopsTpl->assign('otherpage', _MD_OTHERPAGE);

		$result2 = $xoopsDB->query("SELECT CID, pagetitle, pageheadline FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE (publishdate > 0 AND publishdate <= " . time() . ") AND (expiredate = 0 OR expiredate > " . time() . ") AND defaultpage = '0' AND mainpage = '1' ORDER BY weight");
		$total['total'] = $xoopsDB->getRowsNum($result2);

		while ($query_data = $xoopsDB->fetcharray($result2))
		{
			if (pages_IsPageVisible($query_data['CID']))
			{
				$chanlink['id'] = "?pagenum=".$query_data['CID'];
				$tmpvar = trim($query_data['pagetitle']);
				$chanlink['pagetitle'] = $myts->displayTarea($tmpvar);
				if (empty($query_data['pagetitle']))
				{
					$chanlink['pagetitle'] = $myts->displayTarea(trim($query_data['pageheadline']), 1);
				}
				$xoopsTpl->append('chanlink', $chanlink);
			}
		}
		$result3 = $xoopsDB->query("SELECT mainpage, titlelink FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_linktous") . "");

		list($linktous, $titlelink) = $xoopsDB->fetchrow($result3);

		if (intval($linktous) == 1)
		{
			if (is_object($xoopsUser))
			{
				$chanlink['id'] = "?op=link";
				$tmpvar = trim($titlelink);
				$chanlink['pagetitle'] = $myts->displayTarea($tmpvar,1);
				$xoopsTpl->append('chanlink', $chanlink);
			}
			elseif ($xoopsModuleConfig['anonlink'])
			{
				$chanlink['id'] = "?op=link";
				$chanlink['pagetitle'] = $myts->displayTarea(trim($titlelink),1);
				$xoopsTpl->append('chanlink', $chanlink);
			}
		}

		$result4 = $xoopsDB->query("SELECT mainpage, titlerefer FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . "");
		list($referafriend, $refertitle) = $xoopsDB->fetchrow($result4);

		if (intval($referafriend) == 1)
		{
			if (is_object($xoopsUser))
			{
				$chanlink['id'] = "?op=refer";
				$tmpvar = trim($refertitle);
				$chanlink['pagetitle'] = $myts->displayTarea($tmpvar,1);
				$xoopsTpl->append('chanlink', $chanlink);
			}
			elseif ($xoopsModuleConfig['anonrefer'])
			{
				$chanlink['id'] = "?op=refer";
				$chanlink['pagetitle'] = $myts->displayTarea(trim($refertitle),1);
				$xoopsTpl->append('chanlink', $chanlink);
			}
		}
	}
}

function get_page($pagenum, $pageset = 0, $default = 0)
{
	global $xoopsDB, $myts, $articletag, $xoopsModuleConfig, $xoopsUser, $xoopsModule, $xoopsTpl;
	$myts =& MyTextSanitizer::getInstance();

	$sql = "UPDATE " . $xoopsDB->prefix("pages") . " SET counter=counter+1 WHERE CID = " . intval($pagenum) . "";
	$result = $xoopsDB->queryF($sql);

	$page_details = "SELECT * FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE CID = " . intval($pagenum) . "";
	$pagedetails = $xoopsDB->fetchArray($xoopsDB->query($page_details));

// lien de modification

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname($xoopsModule->dirname());
    if ($xoopsUser->isAdmin($xoopsModule->mid())) {
        $adminlink = XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/index.php?op=mod&CID=". intval($pagenum);
        $xoopsTpl->assign('adminlink', "<a href='".$adminlink."'> <img src='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/Image/kedit.gif' alt='"._MD_MODIF."'> "._MD_MODIF." </a>");
    } else $xoopsTpl->assign('adminlink','');
}

//
	$html = ($pagedetails['html']) ? 0 : 1;
	$smiley = ($pagedetails['smiley']) ? 0 : 1;
	$xcodes = ($pagedetails['xcodes']) ? 0 : 1;
	$breaks = $pagedetails['breaks'];

	$articletag['allowcomments'] = intval($pagedetails['allowcomments']);

	if ($xoopsModuleConfig['displaypagetitle'] == 0 && $default == 1)
	{
		$articletag['headline'] = '';
	}
	else
	{
		$tmpvar=trim($pagedetails['pageheadline']);
		$articletag['headline'] = $myts->displayTarea($tmpvar);
		$tmpvar=trim($articletag['headline']);
		$pagetitle = $myts->displayTarea($tmpvar);
	}

	if (empty($pagedetails['htmlfile']))
	{
		$tmpvar = trim($pagedetails['page']);
		$articletag['maintext'] = $myts->displayTarea($tmpvar, $html, $smiley, $xcodes, 1, $breaks);
	}
	else
	{
		$maintextfile = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['htmluploaddir'] . "/" . $pagedetails['htmlfile'];
		if (file_exists($maintextfile) && false !== $fp = fopen($maintextfile, 'r'))
		{
			$articletag['maintext'] = fread($fp, filesize($maintextfile));
			fclose($fp);

			$articletag['maintext'] = $myts->makeTareaData4Show($articletag['maintext'], $html, $smiley, $xcodes, 1, $breaks);
		}
		else
		{
			$articletag['maintext'] = _MD_FILEERROR;
		}
	}
	$articletag['maintext'] = str_replace("\r\n", "", $articletag['maintext']);
	$articletag['maintext'] = str_replace("\n", "", $articletag['maintext']);
	$articletag['maintext'] = preg_replace("/\s+/", " ", $articletag['maintext']);
	$articletag['maintext'] = preg_replace('/(\n|\r|\r\n){2,}/', '', $articletag['maintext']);
	$articletag['maintext'] = preg_replace("/\n\n+/", "\n\n", $articletag['maintext']);
	$articletag['maintext'] = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array('', ''), $articletag['maintext']);
	$articletag['maintext'] = $myts->oopsStripSlashesGPC(trim($articletag['maintext']));

	$articletag['indeximage'] = '';
	if (!empty($pagedetails['indeximage']))
	{
		if (file_exists(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir'] . "/" . $myts->htmlSpecialChars($pagedetails['indeximage'])))
		{
			$articletag['indeximage'] = "<img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['uploaddir'] . "/" . $myts->makeTboxData4Show($pagedetails['indeximage']) . "' name='image' id='image' alt='' />";
		}
	}

createMetaTags($articletag['headline'], $articletag['maintext'], true);

    $search= $myts->makeTboxData4Save($articletag['headline']." ".$articletag['maintext']);
    include XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/html2text.inc';
    $htmlToText = new Html2Text ($search, 200);
    $search = $htmlToText->convert();
	$tmpvar = xoops_trim($search);
    $search = $myts->displayTarea($tmpvar, 1, 1, 1, 1, 1);

    $search = xoops_trim($search);

    // dernier retraitement des tags html
    $ascii_array=array_merge(array(34,38,60,62),range(160,255));
    $chars_array=array_map("chr", $ascii_array);
    $html_array=array_map("htmlentities", $chars_array);
    // Remplace les codes html par leurs équivalents txt dans le texte
    for($i=0; $i<count($ascii_array); $i++)
    {
      $search=ereg_replace($html_array[$i],$chars_array[$i],$search);
    }
    $search=ereg_replace("<br />"," ",$search);
    //elimine des faux positifs
    $search=ereg_replace("-//W3C//DTD HTML 4.0 Transitional//EN"," ",$search);
    $search=ereg_replace("name=AUTHOR"," ",$search);
    $search=ereg_replace("name=COPYRIGHT"," ",$search);
    $search=ereg_replace("name=DESCRIPTION"," ",$search);
    $search=ereg_replace("name=GENERATOR"," ",$search);
    $search=ereg_replace("border=0"," ",$search);
    $search=ereg_replace("'"," ",$search);
    $search=strip_tags($search);

	$sql = "UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()) . " SET search='".$search."' WHERE CID = " . intval($pagenum) . "";
	$result = $xoopsDB->queryF($sql);

	return $articletag;
}

switch ($op)
{
	case "refersend":

	include XOOPS_ROOT_PATH . "/class/xoopsmailer.php";

	Global $_POST, $myts, $xoopsUser;

	$result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . "");
	list($titlerefer, $chanrefheadline, $submenuitem, $mainpage, $referpagelogo, $emailaddress, $usersblurb, $defblurb) = $xoopsDB->fetchrow($result);

	$sname = (!empty($_POST['uname'])) ? $myts->htmlSpecialChars($_POST['uname']) : $xoopsUser->getVar("email");
	$semail = (!empty($_POST['email'])) ? $myts->htmlSpecialChars($_POST['email']) : $xoopsUser->getVar("email");
	$rname = (!empty($_POST['runame'])) ? $myts->htmlSpecialChars(trim($_POST['runame'])) : _MD_YOURFRIEND;
	$remail = $myts->htmlSpecialChars(trim($_POST['remail']));

	$emailadresses = array();
	// Lets do some checking now
	if (checkEmail(trim($_POST['email'])) == false)
	{
		$emailadresses['sender'] = trim($_POST['email']);
		$sender_email_invalid = 1;
	}
	if (checkEmail(trim($_POST['remail'])) == false)
	{
		$emailadresses['remail'] = trim($_POST['remail']);
		$recip_email_invalid = 1;
	}

	if (isset($sender_email_invalid) || isset($recip_email_invalid))
	{
		echo "<div align = \"center\"><br/></div><br/>";
		echo "<div align = \"center\"><b>" . _MD_EMAILSENDSENTERROR . "</b></div><br/>";
		echo "<div align = \"center\"><a href=\"index.php?op=refer\"><b>" . _MD_RETURNTOWHEREYOUWHERE . "</b></a></div>";
		include(XOOPS_ROOT_PATH . "/footer.php");
		exit();
	}

	$message = ($defblurb == 1) ? $myts->htmlSpecialChars($defblurb) : $myts->htmlSpecialChars($_POST['message']);
	$message = $myts->stripSlashesGPC($message);

	$subject = $sname . " " . _MD_MESSAGESUBECT;

	$xoopsMailer = &getMailer();
	$xoopsMailer->useMail();

	$xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/language/' . $xoopsConfig['language'] . '/mail_template');
	$xoopsMailer->setTemplate("refer.tpl");

	$xoopsMailer->assign("SITENAME", $xoopsConfig['sitename']);
	$xoopsMailer->assign("SITEURL", XOOPS_URL . "/");
	$xoopsMailer->assign("TITLE", _MD_MESSAGETITLE);
	$xoopsMailer->assign("SUSER", $sname);
	$xoopsMailer->assign("RUSER", $rname);
	$xoopsMailer->assign("MESSAGE", $message);
	$xoopsMailer->assign("VISIT", _MD_VISIT);

	$xoopsMailer->setToEmails($remail);
	$xoopsMailer->setFromEmail($semail);
	$xoopsMailer->setFromName($sname);
	$xoopsMailer->setSubject($subject);

	if (!$xoopsMailer->send(true))
	{
		$sql = "UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . " SET counter=counter+1";
		$result = $xoopsDB->queryF($sql);
		echo "<div align = \"center\"><b>" . _MD_EMAILSENTWITHERRORS . "</b></div><br/>";
		echo "<div align = \"center\"><a href=\"index.php?op=refer\"><b>" . _MD_RETURNTOWHEREYOUWHERE . "</b></a></div>";
		include(XOOPS_ROOT_PATH . "/footer.php");
		exit();
	} ;
	redirect_header("index.php?op=refer", 1, _MD_EMAILSENT);
	exit();
	break;

	case "refer":

	$xoopsOption['template_main'] = 'pages_refer.html';

	Global $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsUser;

	$usersblurb = '';

	$referfriend = array();
	$result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . "");
	list($titlerefer, $chanrefheadline, $submenuitem, $mainpage, $referpagelogo, $emailaddress, $usersblurb, $defblurb, $smiley, $xcodes, $breaks, $html, $privacy, $emailcheck, $privacy_statement) = $xoopsDB->fetchrow($result);

	$html = ($html == 1) ? 0 : 1;
	$smiley = ($smiley == 1) ? 0 : 1;
	$xcodes = ($xcodes == 1) ? 0 : 1;
	$breaks = ($breaks == 0) ? 1 : 0;
	$referfriend['textlink'] = $myts->makeTareaData4Show($titlerefer);
	$referfriend['chanrefheadline'] = $myts->displayTarea($chanrefheadline, $html, $smiley, $smiley, 1, $breaks);
	$referfriend['path'] = $xoopsModuleConfig['uploaddir'];
	$referfriend['linkpagelogo'] = ($referpagelogo == "blank.png" || !$referpagelogo) ? '' : $myts->htmlSpecialChars($referpagelogo);

// lien de modification

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname($xoopsModule->dirname());
    if ($xoopsUser->isAdmin($xoopsModule->mid())) {
        $adminlink = XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/index.php?op=refer";
        $xoopsTpl->assign('adminlink', "<a href='".$adminlink."'> <img src='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/Image/kedit.gif' alt='"._MD_MODIF."'> "._MD_MODIF." </a>");
    } else $xoopsTpl->assign('adminlink','');
}

//

	if ($emailaddress && is_object($xoopsUser))
	{
		$referfriend['uname'] = $xoopsUser->getVar('uname');
		$referfriend['emailaddy'] = $xoopsUser->getVar('email');
	}

	if ($usersblurb == 1)
	{
		$referfriend['usersblurb'] = $myts->makeTareaData4Show($usersblurb);
		$referfriend['defblurb'] = $myts->makeTareaData4Show($defblurb);
	}

	if ($privacy == 1)
	{
		$referfriend['privacy_statement'] = $myts->displayTarea($privacy_statement, 1, $smiley, $smiley, 1, $breaks);
	}

	$xoopsTpl->assign('referfriend', $referfriend);
	$xoopsTpl->assign('lang_sendername' , _MD_SENDERNAME);
	$xoopsTpl->assign('lang_senderemail' , _MD_SENDEREMAIL);
	$xoopsTpl->assign('lang_recipname' , _MD_RECPINAME);
	$xoopsTpl->assign('lang_reciptremail' , _MD_RECPIEMAIL);
	$xoopsTpl->assign('lang_writeblurb' , _MD_WRITEBLURB);
	$xoopsTpl->assign('lang_linktous' , $myts->makeTareaData4Show($titlerefer));
	$xoopsTpl->assign('lang_send' , _MD_SEND);
	$xoopsTpl->assign('lang_clear' , _MD_CLEAR);
	display_menus();

	break;

	case "link":

	$xoopsOption['template_main'] = 'pages_linktous.html';

	Global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $myts, $articletag, $xoopsModule;


	$logohtml = '';
	$titlelink = '';
	$allowcomments = 0;

	$linktous = array();
	$chanlink = array();

	$result = $xoopsDB->query("SELECT submenuitem, textlink, linkpagelogo, button, microbutton, logo, banner, mainpage, newsfeed, newsfeedjs, newstitle, titlelink, linkintro FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_linktous") . "");
	list($submenuitem, $textlink, $linkpagelogo, $button, $microbutton, $logo, $banner, $mainpage, $newsfeed, $newsfeedjs, $newstitle, $titlelink, $linkintro) = $xoopsDB->fetchrow($result);


// lien de modification
if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname($xoopsModule->dirname());
    if ($xoopsUser->isAdmin($xoopsModule->mid())) {
        $adminlink = XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/index.php?op=links";
        $xoopsTpl->assign('adminlink', "<a href='".$adminlink."'> <img src='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/Image/kedit.gif' alt='"._MD_MODIF."'> "._MD_MODIF." </a>");
    } else $xoopsTpl->assign('adminlink','');
}
//

	$linktous['textlink'] = $myts->makeTareaData4Show($textlink);
	$linktous['path'] = $xoopsModuleConfig['linkimages'];
	$linktous['linkpagelogo'] = ($linkpagelogo == "blank.png" || !$linkpagelogo) ? '' : $myts->htmlSpecialChars($linkpagelogo);
	$linktous['button'] = ($button == "blank.png" || !$button) ? '' : $myts->htmlSpecialChars($button);
	$linktous['microbutton'] = ($microbutton == "blank.png" || !$microbutton) ? '' : $myts->htmlSpecialChars($microbutton);
	$linktous['logo'] = ($logo == "blank.png" || !$logo) ? '' : $myts->htmlSpecialChars($logo);
	$linktous['logohtml'] = $myts->makeTboxData4Show($logohtml);
	$linktous['banner'] = ($banner == "blank.png" || !$banner) ? '' : $myts->htmlSpecialChars($banner);
	$linktous['sitename'] = $myts->makeTareaData4Show($xoopsConfig['sitename']);
	$linktous['newsfeed'] = $myts->makeTareaData4Show($newsfeed);
	$linktous['newsfeedjs'] = $myts->makeTareaData4Show($newsfeedjs);
	$linktous['newstitle'] = $myts->makeTareaData4Show($newstitle);
	$linktous['xoops_url'] = XOOPS_URL;

	$xoopsTpl->assign('linktous', $linktous);
	$xoopsTpl->assign('lang_linktous' , $myts->makeTareaData4Show($titlelink));
	$tmpvar=trim($linkintro);
	$xoopsTpl->assign('lang_linkintro' , $myts->makeTareaData4Show($tmpvar));
	$xoopsTpl->assign('lang_textexample' , _MD_TEXTLINKEXAMPLE);
	$xoopsTpl->assign('lang_buttonexample' , _MD_BUTTONLINKEXAMPLE);
	$xoopsTpl->assign('lang_microbuttonexample' , _MD_BUTTONLINKEXAMPLE);
	$xoopsTpl->assign('lang_logoexample' , _MD_LOGOLINKEXAMPLE);
	$xoopsTpl->assign('lang_bannerexample' , _MD_BANNERLINKEXAMPLE);
	$xoopsTpl->assign('lang_newsfeedexample' , _MD_NEWSFEEDLINKEXAMPLE);
	$xoopsTpl->assign('lang_newsfeedjsexample' , _MD_NEWSFEEDJSLINKEXAMPLE);
	$xoopsTpl->assign('lang_displaytext' , _MD_DISPLAYTEXTLINK);
	$xoopsTpl->assign('lang_displaybutton' , _MD_DISPLAYBUTTONLINK);
	$xoopsTpl->assign('lang_displaymicrobutton' , _MD_DISPLAYMICROBUTTONLINK);
	$xoopsTpl->assign('lang_displaylogo' , _MD_DISPLAYLOGOLINK);
	$xoopsTpl->assign('lang_displaybanner' , _MD_DISPLAYBANNERLINK);
	$xoopsTpl->assign('lang_displaynews' , _MD_DISPLAYNEWSLINK);
	$xoopsTpl->assign('lang_displaynewsrss' , _MD_DISPLAYNEWSRSSLINK);
	$xoopsTpl->assign('lang_displayjsnewsrss' , _MD_DISPLAYJSNEWSRSSLINK);
	$xoopsTpl->assign('lang_displayscript' , _MD_DISPLAYSCRIPT);
	$xoopsTpl->assign('lang_copyrightnotice' , _MD_COPYRIGHTNOTICE);
	display_menus();

	break;

	case "page":
	break;

	case "default":
	default:

	Global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $myts, $pagetitle;

	$xoopsOption['template_main'] = 'pages_index.html';

	$articletag = array();
	$chanlink = array();

	/**
         * gets the default page set by admin
         */
	if (isset($_GET['pagenum']))
	{
		$default = 0;
		$result = $xoopsDB->query("SELECT defaultpage FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE CID = " . intval($_GET['pagenum']) . "");
		list($defaultpage) = $xoopsDB->fetchrow($result);
		$articletag['defaultpage'] = ($defaultpage == 1) ? 1 : 0;
		get_page($_GET['pagenum'], 1, $articletag['defaultpage']);
	}
	else
	{
		$result = $xoopsDB->query("SELECT CID FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE defaultpage = '1'");
		list($CID) = $xoopsDB->fetchrow($result);
		get_page($CID, 0, 1);
	}

	if ( trim($articletag['maintext']) != '' ) {
    	$articletext = explode("[pagebreak]", $articletag['maintext']);
    	$story_pages = count($articletext);

    	if ($story_pages > 1) {
        	include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        	$pagenav = new XoopsPageNav($story_pages, 1, $storypage, 'page', 'pagenum='.$pagenum);
        	$xoopsTpl->assign('pagenav', $pagenav->renderNav());
        	//$xoopsTpl->assign('pagenav', $pagenav->renderImageNav());


        	if ($storypage == 0) {
            	$articletag['maintext'] = $articletext[$storypage];
        	} else {
            	$articletag['maintext'] = $articletext[$storypage];
        	}
    	}
	}
	display_menus();


	$xoopsTpl->assign('article', $articletag);
	$xoopsTpl->assign('lang_more', _MD_ALSOSEE);
// hack titre des pages
  $xoopsTpl->assign('xoops_pagetitle', $articletag['headline']);
//$xoopsTpl->assign('xoops_pagetitle', $myts->TboxData4Show($articletag->headline()));

// fin du hack

}
if (isset($articletag['allowcomments']) && $articletag['allowcomments'] == 1)
{
	include(XOOPS_ROOT_PATH . "/include/comment_view.php");
}
include(XOOPS_ROOT_PATH . "/footer.php");

?>