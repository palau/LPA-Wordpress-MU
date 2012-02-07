<?php
/**
 * The main options file that gets and sets the
 * available options for this theme and version.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 *
 */


/**
 * A unique identifier is defined to store the options 
 * in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and 
 * without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the 
 * options have been reset.
 *
 * @since     2.0
 */
function optionsframework_option_name() {

	/* This gets the theme name from the stylesheet (lowercase and without spaces) */
	$themename = get_theme_data( STYLESHEETPATH . '/style.css' );
	if ( $themename['Template'] ) :
		$themename = $themename['Template'];
	else :
		$themename = $themename['Name'];
	endif;
	$themename = preg_replace( "/\W/", "", strtolower( $themename ) );
	
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
	
	//echo $themename;
}


/**
 * Options Framework Allowed Tags Change
 *
 * Removes and Adds back OF Plugin filter for sanitization.
 * This is done to allow for basic text formatting
 * in Info Options within the Theme Options.
 *
 * @since     2.6
 */
function optionscheck_change_santiziation() 
{
	remove_filter( 'of_sanitize_info', 'of_sanitize_allowedtags' );
	add_filter( 'of_sanitize_info', 'ti_of_sanitize_allowedtags' );
}
add_action( 'admin_init','optionscheck_change_santiziation', 100 );


/**
 * Filter Allowedtags
 *
 * Add basic text formatting for Info Options within 
 * the Theme Options.
 *
 * @since     2.6
 */
function ti_of_sanitize_allowedtags( $input ) 
{
	global $allowedtags;
	
	$allowedtags = array(
		'a' => array(
			'href'   => array(),
			'class'  => array(),
			'title'  => array(),
			'target' => array(),
			'rel'    => array()
		),
		'img' => array(
			'src'    => array(),
			'class'  => array(),
			'alt'    => array(),
			'width'  => array(),
			'height' => array()
		),
		'iframe' => array(
			'src'         => array(),
			'height'      => array(),
			'width'       => array(),
			'frameborder' => array()
		),
		'p' => array(
			'id'    => array(),
			'class' => array()
		),
		'div' => array(
			'id'    => array(),
			'class' => array()
		),
		'span' => array(
			'id'    => array(),
			'class' => array()
		),
		'br' => array(),
		'strong' => array(),
		'em' => array()
	);
	
	$output = wpautop( wp_kses( $input, $allowedtags ) );
	
	return $output;
}


/**
 * Options Framework Styles
 *
 * Add custom CSS Styles to OF Plugin to help 
 * with display of theme options and sections.
 *
 * @since     2.6
 *
 */
function ti_optionsframework_styles() { ?>
	
	<style type="text/css">
	  /* Miscellaneous */
		#optionsframework .note {
			font-style: italic;
			color: #999;
		}
		
		#optionsframework .alignright {
			float: left;
			margin: 0 20px 10px 0;
		}
		
		#optionsframework .alignright {
			float: right;
			margin: 0 0 10px 20px;
		}
		
	  /* Checkmark */
	  #optionsframework .checkmark .heading:before {
	  	color: #008000;
	  	content: "\2713 \00a0 \00a0";
	  }
	  
	  /* Highlight */
	  #optionsframework .featured .heading {
	  	color: #21759B;
	  	text-transform: uppercase;
	  	margin: 0 !important;
	  }
	  
	  #optionsframework .featured .heading:before {
	  	content: "\2193 \00a0";
	  }
	  
	  #optionsframework .featured p,
	  #optionsframework .featured .option {
	  	background: #f5f5f5;
	  	margin: 0;
	  	padding: 1em;
	  	font-style: italic;
	  }
	  
	  #optionsframework .featured .controls .checkbox {
	  	margin-bottom: 0;
	  }
	  
	  /* Toggle */
	  #optionsframework .toggle-info .heading,
	  #optionsframework .toggle-section .heading {
	  	cursor: pointer;
	  }
	  
	  #optionsframework .toggle-info .heading:hover,
	  #optionsframework .toggle-section .heading:hover {
	  	color: #21759B;
	  }
	  
	  #optionsframework .toggle-info .heading:before,
	  #optionsframework .toggle-section .heading:before {
	  	content: "\2B \00a0";
	  }
	  
	  #optionsframework .toggle-info.active .heading:before,
	  #optionsframework .toggle-section.active .heading:before {
	  	content: "\2212 \00a0";
	  }	  
	</style>

<?php
}
add_action( "admin_print_styles-appearance_page_options-framework", 'ti_optionsframework_styles' );


/**
 * Options Framework Scripts
 *
 * @since     2.6
 */
function optionsframework_custom_scripts() { ?>

	<script type="text/javascript">
	
		jQuery(document).ready(function() {
		
			jQuery('.toggle-section, .toggle-info .heading').each( function () {
				jQuery(this).nextUntil('.section-info').wrapAll('<div class="toggle-content" />');
			});
			
			jQuery('.toggle-section, .toggle-info').addClass('active').toggleClass('active');
			
			jQuery('.toggle-info').click(function() {
				jQuery(this, '.heading').toggleClass('active');
				jQuery('.toggle-content', this).slideToggle('fast');
			});
			
			jQuery('.toggle-section').click(function() {
				jQuery(this, '.heading').toggleClass('active');
				jQuery(this).next('.toggle-content').slideToggle('fast');
			});
			
			jQuery('.toggle-content').hide();
			
		});
		
	</script>
 
<?php
}
add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );
 
 
/**
 * Options Framework Options
 *
 * Set some default values for various bits of
 * information to be used in the Theme Options.
 * Then call those theme options files which 
 * have been split into separate files for 
 * organization purposes.
 *
 * @since     2.0
 */
if ( ! function_exists( 'optionsframework_options' ) ) {

	function optionsframework_options() { 
		
		$shortname = "of_";
		$imagepath = get_template_directory_uri() . '/images/';
		$admin_imagepath = get_template_directory_uri() . '/admin/images/';
		
		// Pull all the categories into an array
		$options_categories = array();  
		$options_categories_obj = get_categories();
		$options_categories[''] = __( 'Select a category:', 'theme-it' );
		foreach ( $options_categories_obj as $category ) 
		{
			$options_categories[$category->cat_ID] = $category->cat_name;
		}		
			       
		// Pull all the pages into an array
		$options_pages = array();  
		$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
		$options_pages[''] = __( 'Select a page:', 'theme-it' );
		foreach ( $options_pages_obj as $page ) 
		{
			$options_pages[$page->ID] = $page->post_title;
		}
		
		// The Options
		$options = array();

		include 'options/options-thank-you.php';
		include 'options/options-home.php';
		include 'options/options-general.php';
		include 'options/options-logos.php';
		include 'options/options-styles.php';
							
		return $options;
	
	}
}