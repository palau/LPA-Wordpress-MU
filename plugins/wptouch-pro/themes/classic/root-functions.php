<?php

//-- Admin Panel Filters --//

add_filter( 'wptouch_supported_device_classes', 'classic_supported_devices' );
add_filter( 'wptouch_custom_templates', 'classic_custom_templates' );
add_filter( 'wptouch_default_settings', 'classic_default_settings' );
add_filter( 'wptouch_theme_menu', 'classic_admin_menu' );
add_action( 'wptouch_ajax_instapaper', 'classic_instapaper' );
add_filter( 'wptouch_localize_scripts', 'classic_localize_scripts' );
add_filter( 'wptouch_setting_filter_classic_custom_user_agents', 'classic_user_agent_filter' );
add_action( 'wptouch_theme_init', 'classic_theme_initialization' );

function classic_theme_initialization() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_show_attached_image ) {
		add_filter( 'wptouch_the_content', 'classic_show_attached_image_filter' );	
	}
}	

function classic_show_attached_image_filter( $content ) {
	// 
	if ( is_single() && !is_page() ) {
		global $post;
		$photos = get_children( 
			array( 
				'post_parent' => $post->ID, 
				'post_status' => 'inherit', 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'order' => 'ASC', 
				'orderby' => 'menu_order ID'
			)
		);
	
		$attachment_html = false;	
		if ( $photos ) {
			// Grab the first photo, may show more than one eventually			
			foreach( $photos as $photo ) {
				$attachment_html = apply_filters( 'wptouch_image_attachment', '<div class="wptouch-image-attachment">' . wp_get_attachment_image( $photo->ID, 'large' ) . '</div>' );
				break;	
			}	
		}
		
		if ( $attachment_html ) {
			$can_show_attachment = true;
			
			// Make sure the image isn't already in the post content
			if ( preg_match( '#src=\"(.*)\"#iU', $attachment_html, $matches ) ) {
				$image_url = str_replace( get_bloginfo( 'home' ), '', $matches[1] );
				
				if ( strpos( $content, $image_url ) !== false ) {
					$can_show_attachment = false;	
				}	
			}
			
			if ( $can_show_attachment ) {			
				$settings = wptouch_get_settings();
				switch( $settings->classic_show_attached_image_location ) {
					case 'above':
						$content = $attachment_html . $content;
						break;
					case 'below':
						$content = $content . $attachment_html;
						break;	
				}
			}
		}
	}	
	
	return $content;
}

function classic_instapaper() {
	if ( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}
	
	$url = 'http://www.instapaper.com/api/add?url=' . urlencode( wptouch_get_ajax_param( 'url' ) ) . '&title=' . urlencode( wptouch_get_ajax_param( 'title' ) ) . '&username=' . wptouch_get_ajax_param( 'username' ) . '&password=' . wptouch_get_ajax_param( 'password' );
	
	$request = new WP_Http;
	$response = $request->request( $url );
	
	$success = false;
	if ( !is_wp_error( $response ) ) {
		if ( isset( $response['response']['code'] ) && $response['response']['code'] == 201 ) {
			$success = true;
		}
	}
	if ( $success ) { echo '1'; } else { echo '0'; }
}

// Remove whitespace from beginning and end of user agents
function classic_user_agent_filter( $agents ) {
	return trim( $agents );	
}

function classic_localize_scripts( $localize_info ) {
	$localize_info['loading_text'] = __( 'Loading...', 'wptouch-pro' );
	$localize_info['external_link_text'] = __( 'External Link', 'wptouch-pro' );
	$localize_info['open_browser_text'] = __( 'Open in browser?', 'wptouch-pro' );
	$localize_info['instapaper_saved'] = __( 'Saved to Instapaper!', 'wptouch-pro' );
	$localize_info['instapaper_try_again'] = __( 'Please try again', 'wptouch-pro' );
	$localize_info['instapaper_username'] = __( 'Username or E-Mail', 'wptouch-pro' );
	$localize_info['instapaper_password'] = __( 'Password (if you use one)', 'wptouch-pro' );
	$localize_info['classic_post_desc'] = __( 'Enter Description for Post', 'wptouch-pro' );
	
	return $localize_info;	
}

//-- Global Functions For Classic --//

function classic_supported_devices( $devices ) {
	if ( isset( $devices['iphone'] ) ) {
		$settings = wptouch_get_settings();

		if ( strlen( $settings->classic_custom_user_agents  ) ) {
		
			// get user agents
			$agents = explode( "\n", str_replace( "\r\n", "\n", $settings->classic_custom_user_agents ) );
			if ( count( $agents ) ) {	
				// add our custom user agents
				$devices['iphone'] = array_merge( $devices['iphone'], $agents );
			}
		}
	}
	
	return $devices;	
}

function classic_custom_templates( $templates ) {
	$settings = wptouch_get_settings();

	if ( $settings->classic_show_archives ) {
		$templates[ __( 'Archives', 'wptouch-pro' ) ] = array( 'wptouch-archives' );
	}

	if ( $settings->classic_show_links ) {
		$templates[ __( 'Links', 'wptouch-pro' ) ] = array( 'wptouch-links' );
	}
	
	if ( $settings->classic_show_flickr_rss && function_exists( 'get_flickrRSS' ) ) {
		$templates[ __( 'Photos', 'wptouch-pro' ) ] = array( 'wptouch-flickr-photos' );
	}

	return $templates;
}

//-- Default Settings --//

// All default settings must be added to the $settings object here
// All settings should be properly namespaced, i.e. theme_name_my_setting instead of just my_setting
function classic_default_settings( $settings ) {

//General Settings
	$settings->classic_ajax_mode_enabled = true;
	$settings->classic_use_compat_css = true;
	$settings->classic_excluded_categories = '';
	
//Style and Appearance
	$settings->classic_header_img_location = '';
	$settings->classic_retina_header_img_location = '';
	$settings->classic_header_shading_style = 'glossy';
	$settings->classic_header_font = 'Helvetica-Bold';
	$settings->classic_header_title_font_size = '19px';
	$settings->classic_header_color_style = 'classic-black';
	$settings->classic_show_header_icon = true;

	$settings->classic_general_font = 'Helvetica';
	$settings->classic_general_font_size = '13px';
	$settings->classic_general_font_color = '333333';

	$settings->classic_post_title_font = 'Helvetica-Bold';
	$settings->classic_post_title_font_size = '15px';
	$settings->classic_post_title_font_color = '333333';

	$settings->classic_post_body_font = 'Helvetica';
	$settings->classic_post_body_font_size = '13px';
	
	$settings->classic_text_justification = 'left-justify';

	$settings->classic_link_color = '006bb3';
	$settings->classic_context_headers_color = '475d79';
	$settings->classic_footer_text_color = '777777';
	$settings->classic_text_shade_color = 'light';

	$settings->classic_background_image = 'thinstripes';
	$settings->classic_custom_background_image = '';

//Post Icon Settings
	$settings->classic_icon_type = 'calendar';
	$settings->classic_calendar_icon_bg = 'cal-blue';
	$settings->classic_custom_cal_icon_color = '';
	$settings->classic_custom_field_thumbnail_name = 'thumbnail';
	$settings->classic_thumbs_on_single = false;
	$settings->classic_thumbs_on_pages = false;

//Menu Settings
	$settings->classic_use_menu_icon = true;
	$settings->make_menu_relative = true;
	$settings->classic_show_categories = true;
	$settings->classic_show_tags = true;
	$settings->classic_show_account = false;
	$settings->classic_show_admin_menu_link = true;
	$settings->classic_show_profile_menu_link = true;
	$settings->classic_show_archives = true;
	$settings->classic_show_links = true;
	$settings->classic_show_flickr_rss = false;
	$settings->classic_show_search = true;

//Post Settings
	$settings->classic_show_post_author = true;
	$settings->classic_show_post_categories = true;
	$settings->classic_show_post_tags = true;
	$settings->classic_show_post_date = true;
	$settings->classic_show_excerpts = 'excerpts-hidden';
	
// Single Post Settings
	$settings->classic_show_post_author_single = true;
	$settings->classic_show_post_date_single = true;
	$settings->classic_show_post_cats_single = true;
	$settings->classic_show_post_cats_single = true;
	$settings->classic_show_post_tags_single = true;
	$settings->classic_show_share_save = true;
	$settings->classic_hide_responses = false;
	$settings->classic_show_attached_image = false;
	$settings->classic_show_attached_image_location = 'above';

//Page Options
	$settings->classic_show_comments_on_pages = false;

//UA Settings
	$settings->classic_custom_user_agents = '';

//WebApp Settings
	$settings->classic_webapp_enabled = true;
	$settings->classic_webapp_use_loading_img = true;
	$settings->classic_webapp_loading_img_location = '';
	$settings->classic_webapp_status_bar_color = 'default';
	$settings->classic_enable_persistent = true;
	$settings->classic_show_webapp_notice = true;
	return $settings;
}

function classic_theme_thumbnail_options() {
	$thumbnail_options = array();

	//Calendar Icons
	$thumbnail_options['calendar'] = __( 'Calendar', 'wptouch-pro' );

	// WordPress 2.9+ thumbs
	if ( function_exists( 'add_theme_support' ) ) {
		$thumbnail_options['thumbnails'] = __( 'WordPress Thumbnails/Featured Images', 'wptouch-pro' );
	}	

	// 'thumbnail' Custom field thumbnails
	$thumbnail_options['custom_thumbs'] = __( 'Custom Field Thumbnails', 'wptouch-pro' );

	// Simple Post Thumbnails Plugin
	if (function_exists('p75GetThumbnail')) { 
		$thumbnail_options['simple_thumbs'] = __( 'Simple Post Thumbnails Plugin', 'wptouch-pro' );
	}
	
	// Show nothing!
	$thumbnail_options['none'] = __( 'None', 'wptouch-pro' );	
	
	return $thumbnail_options;
}

// The administrational page for the classic theme is constructed here:

function classic_admin_menu( $menu ) {
// custom Photos template code (2.0.1)
	if ( function_exists( 'get_flickrRSS' ) ) {
		$flickr_rss_option = array( 'checkbox', 'classic_show_flickr_rss', __( 'Show Photos template in menu', "wptouch-pro" ), __( "Shows the latest 20 photos from your Flickr RSS feed.", "wptouch-pro"  ) );
	} else {
		$flickr_rss_option = array( 'checkbox-disabled', 'classic_show_flickr_rss', __( 'Show Photos template in menu', "wptouch-pro" ), __( "Requires the FlickrRSS plugin to be installed.", "wptouch-pro"  ) );	
	}
	
	$menu = array(
		__( "General", "wptouch-pro" ) => array ( 'general', 
			array(
				array( 'section-start', 'misc-options', __( 'Miscellaneous Options', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_ajax_mode_enabled', __( 'Enable AJAX "Load More" link for posts and comments', "wptouch-pro" ), __( 'Posts and comments will be appended to existing content with an AJAX "Load More..." link. If unchecked regular post/comment pagination will be used.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_use_compat_css', __( 'Use compatibility CSS', "wptouch-pro" ), __( 'Add the compat.css file from the theme folder. Contains various CSS declarations for a variety of plugins.', "wptouch-pro" ) ),
				array( 'text', 'classic_excluded_categories', __( 'Excluded Categories (Comma list of category IDs)', "wptouch-pro" ), __( 'Posts in these categories will not be shown in the blog. (e.g. 3,4,5)', "wptouch-pro" ) ),
				array( 'section-end' ),
				) 
			),	
		__( "Menu, Posts and Pages", "wptouch-pro" ) => array ( 'post-theme', 
			array(		
				array( 'section-start', 'menu-options', __( 'Theme Menu Options', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_use_menu_icon', __( 'Use menu icon for menu button', "wptouch-pro" ), __( 'On by default. If unchecked the word "Menu" will be shown.', "wptouch-pro"  ) ),
				array( 'checkbox', 'make_menu_relative', __( 'Make menu drop-down relatively positioned', "wptouch-pro" ), __( 'Will make the menu push the content below it down the page. Fixes issues with videos/YouTube overlaying the content of the menu, and may improve menu performance on some devices.', "wptouch-pro"  ) ),
				array( 'checkbox', 'classic_show_categories', __( 'Show Categories in tab-bar', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_tags', __( 'Show Tags in tab-bar', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_account', __( 'Show Account in tab-bar', "wptouch-pro" ), __( 'Will always show account login/links in tab bar, even if registration for your website is not allowed.', "wptouch-pro"  ) ),
				array( 'checkbox', 'classic_show_search', __( 'Show Search in tab-bar', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_admin_menu_link', __( 'Show "Admin" link in Account tab links', "wptouch-pro" ), __( 'Shows an "Admin" menu link for logged in users that have edit posts capability.', "wptouch-pro"  ) ),
				array( 'checkbox', 'classic_show_profile_menu_link', __( 'Show "Profile" link in Account tab links', "wptouch-pro" ), __( 'Show a "Profile" link for all logged in users.', "wptouch-pro"  ) ),
				array( 'spacer' ),
				array( 'checkbox', 'classic_show_archives', __( 'Show Archives template in menu', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_links', __( 'Show Links template in menu', "wptouch-pro" ) ),
				$flickr_rss_option,
				array( 'copytext', 'copytext-info', __( 'The push message and account tabs are shown/hidden automatically.', "wptouch-pro" ) ),
				array( 'section-end' )	,

				array( 'section-start', 'post-options', __( 'Main View Post Options', "wptouch-pro" ) ),
				array( 'copytext', 'copytext-info', __( 'Shows/hides author name, post tags and categories from display on the WPtouch blog, archive, and search pages.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_author', __( 'Show author name in posts', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_categories', __( 'Show categories in posts', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_tags', __( 'Show tags in posts', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_date', __( 'Show date in posts', "wptouch-pro" ), __( 'Will show the date in post listings where thumbnails or none are selected in the post icon settings. Does not affect calendar icons.', "wptouch-pro" ) ),
				array( 'list', 'classic_show_excerpts', __( 'Excerpt/Content Options', "wptouch-pro" ), __( 'Choose how excerpts are handled in the blog. Search and archive templates always use excerpts.', "wptouch-pro" ), 
					array( 
						'excerpts-hidden' => __( 'Excerpts hidden', 'wptouch-pro' ), 
						'excerpts-shown' => __( 'Excerpts shown', 'wptouch-pro' ), 
						'full-hidden' => __( 'Full posts hidden', 'wptouch-pro' ),	
						'full-shown' => __( 'Full posts shown', 'wptouch-pro' ),	
						'first-full-hidden' => __( 'First w/ full post shown, others excerpted and hidden', 'wptouch-pro' ), 
						'first-full-shown' => __( 'First w/ full post shown, others excerpted and shown', 'wptouch-pro' ) 
					) 
				),	
				array( 'section-end' )	,
				array( 'section-start', 'post-options', __( 'Single Post Options', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_author_single', __( 'Show post author in single post header', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_date_single', __( 'Show post date in single post header', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_cats_single', __( 'Show post categories in single post footer', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_post_tags_single', __( 'Show post tags in single post footer', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_share_save', __( 'Show "Share/Save" button', "wptouch-pro" ), __('The "Share/Save" button allows visitors to bookmark your site, share on popular services and via e-mail, or save to Instapaper. You may want to disable it if you use another sharing plugin.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_hide_responses', __( 'Hide Responses', "wptouch-pro" ), __('Hides comments, trackbacks and pingbacks by default, until a visitor clicks to show them. Speeds up load times if hidden.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_attached_image', __( 'Show attached image in post content', 'wptouch-pro' ), __( 'This option can be used to include an attached image in the post content.  The image is only included if it doesn\'t already exist in the post content.', 'wptouch-pro' ) ),
				array( 'list', 'classic_show_attached_image_location', __( 'Attached image location in content', 'wptouch-pro' ), '', 
					array(
						'above' => __( 'Above content', 'wptouch-pro' ),
						'below' => __( 'Below content', 'wptouch-pro' )
					)
				),				
				array( 'section-end' )	,
				array( 'section-start', 'page-options', __( 'Page Options', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_comments_on_pages', __( 'Show comments on pages', "wptouch-pro" ), __( 'Enabling this setting will cause comments to be shown on pages, if they are enabled in the WordPress settings.', "wptouch-pro" ) ),
				array( 'section-end' )	
			)
		),
		__( 'Style / Appearance', "wptouch-pro" ) => array( 'style-options',
			array(
				array( 'section-start', 'header-style-settings', __( 'Header Styling', "wptouch-pro" ) ),	
				array( 'text', 'classic_header_img_location', __( 'URL to a custom header logo', "wptouch-pro" ), __( 'Should be 270px (width) by 44px (height). Transparent .PNG is recommended. If no image is specified here the default Site Icon and Site Title will be used.', "wptouch-pro" ) ),
				array( 'text', 'classic_retina_header_img_location', __( 'URL to a custom header logo (Retina Sized @ 2x)', "wptouch-pro" ), __( 'Should be 540px (width) by 88px (height). Transparent .PNG is recommended.', "wptouch-pro" ) ),
				array( 'list', 'classic_header_font', __( 'Header title font', "wptouch-pro" ), '', 
					array( 
						'ArialMT' => __( 'Arial', 'wptouch-pro' ),
						'Arial-BoldMT' => __( 'Arial (Bold)', 'wptouch-pro' ),
						'Baskerville' => __( 'Baskerville', 'wptouch-pro' ),
						'Baskerville-Bold' => __( 'Baskerville (Bold)', 'wptouch-pro' ),
						'Cochin' => __( 'Cochin', 'wptouch-pro' ),
						'Cochin-Bold' => __( 'Cochin (Bold)', 'wptouch-pro' ),
						'Courier' => __( 'Courier', 'wptouch-pro' ),
						'Futura-Medium' => __( 'Futura', 'wptouch-pro' ),
						'Georgia' => __( 'Georgia', 'wptouch-pro' ),
						'Georgia-Bold' => __( 'Georgia (Bold)', 'wptouch-pro' ),
						'Helvetica' => __( 'Helvetica', 'wptouch-pro' ), 
						'Helvetica-Bold' => __( 'Helvetica (Bold)', 'wptouch-pro' ), 
						'HelveticaNeue' => __( 'Helvetica Neue', 'wptouch-pro' ),
						'HelveticaNeue-Bold' => __( 'Helvetica Neue (Bold)', 'wptouch-pro' ),
						'Palatino-Roman' => __( 'Palatino', 'wptouch-pro' ),
						'Thonburi' => __( 'Thonburi', 'wptouch-pro' ),
						'Thonburi-Bold' => __( 'Thonburi (Bold)', 'wptouch-pro' ),
						'TimesNewRomanPSMT' => __( 'Times New Roman', 'wptouch-pro' ),
						'TrebuchetMS' => __( 'Trebuchet MS', 'wptouch-pro' ),
						'TrebuchetMS-Bold' => __( 'Trebuchet MS (Bold)', 'wptouch-pro' ),
						'Verdana' => __( 'Verdana', 'wptouch-pro' ),
						'Verdana-Bold' => __( 'Verdana (Bold)', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_header_title_font_size', __( 'Header title font size', "wptouch-pro" ), '', 
					array( 
						'16px' => __( '16px', 'wptouch-pro' ), 
						'17px' => __( '17px', 'wptouch-pro' ), 
						'18px' => __( '18px', 'wptouch-pro' ), 
						'19px' => __( '19px', 'wptouch-pro' ),
						'20px' => __( '20px', 'wptouch-pro' ),
						'21px' => __( '21px', 'wptouch-pro' ),
						'22px' => __( '22px', 'wptouch-pro' ),
						'23px' => __( '23px', 'wptouch-pro' ),
						'24px' => __( '24px', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_header_color_style', __( 'Header Color Group', "wptouch-pro" ), __( 'Choose between a variety of color package header styles.', "wptouch-pro" ), 
					array( 
						'classic-black' => __( 'Classic Black (Default)', 'wptouch-pro' ), 
						'silver-sheen' => __( 'Silver Sheen', 'wptouch-pro' ),
						'blue-ocean' => __( 'Blue Ocean', 'wptouch-pro' ),
						'red-bull' => __( 'Red Bull', 'wptouch-pro' ),
						'green-planet' => __( 'Green Planet', 'wptouch-pro' ),
						'sunkissed-orange' => __( 'Sunkissed Orange', 'wptouch-pro' ),
						'violet-purple' => __( 'Violet Purple', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_header_shading_style', __( 'Header Shading Gradient Style', "wptouch-pro" ), __( 'Changes the default glossy look to other styles.', "wptouch-pro" ), 
					array( 
						'glossy' => __( 'Default (Glossy)', 'wptouch-pro' ), 
						'matte' => __( 'Matte', 'wptouch-pro' ),
						'grainy' => __( 'Grainy', 'wptouch-pro' ),
						'none' => __( 'None', 'wptouch-pro' )
					) 
				),
				array( 'checkbox', 'classic_show_header_icon', __( 'Show header icon', "wptouch-pro" ), __( 'Show/hide the header site icon beside your site title. If you use a custom logo image this setting will not apply.', "wptouch-pro" ) ),
				array( 'section-end' ),
				array( 'section-start', 'body-style-settings', __( 'Body and Post Styling', "wptouch-pro" ) ),	
				array( 'list', 'classic_general_font', __( 'General site font', "wptouch-pro" ), '', 
					array( 
						'ArialMT' => __( 'Arial', 'wptouch-pro' ),
						'Arial-BoldMT' => __( 'Arial (Bold)', 'wptouch-pro' ),
						'Baskerville' => __( 'Baskerville', 'wptouch-pro' ),
						'Baskerville-Bold' => __( 'Baskerville (Bold)', 'wptouch-pro' ),
						'Cochin' => __( 'Cochin', 'wptouch-pro' ),
						'Cochin-Bold' => __( 'Cochin (Bold)', 'wptouch-pro' ),
						'Courier' => __( 'Courier', 'wptouch-pro' ),
						'Futura-Medium' => __( 'Futura', 'wptouch-pro' ),
						'Georgia' => __( 'Georgia', 'wptouch-pro' ),
						'Georgia-Bold' => __( 'Georgia (Bold)', 'wptouch-pro' ),
						'Helvetica' => __( 'Helvetica', 'wptouch-pro' ), 
						'Helvetica-Bold' => __( 'Helvetica (Bold)', 'wptouch-pro' ), 
						'HelveticaNeue' => __( 'Helvetica Neue', 'wptouch-pro' ),
						'HelveticaNeue-Bold' => __( 'Helvetica Neue (Bold)', 'wptouch-pro' ),
						'Palatino-Roman' => __( 'Palatino', 'wptouch-pro' ),
						'Thonburi' => __( 'Thonburi', 'wptouch-pro' ),
						'Thonburi-Bold' => __( 'Thonburi (Bold)', 'wptouch-pro' ),
						'TimesNewRomanPSMT' => __( 'Times New Roman', 'wptouch-pro' ),
						'TrebuchetMS' => __( 'Trebuchet MS', 'wptouch-pro' ),
						'TrebuchetMS-Bold' => __( 'Trebuchet MS (Bold)', 'wptouch-pro' ),
						'Verdana' => __( 'Verdana', 'wptouch-pro' ),
						'Verdana-Bold' => __( 'Verdana (Bold)', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_general_font_size', __( 'General site font size', "wptouch-pro" ), '', 
					array( 
						'11px' => __( '11px', 'wptouch-pro' ), 
						'12px' => __( '12px', 'wptouch-pro' ),
						'13px' => __( '13px', 'wptouch-pro' ),
						'14px' => __( '14px', 'wptouch-pro' ),
						'15px' => __( '15px', 'wptouch-pro' ),
						'16px' => __( '16px', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_post_title_font', __( 'Post title font', "wptouch-pro" ), '', 
					array( 
						'ArialMT' => __( 'Arial', 'wptouch-pro' ),
						'Arial-BoldMT' => __( 'Arial (Bold)', 'wptouch-pro' ),
						'Baskerville' => __( 'Baskerville', 'wptouch-pro' ),
						'Baskerville-Bold' => __( 'Baskerville (Bold)', 'wptouch-pro' ),
						'Cochin' => __( 'Cochin', 'wptouch-pro' ),
						'Cochin-Bold' => __( 'Cochin (Bold)', 'wptouch-pro' ),
						'Courier' => __( 'Courier', 'wptouch-pro' ),
						'Futura-Medium' => __( 'Futura', 'wptouch-pro' ),
						'Georgia' => __( 'Georgia', 'wptouch-pro' ),
						'Georgia-Bold' => __( 'Georgia (Bold)', 'wptouch-pro' ),
						'Helvetica' => __( 'Helvetica', 'wptouch-pro' ), 
						'Helvetica-Bold' => __( 'Helvetica (Bold)', 'wptouch-pro' ), 
						'HelveticaNeue' => __( 'Helvetica Neue', 'wptouch-pro' ),
						'HelveticaNeue-Bold' => __( 'Helvetica Neue (Bold)', 'wptouch-pro' ),
						'Palatino-Roman' => __( 'Palatino', 'wptouch-pro' ),
						'Thonburi' => __( 'Thonburi', 'wptouch-pro' ),
						'Thonburi-Bold' => __( 'Thonburi (Bold)', 'wptouch-pro' ),
						'TimesNewRomanPSMT' => __( 'Times New Roman', 'wptouch-pro' ),
						'TrebuchetMS' => __( 'Trebuchet MS', 'wptouch-pro' ),
						'TrebuchetMS-Bold' => __( 'Trebuchet MS (Bold)', 'wptouch-pro' ),
						'Verdana' => __( 'Verdana', 'wptouch-pro' ),
						'Verdana-Bold' => __( 'Verdana (Bold)', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_post_title_font_size', __( 'Post title font size', "wptouch-pro" ), '', 
					array( 
						'14px' => __( '14px', 'wptouch-pro' ), 
						'15px' => __( '15px', 'wptouch-pro' ), 
						'16px' => __( '16px', 'wptouch-pro' ), 
						'17px' => __( '17px', 'wptouch-pro' ), 
						'18px' => __( '18px', 'wptouch-pro' ), 
						'19px' => __( '19px', 'wptouch-pro' ),
						'20px' => __( '20px', 'wptouch-pro' ),
						'21px' => __( '21px', 'wptouch-pro' ),
						'22px' => __( '22px', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_post_body_font', __( 'Post body font', "wptouch-pro" ), '', 
					array( 
						'ArialMT' => __( 'Arial', 'wptouch-pro' ),
						'Arial-BoldMT' => __( 'Arial (Bold)', 'wptouch-pro' ),
						'Baskerville' => __( 'Baskerville', 'wptouch-pro' ),
						'Baskerville-Bold' => __( 'Baskerville (Bold)', 'wptouch-pro' ),
						'Cochin' => __( 'Cochin', 'wptouch-pro' ),
						'Cochin-Bold' => __( 'Cochin (Bold)', 'wptouch-pro' ),
						'Courier' => __( 'Courier', 'wptouch-pro' ),
						'Futura-Medium' => __( 'Futura', 'wptouch-pro' ),
						'Georgia' => __( 'Georgia', 'wptouch-pro' ),
						'Georgia-Bold' => __( 'Georgia (Bold)', 'wptouch-pro' ),
						'Helvetica' => __( 'Helvetica', 'wptouch-pro' ), 
						'Helvetica-Bold' => __( 'Helvetica (Bold)', 'wptouch-pro' ), 
						'HelveticaNeue' => __( 'Helvetica Neue', 'wptouch-pro' ),
						'HelveticaNeue-Bold' => __( 'Helvetica Neue (Bold)', 'wptouch-pro' ),
						'Palatino-Roman' => __( 'Palatino', 'wptouch-pro' ),
						'Thonburi' => __( 'Thonburi', 'wptouch-pro' ),
						'Thonburi-Bold' => __( 'Thonburi (Bold)', 'wptouch-pro' ),
						'TimesNewRomanPSMT' => __( 'Times New Roman', 'wptouch-pro' ),
						'TrebuchetMS' => __( 'Trebuchet MS', 'wptouch-pro' ),
						'TrebuchetMS-Bold' => __( 'Trebuchet MS (Bold)', 'wptouch-pro' ),
						'Verdana' => __( 'Verdana', 'wptouch-pro' ),
						'Verdana-Bold' => __( 'Verdana (Bold)', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_post_body_font_size', __( 'Post body font size', "wptouch-pro" ), '', 
					array( 
						'11px' => __( '11px', 'wptouch-pro' ), 
						'12px' => __( '12px', 'wptouch-pro' ),
						'13px' => __( '13px', 'wptouch-pro' ),
						'14px' => __( '14px', 'wptouch-pro' ),
						'15px' => __( '15px', 'wptouch-pro' )
					) 
				),
				array( 'list', 'classic_text_justification', __( 'Text justification in post listings, single posts / comments, and pages', "wptouch-pro" ), '',
					array( 
						'left-justify' => __( 'Left', 'wptouch-pro' ),
						'full-justify' => __( 'Full', 'wptouch-pro' ),
						'right-justify' => __( 'Right (RTL)', 'wptouch-pro' )
					) 
				),	
				array( 'text', 'classic_general_font_color', __( 'Sitewide font color', "wptouch-pro" ), __( 'e.g. FFFFFF, (Hex without #)', "wptouch-pro"  ) ),
				array( 'text', 'classic_post_title_font_color', __( 'Sitewide post title color', "wptouch-pro" ) ),
				array( 'text', 'classic_link_color', __( 'Sitewide link color', "wptouch-pro" ) ),
				array( 'text', 'classic_context_headers_color', __( 'Context and label headings color', "wptouch-pro" ), __( 'The context header shows for results pages (e.g. Search Results, Leave A Reply) and other labels and headings.', "wptouch-pro"  ) ),
				array( 'text', 'classic_footer_text_color', __( 'Footer text color', "wptouch-pro" ), __( 'This will govern the color of all text in the footer, except for links.', "wptouch-pro"  ) ),
				array( 'list', 'classic_text_shade_color', __( 'Text shading for headers, footer text', "wptouch-pro" ), __( 'Use "dark" for dark backgrounds, "light" for light backgrounds', "wptouch-pro" ), 
					array( 
						'light' => __( 'Light', 'wptouch-pro' ), 
						'dark' => __( 'Dark', 'wptouch-pro' )
					) 
				),
				array( 'copytext', 'copytext-colorpicker', sprintf( __( '%sOpen colorpicker.com Color Picker%s', "wptouch-pro" ), '<a href="http://www.colorpicker.com/" class="ajax-button" id="color-picker">', '</a>' ) ),
				array( 'section-end' )	,
				array( 'section-start', 'background-options', __( 'Background Options', "wptouch-pro" ) ),
				array( 'list', 'classic_background_image', __( 'Theme background image', "wptouch-pro" ), __( 'Choose a background tile for your theme.', "wptouch-pro" ), 
					array( 
						'thinstripes' => __( 'Thin Stripes', 'wptouch-pro' ), 
						'thickstripes' => __( 'Thick Stripes', 'wptouch-pro' ), 
						'pinstripes-blue' => __( 'Pinstripes Vertical (Blue)', 'wptouch-pro' ), 
						'pinstripes-grey' => __( 'Pinstripes Vertical (Grey)', 'wptouch-pro' ), 
						'pinstripes-horizontal' => __( 'Pinstripes Horizontal', 'wptouch-pro' ), 
						'pinstripes-diagonal' => __( 'Pinstripes Diagonal', 'wptouch-pro' ), 
						'skated-concrete' => __( 'Skated Concrete', 'wptouch-pro' ), 
						'grainy' => __( 'Grainy', 'wptouch-pro' ), 
						'cog-canvas' => __( 'Cog Canvas', 'wptouch-pro' ), 
						'dark-grey-thatch' => __( 'Dark Grey Thatch', 'wptouch-pro' ), 
						'none' => __( 'None', 'wptouch-pro' ) 
					) 
				),	
				array( 'text', 'classic_custom_background_image', __( 'URL path to a custom background image', "wptouch-pro" ), __( 'Tiled images only. Image will be repeated horizontally and vertically.', "wptouch-pro" ) ),
				array( 'section-end' ),
				array( 'section-start', 'post-icon-options', __( 'Post/Page Icon Options', "wptouch-pro" ) ),
				array( 'list', 'classic_icon_type', __( 'Post icon type', "wptouch-pro" ), __( 'You can choose between calendar icons, WordPress thumbnails, custom field thumbnails, or if activated, the Simple Post Thumbnails plugin.', "wptouch-pro" ), classic_theme_thumbnail_options() ),	
				array( 'text', 'classic_custom_field_thumbnail_name', __( 'Custom field name for thumbnails', 'wptouch-pro' ), __( 'Enter the name of the custom field used for your custom post thumbnails.', 'wptouch-pro' ) ),					
	
				array( 'list', 'classic_calendar_icon_bg', __( 'Calendar icons background color', "wptouch-pro" ), __( 'Choose the appearance of your Calendar icons.', "wptouch-pro" ), 
					array( 
						'cal-blue' => __( 'Classic Blue', 'wptouch-pro' ), 
						'cal-colors' => __( 'Various Colors', 'wptouch-pro' ), 
						'cal-ltg' => __( 'Light Grey', 'wptouch-pro' ),	
						'cal-dkg' => __( 'Dark Grey', 'wptouch-pro' ),
						'cal-custom' => __( 'Custom', 'wptouch-pro' )
					) 
				),	
				array( 'text', 'classic_custom_cal_icon_color', __( 'Custom calendar icon color (Hex without #)', 'wptouch-pro' ) ),					
				array( 'checkbox', 'classic_thumbs_on_single', __( 'Show thumbnails on single post pages next to the post title', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_thumbs_on_pages', __( 'Prefer thumbnails on pages over page icons (WordPress thumbs only)', "wptouch-pro" ), __( 'Will show a page thumbnail or featured image instead of the page icon used in the menu. If no thumbnail is specified, the page icon will be used instead.', "wptouch-pro" ) ),
				array( 'text', 'post_thumbnails_new_image_size', __( 'Size (in px) for Classic thumbnails', 'wptouch-pro' ), __( 'Changing this setting will not affect existing post thumbnails.', 'wptouch-pro' ) ),
				array( 'copytext', 'regenerate-copytext-info', sprintf( __( '<small>NOTE: You can regenerate your WordPress thumbnails using the %sRegenerate Thumbnails%s plugin.<br />This will tell wordpress to make new thumbnails for WPtouch this size.</small>', "wptouch-pro" ), '<a target="_blank" href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">', '</a>' ) ),
				array( 'section-end' )	
			)
		),
		__( 'User Agents', "wptouch-pro" ) => array( 'user-agents',
			array(
				array( 'section-start', 'devices', __( 'Default User Agents', "wptouch-pro" ) ),	
				array( 'user-agents'),
				array( 'section-end' ),
				array( 'spacer' ),				
				array( 'section-start', 'user-agents', __( 'Custom User Agents', "wptouch-pro" ) ),
				array( 'textarea', 'classic_custom_user_agents', __( 'Enter additional user agents on separate lines, not device names or other information.', 'wptouch-pro' ) . '<br />' . sprintf( __( 'Visit %sWikipedia%s for a list of device user agents', 'wptouch-pro' ), '<a href="http://en.wikipedia.org/wiki/List_of_user_agents_for_mobile_phones" target="_blank">', '</a>' ) ),	
				array( 'section-end' )
			)				
		),
		__( 'Web-App Mode', "wptouch-pro" ) => array( 'web-app-mode',
			array(
				array( 'section-start', 'settings', __( 'Settings', "wptouch-pro" ) ),	
				array( 'checkbox', 'classic_webapp_enabled', __( 'Enable Web-App Mode', "wptouch-pro" ), __( 'When checked WPtouch will allow iPhone, iPod touch and iPad visitors to bookmark your site to their home screens, saving your site as a web application.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_webapp_use_loading_img', __( 'Use startup splash screen image', "wptouch-pro" ), __( 'When checked WPtouch will show a theme startup image while in web-app mode.', "wptouch-pro" ) ),
				array( 'text', 'classic_webapp_loading_img_location', __( 'URL for a custom loading image', "wptouch-pro" ), __( 'Must be a 320px by 460px .PNG. If no path is specified the default loading image will be used.', "wptouch-pro" ) ),
				array( 'list', 'classic_webapp_status_bar_color', __( 'Status Bar Color', "wptouch-pro" ), __( 'Choose between grey (default), black or black-translucent.', "wptouch-pro" ), 
					array( 
						'default' => __( 'Default (Grey)', 'wptouch-pro' ), 
						'black' => __( 'Black', 'wptouch-pro' ), 
						'black-translucent' => __( 'Black Translucent', 'wptouch-pro' )
					) 
				),
				array( 'checkbox', 'classic_enable_persistent', __( 'Enable persistence', "wptouch-pro" ), __( 'When checked WPtouch will remember and load the last visited page or post for a visitor when entering Web-App Mode.', "wptouch-pro" ) ),
				array( 'checkbox', 'classic_show_webapp_notice', __( 'Show a notice bubble for iPhone and iPod touch visitors about web-app mode', "wptouch-pro" ), __( 'When checked WPtouch will show a notice bubble (similar to YouTube.com) anchored at the bottom middle of the screen letting visitors know about your web-app enabled website.', "wptouch-pro" ) ),
				array( 'section-end' )
			)
		)		
	);	
	
	return $menu;
}

?>