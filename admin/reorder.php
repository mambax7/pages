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

$op = "";

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

if (isset($HTTP_GET_VARS['op'])) $op = $HTTP_GET_VARS['op'];
if (isset($HTTP_POST_VARS['op'])) $op = $HTTP_POST_VARS['op'];

switch ($op)
{
    case "reorder":

        global $orders, $cat;

        for ($i = 0; $i < count($orders); $i++)
        {
            $xoopsDB->queryF("update " . $xoopsDB->prefix("pages") . " set weight = " . $orders[$i] . " WHERE CID=$cat[$i]");
        }
        redirect_header("reorder.php", 1, _AM_REORDERCHANNEL);

        break;

    case "default":
    default:

        xoops_cp_header();

        global $xoopsConfig, $xoopsModule, $HTTP_GET_VARS;

//        wfc_adminmenu(_AM_CHANADMIN);
        echo "<table width='100%'><tr><td align='center'><img src='../Image/pages.gif' alt='' title=''></td><td align='right' width='55'><a href='../help/help.php'><img src='../Image/help.gif' alt='aide' title='aide'></a></td></tr></table><br />";
        pages_tabsAdminMenu(__FILE__);

        $orders = array();
        $cat = array();

       	echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_REORDERADMIN . "</legend>";
        echo "<div style='padding: 8px;'>" . _AM_REORDERINTRO . "</div>";

        echo "<form name='reorder' METHOD='post'>";
        echo "<table border='0' width='100%' cellpadding = '2' cellspacing ='1' class = 'outer'>";
        echo "<tr>";
        echo "<td class = bg3 align='center' width=3% height =16 ><b>" . _AM_REORDERID . "</b>";
        echo "</td><td class = bg3 align='left' width=30%><b>" . _AM_REORDERTITLE . "</b>";
        echo "</td><td class = bg3 align='center' width=5%><b>" . _AM_REORDERWEIGHT . "</b>";
        echo "</td></tr>";

        $result = $xoopsDB->query("SELECT CID, pagetitle, weight FROM " . $xoopsDB->prefix("pages") . " ORDER BY weight");
        while ($myrow = $xoopsDB->fetchArray($result))
        {
            echo "<tr>";
            echo "<td align='center' class = head>" . $myrow['CID'] . "</td>";
            echo "<input type='hidden' name='cat[]' value='" . $myrow['CID'] . "' />";
            echo "<td align='left' nowrap='nowrap' class = even>" . $myrow['pagetitle'] . "</td>";
            echo "<td align='center' class = even>";
            echo "<input type='text' name='orders[]' value='" . $myrow['weight'] . "' size='5' maxlenght='5'>";
            echo "</td>";
            echo "</tr>";
        }
        echo "<tr><td class='even' align='center' colspan='6'>";
        echo "<input type='hidden' name='op' value=reorder />";
        echo "<input type='submit' name='submit' value='" . _SUBMIT . "' />";

        echo "</td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</fieldset>";
		break;
}
xoops_cp_footer();

?>
