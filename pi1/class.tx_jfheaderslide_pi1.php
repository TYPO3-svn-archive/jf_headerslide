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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Slideshow' for the 'jf_headerslide' extension.
 *
 * @author	Juergen Furrer <juergen.furrer@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_jfheaderslide
 */
class tx_jfheaderslide_pi1 extends tslib_pibase
{
	var $prefixId      = 'tx_jfheaderslide_pi1';
	var $scriptRelPath = 'pi1/class.tx_jfheaderslide_pi1.php';
	var $extKey        = 'jf_headerslide';
	var $pi_checkCHash = TRUE;

	var $imageDir = 'uploads/tx_jfheaderslide/';
	var $slide_uid = '';
	var $slideshowJsFile = array();
	var $slideshowCSSFile = array();
	var $colors = array();

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)
	{
		// Define the config
		$this->conf = $conf;
		// Define the slide_uid
		$this->slide_uid = $this->extKey . '_slideshow';
		// Get the Slide Images
		$images  = '';
		$href    = '';
		$caption = '';
		$pageID = FALSE;
		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {
			// It's a content, al data from flexform
			$this->lConf = array(); // Setup our storage array...

			$this->lConf['images']  = $this->getFlexformData('general', 'images');
			$this->lConf['href']    = $this->getFlexformData('general', 'href');
			$this->lConf['caption'] = $this->getFlexformData('general', 'caption');

			$this->lConf['width']            = $this->getFlexformData('settings', 'width');
			$this->lConf['height']           = $this->getFlexformData('settings', 'height');
			$this->lConf['showcontroller']   = $this->getFlexformData('settings', 'showcontroller');
			$this->lConf['showcaption']      = $this->getFlexformData('settings', 'showcaption');
			$this->lConf['captionsDuration'] = $this->getFlexformData('settings', 'captionsDuration');
			$this->lConf['random']           = $this->getFlexformData('settings', 'random');
			$this->lConf['noJS']             = $this->getFlexformData('settings', 'noJS');
			$this->lConf['animateOneImage']  = $this->getFlexformData('settings', 'animateOneImage');
			$this->lConf['loaderAnimation']  = $this->getFlexformData('settings', 'loaderAnimation');
			$this->lConf['centerImage']      = $this->getFlexformData('settings', 'centerImage');

			$this->lConf['type']               = $this->getFlexformData('movement', 'type');
			$this->lConf['typedirection']      = $this->getFlexformData('movement', 'typedirection', ($this->lConf['type'] == 'wipe'));
			$this->lConf['pan']                = $this->getFlexformData('movement', 'pan', ($this->lConf['type'] == 'kenburns'));
			$this->lConf['zoom']               = $this->getFlexformData('movement', 'zoom', ($this->lConf['type'] == 'kenburns'));
			$this->lConf['transition']         = $this->getFlexformData('movement', 'transition');
			$this->lConf['transitiondir']      = $this->getFlexformData('movement', 'transitiondir');
			$this->lConf['transitionduration'] = $this->getFlexformData('movement', 'transitionduration');
			$this->lConf['displayduration']    = $this->getFlexformData('movement', 'displayduration');
			$this->lConf['color']              = $this->getFlexformData('movement', 'color');

			$this->slide_uid .= '_' . $this->cObj->data['uid'];
			$images  = $this->lConf['images'];
			$href    = $this->lConf['href'];
			$caption = $this->lConf['caption'];
			// Override the config with flexform data
			if ($this->lConf['width']) {
				$this->conf['width'] = $this->lConf['width'];
			}
			if ($this->lConf['height']) {
				$this->conf['height'] = $this->lConf['height'];
			}
			if ($this->lConf['type']) {
				$this->conf['type'] = $this->lConf['type'];
			}
			if ($this->lConf['typedirection']) {
				$this->conf['typeDirection'] = $this->lConf['typedirection'];
			}
			if ($this->lConf['pan']) {
				$this->conf['pan'] = $this->lConf['pan'];
			}
			if ($this->lConf['zoom']) {
				$this->conf['zoom'] = $this->lConf['zoom'];
			}
			if ($this->lConf['transition']) {
				$this->conf['transition'] = $this->lConf['transition'];
			}
			if ($this->lConf['transitiondir']) {
				$this->conf['transitionDir'] = $this->lConf['transitiondir'];
			}
			if ($this->lConf['transitionduration']) {
				$this->conf['transitionDuration'] = $this->lConf['transitionduration'];
			}
			if ($this->lConf['displayduration']) {
				$this->conf['displayDuration'] = $this->lConf['displayduration'];
			}
			if ($this->lConf['color']) {
				$this->conf['color'] = $this->lConf['color'];
			}
			if ($this->lConf['captionsDuration']) {
				$this->conf['captionsDuration'] = $this->lConf['captionsDuration'];
			}
			$this->conf['controller']      = $this->lConf['showcontroller'];
			$this->conf['caption']         = $this->lConf['showcaption'];
			$this->conf['random']          = $this->lConf['random'];
			$this->conf['noJS']            = $this->lConf['noJS'];
			$this->conf['animateOneImage'] = $this->lConf['animateOneImage'];
			$this->conf['loaderAnimation'] = $this->lConf['loaderAnimation'];
			$this->conf['centerImage']     = $this->lConf['centerImage'];
		} else {
			// It's the header
			foreach ($GLOBALS['TSFE']->rootLine as $page) {
				if ($page['tx_jfheaderslide_stoprecursion']) {
					break;
				}
				if (trim($page['tx_jfheaderslide_images']) != '' || $this->conf['disableRecursion']) {
					$images  = $page['tx_jfheaderslide_images'];
					$href    = $page['tx_jfheaderslide_href'];
					$caption = $page['tx_jfheaderslide_caption'];
					$pageID = $page['uid'];
					break;
				}
			}
			if ($pageID && $GLOBALS['TSFE']->sys_language_content) {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('tx_jfheaderslide_images, tx_jfheaderslide_href, tx_jfheaderslide_caption','pages_language_overlay','pid='.intval($pageID).' AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content,'','',1);
				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				if (trim($row['tx_jfheaderslide_images']) != '') {
					$images  = $row['tx_jfheaderslide_images'];
					$href    = $row['tx_jfheaderslide_href'];
					$caption = $row['tx_jfheaderslide_caption'];
				}
			}
		}

		// define the colors
		$color_temp = explode(",", $this->conf['color']);
		if (count($color_temp) > 0) {
			foreach ($color_temp as $key => $val) {
				if (preg_match("/^\#([0-9a-f]{3,6})/i", trim($val))) {
					$this->colors[] = trim($val);
				}
			}
		}

		// when no Images in field
		if (trim($images) == '') {
			return $content;
		}

		$images  = explode(',', $images);
		$href    = explode('|||', str_replace(array("\r\n", "\n", "\r"), "|||", $href));
		$caption = explode('|||', str_replace(array("\r\n", "\n", "\r"), "|||", $caption));

		$size = @getimagesize(PATH_site . $this->imageDir . $images[0]);
		if ($size && !(int)$this->conf['width']) {
			$this->conf['width'] = $size[0];
		}
		if ($size && !(int)$this->conf['height']) {
			$this->conf['height'] = $size[1];
		}

		$size = array(
			$this->conf['width'],
			$this->conf['height'],
			'style="width:'.$this->conf['width'].'px; height:'.$this->conf['height'].'px;"',
			'width="'.$this->conf['width'].'" height="'.$this->conf['height'].'"'
		);

		// More than one Image (get a slideshow)
		$data = array();
		foreach ($images as $key => $image) {
			$data[$key]['image']   = trim($image);
			$data[$key]['href']    = trim($href[$key]);
			$data[$key]['caption'] = trim($caption[$key]);
		}

		// if random is activated, and JS is deactive the array will be shuffeld
		if ($this->conf['random'] && $this->conf['noJS']) {
			srand((float)microtime() * 1000000);
			shuffle($data);
		}

		// define first image as alternative (noscript)
		$image_config['file'] = $this->imageDir . $data[0]['image'];
		$image_config['file.']['width']  = $this->conf['width']."c";
		$image_config['file.']['height'] = $this->conf['height']."c";
		$alt_image = $this->cObj->IMG_RESOURCE($image_config);

		// output the js and define the first image
		if ($this->conf['noJS']) {
			$first_image = $alt_image;
		} else {
			$first_image = "clear.gif";
			$this->addSlideshowJS($data);
		}

		// Define the target
		// TODO: XHTML (Javascript)
		if ($this->conf['linkTarget'] && $this->conf['linkTarget'] != '_self') {
			$target = ' target="'.$this->conf['linkTarget'].'"';
		}

		$content .= '
<div id="'.$this->slide_uid.'" class="slideshow" '.$size[2].'>
<script type="text/javascript">
//<![CDATA[
'.($data[0]['href'] ? 'document.writeln(\'<a href="'.$data[0]['href'].'" title="'.t3lib_div::slashJS($data[0]['caption']).'" '.$target.'>\');' : '').'
document.writeln(\'<img src="'.t3lib_div::slashJS($first_image).'" '.$size[3].' alt="'.t3lib_div::slashJS($data[0]['caption']).'" />\');
'.($data[0]['href'] ? "document.writeln('</a>');" : '').'
//]]>
</script>
<noscript>
<p>
'.($data[0]['href'] ? '<a href="'.$data[0]['href'].'" title="'.$data[0]['caption'].'" '.$target.'>' : '').'
<img src="'.$alt_image.'" '.$size[3].' alt="'.$data[0]['caption'].'" />
'.($data[0]['href'] ? '</a>' : '').'
</p>
</noscript>
</div>';
		return $content;
	}

	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	function addResources()
	{
		// checks if t3mootools is loaded
		if (t3lib_extMgm::isLoaded('t3mootools')) {
			require_once(t3lib_extMgm::extPath('t3mootools').'class.tx_t3mootools.php');
		}
		// if t3mootools is loaded and the custom Library had been created
		if (defined('T3MOOTOOLS')) {
			tx_t3mootools::addMooJS();
		} else {
			// Add Mootools at first position of file list
			$this->addSlideshowJsFile($this->conf['pathToMootools'], TRUE);
		}
		// add all defined JS files
		if (count($this->slideshowJsFile) > 0) {
			foreach ($this->slideshowJsFile as $jsToLoad) {
				// Add script only once
				if (! preg_match("/".preg_quote($this->getPath($jsToLoad), "/")."/", $GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey])) {
					$GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey] .= ($this->getPath($jsToLoad) ? '<script src="'.$this->getPath($jsToLoad).'" type="text/javascript"></script>'.chr(10) :'');
				}
			}
		}
		// add all defined CSS files
		if (count($this->slideshowCSSFile) > 0) {
			foreach ($this->slideshowCSSFile as $cssToLoad) {
				// Add script only once
				if (! preg_match("/".preg_quote($this->getPath($cssToLoad), "/")."/", $GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey])) {
					$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey] .= ($this->getPath($cssToLoad) ? '<link rel="stylesheet" href="'.$this->getPath($cssToLoad).'" type="text/css" />'.chr(10) :'');
				}
			}
		}
	}

	/**
	 * Add the headerdata
	 * 
	 * @param array $data
	 * @param string $dir
	 * @return void
	 */
	function addSlideshowJS($data, $dir='')
	{
		// define the directory of images
		if ($dir == '') {
			$dir = $this->imageDir;
		}

		// Check if $data is array
		if (count($data) == 0) {
			return FALSE;
		}

		// no animation if only one picture is selected
		if (count($data) == 1) {
			$this->conf['controller'] = '0';
			$this->conf['paused'] = '1';
			// turn off the animation if configured
			if (! $this->conf['animateOneImage']) {
				$this->conf['type'] = 'none';
				$this->conf['transitionDuration'] = 1;
			}
		}

		// Transitions
		$transition = "";
		if ($this->conf['transition']) {
			if (! $this->conf['transitionDir']) {
				$this->conf['transitionDir'] = ":in";
			}
			$transition = "transition: '{$this->conf['transition']}{$this->conf['transitionDir']}',";
		}

		// define default JS Class
		$jsClass = 'Slideshow';

		// Define default zoom factor
		$zoom_factor = 1;

		// the default slideshow JS
		$this->addSlideshowJsFile($this->conf['slideshow']);

		// Different types
		$classes = "";
		$style = "
#{$this->slide_uid} .slideshow-images {width: {$this->conf['width']}px; height: {$this->conf['height']}px;}";
		switch (trim($this->conf['type'])) {
			case 'wipe' : {
				$classes = "classes: ['','','','','','','','images_{$this->slide_uid}'],";
				$style = "
.slideshow-images_{$this->slide_uid} {width: {$this->conf['width']}px; height: {$this->conf['height']}px;}";
				switch (trim($this->conf['typeDirection'])) {
					case 'up': {
						$style .= "
.slideshow-images_{$this->slide_uid}-visible {margin-top: 0;}
.slideshow-images_{$this->slide_uid}-prev {margin-top: -{$this->conf['height']}px;}
.slideshow-images_{$this->slide_uid}-next {margin-top: {$this->conf['height']}px;}";
						break;
					}
					case 'down': {
						$style .= "
.slideshow-images_{$this->slide_uid}-visible {margin-top: 0;}
.slideshow-images_{$this->slide_uid}-prev {margin-top: {$this->conf['height']}px;}
.slideshow-images_{$this->slide_uid}-next {margin-top: -{$this->conf['height']}px;}";
						break;
					}
					case 'left': {
						$style .= "
.slideshow-images_{$this->slide_uid}-visible {margin-left: 0;}
.slideshow-images_{$this->slide_uid}-prev {margin-left: -{$this->conf['width']}px;}
.slideshow-images_{$this->slide_uid}-next {margin-left: {$this->conf['width']}px;}";
						break;
					}
					default : {
						$style .= "
.slideshow-images_{$this->slide_uid}-visible {margin-left: 0;}
.slideshow-images_{$this->slide_uid}-prev {margin-left: {$this->conf['width']}px;}
.slideshow-images_{$this->slide_uid}-next {margin-left: -{$this->conf['width']}px;}";
						break;
					}
				}
				break;
			}
			case 'push' : {
				$this->addSlideshowJsFile($this->conf['slideshowPush']);
				$jsClass = 'Slideshow.Push';
				break;
			}
			case 'fold' : {
				$this->addSlideshowJsFile($this->conf['slideshowFold']);
				$jsClass = 'Slideshow.Fold';
				break;
			}
			case 'flash' : {
				$this->addSlideshowJsFile($this->conf['slideshowFlash']);
				$jsClass = 'Slideshow.Flash';
				break;
			}
			case 'kenburns' : {
				$this->addSlideshowJsFile($this->conf['slideshowKenburns']);
				$jsClass = 'Slideshow.KenBurns';
				$zoom_factor = (100 + trim($this->conf['pan']) + trim($this->conf['zoom'])) / 100;
				break;
			}
		}

		// add the CSS file
		$this->addSlideshowCssFile($this->conf['cssFile']);

		// add all Resources to additionalHeaderData
		$this->addResources();

		// Create the data array
		$slide_data = array();
		foreach ($data as $key => $val) {
			$image_config['file'] = $dir . $val['image'];
			$image_config['file.']['width']  = ($this->conf['width']  * $zoom_factor)."c";
			$image_config['file.']['height'] = ($this->conf['height'] * $zoom_factor)."c";
			$image_info = pathinfo($this->cObj->IMG_RESOURCE($image_config));
			$new_dir = $image_info['dirname']."/";

			$slide_data[] = "'{$image_info['basename']}': {caption:'".t3lib_div::slashJS($val['caption'])."', href:'".t3lib_div::slashJS($val['href'])."'}";
		}
		$dir = $new_dir."/"; // Should be "typo3temp/pics/"
		$dir = str_replace("//", "/", $dir);

		// create the js
		$content = "
<script type=\"text/javascript\">
//<![CDATA[
window.addEvent('domready', function() {
	var data = {".implode(", ", $slide_data)."};
	myShow_{$this->slide_uid} = new {$jsClass}('{$this->slide_uid}', data, {
		hu: '{$dir}',
		captions: ".($this->conf['caption'] ? '{duration: '.($this->conf['captionsDuration'] > 0 ? $this->conf['captionsDuration'] : 0).'}' : 'false').",
		controller: ".($this->conf['controller'] ? 'true' : 'false').",
		{$classes}
		loader: ".($this->conf['loaderAnimation'] ? 'true' : 'false').",
		resize: ".($this->conf['resize'] ? 'true' : 'false').",
		center: ".($this->conf['centerImage'] ? 'true' : 'false').",
		type: '".(trim($this->conf['type']) ? $this->conf['type'] : 'fade')."',
		duration: ".(trim($this->conf['transitionDuration']) ? intval($this->conf['transitionDuration']) : 2000).",
		delay: ".(trim($this->conf['displayDuration']) ? intval($this->conf['displayDuration']) : 6000).",
		pan: ".(trim($this->conf['pan']) ? $this->conf['pan'] : 20).",
		zoom: ".(trim($this->conf['zoom']) ? $this->conf['zoom'] : 0).",
		color: ['".((count($this->colors) > 0) ? implode("','", $this->colors) : "#ffffff")."'],
		{$transition}
		random: ".($this->conf['random'] && count($slide_data) > 1 ? 'true' : 'false').",
		paused: ".($this->conf['paused'] ? 'TRUE' : 'false').",
		width: '{$this->conf['width']}',
		height: '{$this->conf['height']}',
		thumbnails: false
	});
});
//]]>
</script>
<style type=\"text/css\">
{$style}
</style>
";
		$GLOBALS['TSFE']->additionalHeaderData['data_'.$this->extKey] .= $content;
	}

	/**
	 * Return the webbased path
	 * 
	 * @param string $path
	 * return string
	 */
	function getPath($path="")
	{
		return $GLOBALS['TSFE']->tmpl->getFileName($path);
	}

	/**
	 * Add additional JS file
	 * 
	 * @param string $script
	 * @param boolean $first
	 * @return void
	 */
	function addSlideshowJsFile($script="", $first=FALSE)
	{
		if ($this->getPath($script) && ! in_array($script, $this->slideshowJsFile)) {
			if ($first === TRUE) {
				$this->slideshowJsFile = array_merge(array($script), $this->slideshowJsFile);
			} else {
				$this->slideshowJsFile[] = $script;
			}
		}
	}

	/**
	 * Add additional CSS file
	 * 
	 * @param string $script
	 * @return void
	 */
	function addSlideshowCssFile($script="")
	{
		if ($this->getPath($script) && ! in_array($script, $this->slideshowCSSFile)) {
			$this->slideshowCSSFile[] = $script;
		}
	}


	/**
	 * Extract the requested information from flexform
	 * @param string $sheet
	 * @param string $name
	 * @param boolean $devlog
	 * @return string
	 */
	function getFlexformData($sheet='', $name='', $devlog=TRUE)
	{
		$this->pi_initPIflexForm();
		$piFlexForm = $this->cObj->data['pi_flexform'];
		if (! isset($piFlexForm['data'])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return NULL;
		}
		if (! isset($piFlexForm['data'][$sheet])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return NULL;
		}
		if (! isset($piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return NULL;
		}
		if (isset($piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($piFlexForm, $name, $sheet);
		} else {
			return $piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf_headerslide/pi1/class.tx_jfheaderslide_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf_headerslide/pi1/class.tx_jfheaderslide_pi1.php']);
}
?>