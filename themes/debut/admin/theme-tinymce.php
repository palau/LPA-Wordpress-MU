<?php
/**
 * This file adds features and functionality to the TinyMCE editor.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */


/**
 * Add Scripts and Styles
 *
 * @access    public
 * @since     1.0
 */
function ti_shortcodes_init() {
	wp_register_style( 'tinymce-editor-plugin', ti_ADMINURL . '/tinymce/tinymce-editor-plugin.css',	false, '1.0' );
	wp_enqueue_style( 'tinymce-editor-plugin' );
}
add_action( 'add_meta_boxes', 'ti_shortcodes_init' );


/**
 * Shortcodes Snippets
 *
 * @access    public
 * @since     1.0
 */
require_once ti_ADMINPATH . '/tinymce/tinymce-shortcodes.php';
require_once ti_ADMINPATH . '/tinymce/tinymce-quicktags.php';


/**
 * TinyMCE Button Init
 *
 * @access    public
 * @since     1.0
 */
function ti_shortcodes_mce_init() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		if ( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post-new.php', 'page-new.php', 'post.php', 'page.php' ) ) ) {
			add_filter( 'mce_buttons', 'ti_mce_button' );
			add_filter( 'mce_buttons_2', 'ti_mce_buttons_2' );
			add_filter( 'mce_external_plugins', 'ti_mce_external_plugins' );
			add_filter( 'tiny_mce_before_init', 'ti_tiny_mce_before_init' );
			add_action( 'admin_head','ti_add_simple_buttons' );
		}
	}
}
add_action( 'admin_init', 'ti_shortcodes_mce_init' );


/**
 * Filter TinyMCE Buttons
 *
 * @access    public
 * @since     1.0
 */
function ti_mce_button( $buttons ) {
	array_push( $buttons, '|', 'shortcodesbutton' );
	return $buttons;
}

function ti_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}


/**
 * Filter TinyMCE Buttons
 *
 * @access    public
 * @since     1.0
 */
function ti_mce_external_plugins( $plugins ) {
	$plugins['ti_shortcodes'] = ti_ADMINURL . '/tinymce/tinymce-editor-plugin.js';
	return $plugins;
}


/**
 * Add Style Options
 *
 * First we provide available formats for the style format drop down.
 * This should contain a comma separated list of formats that 
 * will be available in the format drop down list.
 *
 * Next, we provide our style options by adding them to an array.
 * Each option requires at least a "title" value. If only a "title"
 * is provided, that title will be used as a divider heading in the
 * styles drop down. This is useful for creating "groups" of options.
 *
 * After the title, we set what type of element it is and how it should
 * be displayed. We can then provide class and style attributes for that
 * element. The example below shows a variety of options.
 *
 * Lastly, we encode the array for use by TinyMCE editor
 *
 * {@link http://tinymce.moxiecode.com/examples/example_24.php }
 */
function ti_tiny_mce_before_init( $settings ) {
	$settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';

	$style_formats = array(
		array( 'title' => 'Callout Light'	, 'block' => 'div', 'classes' => 'callout-light' ),
		array( 'title' => 'Callout Medium', 'block' => 'div', 'classes' => 'callout-medium' ),
		array( 'title' => 'Callout Dark'	, 'block' => 'div', 'classes' => 'callout-dark' ),
		
		array( 'title' => 'Layouts Columns'),
		array( 'title' => '&frac12;'			, 'block' => 'div', 'classes' => 'one-half' ),
		array( 'title' => '&frac12; Last'	, 'block' => 'div', 'classes' => 'one-half last' ),
		array( 'title' => '&frac13;'			, 'block' => 'div', 'classes' => 'one-third' ),
		array( 'title' => '&frac13; Last'	, 'block' => 'div', 'classes' => 'one-third last' ),
		array( 'title' => '&frac14;'			, 'block' => 'div', 'classes' => 'one-fourth' ),
		array( 'title' => '&frac14; Last'	, 'block' => 'div', 'classes' => 'one-fourth last' ),
		array( 'title' => '&frac23;'			, 'block' => 'div', 'classes' => 'two-third' ),
		array( 'title' => '&frac23; Last'	, 'block' => 'div', 'classes' => 'two-third last' ),
		array( 'title' => '&frac34;'			, 'block' => 'div', 'classes' => 'three-fourth' ),
		array( 'title' => '&frac34; Last'	, 'block' => 'div', 'classes' => 'three-fourth last' ),
	);
    
	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}


?>