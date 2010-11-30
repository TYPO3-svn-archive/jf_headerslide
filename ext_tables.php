<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_jfheaderslide_images' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:jf_headerslide/locallang_db.xml:pages.tx_jfheaderslide_images',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'file',
			'allowed' => 'gif,png,jpeg,jpg',
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'uploadfolder' => 'uploads/tx_jfheaderslide',
			'show_thumbs' => 1,
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 25,
		)
	),
	'tx_jfheaderslide_stoprecursion' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:jf_headerslide/locallang_db.xml:pages.tx_jfheaderslide_stoprecursion',
		'config' => array (
			'type' => 'check',
		)
	),
	'tx_jfheaderslide_href' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:jf_headerslide/locallang_db.xml:pages.tx_jfheaderslide_href',
		'config' => array (
			'type' => 'text',
			'wrap' => 'OFF',
			'cols' => '48',
			'rows' => '6',
		)
	),
	'tx_jfheaderslide_caption' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:jf_headerslide/locallang_db.xml:pages.tx_jfheaderslide_caption',
		'config' => array (
			'type' => 'text',
			'wrap' => 'OFF',
			'cols' => '48',
			'rows' => '6',
		)
	),
);

t3lib_div::loadTCA('pages');
t3lib_extMgm::addTCAcolumns('pages',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('pages','tx_jfheaderslide_images;;;;1-1-1, tx_jfheaderslide_stoprecursion, tx_jfheaderslide_href, tx_jfheaderslide_caption');

t3lib_div::loadTCA('pages_language_overlay');
t3lib_extMgm::addTCAcolumns('pages_language_overlay',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('pages_language_overlay','tx_jfheaderslide_images;;;;1-1-1, tx_jfheaderslide_stoprecursion, tx_jfheaderslide_href, tx_jfheaderslide_caption');

// Content
$tempColumns = Array (
	"tx_jfheaderslide_activate" => Array (
		"exclude" => 1,
		"label" => "LLL:EXT:jf_headerslide/locallang_db.xml:tt_content.tx_jfheaderslide_activate",
		"config" => Array (
			"type" => "check",
		)
	),
	"tx_jfheaderslide_duration" => Array (
		"exclude" => 1,
		"label" => "LLL:EXT:jf_headerslide/locallang_db.xml:tt_content.tx_jfheaderslide_duration",
		"config" => Array (
			"type" => "input",
			"size" => "5",
			"trim" => "int",
			"default" => "6000"
		)
	),
);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns,1);
$TCA['tt_content']['palettes']['tx_jfheaderslide'] = array(
	'showitem' => 'tx_jfheaderslide_activate,tx_jfheaderslide_duration',
	'canNotCollapse' => 1,
);
t3lib_extMgm::addToAllTCAtypes('tt_content', '--palette--;LLL:EXT:jf_headerslide/locallang_db.xml:tt_content.tx_jfheaderslide_title;tx_jfheaderslide', 'textpic', 'before:imagecaption');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';



// Static
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'JF Header Slide');



t3lib_extMgm::addPlugin(array(
	'LLL:EXT:jf_headerslide/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds.xml');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_jfheaderslide_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_jfheaderslide_pi1_wizicon.php';
}

?>