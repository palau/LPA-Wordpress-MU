<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, ti_setup_debut(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Debut
 * @since 1.0
 */

define( 'VERSION', '3.3.6' );

function ti_version_id() {
  if ( WP_DEBUG )
    return time();
  return VERSION;
}


/**
 * General Path/URI Functions
 *
 * @since 1.0
 */
define( 'ti_FILEPATH',  TEMPLATEPATH );
define( 'ti_DIRECTORY', get_template_directory() );
define( 'ti_URL',       get_template_directory_uri() );
define( 'ti_ADMINPATH', ti_FILEPATH .  '/admin' );
define( 'ti_ADMINDIR',  ti_DIRECTORY . '/admin' );
define( 'ti_ADMINURL',  ti_URL .       '/admin' );


/**
 * Theme Setup
 *
 * If you would like to customize the theme setup you
 * are encouraged to adopt the following process.
 *
 * <ol>
 * <li>Create a child theme with a functions.php file.</li>
 * <li>Create a new function named mytheme_setup().</li>
 * <li>Hook this function into the 'after_setup_theme' action at or after 11.</li>
 * <li>call remove_filter(), remove_action() and/or remove_theme_support() as needed.</li>
 * </ol>
 *
 * @return void
 *
 * @since 1.0
 */
function ti_setup_debut() {

	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 550;

	load_theme_textdomain( 'theme-it', get_template_directory() . '/languages' );

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_editor_style( 'style-editor.css' );

	/* Image sizes. */
	set_post_thumbnail_size(            255, 143, true );
	add_image_size( 'thumbnail-large',  150, 150, true );
	add_image_size( 'thumbnail-wide',   240, 140, true );
	add_image_size( 'singular-image',   530, 300, true );
	add_image_size( 'full-image',       840, 470, true );
	add_image_size( 'hero-image',       940, 350, true );

	/* Navigation menus. */
	register_nav_menus( array(
	  'top-nav'     => __( 'Top Menu',     'theme-it' ),
	  'primary-nav' => __( 'Primary Menu', 'theme-it' ),
	  'action-nav'  => __( 'Action Menu',  'theme-it' )
	));
	
	/* WordPress Core. */
	add_filter( 'body_class',        'ti_multiple_post_class' );
	add_filter( 'body_class',        'ti_sidebar_class' );
	add_filter( 'embed_defaults',    'ti_embed_defaults' );
	add_filter( 'embed_googlevideo', 'ti_oembed_dataparse', 10, 4 );
	add_filter( 'embed_oembed_html', 'ti_oembed_dataparse', 10, 4 );
	add_filter( 'embed_oembed_html', 'ti_oembed_wmode_transparent', 10, 4 );
	add_filter( 'excerpt_length',    'ti_excerpt_length' );
	add_filter( 'excerpt_more',      'ti_excerpt_more_auto' );
	add_action( 'wp_head',           'ti_print_theme_info', 1 );
	add_filter( 'wp_title',          'ti_wp_title' );
	add_action( 'wp_enqueue_scripts',   'ti_theme_styles' );
	add_action( 'wp_enqueue_scripts',  'ti_theme_scripts' );
	add_action( 'wp_enqueue_scripts',  'ti_localize_script' );

	/* Custom hooks. */
	add_action( 'has_sidebar',     'ti_has_sidebar', 10, 1 );
	add_action( 'get_media',       'ti_get_media', 10, 5 );
	add_action( 'get_modal_box',   'ti_get_modal_box', 10, 2 );
	add_action( 'limit_string',    'ti_limit_string', 10, 3  );
	add_action( 'the_short_title', 'ti_the_short_title', 10, 4  );
}
add_action( 'after_setup_theme', 'ti_setup_debut' );


/**
 * Include additional admin files
 *
 * @since 1.0
 */
require_once( ti_DIRECTORY . '/admin.php' );
include_once( ti_ADMINPATH . '/theme-metabox.php' );


/**
 * Get Theme Options
 *
 * This function is based around the Options Framework Plugin.
 * Return the theme option value. If the option value
 * does not exist or is empty, return assigned default
 * value, if a default value is not set, return false.
 *
 * @param     string         The name of the option
 * @param     string         The default value if not availble
 *
 * @since 1.0
 */
if ( !function_exists( 'ti_get_option' ) ) :
	function ti_get_option( $name, $default = false ) {
	
		$optionsframework_settings = get_option( 'optionsframework' );
	
		$option_name = $optionsframework_settings['id'];
	
		if ( get_option( $option_name ) )
			$options = get_option( $option_name );
	
		if ( isset( $options[$name] ) && !empty( $options[$name] ) )
			return $options[$name];
		else
			return $default;
	}	
endif; // End ti_get_option check



/**
 * Load Required Theme Styles
 *
 * @since 1.0
 */
function ti_theme_styles() {
	if ( is_admin() ) return;

	wp_enqueue_style( 'ti_fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), ti_version_id() );
	wp_enqueue_style( 'ti_forms',    get_template_directory_uri() . '/style-forms.css',                 array(), ti_version_id() );
}


/**
 * Load Required Theme Scripts
 *
 * @since 1.0
 */
function ti_theme_scripts() {
	if ( is_admin() ) return;
	
	global $is_page;
	
	// Header
	wp_enqueue_script( 'ti_modernizr',  get_template_directory_uri() . '/js/modernizr.js' );
	
	// Footer
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ti_navigation',  get_template_directory_uri() . '/js/jquery.navigation.js',  array( 'jquery' ), ti_version_id(), true );
	
	if( $is_page == 'home' ) {
		wp_enqueue_script( 'ti_video_players', get_template_directory_uri() . '/js/video-players.js',     array( 'jquery' ), ti_version_id(), true );
		wp_enqueue_script( 'ti_heroslider',     get_template_directory_uri() . '/js/jquery.heroslider.js', array( 'jquery' ), ti_version_id(), true );
	}
	
	wp_enqueue_script( 'ti_fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.js', array( 'jquery' ), ti_version_id(), true );
	wp_enqueue_script( 'ti_script',   get_template_directory_uri() . '/js/script.js',                   array( 'jquery' ), ti_version_id(), true );
	
	if ( is_singular() && ti_get_option( 'disable_comments', 0 ) == 0 ) {
		if ( comments_open() && get_option( 'thread_comments' ) ) 
			wp_enqueue_script( 'comment-reply' );
	}
}


/**
 * Localize Scripts. This allows to get theme option values and pass them into
 * a javascript file. In this case, we are passing different theme options into
 * the js/script.js file.
 *
 * @since 2.0
 */
function ti_localize_script() {
	
	/* Check if options framework is enabled. */
	if ( function_exists( 'optionsframework_init' ) )
		$optionsframework_enabled = true; // Needed for checks in script.js
	else
		$optionsframework_enabled = false;
	
	/* Hero Settings */
	$hero_cycle_speed   = ti_get_option( 'hero_cycle_speed', 2 );
	$hero_cycle_timeout = ti_get_option( 'hero_cycle_timeout' );
	$hero_cycle_fx      = ti_get_option( 'hero_cycle_fx', 'scrollHorz' );
	
	if ( empty( $hero_cycle_timeout ) || $hero_cycle_timeout == 0 ) {
		$hero_cycle_timeout = 0;
	} else {
		$hero_cycle_timeout = absint( $hero_cycle_timeout ) * 1000;
	}
		
	/* Set Script Options */
	$script_options = array(
		'optionsframework_enabled' => $optionsframework_enabled,
		'hero_cycle_speed'         => absint( $hero_cycle_speed ) * 1000,
		'hero_cycle_timeout'       => $hero_cycle_timeout,
		'hero_cycle_fx'            => $hero_cycle_fx
	);
	
	wp_localize_script( 'ti_heroslider', 'script_options', $script_options );
}


/**
 * Fileter WP Title 
 *
 * Filter the title depending upon the page.
 *
 * @since 1.0
 */
function ti_wp_title(){
	$title = '';

	if ( is_home() )
		$title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); 
	elseif ( is_search() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Search Results', 'theme-it' );
	elseif ( is_author() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Author Archives', 'theme-it' ); 
	elseif ( is_single() )
		$title = the_title( '', '', false ) . ' | ' . get_bloginfo( 'name' );
	elseif ( is_page() )
		$title = get_bloginfo( 'name' ) . ' | ' . the_title( '', '', false );
	elseif ( is_category() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Archive', 'theme-it' ) . ' | ' . single_cat_title( '', false );
	elseif ( is_month() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Archive', 'theme-it' ) . ' | ' . the_time( 'F' );
	elseif ( is_tag() )
		$title = get_bloginfo( 'name' ) . ' | ' . __( 'Tag Archive', 'theme-it' ) . ' | ' . single_tag_title( '', false );
	print $title;
}


/**
 * Print Theme Info
 *
 * @since 1.0
 */
function ti_print_theme_info() {
	$output  = "<!--\n";
	$output .= "**********************************************************************************************\n";
	$output .=  "\n";
	$output .=  "Debut (" . VERSION . ") - Designed and built by Luke McDonald" . "\n";
	$output .=  "\n";
	$output .=  "**********************************************************************************************\n";
	$output .=  "-->";
	
	print $output;
}


/**
 * Remove default gallery style
 *
 * Removes inline styles printed when the 
 * gallery shortcode is used.
 *
 * @since 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Title Attribute.
 *
 * @since 1.0
 */
if ( ! function_exists( 'ti_the_title_attribute' ) ) :
	function ti_the_title_attribute() {
		printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) );
	}
endif;


/**
 * Has Media Embed
 *
 * This function was created to check if the Media Embed
 * metabox has a value or not.
 *
 * @return    bool
 *
 * @since 1.0
 */
function has_media_embed( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	/* Get global values */
	global $media_embed_mb;
	
	/* Get media embed metabox options */
	$media_embed_mb->the_meta( $post_id ); 
	$media_source     = $media_embed_mb->get_the_value( 'media_source' );
	$media_embed_code = $media_embed_mb->get_the_value( 'media_embed_code' );
	
	$media_embed = ( $media_source || $media_embed_code ) ? true : false;
	
	return $media_embed;
}


/**
 * Generate random number
 *
 * Creates a 4 digit random number for used
 * mostly for unique ID creation. 
 *
 * @since     1.0
 */
function ti_get_random_number() {
	return substr( md5( uniqid( rand(), true) ), 0, 4 );
}



/**
 * YouTube Player
 *
 * Creates the necessary iframe structure for YouTube
 * Gets custom theme options and adds to iframe src.
 *
 * @return    string
 * @since     1.0	
 */
function ti_create_youtube_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	if( preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media_source, $matches ) ) {
		/* Give player a unique ID */
		$player_id = 'ytplayer_' . $matches[1] . '_' . ti_get_random_number();
		
		$defaults = array(
		  'wmode' => 'transparent',
		  'enablejsapi' => 1,
		  'playerapiid' => 'ytplayer',
		  'origin' => esc_url( home_url() ),
		  'color' => null,
		  'theme' => null,
		  'fs' => null,
		  'loop' => null,
		  'rel' => null,
		  'showinfo' => null,
		  'autoplay' => null
		);
		
		$params = wp_parse_args( parse_url( $media_source, PHP_URL_QUERY ), $defaults );
		
		// Stop autoplay from possibly autoplaying on pages with multiple posts and videos
		if( 0 == $allow_autoplay || ! is_singular() )
			$params['autoplay'] = 0;
		
		$url = 'http://www.youtube.com/embed/' . $matches[1] . '/?' . http_build_query( array_filter( $params ), '', '&' );
		
		$output = '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" id="' . $player_id . '" class="youtube-player" frameborder="0" wmode="Opaque" allowfullscreen></iframe>';
	} else {
		$output = __( 'Sorry that seems to be an invalid <strong>YouTube</strong> URL. Please check it again.', 'themeit' );
	}
	
	return $output;
}


/**
 * Vimeo Player
 *
 * Creates the necessary iframe structure for Vimeo
 * Gets custom theme options and adds to iframe src.
 *
 * @since     1.0
 */
function ti_create_vimeo_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	if( preg_match( '~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $media_source, $matches ) ) {
		/* Give player a unique ID */
		$player_id = 'player_' . $matches[1] . '_' . ti_get_random_number();
		$color = ti_get_option( 'main_link_color' );
		$video_color = ( 1 == ti_get_option( 'enable_styles' ) && $color ) ? ltrim( $color, '#' ) : '7FCCFF';
		
		$defaults = array(
		  'wmode' => 'transparent',
		  'api' => 1,
		  'player_id' => $player_id,
		  'title' => 0,
		  'byline' => 0,
		  'portrait' => 0,
		  'autoplay' => null,
		  'loop' => null,
		  'rel' => null,
		  'color' => $video_color
		);
		
		$params = wp_parse_args( parse_url( $media_source, PHP_URL_QUERY), $defaults );
		
		if( 0 == $allow_autoplay || ! is_singular() )
			$params['autoplay'] = 0;
		
		$url = 'http://player.vimeo.com/video/' . $matches[1] . '/?' . http_build_query( array_filter( $params ), '', '&' );

		$output = '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" id="' . $player_id . '" class="vimeo-player" frameborder="0" data-playcount="0" webkitAllowFullScreen allowFullScreen></iframe>';
		
	} else {
		$output = __( 'Sorry that seems to be an invalid <strong>Vimeo</strong> URL. Please check it again. Make sure there is a string of numbers at the end (e.g. http://vimeo.com/2104600).', 'themeit' );
	}
	return $output;
}


/**
 * Create WP Embed
 *
 * Creates the necessary iframe structure for available
 * sites using the default WP embed shortcode. If a video
 * address is one of the accepted sites that can use the
 * URL and oembed, aside from Vimeo and Youtube, this function
 * will be called. Vimeo and YouTube url's use a custom
 * function of ti_create_vimeo_player() or ti_create_youtube_player()
 *
 * @since     3.0
 */
function ti_create_wp_embed_player( $media_source = '', $width = 640, $height = 360, $allow_autoplay = 1 ) {
	$wp_embed = new WP_Embed();
	$output = $wp_embed->run_shortcode( '[embed width=' . $width . ' height=' . $height . ']' . $media_source . '[/embed]' );
	return $output;
}


/**
 * Get Media (Video)
 *
 * Gets media source and decides how it should be displayed.
 * The function first check to see if its a url, if not we
 * assume they have provided an embed code.
 *
 * If it is a url, we'll check to see if it matches  
 * set in functions/theme-metabox.php
 *
 * @since     1.0
 */
function ti_get_media( $post_id = null, $width = 640, $height = 360, $allow_autoplay = 1, $echo = true  ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$media = get_post_meta( $post_id, 'featured-video', true );
	
	// START Soundcheck specific
	if ( ! has_media_embed( $post_id ) )
		return;
	
	global $media_embed_mb;
	if ( $media_embed_mb->the_meta( $post_id ) ) {
		$media_source = $media_embed_mb->get_the_value( 'media_source' );
		$media_embed_code = $media_embed_mb->get_the_value( 'media_embed_code' );
		$media = ( trim( $media_embed_code ) == '' ) ? $media_source : $media_embed_code;
	}
	// END Soundcheck specific
	 
	
	// If media is not provided, return
	if( ! $media )
		return;
	
	// If media string does not start with "http", return it's value, assuming it's an embed code
	if( 0 !== strpos( $media, "http" ) ) {
		$output = stripslashes( htmlspecialchars_decode( $media ) );
		if ( $echo ) {
		  echo $output;
		  return;
		} else {
		  return $output;
		}
	}
	
	// Media appears to be a valid url starting with http, so we'll get some info abou the url
	$media = array(
	    'url'    => $media,
	    'host'   => parse_url( $media, PHP_URL_HOST )
	);
	
	// List of media players methods. Some players we build instead of usine WP embed code.
	$players = array(
	    'youtube'  => ( 'youtube.com' == $media['host'] || 'youtu.be' == $media['host'] ) ? 1 : 0,
	    'vimeo'    => ( 'vimeo.com' == $media['host'] ) ? 1 : 0
	);
	
	// Set output to use WP embed shortcode function by default
	$output = ti_create_wp_embed_player( $media['url'], $width, $height, $allow_autoplay );
	
	// Check URL to see if it matches a cusotm player the them builds manually
	foreach( $players as $player => $source ) {
	    if( 1 === $source ) {
	    	// Create a function based off of matched player key
	    	$function = 'ti_create_' . $player . '_player';
	    	$output = $function( $media['url'], $width, $height, $allow_autoplay );
	    	break;
	    }
	}
	
	if ( $echo )
	  echo $output;
	else
	  return $output;
}


/**
 * Get Modal Box
 *
 * This function is called to create the necessary
 * HTML elements needed for FancyBox. When Instant
 * View is enabled via Theme Options, the video will
 * then be played using FancyBox.
 *
 * @since 1.0
 */
function ti_get_modal_box( $post_id, $echo = true ) {
	/* Set post id */
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	/* Check if it has media set */
	if ( ! has_media_embed( $post_id ) )
		return;
	
	/* Get theme options */
	$instant_size  = ti_get_option( 'instant_size', '640x360' );
	list( $width, $height ) = split( '[x]', $instant_size );
	
	$instant  = '<div class="instant"><div id="video-' . absint( $post_id ) . '" class="instant-view" >';
	$instant .= apply_filters( 'get_media', absint( $post_id ), absint( $width ), absint( $height ), 0, false );
	$instant .= '</div></div>';
	  	
	if ( $echo )
	  echo $instant;
	else
	  return $instant;
}


/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 2.0
 */

if ( ! function_exists( 'ti_posted_on' ) ) :
	function ti_posted_on() {
		printf( __( 'Posted on %1$s by %2$s', 'theme-it' ),
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_html( get_the_date() )
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'theme-it' ), get_the_author() ) ),
				esc_html( get_the_author() )
			)
		);
	}
endif;


/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since 2.0
 */

if ( ! function_exists( 'ti_posted_in' ) ) :
	function ti_posted_in() {
		$output = sprintf( __( 'Bookmark the %1$s', 'theme-it' ), '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( sprintf( __( 'Permalink to %1$s', 'theme-it' ), the_title( '', '', false ) ) ) . '" rel="bookmark">' . esc_html__( 'permalink', 'theme-it' ) . '</a>' );
	
		$tags = get_the_tag_list( '', ', ' );
		$cats = get_the_category_list( ', ' );
	
		if ( ! empty( $tags ) && ! empty( $cats ) ) 
			$output = sprintf( esc_html__( 'This entry was posted in %1$s and tagged %2$s. %3$s', 'theme-it' ), $cats, $tags, $output );
		elseif ( ! empty( $cats ) )
			$output = sprintf( esc_html__( 'This entry was posted in %1$s. %2$s', 'theme-it' ), $cats, $output );
	
		print $output;
	}
endif;


/**
 * Short Title
 *
 * @since 1.0
 */
function ti_the_short_title( $before = '', $after = '', $echo = true, $length = false ) {
	$title = get_the_title();
	
	if ( $length && is_numeric( $length ) )
		$title = substr( $title, 0, $length );
	
	if ( strlen( $title ) > 0 ) {
		if (strlen( $title ) < $length )
			$title = apply_filters( 'the_short_title', $before . $title, $before, $after );
		else
			$title = apply_filters( 'the_short_title', $before . $title . $after, $before, $after );
		
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}


/**
 * Limit String
 *
 * @since 1.0
 */
function ti_limit_string( $string, $length = false, $echo = true  ) {
	if ( absint( $length ) )
		$string = substr( $string, 0, $length );
		
	if ( strlen( $string ) < $length )
	  $string = apply_filters( 'ti_limit_string', $string );
	else
	  $string = apply_filters( 'ti_limit_string', $string . '...' );
	
	if ( strlen( $string ) > 0 ) {
		if ( $echo )
			echo $string;
		else
			return $string;
	}
}


/**
 * Multiple Page Class
 *
 * Add a class to pages that display multiple posts
 *
 * @param     array     All classes for the body element.
 * @return    array     Modified classes for the body element.
 *
 * @since 1.0
 */
function ti_multiple_post_class( $classes ) {
	global $post;
	if ( ! is_singular() || is_page_template( 'template-post-page.php' ) )
		$classes[] = 'multiple';
	return $classes;
}


/**
 * Sidebar Class
 *
 * @param     array     All classes for the body element.
 * @return    array     Modified classes for the body element.
 *
 * @since 1.0
 */
function ti_sidebar_class( $classes ) {
	global $post;
	
	$output = ( ti_has_sidebar() ) ? 'has-sidebar' : 'no-sidebar';
	
	$classes[] = $output;
	
	return $classes;
}


/**
 * Sidebar Check
 *
 * Check to see if sidebars are active. If a sidebar is active
 * return (bool). Used by ti_sidebar_class() to apply a body
 * class of has-sidebar or no-sidebar. Used in page templates to
 * check if sidebar should be shown.
 *
 * @return    bool
 *
 * @since 2.7
 */
function ti_has_sidebar() {
	global $post, $is_page;
	
	if ( isset( $is_page ) && ( $is_page == 'template-full' || $is_page == 'template-post-gallery' || $is_page == 'template-centered' ) ) {
		$has_sidebar = false;
	} elseif ( is_active_sidebar( 'sidebar-top' ) || is_active_sidebar( 'sidebar-bottom' ) ) {
		$has_sidebar = true;
	} else {
		if ( is_single() )
			$has_sidebar =  ( is_active_sidebar( 'sidebar-single' ) ) ? true : false;
		elseif ( is_page() && ! isset( $is_page ) )
			$has_sidebar =  ( is_active_sidebar( 'sidebar-page' ) ) ? true : false;
		else
			$has_sidebar =  ( is_active_sidebar( 'sidebar-multiple' ) ) ? true : false;
	}
	
	return $has_sidebar;
}


/**
 * Custom Excerpt Length
 *
 * @since 1.0
 */
function ti_excerpt_length( $length ) {
	$excerpt_length = ti_get_option( 'excerpt_length', 24 );
	return $excerpt_length;
}


/**
 * Enclose embedded media in a div.
 *
 * Wrapping all flash embeds in a div allows for easier
 * styling with CSS media queries.
 *
 * @todo      Document parameters.
 *
 * @since 1.0
 */
function ti_oembed_dataparse( $cache, $url, $attr = '', $post_ID = '' ) {
	return '<div class="embed oembed">' . $cache . '</div>';
}


/**
 * Video Embed Fix
 *
 * Menus Behind Embedded Video Fix. Adds wmode=transparent to embed objects
 *
 * @since 1.0
 */
function ti_oembed_wmode_transparent( $html, $url, $attr = '', $post_ID = '' ) {
	if ( strpos( $html, "<embed src=" ) !== false )
		$html = str_replace( '</param><embed', '</param><param name="wmode" value="transparent"></param><embed wmode="transparent"', $html );
	
	return $html;
}


/**
 * Embed Defaults
 *
 * Set the defalut size for embed options
 *
 * @since 1.0
 */
function ti_embed_defaults( $embed_size ) {
	$embed_size['width'] = 550;
	$embed_size['height'] = 310;

	return $embed_size;
}


/**
 * Excerpt More (auto).
 *
 * In cases where a post does not have an excerpt defined
 * WordPress will append the string "[...]" to a shortened
 * version of the post_content field. Debut will replace
 * this string with an ellipsis followed by a link to the
 * full post.
 *
 * This filter is attached to the 'excerpt_more' hook
 * in the ti_setup_debut() function.
 *
 * @return string An ellipsis followed by a link to the single post.
 *
 * @since 1.0
 */
function ti_excerpt_more_auto( $more ) {
	return ' &hellip;';
}



/**
 * Check for instant view and return necessary class and link information
 *
 * @since 3.2
 */
function ti_get_instant_view_link( $post_id = null ) {
	// Set post id
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	// Get theme option for instant view 
	$of_instant_view = ti_get_option( 'instant_view', 0 );
	
	if ( $of_instant_view == 1 && has_media_embed() ) {
		$link_href = '#video-' . absint( $post_id );
		$link_class = 'fancybox thumbnail-frame-video';
	} else {
		$link_href = get_permalink( $post_id );
		$link_class = '';  
	}
	
	$link = array(
		'href' => esc_url( $link_href ),
		'class' => esc_attr( $link_class )
	);
	
	return $link;
}



/**
 * Determine page header
 *
 * Menus Behind Embedded Video Fix. Adds wmode=transparent to embed objects
 *
 * @since 1.0
 */
function ti_get_page_title( $content = '' ) {
	$title = array();
	
	if ( is_category() ) :
		$title = array(
			'title' => single_cat_title( '', false ),
			'misc'  => __( 'Browsing Category', 'themeit' )
		);
	elseif( is_tag() ) :
		$title = array(
			'title' => single_tag_title( '', false ),
			'misc'  => __( 'Browsing Tags', 'themeit' )
		);
	elseif( is_day() ) :
		$title = array(
			'title' => get_the_time( 'F jS, Y' ),
			'misc'  => __( 'Browsing', 'themeit' )
		);
	elseif( is_month() ) :
		$title = array(
			'title' => get_the_time( 'F, Y' ),
			'misc'  => __( 'Browsing', 'themeit' )
		);
	elseif( is_year() ) :
		$title = array(
			'title' => get_the_time( 'Y' ),
			'misc'  => __( 'Browsing', 'themeit' )
		);
	elseif( is_search() ) :
		$title = array(
			'title' => get_search_query(),
			'misc'  => __( 'Search for', 'themeit' )
		);
	elseif( is_author() ) :
		$title = array(
			'title' => __( 'Author Archives', 'themeit' ),
			'misc'  => __( 'Browsing', 'themeit' )
		);
	elseif( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) :
		$title = array(
			'title' => __( 'Blog Archives', 'themeit' ),
			'misc'  => __( 'Browsing', 'themeit' )
		);
	elseif( is_404() ) :
		$title = array(
			'title' => __( 'Sorry, nothing here!', 'themeit' ),
			'misc'  => __( 'Whoopsy Daisy!', 'themeit' )
		);
	elseif( is_home() ) :
		$title = array(
			'title' => __( 'Blog', 'themeit' ),
			'misc'  => __( 'multiple posts', 'themeit' )
		);
	else :
		$title = array(
			'title' => false,
			'misc'  => false
		);
	endif;
	
	
	if( array_key_exists( $content, $title ) )
		$title = $title[$content];
	
	return $title;
}



/**
 * Comment Setup
 *
 * @since     1.0
 */
if ( ! function_exists( 'ti_comment' ) ) :
	function ti_comment($comment, $args, $depth) 
	{
		$GLOBALS['comment'] = $comment; ?>
		
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			
			<div id="comment-<?php comment_ID(); ?>">
				
				<div class="comment-border"><!-- nothing to see here --></div>
				
				<div class="comment-author vcard">
	         
	         <?php echo get_avatar( $comment, $size='35', $default='<path_to_url>' ); ?>
	
	         <?php printf( '<cite class="fn">' . __( '%s', 'framework' ) . '</cite>', get_comment_author_link() ) ?>
	      
				</div><!-- .comment-author -->
	      
				<?php if ($comment->comment_approved == '0') : ?>
	         
					<em><?php _e( 'Your comment is awaiting moderation.', 'framework' ) ?></em><br />
	         
				<?php endif; ?>
	
				<div class="comment-meta commentmetadata">
	      
					<span class="comment-date"><?php printf( __( '%1$s', 'framework' ), get_comment_date() ) ?></span>
	      		
					<span class="comment-reply-link-wrap">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => 'Reply' ) ) ) ?>
					</span>
					
			  	<?php echo edit_comment_link( 'edit', '<span>(', ')</span>' ); ?>
	      
				</div><!-- .comment-meta -->
				
				<div class="comment-body">
				
					<?php comment_text(); ?>
				
				</div><!-- .comment-body -->
	
			</div><!-- #comment-## -->
			
	<?php
	}
endif;



?>