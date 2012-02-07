<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php standard_feed_url(); ?>" />
		<!--[if IE]>
			<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie.css" />
		<![endif]-->
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
		<?php if (is_single()) wp_enqueue_script( 'comment-reply' );
		standard_theme_libs();
		wp_head(); ?>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/livetheme.js"></script>
		<?php standard_analytics(true); ?>
		<title><?php echo get_bloginfo('name'); ?>&nbsp;|&nbsp;<?php echo get_bloginfo('description'); ?></title>
	</head>
	<body>
		<div id="container">		
			<div id="header" class="col-full">
				<div id="logo" class="fl">
						<?php if(is_single() || is_page()): ?>
							<h2 class="site-title">
								<a class="fade" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
									<?php if(standard_use_text_header()):
										bloginfo('name');
									else:
										standard_display_logo();
									endif; ?>
								</a>
							</h2>	
						<?php else: ?>
							<h1 class="site-title">
								<a class="fade" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
									<?php if(standard_use_text_header()):
										bloginfo('name');
									else:
										standard_display_logo();
									endif;
									?>
								</a>
							</h1>	
						<?php endif; ?>
				</div>
				<div id="top-widget">
					<?php dynamic_sidebar('header-widget'); ?>
				</div>
			</div>