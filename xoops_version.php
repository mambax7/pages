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

global $xoopsDB, $xoopsUser, $xoopsConfig, $myts, $xoopsModule, $xoopsModuleConfig;

$modversion['name'] = "Pages";
$modversion['version'] = 1.16;
$modversion['description'] = _MI_WFS_CHANDESC;
$modversion['author'] = "Catzwolf, modified by Philou, Christian and Hervé, tests by kris";
$modversion['credits'] = "v1.15";

$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "Image/pages_slogo.png";
$modversion['dirname'] = "pages";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/pages_".$xoopsConfig['language'].".sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][1] = $modversion['dirname'];
$modversion['tables'][2] = $modversion['dirname']."_linktous";
$modversion['tables'][3] = $modversion['dirname']."_refer";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Blocks
$modversion['blocks'][1]['file'] = "pages_menu.php";
$modversion['blocks'][1]['name'] = _MI_PAGES_BNAME1;
$modversion['blocks'][1]['description'] = "Liste des pages";
$modversion['blocks'][1]['show_func'] = "b_pages_list";

// Menu
$modversion['hasMain'] = 1;

// Additionnal script executed during install update
$modversion['onInstall'] = 'include/install.php';

//$modversion['onUpdate'] = 'include/update.php';
$modversion['onUninstall'] = 'include/uninstall.php';


$modhandler = &xoops_gethandler('module');
$xoopsModule = &$modhandler->getByDirname($modversion['dirname']);

if (is_object($xoopsModule) && $xoopsModule->getVar('isactive'))
{
    $config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
    $gperm_handler = &xoops_gethandler('groupperm');
	$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
}

$result2 = $xoopsDB->query("SELECT CID, pagetitle, defaultpage FROM " . $xoopsDB->prefix($modversion['dirname']) . " WHERE defaultpage = '0' AND submenu = 1 AND (publishdate > 0 AND publishdate <= " . time() . ") AND (expiredate = 0 OR expiredate > " . time() . ") ORDER BY weight");
$i = 1;

if (is_object($xoopsModule) && $xoopsModule->getVar('isactive') )
{
	include_once XOOPS_ROOT_PATH."/modules/pages/include/functions.php";
    while (list($CID, $pagetitle) = $xoopsDB->fetchRow($result2))
    {
        if (pages_IsPageVisible($CID))
        {
            $modversion['sub'][$i]['name'] = $pagetitle;
            $modversion['sub'][$i]['url'] = "index.php?pagenum=" . $CID . "";
        }
        $i++;
    }

    $result = $xoopsDB->query("SELECT submenuitem, titlelink FROM " . $xoopsDB->prefix($modversion['dirname']. "_linktous") . "");
    list($submenuitem, $titlelink) = $xoopsDB->fetchrow($result);

    if ($submenuitem)
    {
        if (is_object($xoopsUser))
        {
            $modversion['sub'][$i]['name'] = $titlelink;
            $modversion['sub'][$i]['url'] = "index.php?op=link";
        }
        else
        {
            if (isset($xoopsModuleConfig['anonlink']))
            {
                $modversion['sub'][$i]['name'] = $titlelink;
                $modversion['sub'][$i]['url'] = "index.php?op=link";
            }
        }
    }
    $i++;
    $result2 = $xoopsDB->query("SELECT submenuitem , titlerefer FROM " . $xoopsDB->prefix($modversion['dirname']."_refer") . "");
    list($subitem, $refertitle) = $xoopsDB->fetchrow($result2);

    if ($subitem)
    {
        if (is_object($xoopsUser))
        {
            $modversion['sub'][$i]['name'] = $refertitle;
            $modversion['sub'][$i]['url'] = "index.php?op=refer";
        }
        else
        {
            if (isset($xoopsModuleConfig['anonrefer']))
            {
                $modversion['sub'][$i]['name'] = $refertitle;
                $modversion['sub'][$i]['url'] = "index.php?op=refer";
            }
        }
    }
}
// Search (the old search.inc.php is also available in the same folder. less usefull)
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc2.php";
$modversion['search']['func'] = "page_search";
// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'index.php';
$modversion['comments']['itemName'] = 'pagenum';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'pages_com_approve';
$modversion['comments']['callback']['update'] = 'pages_com_update';
// Templates
$modversion['templates'][1]['file'] = 'pages_index.html';
$modversion['templates'][1]['description'] = 'Display index';
$modversion['templates'][2]['file'] = $modversion['dirname'].'_linktous.html';
$modversion['templates'][2]['description'] = 'Display Link to Us page';
$modversion['templates'][3]['file'] = $modversion['dirname'].'_refer.html';
$modversion['templates'][3]['description'] = 'Display refer page';
$modversion['templates'][4]['file'] = 'pages_rss.html';
$modversion['templates'][4]['description'] = 'Display rss feed';


$i = 0;

$i++;
$modversion['config'][$i]['name'] = 'htmluploaddir';
$modversion['config'][$i]['title'] = '_MI_CHAN_HTMLUPLOADDIR';
$modversion['config'][$i]['description'] = '_MI_CHAN_HTMLUPLOADDIRDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'uploads/'.$modversion['dirname'].'/html';

$i++;
$modversion['config'][$i]['name'] = 'uploaddir';
$modversion['config'][$i]['title'] = '_MI_CHAN_UPLOADDIR';
$modversion['config'][$i]['description'] = '_MI_CHAN_UPLOADDIRDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'uploads/'.$modversion['dirname'].'/Image';

$i++;
$modversion['config'][$i]['name'] = 'linkimages';
$modversion['config'][$i]['title'] = '_MI_CHAN_LINKIMAGES';
$modversion['config'][$i]['description'] = '_MI_CHAN_UPLOADDIRDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'uploads/'.$modversion['dirname'].'/Image/linkimages';

$i++;
$modversion['config'][$i]['name'] = 'maxfilesize';
$modversion['config'][$i]['title'] = '_MI_CHAN_MAXFILESIZE';
$modversion['config'][$i]['description'] = '_MI_CHAN_MAXFILESIZEDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 50000;

$i++;
$modversion['config'][$i]['name'] = 'maximgwidth';
$modversion['config'][$i]['title'] = '_MI_CHAN_IMGWIDTH';
$modversion['config'][$i]['description'] = '_MI_CHAN_IMGWIDTHDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 600;

$i++;
$modversion['config'][$i]['name'] = 'maximgheight';
$modversion['config'][$i]['title'] = '_MI_CHAN_IMGHEIGHT';
$modversion['config'][$i]['description'] = '_MI_CHAN_IMGHEIGHTDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 600;

$i++;
$modversion['config'][$i]['name'] = 'html_import_show';
$modversion['config'][$i]['title'] = '_MI_CHAN_HTMLIMPORTSHOW';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'html_clean';
$modversion['config'][$i]['title'] = '_MI_CHAN_HTMLCLEAN';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'anonlink';
$modversion['config'][$i]['title'] = '_MI_CHAN_LINK';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'anonrefer';
$modversion['config'][$i]['title'] = '_MI_CHAN_ANONREFER';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'use_wysiwyg';
$modversion['config'][$i]['title'] = '_MI_CHAN_WYSIWYG';
$modversion['config'][$i]['description'] = '_MI_CHAN_WYSIWYGDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array('XoopsEditor'  => 'default',
                                   		'Tiny Editor'   => 'tiny',
                                   		'FCK Editor'   => 'fck',
                                   		'Koivi Editor'   => 'koivi',
                                  		'Inbetween' => 'inbetween',
                                  		'Spaw' => 'spaw');
$modversion['config'][$i]['default'] ='default';


$i++;
$modversion['config'][$i]['name'] = 'displaypagetitle';
$modversion['config'][$i]['title'] = '_MI_CHAN_DISPLAYTITLE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'stopshouting';
$modversion['config'][$i]['title'] = '_MI_CHAN_STOPSHOUTING';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

// gestion du menu intégré
$i++;
$modversion['config'][$i]['name'] = 'displaymenu';
$modversion['config'][$i]['title'] = '_MI_CHAN_DISPLAYMENU';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_CHAN_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_MYDOWNLOADS_PERPAGEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);

$i++;
$modversion['config'][$i]['name'] = 'menunav';
$modversion['config'][$i]['title'] = '_MI_CHAN_MENUNAVTYP';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '_MI_CHAN_MENUNAVTYPV';
$modversion['config'][$i]['options'] = array('_MI_CHAN_MENUNAVTYPV' => '_MI_CHAN_MENUNAVTYPV', '_MI_CHAN_MENUNAVTYPH' => '_MI_CHAN_MENUNAVTYPH');


/*  for the next version
$handle = opendir(XOOPS_ROOT_PATH.'/uploads/'.$modversion['dirname'].'/Image/imageset/');
while (false !== ($file = readdir($handle))) {
  if (is_dir(XOOPS_ROOT_PATH.'/uploads/'.$modversion['dirname'].'/Images/imageset/'.$file) && !preg_match("/^[.]{1,2}$/",$file) && strtolower($file) != 'cvs') {
    $dirlist[$file]=$file;
  }
}
closedir($handle);

$modversion['config'][16] = array(
	'name' 			=> 'imageset',
	'title' 		=> '_MI_CHAN_IMAGESET',
	'description' 	=> '_MI_CHAN_IMAGESETDESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'text',
	'options' 		=> $dirlist,
	'default' 		=> "default");
*/
?>