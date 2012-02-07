<?php
/**
 * Template Name: Centered
 *
 * The centered template page. Page content is centered via css.
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
$is_page = 'template-centered';

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