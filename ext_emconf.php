<?php

########################################################################
# Extension Manager/Repository config file for ext "jf_headerslide".
#
# Auto generated 11-05-2011 23:28
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Header Slideshow',
	'description' => 'Insert a slideshow into your template. Manage the images, captions and hrefs recursively in the pagetree and show it in a slideshow.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.6.0',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-5.3.99',
			'typo3' => '4.3.0-4.5.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:26:{s:24:"class.tx_headerslide.php";s:4:"a54a";s:12:"ext_icon.gif";s:4:"3453";s:17:"ext_localconf.php";s:4:"72b6";s:14:"ext_tables.php";s:4:"9506";s:14:"ext_tables.sql";s:4:"4499";s:15:"flexform_ds.xml";s:4:"6ae3";s:13:"locallang.xml";s:4:"23e2";s:16:"locallang_db.xml";s:4:"3873";s:14:"t3mootools.txt";s:4:"dcdd";s:14:"doc/manual.sxw";s:4:"81c0";s:14:"pi1/ce_wiz.gif";s:4:"c511";s:34:"pi1/class.tx_jfheaderslide_pi1.php";s:4:"99f0";s:42:"pi1/class.tx_jfheaderslide_pi1_wizicon.php";s:4:"45d9";s:17:"pi1/locallang.xml";s:4:"1d9c";s:22:"res1/css/slideshow.css";s:4:"b76a";s:32:"res1/img/controller-controls.png";s:4:"4df7";s:23:"res1/img/controller.png";s:4:"349d";s:19:"res1/img/loader.png";s:4:"3f09";s:25:"res1/js/mootools-1.3.1.js";s:4:"c946";s:32:"res1/js/slideshow-1.3.1.flash.js";s:4:"f31e";s:31:"res1/js/slideshow-1.3.1.fold.js";s:4:"164b";s:26:"res1/js/slideshow-1.3.1.js";s:4:"b77f";s:35:"res1/js/slideshow-1.3.1.kenburns.js";s:4:"3e55";s:31:"res1/js/slideshow-1.3.1.push.js";s:4:"fef6";s:20:"static/constants.txt";s:4:"4711";s:16:"static/setup.txt";s:4:"6186";}',
	'suggests' => array(
	),
);

?>