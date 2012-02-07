<?php if ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] == '' ) { ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wptouch_title(); ?></title>
		<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
		<?php wptouch_head(); ?>
	</head>
	
	<body class="<?php wptouch_body_classes(); ?>">
	<!-- New noscript check, we need js on always folks to do cool stuff -->
	<noscript>
		<div id="noscript">
			<h2><?php _e( "Notice", "wptouch-pro" ); ?></h2>
			<p><?php _e( "JavaScript is currently off.", "wptouch-pro" ); ?></p>
			<p><?php _e( "Turn it on in browser settings to view this rich mobile website.", "wptouch" ); ?></p>
		</div>
	</noscript>
		<?php if ( wptouch_has_welcome_message() ) { ?>
			<div id="welcome-message">
				<?php wptouch_the_welcome_message(); ?>
				<a href="<?php wptouch_the_welcome_message_dismiss_url(); ?>" id="close-msg"><?php _e( "Close Message", "wptouch-pro" ); ?></a>	
			</div>
		<?php } ?>
		<?php if ( wptouch_prowl_tried_to_send_message() ) { ?>
			<div id="prowl-message" class="rounded-corners-8px">
				<?php if ( wptouch_prowl_message_succeeded() ) { ?>
					<span class="success"><?php _e( "Push message sent successfully.", "wptouch-pro" ); ?></span>
				<?php } else { ?>
					<span class="failed"><?php _e( "Your push message failed. Please try again.", "wptouch-pro" ); ?></span>
				<?php } ?>
			</div>
		<?php } ?>
<?php } ?>		
		<div id="outer-ajax">
			<div id="inner-ajax">
				<div id="header">
					<?php if ( classic_has_logo() ) { ?>
						<a id="custom-logo-title" href="<?php wptouch_bloginfo( 'siteurl' ); ?>">&nbsp;</a>
							<?php classic_logo_img(); ?>
					<?php } else { ?>
						<?php if ( classic_show_site_icon() ) { ?>
							<img id="logo-icon" src="<?php wptouch_the_site_menu_icon( WPTOUCH_ICON_HOME ) ; ?>" alt="" />
						<?php } ?>
						<a id="logo-title" href="<?php wptouch_bloginfo( 'siteurl' ); ?>">
							<?php wptouch_bloginfo( 'site_title' ); ?>
						</a>
					<?php } ?>
					<!-- If you disable the menu this menu button won't show, so you'll have to roll your own! -->
					<?php if ( wptouch_has_menu() ) { ?>
						<?php if ( classic_has_menu_icon() ) { ?>
							<a id="header-menu-toggle" class="no-ajax" href="#">
								<img src="<?php wptouch_bloginfo( 'template_directory' ); ?>/images/menu_toggle_icon.png" alt="menu image" />
							</a>
						<?php } else { ?>
							<a id="header-menu-toggle" class="no-ajax" href="#">
								<?php _e( "Menu", "wptouch-pro" ); ?>
							</a>
						<?php } ?>
					<?php } ?>
				</div>
				
				<!-- This brings in menu.php // remove it and the whole menu won't show at all -->
				<?php if ( wptouch_has_menu() ) { ?>
					<div id="main-menu">
						<!-- The Hidden Search Bar -->
						<div id="search-bar">
							<div id="wptouch-search-inner">
								<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
									<input type="text" name="s" id="search-input" tabindex="1" />
									<input name="submit" type="hidden" id="search-submit-hidden" tabindex="2" />
								</form>
							</div>		
						</div>
						<!-- The WPtouch Tab-Bar // includes Page Menu -->
						<?php include_once('tab-bar.php'); ?>	
					</div>
				<?php } ?>
				
				<?php do_action( 'wptouch_advertising_top' ); ?>
	
				<?php do_action( 'wptouch_body_top' ); ?>
			
				<div id="content">