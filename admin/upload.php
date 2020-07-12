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

$op = '';

if (isset($HTTP_POST_VARS))
{
    foreach ($HTTP_POST_VARS as $k => $v)
    {
        ${$k} = $v;
    }
}

if (isset($HTTP_GET_VARS))
{
    foreach ($HTTP_GET_VARS as $k => $v)
    {
        ${$k} = $v;
    }
}

$rootpath = (isset($HTTP_GET_VARS['rootpath'])) ? intval($HTTP_GET_VARS['rootpath']) : 0;

switch ($op)
{
    case "upload":

        global $HTTP_POST_VARS;

        if ($HTTP_POST_FILES['uploadfile']['name'] != "")
        {
            if (file_exists(XOOPS_ROOT_PATH . "/" . $HTTP_POST_VARS['uploadpath'] . "/" . $HTTP_POST_FILES['uploadfile']['name']))
            {
                redirect_header("upload.php", 1, _AM_CHANIMAGEEXIST);
            }

            if ($HTTP_POST_VARS['rootnumber'] != 3)
            {
                $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
            }
            else
            {
                $allowed_mimetypes = array('text/html');
            }
            wfc_uploading($allowed_mimetypes, $HTTP_POST_FILES['uploadfile']['name'], "upload.php", 0, $HTTP_POST_VARS['uploadpath'], 1);
        }
        else
        {
            redirect_header("upload.php", '2' , _AM_CHANNOIMAGEEXIST);
        }
        exit();
        break;

    case "delfile":

        if ($confirm)
        {
            $filetodelete = XOOPS_ROOT_PATH . "/" . $HTTP_POST_VARS['uploadpath'] . "/" . $HTTP_POST_VARS['pagefile'];
            if (file_exists($filetodelete))
            {
                chmod($filetodelete, 0666);
                if (@unlink($filetodelete))
                {
                    redirect_header("upload.php", 3, _AM_FILEDELETED);
                }
                else
                {
                    redirect_header("upload.php", 3, _AM_ERRORDELETEFILE);
                }
            }
            exit();
        }
        else
        {
            xoops_cp_header();
            xoops_confirm(array('op' => 'delfile', 'uploadpath' => $HTTP_POST_VARS['uploadpath'], 'pagefile' => $HTTP_POST_VARS['pagefile'], 'confirm' => 1), 'upload.php', _AM_DELETEFILE . "<br/><br />" . $HTTP_POST_VARS['pagefile'], "Delete");
        }
        break;

    case "default":
    default:

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        xoops_cp_header();

        Global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig;

        $dirarray = array(0 => '0', 1 => $xoopsModuleConfig['uploaddir'], 2 => $xoopsModuleConfig['linkimages'], 3 => $xoopsModuleConfig['htmluploaddir']);
        $namearray = array(0 => _AM_UPLOADCHANTYP, 1 => _AM_CHAN_UPLOADDIR , 2 => _AM_CHAN_LINKIMAGES, 3 => _AM_CHAN_HTMLUPLOADDIR);
        $listarray = array(0 => '', 1 => _AM_UPLOADCHANLOGO , 2 => _AM_UPLOADLINKIMAGE, 3 => _AM_UPLOADCHANHTML);
        $displayimage = '';
        $safemode = (ini_get('safe_mode')) ? _AM_ON . _AM_SAFEMODEPROBLEMS: _AM_OFF;
        $downloads = (ini_get('enable_dl')) ? _AM_ON : _AM_OFF;

        //wfc_adminmenu(_AM_CHANADMIN);
        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../help/help.php'><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_SERVERSTATUS . "</legend>";
		echo "<div style='padding: 8px;'>";
        echo "<b>" . _AM_SAFEMODE . "</b> ".$safemode."<br />";
        echo "<b>" . _AM_UPLOADS  . "</b> ". $downloads ."<br />";
        if (ini_get('enable_dl'))
        {
            echo "<b>" . _AM_ANDTHEMAX . "</b> " . ini_get('upload_max_filesize') . "<br />";
        }
		echo "</fieldset><br />";
        
		echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_UPLOAD . "</legend>";
		if ($rootpath > 0)
        {
            echo "<div style='padding: 16px 0 0 8px;'><b>" . _AM_UPLOADPATH . "</b> " . XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath] . "</div>";
        }
       
		$iform = new XoopsThemeForm(_AM_UPLOADIMAGE . $listarray[$rootpath], "op", xoops_getenv('PHP_SELF'));
        $iform->setExtra('enctype="multipart/form-data"');

        ob_start();
        $iform->addElement(new XoopsFormHidden('dir', $rootpath));
        wfc_getDirSelectOption($namearray[$rootpath], $dirarray, $namearray, $addnull = 0);
        $iform->addElement(new XoopsFormLabel(_AM_DIRSELECT, ob_get_contents()));
        ob_end_clean();

        if ($rootpath > 0)
        {
            if (!isset($pagefile)) $pagefile = "blank.png";
            $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath]);

            if ($rootpath != 3)
            {
                $smallimage_select = new XoopsFormSelect('', 'pagefile', $pagefile);
                $smallimage_select->addOptionArray($graph_array);
                $smallimage_select->setExtra("onchange='showImgSelected(\"image\", \"pagefile\", \"" . $dirarray[$rootpath] . "\", \"\", \"" . XOOPS_URL . "\")'");

                $smallimage_tray = new XoopsFormElementTray(_AM_BUTTON, '&nbsp;');
                $smallimage_tray->addElement($smallimage_select);
                $smallimage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $dirarray[$rootpath] . "/" . $pagefile . "' name='image' id='image' alt='' />"));
                $iform->addElement($smallimage_tray);
            }
            else
            {
                ob_start();
                wfc_htmlarray($htmlfile = '', XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath]);
                $iform->addElement(new XoopsFormLabel(_AM_CHANHTML, ob_get_contents()));
                ob_end_clean();
            }
            $iform->addElement(new XoopsFormFile(_AM_UPLOADLINKIMAGE, 'uploadfile', $xoopsModuleConfig['maxfilesize']));
            $iform->addElement(new XoopsFormHidden('uploadpath', $dirarray[$rootpath]));
            $iform->addElement(new XoopsFormHidden('rootnumber', $rootpath));

            $dup_tray = new XoopsFormElementTray('', '');
            $dup_tray->addElement(new XoopsFormHidden('op', 'upload'));
            $butt_dup = new XoopsFormButton('', '', _SUBMIT, 'submit');
            $butt_dup->setExtra('onclick="this.form.elements.op.value=\'upload\'"');
            $dup_tray->addElement($butt_dup);

            $butt_dupct = new XoopsFormButton('', '', _AM_DELETE, 'submit');
            $butt_dupct->setExtra('onclick="this.form.elements.op.value=\'delfile\'"');
            $dup_tray->addElement($butt_dupct);
            $iform->addElement($dup_tray);
        }
        $iform->display();
		echo "</fieldset>";
}
xoops_cp_footer();

?>