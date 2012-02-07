<?php

//! Set this to 'true' to enable debugging
define( 'WPTOUCH_DEBUG', false );

//! Set this to 'true' to enable simulation of all warnings and conflicts
define( 'WPTOUCH_SIMULATE_ALL', false );

// Set up beta variable
if ( strpos( dirname( __FILE__), "/wptouch-pro-beta/" ) !== false ) {
	define( 'WPTOUCH_PRO_BETA', true );	
	define( 'WPTOUCH_ROOT_DIR', 'wptouch-pro-beta' );
} else {
	define( 'WPTOUCH_PRO_BETA', false );	
	define( 'WPTOUCH_ROOT_DIR', 'wptouch-pro' );
}

//! The key in the database for the WPtouch settings
if ( WPTOUCH_PRO_BETA ) {
	define( 'WPTOUCH_SETTING_NAME', 'wptouch-pro-beta' );
	define( 'WPTOUCH_DIR', WP_PLUGIN_DIR . '/wptouch-pro-beta' );	
	define( 'WPTOUCH_URL', WP_PLUGIN_URL . '/wptouch-pro-beta' );
	define( 'WPTOUCH_PRODUCT_NAME', 'WPtouch Pro Beta' );
} else {
	define( 'WPTOUCH_SETTING_NAME', 'wptouch-pro' );
	define( 'WPTOUCH_DIR', WP_PLUGIN_DIR . '/wptouch-pro' );
	define( 'WPTOUCH_URL', WP_PLUGIN_URL . '/wptouch-pro' );
	define( 'WPTOUCH_PRODUCT_NAME', 'WPtouch Pro' );
}

//! The WPtouch Pro user cookie
define( 'WPTOUCH_COOKIE', 'wptouch-pro-view' );
define( 'WPTOUCH_BNCID_CACHE_TIME', 3600 );
define( 'BNC_WPTOUCH_UNLIMITED', 9999 );

define( 'WPTOUCH_ADMIN_DIR', WPTOUCH_DIR . '/admin' );
define( 'WPTOUCH_ADMIN_AJAX_DIR', WPTOUCH_ADMIN_DIR . '/html/ajax' );
define( 'WPTOUCH_BASE_CONTENT_DIR', WP_CONTENT_DIR . '/wptouch-data' );
define( 'WPTOUCH_BASE_CONTENT_URL', WP_CONTENT_URL . '/wptouch-data' );

define( 'WPTOUCH_TEMP_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR . '/temp' );
define( 'WPTOUCH_CUSTOM_SET_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR .'/icons' );		
define( 'WPTOUCH_CUSTOM_ICON_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR . '/icons/custom' );
define( 'WPTOUCH_CUSTOM_THEME_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR .'/themes' );
define( 'WPTOUCH_CUSTOM_LANG_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR .'/lang' );

define( 'WPTOUCH_DEBUG_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR . '/debug' );
define( 'WPTOUCH_CACHE_DIRECTORY', WPTOUCH_BASE_CONTENT_DIR . '/cache' );

define( 'WPTOUCH_CACHE_URL', WPTOUCH_BASE_CONTENT_URL . '/cache' );
define( 'WPTOUCH_CUSTOM_ICON_URL', WPTOUCH_BASE_CONTENT_URL .'/icons/custom' );

global $wptouch_menu_items; 		//! the built menu item tree
global $wptouch_menu_iterator; 		//! the iterator for the main menu
global $wptouch_menu_item;			//! the current menu item

global $wptouch_icon_pack;
global $wptouch_icon_packs;
global $wptouch_icon_packs_iterator;

$wptouch_icon_pack = false;
$wptouch_icon_packs = false;
$wptouch_icon_packs_iterator = false;

// These all need to be negative so as not to conflict with real page numbers
define( 'WPTOUCH_ICON_HOME', -1 );
define( 'WPTOUCH_ICON_BOOKMARK', -2 );
define( 'WPTOUCH_ICON_DEFAULT', -3 );
define( 'WPTOUCH_ICON_EMAIL', -4 );
define( 'WPTOUCH_ICON_RSS', -5 );
define( 'WPTOUCH_ICON_CUSTOM_1', -101 );
define( 'WPTOUCH_ICON_CUSTOM_2', -102 );
define( 'WPTOUCH_ICON_CUSTOM_3', -103 );
define( 'WPTOUCH_ICON_CUSTOM_PAGE_TEMPLATES', -500 );

global $wptouch_device_classes;
$wptouch_device_classes[ 'iphone' ] = array( 
	'iphone', 
	'ipod', 
	'aspen', 
	'incognito', 
	'webmate', 
	'android', 
	'dream', 
	'cupcake', 
	'froyo', 
	'blackberry9500', 
	'blackberry9520', 
	'blackberry9530', 
	'blackberry9550', 
	'blackberry9800', 
	'webos',
	's8000', 
	'bada'
);
?>