#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_jfheaderslide_images text,
	tx_jfheaderslide_stoprecursion tinyint(3) DEFAULT '0' NOT NULL,
	tx_jfheaderslide_href text,
	tx_jfheaderslide_caption text
);



#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	tx_jfheaderslide_images text,
	tx_jfheaderslide_stoprecursion tinyint(3) DEFAULT '0' NOT NULL
	tx_jfheaderslide_href text,
	tx_jfheaderslide_caption text
);



#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_jfheaderslide_activate tinyint(3) DEFAULT '0' NOT NULL,
	tx_jfheaderslide_duration int(11) DEFAULT '0' NOT NULL,
);