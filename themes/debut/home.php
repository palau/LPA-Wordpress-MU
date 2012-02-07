<?php
/**
 * The main template file.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */
 
/**
 * Page Type
 *
 * Used in includes/entry-thumbnail.php and functions.php
 * ti_has_sidebar() check.
 */
$is_page = 'home'; // Set page type to be used in featured loop

get_header(); ?>

	<?php
	/**
	 * Hero Loop
	 *
	 */
	get_template_part( 'content', 'hero' ); // loop-hero.php ?>
	
	
	<?php
	/**
	 * Announcement
	 *
	 */
	locate_template( 'includes/announcement.php', true ); ?>
	
	
	<?php
	/**
	 * Featured Loop
	 *
	 */
	
	// Get theme options
	$of_featured_hide               = ti_get_option( 'featured_hide', 0 );
	$of_featured_filter_thumbs      = ti_get_option( 'featured_filter_thumbs',	null );
	$of_featured_category           = ti_get_option( 'featured_category', null );
	$of_featured_posts_per_page     = ti_get_option( 'featured_posts_per_page', null );
	
	// Check if filter posts without featured thumbs is enabled in theme options
	if ( $of_featured_filter_thumbs == 1 )
		$thumbnail_id = '_thumbnail_id';
	else
		$thumbnail_id = null;

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;


	if ( $paged > 1 )
	  $args['paged'] = $paged;
	
	// Set query arguments
	$featured_args = array(
		'cat'            => $of_featured_category,
		'posts_per_page' => $of_featured_posts_per_page,
		'paged'          => $paged,
		'meta_query'     => array ( 
			array (
				'key' => $thumbnail_id 
			)
		)
	);
	query_posts( $featured_args );
	
	get_template_part( 'content', 'featured' ); // loop-featured.php ?>
			
<?php get_footer(); ?>