<?php
load_theme_textdomain('standardtheme', get_template_directory() . '/lang');
$locale = get_locale();
$locale_file = get_template_directory() . '/languages/$locale.php';
if(is_readable($locale_file)):
	require_once($locale_file);
endif;
add_theme_support('post-thumbnails');
require_once(get_template_directory() . '/admin/functions.php');
require_once(get_template_directory() . '/lib/standardtheme.php');
?>