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
 * This function provide mecanisms to remove a directory and all its content.
 * Thanks to <manuelle_slow@yahoo.fr> for this nice function which saved me
 * some developpement time.
 */
function remove_dir($dir) {

	$nbRemoved = 0;
	$directory = opendir($dir);

	// Removing loop
	while ($file = readdir($directory)) {

		// Excludes current and parent directory
		$exclude = array('.', '..');
		if (!in_array( $file, $exclude)) {
			if (is_dir($dir.'/'.$file)){

				// Recursive removing if another directory
				$nbRemoved += remove_dir($dir.'/'.$file);
			} else {
				unlink($dir.'/'.$file);
				$nbRemoved++;
			}
		}
	}
	closedir($directory);
	rmdir($dir);
	return $nbRemoved;
}

/**
 * This this function is charged to execute additionnal uninstallation script.
 * This code is executed automacically on module uninstallation
 * $modversion['onUninstall'] = 'include/install.php';
 */
function xoops_module_uninstall_pages(&$module) {

	// Deleting all folders directories
	$pagesDirectory = XOOPS_ROOT_PATH.'/uploads/'.$module->getInfo('dirname');
	if (file_exists($pagesDirectory)) {
		$exclude = array('.', '..');
		$pagesDir = dir($pagesDirectory);
		while ($toRemove = $pagesDir->read()) {
			if (!in_array($toRemove, $exclude)) {
				$toRemove = $pagesDirectory.'/'.$toRemove;
				if (is_dir($toRemove)) {
					if (remove_dir($toRemove) <= 0) return false;
				} else {
					if (!unlink($toRemove)) return false;
				}
			}
		}
		$pagesDir->close();
	}
  if (!unlink($pagesDirectory)) return false;
	// No error
	return true;
}
?>