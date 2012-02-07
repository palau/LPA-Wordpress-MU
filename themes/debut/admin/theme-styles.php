<?php
/**
 * Custom Theme Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter in admin.php. This file
 * is here to help keep this rather long function out of the way.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      3.0
 */
 
function ti_custom_theme_styles() {
	$of_enable_styles = ti_get_option( 'enable_styles', 0 );
	
	if ( $of_enable_styles == 1  ) : ?>
	
		<!-- custom theme styles -->	
		<style type="text/css">
			/* Remove text shadows */
			#primary-nav,	#action-nav, .dark-on-light, .dark-on-none, #announcement, .pagenavi, #entry-container .page-header, #entry-container .more-link,	#comments, #respond, .wp-caption, .widget, .ti_light_box, .ti_medium_box,	#site-info, .light-on-dark, .light-on-none, #announcement .link, .pagenavi a:hover, #footer, .ti_dark_box,  #top-search input {
			  text-shadow: none;
			}
		 	
		 	<?php
		 	// Get theme options
			$of_text_logo_text_color   = ti_get_option( 'text_logo_text_color' );
			$of_main_link_color        = ti_get_option( 'main_link_color' );
		 	
			$of_body_background        = ti_get_option( 'body_background' );
			$of_global_background_1    = ti_get_option( 'global_background_1' );
			$of_global_background_2    = ti_get_option( 'global_background_2' );
			$of_global_background_3    = ti_get_option( 'global_background_3' );
			$of_global_background_4    = ti_get_option( 'global_background_4' );
			$of_global_background_5    = ti_get_option( 'global_background_5' );

			$of_body_text_color        = ti_get_option( 'body_text_color' );
			$of_global_text_color_1    = ti_get_option( 'global_text_color_1' );
			$of_global_text_color_2    = ti_get_option( 'global_text_color_2' );
			$of_global_text_color_3    = ti_get_option( 'global_text_color_3' );
			$of_global_text_color_4    = ti_get_option( 'global_text_color_4' );
			$of_global_text_color_5    = ti_get_option( 'global_text_color_5' );
			
			?>
			
			/* Site Info */
			#site-info a, #site-info p  {
				<?php if ( isset( $of_text_logo_text_color ) ) { print 'color:' . $of_text_logo_text_color . ' !important;'; } ?>
			}

			
			/* Main Link Color */
			#main a:active, #main a:visited, #entry-container a, #entry-container a:hover,
			#entry-container a:hover,  #entry-container a:active,  #entry-container a:visited, #entry-container a:hover {
				<?php if ( isset( $of_main_link_color ) ) { print 'color:' . $of_main_link_color . ' !important;'; } ?>
			}
			
			
			/* Site Background */
			body {
				<?php
				$of_body_background_style  = ( isset( $of_body_background['color'] ) ) ? 'background-color:' . $of_body_background['color'] . ' !important; ' : 'background-color: transparent;';
				$of_body_background_style .= ( isset( $of_body_background['image'] ) && ! empty( $of_body_background['image'] ) ) ? 'background-image: url(' . esc_url( $of_body_background['image'] ) . ') !important;' : 'background-image: none; ';
				$of_body_background_style .= ( isset( $of_body_background['repeat'] ) ) ? 'background-repeat:' . $of_body_background['repeat'] . ' !important; ' : null;
				$of_body_background_style .= ( isset( $of_body_background['position'] ) ) ? 'background-position:' . $of_body_background['position'] . ' !important; ' : null;
				$of_body_background_style .= ( isset( $of_body_background['attachment'] ) ) ? 'background-attachment:' . $of_body_background['attachment'] . ' !important; ' : null;
				
				print $of_body_background_style;
				?>
			}
			
			#footer, #footer a {
				<?php if ( isset( $of_body_text_color ) ) { print 'color:' . $of_body_text_color . ' !important;'; } ?>
			}
			
			
			/* Global 1 - Background (Lighest) */
			#author-avatar, #comments, #entry-container .page-header, #entry-container .page-header .entry-excerpt span, #entry-container .wp-caption, #footbar .entry-thumbnail, #footbar .ti-video, #entry-container #nav-below, #primary-nav ul ul, #primary-nav li:hover, #tab-items, .archive #entry-container .more-link, .ti-video, .ti-tab-widget .entry-thumbnail, .callout-light, .date #entry-container .more-link, .flickr_badge_image img, .page-template-template-post-page-php #entry-container .more-link, .page-links, .tab-comments .avatar, .widget_categoryposts .post-thumbnail {
				<?php
				$of_global_background_1_style  = ( isset( $of_global_background_1['color'] ) ) ? 'background-color:' . $of_global_background_1['color'] . ' !important; ' : 'background-color: transparent;';
				$of_global_background_1_style .= ( isset( $of_global_background_1['image'] ) && ! empty( $of_global_background_1['image'] ) ) ? 'background-image: url(' . esc_url( $of_global_background_1['image'] ) . ') !important;' : 'background-image: none;';
				$of_global_background_1_style .= ( isset( $of_global_background_1['repeat'] ) ) ? 'background-repeat:' . $of_global_background_1['repeat'] . ' !important; ' : null;
				$of_global_background_1_style .= ( isset( $of_global_background_1['position'] ) ) ? 'background-position:' . $of_global_background_1['position'] . ' !important; ' : null;
				$of_global_background_1_style .= ( isset( $of_global_background_1['attachment'] ) ) ? 'background-attachment:' . $of_global_background_1['attachment'] . ' !important; ' : null;
				
				print $of_global_background_1_style;
				?>
			}
			
			h3#comments-title, h3#reply-title, #comments, #entry-container .page-header, #entry-container .page-header .entry-title, #entry-container .page-header .entry-excerpt, #entry-container .wp-caption, #entry-container #nav-below, #respond label, #primary-nav ul ul a, #primary-nav li:hover a, #tab-items a, .archive #entry-container .more-link, .ti-video, .callout-light, .date #entry-container .more-link, .page-template-template-post-page-php #entry-container .more-link, .page-links  {
				<?php if ( isset( $of_global_text_color_1 ) ) { print 'color:' . $of_global_text_color_1 . ' !important;'; } ?>
			}
			
			<?php if ( isset( $of_global_background_1['color'] )  || isset( $of_global_background_1['image'] ) ) : ?>
				body form input, body .gform_wrapper input, body form textarea, body .gform_wrapper textarea {
					background: #f5f5f5;
				}
			<?php endif; // end global background color/image check ?>
			
			/* Comment Link Color */
			#main #comments a, #main #comments a:visited {
				<?php if ( isset( $of_global_text_color_1 ) ) { print 'color:' . $of_global_text_color_1 . ' !important;'; } ?>
			}
			

			/* Global 2 - Background (Medium) */
			h3#comments-title, #action-nav li:hover, #announcement, #author-description, #cancel-comment-reply-link, #featured .entry-thumbnail, #footbar, #hero .dark-on-light .entry-content, #hero .dark-on-light .entry-media, #primary-nav ul, #respond .form-submit input, .archive #entry-container .more-link:hover, .callout-medium, .date #entry-container .more-link:hover, #entry-container .entry-thumbnail, .gallery img, .page-template-template-post-page-php #entry-container .more-link:hover, .pagenavi a, .has-sidebar #main {
				<?php
				$of_global_background_2_style  = ( isset( $of_global_background_2['color'] ) ) ? 'background-color:' . $of_global_background_2['color'] . ' !important; ' : 'background-color: transparent;';
				$of_global_background_2_style .= ( isset( $of_global_background_2['image'] ) && ! empty( $of_global_background_2['image'] ) ) ? 'background-image: url(' . esc_url( $of_global_background_2['image'] ) . ') !important;' : 'background-image: none; ';
				$of_global_background_2_style .= ( isset( $of_global_background_2['repeat'] ) ) ? 'background-repeat:' . $of_global_background_2['repeat'] . ' !important; ' : null;
				$of_global_background_2_style .= ( isset( $of_global_background_2['position'] ) ) ? 'background-position:' . $of_global_background_2['position'] . ' !important; ' : null;
				$of_global_background_2_style .= ( isset( $of_global_background_2['attachment'] ) ) ? 'background-attachment:' . $of_global_background_2['attachment'] . ' !important; ' : null;
				
				print $of_global_background_2_style;
				
				if ( isset( $of_global_text_color_2 ) ) { print 'color:' . $of_global_text_color_2 . ' !important;'; }
				?>
				
				<?php if ( isset( $of_global_text_color_2 ) ) { print 'color:' . $of_global_text_color_2 . ' !important;'; } ?>
			}
			
			h3#comments-title, #action-nav li:hover, #announcement, #announcement h3, #author-description, #cancel-comment-reply-link, #footbar, #hero .dark-on-light .entry-content, #hero .dark-on-light .entry-media, #main #comments cite a, #primary-nav ul a, #respond .form-submit input, #sidebar .ti-tab-widget .tab a, .ti-tab-widget .entry-meta, .archive #entry-container .more-link:hover, .callout-medium, .commentlist cite, .commentlist .says, .commentlist .reply a:hover, .dark-on-light a, .page-template-template-post-page-php #entry-container .more-link:hover, #nav-below a, #nav-above a, .has-sidebar #main, .widget-title, .widget a    {
				<?php if ( isset( $of_global_text_color_2 ) ) { print 'color:' . $of_global_text_color_2 . ' !important;'; } ?>
			}
			

			/* Global 3 - Background (Darkest) */
			#announcement a, #hero .light-on-dark .entry-content, #hero .light-on-dark .entry-media, .callout-dark, .pagenavi a:hover, .pagenavi .current {
				<?php
				$of_global_background_3_style  = ( isset( $of_global_background_3['color'] ) ) ? 'background-color:' . $of_global_background_3['color'] . ' !important; ' : 'background-color: transparent;';
				$of_global_background_3_style .= ( isset( $of_global_background_3['image'] ) && ! empty( $of_global_background_3['image'] ) ) ? 'background-image: url(' . esc_url( $of_global_background_3['image'] ) . ') !important;' : 'background-image: none; ';
				$of_global_background_3_style .= ( isset( $of_global_background_3['repeat'] ) ) ? 'background-repeat:' . $of_global_background_3['repeat'] . ' !important; ' : null;
				$of_global_background_3_style .= ( isset( $of_global_background_3['position'] ) ) ? 'background-position:' . $of_global_background_3['position'] . ' !important; ' : null;
				$of_global_background_3_style .= ( isset( $of_global_background_3['attachment'] ) ) ? 'background-attachment:' . $of_global_background_3['attachment'] . ' !important; ' : null;
				
				print $of_global_background_3_style;
				?>
			}
			
			/* Global 3 - Background (Darkest) */
			#announcement a, #hero .light-on-dark .entry-content, #hero .light-on-dark .entry-media, .callout-dark, #nav-below a:hover, #nav-below .current, #nav-above a:hover, #nav-above .current, .light-on-dark a {
				<?php if ( isset( $of_global_text_color_3 ) ) { print 'color:' . $of_global_text_color_3 . ' !important;'; } ?>
			}
			

			/* Global 4 - Background (Colored) */
			#action-nav li, #action-nav li:hover a {
				<?php
				$of_global_background_4_style  = ( isset( $of_global_background_4['color'] ) ) ? 'background-color:' . $of_global_background_4['color'] . ' !important; ' : 'background-color: transparent;';
				$of_global_background_4_style .= ( isset( $of_global_background_4['image'] ) && !empty( $of_global_background_4['image'] ) ) ? 'background-image: url(' . esc_url( $of_global_background_4['image'] ) . ') !important;' : 'background-image: none; ';
				$of_global_background_4_style .= ( isset( $of_global_background_4['repeat'] ) ) ? 'background-repeat:' . $of_global_background_4['repeat'] . ' !important; ' : null;
				$of_global_background_4_style .= ( isset( $of_global_background_4['position'] ) ) ? 'background-position:' . $of_global_background_4['position'] . ' !important; ' : null;
				$of_global_background_4_style .= ( isset( $of_global_background_4['attachment'] ) ) ? 'background-attachment:' . $of_global_background_4['attachment'] . ' !important; ' : null;
				
				print $of_global_background_4_style;
				?>
			}
			
			/* Global 4 - Text Color */
			#action-nav li a, #action-nav li a:hover {
				<?php if ( isset( $of_global_text_color_4 ) ) { print 'color:' . $of_global_text_color_4 . ' !important;'; } ?>
			}
			
			
			/* Global 5 - Background (Overlay) */
			#main-container, #primary-nav, #top-nav ul, #top-search {
				<?php
				$of_global_background_5_style  = ( isset( $of_global_background_5['color'] ) ) ? 'background-color:' . $of_global_background_5['color'] . ' !important;' : 'background-color: transparent;';
				$of_global_background_5_style .= ( isset( $of_global_background_5['image'] ) && ! empty( $of_global_background_5['image'] ) ) ? 'background-image: url(' . esc_url( $of_global_background_5['image'] ) . ') !important;' : 'background-image: none;';
				$of_global_background_5_style .= ( isset( $of_global_background_5['repeat'] ) ) ? 'background-repeat:' . $of_global_background_5['repeat'] . ' !important; ' : null;
				$of_global_background_5_style .= ( isset( $of_global_background_5['position'] ) ) ? 'background-position:' . $of_global_background_5['position'] . ' !important; ' : null;
				$of_global_background_5_style .= ( isset( $of_global_background_5['attachment'] ) ) ? 'background-attachment:' . $of_global_background_5['attachment'] . ' !important; ' : null;
				
				print $of_global_background_5_style;
				?>
			}
			
			/* Global 5 - Text Color */
			#top-nav a, #top-nav a:hover, #top-search input {
				<?php if ( isset( $of_global_text_color_5 ) ) { print 'color:' . $of_global_text_color_5 . ' !important;'; } ?>
			}
			#top-nav a:hover, #top-nav .current_page_item a:hover {
				background: none !important;
			}
			#top-nav li:hover {
				opacity: 0.8;
			}
			
			/* Global 4 - Main Border */
			#entry-container, .no-sidebar #main {
				<?php
				// Border
				if ( isset( $of_global_background_5['color'] ) ) 
					print 'border-color:' . $of_global_background_5['color'] . ' !important;';
				else 
					print 'border-color: transparent !important;';
				?>
			}
			
			

		</style>
		
	<?php endif; // end custom theme styles
}
?>