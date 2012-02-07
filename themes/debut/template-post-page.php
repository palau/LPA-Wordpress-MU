<?php
/**
 * Template Name: Custom Post Page
 *
 * The custom post page template page. This page template is used to
 * show posts for any given page. Options are set via a custom metabox
 * to determine which categories should be included.
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
$is_page = 'template-post-page';

get_header(); ?>

<?php 
// Get custom post page metabox options (functions/theme-metabox.php)
$post_page_mb->the_meta(); 
$enable_post_page_title = $post_page_mb->get_the_value( 'enable_post_page_title' );
$enable_post_page_content = $post_page_mb->get_the_value( 'enable_post_page_content' );
?>

<section id="main">

	<section id="entry-container"> 
		
		<?php if ( $enable_post_page_title || $enable_post_page_content ) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry page-header' ) ?>>
				
				<?php 
				/**
				 * Entry Title & Excerpt
				 *
				 */
				if ( $enable_post_page_title ) : ?>
				
					<header class="entry-header">
				  	
						<h1 class="entry-title"><?php the_title(); ?></h1>
				  	
					</header><!-- .entry-header -->
		  	
				<?php endif; ?>
		  	
		  	
				<?php 
				/**
				 * Entry Content
				 *
				 */
				if ( $enable_post_page_content ) : ?>
		  	  
					<div class="entry-content">
						
						<?php the_content(); ?>  
		  	  
					</div><!-- entry-content -->
				
				<?php endif; ?>
			
			</article><!-- #post-## -->
		
		<?php endif; // end enable post title and content check ?>
		
		
		<?php
		/**
		 * Entry Posts Setup
		 *
		 */
		
		// Check for pages
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		if ( $paged > 1 )
			$args['paged'] = $paged;
		
		$post_page_cats = $post_page_mb->get_the_value( 'post_page_cats' );
		
		// Create query based on metabox options
		$args = array( 
		    'cat'            => ( $post_page_cats ) ? implode(",", $post_page_cats) : null,
		    'posts_per_page' => $post_page_mb->get_the_value( 'post_page_number' ),
		    'paged'          => $paged
		);
		 
		query_posts( $args ); ?>
		
		<?php
		/**
		 * The Loop
		 *
		 */
		get_template_part( 'content' ); ?>
		
		<?php	wp_reset_query(); // reset the query for next use ?>
		
	</section><!-- #entry-container -->
	
	
	<?php	
	/**
	 * Sidebar
	 *
	 */
	if ( ti_has_sidebar() )
		get_sidebar(); ?>

</section><!-- #main -->

<?php get_footer(); ?>