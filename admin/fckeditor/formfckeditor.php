<?php
// $Id: formfckeditor.php,V 1.0 phppp Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
/**
 * Adapted FCKeditor
 *
 * @author	    phppp, http://xoops.org.cn
 * @copyright	copyright (c) 2004 XOOPS.org
 *
 * @package     NewBB 2.0
 * @subpackage  form
 */

class XoopsFormFckeditor extends XoopsFormTextArea
{
	var $language = _LANGCODE;
	var $filePath = "";
	var $uploadEnabled = false;
	var $allowdedExtensions = '';
	var $width;
	var $height;

	/**
	 * Constructor
	 *
     * @param	string  $caption      Caption
     * @param	string  $name         "name" attribute
     * @param	string  $value        Initial text
     * @param	string  $width        iframe width
     * @param	string  $height       iframe height
     * @param	array   $options      Toolbar Options
	 */
	function XoopsFormFckeditor($caption, $name, $value="", $width="100%", $height="300px", $checkCompatible = false)
	{
		if($checkCompatible && !$this->isCompatible()) {
			$this = false;
			return false;
		}
		$this->XoopsFormTextArea($caption, $name, $value);
		$this->width=$width;
		$this->height=$height;
	}

	/**
	 * get textarea width
	 *
     * @return	string
	 */
	function getWidth()
	{
		return $this->width;
	}

	/**
	 * get textarea height
	 *
     * @return	string
	 */
	function getHeight()
	{
		return $this->height;
	}

	/**
	 * get language
	 *
     * @return	string
	 */
	function getLanguage()
	{
		return str_replace('_','-',strtolower($this->language));
	}

	/**
	 * set language
	 *
     * @return	null
	 */
	function setLanguage($lang='en')
	{
		$this->language = $lang;
	}

	/**
	 * get allowed extensions for uploading
	 *
     * @return	string
	 */
	function getAllowedExtensions()
	{
		return $this->allowedExtensions;
	}

	/**
	 * set  allowed extensions for uploading
	 *
     * @return	null
	 */
	function setAllowedExtensions($extensions='')
	{
		$this->allowedExtensions = $extensions;
	}

	/**
	 * set file path
	 *
     * @return	null
	 */
	function setFilePath($path='')
	{
		$this->filePath = $path;
	}

	/**
	 * enable upload
	 *
     * @return	null
	 */
	function enableUpload($extensions = "")
	{
		$this->uploadEnabled = true;
		$this->setAllowedExtensions($extensions);
	}

	/**
	 * enable upload
	 *
     * @return	null
	 */
	function getUploadStatus()
	{
		return $this->uploadEnabled;
	}

	/**
	 * get file path
	 *
     * @return	null
	 */
	function getFilePath()
	{
		$check_func = ($this->getUploadStatus())? "is_writable":"is_readable";
		return $check_func($this->filePath)? $this->filePath: false;
	}

	/**
	 * prepare HTML for output
	 *
     * @return	sting HTML
	 */
	function render()
	{
		global $myts;
		$ret = '';
		if ( is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/fckeditor.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/fckeditor/fckeditor.php");
			$oFCKeditor=new FCKeditor($this->getName());
			$oFCKeditor->SetVar('BasePath', "/class/fckeditor/");
			$oFCKeditor->SetVar('Width', $this->getWidth());
			$oFCKeditor->SetVar('Height', $this->getHeight());
			$value = $this->getValue();
            $value = str_replace( "<br />", "<br />", $myts->undoHtmlSpecialChars($value) );
			$oFCKeditor->SetVar('Value', $value);
			$oFCKeditor->SetLanguage($this->getLanguage());
			//$oFCKeditor->SetVar('ToolbarSet', "Complex");
			ob_start();
			$oFCKeditor->Create();
		    $ret = ob_get_contents();
		    ob_end_clean();
		}
		return $ret;
	}

	/**
	 * Check if compatible
	 *
     * @return
	 */
	function isCompatible()
	{
		if ( !is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/fckeditor.php")) return false;
		include_once(XOOPS_ROOT_PATH . "/class/fckeditor/fckeditor.php");
		return FCKeditor::IsCompatible();
	}
}
?>
