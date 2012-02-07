<?php  
/**
 * The main sidebar template. Checks for certain page types 
 * and displays the proper sidebar widgets for that page.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */
?>

<section id="sidebar-container" role="complementary">

	<ul id="sidebar" class="sidebar">
	  
	  <?php 
		/**
		 * Sidebar Top
		 *
		 */
	  dynamic_sidebar( 'sidebar-top' ); ?>
	  
	  
	  <?php
		/**
		 * Sidebar Multiple
		 *
		 */
	  if ( is_category() || is_search() || is_archive() || is_page_template('template-post-page.php') ) { 
	  	dynamic_sidebar( 'sidebar-multiple' );
	  } ?>
	  
	  
	  <?php
		/**
		 * Sidebar Single
		 *
		 */
	  if ( is_single() ) { 
	  	dynamic_sidebar( 'sidebar-single' ); 
	  } ?>
	  
	  
	  <?php
		/**
		 * Sidebar Page
		 *
		 */
	  if ( is_page() && !is_page_template('template-post-page.php') ) { 
	  	dynamic_sidebar( 'sidebar-page' ); 
	  } ?>
	  
	  
	  <?php
		/**
		 * Sidebar Bottom
		 *
		 */
	  dynamic_sidebar( 'sidebar-bottom' ); ?>
	  
	</ul><!-- #sidebar -->
	
</section><!-- #sidebar-container -->
