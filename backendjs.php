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

// Hacked from backend.php by lykoszine@yahoo.co.uk
// Uses the following CSS classes:
// rss_title
// rss_body
// rss_footer

$filename = "cache/backendjs.txt"; //File to read/write
//$timespan = 3600; //1 hours (if the file is more recent than this, it will not be updated)
$timespan = 1; //1 hours (if the file is more recent than this, it will not be updated)

include( "../../mainfile.php" );

$fd = fopen( $filename, "rb" );
if ( $fd and ( time() - filemtime ( $filename ) < $timespan ) )
{
    $contents = fread ( $fd, filesize ( $filename ) );
    echo $contents;
    fclose ( $fd );
} 
else
{
    fclose ( $fd );

    $sql = "SELECT CID, pagetitle, pageheadline, weight FROM " . $xoopsDB -> prefix( "pages" ) . " WHERE (publishdate > 0 AND publishdate <= " . time() . ") AND (expiredate = 0 OR expiredate > " . time() . ") ORDER BY weight";
    $result = $xoopsDB -> query( $sql, 10, 0 );
    if ( !$result )
    {
        echo "An error occured";
    } 
    else
    {
        $fd = fopen ( $filename, "w+b" );
        $temp = "<script language='Javascript'>";
        $temp .= "document.write('<div class=\"rss_title\">";
        $temp .= "<a href=\"" . XOOPS_URL . "\">" . $xoopsConfig['sitename'] . "</a> Pages<br /></div>');\n";

        while ( $myrow = $xoopsDB -> fetchArray( $result ) )
        {
            $myrow = str_replace( "(", "-", $myrow );
            $myrow = str_replace( ")", "-", $myrow );
            $myrow = str_replace( "'", "", $myrow );

//pour éviter de doublonner le titre si le titre et headline sont identiques

						if ($myrow['pagetitle'] = $myrow['pageheadline']){
						$text = $myrow['pagetitle'];}
						else
						{
						$text =	$myrow['pagetitle'] . " : ". $myrow['pageheadline'];
						}

            $temp .= "document.write('<LI><span class=\"rss_body\"><A HREF=\"" . XOOPS_URL . "/modules/pages/index.php?pagenum=" . $myrow['CID'] . "\" target=blank>";
            $temp .= $text. "</a></span><br />');\n";
        } 

        $t = formatTimeStamp( time(), "m", "" . $xoopsConfig['server_TZ'] . "" );
        $temp .= "document.write('<div class=\"rss_footer\">Updated : $t</div>');";
    } 
    $temp .="</script>";
    echo $temp;
    fwrite ( $fd, $temp, strlen( $temp ) );
    fclose ( $fd );
} 

?>