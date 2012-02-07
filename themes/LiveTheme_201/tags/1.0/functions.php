<?php

/**
 * Looking for the Live Theme functions? Find them in /lib/LiveTheme.php!
 */

// Localization Support
load_theme_textdomain('livetheme', get_template_directory() . '/lang');
$locale = get_locale();
$locale_file = get_template_directory() . '/languages/$locale.php';
if(is_readable($locale_file)):
	require_once($locale_file);
endif;

// Live Theme Dependencies
require_once('admin/functions.php');
require_once('lib/livetheme.php');

?>