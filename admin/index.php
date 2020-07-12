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

include("admin_header.php");
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

global $xoopsModule;

$op = '';

if (isset($_POST))
{
    foreach ($_POST as $k => $v)
    {
        ${$k} = $v;
    }
}

if (isset($_GET))
{
    foreach ($_GET as $k => $v)
    {
        ${$k} = $v;
    }
}

function edittopic($CID = '')
{
    $html = 0;
    $smiley = 0;
    $xcodes = 0;
    $pagetitle = '';
    $pageheadline = '';
    $page = '';
    $breaks = 1;
    $defaultpage = 0;
    $indeximage = '';
    $weight = 1;
    $htmlfile = '';
    $mainpage = 1;
    $submenu = 1;
    $allowcomments = 1;
    $submenu = 0;
    $doctitle = 0;
    $publishdate = 0;
    $expiredate = 0;

    Global $xoopsUser,$xoopsUser,$xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $myts;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    if ($CID)
    {
        $result = $xoopsDB->query("SELECT CID,pagetitle, pageheadline, page, weight, html, smiley, xcodes, breaks, defaultpage, indeximage, htmlfile, mainpage, submenu, created, comments, allowcomments, usedoctitle, publishdate, expiredate  FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE CID = ".intval($CID));
        list($CID, $pagetitle, $pageheadline, $page, $weight, $html, $smiley, $xcodes, $breaks, $defaultpage, $indeximage, $htmlfile, $mainpage, $submenu, $created, $comments, $allowcomments, $doctitle, $publishdate, $expiredate) = $xoopsDB->fetchrow($result);
        if ($xoopsDB->getRowsNum($result) == 0)
        {
            redirect_header("index.php", 1, _AM_NOTOPICTOEDIT);
            exit();
        }
        xoops_cp_header();
        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../language/".$xoopsConfig['language']."/help/index.html' ><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);

        $sform = new XoopsThemeForm(_AM_MODIFYCHAN . ": " . $pagetitle, "op", xoops_getenv('PHP_SELF'));
    }
    else
    {
        xoops_cp_header();
        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../language/".$xoopsConfig['language']."/help/index.html' ><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);

        $sform = new XoopsThemeForm(_AM_ADDCHAN, "op", xoops_getenv('PHP_SELF'));
    }

    if (!$indeximage) $indeximage = "blank.png";
    $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir']);
    $indeximage_select = new XoopsFormSelect('', 'indeximage', $indeximage);
    $indeximage_select->addOptionArray($graph_array);
    $indeximage_select->setExtra("onchange='showImgSelected(\"image1\", \"indeximage\", \"" . $xoopsModuleConfig['uploaddir'] . "\", \"\", \"" . XOOPS_URL . "\")'");
    $indeximage_tray = new XoopsFormElementTray(_AM_CHAIMAGE, '&nbsp;');
    $indeximage_tray->addElement($indeximage_select);
    $indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['uploaddir'] . "/" . $indeximage . "' name='image1' id='image1' alt='' />"));
    $sform->addElement($indeximage_tray);

    $sform->addElement(new XoopsFormText(_AM_CHANW, 'weight', 4, 4, $weight));
    $pagetitle = $myts->htmlSpecialChars($myts->stripSlashesGPC($pagetitle));
    $sform->addElement(new XoopsFormText(_AM_CHANQ, 'pagetitle', 50, 255, $pagetitle), true);
    $pageheadline = $myts->htmlSpecialChars($myts->stripSlashesGPC($pageheadline));
    $sform->addElement(new XoopsFormText(_AM_CHANHDL, 'pageheadline', 50, 255, $pageheadline), false);

	 if ($xoopsModuleConfig['html_import_show']) {
    $sform->insertBreak("<b>" . _AM_PAGEHTMLBODY . "</b>", 'bg3');

    $doctitle_radio = new XoopsFormRadioYN(_AM_DOCTITLE, 'doctitle', $doctitle, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($doctitle_radio);

    $connect = (!empty($htmlfile)) ? 0 : 1;
    $htmlfile_checkbox = new XoopsFormCheckBox('', 'connect', $connect);
    $htmlfile_checkbox->addOption('', _AM_CONNECTHTML);
    $htmlfile_tray = new XoopsFormElementTray(_AM_CHANHTML, '');

    ob_start();
    wfc_htmlarray($htmlfile, XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['htmluploaddir']);
    $htmlfile_tray->addElement(new XoopsFormLabel('', ob_get_contents()));
    ob_end_clean();

    $htmlfile_tray->addElement($htmlfile_checkbox);
    $sform->addElement($htmlfile_tray);
    // $sform->addElement(new XoopsFormFile(_AM_UPLOADDOC, 'worddoc', 1000000), false);
    $htmldb_radio = new XoopsFormRadioYN(_AM_DOHTMLDB, 'htmldb', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($htmldb_radio);

    $cleanhtml_radio = new XoopsFormRadioYN(_AM_CLEANHTML, 'cleanhtml', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($cleanhtml_radio);

    $striptags_radio = new XoopsFormRadioYN(_AM_STRIPHTML, 'striptags', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($striptags_radio);
}
    $maintext = $page;
    $words_to_count = strip_tags($maintext);
    $pattern = "/[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-\-|:|\&|@)]+/";
    $words_to_count = preg_replace ($pattern, " ", $words_to_count);
    $words_to_count = trim($words_to_count);
    $total_words = count(explode(" ", $words_to_count));



 	switch ($xoopsModuleConfig['use_wysiwyg']) {


		case 'fck' :
			if ( is_readable(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php'))	{
					$fckeditor_root = XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/';
					include XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php';
					ob_start();
					$oFCKeditor = new FCKeditor('page') ;
					$oFCKeditor->BasePath	= XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/' ;
					$oFCKeditor->Value		= $page ;
					$oFCKeditor->Height		= 500 ;
					$oFCKeditor->Width		= '99%';
					$oFCKeditor->Create() ;
          $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
					$sform-> insertBreak(ob_get_contents(), 1);
					ob_end_clean();
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));
				}
		break;


		case 'tiny' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormTinyTextArea(array('caption'=> $caption, 'name'=>'page', 'value'=>$page, 'width'=>'100%', 'height'=>'400px'),true));
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));
				}

		break;

		case 'spaw' :
		if ( is_readable(XOOPS_ROOT_PATH.'/class/spaw_control.class.php'))	{
        ob_start();
        $sw = new SPAW_Wysiwyg('page', $page, 'en', 'full', 'default', '99%', '600px');
        $sw->show();
        $sform->addElement(new XoopsFormLabel(_AM_CHANA . _AM_WORDCOUNT . $total_words , ob_get_contents(), 1));
        ob_end_clean();
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));
				}
		break;

 		case 'koivi' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormWysiwygTextArea($caption, 'page', $page, '100%', '400px'));
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));
				}

		break;

 		case 'inbetween' :
  			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
//				$sform-> addElement(new XoopsFormInbetweenTextArea(array('caption'=>$caption, 'name'=>'page', 'value'=>$page, 'width'=>'100%', 'height'=>'400px')));
				$editor = new XoopsFormInbetweenTextArea(array('caption'=>$caption, 'name'=>'page', 'value'=>$page, 'width'=>'100%', 'height'=>'400px'));
				$sform-> insertBreak($editor->render(), 'bg3');
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));
				}
		break;

 		default :
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'page', $page, 20, 60));

		break;


 }

	 if ($xoopsModuleConfig['html_clean']) {

    $cleanhtml2_radio = new XoopsFormRadioYN(_AM_CLEANHTML2, 'cleanhtml2', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($cleanhtml2_radio);

    $striptags2_radio = new XoopsFormRadioYN(_AM_STRIPHTML2, 'striptags2', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($striptags2_radio);

    $options_tray = new XoopsFormElementTray(_AM_OPTIONS, '<br />');

    $html_checkbox = new XoopsFormCheckBox('', 'html', $html);
    $html_checkbox->addOption(1, _AM_DOHTML);
    $options_tray->addElement($html_checkbox);

//philou 111205
//    $smiley_checkbox = new XoopsFormCheckBox('', 'smiley', $smiley);
//    $smiley_checkbox->addOption(1, _AM_DOSMILEY);
//    $options_tray->addElement($smiley_checkbox);

//    $xcodes_checkbox = new XoopsFormCheckBox('', 'xcodes', $xcodes);
//    $xcodes_checkbox->addOption(1, _AM_DOXCODE);
//    $options_tray->addElement($xcodes_checkbox);

    $breaks_checkbox = new XoopsFormCheckBox('', 'breaks', $breaks);
    $breaks_checkbox->addOption(1, _AM_BREAKS);
    $options_tray->addElement($breaks_checkbox);
    $sform->addElement($options_tray);
}

    $sform->insertBreak("<b>" . _AM_MENU . "</b>", 'bg3');

    $time = time();
    $published = ($publishdate > $time) ? $publishdate : $time ;
    $ispublished = ($publishdate > $time) ? 1: 0 ;
    $publishdates = ($publishdate > $time) ? _AM_PUBLISHDATESET . formatTimestamp($publishdate, "Y-m-d H:s") : _AM_SETDATETIMEPUBLISH;

    $publishdate_checkbox = new XoopsFormCheckBox('', 'publishdateactivate', $ispublished);
    $publishdate_checkbox->addOption(1, $publishdates . "<br /><br />");

    $publishdate_tray = new XoopsFormElementTray(_AM_PUBLISHDATE, '');
    $publishdate_tray->addElement($publishdate_checkbox);
    $publishdate_tray->addElement(new XoopsFormDateTime(_AM_SETPUBLISHDATE, 'publishdates', 15, $published));
    $publishdate_tray->addElement(new XoopsFormRadioYN(_AM_CLEARPUBLISHDATE, 'clearpublish', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . ''));
    $sform->addElement($publishdate_tray);

    $expired = ($expiredate < $time) ? $expiredate : $time ;
    $isexpired = ($expiredate > $time) ? 1: 0 ;
    $expiredates = ($expiredate > $time) ? _AM_EXPIREDATESET . formatTimestamp($expiredate, 'Y-m-d H:s') : _AM_SETDATETIMEEXPIRE;

    $warning = "";
    if ($publishdate > $expiredate && $expiredate > $time)
    {
        $warning = _AM_EXPIREWARNING;
    }

    $expiredate_checkbox = new XoopsFormCheckBox('', 'expiredateactivate', $isexpired);
    $expiredate_checkbox->addOption(1, $expiredates . "<br /><br />");
    $expiredate_tray = new XoopsFormElementTray(_AM_EXPIREDATE . $warning, '');
    $expiredate_tray->addElement($expiredate_checkbox);
    $expiredate_tray->addElement(new XoopsFormDateTime(_AM_SETEXPIREDATE, 'expiredates', 15, $expired));
    $expiredate_tray->addElement(new XoopsFormRadioYN(_AM_CLEAREXPIREDATE, 'clearexpire', 0, ' ' . _AM_YES . '', ' ' . _AM_NO . ''));
    $sform->addElement($expiredate_tray);

    $defaultpage_radio = new XoopsFormRadioYN(_AM_DEFAULT, 'defaultpage', $defaultpage, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
    $sform->addElement($defaultpage_radio);

    if ($defaultpage == 0)
    {
        $submenuitem_radio = new XoopsFormRadioYN(_AM_SUBMENUITEM, 'submenu', $submenu, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($submenuitem_radio);
        $mainpage_radio = new XoopsFormRadioYN(_AM_MAINPAGEITEM, 'mainpage', $mainpage, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($mainpage_radio);
    }

//TODO
//detection de la page d'accueil ... verifier l'acces au group anonyme
//
    if ($defaultpage == 0)
    {
        if (!isset($allowcomments)) $allowcomments = 0;
        $allowcomments_radio = new XoopsFormRadioYN(_AM_ALLOWCOMMENTSCHANHTML, 'allowcomments', $allowcomments, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($allowcomments_radio);
    }
    else
    {
        $sform->addElement(new XoopsFormHidden('allowcomments', 0));
    }

    $sform->addElement(new XoopsFormHidden('CID', $CID));
    $sform->addElement(new XoopsFormHidden('publishdate', $publishdate));
    $sform->addElement(new XoopsFormHidden('expiredate', $expiredate));

    $create_tray = new XoopsFormElementTray('', '');
    $create_tray->addElement(new XoopsFormHidden('op', 'save'));

    if (!$CID)
    {
        $butt_save = new XoopsFormButton('', '', _AM_CREATE, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
    }
    else
    {
        $butt_save = new XoopsFormButton('', '', _AM_MODIFY, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
    }
    $create_tray->addElement($butt_save);
    $butt_cancel = new XoopsFormButton('', '', _AM_CANCEL, 'submit');
    $butt_cancel->setExtra('onclick="this.form.elements.op.value=\'cancel\'"');
    $create_tray->addElement($butt_cancel);

// Inclusion des permissions
    $sform-> insertBreak( "<b>"._AM_PERMISSIONCHECK."</b>" , 'bg3');
    $member_handler = & xoops_gethandler('member');
    $group_list = &$member_handler->getGroupList();

    $gperm_handler = &xoops_gethandler('groupperm');
    $full_list = array_keys($group_list);	// Ne récupère que les ID des groupes. (1, 2, 3)

	$groups_ids = array();
    if($CID) {	// On est en édition, on récupère donc les permissions de la page courante.
    	$groups_ids = $gperm_handler->getGroupIds('Page_permissions', $CID, $xoopsModule->getVar('mid'));
    	$groups_ids = array_values($groups_ids);
    	$groups_page_can_view_checkbox = new XoopsFormCheckBox(_AM_PAGE_CAN_VIEW, 'groups_page_can_view[]', $groups_ids);
    } else {	// Mode création, par défaut tous les groupes sont cochés
    	$groups_page_can_view_checkbox = new XoopsFormCheckBox(_AM_PAGE_CAN_VIEW, 'groups_page_can_view[]', $full_list);
    }
    $groups_page_can_view_checkbox->addOptionArray($group_list);


    $groups_page_can_view_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_page_can_view_checkbox);
    $sform->addElement($create_tray);
    $sform->display();
    unset($hidden);
}


switch ($op)
{
    case "mod":
        $CID = (isset($_POST['CID'])) ? $_POST['CID'] : $CID;
        edittopic($CID);
        break;

    case "del":
        Global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModule;

        if ($confirm)
        {
            $sql = sprintf("DELETE FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE CID = $CID");
            $result = $xoopsDB->query($sql);
            $error = _AM_WF_ERROR_DELCHANNEL . $sql;
            if (!$result)
            {
                trigger_error($error, E_USER_ERROR);
            }
            else
            {
                xoops_groupperm_deletebymoditem ($xoopsModule->getVar('mid'), '', $CID);
                xoops_comment_delete($xoopsModule->getVar('mid'), $CID);
                // Suppression des permissions ****
	            $gperm_handler = &xoops_gethandler('groupperm');
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('gperm_itemid', $CID,'='));
				$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'),'='));
				$criteria->add(new Criteria('gperm_name', 'Page_permissions','='));
	            $gperm_handler->deleteAll($criteria);
				// fin de la suppression des permissions ****
            }
            redirect_header("index.php", 1, sprintf(_AM_CHANISDELETED, $pagetitle));
            exit();
        }
        else
        {
            $CID = (isset($_POST['CID'])) ? $_POST['CID'] : $CID;
            $result = $xoopsDB->query("SELECT CID, pagetitle FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " ");
            if ($xoopsDB->getRowsNum($result) == 1)
            {
                redirect_header("index.php", 3, _AM_CANNOTDELETELASTONE);
                exit();
            }

            $result = $xoopsDB->query("SELECT CID, pagetitle FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE CID = $CID");
            list($CID, $pagetitle) = $xoopsDB->fetchrow($result);

            xoops_cp_header();
            echo"<table width='100%' border='0' cellpadding = '2' cellspacing='1' class = 'confirmMsg'><tr><td class='confirmMsg'>";
            echo "<div class='confirmMsg'>";
            echo "<h4>" . _AM_DELTHISCHAN . "</h4>";
            echo "<h5>$pagetitle</h5>";
            echo "<table><tr><td>";
            echo myTextForm("index.php?op=del&CID=" . $CID . "&confirm=1&pagetitle=$pagetitle", _AM_DELETE);
            echo "</td><td>";
            echo myTextForm("index.php", _AM_CANCEL);
            echo "</td></tr></table>";
            echo "</div><br /><br />";
            echo"</td></tr></table>";
        }
        xoops_cp_footer();
        exit();
        break;


    case "save":
        global $xoopsUser, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

        $result = $xoopsDB->query("SELECT CID FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE defaultpage = '1'");
        list($CIDOLD) = $xoopsDB->fetchrow($result);

        if ($xoopsDB->getRowsNum($result) >= 1)
        {
            if ($CIDOLD != $_POST['CID'] && $_POST['defaultpage'] == 1)
            {
                $xoopsDB->query("UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()) . " SET defaultpage = '0'");
            }
        }

        $html = (isset($_POST['html']) && $_POST['html'] == 1) ? 1 : 0;
        $smiley = (isset($_POST['smiley']) && $_POST['smiley'] == 1) ? 1 : 0;
        $xcodes = (isset($_POST['xcodes']) && $_POST['xcodes'] == 1) ? 1 : 0;

        $breaks = ($_POST['breaks'] == 1) ? 1 : 0;
        $doctitle = ($_POST['doctitle'] == 1) ? 1 : 0;
        $submenu = ($_POST['submenu'] == 1) ? 1 : 0;
        $mainpage = ($_POST['mainpage'] == 1) ? 1 : 0;

        if ($defaultpage == 1)
        {
            $submenu = 0;
            $mainpage = 0;
        }
        $weight = ($_POST['weight']) && is_numeric($_POST['weight']) ? intval($_POST['weight']) : 1;
        $defaultpage = ($_POST['defaultpage']) ? 1 : 0;
        $allowcomments = ($_POST['allowcomments']) ? 1 : 0;

        $pagetitle = $myts->addSlashes($_POST['pagetitle'], 0, 0, 0);
        $pageheadline = $myts->addSlashes($_POST['pageheadline'], 0, 0, 0);

        $CID = intval($_POST['CID']);
        $indeximage = ($_POST["indeximage"] != "blank.png") ? $myts->addSlashes($_POST["indeximage"]) : '';
        $publishdate = ($_POST['publishdate'] > 0) ? $_POST['publishdate'] : time();
        $expiredate = ($_POST['expiredate'] > 0) ? $_POST['publishdate'] : 0;
        $page = "";
        $htmlfile = "";

        if (isset($_POST['publishdateactivate']))
        {
            $publishdate = strtotime($_POST['publishdates']['date']) + $_POST['publishdates']['time'];
        }
        if ($_POST['clearpublish'])
        {
            $publishdate = time();
        }

        if (isset($_POST['expiredateactivate']))
        {
            $expiredate = strtotime($_POST['expiredates']['date']) + $_POST['expiredates']['time'];
        }
        if ($_POST['clearexpire'])
        {
            $expiredate = 0;
        }

        if (intval($doctitle) == 1)
        {
            $GLOBALS['fileedit'] = loadfile($_POST["htmlfile"]);
            if (preg_match('_<title>(.*)</title>_is', $GLOBALS['fileedit'], $tmp))
            {
                $pageheadline = wfc_removeShouting($myts->addslashes(xoops_trim($tmp[1])));
                unset($tmp);
            }
        }

        if (isset($_POST["connect"]))
        {
            $htmlfile = trim($_POST["htmlfile"]);
            $page = '';
        }
        else
        {
            $page = trim($_POST['page']);
            if ($_POST["cleanhtml2"])
            {
                $page = htmlcleaner::cleanup($page);
            }
            if ($_POST["striptags2"])
            {
                include XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/html2text.inc';
                $htmlToText = new Html2Text ($page, 200);
                $page = $htmlToText->convert();

                $page = $myts->displayTarea(xoops_trim($page), 1, 1, 1, 1, 1);
                $page = xoops_trim($page);
            }
            $page = $myts->addslashes(xoops_trim($page));
            $htmlfile = '';
        }
        if ($_POST["htmldb"] == 1)
        {
            $htmlfile = '';
            $page = '';
            $GLOBALS['fileedit'] = loadfile($_POST["htmlfile"]);

            if (preg_match('_<body>(.*)</body>_is', $GLOBALS['fileedit'], $tmp))
            {
                $tmp[0] = preg_replace('/\<script[\w\W]*?\<\/script\>/i', '', $GLOBALS['fileedit']);
                $tmp[0] = str_replace('<P>&nbsp;</P>', '', $tmp[0]);
                $tmp[0] = str_replace("<img src=\"", "<img src=\"html/images/", $tmp[0]);
                $tmp[0] = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array('', ''), trim($tmp[0]));

                if ($_POST["cleanhtml"])
                {
                    $tmp[0] = htmlcleaner::cleanup($tmp[0]);
                }
                if ($_POST["striptags"])
                {
                    include XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/html2text.inc';
                    $htmlToText = new Html2Text ($tmp[0], 200);
                    $tmp[0] = $htmlToText->convert();
                    $tmp[0] = $myts->displayTarea(trim($tmp[0]), 1, 1, 1, 1, 1);
                }
                $page = $myts->addslashes($tmp[0]);
            }
            else
            {
                $tmp[0] = preg_replace('/\<script[\w\W]*?\<\/script\>/i', '', $GLOBALS['fileedit']);
                $tmp[0] = str_replace('<P>&nbsp;</P>', '', $tmp[0]);
                $tmp[0] = str_replace("<img src=\"", "<img src=\"html/images/", $tmp[0]);
                $tmp[0] = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array('', ''), trim($tmp[0]));

                if ($_POST["cleanhtml"])
                {
                    $tmp[0] = htmlcleaner::cleanup($tmp[0]);
                }
                if ($_POST["striptags"])
                {
                    include XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/html2text.inc';
                    $htmlToText = new Html2Text ($tmp[0], 200);
                    $tmp[0] = $htmlToText->convert();
                    $tmp[0] = $myts->displayTarea(trim($tmp[0]), 1, 1, 1, 1, 1);
                }
                $page = $myts->addslashes($tmp[0]);
            }
            // unlink( $htmlfile );
            clearstatcache();
            $htmlfile = '';
        }

        if (!$CID)
        {
            $created = time();

            $sql = "INSERT INTO " . $xoopsDB->prefix($xoopsModule->dirname()) . " (pagetitle, pageheadline, page, weight, html, smiley, xcodes, breaks, defaultpage, indeximage, htmlfile, mainpage, submenu, created, allowcomments, usedoctitle, publishdate, expiredate) VALUES ('$pagetitle', '$pageheadline', '$page', '$weight','$html', '$smiley', '$xcodes', $breaks, $defaultpage, '$indeximage', '$htmlfile', '$mainpage', '$submenu', '$created', '$allowcomments', '$doctitle', '$publishdate', '$expiredate')";
            $result = $xoopsDB->query($sql);
            $error = _AM_WF_ERROR_CREATCHANNEL . $sql;
            if (!$result)
            {
                trigger_error($error, E_USER_ERROR);
            }
            else
            {
	            // Mode création de page, gestion des permissions ****
            	$page_id = $xoopsDB->getInsertId();
				$gperm_handler = &xoops_gethandler('groupperm');
				if(isset($_POST['groups_page_can_view'])) {
					foreach($_POST['groups_page_can_view'] as $onegroup_id) {
						$gperm_handler->addRight('Page_permissions',$page_id, $onegroup_id, $xoopsModule->getVar('mid'));
					}
				}
				// Fin des perms ****
                redirect_header("index.php", '1' , _AM_CHANCREATED);
            }
        }
        else
        {
            $sql = "UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()) . " SET pagetitle = '$pagetitle', pageheadline = '$pageheadline', page = '$page', weight = '$weight', html ='$html', smiley ='$smiley', xcodes ='$xcodes', breaks ='$breaks', defaultpage ='$defaultpage', indeximage = '$indeximage', htmlfile = '$htmlfile', mainpage = '$mainpage', submenu = '$submenu', allowcomments = '$allowcomments', usedoctitle = '$doctitle', publishdate = '$publishdate', expiredate = '$expiredate' WHERE CID = $CID";
            $result = $xoopsDB->query($sql);
            $error = _AM_WF_ERROR_UPDATCHANNEL . $sql;
            if (!$result)
            {
                trigger_error($error, E_USER_ERROR);
            }
            else
            {
	            // Mode édition de page, gestion des permissions
	            // On commence par supprimer les permissions actuelles pour cette page
	            $gperm_handler = &xoops_gethandler('groupperm');
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('gperm_itemid', $CID,'='));
				$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'),'='));
				$criteria->add(new Criteria('gperm_name', 'Page_permissions','='));
	            $gperm_handler->deleteAll($criteria);
	            // Ensuite on les sauvegarde
				if(isset($_POST['groups_page_can_view'])) {
					foreach($_POST['groups_page_can_view'] as $onegroup_id) {
						$gperm_handler->addRight('Page_permissions',$CID, $onegroup_id, $xoopsModule->getVar('mid'));
					}
				}
				// Fin des perms ****
                redirect_header("index.php", '1' , _AM_CHANMODIFY);
            }
        }
        exit();
        break;


    case "create":
        edittopic();
        break;

    case "savelink":

        global $xoopsDB, $myts;

        $titlelink = $myts->addSlashes($_POST['titlelink']);
        $textlink = $myts->addSlashes($_POST['textlink']);
        $linkpagelogo = $myts->addSlashes($_POST['linkpagelogo']);
        $button = $myts->addSlashes($_POST['button']);
        $microbutton = $myts->addSlashes($_POST['microbutton']);
        $logo = $myts->addSlashes($_POST['logo']);
        $banner = $myts->addSlashes($_POST['banner']);

        $newsfeedjs = $myts->addSlashes($_POST['newsfeedjs']);
        $newstitle = $myts->addSlashes($_POST['newstitle']);

        $submenuitem = $myts->addSlashes($_POST['submenuitem']);
        $mainpage = $myts->addSlashes($_POST['mainpage']);
        $newsfeed = $myts->addSlashes($_POST['newsfeed']);
        $linkintro = $myts->addSlashes($_POST['linkintro']);

        $sql = sprintf("UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()."_linktous") . " SET textlink = '$textlink', titlelink = '$titlelink', button = '$button', microbutton = '$microbutton', logo = '$logo', banner = '$banner', linkpagelogo = '$linkpagelogo', newsfeed = '$newsfeed', submenuitem = '$submenuitem', mainpage = '$mainpage', newsfeedjs = '$newsfeedjs', newstitle = '$newstitle', linkintro = '$linkintro'");
        $result = $xoopsDB->query($sql);
        $error = _AM_WF_ERROR_UPDATLINK . $sql;
        if (!$result)
        {
            trigger_error($error, E_USER_ERROR);
        }
        else
        {
            redirect_header("index.php?op=links", '1' , _AM_CHANMODIFY);
        }

        exit();
        break;

    case "links":

        xoops_cp_header();

        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../language/".$xoopsConfig['language']."/help/index.html'><img src='../images/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);

        global $xoopsModuleConfig, $xoopsDB, $xoopsConfig;

        $result = $xoopsDB->query("SELECT submenuitem, textlink, linkpagelogo, button, microbutton, logo, banner, mainpage, newsfeed,titlelink, newsfeedjs, newstitle, linkintro  FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_linktous") . "");
        list($submenuitem, $textlink, $linkpagelogo, $button, $microbutton, $logo, $banner, $mainpage, $newsfeed, $titlelink, $newsfeedjs, $newstitle, $linkintro) = $xoopsDB->fetchrow($result);

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $sform = new XoopsThemeForm(_AM_CMODIFYLINK, "op", xoops_getenv('PHP_SELF'));

        if (!$linkpagelogo) $linkpagelogo = "blank.png";
        $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['linkimages']);
        $linkpage_select = new XoopsFormSelect('', 'linkpagelogo', $linkpagelogo);
        $linkpage_select->addOptionArray($graph_array);
        $linkpage_select->setExtra("onchange='showImgSelected(\"image1\", \"linkpagelogo\", \"" . $xoopsModuleConfig['linkimages'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $linkpage_tray = new XoopsFormElementTray(_AM_LINKPAGELOGO, '&nbsp;');
        $linkpage_tray->addElement($linkpage_select);
        $linkpage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['linkimages'] . "/" . $linkpagelogo . "' name='image1' id='image1' alt='' />"));
        $sform->addElement($linkpage_tray);

        $sform->addElement(new XoopsFormText(_AM_CHANQ, 'titlelink', 50, 255, $titlelink), true);



switch ($xoopsModuleConfig['use_wysiwyg']) {


		case 'fck' :
			if ( is_readable(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php'))	{
					$fckeditor_root = XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/';
					include XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php';
					ob_start();
					$oFCKeditor = new FCKeditor('linkintro') ;
					$oFCKeditor->BasePath	= XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/' ;
					$oFCKeditor->Value		= $linkintro ;
					$oFCKeditor->Height		= 300 ;
					$oFCKeditor->Width		= '99%';
					$oFCKeditor->Create() ;
          $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
					$sform-> insertBreak(ob_get_contents(), 1);
					ob_end_clean();
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));
				}
		break;


		case 'tiny' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormTinyTextArea(array('caption'=> $caption, 'name'=>'linkintro', 'value'=>$linkintro, 'width'=>'100%', 'height'=>'300px'),true));
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));
				}

		break;

		case 'spaw' :
		if ( is_readable(XOOPS_ROOT_PATH.'/class/spaw_control.class.php'))	{
        ob_start();
        $sw = new SPAW_Wysiwyg('linkintro', $linkintro, 'en', 'full', 'default', '99%', '600px');
        $sw->show();
        $sform->addElement(new XoopsFormLabel(_AM_CHANA . _AM_WORDCOUNT . $total_words , ob_get_contents(), 1));
        ob_end_clean();
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));
				}

		break;

 		case 'koivi' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormWysiwygTextArea($caption, 'linkintro', $linkintro, '100%', '400px'));
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));
				}

		break;

 		case 'inbetween' :
  			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$editor = new XoopsFormInbetweenTextArea(array('caption'=>$caption, 'name'=>'linkintro', 'value'=>$linkintro, 'width'=>'100%', 'height'=>'400px'));
				$sform-> insertBreak($editor->render(), 'bg3');
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));
				}
		break;

 		default :
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'linkintro', $linkintro, 20, 60));

		break;


 }

        $sform->insertBreak("<b>" . _AM_LOGONNEWSFEED . "</b>", 'bg3');

        if (empty($textlink)) $textlink = $xoopsConfig['slogan'];
        $sform->addElement(new XoopsFormText(_AM_TEXTLINK, 'textlink', 50, 255, $textlink), true);
        if (!$button) $button = "blank.png";
        $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['linkimages']);
        $smallimage_select = new XoopsFormSelect('', 'button', $button);
        $smallimage_select->addOptionArray($graph_array);
        $smallimage_select->setExtra("onchange='showImgSelected(\"image2\", \"button\", \"" . $xoopsModuleConfig['linkimages'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $smallimage_tray = new XoopsFormElementTray(_AM_BUTTON, '&nbsp;');
        $smallimage_tray->addElement($smallimage_select);
        $smallimage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['linkimages'] . "/" . $button . "' name='image2' id='image2' alt='' />"));
        $sform->addElement($smallimage_tray);

//microbouton
        if (!$microbutton) $microbutton = "blank.png";
        $graph_arraymb = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['linkimages']);
        $smallbutton_select = new XoopsFormSelect('', 'microbutton', $microbutton);
        $smallbutton_select->addOptionArray($graph_arraymb);
        $smallbutton_select->setExtra("onchange='showImgSelected(\"image2a\", \"microbutton\", \"" . $xoopsModuleConfig['linkimages'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $smallbutton_tray = new XoopsFormElementTray(_AM_BUTTON, '&nbsp;');
        $smallbutton_tray->addElement($smallbutton_select);
        $smallbutton_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['linkimages'] . "/" . $microbutton . "' name='image2a' id='image2a' alt='' />"));
        $sform->addElement($smallbutton_tray);
//
        if (!$logo) $logo = "blank.png";
        $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['linkimages']);
        $medimage_select = new XoopsFormSelect('', 'logo', $logo);
        $medimage_select->addOptionArray($graph_array);
        $medimage_select->setExtra("onchange='showImgSelected(\"image3\", \"logo\", \"" . $xoopsModuleConfig['linkimages'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $medimage_tray = new XoopsFormElementTray(_AM_LOGO, '&nbsp;');
        $medimage_tray->addElement($medimage_select);
        $medimage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['linkimages'] . "/" . $logo . "' name='image3' id='image3' alt='' />"));
        $sform->addElement($medimage_tray);

        if (!$banner) $banner = "blank.png";
        $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['linkimages']);
        $largeimage_select = new XoopsFormSelect('', 'banner', $banner);
        $largeimage_select->addOptionArray($graph_array);
        $largeimage_select->setExtra("onchange='showImgSelected(\"image4\", \"banner\", \"" . $xoopsModuleConfig['linkimages'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $largeimage_tray = new XoopsFormElementTray(_AM_BANNER, '&nbsp;');
        $largeimage_tray->addElement($largeimage_select);
        $largeimage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['linkimages'] . "/" . $banner . "' name='image4' id='image4' alt='' />"));
        $sform->addElement($largeimage_tray);

        $sform->addElement(new XoopsFormText(_AM_NEWSFEEDTITLE, 'newstitle', 50, 255, $newstitle), false);
        $newsfeed_radio = new XoopsFormRadioYN(_AM_ADDNEWSFEED, 'newsfeed', $newsfeed, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($newsfeed_radio);
        $newsfeedjs_radio = new XoopsFormRadioYN(_AM_ADDNEWSFEEDJS, 'newsfeedjs', $newsfeedjs, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($newsfeedjs_radio);

        $sform->insertBreak("<b>" . _AM_MENU . "</b>", 'bg3');
        $submenuitem_radio = new XoopsFormRadioYN(_AM_SUBMENUITEM, 'submenuitem', $submenuitem, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($submenuitem_radio);
        $mainpage_radio = new XoopsFormRadioYN(_AM_MAINPAGEITEM, 'mainpage', $mainpage, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($mainpage_radio);

        $create_tray = new XoopsFormElementTray('', '');
        $create_tray->addElement(new XoopsFormHidden('op', 'savelink'));
        $butt_save = new XoopsFormButton('', '', _AM_MODIFY, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'savelink\'"');
        $create_tray->addElement($butt_save);
        $butt_cancel = new XoopsFormButton('', '', _AM_CANCEL, 'submit');
        $butt_cancel->setExtra('onclick="this.form.elements.op.value=\'cancel\'"');
        $create_tray->addElement($butt_cancel);
        $sform->addElement($create_tray);
        $sform->display();
        unset($hidden);

        xoops_cp_footer();
        exit();

        break;

    case "saverefer":

        global $xoopsDB, $myts;

        $titlerefer = $myts->addSlashes($_POST['titlerefer']);
        $chanrefheadline = $myts->addSlashes($_POST['chanrefheadline']);
        $submenuitem = $myts->addSlashes($_POST['submenuitem']);
        $mainpage = $myts->addSlashes($_POST['mainpage']);
        $emailaddress = $myts->addSlashes($_POST['emailaddress']);
        $usersblurb = $myts->addSlashes($_POST['usersblurb']);
        $defblurb = $myts->addSlashes($_POST['defblurb']);
        $privacy_statement = $myts->addSlashes($_POST['privacy_statement']);

        $breaks = (isset($_POST['breaks'])) ? 1 : 0;
        $html = (isset($_POST['html'])) ? 1 : 0;
        $smiley = (isset($_POST['smiley'])) ? 1 : 0;
        $xcodes = (isset($_POST['xcodes'])) ? 1 : 0;
        $privacy = ($_POST['privacy'] == 1) ? 1 : 0;
        $emailcheck = ($_POST['emailcheck'] == 1) ? 1 : 0;

        $referpagelogo = (isset($_POST["referpagelogo"])) ? $myts->addSlashes($_POST["referpagelogo"]) : '';

        $sql = sprintf("UPDATE " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . " SET titlerefer = '$titlerefer', chanrefheadline = '$chanrefheadline', submenuitem = '$submenuitem', mainpage = '$mainpage', emailaddress = '$emailaddress', usersblurb = '$usersblurb', defblurb = '$defblurb', referpagelogo = '$referpagelogo', html ='$html', smiley ='$smiley', xcodes ='$xcodes', breaks ='$breaks', privacy ='$privacy', emailcheck ='$emailcheck',  privacy_statement = '$privacy_statement'");
        $result = $xoopsDB->query($sql);
        $error = _AM_WF_ERROR_UPDATREFER . $sql;
        if (!$result)
        {
            trigger_error($error, E_USER_ERROR);
        }
        else
        {
            redirect_header("index.php?op=refer", '1' , _AM_CHANMODIFY);
        }
        exit();
        break;

    case "refer":

        xoops_cp_header();

        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../language/".$xoopsConfig['language']."/help/index.html'><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);

        global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $myts;

        $titlerefer = '';
        $chanrefheadline = '';
        $submenuitem = 1;
        $mainpage = 1;
        $emailaddress = 1;
        $usersblurb = 0;
        $defblurb = '';
        $referpagelogo = '';
        $html = 0;
        $smiley = 0;
        $xcodes = 0;
        $breaks = 1;
        $privacy = 0;
        $emailcheck = 0;

        $result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . "");
        list($titlerefer, $chanrefheadline, $submenuitem, $mainpage, $referpagelogo, $emailaddress, $usersblurb, $defblurb, $smiley, $xcodes, $breaks, $html, $privacy, $emailcheck, $privacy_statement) = $xoopsDB->fetchrow($result);

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $sform = new XoopsThemeForm(_AM_CCONFIGREFER, "op", xoops_getenv('PHP_SELF'));
        $sform->setExtra('enctype="multipart/form-data"');

        if (!$referpagelogo) $referpagelogo = "blank.png";
        $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir']);
        $linkpage_select = new XoopsFormSelect('', 'referpagelogo', $referpagelogo);
        $linkpage_select->addOptionArray($graph_array);
        $linkpage_select->setExtra("onchange='showImgSelected(\"image1\", \"referpagelogo\", \"" . $xoopsModuleConfig['uploaddir'] . "\", \"\", \"" . XOOPS_URL . "\")'");
        $linkpage_tray = new XoopsFormElementTray(_AM_REFERPAGELOGO, '&nbsp;');
        $linkpage_tray->addElement($linkpage_select);
        $linkpage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['uploaddir'] . "/" . $referpagelogo . "' name='image1' id='image1' alt='' />"));
        $sform->addElement($linkpage_tray);

        $titlerefer = $myts->htmlSpecialChars($myts->stripSlashesGPC($titlerefer));
        $sform->addElement(new XoopsFormText(_AM_CHANQ, 'titlerefer', 50, 255, $titlerefer), true);

        $options_tray = new XoopsFormElementTray(_AM_OPTIONS, '<br />');
        $html_checkbox = new XoopsFormCheckBox('', 'html', $html);
        $html_checkbox->addOption(1, _AM_DOHTML);
        $options_tray->addElement($html_checkbox);

        $breaks_checkbox = new XoopsFormCheckBox('', 'breaks', $breaks);
        $breaks_checkbox->addOption(1, _AM_BREAKS);
        $options_tray->addElement($breaks_checkbox);
        $sform->addElement($options_tray);

        $sform->insertBreak("<b>" . _AM_EMAILSETTINGS . "</b>", 'bg3');
        $emailaddress_radio = new XoopsFormRadioYN(_AM_EMAILADDRESS, 'emailaddress', $emailaddress, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($emailaddress_radio);

        $usersblurb_radio = new XoopsFormRadioYN(_AM_USERSBLURB, 'usersblurb', $usersblurb, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($usersblurb_radio);

       $sform->addElement(new XoopsFormTextArea(_AM_DEFBLURB, 'defblurb', $defblurb, 15, 70), false);

        $sform->insertBreak("<b>" . _AM_MENU . "</b>", 'bg3');
        $submenuitem_radio = new XoopsFormRadioYN(_AM_SUBMENUITEM, 'submenuitem', $submenuitem, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($submenuitem_radio);
        $mainpage_radio = new XoopsFormRadioYN(_AM_MAINPAGEITEM, 'mainpage', $mainpage, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($mainpage_radio);

        $sform->insertBreak("<b>" . _AM_MENUOTHER . "</b>", 'bg3');
        $emailcheck_radio = new XoopsFormRadioYN(_AM_CHECKEMAILADDRESS, 'emailcheck', $emailcheck, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($emailcheck_radio);
        $privacy_radio = new XoopsFormRadioYN(_AM_DISPLAYPRIVACY, 'privacy', $privacy, ' ' . _AM_YES . '', ' ' . _AM_NO . '');
        $sform->addElement($privacy_radio);

 	switch ($xoopsModuleConfig['use_wysiwyg']) {

		case 'fck' :
			if ( is_readable(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php'))	{
					$fckeditor_root = XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/';
					include XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/fckeditor.php';
					ob_start();
					$oFCKeditor = new FCKeditor('privacy_statement') ;
					$oFCKeditor->BasePath	= XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/fckeditor/' ;
					$oFCKeditor->Value		= $privacy_statement ;
					$oFCKeditor->Height		= 500 ;
					$oFCKeditor->Width		= '99%';
					$oFCKeditor->Create() ;
          $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
					$sform-> insertBreak(ob_get_contents(), 1);
					ob_end_clean();
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));
				}
		break;


		case 'tiny' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormTinyTextArea(array('caption'=> $caption, 'name'=>'privacy_statement', 'value'=>$privacy_statement, 'width'=>'100%', 'height'=>'400px'),true));
				} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));
				}

		break;

		case 'spaw' :
		if ( is_readable(XOOPS_ROOT_PATH.'/class/spaw_control.class.php'))	{
        ob_start();
        $sw = new SPAW_Wysiwyg('privacy_statement', $privacy_statement, 'en', 'full', 'default', '99%', '600px');
        $sw->show();
        $sform->addElement(new XoopsFormLabel(_AM_CHANA . _AM_WORDCOUNT . $total_words , ob_get_contents(), 1));
        ob_end_clean();
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));
				}
		break;

 		case 'koivi' :
			if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormWysiwygTextArea($caption, 'privacy_statement', $privacy_statement, '100%', '400px'));
			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));
				}

		break;

 		case 'inbetween' :
  			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php");
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$editor = new XoopsFormInbetweenTextArea(array('caption'=>$caption, 'name'=>'privacy_statement', 'value'=>$privacy_statement, 'width'=>'100%', 'height'=>'400px'));
				$sform-> insertBreak($editor->render(), 'bg3');

			} else {
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));
				}
		break;

 		default :
        $sform-> insertBreak( "<b>"._AM_CHANA . _AM_WORDCOUNT . $total_words."</b>" , 'bg3');
				$sform-> addElement(new XoopsFormDhtmlTextArea($caption, 'privacy_statement', $privacy_statement, 20, 60));

		break;


 }

        $create_tray = new XoopsFormElementTray('', '');
        $create_tray->addElement(new XoopsFormHidden('op', 'saverefer'));
        $butt_save = new XoopsFormButton('', '', _AM_MODIFY, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'saverefer\'"');
        $create_tray->addElement($butt_save);
        $butt_cancel = new XoopsFormButton('', '', _AM_CANCEL, 'submit');
        $butt_cancel->setExtra('onclick="this.form.elements.op.value=\'cancel\'"');
        $create_tray->addElement($butt_cancel);
        $sform->addElement($create_tray);
        $sform->display();
        unset($hidden);

        xoops_cp_footer();
        exit();

        break;

    case "default":
    default:

        xoops_cp_header();

        Global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig;

       echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../language/".$xoopsConfig['language']."/help/index.html'><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";


// Nice menu with tabs
        pages_tabsAdminMenu(__FILE__);

        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $start = isset($_GET['start']) ? intval($_GET['start']) : 0;

        // ancien menu admin
        //wfc_adminmenu(_AM_CHANADMIN);

        $result = $xoopsDB->query("SELECT CID, pagetitle FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " WHERE defaultpage = 1 ");
        list($CID, $pagetitle) = $xoopsDB->fetchrow($result);

        $result2 = $xoopsDB->query("SELECT CID FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . "");
        $numrows = $xoopsDB->getRowsNum($result2);

        $result3 = $xoopsDB->query("SELECT counter FROM " . $xoopsDB->prefix($xoopsModule->dirname()."_refer") . "");
        list($counter) = $xoopsDB->fetchrow($result3);

        $pagetitle = "<a href='../index.php?op=mod&CID=" . $CID . "'>" . $pagetitle . "</a>";

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_ADMINPAGE . "</legend>";
        echo "<div style='padding: 8px;'>";
        if ($xoopsDB->getRowsNum($result) == 0)
        {
            echo "" . _AM_NODEFAULTPAGESET . "";
        }
        else
        {
            echo "" . _AM_DEFAULTPAGESET . ": " . $pagetitle . "";
        }
        echo "<br />" . _AM_TOTALNUMCHANL . ": <b>" . $numrows . "</b>";
        echo "<br />" . _AM_TOTALEMAILSSENT . ": <b>" . $counter . "</b>";
        echo "</div>";
        echo "</fieldset><br />";

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_ADMINSPPAGE . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo "<a href='index.php?op=links'>" . _AM_CLINKTOUS ."</a>";
        echo "<br /><a href='index.php?op=refer'>" . _AM_REFER ."</a>";
        echo "</div>";
        echo "</fieldset><br />";

        if ($numrows > 0)
        {
            $sql = "SELECT CID, pagetitle, pageheadline, weight, defaultpage, mainpage, submenu, publishdate, expiredate, counter FROM " . $xoopsDB->prefix($xoopsModule->dirname()) . " ORDER BY weight, pagetitle ASC";
            $result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , $start);

            echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PAGESLIST . "</legend><br />";
            echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
            echo "<tr>";
            echo "<th align='center' width = '5%'><b>" . _AM_ID . "</b></th>";
            echo "<th align='left'><b>" . _AM_PAGETITLE . "</b></th>";
            echo "<th align='center'><b>" . _AM_WEIGHT . "</b></th>";
            echo "<th align='center'><b>" . _AM_DEFAULTPAGE . "</b></th>";
            echo "<th align='center'><b>" . _AM_ISMAINPAGELINK . "</b></th>";
            echo "<th align='center'><b>" . _AM_ISSUBMENU . "</b></th>";
            echo "<th align='center'><b>" . _AM_PUBLISHEDDATE . "</b></th>";
            echo "<th align='center'><b>" . _AM_EXPIREDDATE . "</b></th>";
            echo "<th align='center'><b>" . _AM_READ . "</b></th>";
            echo "<th align='center'><b>" . _AM_ACTION . "</b></th>";
            echo "</tr>";
            $x = 0;

            while (list($CID, $pagetitle, $pageheadline, $weight, $defaultpage, $mainpage, $submenu, $publishdate, $expiredate, $counter) = $xoopsDB->fetchrow($result))
            {
                $pagetitle = $myts->htmlSpecialChars($pagetitle);
                $weight = $myts->htmlSpecialChars($weight);
                $defaultpage = ($defaultpage == 1) ? _AM_YES : _AM_NO;
                $mainpage = ($mainpage == 1) ? _AM_YES : _AM_NO;
                $submenu = ($submenu == 1) ? _AM_YES : _AM_NO;
                $modify = "<a href='index.php?op=mod&CID=" . $CID . "'>" . $editimg . "</a>";
                $delete = "<a href='index.php?op=del&CID=" . $CID . "'>" . $deleteimg . "</a>";

                echo "<tr>";
                echo "<td class='head' align='center'>" . $CID . "</td>";
                echo "<td class='even' align='left'><a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/index.php?pagenum=$CID'>" . $pagetitle . "</a></td>";
                echo "<td class='even' align='center'>" . $weight . "</td>";
                echo "<td class='even' align='center'>" . $defaultpage . "</td>";
                echo "<td class='even' align='center'>" . $mainpage . "</td>";
                echo "<td class='even' align='center'>" . $submenu . "</td>";
                echo "<td class='even' align='center' nowrap>" . formatTimestamp($publishdate, 'Y-m-d') . "</td>";
                $expired = ($expiredate) ? formatTimestamp($expiredate, 'Y-m-d') : _AM_NOTSET;
                echo "<td class='even' align='center' nowrap>" . $expired . "</td>";
                echo "<td class='even' align='center'>" . $counter . "</td>";
                echo "<td class='even' align='center' nowrap> $modify $delete</td>";
                echo "</tr>";
                $x++;
            }
            echo "</table>\n";
            $pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage'] , $start, 'start');
            echo '<div align="right" style="padding: 8px;">' . $pagenav->renderNav() . '</div>';
            echo "</fieldset>";
        }
        break;
}
xoops_cp_footer();
?>