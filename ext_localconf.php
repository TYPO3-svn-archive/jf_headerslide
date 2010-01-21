<?php
if(!defined('TYPO3_MODE')) {
	die('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_jfheaderslide_pi1.php', '_pi1', 'list_type', 1);
$TYPO3_CONF_VARS['FE']['addRootLineFields'].= ',tx_jfheaderslide_images,tx_jfheaderslide_href,tx_jfheaderslide_caption';
?>