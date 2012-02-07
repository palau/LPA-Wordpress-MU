<?php
/**
 * Template Name: Archives
 *
 * The arvhives template page.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */

get_header(); ?>

<section id="main">
	
	<?php 
	/**
	 * Archives Loop
	 *
	 */
	get_template_part( 'content', 'archives' ); ?>
	
	<?php	
	/**
	 * Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar(); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>