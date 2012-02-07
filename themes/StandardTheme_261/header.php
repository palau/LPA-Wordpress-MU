<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
	<head profile="http://gmpg.org/xfn/11">
		<?php include('seotitles.php'); ?>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="description" content="<?php standard_meta_description(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php standard_feed_url(); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
		<!--[if IE 7]>
			<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie7.css" />
		<![endif]-->   
		<?php if ( is_single() ) wp_enqueue_script( 'comment-reply' );
		standard_theme_libs();
		wp_head(); ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/standard.min.js"></script>
		<?php standard_analytics(true); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="container">
			<?php standard_header(get_post_format() != 'aside' && get_post_format() != 'quote' && (is_single() || is_page())); ?>