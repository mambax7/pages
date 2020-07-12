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

include XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/htmlcleaner.php';

function wfc_htmlarray($thishtmlpage, $thepath)
{
    global $xoopsConfig, $wfsConfig;

    $file_array = wfc_filesarray($thepath);

    echo "<select size='1' name='htmlfile'>";
    echo "<option value='0'>---------------------</option>";
    foreach($file_array as $htmlpage)
    {
        if ($htmlpage == $thishtmlpage)
        {
            $opt_selected = "selected='selected'";
        }
        else
        {
            $opt_selected = "";
        }
        echo "<option value='" . $htmlpage . "' $opt_selected>" . $htmlpage . "</option>";
    }
    echo "</select>";
    return $htmlpage;
}

function wfc_filesarray($filearray)
{
    $files = array();
    $dir = opendir($filearray);

    while (($file = readdir($dir)) !== false)
    {
        if ((!preg_match("/^[.]{1,2}$/", $file) && preg_match("/[.htm|.html|.xhtml|.php]$/i", $file) && !is_dir($file)))
        {
            if (strtolower($file) != 'cvs' && !is_dir($file))
            {
                $files[$file] = $file;
            }
        }
    }
    closedir($dir);
    asort($files);
    reset($files);
    return $files;
}

function wfc_getDirSelectOption($selected, $dirarray, $namearray, $addnull = 0)
{
    // global $workd;
    echo "<select size='1' name='workd' onchange='location.href=\"upload.php?rootpath=\"+this.options[this.selectedIndex].value'>";
    if ($addnull == 1)
    {
        echo "<option value=''>--------------------------------------</option>";
    }
    foreach($namearray as $namearray => $workd)
    {
        if ($workd === $selected)
        {
            $opt_selected = "selected";
        }
        else
        {
            $opt_selected = "";
        }
        echo "<option value='" . htmlspecialchars($namearray, ENT_QUOTES) . "' $opt_selected>" . $workd . "</option>";
    }
    echo "</select>";
}

/**
 * adminmenu()
 *
 * @param string $header optional : You can gice the menu a nice header
 * @param string $extra optional : You can gice the menu a nice footer
 * @param array $menu required : This is an array of links. U can
 * @param int $scount required : This will difine the amount of cells long the menu will have.
 * NB: using a value of 3 at the moment will break the menu where the cell colours will be off display.
 * @return THIS ONE WORKS CORRECTLY
 */
function wfc_adminmenu($header = '', $menu = '', $extra = '', $scount = 5)
{
    global $xoopsConfig, $xoopsModule;

    if (isset($_SERVER['PHP_SELF'])) $thispage = basename($_SERVER['PHP_SELF']);
    $op = (isset($_GET['op'])) ? $op = "?op=" . $_GET['op'] : '';

    if (empty($menu))
    {
        /**
         * You can change this part to suit your own module. Defining this here will save you form having to do this each time.
         */
        $menu = array(
            _AM_GENERALSET => "" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "",
            _AM_MAINADMIN => "index.php?op=default",
            _AM_GROUPPERMISSIONS => "permissions.php",
            _AM_UPLOAD => "upload.php",
            _AM_INEEDHELP => "http://wfsections.xoops2.com/modules/newbb/index.php?cat=5",
            _AM_CREATENEWPAGE => "index.php?op=create",
            _AM_CLINKTOUS => "index.php?op=links",
            _AM_REFER => "index.php?op=refer",
            _AM_REORDER => "reorder.php",
            _AM_REPORTBUGS => "http://wfsections.xoops2.com/modules/mantis/bug_report_page.php",
            );
    }

    if (!is_array($menu))
    {
        echo "<table width = '100%' cellpadding= '2' cellspacing= '1' class='outer'>";
        echo "<tr><td class = even align = center><b>No menu items within the menu</b></td></tr></table><br />";
        return false;
    }

    $oddnum = array(1 => "1", 3 => "3", 5 => "5", 7 => "7", 9 => "9", 11 => "11", 13 => "13");
    // number of rows per menu
    $menurows = count($menu) / $scount;
    // total amount of rows to complete menu
    $menurow = ceil($menurows) * $scount;
    // actual number of menuitems per row
    $rowcount = $menurow / ceil($menurows);

    for ($i = count($menu); $i < $menurow; $i++)
    {
        $tempArray = array(1 => null);
        $menu = array_merge($menu, $tempArray);
        $count++;
    }

    /**
     * Sets up the width of each menu cell
     */
    $width = 100 / $scount;
    $width = ceil($width);

    $menucount = 0;
    $count = 0;
    /**
     * Menu table output
     */
    echo "<h3>" . $header . "</h3>";
    echo "<table width = '100%' cellpadding= '2' cellspacing= '1' class='outer'><tr>";

    /**
     * Check to see if $menu is and array
     */
    if (is_array($menu))
    {
        $classcounts = 0;
        $classcol[0] = "even";

        for ($i = 1; $i < $menurow; $i++)
        {
            $classcounts++;
            if ($classcounts >= $scount)
            {
                if ($classcol[$i-1] == 'odd')
                {
                    $classcol[$i] = ($classcol[$i-1] == 'odd' && in_array($classcounts, $oddnum)) ? "even" : "odd";
                }
                else
                {
                    $classcol[$i] = ($classcol[$i-1] == 'even' && in_array($classcounts, $oddnum)) ? "odd" : "even";
                }
                $classcounts = 0;
            }
            else
            {
                $classcol[$i] = ($classcol[$i-1] == 'even') ? "odd" : "even";
            }
        }
        unset($classcounts);

        foreach ($menu as $menutitle => $menulink)
        {
            if ($thispage . $op == $menulink)
            {
                $classcol[$count] = "outer";
            }
            echo "<td class='" . $classcol[$count] . "' align='center' valign='middle' width= $width%>";
            if (is_string($menulink))
            {
                echo "<a href='" . $menulink . "'>" . $menutitle . "</a></td>";
            }
            else
            {
                echo "&nbsp;</td>";
            }
            $menucount++;
            $count++;
            /**
             * Break menu cells to start a new row if $count > $scount
             */
            if ($menucount >= $scount)
            {
                echo "</tr>";
                $menucount = 0;
            }
        }
        echo "</table><br />";
        unset($count);
        unset($menucount);
    }
    if ($extra)
    {
        echo "<div>$extra</div>";
    }
}


function wfc_uploading($allowed_mimetypes, $httppostfiles, $redirecturl = "index.php", $num = 0, $dir = "uploads", $redirect = 0)
{
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";

    global $xoopsConfig, $xoopsModuleConfig, $HTTP_POST_VARS;

    $maxfilesize = $xoopsModuleConfig['maxfilesize'];
    $maxfilewidth = $xoopsModuleConfig['maximgwidth'];
    $maxfileheight = $xoopsModuleConfig['maximgheight'];
    $uploaddir = XOOPS_ROOT_PATH . "/" . $dir . "/";

    $uploader = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);

    if ($uploader->fetchMedia($HTTP_POST_VARS['xoops_upload_file'][$num]))
    {
        if (!$uploader->upload())
        {
            $errors = $uploader->getErrors();
            redirect_header($redirecturl, 1, $errors);
        }
        else
        {
            if ($redirect)
            {
                redirect_header($redirecturl, 1 , _AM_FILEUPLOADED);
            }
        }
    }
    else
    {
        $errors = $uploader->getErrors();
        redirect_header($redirecturl, 1, $errors);
    }
}

function wfc_cleanvars($string)
{
    $string = str_replace(".", ". ", $string);
    $string = str_replace(",", ", ", $string);
    $string = str_replace(" ,", ", ", $string);
    $string = str_replace("!", "! ", $string);
    $string = str_replace("?", "? ", $string);
    $string = str_replace(":", ": ", $string);
    $string = str_replace(";", "; ", $string);
    $string = str_replace("-", " - ", $string);
    $string = str_replace('"', "", $string);
    // Remove multiple spaces/tabs
    $string = str_replace ("\"", "", $string);
    $string = str_replace ("'", "", $string);

    $string = preg_replace('/[ \t]{2,}/', ' ', $string);
    // $string = preg_replace('/"/',"",$string);
    // Remove multipule lines
    $string = preg_replace('/(\n|\r|\r\n){2,}/', '\r', $string);
    $string = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array('/ /', '\r'), $string);

    return trim($string);
}

function wfc_removeShouting($string)
{
    global $xoopsModuleConfig;
    // $lower_exceptions = array("to" => "1", "a" => "1", "the" => "1", "of" => "1"
    $lower_exceptions = array("to" => "1", "of" => "1"
        );

    $higher_exceptions = array("I" => "1", "II" => "1", "III" => "1", "IV" => "1",
        "V" => "1", "VI" => "1", "VII" => "1", "VIII" => "1",
        "XI" => "1", "X" => "1", "I™" => "1", "II™" => "1", "III™" => "1", "IV™" => "1",
        "V™" => "1", "VI™" => "1", "VII™" => "1", "VIII™" => "1",
        "XI™" => "1", "X™" => "1", "I:" => "1", "II:" => "1", "III:" => "1", "IV:" => "1",
        "V:" => "1", "VI:" => "1", "VII:" => "1", "VIII:" => "1",
        "XI:" => "1", "X:" => "1"
        );

    wfc_cleanvars($string);

    if (!$xoopsModuleConfig['stopshouting'])
    {
        return $string;
    }

    $words = split(" ", $string);
    $newwords = array();
    foreach ($words as $word)
    {
        if (!in_array($word, $higher_exceptions)) $word = strtolower($word);
        if (!in_array($word, $lower_exceptions))$word[0] = strtoupper($word[0]);
        array_push($newwords, $word);
    }
    $text = join(" ", $newwords);
    $text = str_replace ("Array", "", $text);
    $text = preg_replace('/[ \t]{2,}/', ' ', $text);
    return $text;
}

function loadfile($file)
{
    global $xoopsModuleConfig;

    $file = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['htmluploaddir'] . "/" . $file;
    if (file_exists($file) && false !== $fp = fopen($file, 'r'))
    {
        $file = fread($fp, filesize($file));
    }
    fclose($fp);

    return $file;
}
// Not used yet
function convertword($DocumentPath)
{
    global $xoopsModuleConfig, $myts;
    // $DocumentPath ;
    // $file = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['htmluploaddir'] . "/" . $file;> $word = new COM("word.application") or die("Unable to instantiate Word"); > print "Loaded Word, version {$word->Version}<br />"; > $word->Visible = 1; > $word->Documents->Add(); > $word->Selection->TypeText("This is a test..."); > $word->Documents[1]->SaveAs("Useless test.doc"); > $word->Quit();
    $word = new COM("word.application") or die("Unable to instantiate application object");
    $wordDocument = new COM("Word.Application") or die("Unable to instantiate document object");
    $wordDocument = $word->Documents->Open($DocumentPath);
    $htmlfile = substr_replace(basename($DocumentPath), 'html', -3, 3);
    $htmlfile = strtolower(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['htmluploaddir'] . "/" . $myts->htmlSpecialChars($htmlfile));

    echo $htmlfile;
    $wordDocument->SaveAs($htmlfile, 8);
    $wordDocument = null;
    $word->Quit();
    $word = null;

    return basename($htmlfile);
}
// end


//philou menu

function pages_tabsAdminMenu($file) {

	global $xoopsModule;


	// Configuring different tables
	$url = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/admin';
	$tabs = array();
	$tabs[] = array(
				'title' => _AM_GENERALSET,
				'url' => XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "",
				'color' => ''
				);
	$tabs[] = array(
				'title' => _AM_MAINADMIN,
				'url' => $url.'/index.php?op=default',
				'color' => ''
				);
	$tabs[] = array(
				'title' => _AM_CREATENEWPAGE,
				'url' => $url.'/index.php?op=create',
				'color' => ''
				);
	$tabs[] = array(
				'title' => _AM_GROUPPERMISSIONS,
				'url' => $url.'/permissions.php',
				'color' => ''
				);
	$tabs[] = array(
				'title' => _AM_REORDER,
				'url' => $url.'/reorder.php',
				'color' => ''
				);
  $tabs[] = array(
				'title' => _AM_UPLOAD,
				'url' => $url.'/upload.php',
				'color' => ''
				);

	// Call generic function with correct params
	xoops_pagestabAdminMenu($xoopsModule, $file, $tabs);
}

/**
 * Creates nice menu with tabs.
 */
function xoops_pagestabAdminMenu($module, $file, $tabs) {

	// Nice buttons styles
	$imgUrl = XOOPS_URL."/modules/".$module->getVar('dirname').'/Image';
	echo "<style type='text/css'>\n"
		."#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }\n"
		."#buttonbar { float:left; width:100%; background: #e7e7e7 url('".$imgUrl."/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }\n"
		."#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }\n"
		."#buttonbar li { display:inline; margin:0; padding:0; }\n"
		."#buttonbar a { float:left; background:url('".$imgUrl."/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }\n"
		."#buttonbar a span { float:left; display:block; background:url('".$imgUrl."/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }\n"
		."/* Commented Backslash Hack hides rule from IE5-Mac */\n"
		."#buttonbar a span {float:none;}\n"
		."/* End IE5-Mac hack */\n"
		."#buttonbar a:hover span { color:#333; }\n"
		."#buttonbar #current a { background-position:0 -150px; border-width:0; }\n"
		."#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }\n"
		."#buttonbar a:hover { background-position:0% -150px; }\n"
		."#buttonbar a:hover span { background-position:100% -150px; }\n"
		."</style>\n";

	// Current tab special settings
	$page = preg_replace("'^.*[\\/](.*?\.php).*$'", "\\1", $file);
	foreach ($tabs as $i => $tab) {
		if (strpos($tab['url'], $page)) {
			$tabs[$i]['color'] = 'current';
		}
	}

	// Displaying tabs
	echo "<div id='buttontop'>\n"
		."<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\">\n"
		."<tr>\n"
		."<td style='font-size: 10px; text-align: right;' colspan='2'>&nbsp;</td>\n"
		."</tr>\n"
		."</table>\n"
		."</div>"
		."<div id='buttonbar'>\n"
		."<ul>";
	foreach ($tabs as $tab) {
		echo "<li id='" . $tab['color'] . "'><a href=\"".$tab['url']."\"><span>".$tab['title']."</span></a></li>\n";
	}
	echo "</ul>\n"
		."</div>&nbsp;\n";
}


/**
* Fonction qui indique si une page est visible de l'utilisateur courant.
*
* Passer à la fonction le numéro de la page à tester.
* La valeur de retour est un booleen (true = page visible, false = page non visible)
*
* @package pages
* @author Christian, Philou et Hervé
* @copyright Christian, Philou et Hervé
* @version 1.0
* @param int $page_id le numéro de la page à tester
*/
function pages_IsPageVisible($page_id)
{
	global $xoopsUser;
	$valret = false;

	static $tblperms= Array();
	if(is_array($tblperms) && array_key_exists($page_id,$tblperms)) {
		return $tblperms[$page_id];
	}

   	$module_handler =& xoops_gethandler('module');
   	$pagesModule =& $module_handler->getByDirname('pages');
   	$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
   	$gperm_handler =& xoops_gethandler('groupperm');

   	$valret = $gperm_handler->checkRight('Page_permissions', intval($page_id), $groups, $pagesModule->getVar('mid'));
	$tblperms[$page_id] = $valret;
    return $valret;
}

?>