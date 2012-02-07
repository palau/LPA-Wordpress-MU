<?php

//!		\defgroup admin Administration Panel
//!		\defgroup advertising Advertising
//!		\defgroup bnc BraveNewCode API
//!		\defgroup compat Compatibility
//!		\defgroup debug Debugging
//!		\defgroup files	Files and Directories
//!		\defgroup wptouchglobal Global
//!		\defgroup helpers Helpers
//!		\defgroup iconssets Icons and Sets
//!		\defgroup menus Menu Items
//!		\defgroup modules Modules and Add-ons
//!		\defgroup prowl Prowl Notifications
//!		\defgroup settings Storing and Retrieving Settings
//! 	\defgroup templatetags Template tags 
//!		\defgroup internal WPtouch methods


class WPtouchPro {
	//! Contains the main settings object
	var $settings;
	
	//! Set to true when the user is surfing on a supported mobile device
	var $is_mobile_device;
	
	//! Set to true when WPtouch is showing a mobile theme
	var $showing_mobile_theme;
	
	//! Contains information about all the tabs in the administrative panel
	var $tabs;
	
	//! Contains information about the active user's mobile device
	var $active_device;
	
	//! Contains information about the active user's mobile device class
	var $active_device_class;
	
	//! A list of CSS files to be included in the css.  Can possibly be cached
	var $css_files;
	
	//! Contains information about the pre-menu in WPtouch
	var $pre_menu;
	
	//! Contains information about the pre-menu in WPtouch
	var $post_menu;
	
	//! Contains the BNC API object
	var $bnc_api;
	
	//! Contains a list of installed modules
	var $modules;
	
	//! Used for updating the plugin via the WordPress update mechanism
	var $transient_set;
	
	//! Contains the version information while doing an update
	var $latest_version_info;
	
	//! Stores a debug log
	var $debug_log;
	
	//! Stores the current language locale
	var $locale;
	
	//! Keeps track of when a Prowl message was attempted
	var $prowl_tried_to_send_message;
	
	//! Keeps track of when a Prowl message succeeds
	var $prowl_message_succeeded;
	
	//! Stores a list of all custom WPtouch page templates
	var $custom_page_templates;
	
	//! Stores a hash map of icons to sets
	var $icon_to_set_map;
	
	//! Stores the post-processed POST variables
	var $post;
	
	//! Stores the post-processed GET variables
	var $get;
	
	//! Stores a list of all internal warnings
	var $warnings;
	
	//! A list of all the known plugin hooks
	var $plugin_hooks;
	
	//! Indicates whether or not we're executing a custom page template
	var $is_custom_page_template;
	
	//! The menu item for the custom page template
	var $custom_page_template_id;
	
	//! Keeps track of weather or not any directories were not created properly
	var $directory_creation_failure;
	
	//! Keeps track whether or not a settings restoration failed
	var $restore_failure;
	
	
	function WPtouchPro() {
		$this->is_mobile_device = false;
		$this->showing_mobile_theme = false;
		$this->settings = false;
		$this->active_device = false;
		$this->active_device_class = false;
		$this->prowl_tried_to_send_message = false;
		$this->prowl_message_succeeded = false;
		$this->directory_creation_failure = false;
		
		$this->tabs = array();
		$this->css_files = array();
		
		$this->pre_menu = array();
		$this->post_menu = array();
		$this->modules = array();
		
		$this->debug_log = array();
		
		$this->transient_set = false;
		$this->latest_version_info = false;
		$this->is_admin = false;
		
		$this->locale = '';
		$this->custom_page_templates = array();
		$this->icon_to_set_map = false;
		
		$this->post = array();
		$this->get = array();
		
		$this->warnings = array();
		$this->plugin_hooks = array();
		
		$this->is_custom_page_template = false;
		$this->custom_page_template_id = WPTOUCH_ICON_DEFAULT;
		
		$this->restore_failure = false;
	}

	
	/*!		\brief Initializes the WPtouch Pro object
	 *
	 *		This method initializes the WPtouch Pro object.  It is meant to be called immediately after object creation.
	 *
	 *		\ingroup internal
	 */	 
	function initialize() {	
	
		$this->check_directories();
					
		$this->load_modules();	
		
		$this->cleanup_post_and_get();

		// Load the current theme functions.php
		
		if ( file_exists( $this->get_current_theme_directory() . '/root-functions.php' ) ) {
			require_once( $this->get_current_theme_directory() . '/root-functions.php' );	
			
			// each theme can add it's own default settings, so we need to reset our internal settings object
			// so that the defaults will get merged in from the current theme
			$this->settings = false;
			// next time get_settings is called, the current theme defaults will be added in
		}
		
		// Load a custom functions.php file
		if ( file_exists( WPTOUCH_BASE_CONTENT_DIR . '/functions.php' ) ) {
			require_once( WPTOUCH_BASE_CONTENT_DIR . '/functions.php' );	
		}
		
		$settings = $this->get_settings();	
				
		// Set up debug log
		if ( $settings->debug_log ) {
			wptouch_debug_enable( true );	
			wptouch_debug_set_log_level( $settings->debug_log_level );
		}
		
		WPTOUCH_DEBUG( WPTOUCH_INFO, 'WPtouch Pro Initializations ' . WPTOUCH_VERSION );			
				
		// These actions and filters are always loaded
		add_action( 'init', array( &$this, 'wptouch_init' ) );			
		add_action( 'admin_init', array( &$this, 'initialize_admin_section' ) );	
		add_action( 'admin_head', array( &$this, 'wptouch_admin_head' ) );
		add_action( 'install_plugins_pre_plugin-information', array( &$this, 'show_plugin_info' ) );
		add_action( 'comment_post', array( &$this, 'prowl_handle_new_comment' ) );
		add_action( 'user_register', array( &$this, 'prowl_handle_new_comment' ) );
		add_filter( 'wptouch_available_icon_sets_post_sort', array( &$this, 'setup_custom_icons' ) );		
		add_filter( 'plugin_action_links', array( &$this, 'wptouch_pro_settings_link' ), 9, 2 );
		add_action( 'wp_ajax_wptouch_client_ajax', array( &$this, 'handle_client_ajax' ) );
		add_action( 'wp_ajax_nopriv_wptouch_client_ajax', array( &$this, 'handle_client_ajax' ) );
		add_action( 'wptouch_settings_saved', array( &$this, 'check_for_restored_settings' ) );
		
		add_shortcode( 'wptouch', array( &$this, 'handle_shortcode' ) );
	
		
		if ( WPTOUCH_PRO_BETA ) {
			add_action( 'after_plugin_row_wptouch-pro-beta/wptouch-pro.php', array( &$this, 'plugin_row' ) );
		} else { 
			add_action( 'after_plugin_row_wptouch-pro/wptouch-pro.php', array( &$this, 'plugin_row' ) );		
		}	
		
		$this->check_user_agent();	
		
		if ( $settings->desktop_is_first_view && $this->is_mobile_device && !$this->showing_mobile_theme ) {
			add_action( 'wp_head', array( &$this, 'handle_desktop_redirect_for_webapp' ) );
		}		
	
		if ( $this->is_mobile_device && $this->showing_mobile_theme ) {			
		
			// Compatibility
			require_once( dirname( __FILE__ ) . '/../compat.php' );			
			
			// Check to see if we should include the functions.php file from the desktop theme
			if ( $settings->include_functions_from_desktop_theme ) {
				$desktop_theme_directory = get_theme_root() . '/'. get_template();	
				$desktop_functions_file = $desktop_theme_directory . '/functions.php';
				
				// Check to see if the theme has a functions.php file
				if ( file_exists( $desktop_functions_file ) ) {
					require_once( $desktop_functions_file );	
				}
			}
						
			// These actions and filters are only loaded when WPtouch and a mobile theme are active	
			add_action( 'wp', array( &$this, 'check_for_redirect' ) );		
			add_filter( 'init', array( &$this, 'init_theme' ) );
			add_filter( 'excerpt_length', array( &$this, 'get_excerpt_length' ) );
			add_filter( 'excerpt_more', array( &$this, 'get_excerpt_more' ) );
			
			add_filter( 'template', array( &$this, 'get_template') );				
			add_filter( 'stylesheet', array( &$this, 'get_stylesheet') );
			add_filter( 'theme_root', array( &$this, 'get_theme_root') );
			add_filter( 'theme_root_uri', array( &$this, 'get_theme_root_uri') );
			
			add_action( 'wptouch_post_head', array( &$this, 'add_mobile_header_info' ) );

			// This is used to add the RSS, email items, etc			
			add_filter( 'wptouch_menu_items', array( &$this, 'add_static_menu_items' ) );
			
			if ( $settings->menu_disable_parent_as_child ) {
				add_filter( 'wptouch_menu_items', array( &$this, 'remove_duplicate_menu_items' ) );
			}
			
			if ( $settings->make_links_clickable ) {
				add_filter( 'the_content', 'make_clickable' );	
			}
		}				
		
		// Setup Post Thumbnails
		if ( $settings->post_thumbnails_enabled && function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'wptouch-new-thumbnail', $settings->post_thumbnails_new_image_size, $settings->post_thumbnails_new_image_size, true );
		}	
		
		$this->custom_page_templates = apply_filters( 'wptouch_custom_templates', $this->custom_page_templates );	
		
		if ( !$settings->has_migrated_icons ) {
			$this->check_old_version();
		
			$settings->has_migrated_icons = true;
			$this->save_settings( $settings );
		}
		
	}	
	
	function check_for_restored_settings() {
		$settings = $this->get_settings();
		
		if ( $settings->restore_string ) {
			if ( function_exists( 'gzuncompress' ) ) {
				$new_settings = @unserialize( gzuncompress( base64_decode( $settings->restore_string ) ) );	
				if ( is_object( $new_settings ) ) {
					$settings = $new_settings;
				} else {
					$this->restore_failure = true;
				}	
			}
			
			$settings->restore_string = '';
			
			$this->save_settings( $settings );				
		}
	}
		
	function handle_desktop_redirect_for_webapp() {
		include( WPTOUCH_DIR . '/include/js/desktop-webapp.js' );
	}
	
	/*!		\brief Handles the wptouch shortcode
	 *
	 *		This method handles the WPtouch Pro shortcode, wptouch.  This shortcode allows content to be targeted for different situations
	 *
	 *		\param src_name the name of the source file
	 *		\param dst_name the name of the destination file
	 *
	 *		\ingroup helpers
	 */	 		
	function handle_shortcode( $attr, $content ) {
		if ( isset( $attr['target'] ) ) {
			switch( $attr['target'] ) {
				case 'non-mobile':
					if ( !$this->is_mobile_device ) {
						return '<div class="wptouch-shortcode-non-mobile">' . $content . '</div>';		
					}
					break;
				case 'desktop':
					if ( $this->is_mobile_device && !$this->showing_mobile_theme ) {
						return '<div class="wptouch-shortcode-desktop">' . $content . '</div>';	
					}
					break;
				case 'non-webapp':
					if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
						return '<div class="wptouch-shortcode-mobile-only" style="display: none;">' . $content . '</div>';	
					}
					break;
				case 'webapp':
					if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
						return '<div class="wptouch-shortcode-webapp-only" style="display: none;">' . $content . '</div>';	
					}					
					break;	
				case 'mobile':
					if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
						return '<div class="wptouch-shortcode-webapp-mobile">' . $content . '</div>';	
					}									
					break;
			}	
		}
		
		return '';
	}
	
	function remove_duplicate_menu_items( $menu_items ) {
		$new_items = array();
		
		foreach( $menu_items as $key => $value ) {
			if ( isset( $value->submenu ) && count( $value->submenu ) ) {
				$value->submenu = $this->remove_duplicate_menu_items( $value->submenu );	
			}
			
			if ( !isset( $value->duplicate_link ) || ( isset( $value->duplicate_link ) && !$value->duplicate_link ) ) {
				$new_items[ $key ] = $value;	
			}	
						
		}
		
		return $new_items;
	}
	
	/*!		\brief Used to copy a file between two locations
	 *
	 *		This method can be used to copy a file between two locations.
	 *
	 *		\param src_name the name of the source file
	 *		\param dst_name the name of the destination file
	 *
	 *		\ingroup helpers
	 */	 	
	function copy_file( $src_name, $dst_name ) {
		$src = fopen( $src_name, 'rb' );
		if ( $src ) {
			$dst = fopen( $dst_name, 'w+b' );
			if ( $dst ) {
				while ( !feof( $src ) ) {
					$contents = fread( $src, 8192 );
					fwrite( $dst, $contents );
				}	
				fclose( $dst );	
			} else {
				WPTOUCH_DEBUG( WPTOUCH_ERROR, 'Unable to open ' . $dst_name . ' for writing' );	
			}
			
			fclose( $src );		
		}
	}
	
	/*!		\brief Checks the old version of WPtouch for custom icons, and copies them to the new version
	 *
	 *		This method checks the old version of WPtouch for custom icons.  If it finds any, they are added to the new version.  
	 *		
	 *		\note Currently only PNG (.png) files are supported
	 *
	 *		\ingroup helpers
	 */	 		
	function check_old_version() {
		$upload_dir = wp_upload_dir();
		if ( $upload_dir && isset( $upload_dir['basedir'] ) ) {
			$base_dir = $upload_dir['basedir'];	
			$old_wptouch_custom_dir = $base_dir . '/wptouch/custom-icons';
			
			$files = $this->get_files_in_directory( $old_wptouch_custom_dir, '.png' );
			if ( $files && count( $files ) ) {
				foreach( $files as $some_file ) {
					$file_name = basename( $some_file );
					$dest_file = WPTOUCH_CUSTOM_ICON_DIRECTORY . '/' . $file_name;
					
					if ( !file_exists( $dest_file ) ) {
						$this->copy_file( $some_file, $dest_file );
					}
				}
			}
		}
	}
	
	/*!		\brief Used to determine the friendly name for a plugin
	 *
	 *		This method can be used to convert a plugin slug into a friendly name for the plugin.
	 *
	 *		\param name the name of the plugin, usually the slug represented by the plugin's directory on disk
	 *
	 *		\returns A string representing the friendly name for a plugin
	 *
	 *		\ingroup internal
	 */	 	
	function get_friendly_plugin_name( $name ) {
		$plugin_file = WP_PLUGIN_DIR . '/' . $name . '/' . $name . '.php';
		if ( file_exists( $plugin_file ) ) {
			$contents = $this->load_file( $plugin_file );
			if ( $contents ) {
				if ( preg_match( "#Plugin Name: (.*)\n#", $contents, $matches ) ) {
					return $matches[1];	
				}	
			}
		}
		
		$all_files = $this->get_files_in_directory( WP_PLUGIN_DIR . '/' . $name, '.php' );
		if ( $all_files ) {
			foreach( $all_files as $some_file ) {
				if ( file_exists( $some_file ) ) {
					$contents = $this->load_file( $some_file );
					if ( $contents ) {
						if ( preg_match( "#Plugin Name: (.*)\n#", $contents, $matches ) ) {
							return $matches[1];	
						}	
					}
				}				
			}	
		}
		
		return str_replace( '_' , ' ', $name );
	}
	
	/*!		\brief Pre-processes the $_POST and $_GET data on a form submission
	 *
	 *		This method does preprocessing of the $_GET and $_POST data on form submissions.  It removes slashes on
	 *		servers that have magic quotes enabled.  
	 *
	 *		\ingroup internal
	 */	 	
	function cleanup_post_and_get() {		
		if ( count( $_GET ) ) {
			foreach( $_GET as $key => $value ) {
				if ( get_magic_quotes_gpc() ) {
					$this->get[ $key ] = @stripslashes( $value );	
				} else {
					$this->get[ $key ] = $value;
				}
			}	
		}	
		
		if ( count( $_POST ) ) {
			foreach( $_POST as $key => $value ) {
				if ( get_magic_quotes_gpc() ) {
					$this->post[ $key ] = @stripslashes( $value );	
				} else {
					$this->post[ $key ] = $value;	
				}
			}	
		}	
	}

	/*!		\brief Adds a static menu item to the main WPtouch menu
	 *
	 *		Adds a static menu item to the WPtouch menu.  An example would be a 
	 *		link to an email account or a Twitter feed.
	 *
	 *		\param menu_items an array representing the menu items to add
	 *
	 *		\ingroup menus
	 */	 
	function add_static_menu_items( $menu_items ) {
		$top_items = array();
		$bottom_items = array();
		
		$settings = $this->get_settings();
		
		// Add the Custom Page Templates here
		if ( count( $this->custom_page_templates ) ) {
			$count = 1;
			foreach( $this->custom_page_templates as $page_name => $page_info ) {
				$bottom_items[ $page_name ] = wptouch_create_menu_item( WPTOUCH_ICON_CUSTOM_PAGE_TEMPLATES - $count, 1, $page_name, 'link', false, 0, false, get_bloginfo( 'url' ) . '?wptouch_page_template=' . $page_info[0] );
				$count++;
			}
		}
		
		// Add Home to the menu if it's enabled
		if ( $settings->menu_show_home ) {
			$top_items[ __( 'Home', 'wptouch-pro' ) ] = wptouch_create_menu_item( WPTOUCH_ICON_HOME, 1, __( 'Home', 'wptouch-pro'), 'link', false, 0, false, get_bloginfo( 'url' ) );	
		}	

		// Add email to the menu if it's enabled
		if ( $settings->menu_show_email ) {
			$email_address = get_option( 'admin_email' );
			if ( $settings->menu_custom_email_address ) {
				$email_address = $settings->menu_custom_email_address;	
			}
			
			$bottom_items[ __( 'Email', 'wptouch-pro' ) ] = wptouch_create_menu_item( WPTOUCH_ICON_EMAIL, 1, __( 'Email', 'wptouch-pro'), 'link', false, 0, false, 'mailto:' . $email_address, 'email' );
		}
		
		// Add RSS icon to the menu if it's enabled
		if ( $settings->menu_show_rss ) {
			$bottom_items[ __( 'RSS', 'wptouch-pro' ) ] = wptouch_create_menu_item( WPTOUCH_ICON_RSS, 1, __( 'RSS', 'wptouch-pro'), 'link', false, 0, false, wptouch_get_bloginfo( 'rss_url') );		
		}
		
		for ( $i = 1; $i <= 3; $i++ ) {
			$text_name = 'custom_menu_text_' . $i;
			$link_name = 'custom_menu_link_' . $i;
			$link_spot = 'custom_menu_position_' . $i;
			$link_class = 'custom_menu_force_external_' . $i;
			if ( $settings->$text_name && $settings->$link_name ) {
				$custom_class = false;
				if ( isset( $settings->$link_class ) && $settings->$link_class ) {
					$custom_class = 'force-external';	
				}
				
				if ( $settings->$link_spot == 'top' ) {
					$top_items[ $settings->$text_name ] = wptouch_create_menu_item( -100 - $i, 1, $settings->$text_name, 'link', false, 0, false, $settings->$link_name, $custom_class );	
				} else {
					$bottom_items[ $settings->$text_name ] = wptouch_create_menu_item( -100 - $i, 1, $settings->$text_name, 'link', false, 0, false, $settings->$link_name, $custom_class );
				}
			}
		}
		
		// Make sure the top menu items override the bottom ones
		foreach ( $top_items as $key => $value ) {
			if ( isset( $menu_items[ $key ] ) ) {
				unset( $menu_items[ $key ] );	
			}
		}		
				
				
		// Make sure the top menu items override the bottom ones
		foreach ( $bottom_items as $key => $value ) {
			if ( isset( $menu_items[ $key ] ) ) {
				unset( $menu_items[ $key ] );	
			}
		}
	
		return array_merge( $top_items, $menu_items, $bottom_items );	
	}
	
	/*!		\brief Used to obtain the icon set object for a given icon
	 *
	 *		This method returns an object representing the icon set containing the icon passed in as a parameter
	 *
	 *		\param icon_path the full path on disk of the icon within the set
	 *
	 *		\returns An object representing the icon set
	 *
	 *		\ingroup internal
	 *		\ingroup iconssets
	 */	 	
	function get_set_with_icon( $icon_path ) {
		if ( !$this->icon_to_set_map ) {
			$this->icon_to_set_map = array();
			$icon_packs = $this->get_available_icon_packs();
			
			if ( $icon_packs ) {
				foreach( $icon_packs as $pack_name => $pack_info ) {
					$icons = $this->get_icons_from_packs( $pack_name );
					if ( $icons ) {
						foreach( $icons as $icon_name => $icon_info ) {
							$hash = md5( $icon_info->location );
							$this->icon_to_set_map[ $hash ] = $pack_info;
						}
					}
				}	
			}
		}	
		
		$hash = md5( $icon_path );
		if ( isset( $this->icon_to_set_map[ $hash ] ) ) {
			return $this->icon_to_set_map[ $hash ];
		} else {
			return false;	
		}
	}

	/*!		\brief Used to update the plugin information on the WordPress plugins page
	 *
	 *		This method updates the plugin information on the WordPress plugins page.  It gives users an opportunity to download a new
 	 *		version of WPtouch Pro.
	 *
	 *		\param plugin_name the name of the plugin	 
	 *
	 *		\ingroup internal
	 */	 	
    function plugin_row( $plugin_name ) {
    	if ( WPTOUCH_PRO_BETA ) {
    		$plugin_name = "wptouch-pro-beta/wptouch-pro.php";
    	} else {
			$plugin_name = "wptouch-pro/wptouch-pro.php";
    	}
		
		if ( false ) {
			echo '</tr><tr class="plugin-update-tr"><td colspan="5" class="plugin-update"><div class="update-message">';
			echo __( 'There is a new version of WPtouch Pro available.', 'wptouch-pro' ) . ' <a href="plugin-install.php?tab=plugin-information&plugin=wptouch-pro&TB_iframe=true&width=640&height=521">' . __( 'View version details' , 'wptouch-pro' ) . '</a>';	
			echo '</div></td>';
		}
    }

	/*!		\brief Adds a "Settings" link beside Deactivate and Edit on the plugins WP admin page
	 *
	 *		This function is used internally.
	 *
	 *		\ingroup internal	 
	 */
	 
	function wptouch_pro_settings_link( $links, $file ) {
	 	if( $file == 'wptouch-pro/wptouch-pro.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'admin.php?page=wptouch-pro/admin/admin-panel.php' ) . '">' . __('Settings') . '</a>';
			array_unshift( $links, $settings_link ); // before the other links
		}
		return $links;
	}

	/*!		\brief Forces WPtouch Pro to look for a version update on the server
	 *
	 *		This function is used internally to check the WPtouch Pro servers for an updated version.
	 *
	 *		\ingroup internal	 
	 */		    
    function check_for_update() {
    	$bnc_api = $this->get_bnc_api();
    	  	
    	if ( WPTOUCH_PRO_BETA ) {
 			$plugin_name = "wptouch-pro-beta/wptouch-pro.php";
 			$latest_info = $bnc_api->get_product_version( 'wptouch-pro', true );
    	} else {
    		$plugin_name = "wptouch-pro/wptouch-pro.php";
    		$latest_info = $bnc_api->get_product_version( 'wptouch-pro' );
    	}
    	
        // Check for WordPress 3.0 function
		if ( function_exists( 'is_super_admin' ) ) {
			$option = get_site_transient( "update_plugins" );
		} else {
			$option = function_exists( 'get_transient' ) ? get_transient("update_plugins") : get_option("update_plugins");
		}
    	
    	if ( $latest_info && $latest_info['version'] != WPTOUCH_VERSION && isset( $latest_info['upgrade_url'] ) ) {    	  		   		
	        $wptouch_option = $option->response[ $plugin_name ];
	
	        if( empty( $wptouch_option ) ) {
	            $option->response[ $plugin_name ] = new stdClass();
	        }
	
			$option->response[ $plugin_name ]->url = "http://www.bravenewcode.com/products/wptouch-pro";
			
			$option->response[ $plugin_name ]->package = $latest_info['upgrade_url'];
			$option->response[ $plugin_name ]->new_version = $latest_info['version'];
			$option->response[ $plugin_name ]->id = "0";
			
			if ( WPTOUCH_PRO_BETA ) {
				$option->response[ $plugin_name ]->slug = "wptouch-pro-beta";	
			} else {
				$option->response[ $plugin_name ]->slug = "wptouch-pro";
			}

	        $this->latest_version_info = $latest_info;
    	} else {
    		unset( $option->response[ $plugin_name ] );	
    	}
    		
        if ( !$this->transient_set ) {      
        	// WordPress 3.0 changed some stuff, so we check for a WP 3.0 function
			if ( function_exists( 'is_super_admin' ) ) {
				$this->transient_set = true; 
				set_site_transient( 'update_plugins', $option );
			} else {
				if ( function_exists( 'set_transient' ) ) {
					$this->transient_set = true;
					set_transient( 'update_plugins', $option );
				}
			}
        }
        	
    }

	/*!		\brief Shows the WPtouch Pro changelog information during an automatic upgrade
	 *
	 *		This method echos the current changelog information from WPtouch Pro.  It is used during the automatic upgrade process
	 *		to give information to the user about what's changed in the new version. 
	 *
	 *		\ingroup internal	 
	 */	
    function show_plugin_info() {
    	
		switch( $_REQUEST[ 'plugin' ] ) {
			case 'wptouch-pro-beta':
				echo "<h2>" . __( "WPtouch Pro Beta Changelog", "wptouch-pro" ) . "</h2>";
				$latest_info = $this->bnc_api->get_product_version( 'wptouch-pro', true );
				if ( $latest_info ) {
					echo $latest_info['update_info'];	
				}
				exit;
				break;
			case 'wptouch-pro':
				echo "<h2>" . __( "WPtouch Pro Changelog", "wptouch-pro" ) . "</h2>";
				$latest_info = $this->bnc_api->get_product_version( 'wptouch-pro', false );
				if ( $latest_info ) {
					echo $latest_info['update_info'];	
				}				
				exit;
				break;
			default:
				break;
		}
    }

	/*!		\brief Returns a list of the WPtouch Pro module directories
	 *
	 *		WPtouch Pro modules are self-contained pieces of code with a paricular functionality. For example, a plugin developer
	 *		may wish to write an add-on module for WPtouch that enables certain functionality for BuddyPress.  The output of this method can
	 *		be filtered using the WordPress filter \em wptouch_module_directories.
	 *
	 *		\returns an array of active module directories 
	 *
	 *		\ingroup modules	 	 
	 */	    
    function get_module_directories() {
		$module_dirs = array( 
			get_wptouch_directory() . '/modules',
			WPTOUCH_BASE_CONTENT_DIR . '/modules'
		);
		
		return apply_filters( 'wptouch_module_directories', $module_dirs );   	
    }

	 
	/*!		\brief This function causes all add-on modules to be loaded
	 *
	 *		This function is used internally to pre-load all the available add-on modules for WPtouch Pro.  This method 	 
	 *		triggers the WordPress action \em wptouch_module_init after the modules are loaded.
	 *
	 *		\ingroup modules	 
	 */		    	
	function load_modules() {
		$module_dirs = $this->get_module_directories();
		
		// Load all modules
		foreach( $module_dirs as $dir ) {
			$all_files = $this->get_files_in_directory( $dir, '.php' );
			if ( $all_files ) {
				foreach( $all_files as $module_file ) {
					require_once( $module_file );	
				}	
			}
		}
		
		do_action( 'wptouch_module_init', $this );
	}
	
	 
	/*!		\brief Used to register an add-on module
	 *
	 *		This method is used internally to register a module.  Each module is responsible for registering itself using
	 *		the appropriate action hook.
	 *
	 *		\param module_name The friendly name of the module to register
	 *		\param module_settings The settings for the associated module
	 *
	 *		\ingroup modules	 
	 */			
	function register_module( $module_name, $module_settings ) {
		$this->modules[ $module_name ] = $module_settings;
	}
	
	 
	/*!		\brief Used to determine if any add-on modules have been installed
	 *
	 *		This method is used internally to determine if any add-on modules have been installed.
	 *
	 *		\returns The number of modules that have been installed
	 *
	 *		\ingroup modules		 
	 */			
	function has_modules() {
		return count( $this->modules );	
	}
	
	 
	/*!		\brief Returns a list of add-on modules
	 *
	 *		This method returns a list of all the currently installed modules.
	 *
	 *		\returns An array of installed modules
	 *
	 *		\ingroup modules		 
	 */			
	function get_modules() {
		return $this->modules;	
	}
	
	/*!		\brief Reads a piece of information from a readme or text file
	 *
	 *		This method can be used to retrieve an information fragment from an external file.  An example of an information
	 *		fragment is the plugin author's name in a PHP file, or the name of an icon set in a readme.txt file.
	 *
	 *		\param style_info The information to search for the fragment
	 *		\param fragment The fragment to search for in the text file
	 *
	 *		\returns the information represented by the fragmnent
	 *
	 *		\ingroup internal	 
	 */			
	function get_information_fragment( &$style_info, $fragment ) {
		if ( preg_match( '#' . $fragment . ': (.*)#i', $style_info, $matches ) ) {
			return $matches[1];
		} else {
			return false;	
		}
	}

	/*!		\brief Returns information about a theme
	 *
	 *		The method is used to obtain information about a given theme.
	 *
	 *		\param theme_location The full path to the theme
	 *		\param theme_url A URL representing the full path
	 *		\param custom Indicates that the theme represents a custom theme
	 *
	 *		\ingroup internal	 
	 *
	 *		\returns An object representing the theme information	 
	 */		
	function get_theme_information( $theme_location, $theme_url, $custom = false ) {
		$style_file = $theme_location . '/readme.txt';
		if ( file_exists( $style_file ) ) {
			$style_info = $this->load_file( $style_file );
			
			$theme_info = new stdClass;
			
			// todo: should probably check to make sure some of these are valid
			$theme_info->name = $this->get_information_fragment( $style_info, 'Theme Name' );
			$theme_info->theme_url = $this->get_information_fragment( $style_info, 'Theme URI' );
			$theme_info->description = $this->get_information_fragment( $style_info, 'Description' );
			$theme_info->author = $this->get_information_fragment( $style_info, 'Author' );
			$theme_info->version = $this->get_information_fragment( $style_info, 'Version' );
			$features = $this->get_information_fragment( $style_info, 'Features' );
			if ( $features ) {
				$theme_info->features = explode( ',', str_replace( ', ', ',', $features ) );
			} else {
				$theme_info->features = false;	
			}
			
			$theme_info->tags = explode( ',', str_replace( ', ', ',', $this->get_information_fragment( $style_info, 'Tags' ) ) );
			$theme_info->screenshot = $theme_url . '/screenshot.png';
			$theme_info->location = str_replace( WP_CONTENT_DIR, '', $theme_location );
			$theme_info->skins_dir = $theme_location . '/skins';
			$theme_info->custom_theme = $custom;
			
			return $theme_info;
		}
		
		return false;
	}

	/*!		\brief Returns a list of files in a particular directory
	 *
	 *		The method can be used to retrieve a list of files in a particular directory
	 *
	 *		\param directory_name The full path of the directory
	 *		\param extension The file extension to look for in the directory
	 *
	 *		\ingroup internal	 
	 *
	 *		\returns An array of files in the specified directory.  All files will have the full path prepended to their name.	 
	 */			
	function get_files_in_directory( $directory_name, $extension ) {
		$files = array();
		
		$dir = @opendir( $directory_name );
		
		if ( $dir ) {
			while ( ( $f = readdir( $dir ) ) !== false ) {
				
				// Skip common files in each directory
				if ( $f == '.' || $f == '..' || $f == '.svn' || $f == '._.DS_Store' ) {
					continue;	
				}
				
				if ( strpos( $f, $extension ) !== false ) {
					$files[] = $directory_name . '/' . $f;	
				}	
			}	
			
			closedir( $dir );	
		}
		
		return $files;
	}

	/*!		\brief Returns a list of available theme directories
	 *
	 *		The method can be used to obtain a list of available theme directories.  It is possible that a plugin or module
	 *		can add an additional directory.  The output of this method can be filtered using the WordPress filter \em wptouch_theme_directories.
	 *
	 *		\ingroup internal	 
	 *
	 *		\returns An array of  theme directories
	 */		
	function get_theme_directories() {
		array();
		
		$theme_directories[] = array( get_wptouch_directory() . '/themes', get_wptouch_url() . '/themes' );		
		$theme_directories[] = array( WPTOUCH_BASE_CONTENT_DIR . '/themes', WPTOUCH_BASE_CONTENT_URL . '/themes' );	
		
		return apply_filters( 'wptouch_theme_directories', $theme_directories );
	}
	
	/*!		\brief Returns a list of available themes
	 *
	 *		The method can be used to obtain a list of available themes. The list of themes is generated by reading the theme information
	 *		files in each of the directories returned by get_theme_directories(). The output of this function can be filtered using the 
	 *		WordPress filter \em wptouch_available_themes.
	 *
	 *		\returns An array of objects representing all available themes
	 *
	 *		\ingroup internal	 
	 */			
	function get_available_themes() {
		$themes = array();
		$theme_directories = $this->get_theme_directories();

		$custom = false;
		foreach( $theme_directories as $theme_dir ) {
			$list_dir = @opendir( $theme_dir[0] );
			
			if ( $list_dir ) {
				while ( ( $f = readdir( $list_dir ) ) !== false ) {
					// Skip common files in each directory
					if ( $f == '.' || $f == '..' || $f == '.svn' || $f == '._.DS_Store' || $f == 'core' ) {
						continue;	
					}
					
					$theme_info = $this->get_theme_information( $theme_dir[0] . '/' . $f, $theme_dir[1] . '/' . $f, $custom );
				
					if ( $theme_info && file_exists( $theme_info->skins_dir ) ) {
						// Load skins here
						$skins = $this->get_files_in_directory( $theme_info->skins_dir, 'css' );
						
						if ( count( $skins ) ) {
							$all_skin_info = array();
							
							foreach( $skins as $skin ) {
								$style_info = $this->load_file( $skin );	
								
								$skin_name = $this->get_information_fragment( $style_info, 'Skin Name' );
								
								if ( $skin_name ) {
									$skin_info = new stdClass;
									$skin_info->skin_location = $skin;
									$skin_info->skin_url = $theme_dir[1] . '/' . $f . '/skins/' . basename( $skin );
									$skin_info->name = $skin_name;
									$skin_info->basename = basename( $skin );
									
									$all_skin_info[ basename( $skin ) ] = $skin_info;
								}
							}	
							
							if ( count ( $all_skin_info ) ) {
								$theme_info->skins = $all_skin_info;
							}
						}
					}
					
					if ( $theme_info ) {
						$themes[ $theme_info->name ] = $theme_info;
					}
				}
				
				closedir( $list_dir );
			}
			
			if ( !$custom ) {
				$custom = true;
			}

		}	
		
		ksort( $themes );	
						
		return apply_filters( 'wptouch_available_themes', $themes );		
	}

	/*!		\brief Returns information about the currently active theme.
	 *
	 *		This method returns information about the currently active theme (the theme the user has selected in the Theme Browser in the administration
	 * 		panel.  
	 *
	 *		\returns An object representing the currently active theme, or false if no theme is currently active
	 *
	 *		\ingroup internal	 
	 */			
	function get_current_theme_info() {
		$settings = $this->get_settings();
		
		$themes = $this->get_available_themes();
		
		if ( isset( $themes[ $settings->current_theme_friendly_name ] ) ) {
			return $themes[ $settings->current_theme_friendly_name ];	
		}
		
		return false;
	}

	/*!		\brief Retrieves the current news items regarding WPtouch from BraveNewCode
	 *
	 *		This method returns a list of recent entries from BraveNewCode regarding WPtouch.
	 *
	 *		\param quantity The number of entries to return	 
	 *
	 *		\returns An array of RSS entries, or false if an error occurs
	 *
	 *		\ingroup internal	 
	 */		
	function get_latest_news( $quantity = 8 ) {
		if ( !function_exists( 'fetch_feed' ) ) {
			include_once( ABSPATH . WPINC . '/feed.php' );
		}
		
		$rss = fetch_feed( 'http://www.bravenewcode.com/category/wptouch/feed' );
		if ( !is_wp_error( $rss ) ) {
			$max_items = $rss->get_item_quantity( $quantity ); 
			$rss_items = $rss->get_items( 0, $max_items ); 
			
			return $rss_items;	
		} else {		
			return false;
		}
	}

	/*!		\brief Creates an object representing information about an icon set
	 *
	 *		This method can be used to create an object that represents a particular icon set.
	 *
	 *		\param name The name of the icon set
	 *		\param desc A description for the icon set
	 *		\param author The author of the icon set
	 *		\param author_url The URL for the author of the set
	 *		\param url The URL where additional information about the set can be found
	 *		\param location The location of the icon set on disk
	 *		\param dark Indicates whether or not the icon set looks best on a dark background
	 *
	 *		\returns An array of RSS entries, or false if an error occurs
	 *
	 *		\ingroup internal	 
	 */		
	function create_icon_set_info( $name, $desc, $author, $author_url, $url, $location, $dark = false ) {
		$icon_pack_info = new stdClass;
		
		$icon_pack_info->name = $name;
		$icon_pack_info->description = $desc;
		
		// Check to see if we have an author.  It's not required that you do, i.e. in the case of Custom
		if ( $author ) {
			$icon_pack_info->author = $author;
			$icon_pack_info->author_url = $author_url;
		}
		
		$icon_pack_info->url = $url;
		$icon_pack_info->location = $location;
		$icon_pack_info->class_name = $this->convert_to_class_name( $icon_pack_info->name );
		$icon_pack_info->dark_background = $dark;
		
		return $icon_pack_info;			
	}
	
	/*!		\brief Retrieves information about a particular icon set
	 *
	 *		This method returns information about a particular icon set.  The icon set information
	 *		is stored in each icon set's directory in a file called \em wptouch.info.
	 *
	 *		\param icon_pack_location The full location of the icon set on disk
	 *		\param icon_pack_url The full URL for the icon set 
	 *
	 *		\returns An object representing the icon set information, or false if the icon set or associated info file cannot be found
	 *
	 *		\ingroup internal	 
	 */		
	function get_icon_set_information( $icon_pack_location, $icon_pack_url ) {
		$info_file = $icon_pack_location . '/wptouch.info';

		if ( file_exists( $info_file ) ) {
			$icon_info = $this->load_file( $info_file );
			
			$dark = false;
			$background_type = $this->get_information_fragment( $icon_info, 'Background' );
			if ( $background_type == 'Dark' ) {
				$dark = true;
			}	
			
			// Create icon set information
			$icon_pack_info = $this->create_icon_set_info( 
				$this->get_information_fragment( $icon_info, 'Name' ),
				$this->get_information_fragment( $icon_info, 'Description' ),
				$this->get_information_fragment( $icon_info, 'Author' ),
				$this->get_information_fragment( $icon_info, 'Author URL' ),
				$icon_pack_url,
				$icon_pack_location,
				$dark
			);
					
			return $icon_pack_info;
		}
		
		return false;
	}

	/*!		\brief Creates an object representing a site-wide icon
	 *
	 *		This method is used to create an object representing a side-wide icon. The created icon can be filtered using the 
	 *		WordPress filter \em wptouch_create_site_icon.
	 *
	 *		\param name The friendly name of the icon
	 *		\param icon The location for the icon on disk
	 *		\param icon_id A globally unique ID for the icon 
	 *		\param class_name The CSS class to use for the icon
	 *
	 *		\returns An object representing the site-wide icon
	 *
	 *		\ingroup iconssets
	 *		\ingroup internal	 
	 */		
	function create_site_icon( $name, $icon, $icon_id, $class_name ) {
		$icon_info = new stdClass;
		
		$icon_info->name = $name;
		$icon_info->icon = $icon;
		$icon_info->id = $icon_id;
		$icon_info->class_name = $class_name;
		$icon_info->url = WP_CONTENT_URL . $icon;
		
		return apply_filters( 'wptouch_create_site_icon', $icon_info );
	} 

	/*!		\brief Returns a list of the site icons
	 *
	 *		This method returns a list of all the available site icons. The output from this method can be filtered using the WordPress
	 *		filter \em wptouch_site_icons.
	 *
	 *		\returns An array of objects representing the site icons available to WPtouch Pro
	 *
	 *		\ingroup internal
	 *		\ingroup iconssets	 
	 */			
	function get_site_icons() {
		$settings = $this->get_settings();
		
		$site_icons = array();
		
		$site_icon[ WPTOUCH_ICON_HOME ] = $this->create_site_icon( __( 'Site', 'wptouch-pro' ), '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/Home.png', WPTOUCH_ICON_HOME, 'home' );
		$site_icon[ WPTOUCH_ICON_BOOKMARK ] = $this->create_site_icon( __( 'iPad/iPhone Bookmark', 'wptouch-pro' ), '/plugins/' . WPTOUCH_ROOT_DIR . '/include/images/wptouch_bookmark_icon.png', WPTOUCH_ICON_BOOKMARK , 'bookmark' );
		
		if ( $settings->menu_show_email  ) {
			$site_icon[ WPTOUCH_ICON_EMAIL ] = $this->create_site_icon( __( 'Email', 'wptouch-pro' ), '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/Mail.png', WPTOUCH_ICON_EMAIL, 'email' );	
		}		
		
		if ( $settings->menu_show_rss  ) {
			$site_icon[ WPTOUCH_ICON_RSS ] = $this->create_site_icon( __( 'RSS', 'wptouch-pro' ), '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/RSS.png', WPTOUCH_ICON_RSS, 'rss' );	
		}
		
		// Add custom menu items here		
		for ( $i = 1; $i <= 3; $i++ ) {
			$text_name = 'custom_menu_text_' . $i;
			$link_name = 'custom_menu_link_' . $i;
			$link_spot = 'custom_menu_position_' . $i;
			if ( $settings->$text_name && $settings->$link_name ) {
				$site_icon[ (-100 - $i) ] = $this->create_site_icon( $settings->$text_name, '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/Default.png', (-100 - $i) , 'custom_' . $i );
			}
		}	
			
		if ( count( $this->custom_page_templates ) ) {
			$count = 1;
			foreach( $this->custom_page_templates as $page_name => $page_info ) {
				$site_icon[ WPTOUCH_ICON_CUSTOM_PAGE_TEMPLATES - $count ] = $this->create_site_icon( $page_name, '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/Default.png', WPTOUCH_ICON_CUSTOM_PAGE_TEMPLATES - $count , 'custom-' . (-$count) );	
				$count++;
			}
		}				
		
		$site_icon[ WPTOUCH_ICON_DEFAULT ] = $this->create_site_icon( __( "Default Page", 'wptouch-pro' ), '/plugins/' . WPTOUCH_ROOT_DIR . '/resources/icons/classic/Default.png', WPTOUCH_ICON_DEFAULT , 'default-prototype' );

				
		return apply_filters( 'wptouch_site_icons', $site_icon );	
	}

	/*!		\brief Returns the maximum upload size for the current server
	 *
	 *		This method returns the maximum upload size for the current server.  It does this by checking various PHP options that are set 
	 *		on different versions.
	 *
	 *		\returns The maximum upload size on the system, usually expressed in megabytes, i.e. 64M
	 *
	 *		\ingroup internal	 
	 */			
	function get_max_upload_size() {
		$max_upload_info = array();
		if ( ini_get( 'post_max_size' ) ) {
			$max_upload_info[] = (int)ini_get( 'post_max_size' );	
		}
		
		if ( ini_get( 'max_file_size' ) ) {
			$max_upload_info[] = (int)ini_get( 'max_file_size' );	
		}
		
		if ( ini_get( 'upload_max_filesize' ) ) {
			$max_upload_info[] = (int)ini_get( 'upload_max_filesize' );	
		}
		
		return min( $max_upload_info );	
	}
	

	/*!		\brief Returns a list of the available icon sets
	 *
	 *		This method returns a list of all the available icon sets. The output from this method can be filtered using the WordPress
	 *		filters \em wptouch_available_icon_sets_pre_sort and \em wptouch_available_icon_sets_post_sort.
	 *
	 *		\returns An array of objects representing the icon sets
	 *
	 *		\ingroup internal	
	 *		\ingroup iconssets 
	 */				
	function get_available_icon_packs() {
		$icon_packs = array();
		$icon_pack_directories = array();
		$icon_pack_directories[] = array( get_wptouch_directory() . '/resources/icons', get_wptouch_url() . '/resources/icons' );		
		$icon_pack_directories[] = array( WPTOUCH_BASE_CONTENT_DIR . '/icons', WPTOUCH_BASE_CONTENT_URL . '/icons' );
		
		foreach( $icon_pack_directories as $some_key => $icon_dir ) {
			$list_dir = @opendir( $icon_dir[0] );
			if ( $list_dir ) {
				while ( ( $f = readdir( $list_dir ) ) !== false ) {
					// Skip common files in each directory
					if ( $f == '.' || $f == '..' || $f == '.svn' || $f == '._.DS_Store' ) {
						continue;	
					}
					
					$icon_pack_info = $this->get_icon_set_information( $icon_dir[0] . '/' . $f, $icon_dir[1] . '/' . $f );
					
					if ( $icon_pack_info ) {
						$icon_packs[ $icon_pack_info->name ] = $icon_pack_info;
					}
				}
			}
		}
			
		$icon_packs = apply_filters( 'wptouch_available_icon_sets_pre_sort', $icon_packs );
		
		ksort( $icon_packs );
				
		return apply_filters( 'wptouch_available_icon_sets_post_sort', $icon_packs );			
	}

	/*!		\brief Called internally to set up the custom icon directory
	 *
	 *		This method is used to set up the custom icon directory.  Currently is adds "Custom Icons" to the list, associating it with the
	 *		directory in /wp-content/wptouch-data
	 *
	 *		\returns A array representing all the icon sets as well as the Custom Icon directory
	 *
	 *		\ingroup internal
	 *		\ingroup iconssets	 
	 */			
	function setup_custom_icons( $icon_pack_info ) {
		$icon_info = array();
		$icon_info[ __( 'Custom Icons', 'wptouch-pro' ) ] = $this->create_icon_set_info(
			__( 'Custom Icons', 'wptouch-pro' ),
			'Custom Icons',
			false,
			'',
			WPTOUCH_CUSTOM_ICON_URL,
			WPTOUCH_CUSTOM_ICON_DIRECTORY
		);
		
		return array_merge( $icon_pack_info, $icon_info );	
	}
	
	/*!		\brief Returns icon set information
	 *
	 *		This method is returns icon set information for the set with the requested name.  
	 *
	 *		\param set_name The name of the icon set to return information for
	 *
	 *		\returns An object representing the icon set, or false if the set is not defined
	 *
	 *		\ingroup internal
	 *		\ingroup iconssets	 
	 */			
	function get_icon_pack( $set_name ) {
		$available_packs = $this->get_available_icon_packs();
		
		if ( isset( $available_packs[ $set_name ] ) ) {
			return $available_packs[ $set_name ];
		} else {
			return false;	
		}
	}

	/*!		\brief Indicates whether or not a given file is an image file
	 *
	 *		This method can be used to determine whether or not a file is an image file.  It makes this determination based on the file extension.  The
	 *		allowable file extensions are currently png, jpg, jpeg, and gif, but can be filtered using the WordPress filter \em wptouch_image_file_types.
	 *
	 *		\param file_name The name of the file to check against
	 *
	 *		\returns True if the file is an image, otherwise false
	 *
	 *		\ingroup internal
	 *		\ingroup helpers	 
	 */			
	function is_image_file( $file_name ) {
		$file_name = strtolower( $file_name );
		$allowable_extensions = apply_filters( 'wptouch_image_file_types', array( '.png', '.jpg', '.gif', '.jpeg' ) );
		
		$is_image = false;
		foreach( $allowable_extensions as $ext ) {
			if ( strpos( $file_name, $ext ) !== false ) {
				$is_image = true;
				break;	
			}
		}
		
		return $is_image;
	}

	/*!		\brief Retrieves a list of icons that are available in a particular set
	 *
	 *		This method can be used to obtain a list of available icons in a particular icon set. 
	 *
	 *		\param setname The name of icon set
	 *
	 *		\returns An array of icons, or an empty array if no icons are found
	 *
	 *		\ingroup internal
	 *		\ingroup iconssets	 
	 */	
	function get_icons_from_packs( $setname ) {		
		$settings = $this->get_settings();
		$icon_packs = $this->get_available_icon_packs();
		
		$icons = array();
			
		if ( isset( $icon_packs[ $setname ] ) ) {
			$pack = $icon_packs[ $setname ];
			$dir = @opendir( $pack->location );
			
			$class_name = $this->convert_to_class_name( $setname );
			
			if ( $dir ) {
				while ( $f = readdir( $dir ) ) {
					if ( $f == '.' || $f == '..' || $f == '.svn' || !$this->is_image_file( $f ) ) continue;
					
					$icon_info = new stdClass;
					$icon_info->location = $pack->location . '/' . $f;
					$icon_info->short_location = str_replace( WP_CONTENT_DIR, '', $icon_info->location );
					$icon_info->url = $pack->url . '/' . $f;
					$icon_info->name = $f;
					$icon_info->set = $setname;
					$icon_info->class_name = $class_name;
					
					$short_name_array = explode( '.', $f );
					$short_name = $short_name_array[0];
					$icon_info->short_name = $short_name;
					
					// add image size information if the user has the GD library installed
					if ( function_exists( 'getimagesize' ) ) {
						$icon_info->image_size = getimagesize( $pack->location . '/' . $f );	
					}
					
					$icons[ $f . '/' . $setname ] = $icon_info;	
				}
			
				closedir( $dir );	
			}
		}
		
		ksort( $icons );
		
		return $icons;
	}

	/*!		\brief Outputs the WPtouch scripts in the administration panel header
	 *
	 *		This method is called internally to determine the proper scripts to use for the administration panel.  To add additional content here, use the
	 *		WordPress action \em wptouch_admin_head.
	 *
	 *		\ingroup internal	
	 *		\ingroup admin 
	 */	
	function wptouch_admin_head() {		
		$current_scheme = get_user_option('admin_color');
		$settings = $this->get_settings();
		
		if ( strpos( $_SERVER['REQUEST_URI'], 'wptouch-pro' ) !== false ) {
			$version_string = md5( WPTOUCH_VERSION );
			$minfile = WPTOUCH_DIR . '/admin/css/wptouch-admin-min.css';
			
			if ( file_exists( $minfile ) ) {
				echo "<link rel='stylesheet' type='text/css' href='" . WPTOUCH_URL . "/admin/css/wptouch-admin-min.css?ver=" . $version_string . "' />\n";
			} else {
				echo "<link rel='stylesheet' type='text/css' href='" . WPTOUCH_URL . "/admin/css/wptouch-admin.css?ver=" . $version_string . "' />\n";			
			}
			
			echo "<link rel='stylesheet' type='text/css' href='" . WPTOUCH_URL . "/admin/css/wptouch-admin-" . $current_scheme . ".css?ver=" . $version_string . "' />\n";		
			
			if ( eregi( "MSIE", getenv( "HTTP_USER_AGENT" ) ) || eregi( "Internet Explorer", getenv( "HTTP_USER_AGENT" ) ) ) {
				echo "<link rel='stylesheet' type='text/css' href='" . WPTOUCH_URL . "/admin/css/wptouch-admin-ie.css?ver=" . $version_string . "' />\n";
			}
			
			do_action( 'wptouch_admin_head' );
		}
	}

	/*!		\brief Converts a string into a format that can be used as a CSS class name
	 *
	 *		This method converts an arbitrary string into a format the can be used in a CSS class name.  Various characters such as spaces and quotes
	 *		are converted into dashes.
	 *
	 *		\param $name The string to convert into a class name
	 *
	 *		\returns A string which can be used in a CSS class
	 *
	 *		\ingroup internal
	 *		\ingroup helpers	 
	 */		
	function convert_to_class_name( $name ) {
		$class_name = str_replace( ' ', '-', str_replace( '"', '', str_replace( '.', '-', str_replace( '\'', '', strtolower( $name ) ) ) ) );	
		return $class_name;
	}
	
	/*!		\brief Used to display an Admob mobile advertisement
	 *
	 *		This method can be used to display an Admob mobile advertisement
	 *
	 *		\returns The HTML representation of the Admob ad to display
	 *
	 *		\ingroup internal
	 *		\ingroup advertising	 
	 */		
	function get_admob_ad() {
		ob_start();
		include( get_wptouch_directory() . '/include/advertising/admob.php' );
		$advertising = ob_get_contents();
		ob_end_clean();	
		
		return $advertising;
	}

	/*!		\brief Used to display a Google Adsense mobile advertisement
	 *
	 *		This method can be used to display an Google Adsense mobile advertisement.  
	 *
	 *		\note Currently only supports iPhone/Webkit-based devices.
	 *
	 *		\returns The HTML representation of the Google Adsense advertisment to display
	 *
	 *		\ingroup internal
	 *		\ingroup advertising	 
	 */			
	function get_google_ad() {
		ob_start();
		if ( $this->get_active_device_class() == 'iphone' ) {
			include( get_wptouch_directory() . '/include/advertising/adsense-iphone.php' );
		} else { 
			WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Attempting to show an iPhone ad on a non-iPhone device' );
		}
		$advertising = ob_get_contents();
		ob_end_clean();	
		
		return $advertising;
	}
	
	/*!		\brief Used to display advertising in WPtouch themes. 
	 *
	 *		This method is called internally to display a mobile advertisement. To add a custom advertisement type, intercept the WordPress filter
	 *		\em wptouch_advertising_types to define a new type. To render the new advertisement, intercept the WordPress action \em wptouch_advertising_{new_type}
	 *		(where {new_type} is the new advertisement type, such as my_advertisement) and output the HTML fragment representing the adverisement.
	 *
	 *		\note Currently only Google Adsense and Admob advertisements are supported
	 *	 
	 *		\ingroup internal
	 *		\ingroup advertising	 
	 *
	 *		\par Custom Advertising:
	 *		To add a custom adverising type, you could do the following:
	 *
	 *		\include custom-advertising.php
	 */		
	function handle_advertising( $content = false ) {
		$settings = $this->get_settings();
		
		$can_show_ads = false;
		switch( $settings->advertising_pages ) {
			case 'ads_single':
				$can_show_ads = is_single() && !is_page();
				break;
			case 'main_single_pages':
				$can_show_ads = is_front_page() || is_home() || is_single() || is_page();
				break;
			case 'all_views':
				// show for everything
				$can_show_ads = true;
				break;	
		}
		
		if ( $can_show_ads ) { 
			switch( $settings->advertising_type ) {
				case 'admob':
					echo $this->get_admob_ad();
					break;
				case 'google':
					echo $this->get_google_ad();
					break;
				case 'custom':
					echo '<div class="wptouch-custom-ad">' . $settings->custom_advertising_code . '</div>';
					break;
				case 'default':
					// Try to get this advertising type from a plugin
					do_action( 'wptouch_advertising_' . $settings->advertising_type );
					break;
			}
		}
	}

	/*!		\brief Used to inject the custom statistics code into the footer of a WPtouch Pro theme
	 *
	 *		This method is called internally to inject custom statistics code into the footer of a WPtouch Pro mobile theme.  
	 *		The custom statistics code is defined in the user setting \em custom_stats_code.  The output from this function
	 *		can be filtered using the WordPress filter \em wptouch_custom_stats_code.
	 *	 
	 *		\ingroup internal	 
	 */		
	function put_stats_in_footer() {
		$settings = $this->get_settings();
		
		echo apply_filters( 'wptouch_custom_stats_code', $settings->custom_stats_code );
	}
	
	/*!		\brief Used to display the number of queries and page loading time in the footer of a mobile theme
	 *
	 *		This method is called internally to display queries and page loading time in the footer. The output of this function is wrapped in 
	 *		an HTML div with an ID of \em wptouch-query.  The output of this function can be filtered using the WordPress filter
	 *		\em wptouch_footer_load_time.
	 *	 
	 *		\ingroup internal	 
	 */			
	function show_footer_load_time() {
		echo apply_filters( 'wptouch_footer_load_time', '<div id="wptouch-query">' . sprintf( __( "%d queries in %0.1f ms", 'wptouch-pro' ), get_num_queries(), 1000*timer_stop( 0, 4 ) ) . '</div>' );	
	}
	
	/*!		\brief Used to display the custom footer message
	 *
	 *		This method is called internally to display a custom footer message in a WPtouch Pro mobile theme.  The custom footer message is 
	 *		defined in the user setting \em footer_message, and can be filtered using the WordPress filter \em wptouch_custom_footer_message.
	 *	 
	 *		\ingroup internal	 
	 */			
	function show_custom_footer_message() {
		$settings = $this->get_settings();
		echo apply_filters( 'wptouch_custom_footer_message', $settings->footer_message );	
	}
	
	function handle_client_ajax() {
		$nonce = $this->post['wptouch_nonce'];
		if ( !wp_verify_nonce( $nonce, 'wptouch-ajax' ) ) {
			die( 'Security' );
		}
		
		if ( isset( $this->post['wptouch_action'] ) ) {
			do_action( 'wptouch_ajax_' . $this->post['wptouch_action'] );	
			exit;
		}
		
		die;
	}
	
	/*!		\brief Initializes all theme components
	 *
	 *		This method is called internally from the \em wp_init action, and is used to setup the majority of filters and action hooks 
	 *		that are required for the mobile themes.  The following actions are initiated from this method: \em wptouch_init, \em wptouch_theme_init, and 
	 *		\em wptouch_theme_language.  The plugins that have been disabled by the user in the administration panel are also disabled from this
	 *		method.
	 *	 
	 *		\ingroup internal	 
	 */			
	function init_theme() {	
		$settings = $this->get_settings();
			
		$this->inject_dynamic_javascript();
		
		if ( $settings->footer_message ) {
			add_action( 'wp_footer', array( &$this, 'show_custom_footer_message' ) );	
		}		
			
		if ( $settings->show_wptouch_in_footer ) {		
			add_action( 'wp_footer', array( &$this, 'show_wptouch_message_in_footer') );	
		}		

		if ( $settings->custom_stats_code ) {
			add_action( 'wp_footer', array( &$this, 'put_stats_in_footer' ) );	
		}	
		
		if ( $settings->show_footer_load_times ) {
			add_action( 'wp_footer', array( &$this, 'show_footer_load_time' ) );	
		}
		
		if ( $settings->custom_css_file ) {
			add_action( 'wp_footer', array( &$this, 'inject_custom_css_in_footer' ) );	
		}
		
		// Setup advertising
		if ( $settings->advertising_type != 'none' ) {
			switch ( $settings->advertising_location ) {
				case 'footer':
					add_action( 'wptouch_advertising_bottom', array( &$this, 'handle_advertising' ) );
					break;
				case 'header':
					add_action( 'wptouch_advertising_top', array( &$this, 'handle_advertising' ) );
					break;
				default:
					WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Unknown advertising location: ' . $settings->advertising_location );
					break;
			}	
		}
		
		wp_enqueue_script( 'wptouch-ajax', get_wptouch_url() . '/include/js/wptouch.js', array( 'jquery' ), md5( WPTOUCH_VERSION ) );
		
		$localize_params = 	array( 
			'ajaxurl' => get_bloginfo( 'wpurl' ) . '/wp-admin/admin-ajax.php',
			'security_nonce' => wp_create_nonce( 'wptouch-ajax' )
		);
	
		wp_localize_script( 'wptouch-ajax', 'WPtouch', apply_filters( 'wptouch_localize_scripts', $localize_params  ) );		

		do_action( 'wptouch_init' );
		
		// Do the theme init
		do_action( 'wptouch_theme_init' );		
		
		// Load the language file
		if ( $this->locale ) {
			do_action( 'wptouch_theme_language', $this->locale );
		}
		
		// Do custom page templates
		if ( isset( $this->get['wptouch_page_template'] ) ) {
			$page_name = false;
			foreach( $this->custom_page_templates as $name => $template_name ) {
				if ( $template_name[0] == $this->get['wptouch_page_template'] ) {
					$page_name = $name;
					break;
				}	
			}
			
			if ( $page_name ) {
				$this->is_custom_page_template = true;
				
				$menu_items = $this->add_static_menu_items( array() );
				
				if ( isset( $menu_items[ $page_name ] ) ) {
					$this->custom_page_template_id = $menu_items[ $page_name ]->page_id;
				}
				
				$template_file = basename( $this->get['wptouch_page_template'] );
				
				if ( !wptouch_do_template( $template_file . '.php' ) ) {
					echo( "Unable to locate template file " . $template_file );	
				}
			}

			die;	
		}
		
		$this->disable_plugins();
	}

	/*!		\brief Injects a link to a custom CSS file into the footer.
	 *
	 *		This method injects a link to a custom CSS file into the footer.  This routine is tied to the setting \em custom_css_file.
	 *	 
	 *		\ingroup internal	
	 */			
	function inject_custom_css_in_footer() {
		$settings = wptouch_get_settings();
		
		if ( $settings->custom_css_file ) {
			echo "\n <link type='text/css' rel='stylesheet' href='" . $settings->custom_css_file . "' media='screen' />\n";
		}
	}
	
	/*!		\brief Adds a warning to the \em Compatibility section in the administration panel
	 *
	 *		This method adds a warning message to the WPtouch Pro administrational panel.  If there is one or more warning messages,
	 *		a notification message is shown in the WPtouchBoard area with a link to the \em Compatibility section.
	 *
	 *		\param area_or_plugin The area of plugin name the warning is associated with
	 *		\param warning_desc The description of the warning
	 *		\param link A URL to a webpage that describes the warning in more detail.
	 *
	 *		\note The link parameter is currently not used, but will be added in future versions
	 *	 
	 *		\ingroup internal	
	 *		\ingroup compat 
	 */		
	function add_warning( $area_or_plugin, $warning_desc, $link = false ) {
		$this->warnings[ $area_or_plugin ] = array( $area_or_plugin, $warning_desc, $link );	
	}

	/*!		\brief Generates an exhaustive list of plugins and their associated hooks
	 *
	 *		This method is used internally to generate a list of all plugins on the system, and also which WordPress actions and filters the plugin
	 *		uses.  This information can be used to selectively remove plugins while WPtouch Pro is running, improving the end user experience
	 *		on sites with plugins that do not natively work with WPtouch Pro.
	 *
	 *		A plugin can automatically add themselves to a whitelist of working plugins by filtering the WordPress filter \em wptouch_plugin_whitelist
	 *		and adding its slug to the array of plugins. 
	 *
	 *		\note Not all plugins can be disabled with this method
	 *
	 *		\param update_list When set to true, the entire list is regenerated.  When false, the list is loaded from settings
	 *	 
	 *		\ingroup internal	 
	 *		\ingroup compat
	 */		
	function generate_plugin_hook_list( $update_list = false ) {
		$settings = $this->get_settings();
	
		if ( $update_list ) {
			$php_files = $this->get_all_recursive_files( WP_PLUGIN_DIR, "php" );
			
			$plugin_whitelist = apply_filters( 'wptouch_plugin_whitelist', array( 'akismet', 'wptouch', 'wptouch-pro', 'wptouch-pro-beta' ) );
			
			foreach( $php_files as $plugin_file ) {
				$path_info = explode( '/', $plugin_file );
				
				if ( count( $path_info ) > 2 ) {		
					$plugin_slug = $path_info[1];
					
					if ( in_array( $plugin_slug, $plugin_whitelist ) ) {
						continue;	
					}
						
					$plugin_file_path = WP_PLUGIN_DIR . $plugin_file;
					
					$contents = $this->load_file( $plugin_file_path );
					
					if ( !isset( $this->plugin_hooks[ $plugin_slug ] ) ) {
						$this->plugin_hooks[ $plugin_slug ] = new stdClass;
					}
					
					// Default actions
					if ( preg_match_all( "#add_action\([ ]*[\'\"]+(.*)[\'\"]+,[ ]*[\'\"]+(.*)[\'\"]+[ ]*(\s*[,]\s*+(.*))*\)\s*;#iU", $contents, $matches ) ) {
						for( $i = 0; $i < count( $matches[0] ); $i++ ) {						
							if ( strpos( $matches[2][$i], ' ' ) === false ) {
								$info = new stdClass;
								$info->hook = $matches[1][$i];
								$info->hook_function = $matches[2][$i];
								
								if ( isset( $matches[4][$i] ) && $matches[4][$i] > 0 ) {
								    $info->priority = $matches[4][$i];   
								} else {
								    $info->priority = false;   
								}
								
								$this->plugin_hooks[ $plugin_slug ]->actions[] = $info;
							}
						}
					}
					
					// Default filters
					if ( preg_match_all( "#add_filter\([ ]*[\'\"]+(.*)[\'\"]+,[ ]*[\'\"]+(.*)[\'\"]+[ ]*(\s*[,]\s*+(.*))*\)\s*;#iU", $contents, $matches ) ) {
						for( $i = 0; $i < count( $matches[0] ); $i++ ) {
							if ( strpos( $matches[2][$i], ' ' ) === false ) {
								$info = new stdClass;
								$info->hook = $matches[1][$i];
								$info->hook_function = $matches[2][$i];
								
								if ( isset( $matches[4][$i] ) && $matches[4][$i] > 0 ) {
								    $info->priority = $matches[4][$i];   
								} else {
								    $info->priority = false;   
								}								
								
								$this->plugin_hooks[ $plugin_slug ]->filters[] = $info;
							}
						}
					}				
				}
			}
			
			ksort( $this->plugin_hooks );
			$settings->plugin_hooks = $this->plugin_hooks;
			
			$this->save_settings( $settings );			
			
		} else {
			$this->plugin_hooks = $settings->plugin_hooks;
		}
		
		$this->settings = false;		
	}

	/*!		\brief Used to check for known plugin incompatibilties
	 *
	 *		This method is used internally to check for known plugins that conflict with WPtouch Pro.  When detected, a warning is added
	 *		to the \em Compatibility section of the WPtouch Pro administration panel.
	 *	 
	 *		\ingroup internal	 
	 *		\ingroup compat
	 */			
	function check_plugins_for_warnings() {
		$settings = $this->get_settings();
		
		if ( WPTOUCH_SIMULATE_ALL || ini_get('safe_mode' ) ) {
			$this->add_warning( 'PHP Safe Mode', __( 'WPtouch Pro will not work fully in safe mode. The ability to save custom icons/sets or themes, and write files like the debug log are not available.', 'wptouch-pro' ) );
		}
		
		if ( WPTOUCH_SIMULATE_ALL || function_exists( 'wp_super_cache_init' ) ) {
			$this->add_warning( 'WP Super Cache', __('Configuration is required to work with WPtouch Pro. It must configured to exclude the user agents that WPtouch Pro is enabled for (iphone, ipod, aspen, incognito, webmate, android, dream, cupcake, froyo, blackberry9500, blackberry9520, blackberry9530, blackberry9550, blackberry 9800, webos, s8000, bada)', 'wptouch-pro' ),  'http://www.bravenewcode.com/support/topic/using-wptouch-pro-with-wp-super-cache' );	
		}
		
		if ( WPTOUCH_SIMULATE_ALL || class_exists( 'W3_Plugin_TotalCache' ) ) {
			$this->add_warning( 'W3 Total Cache', __('Extra configuration is required. It must be configured to exclude the user agents that WPtouch Pro is enabled for (iphone, ipod, aspen, incognito, webmate, android, dream, cupcake, froyo, blackberry9500, blackberry9520, blackberry9530, blackberry9550, blackberry 9800, webos, s8000, bada)', 'wptouch-pro' ), 'http://www.bravenewcode.com/support/topic/using-wptouch-pro-with-w3-cache' );	
		}
		
		if ( WPTOUCH_SIMULATE_ALL || function_exists( 'hyper_activate' ) ) {
			$this->add_warning( 'Hyper Cache', __('Extra configuration is required. You must enable the "Detect mobile devices" option, and add these user agents that WPtouch Pro is enabled for (iphone, ipod, aspen, incognito, webmate, android, dream, cupcake, froyo, blackberry9500, blackberry9520, blackberry9530, blackberry9550, blackberry 9800, webos, s8000, bada) to the Mobile agent list.', 'wptouch-pro' ) );	
		}
		
		if ( WPTOUCH_SIMULATE_ALL || class_exists( 'WPMinify' ) ) {
			$this->add_warning( 'WPMinify', __( 'Extra configuration is required. Add paths to your active WPtouch Pro theme CSS and Javascript files as files to ignore in WPMinify.', 'wptouch-pro' ) );	
		}
		
		if ( WPTOUCH_SIMULATE_ALL || function_exists( 'lightbox_styles' ) ) {
			$this->add_warning( 'Lightbox 2', __( 'This plugin will not work correctly in WPtouch Pro, and should be disabled below in the Plugin Compatibility section.', 'wptouch-pro' ) );
		}
		
		if ( WPTOUCH_SIMULATE_ALL || function_exists( 'cfmobi_check_mobile' ) ) {
			$this->add_warning( 'WP Mobile Edition', __( 'WP Mobile edition should be configured to exclude the user agents that WPtouch Pro is enabled for ("iphone", "ipod", "aspen", "incognito", "webmate", "dream", "android", "cupcake", "froyo", "blackberry9500", "blackberry9530", "blackberry9520", "blackberry9550", "webos").', 'wptouch-pro' ) );
		}
		
		if ( WPTOUCH_SIMULATE_ALL || function_exists( 'wptouch_init' ) ) {
			$this->add_warning( 'WPtouch 1.x', __( 'WPtouch Pro cannot co-exist with WPtouch 1.x.  Disable it first in the WordPress Plugins settings.', 'wptouch-pro' ) );
		}

		if ( WPTOUCH_SIMULATE_ALL || ( function_exists( 'gallery_styles' ) && !$settings->plugin_disable_featured_content_gallery ) ) {
			$this->add_warning( 'Featured Content Gallery', __( 'The Featured Content Gallery plugin does not work correctly with WPtouch Pro. Please disable it below in the Plugin Compatibility section.', 'wptouch-pro' ) );
		}
		
		if ( WPTOUCH_SIMULATE_ALL || ( function_exists( 'id_activate_hooks' ) && !$settings->plugin_disable_intensedebate ) ) {
			$this->add_warning( 'IntenseDebate', __( 'IntenseDebate is not fully supported in WPtouch Pro at this time.', 'wptouch-pro' ) );
		}
		
		
	}
	
	/*!		\brief Used to remove the WordPress filters and actions from incompatible plugins
	 *
	 *		This method is used internally to remove the WordPress filters and actions for plugins known to interfere with
	 *		WPtouch Pro or any mobile themes.  The information used to disable these plugins is obtained from the generate_plugin_hook_list() method.
	 *	 
	 *		\ingroup internal	 
	 *		\ingroup compat
	 */		
	function disable_plugins() {
		$settings = $this->get_settings();
		
		if ( $settings->plugin_hooks && count( $settings->plugin_hooks ) ) {
			foreach( $settings->plugin_hooks as $name => $hook_info ) {
				$proper_name = "plugin_disable_" . str_replace( '-', '_', $name );
				
				if ( isset( $settings->$proper_name ) && $settings->$proper_name ) {

					if ( count( $hook_info->filters ) ) {
						foreach( $hook_info->filters as $hooks ) {
							WPTOUCH_DEBUG( WPTOUCH_VERBOSE, "Disable filter [" . $hooks->hook . "] with function [" . $hooks->hook_function . "]" );
							if ( $hooks->priority ) {
								remove_filter( $hooks->hook, $hooks->hook_function, $hooks->priority );
							} else { 
								remove_filter( $hooks->hook, $hooks->hook_function );	
							}
						}
					}
					
					if ( count( $hook_info->actions ) ) {
						foreach( $hook_info->actions as $hooks ) {
							WPTOUCH_DEBUG( WPTOUCH_VERBOSE, "Disable action [" . $hooks->hook . "] with function [" . $hooks->hook_function . "]" );
							if ( $hooks->priority ) {
								remove_action( $hooks->hook, $hooks->hook_function, $hooks->priority );
							} else {
								remove_action( $hooks->hook, $hooks->hook_function );
							}
						}
					}
				}	
			}
		}
	}
	
	/*!		\brief Returns a list of all children page IDs	 
	 *
	 *		This method is returns sa list of all the page IDs for the children of the specified parent.
	 *
	 *		\param parent The page ID for the parent
	 *	 
	 *		\ingroup menus	 
	 */		
	function parent_and_children_menu_ids( $parent ) {
		global $wpdb;
		
		$all_ids = array( $parent );
		
		$sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'page'", $parent );
		$result = $wpdb->get_results( $sql );
		if ( $result ) {
			foreach( $result as $title ) {
				$all_ids = array_merge( $all_ids, $this->parent_and_children_menu_ids( $title->ID ) );
			}
		}
				
		return $all_ids;	
	}
	
	/*!		\brief Removes a directory
	 *
	 *		This method removes all the files in a particular directory, and then removes the directory. 
	 *
	 *		\param dir_name The name of the directory to delete
	 *
	 *		\note This method does not recurse into subdirectories.  It is assume that the directory is only one level deep.
	 *	 
	 *		\ingroup internal	 
	 *		\ingroup files
	 */		
	function remove_directory( $dir_name ) {
		// Check permissions
		if ( current_user_can( 'manage_options' ) ) {
			$dir = @opendir( $dir_name );
			if ( $dir ) {
				while ( $f = readdir( $dir ) ) {
					if ( $f == '.' || $f == '..' ) continue;
					
					@unlink( $dir_name . '/' . $f );	
				}
				
				closedir( $dir );
				
				@unlink( $dir_name );
			}	
		}
	}

	/*!		\brief Used to setup the text translation for internationalization.
	 *
	 *		This function is called internally to setup the langage translations.  The currently selected language can be filtered
	 *		using the WordPress filter \em wptouch_language.
	 *
	 */	
	function setup_languages() {		
		$current_locale = get_locale();
		
		// Check for language override
		$settings = wptouch_get_settings();
		if ( $settings->force_locale != 'auto' ) {
			$current_locale = $settings->force_locale;
		}
		
		if ( !empty( $current_locale ) ) {
			$current_locale = apply_filters( 'wptouch_language', $current_locale );
			
			$use_lang_file = false;
			$custom_lang_file = WPTOUCH_CUSTOM_LANG_DIRECTORY . '/' . $current_locale . '.mo';
			
			if ( file_exists( $custom_lang_file ) && is_readable( $custom_lang_file ) ) {
				$use_lang_file = $custom_lang_file;
			} else {
				$lang_file = get_wptouch_directory() . '/lang/' . $current_locale . '.mo';
				if ( file_exists( $lang_file ) && is_readable( $lang_file ) ) {
					$use_lang_file = $lang_file;
				}
			}
					
			if ( $use_lang_file ) {
				load_textdomain( 'wptouch-pro', $use_lang_file );	
				
				WPTOUCH_DEBUG( WPTOUCH_INFO, 'Loading language file ' . $use_lang_file );
			}
			
			$this->locale = $current_locale;
			
			do_action( 'wptouch_language_loaded', $this->locale );
		}
	}

	/*!		\brief Basic initialization functions for WPtouch
	 *
	 *		This function is called internally to initialize WPtouch.  Currently only the language conversions occur here.
	 *
	 */	
	function wptouch_init() {	
		$is_wptouch_page = ( strpos( $_SERVER['REQUEST_URI'], 'wptouch-pro' ) !== false );
		
		// Only process POST settings on wptouch-pro pages
		if ( $is_wptouch_page && $this->in_admin_panel() ) {
			$this->process_submitted_settings();	
		}		
			
		$this->setup_languages();
	}
	
	/*!		\brief Retrives the WPtouch Pro settings object
	 *
	 *		This method can be used to retrieve the main WPtouch Pro settings object from the database.  To reduce database load,
	 *		the settings object is cached internally after it is first retrieved from the database; all subsequent calls to this method
	 *		will return the cached copy of the settings.  The save_settings() method will automatically update the internal cache.
	 *
	 *		The settings object is updated dynamically based on the default WPtouchDefaultSettings object; if a setting exists in
	 *		the WPtouchDefaultSettings object but not in the stored settings, the settings object is automatically updated with the default setting.
	 *		The default settings can be filtered with the WordPress filter \em wptouch_default_settings, which is the mechanism WPtouch Pro mobile
	 *		themes are expected to use to configure default settings for each theme.  The global settings object can also be filtered with
	 *		the WordPress filter \em wptouch_settings.
	 *
	 *		\returns The WPtouch Pro settings object
	 *
	 *		\par Adding Default Settings:
	 *		\include wptouch-default-settings.php
	 *
	 *		\ingroup settings
	 */
	function get_settings() {
		// check to see if we've already loaded the settings
		if ( $this->settings ) {
			return apply_filters( 'wptouch_settings', $this->settings );	
		}
		
		//update_option( WPTOUCH_SETTING_NAME, false );
		$this->settings = get_option( WPTOUCH_SETTING_NAME, false );
		if ( !is_object( $this->settings ) ) {
			$this->settings = unserialize( $this->settings );	
		}

		if ( !$this->settings ) {
			// Return default settings
			$this->settings = new WPtouchSettings;
			$defaults = apply_filters( 'wptouch_default_settings', new WPtouchDefaultSettings );

			foreach( (array)$defaults as $name => $value ) {
				$this->settings->$name = $value;	
			}

			return apply_filters( 'wptouch_settings', $this->settings );	
		} else {	
			// first time pulling them from the database, so update new settings with defaults
			$defaults = apply_filters( 'wptouch_default_settings', new WPtouchDefaultSettings );
			
			// Merge settings with defaults
			foreach( (array)$defaults as $name => $value ) {
				if ( !isset( $this->settings->$name ) ) {
					$this->settings->$name = $value;	
				}
			}

			return apply_filters( 'wptouch_settings', $this->settings );	
		}
	}	
	
	/*!		\brief Adds a menu to the main WPtouch menu
	 *
	 *		Adds a menu to the main WPtouch menu.  The menu can be a nested list of
	 *		arrays to create subments.
	 *
	 *		\param menu_type The position on the root WPtouch menu.  Options are currently 'pre' or 'post'.
	 *		\param menu an array representing the menu to add
	 *
	 *		\ingroup menus
	 */
	function add_to_menu( $menu_type, $menu ) {
		switch( $menu_type ) {
			case 'pre':
				$this->pre_menu[] = $menu;
				break;
			case 'post':
				$this->post_menu[] = $menu;
				break;	
		}	
	}


	/*! 	\brief Used to determine the supported device classes within WPtouch Pro
	 *
	 *		This method is used to determine the supported device classes within WPtouch Pro.  These classes can ultimately be modified by themes using
	 *		various WordPress filters.  The appropriate filters are detailed in the get_supported_theme_device_classes() method.
	 *
	 *		\returns an array of WPtouch supported device classes  
	 */		
	function get_supported_device_classes() {
		global $wptouch_device_classes;
		
		$supported_classes = apply_filters( 'wptouch_supported_device_classes', $wptouch_device_classes );
		
		foreach( $wptouch_device_classes as $device_class => $device_info ) {
			$supported_classes[] = $device_class;	
		}	
		
		return $supported_classes;
	}
	

	/*! 	\brief Used to determine the supported device classes for a theme.
	 *
	 *		This method can be used to determine the supported device classes for a theme. To indicate which device classes a particular theme
	 *		supports, a theme would modify the data via the WordPress \em wptouch_supported_device_classes, adding or removing device classes.
	 *		Each supported device class must also have an associated subdirectory within the theme folder.  For example, if a theme were to support
	 *		the "ipad" device class, it would need to add "ipad" using the filter \em wptouch_theme_device_classes, and also have an ipad directory
	 *		containing template files within its main theme directory.
	 *
	 *	 	The WordPress filter \em wptouch_supported_device_classes can also be used to modify the support device classes at a global scope.  Using this filter
	 *		it would be possible to disable a particular class of devices, such as iPads or Blackberries. 
	 *
	 *		\returns an array of supported device classes  
	 */	
	function get_supported_theme_device_classes() {		
		global $wptouch_device_classes;

		// Get a list of all supported mobile device classes
		$supported_device_classes = apply_filters( 'wptouch_theme_device_classes', $this->get_supported_device_classes() );
		
		$device_listing = array();
		foreach( $wptouch_device_classes as $class_name => $class_info ) {
			if ( in_array( $class_name, $supported_device_classes ) ) {
				if ( file_exists( $this->get_current_theme_directory() . '/' . $class_name ) ) {
					$device_listing[ $class_name ] = $class_info;	
				}
			} 	
		}
		
		// We have a complete list of device classes and device user agents
		// but we'll give themes and plugins a chance to modify them
		return apply_filters( 'wptouch_supported_device_classes', $device_listing );		
	}
	
	/*! 	\brief Used to determine the supported user agents.
	 *
	 *		This method can be used to determine which user agents are supported by WPtouch and the active theme.  This method can be 
	 *		filtered using the WordPress filter \em wptouch_supported_agents.
	 *
	 *		\returns an array of supported mobile user agent strings.  
	 */
	function get_supported_user_agents() {
		// Get a list of the supported theme device classes
		$device_listing = $this->get_supported_theme_device_classes();
		
		// Now we'll create a master list of user agents
		$useragents = array();
		foreach( $device_listing as $device_class => $device_user_agents ) {
			$useragents = array_merge( $useragents, $device_user_agents );	
		}
		
		return apply_filters( 'wptouch_supported_agents', $useragents );
	}

	/*! 	\brief Checks to see if the user's device is a supported device 
	 *
	 *		This method can be used to determine if a user's device is a device supported by WPtouch and also the active theme.
	 *
	 * 		\returns True if the user's device is support, otherwise false.
	 *
	 *		\note This method always returns true when developer mode is enabled  
	 */	
	function is_supported_device() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$settings = $this->get_settings();

		// If we're in developer mode, always say it's a supported device
		if ( $this->is_in_developer_mode() ) {
			return true;	
		}
		
		// Now that developer mode is out of the way, let's figure out the proper list of user agents
		$supported_agents = $this->get_supported_user_agents();	
		
		// Figure out the active device type and the active device class
		foreach( $supported_agents as $agent ) {
			$friendly_agent = preg_quote( $agent );
			if ( preg_match( "#$friendly_agent#i", $user_agent ) ) {
				$this->active_device = $agent;
				
				$supported_device_classes = $this->get_supported_theme_device_classes();
				foreach ( $supported_device_classes as $device_class => $device_user_agents ) {
					if ( in_array( $agent, $device_user_agents ) ) {
						$this->active_device_class = $device_class;	
					}	
				}
				
				return true;	
			} else {
				$this->active_device = $this->active_device_class = false;	
			}
		}
		
		return false;
	}	
	
	function is_in_developer_mode() {
		$settings = $this->get_settings();	
		return ( $settings->developer_mode == 'on' || ( $settings->developer_mode == 'admins' && current_user_can( 'manage_options' ) ) );
	}

	/*! 	\brief Used to determine the active device class. 
	 *
	 *		This method can be used to determinie the active device class.  When in developer mode, this method returns "iphone" by default.
	 *		To override this behavior, use the WordPress filter	\em wptouch_developer_mode_device_class.
	 *
	 * 		\returns The active device class for mobile users.  
	 */	
	function get_active_device_class() {
		$settings = $this->get_settings();
		
		if ( $this->is_in_developer_mode() ) {
			// the default theme for developer mode is the iphone
			// a developer could override this by implementing the following filter in the functions.php file of the active theme
			return apply_filters( 'wptouch_developer_mode_device_class', 'iphone' );	
		} else {
			return $this->active_device_class;	
		}
	}

	/*!		\brief Attempts to activate a support and auto-upgrade license for the current site
	 *
	 *		This method attempts to activate a support and auto-upgrade license for the current site using the BNCAPI object.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup bnc
	 */				
	function activate_license() {
		$bnc_api = $this->get_bnc_api();
		if ( $bnc_api ) {
			$bnc_api->user_add_license( 'wptouch-pro' );
			
			$settings = wptouch_get_settings();
			
			// Force a license check next time
			$settings->last_bncid_time = 0;
			$this->save_settings( $settings );
		}
	}
	
	/*!		\brief Attempts to remove a support and auto-upgrade license
	 *
	 *		This method attempts to activate a support and auto-upgrade license for the current site using the BNCAPI object.  
	 *
	 *		\param site The site to remove. If not set, the $_POST['site'] parameter will be used instead.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup bnc
	 */					
	function remove_license( $site = false ) {
		$bnc_api = $this->get_bnc_api();
		if ( $bnc_api ) {
			if ( !$site ) {
				$site = $this->post['site'];
			}
			
			$bnc_api->user_remove_license( 'wptouch-pro', $site );	
		}
	}

	/*!		\brief Retrieves the active mobile device
	 *
	 *		This method is used to retreive the active mobile device, such as "iphone" or "ipod".
	 *
	 *		\returns A string representing the active mobile device
	 *
	 *		\ingroup wptouchglobal
	 */					
	function get_active_mobile_device() {
		return $this->active_device;
	}	
	
	/*!		\brief Echos the active mobile device
	 *
	 *		This method is used to echo the active mobile device, such as "iphone" or "ipod".
	 *
	 *		\ingroup wptouchglobal
	 */	
	function active_mobile_device() {
		echo $this->get_active_mobile_device();
	}
	
	/*!		\brief Retrieves the BNCAPI object
	 *
	 *		This method can be used to retrieve the BNCAPI object for communication with the BNC server.
	 *
	 *		\returns The BNCAPI object
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup bnc
	 */		
	function get_bnc_api() {
		// Can probably do lazy initialization here instead of up top?
		
		return $this->bnc_api;	
	}

	function has_site_license() {
		$api = $this->get_bnc_api();
		$licenses = $api->user_list_licenses( 'wptouch-pro' );	
		$this_site = $_SERVER['HTTP_HOST'];
		return ( in_array( $this_site, (array)$licenses['licenses'] ) );
	}
	
	/*!		\brief Initializes the BNCAPI object
	 *
	 *		This method creates and initializes the BNCAPI object.  The user's license key and BNCID are retrieved from the setting's object.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup bnc
	 */		
	function setup_bncapi() {
		$settings = $this->get_settings();
		
		$this->bnc_api = new BNCAPI( $settings->bncid, $settings->wptouch_license_key );
	}
	
	/*!		\brief Shows the WPtouch Pro banner message in the footer
	 *
	 *		This method displays a message in the footer indicating that the website is proudly running WPtouch Pro.  
	 *
	 *		\ingroup wptouchglobal
	 */		
	function show_wptouch_message_in_footer() {
		echo sprintf( __( "Powered by %1\$s %2\$s", "wptouch-pro" ) . "\n<br />", '<a href="http://www.bravenewcode.com/products/wptouch-pro/">WPtouch Pro</a>', WPTOUCH_VERSION );	
		echo _e( "By BraveNewCode", "wptouch-pro" );	
	}

	/*!		\brief Redirects the user to another page
	 *
	 *		This method performs a redirect to another page.
	 *
	 *		\note Requires that no headers have been sent previously  
	 *
	 *		\ingroup wptouchglobal
	 */			
	function redirect_to_page( $url ) {
		header( 'Location: ' . $url );
		die;	
	}
	
	/*!		\brief Performs a check to see if a redirect is required in a mobile theme, and if so, performs the redirect
	 *
	 *		This method checks to see whether or not a redirect is needed in a mobile theme.  Many blogs have a custom home page template for non-mobile users.
	 *		Because this template does not exist on mobile, many users redirect their home page to their blog page (or any other page in WordPress) for users on
	 *		mobile devices.
	 *
	 *		\ingroup wptouchglobal
	 */			
	function check_for_redirect() {
		$settings = $this->get_settings();
		if ( $settings->enable_home_page_redirect && $this->is_front_page() ) {
			if ( $settings->home_page_redirect_target ) {
				$link = get_permalink( $settings->home_page_redirect_target );
				if ( $link ) {
					$can_do_redirect = true;
					if ( get_option( 'show_on_front', false ) == 'page' ) {
						$front_page = get_option( 'page_on_front' );
						if ( $front_page == $settings->home_page_redirect_target ) {
							$can_do_redirect = false;	
						}
					}
					
					if ( $can_do_redirect ) {
						$this->redirect_to_page( $link );	
					}
				}	
			}
		}
	}

	/*!		\brief Modified function to determine if we're on the front page
	 *
	 *		This is a modified function to determine if we're on the front page.  Takes into account a few weird corner cases with WordPress.
	 *
	 *		\ingroup wptouchglobal
	 */		
	function is_front_page() {
		$front_option = get_option( 'show_on_front', false );
		if ( $front_option == 'page' ) {
			$front_page = get_option( 'page_on_front' );
			if ( $front_page ) {
				return is_front_page();	
			} else {
				return is_home();
			}
		} else {
			// user hasn't defined a dedicated front page, so we return true when on the blog page
			return is_home();	
		}	
	}
	
	/*!		\brief Performs a quick check to determine if the user is in the administration panel
	 *
	 *		This method checks to see if the user is in the administration panel in WordPress.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */		
	function in_admin_panel() {
		return ( strpos( $_SERVER['REQUEST_URI'], '/admin/' ) !== false );	
	}
	
	/*!		\brief Performs initialization for WPtouch for when the administration panel is showing
	 *
	 *		This method performs initialization for WPtouch when the WordPress administration panel is showing. Currently is checks to see
	 *		if any settings have been updated, and handles the POST form submission.  It also checks for plugin updates, queues Javascript scripts,
	 *		localizes Javascript text, and also sets up the Ajax handlers.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */		
	function initialize_admin_section() {	
		$is_wptouch_page = ( strpos( $_SERVER['REQUEST_URI'], 'wptouch-pro' ) !== false );
		$is_plugins_page = ( strpos( $_SERVER['REQUEST_URI'], 'plugins.php' ) !== false );
							
		// We need the BNCAPI for checking for plugin updates and all the wptouch-pro admin functions
		if ( $is_wptouch_page || $is_plugins_page ) {
			$this->setup_bncapi();
			$this->check_for_update();
		}

		// only load admin scripts when we're looking at the WPtouch Pro page
		if ( $is_wptouch_page ) {		
			$this->check_plugins_for_warnings();
			$this->generate_plugin_hook_list();
			$minfile = WPTOUCH_DIR . '/admin/js/wptouch-admin-min.js';
			$localize_params = 	array( 
				'wordpress_url' => get_bloginfo( 'wpurl' ),
				'admin_url' => get_bloginfo('wpurl') . '/wp-admin',
				'wptouch_url' => WPTOUCH_URL,
				'admin_nonce' => wp_create_nonce( 'wptouch_admin' ),
				'upload_header' => __( 'Uploading...', 'wptouch-pro' ),
				'upload_status' => __( 'Your file is currently being uploaded, please wait.', 'wptouch-pro' ),
				'upload_processing_header' => __( 'Upload complete, processing file...', 'wptouch-pro' ),
				'upload_processing_status' => __( 'Your upload has completed, please wait while your file is processed.', 'wptouch-pro' ),
				'upload_done_header' => __( 'Upload completed.', 'wptouch-pro' ),
				'upload_done_set_status' => __( 'Upload completed.', 'wptouch-pro' ) . ' ' . __( 'Your new set is available below.', 'wptouch-pro' ),
				'upload_done_icon_status' => __( 'Upload completed.', 'wptouch-pro' ) . ' ' . __( 'Your new icon is available below.', 'wptouch-pro' ),
				'upload_unzip_header' => __( 'Unzipping icon set...', 'wptouch-pro' ),
				'upload_unzip_status' => __( 'Icon set uploaded, currently unpackaging...', 'wptouch-pro' ),
				'upload_invalid_header' => __( 'Invalid file format.', 'wptouch-pro' ),
				'upload_invalid_status' => __( 'Please upload only .PNG (single image) or .ZIP (icon set) file types.', 'wptouch-pro' ),
				'upload_describe_set' => __( 'Please enter the set information below and click save', 'wptouch-pro' ),
				'are_you_sure_set' => __( 'Delete this set?', 'wptouch-pro' ) . ' ' . __( 'This operation cannot be undone.', 'wptouch-pro' ),
				'are_you_sure_delete' => __( 'Delete this theme and all its files?', 'wptouch-pro' ) . ' ' . __( 'This operation cannot be undone.', 'wptouch-pro' ),
				'reset_admin_settings' => __( 'Reset all WPtouch Pro admin settings?', 'wptouch-pro' ) . ' ' . __( 'This operation cannot be undone.', 'wptouch-pro' ),
				'reset_icon_menu_settings' => __( 'Reset Menu Page and Icon settings?', 'wptouch-pro' ) . ' ' . __( 'This operation cannot be undone.', 'wptouch-pro' ),
				'forum_topic_title' => __( 'Please enter a topic title for the support posting.', 'wptouch-pro' ),
				'forum_topic_tags' => __( 'Please enter at least one tag for the support posting.', 'wptouch-pro' ),
				'forum_topic_text' => __( 'Please enter a description for the support posting.', 'wptouch-pro' ),
				'forum_topic_failed' => __( 'There seems to have been a problem posting your support question.  Please try again later.', 'wptouch-pro' ),
				'forum_topic_success' => __( 'Your support question has been posted!', 'wptouch-pro' ),
				'activating_license' => __( 'Activating license, please wait...', 'wptouch-pro' ),
				'copying_text' => __( 'Your Backup Key was copied to the clipboard.', 'wptouch-pro' )
			);
						
			if ( WPTOUCH_PRO_BETA ) {
				$localize_params[ 'plugin_url' ] = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wptouch-pro-beta/admin/admin-panel.php';	
			} else {
				$localize_params[ 'plugin_url' ] = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wptouch-pro/admin/admin-panel.php';
			}

			wp_enqueue_script( 'jquery-plugins', WPTOUCH_URL . '/admin/js/wptouch-plugins-min.js', 'jquery', md5( WPTOUCH_VERSION ) );	

			if ( file_exists( $minfile ) ) {
				wp_enqueue_script( 'wptouch-pro-custom', WPTOUCH_URL . '/admin/js/wptouch-admin-min.js', 'jquery', md5( WPTOUCH_VERSION ) );
			} else {
				wp_enqueue_script( 'wptouch-pro-custom', WPTOUCH_URL . '/admin/js/wptouch-admin.js', 'jquery', md5( WPTOUCH_VERSION ) );			
			}

			// Set up AJAX requests here
			wp_localize_script( 'wptouch-pro-custom', 'WPtouchCustom', $localize_params );
		}	
		
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );

		$this->setup_wptouch_admin_ajax();
	}
	
	/*!		\brief Adds the appropriate actions for handling WPtouch administration Ajax calls
	 *
	 *		This method sets up the appropriate actions for handling the WPtouch administrational panel Ajax calls that use the admin-ajax script
	 *		that is built into WordPress.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */			
	function setup_wptouch_admin_ajax() {
		add_action( 'wp_ajax_wptouch_ajax', array( &$this, 'admin_ajax_handler' ) );	
	}
	
	/*!		\brief Handles all WPtouch Pro Ajax calls
	 *
	 *		This method handles all Ajax requests in the administrational panel for WPtouch.  It  checks to make sure the user has the appropriate permissions,
	 *		and also verifies that the security NONCE is valid.  
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */			
	function admin_ajax_handler() {
		if ( current_user_can( 'manage_options' ) ) {
			// Check security nonce
			$wptouch_nonce = $this->post['wptouch_nonce'];
			
			if ( !wp_verify_nonce( $wptouch_nonce, 'wptouch_admin' ) ) {
				WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Invalid security nonce for AJAX call' );			
				exit;	
			}
			
			$this->setup_bncapi();
			
			$wptouch_ajax_action = $this->post['wptouch_action'];
			switch( $wptouch_ajax_action ) {
				case 'support-posting':
					if ( WPTOUCH_PRO_BETA ) {
						$result = $this->bnc_api->post_support_topic( $this->post['title'], $this->post['tags'], $this->post['desc'], true );
					} else {
						$result = $this->bnc_api->post_support_topic( $this->post['title'], $this->post['tags'], $this->post['desc'] );
					}
					
					if ( $result ) {
						echo 'ok';
					} 
					break;
				case 'profile':
					include( WPTOUCH_ADMIN_AJAX_DIR . '/profile.php' );
					break;	
				case 'regenerate-plugin-list':
					$this->generate_plugin_hook_list( true );
					echo 'ok';
					break;
				case 'activate-license':
					$this->activate_license();
					include( WPTOUCH_ADMIN_AJAX_DIR . '/profile.php' );
					break;
				case 'remove-license':
					$this->remove_license();
					include( WPTOUCH_ADMIN_AJAX_DIR . '/profile.php' );
					break;
				case 'update-icon-pack':
					require_once( WPTOUCH_ADMIN_DIR . '/template-tags/icons.php' );
					include( WPTOUCH_ADMIN_AJAX_DIR . '/icon-area.php' );
					break;	
				case 'set-menu-icon':
					$settings = $this->get_settings();
					$settings->temp_menu_icons[ $this->post['title'] ] = str_replace( WP_CONTENT_URL, '', $this->post['icon'] );
					$this->save_settings( $settings );
					break;
				case 'reset-menu-icons':
					require_once( WPTOUCH_ADMIN_DIR . '/template-tags/icons.php' );
					
					$settings = $this->get_settings();
					$settings->temp_menu_icons = $settings->menu_icons = array();
					$settings->temp_disabled_menu_items = $settings->disabled_menu_items = array();
					$this->save_settings( $settings );
					
					echo wptouch_get_site_menu_icon( WPTOUCH_ICON_DEAULT );
					break;
				case 'enable-menu-item':
					$settings = $this->get_settings();
					$title = (int)$this->post['title'];
					if ( isset( $settings->temp_disabled_menu_items[ $title ] ) ) {
						unset( $settings->temp_disabled_menu_items[ $title ] );
						$this->save_settings( $settings );	
					} 
					break;
				case 'disable-menu-item':
					$items_to_disable = $this->parent_and_children_menu_ids( $this->post['title'] );
					if ( count( $items_to_disable ) ) {
						$settings = $this->get_settings();	
						foreach( $items_to_disable as $key => $item ) {
							$settings->temp_disabled_menu_items[ $item ] = 1;
						}
						
						$this->save_settings( $settings );
					}
					break;
				case 'remove-menu-icon':
					require_once( WPTOUCH_ADMIN_DIR . '/template-tags/icons.php' );
					$settings = $this->get_settings();
					if ( isset( $settings->temp_menu_icons[ $this->post['title'] ] ) ) {
						unset( $settings->temp_menu_icons[ $this->post['title'] ] );	
						$this->save_settings( $settings );	
					}
					echo wptouch_get_site_menu_icon( WPTOUCH_ICON_DEFAULT );
					break;
				case 'manage-upload':
					switch ( $_FILES['userfile']['type'] ) {
						case 'image/png':
						case 'image/x-png':
							move_uploaded_file( $_FILES['userfile']['tmp_name'], WPTOUCH_CUSTOM_ICON_DIRECTORY . '/' . str_replace( ' ', '-', $_FILES['userfile']['name'] ) );
							echo 'icon-done';
							break;
						case 'application/x-zip-compressed':
						case 'application/zip':
							move_uploaded_file( $_FILES['userfile']['tmp_name'], WPTOUCH_TEMP_DIRECTORY . '/' . $_FILES['userfile']['name'] );
							$settings = $this->get_settings();
							$settings->temp_icon_file_to_unzip = WPTOUCH_TEMP_DIRECTORY . '/' . $_FILES['userfile']['name'];
							$this->save_settings( $settings );
							echo 'zip';
							break;
						default:
							WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Unknown file mime type ' . $_FILES['userfile']['type'] );
							echo 'invalid';
							break;	
					}
					break;
				case 'manage-unzip-set':
					$settings = $this->get_settings();
					$directory_name = basename( strtolower( $settings->temp_icon_file_to_unzip ), '.zip' );
					@$this->create_directory_if_not_exist( WPTOUCH_CUSTOM_SET_DIRECTORY . '/' . $directory_name );
					
					$destination_file = WPTOUCH_CUSTOM_SET_DIRECTORY . '/' . $directory_name . '/' . basename( strtolower( $settings->temp_icon_file_to_unzip ) );
					@rename( $settings->temp_icon_file_to_unzip, $destination_file );
					
					ob_start();
					system( 'unzip -d "' . WPTOUCH_CUSTOM_SET_DIRECTORY . '/' . $directory_name . '" "' . $destination_file . '"' );
					ob_end_clean();
					
					@unlink( $destination_file );
					@unlink( $settings->temp_icon_file_to_unzip );
					
					if ( file_exists( WPTOUCH_CUSTOM_SET_DIRECTORY . '/' . $directory_name . '/wptouch.info' ) ) {
						echo 'done';							
					} else {
						$settings->temp_icon_set_for_readme = WPTOUCH_CUSTOM_SET_DIRECTORY . '/' . $directory_name . '/wptouch.info';
						$this->save_settings( $settings );
						echo 'create-readme';	
					}

					break;
				case 'delete-icon-pack':
					$pack = $this->get_icon_pack( $this->post['set'] ); 
					if ( $pack ) {
						$this->remove_directory( $pack->location );
					}
					break;
				case 'delete-icon':
					$icon_to_delete = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $this->post['icon'] );
					@unlink( $icon_to_delete );
					break;
				case 'activate-theme':	
					$settings = wptouch_get_settings();
					
					$theme_location = $this->post[ 'location' ];
					$theme_name = $this->post[ 'name' ];

					if ( $settings->current_theme_location != $theme_location ) {
						
						$paths = explode( '/', ltrim( rtrim( $theme_location, '/' ), '/' ) );
					
						$settings->current_theme_name = $paths[ count( $paths ) - 1 ];	
						unset( $paths[ count( $paths ) - 1 ] );
						
						$settings->current_theme_location = '/' . implode( '/', $paths );
						$settings->current_theme_friendly_name = $theme_name;
						
						remove_all_filters( 'wptouch_theme_menu' );
						remove_all_filters( 'wptouch_default_settings' );
						
						$this->save_settings( $settings );
					}
					break;
				case 'copy-theme':
					$copy_src = WP_CONTENT_DIR . $this->post[ 'location' ];
					$theme_name = $this->convert_to_class_name( $this->post[ 'name' ] );
					
					$num = $this->get_theme_copy_num( $theme_name );
					$copy_dest = WPTOUCH_CUSTOM_THEME_DIRECTORY . '/' . $theme_name . '-copy-' . $num;
					
					@$this->create_directory_if_not_exist( $copy_dest );
						
					$this->recursive_copy( $copy_src, $copy_dest );
					
					$readme_file = $copy_dest . '/readme.txt';
					$readme_info = $this->load_file( $readme_file );
					if ( $readme_info ) {
						if ( preg_match( '#Theme Name: (.*)#', $readme_info, $matches ) ) {
							$readme_info = str_replace( $matches[0], 'Theme Name: ' . $matches[1] . ' Copy #' . $num, $readme_info );
							$f = fopen( $readme_file, "w+t" );
							if ( $f ) {
								fwrite( $f, $readme_info );
								fclose( $f );
							}
						}
					} else {
						WPTOUCH_DEBUG( WPTOUCH_ERROR, "Unable to modify readme.txt file after copy" );	
					}
				
					break;	
				case 'delete-theme':
					$delete_src = WP_CONTENT_DIR . $this->post[ 'location' ];
					
					$this->recursive_delete( $delete_src );	
					@rmdir( $delete_src );
					
					break;
				case 'dismiss-warning':
					$settings = $this->get_settings();
					if ( $this->post['plugin'] ) {
						if ( !in_array( $this->post['plugin'], $settings->dismissed_warnings ) ) {
							$settings->dismissed_warnings[] = $this->post['plugin'];
							
							$this->save_settings( $settings );
						}	
					}
					
					echo wptouch_get_plugin_warning_count();
					
					break;
				default:
					if ( file_exists( WPTOUCH_ADMIN_AJAX_DIR . '/' . basename( $wptouch_ajax_action ) . '.php' ) ) {
						include( WPTOUCH_ADMIN_AJAX_DIR . '/' . basename( $wptouch_ajax_action ) . '.php' );
					} 
					break;
			}	
		} else {
			WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Insufficient security privileges for AJAX call' );	
		}		
		
		die;
	}

	/*!		\brief Obtains a list of files by recursively traversing a directory
	 *
	 *		This method can be used to obtain a list of files within and off of a particular directory.  
	 *
	 *		\param dir The directory to search for files in
	 *		\param file_types A string or array representing the file extensions to search for.  These extensions should include the period, i.e. .php or .txt
	 *		\param rel_path The relative path for the files; this parameter is not required in most scenarios, and is used primarily internally for searching
	 *		the directory tree
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */		
	function get_all_recursive_files( $dir, $file_types, $rel_path = '' ) {
		$files = array();
		
		if ( !is_array( $file_types ) ) {
			$file_types = array( $file_types );	
		}
				
		$d = opendir( $dir );
		if ( $d ) {
			while ( ( $f = readdir( $d ) ) !== false ) {
				if ( $f == '.' || $f == '..' || $f == '.svn' ) continue;
				
				if ( is_dir( $dir . '/' . $f ) ) {
					$files = array_merge( $files, $this->get_all_recursive_files( $dir . '/' . $f, $file_types, $rel_path . '/' . $f ) );	
				} else {					
					foreach( $file_types as $file_type ) {
						if ( strpos( $f, $file_type ) !== false ) {
							$files[] = $rel_path . '/' . $f;
							break;	
						}	
					}
				}
			}
			
			closedir( $d );	
		}
		
		return $files;	
	}
	
	function inject_dynamic_javascript() {
		$settings = $this->get_settings();		
		
		if ( isset( $this->get['wptouch_pro'] ) ) {
			switch( $this->get['wptouch_pro'] ) {
				case 'dismiss_welcome':
					setcookie( 'wptouch_welcome', '1', 0, '/' );
					$this->redirect_to_page( $this->get['redirect'] );
					
					break;
			}	
		} 
		
		$this->check_and_send_prowl_message();		
	}
	
	/*!		\brief Checks for a Prowl direct message request, and attempts to send it
	 *
	 *		This method checks for a theme-initiated Prowl direct message request, and attempts to send that message to all users represented
	 *		by the Prowl API keys defined in the settings.  Prowl messages are only sent if the \em push_prowl_api_keys setting is enabled.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */		
	function check_and_send_prowl_message() {		
		// Send Prowl direct message
		if ( isset( $this->post['prowl-submit'] ) ) {
			require_once( 'prowl.php' );		
		
			$settings = $this->get_settings();
					
			$this->prowl_tried_to_send_message = true;
			if ( wp_verify_nonce( $this->post['wptouch-prowl-nonce'], 'wptouch-prowl' ) ) {
				if ( isset( $settings->push_prowl_api_keys ) && count( $settings->push_prowl_api_keys) ) {
					foreach( $settings->push_prowl_api_keys as $api_key ) {			
						$prowl = new Prowl( $api_key, $settings->site_title );
						
						$title = sprintf( __( 'From %s (%s)', 'wptouch-pro' ), $this->post['prowl-msg-name'], $this->post['prowl-msg-email'] );
							
						$prowl->add( 1, __( 'Direct Message', 'wptouch-pro' ), $this->prowl_cleanup_message( $title . "\n\n" . $this->post['prowl-msg-message'] ) );	
					}
							
					$this->prowl_message_succeeded = true;	
				} else {
					WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Trying to send Prowl message without any API keys set' );	
				}
			} else {
				WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Unable to send Prowl direct message due to nonce failure' );
			}
		}		
	}

	/*!		\brief Creates a directory if it does not already exist
	 *
	 *		This method checks to see if a directory exists on disk.  If it does not, an attempt will be made to create it.
	 *
	 *		\param dir The directory to check and possibly create	 
	 *
	 *		\ingroup wptouchglobal
	 */			
	function create_directory_if_not_exist( $dir ) {
		if ( !file_exists( $dir ) ) {
			WPTOUCH_DEBUG( WPTOUCH_INFO, 'Creating directory ' . $dir );
			
			// Try and make the directory
			if ( !wp_mkdir_p( $dir ) ) {
				$this->directory_creation_failure = true;

				WPTOUCH_DEBUG( WPTOUCH_ERROR, 'Unable to create directory ' . $dir );
			}	
		}	
	}
	
	/*!		\brief Checks to make sure all the required WPtouch directories exist
	 *
	 *		This method checks to make sure all the required WPtouch directories exist, and if not, attempts to create them.	 
	 *
	 *		\ingroup wptouchglobal
	 */		
	function check_directories() {		
		$this->create_directory_if_not_exist( WPTOUCH_BASE_CONTENT_DIR );		
		$this->create_directory_if_not_exist( WPTOUCH_TEMP_DIRECTORY );
		$this->create_directory_if_not_exist( WPTOUCH_BASE_CONTENT_DIR . '/cache' );
		$this->create_directory_if_not_exist( WPTOUCH_BASE_CONTENT_DIR . '/themes' );	
		$this->create_directory_if_not_exist( WPTOUCH_BASE_CONTENT_DIR . '/modules' );
		$this->create_directory_if_not_exist( WPTOUCH_CUSTOM_SET_DIRECTORY );
		$this->create_directory_if_not_exist( WPTOUCH_CUSTOM_ICON_DIRECTORY );
		$this->create_directory_if_not_exist( WPTOUCH_CUSTOM_LANG_DIRECTORY );
		$this->create_directory_if_not_exist( WPTOUCH_DEBUG_DIRECTORY );
		
		if ( $this->directory_creation_failure ) {
			$this->add_warning( 
				__( "Directory Problem", "wptouch-pro" ), 
				__( "One or more required directories could not be created", "wptouch-pro" ),
				'http://www.bravenewcode.com/docs/wptouch-pro-docs/installation/troubleshooting/'
			);
		}
	}

	/*!		\brief Instructs WordPress on the length to use for excerpts
	 *
	 *		This is the main hook that instructs WordPress on the length to use for excerpts.  The default excerpt length is 24 words, and can be 
	 *		adjusted using the WordPress filter \em wptouch_excerpt_mode.	 
	 *
	 *		\returns The length of the excerpt in words
	 *
	 *		\ingroup wptouchglobal
	 */		
	function get_excerpt_length( $length ) {
		$settings = $this->get_settings();
		
		return apply_filters( 'wptouch_excerpt_length', 24 );	
	}
	
	/*!		\brief Instructs WordPress on the text to use for "more" in excerpts
	 *
	 *		This is the main hook that instructs WordPress what text to use for "more" in the excerpts.  The default text is " ...", and can be
	 *		adjusted using the WordPress filter \em wptouch_excerpt_more.
	 *
	 *		\returns A string representing the text to use for "more" in the excerpts
	 *
	 *		\ingroup wptouchglobal
	 */		
	function get_excerpt_more( $more ) {
		$settings = $this->get_settings();
		
		return apply_filters( 'wptouch_excerpt_more', ' ...' );		
	}
	
	function get_stylesheet( $stylesheet ) {
		// TODO: Remove
		if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
			return $stylesheet;	
		} else {
			return $stylesheet;
		}
	}
	
	/*!		\brief Used to instruct WordPress which device class to use for the theme
	 *
	 *		This is the main hook that instructs WordPress which device class to use in the current theme, i.e. iphone, blackberry, ipad, etc.
	 *
	 *		\param template The default template; passed in by WordPress
	 *
	 *		\returns The active device class if being used on a mobile device
	 *
	 *		\ingroup wptouchglobal
	 */		
	function get_template( $template ) {
		$settings = $this->get_settings();
		
		if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
			return $this->get_active_device_class();	
		} else {
			return $template;
		}		
	}
	
	/*!		\brief Used to instruct WordPress which theme directory to use
	 *
	 *		This is the main hook that instructs WordPress to use a particular theme directory.
	 *
	 *		\returns A string representing the directory of the active theme
	 *
	 *		\ingroup wptouchglobal
	 */			
	function get_theme_root() {
		$settings = $this->get_settings();
		
		if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
			return WP_CONTENT_DIR . '/' . $settings->current_theme_location . '/' . $settings->current_theme_name;
		} else {
			return $template;
		}		
	}

	/*!		\brief Used to instruct WordPress which theme URL to use
	 *
	 *		This is the main hook that instructs WordPress to use a particular theme URL.
	 *
	 *		\returns A string representing the URL to the active theme
	 *
	 *		\ingroup wptouchglobal
	 */		
	function get_theme_root_uri() {
		$settings = $this->get_settings();
				
		if ( $this->is_mobile_device && $this->showing_mobile_theme ) {
			return WP_CONTENT_URL . '/' . $settings->current_theme_location . '/' . $settings->current_theme_name;
		} else {
			return $template;
		}		
	}	

	/*!		\brief Loads a file from disk
	 *
	 *		This method loads a file from diskk
	 *
	 *		\returns The contents of the file loaded from disk, otherwise an empty string
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup helpers
	 */		
	function load_file( $file_name ) {
		$contents = '';
		
		$f = fopen( $file_name, 'rb' );
		if ( $f ) {
			while ( !feof( $f ) ) {
				$new_contents = fread( $f, 8192 );
				$contents = $contents . $new_contents;	
			}
			
			fclose( $f );
		}
		
		return $contents;	
	}
	
	/*!		\brief Returns a the active theme directory
	 *
	 *		This method returns the directory of the active theme directory
	 *
	 *		\returns A string representing the active theme directory
	 *
	 *		\ingroup wptouchglobal
	 */			
	function get_current_theme_directory() {
		return WP_CONTENT_DIR . $this->get_current_theme_location();
	}
	
	/*!		\brief Returns a valid URL to the active theme directory.
	 *
	 *		This method returns a valid URL to the active theme directory.
	 *
	 *		\returns A string representing the active theme directory's URL
	 *
	 *		\ingroup wptouchglobal
	 */			
	function get_current_theme_uri() {
		return WP_CONTENT_URL . $this->get_current_theme_location();	
	}
	
	/*!		\brief Used to determine the current theme name
	 *
	 *		This method returns the current theme name, for example \em Classic.
	 *
	 *		\returns A string representing the currently activated theme name
	 *
	 *		\ingroup wptouchglobal
	 */			
	function get_current_theme() {
		$settings = $this->get_settings();
		
		return $settings->current_theme_name;		
	}
	
	/*!		\brief Used to determine the current theme location
	 *
	 *		This method returns the current theme location.  It does not take into account the mobile device class.  For example
	 *		this method will return ../themes/theme-name instead of ../themes/theme-name/iphone.  This location is relative to the user's
	 *		\em wp-content directory.
	 *
	 *		\returns A string representing the currently activated theme location.
	 *
	 *		\ingroup wptouchglobal
	 */			
	function get_current_theme_location() {
		$settings = $this->get_settings();
		
		return $settings->current_theme_location . '/' . $settings->current_theme_name;			
	}
	
	/*!		\brief Adds the heading information to the HEAD area of the active mobile theme
	 *
	 *		This method is called internally to add the HEAD information for the currently active mobile theme.  The main style.css is added,
	 *		the currently active skin, the CSS files that were added using enqueue_css, and the iPhone bookmark icon.
	 *
	 *		The CSS files can be filtered using the WordPress filter \em wptouch_theme_css_files, and the bookmark icon HTML code can be
	 *		filtered using the WordPress filter \em wptouch_bookmark_meta.
	 *
	 *		\ingroup wptouchglobal
	 */		
	function add_mobile_header_info() {
		$settings = $this->get_settings();
		
		// Add the default stylesheet to the end, use min if available
		$minfile = WP_CONTENT_DIR . $settings->current_theme_location . '/' . $settings->current_theme_name . '/iphone/style-min.css';
		if ( file_exists( $minfile ) ) {		
			$this->css_files[] = wptouch_get_bloginfo( 'template_directory' ) . '/style-min.css';
		} else {
			$this->css_files[] = wptouch_get_bloginfo( 'template_directory' ) . '/style.css';
		}
		// Check for an active skin
		if ( $settings->current_theme_skin != 'none' ) {
			$current_theme = $this->get_current_theme_info();
			if ( isset( $current_theme->skins[ $settings->current_theme_skin ] ) ) {
				$this->css_files[] = $current_theme->skins[ $settings->current_theme_skin ]->skin_url;	
			}
		}
		
		$this->css_files = apply_filters( 'wptouch_theme_css_files', $this->css_files );
		
		foreach( $this->css_files as $css ) {
			echo "<link rel='stylesheet' type='text/css' media='screen' href='$css' />\n";	
		}
		
		if ( $settings->glossy_bookmark_icon ) {
			$bookmark_icon = "<link rel='apple-touch-icon' href='" . wptouch_get_site_menu_icon( WPTOUCH_ICON_BOOKMARK ) . "' />\n";
		} else {
			$bookmark_icon = "<link rel='apple-touch-icon-precomposed' href='" . wptouch_get_site_menu_icon( WPTOUCH_ICON_BOOKMARK ) . "' />\n";
		}
		
		echo apply_filters( 'wptouch_bookmark_meta', $bookmark_icon );
	}
	
	/*!		\brief Determines the name of the current WPtouch theme skin
	 *
	 *		This method can be used to determine the name of the currently active WPtouch theme skin.
	 *
	 *		\returns A string representing the name of the skin, or false if no skin is active
	 *
	 *		\ingroup wptouchglobal
	 */		
	function get_current_theme_skin() {
		$settings = $this->get_settings();
		
		if ( $settings->current_theme_skin != 'none' ) {
			return $settings->current_theme_skin;
		} else {
			return false;	
		}	
	}
	
	/*!		\brief Checks the user agent and COOKIE to see which type of theme should be shown. 
	 *
	 *		This method is called internally to check the user agent and COOKIE value to see which type of theme should be shown, desktop
	 *		or mobile.  The \em wptouch_switch COOKIE is checked to determine if the user has previously selected the type of theme they would want, 
	 *		and the user agent of the device is also checked.  This method calls is_supported_device() to
	 *		determine whether or not the user's browser is supported by the active WPtouch theme.
	 *
	 *		\ingroup wptouchglobal
	 */		
	function check_user_agent() {	
		// check and set cookie
		if ( isset( $this->get['wptouch_switch'] ) ) {
			setcookie( WPTOUCH_COOKIE, $this->get['wptouch_switch'] );
			$this->redirect_to_page( $this->get['redirect'] );
		}
		
		// If we're in the admin, we're not a mobile device
		if ( is_admin() ) {
			$this->is_mobile_device = false;
			$this->showing_mobile_theme = false;
			
			return;	
		}
		
		$this->is_mobile_device = $this->is_supported_device();		
		
		if ( $this->is_mobile_device ) {
			if ( !isset( $_COOKIE[ WPTOUCH_COOKIE ] ) ) {
				$settings = $this->get_settings();
				
				if ( $settings->desktop_is_first_view ) {
					// Show desktop theme initially
					$this->showing_mobile_theme = false;	
				} else {
					$this->showing_mobile_theme = true;	
				}
			} else {
				// If Cookie is set, check value
				if ( $_COOKIE[WPTOUCH_COOKIE] === 'mobile' ) {
					$this->showing_mobile_theme = true;
				} else {
					$this->showing_mobile_theme = false;
				}
			}
		}
		
		// Add switch link for desktop
		if ( !$this->showing_mobile_theme && $this->is_mobile_device ) {
			add_action( 'wp_footer', array( &$this, 'show_desktop_switch_link' ) );	
			add_action( 'wp_head', array( &$this, 'include_desktop_switch_css' ) );
		}
	}
	
	/*!		\brief Adds the desktop switch HTML to the desktop theme	 
	 *
	 *		This method is called internally to add the HTML code for the desktop to mobile switching.  It currently reads HTML from a file in the include/html 
	 *		directory called desktop-switch.php.  The HTML code can be modified using the WordPress filter \em wptouch_desktop_switch_html.
	 *
	 *		\ingroup wptouchglobal
	 */		
	function show_desktop_switch_link() {
		if ( file_exists( get_wptouch_directory() . '/include/html/desktop-switch.php' ) ) {
			ob_start();
			include( get_wptouch_directory() . '/include/html/desktop-switch.php' );
			$switch_html = ob_get_contents();
			ob_end_clean();
			
			echo apply_filters( 'wptouch_desktop_switch_html', $switch_html );
		}
	}

	/*!		\brief Adds the CSS code for the switch link in the desktop theme	 
	 *
	 *		This method is called internally to add the CSS code for the switch link in the desktop theme
	 *
	 *		\ingroup wptouchglobal
	 */		
	function include_desktop_switch_css() {
		$settings = $this->get_settings();
		echo "<style type='text/css'>\n";	
		echo $settings->desktop_switch_css;	
		echo "</style>\n";	
	}

	/*!		\brief Verifies that the administration NONCE is valid
	 *
	 *		This method is called internally from process_submitted_settings() to verify that the administration nonces are valid.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */		
	function verify_post_nonce() {	 
		$nonce = $this->post['wptouch-admin-nonce'];
		if ( !wp_verify_nonce( $nonce, 'wptouch-post-nonce' ) ) {
			WPTOUCH_DEBUG( WPTOUCH_SECURITY, "Unable to verify WPtouch post nonce" );
			die( 'Unable to verify WPtouch post nonce' );	
		}		
		
		return true;
	}

	/*!		\brief Processes the submission of the settings form in the administration panel
	 *
	 *		This method is used internally to process the submitted settings.  It verifies that the security NONCE is valid and also that the proper
	 *		submit button was pressed.
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup admin
	 */			
	function process_submitted_settings() {
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			return;	
		}
		
		if ( isset( $this->post['wptouch-set-info-submit'] ) ) {
			$this->verify_post_nonce();
			
			// this is how we change the set information for a new set
			$settings = $this->get_settings();
			if ( isset( $settings->temp_icon_set_for_readme ) && strlen( $settings->temp_icon_set_for_readme ) ) {
				$f = fopen( $settings->temp_icon_set_for_readme, 'w+t' );
				if ( $f ) { 
					$set_name = $this->post['wptouch-set-name'];
					
					$set_info = "Name: {$set_name}\nDescription: {$set_name}\n";
					fwrite( $f, $set_info );
					fclose( $f );		
					
					$settings->temp_icon_set_for_readme = '';
					$this->save_settings( $settings );
				}
			}
		} else if ( isset( $this->post['wptouch-submit'] ) ) {
			$this->verify_post_nonce();
			
			$settings = $this->get_settings();
			
			// The license key information has changed
			if ( $settings->bncid != $this->post['bncid'] || $settings->wptouch_license_key != $this->post['wptouch_license_key'] ) {				
				// Clear the BNCID cache whenever we save information
				// will force a proper API call next load
				$settings->last_bncid_result = false;
				$settings->last_bncid_licenses = false;
				$settings->bncid_had_license = false;	
				
				$this->setup_bncapi();
				$this->bnc_api->invalidate_all_tokens();	
			}
						
			$settings->last_bncid_time = 0;	
			
			foreach( (array)$settings as $name => $value ) {
				if ( isset( $this->post[ $name ] ) ) {
					
					// Remove slashes if they exist
					if ( is_string( $this->post[ $name ] ) ) {						
						$this->post[ $name ] = htmlspecialchars_decode( $this->post[ $name ] );
					}	
					
					$settings->$name = apply_filters( 'wptouch_setting_filter_' . $name, $this->post[ $name ] );	
				} else {
					// Remove checkboxes if they don't exist as data
					if ( isset( $this->post[ $name . '-hidden' ] ) ) {
						$settings->$name = false;
					}
					
					// check to see if the hidden fields exist
					if ( isset( $this->post[ $name . '_1' ] ) ) {
						// this is an array field
						$setting_array = array();
						
						$count = 1;							
						while ( true ) {
							if ( !isset( $this->post[ $name . '_' . $count ] ) ) {
								break;	
							}	
							
							// don't add empty strings
							if ( $this->post[ $name . '_' . $count ] ) {
								$setting_array[] = $this->post[ $name . '_' . $count ];
							}
							
							$count++;
						}
						
						$settings->$name = $setting_array;	
					}
				}
			}
			
			if ( isset( $this->post['hidden-menu-items'] ) ) {
				$settings->disabled_menu_items = array();
				
				$disable_these = explode( ",", rtrim( $this->post['hidden-menu-items'], "," ) );
				
				if ( count( $disable_these ) ) {
					foreach( $disable_these as $menu_id ) {		
						if ( is_numeric( $menu_id ) ) {
							$settings->disabled_menu_items[ $menu_id ] = 1;
						}
					}	
				} 
				
				$settings->temp_disabled_menu_items = $settings->disabled_menu_items;		
			} 
			
			$settings->menu_icons = $settings->temp_menu_icons;

			$this->save_settings( $settings );
			
			do_action( 'wptouch_settings_saved' );
			
		} else if ( isset( $this->post['wptouch-submit-reset'] ) ) {
			$this->verify_post_nonce();
			
			// rove the setting from the DB
			update_option( WPTOUCH_SETTING_NAME, false );
			$this->settings = false;
		} else {
			// This code path is probably dead now
			WPTOUCH_DEBUG( WPTOUCH_WARNING, "Shouldn't be here" );
		
			$settings = $this->get_settings();
			$do_redirect = false;
						
			// Reset the menu icons in the back panel 
			$settings->temp_menu_icons = $settings->menu_icons;
			$settings->temp_disabled_menu_items = $settings->disabled_menu_items;
										
			$this->save_settings( $settings );
			
			if ( $do_redirect ) {
				$this->redirect_to_page( $_SERVER['REQUEST_URI'] );
			}
		}		
	}

	/*!		\brief Determines how many copies of a particular theme exist
	 *
	 *		This method is used internally to determine the number of copies that exist for a theme.  This number is then used to update
	 *		the theme name when it is copied such that no two themes will have the same name.
	 *
	 *		\param base The base theme name, for example "skeleton".
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup helpers
	 */				
	function get_theme_copy_num( $base ) {
		$num = 1;
		while( true ) {
			if ( !file_exists( WPTOUCH_CUSTOM_THEME_DIRECTORY . '/' . $base . '-copy-' . $num ) ) {
				break;
			}	
			
			$num++;
		}	
		
		return $num;
	}

	/*!		\brief Saves the WPtouch Pro settings object into the WordPress database
	 *
	 *		This method will save the settings object into the WordPress database. Modification of the settings object itself does not result in 
	 * 		persistent settings changes - this method must be called after all modifications are made.
	 *
	 *		\param settings The settings object to save to the database
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup settings
	 */			
	function save_settings( $settings ) {
		$settings = apply_filters( 'wptouch_update_settings', $settings );

		$serialized_data = serialize( $settings );
				
		update_option( WPTOUCH_SETTING_NAME, $serialized_data );	
		
		$this->settings = $settings;
	}

	/*!		\brief Enqueues a CSS file for use in a WPtouch Pro mobile theme.
	 *
	 *		This method will enqueue CSS files.  Currently this method just results in the CSS files being injected into the header of a mobile theme,
	 *		but will hopefully cause CSS files to be merged and optimized in future versions of WPtouch Pro.
	 *
	 *		\param css The URL for the CSS file
	 *
	 *		\ingroup wptouchglobal
	 */		
	function enqueue_css( $css ) {
		$this->css_files[] = $css;	
	}
	
	/*!		\brief Converts a full URL into a relative URL
	 *
	 *		This method is called internally to convert long URLs into short URLs that are relative to the user's home URL
	 *
	 *		\param url The long URL, usually contains http://
	 *
	 *		\returns A short URL relative to the user's home directory.  For example, http://somesite.com/somelink will become /somelink.
	 *
	 *		\ingroup wptouchglobal
	 */			
	function convert_to_internal_url( $url ) {
		$settings = $this->get_settings();
		if ( !$settings->convert_menu_links_to_internal ) {
			// If the user has disabled converting links to internal URLs
			// simply return the default URL
			return $url;
		}
		
		
		$home = rtrim( get_bloginfo( 'home' ), "/" );		
		$url_info = parse_url( $home );
		
		if ( isset( $url_info['scheme'] ) && isset( $url_info['host'] ) ) {
			$root_location = $url_info['scheme'] . '://' . $url_info['host'];
			
			$new_url = str_replace( $root_location, '', $url );	
			
			if ( strlen( $new_url ) == 0 ) {
				$new_url = "/";
			}
		
			return $new_url;
		} else {
			return $url;
		}	
	}

	/*!		\brief Used to determine the URL for an existing icon
	 *
	 *		This method is called internally to determine the URL for an existing icon	 
	 *
	 *		\param short_icon_name The parital path for the existing icon.  Must be relative to the user's wp-content directory.
	 *
	 *		\returns The full URL for the icon if it exists, otherwise false
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup iconssets
	 */		
	function get_url_for_this_icon( $short_icon_name ) {
		if ( file_exists( get_wptouch_directory() . '/resources/icons/sets/' . $short_icon_name ) ) {
			return get_wptouch_url() . '/resources/icons/sets/' . $short_icon_name;
		}
	}
	
	/*!		\brief Checks to see if a Prowl API key is valid
	 *
	 *		This method is called internally to determine if a Prowl API key is valid.  It contacts the Prowl
	 *		server using the API.
	 *
	 *		\param api_key The api_key to check
	 *
	 *		\returns true if the API key is valid, otherwise false
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */	
	function prowl_is_key_valid( $api_key ) {
		require_once( 'prowl.php' );		
		
		$settings = $this->get_settings();
			
		if ( $api_key ) {
			$prowl = new Prowl( $api_key, $settings->site_title );	
			
			$verify = $prowl->verify();
			
			if ( !$verify ) {
				WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Unable to verify Prowl API Key: ' . $api_key );	
			}
			
			return ( $verify === true );
		}
		
		return false;
	}
	
	/*!		\brief Performs sanitation on Prowl messages prior to them being sent	 
	 *
	 *		This method is called internally to clean up outgoing Prowl messages by removing redundant carriage returns.
	 *
	 *		\param msg The pre-sanitized message
	 *
	 *		\returns The sanitized version of the message
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */		
	function prowl_cleanup_message( $msg ) {
		$msg = str_replace( "\r\n", "\n", $msg );
		$msg = str_replace( "\r", "\n", $msg );
		return $msg;	
	}	
	
	/*!		\brief Sends a Prowl message to all API keys that the user has defined and are valid	 
	 *
	 *		This method is called internally to send all Prowl messages to the user.  If the user has defined multiple
	 *		Prowl API keys, a message is sent to each of them.
	 *
	 *		\param title The title for the Prowl message
	 *		\param message The message body for the Prowl message.  This message is sanitized using prowl_cleanup_message() prior to being sent.
	 *
	 *		\returns True if the message was delivered, false otherwise
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */			
	function prowl_send_prowl_message( $title, $message ) {
		require_once( 'prowl.php' );		
		
		$settings = $this->get_settings();
				
		if ( isset( $settings->push_prowl_api_keys ) && count( $settings->push_prowl_api_keys ) ) {
			$succeeded = true;
			
			foreach( $settings->push_prowl_api_keys as $api_key ) {			
				$prowl = new Prowl( $api_key, $settings->site_title );
					
				$succeeded = $succeeded && $prowl->add( 1, $title, $this->prowl_cleanup_message( $message ) );		
			}
			
			return $succeeded;
		} else {
			WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Trying to send Prowl message without any API keys set' );
			
			return false;	
		}
	}	
	
	/*!		\brief Handles Prowl messages for new comments	 
	 *
	 *		This method is called internally to determine whether or not a new comment will cause a Prowl message to be sent.  If the user has defined
	 *		one or more Prowl API keys, and has enabled the \em push_prowl_comments_enabled setting, then Prowl notifications will be sent to all users represented
	 *		by the Prowl API keys.
	 *
	 *		\param comment_id The comment ID for the new comment
	 *		\param approval_status The approval status for the new comment
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */		
	function prowl_handle_new_comment( $comment_id, $approval_status = '1' ) {
		require_once( 'prowl.php' );
		
		$settings = $this->get_settings();
		
		if ( $approval_status != 'spam' && count( $settings->push_prowl_api_keys ) && $settings->push_prowl_comments_enabled ) {
				
			foreach( $settings->push_prowl_api_keys as $api_key ) {
			
				$comment = get_comment( $comment_id );
				$prowl = new Prowl( $api_key, $settings->site_title );
								
				if ( $comment->comment_type != 'spam' && $comment->comment_approved != 'spam' ) {
					if ( $comment->comment_type == 'trackback' || $comment->comment_type == 'pingback' ) {
						$result = $prowl->add( 	1, 
							__( "New Ping/Trackback", "wptouch-pro" ),
							sprintf( 
								__( "From: %s", "wptouch-pro" ) . "\n" . __( "Post: %s", "wptouch-pro" ), 
								$this->prowl_cleanup_message( stripslashes( $comment->comment_author ) ),
								$this->prowl_cleanup_message( stripslashes( $comment->comment_content ) ) 
							)
						);			
				 	} else {
						$result = $prowl->add( 	1, 
							__( "New Comment", "wptouch-pro" ),
							sprintf( 
								__( "Name: %s", "wptouch-pro" ) . "\n" . __( "Email: %s", "wptouch-pro" ) . "\n" . __( "Comment: %s", "wptouch-pro" ), 
								$this->prowl_cleanup_message( stripslashes( $comment->comment_author ) ), 
								$this->prowl_cleanup_message( stripslashes( $comment->comment_author_email ) ),
								$this->prowl_cleanup_message( stripslashes( $comment->comment_content ) )
							)
						);		 
				 	}
				}
			}
		 }
	}	
	
	/*!		\brief Performs a recursive copy from one directory to another
	 *
	 *		This method can be used to recursively copy an entire directory. 
	 *
	 *		\param source_dir The source directory for the copy.
	 *		\param dest_dir The destination directory for the copy. This directory will be created if it does not exist.  
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup files
	 */			
	function recursive_copy( $source_dir, $dest_dir ) {
		$src_dir = @opendir( $source_dir );
		if ( $src_dir ) {
			while ( ( $f = readdir( $src_dir ) ) !== false ) {
				if ( $f == '.' || $f == '..' ) {
					continue;
				}		
				
				$cur_file = $source_dir . '/' . $f;
				if ( is_dir( $cur_file ) ) {
					if ( !wp_mkdir_p( $dest_dir . '/' . $f ) ) {
						WPTOUCH_DEBUG( WPTOUCH_WARNING, "Unable to create directory " . $dest_dir . '/' . $f );	
					}
					
					$this->recursive_copy( $source_dir . '/' . $f, $dest_dir . '/' . $f );
				} else {
					$dest_file = $dest_dir . '/' . $f;
					
					$src = fopen( $cur_file, 'rb' );
					if ( $src ) {
						$dst = fopen( $dest_file, 'w+b' );
						if ( $dst ) {
							while ( !feof( $src ) ) {
								$contents = fread( $src, 8192 );
								fwrite( $dst, $contents );
							}	
							fclose( $dst );	
						} else {
							WPTOUCH_DEBUG( WPTOUCH_ERROR, 'Unable to open ' . $dest_file . ' for writing' );	
						}
						
						fclose( $src );
					} else {
						WPTOUCH_DEBUG( WPTOUCH_ERROR, 'Unable to open ' . $cur_file . ' for reading' );
					}
				}	
			}
			
			closedir( $src_dir );	
		}
	}

	/*!		\brief Performs a recursive delete on a directory
	 *
	 *		This method can be used to recursively delete a directory.  Care must be taken when using this method, as it 
	 *		will completely remove all nested subdirectories.
	 *
	 *		\param source_dir The directory to completely remove
	 *
	 *		\note Will only delete directories located off of the base WPtouch Pro content directory
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup files
	 */		
	function recursive_delete( $source_dir ) {
		// Only allow a delete to occur for directories in the main WPtouch data directory
		if ( strpos( $source_dir, '..' ) !== false || strpos( $source_dir, WPTOUCH_BASE_CONTENT_DIR ) === false ) {
			WPTOUCH_DEBUG( WPTOUCH_SECURITY, 'Not deleting directory ' . $source_dir . ' due to possibly security risk' );
			return;
		}
		
		$src_dir = @opendir( $source_dir );
		if ( $src_dir ) {
			while ( ( $f = readdir( $src_dir ) ) !== false ) {
				if ( $f == '.' || $f == '..' ) {
					continue;
				}		
				
				$cur_file = $source_dir . '/' . $f;
				if ( is_dir( $cur_file ) ) {
					$this->recursive_delete( $cur_file );
					@rmdir( $cur_file );
				} else {
					@unlink( $cur_file );
				}	
			}
			
			closedir( $src_dir );
			
			@rmdir( $src_dir );	
		}
	}	

	/*!		\brief Checks to see if a new user should be sent out using a Prowl notification
	 *
	 *		This method is called internally to attempt a Prowl notification for a new user.  A Prowl notification is only sent 
	 *		if the user has defined one or more valid Prowl API keys and the setting \em push_prowl_registrations is enabled.
	 *
	 *		\param user_id The user_id of the new user
	 *
	 *		\ingroup wptouchglobal
	 *		\ingroup prowl
	 */	
	function prowl_handle_new_user( $user_id ) {
		require_once( 'prowl.php' );
			
		global $wpdb;			
		global $table_prefix;		
			
		$settings = $this->get_settings();
		
		if ( count( $settings->push_prowl_api_keys ) && $settings->push_prowl_registrations ) {		
			foreach( $settings->push_prowl_api_keys as $api_key ) {
				$user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $table_prefix . "users WHERE ID = %d", $user_id ) );
				
				if ( $user ) {
					$prowl = new Prowl( $api_key, $settings->site_title );	
					$result = $prowl->add( 	1, 
						__( "User Registration", "wptouch-pro" ),
						sprintf( 
							__( "Name: %s", "wptouch-pro" ) . "\n" . __( "Email: %s", "wptouch-pro" ),
							$this->wptouch_cleanup_growl( stripslashes( $user->user_login ) ),
							$this->wptouch_cleanup_growl( stripslashes( $user->user_email ) )
						)
					);			
				}
			}
		}
	}	
}

/*!		\brief Echos the current directory for WPtouch Pro
 *
 *		This method can be used to echo the current WPtouch Pro directory. Internally this method calls get_wptouch_directory().
 *
 *		\ingroup wptouchglobal
 */
function wptouch_directory() {
	echo get_wptouch_directory();
}

/*!		\brief Retrieves the current directory for WPtouch Pro
 *
 *		This method can be used to retrieve the current WPtouch Pro directory
 * 
 *		\returns A string containing the directory on disk for the main WPtouch Pro directory
 *
 *		\ingroup wptouchglobal
 */
function get_wptouch_directory() {
	return WPTOUCH_DIR;
}

/*!		\brief Echos the URL for the main WPtouch Pro directory
 *
 *		This method can be used to echo the current URL for the WPtouch Pro directory. Internally this method calls get_wptouch_url().
 *
 *		\ingroup wptouchglobal
 */
function wptouch_url() {
	echo get_wptouch_url();
}

/*!		\brief Returns the URL for the main WPtouch Pro  directory
 *
 *		This method can be used to determine the URL for the WPtouch Pro  directory. 
 * 
 *		\returns A string representing the URL
 *
 *		\ingroup wptouchglobal
 */
function get_wptouch_url() {
	return WPTOUCH_URL;	
}

/*!		\brief Can be used to enqueue a CSS script from WPtouch.
 *
 *		This method can be used to enqueue a CSS script from WPtouch.  CSS scripts will hopefully be merged into one in future
 *		releases of WPtouch Pro.
 * 
 *		\param css_url The full URL of the CSS file the should be added
 *
 *		\ingroup wptouchglobal
 */
function wptouch_enqueue_css( $css_url ) {
	global $wptouch_pro;
	$wptouch_pro->enqueue_css( $css_url );	
}

/*!		\brief A substitute for WordPress' bloginfo function.
 *
 *		The method echos a configuration parameter for WPtouch.  If the parameter isn't WPtouch specific, the WordPress configuration 
 *		parameter will be returned.  Internally this function calls wptouch_get_bloginfo().
 * 
 *		\param setting_name The associated setting name to retrieve.  Please see wptouch_get_bloginfo() for a complete list.
 *
 *		\returns The associated setting parameter
 *
 *		\ingroup wptouchglobal
 */
function wptouch_bloginfo( $setting_name ) {
	echo wptouch_get_bloginfo( $setting_name );
}

/*!		\brief A substitute for WordPress' get_bloginfo function.
 *
 *		The method returns a configuration parameter for WPtouch.  If the parameter isn't WPtouch specific, the WordPress configuration 
 *		parameter will be returned.
 * 
 *		\param setting_name The associated setting name to retrieve.  The currently supported parameters are:
 *		\arg \c template_directory The currently active WPtouch theme directory
 *		\arg \c template_url Same as template_directory
 *		\arg \c max_upload_size The maximum upload size supported on the server
 *		\arg \c wptouch_directory The current server directory for WPtouch
 *		\arg \c wptouch_url The URL associated with the current WPtouch directory on the server
 *		\arg \c version The currently version for WPtouch Pro
 *		\arg \c theme_count The number of currently installed themes
 *		\arg \c icon_set_count The number of currently installed icon sets
 *		\arg \c icon_count The number of available icons
 *		\arg \c support_licenses_remaining The number of remaining support and upgrade licenses
 *		\arg \c active_theme_friendly_name The currently active theme's friendly name
 *		\arg \c rss_url The WPtouch Pro RSS feed URL.  Takes into account the user's custom settings
 *		\arg \c warnings The number of WPtouch Pro compatibility warnings
 *		\arg \c siteurl If a custom redirect target is enabled, it returns that, otherwise the default WordPress siteurl
 *		\arg \c theme_root_directory The root theme directory for the current theme
 *
 *		\note All other parameters are proxied to get_bloginfo, and will return the WordPress configuration parameters. 
 *
 *		\returns The associated setting parameter
 *		
 *		\ingroup wptouchglobal
 */
function wptouch_get_bloginfo( $setting_name ) {
	global $wptouch_pro;
	$settings = $wptouch_pro->get_settings();
	
	$setting = false;
	
	switch( $setting_name ) {
		case 'template_directory':
		case 'template_url':
			$setting = $wptouch_pro->get_current_theme_uri() . '/' . $wptouch_pro->get_active_device_class();
			break;
		case 'theme_root_directory':
			$setting = $wptouch_pro->get_current_theme_directory();
			break;
		case 'max_upload_size':
			$setting = $wptouch_pro->get_max_upload_size();	
			break;
		case 'site_title':
			$setting = $settings->site_title;
			break;
		case 'wptouch_directory':
			$setting = get_wptouch_directory();
			break;
		case 'wptouch_url':
			$setting = get_wptouch_url();
			break;
		case 'version':
			$setting = WPTOUCH_VERSION;
			break;
		case 'theme_count':
			$themes = $wptouch_pro->get_available_themes();
			$setting = count( $themes );
			break;
		case 'icon_set_count':
			$icon_sets = $wptouch_pro->get_available_icon_packs();
			// Remove the custom icon count
			$setting = count( $icon_sets ) - 1;
			break;
		case 'icon_count':
			$icon_sets = $wptouch_pro->get_available_icon_packs();
			$total_icons = 0;	
			foreach( $icon_sets as $setname => $set ) {
				if ( $setname == "Custom Icons" ) continue;
				
				$icons = $wptouch_pro->get_icons_from_packs( $setname );
				$total_icons += count( $icons );
			}
			$setting = $total_icons;
			break;
		case 'support_licenses_remaining':
			$licenses = $wptouch_pro->bnc_api->user_list_licenses( 'wptouch-pro' );
			if ( $licenses ) {
				$setting = $licenses['remaining'];	
			} else {
				$setting = 0;	
			}
			break;
		case 'active_theme_friendly_name':
			$setting = $settings->current_theme_friendly_name;
			break;
		case 'rss_url':
			if ( $settings->menu_custom_rss_url ) {
				$setting = $settings->menu_custom_rss_url;	
			} else {
				$setting = get_bloginfo( 'rss2_url' );
			}
			break;
		case 'warnings':
			$setting = wptouch_get_plugin_warning_count();
			break;
		case 'siteurl':
			if ( $settings->enable_home_page_redirect ) {
				$setting = get_permalink( $settings->home_page_redirect_target );
			} else {
				$setting = get_bloginfo( $setting_name );	
			}
			break;
		default:
			// proxy other values to the original get_bloginfo function
			$setting = get_bloginfo( $setting_name );
			break;	
	}
	
	return $setting;	
}

/*!		\brief Retrives the WPtouch Pro settings object
 *
 *		This method can be used to retrieve the WPtouch Pro settings object.
 * 
 *		\returns The WPtouch Pro settings object
 *
 *		\ingroup wptouchglobal
 *		\ingroup settings
 */
function wptouch_get_settings() {
	global $wptouch_pro;
	
	return $wptouch_pro->get_settings();	
}

/*!		\brief Saves the WPtouch Pro settings object to the database
 *
 *		This method can be used to save the WPtouch Pro settings object to the database.  Internally this method calls WPtouchPro::save_settings().
 *
 *		\param settings The settings object to save
 *
 *		\par Typical Usage:
 *		\include save-settings.php
 *
 *		\ingroup wptouchglobal
 *		\ingroup settings
 */
function wptouch_save_settings( $settings ) {
	global $wptouch_pro;
	
	$wptouch_pro->save_settings( $settings );	
}

/*!		\brief Retrieves an AJAX parameter for a client-side AJAX call
 *
 *		This method can be used to retrive a client-side AJAX parameter for AJAX routines that are initiaited from the JS function WPtouchAjax.
 *
 *		\param name The AJAX parameter name to retreive
 *
 *		\returns The AJAX parameter, or false is it has not been set
 *
 *		\ingroup wptouchglobal
 */
function wptouch_get_ajax_param( $name ) {
	global $wptouch_pro;
	
	if ( isset( $wptouch_pro->post[ $name ] ) ) {
		return $wptouch_pro->post[ $name ];	
	}
	
	return false;	
}

/*!		\brief Echos the AJAX parameter for a client-side AJAX call
 *
 *		This method can be used to echo a client-side AJAX parameter for AJAX routines that are initiaited from the JS function WPtouchAjax.
 *
 *		\param name The AJAX parameter name to retreive
 *
 *		\ingroup wptouchglobal
 */
function wptouch_the_ajax_param( $name ) {
	global $wptouch_pro;
	
	if ( isset( $wptouch_pro->post[ $name ] ) ) {
		return $wptouch_pro->post[ $name ];	
	}
	
	return false;	
}

/*!		\brief Determines whether or not WordPress 3.x is in multisite mode
 *
 *		This method can be used to determine whether or not WordPress 3.x is configured in multisite mode.
 *
 *		\version 2.0.5
 *		\ingroup wptouchglobal
 */
function wptouch_is_multisite_enabled() {
	return ( defined( 'MULTISITE' ) );
}

/*!		\brief Determines whether or not the primary site in a WordPress 3.x multisite install is showing
 *
 *		This method can be used to determine the primary site in a WordPress 3.x multisite install is showing
 *
 *		\version 2.0.5
 *		\ingroup wptouchglobal
 */
function wptouch_is_multisite_primary() {
	global $blog_id;
	return ( $blog_id == 1 );
}	

/*!		\brief Determines whether or not the restoration key was valid
 *
 *		This method can be used to determine whether or not the restoration key in the backup/restore section was valid.
 *
 *		\version 2.0.7
 *		\ingroup wptouchglobal
 */
function wptouch_restore_failed() {
	global $wptouch_pro;
	return ( $wptouch_pro->restore_failure );
}

?>