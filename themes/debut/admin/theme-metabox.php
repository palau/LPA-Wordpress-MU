<?php
/**
 * Metaboxes Setup
 *
 * Here we create custom metaboxes using WPAlchemy Metabox Class.
 *{@link http://farinspace.com/wpalchemy-metabox/ }
 *
 * @package WordPress
 * @subpackage Debut
 * @since 1.0
 */


/**
 * WPAlchemy Metabox Scripts and Styles
 *
 * @since 1.0
 */
function ti_metabox_init() {
	/* Register */
	wp_register_script( 'metabox',        ti_ADMINURL . '/metabox/MetaBox.js', 'jquery', '1.0', true );
	wp_register_style(  'metabox',        ti_ADMINURL . '/metabox/MetaBox.css' );
	wp_register_style(  'metabox-custom', ti_ADMINURL . '/metabox/metabox-custom.css' );
	
	/* Enqueue */
	wp_enqueue_script( 'metabox' );
	wp_enqueue_style( 'metabox' );
	wp_enqueue_style( 'metabox-custom' );
}
add_action( 'add_meta_boxes', 'ti_metabox_init' );


/**
 * WPAlchemy Metabox Class
 *
 * This class adds the functionality to easily 
 * create custom metaboxes. Very quick and useful.
 *
 * @since 1.0
 */
require_once ti_ADMINPATH . '/metabox/MetaBox.php';


/**
 * WPAlchemy MediaAccess Class
 *
 * This class provides the functionality necessary
 * to upload media. This is used to upload a custom
 * background image for a post. This image is then 
 * used over a featured image in the hero slider
 * on the home page.
 *
 * @since 1.0
 */
require_once ti_ADMINPATH . '/metabox/MediaAccess.php';

/* Define a media acess object */
$wpalchemy_media_access = new WPAlchemy_MediaAccess();


/**
 * Hero Options Metabox
 *
 * This metabox is responsible for how the post
 * content is displayed in the Hero slider on the
 * home page.
 *
 * The metabox will only display on Post pages and 
 * will be located in the main column area, beneath
 * the text editor.
 *
 * @return    array
 * @since 1.0
 */
$hero_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_hero_mb',
  'title'    => 'Hero Options',
  'types'    => array( 'post' ),
  'template' => ti_ADMINPATH . '/metabox/metabox-hero-options.php'
));


/**
 * Page Excerpt Metabox
 *
 * Adds a simple textarea to Pages. This text is 
 * considered the page excerpt. This is done instead 
 * of using add_post_type_support( 'page', 'excerpt' )
 * for the simple reason of the option to leave empty.
 *
 * @return    array
 * @since 1.0
 */
$page_excerpt_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_page_excerpt_mb',
  'title'    => 'Page Excerpt',
  'types'    => array( 'page' ),
	'exclude_template' => array( 'template-post-page.php' ),
  'template' => ti_ADMINPATH . '/metabox/metabox-page-excerpt.php'
));


/**
 * Media Embed Metabox
 *
 * This metabox is used to handle media embeds.
 * The user can supply a URL or custom embed code
 * in which a function ti_get_media() uses WP embed
 * shortcode to take care of the rest.
 *
 * This function has been created in functions.php 
 * to handle this content and display on a page using
 * a custom action/filter.
 *
 * This metabox is set to show on Posts and Pages.
 * It's location will be shown in the side.
 *
 * @return    array
 * @since 1.0
 */
$media_embed_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_media_embed_mb',
  'title'    => 'Media Embed',
  'types'    => array( 'page', 'post' ),
  'context'  => 'side',
  'template' => ti_ADMINPATH . '/metabox/metabox-media-embed.php'
));


/**
 * Post Page Metabox
 *
 * This metabox basically pulls in all the
 * categories which have posts. It's service
 * is used to turn any Page into a blog by use
 * of a page template.
 *
 * The metabox will only show on Pages after
 * the Custom Post Page or Custom Post Gallery
 * page templates are selected and the post is
 * saved/published. It's location by default
 * will display in the side.
 *
 * @return    array
 * @since 1.0
 */
$post_page_mb = new WPAlchemy_MetaBox( array(
  'id'               => '_post_page_mb',
  'title'            => 'Custom Post Page',
  'types'            => array( 'page' ),
  'context'          => 'side',
  'include_template' => array( 'template-post-page.php', 'template-post-gallery.php' ),
  'template'         => ti_ADMINPATH . '/metabox/metabox-post-page.php'
));


?>