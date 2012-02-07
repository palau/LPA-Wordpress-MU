<?php
/**
 * The main template file.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */

get_header(); ?>

<section id="main">

	<?php 
	/**
	 * Index Loop (default)
	 *
	 */
	get_template_part( 'content', 'index' ); // content.php ?>
	
	<?php
	/**
	 * Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar(); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>