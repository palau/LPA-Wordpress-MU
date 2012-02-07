<?php
/**
 * Admin Functions
 *
 * @package WordPress
 * @subpackage Debut
 * @since 3.0
 */
 
 
function ti_setup_theme_admin() {
	include_once ti_ADMINPATH . '/theme-styles.php';
	include_once ti_ADMINPATH . '/theme-tinymce.php';
	include_once ti_ADMINPATH . '/theme-widgets.php';
	
	/* WordPress Core. */
	add_action( 'admin_notices',        'ti_of_admin_notice' );
	add_action( 'admin_init',           'ti_of_nag_ignore' );
	add_filter( 'login_headertitle',    'ti_login_headertitle' );
	add_filter( 'login_headerurl',      'ti_login_headerurl' );
	add_filter( 'tiny_mce_before_init', 'ti_tiny_mce_valid_elements' );
	add_action( 'widgets_init',         'ti_register_sidebars' );
	add_filter( 'widget_text',          'do_shortcode' );
	add_filter( 'widget_text',          'shortcode_unautop' );
	add_filter( 'wp_head',              'ti_custom_theme_styles', 9 ); // admin/theme-styles.php
}
add_action( 'after_setup_theme', 'ti_setup_theme_admin' );

/**
 * Options Framework Notice
 *
 * Display a notice that can be dismissed
 *
 * @since 1.0
 */
function ti_of_admin_notice() {
	global $current_user ;
		$user_id = $current_user->ID;

	if ( ! get_user_meta($user_id, 'ti_of_ignore_notice') && ! function_exists( 'optionsframework_init' ) ) {
	
		add_thickbox();
		
		echo '<div class="updated"><p>';
		printf( __( 'The Options Framework plugin is required for this theme to function properly. <a href="%1$s" class="thickbox onclick">Install now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url( 'plugin-install.php?tab=plugin-information&plugin=options-framework&TB_iframe=true&width=640&height=517' ) , '?ti_of_nag_ignore=0' );
		echo "</p></div>";
	}
}
 
/**
 * Options Framework Notice Ignore
 *
 * @since 1.0
 */ 
function ti_of_nag_ignore() {
	global $current_user;
	$user_id = $current_user->ID;

	if ( isset( $_GET['ti_of_nag_ignore'] ) && '0' == $_GET['ti_of_nag_ignore'] ) {
		add_user_meta( $user_id, 'ti_of_ignore_notice', 'true', true );
	}
} 


/**
 * TinyMCE iFrames
 *
 * Allow iFrames in Tiny MCE. Allows google 
 * maps, youtube iframe embeds, etc. to not 
 * be romoved from editor.
 *
 * @since 1.0
 */
function ti_tiny_mce_valid_elements( $elements ) {
	$elements['extended_valid_elements'] = 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]';
	return $elements;
}


/**
 * Login Logo Link
 *
 * @since 1.0
 */
function ti_login_headerurl( $url ) {
	return esc_url( home_url() );
}


/**
 * Login Title
 *
 * @since 1.0
 */
function ti_login_headertitle( $message ) {
	return esc_html( get_bloginfo( 'name' ) );
}


/**
 * Register Sidebars
 *
 * @since 1.0
 */
function ti_register_sidebars() {	
	register_sidebar( array(
		'id'            => 'sidebar-top',
		'name'          => __( 'All Pages - Top', 'theme-it' ),
		'description'   => __( 'On all page sidebar above other widgets.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-bottom',
		'name'          => __( 'All Pages - Bottom', 'theme-it' ),
		'description'   => __( 'On all page sidebars below other widgets.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-multiple',
		'name'          => __( 'Multiple Post Pages', 'theme-it' ),
		'description'   => __( 'Shown on pages with multiple posts.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-single',
		'name'          => __( 'Single Post Pages', 'theme-it' ),
		'description'   => __( 'Shown on single post pages.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-page',
		'name'          => __( 'Page Pages', 'theme-it' ),
		'description'   => __( 'Shown on page type pages.', 'theme-it' ),
		'before_widget' => '<li><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'footbar-column-1',
		'name'          => __( 'Footer - Column 1', 'theme-it' ),
		'description'   => __( 'Shown in first column of footer.', 'theme-it' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title' 	=> '</h4>'
	));
	
	register_sidebar( array(
		'id'            => 'footbar-column-2',
		'name'          => __( 'Footer - Column 2', 'theme-it' ),
		'description'   => __( 'Shown in second column of footer.', 'theme-it' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title' 	=> '</h4>'
	));	
	
	register_sidebar( array(
		'id'            => 'footbar-column-3',
		'name'          => __( 'Footer - Column 3', 'theme-it' ),
		'description'   => __( 'Shown in third column of footer.', 'theme-it' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title' 	=> '</h4>'
	));
}

?>