<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Debut
 * @since 1.0
 */
?><!doctype html>  

<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,<?php bloginfo( 'html_type' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title><?php wp_title() ?></title>
	
 	<link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?ver=' . ti_version_id(); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
	
</head>

<body id="top" <?php body_class(); ?> >

<div id="header-container">
	
	<header id="header" class="hfeed">
		
		<div id="header-above">
		
			<?php
			/**
			 * Search Form
			 *
			 * A search form can be displayed via theme options
			 *
			 */
			 
			// Get theme options.
			$of_top_search_form = ti_get_option( 'top_search_form', 0 );
  		
			if ( $of_top_search_form == 1 ) :	?>
			
				<section id="top-search" role="search">
					
					<?php get_search_form(); ?>
				
				</section><!-- #top-search -->
			
			<?php endif; // end search form check ?>
			
			
			<nav id="top-nav" role="navigation">
				<ul>
					<?php 
					/**
					 * Top Nav
					 *
					 */
					if ( has_nav_menu( 'top-nav' ) ) : // Check if top menu has been set in WP menu options
						wp_nav_menu( array(
							'theme_location' => 'top-nav',
							'container'      => '',
							'items_wrap'     => '%3$s',
							'depth'          => '1',
							'sort_column'    => 'menu_order' 
						)); 
					else :
						wp_list_pages( array (
						  'title_li' => '',
						  'depth'    => '1' 
						));
					endif;
					?>
				</ul>
			</nav><!-- #top-nav -->
  		
			<div id="site-info" role="banner">
  		
				<?php 
				/**
				 * Site Info. Tag changes depending upon page.
				 *
				 */
				$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				
				<<?php echo $heading_tag; ?> class="site-title">
  			
					<?php
					/**
					 * Logo
					 *
					 */
					
					// Get theme options. (multicheck)
					$of_logo_options = ti_get_option( 'logo_options', 0 );
					
					if ( $of_logo_options['logo_text'] == 1 ) : ?>
					
						<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
					
					<?php else : // Not a text based logo ?>
    	  	
						<a class="fade" href="<?php echo esc_url( home_url() ); ?>" title="Home" >
							<?php
							$logo_default = get_template_directory_uri() . '/images/logo.png'; // Set default logo 
							$logo = ti_get_option( 'logo_image', $logo_default ); // Get image based logo set in theme options or set as default
							?>
							<img src="<?php echo $logo ?>" alt="<?php bloginfo( 'name' ); ?>" />
						</a>
					
					<?php endif; // end text logo check ?>
				
				</<?php echo $heading_tag; ?>><!-- #site-title -->
				
				
				<?php
				/**
				 * Site Description
				 *
				 * Check if site description is enabled in theme options.
				 * If not enabled, apply a "hidden" class.
				 *
				 */
				if ( $of_logo_options['site_description'] == 1 )
					$hide_site_description = false;
				else
					$hide_site_description = 'class="hidden"';
				?>
				
				<p <?php echo $hide_site_description; ?>><?php bloginfo( 'description' ); ?></p>
  		
			</div><!-- .site-info -->
			
		</div><!-- .header-above -->
		
		<div id="header-below">
		
			<?php 
			/**
			 * Action Nav
			 *
			 */
			if ( has_nav_menu( 'action-nav' ) ) : // Check if action menu has been set in WP menu options ?>
			
				<nav id="action-nav" role="navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'action-nav',
						'container'      => '',
						'menu_class'     => 'sf-menu', 
						'sort_column'    => 'menu_order'
					));
					?>
				</nav><!-- #action-nav -->
			
			<?php endif; // end action nav check ?>
			
			<nav id="primary-nav" role="navigation">
				
				<ul class="sf-menu">
					<?php 
					/**
					 * Primary Nav
					 *
					 */
					if ( has_nav_menu( 'primary-nav' ) ) : // Check if primary menu has been set in WP menu options
						wp_nav_menu( array(
							'theme_location' => 'primary-nav',
							'container'      => '',
							'items_wrap'     => '%3$s',
							'sort_column'    => 'menu_order' 
						));
					else :
						wp_list_categories( array( 
							'title_li'	=>	'' 
						));
					endif;
					?>
				</ul><!-- .sf-menu -->
			
			</nav><!-- #primary-nav -->
			
		</div><!-- .header-below -->
		
	</header><!-- #header -->
  
</div><!-- #header-container -->

<div id="main-container" role="main">
