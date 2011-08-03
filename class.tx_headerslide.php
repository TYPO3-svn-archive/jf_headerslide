<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Juergen Furrer <juergen.furrer@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * @author	Juergen Furrer <juergen.furrer@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_jfheaderslide
 */
class user_tx_headerslide {
	var $cObj;

	function isActive($content, $conf) {
		if ($this->cObj->data['tx_jfheaderslide_activate']) {
			return 1;
		}
	}

	function getSlideshow($content, $conf) {
		if ($this->cObj->data['tx_jfheaderslide_activate']) {
			$images  = explode(',', $this->cObj->data['image']);
			$caption = explode('|||', str_replace(array("\r\n", "\n", "\r"), "|||", $this->cObj->data['imagecaption']));
			$data = array();
			foreach ($images as $key => $image) {
				$data[$key]['image']   = trim($image);
				$data[$key]['href']    = trim($href[$key]);
				$data[$key]['caption'] = trim($caption[$key]);
			}
			require_once(t3lib_extMgm::extPath('jf_headerslide').'pi1/class.tx_jfheaderslide_pi1.php');
			$obj = t3lib_div::makeInstance('tx_jfheaderslide_pi1');
			$obj->slide_uid = $obj->extKey . '_slideshow_' . $this->cObj->data['uid'];
			$obj->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_jfheaderslide_pi1.'];
			// overwrite the width and height of the config
			$obj->conf['width'] = $GLOBALS['TSFE']->register['imagewidth'];
			$obj->conf['height'] = $GLOBALS['TSFE']->register['imageheight'];
			$obj->addSlideshowJS($data, 'uploads/pics/');
		}
		return $content;
	}
}

// XCLASS inclusion code
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf_headerslide/class.tx_headerslide.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf_headerslide/class.tx_headerslide.php']);
}
?>