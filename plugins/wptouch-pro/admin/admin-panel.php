<?php

/* Administration panel bootstrap */
require_once( 'template-tags/themes.php' );
require_once( 'template-tags/tabs.php' );

add_action( 'admin_menu', 'wptouch_admin_menu' );

function wptouch_admin_menu() {
	$settings = wptouch_get_settings();
	
	if ( $settings->put_wptouch_in_appearance_menu ) {
		add_submenu_page( 'themes.php', __( "WPtouch Settings", "wptouch-pro" ), __( "WPtouch Settings", "wptouch-pro" ), 'install_plugins', __FILE__, 'wptouch_admin_panel' );	
	} else {
		// Check to see if another plugin created the BraveNewCode menu
		if ( !defined( 'WPTOUCH_MENU' ) ) {
			define( 'WPTOUCH_MENU', true );
			
			// Add the main plugin menu for WPtouch Pro 
			add_menu_page( 'WPtouch Pro', 'WPtouch Pro', 'manage_options', __FILE__, '', get_wptouch_url() . '/admin/images/wptouch-admin-icon.png' );
		}
		
		add_submenu_page( __FILE__, __( "WPtouch Settings", "wptouch-pro" ), __( "WPtouch Settings", "wptouch-pro" ), 'install_plugins', __FILE__, 'wptouch_admin_panel' );	
	}
}

function wptouch_admin_panel() {	
	// Setup administration tabs
	wptouch_setup_tabs();
	
	// Generate tabs	
	wptouch_generate_tabs();
}

//! Can be used to add a tab to the settings panel
function wptouch_add_tab( $tab_name, $class_name, $settings, $custom_page = false ) {
	global $wptouch_pro;
	
	$wptouch_pro->tabs[ $tab_name ] = array(
		'page' => $custom_page,
		'settings' => $settings,
		'class_name' => $class_name
	);
}

function wptouch_generate_tabs() {
	include( 'html/admin-form.php' );
}

function wptouch_string_to_class( $string ) {
	return strtolower( str_replace( '--', '-', str_replace( '+', '', str_replace( ' ', '-', $string ) ) ) );
}	

function wptouch_show_tab_settings() {
	include( 'html/tabs.php' );
}

function wptouch_admin_get_languages() {
	$languages = array(
		'auto' => __( 'Auto-detect', 'wptouch-pro'),
		'fr_FR' => 'Français',
		'ja_JP' => '日本語',
		'it_IT' => 'Italiano',
		'es_ES' => 'Español',
		'de_DE' => 'Deutsch',
		'nb_NO' => 'Norsk',
		'br_PT' => 'Português',
		'nl_NL' => 'Nederlands',
		'sv_SE' => 'Svenska'		
	);	
	
	return apply_filters( 'wptouch_admin_languages', $languages );
}

function wptouch_save_reset_notice() {
	if ( isset( $_POST[ 'wptouch-submit' ] ) ) {
		echo ( '<div class="saved">' );
		echo __( 'Settings saved!', "wptouch-pro" );
		echo('</div>');
	} elseif ( isset( $_POST[ 'wptouch-submit-reset' ] ) ) {
		echo ( '<div class="reset">' );
		echo __( 'Defaults restored', "wptouch-pro" );
		echo( '</div>' );
	}
}

function wptouch_setup_general_tab() {
	global $wptouch_pro;
	$settings = $wptouch_pro->get_settings();
	
	$active_plugins = get_option( 'active_plugins' );
	$new_plugin_list = array();
	foreach( $active_plugins as $plugin ) {
		$dir = explode( '/', $plugin );
		$new_plugin_list[] = $dir[0];
	}

	$plugin_compat_settings = array();
	
	$plugin_compat_settings[] = array( 'section-start', 'warnings-and-conflicts', __( 'Warnings or Conflicts', 'wptouch-pro' ) );
	$plugin_compat_settings[] = array( 'plugin-compat' );
	$plugin_compat_settings[] = array( 'section-end' );	
	
	$plugin_compat_settings[] = array( 'section-start', 'plugin-compat-options', __( 'Compatibility Options', 'wptouch-pro' ) );
	$plugin_compat_settings[] = array( 'checkbox', 'include_functions_from_desktop_theme', __( 'Include functions.php from the active desktop theme', 'wptouch-pro' ), __( 'This option will include and load the functions.php from the active WordPress theme.  This may be required for themes with custom field features like post images, etc.', 'wptouch-pro' ) );
	$plugin_compat_settings[] = array( 'checkbox', 'convert_menu_links_to_internal', __( 'Convert permalinks into internal URLs', 'wptouch-pro' ), __( 'This option reduces the loading time for pages, but may cause issues with the menu when permalinks are non-standard or on another domain.', 'wptouch-pro' ) );
	$plugin_compat_settings[] = array( 'section-end' );
	
	$plugin_compat_settings[] = array( 'section-start', 'plugin-compatibility', __( 'Plugin Compatibility', 'wptouch-pro' ) );	
	if ( $wptouch_pro->plugin_hooks && count( $wptouch_pro->plugin_hooks ) ) {
		
		$plugin_compat_settings[] = array( 'copytext', 'plugin-compat-copy', __( "WPtouch will attempt to disable selected plugin hooks when WPtouch and your mobile theme are active. Check plugins to disable:", "wptouch-pro" ) ); 
				
		foreach( $wptouch_pro->plugin_hooks as $plugin_name => $hooks ) {
			if ( in_array( $plugin_name, $new_plugin_list ) ) {
				$proper_name = "plugin_disable_" . str_replace( '-', '_', $plugin_name );
				$plugin_compat_settings[] = array( 'checkbox', $proper_name, $wptouch_pro->get_friendly_plugin_name( $plugin_name ) );
			}
		}
	} else {
		$plugin_compat_settings[] = array( 'copytext', 'plugin-compat-copy-none', __( "There are currently no active plugins to disable.", "wptouch-pro" ) .  "<br />" . __( "If you have recently installed or reset WPtouch Pro, it must gather active plugin information first.", "wptouch-pro" ) ); 
	}
		
	$plugin_compat_settings[] = array( 'copytext', 'plugin-compat-refresh', sprintf( __( "%sRegenerate Plugin List%s", "wptouch-pro" ), '<a href="#" class="regenerate-plugin-list round-24">', ' &raquo;</a>' ) ); 
	$plugin_compat_settings[] = array( 'section-end' );	
	
	$wptouch_advertising_types = array(
		'none' => __( 'No advertising', 'wptouch-pro' ),
		'google' => __( 'Google Adsense', 'wptouch-pro' ),
		'admob' => __( 'Admob Ads', 'wptouch-pro' ),
		'custom' => __( 'Custom', 'wptouch-pro' )
	);
	
	$wptouch_advertising_types = apply_filters( 'wptouch_advertising_types', $wptouch_advertising_types );
	
	wptouch_add_tab( __( 'General', 'wptouch-pro' ), 'general',
		array(
			__( 'Overview', "wptouch-pro" ) => array ( 'overview',
				array(
					array( 'section-start', 'touchboard', __( 'WPtouchboard', "wptouch-pro" ) ),
					array( 'wptouch-board'),
					array( 'section-end' )
				)	
			),
			__( 'General Options', 'wptouch-pro' ) => array ( 'general-options', 
				array(
					array( 'section-start', 'site-branding', __( 'Site Branding', 'wptouch-pro' ) ),
					array( 'text', 'site_title', __( 'WPtouch site title', 'wptouch-pro' ), __( 'If the title of your site is long, you can shorten it for display within WPtouch.', 'wptouch-pro' ) ),		
					array( 'checkbox', 'show_wptouch_in_footer', __( 'Display "Powered by WPtouch Pro" in footer', 'wptouch-pro' ) ),						
					array( 'section-end' ),
					array( 'section-start', 'language-text', __( 'Regionalization', 'wptouch-pro' ) ),
					array( 'list', 'force_locale', __( 'WPtouch Pro language', 'wptouch-pro' ), __( 'The WPtouch Pro admin panel / supported themes will be shown in this locale', 'wptouch-pro' ), 
						wptouch_admin_get_languages()
					),
					array( 'checkbox', 'respect_wordpress_date_format', __( 'Respect WordPress date format in themes', 'wptouch-pro' ), __( 'When checked WPtouch will use the WordPress date format in themes that support it (set in WordPress -> Settings - > General).', 'wptouch-pro' ) ),
					array( 'section-end' ),
					array( 'section-start', 'landing-page', __( 'WPtouch landing page', 'wptouch-pro' ) ),
					array( 'checkbox', 'enable_home_page_redirect', __( 'Enable custom homepage redirect (overrides default WordPress settings)', 'wptouch-pro' ), __( 'When checked WPtouch overrides your WordPress homepage settings, and uses another page you select for its homepage.', 'wptouch-pro' ) ),
					array( 'redirect' ),
					array( 'section-end' ),
					array( 'spacer' ),			
					array( 'section-start', 'switch-link', __( 'Switch Link', 'wptouch-pro' ) ),
					array( 'checkbox', 'show_switch_link', __( 'Show switch link', 'wptouch-pro' ), __( 'When unchecked WPtouch will not show a switch link allowing users to switch between the mobile view and your regular theme view', 'wptouch-pro' ) ),
					array( 'list', 'home_page_redirect_address', __( 'Switch link destination', 'wptouch-pro' ), __( 'Choose between the same URL from which a user chooses to switch, or your Homepage as the switch link destination.', 'wptouch-pro' ), 
						array(
							'same' => __( 'Same URL', 'wptouch-pro'),
							'homepage' => __( 'Site Homepage', 'wptouch-pro')
						)
					),
					array( 'textarea', 'desktop_switch_css', __( 'Theme switch styling', 'wptouch-pro' ), __( 'Here you can edit the CSS output to style the switch link appearance in the footer of your regular theme.', 'wptouch-pro' ) ),	
					array( 'section-end' ),
					array( 'spacer' ),			
					array( 'section-start', 'custom_stuff', __( 'Custom CSS File', 'wptouch-pro' ) ),
					array( 'text', 'custom_css_file', __( 'URL to a custom CSS file', 'wptouch-pro' ), __( 'Full URL to a custom CSS file to be loaded last in themes. Will override existing styles, preserving updateability of themes.', 'wptouch-pro' ) ),	
					array( 'section-end' ),
					array( 'spacer' ),			
					array( 'section-start', 'misc', __( 'Miscellaneous', 'wptouch-pro' ) ),
					array( 'checkbox', 'desktop_is_first_view', __( '1st time visitors see desktop theme', 'wptouch-pro' ), __( 'Your regular theme will be shown to 1st time mobile visitors first, with the Mobile View switch link available in the footer.', 'wptouch-pro' ) ),		
					array( 'checkbox', 'make_links_clickable', __( 'Convert all plain-text links in post content to clickable links', 'wptouch-pro' ), __( 'Normally links posted into post content are plain-text and cannot be clicked.  Enabling this option will make these links clickable, similar to the P2 theme.', 'wptouch-pro' ) ),	
					array( 'textarea', 'welcome_alert', __( 'Welcome message shown on 1st visit (HTML is OK)', 'wptouch-pro' ), __( 'The welcome message shows below the header for visitors until dismissed.', 'wptouch-pro' ) ),
					array( 'textarea', 'fourohfour_message', __( 'Custom 404 message (HTML is OK)', 'wptouch-pro' ), __( 'Change this to whatever you\'d like for your 404 page message.', 'wptouch-pro' ) ),	
					array( 'textarea', 'footer_message', __( 'Custom footer content (HTML is OK)', 'wptouch-pro' ), __( 'Enter additional content to be displayed in the WPtouch footer. Everything here is wrapped in a paragraph tag.', 'wptouch-pro' ) ),	
					array( 'section-end' )
				)
			),		
			__( 'Advertising', 'wptouch-pro' ) => array ( 'advertising-options', 
				array(
					array( 'section-start', 'advertising', __( 'Advertising Options', 'wptouch-pro' ) ),
					array( 'list', 'advertising_type', __( 'Advertising support', 'wptouch-pro' ), __( 'WPtouch natively supports ads from Google Adsense or Admob. May not show on all devices (limitations of these services).', 'wptouch-pro' ), 
						$wptouch_advertising_types
					),				
					array( 'list', 'advertising_location', __( 'Advertising display location', 'wptouch-pro' ), __( 'Choose where you would like your ads positioned.', 'wptouch-pro' ), 
						array(
							'header' => __( 'Below the header', 'wptouch-pro' ),
							'footer' => __( 'In the footer','wptouch-pro' )
							
						)	
					),	
					array( 'list', 'advertising_pages', __( 'Show ads in these places', 'wptouch-pro' ), __( 'Choose which page views you\'d like ads displayed on', 'wptouch-pro' ), 
						array(
							'ads_single' => __( 'Single Post Only', 'wptouch-pro' ),
							'main_single_pages' => __( 'Home, Blog, Single Post, Pages', 'wptouch-pro' ),
							'all_views' => __( 'All Pages (Home, Blog, Single Post, Pages, Search)', 'wptouch-pro' )							
						)	
					),							
					array( 'copytext', 'copytext-ads', sprintf(__( '%sNote: Adsense and Admob ads only show on service supported devices, and do NOT work in Web-App Mode%s', 'wptouch-pro' ), '<small>','</small>' ) ),
					array( 'copytext', 'copytext-ads3', sprintf(__( '%sAlso, ads will not be shown in Developer Mode on desktop browsers unless the user agent is changed in the browser to a supported device.%s', 'wptouch-pro' ), '<small>','</small>' ) ),
					array( 'section-end' ),	
					array( 'section-start', 'custom-advertising', __( 'Custom Ads', 'wptouch-pro' ) ),
					array( 'textarea', 'custom_advertising_code', __( 'Advertising code', 'wptouch-pro' ), __( 'You can enter custom advertising code (images, links, scripts, etc.) here', 'wptouch-pro' ) ),
					array( 'section-end' ),					
					array( 'section-start', 'google', __( 'Google Adsense', 'wptouch-pro' ) ),
					array( 'text', 'adsense_id', __( 'Adsense Publisher ID', 'wptouch-pro' ), __( 'Enter your full Publisher ID', 'wptouch-pro' ) ),
					array( 'text', 'adsense_channel', __( 'Adsense Channel ID', 'wptouch-pro' ), __( 'Your Adsense Channel', 'wptouch-pro' ) ),				
					array( 'section-end' ),
					array( 'section-start', 'admob', __( 'Admob Ads', 'wptouch-pro' ) ),
					array( 'text', 'admob_publisher_id', __( 'Admob Publisher ID', 'wptouch-pro' ), __( 'Enter your full Admob Publisher ID', 'wptouch-pro' ) ),			
					array( 'section-end' )
				)
			),
			__( 'Statistics', 'wptouch-pro' ) => array( 'site-statistics',
				array(
					array( 'section-start', 'site-stats', __( 'Site Statistics', 'wptouch-pro' ) ),
					array( 'textarea', 'custom_stats_code', __( 'Custom statistics code', 'wptouch-pro' ), __( 'Enter your custom statistics tracking code snippets (Google Analytics, MINT, etc.)', 'wptouch-pro' ) ),		
					array( 'section-end' )
				)
			),
			__( 'Push Notifications', 'wptouch-pro' ) => array ( 'push-notifications',
				array(
					array( 'section-start', 'prowl-notifications', __( 'Prowl Push Notifications', 'wptouch-pro' ) ),
					array( 'text-array', 'push_prowl_api_keys', __( 'Prowl API keys', 'wptouch-pro' ), __( 'Enter your Prowl API key here to enable push notifications from WPtouch to your iPhone/iPod touch via the Prowl app, or Mac with Growl installed and configured for Prowl. If you have multiple keys, enter and save each one for a new input to appear.', 'wptouch-pro' ) ),	
					array( 'checkbox', 'push_prowl_comments_enabled', __( 'Notify of new comments &amp; pingbacks/tracksbacks', 'wptouch-pro' ), __( 'Requires Discussion settings to be enabled in the WordPress settings.', 'wptouch-pro' ) ),
					array( 'checkbox', 'push_prowl_registrations', __( 'Notify of new account registrations', 'wptouch-pro' ), __( 'Requires the "Anyone can register" WordPress setting to be enabled.', 'wptouch-pro' ) ),				
					array( 'checkbox', 'push_prowl_direct_messages', __( 'Allow users to send direct messages', 'wptouch-pro' ), __( 'Adds a push message form in the header to allow visitors to send messages to you.', 'wptouch-pro' ) ),							
					array( 'copytext', 'copytext-info-1', '<small>' . __( '(Requires Prowl app on iPhone / iPod touch, or Growl setup with Prowl on a Mac)', 'wptouch-pro' ) . '</small>' ),
					array( 'copytext', 'copytext-info-2', '<a href="http://itunes.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=320876271" target="_blank">' . __( "Get Prowl (App Store)", "wptouch-pro" ) . '</a> | <a href="http://prowl.weks.net/" target="_blank">' . __( "Prowl Website", "wptouch-pro" ) . '</a> | <a href="http://growl.info/" target="_blank">' . __( "Get Growl", "wptouch-pro" ) . '</a>' ),
					array( 'section-end' )
				)
			),
			__( 'Compatibility', 'wptouch-pro' ) => array( 'compatibility', 
				$plugin_compat_settings
			),
			__( 'Tools and Debug', 'wptouch-pro' ) => array ( 'tools-and-debug',
				array(
					array( 'section-start', 'tools-and-development', __( 'General', 'wptouch-pro' ) ),
					array( 'list', 'developer_mode', __( 'Developer mode', 'wptouch-pro' ), __( 'Shows WPtouch in ALL browsers when enabled. Please remember to disable this option when finished!', 'wptouch-pro' ),
						array(
							'off' => __( 'Disabled', 'wptouch-pro' ),
							'admins' => __( 'Enabled for admins only', 'wptouch-pro' ),							
							'on' => __( 'Enabled for all users', 'wptouch-pro' )
						)
					),	
					array( 'checkbox', 'show_footer_load_times', __( 'Show load times in the footer', 'wptouch-pro' ), __( 'WPtouch will show query count and load time to help you find slow areas of your site.', 'wptouch-pro' ) ),	
					array( 'checkbox', 'put_wptouch_in_appearance_menu', __( 'Move WPtouch admin settings to Appearance menu', 'wptouch-pro' ),  __( 'Moves WPtouch admin settings from the top-level to the WordPress Appearance settings. Refresh your browser after saving.', 'wptouch-pro' ) ),						
					array( 'section-end' ),
					array( 'section-start', 'clientmode', __( 'Client Mode', 'wptouch-pro' ) ),
					array( 'checkbox', 'admin_client_mode_hide_licenses', __( 'Hide BNCID + Licenses tab, and other license content', 'wptouch-pro' ),  __( 'Hides all license settings and references. Allows client to see and upgrade the plugin, adjust active theme and global settings, but not see and/or change license and domain settings.', 'wptouch-pro' ) ),
					array( 'checkbox', 'admin_client_mode_hide_browser', __( 'Hide Theme Browser tab', 'wptouch-pro' ),  __( 'Hides the theme browser tab, and prevents theme switching', 'wptouch-pro' ) ),
					array( 'checkbox', 'admin_client_mode_hide_tools', __( 'Hide Tools and Debug settings', 'wptouch-pro' ),  __( 'Hides the Tools and Debug settings completely. Once checked only resetting WPtouch Pro settings will show them again.', 'wptouch-pro' ) ),
					array( 'section-end' ),
					array( 'section-start', 'debugging', __( 'Debugging', 'wptouch-pro' ) ),
					array( 'sysinfo' ),				
					array( 'checkbox', 'debug_log', __( 'Debug log', 'wptouch-pro' ), __( 'Creates a debug file to help diagnose issues with WPtouch.', 'wptouch-pro' ) ),	
					array( 'list', 'debug_log_level', __( 'Debug log level', 'wptouch-pro' ), __( 'Increasing this above Level 1 (Errors) should only be done when troubleshooting.', 'wptouch-pro' ), 
						array(
							WPTOUCH_ERROR => __( 'Errors (1)', 'wptouch-pro' ),
							WPTOUCH_SECURITY => __( 'Security (2)', 'wptouch-pro' ),
							WPTOUCH_WARNING => __( 'Warnings (3)','wptouch-pro' ),
							WPTOUCH_INFO => __( 'Information (4)','wptouch-pro' ),
							WPTOUCH_VERBOSE => __( 'Verbose (5)','wptouch-pro' ),
						)	
					),				
					array( 'section-end' )
				)
			),
			__( 'Backup/Import', 'wptouch-pro' ) => array( 'backup-restore' ,
				array(
					array( 'section-start', 'site_backup_restore', __( 'Settings Backup and Import', 'wptouch-pro' ) ),
					array( 'list', 'backup_or_restore', __( '&harr; On this site I want to', 'wptouch-pro' ), '', 
						array(
							'backup' => __( 'Backup Settings', 'wptouch-pro' ),
							'restore' => __( 'Import Settings', 'wptouch-pro' )	
						)
					),
					array( 'section-end' ),
					array( 'section-start', 'backup', __( 'Backup', 'wptouch-pro' ) ),
					array( 'copytext', 'backup-instructions', __( 'This key represents a backup of all WPtouch Pro settings.<br />You can cut and paste it into another installation, or save the data to restore at a later time.', 'wptouch-pro' ) ),
					array( 'backup' ),
					array( 'copytext', 'backup-copy-all', sprintf( __( '%sCopy Backup Key To Clipboard%s', 'wptouch-pro' ), '<a id="copy-text-button" class="ajax-button">', '</a>' ) ),
					array( 'copytext', 'backup-instructions-2', sprintf( __( '%sNOTE: A settings backup/restore does NOT include saved files, icons or themes inside the "wp-content/wptouch-data/" directory.%s', 'wptouch-pro' ), '<small>', '</small>' ) ),
					array( 'section-end' ),
					array( 'section-start', 'import', __( 'Import', 'wptouch-pro' ) ),
					array( 'restore', 'restore_string', sprintf( __( 'Paste a backup key, then save: %s(Right click in textarea, choose "Paste")%s', 'wptouch-pro' ), '<small>', '</small>') ),
					array( 'section-end' )
				)
			)

			//,
//			__( 'What\'s New', 'wptouch-pro' ) => array ( 'whats-new',
//				array(
//					array( 'section-start', 'latest-additions', __( 'Additions', 'wptouch-pro' ) ),
//					array( 'copytext', 'copytext-info-additions', __( 'Info from readme "Added:" goes here.', 'wptouch-pro' ) ),
//					array( 'section-end' ),
//					array( 'section-start', 'latest-changes', __( 'Changes', 'wptouch-pro' ) ),
//					array( 'copytext', 'copytext-info-changes', __( 'Info from readme "Changed:" goes here.', 'wptouch-pro' ) ),
//					array( 'section-end' ),
//					array( 'section-start', 'latest-fixes', __( 'Fixes', 'wptouch-pro' ) ),
//					array( 'copytext', 'copytext-info-fixes', __( 'Info from readme "Fixed:" goes here.', 'wptouch-pro' ) ),
//					array( 'section-end' ),
//				)
//			)		

		)
	);
}

function wptouch_setup_theme_browser_tab() {
	$settings = wptouch_get_settings();
	if ( !$settings->admin_client_mode_hide_browser ) {
		wptouch_add_tab( __( 'Theme Browser', 'wptouch-pro' ), 'theme-browser', 
			array(
				__( 'Installed Themes', 'wptouch-pro' ) => array ( 'installed-themes',
					array(
						array( 'section-start', 'installed-themes', '&nbsp;' ),
						array( 'theme-browser' ),
						array( 'section-end' )
					)
				)
			)
		);		
	}
	
	$theme_menu = apply_filters( 'wptouch_theme_menu', array() );
	
	global $wptouch_pro;
	$current_theme = $wptouch_pro->get_current_theme_info();
	
	// Check for skins
	if ( isset( $current_theme->skins ) && count( $current_theme->skins ) ) {
		$skin_options = array( 'none' => __( 'None', 'wptouch-pro' ) );
		foreach( $current_theme->skins as $skin ) {
			$skin_options[ $skin->basename ] = $skin->name;	
		}
		
		$skin_menu =  array(
			__( 'Theme Skins', 'wptouch-pro' ) => array ( 'theme-skins',
				array(
					array( 'section-start', 'available-skins', __( 'Available Skins', 'wptouch-pro' ) ),
					array( 'list', 'current_theme_skin', __( 'Active skin', 'wptouch-pro' ), __( 'Skins are alternate stylesheets which change the look and feel of a theme.', 'wptouch-pro' ), 
						$skin_options
					),				
					array( 'section-end' )
				)
			)
		);
		
		$theme_menu = array_merge( $theme_menu, $skin_menu );
	}
	
	// Add the skins menu
	if ( $theme_menu ) {		
		$settings = $wptouch_pro->get_settings();
		
		wptouch_add_tab( __( "{$settings->current_theme_friendly_name}", 'wptouch-pro' ), 'custom_theme', $theme_menu );
	}
}

function wptouch_setup_menu_icons_tab() {
	wptouch_add_tab( __( 'Menu + Icons', 'wptouch-pro' ), 'menu_and_icons', 
		array(
			__( 'General Settings', 'wptouch-pro' ) => array( 'general-settings',
				array(
					array( 'section-start', 'general-menu-options', __( 'General Menu Options', 'wptouch-pro' ) ),
					array( 'checkbox', 'enable_menu_icons', __( 'Enable menu icons', 'wptouch-pro' ), __( 'When checked icons are beside menu links and page heading titles.', 'wptouch-pro' ) ),
					array( 'checkbox', 'glossy_bookmark_icon', __( 'Glossy bookmark icon', 'wptouch-pro' ), __( 'If unchecked your bookmark icon will be set as "precomposed", and not have the glossy effect applied to it.', 'wptouch-pro' ) ),
					array( 'checkbox', 'menu_show_home', sprintf( __( 'Include a link to %sHome%s in the menu', 'wptouch-pro' ), '<strong>', '</strong>' ), '' ),	
					array( 'checkbox', 'menu_show_rss', sprintf( __( 'Include a link to the %sRSS%s feed in the menu', 'wptouch-pro' ), '<strong>', '</strong>' ), '' ),	
					array( 'text', 'menu_custom_rss_url', __( 'Custom RSS feed URL', 'wptouch-pro' ), __( 'You can enter a custom RSS URL here, such as a FeedBurner feed. When left blank, the default website RSS Feed is used.', 'wptouch-pro' ), '', 'menu_show_email', true ),		
					array( 'checkbox', 'menu_show_email', __( 'Include a link to the admin <strong>Email</strong> in the menu', 'wptouch-pro' ), '' ),
					array( 'text', 'menu_custom_email_address', __( 'Custom email address', 'wptouch-pro' ), __( 'You can enter a custom email address here. When left blank the default admin email is used.', 'wptouch-pro' ), '', 'menu_show_email', true ),					
					array( 'checkbox', 'disable_menu', __( 'Disable site-wide menu', 'wptouch-pro' ), __( 'Check this to disable the WPtouch header menu altogether (useful if you have a custom theme which does not use the WPtouch menu + icon settings).', 'wptouch-pro' ) ),		
					array( 'checkbox', 'menu_disable_parent_as_child', __( 'Disable parent as menu child-item', 'wptouch-pro' ), __( 'Check this to disable showing each menu parent as a clickable child item. NOTE: Parent link will not be accessible with this option enabled.', 'wptouch-pro' ) ),		
					array( 'list', 'menu_sort_order', 
						__( 'Menu sort order', 'wptouch-pro' ), 
						__( 'Used to adjust the menu sort order for WPtouch Pro themes ', 'wptouch-pro' ), 
						array(
							'wordpress' => __( 'Sort by WordPress page order', 'wptouch-pro' ),
							'alpha' => __( 'Sort alphabetically', 'wptouch-pro' )
						) 
					),
					array( 'section-end' )		
				)			
			),		
			__( 'Menu and Icon Setup', 'wptouch-pro' ) => array( 'menu-and-icon-setup',
				array(
					array( 'section-start', 'icon-pool', __( 'Icon Pool', 'wptouch-pro' ) ),
					array( 'icon-picker' ),
					array( 'section-end' )	
				)		
			),
			__( 'Manage Icons and Sets', 'wptouch-pro' ) => array ( 'upload_icons_and_sets',
				array(
					array( 'section-start', 'upload-icons', __( 'Upload Icons + Icon Sets', 'wptouch-pro' ) ),
					array( 'manage-sets' ),
					array( 'section-end' )		
				)		
			),
			__( 'Custom Menu Items', 'wptouch-pro' ) => array( 'custom-menu-icons',
				array(
					array( 'section-start', 'custom-menu-items', __( 'Custom Menu Items', 'wptouch-pro' ) ),
					array( 'copytext', 'copytext-menu-items', __( 'You can enter up to 3 custom menu links to be shown in the WPtouch header menu.', 'wptouch-pro' ) ),
					array( 'text', 'custom_menu_text_1', sprintf( __( 'Custom menu title %s', 'wptouch-pro' ), 1 ) ),				
					array( 'text', 'custom_menu_link_1', sprintf( __( 'Custom menu URL %s', 'wptouch-pro' ), 1 ) ),
					array( 'list', 'custom_menu_position_1', sprintf( __( 'Custom menu position %s', 'wptouch-pro' ), 1 ), __( 'Select whether the link is shown above or below the WP pages in your menu', 'wptouch-pro' ), array( 'top' => __( 'Top', 'wptouch-pro' ), 'bottom' => __( 'Bottom', 'wptouch-pro' ) ) ),
					array( 'checkbox', 'custom_menu_force_external_1', __( 'Force URL to leave web-app mode', 'wptouch-pro' ), __( 'URL will be opened in Mobile Safari.  This feature is sometimes required for external links.', 'wptouch-pro' ) ),						
					array( 'spacer' ),
					array( 'text', 'custom_menu_text_2', sprintf( __( 'Custom menu title %s', 'wptouch-pro' ), 2 ) ),						
					array( 'text', 'custom_menu_link_2', sprintf( __( 'Custom menu URL %s', 'wptouch-pro' ), 2 ) ),
					array( 'list', 'custom_menu_position_2', sprintf( __( 'Custom menu position %s', 'wptouch-pro' ), 2 ), '', array( 'top' => __( 'Top', 'wptouch-pro' ), 'bottom' => __( 'Bottom', 'wptouch-pro' ) ) ),
					array( 'checkbox', 'custom_menu_force_external_2', __( 'Force URL to leave web-app mode', 'wptouch-pro' ) ),						
					array( 'spacer' ),
					array( 'text', 'custom_menu_text_3', sprintf( __( 'Custom menu title %s', 'wptouch-pro' ), 3 ) ),						
					array( 'text', 'custom_menu_link_3', sprintf( __( 'Custom menu URL %s', 'wptouch-pro' ), 3 ) ),
					array( 'list', 'custom_menu_position_3', sprintf( __( 'Custom menu position %s', 'wptouch-pro' ), 3 ), '', array( 'top' => __( 'Top', 'wptouch-pro' ), 'bottom' => __( 'Bottom', 'wptouch-pro' ) ) ),								
					array( 'checkbox', 'custom_menu_force_external_3', __( 'Force URL to leave web-app mode', 'wptouch-pro' ) ),						
					array( 'section-end' )		
				)	
			)					
		)
	);		
}

function wptouch_setup_bncid_account_tab() {
	$support_panel = array(
		__( 'BNCID', 'wptouch-pro' ) => array( 'bncid',
			array(	
				array( 'section-start', 'account-information', __( 'Account Information', 'wptouch-pro' ) ),
				array( 'copytext', 'bncid-info', sprintf( __( 'Your %sBNCID%s and License Key are used to enable site licenses for support and auto-upgrades.', 'wptouch-pro' ), '<a href="http://www.bravenewcode.com/docs/wptouch-pro-docs/what-is-a-bncid/" target="_blank">', '</a>' ) ),
				array( 'ajax-div', 'wptouch-profile-ajax', 'profile' ),		
				array( 'text', 'bncid', __( 'BNCID E-Mail', 'wptouch-pro' ) ),			
				array( 'text', 'wptouch_license_key', __( 'License Key', 'wptouch-pro' ) ),
				array( 'license-check', 'license-check' ),
				array( 'section-end' )
			)
		)
	);
	
	if ( wptouch_has_proper_auth() ) {
		$support_panel[ __( 'Manage Licenses', 'wptouch-pro' ) ] = array( 'manage-licenses', 
			array(
				array( 'section-start' , 'manage-my-licenses', __( 'Manage Licenses', 'wptouch-pro' ) ),
				array( 'manage-licenses', 'manage-these-licenses' ),
				array( 'section-end' )
			)
		);
	}
		
	global $blog_id;
	$settings = wptouch_get_settings();
	
	if ( $blog_id == 1 && !$settings->admin_client_mode_hide_licenses ) {
		wptouch_add_tab( __( 'BNCID + Licenses', 'wptouch-pro' ), 'bncid_and_licenses', 
			$support_panel
		);		
	}				
}

function wptouch_setup_plugins() {
	global $wptouch_pro;	
	$modules = $wptouch_pro->get_modules();
	ksort( $modules );
	
	wptouch_add_tab( __( 'Modules', 'wptouch-pro' ), 'modules', $modules );	
}

function wptouch_setup_tabs() {
	global $wptouch_pro;
	$settings = $wptouch_pro->get_settings();
		
	wptouch_setup_general_tab();	
	
	if ( $wptouch_pro->has_modules() ) {
		wptouch_setup_plugins();
	}	
		
	do_action( 'wptouch_admin_tab' );

	wptouch_setup_theme_browser_tab();

	wptouch_setup_menu_icons_tab();

	wptouch_setup_bncid_account_tab();
	
}

?>