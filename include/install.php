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
 * This this function is charged to execute additionnal installation script.
 * This code is executed automacically on module installation
 * $modversion['onInstall'] = 'include/install.php';
 */
   
function xoops_module_install_pages(&$module) {  

global $xoopsModule, $xoopsModuleConfig;
$modhandler = &xoops_gethandler('module');

$chemin        = XOOPS_ROOT_PATH.'/uploads/'.$module->getInfo('dirname').'/';
$cheminhtml_o  = XOOPS_ROOT_PATH.'/modules/'.$module->getInfo('dirname').'/html';
$cheminhtml_oi = XOOPS_ROOT_PATH.'/modules/'.$module->getInfo('dirname').'/Image';

//create the empty folders
mkdir("$chemin",0777);

 function create_tab ($dir) { 
     $dir = rtrim ($dir, '/'); 
         if (is_dir ($dir)) 
             $dh = opendir ($dir); 
         else {
             echo $dir, ' n\'est pas un repertoire valide'; 
             exit;
             }
         while (($file = readdir ($dh)) !== false ) { 
             if ($file !== '.' && $file !== '..') { 
                 $path =$dir.'/'.$file; 
                 if (is_dir ($path)) { 
                     $tableau[$dir]['dir'][] = $path;
                     $tabTmp = create_tab ($path); 
                     if (is_array ($tabTmp) && is_array ($tableau))
                         $tableau = array_merge ($tableau, $tabTmp);
                 }
                 else
                     $tableau[$dir]['file'][] = $path;
             }
         }
         closedir ($dh); 
         if (isset ($tableau)) {
             return $tableau;
         }
     }
  
 function copier_rep ($destination, $reps, $tableau_dir = array ()) { 
         if (empty ($tableau_dir)) {
//             echo 'Entrée';
             $tableau_dir = create_tab ($reps);
         }
         if (!is_array ($reps)) {
             $reps = array ($reps);
         }
         foreach ($reps as $rep) {
             if (!is_dir ($destination.'/'.basename ($rep))) {
                 mkdir ($destination.'/'.basename ($rep),0777);
                 if (!empty ($tableau_dir[$rep]['file']) && isset($tableau_dir[$rep]['file']) && is_array ($tableau_dir[$rep]['file'])) {
                     foreach ($tableau_dir[$rep]['file'] as $fichier) {
                         copy ($fichier, $destination.'/'.basename ($rep).'/'.basename ($fichier));
                         chmod ($destination.'/'.basename ($rep).'/'.basename ($fichier), 0777);
                     }
                 }
                 if (!empty ($tableau_dir[$rep]['dir']) && isset ($tableau_dir[$rep]['dir']) && is_array ($tableau_dir[$rep]['dir'])) {
                     copier_rep ($destination.'/'.basename ($rep), $tableau_dir[$rep]['dir'], $tableau_dir);
                 }
             }
         }
     }
     
 // 1er paramètre : le répertoire de destination sous forme d'une chaine
 // 2d paramètre : le répertoire à copier sous forme d'une chaine ou d'un tableau 
copier_rep ($chemin, $cheminhtml_o); 
copier_rep ($chemin, $cheminhtml_oi); 

	return true;
}
?>