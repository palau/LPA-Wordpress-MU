<?php
/**
 * Template Name: Full Width
 *
 * The full width template page. Page width is adjusted via CSS.
 * The CSS class is provided via the WordPress body_class() function.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */
 
/**
 * Page Type
 *
 * Used in includes/entry-thumbnail.php and functions.php
 * ti_has_sidebar() check.
 */
$is_page = 'template-full'; // Used to set media embed size in includes/entry-thumbnail.php

get_header(); ?>

<section id="main">
	
	<?php
	
	/**
	 * Singular Loop (single, page, attachment)
	 *
	 */
	get_template_part( 'content', 'singular' ); ?>
	
</section><!-- #main -->

<?php get_footer(); ?>
