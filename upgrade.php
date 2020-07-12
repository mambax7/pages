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

global $xoopsDB, $xoopsConfig;
include(XOOPS_ROOT_PATH . "/header.php");

function install_header()
{

    ?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title>WFChannel Upgrade</title>
	<meta http-equiv="Content-Type" content="text/html; charset=">
	<meta name="AUTHOR" content="WFCHANNEL">
	<meta name="GENERATOR" content="WFCHANNEL---->http://www.wf-projects.com">
	</head>
	<body>
	<div style='text-align:center'><h4>WFChannel Update</h4>
<?php
} 

function install_footer()
{

    ?>
	</body>
	</html>
<?php

} 
// echo "Welcome to the WF-Channel update script";
foreach ($HTTP_POST_VARS as $k => $v)
{
    ${$k} = $v;
} 

foreach ($HTTP_GET_VARS as $k => $v)
{
    ${$k} = $v;
} 

if (!isset($action) || $action == "")
{
    $action = "message";
} 

if ($action == "message")
{
    install_header();
    echo "
  <table width='100%' border='0'>
  <tr>
    <td align='center'><b>" . _MD_UPDATE1 . "</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>";

    echo "
	<table width='50%' border='0'><tr><td colspan='2'>" . _MD_UPDATE2 . "<br /><br /><b>" . _MD_UPDATE3 . "<b></td></tr>

	<tr><td></td><td >" . _MD_UPDATE4 . "</td></tr>
	<tr><td></td><td><span style='color:#ff0000;font-weight:bold;'>" . _MD_UPDATE5 . "</span></td></tr>
	</table>
	";
    echo "<p>" . _MD_UPDATE6 . "</p>";
    echo "<form action='" . $HTTP_SERVER_VARS['PHP_SELF'] . "' method='post'><input type='submit' value='Start Upgrade' /><input type='hidden' value='upgrade' name='action' /></form>";
    install_footer();
    
} 
// THIS IS THE UPDATE DATABASE FROM HERE!!!!!!!!! DO NOT TOUCH THIS!!!!!!!!
if ($action == "upgrade")
{
    install_header();

    echo "<p>" . _MD_UPDATE24 . "</p>\n";
    $count = 0;
    $result = $xoopsDB->queryF("SELECT * FROM " . $xoopsDB->prefix("wfsrefer") . " ");
    if ($result)
    {
        $error[] = "Skipped! Creating table <b>" . $xoopsDB->prefix("wfsrefer") . "</b>, it already exist.";
    } 
    else
    {
        $xoopsDB->queryF("CREATE TABLE " . $xoopsDB->prefix("wfsrefer") . " ( 
		titlerefer varchar(255) NOT NULL default '', 
		chanrefheadline text, 
		submenuitem int(10) NOT NULL default '10', 
		mainpage int(10) NOT NULL default '1', 
		referpagelogo varchar(255) NOT NULL default '', 
		emailaddress int(10) NOT NULL default '1', 
		usersblurb int(10) NOT NULL default '0', 
		defblurb varchar(255) NOT NULL default '', 
		smiley tinyint(11) NOT NULL default '0', 
		xcodes tinyint(11) NOT NULL default '0', 
		breaks tinyint(4) NOT NULL default '0', 
		html tinyint(11) NOT NULL default '1', 
		PRIMARY KEY  (submenuitem) 
		)");

        $xoopsDB->queryF("INSERT INTO  " . $xoopsDB->prefix("wfsrefer") . " set titlerefer = 'Refer a friend', chanrefheadline = 'Let a friend know about us', submenuitem = '1', mainpage ='1', referpagelogo = 'referfriend.png', emailaddress = '1', usersblurb = '1', defblurb = '', smiley = '0', xcodes = '1', breaks ='1', html= '1'");
        echo "Created New Table " . $xoopsDB->prefix("wfsrefer") . ".<br />";
        $count++;
    } 

	$result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfsrefer") . " ADD privacy int(1) NOT null default '1' AFTER html");
    if ($result)
    {
        echo "Adding privacy to " . $xoopsDB->prefix("wfsrefer") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfsrefer") . " ADD emailcheck int(1) NOT null default '1' AFTER privacy");
    if ($result)
    {
        echo "Adding emailcheck to " . $xoopsDB->prefix("wfsrefer") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfsrefer") . " ADD privacy_statement text NOT null AFTER emailcheck");
    if ($result)
    {
        echo "Adding privacy_statement to " . $xoopsDB->prefix("wfsrefer") . ".<br />";
        $count++;
    } 

	$result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfsrefer") . " ADD counter int(11) NOT NULL default '0' AFTER privacy_statement");
    if ($result)
    {
        echo "Adding privacy to " . $xoopsDB->prefix("wfsrefer") . ".<br />";
        $count++;
    } 
    	
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfslinktous") . " ADD texthtml varchar(255) NOT NULL default '' AFTER newsfeed");
    if ($result)
    {
        echo "Adding texthtml to " . $xoopsDB->prefix("wfslinktous") . ".<br />";
        $count++;
    } 

    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfslinktous") . " ADD linkintro text NOT NULL AFTER newstitle");
    if ($result)
    {
        echo "Adding linkintro to " . $xoopsDB->prefix("wfslinktous") . ".<br />";
        $count++;
    } 

    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfslinktous") . " ADD titlelink varchar(255) NOT NULL default 'Link to Us' AFTER texthtml");
    if ($result)
    {
        echo "Adding titlelink to " . $xoopsDB->prefix("wfslinktous") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfslinktous") . " ADD newsfeedjs mediumint(10) NOT NULL default '0' AFTER titlelink");
    if ($result)
    {
        echo "Adding newsfeedjs to " . $xoopsDB->prefix("wfslinktous") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfslinktous") . " ADD newstitle varchar(255) NOT NULL default '' AFTER newsfeedjs");
    if ($result)
    {
        echo "Adding newstitle to " . $xoopsDB->prefix("wfslinktous") . ".<br />";
        $count++;
    } 

    $time = time();
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD created int(10) NOT NULL default '" . $time . "' AFTER submenu");
    if ($result)
    {
        echo "Adding created to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 

    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD comments tinyint(11) NOT NULL default '0' AFTER created");
    if ($result)
    {
        echo "Adding comments to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 

    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD allowcomments tinyint(11) NOT NULL default '0' AFTER comments");
    if ($result)
    {
        echo "Adding allowcomments to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 
    // Added here 18/03/2004
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD usedoctitle tinyint(1) NOT NULL default '0' AFTER allowcomments");
    if ($result)
    {
        echo "Adding usedoctitle to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD publishdate int(10) unsigned NOT NULL default '" . $time . "' AFTER usedoctitle");
    if ($result)
    {
        echo "Adding publishdate to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD expiredate int(10) unsigned NOT NULL default '0' AFTER publishdate");
    if ($result)
    {
        echo "Adding expiredate to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 
    $result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix("wfschannel") . " ADD counter int(11) NOT NULL default '0' AFTER expiredate");
    if ($result)
    {
        echo "Adding counter to " . $xoopsDB->prefix("wfschannel") . ".<br />";
        $count++;
    } 

    $xoopsDB->queryF("UPDATE " . $xoopsDB->prefix("wfslinktous") . " SET textlink = 'Change Me', titlelink = 'Link to us', button = 'poweredby.gif', logo = 'logo.gif', banner = 'xoops_banner_2.gif', linkpagelogo = 'linktous.png', newsfeed = '1', submenuitem = '1', mainpage = '1', newsfeedjs = '1', newstitle = '', linkintro = 'We welcome you to link to our Web site.  Feel free to create links from any section of your Web site to our articles about your website.  You are also welcome to link to our website directories and other resource pages.\r\n<br /><br />Whenever possible, we ask that you include our logo with the link on your Web site.  You may use any of the logos below.  Please make the logo a clickable link to the home page of our site, or another appropriate page if you are linking to a specific article or resource.\r\n<br /><br />To get a copy of the logo file, simply right-click on the logo of your choice below, and select \'Save Picture as...\' from the pop-up menu to save the image to your hard drive.  Then post the logo to the appropriate page on your site.'");
    $xoopsDB->queryF("UPDATE " . $xoopsDB->prefix("wfsrefer") . " SET titlerefer = 'Refer a friend', chanrefheadline = 'Let a friend know about us.', submenuitem = '1', mainpage = '1', emailaddress = '1', usersblurb = '1', defblurb = 'Please visit this fantastic website that I have just found.', referpagelogo = 'referfriend.png', html ='1', smiley ='0', xcodes ='1', breaks ='1', privacy ='1', emailcheck ='1',  privacy_statement = 'We will not and do not collect, sell, or distribute in any way or form the email addresses gathered through this referral option. The intended recipient(s) will only receive the following message and no one else.'");

    if ($count == 0)
    {
        echo "<div>There where No updates to the database</div>";
    } 
    else
    {
        echo "<br />";
        echo "" . _MD_UPDATE22 . "";
    } 
    echo $result;
    echo "<p><span> <a href='index.php'>" . _MD_UPDATE23 . "</a></span></p>\n";
	install_footer();
   
} 

?>